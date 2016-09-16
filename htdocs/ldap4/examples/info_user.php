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
//require_once __DIR__.'/src/Adldap.php';
include ('../src/Adldap.php');


use adLDAP\adLDAP;
use adLDAP\Exceptions\adLDAPException;



// Hand everything over to the view for display.
$ldap_db = mysql_query("select * from computer_availability.ad order by ad_id asc ");
	
while ($row =  mysql_fetch_array($ldap_db)){
$domain=str_replace("@",".",$row['domain_controllers_1']);
$domain2=$row['domain_controllers_2'];



    $configuration = array(
       // 'user_id_key' => 'samaccountname',
        'account_suffix' => $row['account_suffix'],
        'person_filter' => array('category' => 'objectCategory', 'person' => 'person'),
        'base_dn' => $row['base_dn'],
        'domain_controllers' => array($domain),
        'admin_username' => $row['admin_username'],
        'admin_password' => $row['admin_password'],
        'real_primarygroup' => true,
        'use_ssl' => false,
        'use_tls' => false,
        'recursive_groups' => true,
        'ad_port' => '389',
        'sso' => false,
    );
  
    try
    {
        $ad = new Adldap($configuration);
	

       // echo "Awesome, we're connected!";
    } catch(AdldapException $e)
    {
       // echo "Uh oh, looks like we had an issue trying to connect: $e";
    }
	
	if(isset($_GET['name'])){
		$name=$_GET['name'];
	}
			  $results = $ad->search()->query('(cn='.$name.')');
			  $data=array($results);
			//echo '<pre>';
			//print_r($results);
		//	echo '<//pre>';
			
	
 $department="";
 $cn="";
 $mail="";
 $mobile="";
 $streetaddress="";
 $wwwhomepage=""; //Domain user
 $name="";

	
	if(isset($results[0]['department'])){
		$department=$results[0]['department'];
	}
	if(isset($results[0]['cn'])){
		$cn=$results[0]['cn'];
	}
	if(isset($results[0]['mail'])){
		$mail=$results[0]['mail'];
	}
	if(isset($results[0]['mobile'])){
		$mobile=$results[0]['mobile'];
	}
	if(isset($results[0]['streetaddress'])){
		$streetaddress=$results[0]['streetaddress'];
	}
	if(isset($results[0]['name'])){
		$name=$results[0]['name'];
	}

	$data=array( 
	
						'cn'=>$cn,
						'email' => $mail,
						'mobile' => $mobile,
						'name'=> $name,
						'streetaddress'=> $streetaddress,
						'category_ad'=> $row['category_ad'],
	
	);
	
	
	
	if($cn != null){
		echo json_encode($data);
		break;
	}
	
}
	?>