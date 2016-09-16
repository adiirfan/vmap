<?php

include 'sqlconfig.php';

$adDelete = $_POST['adDelete'];

// Delete admin
if ($adDelete) {
    $sql_admin = "DELETE FROM ad WHERE ad_id = '".$adDelete."'";
    mysql_query($sql_admin) or die(mysql_error());
}

mysql_close($DB);

?>

