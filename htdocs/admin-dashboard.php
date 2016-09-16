<?php
session_start();
include 'php/sqlconfig.php';
$license = "SELECT * FROM license where id='1'";
$licenses = mysql_query($license);
$hasil = mysql_fetch_assoc($licenses);
$countpc =  "SELECT * FROM compstatus";
$result_count =  mysql_query($countpc);
$now = date("Y-m-d");
$date1 = date("Y-m-d");
$date2 = $hasil['expired'];
$terpakai = mysql_num_rows($result_count);
$diff = abs(strtotime($date2) - strtotime($date1));
if((time()-(60*60*24)) < strtotime($hasil['expired'])){
	$expirys = $hasil['max'];
	$tanggal = $hasil['expired'];
	$sisa = $expirys - $terpakai;
	
}
else{
	$expirys= 30;
	$tanggal = "Not Active";
	$sisa = $expirys - $terpakai;
}
$color = $sisa;

if (!isset($_SESSION['adminID'])) {
    header("location: login/index.php");
}
if ( isset( $_SESSION['pesan2'] ) )
{
 $var1= $_SESSION['pesan3'];
 $var2= $_SESSION['pesan2'];
  $var3= $_SESSION['pesan4'];
   $var4= $_SESSION['pesan5'];

 
  $pesan = "Thanks For your purchase,here is the detail:<br>Your App Code :$var2<br>Your Key : $var1<br>Life Time :$var3 Month<br>Added PC: :$var4<br>";
  unset( $_SESSION['pesan2'] );

  // show error #5
}elseif ( isset( $_SESSION['pesan'] ) )
{
  $pesan = $_SESSION['pesan'];
  unset( $_SESSION['pesan'] );

  // show error #5
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

        <title>Dashboard - VMap</title>

        <!-- Bootstrap core CSS -->
        <link href="dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

        <!--JqueryUI CSS-->
        <link rel="stylesheet" href="stylesheets/jquery-ui.css"/>
        <link rel="stylesheet" href="stylesheets/jquery-ui.structure.css"/>
        <link rel="stylesheet" href="stylesheets/jquery-ui.theme.css"/>

		
		
        <!--Scheduler core-->
        <script src="codebase/dhtmlxscheduler.js" type="text/javascript"></script>
        <script src="codebase/ext/dhtmlxscheduler_collision.js"></script>
        <link rel="stylesheet" href="codebase/dhtmlxscheduler_flat.css" type="text/css">

        <link rel="stylesheet" type="text/css" href="stylesheets/draw-map.css">
        <link rel="stylesheet" type="text/css" href="stylesheets/mapicons.css"> 

        <!-- Custom styles for this template -->
        <link href="stylesheets/admin-dashboard.css" rel="stylesheet">

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="assets/js/ie-emulation-modes-warning.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->


    </head>

    <body>

        <nav class="navbar navbar-inverse navbar-fixed-top" style="background-color:#23baed !important; height:70px !important"">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a  href="#" style="color:white !important;"><img src="images/vmap_logo.png" width="100px" height="60px" style="padding-top: 5px; padding-bottom: 10px;" data-pin-nopin="true"></a>
                </div>
                <div id="navbar" class="navbar-collapse collapse" style="margin-top:0px !important">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a id = "admin-id" style="color:white !important;padding-top: 20px;"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                <?php echo $_SESSION['adminID'] ?></a>
                        </li>
					

                        <li class ="dropdown"><a class="dropdown-toggle" style="color:white !important;padding-top: 20px;" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>
                            <ul class="dropdown-menu">
								<li><a href="php/admin-logout.php" role="button" id ="button-logout" >Logout</a></li>
                                <li><a href="#overview" role="button" id ="button-logout">Overview</a></li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
		

        <div class="container-fluid" style="margin-top:50px">
            <div class="row">
                <div class="col-sm-3 col-md-2 col-lg-2 sidebar">
                    <ul class="nav nav-sidebar">
                        <li id = "overview" class="menu-invoke"><a href="#overview">Overview <span class="sr-only">(current)</span></a></li>
                        <li id = "lab-design"><a href="#" data-toggle="collapse" data-target="#lab-design-menu" >Lab Editor<i class="arrowd glyphicon glyphicon-chevron-down"></i></a>
                            <ul class="nav nav-stacked collapse in" id="lab-design-menu">
                                <li class="menu-invoke" id="add-lab"> <a href="#add-lab"><i class="sub-nav glyphicon glyphicon-plus"></i> Add / Edit Lab </a></li>
                                <!--<li class="menu-invoke" id="edit-lab"><a href="#"><i class="glyphicon glyphicon-erase"></i> Edit Lab</a></li>-->
                                <li class="menu-invoke" id="manage-lab"><a href="#manage-lab"><i class="sub-nav glyphicon glyphicon-stats"></i> Manage Lab</a></li>
                            </ul>
                        </li>
                        <li id = "scheduling" class="menu-invoke"><a href="#scheduling">Scheduling</a></li>
                        <li id = "admin-management" class="menu-invoke"><a href="#admin-management">Admin Management</a></li>
						<li id = "student-management" class="menu-invoke"><a href="#student-management">Student Management</a></li>
						<li id = "teacher-management" class="menu-invoke"><a href="#teacher-management">Teacher Management</a></li>
						 <li id = "indexa" class="menu-invoke"><a href="#indexa">Tutorial & FAQ</a></li>
						 <li class="menu-invoke" style="display:<?php
						include 'php/sqlconfig.php';
						$license = "SELECT * FROM license where id='1'";
						$licenses = mysql_query($license);
						$hasil = mysql_fetch_assoc($licenses);
						if($hasil['vdash'] == 1){
						echo "block";
	
						}else {
							
							echo "none";
						}
						
						?>"><a href="/vdash">Reporting</a></li>
						<li style="display:none"> <p >Content here. <a class="alert" id="modal" href="#">Alert!</a></p></li>
                    </ul>

                    <!--                    <li class="nav-header" id="usermanagement"> <a href="#" data-toggle="collapse" data-target="#userMenu"><i class="glyphicon glyphicon-briefcase"></i> User Management <i class="arrowd glyphicon glyphicon-chevron-right"></i></a>
                                            <ul class="nav nav-stacked collapse " id="userMenu">
                    
                                                <li class="active myajax" id="adduser"> <a href="#"><i class="glyphicon glyphicon-plus"></i> Add User</a></li>
                                                <li class="myajax" id="edituser"><a href="#"><i class="glyphicon glyphicon-erase"></i> Edit User</a></li>
                                                <li class="myajax" id="deleteuser"><a href="#"><i class="glyphicon glyphicon-trash"></i> Delete User</a></li>
                    
                                            </ul>
                                        </li>-->
                    <ul class="nav nav-sidebar">
                        <li id = "statistic" class="menu-invoke" style="display:<?php
						include 'php/sqlconfig.php';
						$license = "SELECT * FROM license where id='1'";
						$licenses = mysql_query($license);
						$hasil = mysql_fetch_assoc($licenses);
						if((time()-(60*60*24)) < strtotime($hasil['expired'])){
						echo "block";
	
						}else {
							
							echo "block";
						}
						
						?>">
						
						
						<a href="#statistic">License Key</a></li>
							
						
                        <!--            <li><a href="">Nav item again</a></li>
                                    <li><a href="">One more nav</a></li>
                                    <li><a href="">Another nav item</a></li>
                                    <li><a href="">More navigation</a></li>-->
                    </ul>
					 <ul class="nav nav-sidebar">
					 <li  id = "student-booking" class="menu-invoke" style="display:<?php
						include 'php/sqlconfig.php';
						$license = "SELECT * FROM license where id='1'";
						$licenses = mysql_query($license);
						$hasil = mysql_fetch_assoc($licenses);
						if($hasil['booking'] == 1){
						echo "block";
	
						}else {
							
							echo "none";
						}
						
						?>">
					<a href="#student-booking">Student Booking </a>
					</li>
					<li  id = "maxbooking" class="menu-invoke" style="display:<?php
						include 'php/sqlconfig.php';
						$license = "SELECT * FROM license where id='1'";
						$licenses = mysql_query($license);
						$hasil = mysql_fetch_assoc($licenses);
						if($hasil['booking'] == 1){
						echo "block";
	
						}else {
							
							echo "none";
						}
						
						?>">
					<a href="#maxbooking">Student Maximum Booking</a>
					</li>
					<li  id = "labbooking" class="menu-invoke" style="display:<?php
						include 'php/sqlconfig.php';
						$license = "SELECT * FROM license where id='1'";
						$licenses = mysql_query($license);
						$hasil = mysql_fetch_assoc($licenses);
						if($hasil['booking'] == 1){
						echo "block";
	
						}else {
							
							echo "none";
						}
						
						?>">
					<a href="#labbooking">Lab Maximum Booking</a>
					</li>
					<li  id = "emailconfig" class="menu-invoke" style="display:<?php
						include 'php/sqlconfig.php';
						$license = "SELECT * FROM license where id='1'";
						$licenses = mysql_query($license);
						$hasil = mysql_fetch_assoc($licenses);
						if($hasil['booking'] == 1){
						echo "block";
	
						}else {
							
							echo "none";
						}
						
						?>">
					<a href="#emailconfig">Email Config</a>
					</li>
					<li  id = "configad" class="menu-invoke" style="display:<?php
						include 'php/sqlconfig.php';
						$license = "SELECT * FROM license where id='1'";
						$licenses = mysql_query($license);
						$hasil = mysql_fetch_assoc($licenses);
						if($hasil['booking'] == 1){
						echo "block";
	
						}else {
							
							echo "none";
						}
						
						?>">
					<a href="#configad">Active Directory Config</a>
					</li>
					</ul>
					
                    <!--          <ul class="nav nav-sidebar">
                                <li><a href="">Nav item again</a></li>
                                <li><a href="">One more nav</a></li>
                                <li><a href="">Another nav item</a></li>
                              </ul>-->
                </div>
					
                <div class="col-sm-8 col-sm-offset-3 col-md-9 col-md-offset-2 col-lg-9 col-lg-offset-2 main">
                    <div id ="dashboard-content" class="panel">

                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>

        <script>
            var privilege = '<?php echo $_SESSION['privilege'] ?>';
            console.log(privilege);

            if (privilege == 'ITStaff') {
                $("#admin-management").remove();

            } else if (privilege == 'Normal') {
                $("#admin-management").remove();
                $("#lab-design").remove();
            }
        </script>
		<script type="text/javascript">var color = "<?php echo $color ?>";var line = "<?php echo $tanggal; ?>";var rowling = "<?php echo $sisa; ?>";</script>
		
        <!--JQuery UI Javascript-->
        <!--==================================================-->
        <!--<script src="external/jquery/jquery.js"></script>-->
        <script src="js/jquery-ui/jquery-ui.js"></script>
		

        <script type="text/javascript">
            // Change JQueryUI plugin names to fix name collision with Bootstrap.
            $.widget.bridge('uitooltip', $.ui.tooltip);
            $.widget.bridge('uibutton', $.ui.button);

        </script>
		<!--script src="js/bootbox.min.js"></script>
		 <script>
        $(document).on("click", ".alert", function(e) {
            bootbox.alert("<?php //echo $pesan;?>", function() {
                console.log("Alert Callback");
            });
        });
			jQuery(function(){
		    jQuery('#modal').click();
		});
		</script>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script!-->
        <script src="dist/js/bootstrap.min.js"></script>
		
        <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
        <script src="assets/js/vendor/holder.min.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="assets/js/ie10-viewport-bug-workaround.js"></script>

        <script src="js/admin-dashboard.js"></script>

    </body>
</html>
