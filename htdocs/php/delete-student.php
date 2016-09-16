<?php

include 'sqlconfig.php';

$adminToDelete = $_POST['adminToDelete'];

// Delete admin
if ($adminToDelete) {
    $sql_admin = "DELETE FROM student WHERE student_name = '".$adminToDelete."'";
    mysql_query($sql_admin) or die(mysql_error());
}

mysql_close($DB);
?>

