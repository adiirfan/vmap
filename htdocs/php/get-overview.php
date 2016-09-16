<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'sqlconfig.php';

$query_map = "SELECT * FROM labmap";
$query_pc =  "SELECT * FROM compstatus";
$countpc =  "SELECT * FROM compstatus";
$countpcbusy =  "SELECT * FROM compstatus where status = '1'";
$countpcavail =  "SELECT * FROM compstatus where status = '0'";
$countpcoff =  "SELECT * FROM compstatus where status = '3'";
$license = "SELECT * FROM license where id='1'";
$test = "select * from test";
$query_lab_group = "SELECT DISTINCT `lab_group` FROM `labmap`";

$result_map = mysql_query($query_map);
$result_test =  mysql_query($test);
$result_count =  mysql_query($countpc);
$busys = mysql_query($countpcbusy);
$avails =  mysql_query($countpcavail);
$offs =  mysql_query($countpcoff);
$result_pc = mysql_query($query_pc);
$result_lab_group = mysql_query($query_lab_group);
$licenses = mysql_query($license);
$hasil = mysql_fetch_assoc($licenses);
$resultpc= mysql_fetch_assoc($result_count);
$busy = mysql_num_rows($busys);
$off = mysql_num_rows($offs);
$avail = mysql_num_rows($avails);


$i = 0;
$k = 0;

if (mysql_num_rows($result_map) >=0){
    while ($row_map = mysql_fetch_assoc($result_map)) {
        $lab_name[$i] = $row_map['lab_name'];
        $lab_group[$i] = $row_map['lab_group'];
        
        $temp_query_total = "SELECT * FROM compstatus where lab_name = '".$lab_name[$i]."'";
        $temp_query_avail = "SELECT * FROM compstatus where status = '0' AND lab_name = '".$lab_name[$i]."'";
        $pc_total[$i] = mysql_num_rows(mysql_query($temp_query_total));
        $pc_avail[$i] = mysql_num_rows(mysql_query($temp_query_avail));
		
        
        // Future Extention, adding description of a Map
        $description[$i] = $row_map['description'];
        
        $i++;
    }
}
if (mysql_num_rows($result_count) >=0){
    while ($row_pc = mysql_fetch_assoc($result_count)) {
        $pc_name[$k] = $row_pc['computer_name'];
        $status[$k] = $row_pc['status'];
		if ($status[$k]== 3){
			$stat[$k]= "off";
		}elseif($status[$k]== 1){$stat[$k]= "busy";}
		elseif($status[$k]== 0){$stat[$k]= "available";}
		
        
      
		
      
        $k++;
    }
}
if (mysql_num_rows($result_map) >0) {
	$kosong= 0;
}else{
	$kosong=1;
}
$k = 0;
if (mysql_num_rows($result_test) >0){
    while ($row_test = mysql_fetch_assoc($result_test)) {
        $testid[$k] = $row_test['id'];
       $testdata[$k] = $row_test['data'];
        
        $k++;
    }
}


$j = 0;
while ($row_lab_group = mysql_fetch_assoc($result_lab_group)) {
    $lab_group_distinct[$j] = $row_lab_group['lab_group'];
   
    $j++;
    
}
$now = date("Y-m-d");
$date1 = date("Y-m-d");
$date2 = $hasil['expired'];
$diff = abs(strtotime($date2) - strtotime($date1));
if((time()-(60*60*24)) < strtotime($hasil['expired'])){
	$expiry = 1;
	
}
else{
	$expiry= 0;
	
}
if (mysql_num_rows($licenses)==0){
	$free=0;
	$max= 30;
	$tanggal = 'Free License';
	$tanggalasli= date("Y-m-d");
	$pembeda='i';
	
}else{
	$free=1;
	$max=$hasil['max'];
	$tanggal = $hasil['expired'];
	$tanggalasli = $hasil['expired'];
	$pembeda='';
}
mysql_close($DB);
//$data['namapc']= $pc_name;
//$data['setatus'] =  $stat;
$data['off']= $off;
$data['avail'] =  $avail;
$data['busy']= $busy;
$_SESSION['pesanan']   = $expiry;
$data['pembeda'] = $free;
$data['kosong'] = $kosong;
$data['tanggal'] = $tanggal;
$data['beda'] = $diff;
$data['count']= mysql_num_rows($result_count);
$data['status']= $hasil['status'];
$data['expiry']= $expiry;
$data['max']= $max;
$data['beda']= $pembeda;
//$data['testid'] = $testid;
//$data['testdata'] =  $testdata;
$data['tanggalasli']=$tanggalasli;
$data['lab_name'] = $lab_name;
$data['lab_group'] = $lab_group;
$data['lab_group_distinct'] = $lab_group_distinct;
$data['pc_total'] = $pc_total;
$data['pc_avail'] = $pc_avail;
$data['description'] = $description;
echo json_encode($data);

?>