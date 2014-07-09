<?php
/* Author: Tanvir Nowaz
 * configuration.php - Common definitions for test framework
 */

/*
 * 1 - AWS SDK for PHP
 * ===================
 */

require_once('/var/www/html/testframework/vendor/autoload.php');

/*
 * 2 - Package Locations
 * =====================
 *
 * Magpie RSS           http://magpierss.sourceforge.net/
 * Simple HTML DOM      http://simplehtmldom.sourceforge.net/
 *
 */

define('MAGPIE_DIR',            'magpierss/');
define('SIMPLE_HTML_DOM_DIR',   '/var/www/html/testframework/simplehtmldoc/');

/*
 * 3 - AWS Credentials
 * ===================
 *
 * Create an AWS Account at http://aws.amazon.com and
 * download your public and secret keys. Edit the following
 * lines to reference your credentials:
 */
define('AWS_PUBLIC_KEY', 'AKIAIIVKJQVKHKPBPWBQ');
define('AWS_SECRET_KEY', 'qLowFlWyZyJo3YJ0l/JBRIPI9A2qYJ3nQ/sIN4oP');

/*
 * 4 - AWS Regions
 * ===============
 *
 * Set the following variables to the AWS region that you want
 * to use. You can set the S3 bucket and the EC2 region separately,
 * but in most cases you'll want to use the same value for both
 * items.
 */

define('BUCKET_REGION',       'us-west-2');
define('EC2_REGION',          'us-west-2');

/*
 * 5 - Bucket Names
 * ================
 *
 * Edit the following two names to refer to the S3 bucket
 * names that you want to use. The names must be globally
 * unique.
 * 
 * The THUMB_BUCKET_SUFFIX is appended to BOOK_BUCKET and
 * the resulting name must also be globally unique.
 */
define('PRODUCT_BUCKET',  'cheat-products-repo');
define('TEST_BUCKET',  'tanvir-test-bucket-222');
define('THUMB_BUCKET_SUFFIX', '-aws');

/*
 * 6 - EC2 Key and AMI
 * ===================
 *
 * Set your EC2 key name in the following line. If you
 * are not running the code in the us-west-2 region,
 * find the AMI identifier for the 64-bit Amazon Linux
 * AMI and edit the second line.
 */

define('EC2_KEY',             'tanvir-west');
define('EC2_AMI',             'ami-ffdca1cf');    // 64-bit Redhat Linux AMI


//DB Configuration
define('RDS_HOST', 'rseg176-groupa-assignment1v2.cmi3uvkivrhy.us-east-1.rds.amazonaws.com');
define('RDS_USER', 'rseg176admin');
define('RDS_PASS', 'CloudDatabase');
define('RDS_DB', 'rseg176_assignment1dbv2');
define('RDS_PORT', 3306);
