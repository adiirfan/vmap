<style>
div.ground{
	width:100px;
	height:100px;
	margin-left:200px;
	z-index: 1;
	position:absolute;
}

div.hi{
	width:100px;
	height:100px;
	margin-left:400px;
	z-index: 100;
	position:absolute;
	margin-top:40px;
}
div.people{
	width:100px;
	height:100px;
	margin-left:400px;
	z-index: 100;
	position:absolute;
	margin-top:140px;
}
</style>
<!--

<div class="ground">
<img src="http://161.202.15.195/demo/images/mail/notif_1.png">
</div>
-->


<?php
											include('sqlconfig.php');
											$id=$_GET['booking'];
											$booked = mysql_query("select * from booking_student left join compstatus on compstatus.computer_name=booking_student.computer_name left join student on student.student_id=booking_student.student_id where booking_student_id='$id'");
											if (!$booked) {
											die('Invalid query: ' . mysql_error());
											}
											$book = mysql_fetch_assoc($booked);
										
											$email = mysql_query("select * from email_config");
											if (!$email) {
											die('Invalid query: ' . mysql_error());
											}			
											$template = mysql_fetch_assoc($email);
	
											$prolog=str_replace("!name_student!",$book['student_name'],$template['prolog']);
												?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><!--[if IE]><html xmlns="http://www.w3.org/1999/xhtml" class="ie"><![endif]--><!--[if !IE]><!--><html style="margin: 0;padding: 0;" xmlns="http://www.w3.org/1999/xhtml"><!--<![endif]--><head>
											<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
											<!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
											<meta name="viewport" content="width=device-width" />
											<style type="text/css">
										@media only screen and (min-width: 620px) {
										  * [lang=x-wrapper] h1 {
											font-size: 26px !important;
											line-height: 34px !important;
										  }
										  * [lang=x-wrapper] h2 {
											font-size: 20px !important;
											line-height: 28px !important;
										  }
										  * div [lang=x-size-8] {
											font-size: 8px !important;
											line-height: 14px !important;
										  }
										  * div [lang=x-size-9] {
											font-size: 9px !important;
											line-height: 16px !important;
										  }
										  * div [lang=x-size-10] {
											font-size: 10px !important;
											line-height: 18px !important;
										  }
										  * div [lang=x-size-11] {
											font-size: 11px !important;
											line-height: 19px !important;
										  }
										  * div [lang=x-size-12] {
											font-size: 12px !important;
											line-height: 19px !important;
										  }
										  * div [lang=x-size-13] {
											font-size: 13px !important;
											line-height: 21px !important;
										  }
										  * div [lang=x-size-14] {
											font-size: 14px !important;
											line-height: 21px !important;
										  }
										  * div [lang=x-size-15] {
											font-size: 15px !important;
											line-height: 23px !important;
										  }
										  * div [lang=x-size-16] {
											font-size: 16px !important;
											line-height: 24px !important;
										  }
										  * div [lang=x-size-17] {
											font-size: 17px !important;
											line-height: 26px !important;
										  }
										  * div [lang=x-size-18] {
											font-size: 18px !important;
											line-height: 26px !important;
										  }
										  * div [lang=x-size-18] {
											font-size: 18px !important;
											line-height: 26px !important;
										  }
										  * div [lang=x-size-20] {
											font-size: 20px !important;
											line-height: 28px !important;
										  }
										  * div [lang=x-size-22] {
											font-size: 22px !important;
											line-height: 31px !important;
										  }
										  * div [lang=x-size-24] {
											font-size: 24px !important;
											line-height: 32px !important;
										  }
										  * div [lang=x-size-26] {
											font-size: 26px !important;
											line-height: 34px !important;
										  }
										  * div [lang=x-size-28] {
											font-size: 28px !important;
											line-height: 36px !important;
										  }
										  * div [lang=x-size-30] {
											font-size: 30px !important;
											line-height: 38px !important;
										  }
										  * div [lang=x-size-32] {
											font-size: 32px !important;
											line-height: 40px !important;
										  }
										  * div [lang=x-size-34] {
											font-size: 34px !important;
											line-height: 43px !important;
										  }
										  * div [lang=x-size-36] {
											font-size: 36px !important;
											line-height: 43px !important;
										  }
										  * div [lang=x-size-40] {
											font-size: 40px !important;
											line-height: 47px !important;
										  }
										  * div [lang=x-size-44] {
											font-size: 44px !important;
											line-height: 50px !important;
										  }
										  * div [lang=x-size-48] {
											font-size: 48px !important;
											line-height: 54px !important;
										  }
										  * div [lang=x-size-56] {
											font-size: 56px !important;
											line-height: 60px !important;
										  }
										  * div [lang=x-size-64] {
											font-size: 64px !important;
											line-height: 63px !important;
										  }
										}
										</style>
											
											<title></title>
										  <!--[if !mso]><!--><style type="text/css">
										@import url(https://fonts.googleapis.com/css?family=Ubuntu:400,700,400italic,700italic);
										</style><link href="https://fonts.googleapis.com/css?family=Ubuntu:400,700,400italic,700italic" rel="stylesheet" type="text/css" /><!--<![endif]--><style type="text/css">
										body{background-color:#f2f2f2}.mso h1{}.h2{font-size:20px !important}.mso h3{}.mso .layout-fixed-width td,.mso .layout-full-width td,.mso .column__background td{}.mso .btn a{}.mso .webversion,.mso .snippet,.mso .layout-email-footer td,.mso .footer__share-button p{}.mso .webversion,.mso .snippet,.mso .layout-email-footer td,.mso .footer__share-button p{font-family:sans-serif !important}.mso .logo{}.mso .logo{font-family:Tahoma,sans-serif !important}.logo a:hover,.logo a:focus{color:#859bb1 !important}.mso .layout-has-border{border-top:1px solid #bfbfbf;border-bottom:1px solid #bfbfbf}.mso .layout-has-bottom-border{border-bottom:1px solid #bfbfbf}.mso .border,.ie .border{background-color:#bfbfbf}@media only screen and (min-width: 620px){.wrapper h1{}.wrapper h1{font-size:26px !important;line-height:34px !important}.wrapper h2{}.wrapper h2{font-size:20px !important;line-height:28px !important}.wrapper 
										h3{}.column,.column__background td{}}.mso h1,.ie h1{}.mso h1,.ie h1{font-size:26px !important;line-height:34px !important}.mso h2,.ie h2{}.mso h2,.ie h2{font-size:20px !important;line-height:28px !important}.mso h3,.ie h3{}.mso .column,.ie .column,.mso .column__background td,.ie .column__background td{}
										</style><meta name="robots" content="noindex,nofollow" />
										<meta property="og:title" content="My First Campaign" />
										</head>
										<!--[if mso]>
										  <body class="mso">
										<![endif]-->
										<!--[if !mso]><!-->
										  <body class="full-padding" style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%; font-family: Quicksand;font-size: 18px;">
										<!--<![endif]-->
											<div class="wrapper" style="min-width: 320px;background-color: #23baed;" lang="x-wrapper">
											  <div class="preheader" style="Margin: 0 auto;max-width: 560px;min-width: 280px; width: 280px;width: calc(28000vw - 173040px);">
												<div style="border-collapse: collapse;display: table;">
												<!--[if (mso)|(IE)]><table align="center" class="preheader" cellpadding="0" cellspacing="0"><tr><td style="width: 280px" valign="top"><![endif]-->
												  <div class="snippet" style="Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 140px; width: 140px;width: calc(14000vw - 86520px);padding: 10px 0 5px 0;color: #b8b8b8;font-family: Ubuntu,sans-serif;">
													
												  </div>
												<!--[if (mso)|(IE)]></td><td style="width: 280px" valign="top"><![endif]-->
												  <div class="webversion" style="Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 139px; width: 139px;width: calc(14100vw - 87140px);padding: 10px 0 5px 0;text-align: right;color: #b8b8b8;font-family: Ubuntu,sans-serif;">
													
												  </div>
												<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
												</div>
											  </div>
											  <div class="header" style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000vw - 173000px);" id="emb-email-header-container">
											  <!--[if (mso)|(IE)]><table align="center" class="header" cellpadding="0" cellspacing="0"><tr><td style="width: 600px"><![endif]-->
												
											  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
											  </div>
											  <div class="layout one-col fixed-width" style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000vw - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;">
												<div class="layout__inner" style="border-collapse: collapse;display: table;background-color: #ffffff;" emb-background-style>
												<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-fixed-width" emb-background-style><td style="width: 600px" class="w560"><![endif]-->
												  <div class="column" style="text-align: left;color: #23baed;font-family: Quicksand;font-size: 18px;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000vw - 173000px);">
												
												
											  
											<div style="Margin-left: 0px;Margin-right: 00px;Margin-top: 20px;">
											
											</div>
											<div class="hi">
											<img src="http://161.202.15.195/demo/images/mail/notif_2.png" width="150px" height="100px">
											</div>
											<div class="people">
											<img src="http://161.202.15.195/demo/images/mail/notif_3.png" width="150px" height="130px">
											</div>
											<div style="Margin-left: 0px;Margin-right: 20px;">
											  <h2>
											  <?php echo $prolog; ?></h2>
											 
											  <div style="margin-left:130px" >
											  <h4 align="center">PC Name : <?php echo  $book['computer_name'];   ?> </h4>
											  <h4 align="center">Start date : <?php echo  $book['start_booking'];   ?> </h4>
											  <h4 align="center">End date : <?php echo  $book['end_booking'];   ?> </h4>
											  <h4 align="center">Lab  : <?php echo  $book['lab_name'];   ?> </h4>
											  </div>
											</div>
												
											<div style="Margin-left: 20px;Margin-right: 20px;">
											 
											</div>
												
													<div style="Margin-left: 20px;Margin-right: 20px;">
											  <div style="line-height:10px;font-size:1px">&nbsp;</div>
											</div>
												
													<div style="Margin-left: 20px;Margin-right: 20px;Margin-bottom: 24px;">
											  <p class="size-14" style="Margin-top: 0;Margin-bottom: 0;font-size: 14px;line-height: 21px;" lang="x-size-14"><?php echo $template['ending']; ?><br />
										</p>
											</div>
												
												  </div>
												<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
												</div>
											  </div>
										  
											  <div class="layout email-footer" style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000vw - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;">
												<div class="layout__inner" style="border-collapse: collapse;display: table;">
												<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-email-footer"><td style="width: 400px;" valign="top" class="w360"><![endif]-->
												  <div class="column wide" style="text-align: left;font-size: 12px;line-height: 19px;color: #b8b8b8;font-family: Ubuntu,sans-serif;Float: left;max-width: 400px;min-width: 320px; width: 320px;width: calc(8000vw - 49200px);">
													<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
													  <table class="email-footer__links emb-web-links" style="border-collapse: collapse;table-layout: fixed;"><tbody><tr>
													  <td class="emb-web-links" style="padding: 0;width: 26px;"><a style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #b8b8b8;" href="http://vmap.clouddesk.io"><img style="border: 0;" src="https://i2.createsend1.com/static/eb/beta/13-the-blueprint-3/images/website.png" width="26" height="26" /></a></td>
													  </tr></tbody></table>
													 <?php echo $template['footer'] ?>
													  <div style="Margin-top: 18px;">
														
													  </div>
													</div>
												  </div>
												<!--[if (mso)|(IE)]></td><td style="width: 200px;" valign="top" class="w160"><![endif]-->
												  <div class="column narrow" style="text-align: left;font-size: 12px;line-height: 19px;color: #b8b8b8;font-family: Ubuntu,sans-serif;Float: left;max-width: 320px;min-width: 200px; width: 320px;width: calc(74600px - 12000vw);">
													<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
													  
													</div>
												  </div>
												<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
												</div>
											  </div>
											  <div class="layout one-col email-footer" style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000vw - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;">
												<div class="layout__inner" style="border-collapse: collapse;display: table;">
												<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-email-footer"><td style="width: 600px;" class="w560"><![endif]-->
												  <div class="column" style="text-align: left;font-size: 12px;line-height: 19px;color: #b8b8b8;font-family: Ubuntu,sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000vw - 173000px);">
													<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
													  <div>
														<unsubscribe style="text-decoration: underline;">Unsubscribe</unsubscribe>
													  </div>
													</div>
												  </div>
												<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
												</div>
											  </div>
											  <div style="line-height:40px;font-size:40px;">&nbsp;</div>
											
										  </div>
										</body></html>