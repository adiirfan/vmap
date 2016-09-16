<h2 class="page-title"><?php echo lang('app_detail'); ?></h2>
<div class="row">
	<div class="col-md-4">
		<div class="box">
			<div class="detail">
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('app_name'); ?>
					</div>
					<div class="detail-info">
						<?php echo $app_data['app_sys_name']; ?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('app_friendly_name'); ?>
					</div>
					<div class="detail-info">
						<?php echo $app_data['app_friendly_name']; ?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('app_license'); ?>
					</div>
					<div class="detail-info">
						<?php
						$license_count = intval($app_data['app_license_count']);
						echo ($license_count ? $license_count : 'n/a');
						?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('app_total_instances'); ?>
					</div>
					<div class="detail-info">
						<?php
						echo intval($total_instances);
						?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('app_max_concurrent'); ?>
					</div>
					<div class="detail-info">
						<?php
						echo $max_concurrent_app;
						?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('app_most_used_user'); ?>
					</div>
					<div class="detail-info">
						<?php
						if ( isset($most_used_user) && iterable($most_used_user) ) {
							echo $most_used_user['user_name'];
						} else {
							echo 'n/a';
						}
						?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('app_most_used_machine_group'); ?>
					</div>
					<div class="detail-info">
						<?php
						if ( isset($most_used_machine_group) && iterable($most_used_machine_group) ) {
							echo $most_used_machine_group['machine_group_name'];
						} else {
							echo 'n/a';
						}
						?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('app_most_used_machine'); ?>
					</div>
					<div class="detail-info">
						<?php
						if ( isset($most_used_machine) && iterable($most_used_machine) ) {
							echo $most_used_machine['machine_name'];
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
			<h4 class="box-title"><?php echo lang('app_most_used_machine'); ?></h4>
			
			<div class="chart"
				data-name="top5_used_machines"
				data-chart="piechart"
				data-data="<?php echo htmlentities(json_encode($top5_used_machines)); ?>"
				data-columns="<?php echo htmlentities(json_encode(array(
					array('string', lang('machine')),
					array('number', lang('logon_sessions')),
				))); ?>"
				data-options="<?php echo htmlentities(json_encode(array(
					'width' => '100%',
					'height' => '210',
					'chartArea' => array(
						'width' => '100%',
						'height' => '80%',
					),
				))); ?>"></div>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="box" style="min-height: 278px;">
			<h4 class="box-title"><?php echo lang('app_most_concurrent_usage'); ?></h4>
			<ul class="item-list item-list-inline">
				<?php foreach ( $max_concurrent_periods as $period => $instances ): ?>
				<li>
					<span class="item-title"><?php echo lang($period); ?></span>
					<?php
					if ( $license_count ) {
						$percentage = round($instances / $license_count * 100);
						$context_class = '';
						
						if ( $percentage >= 80 ) {
							$context_class = ' progress-bar-danger';
						} else if ( $percentage >= 50 ) {
							$context_class = ' progress-bar-warning';
						}
						
					?>
					<div class="progress">
						<div class="progress-bar<?php echo $context_class; ?>" role="progressbar" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentage; ?>%;">
							<span class="text"><?php echo $instances . ' / ' . $license_count; ?></span>
						</div>
					</div>
					<?php
					} else {
					?>
					<span class="item-info"><?php echo _lang('_instances_launched', $instances); ?></span>
					<?php
					}
					?>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="box">
			<h4 class="box-title"><?php echo lang('machine_information'); ?></h4>
			<?php echo $machine_list; ?>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="box">
			<h4 class="box-title"><?php echo lang('user_information'); ?></h4>
			<?php echo $user_list; ?>
		</div>
	</div>
</div>