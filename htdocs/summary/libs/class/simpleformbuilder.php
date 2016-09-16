<?php
/*
	class		: simpleFormBuilder
	filename	: simpleformbuilder.php
	create 		: 01 Agustus 2012
	by			: Adhan Singgih (singgih.blacklist15@gmail.com)
	Description	: untuk membuat element form seperti text, files, textarea, texteditor, option, checkbox, radio button secara otomatis.
	Require		: file newfunc.php on folder /manager/include
	
	jika ingin menggunakan simple cms builder agar tidak report2 saat bikin form di cms bisa gunakan contoh di bawah ini.		
	
	@parameter :
		-- prosesname -> memberi nama proses yang akn berlangsung. nantinya akan menjadi variable untuk pesan sukses/failed dan log.
	
		-- action -> tujuan dari form ketika submit di klik. defaultnya adalah kosong, dan akan memproses data pada form sesuai dengan type form tersebut (jika ketentuan penulisan element sesuai)
		
		-- method -> operasi yang akan dilakukan jika action dalam keadaan kosong dan tombol submit si klik. opsi pilihan insert atau update
		
		-- datatabel -> nama table di mana data akan di insert/update
		
		-- dataedit	-> digunakan dalam proses update data. berisi object dari hasil query dai data yang akan di edit/update
		
		-- conedit -> variable digunakan untuk proses update. bertype array dengan ketentuan arrayKey sebagai 'nama kolom' dan arrayValu sebagai value dari kolom yang akan di update.
		
		-- redirect -> halaman tujuan ketika proses insert / update telah selesai. jika dalam keadaan kosong / tidak di set, maka redirect nantinya akan menuju ke halaman sebelumnya.
		
		-- element -> element yang akan dibentuk dalam suatu form, dengan parameter sebagai berikut
			@params :
				-- array key -> akan menjadi name text / title dari element yang akan dibuat nantinya.
				-- array value -> berupa array dengan rincian sebagai berikut :
					++ type -> element yang akan dibuat bertipe apa, text? textarea? atau yang lain.
					++ dataname -> nama kolom pada tabel dimana value/isi dari element ini akan diambil dari dataedit. sekaligus akan menjadi nama/id dari element tersebut.
					++ required -> element ini mandatori/harus diisi atau tidak. 1 untuk ya, 0 untuk tidak.
					++ filesid -> untuk mengganti ID pada element
					++ datalist -> dipakai pada options , checbox, dan radio. parameter berupa array dengan rincian arrayKey sebagai 'value' dan arrayValue sebagai 'text'
					++ ignore -> data dari input tidak akan dimasukkan ke dalam database
		exemple :
		
		<?php
			require_once(simpleformbuilder.php);
			$simpleFormBuilder = new simpleFormBuilder;
			
			$page_id 	= "home";		
			$page_title	= "&quot;Add New Link&quot; - Home Management";
			
			checkPrivilege4("Home Management","edit");
			
				
			$religions	= array('1' => "Islam", "2" => "Kristen", "3" => "Katolik", "4" => "Hindu", "5" => "Buddha");
			$sex	= array('1' => "Male", "2" => "Female");
			$hobby	= array('1' => "Football", "2" => "Basket", "3" => "Fishing", "4" => "Sleeping");
			
			$builder 	= array	(
									"action"	=> "",
									"method"	=> "update",
									"datatable"	=> "tbl_general",
									"dataedit"	=> (object) array("nama" => "Adhan Singgih", "photo" => "imagessatu.jpg", "profile" => "hemn...", "sprofile" => "hemn....", "relegions" => "1", "sex" => "1", "hobby" => array("1", "4")),
									"conedit"	=> array("id" => "1"),
									"element"	=> array	( 
																"Nama" => array( "type" => "text", "dataname" => "nama", "required" => 1 ),
																"Photo" => array( "type" => "inputfiles", "dataname" => "photo", "required" => 1, "allow" => "images", "dest" => "/path/to/folder/" ),
																"Profile" => array( "type" => "texteditor", "dataname" => "profile", "required" => 1 ),
																"Profile Pendek" => array( "type" => "textarea", "dataname" => "sprofile", "required" => 1 ),
																"Religion" => array( "type" => "options", "dataname" => "relegions", "datalist" => $religions, "required" => 1 ),
																"Sex" => array( "type" => "radio", "dataname" => "sex", "datalist" => $sex, "required" => 1 ),
																"Hobby" => array( "type" => "checkbox", "dataname" => "hobby", "datalist" => $hobby, "required" => 1 ),
															)
								);
								
			
			$simpleFormBuilder->builder($builder);
		?>

*/

class simpleFormBuilder {
	private $dataBuilder, $dataArgs, $postToken, $errorFields = array(), $isSuccess = false, $postActive = false, $arrayC = 0, $is_upload = false,$withoutExecute = false;
	public $MYSQLID = 0, $errorMessage, $haveError = false;
	
	function __construct (){
		$this->postToken = sha1 (uniqid ("batavianet"));			
	}
	
	/*
		create element limiter
	*/
		
	function limiter ($args){	
		$this->openTemplateForm($args);
		?>		
		<tr class="trlimiter" style="background:#000; color:#FFF; font-weight:bold;" >
			<td colspan="2"><?php echo $args['text']; ?></td>
		</tr>		
		<?php		
		$this->closeTemplateForm();
	}
	
	/*
		create element limiter
	*/
		
	function simpletext ($args){	
		$this->openTemplateForm($args);
		?>		
		<tr class="trlimiter" style="font-weight:bold;" >
			<td colspan="2"><?php echo $args['message']; ?></td>
		</tr>		
		<?php		
		$this->closeTemplateForm();
	}
	
	/*
		create element captcha 
	*/

	function captcha ($args){	
		$this->openTemplateForm($args);
		?>		
		<tr class="trlimiter" style="font-weight:bold;" >
			<td colspan="2">
				<samp>
					<img id="captchaImg" src="/public/reader/simplecaptcha.php" alt="captcha Image" align="left" width="100" />
					<a tabindex="-1" style="border-style: none;" href="#" title="Refresh Image" onclick="document.getElementById('captchaImg').src = '/public/reader/simplecaptcha.php?sid=' + Math.random(); this.blur(); return false">
						<img src="/public/reader/refresh.png" alt="Reload Image" onclick="this.blur()" align="left" style="margin:5px 0 0 5px;" border="0" width="20px">
					</a>
				</samp>
				<div style="clear:both"><br/></div>
				<input class="answer" name="antispam" id="question" type="text" size="10" />
				<strong><?php echo $args['message']; ?></strong>
			</td>
		</tr>		
		<?php		
		$this->closeTemplateForm();
	}
	
	/*
		create element input text
	*/
		
	function text ($args){	
		$this->openTemplateForm($args);
		?>		
		<tr>
			<td colspan="2">
				<input type="text" name="<?php if(isset($args['dataname'])) echo $args['dataname']; else echo 'inputtext'; ?>" <?php if(isset($args['required']) AND $args['required'] == 1) echo 'required'; ?> <?php if(isset($args['readonly']) AND $args['readonly'] == 1) echo 'readonly'; ?> style="width:<?php $w = isset($args['width']) ? $args['width'] : '50%'; echo $w; ?>" id="<?php if(isset($args['filesid'])) echo replace_text($args['filesid']); else echo 'textid'; ?>" value="<?php echo str_replace("\&quot;","",stripslashes($args['value'])); ?>" /> 
			</td>
		</tr>		
		<?php		
		$this->closeTemplateForm();
	}
	
	/*
		create element for input date
	*/
		
	function datepicker ($args){	
		$this->openTemplateForm($args);
		?>		
		<tr>
			<td colspan="2">
				<input type="text" name="<?php if(isset($args['dataname'])) echo $args['dataname']; else echo 'mydatepicker'; ?>" <?php if(isset($args['required']) AND $args['required'] == 1) echo 'required'; ?> style="width:<?php $w = isset($args['width']) ? $args['width'] : '50%'; echo $w; ?>" id="<?php if(isset($args['filesid'])) echo replace_text($args['filesid']); else echo 'mydatepicker'; ?>" class="mydatepicker" value="<?php echo $args['value']; ?>" /> 
			</td>
		</tr>		
		<?php		
		$this->closeTemplateForm();
	}

	/*
		create element hidden input
	*/
		
	function hidden ($args){
		$this->openTemplateForm($args);
		?>		
		<input type="hidden" name="<?php if(isset($args['dataname'])) echo $args['dataname']; else echo 'hiddeninput'; ?>" <?php if(isset($args['required']) AND $args['required'] == 1) echo 'required'; ?> style="width:50%" id="<?php if(isset($args['filesid'])) echo replace_text($args['filesid']); else echo 'hiddenid'; ?>" value="<?php echo $args['value']; ?>" />		
		<?php		
		$this->closeTemplateForm();
	}
	
	/*
		create element input files
	*/
		
	function inputfiles ($args){
		$this->openTemplateForm($args);
		?>		
		<tr>
			<td colspan="2">
				<input type="file" name="<?php if(isset($args['dataname'])) echo $args['dataname']; else echo 'inputfiles'; ?>" <?php if(isset($args['required']) AND $args['required'] == 1) echo 'required'; ?> style="width:50%" id="<?php if(isset($args['filesid'])) echo replace_text($args['textid']); else echo 'inputfilesid'; ?>" value="<?php echo $args['value']; ?>" /> 
				<?php if(isset($args['preview']) AND $args['preview'] == 1) :?>
				<p><b><?php echo $args['text']?> Preview</b></p>
				<?php echo img_preview($args['value'], 350); ?>
				<?php endif; ?>
			</td>
		</tr>		
		<?php		
		$this->closeTemplateForm();
	}
	
	/*
		create element input files with filemanager
	*/
	
	function choosefiles ($args){
		$this->openTemplateForm($args);
		?>
		<tr>
			<td colspan="2"> 
				<input type="text" <?php if(isset($args['required']) AND $args['required'] == 1) echo 'required'; ?> <?php if(isset($args['readonly']) AND $args['readonly'] == 1) echo 'readonly'; ?> name="<?php if(isset($args['dataname'])) echo $args['dataname']; else echo 'choosefiles'; ?>" id="<?php if(isset($args['filesid'])) echo replace_text($args['filesid']); else echo $args['dataname']; ?>" class="<?php if (empty($args['readonly']) && !isset($args['readonly'])) echo 'choose_file';?>" style="width:50%" value="<?php echo $args['value']; ?>" <?php if(isset($args['folder'])) echo 'src="'.$args['folder'].'"'; ?>  />
				<?php if(isset($args['preview']) AND $args['preview'] == 1) :?>
				<p><b><?php echo $args['text']?> Preview</b></p>
				<?php echo img_preview($args['value'], 350); ?>
				<?php endif; ?>
			</td>
		</tr>
		<?php		
		$this->closeTemplateForm();
	}
	
	/*
		create element multiple input files with filemanager
	*/
	
	function multiplechoosefiles ($args){
		$this->openTemplateForm($args);
		?>
		<tr>
			<td colspan="2">
				<div id="btnplus" style="border-bottom:1px solid #CCC; height:20px; line-height:20px; padding-right:20px; cursor:pointer; width:auto; float:left;">
					<img src="/manager/images/btn_addnew.jpg" title="add new element" align="left" /> add new element 
				</div>
				<input type="hidden" name="countfield_<?php if(isset($args['filesid'])) echo replace_text($args['filesid']); else echo 'multiplechooseid'; ?>" id="countfield_<?php if(isset($args['filesid'])) echo replace_text($args['filesid']); else echo 'multiplechooseid'; ?>" value="0" />
				
				<div style="clear:both;"><br/></div>
				<input type="text" <?php if(isset($args['required']) AND $args['required'] == 1) echo 'required'; ?> name="<?php if(isset($args['dataname'])) echo $args['dataname']; else echo 'choosefiles'; ?>" id="<?php if(isset($args['filesid'])) echo replace_text($args['filesid']); else echo 'multiplechooseid'; ?>" class="choose_file" style="width:50%" <?php if(isset($args['folder'])) echo 'src="'.$args['folder'].'"'; ?> />
				
				<?php 
				
					if(isset($args['preview']) AND $args['preview'] == 1):						
						$value = $args['value']; 					
						if(is_array($value)){
							$this->listDataFromSerialize($value, $args);							
						}else{
							$value = my_unserialize($value);
							$this->listDataFromSerialize($value, $args);
						}
						
						if(isset($_GET['removeSerialize']) AND is_numeric(_64de($_GET['removeSerialize'], 'raw'))){
							$this->removeSerialize($value, $args);
						}					
					endif; 
				?>	
				
				<div id="another_image"></div>
			</td>
		</tr>
		<script>
			$("#btnplus").click(function(){
				var c = $("#countfield_<?php if(isset($args['filesid'])) echo replace_text($args['filesid']); else echo 'multiplechooseid'; ?>").val();
				$("#another_image").append('<input type="text" name="<?php if(isset($args['dataname'])) echo $args['dataname']; else echo 'choosefiles'; ?>" id="<?php if(isset($args['filesid'])) echo replace_text($args['filesid']); else echo 'chooseid'; ?>_'+c+'" placeholder="addition element '+((parseInt(c))+1)+'" class="choose_file" style="width:50%" <?php if(isset($args['folder'])) echo 'src="'.$args['folder'].'"'; ?> /> <br/>');
				$("#countfield_<?php if(isset($args['filesid'])) echo replace_text($args['filesid']); else echo 'multiplechooseid'; ?>").val((parseInt(c))+1);
			});
		</script>
		<?php		
		$this->closeTemplateForm();
	}
	
	function removeSerialize($value, $args){
		global $DB;	
		$key = _64de($_GET['removeSerialize'], 'raw');
		// remove from array
		$tmpValue = $value;
		unset($tmpValue[$key]);
		sort($tmpValue);
		
		// get data table
		$update = _64en(serialize($tmpValue), 'raw');
		$rowupdate = str_replace('[]', '', $args['dataname']);
		
		$where = array();
		foreach($this->dataBuilder['conedit'] as $keyrow => $valrow )
			$where[] = " {$keyrow} = '{$valrow}' ";									
		$where = implode(" AND ", $where);	
			
		$sqlUpdate = "UPDATE {$this->dataBuilder['datatable']} SET {$rowupdate} = '{$update}' WHERE {$where} ";
		//echo $sqlUpdate;die;
		if($DB->Query($sqlUpdate)){
			if(strpos($_SERVER['REQUEST_URI'], "?") === false)
				$redirect = explode('?removeSerialize', $_SERVER['REQUEST_URI']);
			else
				$redirect = explode('&removeSerialize', $_SERVER['REQUEST_URI']);
			
			echo '<meta http-equiv="refresh" content="0;url='.$redirect[0].'#addfile">';
		}
	}
	
	function listDataFromSerialize($value, $args) {
		echo "<div id='addfile' style='padding:10px 0; font-weight:bold;'> List {$args['text']} : </div>";
		if(count($value) > 0):
			
			foreach($value as $key => $file):
				?><input type="hidden" <?php if(isset($args['required']) AND $args['required'] == 1) echo 'required'; ?> name="<?php if(isset($args['dataname'])) echo $args['dataname']; else echo 'choosefiles'; ?>" id="<?php if(isset($args['filesid'])) echo replace_text($args['filesid']); else echo 'multiplechooseid'; ?>" class="choose_file" style="width:50%" <?php if(isset($args['folder'])) echo 'src="'.$args['folder'].'"'; ?> value="<?php echo $file; ?>" /><?php
				
				if(strpos($_SERVER['REQUEST_URI'], "?") === false)
					$removeLink = $_SERVER['REQUEST_URI'].'?removeSerialize='._64en($key,'raw');
				else
					$removeLink = $_SERVER['REQUEST_URI'].'&removeSerialize='._64en($key,'raw');
				
				$filename = getFilenameWithoutExt($file);
				
				if(trim($filename[0]) != ''):
					echo "<li style='padding:5px 0'>
							<a href='".downloadfile($file)."' title='download this file' >". $filename[0] ."</a> &nbsp;&nbsp;&nbsp;
							<a title='remove file' href='{$removeLink}' style='color:red; font-size:11px;'>[remove]</a>
						</li>";
				endif;
			endforeach;
		else:
			echo "No additional file.";
		endif;
	}
	
	/*
		create element textarea
	*/
	function textarea ($args){
		$this->openTemplateForm($args);
		?>
		<tr>
			<td colspan="2"> <textarea <?php if(isset($args['required']) AND $args['required'] == 1) echo 'required'; ?> <?php if(isset($args['readonly']) AND $args['readonly'] == 1) echo 'readonly'; ?> name="<?php if(isset($args['dataname'])) echo $args['dataname']; else echo 'inputarea'; ?>" id="<?php if(isset($args['filesid'])) echo replace_text($args['filesid']); else echo 'textareaid'; ?>" style="width:<?php if(isset($args['width'])){ echo $args['width']; }else{ echo '50'; }?>%; height:100px;" ><?php echo str_replace("\&quot;","",stripslashes($args['value'])); ?></textarea> </td>
		</tr>
		<?php		
		$this->closeTemplateForm();
	}
	
	/*
		create element select
	*/
	function options ($args){
		$this->openTemplateForm($args);
		?>
		<tr>
			<td colspan="2"> 
				<select <?php if(isset($args['required']) AND $args['required'] == 1) echo 'required'; ?> name="<?php if(isset($args['dataname'])) echo $args['dataname']; else echo 'inputarea'; ?>" id="<?php if(isset($args['filesid'])) echo replace_text($args['filesid']); else echo 'optionsid'; ?>" style="width:50%;">
				<?php 
					if(isset($args['datalist']) AND is_array($args['datalist'])): 
						foreach($args['datalist'] as $value => $text):
							if($args['value'] == $value){ $selected = 'selected'; }else{ $selected = ''; }
							echo '<option value="'.$value.'" '.$selected.'>'.$text.'</option>';
						endforeach; 
					endif; 
				?>			
				</select> 
			</td>
		</tr>
		<?php		
		$this->closeTemplateForm();
	}

	/*
		create element multiple select
	*/

	function multipleoptions ($args){
		$this->openTemplateForm($args);
		if(is_array($args['value'])):
			$value = $args['value'];
		else:
			$value = unserialize(base64_decode($args['value']));
		endif;
		?>
		<script> $(document).ready(function() { <?php if(is_array($value) AND $value != "") : ?>$("#<?php if(isset($args['filesid'])) echo replace_text($args['filesid']); else echo 'multipleoptionsid'; ?>").val([<?php echo implode(",", $value); ?>]); <?php endif; ?> $("#<?php if(isset($args['filesid'])) echo replace_text($args['filesid']); else echo 'multipleoptionsid'; ?>").select2(<?php if(isset($args['placeholder'])): ?>{ placeholder: "<?php echo $args['placeholder']; ?>", allowClear: true}); }<?php endif; ?>); </script>
		<tr>
			<td colspan="2"> 
				<select multiple <?php if(isset($args['required']) AND $args['required'] == 1) echo 'required'; ?> name="<?php if(isset($args['dataname'])) echo $args['dataname']; else echo 'inputarea'; ?>" id="<?php if(isset($args['filesid'])) echo replace_text($args['filesid']); else echo 'multipleoptionsid'; ?>" style="width:50%;">
				<?php 
					if(isset($args['datalist']) AND is_array($args['datalist'])): 
						foreach($args['datalist'] as $value => $text):
							if($args['value'] == $value){ $selected = 'selected'; }else{ $selected = ''; }
							echo '<option value="'.$value.'" '.$selected.'>'.$text.'</option>';
						endforeach; 
					endif; 
				?>			
				</select> 
			</td>
		</tr>
		<?php		
		$this->closeTemplateForm();
	}
	
	/*
		create element radio
	*/
	function radio ($args){
		$this->openTemplateForm($args);
		?>
		<tr>
			<td colspan="2"> 
				<?php 
					if(isset($args['datalist']) AND is_array($args['datalist'])): 
						foreach($args['datalist'] as $value => $text):
							if($args['value'] == $value){ $checked = 'checked'; }else{ $checked = ''; }
							if(!isset($args['listtype']) OR $args['listtype'] == 'horisontal'){
								$style = "style='float:left; width:auto; margin:0 5px 4px 0';";
							}else{
								$style = "style='margin:0 0 2px 0; width:100%;';";
							}
							?>
								<div <?php echo $style; ?>> 
									<input  type="radio" name="<?php if(isset($args['dataname'])) echo $args['dataname']; else echo 'inputradio'; ?>" id="<?php if(isset($args['filesid'])) echo replace_text($args['filesid']); else echo 'radioid'; ?>" <?php echo $checked; ?> value="<?php echo $value; ?>"> <?php echo $text; ?>
								</div>
							<?php
						endforeach; 
					endif; 
				?>
			</td>
		</tr>
		<?php		
		$this->closeTemplateForm();
	}
	
	/*
		create element checkbox
	*/
	function checkbox ($args){
		$this->openTemplateForm($args);
		?>
		<tr>
			<td colspan="2"> 
				<?php 
					if(isset($args['datalist']) AND is_array($args['datalist'])): 
						foreach($args['datalist'] as $value => $text):
							// set default $args['value'] to array
							if(isset($args['value']) AND !is_array($args['value'])){ $args['value'] = array($args['value']); }
							// check value of checkbox
							if(isset($args['value']) AND in_array($value, $args['value'])){ $checked = 'checked'; }else{ $checked = ''; }
							if(!isset($args['listtype']) OR $args['listtype'] == 'horisontal'){
								$style = "style='float:left; width:auto; margin:0 5px 4px 0';";
							}else{
								$style = "style='margin:0 0 2px 0; width:100%;';";
							}
							?>
								<div <?php echo $style; ?>> 
									<input  type="checkbox" class="checkbox" name="<?php if(isset($args['dataname'])) echo $args['dataname']; else echo 'inputradio'; ?>" id="<?php if(isset($args['filesid'])) echo replace_text($args['filesid']).'_'.$value; else echo 'radioid_'.$value; ?>" <?php echo $checked; ?> value="<?php echo $value; ?>"> <?php echo $text; ?>
								</div>
							<?php
						endforeach; 
					endif; 
				?>
			</td>
		</tr>
		<?php		
		$this->closeTemplateForm();
	}
	
	/*
		create element texteditor using FCK Editor
	*/
	
	function texteditor ($args) {
		$this->openTemplateForm($args);
		?>
		<?php if(isset($args['dataname'])) $name = $args['dataname']; else $name = 'inputfiles'; ?>
		<tr>
			<td colspan="2" > 
				<?php
					$oFCKeditor = new FCKeditor($name) ;
					$oFCKeditor->BasePath = SITE_URL.'addin/fckeditor/' ;
					$oFCKeditor->ToolbarSet = "CustomToolBar";
					$oFCKeditor->Value = str_replace("\&quot;","",stripslashes($args['value']));
					$oFCKeditor->Height = 250 ;
					$oFCKeditor->Create() ;
				?>
			</td>
		</tr>
		<?php		
		$this->closeTemplateForm();
	}
	
	/*
		create template text
	*/
	function openTemplateForm($args){		
		if(in_array($args['text'], $this->errorFields)){
			$replaceText	= '<i style="color:red">'.$args['text'].'</i>';
			$args['text'] 	= str_replace($args['text'], $replaceText, $args['text']);
		}
	
		ob_start();
		if($args['text'] == 'hidden' OR $args['type'] == 'limiter' OR $args['type'] == 'captcha'):
			// do nothing
		else:
		?>
		<tr>
			<td colspan="2" valign="top">
				<b><?php if(isset($args['text'])) echo $args['text']; ?></b> 
				<?php if(isset($args['required']) AND $args['required'] == 1) echo '<span style="color:red;">*</span>'; ?>
				<?php if(isset($args['message'])) echo $args['message']; ?>
			</td>
		</tr>
		<?php	
		endif;
	}
	
	/*
		create output
	*/
	function closeTemplateForm(){
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
	}

	/* check validation email */
	function isValidEmail($email){
	    return preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email);
	}

	/* chack validation phone number */
	function isValidPhone($phone){
		if(is_numeric($phone)) return 1; else return 0;
	}

	/*
		create all element from parameter
	*/
	
	function builder ($builder, $closeDB=false, $withoutExecute=false, $forBackend=true){
		global $page_title, $con;		
		$this->dataBuilder = $builder;
		$this->withoutExecute = $withoutExecute;
		
		if(!isset($builder['action'])) 
			$builder['action'] = ""; 
		
		$this->execute();
		
		ob_start();
		?>
		<?php 
			if($forBackend) include(SITE_PATH."addin/template/up.php"); 
			if(isset($_SESSION['message']) AND $_SESSION['message'] != ''){
				echo $_SESSION['message'];
				unset($_SESSION['message']);
			}
			if($this->haveError) 
				echo "<div style='color:red;border-bottom:1px solid red;margin-bottom:10px;'><b>".$this->errorMessage."</b></div>";
				
			if($this->isSuccess){ 
				$_SESSION['message'] = "<div style='color:green;border-bottom:1px solid green;margin-bottom:10px;'><b>".$this->errorMessage."</b></div>";
				echo '<meta http-equiv="refresh" content="0.5">';
				exit;
			}
		?>
			
			<link href="/public/script/select2/select2.css" rel="stylesheet"/>						
   			<script src="/public/script/select2/select2.min.js"></script>
   			<link href="/public/script/datepicker/jquery-ui-1.7.2.custom.css" rel="stylesheet" type="text/css" />
   			<script src="/public/script/datepicker/jquery-ui-1.7.2.custom.min.js"></script>
   			<script type="text/javascript"> jQuery(document).ready(function(){ jQuery('.mydatepicker').datepicker({ dateFormat : 'yy-mm-dd', changeMonth: true,
				changeYear: true, yearRange: "2000:<?php echo date("Y");?>"  }); }); </script>

			<form name="form_add" method="post" enctype="multipart/form-data" action="<?php echo $builder['action']; ?>" >				
				<input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>" />
				<input type="hidden" name="pid" value="<?php echo $_GET["pid"]; ?>" />
				<input type="hidden" name="page" value="<?php echo $_GET['page']; ?>" />
				<input type="hidden" name="flag" value="<?php echo $_GET['flag']; ?>" />
				<?php if(is_array($builder['element'])): ?>
				<table id="add_table" cellspacing="0" cellpadding="5" border="0" width="100%">
					<?php 
						/* check dataedit berupa object atau tidak */
						if(is_object($builder['dataedit'])){
							$dataEdit = $builder['dataedit'];
						}elseif(is_array($builder['dataedit']) AND count($builder['dataedit']) > 0){	
							$dataEdit = (object) $builder['dataedit'];
						}else if($this->postActive){
							$dataEdit = true;
						}else{
							$dataEdit = false;
						}
						
						foreach($builder['element'] as $key => $element):
							$element['text'] = $key;
							
							if($dataEdit != false AND !isset($element['value'])){ 
								if($element['type'] == 'limiter') continue;
								if($this->postActive){	
									// jika element yang di inputkan menggunakan array
									if(strpos($element['dataname'],"[]")){
										$elname = str_replace('[]','',$element['dataname']);
										$value	= $_POST[$elname];
										
										if(is_array($value))
											$element['value'] = $value[$this->arrayC];										
										else
											$element['value'] = @$dataEdit->$elname;
											
										//$element['value'] = @$dataEdit->$elname;
										$this->arrayC++;
									}else{
										$getPost = trim($_POST[$element['dataname']]);
										$element['value'] = !empty($getPost) ? $_POST[$element['dataname']] : @$dataEdit->$element['dataname'];	
									}
								}else{		
									// jika element yang di inputkan menggunakan array
									if(strpos($element['dataname'],"[]")){
										$elname = str_replace('[]','',$element['dataname']);
										$value	= @$dataEdit->$elname;
										if(is_array($value))
											$element['value'] = $value[$this->arrayC];											
										else
											$element['value'] = @$dataEdit->$elname;
										
										$this->arrayC++;
									}else{
										$element['value'] = @$dataEdit->$element['dataname'];
									}
								}
							}else if(isset($element['value'])){
								//do nothing
							}else{							
								$element['value'] = '';
							}
							
							if(isset($element['autoclear']) AND $element['autoclear'] == 1)
								$element['value'] = '';
							
							if(isset($element['type'])){
								if(method_exists($this, $element['type'])){
									echo $this->$element['type'] ($element);
								}
							}							
							
						endforeach;
					?>
					<?php if ($builder['method'] != "" ){?>
					<tr>
						<td colspan="2" >
							<input type="submit" value="Submit" name="submit" id="submit" />
							<input type="reset" value="Reset" name="reset" id="reset" />
							<input type="hidden" value="<?php echo $this->postToken ?>" name="posttoken" size="100" />
						</td>
					</tr>
					<tr>
						<td colspan="2" ><span style="color:red;"><strong>* Required Field </strong></span></td>
					</tr>
					<?php }?>
				</table>
				<?php endif; ?>
			</form>
		<?php if($forBackend) include(SITE_PATH."addin/template/bottom.php"); ?>			
		<?php if($forBackend) { if($closeDB == false){ include(SITE_PATH.'include/con_close.php'); } }?>
		<?php
		
		$output = ob_get_contents();
		ob_end_clean();
		
		if($forBackend) 
			echo $output;
		else
			return $output;
	}
	
	function execute (){
		if(isset($_POST['submit']) AND $_POST['submit'] == "Submit" AND !empty($_POST['posttoken'])){
			if($this->withoutExecute)
				return; // goto BYPASS;
		
			$this->postActive = true;
			$builder = $this->dataBuilder;
			
			// cek apakah data di refresh setelah post berhasil
			if( ($_SESSION['posttoken'] == $_POST['posttoken'])){
				$this->errorMessage = "Save Failed! Cannot save data with same value!";	
				$this->haveError = true;
			};
			
			/* cek apakah ada kesalaha dalam pembuatan variable builder */
			if(!isset($builder['method']) OR empty($builder['method']) OR !isset($builder['datatable']) OR empty($builder['datatable']) OR !isset($builder['element']) OR empty($builder['element'])) 
				$this->error_message(1);				
			
			if(isset($builder['element']['captcha'])){
				$ses_security_code 	= $_SESSION['security_code'];
				$inp_security_code	= $_POST['antispam'];
				
				if($ses_security_code != $inp_security_code){
					$this->errorMessage = "code anti spam invalid!";
					$this->haveError 	= true;
				}
			}
			
			$dataField = array();
			foreach($builder['element'] as $elkey => $elval){								
				if(strpos($elval['dataname'],"[]"))
					$elname = str_replace('[]','',$elval['dataname']);
				else
					$elname = $elval['dataname'];
				
				if($elval['type'] == 'inputfiles'){
					$valPost = trim($_FILES[$elname]['name']);
				}elseif(is_array($_POST[$elname])){
					$valPost = trim($_POST[$elname][0]);
				}else{
					$valPost = trim($_POST[$elname]);
				}
				
				$isRequire 	= (isset($elval['required']) AND $elval['required'] == 1 AND !empty($valPost)) ? 1 : 0;
				$noRequire	= (!isset($elval['required']) OR $elval['required'] == 0) ? 1 : 0;
				
				if( $isRequire OR $noRequire ) {			
					// chech validation email
					if(isset($elval['emailvalid']) AND $elval['emailvalid'] == 1){
						if(!$this->isValidEmail($_POST[$elname])){
							$this->errorFields[$elkey] = $elkey;
							$this->errorMessage = "Email not valid!";	
							$this->haveError = true;

							continue;
						}
					}

					if(isset($elval['phonevalid']) AND $elval['phonevalid'] == 1){
						if(!$this->isValidPhone($_POST[$elname])){
							$this->errorFields[$elkey] = $elkey;
							$this->errorMessage = "Phone number not valid!";	
							$this->haveError = true;

							continue;
						}
					}

					if( (isset($elval['ignore']) AND $elval['ignore'] == 1) OR $elval['type']=='limiter'):
					
					else:	
						if($elval['type'] == 'inputfiles'){
							
							if($_FILES[$elname]['name'] != ""):
							
								$this->is_upload =	array	(
																"type"		=> $elval['allow'],
																"files" 	=> $_FILES[$elname],
																"folder"	=> $elval['dest'],
																"rows_name"	=> $elval['dataname']
															);
							else:
								$this->is_upload = false;
							endif;
														
						}elseif(is_array($_POST[$elname])){
							$dataField[$elname] = base64_encode(serialize($_POST[$elname]));
						}else{
							$dataField[$elname] = $_POST[$elname];
						}
					endif;
				}else{
					$this->errorFields[$elkey] = $elkey;
					$this->errorMessage = "Required information cannot be left blank!";	
					$this->haveError = true;
				}
			}
			
			
			if($this->haveError == true OR !empty($builder['action']))
				return; //goto BYPASS;
				
			/* jika method yang terdeteksi adalah insert */
			if($builder['method'] == "insert"){	
				$this->insert_prosses ($builder, $dataField);	
			}
			
			/* jika method yang terdeteksi adalah update */
			if($builder['method'] == "update"){	
				/* cek apakah ada kesalaha dalam pembuatan variable builder */
				if(!isset($builder['conedit'])) 
					$this->error_message(1);
				
				$this->update_prosses ($builder, $dataField);	
			}			
		}		
		
		// BYPASS: ;
	}
	
	function insert_prosses ($builder, $dataField){
		/* set up insert prosses */		
		$message= array (
							"log" => $builder['prosesname']." Successfully",
							"success" => $builder['prosesname']." Successfully",
							"failed" => $builder['prosesname']." Failed"
						);
						
		if($this->is_upload != false){
			$upload = $this->is_upload;
		}else{
			$upload = null;
		}
		
		$mysql_id = insert_data($builder['datatable'], $dataField, $upload, $message, true, true);
		if($mysql_id){
			$this->MYSQLID = $mysql_id;
			$this->isSuccess = true;
			$this->haveError = false;
			$this->errorMessage = $message['success'];
			$_SESSION['posttoken'] = $_POST['posttoken'];
			$this->postActive= false;
		}else{
			$this->haveError = true;
			$this->errorMessage = $message['failed'];
		};	
	}
	
	function update_prosses ($builder, $dataField){
		/* set up update prosses */
		$tmpWhere = array();
		foreach($builder['conedit'] as $rows => $value)
			$tmpWhere[] = $rows. " = '".$value."' ";
		
		$table	= array	(
					"table_name" => $builder['datatable'],
					"where"	=> implode('AND',  $tmpWhere)
				);				

		if($this->is_upload != false){
			$upload = $this->is_upload;
		}else{
			$upload = null;
		}
		
		$message= array (
							"log" => $builder['prosesname']." Successfully",
							"success" => $builder['prosesname']." Successfully",
							"failed" => $builder['prosesname']." Failed"
						);
		
		if(update_data($table, $dataField, $upload, $message, true)){
			$this->isSuccess = true;
			$this->haveError = false;
			$this->errorMessage = $message['success'];
			$_SESSION['posttoken'] = $_POST['posttoken'];
		}else{
			$this->haveError = true;
			$this->errorMessage = $message['failed'];
		};	
	}
	
	function error_message ($code, $message=null) {
		/* error kesalahan pada pembuatan variable builder */
		if($code == 1){
			die("<div style='color:red;width:800px; margin:0 auto; padding:10px; border:red 1px solid; text-align:center;'>
					Kesalahan dalam pengiriman parameter untuk form builder. Silahkan cek kembali variable builder anda.
				</div>");
		}
	} 
}

$simpleFormBuilder = new simpleFormBuilder;