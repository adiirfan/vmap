<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();
require_once 'passwordLib.php';
$user = "root";
$password = "";
$database = "computer_availability";

#connect to the database
$DB = mysql_connect('127.0.0.1', $user, $password);
@mysql_select_db($database) or die("Unable to select database");

$adminID = $_POST['username']; //var_dump($adminID);die;// Getting lab ID
$adminID = mysql_real_escape_string($adminID);
$adminPW = $_POST['password']; // Getting lab ID
$adminPW = mysql_real_escape_string($adminPW);

$query = "SELECT * FROM admin_profile WHERE username = '".$adminID."'";
$result = mysql_query($query);

$row = mysql_fetch_assoc($result);
//$boolean = password_verify($adminPW, $row['password']);
if(password_verify($adminPW, $row['password'])){
    echo 1;
    $_SESSION['adminID'] = $adminID;
    $_SESSION['privilege'] = $row['privilege'];
}
else{
    echo 0;
}

mysql_close($DB);
?>