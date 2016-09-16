<?php date_default_timezone_set('Asia/Kuala_Lumpur'); ?>
<?php 
    error_reporting(E_ALL ^ E_NOTICE);
    ini_set('display_errors', 'On');
  	define("SITE_NAME" , "Moizland Indonesia");
	  define("COMPANY_NAME" , "Moizland Indonesia");
	  define("SUPERADMIN_EMAIL" , "vas@batavianet.com");
  	define("SITEURL", "http://".$_SERVER['SERVER_NAME']."/");
    define("SITEPATH", $_SERVER['DOCUMENT_ROOT'] . "/");
  	define("SITE_PATH", $_SERVER['DOCUMENT_ROOT'] . "/");

  	/* database config */
  	define("DATABASE_LOCATION", "localhost");
    define("DATABASE_USERNAME", "root");
    define("DATABASE_PASS", "");
    define("DATABASE_NAME", "moizland");
   
    require_once(SITEPATH.'libs/con_open.php');
?>