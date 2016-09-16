<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Machine_group extends EB_Controller {
	public function init()
	{
		$this->load->model('Machine_group_model', 'machine_group_model');
	}
	
	public function a_delete()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny(true, 'login');
		}
		
		$token = $this->input->get('token');
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$this->access_deny();
		}
		
		$machine_group_id = $this->input->get('machine_group_id');
		
		$this->machine_group_model->load(array(
			'machine_group_id' => $machine_group_id,
		));
		
		if ( $this->machine_group_model->is_empty() ) {
			$output['error'] = 1;
			$output['message'] = lang('error_machine_group_not_found');
		} else {
			$this->machine_group_model->delete();
		}
		
		json_output($output);
	}
	
	public function a_machine_chooser()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny();
		}
		
		// $business_id = $this->input->get('business_id');
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		$machine_group_id = $this->input->get('machine_group_id');
		$result_type = $this->input->get('result_type');
		$token = $this->input->get('token');
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		
		$this->machine_group_model->load(array(
			'machine_group_id' => $machine_group_id,
		));
		
		if ( $this->machine_group_model->is_empty() ) {
			$output['error'] = 1;
			$output['message'] = lang('error_machine_group_not_found');
		} else if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			if ( $sys_user_type != 'superadmin' ) {
				// Check if the machine group is belongs to this user.
				$business_model = $sys_user_model->get_business_model();
				$business_id = $business_model->get_value('business_id');

				if ( $business_id != $this->machine_group_model->get_value('business_id') ) {
					$this->access_deny();
				}
			}
			
			$list_options = array(
				'layout' => 'machine_modal',
				'per_page' => 10,
			);
			
			if ( $result_type == 'selected' ) {
				$list_options['machine_group_id'] = $machine_group_id;
			} else if ( $result_type == 'available' ) {
				$list_options['business_id'] = $this->machine_group_model->get_value('business_id');
			} else {
				$output['error'] = 1;
				$output['message'] = lang('error_invalid_action');
			}
			
			if ( !$output['error'] ) {
				$this->load->library('listings/machine_chooser_listing', $list_options);
				
				$output['html_list'] = $this->machine_chooser_listing->render();
				$output['total_result'] = $this->machine_chooser_listing->get_total_records();
				$output['next_page'] = $this->machine_chooser_listing->get_current_page() + 1;
				$output['more_records'] = $this->machine_chooser_listing->has_more_records();
			}
		}
		
		json_output($output);
	}
	
	public function a_update_machines()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny();
		}
		
		$token = $this->input->get('token');
		$machine_group_id = $this->input->get('machine_group_id');
		$update_string = $this->input->get('update');
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$this->access_deny();
		}
		
		if ( is_empty($update_string) || false === ($update = json_decode($update_string, true)) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_update_string');
		} else {
			$this->machine_group_model->load(array(
				'machine_group_id' => $machine_group_id,
			));
			
			if ( $this->machine_group_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_machine_group_not_found');
			} else {
				$sys_user_model = $this->authentication->get_model();
				$sys_user_type = $sys_user_model->get_value('sys_user_type');
				$business_id = intval($sys_user_model->get_value('business_id'));
				
				if ( $sys_user_type != 'superadmin' && $business_id != $this->machine_group_model->get_value('business_id') ) {
					$this->access_deny();
				} else {
					$available = array_ensure($update, 'available', array());
					$selected = array_ensure($update, 'selected', array());
					
					if ( iterable($available) ) {
						foreach ( $available as $machine_id ) {
							if ( $business_id ) {
								$qry = $this->db->get_where('machines', array(
									'machine_id' => $machine_id,
									'business_id' => $business_id,
								));
								
								if ( !$qry->num_rows() ) {
									continue ;
								}
							}
							
							$this->machine_group_model->add_machine($machine_id);
						}
					}
					
					if ( iterable($selected) ) {
						foreach ( $selected as $machine_id ) {
							if ( $business_id ) {
								$qry = $this->db->get_where('machines', array(
									'machine_id' => $machine_id,
									'business_id' => $business_id,
								));
							
								if ( !$qry->num_rows() ) {
									continue ;
								}
							}
							
							$this->machine_group_model->remove_machine($machine_id);
						}
					}
					
					$output['total_machines'] = $this->machine_group_model->get_total_machines();
					$output['online_machines'] = $this->machine_group_model->get_total_online_machines();
					$output['offline_machines'] = $this->machine_group_model->get_total_offline_machines();
				}
			}
		}
		
		json_output($output);
	}
	
	public function add()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny(true, 'login');
		}
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		$business_id = 0;
		
		if ( $sys_user_type != 'superadmin' ) {
			$business_id = $sys_user_model->get_business_model()->get_value('business_id');
		}
		
		$this->machine_group_model->new_data();
		$this->machine_group_model->set_value('business_id', $business_id);
		
		$data = array();
		
		$this->load->library('forms/machine_group_form', array(
			'name' => 'machine_group',
			'action' => 'machine_group/add',
			'method' => 'post',
			'layout' => 'bootstrap_horizontal',
			'allow_change_business' => ($sys_user_type == 'superadmin' ? true : false),
			'models' => array(
				$this->machine_group_model,
			),
			'submit_label' => lang('save'),
		));
		
		if ( $this->machine_group_form->is_submission_succeed() ) {
			$this->system->set_message('success', lang('txt_machine_group_created'));
			
			$machine_group_id = $this->machine_group_model->get_value('machine_group_id');
			
			redirect('machine_group/detail/' . $machine_group_id);
		}
		
		$data['form'] = $this->machine_group_form->render();
		
		$this->template->set_page_title(lang('machine_group_detail'));
		$this->template->set_layout('default');
		$this->template->set_content('machine_group_form');
		$this->template->display($data);
	}
	
	public function detail($machine_group_id)
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny(true, 'login');
		}
		
		$this->machine_group_model->load(array(
			'machine_group_id' => $machine_group_id,
		));
		
		if ( $this->machine_group_model->is_empty() ) {
			show_404();
		}
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		
		if ( $sys_user_type != 'superadmin' ) {
			if ( $sys_user_model->get_value('business_id') != $this->machine_group_model->get_value('business_id') ) {
				$this->access_deny(true, 'machine_group/index');
			}
		}
		
		$data = array(
			'machine_group_id' => $machine_group_id,
			'machine_group_data' => $this->machine_group_model->get_data(),
			'total_machines' => $this->machine_group_model->get_total_machines(),
			'most_apps' => '',
			'most_machines' => '',
			'app_usage_info' => array(),
			'machine_usage_info' => array(),
		);
		
		# Most launched applications.
		$this->db->select('apps.*, COUNT(*) AS total_instances');
		$this->db->from('app_sessions');
		$this->db->join('apps', 'app_sessions.app_id = apps.app_id');
		$this->db->join('user_sessions', 'app_sessions.user_session_id = user_sessions.user_session_id');
		$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
		$this->db->where('machines.machine_group_id', $machine_group_id);
		$this->db->where('apps.app_visible', 1);
		$this->db->group_by('app_sessions.app_id');
		$this->db->order_by('total_instances', 'desc');
		$this->db->limit(5);
		
		$app_qry = $this->db->get();
		
		if ( $app_qry->num_rows() ) {
			$row = $app_qry->row_array();
			
			$data['most_apps'] = $row['app_friendly_name'];
		}
		
		# Most used machines.
		$this->db->select('machines.*, COUNT(*) AS total_sessions');
		$this->db->from('user_sessions');
		$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
		$this->db->join('users', 'user_sessions.user_id = users.user_id');
		$this->db->where(array(
			'machines.machine_visible' => 1,
			'users.user_visible' => 1,
			'machines.machine_group_id' => $machine_group_id,
		));
		$this->db->group_by('user_sessions.machine_id');
		$this->db->order_by('total_sessions', 'desc');
		$this->db->limit(1);
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			
			$data['most_machines'] = $row['machine_name'];
		}
		
		# App usage information.
		if ( $app_qry->num_rows() ) {
			foreach ( $app_qry->result_array() as $app_row ) {
				$data['app_usage_info'][] = array($app_row['app_friendly_name'], intval($app_row['total_instances']));
			}
		}
		
		# Usage information.
		$periods = array(
			'today', 'this week', 'this month', 'this year',
		);
		
		$now = time();
		
		foreach ( $periods as $period ) {
			$start_time = 0;
			$end_time = 0;
			$date_label = '';
			$null_compare = 0;
		
			switch ( $period ) {
				case 'today':
					$start_time = strtotime('today');
					$end_time = $start_time + 24 * 3600 - 1;
					$date_label = lang('today');
		
					break;
				case 'this week':
					$start_time = strtotime('monday this week');
					$end_time = strtotime('sunday this week');
					$end_time = $end_time + 24 * 3600 - 1;
					$date_label = lang('this_week');
		
					break;
				case 'this month':
					$start_time = strtotime(date('Y-m-1') . ' 00:00:00');
					$end_time = strtotime(date('Y-m-t') . ' 23:59:59');
					$date_label = lang('this_month');
		
					break;
				case 'this year':
					$start_time = strtotime(date('Y') . '-01-01 00:00:00');
					$end_time = strtotime(date('Y') . '-12-31 23:59:59');
					$date_label = lang('this_year');
		
					break;
			}
				
			$is_today = (date('Y-m-d', $start_time) == date('Y-m-d'));
				
			if ( $end_time > $now || $is_today ) {
				$null_compare = 1;
			}
		
			$this->db->select('COUNT(*) AS total_sessions');
			$this->db->from('user_sessions');
			$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
			$this->db->join('users', 'user_sessions.user_id = users.user_id');
			$this->db->where('(UNIX_TIMESTAMP(user_sessions.user_session_start) BETWEEN "' . $start_time . '" AND "' . $end_time . '" OR
				UNIX_TIMESTAMP(user_sessions.user_session_end) BETWEEN "' . $start_time . '" AND "' . $end_time . '" OR
				(UNIX_TIMESTAMP(user_sessions.user_session_start) < "' . $end_time . '" AND user_sessions.user_session_end IS NULL AND 1 = ' . $null_compare . '))');
			$this->db->where(array(
				'machines.machine_group_id' => $machine_group_id,
				'users.user_visible' => 1,
			));
		
			$qry = $this->db->get();
			$total_sessions = 0;
		
			if ( $qry->num_rows() ) {
				$row = $qry->row_array();
				$total_sessions = intval($row['total_sessions']);
			}
		
			$data['machine_usage_info'][] = array(
				$date_label, $total_sessions,
			);
		}
		
		# User login information.
		$this->load->library('listings/machine_group_user_listing', array(
			'machine_group_id' => $machine_group_id,
			'layout' => 'bootstrap_column_listing',
		));
		
		$data['user_login_list'] = $this->machine_group_user_listing->render();
		
		# App usage information.
		$this->load->library('listings/machine_group_app_listing', array(
			'machine_group_id' => $machine_group_id,
			'layout' => 'bootstrap_column_listing',
		));
		
		$data['app_usage_list'] = $this->machine_group_app_listing->render();
		
		// print_r($data); exit();
		
		$this->template->set_page_title(lang('machine_group_detail'));
		$this->template->set_js('//www.google.com/jsapi');
		$this->template->set_js('~/js/chart_initialization.js');
		$this->template->set_js('!/js/jquery.typewatch.js');
		$this->template->set_js('!/js/jquery.slimscroll.min.js');
		$this->template->set_js('~/js/machine_group_detail.js');
		$this->template->set_js('~/js/machine_group_chooser.js');
		$this->template->set_layout('default');
		$this->template->set_content('machine_group_detail');
		$this->template->display($data);
	}
	
	public function edit($machine_group_id)
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny(true, 'login');
		}
		
		$this->machine_group_model->load(array(
			'machine_group_id' => $machine_group_id,
		));
		
		if ( $this->machine_group_model->is_empty() ) {
			show_404();
		}
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		
		if ( $sys_user_type != 'superadmin' ) {
			if ( $sys_user_model->get_value('business_id') != $this->machine_group_model->get_value('business_id') ) {
				$this->access_deny(true, 'machine_group/index');
			}
		}
		
		$data = array();
		
		$this->load->library('forms/machine_group_form', array(
			'name' => 'machine_group',
			'action' => 'machine_group/edit/' . $machine_group_id,
			'method' => 'post',
			'layout' => 'bootstrap_horizontal',
			'allow_change_business' => ($sys_user_type == 'superadmin' ? true : false),
			'models' => array(
				$this->machine_group_model,
			),
			'submit_label' => lang('save'),
		));
		
		if ( $this->machine_group_form->is_submission_succeed() ) {
			$this->system->set_message('success', lang('txt_machine_group_updated'));
			
			redirect('machine_group/detail/' . $machine_group_id);
		}
		
		$data['form'] = $this->machine_group_form->render();
		
		$this->template->set_page_title(lang('machine_group_detail'));
		$this->template->set_layout('default');
		$this->template->set_content('machine_group_form');
		$this->template->display($data);
	}
	
	public function index()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny(true, 'login');
		}
		
		$per_page_options = array(10, 20, 30, 50, 100);
		$per_page = $this->input->get('per_page');
		
		if ( !in_array($per_page, $per_page_options) ) {
			$per_page = array_first($per_page_options);
		}
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		$business_id = 0;
		$data = array(
			'per_page_options' => $per_page_options,
		);
		
		if ( $sys_user_type != 'superadmin' ) {
			$business_model = $sys_user_model->get_business_model();
			$business_id = $business_model->get_value('business_id');
		}
		
		$this->load->library('forms/machine_group_filter_form', array(
			'name' => 'filter_form',
			'action' => 'machine_group/index',
			'method' => 'get',
			'show_business_filter' => ($business_id == 0),
			'layout' => 'bootstrap_inline',
			'submit_label' => '<i class="fa fa-search"></i> ' . lang('search'),
		));
		
		$this->load->library('listings/machine_group_listing', array(
			'layout' => 'bootstrap_column_listing',
			'business_id' => $business_id,
		));
		
		if ( $this->input->get('export') ) {
			$export_file_type = $this->input->get('export');
			
			$header_columns = array(lang('machine_group_name'));
				
			if ( $sys_user_type == 'superadmin' ) {
				$header_columns[] = lang('business');
			}
				
			$header_columns = array_merge($header_columns, array(
				lang('machine_group_desc'),
				lang('total_machines'),
				lang('online_offline'),
			));
			
			$last_query = $this->machine_group_listing->get_last_query();
			
			// Remove the limit statement.
			$last_query = preg_replace('/ LIMIT \d+/', '', $last_query);
			$last_query = trim($last_query);
			
			$qry = $this->db->query($last_query);
				
			switch ( $export_file_type ) {
				case 'csv':
					// Create the header row.
					$fh = fopen('php://memory', 'w');
					
					fputcsv($fh, $header_columns);
					
					if ( $qry->num_rows() ) {
						foreach ( $qry->result_array() as $row ) {
							$data_row = array($row['machine_group_name']);
							$online_machines = intval($row['online_machines']);
							$offline_machines = intval($row['offline_machines']);
							$status_text = $online_machines . ' online / ' . $offline_machines . ' offline';
							
							if ( $sys_user_type == 'superadmin' ) {
								$data_row[] = $row['business_name'];
							}
							
							$data_row = array_merge($data_row, array(
								$row['machine_group_desc'],
								$row['total_machines'],
								$status_text,
							));
							
							fputcsv($fh, $data_row);
						}
					}
					
					ob_start();
					
					fseek($fh, 0);
					
					fpassthru($fh);
					
					$csv = ob_get_clean();
						
					$this->output->set_content_type('application/csv');
					$this->output->set_header('Content-Disposition: attachment; filename=machine-group-list.csv');
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
							$data_row = array($row['machine_group_name']);
							$online_machines = intval($row['online_machines']);
							$offline_machines = intval($row['offline_machines']);
							$status_text = $online_machines . ' online / ' . $offline_machines . ' offline';
							
							if ( $sys_user_type == 'superadmin' ) {
								$data_row[] = $row['business_name'];
							}
							
							$data_row = array_merge($data_row, array(
								$row['machine_group_desc'],
								$row['total_machines'],
								$status_text,
							));
							
							$data[] = $data_row;
						}
					}
						
					$html = $this->template->display(array(
						'header' => $header_columns,
						'data' => $data,
						'page_title' => 'Machine Group List',
					), true);
						
					require_once('mpdf60/mpdf.php');
						
					$mpdf = new mPDF();
					
					$mpdf->WriteHTML($html);
						
					$mpdf->Output('machine-group-list.pdf', 'I');
						
					break;
			}
		} else {
			$data['list'] = $this->machine_group_listing->render();
			$data['filter_form'] = $this->machine_group_filter_form->render();
			
			$this->template->set_js('!/js/jquery.typewatch.js');
			$this->template->set_js('!/js/jquery.slimscroll.min.js');
			$this->template->set_js('~/js/machine_group_index.js');
			$this->template->set_js('~/js/machine_group_chooser.js');
			$this->template->set_layout('default');
			$this->template->set_content('machine_group_index');
			$this->template->display($data);
		}
	}
}