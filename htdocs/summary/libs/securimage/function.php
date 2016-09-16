<?php 
function check_user_agent()
{
	//if(preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|sagem|sharp|sie-|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT']))
	if(preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipaq|ipod|j2me|java|midp|mini|mmp|motorola|nec-|nokia|palm|panasonic|philips|phone|sagem|sharp|sie-|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT']))
        return true;
 
    else
        return false;
}
function myTruncate($string, $limit, $break=".", $pad="...") { 
			// return with no change if string is shorter than $limit  
			if(strlen($string) <= $limit) return $string; 
				// is $break present between $limit and the end of the string?  
				if(false !== ($breakpoint = strpos($string, $break, $limit))) 
				{ 
					if($breakpoint < strlen($string) - 1) 
					{ 
						$string = substr($string, 0, $breakpoint) . $pad; 
					} 
				}
				return $string;
			}

function getFilenameWithoutExt($filename){
    $filename = basename($filename);
    //$pos = strripos($filename, '.');
	
	$raw_ext = explode(".",$filename);
	
	$count = count($raw_ext);
	
	$name = "";
	if($count>1)
	{
		for($i=0;$i<$count;$i++)
		{
			if($i < $count-1)
				$name .= $raw_ext[$i];
			else
				$ext = $raw_ext[$i];
		}
	}
	
	$file_info = Array(
			0 => $name,
			1 => $ext);
			
	return $file_info;
	
    /*if($pos === false)
	{
        return $filename;
    }
	else
	{
		$name = substr($filename, 0, $pos);
		$ext = substr(strrchr($filename, '.'), 1);
		
		$file_info = Array(
			0 => $name,
			1 => $ext);
		
        return $file_info;
    }*/
}

function addLog($message)
{
	
	$user_id = !empty($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 1 ;
	$user_name = $_SESSION['user']['name'];
	$log_message = $message . " by " . $user_name;
	$ip = $_SERVER['REMOTE_ADDR'];
	$log_date = CURRENT_TIME;
	

	$query = "INSERT INTO tbl_log (log_action,log_date,user_id,log_ip) VALUES ('$log_message','$log_date',$user_id,'$ip')";
	$hasil = mysql_query($query)
		or die(mysql_error());
}
function addLogMember($message,$MemberID)
{
	
	$user_id = !empty($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 1 ;
	$user_name = $_SESSION['user']['name'];
	$log_message = $message . " by " . $user_name;
	$ip = $_SERVER['REMOTE_ADDR'];
	$log_date = CURRENT_TIME;

	$query = "INSERT INTO tbl_memberlog (log_action,log_date,user_id,log_ip,MemberID) VALUES ('$log_message','$log_date',$user_id,'$ip','$MemberID')";
	$hasil = mysql_query($query)
		or die(mysql_error());
}
function get_time_difference( $start, $end )
{
    $uts['start']      =    strtotime( $start );
    $uts['end']        =    strtotime( $end );
    if( $uts['start']!==-1 && $uts['end']!==-1 )
    {
        if( $uts['end'] >= $uts['start'] )
        {
            $diff    =    $uts['end'] - $uts['start'];
            if( $days=intval((floor($diff/86400))) )
                $diff = $diff % 86400;
            if( $hours=intval((floor($diff/3600))) )
                $diff = $diff % 3600;
            if( $minutes=intval((floor($diff/60))) )
                $diff = $diff % 60;
            $diff    =    intval( $diff );            
            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
        }
        else
        {
            trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
        }
    }
    else
    {
        trigger_error( "Invalid date/time data detected", E_USER_WARNING );
    }
    return( false );
}

function checkPrivilege($moduleName,$privilege)
{
	$cat = intval($_SESSION['user']['category_id']) ? $_SESSION['user']['category_id'] : 0;
	if($cat!=1)
	{
		$query = "SELECT c.privilege_value FROM tbl_privilege a INNER JOIN tbl_module b ON b.module_id=a.module_id INNER JOIN tbl_user_privilege c ON c.privilege_id = a.privilege_id WHERE c.user_category_id=".$cat." AND LCASE(b.module_name)='".strtolower($moduleName)."' AND LCASE(a.privilege_name)='".strtolower($privilege)."'";
		$hasil = mysql_query($query)
			or die(mysql_error());
		$rs = mysql_fetch_array($hasil);
		$priv = array();
		$priv['privilege_value'] = !empty($rs['privilege_value']) ? 1 : 0;
	}
	else
	{
		$priv['privilege_value'] = 1;
	}
	return $priv;
}

function checkPrivilege2($moduleName,$privilege)
{
	$cat = intval($_SESSION['user']['category_id']) ? $_SESSION['user']['category_id'] : 0;
	if($cat!=1)
	{
		$query = "SELECT c.privilege_value FROM tbl_privilege a INNER JOIN tbl_module b ON b.module_id=a.module_id INNER JOIN tbl_user_privilege c ON c.privilege_id = a.privilege_id WHERE c.user_category_id=".$cat." AND LCASE(b.module_name)='".strtolower($moduleName)."' AND LCASE(a.privilege_name)='".strtolower($privilege)."'";
		$hasil = mysql_query($query)
			or die(mysql_error());
		$rs = mysql_fetch_array($hasil);
		$priv = 0;
		$priv = !empty($rs['privilege_value']) ? 1 : 0;
	}
	else
	{
		$priv = 1;
	}
	return $priv;
}

function cetak($string,$output='')
{
	$s = isset($output) ? $output : '';
	$cetak = !empty($string) ? stripslashes($string) : $s;
	echo $cetak;
}


function getAlias($name)
{
	$alias=preg_replace('/[^A-Za-z0-9_]/', '', $name);
	$query = "SELECT alias_id from tbl_alias where alias_name='$alias'";
	$hasil = mysql_query($query)
			or die(mysql_error());
	$rs = mysql_fetch_array($hasil);
	$result = !empty($rs['alias_id']) ? 1 : 0;
	
	return $result;
}

function replace_text($text)
	{
		$text = trim($text);
		$text = strip_tags($text);
		$text = str_replace("@","a",$text);
		$text=preg_replace('/[^A-Za-z0-9_.]/', '-', $text);
		$text = str_replace(" ","-",$text);
		return $text;
	}
function getLinkTitle($title){
	$link	= str_replace(" ","-",strtolower($title));
	return $link;
}
function getHeader($id){
	global $DB;
	$query	= "select * from tbl_header where header_id='".$id."'";
	$data	= $DB->getData($query);
	return $data[0]['header_path'];
}

function getSeo($id){
	global $DB;
	$query	= "select seo_title, seo_keyword,seo_description from tbl_seo where seo_id = '".$id."' ";
	$data	= $DB->getData($query);
	$title  = $data[0]['seo_title'];
	//$keydesc = unserialize(base64_decode($data[0]['general_desc']));
	$keyword = $data[0]['seo_keyword'];
	$desc	 = $data[0]['seo_description'];
	$data_seo= array($title, $keyword, $desc);
	return $data_seo;
}

function validEmail($mail){
	if(!preg_match('/^(?:[\w\d]+\.?)+@(?:(?:[\w\d]\-?)+\.)+\w{2,4}$/i', $mail))
		return false;
	else
		return true;
}

function submitForm($arr_post,$table){
	global $DB;
	$i	= 0; $err_field	= ""; $error = 0;$captcha	= "";
	$_SESSION['ctform'] = "";
	$_SESSION['status'] = false;
	$_SESSION['form_message'] = "";
	$_SESSION['captcha_error'] = "";
	
	foreach($arr_post as $temp){
		if($temp['required'] && empty($temp['value'])){
			$error++;
		}elseif($temp['required'] && !empty($temp['value'])){
			if($temp['type'] == "text" && strlen($temp['value'])<=4){
				if(strlen($temp['value'])< intval($temp['char'])){
					$error++;
				}
			}elseif($temp['type'] == "number" && !is_numeric($temp['value']) || (is_numeric($temp['value']) && strlen($temp['value'])<=4)){
				if(strlen($temp['value'])< intval($temp['char'])){
					$error++;
				}
			}elseif($temp['type'] == "email" && !preg_match('/^(?:[\w\d]+\.?)+@(?:(?:[\w\d]\-?)+\.)+\w{2,4}$/i', $temp['value'])){
				$error++;
			}
			
		}elseif(!empty($temp['value'])){
			if($temp['type'] == "text" && strlen($temp['value'])<=4){
				if(strlen($temp['value'])< intval($temp['char'])){
					$error++;
				}
			}elseif($temp['type'] == "number" && !is_numeric($temp['value']) || (is_numeric($temp['value']) && strlen($temp['value'])<=4)){
				if(strlen($temp['value'])< intval($temp['char'])){
					$error++;
				}
			}elseif($temp['type'] == "email" && !preg_match('/^(?:[\w\d]+\.?)+@(?:(?:[\w\d]\-?)+\.)+\w{2,4}$/i', $temp['value'])){
				$error++;
			}
		}
		if($error > 0){
			$err_field .= $temp['visible_name']."#";
		}
		$_SESSION['ctform'][$temp['name']]	= $temp['value'];
		
		if($temp['type'] == 'captcha'){
			
			require_once  'securimage.php';
			$securimage = new Securimage();
			
			if ($securimage->check($temp['value']) == false) {
				$_SESSION['captcha_error'] = 'Incorrect security code entered';
			}
		}
		$error = 0;
		
	}

	if(!empty($err_field) || !empty($_SESSION['captcha_error'])){
		if(!empty($err_field)){
			$_SESSION['form_message'] = "please fill out this field : ".str_replace("#",", ",trim($err_field));
		}
		$_SESSION['status'] = false;
	}else{
		$query	= "";$values = "";
		foreach($arr_post as $temp){
			if($temp['type'] != 'captcha'){
				$query	.= "c_".$temp['name']." ";
				$values	.= "'".mysql_real_escape_string(strip_tags($temp['value']))."'#-";
			}
		}
		$query	= str_replace(" ",",",trim($query));
		$values	= str_replace("#-",",",(trim($values)));
		$exec	= "insert into ".$table." (".$query.",c_inputdtm,status) values (".$values."now(),'0')";
		$DB->Query($exec);
		$_SESSION['form_message'] = "Well done! Your message has been sent.";
		$_SESSION['status'] = true;
		$_SESSION['ctform'] = "";
		$_SESSION['captcha_error'] = "";
	}
}

function checkCaptcha($capca){
	require_once  'securimage.php';
	$securimage = new Securimage();
	
	if ($securimage->check($temp['value']) == false) {
		return false;
	}else{
		return true;
	}
	
}

function clearContentFCKFromWord($content){
	$search	= array("font-family","font-size","line-height");
	$replace= array("no-font-family","no-font-size","no-line-height");
	$content	= str_replace($search,$replace,$content);
	return strip_tags($content,"<p><a><b><i><u><strong><div><br><img><h1><h2><h3><h4><h5><h6><span><ul><ol><li><button><form><table><tbody><tr><td>");
}

function sendmail(){
	global $DB;
	$status	= true;
	require_once($_SERVER['DOCUMENT_ROOT'].'/libs/class/class.phpmailer.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/libs/class/class.smtp.php');
		
	$query	= "select * from tbl_contact where status='0' order by c_id desc limit 0,1";
	$data	= $DB->getData($query);
	
	$query	= "select * from tbl_contact_recipient order by contact_recipient_id desc";
	$recv	= $DB->getData($query);
	
	foreach($recv as $temp){
		$mail = new PHPMailer(); 
		$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mail->IsSMTP();  // telling the class to use SMTP
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = 'ssl://smtp.gmail.com';
		$mail->Port = 465; 
		 
		$mail->Username = 'rspi.group.2013@gmail.com';  
		$mail->Password = 'b4t4v14n3t';   
		$mail->From     = $data[0]['c_email'];
		$mail->FromName = $data[0]['c_name'];
		$mail->AddReplyTo($data[0]['c_email'],$data[0]['c_name']);
		$mail->WordWrap = 50;
		$mail->IsHTML(true);
		$mail->Subject  = "[Web Rumah Sakit Pondok Indah] CONTACT US";
		
		$isi_email = "	
			<table>
				<tr>
					<td>Name</td><td>:</td><td>".strip_tags(stripslashes($data[0]['c_name']))."</td>
					<td>Email</td><td>:</td><td>".strip_tags(stripslashes($data[0]['c_email']))."</td>
					<td>Mobile Phone</td><td>:</td><td>".strip_tags(stripslashes($data[0]['c_mobile_phone']))."</td>
					<td>Address</td><td>:</td><td>".strip_tags(stripslashes($data[0]['c_address']))."</td>
					<td>Message</td><td>:</td><td>".strip_tags(stripslashes($data[0]['c_message']))."</td>
				</tr>
			</table>
		";
		
		$receiver	= $temp['contact_recipient_email'];
		$mail->Body = $isi_email;
		$mail->AddAddress($receiver,'');
		if($mail->Send())
			$status	= true;
		else
			$status	= false;
		$mail->ClearAddresses();
		
		if($status){
			$query	= "update tbl_contact set status='1' where inquiry_id='".$data[0]['inquiry_id']."'";
			$DB->Query($query);
		}
	}
}


function mailqueue(){
	global $DB;
	$status	= true;
	
	//require_once($_SERVER['DOCUMENT_ROOT'].'/libs/class/class.smtp.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/libs/class/class.pop3.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/libs/class/class.phpmailer.php');
		
	$query	= "select * from tbl_mail_queue where mail_queue_status='0' order by mail_queue_id desc limit 0,1";
	$data	= $DB->getData($query);
	if(is_array($data) && count($data) > 0){	
		$isi_email = "'".stripslashes($data[0]['mail_queue_content'])."'";
		
		date_default_timezone_set('Etc/UTC');

		require_once($_SERVER['DOCUMENT_ROOT'].'/libs/class/PHPMailerAutoload.php');
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->IsHTML(true);
		$mail->setFrom("no-reply@rspondokindah.com", 'RSPI Group');
		$mail->addReplyTo("no-reply@rspondokindah.com", 'RSPI Group');
		$mail->addAddress($data[0]['mail_queue_to'], 'RSPI Group');
		$mail->AddBCC("arie.warlord@gmail.com"); 
		$mail->Subject  = stripslashes($data[0]['mail_queue_subject']);
		$mail->msgHTML($isi_email);
		$mail->AltBody = 'This is a plain-text message body';
		
		if ($data[0]['mail_queue_type'] == 'card'){
			//$mail->AddEmbeddedImage($data[0]['mail_queue_attach'], 'thumbimage', $data[0]['mail_queue_attach']);
			$mail->addAttachment($data[0]['mail_queue_attach']);
		}
		if(!empty($data[0]['mail_queue_to'])){
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo "Message sent!";
			$query	= "delete from tbl_mail_queue where mail_queue_id='".$data[0]['mail_queue_id']."'";
			$query	= "update tbl_mail_queue set mail_queue_status='1' where mail_queue_id='".$data[0]['mail_queue_id']."'";
			$DB->Query($query);
		}
		}
		/*
		$mail = new PHPMailer(); die("exist");
		 
		$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mail->IsSMTP();  // telling the class to use SMTP
		$mail->SMTPAuth = true;
		//$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
		//$mail->Host = //'smtp.telkom.net';//'smtp.gmail.com';
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587; 
		$mail->SMTPSecure = 'tls';
		$mail->Username = 'rspi.group.2013@gmail.com';  
		$mail->Password = 'b4t4v14n3t';   
		$mail->From     = $data[0]['mail_queue_from'];
		$mail->FromName = $data[0]['mail_queue_name'];
		$mail->AddReplyTo($data[0]['mail_queue_from'],$data[0]['mail_queue_name']);
		$mail->WordWrap = 50;
		$mail->IsHTML(true);
		
		if ($data[0]['mail_queue_type'] == 'card'){
			$mail->AddEmbeddedImage($data[0]['mail_queue_attach'], 'thumbimage', $data[0]['mail_queue_attach']);
		}else{}
		
		$isi_email = "'".stripslashes($data[0]['mail_queue_content'])."'";
		
		$receiver	= $data['mail_queue_to'];
		$mail->Body = $isi_email;
		$mail->AddAddress('arie.warlord@gmail.com','arie.warlord@gmail.com');
		
		if($mail->Send()){
			$status	= true;echo "sukses";
		}else{
			$status	= false;echo $mail->ErrorInfo;
		}
		$mail->ClearAddresses();
		
		
		
		if($status){
			$query	= "update tbl_mail_queue set mail_queue_id='1' where mail_queue_id='".$data[0]['mail_queue_id']."'";
			$DB->Query($query);
		}	
		/* 
		try{
			mail('arie.warlord@gmail.com', 'test RSPI', $isi_email);
			$query	= "delete from tbl_mail_queue where mail_queue_id='".$data[0]['mail_queue_id']."'";
			$DB->Query($query);
		
		}catch(Exception $e){ echo 'Message: ' .$e->getMessage();}
		*/
	}
	/*
	
	*/
}
?>