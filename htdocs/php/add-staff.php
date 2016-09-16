<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'sqlconfig.php';

$name = $_POST['name'];
$name = mysql_real_escape_string($name);
$username = $_POST['username'];
$username = mysql_real_escape_string($username);
$password = md5($_POST['password']);
$password = mysql_real_escape_string($password);

$email = mysql_real_escape_string($_POST['email']);
$mobile = mysql_real_escape_string($_POST['mobile']);
$address = mysql_real_escape_string($_POST['address']);
$category=mysql_real_escape_string($_POST['category']);

$sql = "INSERT INTO `student`(`student_name`, `student_username`, `student_password`, `student_email`, `student_mobile`, `student_address`, `category_ad`) VALUES ('" . $name . "','" . $username . "','" . $password . "','" . $email . "','" . $mobile . "','" . $address . "','" . $category . "')";
mysql_query($sql) or die(mysql_error());

mysql_close($DB);