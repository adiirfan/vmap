<?php 
include 'sqlconfig.php';
if(!isset($_FILES["file"]["tmp_name"]))
	$data = array('code'=>400,'status'=>'danger','msg'=> 'Invalid File : Please upload CSV file.');
else if($_FILES["file"]["size"] > 0)
{
	$filename=$_FILES["file"]["tmp_name"]; 
	$file = fopen($filename, "r");
	//$sql_data = "SELECT * FROM prod_list_1 ";
	
	while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
	{
		//print_r($emapData);
		//exit();
		$param1 	= (isset($emapData[0]))?$emapData[0]:null;
		$param2 	= (isset($emapData[1]))?$emapData[1]:null;
		$param8 	= md5($param3 = (isset($emapData[2]))?$emapData[2]:null);
		$param4 	= (isset($emapData[3]))?$emapData[3]:null;
		$param5 	= (isset($emapData[4]))?$emapData[4]:null;
		$param6 	= (isset($emapData[5]))?$emapData[5]:null;
		$param7 	= (isset($emapData[6]))?$emapData[6]:null;
		if(!empty($param1) && !empty($param2) && !empty($param3) && !empty($param4)){
		$sql = "INSERT into `student` (`student_name`, `student_username`, `student_password`, `student_email`, `student_mobile`, `student_address`, `category_ad`) values ('{$param1}','{$param2}','{$param8}','{$param4}','{$param5}','{$param6}','{$param7}')";
		mysql_query($sql);
		}
	}
	fclose($file);
	$data = array('code'=>200,'status'=>'success','msg'=> 'CSV file has been imported');
}
else
	$data = array('code'=>400,'status'=>'danger','msg'=> 'Invalid File : Please upload CSV file.');
	
mysql_close($DB);

header('Content-Type: application/json');
echo json_encode($data);
die;
?>