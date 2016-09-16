<?php

   session_start();
   
   $user_check = $_SESSION['login_user'];
   
   $ses_sql = mysql_query("select student_username from student where student_username = '$user_check' ");
   
   $row = mysql_query($ses_sql);
   
   $login_session = $row['student_username'];
   
   if(!isset($_SESSION['login_user'])){
      header("location:index.php");
   }
?>