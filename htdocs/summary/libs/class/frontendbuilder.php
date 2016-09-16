<?php
	class frontendbuilder {
		
		function __construct (){
		
		}

		/* 
			nivo slider image gallery 
			$data merupakan data array dengan rincian sebagai berikut
				- name : penentu id untuk gallery biar tidak terjadi bentrok jika ada lebih 1 slider
				- image : berisi data array berupa 'path' (image location) dan 'title' yang nantinya digunakan untuk caption (jika caption active).
				- nivOpt : option untuk nivo slider
		*/
		
		function nivoGallery ($data){
			ob_start();		
			if(is_array($data['image']) and count($data['image']) > 0):
			?>				
				<link rel="stylesheet" href="/public/fbclass/nivoSlider/nivo-slider.css" type="text/css" media="screen" />
				<link rel="stylesheet" href="/public/fbclass/nivoSlider/themes/default.css" type="text/css" media="screen" />
				<div class="cSlider theme-default">
					<div id="<?php echo str_replace(' ','_',strtolower($data['name'])); ?>" class="nivoSlider">
						<?php foreach($data['image'] as $index => $images): ?>
							<?php if(isset($images['link']) AND trim($images['link']) != '') echo '<a href="'.$images['link'].'" >'; ?>
								<img src="<?php echo $images['path']; ?>" data-thumb="<?php echo $images['path']; ?>" alt="<?php echo 'slide'.$index; ?>" title="<?php if(isset($images['caption']) AND trim($images['caption']) != ''){ echo "#htmlcaption-slide".$index; }else{ echo $images['title']; } ?>" />
							<?php if(isset($images['link']) AND trim($images['link']) != '') echo '</a>'; ?>
						<?php endforeach; ?>
					</div>
					
					<?php foreach($data['image'] as $index => $images): ?>
						<?php if(isset($images['caption']) AND trim($images['caption']) != ''): ?>
						<div id="htmlcaption-slide<?php echo $index; ?>" class="nivo-html-caption">
							<?php echo $images['caption']; ?>
						</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
				<script type="text/javascript" src="/public/fbclass/nivoSlider/jquery.nivo.slider.js"></script>
				<script> 
					if(!window.jQuery) { 
						document.write("<font color='red'>JQuery not found!!</font>"); 
					}else{ 
						$(window).load(function() {
							$('#<?php echo str_replace(' ','_',strtolower($data['name'])); ?>').nivoSlider(<?php if(isset($data['nivOpt'])) echo $data['nivOpt'];?>);
						});
					}
				</script>
			<?php
			endif;
			$output = ob_get_contents();
			ob_end_clean();	
			
			return $output;
		}
		
		/*
			fungsi untuk membuat tampilan default dari tabel general
			hanya menampilkan title dan description dari spesifik konten
		*/
		
		function generalTemplate ($data){
			ob_start();		
			if(isset($data['title']) and isset($data['description'])):
			?>
			<div class="title text">
				<h1><?php echo $data['title']; ?></h1>
			</div>
            
            <div id="description text">
				<?php echo $data['description']; ?>
            </div>
			<?php
			endif;
			$output = ob_get_contents();
			ob_end_clean();	
			
			return $output;
		}
		
		/*
			fungsi untuk membuat default contact us 
			berisi nama, alamat, email, dan pesan
		*/
		function contactUs ($sendEmail=false, $serverSetting=null){
			$simpleFormBuilder = new simpleFormBuilder;
			
			$builder 	= array	(
							"prosesname"=> "Your Contact Has Been Saved ",
							"action"	=> "",
							"method"	=> "insert",
							"datatable"	=> "tbl_contact",
							"element"	=> array	( 
														"Name" => array( "type" => "text", "dataname" => "contact_name	", "required" => 1),
														"Email" => array( "type" => "text", "dataname" => "contact_email", "required" => 1, "emailvalid" => 1),
														"Phone" => array( "type" => "text", "dataname" => "contact_phone", "required" => 1, "phonevalid" => 1),					
														"Address" => array( "type" => "text", "dataname" => "contact_address", "required" => 1),
														"Message" => array( "type" => "textarea", "dataname" => "contact_message", "required" => 1, "width" => "75"),
														"captcha" => array( "type" => "captcha", "ignore" => 1, "message" => "(spam protection)"),
														
														"hidden" => array( "type" => "hidden", "dataname" => "contact_date" , "value" => date("Y-m-d H:i:s")),
													)
						);
			
		
			$form	= $simpleFormBuilder->builder($builder, false, false, false);
			
			if($simpleFormBuilder->haveError != 1 AND isset($_POST['submit']) AND $sendEmail == true){
				echo $simpleFormBuilder->haveError;
				if(is_null($serverSetting)){
					$objEmail 	= new send2email(MAIL_SERVER, SITE_EMAIL, SITE_EMAIL_PASS, MAIL_PORT, true);
					$receiver	= MANAGEMENT_EMAIL;
				}else{
					$objEmail 	= new send2email(trim($serverSetting[0]), trim($serverSetting[1]), trim($serverSetting[2]), trim($serverSetting[3]), trim($serverSetting[4]) );
					$receiver	= $serverSetting[5];
				}

				$send 		= $objEmail->send($_POST["contact_email"], '[Blanco Indonesia] Contact Us from '.$_POST["contact_name"] .' ('.$_POST["contact_phone"]. ')', $_POST["contact_message"], $receiver, 'Contact Us', $_POST["contact_name"]);
				/*echo '<!-- <pre>'; print_r($send); echo ' </pre> -->';*/
			}
			
			return $form;
		}
		
		
		
		/* End of Class */	
	}
	
	
	
?>