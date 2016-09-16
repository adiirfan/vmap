<?php
/**
 * Default form layout.
 * You can use $form object referencing to generate
 * your form layout.
 */
?>

<?php echo $form->form_open(); ?>

<?php echo $form->get_hidden_field_text(); ?>

<?php if ( $form->has_error('_form') ): ?>
<div class="error"><?php echo $form->get_error_message('_form'); ?></div>
<?php endif; ?>
<table class="form">
	<?php foreach ( $form->get_fields() as $field ): ?>
	<?php $field_name = $field->get_name(); ?>
	<?php if ( $field instanceof Hidden ) { continue ; } ?>
	<tr>
		<th>
			<label for="<?php echo $field->get_attribute('id'); ?>"><?php echo $field->get_label(); ?></label>
			<?php if ( $field->has_tips() ): ?>
			<br />
			<span class="tips"><?php echo $field->get_tips(); ?></span>
			<?php endif; ?>
		</th>
		<td>
			<?php echo $field->render(); ?>
			<?php if ( $form->has_error($field_name) ): ?>
			<br />
			<div class="error"><?php echo $form->get_error_message($field_name); ?></div>
			<?php endif; ?>
		</td>
	</tr>
	<?php endforeach; ?>
	
	<?php if ( $form->has_captcha() ): ?>
	<tr>
		<th>Captcha</th>
		<td><?php echo $form->get_captcha()->render(); ?>
			<?php if ( $form->has_error('_captcha')): ?>
			<div class="error"><?php echo $form->get_error_message('_captcha'); ?></div>
			<?php endif; ?>
		</td>
	</tr>
	<?php endif; ?>
	
	<tr>
		<td colspan="2">
			<input type="submit" value="<?php echo $form->get_submit_label(); ?>" />
			<?php if ( $form->get_reset_button() ): ?>
			<input type="reset" value="<?php echo $form->get_reset_label(); ?>" />
			<?php endif; ?>
		</td>
	</tr>
</table>

<?php echo $form->form_close(); ?>