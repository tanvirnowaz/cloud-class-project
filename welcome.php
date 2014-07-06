<!DOCTYPE html>

<!
 * RSEG176 CLOUD COMPUTING
 * Author : Krishnaveni Vempati
 * Creation : 6/18/2014
 * Welcome_Master.php
>


<html>

	<head>
		<title>Cloud Hosted Environment And Application Testing</title>
		
		</head>
	</center></h1>
<body>
<div id="container" style="width:1500px">

<div id="header" style="background-color:blue;">
<h1 style="margin-bottom:0;"><center>Welcome To <br> Cloud Hosted Environment And Application Testing</center></h1></div>



<form name=welcomemenu method=post action=master.php>

<div id="menu" style="background-color:lightblue;height:1500px;width:300px;float:left;">




<!--------------------------------------------------------- Application Tenant ----------------------------------------------->
<?php
$con=mysqli_connect("rseg176-groupa-assignment1v2.cmi3uvkivrhy.us-east-1.rds.amazonaws.com","rseg176admin","CloudDatabase","rseg176_assignment1dbv2","3306");

// Check the connection to the database
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>


<Label><h3>Application Tenant Info</h3></Label>
<Label>Customer ID : </Label>
<select name="custid">
<?php
	$res = mysqli_query($con,"SELECT * FROM APP_CUSTOMER");
	while($row = mysqli_fetch_assoc($res))  {
    echo '<option value="'.$row['CustomerID'].'">'.$row['CustomerID']." ". $row['First_Name']." ".$row['Last_Name'].'</option>';  }  
?>
</select>
<br>
<br>



<!--------------------------------------------------------- Application OS ----------------------------------------------->
<?php
$con=mysqli_connect("rseg176-groupa-assignment1v2.cmi3uvkivrhy.us-east-1.rds.amazonaws.com","rseg176admin","CloudDatabase","rseg176_assignment1dbv2","3306");

// Check the connection to the database
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>

<Label><h3>Application Operating Info</h3></Label>
<Label>OS Name : </Label>
<select name="osname">
<?php  
	$res = mysqli_query($con,"SELECT * FROM APP_OS");
	while($row = mysqli_fetch_assoc($res))  {
    echo '<option value="'.$row['OS_Name'].'">'.$row['OS_Name'].'</option>';  }  
	mysqli_close($con);
?>
</select>
<br>
<br>



<!--------------------------------------------------------- Application OS Product ----------------------------------------------->
<?php
$con=mysqli_connect("rseg176-groupa-assignment1v2.cmi3uvkivrhy.us-east-1.rds.amazonaws.com","rseg176admin","CloudDatabase","rseg176_assignment1dbv2","3306");

// Check the connection to the database
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>

<Label><h3>Application OS Product</h3></Label>
<Label>Product Name : </Label>
<select name="productname">
<?php  
	$res = mysqli_query($con,"SELECT * FROM APP_PRODUCT");
	while($row = mysqli_fetch_assoc($res))  {
    echo '<option value="'.$row['Product_Name'].'">'.$row['Product_Name'].'</option>';  }  
	mysqli_close($con);
	?>
</select>
<br>
<br>


<!--------------------------------------------------------- Application Test Type ----------------------------------------------->
<?php
$con=mysqli_connect("rseg176-groupa-assignment1v2.cmi3uvkivrhy.us-east-1.rds.amazonaws.com","rseg176admin","CloudDatabase","rseg176_assignment1dbv2","3306");

// Check the connection to the database
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>

<Label><h3>Application Test Type</h3></Label>

<Label>Type Name : </Label>
<select name="typename">
<?php  
	$res = mysqli_query($con,"SELECT * FROM APP_TEST_TYPE");
	while($row = mysqli_fetch_assoc($res))  {
    echo '<option value="'.$row['Type_Name'].'">'.$row['Type_Name'].'</option>';  }  
	mysqli_close($con);
	?>
</select>
<br>
<br>
<br>
   <!--<input type="submit" value="Submit" onclick="this.form.target='master.php';return true;"> -->
   <input type="submit" name="submit" value="Submit">
   <div id="txtHint"><br><b>*Select all the fields and then Click Submit button</b></div>
   </div>
   

</form>




<form name=reports method=post>
<br>
<br>
<div id="txtHint"><b>*Click on Generate Reports button to see the updated results.</b></div>
<input type="submit" value="Generate Reports" onclick="this.form.target=reports;"> 
<br>
<br>
<div id="content" style="background-color:#EEEEEE;height:1400px;width:1150px;float:left;">

<?php
$con=mysqli_connect("rseg176-groupa-assignment1v2.cmi3uvkivrhy.us-east-1.rds.amazonaws.com","rseg176admin","CloudDatabase","rseg176_assignment1dbv2","3306");

// Check the connection to the database
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>

<?php
/**$res1 = mysqli_query($con,"SELECT * FROM APP_CUSTOMER");
	while($row = mysqli_fetch_assoc($res1))  {
    echo '<option value="'.$row['CustomerID'].'">'.$row['CustomerID']." ". $row['First_Name']." ".$row['Last_Name'].'</option>';  }
	$CustomerID = $row['CustomerID'];
	
	echo $CustomerID;*/
	$res = mysqli_query($con,"SELECT APP_SERVICE.ServiceID, 
				    APP_CUSTOMER.CustomerID, 
				    APP_CUSTOMER.First_Name, 
				    APP_CUSTOMER.Last_Name, 
				    APP_OS.OS_Name, 
				    APP_PRODUCT.Product_Name, 
				    APP_TEST_TYPE.Type_Name, 
				    APP_TEST_LIST.List_Name,
				    APP_RESULT_TYPE.Result_Type,
				    APP_SERVICE.Date, 
				    APP_SERVICE.Time
			     FROM ((((((APP_CUSTOMER 	
			     		INNER JOIN APP_SERVICE ON APP_CUSTOMER.CustomerID = APP_SERVICE.CustomerID) 
			     		INNER JOIN APP_PRODUCT ON APP_SERVICE.ProductID = APP_PRODUCT.ProductID) 
			     		INNER JOIN APP_OS ON APP_SERVICE.OS_ID = APP_OS.OS_ID) 
			     		INNER JOIN APP_TEST_TYPE ON APP_SERVICE.TypeID = APP_TEST_TYPE.TypeID) 
			     		INNER JOIN APP_TEST_RESULTS ON APP_SERVICE.ServiceID = APP_TEST_RESULTS.ServiceID) 
			     		INNER JOIN APP_TEST_LIST ON (APP_TEST_TYPE.TypeID = APP_TEST_LIST.TypeID) 
			     			AND (APP_TEST_RESULTS.TestID = APP_TEST_LIST.TestID)) 
			     		INNER JOIN APP_RESULT_TYPE ON APP_TEST_RESULTS.ResultTypeID = APP_RESULT_TYPE.ResultTypeID
			     WHERE APP_CUSTOMER.CustomerID=APP_CUSTOMER.CustomerID
			     ORDER BY APP_TEST_RESULTS.ServiceID DESC");
				 
		echo "<table border='2px' style = 'width:1000px' cellpadding='10x'>";		
	/*	echo "<th style=background-color:skyblue>";*/
		echo "<tr><th bgcolor='lightblue'>ServiceID</th><th bgcolor='skyblue'>CustomerID</th><th bgcolor='skyblue'>First_Name</th><th bgcolor='skyblue'>Last_Name</th><th bgcolor='skyblue'>OS_Name</th><th bgcolor='skyblue'>Product_Name</th><th bgcolor='skyblue'>Type_Name</th><th bgcolor='skyblue'>Test_Name</th><th bgcolor='skyblue'>Result_Type</th><th bgcolor='skyblue'>ExecutionDate</th><th bgcolor='skyblue'>Time</th>";	
				 
	while($row1 = mysqli_fetch_assoc($res))  {
    //echo '<option value="'.$row['CustomerID'].'">'.$row['CustomerID']." ". $row['First_Name']." ".$row['Last_Name'].'</option>';  }  

//*	echo "<table width='600' cellpadding='20' cellspacing='5' border='1'>";**/
//	$result_value = $row1['Result_Type'];
	
	//if($result_value == "Pass")
	//$flag = '1';
	//echo "$result_value";
	
	echo "<tr><td>".$row1['ServiceID']."</td><td>".$row1['CustomerID']."</td><td>".$row1['First_Name']."</td><td>".$row1['Last_Name']."</td><td>".$row1['OS_Name']."</td><td>".$row1['Product_Name']."</td><td>".$row1['Type_Name']."</td><td>".$row1['List_Name']."</td><td >".$row1['Result_Type']."</td><td>".$row1['Date']."</td><td>".$row1['Time']."</td></tr>";
/**	you can do this for as many rows as you like**/
	}
	echo "</table>";
/** this ends your table**/
	
	// Close the database connection
	mysqli_close($con);	
?>
<br>
<br>

<form>





</div>

<div id="footer" style="background-color:blue;clear:both;text-align:center;">
Copyright © CHEAT.com</div>

</div>



<p>




</body>
</html>
