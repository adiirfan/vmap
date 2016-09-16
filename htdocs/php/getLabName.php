<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'sqlconfig.php';

$total_map = mysql_query("SELECT * FROM labmap");
$num_maps = mysql_num_rows($total_map);

$i = 0;
while ($row = mysql_fetch_assoc($total_map)) {
    $lab_name[$i] = $row['lab_name'];
    $i++;
}
mysql_close($DB);
echo json_encode($lab_name);
?>