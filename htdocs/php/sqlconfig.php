<?php
date_default_timezone_set('Asia/Jakarta');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
#add your database username and password
$user = "root";
$password = "";
$database = "computer_availability";

#connect to the database
$DB = mysql_connect('127.0.0.1', $user, $password);
mysql_select_db($database) or die("Unable to select database");