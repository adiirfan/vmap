<input type="checkbox" name="<?php echo $field->get_name(); ?>" value="1"<?php
if ( $field->is_on() ) {
	echo ' checked ="checked"';
}

echo ' ' . $html_attribute;
?>
/>