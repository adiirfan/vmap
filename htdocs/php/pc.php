<?php
	include(dirname(__FILE__) .'/sqlconfig.php');
	//$res = mysql_connect("localhost", "vmap", "rajakredit2016");
	mysql_select_db("lab_scheduling");
	date_default_timezone_set('Asia/Jakarta');
   
   
   $pc_name=$_GET['id'];
   $pc = mysql_query("select computer_name,comp_ip,lab_name,status,lab_group from computer_availability.compstatus where computer_name = '$pc_name' ");
   // $row = mysql_query($pc);
   $row2 =  mysql_fetch_assoc($pc);
   
   $tanggal_1=date("Y-m-d H:00:00", strtotime("+1 hours")); 
	$tanggal_2=date("Y-m-d H:00:00", strtotime("+2 hours")); 
	$now=date("Y-m-d");
	$batas_hari=date("Y-m-d H:00:00",strtotime('+1 days', strtotime( $now )));
	//7 27 2016 edu change start_booking <= '$tanggal_2' to start_booking < '$tanggal_2'
	$student = mysql_query("select * from computer_availability.booking_student left join computer_availability.student on booking_student.student_id=student.student_id where start_booking >= '$tanggal_1' and start_booking < '$tanggal_2'   and computer_name = '$pc_name' order by start_booking ASC");
	if (!$student) {
    die('Invalid query: ' . mysql_error());
	}
	$book_student = mysql_fetch_assoc($student);
	

	$lab_name=str_replace(" ","_",$row2['lab_name']);
	$table_lab=strtolower($lab_name);
	$now_lab=date("Y-m-d H:i:s");
	//echo $lab_name;
	$lab = mysql_query("select * from lab_scheduling.$table_lab where start_date <= '$now_lab' AND `end_date` >= '$now_lab'  order by start_date desc");
	if (!$lab) {
    die('Invalid query: ' . mysql_error());
	}
	$lab_book = mysql_fetch_assoc($lab);
	//echo "select * from lab_scheduling.$table_lab where start_date >= '$now_lab'  order by start_date desc";
 // echo "select * from $table_lab where start_date >= '$now_lab' limit 1 order by start_date desc";
   $jason= array(
					'pc' => $row2,
					'student' => $book_student,
					'lab' => $lab_book,
					);
   echo json_encode($jason);

//echo "select * from computer_availability.booking_student left join computer_availability.student on booking_student.student_id=student.student_id where start_booking >= '$tanggal_1' and start_booking <= '$tanggal_2'   and computer_name = '$pc_name' order by start_booking desc";

?>