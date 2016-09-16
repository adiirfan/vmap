<?php
$name = $field->get_name();
$options = $field->get_options();
$field->get_selected_options();
?>

<select multiple="multiple" name="<?php echo $name?>[]" <?php echo $html_attribute; ?>>
	<?php
	if ( iterable($options) ) {
		foreach ( $options as $value => $text ) {
			$selected_text = '';
			$option_attributes = $field->get_option_attribute_html($value);
			
			if ( $field->is_option_selected($value) ) {
				$selected_text = ' selected="selected"';
			}
			
			echo '<option value="' . $value . '"' . $selected_text . $option_attributes .  '>' . $text . '</option>' . PHP_EOL;
		}
	}
	?>
</select>