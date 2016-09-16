<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'sqlconfig.php';

$query = mysql_query("SELECT DISTINCT `lab_group` FROM `labmap`");

$i = 0;
while ($row = mysql_fetch_assoc($query)) {
    $lab_group[$i] = $row['lab_group'];
    $lab_group_total[$i] = mysql_num_rows(mysql_query("SELECT * FROM compstatus WHERE lab_group = '".$lab_group[$i]."'"));
    $lab_group_avail[$i] = mysql_num_rows(mysql_query("SELECT * FROM compstatus WHERE lab_group = '".$lab_group[$i]."' AND status = '0' "));
    $lab_group_unavail[$i] = $lab_group_total[$i] - $lab_group_avail[$i];
    
    $i++;
    
}

mysql_close($DB);

$data['lab_group'] = $lab_group;
$data['lab_group_total'] = $lab_group_total;
$data['lab_group_avail'] = $lab_group_avail;
$data['lab_group_unavail'] = $lab_group_unavail;
echo json_encode($data)
?>