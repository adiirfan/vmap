<?php

include 'sqlconfig.php';

$mapToDelete = $_POST['mapToDelete'];
//echo $mapToDelete;

// Delete Map and PC
if ($mapToDelete) {
    foreach ($mapToDelete as $lab_name) {
        $lab_name = mysql_real_escape_string($lab_name);
        $lab_schedule = strtolower(str_replace(' ','_',$lab_name));
        
        $sql_lab = "DELETE FROM labmap WHERE lab_name = '".$lab_name."'"; 
        $sql_comp = "DELETE FROM compstatus WHERE lab_name = '".$lab_name."'";
        
        mysql_query($sql_lab) or die(mysql_error());
        mysql_query($sql_comp) or die(mysql_error());
        echo "$lab_name DELETED from database\n";
    }
}

// Delete Schedule
mysql_select_db("lab_scheduling") or die("Unable to select database");
if ($mapToDelete) {
    foreach ($mapToDelete as $lab_name) {
        $lab_name = mysql_real_escape_string($lab_name);
        $lab_schedule = strtolower(str_replace(' ','_',$lab_name));
       
        
        $sql_schedule = "DROP TABLE `".$lab_schedule."`";
        
        mysql_query($sql_schedule) or die(mysql_error());
        echo "$lab_name Schedule DELETED\n";
    }
}


mysql_close($DB);
?>

