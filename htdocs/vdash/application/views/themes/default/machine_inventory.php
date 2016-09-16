<?php
$current_uri = current_uri();
if ( !preg_match('/\?/', $current_uri) ) {
	$current_uri .= '?';
} else {
	$current_uri .= '&';
}

$sys_user_model = $this->authentication->get_model();
$sys_user_type = $sys_user_model->get_value('sys_user_type');
?>
<div class="box">
	<h2 class="page-title"><?php echo lang('machine_inventory'); ?></h2>
	
	<div class="export-controls left">
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-import">
			<i class="fa fa-download"></i> Import from CSV
		</button>
	</div>
	
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

<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('import_from_csv'); ?></h4>
      </div>
      <div class="modal-body">
        <p><?php echo lang('txt_app_inventory_import'); ?></p>
        <p>
        	<?php echo _lang('_txt_app_inventory_download_csv', base_url('machine_inventory_sample.csv')); ?>
        </p>
        
        <?php if ( $sys_user_type == 'superadmin' ): ?>
        <div class="input-group">
        	<span class="input-group-addon">
        		Choose a business to import:
        	</span>
	        <select id="dropdown-business-import" class="form-control">
	        	<?php
	        	$this->load->model('Business_model', 'business_model');
	        	$business_option_list = $this->business_model->get_option_list('business_id', 'business_name', array(
	        		'order_by' => array('business_name', 'asc'),
	        	));
	        	
	        	foreach ( $business_option_list as $business_id => $business_name ) {
	        		echo '<option value="' . $business_id . '">' . htmlentities($business_name) . '</option>' . PHP_EOL;
	        	}
	        	?>
	        </select>
	    </div>
        <?php endif; ?>
        
        <div id="file-container" class="file-container hidden">
        	<span class="file-name"></span>
        	<span class="file-size"></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
        <span class="btn btn-primary btn-upload">
        	<span><?php echo lang('browse'); ?>...</span>
        	<input type="file" id="btn-browse" name="csv_file" />
        </span>
        <button id="btn-upload" type="button" class="btn btn-success hidden">
        	<?php echo lang('upload'); ?>
        </button>
      </div>
    </div>
  </div>
</div>