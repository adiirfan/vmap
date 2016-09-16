<div class="box">
	<h2 class="page-title">
		<?php if ( isset($page_title) && !is_empty($page_title) ): ?>
		<?php echo $page_title; ?>
		<?php endif; ?>
		
		<?php
		if ( isset($action_buttons ) && iterable($action_buttons) ) {
		?>
		<div class="pull-right">
		<?php
			foreach ( $action_buttons as $button ) {
				$button_style = array_ensure($button, 'type', 'default');
				$link = array_ensure($button, 'url', '#');
				$icon = array_ensure($button, 'icon', '');
		?>
			<a href="<?php echo $link; ?>" class="btn btn-<?php echo $button_style; ?>">
				<?php if ( !is_empty($icon) ): ?>
				<i class="<?php echo $icon; ?>"></i>
				<?php endif; ?>
				<?php echo array_ensure($button, 'label', '');?>
			</a>
		<?php
			}
		?>
		</div>
		<?php
		}
		?>
	</h2>
	
	<?php if ( isset($filter_form) || isset($per_page_options) ): ?>
	<div class="row">
		<div class="col-md-10">
			<?php
			if ( isset($filter_form) && !is_empty($filter_form) ) {
				echo $filter_form;
			}
			?>
		</div>
		<?php if ( isset($per_page_options) ): ?>
		<div class="col-md-2 form-inline text-right">
			# <?php echo lang('entries'); ?>
			<select class="form-control" id="per-page">
				<?php
				$this->template->set_js('~/js/list_per_page.js');
				
				foreach ( $per_page_options as $count ) {
					$selected = '';
					
					if ( $count == $this->input->get('per_page') ) {
						$selected = ' selected="selected"';
					}
					echo '<option value="' . $count . '"' . $selected . '>' . $count . '</option>';
				}
				?>
			</select>
		</div>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	
	<?php
	if ( isset($list) && !is_empty($list) ) {
		echo $list;
	}
	?>
</div>