<?php
	include('sqlconfig.php');
//	$res = mysql_connect("localhost", "root", "");
mysql_select_db("lab_scheduling");
date_default_timezone_set('Asia/Jakarta');

if(isset($_GET['pc'])){
	$pc=$_GET['pc'];
	$tes="waw";
	
	$pc_query = mysql_query("select * from computer_availability.compstatus where computer_name='$pc' ");
	
	 $row =  mysql_fetch_array($pc_query);
	 $tes1=htmlentities($row['computer_name']);
	 $tes2="$tes1";
	 $status=null;
	 if($row['booked'] == 1){
		  $status="Booked";
	 }else {
		 
		 if($row['status']==0){
			 $status="free";
		 }else if($row['status']==1){
			  $status="Busy";
		 }else if($row['status']==4){
			  $status="Booking";
		 }else {
			  $status="off";
			 
		 }
	 }
	 
	///Booking Lab
	$lab_name=str_replace(" ","_",$row['lab_name']);
	//$lab_name=$row['comp_ip'];
	$table_lab=strtolower($lab_name);
	$now_lab=date("Y-m-d H:i:s");
	//echo $lab_name;
	$lab = mysql_query("select * from lab_scheduling.$table_lab where start_date <= '$now_lab' AND `end_date` >= '$now_lab'  order by start_date desc");
	if (!$lab) {
    die('Invalid query: ' . mysql_error());
	}
	$lab_book = mysql_fetch_assoc($lab);
	
	$lab_data=array();
	$lab_label=array();
	
	 if($lab_book <= 0 ){
		  $lab_data['start_date']="";
		 $lab_data['end_date']="";
		  $lab_data['text']="";
		  
		  $lab_label['start_date']="";
		 $lab_label['end_date']="";
		  $lab_label['text']="";
		 
	 }else{
		 $lab_data['start_date']=$lab_book['start_date'].'<br>';
		 $lab_data['end_date']=$lab_book['end_date'].'<br>';
		 $lab_data['text']=$lab_book['text'].'<br>';
		 
		  $lab_label['start_date']="Start date :";
		 $lab_label['end_date']="End_date :";
		 $lab_label['text']="Agenda :";
	 }
	 
	 
	 ///Bokooking Student
	 $tanggal_1=date("Y-m-d H:00:00", strtotime("+1 hours")); 
	$tanggal_2=date("Y-m-d H:00:00", strtotime("+2 hours")); 
	$now=date("Y-m-d");
	$batas_hari=date("Y-m-d H:00:00",strtotime('+1 days', strtotime( $now )));
	$student = mysql_query("select * from computer_availability.booking_student left join computer_availability.student on booking_student.student_id=student.student_id where start_booking >= '$tanggal_1' and start_booking <= '$tanggal_2'   and computer_name = '$pc' order by start_booking desc");
	if (!$student) {
    die('Invalid query: ' . mysql_error());
	}
	
	$book_student = mysql_fetch_assoc($student);
	 $book=array(); 
	 $label=array(); 
	 if($book_student <= 0 ){
		//$book_student="Free"; 
		$book['student_name']="";
		$book['start_booking']="";
		$book['end_booking']="";
		
		$label['student_name']="";
		$label['start_booking']="";
		$label['end_booking']="";
		
		
	 }else{
		
		$book['student_name']=$book_student['student_name'].'<br>';
		$book['start_booking']=$book_student['start_booking'].'<br>';
		$book['end_booking']=$book_student['end_booking'].'<br>';
		
		$label['student_name']="Student name :";
		$label['start_booking']="Start Booking :";
		$label['end_booking']="End Booking :";
	 }
	 
	 
	 $json=array(
	 
			'pc'=>$row,
			'status'=>$status,
			'student' => $book,
			'label' => $label,
			'lab' => $lab_data,
			'lab_label' => $lab_label
	 
	 );
		 //echo $row['computer_name'].' ('.$status.')'; 
		 echo json_encode($json);

	}else{
	
	$pc = mysql_query("select computer_name from computer_availability.compstatus ");
	   // $row = mysql_query($pc);
	$data=array();
	$i=0;
	   while ($row =  mysql_fetch_array($pc)){
		   $data[$i]=$row;
		   $i++;
	   }
	   echo json_encode($data);
	   }
?>