<div class="box">
	<?php if ( isset($form_title) && !is_empty($form_title) ): ?>
	<h2 class="page-title"><?php echo $form_title; ?></h2>
	<?php endif; ?>
	
	<?php echo $form; ?>
</div>