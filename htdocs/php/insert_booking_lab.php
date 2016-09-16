<?php

	include('sqlconfig.php');
	mysql_select_db("lab_scheduling");
	date_default_timezone_set('Asia/Jakarta');
	
	
	
 	$tanggal_1=$_POST['start_date'];

	$tanggal_2=$_POST['end_date'];

	$text=$_POST['text_submit'];
	
	$student=$_POST['student_submit'];
	
	$email_submit=$_POST['email_submit'];
	
	$date1=$tanggal_1.":00";

	$date2= $tanggal_2.":00";
	
	$start = date("Y-m-d H:i:00", strtotime($date1));

	$end = date("Y-m-d H:i:00", strtotime($date2));
	$nama_lab=$_POST['lab_name_submit'];
	$lab_name=str_replace(" ","_",$_POST['lab_name_submit']);

	$table_lab=strtolower($lab_name);
	
	mysql_query("INSERT INTO `lab_scheduling`.`$table_lab` (`start_date`, `end_date`, `text`) VALUES ('$start', '$end', '$text')");

	//GET LAST ID

	$booking_id=mysql_insert_id();
	
	mysql_query("INSERT INTO `computer_availability`.`booking_lab` (`id`, `start_date`, `end_date`, `agenda`, `student_id`, `lab_name`, `booking_lab_email`) VALUES ('$booking_id', '$start', '$end', '$text', '$student','$nama_lab','$email_submit')");

	
	//Destroy booking student if same time with time booking
	$query = mysql_query("SELECT * 
			FROM  computer_availability.booking_student where start_booking BETWEEN '$start' AND '$end';");		
	if (!$query) {
    die('Invalid query: ' . mysql_error());
	}
	
	while ($checking = mysql_fetch_array($query)) {
			
		$queryupdate4 = "UPDATE computer_availability.booking_student SET `expired`= 1 WHERE booking_student_id = '".$checking['booking_student_id']."' ";
		mysql_query($queryupdate4) or die(mysql_error());
		
		$queryupdate5 = "UPDATE computer_availability.compstatus SET `booked`= 0, status=0 WHERE computer_name = '".$checking['computer_name']."' ";
		mysql_query($queryupdate5) or die(mysql_error());
				
				//echo "UPDATE computer_availability.booking_student SET `expired`= 1 WHERE booking_student_id = '".$checking['booking_student_id']."' ";
	}
	
	$email = mysql_query("select * from computer_availability.student where student_id='$student'");

	if (!$email) {

    die('Invalid query: ' . mysql_error());

	}

	//echo "select * from student where student_id='$student'";

	$email_send = mysql_fetch_assoc($email);
	
	//Config Email

	$sender_query = mysql_query("select * from computer_availability.email_config left join computer_availability.mail_set on email_config.mail_set_id=mail_set.mail_set_id");

	if (!$sender_query) {

    die('Invalid query: ' . mysql_error());

	}

	$email_sender = mysql_fetch_assoc($sender_query);

	$sender =$email_sender['sender'];

//	$name =$sender['student_name'];

	date_default_timezone_set('Etc/UTC');

	
    $current=$_SERVER['SERVER_NAME'].Dirname($_SERVER['PHP_SELF']);
	$actual_link = "http://$current";
	
	$url2 = "http://localhost/php/contents_lab.php?booking=".$booking_id."&lab=".$table_lab;

	$konten = file_get_contents($url2);  

	$url3 = 'http://localhost/php/contents_lab_admin.php?booking='.$booking_id."&lab=".$table_lab;

	$kontenadmin = file_get_contents($url3);  

	require '../mail/PHPMailerAutoload.php';

	function sendemail($sender,$subject,$konten,$host,$port,$password,$email_submit,$name,$secure) {

	$mail = new PHPMailer;

	//Tell PHPMailer to use SMTP
	$mail->isSMTP();
	
	//$mail->SMTPDebug = 2;

//Ask for HTML-friendly debug output
	//$mail->Debugoutput = 'html';

	$mail->Host = $host;

	$mail->Port = $port;

	$mail->SMTPSecure = $secure;

	$mail->SMTPAuth = true;

	
	$mail->Username = $sender;

	
	$mail->Password = $password;



	$mail->setFrom($sender, '');

	

	$mail->addAddress($email_submit, $name);

	

	$mail->Subject = $subject;



	$mail->msgHTML($konten);



	$mail->AltBody = 'This is a plain-text message body';


		if (!$mail->send()) {

		

		} else {

		

		}

	}
	//to user
	sendemail($sender,'Lab booking',$konten,$email_sender['host'],$email_sender['port'],$email_sender['password'],$email_submit,$email_send['student_name'],$email_sender['secure']);
	
	//to admin
	sendemail($sender,'Booking Information',$kontenadmin,$email_sender['host'],$email_sender['port'],$email_sender['password'],$sender,$email_send['student_name'],$email_sender['secure']);
	session_start();

	 echo '<br>edu'.$_SESSION['login_user'];

	// echo "INSERT INTO `computer_availability`.`booking_lab` (`id`, `start_date`, `end_date`, `agenda`, `student_id`, `lab_name`, `booking_lab_email`) VALUES ('$booking_id', '$start', '$end', '$text', '$student','$nama_lab','$email_submit')";
	 header("location:logout.php");
	echo $url3;
	//echo $student.'tes';

?>