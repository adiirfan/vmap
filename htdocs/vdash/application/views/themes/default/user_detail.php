<h2 class="page-title"><?php echo lang('user_detail'); ?></h2>
<div class="row">
	<div class="col-md-4">
		<div class="box">
			<div class="detail">
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('user_name'); ?>
					</div>
					<div class="detail-info">
						<?php echo $user_data['user_name']; ?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('user_domain'); ?>
					</div>
					<div class="detail-info">
						<?php echo string_ensure($user_data['user_domain'], 'n/a'); ?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('user_group'); ?>
					</div>
					<div class="detail-info">
						<?php echo string_ensure($user_data['user_ad_group']); ?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('user_sum_active_sessions'); ?>
					</div>
					<div class="detail-info">
						<?php echo $sum_active_sessions; ?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('user_sum_application_used'); ?>
					</div>
					<div class="detail-info">
						<?php echo $sum_application_instances; ?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('user_total_active_duration'); ?>
					</div>
					<div class="detail-info">
						<?php echo $total_active_duration; ?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('user_most_used_application'); ?>
					</div>
					<div class="detail-info">
						<?php
						if ( isset($most_used_application) && iterable($most_used_application) ) {
							echo $most_used_application['app_friendly_name'];
							echo ' (' . $most_used_application['total_instances'] . ')';
						} else {
							echo 'n/a';
						}
						?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('user_most_used_machine'); ?>
					</div>
					<div class="detail-info">
						<?php
						if ( isset($most_used_machine) && iterable($most_used_machine) ) {
							echo $most_used_machine['machine_name'];
							echo ' (' . $most_used_machine['logon_sessions'] . ')';
						} else {
							echo 'n/a';
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="box">
			<h4 class="box-title"><?php echo lang('machine_usage'); ?></h4>
			<div class="row">
				<div class="chart"
					data-name="top5_logon_machines"
					data-chart="piechart"
					data-data="<?php echo htmlentities(json_encode($top5_used_machines)); ?>"
					data-columns="<?php echo htmlentities(json_encode(array(
						array('string', lang('machine')),
						array('number', lang('logon_sessions')),
					))); ?>"
					data-options="<?php echo htmlentities(json_encode(array(
						'width' => '100%',
						'height' => '210',
						'legend' => array(
							'position' => 'none',
						),
						'chartArea' => array(
							'width' => '90%',
							'height' => '80%',
						),
					))); ?>"></div>
			</div>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="box">
			<h4 class="box-title"><?php echo lang('app_usage'); ?></h4>
			<div class="slimscroll" data-toggle="slimscroll" data-height="210">
				<?php if ( isset($top5_used_applications) && iterable($top5_used_applications) ): ?>
				<ul class="item-list item-list-inline">
					<?php foreach ( $top5_used_applications as $app ): ?>
					<li>
						<span class="item-title"><i class="fa fa-windows"></i> <?php echo $app[0]; ?></span>
						<span class="item-info"><?php echo _lang('_instances_launched', $app[1]); ?></span>
					</li>
					<?php endforeach; ?>
				</ul>
			
				<?php else: ?>
				<p class="text-danger">
					<?php echo lang('txt_app_no_usage'); ?>
				</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<?php echo $machine_login_list; ?>
	</div>
	<div class="col-md-6">
		<?php echo $application_usage_list; ?>
	</div>
</div>