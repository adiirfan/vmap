<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends EB_Controller {
	public function init()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny(true, 'login');
		}
	}
	
	public function a_app_usage()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny();
		}
		
		$code = $this->input->get('code');
		
		if ( !$this->system->verify_client_id($code) ) {
			show_error(lang('error_invalid_token'), 403);
		}
		
		$this->load->helper('statistic');
		
		$output = $this->_load_application_statistic();
		
		$date = $output['data']['date'];
		$date_format = 'j M Y';
		
		if ( iterable($date) ) {
			foreach ( $date as $index => $d ) {
				$t = strtotime($d);
		
				if ( false !== $t ) {
					$date[$index] = user_date($t, $date_format);
				}
			}
		} else {
			$t = strtotime($date);
				
			if ( false !== $t ) {
				$date = user_date($t, $date_format);
			}
		}
		
		$output['data']['date'] = $date;
		
		json_output($output);
	}
	
	public function a_machine_usage()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny();
		}
		
		$code = $this->input->get('code');
		
		if ( !$this->system->verify_client_id($code) ) {
			show_error(lang('error_invalid_token'), 403);
		}
		
		$this->load->helper('statistic');
		
		$output = $this->_load_machine_statistic();
		
		$date = $output['data']['date'];
		$date_format = 'j M Y';
		
		if ( iterable($date) ) {
			foreach ( $date as $index => $d ) {
				$t = strtotime($d);
		
				if ( false !== $t ) {
					$date[$index] = user_date($t, $date_format);
				}
			}
		} else {
			$t = strtotime($date);
				
			if ( false !== $t ) {
				$date = user_date($t, $date_format);
			}
		}
		
		$output['data']['date'] = $date;
		
		json_output($output);
	}
	
	public function index()
	{
		$this->load->helper('statistic');
		
		
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		$business_id = $sys_user_model->get_value('business_id');
		
		$data = array(
			'total_online_users' => 0,
			'total_machines' => 0,
			'total_apps' => 0,
			'total_users' => 0,
			'user_statistics' => null,
		);
		
		// First, retrieve a list of machine groups.
		$machine_group = $this->input->get('machine_group');
		$machine_groups = get_machine_group_option_list();
		
		$data['machine_group_option_list'] = $machine_groups;
		
		// Determine the machine group filter.
		$machine_group_info = parse_machine_group($machine_group);
		$type = $machine_group_info['type'];
		$id = $machine_group_info['id'];
		$b_id = $machine_group_info['business_id'];
		
		# Dashboard reporting here.
		
		// Find the total users currently online.
		$this->db->select('COUNT(*) AS total_online_users');
		$this->db->from('users');
		$this->db->where(array(
			'user_status' => 'online',
			'user_visible' => 1,
		));
		
		if ( $type == 'business' ) {
			// Filter business.
			$this->db->where('business_id', $id);
		} else if ( $type == 'machine_group' ) {
			// Filter by machine group.
			$this->db->where('user_id IN (
				SELECT DISTINCT(user_id)
				FROM user_sessions
				INNER JOIN machines ON user_sessions.machine_id = machines.machine_id
				WHERE machines.machine_group_id = ' . $id . '
			)');
		} else {
			// No filter, show all users.
			if ( $sys_user_type != 'superadmin' ) {
				// Show only the specific business ID.
				$this->db->where('business_id', $business_id);
			}
		}
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			$data['total_online_users'] = intval($row['total_online_users']);
		}
		
		// Find the total number of machines.
		$this->db->select('COUNT(*) AS total_machines');
		$this->db->from('machines');
		$this->db->where('machine_visible', 1);
		
		if ( $type == 'business' ) {
			$this->db->where('business_id', $id);
		} else if ( $type == 'machine_group' ) {
			$this->db->where('machine_group_id', $id);
		} else {
			// Show all machines.
			if ( $sys_user_type != 'superadmin' ) {
				// Show only the specific business ID.
				$this->db->where('business_id', $business_id);
			}
		}
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			$data['total_machines'] = intval($row['total_machines']);
		}
		
		// Find the total number of applications.
		$this->db->select('COUNT(*) AS total_apps');
		$this->db->from('apps');
		$this->db->where('app_visible', 1);
		
		if ( $type == 'business' ) {
			$this->db->where('business_id', $id);
		} else if ( $type == 'machine_group' ) {
			$this->db->where('app_id IN (
				SELECT DISTINCT(app_sessions.app_id)
				FROM app_sessions
				INNER JOIN user_sessions ON app_sessions.user_session_id = user_sessions.user_session_id
				INNER JOIN machines ON user_sessions.machine_id = machines.machine_id
				WHERE machines.machine_group_id = ' . $id . '
			)');
		} else {
			// Show all applications.
			if ( $sys_user_type != 'superadmin' ) {
				$this->db->where('business_id', $business_id);
			}
		}
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			
			$data['total_apps'] = intval($row['total_apps']);
		}
		
		// Find the total number of users.
		$this->db->select('COUNT(*) AS total_users');
		$this->db->from('users');
		$this->db->where('user_visible', 1);
		
		if ( $type == 'business' ) {
			$this->db->where('business_id', $id);
		} else if ( $type == 'machine_group' ) {
			$this->db->where('user_id IN (
				SELECT DISTINCT(user_id)
				FROM user_sessions
				INNER JOIN machines ON user_sessions.machine_id = machines.machine_id
				WHERE machines.machine_group_id = ' . $id . '
			)');
		} else {
			// No filter, show all users.
			if ( $sys_user_type != 'superadmin' ) {
				// Show only the specific business ID.
				$this->db->where('business_id', $business_id);
			}
		}
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			
			$data['total_users'] = intval($row['total_users']);
		}
		
		$this->db->select('status');
		$this->db->from('license');
		$this->db->where('status', "Premium User");
		$qry = $this->db->get();
		if (!$qry->num_rows()) {
			$row = $qry->row_array();
			
			$data['msg'] = "test";
		}else{
		$data['msg'] = "test succses";
		}
		
		
		
		// Find the logon session grouped by machine_group.
		$this->db->select('machines.machine_group_id, machine_groups.machine_group_name, COUNT(user_sessions.user_session_id) AS total_sessions');
		$this->db->from('user_sessions');
		$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
		$this->db->join('machine_groups', 'machines.machine_group_id = machine_groups.machine_group_id', 'left');
		$this->db->group_by('machines.machine_group_id');
		$this->db->order_by('total_sessions', 'desc');
		
		if ( $type == 'business' ) {
			$this->db->where('machines.business_id', $id);
		} else if ( $type == 'machine_group' ) {
			// Find the business ID of this machine group.
			$this->db->where('machines.business_id', $b_id);
		} else {
			// No filter, show all users.
			if ( $sys_user_type != 'superadmin' ) {
				// Show only the specific business ID.
				$this->db->where('machines.business_id', $business_id);
			}
		}
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$data['user_statistics'] = array(
				'groups' => array(),
				'chart_data' => array(),
			);
			
			$label_others = lang('others');
			$group_count = 0;
			
			foreach ( $qry->result_array() as $row ) {
				$machine_group_id = $row['machine_group_id'];
				$machine_group_name = $row['machine_group_name'];
				$total_sessions = intval($row['total_sessions']);
				
				if ( $group_count < 5 && $machine_group_id ) {
					// Top 5 group
					$data['user_statistics']['groups'][$machine_group_id] = array(
						'name' => $machine_group_name,
						'sessions' => $total_sessions,
					);
					
					//$data['user_statistics']['chart_data'][$machine_group_name] = $total_sessions;
					$data['user_statistics']['chart_data'][] = array($machine_group_name, $total_sessions);
				} else {
					// Others.
					if ( !isset($data['user_statistics']['groups']['others']) ) {
						$data['user_statistics']['groups']['others'] = array(
							'name' => $label_others,
							'sessions' => 0,
						);
						
						$data['user_statistics']['chart_data'][] = array($label_others, 0);
					}
					
					$other_index = sizeof($data['user_statistics']['chart_data']) - 1;
					
					$data['user_statistics']['groups']['others']['sessions'] += $total_sessions;
					//$data['user_statistics']['chart_data'][$label_others] += $total_sessions;
					$data['user_statistics']['chart_data'][$other_index][1] += $total_sessions;
				}
				
				$group_count ++;
			}
		}
		

		
		$data['application_statistics'] = $this->_load_application_statistic();
		$data['machine_statistics'] = $this->_load_machine_statistic();
		
		$this->template->set_js('!/js/jquery.slimscroll.min.js');
		$this->template->set_js('~/js/slimscroll.initialize.js');
		$this->template->set_js('//www.google.com/jsapi');
		$this->template->set_js('~/js/chart_initialization.js');
		$this->template->set_js('~/js/dashboard.js');
		$this->template->set_layout('default');
		$this->template->set_content('dashboard');
		$this->template->display($data);
	
		
	}
	
	protected function _load_application_statistic($options = array())
	{
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('user_type');
		$date = array_ensure($options, 'date', $this->input->get('date'));
		$machine_group = 0;
		$business_id = 0;
		
		if ( $user_machine_group = $this->input->get('machine_group') ) {
			if ( preg_match('/B\:(\d+)/', $user_machine_group, $matches) ) {
				$business_id = intval($matches[1]);
			} else if ( preg_match('/G\:(\d+)/', $user_machine_group, $matches) ) {
				$machine_group = intval($matches[1]);
			}
		}
		
		if ( $sys_user_type != 'superadmin' ) {
			$business_model = $sys_user_model->get_business_model();
			
			if ( $business_model ) {
				$business_id = $business_model->get_value('business_id');
			}
		}
		
		// Get the overview number first.
		$all_time = application_usage(array(
			'business_id' => $business_id,
			'machine_group' => $machine_group,
			'return_overall' => true,
			'return_chart_data' => false,
			'return_top_app' => false,
		));
		$today = application_usage(array(
			'date' => 'today',
			'business_id' => $business_id,
			'machine_group' => $machine_group,
			'return_overall' => true,
			'return_chart_data' => false,
			'return_top_app' => false,
		));
		$this_week = application_usage(array(
			'date' => 'this week',
			'business_id' => $business_id,
			'machine_group' => $machine_group,
			'return_overall' => true,
			'return_chart_data' => false,
			'return_top_app' => false,
		));
		$this_month = application_usage(array(
			'date' => 'this month',
			'business_id' => $business_id,
			'machine_group' => $machine_group,
			'return_overall' => true,
			'return_chart_data' => false,
			'return_top_app' => false,
		));
		$this_year = application_usage(array(
			'date' => 'this year',
			'business_id' => $business_id,
			'machine_group' => $machine_group,
			'return_overall' => true,
			'return_chart_data' => false,
			'return_top_app' => false,
		));
		$data = application_usage(array(
			'date' => $date,
			'business_id' => $business_id,
			'machine_group' => $machine_group,
			'return_overall' => false,
		));
		
		return array(
			'data' => $data,
			'all_time' => intval(array_ensure($all_time, 'overall', 0)),
			'today' => intval(array_ensure($today, 'overall', 0)),
			'this_week' => intval(array_ensure($this_week, 'overall', 0)),
			'this_month' => intval(array_ensure($this_month, 'overall', 0)),
			'this_year' => intval(array_ensure($this_year, 'overall', 0)),
		);
	}
	
	protected function _load_machine_statistic($options = array())
	{
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('user_type');
		$date = array_ensure($options, 'date', $this->input->get('date'));
		$machine_group = 0;
		$business_id = 0;
		
		if ( $user_machine_group = $this->input->get('machine_group') ) {
			if ( preg_match('/B\:(\d+)/', $user_machine_group, $matches) ) {
				$business_id = intval($matches[1]);
			} else if ( preg_match('/G\:(\d+)/', $user_machine_group, $matches) ) {
				$machine_group = intval($matches[1]);
			}
		}
		
		if ( $sys_user_type != 'superadmin' ) {
			$business_model = $sys_user_model->get_business_model();
			
			if ( $business_model ) {
				$business_id = $business_model->get_value('business_id');
			}
		}
		
		// Get the overview number first.
		$all_time = machine_usage(array(
			'business_id' => $business_id,
			'machine_group' => $machine_group,
			'return_overall' => true,
			'return_chart_data' => false,
			'return_top_app' => false,
		));
		$today = machine_usage(array(
			'date' => 'today',
			'business_id' => $business_id,
			'machine_group' => $machine_group,
			'return_overall' => true,
			'return_chart_data' => false,
			'return_top_app' => false,
		));
		$this_week = machine_usage(array(
			'date' => 'this week',
			'business_id' => $business_id,
			'machine_group' => $machine_group,
			'return_overall' => true,
			'return_chart_data' => false,
			'return_top_app' => false,
		));
		$this_month = machine_usage(array(
			'date' => 'this month',
			'business_id' => $business_id,
			'machine_group' => $machine_group,
			'return_overall' => true,
			'return_chart_data' => false,
			'return_top_app' => false,
		));
		$this_year = machine_usage(array(
			'date' => 'this year',
			'business_id' => $business_id,
			'machine_group' => $machine_group,
			'return_overall' => true,
			'return_chart_data' => false,
			'return_top_app' => false,
		));
		$data = machine_usage(array(
			'date' => $date,
			'business_id' => $business_id,
			'machine_group' => $machine_group,
			'return_overall' => false,
		));
		
		return array(
			'data' => $data,
			'all_time' => intval(array_ensure($all_time, 'overall', 0)),
			'today' => intval(array_ensure($today, 'overall', 0)),
			'this_week' => intval(array_ensure($this_week, 'overall', 0)),
			'this_month' => intval(array_ensure($this_month, 'overall', 0)),
			'this_year' => intval(array_ensure($this_year, 'overall', 0)),
		);
	}
}