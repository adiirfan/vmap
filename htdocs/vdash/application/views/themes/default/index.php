<?php
$CI =& get_instance();
$template = $CI->template;
?><!doctype html>
<html lang="en">
	<head>
		<?php echo $template->html_header('meta'); ?>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="stylesheet" type="text/css" href="!/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="!/css/bootstrap-theme.min.css" />
		
		<link rel="stylesheet" type="text/css" href="~/css/style.css" />
		<link rel="stylesheet" type="text/css" href="~/css/swc.css" />
		<?php echo $template->html_header('css'); ?>
		
		<?php
		if ( $template->is_script_exists('~/css/override.css') ) {
		?>
		<link rel="stylesheet" type="text/css" href="~/css/override.css" />
		<?php
		}
		?>
	</head>
	
	<body>
		<?php echo $content; ?>
		
		<script>
		var baseurl = "<?php echo site_url(''); ?>";
		var clientId = "<?php echo $CI->system->get_client_id(); ?>";
		</script>
		<script type="text/javascript" src="!/js/jquery.min.js"></script>
		<script type="text/javascript" src="!/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="~/js/extends.js"></script>
		<script type="text/javascript" src="~/js/swc.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script>
		<?php echo $template->html_header('js'); ?>
	</body>
</html>