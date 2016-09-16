<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Machine extends EB_Controller {
	public function init()
	{
		$this->load->model('Machine_model', 'machine_model');
	}
	
	public function a_clear_inv()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny();
		}
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		$token = $this->input->get('token');
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$machine_id = $this->input->get('machine_id');
			
			$this->machine_model->load(array(
				'machine_id' => $machine_id,
			));
			
			if ( $this->machine_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_machine_id_not_found');
			} else {
				if ( !$this->machine_model->clear_user_data() ) {
					$output['error'] = 1;
					$output['message'] = lang('error_machine_data_clear');
				} else {
					$output['machine_default_name'] = $this->machine_model->get_value('machine_default_name');
				}
			}
		}
		
		json_output($output);
	}
	
	public function a_inventory_upload()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny();
		}
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		$token = $this->input->post('token');
		$business_id = $this->input->post('business');
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$sys_user_model = $this->authentication->get_model();
			$sys_user_type = $sys_user_model->get_value('sys_user_type');
			
			if ( $sys_user_type == 'superadmin' ) {
				// Make sure business ID exists.
				if ( !$business_id ) {
					$output['error'] = 1;
					$output['message'] = lang('error_business_not_found');
				} else {
					$this->load->model('Business_model', 'business_model');
					$this->business_model->load(array(
						'business_id' => $business_id,
					));
					
					if ( $this->business_model->is_empty() ) {
						$output['error'] = 1;
						$output['message'] = lang('error_business_not_found');
					}
				}
			} else {
				// Assign the user's business ID to it.
				$business_model = $sys_user_model->get_business_model();
				$business_id = $business_model->get_value('business_id');
			}
			
			if ( !$output['error'] ) {
				$file = $_FILES['csv_file'];
				$error = array_ensure($file, 'error', 0);
				$filename = array_ensure($file, 'name', '');
				$size = array_ensure($file, 'size', 0);
				$tmp_name = array_ensure($file, 'tmp_name', '');
				$filetype = array_ensure($file, 'type', '');
				
				if ( $error ) {
					$output['error'] = 1;
					$output['message'] = lang('error_upload');
				} else {
					if ( !preg_match('/\.csv$/i', $filename) ) {
						$output['error'] = 1;
						$output['message'] = lang('error_upload_invalid_file_type');
					} else {
						$max_filesize = 5 * 1024 * 1024;
						
						if ( $size > $max_filesize ) {
							$output['error'] = 1;
							$output['message'] = lang('error_upload_file_size');
						} else {
							$fh = @fopen($tmp_name, 'r');
							
							if ( false === $fh ) {
								$output['error'] = 1;
								$output['message'] = lang('error_unable_read_uploaded_file');
							} else {
								$header_maps = array();
								$column_maps = array(
									'mac_address' => 'machine_mac_address',
									'ip_address' => 'machine_ip_address',
									'machine_default_name' => 'machine_default_name',
									'machine_name' => 'machine_name',
									'operating_system' => 'machine_os_name',
									'serial_number' => 'machine_serial_number',
									'model' => 'machine_model',
									'processor' => 'machine_processor',
									'ram' => 'machine_ram',
									'year_bought' => 'machine_year',
									'end_of_year_support' => 'machine_support_expiry',
									'condition' => 'machine_physical_status',
								);
								$data = array();
								
								// Read header line.
								$header_row = fgetcsv($fh, 1024, ',');
								
								if ( false !== $header_row ) {
									foreach ( $header_row as $index => $header ) {
										if ( isset($column_maps[$header]) ) {
											$header_maps[$index] = $header;
										}
									}
								}
								
								// Now read on the data.
								while ( false !== ($data_row = fgetcsv($fh, 1024, ',')) ) {
									if ( iterable($header_maps) ) {
										$row = array();
										
										foreach ( $header_maps as $index => $column_header ) {
											$cell_value = array_ensure($data_row, $index, null);
											$db_field = array_ensure($column_maps, $column_header, false);
											
											if ( !is_empty($db_field) && !is_empty($cell_value) ) {
												$row[$db_field] = $cell_value;
											}
										}
										
										$data[] = $row;
									}
								}
								
								if ( iterable($data) ) {
									$this->load->model('Machine_model', 'machine_model');
									$this->load->model('Machine_filter_model', 'machine_filter_model');
									$this->load->model('Machine_category_model', 'machine_category_model');
									
									foreach ( $data as $machine ) {
										$os_name = array_ensure($machine, 'machine_os_name', '');
										$mac_address = array_ensure($machine, 'machine_mac_address', '');
										$machine_default_name = array_ensure($machine, 'machine_default_name', '');
										
										if ( is_empty($os_name) || is_empty($mac_address) || is_empty($machine_default_name) ) {
											log_message('error', 'Machine inventory import error. Missing required field(s).');
											continue ;
										}
										
										$qry = $this->db->get_where('machines', array(
											'machine_mac_address' => $mac_address,
											'business_id' => $business_id,
										));
										
										if ( $qry->num_rows() ) {
											$machine_row = $qry->row_array();
											$machine['machine_id'] = $machine_row['machine_id'];
										} else {
											// Assign machine categories.
											$machine_category_data = $this->machine_category_model->match_category($os_name);
												
											if ( false === $machine_category_data ) {
												continue ;
											}
												
											$machine['machine_category_id'] = $machine_category_data['machine_category_id'];
											
											// Machine filtering here.
											$machine_filters = $this->machine_filter_model->filter_all($business_id, $machine);
											
											if ( iterable($machine_filters) ) {
												foreach ( $machine_filters as $filter ) {
													$action = $filter['machine_filter_action'];
														
													if ( $action == 'block' ) {
														$machine['machine_visible'] = 0;
													} else if ( $action == 'allow' && $connected_agents < $max_agents ) {
														$machine['machine_visible'] = 1;
													} else if ( $action == 'group' ) {
														$machine_group_id = $filter['machine_filter_group_assigned'];
											
														$machine['machine_group_id'] = $machine_group_id;
													}
												}
											}
											
											// Ensure the machine name.
											if ( !isset($machine['machine_name']) || is_empty($machine['machine_name']) ) {
												$machine['machine_name'] = $machine_default_name;
											}
										}
										
										$machine['business_id'] = $business_id;
										
										// Ensure field values.
										if ( isset($machine['machine_year']) ) {
											$machine['machine_year'] = intval($machine['machine_year']);
										}
										
										if ( isset($machine['machine_support_expiry']) ) {
											$machine['machine_support_expiry'] = intval($machine['machine_support_expiry']);
										}
										
										$this->machine_model->set_data($machine);
									}
									
									// Save/update all.
									$this->machine_model->save(true);
								}
							}
						}
					}
				}
			}
		}
		
		json_output($output);
	}
	
	public function a_load_machine_usage_data()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny();
		}
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		$token = $this->input->get('token');
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$machine_group_info = parse_machine_group($this->input->get('machine_group'));
			$business_id = $machine_group_info['business_id'];
			$period = $this->input->get('period');
			
			$output['data'] = $this->_top5_machine_usage($period, $business_id);
		}
		
		json_output($output);
	}
	
	public function a_set_visibility()
	{
		$output = array(
			'error' => 0,
			'message' => '',
		);
	
		$token = $this->input->get('token');
		$machine_id = $this->input->get('machine_id');
		$visibility = $this->input->get('visibility');
		$visibility = ($visibility ? 1 : 0);
	
		// Verify the token.
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->machine_model->load(array(
				'machine_id' => $machine_id,
			));
				
			if ( $this->machine_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_machine_id_not_found');
			} else {
				if ( !$this->machine_model->set_visibility($visibility) ) {
					$output['error'] = 1;
					$output['message'] = lang('error_machine_set_visibility');
				}
			}
		}
	
		json_output($output);
	}
	
	public function detail($machine_id)
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny(true, 'login');
		}
		
		$this->machine_model->load(array(
			'machine_id' => $machine_id,
		));
		
		if ( $this->machine_model->is_empty() ) {
			show_404();
		}
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		
		if ( $sys_user_type != 'superadmin' ) {
			$business_model = $sys_user_model->get_business_model();
			$business_id = $business_model->get_value('business_id');
			
			if ( $business_id != $this->machine_model->get_value('business_id') ) {
				$this->access_deny(true, 'machine/index');
			}
		}
		
		$data = $this->machine_model->get_data();
		$data['machine_group_data'] = false;
		$data['machine_uptime'] = 'n/a';
		$data['most_logon_user'] = 'n/a';
		$data['most_used_app'] = 'n/a';
		$data['app_usage_info'] = false;
		$data['machine_usage_info'] = array();
		
		$now = time();
		$machine_group_model = $this->machine_model->get_machine_group_model();
		
		if ( $machine_group_model ) {
			$data['machine_group_data'] = $machine_group_model->get_data();
		}
		
		# Machine uptime.
		$this->db->from('machine_sessions');
		$this->db->where('machine_id', $machine_id);
		$this->db->order_by('machine_session_start', 'desc');
		$this->db->limit(1);
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			$start_datetime = strtotime($row['machine_session_start']);
			$end_date = $row['machine_session_end'];
			$end_datetime = $now;
			
			if ( !is_empty($end_date) ) {
				$end_datetime = strtotime($end_date);
			}
			
			$duration = $end_datetime - $start_datetime;
			
			$data['machine_uptime'] = parse_duration($duration);
		}
		
		# Most login users.
		$this->db->select('users.*, COUNT(*) AS logon_sessions');
		$this->db->from('user_sessions');
		$this->db->join('users', 'user_sessions.user_id');
		$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
		$this->db->where(array(
			'users.user_visible' => 1,
			'machines.machine_id' => $machine_id,
		));
		$this->db->group_by('user_sessions.user_id');
		$this->db->order_by('logon_sessions', 'desc');
		$this->db->limit(1);
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			
			$data['most_logon_user'] = $row;
		}
		
		# Most launched application.
		$this->db->select('apps.*, COUNT(*) AS total_launches');
		$this->db->from('app_sessions');
		$this->db->join('apps', 'app_sessions.app_id = apps.app_id');
		$this->db->join('user_sessions', 'app_sessions.user_session_id = user_sessions.user_session_id');
		$this->db->join('users', 'user_sessions.user_id');
		//$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
		$this->db->where(array(
			'user_sessions.machine_id' => $machine_id,
			'users.user_visible' => 1,
			'apps.app_visible' => 1,
		));
		$this->db->group_by('app_sessions.app_id');
		$this->db->order_by('total_launches', 'desc');
		$this->db->limit(5);
		
		$most_app_qry = $this->db->get();
		
		if ( $most_app_qry->num_rows() ) {
			$row = $most_app_qry->row_array();
			
			$data['most_used_app'] = $row;
		}
		
		# App usage information (Top 5 app sessions)
		if ( $most_app_qry->num_rows() ) {
			foreach ( $most_app_qry->result_array() as $row ) {
				$app_name = $row['app_friendly_name'];
				$instances = intval($row['total_launches']);
				
				$data['app_usage_info'][] = array($app_name, $instances);
			}
		}
		
		# Machine usage information.
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
				'machines.machine_id' => $machine_id,
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
		$this->load->library('listings/machine_user_listing', array(
			'machine_id' => $machine_id,
			'layout' => 'bootstrap_column_listing',
		));
		
		$data['user_login_list'] = $this->machine_user_listing->render();
		
		# App usage information
		$this->load->library('listings/machine_app_listing', array(
			'machine_id' => $machine_id,
			'layout' => 'bootstrap_column_listing',
		));
		
		$data['app_usage_list'] = $this->machine_app_listing->render();
		
		// print_r($data); exit();
		
		$this->template->set_js('//www.google.com/jsapi');
		$this->template->set_js('~/js/chart_initialization.js');
		$this->template->set_css('!/css/bootstrap-toggle.min.css');
		$this->template->set_js('!/js/bootstrap-toggle.min.js');
		$this->template->set_js('~/js/machine_detail.js');
		$this->template->set_page_title(lang('page_title_machine/detail'));
		$this->template->set_layout('default');
		$this->template->set_content('machine_detail');
		$this->template->display($data);
	}
	
	public function index()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny();
		}
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		$business_id = 0;
		$per_page_options = array(10, 20, 30, 50, 100);
		$per_page = $this->input->get('per_page');
		
		if ( !in_array($per_page, $per_page_options) ) {
			$per_page = array_first($per_page_options);
		}
		
		if ( $sys_user_type != 'superadmin' ) {
			$business_model = $sys_user_model->get_business_model();
			$business_id = $business_model->get_value('business_id');
		}
		
		$this->load->library('forms/machine_filter_form', array(
			'name' => 'filter_form',
			'action' => 'machine/index',
			'method' => 'get',
			'layout' => 'bootstrap_inline',
			'submit_label' => '<i class="fa fa-search"></i> ' . lang('search'),
		));
		
		$this->load->library('listings/machine_listing', array(
			'layout' => 'bootstrap_column_listing',
			'business_id' => $business_id,
		));
		
		if ( $this->input->get('export') ) {
			$export_file_type = $this->input->get('export');
			
			$header_columns = array(lang('machine_name'));
				
			if ( $sys_user_type == 'superadmin' ) {
				$header_columns[] = lang('business');
			}
				
			$header_columns = array_merge($header_columns, array(
				lang('machine_os'),
				lang('machine_ip_address'),
				lang('machine_mac_address'),
				lang('machine_category'),
				lang('machine_group_name'),
				lang('machine_status'),
				lang('blacklist'),
			));
			
			$last_query = $this->machine_listing->get_last_query();
			
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
							$machine_visible = $row['machine_visible'];
							$blacklist = '';
							
							if ( $machine_visible ) {
								$blacklist = 'no';
							} else {
								$blacklist = 'yes';
							}
							
							$data_row = array($row['machine_name']);
							
							if ( $sys_user_type == 'superadmin' ) {
								$data_row[] = $row['business_name'];
							}
							
							$data_row = array_merge($data_row, array(
								$row['machine_os_name'],
								$row['machine_ip_address'],
								$row['machine_mac_address'],
								$row['machine_category_name'],
								$row['machine_group_name'],
								$row['machine_status'],
								$blacklist,
							));
							
							fputcsv($fh, $data_row);
						}
					}
					
					ob_start();
					
					fseek($fh, 0);
					
					fpassthru($fh);
					
					$csv = ob_get_clean();
						
					$this->output->set_content_type('application/csv');
					$this->output->set_header('Content-Disposition: attachment; filename=machine-list.csv');
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
							$machine_visible = $row['machine_visible'];
							$blacklist = '';
							
							if ( $machine_visible ) {
								$blacklist = 'no';
							} else {
								$blacklist = 'yes';
							}
							
							$data_row = array($row['machine_name']);
							
							if ( $sys_user_type == 'superadmin' ) {
								$data_row[] = $row['business_name'];
							}
							
							$data_row = array_merge($data_row, array(
								$row['machine_os_name'],
								$row['machine_ip_address'],
								$row['machine_mac_address'],
								$row['machine_category_name'],
								$row['machine_group_name'],
								$row['machine_status'],
								$blacklist,
							));
							
							$data[] = $data_row;
						}
					}
						
					$html = $this->template->display(array(
						'header' => $header_columns,
						'data' => $data,
						'page_title' => 'Machine List',
					), true);
						
					require_once('mpdf60/mpdf.php');
						
					$mpdf = new mPDF();
						
					$mpdf->WriteHTML($html);
						
					$mpdf->Output('machine-list.pdf', 'I');
						
					break;
			}
		} else {
			$this->template->set_js('~/js/machine_list.js');
			$this->template->set_layout('default');
			$this->template->set_content('machine_list');
			$this->template->display(array(
				'list' => $this->machine_listing->render(),
				'filter_form' => $this->machine_filter_form->render(),
				'per_page_options' => $per_page_options,
			));
		}
	}
	
	public function inv_detail($machine_id)
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny(true, 'login');
		}
		
		$this->machine_model->load(array(
			'machine_id' => $machine_id,
		));
		
		if ( $this->machine_model->is_empty() ) {
			show_404();
		}
		
		$data = array(
			'form' => '',
		);
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		
		if ( $sys_user_type != 'superadmin' ) {
			$business_model = $sys_user_model->get_business_model();
			$business_id = $business_model->get_value('business_id');
			
			if ( $business_id != $this->machine_model->get_value('business_id') ) {
				$this->access_deny(true, 'machine/inventory');
			}
		}
		
		$this->load->library('forms/machine_inventory_form', array(
			'name' => 'inventory_form',
			'action' => 'machine/inv_detail/' . $machine_id,
			'method' => 'post',
			'models' => array($this->machine_model),
			'layout' => 'bootstrap_horizontal',
			'submit_label' => lang('save'),
		));
		
		if ( $this->machine_inventory_form->is_submission_succeed() ) {
			$this->system->set_message('success', lang('machine_inventory_updated'));
			
			redirect('machine/inv_detail/' . $machine_id);
		}
		
		$data['form'] = $this->machine_inventory_form->render();
		
		$this->template->set_layout('default');
		$this->template->set_content('machine_inventory_detail');
		$this->template->display($data);
	}
	
	public function inventory()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny(true, 'login');
		}
		
		$data = array();
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		$business_id = 0;
		
		if ( $sys_user_type != 'superadmin' ) {
			$business_model = $sys_user_model->get_business_model();
			$business_id = $business_model->get_value('business_id');
		}
		
		$per_page_options = array(10, 20, 30, 50, 100);
		$per_page = $this->input->get('per_page');
		
		if ( !in_array($per_page, $per_page_options) ) {
			$per_page = array_first($per_page_options);
		}
		
		$data['per_page_options'] = $per_page_options;
		
		$this->load->library('forms/machine_inventory_filter_form', array(
			'name' => 'filter_form',
			'action' => 'machine/inventory',
			'method' => 'get',
			'layout' => 'bootstrap_inline',
			'show_business_filter' => ($sys_user_type == 'superadmin'),
		));
		
		$data['filter_form'] = $this->machine_inventory_filter_form->render();
		
		$this->load->library('listings/machine_inventory_listing', array(
			'layout' => 'bootstrap_column_listing',
			'business_id' => $business_id,
		));
		
		if ( $this->input->get('export') ) {
			$export_file_type = $this->input->get('export');
			
			$header_columns = array(
				lang('machine_name'),
				lang('machine_serial_number'),
				lang('machine_mac_address'),
				lang('machine_model'),
				lang('machine_os'),
				lang('machine_group_name'),
				lang('machine_year'),
				lang('machine_year_expired'),
				lang('machine_condition'),
			);
			
			$last_query = $this->machine_inventory_listing->get_last_query();
			
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
							$year_bought = intval($row['machine_year']);
							
							if ( !$year_bought ) {
								$year_bought = 'n/a';
							}
							
							$data_row = array(
								$row['machine_name'],
								string_ensure($row['machine_serial_number'], 'n/a'),
								$row['machine_mac_address'],
								string_ensure($row['machine_model'], 'n/a'),
								$row['machine_os_name'],
								$row['machine_group_name'],
								string_ensure($row['machine_year'], 'n/a'),
								string_ensure($row['machine_support_expiry'], 'n/a'),
								string_ensure($row['machine_physical_status'], 'n/a'),
							);
							
							fputcsv($fh, $data_row);
						}
					}
					
					ob_start();
					
					fseek($fh, 0);
					
					fpassthru($fh);
					
					$csv = ob_get_clean();
						
					$this->output->set_content_type('application/csv');
					$this->output->set_header('Content-Disposition: attachment; filename=machine-inventory-list.csv');
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
							$year_bought = intval($row['machine_year']);
							
							if ( !$year_bought ) {
								$year_bought = 'n/a';
							}
							
							$data_row = array(
								$row['machine_name'],
								string_ensure($row['machine_serial_number'], 'n/a'),
								$row['machine_mac_address'],
								string_ensure($row['machine_model'], 'n/a'),
								$row['machine_os_name'],
								$row['machine_group_name'],
								string_ensure($row['machine_year'], 'n/a'),
								string_ensure($row['machine_support_expiry'], 'n/a'),
								string_ensure($row['machine_physical_status'], 'n/a'),
							);
							
							$data[] = $data_row;
						}
					}
						
					$html = $this->template->display(array(
						'header' => $header_columns,
						'data' => $data,
						'page_title' => 'Machine List',
					), true);
						
					require_once('mpdf60/mpdf.php');
						
					$mpdf = new mPDF();
						
					$mpdf->WriteHTML($html);
						
					$mpdf->Output('machine-inventory-list.pdf', 'I');
						
					break;
			}
		} else {
			$data['list'] = $this->machine_inventory_listing->render();
			
			// Javascripts for file upload.
			$this->template->set_js(array(
				'//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js',
				'//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js',
				'!/js/jquery.ui.widget.js',
				'!/js/jquery.iframe-transport.js',
				'!/js/jquery.fileupload.js',
				'!/js/jquery.fileupload-process.js',
				'!/js/jquery.fileupload-image.js',
				'!/js/jquery.fileupload-validate.js',
			));
			
			$this->template->set_js('~/js/machine_inventory.js');
			$this->template->set_layout('default');
			$this->template->set_content('machine_inventory');
			$this->template->display($data);
		}
	}
	
	public function overview()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny(true, 'login');
		}
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		$business_id = 0;
		
		if ( $sys_user_type != 'superadmin' ) {
			$business_model = $sys_user_model->get_business_model();
			$business_id = $business_model->get_value('business_id');
		}
		
		$data = array(
			'machine_group_option_list' => get_machine_group_option_list(),
			'machine_uptime' => 0,
			'total_logon_sessions' => 0,
			'total_machines' => 0,
			'machine_activities'=> array(),
			'machine_usage_top5' => array(),
			'overall_machine_usage' => array(),
			'machine_usage_by_years' => array(),
			'machine_by_machine_group' => array(),
			'machine_usage_statistics' => array(),
			'most_used_machines' => array(),
		);
		
		$machine_group_info = parse_machine_group($this->input->get('machine_group'));
		$filter_type = $machine_group_info['type'];
		$machine_group_id = $machine_group_info['id'];
		$selected_business_id = $machine_group_info['business_id'];
		
		if ( $selected_business_id && $selected_business_id != $business_id && $sys_user_type != 'superadmin' ) {
			$this->access_deny(true, 'machine/overview');
		}
		
		# Total logon sessions.
		$this->db->select('COUNT(*) AS total_logon_sessions');
		$this->db->from('user_sessions');
		$this->db->join('users', 'user_sessions.user_id = users.user_id');
		$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
		$this->db->where(array(
			'machines.machine_visible' => 1,
			'users.user_visible' => 1,
		));
		
		if ( $filter_type == 'business' ) {
			$this->db->where('machines.business_id', $selected_business_id);
		} else if ( $filter_type == 'machine_group' ) {
			$this->db->where('machines.machine_group_id', $machine_group_id);
		} else if ( $business_id ) {
			$this->db->where('machines.business_id', $business_id);
		}
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			
			$data['total_logon_sessions'] = intval($row['total_logon_sessions']);
		}
		
		# Total machines.
		$this->db->select('COUNT(*) AS total_machines');
		$this->db->from('machines');
		$this->db->where('machines.machine_visible', 1);
		
		if ( $filter_type == 'business' ) {
			$this->db->where('machines.business_id', $selected_business_id);
		} else if ( $filter_type == 'machine_group' ) {
			$this->db->where('machines.machine_group_id', $machine_group_id);
		} else if ( $business_id ) {
			$this->db->where('machines.business_id', $business_id);
		}
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			
			$data['total_machines'] = intval($row['total_machines']);
		}
		
		# Total active/inactive machines.
		$this->db->select('COUNT(*) AS offline_machines');
		$this->db->from('machines');
		$this->db->where(array(
			'machines.machine_visible' => 1,
			'machines.machine_status' => 'offline',
		));
		
		if ( $filter_type == 'business' ) {
			$this->db->where('machines.business_id', $selected_business_id);
		} else if ( $filter_type == 'machine_group' ) {
			$this->db->where('machines.machine_group_id', $machine_group_id);
		} else if ( $business_id ) {
			$this->db->where('machines.business_id', $business_id);
		}
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			
			$offline_machines = intval($row['offline_machines']);
			$online_machines = $data['total_machines'] - $offline_machines;
			$data['machine_activities'] = array(
				'online' => $online_machines,
				'offline' => $offline_machines,
			);
		}
		
		# Machine usage by machine group (Top 5).
		$data['machine_usage_top5'] = $this->_top5_machine_usage('today', ($selected_business_id ? $selected_business_id : $business_id));
		
		# Overall machine usage (within this week).
		$monday_time = strtotime('monday this week');
		$sunday_time = strtotime('sunday this week');
		$start_time = $monday_time;
		$now = time();
		$today_date = date('Y-m-d');
		$row_data = array();
		
		while ( $start_time <= $sunday_time ) {
			$end_time = strtotime('+1 day', $start_time);
			$null_compare = 0;
			$date_label = date('D, j/n/Y', $start_time);
			
			// We will include the result if the date is on today.
			if ( $end_time < $now || date('Y-m-d', $start_time) == $today_date ) {
				$null_compare = 1;
			}
			
			//echo date('Y-m-d H:i:s', $start_time) . ' ';
			//echo date('Y-m-d H:i:s', $end_time) . ' ';
			
			$this->db->select('COUNT(*) total_sessions');
			$this->db->from('user_sessions');
			$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
			$this->db->join('users', 'user_sessions.user_id = users.user_id');
			$this->db->group_by('user_sessions.user_session_starter');
			$this->db->where(array(
				'users.user_visible' => 1,
				'machines.machine_visible' => 1,
			));
			$this->db->where('(UNIX_TIMESTAMP(user_sessions.user_session_start) BETWEEN "' . $start_time . '" AND "' . $end_time . '" OR 
				UNIX_TIMESTAMP(user_sessions.user_session_end) BETWEEN "' . $start_time . '" AND "' . $end_time . '" OR 
				(UNIX_TIMESTAMP(user_sessions.user_session_start) < "' . $end_time . '" AND user_sessions.user_session_end IS NULL AND 1 = "' . $null_compare . '"))');
			$this->db->order_by('total_sessions', 'desc');
			$this->db->limit(1);
			
			if ( $machine_group_id ) {
				$this->db->where('machines.machine_group_id', $machine_group_id);
			} else if ( $selected_business_id ) {
				$this->db->where('machines.business_id', $selected_business_id);
			} else if ( $business_id ) {
				$this->db->where('machines.business_id', $business_id);
			}
			
			$qry = $this->db->get();
			$total_sessions = 0;
			
			if ( $qry->num_rows() ) {
				$row = $qry->row_array();
				
				$total_sessions = intval($row['total_sessions']);
			}
			
			$row_data[] = array($date_label, $total_sessions);
			
			$start_time = $end_time;
		}
		
		$data['overall_machine_usage'] = $row_data;
		
		# Machine by purchase years.
		$this_year = date('Y');
		$purchase_years = array(
			'year_0' => $this_year,
			'year_1' => array($this_year - 3, $this_year - 1),
			'year_2' => array($this_year - 6, $this_year - 4),
			'year_3' => $this_year - 7,
		);
		
		foreach ( $purchase_years as $year_name => $year ) {
			$this->db->select('COUNT(*) AS total_machines');
			$this->db->from('machines');
			$this->db->where('machine_visible', 1);
			$this->db->where('machine_year IS NOT NULL');
			
			if ( $year_name == 'year_0' ) {
				$this->db->where('machine_year >=', $year);
			} else if ( $year_name == 'year_3' ) {
				$this->db->where('machine_year <', $year);
			} else {
				$this->db->where('machine_year BETWEEN "' . $year[0] . '" AND "' . $year[1] . '"');
			}
			
			if ( $machine_group_id ) {
				$this->db->where('machine_group_id', $machine_group_id);
			} else if ( $selected_business_id ) {
				$this->db->where('business_id', $selected_business_id);
			} else if ( $business_id ) {
				$this->db->where('machines.business_id', $business_id);
			}
			
			$qry = $this->db->get();
			$total_machines = 0;
			
			if ( $qry->num_rows() ) {
				$row = $qry->row_array();
				
				$total_machines = intval($row['total_machines']);
			}
			
			$year_label = lang($year_name);
			
			$data['machine_usage_by_years'][] = array($year_label, $total_machines);
		}
		
		# Total machines in each machine group.
		$this->db->select('machine_groups.*, COUNT(*) AS total_machines');
		$this->db->from('machines');
		$this->db->join('machine_groups', 'machines.machine_group_id = machine_groups.machine_group_id');
		$this->db->where('machines.machine_group_id IS NOT NULL');
		$this->db->group_by('machines.machine_group_id');
		
		if ( $selected_business_id ) {
			$this->db->where('machines.business_id', $selected_business_id);
		} else if ( $business_id ) {
			$this->db->where('machines.business_id', $business_id);
		}
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			foreach ( $qry->result_array() as $machine_group_row ) {
				$data['machine_by_machine_group'][] = $machine_group_row;
			}
		}
		
		# Machine usage statistics.
		$periods = array(
			'today', 'this week', 'this month', 'this year',
		);
		
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
				'machines.machine_visible' => 1,
				'users.user_visible' => 1,
			));
			
			if ( $machine_group_id ) {
				$this->db->where('machines.machine_group_id', $machine_group_id);
			} else if ( $selected_business_id ) {
				$this->db->where('machines.business_id', $selected_business_id);
			} else if ( $business_id ) {
				$this->db->where('machines.business_id', $business_id);
			}
			
			$qry = $this->db->get();
			$total_sessions = 0;
			
			if ( $qry->num_rows() ) {
				$row = $qry->row_array();
				$total_sessions = intval($row['total_sessions']);
			}
			
			$data['machine_usage_statistics'][] = array(
				$date_label, $total_sessions,
			);
		}
		
		# Most used machines (top5)
		$this->db->select('machines.*, machine_groups.*, last_logon_users.*, COUNT(*) AS total_sessions');
		$this->db->from('user_sessions');
		$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
		$this->db->join('machine_groups', 'machines.machine_group_id = machine_groups.machine_group_id');
		$this->db->join('users', 'user_sessions.user_id = users.user_id');
		$this->db->join('users last_logon_users', 'machines.machine_last_login_user = last_logon_users.user_id', 'left');
		$this->db->where(array(
			'machines.machine_visible' => 1,
			'users.user_visible' => 1,
		));
		$this->db->group_by('user_sessions.machine_id');
		$this->db->order_by('total_sessions', 'desc');
		$this->db->limit(5);
		
		if ( $machine_group_id ) {
			$this->db->where('machines.machine_group_id', $machine_group_id);
		} else if ( $selected_business_id ) {
			$this->db->where('machines.business_id', $selected_business_id);
		} else if ( $business_id ) {
			$this->db->where('machines.business_id', $business_id);
		}
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			foreach ( $qry->result_array() as $row ) {
				$machine_name = $row['machine_name'];
				$machine_group_name = $row['machine_group_name'];
				$last_login_name = $row['user_name'];
				$last_login_date = user_date($row['machine_last_login'], 'j/n/Y H:i:s');
				$total_sessions = intval($row['total_sessions']);
				
				$data['most_used_machines'][] = array(
					'machine_name' => $machine_name,
					'machine_group_name' => $machine_group_name,
					'last_login_name' => $last_login_name,
					'last_login_date' => $last_login_date,
					'total_sessions' => $total_sessions,
				);
			}
		}
		
		//print_r($data); exit();
		
		$this->template->set_js('!/js/jquery.slimscroll.min.js');
		$this->template->set_js('~/js/slimscroll.initialize.js');
		$this->template->set_js('//www.google.com/jsapi');
		$this->template->set_js('~/js/chart_initialization.js');
		$this->template->set_js('~/js/machine_overview.js');
		$this->template->set_layout('default');
		$this->template->set_content('machine_overview');
		$this->template->display($data);
	}
	
	/**
	 * This return the top 5 machine usage chart data.
	 * 
	 * @param string $period
	 * @param int $business_id
	 * @return array
	 */
	protected function _top5_machine_usage($period, $business_id = 0)
	{
		$columns = array();
		$data = array();
		
		// Determine the step, start and end date.
		$step = '';
		$start_date = '';
		$end_date = '';
		$start_datetime = 0;
		$end_datetime = 0;
		$now = time();
		$today_hour = date('Y-m-d H');
		$today_date = date('Y-m-d');
		$today_month = date('Y-m');
		$null_compare = 0;
		$is_current = false;
		
		switch ( $period ) {
			case 'today':
				$step = '+1 hour';
				$start_date = date('Y-m-d') . ' 00:00:00';
				$end_date = date('Y-m-d') . ' 23:59:59';
				$start_datetime = strtotime($start_date);
				$end_datetime = strtotime($end_date);
				$columns[] = array('string', lang('hour'));
				$is_current = (date('Y-m-d H', $start_datetime) == date('Y-m-d H'));
				break;
			case 'this week':
				$step = '+1 day';
				$monday = strtotime('monday this week');
				$sunday = strtotime('sunday this week');
				$start_date = date('Y-m-d', $monday);
				$end_date = date('Y-m-d', $sunday);
				$start_datetime = strtotime($start_date . ' 00:00:00');
				$end_datetime = strtotime($end_date . ' 23:59:59');
				$columns[] = array('string', lang('day'));
				$is_current = (date('Y-m-d', $start_datetime) == date('Y-m-d'));
				break;
			case 'this month':
				$step = '+1 day';
				$start_date = date('Y-m-1');
				$end_date = date('Y-m-t');
				$start_datetime = strtotime($start_date . ' 00:00:00');
				$end_datetime = strtotime($end_date . ' 23:59:59');
				$columns[] = array('string', lang('date'));
				$is_current = (date('Y-m-d', $start_datetime) == date('Y-m-d'));
				break;
			case 'this year':
				$step = '+1 month';
				$start_date = date('Y-01-01');
				$end_date = date('Y-12-31');
				$start_datetime = strtotime($start_date . ' 00:00:00');
				$end_datetime = strtotime($end_date . ' 23:59:59');
				$columns[] = array('string', lang('month'));
				$is_current = (date('Y-m', $start_datetime) == date('Y-m'));
				break;
		}
		
		if ( $end_datetime > $now || $is_current ) {
			$null_compare = 1;
		}
		
		// Get the top5 machine logon sessions.
		$this->db->select('machine_groups.*, COUNT(*) AS total_sessions');
		$this->db->from('user_sessions');
		$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
		$this->db->join('users', 'user_sessions.user_id = users.user_id');
		$this->db->join('machine_groups', 'machines.machine_group_id = machine_groups.machine_group_id');
		$this->db->where(array(
			'users.user_visible' => 1,
			'machines.machine_visible' => 1,
		));
		$this->db->where('(UNIX_TIMESTAMP(user_sessions.user_session_start) BETWEEN "' . $start_datetime . '" AND "' . $end_datetime . '" OR
			UNIX_TIMESTAMP(user_sessions.user_session_end) BETWEEN "' . $start_datetime . '" AND "' . $end_datetime . '" OR 
			(UNIX_TIMESTAMP(user_sessions.user_session_start) < "' . $end_datetime . '" AND user_sessions.user_session_end IS NULL AND 1 = ' . $null_compare . '))');
		$this->db->group_by('machines.machine_group_id');
		$this->db->order_by('total_sessions', 'desc');
		$this->db->limit(5);
		
		if ( $business_id ) {
			$this->db->where('machines.business_id', $business_id);
		}
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			// Add-in the machine group label to columns.
			foreach ( $qry->result_array() as $row ) {
				$machine_group_name = $row['machine_group_name'];
				$columns[] = array('number', $machine_group_name);
			}
			
			$time = $start_datetime;
			
			while ( $time <= $end_datetime ) {
				$end_time = strtotime($step, $time);
				$date_label = '';
				$null_compare = 0;
				
				if ( $end_time < $now ||
					($period == 'today' && date('Y-m-d H', $time) == $today_hour ) ||
					(($period == 'this week' || $period == 'this month') && date('Y-m-d', $time) == $today_date) ||
				    ($period == 'this year' && date('Y-m', $time) == $today_month ) ) {
					$null_compare = 1;
				}
				
				switch ( $period ) {
					case 'today':
						$date_label = date('ga', $time);
						break;
					case 'this week':
						$date_label = date('D, j/n/Y', $time);
						break;
					case 'this month':
						$date_label = date('j/n/Y', $time);
						break;
					case 'this year':
						$date_label = date('M, Y', $time);
						break;
				}
				
				$data_row = array($date_label);
				
				foreach ( $qry->result_array() as $user_session_row ) {
					$machine_group_id = $user_session_row['machine_group_id'];
					
					// Find the number of sessions for this period.
					$this->db->select('COUNT(*) AS sessions');
					$this->db->from('user_sessions');
					$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
					$this->db->join('users', 'user_sessions.user_id = users.user_id');
					$this->db->where(array(
						'machines.machine_visible' => 1,
						'users.user_visible' => 1,
					));
					$this->db->where('(UNIX_TIMESTAMP(user_sessions.user_session_start) BETWEEN "' . $time . '" AND "' . $end_time . '" OR
						UNIX_TIMESTAMP(user_sessions.user_session_end) BETWEEN "' . $time . '" AND "' . $end_time . '" OR
						(UNIX_TIMESTAMP(user_sessions.user_session_start) < "' . $end_time . '" AND user_sessions.user_session_end IS NULL AND 1 = ' . $null_compare . '))');
					$this->db->where('machines.machine_group_id', $machine_group_id);
						
					if ( $business_id ) {
						$this->db->where('machines.business_id', $business_id);
					}
						
					$sub_qry = $this->db->get();
					
					$sessions = 0;
						
					if ( $sub_qry->num_rows() ) {
						$session_count_row = $sub_qry->row_array();
						$sessions = intval($session_count_row['sessions']);
					}
					
					$data_row[] = $sessions;
				}
				
				// Append the data row.
				$data[] = $data_row;
					
				// Increment.
				$time = $end_time;
			}
		}
		
		if ( iterable($data) ) {
			return array(
				'data' => $data,
				'columns' => $columns,
			);
		} else {
			return false;
		}
	}
}