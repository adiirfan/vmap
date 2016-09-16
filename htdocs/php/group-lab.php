<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'sqlconfig.php';

$labGroup = $_POST['labGroup'];
$labGroup = mysql_real_escape_string($labGroup);
$labToGroup = $_POST['labToGroup'];

if ($labToGroup) {

    foreach ($labToGroup as $lab_name) {
        $lab_name = mysql_real_escape_string($lab_name);
        $sql_lab = "UPDATE labmap SET lab_group = '" . $labGroup . "' WHERE lab_name = '" . $lab_name . "'";
        $sql_comp = "UPDATE compstatus SET lab_group = '" . $labGroup . "' WHERE lab_name = '" . $lab_name . "'";

        mysql_query($sql_lab) or die(mysql_error());
        mysql_query($sql_comp) or die(mysql_error());
    }
}

mysql_close($DB);