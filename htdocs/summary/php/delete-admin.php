<?php

include 'sqlconfig.php';

$adminToDelete = $_POST['adminToDelete'];

// Delete admin
if ($adminToDelete) {
    $sql_admin = "DELETE FROM admin_profile WHERE username = '".$adminToDelete."'";
    mysql_query($sql_admin) or die(mysql_error());
}

mysql_close($DB);
?>

