<?php


/**
 * This file contains a working example of adLDAP in operation.
 *
 * @file
 */
if (!file_exists(__DIR__.'/../vendor/autoload.php')) {
    echo 'Before using this demo, please run <code>composer dump-autoload</code>';
    exit(1);
}
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../src/adLDAP.php';

use adLDAP\adLDAP;
use adLDAP\Exceptions\adLDAPException;



// Hand everything over to the view for display.




    $configuration = array(
        'user_id_key' => 'samaccountname',
        'account_suffix' => '@domain.local',
        'person_filter' => array('category' => 'objectCategory', 'person' => 'person'),
        'base_dn' => 'DC=domain,DC=local',
        'domain_controllers' => array('DC1.domain.local', 'DC2.domain.local'),
        'admin_username' => 'administrator',
        'admin_password' => 'password',
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
        
        echo "Awesome, we're connected!";
    } catch(AdldapException $e)
    {
        echo "Uh oh, looks like we had an issue trying to connect: $e";
    }

	
	
	?>