<?php
include 'sqlconfig.php';
$pc_name=$_GET['labname'];

$i = 0;
$result = mysql_query("SELECT booking_student.computer_name,booking_student.student_id,compstatus.lab_name,student.student_name,booking_student.start_booking,booking_student.end_booking
							FROM booking_student
							LEFT JOIN compstatus
							ON booking_student.computer_name=compstatus.computer_name
							LEFT JOIN student  ON student.student_id  = booking_student.student_id 
							where booking_student.end_booking > now() AND compstatus.lab_name = '$pc_name'  
							ORDER BY booking_student.computer_name;");


$i = 0;
$jason = array();						
while ($row = mysql_fetch_assoc($result)) {
    $jason[] = $row;
}
mysql_close($DB);
echo json_encode($jason);

?>