<?php

require_once("../codebase/connector/scheduler_connector.php");

$res = mysql_connect("localhost", "root", "");
mysql_select_db("lab_scheduling");

$lab_id = $_GET["lab_id"];
echo $lab_id;
$labsql = strtolower(str_replace(' ','_',$lab_id));
echo $labsql;

$conn = new SchedulerConnector($res);
 
$conn->render_table("`$labsql`","id","start_date,end_date,text");

//echo $labsql;