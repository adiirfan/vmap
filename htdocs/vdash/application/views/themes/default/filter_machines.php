<?php
$has_filters = (isset($filters) && iterable($filters));
$has_machine_group_list = (isset($machine_group_option_list) && iterable($machine_group_option_list));
$machine_group_list = '<option value="">- ' . lang('select_a_machine_group') . ' -</option>';

if ( $has_machine_group_list ) {
	foreach ( $machine_group_option_list as $val => $text ) {
		$machine_group_list .= '<option value="' . $val . '">' . htmlentities($text) . '</option>';
	}
}
?>
<div class="box">
	<h2 class="page-title">
		<?php echo lang('machine_filters'); ?>
		<?php if ( isset($business_option_list) && iterable($business_option_list) ): ?>
		<div class="pull-right form-inline">
			<select id="dropdown-business" class="form-control">
				<?php foreach ( $business_option_list as $id => $value ): ?>
				<?php $selected = ($this->input->get('business') == $id ? ' selected="selected"' : ''); ?>
				<option value="<?php echo $id; ?>"<?php echo $selected; ?>><?php echo htmlentities($value); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<?php endif; ?>
	</h2>
	<button class="btn btn-success" id="btn-create">
		<i class="fa fa-plus"></i>
		<?php echo lang('create_new_filter')?>
	</button>
	<button class="btn btn-default" id="btn-simulate">
		<i class="fa fa-cogs"></i>
		<?php echo lang('simulate')?>...
	</button>
	<button class="btn btn-default" id="btn-process">
		<i class="fa fa-tasks"></i>
		<?php echo lang('process')?>...
	</button>
	<br /><br />
	
	<div class="panel-group filter-list" id="filter-list" role="tablist" aria-multiselectable="true">
		<?php
		if ( $has_filters ) {
			foreach ( $filters as $filter ) {
				$filter_id = $filter['machine_filter_id'];
				$filter_name = htmlentities($filter['machine_filter_name']);
				$filter_machine_name = $filter['machine_filter_pc_name'];
				$filter_machine_ip_address = $filter['machine_filter_ip_address'];
				$filter_machine_mac_address = $filter['machine_filter_mac_address'];
				$filter_machine_group_assigned = intval($filter['machine_filter_group_assigned']);
				$filter_action = trim($filter['machine_filter_action']);
				$negate = ($filter['machine_filter_negate'] ? true : false);
				$on_success = $filter['machine_filter_on_success'];
				$on_fail = $filter['machine_filter_on_fail'];
		
		// Filter row template here.
		?>
		<div class="panel panel-default" data-filter-id="<?php echo $filter_id; ?>">
			<div class="panel-heading" role="tab" id="heading-<?php echo $filter_id; ?>">
				<h4 class="panel-title">
					<i class="fa fa-arrows-v sort-handle"></i>&nbsp;
					<a data-toggle="collapse" href="#collapse-<?php echo $filter_id; ?>"
						aria-expanded="false" aria-controls="collapse-<?php echo $filter_id; ?>">
						<span class="filter-name"><?php echo $filter_name; ?></span>
					</a>
				</h4>
			</div>
			<div id="collapse-<?php echo $filter_id; ?>" class="panel-collapse collapse" role="tabpanel"
				aria-labelledby="heading-<?php echo $filter_id; ?>">
				<div class="panel-body">
					<div class="detail detail-inline">
						<div class="detail-row">
							<div class="detail-label tips"
								data-toggle="tooltip"
								data-container="body"
								title="<?php echo lang('txt_filter_machine_name_tips'); ?>">
								<i class="fa fa-question-circle"></i> <?php echo lang('filter_machine_name_pattern'); ?>
							</div>
							<div class="detail-info">
								<span class="filter-pattern"><?php
								if ( is_empty($filter_machine_name) ) {
									echo 'n/a';
								} else {
									echo htmlentities($filter_machine_name);
								}
								?></span>
								<button type="button" class="btn btn-primary btn-sm filter-pattern-modify"
									data-filter-id="<?php echo $filter_id; ?>"
									data-filter-name="<?php echo htmlentities($filter_name); ?>"
									data-filter-pattern-name="machine_name"
									data-filter-pattern="<?php echo htmlentities($filter_machine_name); ?>"><?php echo lang('modify'); ?></button>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="detail-row">
							<div class="detail-label tips"
								data-toggle="tooltip"
								data-container="body"
								title="<?php echo lang('txt_filter_machine_ip_address_tips'); ?>">
								<i class="fa fa-question-circle"></i> <?php echo lang('filter_machine_ip_address_pattern'); ?>
							</div>
							<div class="detail-info">
								<span class="filter-pattern"><?php
								if ( is_empty($filter_machine_ip_address) ) {
									echo 'n/a';
								} else {
									echo htmlentities($filter_machine_ip_address);
								}
								?></span>
								<button type="button" class="btn btn-primary btn-sm filter-pattern-modify"
									data-filter-id="<?php echo $filter_id; ?>"
									data-filter-name="<?php echo htmlentities($filter_name); ?>"
									data-filter-pattern-name="ip_address"
									data-filter-pattern="<?php echo htmlentities($filter_machine_ip_address); ?>"><?php echo lang('modify'); ?></button>
							</div>
						</div>
						<div class="detail-row">
							<div class="detail-label">
								<?php echo lang('filter_machine_mac_address_pattern'); ?>
							</div>
							<div class="detail-info">
								<span class="filter-pattern"><?php
								if ( is_empty($filter_machine_mac_address) ) {
									echo 'n/a';
								} else {
									echo htmlentities($filter_machine_mac_address);
								}
								?></span>
								<button type="button" class="btn btn-primary btn-sm filter-pattern-modify"
									data-filter-id="<?php echo $filter_id; ?>"
									data-filter-name="<?php echo htmlentities($filter_name); ?>"
									data-filter-pattern-name="mac_address"
									data-filter-pattern="<?php echo htmlentities($filter_machine_mac_address); ?>"><?php echo lang('modify'); ?></button>
							</div>
						</div>
						<div class="detail-row">
							<div class="detail-label tips"
								data-toggle="tooltip"
								data-container="body"
								title="<?php echo htmlentities(lang('txt_app_filter_negate_tips')); ?>">
								<i class="fa fa-question-circle"></i> <?php echo lang('filter_negate'); ?>:
							</div>
							<div class="detail-info">
								<input type="checkbox" class="filter-negate" name="action[<?php echo $filter_id; ?>]" value="1"
									data-filter-id="<?php echo $filter_id; ?>"
									data-filter-option="negate"
									data-toggle="toggle"
									data-size="small"
									data-width="80"
									data-on="<?php echo lang('on'); ?>"
									data-off="<?php echo lang('off'); ?>"
									data-onstyle="success"
									data-offstyle="danger"<?php
									if ( $negate ) {
										echo 'checked="checked"';
									}
									?> />
							</div>
						</div>
						<div class="detail-row">
							<div class="detail-label"><?php echo lang('action'); ?>:</div>
							<div class="detail-info">
								<select class="form-control filter-actions" data-filter-id="<?php echo $filter_id; ?>">
									<option value="allow"<?php echo ($filter_action == 'allow' ? ' selected="selected"' : ''); ?>><?php echo lang('filter_action_allow'); ?></option>
									<option value="block"<?php echo ($filter_action == 'block' ? ' selected="selected"' : ''); ?>><?php echo lang('filter_action_block'); ?></option>
									<option value="group"<?php echo ($filter_action == 'group' ? ' selected="selected"' : ''); ?>><?php echo lang('filter_action_group'); ?></option>
								</select>
								<select data-filter-id="<?php echo $filter_id; ?>" data-machine-group-id="<?php echo $filter_machine_group_assigned; ?>" class="form-control machine-group-list"<?php echo ($filter_action != 'group' ? ' disabled="disabled"': ''); ?>><?php echo $machine_group_list; ?></select>
							</div>
						</div>
						<div class="detail-row">
							<div class="detail-label"><?php echo lang('on_success'); ?>:</div>
							<div class="detail-info">
								<input type="checkbox" class="filter-success" name="on_success[<?php echo $filter_id; ?>]" value="pass"
									data-filter-id="<?php echo $filter_id; ?>"
									data-filter-option="on_success"
									data-toggle="toggle"
									data-size="small"
									data-width="80"
									data-on="<?php echo lang('pass'); ?>"
									data-off="<?php echo lang('stop'); ?>"
									data-onstyle="success"
									data-offstyle="danger"<?php
									if ( $on_success == 'pass' ) {
										echo 'checked="checked"';
									}
									?> />
							</div>
						</div>
						<div class="detail-row">
							<div class="detail-label"><?php echo lang('on_failure'); ?>:</div>
							<div class="detail-info">
								<input type="checkbox" class="filter-fail" name="on_fail[<?php echo $filter_id; ?>]" value="pass"
									data-filter-id="<?php echo $filter_id; ?>"
									data-filter-option="on_fail"
									data-toggle="toggle"
									data-size="small"
									data-width="80"
									data-on="<?php echo lang('pass'); ?>"
									data-off="<?php echo lang('stop'); ?>"
									data-onstyle="success"
									data-offstyle="danger"<?php
									if ( $on_fail == 'pass' ) {
										echo 'checked="checked"';
									}
									?> />
							</div>
						</div>
					</div>
					
					<div class="controls">
						<button class="btn btn-default filter-test"
							data-filter-id="<?php echo $filter_id; ?>"
							data-filter-name="<?php echo htmlentities($filter_name); ?>">
							<i class="fa fa-check"></i> <?php echo lang('test'); ?>
						</button>
						<button class="btn btn-default filter-rename"
							data-filter-id="<?php echo $filter_id; ?>"
							data-filter-name="<?php echo htmlentities($filter_name); ?>">
							<i class="fa fa-edit"></i> <?php echo lang('rename'); ?>
						</button>
						<button class="btn btn-danger filter-delete"
							data-filter-id="<?php echo $filter_id; ?>"
							data-filter-name="<?php echo htmlentities($filter_name); ?>">
							<i class="fa fa-trash"></i> <?php echo lang('delete'); ?>
						</button>
					</div>
				</div>
			</div>
		</div>
		<?php
			}
		}
		?>
	</div>
	
	<p class="text-danger no-filter<?php if ( $has_filters ) { echo ' hidden'; } ?>">
		<?php echo lang('txt_filter_not_found'); ?>
	</p>
</div>


<?php
/* Modal Templates */
?>

<div class="modal fade" id="modal-change-pattern" tabindex="-1" role="dialog" aria-labelledby="modifyFilterPattern" aria-hidden="true" data-backdrop="static" data-show=false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('filter_modify_pattern'); ?> (<span class="filter-name"></span>)</h4>
      </div>
      <div class="modal-body flexiwidth">
        <span class="hidden txt-machine-name"><?php echo lang('txt_filter_machine_name_change_pattern'); ?></span>
        <span class="hidden txt-ip-address"><?php echo lang('txt_filter_machine_ip_address_change_pattern'); ?></span>
        <span class="hidden txt-mac-address"><?php echo lang('txt_filter_machine_mac_address_change_pattern'); ?></span>
        <br />
        <input type="text" class="form-control" id="filter-new-pattern" value="" size="40" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
        <button type="button" class="btn btn-primary" id="btn-modify-pattern"><?php echo lang('save_changes'); ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="deleteFilter" aria-hidden="true" data-backdrop="static" data-show=false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('filter_deleting'); ?></h4>
      </div>
      <div class="modal-body flexiwidth">
      	<p>
          <?php echo lang('txt_filter_delete_confirmation'); ?>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('cancel'); ?></button>
        <button type="button" class="btn btn-danger" id="btn-delete"><?php echo lang('confirm'); ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-rename" tabindex="-1" role="dialog" aria-labelledby="renameFilter" aria-hidden="true" data-backdrop="static" data-show=false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('filter_renaming'); ?></h4>
      </div>
      <div class="modal-body flexiwidth">
        <?php echo lang('txt_filter_new_name'); ?>:<br />
        <input type="text" class="form-control" id="filter-new-name" value="" size="35" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
        <button type="button" class="btn btn-primary" id="btn-rename"><?php echo lang('save_changes'); ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-test" tabindex="-1" role="dialog" aria-labelledby="testFilter" aria-hidden="true" data-backdrop="static" data-show=false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('filter_testing'); ?> (<span class="filter-name"></span>)</h4>
      </div>
      <div class="modal-body">
      	<div class="form-inline form-equal-label flexiwidth">
      	  <div class="form-group">
      	    <div class="input-group">
      	      <span class="input-group-addon">
      	        <?php echo lang('machine_name'); ?>
      	      </span>
      	      <input type="text" class="form-control" size="35"
      	      	id="txt-test-machine-name" />
      	    </div>
      	  </div>
      	  <div class="form-group">
      	    <div class="input-group">
      	      <span class="input-group-addon">
      	        <?php echo lang('machine_ip_address'); ?>
      	      </span>
      	      <input type="text" class="form-control" size="35"
      	      	id="txt-test-machine-ip-address" />
      	    </div>
      	  </div>
      	  <div class="form-group">
      	    <div class="input-group">
      	      <span class="input-group-addon">
      	        <?php echo lang('machine_mac_address'); ?>
      	      </span>
      	      <input type="text" class="form-control" size="35"
      	      	id="txt-test-machine-mac-address" />
      	    </div>
      	  </div>
      	</div>
      	
      	<div class="text-success test-result-match hidden">
      		<i class="fa fa-check"></i> <?php echo lang('txt_filter_test_matched'); ?>
      	</div>
      	<div class="text-danger test-result-not-match hidden">
      		<i class="fa fa-times"></i> <?php echo lang('txt_filter_test_not_matched'); ?>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('done'); ?></button>
        <button type="button" class="btn btn-primary" id="btn-test-filter">
        	<i class="fa fa-check"></i>
        	<?php echo lang('test'); ?>
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-new-filter" tabindex="-1" role="dialog" aria-labelledby="createFilter" aria-hidden="true" data-backdrop="static" data-show=false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('filter_creating'); ?></h4>
      </div>
      <div class="modal-body flexiwidth">
        <form name="new_filter_form" id="new-filter-form" action="<?php echo site_url('filter/a_machine_new_filter'); ?>" method="post" class="form-horizontal flexiwidth">
        	<input type="hidden" name="business_id" value="<?php echo $business_id; ?>" />
        	<input type="hidden" name="token" value="<?php echo $this->system->get_client_id(); ?>" />
        	<div class="form-group">
        		<label for="filter-name" class="col-md-4 control-label">
        			* <?php echo lang('filter_name'); ?>
        		</label>
        		<div class="col-md-8">
        			<input type="text" name="filter_name" id="filter-name" value="" class="form-control" size="25" placeholder="eg: Global" />
        		</div>
        	</div>
        	
        	<div class="form-group">
        		<label for="filter-machine-name" class="col-md-4 control-label">
        			<?php echo lang('filter_machine_name_pattern'); ?>
        		</label>
        		<div class="col-md-8">
        			<input ttype="text" name="filter_machine_name" id="filter-machine-name"
        				value="" class="form-control" size="35" placeholder="eg: PC-*" />
        		</div>
        	</div>
        	
        	<div class="form-group">
        		<label for="filter-machine-ip-address" class="col-md-4 control-label">
        			<?php echo lang('filter_machine_ip_address_pattern'); ?>
        		</label>
        		<div class="col-md-8">
        			<input ttype="text" name="filter_machine_ip_address" id="filter-machine-ip-address"
        				value="" class="form-control" size="15" placeholder="eg: 192.168.*" />
        		</div>
        	</div>
        	
        	<div class="form-group">
        		<label for="filter-machine-mac-address" class="col-md-4 control-label">
        			<?php echo lang('filter_machine_mac_address_pattern'); ?>
        		</label>
        		<div class="col-md-8">
        			<input ttype="text" name="filter_machine_mac_address" id="filter-machine-mac-address"
        				value="" class="form-control" size="15" placeholder="eg: 00*" />
        		</div>
        	</div>
        	
        	<div class="form-group">
        		<label for="filter-negate" class="col-md-4 control-label"><?php echo lang('filter_negate'); ?></label>
        		<div class="col-md-8">
        			<input type="checkbox" name="filter_negate" id="filter-negate" value="1"
        				data-toggle="toggle"
        				data-on="<?php echo lang('on'); ?>"
        				data-off="<?php echo lang('off'); ?>"
        				data-onstyle="success"
        				data-offstyle="danger" />
        		</div>
        	</div>
        	
        	<div class="form-group">
        		<label for="filter-action" class="col-md-4 control-label"><?php echo lang('action'); ?></label>
        		<div class="col-md-8">
        			<select class="form-control" name="filter_action" id="filter-action">
        				<option value="allow"><?php echo lang('filter_action_allow'); ?></option>
        				<option value="block"><?php echo lang('filter_action_block'); ?></option>
        				<option value="group"><?php echo lang('filter_action_group'); ?></option>
        			</select>
        			<select class="form-control" disabled="disabled" name="filter_assigned_group" id="filter-assigned-group">
        				<?php if ( $has_machine_group_list ): ?>
        				<?php echo $machine_group_list; ?>
        				<?php endif; ?>
        			</select>
        		</div>
        	</div>
        	
        	<div class="form-group">
        		<label for="filter-success" class="col-md-4 control-label"><?php echo lang('on_success'); ?></label>
        		<div class="col-md-8">
        			<input type="checkbox" name="filter_success" id="filter-success" value="pass"
        				data-toggle="toggle"
        				data-width="80"
        				data-on="<?php echo lang('pass'); ?>"
        				data-off="<?php echo lang('stop'); ?>"
        				data-onstyle="success"
        				data-offstyle="danger" />
        		</div>
        	</div>
        	
        	<div class="form-group">
        		<label for="filter-fail" class="col-md-4 control-label"><?php echo lang('on_failure'); ?></label>
        		<div class="col-md-8">
        			<input type="checkbox" name="filter_fail" id="filter-fail" value="pass"
        				data-toggle="toggle"
        				data-width="80"
        				data-on="<?php echo lang('pass'); ?>"
        				data-off="<?php echo lang('stop'); ?>"
        				data-onstyle="success"
        				data-offstyle="danger" />
        		</div>
        	</div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
        <button type="button" class="btn btn-success" id="btn-create-filter"><?php echo lang('create'); ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-simulate" tabindex="-1" role="dialog" aria-labelledby="simulateFilter" aria-hidden="true" data-backdrop="static" data-show=false" data-business-id="<?php echo $business_id; ?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('filter_simulation'); ?></h4>
      </div>
      <div class="modal-body">
        <p>
          <?php echo lang('txt_filter_machine_simulation'); ?>
        </p>
        
        <div class="form-horizontal">
	        <div class="form-group">
				<label for="sim-machine-name" class="col-md-4 control-label">
					<?php echo lang('machine_name'); ?>
				</label>
				<div class="col-md-8">
					<input type="text" id="sim-machine-name"
						value="" class="form-control" size="35" placeholder="" />
				</div>
			</div>
				
			<div class="form-group">
				<label for="sim-machine-ip-address" class="col-md-4 control-label">
					<?php echo lang('machine_ip_address'); ?>
				</label>
				<div class="col-md-8">
					<input type="text" id="sim-machine-ip-address"
						value="" class="form-control" size="15" placeholder="" />
				</div>
			</div>
			
			<div class="form-group">
				<label for="sim-machine-mac-address" class="col-md-4 control-label">
					<?php echo lang('machine_mac_address'); ?>
				</label>
				<div class="col-md-8">
					<input type="text" id="sim-machine-mac-address"
						value="" class="form-control" size="15" placeholder="" />
				</div>
			</div>
		</div>
        
        <div class="test-result"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('done'); ?></button>
        <button type="button" class="btn btn-primary" id="btn-start-simulate"><?php echo lang('simulate'); ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-process" tabindex="-1" role="dialog" aria-labelledby="processFilter" aria-hidden="true" data-backdrop="static" data-show=false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('filter_processing'); ?></h4>
      </div>
      <div class="modal-body flexiwidth">
      	<p>
      		<?php echo lang('txt_filter_machine_process'); ?>
      	</p>
      	<div id="evaluate-result">
      		<div class="scrolling-area">
	      		<div class="result"></div>
	      	</div>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
        <button type="button" class="btn btn-primary" id="btn-process-evaluate">
        	<?php echo lang('evaluate'); ?>
        	<i class="fa fa-spinner fa-spin hidden icon-loading"></i>
        </button>
        <button type="button" class="btn btn-success hidden" id="btn-process-go">
        	<?php echo lang('process'); ?>
        	<i class="fa fa-spinner fa-spin hidden icon-loading"></i>
        </button>
      </div>
    </div>
  </div>
</div>