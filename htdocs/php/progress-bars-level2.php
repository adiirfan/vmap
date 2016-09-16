<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'sqlconfig.php';

$lab_group = $_GET['lab_group']; // Getting group name
$lab_group = mysql_real_escape_string($lab_group);
$index = $_GET['index'];

$query = mysql_query("SELECT * FROM labmap WHERE lab_group ='".$lab_group."'");

$i = 0;
while ($row = mysql_fetch_assoc($query)) {
    $lab_name[$i] = $row['lab_name'];    
    $i++;
    
}

mysql_close($DB);

$data['lab_name'] = $lab_name;
$data['index'] = $index;

echo json_encode($data)
?>