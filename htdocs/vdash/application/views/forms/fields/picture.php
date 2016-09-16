<?php $thumb_url = $field->get_thumbnail_url(); ?>

<div class="picture-file">
	<?php if ( false !== $thumb_url ): ?>
	<div class="thumb">
		<img src="<?php echo $thumb_url; ?>" alt="<?php echo $field->get_value('name'); ?>" />
	</div>
	<?php endif; ?>
	<input type="file" name="<?php echo $field->get_name(); ?>" <?php echo $html_attribute; ?> />
</div>