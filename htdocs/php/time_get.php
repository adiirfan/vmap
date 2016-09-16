<?php
	include('sqlconfig.php');
	date_default_timezone_set('Asia/Jakarta');

	if(isset($_GET['time'])){
	   
	
	$start= $_GET['time'].':00';
	   $id=1;
	 mysql_query("UPDATE `max_booking` SET `max`= '" . $start . "' WHERE max_booking_id = '" . $id . "'");
	 //echo "UPDATE `max_booking` SET `max`= '" . $start . "' WHERE max_booking_id = '" . $id . "'";
	 $jason= array(
					'result' => 'Berhasil',
					
					//'max' => $row2['max'],
					
					);
	echo json_encode($jason);
	 
	 
	}else{
	   
	   
	$query2 = mysql_query("select max from max_booking ");
	if (!$query2) {
    die('Invalid query: ' . mysql_error());
	}
	
	$row2 =  mysql_fetch_array($query2); 
	   
	   $hour=substr($row2['max'],0,2);
	    $min=substr($row2['max'],3,-3);
	   $jason= array(
					'hour' => $hour,
					'min' => $min,
					);
	echo json_encode($jason);
  
	}
	//GET MAX TIME

?>