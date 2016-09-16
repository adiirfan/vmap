<?php
include 'sqlconfig.php';

$query_admin = "SELECT * FROM student where category_ad=1 limit 100";
$result_admin = mysql_query($query_admin);
//var_dump($result_admin);
$i = 0;
if (mysql_num_rows($result_admin) >0){
    while ($row_admin = mysql_fetch_assoc($result_admin)) {
        $admin_name[$i] = $row_admin['student_name'];
        $admin_username[$i] = $row_admin['student_username'];
        $admin_pw[$i] = $row_admin['student_password'];   
		$admin_email[$i] = $row_admin['student_email'];
		$admin_mobile[$i] = $row_admin['student_mobile'];
        $i++;
    }
}

mysql_close($DB);

$data['admin_name'] = $admin_name;
$data['admin_username'] = $admin_username;
$data['admin_pw'] = $admin_pw;
$data['admin_email'] = $admin_email;
$data['admin_mobile'] = $admin_mobile;

echo json_encode($data);
?>