<?php

include 'sqlconfig.php';
date_default_timezone_set('Asia/Jakarta');

$now=date("Y-m-d 00:00:00");
$batas_hari=date("Y-m-d 00:00:00",strtotime('+1 days', strtotime( $now )));

$query_book = "SELECT * FROM booking_student left join compstatus on booking_student.computer_name=compstatus.computer_name left join student on student.student_id=booking_student.student_id where booking_student.expired='1' order by booking_student.booking_student_id DESC";
$result_book = mysql_query($query_book);
//var_dump($result_admin);
$i = 0;
if (mysql_num_rows($result_book) >0){
    while ($row_admin = mysql_fetch_array($result_book)) {
		$booking_student_id[$i] = $row_admin['booking_student_id'];
        $student_id[$i] = $row_admin['student_id'];
        $student_name[$i] = $row_admin['student_username'];
        $pc_name[$i] = $row_admin['computer_name']; 
		$lab_name[$i] = $row_admin['lab_name'];   
		$start[$i] = $row_admin['start_booking'];
		$end[$i] = $row_admin['end_booking'];   
		
		$dteStart = new DateTime($row_admin['start_booking']); 
		$dteEnd   = new DateTime($row_admin['end_booking']); 
		$dteDiff  = $dteStart->diff($dteEnd); 
		$duration[$i]= $dteDiff->format("%H:%I:%S"); 
		
        $i++;
    }
}

mysql_close($DB);

$data['booking_student_id'] = $booking_student_id;
$data['student_id'] = $student_id;
$data['student_name'] = $student_name;
$data['pc_name'] = $pc_name;
$data['lab_name'] = $lab_name;
$data['start'] = $start;
$data['end'] = $end;
$data['duration'] = $duration;
echo json_encode($data);

?>