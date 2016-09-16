<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'sqlconfig.php';

$username = $_POST['username'];
$username = mysql_real_escape_string($username);
$firstname = $_POST['firstname'];
$firstname = mysql_real_escape_string($firstname);
$lastname = $_POST['lastname'];
$lastname = mysql_real_escape_string($lastname);
$staffID = $_POST['staffID'];
$staffID = mysql_real_escape_string($staffID);
$email = $_POST['email'];
$email = mysql_real_escape_string($email);
$password = $_POST['password'];
$password = mysql_real_escape_string($password);
$privilege = $_POST['privilege'];
$privilege = mysql_real_escape_string($privilege);

//Hashing Password
$hashed_pass = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO `admin_profile`(`username`, `password`, `privilege`, `email`, `staffID`, `firstname`, `lastname`) VALUES ('" . $username . "','" . $hashed_pass . "','" . $privilege . "','" . $email . "','" . $staffID . "','" . $firstname . "','" . $lastname . "')";
mysql_query($sql) or die(mysql_error());

mysql_close($DB);