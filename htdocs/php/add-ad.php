<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'sqlconfig.php';

$suffix = $_POST['suffix'];
$suffix = mysql_real_escape_string($suffix);
$controller_1 = $_POST['controller_1'];
$controller_1 = mysql_real_escape_string($controller_1);
$controller_2 = $_POST['controller_2'];
$controller_2 = mysql_real_escape_string($controller_2);
$base = $_POST['base'];
$base = mysql_real_escape_string($base);
$username = $_POST['username'];
$username = mysql_real_escape_string($username);
$pass = $_POST['pass'];
$pass = mysql_real_escape_string($pass);
$category = $_POST['category'];
$category = mysql_real_escape_string($category);


if($_POST['id'] != null){
	$id=$_POST['id'];
		$sql = "UPDATE `ad` SET `account_suffix`='" . $suffix . "',`domain_controllers_1`='" . $controller_1 . "',`domain_controllers_2`='" . $controller_2 . "',`base_dn`='" . $base . "',`admin_username`='" . $username . "',`admin_password`='" . $pass . "',`category_ad`='" . $category . "' WHERE ad_id='$id'";
		mysql_query($sql) or die(mysql_error());
}else{
		$sql = "INSERT INTO `ad`(`account_suffix`, `domain_controllers_1`, `domain_controllers_2`, `base_dn`, `admin_username`, `admin_password`,`category_ad`) VALUES ('" . $suffix . "','" . $controller_1 . "','" . $controller_2 . "','" . $base . "','" . $username . "','" . $pass . "','" . $category . "')";
		mysql_query($sql) or die(mysql_error());
}

mysql_close($DB);