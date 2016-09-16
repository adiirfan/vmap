<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'sqlconfig.php';

$lab_name_old = $_POST['lab_name_old'];
$lab_name_old = mysql_real_escape_string($lab_name_old);
$lab_name_new = $_POST['lab_name_new'];
$lab_name_new = mysql_real_escape_string($lab_name_new);
$description = $_POST['description'];
$description = mysql_real_escape_string($description);

if ($lab_name_new == $lab_name_old) {
    $sql = "UPDATE labmap SET description = '" . $description . "' WHERE lab_name = '" . $lab_name_old . "'";
    mysql_query($sql) or die(mysql_error());
} else {
    $sql1 = "UPDATE labmap SET lab_name = '" . $lab_name_new . "', description = '" . $description . "' WHERE lab_name = '" . $lab_name_old . "'";
    $sql2 = "UPDATE compstatus SET lab_name = '" . $lab_name_new . "' WHERE lab_name = '" . $lab_name_old . "'";
    mysql_query($sql1) or die(mysql_error());
    mysql_query($sql2) or die(mysql_error());

    mysql_select_db("lab_scheduling") or die("Unable to select database");
    $lab_schedule_old = strtolower(str_replace(' ', '_', $lab_name_old));
    $lab_schedule_new = strtolower(str_replace(' ', '_', $lab_name_new));

    $sql_sche = "ALTER TABLE `".$lab_schedule_old."` RENAME TO `".$lab_schedule_new."`";
    mysql_query($sql_sche) or die(mysql_error());
}


mysql_close($DB);
