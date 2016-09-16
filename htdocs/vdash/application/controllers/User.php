<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends EB_Controller {
	
	public function a_set_visibility()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny();
		}
		
		$this->load->model('User_model', 'user_model');
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		$token = $this->input->get('token');
		$user_id = intval($this->input->get('user_id'));
		$visibility = $this->input->get('visibility');
		$visibility = ($visibility ? 1 : 0);
		
		// Verify the token.
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->user_model->load(array(
				'user_id' => $user_id,
			));
			
			if ( $this->user_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_user_id_not_found');
			} else {
				if ( !$this->user_model->set_visibility($visibility) ) {
					$output['error'] = 1;
					$output['message'] = lang('error_user_set_visibility');
				}
			}
		}
		
		json_output($output);
	}
	
	/**
	 * To handle the ajax call for user session statistics.
	 * The period can be weekly or monthly.
	 * 
	 * @param string $period
	 */
	public function a_user_session($period)
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny();
		}
		
		$sys_user_model = $this->authentication->get_model();
		$output = array();
		
		if ( $period == 'weekly' ) {
			$output['chart_data'] = $this->_top_machine_group_chart_data('weekly');
			$output['top_user_list'] = $this->_top_user_list('weekly');
		} else {
			$output['chart_data'] = $this->_top_machine_group_chart_data('monthly');
			$output['top_user_list'] = $this->_top_user_list('monthly');
		}
		
		json_output($output);
	}
	
	public function detail($user_id = 0)
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny(true, 'login');
		}
		
		$this->load->model('User_model', 'user_model');
		
		$this->user_model->load(array(
			'user_id' => $user_id,
		));
		
		if ( $this->user_model->is_empty() ) {
			show_404();
		}
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		
		// Verify this user has the access to this user profile.
		if ( $sys_user_type != 'superadmin' ) {
			$business_model = $sys_user_model->get_business_model();
			$business_id = $business_model->get_value('business_id');
			
			if ( $this->user_model->get_value('business_id') != $business_id ) {
				$this->access_deny(true, 'user/index');
			}
		}
		
		$data = array(
			'user_data' => $this->user_model->get_data(),
			'sum_active_sessions' => 0,
			'sum_application_instances' => 0,
			'total_active_duration' => 0,
			'most_used_application' => null,
			'most_used_machine' => null,
			'top5_used_machines' => null,
			'top5_used_applications' => null,
		);
		
		# Sum of logon sessions.
		$this->db->select('COUNT(*) AS total_sessions');
		$this->db->from('user_sessions');
		$this->db->where('user_id', $user_id);
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			
			$data['sum_active_sessions'] = intval($row['total_sessions']);
		}
		
		# Sum of application launched.
		$this->db->select('COUNT(*) AS total_instances');
		$this->db->from('app_sessions');
		$this->db->join('apps',' app_sessions.app_id = apps.app_id');
		$this->db->join('user_sessions', 'app_sessions.user_session_id = user_sessions.user_session_id');
		$this->db->where(array(
			'user_sessions.user_id' => $user_id,
			'apps.app_visible' => 1,
		));
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			
			$data['sum_application_instances'] = intval($row['total_instances']);
		}
		
		# Total session duration.
		$this->db->select('SUM(
			IF(user_session_duration IS NULL,
				UNIX_TIMESTAMP() - UNIX_TIMESTAMP(user_session_start),
				user_session_duration
			)
		) AS session_duration', false);
		$this->db->from('user_sessions');
		$this->db->where('user_id', $user_id);
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			$seconds = intval($row['session_duration']);
			
			$data['total_active_duration'] = parse_duration($seconds);
		}
		
		# Most used application.
		$this->db->select('apps.*, COUNT(*) AS total_instances');
		$this->db->from('app_sessions');
		$this->db->join('apps', 'app_sessions.app_id = apps.app_id');
		$this->db->join('user_sessions', 'app_sessions.user_session_id = user_sessions.user_session_id');
		$this->db->where(array(
			'user_sessions.user_id' => $user_id,
			'apps.app_visible' => 1,
		));
		$this->db->group_by('app_sessions.app_id');
		$this->db->order_by('total_instances', 'desc');
		$this->db->limit(5);
		$app_qry = $this->db->get();
		
		if ( $app_qry->num_rows() ) {
			$data['most_used_application'] = $app_qry->row_array();
		}
		
		# Most logged on machine.
		$this->db->select('machines.*, COUNT(*) AS logon_sessions');
		$this->db->from('user_sessions');
		$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
		$this->db->group_by('user_sessions.machine_id');
		$this->db->where(array(
			'user_sessions.user_id' => $user_id,
			'machines.machine_visible' => 1,
		));
		$this->db->order_by('logon_sessions', 'desc');
		$this->db->limit(5);
		$machine_qry = $this->db->get();
		
		if ( $machine_qry->num_rows() ) {
			$data['most_used_machine'] = $machine_qry->row_array();
		}
		
		# Top 5 machine logged on.
		if ( $machine_qry->num_rows() ) {
			$data['top5_used_machines'] = array();
			
			foreach ( $machine_qry->result_array() as $row ) {
				$machine_name = $row['machine_name'];
				$logon_sessions = intval($row['logon_sessions']);
				
				$data['top5_used_machines'][] = array($machine_name, $logon_sessions);
			}
		}
		
		# Top 5 application launched.
		if ( $app_qry->num_rows() ) {
			$data['top5_used_applications'] = array();
			
			foreach ( $app_qry->result_array() as $row ) {
				$app_name = $row['app_friendly_name'];
				$launched_sessions = intval($row['total_instances']);
				
				$data['top5_used_applications'][] = array($app_name, $launched_sessions);
			}
		}
		
		# Machine login information table.
		$this->load->library('listings/user_machine_listing', array(
			'user_id' => $user_id,
			'layout' => 'bootstrap_column_listing',
		));
		
		$data['machine_login_list'] = $this->user_machine_listing->render();
		
		# Application usage information table.
		$this->load->library('listings/user_app_listing', array(
			'user_id' => $user_id,
			'layout' => 'bootstrap_column_listing',
		));
		
		$data['application_usage_list'] = $this->user_app_listing->render();
		
		//print_r($data); exit();
		
		$this->template->set_js('!/js/jquery.slimscroll.min.js');
		$this->template->set_js('~/js/slimscroll.initialize.js');
		$this->template->set_js('//www.google.com/jsapi');
		$this->template->set_js('~/js/chart_initialization.js');
		$this->template->set_page_title(lang('page_title_user/detail'));
		$this->template->set_layout('default');
		$this->template->set_content('user_detail');
		$this->template->display($data);
	}
	
	/**
	 * This controller will list the users in the system.
	 * If the user is superadmin, it allow the user to filter
	 * the users by business. Otherwise, it will only shows
	 * the users which under their own business.
	 */
	public function index()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny(true, 'login');
		}
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value("sys_user_type");
		$business_id = 0;
		$per_page = intval($this->input->get('per_page'));
		$per_page_options = array(10, 20, 30, 50, 100);
		
		if ( !in_array($per_page, $per_page_options) ) {
			$per_page = array_first($per_page_options);
		}
		
		$data = array(
			'per_page_options' => $per_page_options,
		);
		
		if ( $sys_user_type != 'superadmin' ) {
			$business_model = $sys_user_model->get_business_model();
			$business_id = $business_model->get_value('business_id');
		}
		
		$this->load->library('forms/user_filter_form', array(
			'action' => 'user/index',
			'method' => 'get',
			'name' => 'user_filter_form',
			'layout' => 'bootstrap_inline',
			'submit_label' => '<i class="fa fa-search"></i> ' . lang('search'),
			'show_business_filter' => ($business_id ? false : true),
		));
		
		$this->load->library('listings/user_listing', array(
			'business_id' => $business_id,
			'layout' => 'bootstrap_column_listing',
			'per_page' => $per_page,
		));
		
		if ( $this->input->get('export') ) {
			$export_file_type = $this->input->get('export');
			
			$last_query = $this->user_listing->get_last_query();
			
			// Remove the limit statement.
			$last_query = preg_replace('/LIMIT \d+/', '', $last_query);
			$last_query = trim($last_query);
			
			$qry = $this->db->query($last_query);
			
			switch ( $export_file_type ) {
				case 'csv':
					// Create the header row.
					$fh = fopen('php://memory', 'w');
					
					fputcsv($fh, array(
						'username',
						'domain',
						'business',
						'ad_group',
						'last_logged_in',
						'usage',
						'status',
					));
					
					if ( $qry->num_rows() ) {
						foreach ( $qry->result_array() as $row ) {
							fputcsv($fh, array(
								$row['user_name'],
								$row['user_domain'],
								$row['business_name'],
								$row['user_ad_group'],
								$row['last_logged_in'],
								$row['usage_duration'],
								$row['user_status'],
							));
						}
					}
					
					ob_start();
					
					fseek($fh, 0);
					
					fpassthru($fh);
					
					$csv = ob_get_clean();
						
					$this->output->set_content_type('application/csv');
					$this->output->set_header('Content-Disposition: attachment; filename=user-list.csv');
					$this->output->set_output($csv);
					
					break;
				case 'pdf':
					// Generate the output in HTML first.
					$this->template->set_index_script('print_pdf');
					$this->template->set_layout('pdf');
					$this->template->set_content('pdf_list');
					
					$data = array();
					
					if ( $qry->num_rows() ) {
						foreach ( $qry->result_array() as $row ) {
							$data[] = array(
								$row['user_name'],
								$row['user_domain'],
								$row['business_name'],
								$row['user_ad_group'],
								$row['last_logged_in'],
								parse_duration($row['usage_duration']),
								$row['user_status'],
							);
						}
					}
					
					$html = $this->template->display(array(
						'header' => array(
							'username',
							'domain',
							'business',
							'ad_group',
							'last_logged_in',
							'usage',
							'status',
						),
						'data' => $data,
						'page_title' => 'User List',
					), true);
					
					require_once('mpdf60/mpdf.php');
					
					$mpdf = new mPDF();
					
					$mpdf->WriteHTML($html);
					
					$mpdf->Output('user-list.pdf', 'I');
					
					break;
			}
		} else {
			$data['page_title'] = lang('user_list');
			$data['filter_form'] = $this->user_filter_form->render();
			$data['list'] = $this->user_listing->render();
			
			$this->template->set_js('~/js/user_list.js');
			$this->template->set_layout('default');
			$this->template->set_content('user_list');
			$this->template->display($data);
		}
	}
	
	public function login()
	{
		if ( $this->authentication->is_authenticated() ) {
			redirect('dashboard');
		}
		
		$this->load->model('Sys_user_model', 'sys_user_model');
		
		$this->load->library('forms/login_form', array(
			'name' => 'login_form',
			'action' => 'login',
			'method' => 'post',
			'layout' => 'login',
			'layout_data' => array(
				'col-label-width' => 'col-sm-4',
				'col-field-width' => 'col-sm-8',
			),
			'submit_label' => lang('login'),
			'models' => array(
				$this->sys_user_model,
			),
		));
		
		if ( $this->login_form->is_submission_succeed() ) {
			redirect('dashboard');
		}
		
		$this->template->set_css('~/css/login.css');
		$this->template->set_layout('fullpage');
		$this->template->set_content('login');
		$this->template->display(array(
			'form' => $this->login_form->render(),
		));
	}
	
	public function logout()
	{
		if ( $this->authentication->is_authenticated() ) {
			$this->authentication->get_model()->logout();
			
			redirect('login');
		}
	}
	
	public function overview()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny(true, 'login');
		}
		
		$this->load->model('Business_model', 'business_model');
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		$business_model = null;
		$business_id = 0;
		
		if ( $sys_user_type != 'superadmin' ) {
			$business_model = $sys_user_model->get_business_model();
			$business_id = $business_model->get_value('business_id');
		}
		
		$data = array(
			'user_type' => $sys_user_type,
			'machine_group_option_list' => get_machine_group_option_list(),
			'total_users' => 0,
			'total_sessions' => 0,
			'total_unique_sessions' => 0,
			'top_machine_group_logon_chart_data' => false,
			'top_machine_group_weekly' => false,
			'top_machine_group_weekly_chart_data' => $this->_top_machine_group_chart_data('weekly'),
			'top_user_weekly_list' => $this->_top_user_list('weekly'),
			'top_machine_group_monthly' => false,
			'top_machine_group_monthly_chart_data' => $this->_top_machine_group_chart_data('monthly'),
		);
		
		$machine_group_info = parse_machine_group($this->input->get('machine_group'));
		$filter_type = $machine_group_info['type'];
		$machine_group_id = $machine_group_info['id'];
		$selected_business_id = $machine_group_info['business_id'];
		
		if ( $selected_business_id && $sys_user_type != 'superadmin' && $selected_business_id != $business_id ) {
			$this->access_deny(true, 'user/overview');
		}
		
		# Total number of users for the selected machine group or business.
		if ( $filter_type == 'machine_group' ) {
			$this->db->select('COUNT(DISTINCT(user_sessions.user_id)) AS total_users');
			$this->db->from('user_sessions');
			$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
			$this->db->join('users', 'user_sessions.user_id = users.user_id');
			$this->db->where(array(
				'machines.machine_group_id' => $machine_group_id,
				'users.user_visible' => 1,
			));
		} else if ( $filter_type == 'business' ) {
			$this->db->select('COUNT(*) AS total_users');
			$this->db->from('users');
			$this->db->where(array(
				'business_id' => $selected_business_id,
				'users.user_visible' => 1,
			));
		} else {
			$this->db->select('COUNT(*) AS total_users');
			$this->db->from('users');
			$this->db->where('users.user_visible', 1);
			
			if ( $business_id ) {
				$this->db->where('users.business_id', $business_id);
			}
		}
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$user_count_row = $qry->row_array();
			$total_users = intval($user_count_row['total_users']);
			
			$data['total_users'] = $total_users;
		}
		
		# Total logon sessions.
		$this->db->select('COUNT(*) AS total_sessions');
		$this->db->from('user_sessions');
		$this->db->join('users', 'user_sessions.user_id = users.user_id');
		$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
		$this->db->where('users.user_visible', 1);
		
		if ( $filter_type == 'machine_group' ) {
			$this->db->where('machines.machine_group_id', $machine_group_id);
		} else if ( $filter_type == 'business' ) {
			$this->db->where('machines.business_id', $selected_business_id);
		} else if ( $business_id ) {
			$this->db->where('machines.business_id', $business_id);
		}
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$session_count_row = $qry->row_array();
			$total_sessions = intval($session_count_row['total_sessions']);
			
			$data['total_sessions'] = $total_sessions;
		}
		
		# Unique logon sessions. (All time logon sessions with unique username)
		$this->db->select('COUNT(DISTINCT(user_sessions.user_id)) AS total_unique_sessions');
		$this->db->from('user_sessions');
		$this->db->join('users', 'user_sessions.user_id = users.user_id');
		$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
		$this->db->where('users.user_visible', 1);
		
		if ( $filter_type == 'machine_group' ) {
			$this->db->where('machines.machine_group_id', $machine_group_id);
		} else if ( $filter_type == 'business' ) {
			$this->db->where('machines.business_id', $selected_business_id);
		} else if ( $business_id ) {
			$this->db->where('machines.business_id', $business_id);
		}
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$unique_session_count_row = $qry->row_array();
			$total_unique_sessions = intval($unique_session_count_row['total_unique_sessions']);
			
			$data['total_unique_sessions'] = $total_unique_sessions;
		}
		
		# Top 5 machine groups that has the most login sessions.
		$max_rows = 5;
		$selected_machine_group_ids = array();
		
		/*
		 * First, we find the total number of logon sessions for the selected criteria.
		 */
		$total_logon_sessions = 0;
		$this->db->select('COUNT(*) AS total_sessions');
		$this->db->from('user_sessions');
		$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
		$this->db->where('machines.machine_visible', 1);
		// We only filter by the business if selected.
		if ( $selected_business_id ) {
			$this->db->where('machines.business_id', $selected_business_id);
		} else if ( $business_id ) {
			$this->db->where('machines.business_id', $business_id);
		}
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			
			$total_logon_sessions = intval($row['total_sessions']);
		}
		
		/*
		 * Now find the most logon sessions for the machine groups.
		 */
		$machine_group_logon_sessions = 0;
		$this->db->select('machine_groups.*, COUNT(*) AS total_sessions');
		$this->db->from('user_sessions');
		$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
		$this->db->join('machine_groups', 'machines.machine_group_id = machine_groups.machine_group_id');
		$this->db->where('machines.machine_visible', 1);
		$this->db->group_by('machines.machine_group_id');
		$this->db->order_by('total_sessions', 'desc');
		$this->db->limit($max_rows);
		
		// We only filter by the business if selected.
		if ( $selected_business_id ) {
			$this->db->where('machines.business_id', $selected_business_id);
		} else if ( $business_id ) {
			$this->db->where('machines.business_id', $business_id);
		}
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$data['top_machine_group_logon_chart_data'] = array();
			
			foreach ( $qry->result_array() as $row ) {
				$mg_id = $row['machine_group_id'];
				$mg_name = $row['machine_group_name'];
				$total_sessions = intval($row['total_sessions']);
				$machine_group_logon_sessions += $total_sessions;
				
				$data['top_machine_group_logon_chart_data'][] = array($mg_name, $total_sessions);
				$selected_machine_group_ids[] = $mg_id;
			}
		}
		
		/*
		 * Now deduct the total logon sessions with the machine group sessions.
		 */
		$total_other_sessions = $total_logon_sessions - $machine_group_logon_sessions;
		$data['top_machine_group_logon_chart_data'][] = array(lang('others'), $total_other_sessions);
		
		# Top 5 user logon sessions in this week.
		$data['top_machine_group_weekly'] = $this->_machine_group_overview_count(($business_id ? $business_id : $selected_business_id), 'weekly');
		$data['top_machine_group_monthly'] = $this->_machine_group_overview_count(($business_id ? $business_id : $selected_business_id), 'monthly');
		
		// print_r($data); exit();
		
		$this->template->set_js('!/js/jquery.slimscroll.min.js');
		$this->template->set_js('~/js/slimscroll.initialize.js');
		$this->template->set_js('//www.google.com/jsapi');
		$this->template->set_js('~/js/chart_initialization.js');
		$this->template->set_js('~/js/user_overview.js');
		$this->template->set_layout('default');
		$this->template->set_content('user_overview');
		$this->template->display($data);
	}
	
	protected function _machine_group_overview_count($business_id, $period = 'weekly')
	{
		if ( $period == 'weekly' ) {
			$machine_group_code = $this->input->get('machine_group_weekly');
			
			$monday_time = strtotime('monday this week');
			$sunday_time = strtotime('sunday this week');
			$start = date('Y-m-d', $monday_time);
			$end = date('Y-m-d', $sunday_time);
		} else {
			$machine_group_code = $this->input->get('machine_group_monthly');
			
			$start = date('Y-m') . '-1';
			$end = date('Y-m-t');
		}
		
		$data = array();
		
		// Find the total logon sessions for this week.
		$overall_sessions = 0;
		$this->db->select('COUNT(*) AS total_sessions');
		$this->db->from('user_sessions');
		$this->db->join('users', 'user_sessions.user_id = users.user_id');
		$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
		$this->db->where(array(
			'users.user_visible' => 1,
			'machines.machine_visible' => 1,
		));
		$this->db->where('DATE(user_sessions.user_session_start) BETWEEN "' . $start . '" AND "' . $end . '"');
		
		// We only filter by business ID.
		if ( $business_id ) {
			$this->db->where('machines.business_id', $business_id);
		}
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			$overall_sessions = intval($row['total_sessions']);
		}
		
		// Update the data array.
		$data[] = array(
			'code' => '',
			'name' => lang('overall'),
			'total_sessions' => $overall_sessions,
		);
		
		// Now select the top 5 machine groups with the most logon sessions.
		$this->db->select('machine_groups.*, COUNT(*) AS total_sessions');
		$this->db->from('user_sessions');
		$this->db->join('users', 'user_sessions.user_id = users.user_id');
		$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
		$this->db->join('machine_groups', 'machines.machine_group_id = machine_groups.machine_group_id');
		$this->db->where(array(
			'users.user_visible' => 1,
			'machines.machine_visible' => 1,
		));
		$this->db->where('DATE(user_sessions.user_session_start) BETWEEN "' . $start . '" AND "' . $end . '"');
		$this->db->group_by('machines.machine_group_id');
		$this->db->order_by('total_sessions', 'desc');
		$this->db->limit(5);
		
		// We only filter by business ID.
		if ( $business_id ) {
			$this->db->where('machines.business_id', $business_id);
		}
		
		$total_logon_sessions = 0;
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			// $data['top_machine_group_weekly'] = array();
				
			foreach ( $qry->result_array() as $row ) {
				$mg_id = $row['machine_group_id'];
				$mg_code = $row['machine_group_code'];
				$mg_name = $row['machine_group_name'];
				$total_sessions = intval($row['total_sessions']);
				$total_logon_sessions += $total_sessions;
		
				$data[] = array(
					'code' => $mg_code,
					'name' => $mg_name,
					'total_sessions' => $total_sessions,
				);
			}
		}
		
		// Calculate the others logon sessions.
		$other_logon_sessions = $overall_sessions - $total_logon_sessions;
		$data[] = array(
			'code' => '_others',
			'name' => lang('others'),
			'total_sessions' => $other_logon_sessions,
		);
		
		return $data;
	}
	
	protected function  _top_machine_group_chart_data($period = 'weekly')
	{
		if ( $period == 'weekly' ) {
			$monday_time = strtotime('monday this week');
			$sunday_time = strtotime('sunday this week');
			$start = date('Y-m-d', $monday_time);
			$end = date('Y-m-d', $sunday_time);
		} else {
			$start = date('Y-m') . '-1';
			$end = date('Y-m-t');
		}
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		$machine_group_code = $this->input->get('machine_group');
		$business_id = 0;
		
		if ( $sys_user_type != 'superadmin' ) {
			$business_model = $sys_user_model->get_business_model();
			
			$business_id = $business_model->get_value('business_id');
		}
		
		$this->db->select('DATE(user_sessions.user_session_start) AS session_date, COUNT(*) AS logon_sessions');
		$this->db->from('user_sessions');
		$this->db->join('users', 'user_sessions.user_id = users.user_id');
		$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
		$this->db->where(array(
			'users.user_visible' => 1,
			'machines.machine_visible' => 1,
		));
		$this->db->where('DATE(user_sessions.user_session_start) BETWEEN "' . $start . '" AND "' . $end . '"');
		$this->db->group_by('DATE(user_sessions.user_session_start)');
		
		if ( $business_id ) {
			$this->db->where('users.business_id', $business_id);
		}
		
		if ( !is_empty($machine_group_code) ) {
			if ( $machine_group_code == '_others' ) {
				// Select those machine group which is not in the TOP 5 sessions.
				$this->db->where('machines.machine_group_id NOT IN(
					SELECT table_1.machine_group_id
					FROM (
						SELECT mg.*, COUNT(*) AS total_sessions
						FROM user_sessions us
						INNER JOIN machines m ON us.machine_id = m.machine_id
						INNER JOIN machine_groups mg ON m.machine_group_id = mg.machine_group_id
						GROUP BY mg.machine_group_id
						ORDER BY total_sessions DESC
						LIMIT 5
					) AS table_1
				)');
			} else {
				$this->db->where('machines.machine_group_id = (
					SELECT mg.machine_group_id
					FROM machine_groups mg
					WHERE mg.machine_group_code = "' . $machine_group_code . '"
				)');
			}
		}
		
		$qry = $this->db->get();
		$data = array();
		
		if ( $qry->num_rows() ) {
			foreach ( $qry->result_array() as $row ) {
				$date = $row['session_date'];
				$date = user_date($date, 'D, j/n/Y');
				$sessions = $row['logon_sessions'];
				
				$data[] = array($date, intval($sessions));
			}
		}
		
		if ( iterable($data) ) {
			return $data;
		} else {
			return array();
		}
	}
	
	protected function _top_user_list($period = 'weekly')
	{
		if ( $period == 'weekly' ) {
			$machine_group_code = $this->input->get('machine_group_weekly');
			
			$monday_time = strtotime('monday this week');
			$sunday_time = strtotime('sunday this week');
			$start = date('Y-m-d', $monday_time);
			$end = date('Y-m-d', $sunday_time);
		} else {
			$machine_group_code = $this->input->get('machine_group_monthly');
			
			$start = date('Y-m') . '-1';
			$end = date('Y-m-t');
		}
		
		$this->db->select('users.*, COUNT(*) AS logon_sessions, lcm.machine_name AS last_connected_machine');
		$this->db->from('user_sessions');
		$this->db->join('users', 'user_sessions.user_id = users.user_id');
		$this->db->join('machines lcm', 'users.user_last_connected_machine = lcm.machine_id', 'left');
		$this->db->where('users.user_visible', 1);
		$this->db->where('DATE(user_sessions.user_session_start) BETWEEN "' . $start . '" AND "' . $end . '"');
		
		if ( !is_empty($machine_group_code) ) {
			$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
			$this->db->where('machines.machine_group_id = (
				SELECT mg.machine_group_id
				FROM machine_groups mg
				WHERE mg.machine_group_code = "' . $machine_group_code . '"
			)');
		}
		
		$this->db->group_by('user_sessions.user_id');
		$this->db->order_by('logon_sessions', 'desc');
		$this->db->limit(5);
		
		$qry = $this->db->get();
		
		$data = array();
		
		if ( $qry->num_rows() ) {
			foreach ( $qry->result_array() as $row ) {
				$user_id = $row['user_id'];
				$user_name = $row['user_name_full'];
				$user_ad_group = $row['user_ad_group'];
				$last_connected_machine_name = $row['last_connected_machine'];
				
				$data[] = array(
					'id' => $user_id,
					'name' => $user_name,
					'group' => $user_ad_group,
					'last_connected_machine' => $last_connected_machine_name,
				);
			}
		}
	}
}