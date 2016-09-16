<?php 
function getFilenameWithoutExt($filename, $returnName=false, $eraseUnderScore=false){
    $filename = basename($filename);
	
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
	
	if($eraseUnderScore)
		$name = str_replace("_", " ", $name);
	
	if($returnName)
		return $name;
	
	$file_info = Array(
			0 => $name,
			1 => $ext);
			
	return $file_info;
	
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

function cetak($string,$output='')
{
	$s = isset($output) ? $output : '';
	$cetak = !empty($string) ? stripslashes($string) : $s;
	echo $cetak;
}

function get_content($url)  
{  
	$ch = curl_init();     
    curl_setopt ($ch, CURLOPT_URL, $url);  
    curl_setopt ($ch, CURLOPT_HEADER, 0);  
   
    ob_start();  
   
    curl_exec ($ch);  
    curl_close ($ch);  
    $string = ob_get_contents();  
   
    ob_end_clean();  
      
    return $string;      
   
}  

function replace_text($text)
{
	$text=strtolower(preg_replace('/[^A-Za-z0-9_]/', '-', $text));
	return $text;
}

function makeClean($string)
{
	if(IS_CLEAN==1)
	{
		$find = array("/?","=","&");
		$string = str_replace($find,"/",$string);
	}
	return $string;
}

function curPageURL() 
{
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") 
	{
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	}
	else 
	{
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

function sanitize($string)
{
  $str = str_replace(array("'",'"'),'',strip_tags($string));
  $str = mysql_real_escape_string($str);
  return $str;
}

function valid_url($url)
{
 $link = htmlspecialchars($url);
 if(substr($link,0,4) <> 'http'){ $link = 'http://'.$link; }
 return $link;
}

function mark_key($x,$y)
{
   $str = explode(' ',$y);
  
   $str_x = ' ';
  
   foreach($str as $strnya){
     
	 $char = strtolower($x);
	 $cuari = trim(str_replace(array(',','"'),' ',strtolower($strnya)));
	 
	 if($char <> ''){ 
	 unset($pos);
	 $len  = strlen($char);
	 $pos  = strpos($cuari,$char);
	 //echo 'kata = '.$cuari.' Char ='.$char.' POS ='.$pos.'<br>';

	 if($pos > -1){
		 //echo 'Pos is not null = '.$pos.'<br>';
		 
		 $awal   = substr($cuari,0,$pos);
		 
		 if($pos<1){
		 $tengah = '<span style="color:#FB0601; font-weight:bold;">'.ucwords(substr($cuari,$pos,$len)).'</span>';
		 }else{
		 $tengah = '<span style="color:#FB0601; font-weight:bold;">'.substr($cuari,$pos,$len).'</span>';
		 }
	 
		 if($pos<1){
		 $akhir  = substr($cuari,$len,100000);
		 }elseif($pos<2){
		   $akhir  = substr($cuari,($len+1),100000);
		 }else{
		   $akhir  = substr($cuari,($len+2),100000);
		 }
		 $strnya = $awal.$tengah.$akhir;
	   }else{ $strnya = $cuari; } //end if $pos
	 }
	 
	 $str_x .= $strnya . ' ';
   }
  return $str_x;
}

function short_desc($x)
{
  if(strlen($x) > 145){ $add = ' ...'; }
  $val = substr(strip_tags($x),0,145);
  return $val . $add;
}

function middle_desc($x)
{
  if(strlen($x) > 300){ $add = ' ...'; }
  $val = substr(strip_tags($x),0,300);
  return $val . $add;
}
 
function redirect($url = '')
 {
    if(!is_null($url)){ echo '<meta http-equiv="refresh" content="0; url='.$url.'"/>'; die; }
	else{ echo '<meta http-equiv="refresh" content="0; url='.WEBSITE.'"/>'; die; }
 } 
 
function text_safe_for_js($x)
{
   return preg_replace("/\r?\n/", "\\n", htmlspecialchars(addslashes(stripslashes($x))));
}
 
function convert_rp($val)
{
   $huruf = number_format($val,0,'','.');
   return 'Rp. '.$huruf.',-';
} 

function convert_bulan($x=1)
{
  switch($x)
   {
    case '1' : return 'Januari'; break;
	case '2' : return 'Februari'; break;
	case '3' : return 'Maret'; break;
	case '4' : return 'April'; break;
	case '5' : return 'Mei'; break;
	case '6' : return 'Juni'; break;
	case '7' : return 'Juli'; break;
	case '8' : return 'Agustus'; break;
	case '9' : return 'September'; break;
	case '10' : return 'Oktober'; break;
	case '11' : return 'November'; break;
	case '12' : return 'Desember'; break;
	default  : return 'Januari'; break;
   }
} 

function create_select_year($post_year = '')
{
  $select_year = '';
  $e = date('Y');
  
  $s = date('Y')-12;
  while($s<=$e)
		    { 
			  if($e==$post_year){
			  $select_year .='<option value="'.$e.'" class="opt4-'.$e.'" selected="selected">'.$e.'</option>';
			  }else{
			  $select_year .='<option value="'.$e.'" class="opt4-'.$e.'">'.$e.'</option>';
			  }
			  $e--;
	}
	return $select_year;	
}

function create_select_month($post_month='')
{
	$select_month = '';
	$s=1;
	$e=12;
  
	while($s<=$e)
		    { 
			  if($s==$post_month){
			  $select_month .='<option value="'.$s.'" class="opt3-'.$s.'" selected="selected">'.convert_bulan($s).'</option>';
			  }else{
			  $select_month .='<option value="'.$s.'" class="opt3-'.$s.'">'.convert_bulan($s).'</option>';
			  }
			  $s++;
	}
	return $select_month;	
}

function check_upload_cv($x)
{   
	switch($x)
	{
		case 'application/pdf':return true; break;	
		case 'application/excel':return true; break;																			   
		case 'application/msword':return true; break;
		default : return false;
	}
}

function check_email_address($email) {
	// First, we check that there's one @ symbol, 
	// and that the lengths are right.
	if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
		// Email invalid because wrong number of characters 
		// in one section or wrong number of @ symbols.
		return false;
	}
  
	// Split it into sections to make life easier
	$email_array = explode("@", $email);
	$local_array = explode(".", $email_array[0]);
	for ($i = 0; $i < sizeof($local_array); $i++) {
		if(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",$local_array[$i])) {
			return false;
		}
	}
	// Check if domain is IP. If not, 
	// it should be valid domain name
	if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2) {
			return false; // Not enough parts to domain
		}
		
		for ($i = 0; $i < sizeof($domain_array); $i++) {
			if(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$",
				$domain_array[$i])) {
				return false;
			}
		}
	}
	return true;
}

/* add by adhan duhriatna singgih - 30072012 */ 

function socmedcounter($link){
	return 	'<div class="fb-like" data-href="'.$link.'" data-send="false" data-layout="box_count" data-width="50" data-show-faces="false" data-font="arial"></div>					
			<div class="twiter-count"><a href="https://twitter.com/share" class="twitter-share-button" data-url="'.$link.'" data-count="vertical" data-text="custom title" data-size="35" >Tweet</a></div>
			<div class="gplus"><div class="g-plusone" data-size="tall" href="'.$link.'" ></div></div>';
}

function __autoload($class_name) {
	$class_name	= strtolower($class_name);
	$path 		= dirname(__FILE__)."/class/{$class_name}.php";
	if(file_exists($path)){
		require_once $path;
	}else{
		die("File {$class_name}.php tidak dapat ditemukan.");
	}
}

function setSEOonPage($page){
	global $uri_2, $smarty;
	$current= $uri_2[0];
	
	if(empty($current) OR $current == "" OR strtolower($current) == 'home' OR !isset($page[$current]))
		$current = 'default';

	$SEO	= data_general($page[$current]);
	
	$tmpKD	= my_unserialize($SEO->general_desc);
	
	$smarty->assign('page_title', $SEO->general_title);
	$smarty->assign('meta_keywords', $tmpKD[0]);
	$smarty->assign('meta_desc', $tmpKD[1]);
}


function paging4($total_page,$act_page,$url,$key='')
{
	$this_script = $url;
	$act_page = ($total_page < $act_page) ? $total_page : $act_page;
	$start_page = 1;
  /*$string = '<a class="pagination" style="text-decoration:none; color:#666666; font-size:12px;"  title="go to first page" href=" '.$this_script.$key.' 1" class="paging"> FIRST << </a>&nbsp;';	
if($act_page==1)
{$string="";}*/
  
	
	for($i=$start_page;$i<=$total_page;$i++)
	{
		if($i==$act_page)
			$string .= '<span style="font-weight:bold; color:#666666; font-size:14px;padding:4px 8px;background:white;"> '.$i.' </span>&nbsp;';
		else
			$string .= '<a id="my_text_link" style="text-decoration:none; color:#666666; font-size:14px;padding:4px 8px;background:white;" class="pagination" href=" '.$this_script.$key.$i.' " class="paging"> '.$i.' </a>&nbsp;';
	}
	
	/*if($total_page==$act_page)
      { return $string; }
	else if($total_page>=$act_page)
      { $string .= '<a style="text-decoration:none; color:#666666; font-size:12px;"  class="pagination" title="go to last page" href=" '.$this_script.$key.$total_page.' " class="paging"> >> LAST </a>'; }*/
	
	
	
	if($total_page == 1 OR $total_page == 0) return "&nbsp"; else return $string;
}



function load_template (){
	global $uri_2, $smarty, $DB, $listPage;
	/* untuk menampilkan file yang di minta di dalam template */
	if(trim($uri_2[0])=="" OR $uri_2[0]=="home"){
		if(file_exists(SITE_PATH."/default.php")){
			setSEOonPage($listPage);
			require_once("default.php");
		}else{
			die('file not found!');
		}
	}else{
		$files = $uri_2[0].".php";	
		if(file_exists(SITE_PATH."/".$files)){
			setSEOonPage($listPage);
			require_once($files);
		}else{
			$alias		= $uri_2[0];
			$pages		= array();			
			// get all pages
			$checkPage 	= data_grabber("tbl_general", "general_id, general_title, general_desc", " is_active = 1 AND (general_flag = 'simple-page') ", " is_order ASC ");
			foreach($checkPage as $general){
				$pages[replace_text($general->general_title)] = array	(
																			"title" 		=> $general->general_title,
																			"description"	=> stripslashes($general->general_desc)
																		);
			}
			
			if(isset($pages[$alias]) AND count($pages[$alias]) > 0){
				setSEOonPage($listPage);
				$fb = new frontendbuilder;
				$smarty->assign('open', $alias);
				$smarty->assign('navigation', $checkPage);
				$smarty->assign('overview', $fb->generalTemplate($pages[$alias]) );
				$smarty->assign('display', 'simple-page');
				$smarty->display("template.tpl");
			}else{
				header("location:".SITE_URL);
			}
		}
	}
}


if(file_exists(SITE_PATH."manager/include/function.php")) 
	include(SITE_PATH."manager/include/function.php");

?>