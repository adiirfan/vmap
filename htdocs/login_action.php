<?php 
   $user = "root";
$password = "";
$database = "computer_availability";

#connect to the database
$DB = mysql_connect('127.0.0.1', $user, $password);
@mysql_select_db($database) or die("Unable to select database");
   session_start();
 
      // username and password sent from form 
	//var_dump($_SERVER['REQUEST_METHOD']);
	   if(count($_POST)){
		$myusername = $_POST["username"];
		$mypassword = md5($_POST['password']); 
		$password = $_POST['password']; 
		
	   }
	   
      
      $sql = "SELECT student_id,category_ad FROM student WHERE student_username = '$myusername' and student_password = '$mypassword'";
      $result = mysql_query($sql);
      $row = mysql_fetch_array($result); //var_dump($row);die('test');
      
      $count = mysql_num_rows($result); 
      //var_dump($sql);die('test');
      // If result matched $myusername and $mypassword, table row must be 1 row
      if($count == 1) { 
		//echo 1; 
         $_SESSION['login_user'] = $myusername;
		  $_SESSION['level'] = $row['category_ad'];
		  echo json_encode(array("status_login" => 1,"level" => $row['category_ad'],"user_id" => $row['student_id']));
      }else {
        // $error = "Your Login Name or Password is invalid";
		$url = 'http://localhost/ldap/examples/index.php?username='.$myusername .'&password='.str_replace("#","eduganteng",$password);

		$json = file_get_contents($url);  
		$data = json_decode($json);
		$hasil=$data->hasil;
		
		if($hasil == 1){
			
		$url2 = 'http://localhost/ldap4/examples/info_user.php?name='.$myusername;
		$json2 = file_get_contents($url2);  
		$data2 = json_decode($json2);
		
		$cn=$data2->cn;
		$name=$data2->name;
		$category=$data2->category_ad;
		
		$pc_query = mysql_query("INSERT INTO `student` (`student_id`, `student_name`, `student_username`, `student_password`, `category_ad`) VALUES (NULL, '$name', '$cn', '$mypassword', '$category');") or die(mysql_error());
		$_SESSION['user_id']=mysql_insert_id();
	//	echo $data->hasil;
		 $_SESSION['login_user'] = $myusername;
		 $_SESSION['level'] = $category;
		 
			echo json_encode(array("status_login" => 1,"level" =>$category,"user_id" =>mysql_insert_id()));
		 
		}else{
			
			 echo json_encode(array("status_login" => 0,"level" => 0,"user_id" => 0));
		}
		 
      } 
?>