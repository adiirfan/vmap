<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'sqlconfig.php';

$idToCheck = $_GET['idToCheck'];
$idToCheck = mysql_real_escape_string($idToCheck);

if ( mysql_num_rows(mysql_query("SELECT * FROM compstatus WHERE computer_name = '".$idToCheck."'")) > 0){
    echo 0;
} else {
    echo 1;
}