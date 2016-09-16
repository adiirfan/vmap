<?php
$CI =& get_instance();
$template = $CI->template;
$template->set_css('~/css/fullpage.css');
$system = $CI->system;
$messages = $system->get_message();

if ( iterable($messages) ) {
	foreach ( $messages as $message ) {
		$type = array_ensure($message, 'type', 'info');
		$icon = array_ensure($message, 'icon', '');
		$text = array_ensure($message, 'message', '');
		
		if ( $type == 'error' ) {
			$type = 'danger';
		}
		
		echo '<div class="alert alert-' . $type . '">';
		echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		
		
		if ( !is_empty($icon) ) {
			echo '<i class="' . $icon . '"></i>';
		}
		
		echo $text;
		
		echo '</div>';
	}
}
?>

<div class="fullpage">
	<div class="inner">
		<?php echo $content; ?>
	</div>
</div>