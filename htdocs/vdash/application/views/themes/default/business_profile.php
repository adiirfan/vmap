<h2 class="page-title"><?php echo $page_title; ?></h2>
<div class="row">
	<div class="col-md-4">
		<?php
		$business_id = $business_model->get_value('business_id');
		$business_picture = $business_model->get_value('business_picture');
		$connected_agents = intval($business_model->get_value('business_connected_agent'));
		$max_agents = intval($business_model->get_value('business_max_agent'));
		$utilization_percentage = round($connected_agents / $max_agents * 100);
		$utilization_class = 'progress-bar-success';
		$concurrent_class = 'progress-bar-success';
		$max_concurrent = get_max_concurrent_user_sessions($business_id);
		$concurrent_agents = 0;
		$business_users = $business_model->get_business_users();
		
		if ( false !== $max_concurrent ) {
			$concurrent_agents = intval(array_ensure($max_concurrent, 'sessions', 0));
			$concurrent_date = array_ensure($max_concurrent, 'date', '');
			$concurrent_date = date('j/n/Y g:ia', strtotime($concurrent_date));
		}
		$concurrent_percentage = round($concurrent_agents / $max_agents * 100);
		
		if ( $utilization_percentage >= 80 ) {
			$utilization_class = 'progress-bar-danger';
		} else if ( $utilization_percentage >= 50 ) {
			$utilization_class = 'progress-bar-warning';
		}
		
		if ( $concurrent_percentage >= 80 ) {
			$concurrent_class = 'progress-bar-danger';
		} else if ( $concurrent_percentage >= 50 ) {
			$concurrent_class = 'progress-bar-warning';
		}
		?>
		
		<div class="box">
			<h3><?php echo lang('business_picture'); ?></h3>
			<div class="text-center">
				<?php if ( !is_empty($business_picture) ): ?>
				<img id="business-picture" src="!/uploads/<?php echo $business_picture; ?>" class="profile-image" alt="<?php echo htmlentities($business_model->get_value('business_name')); ?>" />
				<?php else: ?>
				<img id="business-picture" src="!/images/no-image.jpg" class="profile-image" alt="No picture available" />
				<?php endif; ?>
			</div>
			<br />
			<div id="image-preview"></div>
			<span class="btn btn-primary btn-upload">
				<i class="fa fa-plus"></i>
				<span><?php echo lang('upload'); ?></span>
				<input type="file" name="picture" id="btn-picture" data-business-id="<?php echo $business_id; ?>" />
			</span>
			<button type="button" id="btn-start-upload" class="btn btn-success hidden">
				<i class="fa fa-upload"></i>
				<?php echo lang('start_upload'); ?>
			</button>
		</div>
		
		<div class="box">
			<h3><?php echo lang('installed_agents'); ?></h3>
			
			<div class="progress">
				<div class="progress-bar progress-bar-striped <?php echo $utilization_class; ?>" role="progressbar"
					aria-valuenow="<?php echo $utilization_percentage; ?>" aria-valuemin="0" aria-valuemax="100"
					style="width: <?php echo $utilization_percentage; ?>%">
					<span class="reading"><?php echo $connected_agents . '/' . $max_agents; ?></span>
				</div>
			</div>
		</div>
		
		<div class="box">
			<h3><?php echo lang('max_concurrent_agents'); ?></h3>
			
			<div class="progress">
				<div class="progress-bar progress-bar-striped <?php echo $concurrent_class; ?>" role="progressbar"
					aria-valuenow="<?php echo $concurrent_percentage; ?>" aria-valuemin="0" aria-valuemax="100"
					style="width: <?php echo $concurrent_percentage; ?>%">
					<span class="reading"><?php echo _lang('_concurrent_max_agents_reading', $concurrent_agents, $max_agents); ?></span>
				</div>
			</div>
			<span class="small">
				<?php if ( isset($concurrent_date) ): ?>
				<?php echo _lang('_txt_max_concurrent_date', $concurrent_date); ?>
				<?php endif; ?>
			</span>
		</div>
	</div>
	<div class="col-md-8">
		<div class="box">
			<h3><?php echo lang('business_profile'); ?></h3>
			<?php
			$fields = array(
				'business_name', 'business_code', 'business_domain' => 'business_site_domain',
				'business_phone', 'business_fax', 'business_email', 'business_profile', 
				'business_max_agents' => 'business_max_agent', 'creation_date' => 'business_created',
			);
			?>
			<div class="bootstrap-detail-table">
				<div class="data-rows">
					<?php
					$index = 1;
					foreach ( $fields as $key => $val ) {
						if ( is_pure_digits($key) ) {
							$key = $val;
						}
						
						$label = lang($key);
						$value = $business_model->get_value($val);
						$row_class = ($index  % 2 ? 'odd' : 'even');
						$index ++;
						
						if ( $val == 'business_max_agent' ) {
							$value = intval($value);
						}
					?>
					<div class="row data-row <?php echo $row_class; ?>">
						<div class="col-md-6 label">
							<?php echo $label; ?>
						</div>
						<div class="col-md-6">
							<?php echo htmlentities($value); ?>
						</div>
					</div>
					<?php
					}
					?>
				</div>
			</div>
			<br />
			<a href="<?php echo site_url('business/edit/' . $business_id); ?>" class="btn btn-primary">
				<i class="fa fa-edit"></i>
				<?php echo lang('business_edit'); ?>
			</a>
		</div>
		
		<div class="box">
			<h3><?php echo lang('business_users'); ?></h3>
			<?php echo $user_list; ?>
		</div>
	</div>
</div>
