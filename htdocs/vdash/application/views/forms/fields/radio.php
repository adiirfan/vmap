<?php
$options = $field->get_options();
$field_name = $field->get_name();
$field_id = $field->get_attribute('id');
$label_position = $field->get_label_position();
$layout = $field->get_layout();

if ( iterable($options) ) {
	foreach ( $options as $value => $text ) {
		$selected_text = ($field->is_option_selected($value) ? ' checked="checked"' : '');
		
		// Replace the html attribute's ID with the custom ID.
		$option_id = $field_id . '-' . $value;
		$html_attribute = preg_replace('/id=\"[^\"]+\"/', 'id="' . $option_id . '"', $html_attribute);
		$option_attributes = $field->get_option_attribute_html($value);
		
		$radio_button = '<input type="radio" name="' . $field_name . '" ' . $html_attribute . $selected_text . $option_attributes . ' value="' . $value . '" />';
		$label = '<label for="' . $option_id . '">' . $text . '</label>';
		
		if ( $label_position == 'before' ) {
			echo $label . PHP_EOL;
			echo $radio_button . PHP_EOL;
		} else {
			echo $radio_button . PHP_EOL;
			echo $label . PHP_EOL;
		}
		
		if ( $layout == 'list' ) {
			echo '<br />';
		}
	}
}
?>