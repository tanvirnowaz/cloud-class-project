<html>
<body>
<?php
 /*
Author: Tanvir Nowaz
This is a master controller script to use AWS's EC2, AMI, S3, DB 
in order to install user specified product in specified OS and to run 
specified tests. 
  */

error_reporting(E_ALL);
require_once('/var/www/html/testframework/configuration.php');
use Aws\S3\S3Client;
use Aws\Ec2\Ec2Client;

//Receved user specifications for running test 
$u_customerid= $_POST["custid"];
$u_testtypeid = $_POST["testtype"];
$u_ostypeid = $_POST["ostype"];
$u_productid= $_POST["producttype"];

echo "testtype ${u_testtypeid}\n";
echo "producttype $u_productid\n";


//Test variables 
$testRootDir = "/var/www/html/testframework";

//Retrive prodcut from S3 hosted product bucket repo

//Determine product name from user input
if ($u_productid == "1"){
  $productName="replace1.1.pl";
} else {
  $productName="replace1.2.pl";
}

//Destination local path for downloaded product 
$localProductPath="$testRootDir" . "/tests/$productName";


//Create S3 client
try
{
  $S3 = S3Client::factory(array('key'    => AWS_PUBLIC_KEY,
                                'secret' => AWS_SECRET_KEY,
                                'region' => BUCKET_REGION));
}
catch (Exception $e)
{
  print("Error creating client:\n");
  print($e->getMessage());
}
             

//Download product
$result = $S3->getObject(array('Bucket' => PRODUCT_BUCKET,
                               'Key'    => $productName,
                               'SaveAs' => $localProductPath
                               ));

//modify the permisssion of the file to execute
chmod("$localProductPath", 0755); 


//Create an EC2 intance from an AMI as per user's specificateion
// Create the EC2 client
try
{
  $EC2 = Ec2Client::factory(array('key'    => AWS_PUBLIC_KEY,
                                  'secret' => AWS_SECRET_KEY,
                                  'region' => EC2_REGION));
}
catch (Exception $e)
{ 
  print("Error creating client:\n");
  print($e->getMessage());
}                                                                                                    

//select AMI as per user's specification
$amiId="ami-ffdca1cf";
if ($u_ostypeid == "1"){
  $amiId = "ami-ffdca1cf";
} else {
  $amiId = "ami-ffdca1cf";
}
  
echo "ami = $amiId\n";
try
{
  $Model = $EC2->runInstances(array('ImageId'      => $amiId,
                                  'KeyName'      => EC2_KEY,
                                  'InstanceType' => 't1.micro',
                                  'MinCount'     => 1,
                                  'MaxCount'     => 1,
                                  'SecurityGroups' => array('tanvir-sg-admin-west')
                                  ));
}

catch (Exception $e)
{
  exit("Could not launch instance - " . $e->getMessage () . "\n");
}

// Get the Id and Availability Zone of the instance
$Instances        = $Model['Instances'];
$InstanceId       = $Instances[0]['InstanceId'];
$PrivateDnsName   = $Instances[0]['PrivateDnsName'];   
$AvailabilityZone = $Instances[0]['Placement']['AvailabilityZone'];

print("Launched instance ${InstanceId} " .
      "with ip= $PrivateDnsName in availability zone ${AvailabilityZone}.\n");

// Wait for the instance's state to change to running
$EC2->waitUntilInstanceRunning(array('InstanceIds' => array($InstanceId)));

print("Instance is running.\n");

$credentialPath = "$testRootDir/credential/tanvir-west.pem";
$PrivateDnsName="ip-172-31-2-161.us-west-2.compute.internal";

//Get Testlist
//we would get the test list via DB but the new contrller IP
//is does not have access yet
///DB call as below
//$result = exec ("php tests.php $u_testtypeid");  //receive comma seperated list from DB
//$testListArray = explode(",", $result);          //populate testList array

if ($u_testtypeid = "1"){
  $testListArray = array("test1.pl","test2.pl","test3.pl");
} else {
 $testListArray = array("test4.pl","test5.pl");
}

//Record Date and Time
$dateTime=getdate();
$testDate = "$dateTime[mon]"."-"."$dateTime[mday]"."-"."$dateTime[year]";
$testTime="$dateTime[hours]".":"."$dateTime[minutes]".":"."$dateTime[seconds]";

echo "date = $testDate\n";
echo "time = $testTime\n";

//Run Test and record result in an associative array
for ($i=0; $i < count($testListArray); $i++) {
  $result = exec("cd $testRootDir/tests && /usr/bin/perl $testRootDir/tests/$testListArray[$i] $productName");
  //  $result = exec("cd $testRootDir/tests && /usr/bin/perl $testRootDir/tests/test3.pl $productName"); 

  echo "$testListArray[$i] $result;\n";
  if (($result == "Pass") or ($result == "Fail")){
    $testResult[$testListArray[$i]] = $result;
  } else{
    $testResult[$testListArray[$i]] ="Not Run";
  }
}
echo "complete Test Run!!\n";

//Populate DB is now not expsoed now due to DB controler connection issue.
//Pupulate Test Service
//Servcie table inputs: CustomerID OS_ID ProductID TypeID Date Time; 
//Test result inputs:   ServiceID ResultTypeID TestID
//  $service_id =  exec("php ./write_service.php $u_custid, $u_producti,$u_testtypeid, $testDate, $testTime");
//  $result  =  exec("php ./write_test.php $service_id, $resutTypeId,$testId"); 



exit(0);

?>
</body>
</html>
