<?php include(SITE_PATH.'summary/libs/class/DB.php');?>
<?php date_default_timezone_set('Asia/Jakarta'); ?>
<?php
	$hostname = DATABASE_LOCATION;
	$username = DATABASE_USERNAME;
	$password = DATABASE_PASS;
	$dbname = DATABASE_NAME;
	
	$DB = new DB($hostname, $username, $dbname, $password);
	//$con = $DB->connectDB();
?>