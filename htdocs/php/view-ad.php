<?php

include 'sqlconfig.php';

$adminToView =$_POST['adminToView'];

$query_admin = "SELECT * FROM ad WHERE ad_id = '" . $adminToView . "'";

$result_admin = mysql_query($query_admin);
$i = 0;
if (mysql_num_rows($result_admin) > 0) {
    $row_admin = mysql_fetch_assoc($result_admin);
   $ad_id[$i] = $row_admin['ad_id'];
        $account_suffix[$i] = $row_admin['account_suffix'];
        $domain_controllers_1[$i] = $row_admin['domain_controllers_1'];
        $domain_controllers_2[$i] = $row_admin['domain_controllers_2']; 
		$base_dn[$i] = $row_admin['base_dn'];
		$admin_username[$i] = $row_admin['admin_username'];
		$admin_password[$i] = $row_admin['admin_password']; 
		$category_ad[$i] = $row_admin['category_ad'];   		
   
}else{
		$ad_id[$i] = "";
        $account_suffix[$i] = "";
        $domain_controllers_1[$i] = "";
        $domain_controllers_2[$i] = ""; 
		$base_dn[$i] = "";
		$admin_username[$i] = "";
		$admin_password[$i] = ""; 
		$category_ad[$i] = "";		
}

mysql_close($DB);

$data['ad_id'] = $ad_id;
$data['account_suffix'] = $account_suffix;
$data['domain_controllers_1'] = $domain_controllers_1;
$data['domain_controllers_2'] = $domain_controllers_2;
$data['base_dn'] = $base_dn;
$data['admin_username'] = $admin_username;
$data['admin_password'] = $admin_password;
$data['category_ad'] = $category_ad;

echo json_encode($data);
?>
