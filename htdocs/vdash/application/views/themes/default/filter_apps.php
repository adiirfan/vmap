<?php
$has_filters = (isset($filters) && iterable($filters));
?>
<div class="box">
	<h2 class="page-title">
		<?php echo lang('app_filters'); ?>
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
				$filter_id = $filter['app_filter_id'];
				$filter_name = htmlentities($filter['app_filter_name']);
				$filter_app_name = htmlentities($filter['app_filter_sys_name']);
				$filter_action = trim($filter['app_filter_action']);
				$negate = ($filter['app_filter_negate'] ? true : false);
				$on_success = $filter['app_filter_on_success'];
				$on_fail = $filter['app_filter_on_fail'];
		?>
		<div class="panel panel-default" data-filter-id="<?php echo $filter_id; ?>">
			<div class="panel-heading" role="tab" id="heading-<?php echo $filter_id; ?>">
				<h4 class="panel-title">
					<i class="fa fa-arrows-v sort-handle"></i>&nbsp;
					<a data-toggle="collapse" href="#collapse-<?php echo $filter_id; ?>"
						aria-expanded="false" aria-controls="collapse-<?php echo $filter_id; ?>">
						<?php echo $filter_name; ?>
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
								title="<?php echo htmlentities(lang('txt_app_filter_pattern_tips')); ?>">
								<i class="fa fa-question-circle"></i> <?php echo lang('filter_pattern'); ?>:
							</div>
							<div class="detail-info">
								<span class="filter-pattern"><?php echo $filter_app_name; ?></span>&nbsp;
								<button type="button" class="btn btn-primary btn-sm pull-right filter-pattern-modify"
									data-filter-id="<?php echo $filter_id; ?>"
									data-filter-name="<?php echo htmlentities($filter_name); ?>"
									data-filter-pattern="<?php echo htmlentities($filter_app_name); ?>"><?php echo lang('modify'); ?></button>
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
								<input type="checkbox" class="filter-action" name="action[<?php echo $filter_id; ?>]" value="allow"
									data-filter-id="<?php echo $filter_id; ?>"
									data-toggle="toggle"
									data-size="small"
									data-width="80"
									data-on="<?php echo lang('filter_action_allow'); ?>"
									data-off="<?php echo lang('filter_action_block'); ?>"
									data-onstyle="success"
									data-offstyle="danger"<?php
									if ( $filter_action == 'allow' ) {
										echo 'checked="checked"';
									}
									?> />
							</div>
						</div>
						<div class="detail-row">
							<div class="detail-label"><?php echo lang('on_success'); ?>:</div>
							<div class="detail-info">
								<input type="checkbox" class="filter-success" name="on_success[<?php echo $filter_id; ?>]" value="pass"
									data-filter-id="<?php echo $filter_id; ?>"
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

<div class="modal fade" id="modal-rename" tabindex="-1" role="dialog" aria-labelledby="renameFilter" aria-hidden="true" data-backdrop="static" data-show=false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('filter_renaming'); ?></h4>
      </div>
      <div class="modal-body flexiwidth">
        <?php echo lang('txt_filter_new_name'); ?>:<br />
        <input type="text" class="form-control" id="filter-new-name" value="" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
        <button type="button" class="btn btn-primary" id="btn-rename"><?php echo lang('save_changes'); ?></button>
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

<div class="modal fade" id="modal-test" tabindex="-1" role="dialog" aria-labelledby="testFilter" aria-hidden="true" data-backdrop="static" data-show=false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('filter_testing'); ?> (<span class="filter-name"></span>)</h4>
      </div>
      <div class="modal-body">
      	<div class="form-inline flexiwidth">
      	  <div class="form-group">
      	    <div class="input-group">
      	      <span class="input-group-addon">
      	        <i class="icon icon-test fa fa-bolt"></i>
      	        <i class="icon icon-loading fa fa-circle-o-notch fa-spin hidden"></i>
      	        <i class="icon icon-success fa fa-check hidden"></i>
      	        <i class="icon icon-fail fa fa-times hidden"></i>
      	      </span>
      	      <input type="text" class="form-control" size="35" placeholder="<?php echo lang('txt_enter_app_name'); ?>" id="txt-test-app-name" />
      	      <span class="input-group-btn">
      	        <button class="btn btn-default" type="button" id="btn-test-filter">
      	          <?php echo lang('execute'); ?>
      	        </button>
      	        
      	      </span>
      	    </div>
      	  </div>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('done'); ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-modify-pattern" tabindex="-1" role="dialog" aria-labelledby="modifyFilter" aria-hidden="true" data-backdrop="static" data-show=false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('filter_modify_pattern'); ?> (<span class="filter-name"></span>)</h4>
      </div>
      <div class="modal-body flexiwidth">
        <?php echo lang('txt_filter_new_pattern'); ?>:<br />
        <input type="text" class="form-control" id="filter-new-pattern" value="" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
        <button type="button" class="btn btn-primary" id="btn-modify-pattern"><?php echo lang('save_changes'); ?></button>
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
          <?php echo lang('txt_filter_simulation'); ?>
        </p>
        <div class="form-inline flexiwidth">
          <div class="form-group">
            <div class="input-group">
      	      <span class="input-group-addon">
      	        <i class="icon icon-test fa fa-bolt"></i>
      	      </span>
      	      <input type="text" class="form-control" size="35" placeholder="<?php echo lang('txt_enter_app_name'); ?>" id="txt-simulate-app-name" />
      	      <span class="input-group-btn">
      	        <button class="btn btn-default" type="button" id="btn-simulate-filter">
      	          <?php echo lang('execute'); ?>
      	        </button>
      	      </span>
      	    </div>
          </div>
        </div>
        <div class="test-result"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('done'); ?></button>
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
        <form name="new_filter_form" id="new-filter-form" action="<?php echo site_url('filter/a_app_new_filter'); ?>" method="post" class="form-horizontal flexiwidth">
        	<input type="hidden" name="business_id" value="<?php echo $business_id; ?>" />
        	<input type="hidden" name="token" value="<?php echo $this->system->get_client_id(); ?>" />
        	<div class="form-group">
        		<label for="filter-name" class="col-md-4 control-label"><?php echo lang('filter_name'); ?></label>
        		<div class="col-md-8">
        			<input type="text" name="filter_name" id="filter-name" value="" class="form-control" size="25" placeholder="eg: Global" />
        		</div>
        	</div>
        	<div class="form-group">
        		<label for="filter-patter" class="col-md-4 control-label"><?php echo lang('filter_pattern'); ?></label>
        		<div class="col-md-8">
        			<input type="text" name="filter_pattern" id="filter-pattern" value="" class="form-control" size="35" placeholder="eg: *.exe" />
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
        			<input type="checkbox" name="filter_action" id="filter-action" value="allow"
        				data-toggle="toggle"
        				data-width="80"
        				data-on="<?php echo lang('filter_action_allow'); ?>"
        				data-off="<?php echo lang('filter_action_block'); ?>"
        				data-onstyle="success"
        				data-offstyle="danger" />
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

<div class="modal fade" id="modal-process" tabindex="-1" role="dialog" aria-labelledby="processFilter" aria-hidden="true" data-backdrop="static" data-show=false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('filter_processing'); ?></h4>
      </div>
      <div class="modal-body flexiwidth">
      	<p>
      		<?php echo lang('txt_filter_app_process'); ?>
      	</p>
      	<div id="evaluate-result">
      		<div class="scrolling-area">
	      		<ul class="filter-result"></ul>
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