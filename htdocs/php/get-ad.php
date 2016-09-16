<?php

include 'sqlconfig.php';
date_default_timezone_set('Asia/Jakarta');

$query_book = "SELECT * FROM ad";
$result_book = mysql_query($query_book);
//var_dump($result_admin);
$i = 0;
if (mysql_num_rows($result_book) >0){
    while ($row_admin = mysql_fetch_array($result_book)) {
		$ad_id[$i] = $row_admin['ad_id'];
        $account_suffix[$i] = $row_admin['account_suffix'];
        $domain_controllers_1[$i] = $row_admin['domain_controllers_1'];
        $domain_controllers_2[$i] = $row_admin['domain_controllers_2']; 
		$base_dn[$i] = $row_admin['base_dn'];
		$admin_username[$i] = $row_admin['admin_username'];
		$admin_password[$i] = $row_admin['admin_password']; 
		
		$url = 'http://localhost/ldap/examples/connection.php?id='.$row_admin['ad_id'];

		$json = file_get_contents($url);  
		$ldap = json_decode($json);
		$hasil[$i]=$ldap->konek;

		
        $i++;
    }
}

mysql_close($DB);

$data['ad_id'] = $ad_id;
$data['account_suffix'] = $account_suffix;
$data['domain_controllers_1'] = $domain_controllers_1;
$data['domain_controllers_2'] = $domain_controllers_2;
$data['base_dn'] = $base_dn;
$data['admin_username'] = $admin_username;
$data['admin_password'] = $admin_password;
$data['hasil'] = $hasil;

echo json_encode($data);

?>