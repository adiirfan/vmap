	
<h2 class="page-title">
	<?php echo lang('dashboard'); ?><br>
	<?php if (isset($_SESSION['pesan2'])){
      
	 $var1= $_SESSION['pesan3'];
	 $var2= $_SESSION['pesan2'];
	  $var3= $_SESSION['pesan4'];
	   $var4= $_SESSION['pesan5'];
		 $i='style="display: block !important;";';
 
		  $pesan = "Thanks For your purchase,here is the detail:<br>Your App Code :$var2<br>Your Key : $var1<br>Life Time :$var3 Month<br>Added PC: :$var4<br>";
		  unset( $_SESSION['pesan2'] );
	}else {
		$i= 'style="display: none !important;";';
	} ?>
	<div class="pull-right">
		<select class="form-control" id="dropdown-machine-group">
			<option value="">- <?php echo lang('select_a_machine_group'); ?> -</option>
			<?php if ( isset($machine_group_option_list) && iterable($machine_group_option_list) ): ?>
				<?php foreach ( $machine_group_option_list as $value => $text ): ?>
					<?php if ( $this->input->get('machine_group') == $value ): ?>
			<option value="<?php echo htmlentities($value); ?>" selected="selected"><?php echo htmlentities($text); ?></option>
					<?php else: ?>
			<option value="<?php echo htmlentities($value); ?>"><?php echo htmlentities($text); ?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</select>
	</div>
	<div class="clearfix"></div>
</h2>

<div class="row">
	<div class="col-md-4">
		<div class="box box-baby-blue">
			<i class="fa fa-user box-icon"></i>
			<div class="box-big-figure">
				<?php echo $total_online_users; ?>
			</div>
			<div class="box-figure-remark">
				<?php echo lang('online_users'); ?>
			</div>
		</div>
		
		<div class="box">
			<i class="fa fa-desktop box-icon"></i>
			<div class="box-big-figure">
				<?php echo $total_machines; ?>
			</div>
			<div class="box-figure-remark">
				<?php echo lang('total_no_of_machines'); ?>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box">
			<i class="fa fa-windows box-icon"></i>
			<div class="box-big-figure">
				<?php echo $total_apps; ?>
			</div>
			<div class="box-figure-remark">
				<?php echo lang('total_no_of_apps'); ?>
			</div>
		</div>
		
		<div class="box box-blue">
			<i class="fa fa-users box-icon"></i>
			<div class="box-big-figure">
				<?php echo $total_users; ?>
			</div>
			<div class="box-figure-remark">
				<?php echo lang('total_no_of_users'); ?>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box">
			<h4 class="box-title">User statistic by machine group</h4>
			<?php if ( !isset($user_statistics) || !iterable($user_statistics) ): ?>
				<p class="text-danger"><?php echo lang('txt_no_user_statistics'); ?></p>
			<?php else: ?>
				<div class="chart"
					data-chart="piechart"
					data-data="<?php echo htmlentities(json_encode($user_statistics['chart_data'])); ?>"
					data-columns="<?php echo htmlentities(json_encode(array(
						array('string', lang('machine_group')),
						array('number', lang('logon_sessions')),
					))); ?>"
					data-options="<?php echo htmlentities(json_encode(array(
						'width' => '100%',
						'height' => '125',
						'chartArea' => array(
							'width' => '100%',
							'height' => '90%',
						),
						/*'legend' => array(
							'position' => 'none',
						),*/
					))); ?>"></div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php
// Application Usage Statistics
$app_data = array_ensure($application_statistics, 'data', array());
$app_date = array_ensure($app_data, 'date', lang('all_time'));
$app_chart_data = array_ensure($app_data, 'chart_data', array());
$app_top_list = array_ensure($app_data, 'top_apps', array());

if ( is_empty($app_date) ) {
	$app_date = lang('all_time');
} else if ( iterable($app_date) ) {
	$tmp_date = $app_date;
	$app_date = '';
	
	foreach ( $tmp_date as $d ) {
		$t = strtotime($d);
		
		if ( false !== $t ) {
			$app_date .= user_date($t, 'j M Y') . ' - ';
		}
	}
	
	$app_date = rtrim($app_date, ' - ');
} else {
	$t = strtotime($app_date);
	
	if ( false !== $t ) {
		$app_date = user_date($t, 'j M Y');
	}
}
?>
<div class="row">
	<div class="col-xs-12">
		<h3><?php echo lang('application_usage_statistic'); ?></h3>
	</div>
	<div class="col-md-3">
		<div class="list-group" id="application-usage-period">
			<a class="list-group-item active" href="#" data-period="all time">
				<?php echo lang('all_time'); ?>
				<span class="badge"><?php echo $application_statistics['all_time']; ?></span>
			</a>
			<a class="list-group-item" href="#" data-period="today">
				<?php echo lang('today'); ?>
				<span class="badge"><?php echo $application_statistics['today']; ?></span>
			</a>
			<a class="list-group-item" href="#" data-period="this week">
				<?php echo lang('this_week'); ?>
				<span class="badge"><?php echo $application_statistics['this_week']; ?></span>
			</a>
			<a class="list-group-item" href="#" data-period="this month">
				<?php echo lang('this_month'); ?>
				<span class="badge"><?php echo $application_statistics['this_month']; ?></span>
			</a>
			<a class="list-group-item" href="#" data-period="this year">
				<?php echo lang('this_year'); ?>
				<span class="badge"><?php echo $application_statistics['this_year']; ?></span>
			</a>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-no-margin">
			<h4 class="box-title" id="app-chart-title"><?php echo htmlentities($app_date); ?></h4>
			<div class="chart"
				data-name="app_usage"
				data-chart="linechart"
				data-data="<?php echo htmlentities(json_encode($app_chart_data)); ?>"
				data-columns="<?php echo htmlentities(json_encode(array(
					array('string', lang('date')),
					array('number', lang('app_instances')),
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
					'curveType' => 'function',
					'chartArea' => array(
						'width' => '90%',
						'height' => '70%',
					),
				))); ?>"></div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-no-margin">
			<h4 class="box-title"><?php echo lang('top_applications'); ?></h4>
			<div id="top-apps">
				<div class="slimscroll" data-toggle="slimscroll" data-height="140">
					<ul class="item-list">
						<?php
						if ( iterable($app_top_list) ) {
							foreach ( $app_top_list as $app ) {
								$app_name = $app['name'];
								$app_instances = $app['instance_word'];
								echo '<li>';
								echo '<span class="item-title"><i class="fa fa-windows"></i> ' . str_truncate($app_name, 25) . '</span>';
								echo '<span class="sub-line">' . $app_instances . '</span>';
								echo '</li>';
							}
						}
						?>
					</ul>
				
					<p class="text-danger no-result<?php
					if ( iterable($app_top_list) ) {
						echo ' hidden';
					}
					?>"><?php echo lang('txt_no_applications_found'); ?></p>
				
				</div>
			</div>
		</div>
	</div>
</div>

<?php
// Machine Usage Statistics
$machine_data = array_ensure($machine_statistics, 'data', array());
$machine_date = array_ensure($machine_data, 'date', lang('all_time'));
$machine_chart_data = array_ensure($machine_data, 'chart_data', array());
$machine_top_list = array_ensure($machine_data, 'top_machines', array());

if ( is_empty($machine_date) ) {
	$machine_date = lang('all_time');
} else if ( iterable($machine_date) ) {
	$tmp_date = $machine_date;
	$machine_date = '';
	
	foreach ( $tmp_date as $d ) {
		$t = strtotime($d);
		
		if ( false !== $t ) {
			$machine_date .= user_date($t, 'j M Y') . ' - ';
		}
	}
	
	$machine_date = rtrim($machine_date, ' - ');
} else {
	$t = strtotime($machine_date);
	
	if ( false !== $t ) {
		$machine_date = user_date($t, 'j M Y');
	}
}
?>
<div class="row">
	<div class="col-xs-12">
		<h3><?php echo lang('machine_usage_statistic'); ?></h3>
	</div>
	
	<div class="col-md-3">
		<div class="list-group" id="machine-usage-period">
			<a class="list-group-item active" href="#" data-period="all time">
				<?php echo lang('all_time'); ?>
				<span class="badge"><?php echo $machine_statistics['all_time']; ?></span>
			</a>
			<a class="list-group-item" href="#" data-period="today">
				<?php echo lang('today'); ?>
				<span class="badge"><?php echo $machine_statistics['today']; ?></span>
			</a>
			<a class="list-group-item" href="#" data-period="this week">
				<?php echo lang('this_week'); ?>
				<span class="badge"><?php echo $machine_statistics['this_week']; ?></span>
			</a>
			<a class="list-group-item" href="#" data-period="this month">
				<?php echo lang('this_month'); ?>
				<span class="badge"><?php echo $machine_statistics['this_month']; ?></span>
			</a>
			<a class="list-group-item" href="#" data-period="this year">
				<?php echo lang('this_year'); ?>
				<span class="badge"><?php echo $machine_statistics['this_year']; ?></span>
			</a>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-no-margin">
			<h4 class="box-title" id="machine-chart-title"><?php echo htmlentities($machine_date); ?></h4>
			<div class="chart"
				data-name="machine_usage"
				data-chart="linechart"
				data-data="<?php echo htmlentities(json_encode($machine_chart_data)); ?>"
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
					'curveType' => 'function',
					'chartArea' => array(
						'width' => '90%',
						'height' => '70%',
					),
				))); ?>"></div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-no-margin">
			<h4 class="box-title"><?php echo lang('top_machines'); ?></h4>
			<div id="top-machines">
				<div class="slimscroll" data-toggle="slimscroll" data-height="140">
					<ul class="item-list">
						<?php
						if ( iterable($machine_top_list) ) {
							foreach ( $machine_top_list as $machine ) {
								$machine_name = $machine['name'];
								$sessions = $machine['session_word'];
								
								echo '<li>';
								echo '<span class="item-title"><i class="fa fa-desktop"></i> ' . $machine_name . '</span>';
								echo '<span class="sub-line">' . $sessions . '</span>';
								echo '</li>';
							}
						}
						?>
					</ul>
					
					<p class="text-danger no-result<?php
					if ( iterable($app_top_list) ) {
						echo ' hidden';
					}
					?>"><?php echo lang('txt_no_applications_found'); ?></p>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="boxes"  <?php echo $i; ?>>
	<div style="display: none;" id="dialog2" class="window"> 
	<div id="san">
	<a href="#" class="close agree">X</a><br>
	<p>SUCCESS</p>
	<p><?php echo $pesan;?></p>
	<br>
	</div>
	</div>
	<div style="width: 2478px; font-size: 32pt; color:white; height: 1202px; display: none; opacity: 0.4;" id="mask"></div>
</div>