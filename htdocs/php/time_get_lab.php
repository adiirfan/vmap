<?php

	include('sqlconfig.php');

	date_default_timezone_set('Asia/Jakarta');



	if(isset($_GET['time'])){

	$hiddeninput = $_GET['hiddeninput'];

	$checkid = mysql_query("SELECT * from `lab_max_booking` WHERE lab_id = '" . $hiddeninput . "'");

	$start= $_GET['time'].':00';

	   if(mysql_num_rows ($checkid) > 0){
		mysql_query("UPDATE `lab_max_booking` SET `lab_max`= '" . $start . "' , `lab_satuan` = 'Hour' WHERE lab_id = '" . $hiddeninput . "'");
	   }
	   else{
		 mysql_query("INSERT into lab_max_booking (lab_max,lab_id,lab_satuan) VALUES ('". $start ."','". $hiddeninput ."','Hour')");
	   }
	 //echo "UPDATE `max_booking` SET `max`= '" . $start . "' WHERE max_booking_id = '" . $id . "'";

	 $jason= array(

					'result' => 'Berhasil',

					

					//'max' => $row2['max'],

					

					);

	echo json_encode($jason);

	 

	 

	}else{

	   

	   

	$query2 = mysql_query("select lab_max from lab_max_booking ");

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