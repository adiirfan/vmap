<?php
	include('sqlconfig.php');
	//$res = mysql_connect("localhost", "root", "");
//mysql_select_db("computer_availability");
date_default_timezone_set('Asia/Jakarta');

if(isset($_POST['update'])){
	
	$account=$_POST['account'];
	$domain_1=$_POST['domain_1'];
	$domain_2=$_POST['domain_2'];
	$base_dn=$_POST['base_dn'];
	$username=$_POST['username'];
	$password=$_POST['password'];
	$pc_query = mysql_query("UPDATE ad SET account_suffix='$account', domain_controllers_1='$domain_1' , domain_controllers_2='$domain_2' ,base_dn='$base_dn', admin_username='$username',admin_password='$password' WHERE ad_id=1") or die(mysql_error());;
	
	$url = 'http://localhost/demo/ldap/examples/index.php';

	$json = file_get_contents($url);  
	$data = json_decode($json);
		$cek= $data->konek;
		echo $cek;
	//	if($cek == 1){
		
	//echo 1;
	//	}

	//echo "UPDATE ad SET account_suffix='$account', domain_controllers_1='$domain_1' , domain_controllers_2='$domain_2' ,base_dn='$base_dn', admin_username='username',admin_password='$password' WHERE ad_id=1";
	
	   }else {

	 
	$ad= mysql_query("select * from computer_availability.ad ");
	   // $row = mysql_query($pc);
	$data=array();
	$i=0;
	   while ($row =  mysql_fetch_array($ad)){
		   
		   $data['account']=$row['account_suffix'];
		    $data['domain_controllers_1']=$row['domain_controllers_1'];
			 $data['domain_controllers_2']=$row['domain_controllers_2'];
			  $data['base_dn']=$row['base_dn'];
			   $data['username']=$row['admin_username'];
			     $data['password']=$row['admin_password'];
		   $i++;
	   }
	   echo json_encode($data);
	   }
	
?>