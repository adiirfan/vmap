<?php 
$CI =& get_instance();
$template = $CI->template;

$auth = $CI->authentication;
$sys_user_model = $auth->get_model();
$user_name = $sys_user_model->get_value('sys_user_name');
$user_type = $sys_user_model->get_value('sys_user_type');
$business_model = $sys_user_model->get_business_model(); // this might be null.

// Notification messages.
$messages = $CI->system->get_message();

// Assign CSS and javascript.
$template->set_css('!/css/font-awesome.min.css');
$template->set_css('~/css/default.css');
$template->set_js('!/js/jquery.fullscreen-min.js');
$template->set_js('~/js/init.js');
?>

<?php if ( iterable($messages) ): ?>
<div class="message">
	<?php foreach ( $messages as $message ): ?>
	<div class="alert alert-<?php echo $message['type']; ?>">
		<?php if ( isset($message['icon']) && !is_empty($message['icon']) ): ?>
		<span class="<?php echo $message['icon']; ?>"></span>
		<?php endif; ?>
		
		<?php echo $message['message']; ?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<?php endforeach; ?>
</div>
<?php endif; ?>

<div class="wrapper">
	<header class="topbar">
		<div class="logo">
			<img src="http://<?php echo $_SERVER['HTTP_HOST'];?>/images/vmap_logo_grey.png" width="100px" style="padding-top: 5px; padding-bottom: 10px;" data-pin-nopin="true">
		</div>
		
		<a class="button btn-menu-toggle" id="btn-menu-toggle">
			<i class="fa fa-bars"></i>
		</a>
		
		<ul class="nav navbar-nav navbar-right">
			<li class="notification">
				<a href="javascript: void(0);">
					<i class="fa fa-globe"></i>
				</a>
			</li>
			<li class="dropdown profile">
				<a href="javascript: void(0);" aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown">
					<span class="profile-block">
						<span class="avatar">
							<i class="fa fa-user"></i>
						</span>
						<span class="name">
							<?php echo $user_name; ?>
							
						</span>
						<span class="caret"></span>
					</span>
				</a>
				<ul class="dropdown-menu" role="menu">
					<?php if ( $user_type != 'superadmin' ): ?>
					<li role="presentation" class="dropdown-header">
						<?php
						$connected_agents = intval($business_model->get_value('business_connected_agent'));
						$max_agents = intval($business_model->get_value('business_max_agent'));
						$percentage = round($connected_agents / $max_agents * 100);
						
						if ( $percentage < 50 ) {
							$context_class = ' progress-bar-success';
						} else if ( $percentage < 70 ) {
							$context_class = ' progress-bar-warning';
						} else {
							$context_class = ' progress-bar-danger';
						}
						?>
						<h6 class="text-center"><?php echo lang('connected_agents'); ?> (<?php echo $connected_agents . '/' . $max_agents; ?>)</h6>
						<div class="progress">
							<div class="progress-bar<?php echo $context_class; ?>" role="progressbar" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentage; ?>%">
								<?php echo $percentage; ?>%
							</div>
						</div>
					</li>
					<?php else: ?>
					<li role="presentation" class="dropdown-header">
						<?php
						$total_business = get_total_business();
						$total_agent = get_total_agent();
						
						if ( $total_business ) {
						?>
						<h6 class="text-center">
							<?php echo _lang('_txt_admin_topmenu_summary', $total_business, $total_agent); ?>
						</h6>
						<?php
						} else {
						?>
						<h6 class="text-center">
							<?php echo lang('txt_no_business'); ?>
						</h6>
						<div class="text-center">
							<button href="<?php echo site_url('business/add'); ?>" class="btn btn-primary btn-xs" onclick="window.location='<?php echo site_url('business/add'); ?>'">
								<i class="glyphicon glyphicon-plus"></i>
								<?php echo lang('create_business'); ?>
							</button>
						</div>
						<?php
						}
						?>
					</li>
					<?php endif; ?>
					<li class="divider" role="presentation"></li>
					<li role="presentation">
						<a href="<?php echo site_url('sys_user/profile'); ?>">
							<i class="fa fa-user"></i>
							<?php echo lang('menu_my_account'); ?>
						</a>
					</li>
					<?php
					/*
					<?php if ( $user_type != 'viewer' ): ?>
					<li role="presentation">
						<a href="">
							<i class="fa fa-cog"></i>
							<?php echo lang('menu_settings'); ?>
						</a>
					</li>
					<?php endif; ?>
					*/
					?>
					<li role="presentation">
						<a href="<?php echo site_url('logout'); ?>">
							<i class="fa fa-sign-out"></i>
							<?php echo lang('menu_signout'); ?>
						</a>
					</li>
				</ul>
			</li>
			<li class="fullscreen-item">
				<a href="javascript: void(0);" data-toggle="fullscreen">
					<i class="fa fa-expand icon"></i>
				</a>
			</li>
		</ul>
	</header>
	
	<div class="sidebar">
		<nav class="sidebar-nav">
			<ul class="nav">
				<li<?php echo uri_check('/^(?:dashboard||dashboard\?.*)$/', ' class="open"'); ?>>
					<a href="<?php echo site_url('dashboard'); ?>">
						<i class="nav-icon fa fa-tachometer"></i>
						<span class="nav-label"><?php echo lang('menu_dashboard'); ?></span>
					</a>
				</li>
				<li class="has-child<?php echo uri_check('/^user/', ' open'); ?>">
					<a href="#">
						<i class="nav-icon fa fa-users"></i>
						<span class="nav-label">
							<?php echo lang('menu_users'); ?>
							<span class="sidebar-caret fa fa-caret-right"></span>
						</span>
					</a>
					<ul class="sub-menu nav">
						<li<?php echo uri_check('/^user\/overview$/', ' class="active"'); ?>>
							<a href="<?php echo site_url('user/overview'); ?>">
								<i class="fa fa-area-chart"></i>
								<?php echo lang('menu_user_overview'); ?>
							</a>
						</li>
						<li<?php echo uri_check('/^user\/(?:index\??.*|detail\/\d+)$/', ' class="active"'); ?>>
							<a href="<?php echo site_url('user/index'); ?>">
								<i class="fa fa-list"></i>
								<?php echo lang('menu_user_list'); ?>
							</a>
						</li>
					</ul>
				</li>
				<li class="has-child<?php echo uri_check('/^(?:app|app\/)/', ' open'); ?>">
					<a href="#">
						<i class="nav-icon fa fa-windows"></i>
						<span class="nav-label">
							<?php echo lang('menu_applications'); ?>
							<span class="sidebar-caret fa fa-caret-right"></span>
						</span>
					</a>
					<ul class="sub-menu nav">
						<li<?php echo uri_check('/^app\/overview\??/', ' class="active"'); ?>>
							<a href="<?php echo site_url('app/overview'); ?>">
								<i class="fa fa-area-chart"></i>
								<?php echo lang('menu_application_overview'); ?>
							</a>
						</li>
						<li<?php echo uri_check('/^(?:app\/index|app\/detail)\/?/', ' class="active"'); ?>>
							<a href="<?php echo site_url('app/index'); ?>">
								<i class="fa fa-list"></i>
								<?php echo lang('menu_application_list'); ?>
							</a>
						</li>
						<li<?php echo uri_check('/^app\/(?:inventory|inv_detail)/', ' class="active"'); ?>>
							<a href="<?php echo site_url('app/inventory'); ?>">
								<i class="fa fa-list-alt"></i>
								<?php echo lang('menu_application_inventory'); ?>
							</a>
						</li>
					</ul>
				</li>
				<li class="has-child<?php echo uri_check('/^(?:machine\/|machine_group\/)/', ' open'); ?>">
					<a href="#">
						<i class="nav-icon fa fa-desktop"></i>
						<span class="nav-label">
							<?php echo lang('menu_machines'); ?>
							<span class="sidebar-caret fa fa-caret-right"></span>
						</span>
					</a>
					<ul class="sub-menu nav">
						<li<?php echo uri_check('/^machine\/overview/', ' class="active"'); ?>>
							<a href="<?php echo site_url('machine/overview'); ?>">
								<i class="fa fa-area-chart"></i>
								<?php echo lang('menu_machine_overview'); ?>
							</a>
						</li>
						<li<?php echo uri_check('/^(?:machine\/index|machine\/detail)/', ' class="active"'); ?>>
							<a href="<?php echo site_url('machine/index'); ?>">
								<i class="fa fa-list"></i>
								<?php echo lang('menu_machine_list'); ?>
							</a>
						</li>
						<li<?php echo uri_check('/^(?:machine\/inventory|machine\/inv_detail\/\d+)/', ' class="active"'); ?>>
							<a href="<?php echo site_url('machine/inventory'); ?>">
								<i class="fa fa-list-alt"></i>
								<?php echo lang('menu_machine_inventory'); ?>
							</a>
						</li>
						<li<?php echo uri_check('/^(?:machine\_group\/index|machine_group\/detail|machine_group\/edit\/\d+)/', ' class="active"'); ?>>
							<a href="<?php echo site_url('machine_group/index'); ?>">
								<i class="fa fa-th"></i>
								<?php echo lang('menu_machine_group'); ?>
							</a>
						</li>
					</ul>
				</li>
				<li class="has-child<?php echo uri_check('/^filter\/?/', ' open'); ?>">
					<a href="#">
						<i class="nav-icon fa fa-filter"></i>
						<span class="nav-label">
							<?php echo lang('menu_filters'); ?>
							<span class="sidebar-caret fa fa-caret-right"></span>
						</span>
					</a>
					<ul class="sub-menu nav">
						<li<?php echo uri_check('/^filter\/app\/?/', ' class="active"'); ?>>
							<a href="<?php echo site_url('filter/app'); ?>">
								<?php echo lang('menu_filter_app'); ?>
							</a>
						</li>
						<li<?php echo uri_check('/^filter\/machine\/?/', ' class="active"'); ?>>
							<a href="<?php echo site_url('filter/machine'); ?>">
								<?php echo lang('menu_filter_machine'); ?>
							</a>
						</li>
						<li<?php echo uri_check('/^filter\/user\/?/', ' class="active"'); ?>>
							<a href="<?php echo site_url('filter/user'); ?>">
								<?php echo lang('menu_filter_user'); ?>
							</a>
						</li>
					</ul>
				</li>
				<?php if ( $user_type == 'superadmin' ): ?>
				<li class="has-child<?php echo uri_check('/^(?:business\/?|sys_user\/?)/', ' open'); ?>">
					<a href="#">
						<i class="nav-icon fa fa-building"></i>
						<span class="nav-label">
							<?php echo lang('menu_businesses'); ?>
							<span class="sidebar-caret fa fa-caret-right"></span>
						</span>
					</a>
					<ul class="sub-menu nav">
						<li<?php echo uri_check('/^business\/add/', ' class="active"'); ?>>
							<a href="<?php echo site_url('business/add'); ?>">
								<i class="fa fa-plus"></i>
								<?php echo lang('menu_business_add'); ?>
							</a>
						</li>
						<li<?php echo uri_check('/^(?:business|business\/index|business\/profile\/.*|business\/edit\/\d+)$/', ' class="active"'); ?>>
							<a href="<?php echo site_url('business'); ?>">
								<i class="fa fa-list"></i>
								<?php echo lang('menu_business_list'); ?>
							</a>
						</li>
						<li<?php echo uri_check('/^business\/user\/?/', ' class="active"'); ?>>
							<a href="<?php echo site_url('business/user'); ?>">
								<i class="fa fa-users"></i>
								<?php echo lang('menu_business_users'); ?>
							</a>
						</li>
						
					</ul>
				</li>
				<li class="has-child<?php echo uri_check('/^(?:license\/?|sys_user\/?)/', ' open'); ?>">
					<a href="#">
						<i class="nav-icon fa fa-building"></i>
						<span class="nav-label">
							License
							<span class="sidebar-caret fa fa-caret-right"></span>
						</span>
					</a>
					<ul class="sub-menu nav">
						<li<?php echo uri_check('/^license\/user\/?/', ' class="active"'); ?>>
							<a href="<?php echo site_url('license/add'); ?>">
								<i class="fa fa-users"></i>
								<?php echo "License Input";?>
							</a>
						</li>
						
						
					</ul>
				</li>
			
				<?php endif; ?>
			</ul>
		</nav>
	</div>
	
	<div class="main-content">
		<div class="container-fluid">
			<?php echo $content; ?>
		</div>
	</div>
	
</div>

<div class="modal fade" id="modal-loading" data-backdrop="static" data-keyboard="false" data-show="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title"><?php echo lang('loading'); ?></h4>
      </div>
      <div class="modal-body">
      	<p class="text-center loading-text">
          <i class="fa fa-circle-o-notch fa-spin"></i>
        </p>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->