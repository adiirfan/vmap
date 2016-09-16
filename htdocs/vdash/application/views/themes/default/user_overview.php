<h2 class="page-title">
	<?php echo lang('user_overview'); ?>
	
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
		<div class="box box-green">
			<i class="fa fa-users box-icon"></i>
			<div class="box-big-figure">
				<?php echo $total_users; ?>
			</div>
			<div class="box-figure-remark">
				<?php echo lang('total_users'); ?>
			</div>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="box">
			<i class="fa fa-sign-in box-icon"></i>
			<div class="box-big-figure">
				<?php echo $total_sessions; ?>
			</div>
			<div class="box-figure-remark">
				<?php echo lang('total_login_sessions'); ?>
			</div>
		</div>
		<div class="box box-blue">
			<i class="fa fa-sign-in box-icon"></i>
			<div class="box-big-figure">
				<?php echo $total_unique_sessions; ?>
			</div>
			<div class="box-figure-remark">
				<?php echo lang('total_unique_login_sessions'); ?>
			</div>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="box">
			<h4 class="box-title"><?php echo lang('top5_user_stats'); ?></h4>
			<?php if ( !isset($top_machine_group_logon_chart_data) || !iterable($top_machine_group_logon_chart_data) ): ?>
			<p class="text-danger"><?php echo lang('txt_no_top_machine_group_sessions'); ?></p>
			<?php else: ?>
			<div class="chart"
				data-name="top_user_logon"
				data-chart="piechart"
				data-data="<?php echo htmlentities(json_encode($top_machine_group_logon_chart_data)); ?>"
				data-columns="<?php echo htmlentities(json_encode(array(
					array('string', lang('machine_group')),
					array('number', lang('logon_sessions')),
				))); ?>"
				data-options="<?php echo htmlentities(json_encode(array(
					'width' => '100%',
					'height' => '126',
					'chartArea' => array(
						'width' => '90%',
						'height' => '90%',
					),
				))); ?>"></div>
			<?php endif; ?>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<h3><?php echo lang('user_sessions_statistics_weekly'); ?></h3>
	</div>
	<div class="col-md-3">
		<div class="list-group" id="user-session-weekly">
			<?php if ( isset($top_machine_group_weekly) && iterable($top_machine_group_weekly) ): ?>
			<?php
			foreach ( $top_machine_group_weekly as $index => $machine_group ) {
				$code = $machine_group['code'];
				$name = $machine_group['name'];
				$total_sessions = $machine_group['total_sessions'];
				$class = 'list-group-item';
				
				if ( $index == 0 ) {
					$class .= ' active';
				}
				
				echo '<a href="#" class="' . $class . '" data-machine-group="' . $code . '">';
				echo htmlentities($name);
				echo '<span class="badge">' . $total_sessions . '</span>';
				echo '</a>';
			}
			?>
			<?php endif; ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-no-margin">
			<h4 class="box-title">
				<?php
				$monday_time = strtotime('monday this week');
				$sunday_time = strtotime('sunday this week');
				$monday = date('D j/n/Y', $monday_time);
				$sunday = date('D j/n/Y', $sunday_time);
				
				echo $monday . ' - ' . $sunday;
				?></h4>
			<div class="chart"
				data-name="user_sessions_statistic_weekly"
				data-chart="linechart"
				data-data="<?php echo htmlentities(json_encode($top_machine_group_weekly_chart_data)); ?>"
				data-columns="<?php echo htmlentities(json_encode(array(
					array('string', lang('date')),
					array('number', lang('logon_sessions')),
				))); ?>"
				data-options="<?php echo htmlentities(json_encode(array(
					'width' => '100%',
					'height' => '140',
					'legend' => array(
						'position' => 'none',
					),
					'vAxis' => array(
						'format' => '#',
					),
					'pointSize' => 5,
					'chartArea' => array(
						'width' => '90%',
						'height' => '70%',
					),
				))); ?>"></div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-no-margin" id="top-active-profile-weekly">
			<h4 class="box-title"><?php
			echo lang('top_active_profile');
			?></h4>
			<div class="slimscroll" data-toggle="slimscroll" data-height="140">
				<ul class="item-list">
				<?php
				if ( iterable($top_user_weekly_list) ) {
					foreach ( $top_user_weekly_list as $user_data ) {
						$user_id = $user_data['id'];
						$user_name = $user_data['name'];
						$user_ad_group = $user_data['group'];
						$last_connected_machine = $user_data['last_connected_machine'];
						
						echo '<li>';
						echo '<span class="item-title"><i class="fa fa-user"></i> ' . htmlentities($user_name) . '</span>';
						echo '<span class="sub-line">' . $last_connected_machine . '</span>';
						echo '</li>';
					}
				} ?>
				</ul>
				<p class="text-danger no-result<?php
				if ( iterable($top_user_weekly_list) ) {
					echo ' hidden';
				}
				?>"><?php echo lang('txt_no_active_profile'); ?></p>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<h3><?php echo lang('user_sessions_statistics_monthly'); ?></h3>
	</div>
	<div class="col-md-3">
		<div class="list-group" id="user-session-monthly">
			<?php if ( isset($top_machine_group_monthly) && iterable($top_machine_group_monthly) ): ?>
			<?php
			foreach ( $top_machine_group_monthly as $index => $machine_group ) {
				$code = $machine_group['code'];
				$name = $machine_group['name'];
				$total_sessions = $machine_group['total_sessions'];
				$class = 'list-group-item';
				
				if ( $index == 0 ) {
					$class .= ' active';
				}
				
				echo '<a href="#" class="' . $class . '" data-machine-group="' . $code . '">';
				echo htmlentities($name);
				echo '<span class="badge">' . $total_sessions . '</span>';
				echo '</a>';
			}
			?>
			<?php endif; ?>
		</div>
	</div>
	<div class="col-md-9">
		<div class="box box-no-margin">
			<h4 class="box-title">
				<?php
				$start_date = date('1/n/Y');
				$end_date = date('t/n/Y');
				
				echo $start_date . ' - ' . $end_date;
				?></h4>
			<div class="chart"
				data-name="user_sessions_statistic_monthly"
				data-chart="columnchart"
				data-data="<?php echo htmlentities(json_encode($top_machine_group_monthly_chart_data)); ?>"
				data-columns="<?php echo htmlentities(json_encode(array(
					array('string', lang('date')),
					array('number', lang('logon_sessions')),
				))); ?>"
				data-options="<?php echo htmlentities(json_encode(array(
					'width' => '100%',
					//'height' => '150',
					'legend' => array(
						'position' => 'none',
					),
					'vAxis' => array(
						'format' => '#',
					),
					'pointSize' => 5,
					'chartArea' => array(
						'width' => '90%',
						'height' => '70%',
					),
				))); ?>"></div>
		</div>
	</div>
</div>