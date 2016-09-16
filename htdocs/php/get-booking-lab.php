<?php

include 'sqlconfig.php';
date_default_timezone_set('Asia/Jakarta');

$now=date("Y-m-d 00:00:00");
$batas_hari=date("Y-m-d 00:00:00",strtotime('+1 days', strtotime( $now )));

$query_book = "SELECT a.lab_name,a.lab_id,b.lab_max FROM labmap a left join lab_max_booking b on a.lab_id=b.lab_id";
$result_book = mysql_query($query_book);
//var_dump($result_admin);
$i = 0;
if (mysql_num_rows($result_book) >0){
    while ($row_admin = mysql_fetch_array($result_book)) {
		$lab_id[$i] = $row_admin['lab_id'];   
		$lab_name[$i] = $row_admin['lab_name'];   
		$lab_max[$i] = $row_admin['lab_max'];   
		
        $i++;
    }
}

mysql_close($DB);
$data['lab_id'] = $lab_id;
$data['lab_name'] = $lab_name;
$data['lab_max'] = $lab_max;
echo json_encode($data);

?>