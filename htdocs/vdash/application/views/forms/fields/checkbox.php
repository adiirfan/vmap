<?php
$name = $field->get_name();
$options = $field->get_options();
$selected_options = $field->get_selected_options();
$label_position = $field->get_label_position();
$layout = $field->get_layout();

foreach ( $options as $value => $text ) {
	$id = $name . '-' . $value;
	$attribute_string = preg_replace('/id\=\"[^\"]+\"/', 'id="' . $id . '"', $html_attribute);
	$option_attributes = $field->get_option_attribute_html($value);
	
	if ( false !== $selected_options && in_array($value, $selected_options) ) {
		if ( !is_empty($attribute_string) ) {
			$attribute_string .= ' ';
		}
		$attribute_string .= 'checked="checked"';
	}
	
	$attribute_string .= $option_attributes;
	
	$label = '<label for="' . $id . '">' . $text . '</label>';
	$checkbox = '<input type="checkbox" name="' . $name . '[]" value="' . $value . '" ' . $attribute_string . ' />';
	
	if ( $label_position == 'before' ) {
		echo $label . PHP_EOL;
		echo $checkbox . PHP_EOL;
	} else {
		echo $checkbox . PHP_EOL;
		echo $label . PHP_EOL;
	}
	
	if ( $layout == 'list' ) {
		echo '<br />';
	}
}
?>
