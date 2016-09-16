<?php

include 'sqlconfig.php';

$query_admin = "SELECT * FROM admin_profile";

$result_admin = mysql_query($query_admin);
$i = 0;
if (mysql_num_rows($result_admin) >0){
    while ($row_admin = mysql_fetch_assoc($result_admin)) {
        $admin_name[$i] = $row_admin['username'];
        $admin_pw[$i] = $row_admin['password'];
        $admin_privilege[$i] = $row_admin['privilege'];
        $admin_email[$i] = $row_admin['email'];       
        $i++;
    }
}

mysql_close($DB);

$data['admin_name'] = $admin_name;
$data['admin_pw'] = $admin_pw;
$data['admin_privilege'] = $admin_privilege;
$data['admin_email'] = $admin_email;
echo json_encode($data);
?>