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
?>
<div class="checkbox<?php
if ( $layout == 'list' ) {
	echo ' list';
} else {
	echo ' inline';
}
?>">
	<label>
		<?php if ( $label_position == 'before' ): ?>
		<?php echo $text; ?>
		<input type="radio" name="<?php echo $field_name; ?>" value="<?php echo $value; ?>" <?php echo $html_attribute . $selected_text; ?> />
		<?php else: ?>
		<input type="radio" name="<?php echo $field_name; ?>" value="<?php echo $value; ?>" <?php echo $html_attribute . $selected_text; ?> />
		<span class="text"><?php echo $text; ?></span>
		<?php endif; ?>
	</label>
</div>
<?php
	}
	
	if ( $layout == 'inline' ) {
		echo '<div class="clear"></div>';
	}
}
?>