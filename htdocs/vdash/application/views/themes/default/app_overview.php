<h2 class="page-title">
	<?php echo lang('app_overview'); ?>
	<div class="pull-right form-inline">
		<?php if ( isset($business_option_list) && iterable($business_option_list) ): ?>
		<select class="form-control" id="dropdown-business">
			<option value="">- <?php echo lang('txt_select_a_business'); ?> -</option>
			<?php foreach ( $business_option_list as $value => $text ): ?>
			<?php $selected = ''; ?>
			<?php if ( $this->input->get('business') == $value ) { $selected = ' selected="selected"'; } ?>
			<option value="<?php echo $value; ?>"<?php echo $selected; ?>><?php echo htmlentities($text); ?></option>
			<?php endforeach; ?>
		</select>
		<?php endif; ?>
		<label for="dropdown-date" class="small"><?php echo lang('txt_select_a_date'); ?></label>
		<select class="form-control" id="dropdown-date">
			<?php foreach ( $date_options as $val => $text ) {
				$output_text = lang($val);
				$selected = '';
				
				if ( $this->input->get('date') == $text ) {
					$selected = ' selected="selected"';
				}
				
				echo '<option value="' . $text . '"' . $selected . '>' . $output_text . '</option>';
			}
			?>
		</select>
	</div>
	<div class="clearfix"></div>
</h2>

<div class="row">
	<div class="col-md-4">
		<div class="box box-baby-blue">
			<i class="fa fa-sign-in box-icon"></i>
			<div class="box-big-figure">
				<?php echo $total_sessions; ?>
			</div>
			<div class="box-figure-remark">
				<?php echo lang('app_total_sessions'); ?>
			</div>
			<?php if ( isset($total_sessions_chart) && iterable($total_sessions_chart) ): ?>
			<div class="chart"
				data-chart="columnchart"
				data-data="<?php echo htmlentities(json_encode($total_sessions_chart)); ?>"
				data-columns="<?php echo htmlentities(json_encode(array(
					array('string', lang('date')),
					array('number', lang('sessions')),
				))); ?>"
				data-options="<?php echo htmlentities(json_encode(array(
					'width' => '100%',
					'height' => '100',
					'legend' => array(
						'position' => 'none',
					),
					'backgroundColor' => array(
						'fill' => 'transparent',
					),
					'vAxis' => array(
						'gridlines' => array(
							'color' => 'transparent',
						),
						'baselineColor' => 'transparent',
					),
					'series' => array(
						0 => array(
							'color' => '#ffffff',
						),
					),
					'chartArea' => array(
						'width' => '100%',
						'height' => '90%',
					),
				))); ?>"></div>
			<?php endif; ?>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="box">
			<i class="fa fa-windows box-icon"></i>
			<div class="box-big-figure">
				<?php echo $total_apps; ?>
			</div>
			<div class="box-figure-remark">
				<?php echo lang('app_total_applications'); ?>
			</div>
			<?php if ( isset($total_apps_chart) && iterable($total_apps_chart) ): ?>
			<div class="chart"
				data-chart="columnchart"
				data-data="<?php echo htmlentities(json_encode($total_apps_chart)); ?>"
				data-columns="<?php echo htmlentities(json_encode(array(
					array('string', lang('date')),
					array('number', lang('application')),
				))); ?>"
				data-options="<?php echo htmlentities(json_encode(array(
					'width' => '100%',
					'height' => '100',
					'legend' => array(
						'position' => 'none',
					),
					'backgroundColor' => array(
						'fill' => 'transparent',
					),
					'vAxis' => array(
						'gridlines' => array(
							'color' => 'transparent',
						),
						'baselineColor' => 'transparent',
					),
					'series' => array(
						0 => array(
							'color' => '#333',
						),
					),
					'chartArea' => array(
						'width' => '100%',
						'height' => '90%',
					),
				))); ?>"></div>
			<?php endif; ?>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="box">
			<i class="fa fa-hourglass-start box-icon"></i>
			<div class="box-big-figure">
				<?php echo $total_utilization; ?>
			</div>
			<div class="box-figure-remark">
				<?php echo lang('app_total_utilization'); ?>
			</div>
			<?php if ( isset($total_utilization_chart) && iterable($total_utilization_chart) ): ?>
			<div class="chart"
				data-chart="columnchart"
				data-data="<?php echo htmlentities(json_encode($total_utilization_chart)); ?>"
				data-columns="<?php echo htmlentities(json_encode(array(
					array('string', lang('date')),
					array('number', lang('seconds')),
				))); ?>"
				data-options="<?php echo htmlentities(json_encode(array(
					'width' => '100%',
					'height' => '100',
					'legend' => array(
						'position' => 'none',
					),
					'backgroundColor' => array(
						'fill' => 'transparent',
					),
					'vAxis' => array(
						'gridlines' => array(
							'color' => 'transparent',
						),
						'baselineColor' => 'transparent',
					),
					'series' => array(
						0 => array(
							'color' => '#333',
						),
					),
					'chartArea' => array(
						'width' => '100%',
						'height' => '90%',
					),
				))); ?>"></div>
			<?php endif; ?>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-title">
				<h4 style="margin-bottom: 0px; float: left;"><?php echo lang('app_usage_activity'); ?></h4>
				<div class="calendar-box pull-right">
					<i class="fa fa-calendar"></i>&nbsp;
					<input type="hidden" class="calendar-input" value="" />
					<span class="calendar-text"></span>
					<i class="caret"></i>
				</div>
				<div class="clearfix"></div>
			</div>
			<div id="graph-area"></div>
			<div id="graph-loading" class="text-center">
				<i class="fa fa-spinner fa-spin"></i>
				<?php echo lang('loading'); ?>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="box">
			<h4 class="box-title"><?php echo lang('app_concurrent_usage'); ?></h4>
			<?php
			if ( isset($top5_app_concurrent) && iterable($top5_app_concurrent) ) {
				echo '<ul class="item-list item-list-inline">';
				foreach ( $top5_app_concurrent as $app ) {
					echo '<li>';
					echo '<span class="item-title"><i class="fa fa-windows"></i> ' . htmlentities($app['app_friendly_name']) . '</span>';
					echo '<span class="item-info"><span class="label label-default">' . $app['concurrent_instances'] . '</span></span>';
					echo '</li>';
				}
				echo '</ul>';
			} else {
				echo '<p class="text-danger">';
				echo lang('txt_app_no_current_result');
				echo '</p>';
			}
			?>
		</div>
	</div>
	
	<div class="col-md-8">
		<div class="box">
			<h4 class="box-title"><?php echo lang('app_top_usage'); ?></h4>
			<?php
			if ( isset($top5_app_usage) && iterable($top5_app_usage) ) {
			?>
			<div class="row">
				<div class="col-md-6">
					<ul class="item-list item-list-inline">
						<?php foreach ( $top5_app_usage as $app ): ?>
						<li>
							<span class="item-title"><i class="fa fa-windows"></i> <?php echo htmlentities($app[0]); ?></span>
							<span class="item-info">
								<span class="label label-default">
									<?php echo $app[1]; ?>
								</span>
							</span>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="col-md-6">
					<div class="chart"
						data-chart="piechart"
						data-data="<?php echo htmlentities(json_encode($top5_app_usage)); ?>"
						data-columns="<?php echo htmlentities(json_encode(array(
							array('string', lang('application')),
							array('number', lang('instances')),
						))); ?>"
						data-options="<?php echo htmlentities(json_encode(array(
							'width' => '100%',
							'height' => '150',
							'legend' => array(
								'position' => 'none',
							),
							'chartArea' => array(
								'width' => '100%',
								'height' => '90%',
							),
						))); ?>"></div>
				</div>
			</div>
			<?php
			} else {
				echo '<p class="text-danger">';
				echo lang('txt_app_no_usage');
				echo '</p>';
			}
			?>
		</div>
	</div>
</div>