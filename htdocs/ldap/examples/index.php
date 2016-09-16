<?php

/**
 * This file contains a working example of adLDAP in operation.
 *
 * @file
 */
 $user = "root";
$password = "";
$database = "computer_availability";

#connect to the database
$DB = mysql_connect('127.0.0.1', $user, $password);
mysql_select_db($database) or die("Unable to select database");


 
if (!file_exists(__DIR__.'/../vendor/autoload.php')) {
    echo 'Before using this demo, please run <code>composer dump-autoload</code>';
    exit(1);
}
require_once __DIR__.'/../vendor/autoload.php';
//require_once __DIR__.'/../src/adLDAP.php';

use adLDAP\adLDAP;
use adLDAP\Exceptions\adLDAPException;

$ad = new \Adldap\Adldap();

$konek="";
$hasil=0;
// Create a configuration array.
$ldap_db = mysql_query("select * from computer_availability.ad order by ad_id asc ");
	
while ($row =  mysql_fetch_array($ldap_db)){
$domain=$row['domain_controllers_1'];
$domain2=$row['domain_controllers_2'];

$config = [
  'account_suffix'        =>$row['account_suffix'],
  'domain_controllers'    => [$domain, $domain2],
  'base_dn'               =>$row['base_dn'],
  'admin_username'        => $row['admin_username'],
  'admin_password'        =>  $row['admin_password'],
];

// Create a new connection provider.
$provider = new \Adldap\Connections\Provider($config);

// Add the provider to Adldap.
$ad->addProvider('default', $provider);

// Try connecting to the provider.
	try {
		// Connect using the providers alias name.
		$ad->connect('default');

		if(isset($_GET['username'])){
		$username = $_GET['username'];
		$password = str_replace("eduganteng","#",$_GET['password']);

		}else {
		$username 	="esd";
		$password ="sdsd";
		}

	$konek="Has been connect Active Directory";
		if ($provider->auth()->attempt($username, $password, $bindAsUser = true)) {
		 
		  
		  $hasil=1;

		}else{
			$hasil=0;
			
		}

		
		
		if($hasil==1){
			$result=array('hasil'=>$hasil,'konek'=>$konek);
		
			break;
		}else{
			$result=array('hasil'=>$hasil,'konek'=>$konek);
		}
	  
	} catch (\Adldap\Exceptions\Auth\BindException $e) {

		// There was an issue binding / connecting to the server.
		//$result=array('hasil'=>0);
		//echo json_encode($result);
		//echo $e;
		
		// $result=array('hasil'=>0,'konek'=>"Cannot Connect");
	//	echo json_encode($result);
		

	}
	
}
echo json_encode($result);