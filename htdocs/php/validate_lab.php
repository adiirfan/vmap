<?php
	include('sqlconfig.php');
	$res = mysql_connect("localhost", "root", "");mysql_select_db("lab_scheduling");
	date_default_timezone_set('Asia/Jakarta');
   

	$start_booking=str_replace("/"," ",$_GET['start']);
	$start= $start_booking.':00';
 

    $end_booking = str_replace("/"," ",$_GET['end']);
	$end=$end_booking.':00';
	
	$exp = explode(" ", $start);
	$exp2 = explode(" ", $end);
									
	$date=$exp[0];
	$date2=$exp2[0];
	$min=$exp[1];	
	$min2=$exp2[1];	
	
	$lab_name2=str_replace("-"," ",$_GET['lab']);
	
	//GET MAX TIME
	 $query2 = mysql_query("select max from computer_availability.max_booking ");
	if (!$query2) {
    die('Invalid query: ' . mysql_error());
	}
	
	$row2 =  mysql_fetch_array($query2);
	
	//GET MAX TIME Lab
	 $query3 = mysql_query("select lab_id from computer_availability.labmap where lab_name='$lab_name2'  ");
	if (!$query3) {
    die('Invalid query: ' . mysql_error());
	}
	$row3 =  mysql_fetch_array($query3);
	
	$lab_id=$row3['lab_id'];
	$query4 = mysql_query("select lab_max from computer_availability.lab_max_booking where lab_id='$lab_id'  ");
	if (!$query4) {
    die('Invalid query: ' . mysql_error());
	}
	$row4 =  mysql_fetch_array($query4);


	$lab_name=str_replace("-","_",$_GET['lab']);
	$table_lab=strtolower($lab_name);
	$now_lab=date("Y-m-d H:i:s");
	
	$lab = mysql_query("select * from lab_scheduling.$table_lab where start_date <= '$start' AND `end_date` >= '$end'  order by start_date desc");
	if (!$lab) {
    die('Invalid query: ' . mysql_error());
	}
	if (mysql_num_rows($lab)) {
    $booked_lab= 1;
	} else {
    $booked_lab = 0;
	}
	

	
	
	//Role Booking
	$dteStart = new DateTime(str_replace("/"," ",$_GET['start'])); 
	$dteEnd   = new DateTime(str_replace("/"," ",$_GET['end'])); 
	$dteDiff  = $dteStart->diff($dteEnd); 
   // print $dteDiff->format("%H:%I:%S"); 
	
	$now=date("Y-m-d H:i:s");
	
	$startDate = time();
	//echo $dteDiff->format("%H:%I:00");
	$now_2 = date('Y-m-d 00:00:00', strtotime('+1 day', $startDate));
	$lab_max_time=$row4['lab_max'];
	if($row4['lab_max'] == null ){
	$lab_max_time='05:00:00';	
	}
	if($dteDiff->format("%H:%I:00") > $lab_max_time ){ //if submit book > maximum time
		$result="Maximum time lab $lab_name booking is ".substr($row2['max'],0,5);
	}else if(str_replace("/"," ",$_GET['start']) > $now_2){
		$result="maximum one day";
	}else if($dteDiff->format("%H:%I:00") > $row2['max'] ){ //if submit book > maximum time
		$result="Maximum time booking is ".substr($row2['max'],0,5);
	}else if($end < $start){
		$result="Start date cannot more End date";
	}else if($end == $start){
		$result="Start date cannot same End date";
	}else if ($booked_lab == 1){
		$result= "Lab has booked by class";
	}else {
		$result="Success";
	}
	/*
	if (in_array(1, $booked_detail)){
		$result= "Pc has booked";	
	}
*/
   $jason= array(
					'result' => $result
					
					);
   echo json_encode($jason);
 // echo str_replace("/"," ",$_GET['start']).'   '.$now_2;
   
   


?>