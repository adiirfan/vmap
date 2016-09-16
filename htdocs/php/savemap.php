<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

#add your database username and password
include 'sqlconfig.php';

$labmap = $_POST['maptext']; // Getting HTML
$labmap = mysql_real_escape_string($labmap);
$labname = $_POST['labname']; // Getting Lab Name
$labname = mysql_real_escape_string($labname);
$labgroup = $_POST['labgroup']; // Getting Lab Group
$labgroup = mysql_real_escape_string($labgroup);

if (isset($_POST['pc_ids'])) {
    $pc_ids = $_POST['pc_ids'];
}

if (isset($_POST['mac_ids'])) {
    $mac_ids = $_POST['mac_ids'];
}
echo "<h4><u> Map Status </u></h4>";

if (isset($labmap)) {
    // Check if labname exist
    $sql_check = "SELECT * FROM labmap WHERE lab_name = '" . $labname . "'";
    $result_check = mysql_query($sql_check);

    if (mysql_num_rows($result_check) > 0) {
        // If Exist, update map and labgroup, and delete all the current PC in the map
        $sql_update = "UPDATE labmap SET map = '" . $labmap . "', lab_group = '" . $labgroup . "' WHERE lab_name = '" . $labname . "'";
        $sql_update_delete = "DELETE FROM compstatus WHERE lab_name = '" . $labname . "'";
        mysql_query($sql_update) or die(mysql_error());
        mysql_query($sql_update_delete) or die(mysql_error());
        echo "MAP is OVERWRITTEN and UPDATED <br>";
    } else {
        // Else, Create New map
        $sql = "INSERT INTO labmap SET map = '" . $labmap . "',lab_name = '" . $labname . "', lab_group = '" . $labgroup . "'";
        mysql_query($sql) or die(mysql_error());
        echo "MAP INSERTED<br>";
    }
}

echo "<h4><u> PC Status</u> </h4>";
// Insert PC
if (isset($pc_ids)) {
    foreach ($pc_ids as $id) {
        $id = mysql_real_escape_string($id);
        $sql = "INSERT INTO compstatus SET computer_name ='" . $id . "',lab_name ='" . $labname . "',computer_type ='PC', status = '3', lab_group = '" . $labgroup . "'";
        mysql_query($sql) or die(mysql_error());
        echo "$id INSERTED into database<br>";
    }
}

// Insert MAC
if (isset($mac_ids)) {
    foreach ($mac_ids as $id) {
        $id = mysql_real_escape_string($id);
        $sql = "INSERT INTO compstatus SET computer_name ='" . $id . "',lab_name ='" . $labname . "',computer_type ='MAC', status = '3',lab_group = '" . $labgroup . "'";
        mysql_query($sql) or die(mysql_error());
        echo "$id INSERTED into database<br>";
    }
}

echo "<h4><u> Schedule Status </u></h4>";
// Create a table for scheduling
mysql_select_db("lab_scheduling") or die("Unable to select database");

if (mysql_num_rows($result_check) > 0) {
    echo "NO Schedule is created or altered";
} else {
    $lab_schedule = strtolower(str_replace(' ', '_', $labname));
    $sqlschedule = "CREATE TABLE `" . $lab_schedule . "` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `text` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
)";

    mysql_query($sqlschedule) or die(mysql_error());
    echo "$labname SCHEDULE created<br>";
}


mysql_close($DB);
?>