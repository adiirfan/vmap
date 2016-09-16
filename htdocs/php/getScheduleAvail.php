<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'sqlconfig.php';

$lab_id = $_POST['lab_id']; // Getting lab ID
$lab_id = mysql_real_escape_string($lab_id);
$labsql = strtolower(str_replace(' ','_',$lab_id));

mysql_select_db("lab_scheduling") or die("Unable to select database");

$query = "SELECT * FROM `".$labsql."` WHERE `start_date` <= NOW() AND `end_date` >= NOW()";
$result = mysql_query($query);

if (mysql_num_rows($result)){
    echo 1;
    
}
else{
    echo 0;
}

mysql_close($DB);