<?php
   include('php/sqlconfig.php');
$res = mysql_connect("localhost", "root", "");mysql_select_db("lab_scheduling");
    session_start();
   
   $user_check = $_SESSION['login_user'];
   
   $ses_sql = mysql_query("select student_username,student_id from computer_availability.student where student_username = '$user_check' ");
   
   $row2 =  mysql_fetch_assoc($ses_sql);
   
   $username = $row2['student_username'];
   $id_student = $row2['student_id'];
   
   if(!isset($_SESSION['login_user'])){
      header("location:index.php");
   }

 
	$pc_get=$_GET['pc'];
	$pc_get2=$_GET['pc'];
	$pc = mysql_query("select computer_name,lab_name,status from computer_availability.compstatus where computer_name = '$pc_get'");
	if (!$pc) {
    die('Invalid query: ' . mysql_error());
	}
	$row = mysql_fetch_array($pc);
	
		$status;
			if($row['status']==0){
			$status="free";
			}else if($row['status']==1){
			$status="busy";
			}else if($row['status']==2){
			$status="unavailable";
			}else {
			$status="off";
			}
	//$tanggal_1=date("Y-m-d H:00:00"); 
	$tanggal_1=date("Y-m-d H:00:00", strtotime("+1 hours")); 
	$tanggal_2=date("Y-m-d H:00:00", strtotime("+2 hours")); 
	$student = mysql_query("select * from computer_availability.booking_student left join computer_availability.student on booking_student.student_id=student.student_id where start_booking >= '$tanggal_1' and computer_name = '$pc_get' order by start_booking desc");
	if (!$student) {
    die('Invalid query: ' . mysql_error());
	}
	$book_student = mysql_fetch_array($student);

	
	function booked($time_now,$time_next,$date_1,$date_2,$get_pc) {
	$queryschedule = "SELECT * FROM `booking_student` WHERE `start_booking` >= '$time_now' and `end_booking` <= '$time_next' and computer_name='$get_pc'";
	$tes=0;
	$resultschedule = mysql_query($queryschedule);

	$booked=array();
	$i=0;
	while ($rowsc = mysql_fetch_array($resultschedule)){
		//&& $date_1 <= $rowsc['end_booking']
	//if(strtotime($rowsc['start_booking']) <= strtotime($date_1) || strtotime($rowsc['end_booking']) >= strtotime($date_2) ){
		//if($test['student_id'] <= 2 ){
	//	$tes=$rowsc['end_booking'];
	//	$booked="Booked";
		//break;
	//}
	
	if(strtotime($rowsc['start_booking']) <= strtotime($date_1)){
		//echo $rowsc['end_booking'];
		//if($test['student_id'] <= 2 ){
		
		if(strtotime($rowsc['end_booking']) >= strtotime($date_1)){
		$booked[$i]="Booked";
		}else {
			
			$booked[$i]="Available";
		}
		//break;
	}else{
		$booked[$i]="Available";
	}
	
	$i++;	
	}
	return $booked;
	}
	
	function booked_new($date,$time,$date_2,$time_2,$get_pc) {
	//$queryschedule = "SELECT * FROM `booking_student` WHERE `start_booking` >= '$time_now' and `end_booking` <= '$time_next' and computer_name='$get_pc'";
	$queryschedule = "SELECT * 
			FROM  computer_availability.booking_student
			WHERE  `start_booking` <= CONCAT( DATE_FORMAT(  '$date',  '%Y-%m-%d' ) ,  ' ',  '$time' ) 
			AND  `end_booking` >= CONCAT( DATE_FORMAT(  '$date_2',  '%Y-%m-%d' ) ,  ' ',  '$time_2' ) 
			 and computer_name='$get_pc' LIMIT 1";
	
	$resultschedule = mysql_query($queryschedule);
	if (mysql_num_rows($resultschedule)) {
    $booked = 1;
	} else {
    $booked = 0;
	}

	return $booked;
	}
	
	function booked_class($date,$date_2,$get_pc) {
		
	$pc = mysql_query("select lab_name from computer_availability.compstatus where computer_name = '$get_pc' "); // SELECT lab name
	$cek_lab =  mysql_fetch_assoc($pc);
	$lab_name=str_replace(" ","_",$cek_lab['lab_name']);
	$table_lab=strtolower($lab_name);
	$now_lab=date("Y-m-d H:i:s");
	
	$lab = mysql_query("select * from lab_scheduling.$table_lab where start_date <= '$date' AND `end_date` >= '$date_2'  order by start_date desc");
	if (!$lab) {
    die('Invalid query: ' . mysql_error());
	}
	if (mysql_num_rows($lab)) {
    $booked_lab= 1;
	} else {
    $booked_lab = 0;
	}

	return $booked_lab;
	}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="./images/clouddesk_favicon.png">

        <title>CloudDesk VMap</title>

        <!-- Bootstrap core CSS -->
        <link href="dist/css/bootstrap.min.css" rel="stylesheet">
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">-->

        <!--Font Awesome CSS-->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
		
	

        <!--Scheduler core-->
        <!--script src="codebase/dhtmlxscheduler.js" type="text/javascript"></script>
        <script src="codebase/ext/dhtmlxscheduler_collision.js"></script>
        <link rel="stylesheet" href="codebase/dhtmlxscheduler_flat.css" type="text/css">

        <!-- Custom styles for this template -->
        <link rel="stylesheet" type="text/css" href="stylesheets/vmap.css">

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="assets/js/ie-emulation-modes-warning.js"></script>
		
		 <!-- Datetime PICKER EDU! -->
		 <link href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
		  
		   
        <!-- 
         __  __            _ __           _        _  _  
  __ __ |  \/  |  __ _    | '_ \         | |__    | || | 
  \ V / | |\/| | / _` |   | .__/    _    | '_ \    \_, | 
  _\_/_ |_|__|_| \__,_|   |_|__   _(_)_  |_.__/   _|__/  
_|"""""|_|"""""|_|"""""|_|"""""|_|"""""|_|"""""|_| """"| 
"`-0-0-'"`-0-0-'"`-0-0-'"`-0-0-'"`-0-0-'"`-0-0-'"`-0-0-' 
        
      _    ___             ___      _                        _     ___                     _     
   _ | |  / __|           / __|    | |     ___    _  _    __| |   |   \    ___     ___    | |__  
  | || |  \__ \     _    | (__     | |    / _ \  | +| |  / _` |   | |) |  / -_)   (_-<    | / /  
  _\__/   |___/   _(_)_   \___|   _|_|_   \___/   \_,_|  \__,_|   |___/   \___|   /__/_   |_\_\  
_|"""""|_|"""""|_|"""""|_|"""""|_|"""""|_|"""""|_|"""""|_|"""""|_|"""""|_|"""""|_|"""""|_|"""""| 
"`-0-0-'"`-0-0-'"`-0-0-'"`-0-0-'"`-0-0-'"`-0-0-'"`-0-0-'"`-0-0-'"`-0-0-'"`-0-0-'"`-0-0-'"`-0-0-' 
        -->
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#" onclick="window.location.reload(true)"><img src="images/vmap_logo.png" height ="30" witdh="60"></a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">                       
                        <!--Select Map Dropdown-->
						<li><a href="../demo/summary/" target="_blank">Summary Page</a></li>	
						<li><a href="../demo" target="_blank">Home</a></li>							
                       <li><a id="kiosk" class="kiosk-off" href="#">Kiosk Mode</a></li>
                       
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
		<!--
        <div id="background-cloud" class="fluid-container">
            <div class="bot-cloud back-clouds"></div>
            <div class="front-clouds bot-cloud"></div>
            <!--<div class="vmap-logo"></div>-->
        </div>

        <div class="container-fluid" style="padding-top: 50px;">
            <div class = "row">
                <div id = "div-vmap" class= "col-lg-8 col-md-6 col-sm-6 col-xs-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> <?php echo $row['lab_name']; ?>
                        </div>
                        <div class="panel-body">
                            <div  class="row">
                                <div class = "col-lg-2 col-md-3 col-sm-3 col-xs-6">
                                  
                                </div>

                                <div class = "col-lg-8 col-md-3 col-sm-3 col-xs-12">
                                    <div class="legend-box">
                                       
                                 <div align="center"> <img src="images/legend/pc_<?php echo $status; ?>.png" alt="Busy" class="img-responsive " width="100px" height="100px"></div>
                                      
                                      <h2 align="center">  <?php echo $row['computer_name']; ?> </h2>
									  <!--  -->
									  <form method="post"  action="php/insert_booking.php" onsubmit="return validate();"  accept-charset="utf-8">
									   
									  <div class = "row">
									  <div class = "col-lg-3 col-md-3 col-sm-3 col-xs-3" align="right">
									  </div>
									   <div class = "col-lg-6 col-md-6 col-sm-6 col-xs-12" align="right">
									    <h5 align="center">Email</h5>
									  <h2 align="center">  

									  <input type="email" value="" name="email" id="email" placeholder="Your email" class="form-control" required /> 
									  </h2>
									  </div>
									   <div class = "col-lg-3 col-md-3 col-sm-3 col-xs-3" align="right">
									  </div>
									  </div>
									  <h5 align="center">Start Booking </h5>
									  <br>
									 
									  <input type="hidden" value="<?php echo $pc_get; ?>" name="pc" id="pc" class="form-control" /> 
									  <input type="hidden" value="<?php echo  $id_student; ?>" name="student" id="student" class="form-control" />
									  
									  <div class = "row">
									   <div class = "col-lg-6 col-md-6 col-sm-6 col-xs-6" align="right">
										 <div class="form-group">
                                                                    <div>
                                                                       <input type="text" id="datestart" data-format="MM-DD" data-template="DD MMM" /> 
                                                                    </div>
										</div>
										</div>
										 <div class = "col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<div class="form-group ">
																	 <div class="input-group date">
																		<input type="text" id="hourstart" data-format="HH:mm" data-template="HH : mm" name="datetime" value="<?php print date('H:i');?>">
                                                                        
                                                                        
																	  </div>
                                         </div>
										 </div>
										</div>
										<h5 align="center">To</h5>
										<div class = "row" padding-top = "20px">
									   <div class = "col-lg-6 col-md-6 col-sm-6 col-xs-6" align="right">
										 <div class="form-group">
                                                                    <div class="input-group date">
                                                                        <input type="text" id="dateend" data-format="MM-DD" data-template="DD MMM" /> 
                                                                    </div>
										</div>
										</div>
										 <div class = "col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<div class="form-group ">
																	 <div class="input-group date">
                                                                       <input type="text" id="hourend" data-format="HH:mm" data-template="HH : mm" name="datetime" value="<?php print date('H:i');?>">
																	  </div>
                                         </div>
										 </div>
										</div>
										<br>
										<!--<button class="btn btn-warning center-block longer" onclick="validate1()" type="submit">Booking</button>-->
										</form>
										
										<button class="btn btn-warning center-block longer" onclick="validate()" type="submit">Booking</button>
                                    </div>
                                </div> 
								<div class = "col-lg-2 col-md-3 col-sm-3 col-xs-6">
                                    
                                </div>

                                
                            </div>
                           
                        </div>
                    </div>
                </div>

        
                <div id = "div-statistic" class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="panel panel-success hidden">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-equalizer" aria-hidden="true"></span>
                            Availability Statistic
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class = "col-xs-4 col-lg-5">
                                    <h5 style="text-align: center"><b><u>Current Lab</u></b></h5>
                                </div>
                                <div class = "col-xs-4 col-lg-2 " >
 
                                </div>
                                <div class = "col-xs-4 col-lg-5">
                                    <h5 style="text-align: center"><b><u>All Labs</u></b></h5>
                                    
                                </div>

                            </div>
                            <div class="row">
                                <div class = "col-xs-4 col-lg-5">
                                   
                                    <canvas id="doughnut-current" width="150" height="120"></canvas>
                                </div>
                                <div class = "col-xs-4 col-lg-2 " >
                                    <div style="width : 75px ; margin : auto ;">
                                        <ul class="chart-legend clearfix">
                                            <li><i class="fa fa-circle text-red"></i> Busy</li>
                                            <li><i class="fa fa-circle text-green"></i> Free</li>
                                            <li><i class="fa fa-circle text-yellow"></i> Booked</li>
                                            <li><i class="fa fa-circle text-gray"></i> Off</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class = "col-xs-4 col-lg-5">
                                    
                                    <canvas id="doughnut-all" width="150" height="120"></canvas>
                                </div>

                            </div>
                            <ul id="list-progress" class="list-group">

                            </ul>
                        </div>

                    </div>
					<div class="panel panel-warning">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                            <?php echo $row['computer_name']; ?> Schedule <?php //echo $_SERVER['SERVER_NAME']; ?>
                        </div>
                        <h5><?php echo $today = date("j F , Y");   ?></h5>
                       
                        <div>
                            <table class="table table-condensed">
                                <tbody>
								<?php
								$x=10;
								$jam=8;
								for($i=0;$i<10;$i++){ ?>
								 <tr><td rowspan="2" class ="table-time"><?php echo $jam;  ?>:00</td><td align="center" class ="table-avail"><?php 
									//$time_1 = date("Y-m-d H:i:s", strtotime("+5 hours")); 
									
									$time_1 = date("Y-m-d $jam:00:00");
									$jam_2=$jam+1;
									$time_2 = date("Y-m-d $jam:30:00");
									$time_now = date('Y-m-d 00:00:00');
									$now=date("Y-m-d");
									$time_next = date('Y-m-d 00:00:00',strtotime('+1 days', strtotime( $now )));

									$exp = explode(" ", $time_1);
									$exp2 = explode(" ", $time_2);
									
									$book= booked_new($exp[0],$exp[1],$exp2[0],$exp2[1],$pc_get);
									
									$book_class= booked_class($time_1,$time_2,$pc_get);
									if ($book_class == 1){
										?>
											<p style="cursor:pointer" onclick="info('<?php echo $exp[0]; ?>','<?php echo $exp[1]; ?>','<?php echo $exp2[0]; ?>','<?php echo $exp2[1]; ?>','<?php echo $_GET['pc']; ?>')">Booked by class</p>
										<?php
									}else {
									if ($book != 0) {
										?>
										<p style="cursor:pointer" onclick="info('<?php echo $exp[0]; ?>','<?php echo $exp[1]; ?>','<?php echo $exp2[0]; ?>','<?php echo $exp2[1]; ?>','<?php echo $_GET['pc']; ?>')">Booked </p>
										<?php
									}else {
										?>
										<p onclick="info('<?php echo $exp[0]; ?>','<?php echo $exp[1]; ?>','<?php echo $exp2[0]; ?>','<?php echo $exp2[1]; ?>')">Available</p>
										<?php
									}
									}
									?> </td></tr>
									 <tr><td align="center" class ="table-avail">
									 <?php 
									 $jam_2=$jam+1;
									 $time_1 = date("Y-m-d $jam:30:00");
									 $time_2 = date("Y-m-d $jam_2:00:00");
									
									$exp = explode(" ", $time_1);
									$exp2 = explode(" ", $time_2);
									
									$book= booked_new($exp[0],$exp[1],$exp2[0],$exp2[1],$pc_get);
									
									$book_class= booked_class($time_1,$time_2,$pc_get);
									if ($book_class == 1){
										?>
											<p style="cursor:pointer" onclick="info('<?php echo $exp[0]; ?>','<?php echo $exp[1]; ?>','<?php echo $exp2[0]; ?>','<?php echo $exp2[1]; ?>','<?php echo $_GET['pc']; ?>')">Booked by class</p>
										<?php
									}else {
									if ($book != 0) {
										?>
										<p style="cursor:pointer" onclick="info('<?php echo $exp[0]; ?>','<?php echo $exp[1]; ?>','<?php echo $exp2[0]; ?>','<?php echo $exp2[1]; ?>','<?php echo $_GET['pc']; ?>')">Booked </p>
										<?php
									}else {
										?>
										<p onclick="info('<?php echo $exp[0]; ?>','<?php echo $exp[1]; ?>','<?php echo $exp2[0]; ?>','<?php echo $exp2[1]; ?>')">Available</p>
										<?php
									}
									}
									
									 ?>
									</td></tr>
								<?php $jam++; }  ?>
								<!--
                                    <tr ><td class ="table-time">8:00</td><td align="center"><?php 
									//$time_1 = date("Y-m-d H:i:s", strtotime("+5 hours")); 
									//$time_1 = date("Y-m-d H:i:s");
									//echo $time_1; ?> </td></tr>
									<tr ><td class ="table-time">16:00</td><td align="center">
									<?php //echo booked('2016-07-13 00:00:00','2016-07-14 00:00:00','2016-07-12 15:00:00','2016-07-12 16:00:00',$pc_get);  ?>
									</td></tr>-->
                                   
                                  
                                    

                                </tbody>

                            </table>
                        </div>
							
                    </div>
                </div>
            </div>
			
		
			
            <div id="hidden-bar-level1" style= "display :none">
                <li class="list-group-item">
                    <div  class="progress-group" data-toggle="collapse" href="" aria-expanded="false" aria-controls="">
                        <span class="progress-text lab-name-text"></span>
                        <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
                        <span class="progress-number"><b><span class="vacant-pc-text"></span></b>/<span class="total-pc-text"></span></span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-red" style="width: 0%"></div>
                        </div>
                    </div>
                </li>
            </div>

            <div id="hidden-bar-level2" style= "display :none">
                <li class="list-group-item list-level2">
                    <div  class="progress-group" data-toggle="collapse" href="" aria-expanded="false" aria-controls="">
                        <span class="progress-text lab-name-text"></span>                       
                        <span class="progress-number"><b><span class="vacant-pc-text"></span></b>/<span class="total-pc-text"></span></span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-red" style="width: 60%"></div>
                        </div>
                    </div>
                </li>
            </div>


        </div><!-- /.container -->
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
		  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery.min.js"><\/script>')</script>
        <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
        <script src="dist/js/bootstrap.min.js"></script>
        <script src="js/Chart.js"></script>
      
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
        <script src="js/user-ui.js"></script>
		
		
		<!--
		
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery.min.js"><\/script>')</script>
        
        <script src="dist/js/bootstrap.min.js"></script>
          <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
     
      
		<!-- SweetAlert -->
		<link href="assets/js/bootstrap-sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css">
		<script src="assets/js/bootstrap-sweetalert-master/dist/sweetalert.min.js" type="text/javascript"></script>
		<!-- Datetime PICKER EDU! -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
		<script src="js/combodate.js"></script>
		<script src="js/bootstrap-datetimepicker.js"></script>

	
<script>
function info(date,time,date_2,time_2,pc){
	//swal(time);
	//swal("php/validate_json.php?date="+date+'&time='+time+'&date2='+date_2+'&time2='+time_2+'&pc='+pc);
	jQuery.ajax({
            type: "POST",
            url: "php/validate_json.php?date="+date+'&time='+time+'&date2='+date_2+'&time2='+time_2+'&pc='+pc,
            dataType: 'json',
            success: function(res) {
			//swal(res.result.student_name+'<br>'+'Start :'+res.result.start_booking+'<br>'+'End :'+res.result.end_booking);
				if(typeof res.result.student_name === "undefined"){
			swal({   title: "Information Booking",   text: 'Booked by '+res.lab.text+'<br>'+'Start :'+res.lab.start_date+'<br>'+'End :'+res.lab.end_date,   html: true });		  
				}else{
					swal({   title: "Information Booking",   text: 'Booked by '+res.result.student_name+'<br>'+'Start :'+res.result.start_booking+'<br>'+'End :'+res.result.end_booking,   html: true });		
				}	  
				}
			});
	
}

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
function validate(){
	// $(this).unbind('myform').submit();
		//var text='#start_date'+nilai;
		var year = "2016-";
		var startdate =year+$('#datestart').val();
		var enddate =year+$('#dateend').val();
		var starthour =$('#hourstart').val();
		var endhour =$('#hourend').val();
		var pc =$('#pc').val(); 
		var student =$('#student').val();
		var email =$('#email').val();
	//	alert(start);

	 
	 
		var start=startdate+' '+starthour;
		var end=enddate+' '+endhour;
		//alert (start+end);
		$('[name="pc_submit"]').val(pc);
		$('[name="student_submit"]').val(student);
		$('[name="email_submit"]').val(email);
		$('[name="end_date"]').val(end);
		$('[name="start_date"]').val(start);
		
		 if (isEmail(email)) {
			//alart(email); 
		 }else if(email == ""){
			swal({
					title             : "Sorry!",
					text              : "Email required",
					type              : "error",
					confirmButtonClass: "btn-info"
                 });
            return;
		 }else{
			swal({
                    title             : "Sorry!",
                    text              : "Email not valid",
                    type              : "error",
                    confirmButtonClass: "btn-info"
                });
            return;
		 }
		
//sweetAlert ("php/validate_json.php?start="+startdate+"/"+starthour+"&end="+enddate+"/"+endhour+"&pc="+pc);
	
	
	//	sweetAlert("Oops...", "php/validate_json.php?start="+date_1+"/"+min_1+"&end="+date_2+"/"+min_2+"&pc="+pc, "error");
		
		jQuery.ajax({
            type: "POST",
            url: "php/validate_json.php?start="+startdate+"/"+starthour+"&end="+enddate+"/"+endhour+"&pc="+pc,
            dataType: 'json',
            success: function(res) {
					
			
						if (res.result != "Success"){
									swal({
										title             : "Sorry!",
										text              : res.result,
										type              : "error",
										confirmButtonClass: "btn-info"
									});
									return;
								}
						
						///sweetAlert("Oops...", res.result, "berhasil");
				// Sweet Alert
                        swal({
                            title: 'Confirmation Booking',
                            text:
                            '<label>Start Date</label>'+
							'<br>'+
                            '<label>'+startdate+' '+starthour+'</label>'+
                            '<br>'+
                            '<label>End Date</label>'+
                            '<br>'+
                            '<label>'+enddate+' '+endhour+'</label>'+
                            '<br>',
                          
                          
                            html               : true,
                            confirmButtonText  : 'Submit',
                            confirmButtonClass : "btn-info",
                            showCancelButton   : true,
                            closeOnConfirm     : false,
                            showLoaderOnConfirm: true
                        }, function() {
                           
						  
						 //  proceed ()
						 //alert($("#h_amount").val($(text).val()));
						
                            setTimeout(function() {
                                swal({
                                    title            : "Success!",
									text			 :	'<br><label>Thanks for booking</label>',
									html               : true,	
                                    type             : "success",
                                    timer            : 4000,
                                    showConfirmButton: false
                                });
                            }, 2000);
							
							 setTimeout(function() {
                                $('#formku').attr('action', 'php/insert_booking.php');
                            document.getElementById("formku").submit();
                            }, 5000);
                                
                         
							
                        });
					 
				}
			});
			
		
		
}

</script> 
<form  id="formku" method="post" accept-charset="utf-8">
 <input type="hidden" value="<?php echo $pc_get; ?>" name="pc_submit" class="form-control" /> 
<input type="hidden" value="<?php echo  $id_student; ?>" name="student_submit" class="form-control" />
 <input type="hidden" id="email_submit" name="email_submit" value="">
            <input type="hidden" id="start_date" name="start_date" value="">
			 <input type="hidden" id="end_date" name="end_date" value="">
</form>		


		
		

    </body>
</html>

				<script type="text/javascript">	
				$(function(){
					$('#datestart,#dateend').combodate({
						  value: new Date(),
						  minYear: 2016,
						  maxYear: moment().format('YYYY')  
					});    
				});
				$(function(){
					$('#hourstart,#hourend').combodate({
						firstItem: 'none', //show 'hour' and 'minute' string at first item of dropdown
						minuteStep: 30
					});  
				});

			
				$(document).ready(function(){
					$('#datestart,#dateend').datetimepicker(
					{
						format:'MM-DD'
					}); 
					$('#hourstart,#hourend').datetimepicker(
					{
						format:'HH:mm'
						
						//value: '12:45'
						//defaultTime: '10:45'; 
					});
				});
				$(function () {
					$('#hourstart,#hourend').datetimepicker({
						use24hours: true
					});
				});
				
				</script>
       
                                                       

    

    








