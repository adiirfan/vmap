<h2 class="page-title"><?php echo lang('page_title_machine/detail'); ?></h2>
<div class="row">
	<div class="col-md-4">
		<div class="box">
			<div class="detail">
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('machine_name'); ?>
					</div>
					<div class="detail-info">
						<?php echo $machine_name; ?><br />
						<span class="small">(<?php echo _lang('_default_name', $machine_default_name); ?>)</span>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('machine_ip_address'); ?>
					</div>
					<div class="detail-info">
						<?php echo string_ensure($machine_ip_address, 'n/a'); ?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('machine_mac_address'); ?>
					</div>
					<div class="detail-info">
						<?php echo string_ensure($machine_mac_address, 'n/a'); ?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('machine_domain'); ?>
					</div>
					<div class="detail-info">
						<?php echo string_ensure($machine_domain_name, 'n/a'); ?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('machine_group'); ?>
					</div>
					<div class="detail-info">
						<?php
						if ( isset($machine_group_data) && iterable($machine_group_data) ) {
							echo array_ensure($machine_group_data, 'machine_group_name', 'n/a');
						} else {
							echo 'n/a';
						}
						?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('machine_uptime'); ?>
					</div>
					<div class="detail-info">
						<?php echo $machine_uptime; ?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('machine_most_login_user'); ?>
					</div>
					<div class="detail-info">
						<?php
						if ( isset($most_logon_user) && iterable($most_logon_user) ) {
							echo htmlentities($most_logon_user['user_name_full']) . '<br />';
							echo '<span class="small">(' . _lang('_sessions', $most_logon_user['logon_sessions']) . ')</span>';
						} else {
							echo 'n/a';
						}
						?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('machine_most_used_app'); ?>
					</div>
					<div class="detail-info">
						<?php
						if ( isset($most_used_app) && iterable($most_used_app) ) {
							echo htmlentities($most_used_app['app_friendly_name']) . '<br />';
							echo '<span class="small">(' . _lang('_instances', $most_used_app['total_launches']) . ')</span>';
						} else {
							echo 'n/a';
						}
						?>
					</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">
						<?php echo lang('blacklist'); ?>
					</div>
					<div class="detail-info">
						<input type="checkbox" name="blacklist" id="machine-blaklist"
							data-toggle="toggle" data-on="<?php echo lang('blacklist'); ?>" data-off="<?php echo lang('no'); ?>"
							data-onstyle="danger" data-offstyle="default" data-machine-id="<?php echo $machine_id; ?>"<?php
							if ( !$machine_visible ) {
								echo ' checked="checked"';
							}
							?> />
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="box">
			<h4 class="box-title"><?php echo lang('app_usage_information_top5'); ?></h4>
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
					'height' => '316',
					'chartArea' => array(
						'width' => '90%',
						'height' => '80%',
					),
				))); ?>"></div>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="box" style="min-height: 382px;">
			<h4 class="box-title"><?php echo lang('machine_usage_information'); ?></h4>
			<?php if ( isset($machine_usage_info) && iterable($machine_usage_info) ): ?>
				<ul class="item-list item-list-inline">
					<?php foreach ( $machine_usage_info as $info ): ?>
					<li>
						<span class="item-title"><?php echo $info[0]; ?></span>
						<span class="item-info"><?php echo _lang('_sessions', $info[1]); ?></span>
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