<?php
   include('sqlconfig.php');
	$tanggal_1=$_POST['start_date'];
	$tanggal_2=$_POST['end_date'];
	$pc=$_POST['pc_submit'];
	$student=$_POST['student_submit'];		$email_submit=$_POST['email_submit'];
  
	//$start_rep=str_replace("/","-",$tanggal_1);
   // $end_rep=str_replace("/","-",$tanggal_2);
	$date1=$tanggal_1.":00";
	$date2= $tanggal_2.":00";
	
	$start = date("Y-m-d H:i:00", strtotime($date1));
	$end = date("Y-m-d H:i:00", strtotime($date2));
	
	$email = mysql_query("select * from student where student_id='$student'");
	if (!$email) {
    die('Invalid query: ' . mysql_error());
	}
	//echo "select * from student where student_id='$student'";
	$email_send = mysql_fetch_assoc($email);
	//echo $mailing =$email_send['student_email'];
	//echo $name =$email_send['student_name'];
	
	mysql_query("INSERT INTO `computer_availability`.`booking_student` (`booking_student_id`, `computer_name`, `student_id`, `start_booking`, `end_booking`, `booking_email`, `expired`) VALUES (NULL, '$pc', '$student', '$start', '$end', '$email_submit','0')");
	echo "INSERT INTO `computer_availability`.`booking_student` (`booking_student_id`, `computer_name`, `student_id`, `start_booking`, `end_booking`, `booking_email`, `expired`) VALUES (NULL, '$pc', '$student', '$start', '$end', '$email_submit','0')";
	//GET LAST ID
	$booking_id=mysql_insert_id();
	//echo $booking_id;
	
	//Config Email
	$sender_query = mysql_query("select * from email_config left join mail_set on email_config.mail_set_id=mail_set.mail_set_id");
	if (!$sender_query) {
    die('Invalid query: ' . mysql_error());
	}
	$email_sender = mysql_fetch_assoc($sender_query);
	$sender =$email_sender['sender'];
//	$name =$sender['student_name'];
	date_default_timezone_set('Etc/UTC');
	    $current=$_SERVER['SERVER_NAME'].Dirname($_SERVER['PHP_SELF']);
	$actual_link = "http://$current";	
	$url2 = "http://localhost/php/contents.php?booking=".$booking_id;
	$konten = file_get_contents($url2);  
	$url3 = 'http://localhost/php/contents_admin.php?booking='.$booking_id;
	$kontenadmin = file_get_contents($url3);  
	require '../mail/PHPMailerAutoload.php';	function sendemail($sender,$subject,$konten,$host,$port,$password,$email_submit,$name,$secure) {    	$mail = new PHPMailer;	//Tell PHPMailer to use SMTP	$mail->isSMTP();		//$mail->SMTPDebug = 2;//Ask for HTML-friendly debug output	//$mail->Debugoutput = 'html';	$mail->Host = $host;	$mail->Port = $port;	$mail->SMTPSecure = $secure;	$mail->SMTPAuth = true;		$mail->Username = $sender;		$mail->Password = $password;	$mail->setFrom($sender, '');		$mail->addAddress($email_submit, $name);		$mail->Subject = $subject;	$mail->msgHTML($konten);	$mail->AltBody = 'This is a plain-text message body';		if (!$mail->send()) {				} else {				}	}	//to user
	sendemail($sender,$email_sender['subject'],$konten,$email_sender['host'],$email_sender['port'],$email_sender['password'],$email_submit,$email_send['student_name'],$email_sender['secure']);		//to admin	sendemail($sender,'Booking Information',$kontenadmin,$email_sender['host'],$email_sender['port'],$email_sender['password'],$sender,$email_send['student_name'],$email_sender['secure']);
	session_start();
	 echo '<br>edu'.$_SESSION['login_user'];
	header("location:logout.php");

?>