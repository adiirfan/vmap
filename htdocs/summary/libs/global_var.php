<?php 
		
	$uri_2 = explode("/",$uri);
   	$jumlah_uri = count($uri_2);
	$urilengkap = ''; 
	for($i=0;$i<$jumlah_uri-1;$i++)
	{
		$$uri_2[$i]  = $uri_2[$i+1];
		$urilengkap .= $uri_2[$i].'/';
	}
	
	if(!isset($lang)) $lang = "id";

	$smarty = new Smarty_Class();
	$smarty->assign("lang",$lang);
	$smarty->assign("webpath",TEMP_PATH);
	$smarty->assign("sitename",SITE_NAME);
	$smarty->assign("sitepath",SITE_PATH);
	$smarty->assign("website",SITE_URL);
	$smarty->assign("uploadlink",rtrim(MEDIA_READ_DIR, "/").'/');
	$smarty->assign("image_read_dir",rtrim(IMAGE_READ_DIR, "/").'/');
	$smarty->assign("template_read",rtrim(TEMPLATE_IMG, "/").'/');
	$smarty->assign("urlnow","http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
	
	$referer = @$_SERVER["HTTP_REFERER"];
	$smarty->assign("back",$referer);
	$smarty->assign("urilengkap",$urilengkap);
		
	$smarty->register_modifier('smartyobject', 'smartyobject');
	$smarty->register_modifier('showimage', 'sh_icon');
	$smarty->register_modifier('socmedcounter', 'socmedcounter');
	$smarty->register_modifier('base64_encode', 'base64_encode');
	$smarty->register_modifier('ss', 'stripslashes');
	$smarty->register_modifier('trim', 'trim');
	$smarty->register_modifier('strip_tags', 'strip_tags');
	$smarty->register_modifier('ucwords', 'ucwords');
	$smarty->register_modifier('strtolower', 'strtolower');    
	$smarty->register_modifier('rep_text', 'replace_text');
	$smarty->register_modifier('makeClean', 'makeClean');
	$smarty->register_modifier('valid_url', 'valid_url');
	$smarty->register_modifier("short_desc", 'short_desc');
	$smarty->register_modifier("middle_desc", 'middle_desc');
	$smarty->register_modifier("htmlspc", 'htmlspecialchars');
	$smarty->register_modifier("sanitize", 'sanitize');
	$smarty->register_modifier("text_safe_for_js", 'text_safe_for_js');
	$smarty->register_modifier("rp", 'convert_rp');
	$smarty->register_modifier("cetak", 'cetak');
	$smarty->register_modifier("eventyear", 'eventyear');
	$smarty->register_modifier("corrent_link", 'corrent_link');
	
   // $smarty->assign("is_clean",IS_CLEAN);
		
	if(!isset($msg))
	{
		if(isset($_GET['msd']))
			$msg = urldecode($_GET['msg']);
		else
			$msg = "";
	}
	
  $smarty->assign("msg",urldecode($msg));
  $smarty->assign("year", date('Y'));
  $smarty->assign("datenow",date('Y-m-d'));
  
  $tanggalplus1 = date('d') + 1;
  $tanggalplus1 = date('Y-m') .'-'. $tanggalplus1;
  $smarty->assign("datenowplus1",$tanggalplus1);
  
		
?>