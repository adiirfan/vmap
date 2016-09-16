<?php
$system_date = $field->get_system_date();
$locale = $field->get_locale();
$data_locale = '';

if ( !is_empty($locale) ) {
	$data_locale = ' data-locale="' . $locale . '"';
}
?>
<div class="bootstrap-datepicker input-group">
	<div class="input-group">
		<input type="text" name="<?php echo $name; ?>[display]" <?php echo $html_attribute . $data_locale; ?> value="" autocomplete="off" />
		<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
	</div>
	<input type="hidden" name="<?php echo $name; ?>[system]" value="<?php echo $system_date; ?>" />
</div>