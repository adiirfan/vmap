<?php
$current_uri = current_uri();
if ( !preg_match('/\?/', $current_uri) ) {
	$current_uri .= '?';
} else {
	$current_uri .= '&';
}
?>
<div class="box">
	<h2 class="page-title">
		<?php echo lang('machine_group_list'); ?>
		
		<div class="pull-right">
			<a href="<?php echo site_url('machine_group/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> <?php echo lang('machine_group_add'); ?></a>
		</div>
	</h2>
	
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
			<?php
			if ( isset($filter_form) && !is_empty($filter_form) ) {
				echo $filter_form;
			}
			?>
		</div>
		<div class="col-md-2 form-inline text-right">
			# <?php echo lang('entries'); ?>
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
		</div>
	</div>
	
	<?php if ( isset($list) && !is_empty($list) ): ?>
	<?php echo $list; ?>
	<?php endif; ?>
</div>

<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="deleteMachineGroup" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('machine_group_delete_title'); ?></h4>
      </div>
      <div class="modal-body">
        <p>
          <?php echo lang('txt_machine_group_delete_confirmation'); ?>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('cancel'); ?></button>
        <button type="button" class="btn btn-danger" id="btn-delete"><?php echo lang('delete'); ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-manage-machines" tabindex="-1" role="dialog" aria-labelledby="manageMachine" aria-hidden="true" data-keyboard="false" data-show="false" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('machine_group_manage_machines'); ?></h4>
      </div>
      <div class="modal-body">
        <div class="result-body hidden">
        	<div class="search-box">
        		<div class="input-group search-input">
        			<input type="text" class="form-control search" placeholder="<?php echo lang('search'); ?>..." />
        			<span class="input-group-addon">
        				<i class="fa fa-search"></i>
        				<i class="fa fa-spinner fa-spin hidden"></i>
        			</span>
        		</div>
	        </div>
	        
	        <br />
	        
	        <div class="tabpanel">
		        <ul class="nav nav-tabs nav-justified" role="tablist">
		        	<li role="presentation" class="active" data-type="available">
		        		<a href="#mm-available" aria-controls="available" role="tab" data-toggle="tab"><?php echo lang('available'); ?> (<span class="available-count"></span>)</a>
		        	</li>
		        	<li role="presentation" data-type="selected">
		        		<a href="#mm-selected" aria-controls="available" role="tab" data-toggle="tab"><?php echo lang('selected')?> (<span class="selected-count"></span>)</a>
		        	</li>
		        </ul>
		        
		        <div class="tab-content">
			        <div class="tab-pane content content-available active" id="mm-available">
			        	<div class="result-blocks" data-toggle="slimscroll" data-height="200"></div>
			        </div>
			        <div class="tab-pane content content-selected" id="mm-selected">
			        	<div class="result-blocks" data-toggle="slimscroll" data-height="200"></div>
			       </div>
			    </div>
		    </div>
        </div>
        <div class="loading-box text-center">
        	<i class="fa fa-circle-o-notch fa-spin"></i> <?php echo lang('loading'); ?>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('cancel'); ?></button>
        <button type="button" class="btn btn-primary update-button"><?php echo lang('update'); ?></button>
      </div>
    </div>
  </div>
</div>