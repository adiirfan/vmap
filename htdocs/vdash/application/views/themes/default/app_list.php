<?php
$current_uri = current_uri();
if ( !preg_match('/\?/', $current_uri) ) {
	$current_uri .= '?';
} else {
	$current_uri .= '&';
}
?>
<div class="box">
	<h2 class="page-title"><?php echo lang('app_list'); ?></h2>
	
	<div class="export-controls">
		<a href="<?php echo site_url($current_uri . 'export=csv'); ?>" class="btn-export" target="_blank">
			<i class="fa fa-file-excel-o"></i>
			<?php echo lang('csv'); ?>
		</a>
		<a href="<?php echo site_url($current_uri . 'export=pdf'); ?>" class="btn-export" target="_blank">
			<i class="fa fa-file-pdf-o"></i>
			<?php echo lang('pdf'); ?>
		</a>
		<div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>
	
	<div class="row">
		<div class="col-md-10">
			<?php echo $filter_form; ?>
		</div>
		<div class="col-md-2 form-inline">
			<?php echo lang('show'); ?>
			<select class="form-control" id="per-page">
				<?php
				foreach ( $per_page_options as $count ) {
					$selected = '';
					
					if ( $count == $this->input->get('per_page') ) {
						$selected = ' selected="selected"';
					}
					echo '<option value="' . $count . '"' . $selected . '>' . $count . '</option>';
				}
				?>
			</select>
			<?php echo strtolower(lang('entries')); ?>
		</div>
	</div>
	<?php echo $list; ?>
</div>