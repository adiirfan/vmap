<?php	include('sqlconfig.php'); $res = mysql_connect("localhost", "root", "");mysql_select_db("lab_scheduling");	date_default_timezone_set('Asia/Jakarta');      if(isset($_GET['date'])){	   $now= date("Y-m-d H:i:s" );	  $date= $_GET['date'];	  $time= $_GET['time'];	  $date_2= $_GET['date2'];	  $time_2= $_GET['time2'];	  	   //cek book class	   	$tanggal=$date.' '.$time;	$tanggal2=$date_2.' '.$time_2;	$pc=$_GET['pc'];	$kueri = mysql_query("select lab_name from computer_availability.compstatus where computer_name = '$pc' "); // SELECT lab name	$cek_lab =  mysql_fetch_assoc($kueri);	$lab_name=str_replace(" ","_",$cek_lab['lab_name']);	$table_lab=strtolower($lab_name);	$now_lab=date("Y-m-d H:i:s");		$lab = mysql_query("select * from lab_scheduling.$table_lab where start_date <= '$tanggal' AND end_date >= '$tanggal2'  order by start_date desc");	//echo "select * from lab_scheduling.$table_lab where start_date <= '$tanggal' AND end_date >= '$tanggal2'  order by start_date desc";	 $lab_book =  mysql_fetch_array($lab);	 	 		 $query = mysql_query("SELECT * 			FROM  computer_availability.booking_student left join computer_availability.student on student.student_id=booking_student.student_id			WHERE  `start_booking` <= CONCAT( DATE_FORMAT(  '$date',  '%Y-%m-%d' ) ,  ' ',  '$time' ) 			AND  `end_booking` >= CONCAT( DATE_FORMAT(  '$date_2',  '%Y-%m-%d' ) ,  ' ',  '$time_2' ) AND computer_name='$pc'			LIMIT 1");								if (!$query) {    die('Invalid query: ' . mysql_error());	}  	 $row =  mysql_fetch_array($query);	 $jason= array(					'result' => $row,					'lab' => $lab_book					);   echo json_encode($jason);	      }else { ///Batas   $start_booking=str_replace("/"," ",$_GET['start']);  $start= $start_booking.':00';    $pc_get=$_GET['pc'];    $end_booking = str_replace("/"," ",$_GET['end']);	$end=$end_booking.':00';		$exp = explode(" ", $start);	$exp2 = explode(" ", $end);										$date=$exp[0];	$date2=$exp2[0];	$min=$exp[1];		$min2=$exp2[1];			//GET MAX TIME	 $query2 = mysql_query("select max from computer_availability.max_booking ");	if (!$query2) {    die('Invalid query: ' . mysql_error());	}		 $row2 =  mysql_fetch_array($query2);	//Cek booked by class lab 	$pc = mysql_query("select lab_name from computer_availability.compstatus where computer_name = '$pc_get' "); // SELECT lab name	$cek_lab =  mysql_fetch_assoc($pc);	$lab_name=str_replace(" ","_",$cek_lab['lab_name']);	$table_lab=strtolower($lab_name);	$now_lab=date("Y-m-d H:i:s");		$lab = mysql_query("select * from lab_scheduling.$table_lab where start_date <= '$start' AND `end_date` >= '$end'  order by start_date desc");	if (!$lab) {    die('Invalid query: ' . mysql_error());	}	if (mysql_num_rows($lab)) {    $booked_lab= 1;	} else {    $booked_lab = 0;	}		  	//Cek booked by student	$query = mysql_query("SELECT * 			FROM  computer_availability.booking_student left join computer_availability.student on student.student_id=booking_student.student_id			WHERE  `start_booking` <= CONCAT( DATE_FORMAT(  '$date',  '%Y-%m-%d' ) ,  ' ',  '$min' ) 			AND  `end_booking` >= CONCAT( DATE_FORMAT(  '$date2',  '%Y-%m-%d' ) ,  ' ',  '$min2' ) and computer_name='$pc_get'			LIMIT 1");									if (!$query) {    die('Invalid query: ' . mysql_error());	}	if (mysql_num_rows($query)) {    $booked = 1;	} else {    $booked = 0;	}		$booked_detail=array();	$i=0;	//cek booking by student 2 for datail time	$now=date("Y-m-d");	$batas_hari=date("Y-m-d H:00:00",strtotime('+1 days', strtotime( $now )));	$query_detail=mysql_query("SELECT * 			FROM  computer_availability.booking_student 			WHERE  `end_booking` >= '$now_lab'			AND  `end_booking` <= '$batas_hari' and computer_name='$pc_get'");							while ($checking = mysql_fetch_array($query_detail)) {		if ($checking['start_booking'] < $start){			//echo $checking['start_booking'].' '.$checking['end_booking'];				if ($checking['start_booking'] < $start){										if ($checking['end_booking'] > $start){						$booked_detail[$i] = 1;										}				}					}else if ($checking['start_booking'] > $start){			//echo $checking['start_booking'].' '.$checking['end_booking'];			//echo $checking['end_booking'];				if ($checking['start_booking'] < $end){					if ($checking['end_booking'] > $end){							$booked_detail[$i] = 1;					}					if ($checking['start_booking'] > $start){							$booked_detail[$i] = 1;					}										}					}else {		$booked_detail[$i] = 0;			}				$i++;	}				//Role Booking	$dteStart = new DateTime(str_replace("/"," ",$_GET['start'])); 	$dteEnd   = new DateTime(str_replace("/"," ",$_GET['end'])); 	$dteDiff  = $dteStart->diff($dteEnd);    // print $dteDiff->format("%H:%I:%S"); 		$now=date("Y-m-d H:i:s");		$startDate = time();	$now_2 = date('Y-m-d 00:00:00', strtotime('+1 day', $startDate));	if(str_replace("/"," ",$_GET['start']) > $now_2){		$result="maximum one day";	}else if($dteDiff->format("%H:%I:00") > $row2['max'] ){ //if submit book > maximum time		$result="Maximum time booking is ".substr($row2['max'],0,5);	}else if($end < $start){		$result="Start date cannot more End date";	}else if($end == $start){		$result="Start date cannot same End date";	}	else if($now >= $start ){ //if current time > submit date		$result= "Date booking must be more now";	}else if ($booked == 1) {		$result= "Pc has booked";		}else if ($booked_lab == 1){		$result= "Pc has booked by class";	}else {		$result="Success";	}		if (in_array(1, $booked_detail)){		$result= "Pc has booked";		}   $jason= array(					'result' => $result										);   echo json_encode($jason);        }?>