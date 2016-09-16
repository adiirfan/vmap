<?php
	include('sqlconfig.php');
	$res = mysql_connect("localhost", "root", "");
mysql_select_db("computer_availability");
date_default_timezone_set('Asia/Jakarta');

if(isset($_POST['update'])){
	
	$sender=$_POST['sender'];	$password=$_POST['password'];
	$subject=$_POST['subject'];
	$prolog=$_POST['prolog'];
	//$body=$_POST['body'];

	$ending=$_POST['ending'];	$type=$_POST['type'];
	$pc_query = mysql_query("UPDATE email_config SET sender='$sender', subject='$subject' , prolog='$prolog', ending='$ending',password='$password',mail_set_id='$type' WHERE email_config_id=1") or die(mysql_error());;

	   }else {

	$ad= mysql_query("select * from computer_availability.email_config ");
	   // $row = mysql_query($pc);
	$data=array();
	$i=0;
	   while ($row =  mysql_fetch_array($ad)){
		   
			$data['sender']=$row['sender'];			$data['password']=$row['password'];
		    $data['subject']=$row['subject'];
			$data['prolog']=$row['prolog'];
			$data['body']=$row['body'];
			$data['footer']=$row['footer'];
			$data['ending']=$row['ending'];			$data['type']=$row['mail_set_id'];
		   $i++;
	   }
	   echo json_encode($data);
	   }
	
?>