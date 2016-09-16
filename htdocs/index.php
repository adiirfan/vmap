<?php
   include("/php/sqlconfig.php");
   session_start();
   $sesi=0;
   $id_student=0;
	//Update pc status=4 old
	$result = mysql_query("SELECT booking_student.* , compstatus.*
							FROM booking_student
							LEFT JOIN compstatus
							ON booking_student.computer_name=compstatus.computer_name
							where booking_student.end_booking > now()
							ORDER BY booking_student.computer_name;");
	$query = mysql_query("SELECT computer_name 
			FROM  computer_availability.compstatus where status=4");		
	if (!$query) {
    die('Invalid query: ' . mysql_error());
	}
	$now=date("Y-m-d H:i:s");
	$currentDate = strtotime($now);
	$futureDate = $currentDate+(60*15);
	$endTime = date("Y-m-d H:i:s", $futureDate);
	while ($checking = mysql_fetch_array($query)) {
		$pc=$checking['computer_name'];
		$query_detail=mysql_query("SELECT * 
			FROM  computer_availability.booking_student 
			WHERE  `start_booking` >= '$endTime' and computer_name='$pc'");
			if (mysql_num_rows($query_detail)) {
			
			} else {
				
			$queryupdate4 = "UPDATE `compstatus` SET `status`= 0 WHERE computer_name = '".$checking['computer_name']."' ";
			mysql_query($queryupdate4) or die(mysql_error());
			
			}
		
	}
	
	// Select Lab
	$query_lab = mysql_query("select lab_name from compstatus group by lab_name");		
	if (!$query_lab) {
    die('Invalid query: ' . mysql_error());
	}
	
	
	
	if ( isset($_SESSION['login_user'])){
	    $sesi=$_SESSION['login_user'];
		$level=$_SESSION['level'];
		$ses_sql = mysql_query("select student_username,student_id from computer_availability.student where student_username = '$sesi' ");
   
		$row2 =  mysql_fetch_assoc($ses_sql);
   
	   $username = $row2['student_username'];
	   $id_student = $row2['student_id'];
	}else {
	   $sesi=0;
	   $level=0;
	}
 ?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="CloudDesk vmap is a lab management and online booking tool available as SaaS that maps and reports real-time resource usage">
		<meta name="keywords" content="vmap, lab management, computer lab, pc lab, media lab, it lab, student computing, tracking software, access management, lab booking, resource monitoring, resource planning">
		<meta name="author" content="">
		<title>Lab management and online booking tool for real-time resource utilization</title>
        <link rel="icon" href="./images/clouddesk_favicon.png">

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
		<p id="test"></p>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#" onclick="window.location.reload(true)"><img src="images/vmap_logo.png" height ="60" witdh="60"></a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">                       
                        <!--Select Map Dropdown-->
						<li><a href="/summary/" target="_blank" style="padding-top: 25px;">Summary Page</a></li>						
                        <li id="dropdown-select-map" role="presentation" class="dropdown" >
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"  style="padding-top: 25px;">Select Map <span class="caret"></span></a>
                            <ul class="dropdown-menu" id="map-dropdown">
                            </ul>                            
                        </li>
                        <li><a id="kiosk" class="kiosk-off" href="#"  style="padding-top: 25px;">Kiosk Mode</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
         <!--div id="background-cloud" class="fluid-container">
            <div class="bot-cloud back-clouds"></div>
            <div class="front-clouds bot-cloud"></div>
            <<div class="vmap-logo"></div>>
        </div!-->
        <div class="container-fluid" style="padding-top: 50px;">
            <div class = "row">
                <div id = "div-vmap" class= "col-lg-8 col-md-6 col-sm-8 col-xs-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> <span id="lab-name"></span></h4>
                        </div>
					</div>
					<div class="panel panel-info">
						<div class="panel-heading">	
                       
                            <div class="row">
                                <div class = "col-lg-3 col-md-3 col-sm-3 col-xs-6">
									<div align="center">
                                    <div class = "map-legend">
                                            <img src="images/legend/pc_free.png" alt="Free" class="img-responsive" width="35px">
                                        </div >
									<br>
									
									  <span class="legend-text"><b><font color="#000">Free ( <span id="free" ></span> )</font></b></span>
									</div>
                                </div>

                                <div class = "col-lg-3 col-md-3 col-sm-3 col-xs-6">
								   <div align="center">
                                   
                                        <div class = "map-legend">
                                            <img src="images/legend/pc_busy.png" alt="Busy" class=" img-responsive " width="35px">
                                        </div>
                                      
                                    
									<br>
									  <span class="legend-text"><strong><font color="#000"> Busy ( <span id="busy" ></span> )</font></strong> </span>
								   </div>
                                </div>

                                <div class = "col-lg-3 col-md-3 col-sm-3 col-xs-6">
									 <div align="center">
									 
                                        <div class = "map-legend">
                                            <img src="images/legend/pc_unavailable.png" alt="Unavailable" class=" img-responsive " width="35px">
                                        </div>
                                     
                                    <br>
									 
									 <span class="legend-text"><b><font color="#000"> Booked ( <span id="booked" ></span> )</font></b></span>
									 </div>
                                </div>

                                <div class = "col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                     <div align="center">
                                        <div class = "map-legend">
                                            <img src="images/legend/pc_off.png" alt="Off" class=" img-responsive " width="35px">
                                        </div>
                                       
                                   
									<br>
									
									 <span class="legend-text"><b><font color="#000"> Off  ( <span id="off" ></span> )</font></b></span>
									 </div>
                                    <!--<span id="legend-off" class = "map-legend"></span>-->
                                </div>
                            </div>
						</div>
						<div class="panel-body">
                            <!--PC's available: <span id = "num_pc"></span>  Mac's available: <span id = "num_mac"></span>-->
                            <div id ="display-map"></div>
							<!--
							<div class="clonediv7 dragged3 resize-image PC-icon PC ui-draggable ui-draggable-handle loaded-icon PC-status-free tooltipstered" id="PCedu" title="This is my span's tooltip message!">PC4</div>
                            <!--                            <blockquote class="blockquote-reverse">
                                                            <p>Last updated at </p>
                                                            <footer>Map will auto-refresh every 5 minute</footer>
                                                        </blockquote>-->
						</div>
                    </div>
					 <div class="panel panel-warning">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                            Lab Booking List
							
							
                        </div>
                       
                        <div>
                            
							
							<table border="1" class="table table-hover table-mc-light-blue"  id="testing">
							
							</table>
								
                        </div>
							
                    </div>
                </div>
              

             
                <div id = "div-statistic" class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
						  <h4>
                            <span class="glyphicon glyphicon-equalizer" aria-hidden="true"></span>
                            Availability Statistic
						  </h4>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class = "col-xs-4 col-lg-5">
                                    <h5 style="text-align: center"><b>Current Lab</b></h5>
                                </div>
                                <div class = "col-xs-4 col-lg-2 " >
 
                                </div>
                                <div class = "col-xs-4 col-lg-5">
                                    <h5 style="text-align: center"><b>All Labs</b></h5>
                                    
                                </div>

                            </div>
                            <div class="row">
                                <div class = "col-xs-4 col-lg-5">
                                   
                                    <canvas id="doughnut-current" width="150" height="120"></canvas>
                                </div>
                                <div class = "col-xs-4 col-lg-2 " >
                                    <div style="width : 80px ; margin : auto ;">
                                        <ul class="chart-legend clearfix">
                                            <li><i class="fa fa-circle text-red"></i><font size="3"> Busy</font></li>
                                            <li><i class="fa fa-circle text-green"></i><font size="3"> Free</font></li>
                                            <li><i class="fa fa-circle text-yellow"></i><font size="3"> Booked</font></li>
                                            <li><i class="fa fa-circle text-gray"></i><font size="3"> Off</font></li>
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
					<div class="panel panel-success">
                        <div class="panel-heading" style="background-color:#f5f2a3">
						  <h4>
                            <span class="glyphicon glyphicon-equalizer" aria-hidden="true"></span>
                            Booking Lab
						  </h4>
                        </div>
                        <div class="panel-body">
						<h2 align="center">
                         <button type="button" id="lab_book" class="btn btn-primary active" style="width: 300px !important; height: 48px !important; background-color:#23baed;">Teacher's Lab Booking</button>
						</h2>
                        </div>

                    </div>
					 <div class="panel panel-warning">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                            Lab Daily Schedule<div class="hidden" id="user_id"></div> <div class="hidden" id="level_tes"></div><div class="hidden" id="sesion"></div>
							
							
							
                        </div>
                        <h5 id="current-date"></h5>
                        <h5 id="current-time"></h5>
                        <div>
                            <table class="table table-condensed">
                                <tbody>
                                    <tr data-schedule = "08:01"><td class ="table-time" rowspan="2">8:00</td><td class ="table-avail"></td></tr>
                                    <tr data-schedule = "08:31"><td class ="table-avail"></td></tr>
                                    <tr data-schedule = "09:01"><td class ="table-time" rowspan="2">9:00</td><td class ="table-avail"></td></tr>
                                    <tr data-schedule = "09:31"><td class ="table-avail"></td></tr>
                                    <tr data-schedule = "10:01"><td class ="table-time" rowspan="2">10:00</td><td class ="table-avail"></td></tr>
                                    <tr data-schedule = "10:31"><td class ="table-avail"></td></tr>
                                    <tr data-schedule = "11:01"><td class ="table-time" rowspan="2">11:00</td><td class ="table-avail"></td></tr>
                                    <tr data-schedule = "11:31"><td class ="table-avail"></td></tr>
                                    <tr data-schedule = "12:01"><td class ="table-time" rowspan="2">12:00</td><td class ="table-avail"></td></tr>
                                    <tr data-schedule = "12:31"><td class ="table-avail"></td></tr>
                                    <tr data-schedule = "13:01"><td class ="table-time" rowspan="2">13:00</td><td class ="table-avail"></td></tr>
                                    <tr data-schedule = "13:31"><td class ="table-avail"></td></tr>
                                    <tr data-schedule = "14:01"><td class ="table-time" rowspan="2">14:00</td><td class ="table-avail"></td></tr>
                                    <tr data-schedule = "14:31"><td class ="table-avail"></td></tr>
                                    <tr data-schedule = "15:01"><td class ="table-time" rowspan="2">15:00</td><td class ="table-avail"></td></tr>
                                    <tr data-schedule = "15:31"><td class ="table-avail"></td></tr>
                                    <tr data-schedule = "16:01"><td class ="table-time" rowspan="2">16:00</td><td class ="table-avail"></td></tr>
                                    <tr data-schedule = "16:31"><td class ="table-avail"></td></tr>
                                    <tr data-schedule = "17:01"><td class ="table-time" rowspan="2">17:00</td><td class ="table-avail"></td></tr>
                                    <tr data-schedule = "17:31"><td class ="table-avail"></td></tr>
                                    <tr data-schedule = "18:01"><td class ="table-time" rowspan="2">18:00</td><td class ="table-avail"></td></tr>
                                    <tr data-schedule = "18:31"><td class ="table-avail"></td></tr>

                                </tbody>

                            </table>
                        </div>
							
                    </div>
                </div>
            </div>
			
			<div id="login" class="modal fade" role="dialog" align = "center">
			
				<div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content" style="max-width:400px;">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						 </div>
						<div class="modal-body">
						<div style = "width:300px; border: solid 1px #333333; " align = "left">
						<div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
							
						<div style = "margin:30px">
						   
						   <form role="form" method="post" action="" class="booking">
							  <label>UserName  :</label>
							  <input type = "hidden" name ="lab" id="lab" class = "box"/><br /><br />
								<input type = "text" name ="username" id="username" class = "box"/><br /><br />
							  <label>Password  :</label>
								<input type ="password" name ="password" id="password" class = "box" /><br/><br />
								<input type ="hidden" name ="pc" id="pc" class = "box" /><br/><br />
								<input type="button"  value ="Submit " id="submit"/><br />
						   </form>
						   
						   <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php //echo $error; ?></div>
								
						</div>
							
						</div>
						</div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  </div>
					</div>

				</div>
				 
					
			</div>
			<div id="cannot-book" class="modal fade" role="dialog" align = "center">
			
				<div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content" style="max-width:400px;">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						 </div>
						<div class="modal-body">	
						<h2 align="center">Student can't book Lab</h2>
						</div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  </div>
					</div>

				</div>

			</div>
				 
					
			</div>
			<div id="lab_booking" class="modal fade" role="dialog" align = "center">
			
				<div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content" style="max-width:500px;">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body" style="overflow-y: auto;max-height: 550px;">
						<div style = "width:400px; border: solid 1px #333333; " align = "left">
						<div style = "background-color:#333333; color:#FFFFFF; padding:0px;"><b>Lab Booking</b></div>
							
						<div style = "margin:30px">
						   
						   <form role="form" method="post" action="php/insert_booking_lab.php" class="booking">
						   <div align="center" id="pesan"></div>
							<div class = "row">
								<div class = "col-lg-1 col-md-1 col-sm-1 col-xs-1" align="right">
								</div>
								<div class = "col-lg-10 col-md-10 col-sm-10 col-xs-12" align="right">
										<h5 align="center">Lab Name</h5>
									  
										<select name="lab_name" id="lab_name" class="form-control">
										<option value="0">-- Select Lab --</option>
										<?php
										while ($select_lab = mysql_fetch_array($query_lab)) {
										?>
										<option value="<?php echo $select_lab['lab_name'];  ?>"><?php echo $select_lab['lab_name']  ?></option>
										<?php
										}
										?>
										</select>
										<font color="red">  <p align="center" id="alert_lab"></p></font>
										
									    <h5 align="center">Email</h5>
										<h2 align="center">  

										<input type="email" value="" name="email" id="email" placeholder="Your email" class="form-control" required /> 
										</h2>
										<font color="red"> <p align="center" id="alert_email"></p></font>
								</div>
								<div class = "col-lg-1 col-md-1 col-sm-1 col-xs-1" align="right">
								</div>
							</div>
									  <h5 align="center">Start Booking </h5>
									  <br>
									  <input type="hidden" value="<?php echo  $id_student; ?>" name="teacher" id="teacher" class="form-control" />
									  
							<div class = "row">
								<div class = "col-lg-6 col-md-6 col-sm-6 col-xs-6" align="right">
									<div class="form-group">
                                        <div>
                                            <input type="text" id="datestart" data-format="MM-DD" data-template="DD MMM" /> 
                                        </div>
									</div>
								</div>
								<div class = "col-lg-5 col-md-5 col-sm-5 col-xs-6">
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
								<div class = "col-lg-5 col-md-5 col-sm-5 col-xs-6">
										<div class="form-group ">
											<div class="input-group date">
                                                <input type="text" id="hourend" data-format="HH:mm" data-template="HH : mm" name="datetime" value="<?php print date('H:i');?>">
											</div>
                                        </div>
								</div>
							</div>
										<h5 align="center">Agenda</h5>
										<h2 align="center">  

										<input type="text" value="" name="text" id="text" placeholder="Agenda" class="form-control" required /> 
										</h2>
										<font color="red">  <p align="center" id="alert_agenda"></p></font>
										<h3 align="center">	<input type="button" onclick="validate()"  value ="Submit " id="submit"/></h3>
						   </form>
						   	
						</div>
							
						</div>
						</div>
						 <div class="modal-footer">
									<button type="button" class="btn btn-warning"  data-dismiss="modal">Close</button>
						</div>
					</div>

				</div>
				 
					
			</div>
			
			<div id="info" class="modal fade" role="dialog" align = "center">
			
				<div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content" style="max-width:400px;">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						 </div>
						<div class="modal-body">
						<div style = "border: solid 1px #333333; " align = "left">
						<div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>PC Info</b></div>
							
						<div>
						  
						   <form  method="post" action="" >
										<p align="center"><strong>PC Name</strong></p> 
										<p align="center" id="pc_name"></p>
							
							
										<p align="center"><strong>IP</strong></p> 
										<p align="center" id="comp_ip">199.157.189.1</p>
									
							
										<p align="center"><strong>Lab Name</strong></p>
										<p align="center" id="lab_name"></p>
									
							
										<p align="center"><strong>Lab Group</strong></p> 
										<p align="center" id="lab_group">Computer Science</p>
								
							
										<p align="center"><strong>Status</strong></p>
										<p align="center" id="status"></p>
									
							
										<div id="text_event">
										</div>
										<div id="start_date">
										</div>
										<div id="end_date">
										</div>

										<h4 align="center">
										<div id="student_name">
										</div>
										<div id="start_booking">
										</div>
										<div id="end_booking">
										</div>
										</h4>
														
							
							 <input type ="hidden" name ="pc2" id="pc2" class = "box" /><br/>
							 <?php
						include 'php/sqlconfig.php';
						$license = "SELECT * FROM license where id='1'";
						$licenses = mysql_query($license);
						$hasil = mysql_fetch_assoc($licenses);
						if($hasil['booking'] == 1){
						?>
					<h2 align="center">	<input type="button" class="btn btn-warning"  value="Booking" id="booking"/></h2><br />
						
						<?php
						}
						
						?>
							 
							
						   </form>
						   
						   <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php //echo $error; ?></div>
								
						</div>
							
						</div>
						</div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
        <script src="js/plugin/jquery.fullscreen.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
        <script src="js/user-ui.js"></script>
		<script src="js/ajax-post.js"></script>
		<script>
	
		function isEmail(email) {
		  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		  return regex.test(email);
		}
		function validate(){
		//	
		// $(this).unbind('myform').submit();
			//var text='#start_date'+nilai;
			var year = "2016-";
			var startdate =year+$('#datestart').val();
			var enddate =year+$('#dateend').val();
			var starthour =$('#hourstart').val();
			var endhour =$('#hourend').val();
			var teacher =$('#teacher').val();
			var email =$('#email').val();
			var text =$('#text').val();
			var lab_name =$('#lab_name').val();
		//	alert(start);
			//alert (lab_name.replace(/ /g,"-"));
			var start=startdate+' '+starthour;
			var end=enddate+' '+endhour;
			//alert (start+end);
		//	alert(start+' '+end+' '+teacher+' '+email+' '+lab_name+' '+text);
			$('[name="student_submit"]').val($("#user_id").text());
			$('[name="email_submit"]').val(email);
			$('[name="end_date"]').val(end);
			$('[name="start_date"]').val(start);
			$('[name="text_submit"]').val(text);
			$('[name="lab_name_submit"]').val(lab_name);
			//alert(lab_name);
			 if (isEmail(email)) {
				//alart(email); 
			 }else if(email == ""){
				$("#pesan").html('<div class="alert alert-danger"><button data-dismiss="alert" class="close">&times;</button><i class="fa fa-times-circle"></i><strong>Sorry! </strong> email required </div>');
				return;
			 }else{
				$("#pesan").html('<div class="alert alert-danger"><button data-dismiss="alert" class="close">&times;</button><i class="fa fa-times-circle"></i><strong>Sorry! </strong>email not valid </div>');
				return;
			 }
			 if(text == ""){
				$("#pesan").html('<div class="alert alert-danger"><button data-dismiss="alert" class="close">&times;</button><i class="fa fa-times-circle"></i><strong>Sorry! </strong>agenda required </div>');
				return;
			 }
			  if(lab_name == 0){
				$("#pesan").html('<div class="alert alert-danger"><button data-dismiss="alert" class="close">&times;</button><i class="fa fa-times-circle"></i><strong>Sorry! </strong>must select lab'+lab_name+' </div>');
				return;
			 }
			 
			 
			jQuery.ajax({
            type: "POST",
            url: "php/validate_lab.php?start="+startdate+"/"+starthour+"&end="+enddate+"/"+endhour+"&lab="+lab_name.replace(/ /g,"-"),
            dataType: 'json',
            success: function(res) {
					
			
						if (res.result != "Success"){
						$("#pesan").html('<div class="alert alert-danger"><button data-dismiss="alert" class="close">&times;</button><i class="fa fa-times-circle"></i><strong>Sorry! </strong>'+res.result+' </div>');
									return;
						}
						
						///sweetAlert("Oops...", res.result, "berhasil");
				// Sweet Alert
                        
                           
						  
						 //  proceed ()
						 //alert($("#h_amount").val($(text).val()));
						
                            $('#formku').attr('action', 'php/insert_booking_lab.php');
								document.getElementById("formku").submit();	
							
							// setTimeout(function() {
                            //    $('#formku').attr('action', 'php/insert_booking.php');
                           // document.getElementById("formku").submit();
                          //  }, 100);
                                
                         
							
                       
					 
				}
			});
			 

                              
								
		}

</script> 
<form  id="formku" method="post" accept-charset="utf-8">

<input type="hidden" value="<?php echo  $id_student; ?>" name="student_submit" id="user" class="form-control" />
<input type="hidden" id="email_submit" name="email_submit" value="">
<input type="hidden" id="start_date" name="start_date" value="">
<input type="hidden" id="end_date" name="end_date" value="">
<input type="hidden" id="lab_name_submit" name="lab_name_submit" value="">
<input type="hidden" id="text_submit" name="text_submit" value="">
</form>	
		<script>
		$("#lab_book").click(function () {
			$('#lab_name').val($("#lab-name").text());	
			$('#lab').val(1);	
			if($("#sesion").text() == null){
			var sesi = "<?php echo $sesi ?>"; 	
			}else {
			var sesi = $("#sesion").text();	
			}
			if($("#level_tes").text() == null){
			var level = "<?php echo $level ?>"; 	
			}else {
			var level = $("#level_tes").text();	
			}
			//alert(level+' '+sesi );
				if (sesi == 0 ){

					$('#info').modal('hide');  
					$('<?php
						include 'php/sqlconfig.php';
						$license = "SELECT * FROM license where id='1'";
						$licenses = mysql_query($license);
						$hasil = mysql_fetch_assoc($licenses);
						if($hasil['booking'] == 1){
						echo "#login";
	
						}else {
							
							echo "#logins";
						}
						
						?>').modal('show');
					
				}else {
						if(level == 1){
								//$('#cannot-book').modal('show'); 
								$('#login').modal('show'); 
								}else {
								$('#login').modal('hide'); 
								$('#lab_booking').modal('show'); 
								}
				
				}
				
				
		});
		
		
		$("#booking").click(function () {
				$('#lab').val(0);	
			var sesi= "<?php echo $sesi ?>";
				
				if (sesi == 0 ){
					$('#info').modal('hide');  
					$('<?php
						include 'php/sqlconfig.php';
						$license = "SELECT * FROM license where id='1'";
						$licenses = mysql_query($license);
						$hasil = mysql_fetch_assoc($licenses);
						if($hasil['booking'] == 1){
						echo "#login";
	
						}else {
							
							echo "#logins";
						}
						
						?>').modal('show');
				}else {
			
			
				var pc= $("#pc").val();
                location.href = "/booking.php?pc="+pc;	
				
				}
				
				
			});
		
		
		</script>
        <script src="js/pc-update.js"></script>
		<script>
		$(document).ready(function(){
			
			 $("span .form-control").addClass("hidden");
			$("#display-map").on("click",".PC-icon",function(){
				
				var id = $(this).attr("id");
				$("#pc").val($(this).attr("id"));
				$("#pc2").val($(this).attr("id"));
				

					jQuery.ajax({
					url : "php/pc.php/?id=" + id,
					type: "GET",
					dataType: "JSON",
					success: function(data)
					{
						
						var status;
						if(data.pc.status==0){
						status="Free";
						}else if(data.pc.status==1){
						status="Busy";
						}else if(data.pc.status==2){
						status="Booked";
						}else {
						status="Off";
						}
						
						var ip;
						
						if(data.pc.comp_ip == 'null'){
						ip=data.pc.comp_ip;
						}else {
						ip="Null";
						}
						if(!data){
						alert(data.student.student_id || '');
						}
					var cek =data.student.student_id;
					document.getElementById('pc_name').innerHTML = data.pc.computer_name;
					document.getElementById('status').innerHTML = status;
					document.getElementById('comp_ip').innerHTML = ip;
					document.getElementById('lab_name').innerHTML = data.pc.lab_name;
					document.getElementById('lab_group').innerHTML = data.pc.lab_group;
					
					if(typeof data.lab.text === "undefined"){
					document.getElementById('text_event').innerHTML = "";
					document.getElementById('end_date').innerHTML = "";
					document.getElementById('start_date').innerHTML = "";
					
					}else{
						
					document.getElementById('text_event').innerHTML = "<label style=\"padding-right:67px;\">Event</label> :"+data.lab.text;
					document.getElementById('start_date').innerHTML = "<label style=\"padding-right:48px;\">Start Date</label> :"+data.lab.start_date;
					document.getElementById('end_date').innerHTML = "<label style=\"padding-right:45px;\">End Date</label> :"+data.lab.end_date;
					}
					
					
					if(typeof data.student.student_name === "undefined"){
					document.getElementById('student_name').innerHTML = "";
					document.getElementById('start_booking').innerHTML = "";
					document.getElementById('end_booking').innerHTML = "";
					}else{
											
					console.log(data.student.student_name);
					document.getElementById('student_name').innerHTML =  "<label style=\"padding-right:43px;\">Student Name </label> :"+data.student.student_name;
					document.getElementById('start_booking').innerHTML =  "<label style=\"padding-right:43px;\">Start Booking</label> :"+data.student.start_booking;
					document.getElementById('end_booking').innerHTML =  "<label style=\"padding-right:43px;\">End Booking</label> :"+data.student.end_booking;
					}
					
					},
					error: function (jqXHR, textStatus, errorThrown)
						{
							alert('Error get data from ajax');
						}
					});
					$('#info').modal('show');  
					//$("#frame").click(".PC-icon",function(){ alert('test');});
					//$("#frame").tooltip(".PC-icon",function(){
						
					//});
					
					 // location.href = 'booking.php?pc='+id;
				
				
			});
		});
		</script>
    </body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
		<script src="js/combodate.js"></script>
		<script src="js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript">	
					
			$(document).ready(function() {
 
					var table = $('#table');

					// Table bordered
					$('#table-bordered').change(function() {
						var value = $( this ).val();
						table.removeClass('table-bordered').addClass(value);
					});

					// Table striped
					$('#table-striped').change(function() {
						var value = $( this ).val();
						table.removeClass('table-striped').addClass(value);
					});
				  
					// Table hover
					$('#table-hover').change(function() {
						var value = $( this ).val();
						table.removeClass('table-hover').addClass(value);
					});

					// Table color
					$('#table-color').change(function() {
						var value = $(this).val();
						table.removeClass(/^table-mc-/).addClass(value);
					});
				});

				// jQuery’s hasClass and removeClass on steroids
				// by Nikita Vasilyev
				// https://github.com/NV/jquery-regexp-classes
				(function(removeClass) {

					jQuery.fn.removeClass = function( value ) {
						if ( value && typeof value.test === "function" ) {
							for ( var i = 0, l = this.length; i < l; i++ ) {
								var elem = this[i];
								if ( elem.nodeType === 1 && elem.className ) {
									var classNames = elem.className.split( /\s+/ );

									for ( var n = classNames.length; n--; ) {
										if ( value.test(classNames[n]) ) {
											classNames.splice(n, 1);
										}
									}
									elem.className = jQuery.trim( classNames.join(" ") );
								}
							}
						} else {
							removeClass.call(this, value);
						}
						return this;
					}

				})(jQuery.fn.removeClass);
	</script>
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
 <link rel="stylesheet" type="text/css" href="assets/dist/css/tooltipster.bundle.min.css" />
	<link rel="stylesheet" type="text/css" href="assets/dist/css/plugins/tooltipster/sideTip/themes" />


    <script type="text/javascript" src="assets/dist/js/tooltipster.bundle.min.js"></script>