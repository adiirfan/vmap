<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'sqlconfig.php';

$labID = $_POST['lab_id']; // Getting lab ID
$labID = mysql_real_escape_string($labID);

if ($labID) {
    $sql = "SELECT map FROM labmap WHERE lab_name ='" . $labID . "'";
    ($result = mysql_query($sql))or die(mysql_error());
    if ($result) {
        while ($row = mysql_fetch_assoc($result)) {
            $labmap = $row['map'];
        }
    }
}
mysql_close($DB);

echo $labmap;
?>
