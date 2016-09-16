<?php
# add your database username and password
$user="root";
$password="";
$database="computer_availability";

#unless the computers name was empty
if($_POST['workstation'] != ""){
        $workstation = strtoupper($_POST['workstation']);
        echo "Computer name is not empty\n";
        echo "Computer name is $workstation \n";
}
else{ #build the computer's name from the host
 
$host_domain = strstr($_POST['hostip'], '.');
        $workstation = strtoupper(str_replace($host_domain, '', $_POST['hostip']));
}
 
#connect to the database
$DB = mysql_connect('127.0.0.1:3306', $user, $password);
mysql_select_db($database) or die("Unable to select database");
 
#get the computer's row based on it's name
$checkQuery = "SELECT computer_name FROM compstatus WHERE computer_name = '".$workstation."'";
$result = mysql_query($checkQuery);
 
#if we find a computer update it's status
if(mysql_numrows($result)>0){
        $query="UPDATE `compstatus` SET status = '".$_POST['status'].
                "', comp_ip = '".$_POST['hostip']."' WHERE computer_name = '".$workstation."'";
        mysql_query($query) or die(mysql_error());
        echo "Status and IP Updated \n";
}
# if the computer is not in table, add new row (
//elseif (mysql_numrows($result)== false){
//    $query="INSERT INTO compstatus SET computer_name = '".$workstation."',status ='".$_POST['status'].
//            "', comp_ip = '".$_POST['hostip']."'";
//       
//        mysql_query($query) or die(mysql_error());
//        echo "New Row Inserted\n";
//}

 
mysql_close($DB);
