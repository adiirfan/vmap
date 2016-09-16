<?php

//echo "XXXXXXXXXXXXXXXX PHP FILE EXECUTED XXXXXXXXXXXXXXXXXXXXXXXXXX";
include 'sqlconfig.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
//$array_ajax = [];
$labID = $_GET['lab_id']; // Getting lab ID
$labID = mysql_real_escape_string($labID);
$arrayTime = $_GET['arrayTime'];

####################################################################################################
#
# COMPUTER STATUS QUERY
####################################################################################################
#
# CHECK IF ROOM IS BOOKED
mysql_select_db("lab_scheduling") or die("Unable to select database"); // Switch Active Database

$labsql = strtolower(str_replace(' ', '_', $labID));

$queryschedule = "SELECT * FROM `" . $labsql . "` WHERE `start_date` <= NOW() AND `end_date` >= NOW()";
$resultschedule = mysql_query($queryschedule);

if (mysql_num_rows($resultschedule)) {
    $booked = 1;
} else {
    $booked = 0;
}

$k = 0;
foreach ($arrayTime as $time_to_check) {
    $sqltime = "SELECT * FROM `" . $labsql . "` WHERE `start_date` <= CONCAT(DATE_FORMAT(NOW(),'%Y-%m-%d')".",' ','".$time_to_check.":00') AND `end_date` >= CONCAT(DATE_FORMAT(NOW(),'%Y-%m-%d')".",' ','".$time_to_check.":00')";
//    echo $sqltime;
//    echo $sqltime;
    $resulttime = mysql_query($sqltime) or die(mysql_error());
//    echo $resulttime;

    if (mysql_num_rows($resulttime)) {
        $this_time[$k] = 'Booked';
    } else {
        $this_time[$k] = 'Available';
    }
    $k++;
}


# GET ALL COMPUTER STATUS
mysql_select_db($database) or die("Unable to select database"); // Switch Active Database
# Update Booking status
$queryupdate = "UPDATE `compstatus` SET `booked`= '" . $booked . "' WHERE lab_name = '" . $labID . "'";
mysql_query($queryupdate) or die(mysql_error());

#get all the computer's row of data
$result = mysql_query("SELECT * FROM compstatus WHERE lab_name = '" . $labID . "'");

$status_name = "";

while ($row = mysql_fetch_assoc($result)) {
    $status_name = $status_name . ($row['status'] . " " . $row['computer_name'] . ",");
}

$array_ajax['status_name'] = $status_name;
####################################################################################################
#
# PIE CHART QUERY 
####################################################################################################
#get total number of computer for each status
# 0 = available
# 1 = busy
# 3 = shutdown
# Booked = 0 (LAB IS NOT BOOKED)
# Booked = 1 (LAB IS BOOKED)
# All Labs
$array_ajax['no_avail'] = mysql_num_rows(mysql_query("SELECT * FROM compstatus WHERE status='0' AND booked = '0'"));
$array_ajax['no_busy'] = mysql_num_rows(mysql_query("SELECT * FROM compstatus WHERE status='1' AND booked = '0'"));
$array_ajax['no_notavail'] = mysql_num_rows(mysql_query("SELECT * FROM compstatus WHERE booked = '1'"));
$array_ajax['no_shutdown'] = mysql_num_rows(mysql_query("SELECT * FROM compstatus WHERE status='3' AND booked = '0'"));

# Current Lab
$array_ajax['this_avail'] = mysql_num_rows(mysql_query("SELECT * FROM compstatus WHERE status='0' AND booked = '0' AND lab_name = '" . $labID . "'"));
$array_ajax['this_busy'] = mysql_num_rows(mysql_query("SELECT * FROM compstatus WHERE status='1' AND booked = '0' AND lab_name = '" . $labID . "'"));
$array_ajax['this_notavail'] = mysql_num_rows(mysql_query("SELECT * FROM compstatus WHERE booked = '1' AND lab_name = '" . $labID . "'"));
$array_ajax['this_shutdown'] = mysql_num_rows(mysql_query("SELECT * FROM compstatus WHERE status='3' AND booked = '0' AND lab_name = '" . $labID . "'"));
####################################################################################################
#
# PROGRESS BAR QUERY
####################################################################################################
### LEVEL 1 PROGRESS BAR ###
$bar1_query = mysql_query("SELECT DISTINCT `lab_group` FROM `labmap`");

$i = 0;
while ($bar1_row = mysql_fetch_assoc($bar1_query)) {
    $lab_group[$i] = $bar1_row['lab_group'];
    $lab_group_total[$i] = mysql_num_rows(mysql_query("SELECT * FROM compstatus WHERE lab_group = '" . $lab_group[$i] . "'"));
    $lab_group_avail[$i] = mysql_num_rows(mysql_query("SELECT * FROM compstatus WHERE lab_group = '" . $lab_group[$i] . "' AND status = '0' AND booked = '0'"));
    $lab_group_unavail[$i] = $lab_group_total[$i] - $lab_group_avail[$i];
    
    $i++;
}

### LEVEL 2 PROGRESS BAR ###
$bar2_query = mysql_query("SELECT * FROM `labmap`");

$i = 0;
while ($bar2_row = mysql_fetch_assoc($bar2_query)) {
    $lab_name[$i] = $bar2_row['lab_name'];
    $lab_name_total[$i] = mysql_num_rows(mysql_query("SELECT * FROM compstatus WHERE lab_name = '" . $lab_name[$i] . "'"));
    $lab_name_avail[$i] = mysql_num_rows(mysql_query("SELECT * FROM compstatus WHERE lab_name = '" . $lab_name[$i] . "' AND status = '0' AND booked = '0'"));
    $lab_name_unavail[$i] = $lab_name_total[$i] - $lab_name_avail[$i];

    $i++;
}
####################################################################################################

mysql_close($DB);

### PACKAGING OUTPUT DATA
$array_ajax['lab_group'] = $lab_group;
$array_ajax['lab_group_total'] = $lab_group_total;
$array_ajax['lab_group_avail'] = $lab_group_avail;
$array_ajax['lab_group_unavail'] = $lab_group_unavail;

$array_ajax['lab_name'] = $lab_name;
$array_ajax['lab_name_total'] = $lab_name_total;
$array_ajax['lab_name_avail'] = $lab_name_avail;
$array_ajax['lab_name_unavail'] = $lab_name_unavail;

$array_ajax['booked'] = $booked;
$array_ajax['this_time'] = $this_time;


$array_ajax['current_date'] = date('jS \of F Y');
$array_ajax['current_time'] = date('H:i');

echo json_encode($array_ajax);
?>