<?php
$name = $field->get_name();
$options = $field->get_options();
$selected_options = $field->get_selected_options();
$label_position = $field->get_label_position();
$layout = $field->get_layout();


foreach ( $options as $value => $text ) {
	$id = $name . '-' . $value;
	$attribute_string = preg_replace('/id\=\"[^\"]+\"/', 'id="' . $id . '"', $html_attribute);
	
	if ( false !== $selected_options && in_array($value, $selected_options) ) {
		if ( !is_empty($attribute_string) ) {
			$attribute_string .= ' ';
		}
		$attribute_string .= 'checked="checked"';
	}
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
		<?php echo htmlentities($text); ?>
		<input type="checkbox" name="<?php echo $name; ?>[]" value="<?php echo $value; ?>" <?php echo $attribute_string; ?> />
		<?php else: ?>
		<input type="checkbox" name="<?php echo $name; ?>[]" value="<?php echo $value; ?>" <?php echo $attribute_string; ?> />
		<?php echo htmlentities($text); ?>
		<?php endif; ?>
	</label>
</div>
<?php
}
?>
