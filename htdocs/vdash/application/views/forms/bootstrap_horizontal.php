<?php if ( $form->has_error('_form') ) { ?>
<div class="alert alert-danger" role="alert">
	<i class="glyphicon glyphicon-warning-sign"></i>
	<?php echo $form->get_error_message('_form'); ?>
	<a class="glyphicon glyphicon-remove close" aria-hidden="true" data-dismiss="alert"></a>
</div>
<?php } else if ( $form->has_error() ) { ?>
<div class="alert alert-danger" role="alert">
	<i class="glyphicon glyphicon-warning-sign"></i>
	<?php echo lang('_form_error'); ?>
	<a class="glyphicon glyphicon-remove close" aria-hidden="true" data-dismiss="alert"></a>
</div>
<?php }; ?>


<form class="form-horizontal flexiwidth" role="form" name="<?php echo $form->get_name(); ?>"
	action="<?php echo site_url($form->get_action()); ?>"
	method="<?php echo $form->get_method(); ?>"
	enctype="<?php echo $form->get_enctype(); ?>"
	data-toggle="validator">

<?php echo $form->get_hidden_field_text(); ?>

<?php
foreach ( $form->get_fields() as $field ) {
	if ( $field instanceof Hidden ) {
		continue ;
	}
	
	$field_class = get_class($field);
	$field_name = $field->get_name();
	$field_id = $field->get_attribute('id');
	$field_label = $field->get_label();
	$has_error = $form->has_error($field_name);
	$has_tips = $field->has_tips();
	$tips_text = $field->get_tips();
	
	// Make sure the input field has the form-control class
	if ( in_array($field_class, array(
			'Text',
			'Textarea',
			'Dropdown',
			'Password',
			'Date',
			'Daterange',
			'Email',
		)
	)) {
		$css_class = $field->get_attribute('class');
		$css_class .= ' form-control';
		$field->set_attribute('class', $css_class);
	}
	
	$has_error_class = ($has_error ? ' has-error' : '');
	$has_tips_attr = ($has_tips ? ' data-toggle="tooltip" data-placement="top" title="' . htmlentities($tips_text) . '"' : '');
	$is_required = $field->has_rule('required');
	
	
?>
	<div class="form-group<?php echo $has_error_class; ?>">
		<label for="<?php echo $field_id; ?>" class="<?php echo $form->get_layout_data('col-label-width', 'col-sm-2'); ?> control-label"<?php echo $has_tips_attr; ?>>
			<?php
			if ( $is_required ) {
				echo '<span class="required">*</span> ';
			}
			?>
			<?php echo $field_label; ?>
			<?php if ( $has_tips ): ?>
			<i class="glyphicon glyphicon-question-sign"></i>
			<?php endif; ?>
		</label>
		<div class="<?php echo $form->get_layout_data('col-field-width', 'col-sm-10'); ?>">
			<?php echo $field->render(); ?>
			
			<?php if ( $has_error ): ?>
			<span class="text-danger">
				<?php echo $form->get_error_message($field_name); ?>
			</span>
			<?php endif; ?>
			
			<div class="help-block with-errors"></div>
		</div>
	</div>
	<?php
	}
	?>
	
	<?php
	if ( $form->has_captcha() ) {
		$has_error = $form->has_error('_captcha');
	?>
	<div class="form-group">
		<div class="<?php echo $form->get_layout_data('col-field-width', 'col-sm-10'); ?>">
			<?php echo $form->get_captcha()->render(); ?>
			<?php if ( $has_error ): ?>
			<span class="text-danger">
				<?php echo $form->get_error_message('_captcha'); ?>
			</span>
			<?php endif; ?>
		</div>
	</div>
	<?php
	}
	?>
	
	<div class="form-group">
		<div class="<?php echo $form->get_layout_data('col-label-width', 'col-sm-2'); ?>"></div>
		<div class="<?php echo $form->get_layout_data('col-field-width', 'col-sm-10'); ?>">
			<button type="submit" class="btn btn-primary">
				<?php echo $form->get_submit_label(); ?>
			</button>
			<?php if ( $form->get_reset_button() ): ?>
			<button type="reset" class="btn btn-success">
				<?php echo $form->get_reset_label(); ?>
			</button>
			<?php endif; ?>
			
			<?php
			if ( method_exists($form, 'get_buttons') ) {
				$buttons = $form->get_buttons();
				
				if ( iterable($buttons) ) {
					foreach ( $buttons as $button ) {
						$label = array_ensure($button, 'label', '');
						$button_type = array_ensure($button, 'type', 'default');
						$link = array_ensure($button, 'link', '#');
						$icon = array_ensure($button, 'icon', '');	// It has to be full class name.
						
						echo '<a href="' . $link . '" role="button" class="btn btn-' . $button_type . '">';
						
						if ( !is_empty($icon) ) {
							echo '<i class="' . $icon . '"></i> ';
						}
						
						echo htmlentities($label);
						echo '</a> ';
					}
				}
			}
			?>
		</div>
	</div>

</form>