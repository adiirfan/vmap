<?php

/*
Test for the new user collections object
*/

//error_reporting(E_ALL ^ E_NOTICE);

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../src/adLDAP.php';
use adLDAP\adLDAP;
use adLDAP\Exceptions\adLDAPException;
 $options = array(
       // 'user_id_key' => 'samaccountname',
        'account_suffix' => '@vmap.com',
       // 'person_filter' => array('category' => 'objectCategory', 'person' => 'person'),
        'base_dn' => 'DC=vmap,DC=com',
        'domain_controllers' => array('ServerAD.vmap.com'),
        'admin_username' => 'administrator',
        'admin_password' => 'Welcome123',
        'real_primarygroup' => true,
        'use_ssl' => false,
        'use_tls' => false,
        'recursive_groups' => true,
        'ad_port' => '389',
        'sso' => false,
    );
try {
	
	   
    $ad = new adLDAP($options);
	echo "konek";
} catch (adLDAPException $e) {
    echo $e;
    exit();
}



$results = $ad->search()->select(array('cn', 'givenname','mail','street'))->all();


 //$results = $ad->search()->where('cn', '=', 'Edu')->get();
  // $results = $ad->search()->where('cn', 'starts_with', 'Edu')->get();
//print_r($results);



 //  $username = 'Alfian';
    
 
//print_r($collection->memberOf);
//print_r($collection->displayName);
