<!DOCTYPE html>
<?php session_start(); 
date_default_timezone_set('Asia/Jakarta');
include('libs/global.php');?>
<?php include('libs/con_open.php');?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="refresh" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="../images/clouddesk_favicon.png">
	<title>CloudDesk VMap</title>
	<link href="../dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" type="text/css" rel="stylesheet" />
	<link href="css/temp.css" type="text/css" rel="stylesheet" />
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link href="../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../stylesheets/vmap.css">
	<script src="../assets/js/ie-emulation-modes-warning.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>	
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	
</head>
<style>
	body {background-color:#fff !important; padding-top:0px !important;}
	tbody tr:nth-child(odd) {
	   background-color: #f2f2f2;
	}
</style>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header"">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#" onclick="window.location.reload(true)" style="margin-bottom:20px;"><img src="../images/vmap_logo.png" height ="60" witdh="70"></a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">                       
					<!--Select Map Dropdown-->
					<li><a href="../summary/" style="padding-top: 25px;">Summary Page</a></li>						
					<li><a href="../" target="_blank" style="padding-top: 25px;">Demo</a></li>
					<li><a id="kiosk" class="kiosk-off" href="#" style="padding-top: 25px;">Kiosk Mode</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</nav>
	
	
	<div data-role="page" class="type-home" style="margin: 110px 5px !important;">
		<div data-role="content">
			
			<div class="content-secondary">
				<div id="cls-homeheader">
					<h1>Labs Statistic</h1>
				</div>

				<div id="dvStats" dstyle="width:100%"><h3>Public Stats</h3>
					
					<div style="position:relative; height:30px; background-color: #45add5; border: 0px solid; border-radius: 5px;">
						<div style="position:absolute; width:100%; top:0; left:0; text-align:left;">
							<div style="padding:5px 8px; line-height:20px; font-weight:bold; font-size:15px; color:#fff;">Current Statistics</div>
						</div>
					</div>	
					
					<table border-radius='5' border='1' rules='all' width='100%'>
						<tr>
							<td style='font-weight:bold;width:200px;padding-left:5px;'>Group Name</td>
							<td style='font-weight:bold;text-align:center'>% Group Usage</td>
							<td style='font-weight:bold;text-align:center;width:90px'>Busy</td>
							<td style='font-weight:bold;text-align:center;width:90px'>Free</td>
							<td style='font-weight:bold;text-align:center;width:90px'>Offline</td>
							<td style='font-weight:bold;text-align:center;width:90px'>Total Stations</td>
							<td style='font-weight:bold;text-align:center;width:150px'>Schedule</td>
						</tr>
						<?php 
						$labstat = $DB->getData("compstatus a group by lab_name", "( select count(status) from compstatus where lab_name = a.lab_name and status = 0 ) as free, ( select count(status) from compstatus where lab_name = a.lab_name and status = 1 ) as busy, ( select count(status) from compstatus where lab_name = a.lab_name and status = 3 ) as off, ( select count(status) from compstatus where lab_name = a.lab_name and ( status = 3 or status = 1 or status = 0 ) ) as station, lab_name"); 
						if(!is_null($labstat->lab_name)){
						?>
						<div id="popup<?php echo $namalabnoloop = str_replace(' ', '', $labstat->lab_name)?>" class="modal fade" role="dialog" align = "center">
							<div class="modal-dialog">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-body" style="padding: 0px !important">
										<div id="statchart<?php echo $namenoloop = str_replace(' ', '', $labstat->lab_name)?>" style="max-width:310px;width: 100%; height: 400px; max-width: 600px; margin: 0 auto;background:white;z-index:99;position:fixed;left:0px;right:0px;">
									</div>
								</div>
							</div>
						</div>
						<tr style="font-size:14px">
							<td style="padding-left:5px;"><a data-toggle="modal" data-target="#popup<?php echo $namalabnoloop = str_replace(' ', '', $labstat->lab_name)?>"><?php echo $labstat->lab_name?></a></td>
							<td align='center' width='170px'>
							<div style="padding-left:2px;width:100%;text-align:left;position:relative;"><img src="img/greenDot.png" style="top:-4px;position:absolute;width:<?php echo $labstat->busy / $labstat->station * 100 ?>%; height:8px"><h5 style="position:absolute;top:-18px;left:47%;"><?php echo round($labList["busy"] / $labList["station"] * 100) ?>%</h5></div>
							</td>
							<td align='center'><?php echo $labstat->busy?></td>
							<td align='center'><?php echo $labstat->free?></td>
							<td align='center'><?php echo $labstat->off?></td>
							<td align='center'><?php echo $labstat->station?></td>
							<td align='center'><a data-toggle="modal" data-target="#schedule">Show Schedule</a></td>
						</tr>
						<script type="text/javascript">
							$(function () {
								$('#statchart<?php echo $namenoloop = str_replace(' ', '', $labstat->lab_name)?>').highcharts({
									chart: {
										plotBackgroundColor: null,
										plotBorderWidth: null,
										plotShadow: false,
										type: 'pie'
									},
									title: {
										text: '<?php echo $namenoloop = str_replace(' ', '', $labstat->lab_name)?>'
									},
									tooltip: {
										pointFormat: '<b>{point.y}</b>'
									},
									plotOptions: {
										pie: {
											allowPointSelect: true,
											cursor: 'pointer',
											dataLabels: {
												enabled: false
											},
											showInLegend: true
										}
									},
									series: [{
										name: '',
										colorByPoint: true,
										data: [{
											name: 'Busy',
											y: <?php echo $labstat->busy?>
										}, {
											name: 'Free',
											y: <?php echo $labstat->free?>,
											sliced: true,
											selected: true
										}, {
											name: 'Offline',
											y: <?php echo $labstat->off?>
										}]
									}]
								});
							});
						</script>
						<?php
						} else{
						foreach($labstat as $labList){
						?>
						<div id="popup<?php echo $namalab = str_replace(' ', '', $labList["lab_name"])?>" class="modal fade" role="dialog" align = "center">
							<div class="modal-dialog">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-body" style="padding: 0px !important">
										<div id="statchart<?php echo $name = str_replace(' ', '', $labList["lab_name"])?>" style="max-width:310px;width: 100%; height: 400px; max-width: 600px; margin: 0 auto;background:white;z-index:99;position:fixed;left:0px;right:0px;">
									</div>
								</div>
							</div>
						</div>
						<tr style="font-size:14px">
							<td style="padding:10px;"><a data-toggle="modal" data-target="#popup<?php echo $namalab = str_replace(' ', '', $labList["lab_name"])?>"><?php echo $labList["lab_name"]?></a></td>
							<td align='center' width='170px'>
								<div style="width:100%;height:23px;overflow:hidden;position:relative;">
									<div data-width="<?php echo $labList["busy"] / $labList["station"] * 100 ?>%" class="groupUsage" style="float:left; height:25px;background:#2aa9e0;"></div>
									<div style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;font-size:14px;"><?php echo round($labList["busy"] / $labList["station"] * 100) ?>%</div>
								</div>
							</td>
							<td style="padding:10px;" align='center'><?php echo $labList["busy"]?></td>
							<td  style="padding:10px;"align='center'><?php echo $labList["free"]?></td>
							<td style="padding:10px;" align='center'><?php echo $labList["off"]?></td>
							<td style="padding:10px;" align='center'><?php echo $labList["station"]?></td>
							<td style="padding:10px;" align='center'><a data-toggle="modal" data-target="#schedule">Show Schedule</a></td>
						</tr>
						<script type="text/javascript">
							$(function () {
								$('#statchart<?php echo $name = str_replace(' ', '', $labList["lab_name"])?>').highcharts({
									chart: {
										plotBackgroundColor: null,
										plotBorderWidth: null,
										plotShadow: false,
										type: 'pie'
									},
									title: {
										text: '<?php echo $labList["lab_name"]?>'
									},
									tooltip: {
										pointFormat: '<b>{point.y}</b>'
									},
									plotOptions: {
										pie: {
											allowPointSelect: true,
											cursor: 'pointer',
											dataLabels: {
												enabled: false
											},
											showInLegend: true
										}
									},
									series: [{
										name: '',
										colorByPoint: true,
										data: [{
											name: 'Busy',
											y: <?php echo $labList["busy"]?>
										}, {
											name: 'Free',
											y: <?php echo $labList["free"]?>,
											sliced: true,
											selected: true
										}, {
											name: 'Offline',
											y: <?php echo $labList["off"]?>
										}]
									}]
								});
							});
						</script>
						<?php
						}
						}
						?>
					</table>
					
					<div class="clear"></div>
					
					<div style="position:relative; height:30px; background-color: #45add5; border: 0px solid; border-radius: 5px;">
						<div style="position:absolute; width:100%; top:0; left:0; text-align:left;">
							<div style="padding:5px 8px; line-height:20px; font-weight:bold; font-size:15px; color:#fff;">Published Lab Maps</div>
						</div>
					</div>
					
					<div class="RadGrid RadGrid_Default" style="margin:20px;">
					<table class="rgMasterTable" cellspacing="0" border="0" style="width:100%; table-layout:auto; empty-cells:show;">
						<colgroup>
							<col width="120" />
							<col width="120" />
							<col width="300" />
						</colgroup>
						<thead>
							<tr>
								<th class="rgHeader" style="text-align:left;" scope="col">View</th>
								<th class="rgHeader" style="text-align:left;" scope="col">Map Name</th>
								<th class="rgHeader" style="text-align:left;" scope="col">Description</th>
							</tr>
						</thead>
						<tbody>
							<?php if(!is_null($labstat->lab_name)){
							?>
							<tr style="font-size:14px">
								<td>
									<a class="linkButton" href="../<?php echo $labstat->lab_name?>">Map</a>
								</td>
								<td><?php echo $labstat->lab_name?></td>
								<td>5803,School of Engineering</td>
							</tr>
							<?php
							} else{
							foreach($labstat as $labList){
							?>
							<tr style="font-size:14px">
								<td>
									<a class="linkButton" href="../?map=<?php echo $labList["lab_name"]?>" target="_blank">Map</a>
								</td>
								<td><?php echo $labList["lab_name"]?></td>
								<td>5803,School of Engineering</td>
							</tr>
							<?php }} ?>
						</tbody>
					</table>
					</div>
				</div>
			</div>	
		</div>
	</div>
	
	<div id="schedule" class="modal fade" role="dialog" align = "center">
			
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				 </div>
				<div class="modal-body" style="padding: 0px !important">
					<div id = "div-schedule" class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="panel panel-warning">
							<div class="panel-heading">
								<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
								Daily Schedule
							</div>
							<h5 id="current-date"></h5>
							<h5 id="current-time"></h5>
							<div>
								<table class="table table-condensed">
									<tbody>
										<tr data-schedule = "08:00"><td class ="table-time" rowspan="2">8:00</td><td class ="table-avail"></td></tr>
										<tr data-schedule = "08:30"><td class ="table-avail"></td></tr>
										<tr data-schedule = "09:00"><td class ="table-time" rowspan="2">9:00</td><td class ="table-avail"></td></tr>
										<tr data-schedule = "09:30"><td class ="table-avail"></td></tr>
										<tr data-schedule = "10:00"><td class ="table-time" rowspan="2">10:00</td><td class ="table-avail"></td></tr>
										<tr data-schedule = "10:30"><td class ="table-avail"></td></tr>
										<tr data-schedule = "11:00"><td class ="table-time" rowspan="2">11:00</td><td class ="table-avail"></td></tr>
										<tr data-schedule = "11:30"><td class ="table-avail"></td></tr>
										<tr data-schedule = "12:00"><td class ="table-time" rowspan="2">12:00</td><td class ="table-avail"></td></tr>
										<tr data-schedule = "12:30"><td class ="table-avail"></td></tr>
										<tr data-schedule = "13:00"><td class ="table-time" rowspan="2">13:00</td><td class ="table-avail"></td></tr>
										<tr data-schedule = "13:30"><td class ="table-avail"></td></tr>
										<tr data-schedule = "14:00"><td class ="table-time" rowspan="2">14:00</td><td class ="table-avail"></td></tr>
										<tr data-schedule = "14:30"><td class ="table-avail"></td></tr>
										<tr data-schedule = "15:00"><td class ="table-time" rowspan="2">15:00</td><td class ="table-avail"></td></tr>
										<tr data-schedule = "15:30"><td class ="table-avail"></td></tr>
										<tr data-schedule = "16:00"><td class ="table-time" rowspan="2">16:00</td><td class ="table-avail"></td></tr>
										<tr data-schedule = "16:30"><td class ="table-avail"></td></tr>
										<tr data-schedule = "17:00"><td class ="table-time" rowspan="2">17:00</td><td class ="table-avail"></td></tr>
										<tr data-schedule = "17:30"><td class ="table-avail"></td></tr>
										<tr data-schedule = "18:00"><td class ="table-time" rowspan="2">18:00</td><td class ="table-avail"></td></tr>
										<tr data-schedule = "18:30"><td class ="table-avail"></td></tr>

									</tbody>

								</table>
							</div>

						</div>
					</div>
				</div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  </div>
			</div>

		</div>
		 
			
	</div>
	
	<nav class="navbar navbar-inverse navbar-fixed-top" style="display:none;">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#" onclick="window.location.reload(true)"><img src="images/vmap_logo_grey.png" height ="30" witdh="60"></a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">                       
					<!--Select Map Dropdown-->
					<li><a href="#">Summary Page</a></li>						
					<li id="dropdown-select-map" role="presentation" class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Select Map <span class="caret"></span></a>
						<ul class="dropdown-menu" id="map-dropdown">
						</ul>                            
					</li>
					<li><a id="kiosk" class="kiosk-off" href="#">Kiosk Mode</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</nav>
	<div id="background-cloud" class="fluid-container" style="display:none;">
		<div class="bot-cloud back-clouds"></div>
		<div class="front-clouds bot-cloud"></div>
		<!--<div class="vmap-logo"></div>-->
	</div>

	<div class="container-fluid">
		<div class = "row">
			<div id = "div-vmap" class= "col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:none;">
				<div class="panel panel-info">
					<div class="panel-heading">
						<span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> <span id="lab-name"></span>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class = "col-lg-3 col-md-3 col-sm-3 col-xs-6">
								<div class="legend-box">
									<div class = "map-legend">
										<img src="images/legend/pc_free.png" alt="Free" class="img-circle img-responsive ">
									</div >
									<span class="legend-text">Free ( <span id="free" ></span> )</span>
								</div>
							</div>

							<div class = "col-lg-3 col-md-3 col-sm-3 col-xs-6">
								<div class="legend-box">
									<div class = "map-legend">
										<img src="images/legend/pc_busy.png" alt="Busy" class="img-circle img-responsive ">
									</div>
									<span class="legend-text"> Busy ( <span id="busy" ></span> ) </span>
								</div>
							</div>

							<div class = "col-lg-3 col-md-3 col-sm-3 col-xs-6">
								<div class="legend-box">
									<div class = "map-legend">
										<img src="images/legend/pc_unavailable.png" alt="Unavailable" class="img-circle img-responsive ">
									</div>
									<span class="legend-text"> Booked ( <span id="booked" ></span> )</span>
								</div>
							</div>

							<div class = "col-lg-3 col-md-3 col-sm-3 col-xs-6">
								<div class="legend-box">
									<div class = "map-legend">
										<img src="images/legend/pc_off.png" alt="Off" class="img-circle img-responsive ">
									</div>
									<span class="legend-text"> Off  ( <span id="off" ></span> )</span>
								</div>
								<!--<span id="legend-off" class = "map-legend"></span>-->
							</div>
						</div>
						<!--PC's available: <span id = "num_pc"></span>  Mac's available: <span id = "num_mac"></span>-->
						<div id ="display-map"></div>
						<!--                            <blockquote class="blockquote-reverse">
														<p>Last updated at </p>
														<footer>Map will auto-refresh every 5 minute</footer>
													</blockquote>-->
					</div>
				</div>
			</div>

			<div id = "div-statistic" class= "col-lg-4 col-md-4 col-sm-4 col-xs-12" style="display:none;">
				<div class="panel panel-success">
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
	<script>
	$(document).ready(function(){
		$(".groupUsage").each(function(){
			var width = $(this).attr("data-width");
			$(this).animate({width : width},800);
		});
	});
	</script>
	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.min.js"></script>')</script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<script src="../js/Chart.js"></script>
	<script src="../js/plugin/jquery.fullscreen.js"></script>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
	<script src="../js/user-ui.js"></script>

	<script src="../js/pc-update.js"></script>
</body>
</html>