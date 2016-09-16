<h2 class="page-title"><?php echo lang('machine_group_detail'); ?></h2>

<div class="row">
	<div class="col-md-4">
		<div class="box">
			<div class="detail">
				<div class="detail-row">
					<div class="detail-label"><?php echo lang('machine_group_name'); ?></div>
					<div class="detail-info">
						<?php echo htmlentities($machine_group_data['machine_group_name']); ?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label"><?php echo lang('total_machines'); ?></div>
					<div class="detail-info">
						<span class="total-machines"><?php echo $total_machines; ?></span>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label"><?php echo lang('machine_group_desc'); ?></div>
					<div class="detail-info">
						<?php echo htmlentities(string_ensure($machine_group_data['machine_group_desc'], 'n/a')); ?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label"><?php echo lang('machine_group_top_app'); ?></div>
					<div class="detail-info">
						<?php echo string_ensure($most_apps, 'n/a'); ?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label"><?php echo lang('machine_group_top_machine'); ?></div>
					<div class="detail-info">
						<?php echo string_ensure($most_machines, 'n/a'); ?>
					</div>
				</div>
			</div>
			<br />
			<a href="<?php echo site_url('machine_group/edit/' . $machine_group_id); ?>" class="btn btn-default btn-sm">
				<i class="fa fa-edit"></i>
				<?php echo lang('edit'); ?>
			</a>
			<button type="button" class="btn btn-primary btn-sm" id="btn-manage-machines" data-machine-group-id="<?php echo $machine_group_id; ?>">
				<i class="fa fa-exchange"></i>
				<?php echo lang('machine_group_manage'); ?>
			</button>
			<button type="button" class="btn btn-danger btn-sm" id="btn-delete">
				<i class="fa fa-trash"></i>
				<?php echo lang('delete'); ?>
			</button>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="box">
			<h4 class="box-title"><?php echo lang('app_usage_information'); ?></h4>
			<div class="chart"
				data-name="app_usage_information"
				data-chart="piechart"
				data-data="<?php echo htmlentities(json_encode($app_usage_info)); ?>"
				data-columns="<?php echo htmlentities(json_encode(array(
					array('string', lang('app_name')),
					array('number', lang('instances')),
				))); ?>"
				data-options="<?php echo htmlentities(json_encode(array(
					'width' => '100%',
					'height' => '166',
					'chartArea' => array(
						'width' => '90%',
						'height' => '80%',
					),
				))); ?>"></div>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="box" style="min-height: 235px;">
			<h4 class="box-title"><?php echo lang('machine_usage_information'); ?></h4>
			<?php if ( isset($machine_usage_info) && iterable($machine_usage_info) ):?>
			<ul class="item-list item-list-inline">
				<?php foreach ( $machine_usage_info as $row ): ?>
				<li>
					<span class="item-title"><?php echo $row[0]; ?></span>
					<span class="item-info"><?php echo _lang('_sessions', $row[1]); ?></span>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php else: ?>
			<p class="text-danger"><?php echo lang('txt_no_machine_usage_info'); ?></p>
			<?php endif; ?>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="box">
			<h4 class="box-title"><?php echo lang('user_login_information'); ?></h4>
			<?php echo $user_login_list; ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box">
			<h4 class="box-title"><?php echo lang('app_usage_information'); ?></h4>
			<?php echo $app_usage_list; ?>
		</div>
	</div>
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
        <button type="button" class="btn btn-danger" id="btn-delete-confirm" data-machine-group-id="<?php echo $machine_group_id; ?>"><?php echo lang('delete'); ?></button>
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