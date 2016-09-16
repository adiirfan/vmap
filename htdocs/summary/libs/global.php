<?php 
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
define ("SITE_NAME" , "Hasjrat-Toyota Indonesia");
define ("COMPANY_NAME" , "Hasjrat-Toyota Indonesia");
define ("SUPERADMIN_EMAIL" , "");
define ("MANAGEMENT_EMAIL" , "");
define ("MARKETING_EMAIL" , "");
define ("SITE_EMAIL" , "");
define ("SITE_EMAIL_PASS" , "");
define ("MAIL_PORT" , "");
define ("MAIL_SERVER" , "");

define ("DATABASE_USERNAME" , "root");
define ("DATABASE_NAME" , "computer_availability");
define ("DATABASE_PASS" , "");
define ("DATABASE_LOCATION" , "localhost");

define ("SITE_URL" , "http://".$_SERVER['SERVER_NAME']."/");
define ("UPLOAD_FOLDER", "public/files");

define ('DOC_ROOT', rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/');
define ("TEMP_PATH" , DOC_ROOT.'__templates/');
define ("UPLOAD_DIR" , DOC_ROOT.UPLOAD_FOLDER.'/');

define ("WEBSITE" , SITE_URL);
define ("SITE_PATH" , DOC_ROOT);

define ("MEDIA_READ_DIR", SITE_URL.UPLOAD_FOLDER.'/');
define ("MEDIA_READ_PATH", UPLOAD_DIR);

define ("IMAGE_READ_DIR", MEDIA_READ_DIR.'images/');
define ("TEMPLATE_IMG" , SITE_URL.'images/');

define ("FCK_URL", SITE_URL."public/fck/");
define ("FCK_PATH", DOC_ROOT."public/fck/");

$now = date("Y-m-d H:i:s", time());
define ("CURRENT_TIME" , $now);
define ("PRODUCTLIMIT" , 12);
define ("CACHE_IMAGEREADER" , false);

/* require(SITE_PATH . 'demo/summary/libs/class/smarty/Smarty.class.php');

class Smarty_Class extends Smarty {
	function Smarty_Class()
	{
		// Class Constructor.
		// These automatically get set with each new instance.
		$this->Smarty();
		$this->template_dir = SITE_PATH . '__templates/';
		$this->compile_dir 	= SITE_PATH . '__templates_c/';
		$this->config_dir 	= SITE_PATH . '__templates_c/configs/';
		$this->cache_dir 	= SITE_PATH . '__templates_c/cache/';
	}
}
 */

//local setting
//$uri_0 = explode('/',$_SERVER['REQUEST_URI']);
//$uri   = $uri_0[1]; 

//demo or live
$uri = substr($_SERVER['REQUEST_URI'],1,100000);

?>