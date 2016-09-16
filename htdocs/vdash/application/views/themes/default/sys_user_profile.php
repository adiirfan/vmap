<h2 class="page-title"><?php echo $page_title; ?></h2>
<div class="row">
	<div class="col-md-8">
		<div class="box">
			<h3><?php echo lang('user_profile'); ?></h3>
			<?php
			$display_fields = array(
				'sys_user_email' => 'email',
				'sys_user_password' => 'password',
				'sys_user_name' => 'name',
				'business_name' => 'business',
				'sys_user_phone' => 'phone',
				'sys_user_mobile' => 'mobile',
				'sys_user_remark' => 'remark',
				'sys_user_type' => 'user_type',
				'sys_user_valid' => 'status',
				'sys_user_last_login' => 'last_login',
				'sys_user_created' => 'creation_date',
			);
			
			if ( isset($tmp_password) && !is_empty($tmp_password) ) {
				$sys_user_data['sys_user_password'] = '<span class="text-success text-bold">' . $tmp_password . '</span>';
			} else {
				unset($display_fields['sys_user_password']);
			}
			
			if ( $sys_user_data['sys_user_type'] != 'superadmin' ) {
				// Get the business model.
				$business_model = $sys_user_model->get_business_model();
				$business_name = $business_model->get_value('business_name');
				$business_id = $business_model->get_value('business_id');
				$url = site_url('business/profile/' . $business_id);
				$anchor = '<a href="' . $url . '" target="_blank">' . $business_name . ' <i class="fa fa-external-link"></i></a>';
				
				$sys_user_data['business_name'] = $anchor;
			} else {
				unset($display_fields['business_name']);
			}
			
			?>
			<div class="bootstrap-detail-table">
				<div class="data-rows">
					<?php
					$index = 1;
					
					foreach ( $display_fields as $db_field => $lang_key ) {
						$label = lang($lang_key);
						$value = array_ensure($sys_user_data, $db_field, '');
						$row_class = ($index % 2 ? 'odd' : 'even');
						$index ++;
						
						if ( is_empty($value) ) {
							$value = '-';
						} else {
							switch ( $db_field ) {
								case 'sys_user_type':
									$value = ucfirst($value);
									break;
								case 'sys_user_valid':
									if ( $value ) {
										$value = '<span class="label label-success">' . lang('active') . '</span>';
									} else {
										$value = '<span class="label label-danger">' . lang('inactive') . '</span>';
									}
									break;
							}
						}
					?>
					<div class="row data-row <?php echo $row_class; ?>">
						<div class="col-md-6 label">
							<?php echo $label; ?>
						</div>
						<div class="col-md-6">
							<?php echo $value; ?>
						</div>
					</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box">
			<h3>Actions</h3>
			<a href="<?php echo site_url('sys_user/edit/' . $sys_user_id); ?>" class="btn btn-primary">
				<i class="fa fa-edit"></i>
				<?php echo lang('edit_profile'); ?>
			</a>
			<a href="#" class="btn btn-default" data-toggle="modal" data-target="#modal-password">
				<i class="fa fa-key"></i>
				<?php echo lang('change_password'); ?>
			</a>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-password" tabindex="-1" role="dialog" aria-labelledby="changePassword" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="changePassword"><?php echo lang('change_password'); ?></h4>
      </div>
      <div class="modal-body">
      	<div class="container-fluid">
	        <div class="form form-horizontal flexiwidth">
	        	<div class="form-group">
	        		<label for="txt-password"><?php echo lang('new_password'); ?></label>
	        		<input type="text" class="form-control" id="txt-password" size="30" maxlength="50" />
	        	</div>
	        </div>
	    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
        <button type="button" id="btn-change-password" data-url="<?php echo site_url('sys_user/change-password/' . $sys_user_id); ?>" class="btn btn-primary"><?php echo lang('change_password'); ?></button>
      </div>
    </div>
  </div>
</div>