<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'sqlconfig.php';

$labname = $_GET['labname'];
$labname = mysql_real_escape_string($labname);

$load_sql = "SELECT map FROM labmap WHERE lab_name = '".$labname."'";
$result = mysql_query($load_sql);
$row = mysql_fetch_assoc($result);
mysql_close($DB);

echo json_encode($row['map']);


