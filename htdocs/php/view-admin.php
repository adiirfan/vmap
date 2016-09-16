<?php

include 'sqlconfig.php';

$adminToView = $_POST['adminToView'];

$query_admin = "SELECT * FROM admin_profile WHERE username = '" . $adminToView . "'";

$result_admin = mysql_query($query_admin);
$i = 0;
if (mysql_num_rows($result_admin) > 0) {
    $row_admin = mysql_fetch_assoc($result_admin);
    $admin_name[$i] = $row_admin['username'];
    $admin_firstname[$i] = $row_admin['firstname'];
    $admin_lastname[$i] = $row_admin['lastname'];
    $admin_staffID[$i] = $row_admin['staffID'];
    $admin_privilege[$i] = $row_admin['privilege'];
    $admin_email[$i] = $row_admin['email'];
    $i++;
}

mysql_close($DB);

$data['admin_name'] = $admin_name;
$data['admin_firstname'] = $admin_firstname;
$data['admin_lastname'] = $admin_lastname;
$data['admin_staffID'] = $admin_staffID;
$data['admin_privilege'] = $admin_privilege;
$data['admin_email'] = $admin_email;

echo json_encode($data);
?>
