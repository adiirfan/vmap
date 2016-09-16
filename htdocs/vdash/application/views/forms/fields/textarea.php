<?php
$show_line_number = $field->get_show_line_number();
$html_attributes = $html_attribute;
if ( !is_empty($html_attributes) ) {
	$html_attributes .= ' ';
}

$html_attributes .= 'data-show-line-number="' . intval($show_line_number) .'"';
?>
<textarea name="<?php echo $field->get_name(); ?>" <?php echo $html_attributes; ?>><?php echo $field->get_value(); ?></textarea>