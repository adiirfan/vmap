<?php

include 'sqlconfig.php';

$adminToView = $_POST['adminToView'];

$query_admin = "SELECT * FROM student WHERE student_name = '" . $adminToView . "'";

$result_admin = mysql_query($query_admin);
$i = 0;
if (mysql_num_rows($result_admin) > 0) {
    $row_admin = mysql_fetch_assoc($result_admin);
    $admin_name[$i] = $row_admin['student_name'];
    $admin_username[$i] = $row_admin['student_username'];
	$admin_email[$i] = $row_admin['student_email'];
	$admin_mobile[$i] = $row_admin['student_mobile'];
	$admin_address[$i] = $row_admin['student_address'];
    $i++;
}

mysql_close($DB);

$data['admin_name'] = $admin_name;
$data['admin_username'] = $admin_username;
$data['admin_email'] = $admin_email;
$data['admin_mobile'] = $admin_mobile;
$data['admin_address'] = $admin_address;

echo json_encode($data);
?>
