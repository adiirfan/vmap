<h2 class="page-title">
	<?php echo lang('machine_overview'); ?>
	<?php if ( isset($machine_group_option_list) && iterable($machine_group_option_list) ): ?>
	<div class="pull-right">
		<select id="dropdown-machine-group" name="machine_group" class="form-control">
			<option value="">- <?php echo lang('select_a_machine_group'); ?> -</option>
			<?php foreach ( $machine_group_option_list as $value => $text ): ?>
			<option value="<?php echo htmlentities($value); ?>"<?php
			if ( $this->input->get('machine_group') == $value ) {
				echo ' selected="selected"';
			}
			?>><?php echo htmlentities($text); ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="clearfix"></div>
	<?php endif; ?>
</h2>

<div class="row">
	<div class="col-md-4">
		<div class="box box-baby-blue">
			<i class="fa fa-sign-in box-icon"></i>
			<div class="box-big-figure">
				<?php echo $total_logon_sessions; ?>
			</div>
			<div class="box-figure-remark">
				<?php echo lang('machine_usage'); ?> (<?php echo lang('total_logon_sessions'); ?>)
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box">
			<i class="fa fa-sign-in box-icon"></i>
			<div class="box-big-figure">
				<?php echo $total_machines; ?>
			</div>
			<div class="box-figure-remark">
				<?php echo lang('machine_total'); ?>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box">
			<i class="fa fa-sign-in box-icon"></i>
			<div class="box-big-figure">
				<?php
				if ( isset($machine_activities) && iterable($machine_activities) ) {
				?>
				<span class="text-success" data-toggle="tooltip" data-placement="left" title="<?php echo lang('online_machines'); ?>">
					<i class="fa fa-circle"></i>
					<?php echo $machine_activities['online']; ?>
				</span>
				<span class="text-danger" data-toggle="tooltip" data-placement="left" title="<?php echo lang('offline_machines'); ?>">
					<i class="fa fa-circle-thin"></i>
					<?php echo $machine_activities['offline']; ?>
				</span>
				<?php
				}
				?>
			</div>
			<div class="box-figure-remark">
				<?php echo lang('machine_total_activities'); ?>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-7">
		<div class="box">
			<h4 class="box-title"><?php echo lang('machine_usage_top5'); ?></h4>
			<div class="btn-group period" role="group">
				<button type="button" class="btn btn-default active" data-period="today"><?php echo lang('today'); ?></button>
				<button type="button" class="btn btn-default" data-period="this week"><?php echo lang('this_week'); ?></button>
				<button type="button" class="btn btn-default" data-period="this month"><?php echo lang('this_month'); ?></button>
				<button type="button" class="btn btn-default" data-period="this year"><?php echo lang('this_year'); ?></button>
			</div>
			
			<div id="chart-machine-usage"></div>
			<p class="text-danger hidden" id="no-machine-usage-data">
				<?php echo lang('machine_usage_empty'); ?>
			</p>
			<?php if ( isset($machine_usage_top5) && iterable($machine_usage_top5) ): ?>
			<script>
			var machineUsageData = <?php echo json_encode($machine_usage_top5); ?>;
			</script>
			<?php endif; ?>
		</div>
	</div>
	
	<div class="col-md-5">
		<div class="box">
			<h4 class="box-title"><?php echo lang('machine_overall_usage'); ?></h4>
			<div class="chart"
				data-name="overall_machine_usage"
				data-chart="columnchart"
				data-data="<?php echo htmlentities(json_encode($overall_machine_usage)); ?>"
				data-columns="<?php echo htmlentities(json_encode(array(
					array('string', lang('date')),
					array('number', lang('machine_max_concurrent')),
				))); ?>"
				data-options="<?php echo htmlentities(json_encode(array(
					'width' => '100%',
					'height' => '100',
					'legend' => array(
						'position' => 'none',
					),
					'chartArea' => array(
						'width' => '90%',
						'height' => '70%',
					),
					'pointSize' => 5,
				))); ?>"></div>
		</div>
		
		<div class="box">
			<h4 class="box-title"><?php echo lang('machine_by_purchase_years'); ?></h4>
			<div class="chart"
				data-name="machine_purchase_year"
				data-chart="piechart"
				data-data="<?php echo htmlentities(json_encode($machine_usage_by_years)); ?>"
				data-columns="<?php echo htmlentities(json_encode(array(
					array('string', lang('year')),
					array('number', lang('machine_count')),
				))); ?>"
				data-options="<?php echo htmlentities(json_encode(array(
					'width' => '100%',
					'height' => '100',
					'chartArea' => array(
						'width' => '90%',
						'height' => '90%',
					),
				))); ?>"></div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="box box-blue">
			<h4 class="box-title"><?php echo lang('machine_count_by_machine_group'); ?></h4>
			<?php if ( isset($machine_by_machine_group) && iterable($machine_by_machine_group) ): ?>
				<div class="slimscroll" data-toggle="slimscroll" data-height="130">
					<ul class="item-list item-list-inline item-list-noline">
					<?php foreach ( $machine_by_machine_group as $machine_group ): ?>
						<li>
							<span class="item-title"><?php echo htmlentities($machine_group['machine_group_name']); ?></span>
							<span class="item-info"><?php echo intval($machine_group['total_machines']); ?></span>
						</li>
					<?php endforeach; ?>
					</ul>
				</div>
			<?php else: ?>
			<p class="text-danger">
				<?php echo lang('txt_machine_count_group_no_records'); ?>
			</p>
			<?php endif; ?>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="box box-blue">
			<h4 class="box-title"><?php echo lang('machine_usage_statistics'); ?></h4>
			<?php if ( isset($machine_usage_statistics) && iterable($machine_usage_statistics) ): ?>
			<ul class="item-list item-list-inline item-list-noline">
			<?php foreach ( $machine_usage_statistics as $machine_usage ): ?>
				<li>
					<span class="item-title"><?php echo htmlentities($machine_usage[0]); ?></span>
					<span class="item-info"><?php echo intval($machine_usage[1]); ?></span>
				</li>
			<?php endforeach; ?>
			</ul>
			<?php else: ?>
			<p class="text-danger"><?php echo lang('txt_machine_usage_statistics_not_found'); ?></p>
			<?php endif; ?>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="box">
			<h4 class="box-title"><?php echo lang('most_used_machines'); ?></h4>
			<?php if ( isset($most_used_machines) && iterable($most_used_machines) ): ?>
			<div class="slimscroll" data-toggle="slimscroll" data-height="130">
				<ul class="item-list">
				<?php foreach ( $most_used_machines as $machine ): ?>
					<li>
						<span class="item-title"><?php echo htmlentities($machine['machine_name']); ?> (<?php echo _lang('_sessions', intval($machine['total_sessions'])); ?>)</span>
						<span class="sub-line"><?php echo $machine['machine_group_name']; ?></span>
						<span class="small"><?php echo _lang('_last_login', htmlentities($machine['last_login_name'])); ?></span>
					</li>
				<?php endforeach; ?>
				</ul>
			</div>
			<?php else: ?>
			<p class="text-danger"><?php echo lang('txt_machine_usage_statistics_not_found'); ?></p>
			<?php endif; ?>
		</div>
	</div>
</div>