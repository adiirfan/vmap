<?php
$name = $field->get_name();
$value = $field->get_value();

if ( is_empty($value) ) {
	$value = $field->get_data_attribute("min");
	
	if ( is_empty($value) ) {
		$value = 0;
	}
}
?>
<div class="slider">
	<div class="slider-bar"></div>
	<input type="text" name="<?php echo $name; ?>" value="<?php echo $value; ?>" <?php echo $html_attribute; ?> />
</div>