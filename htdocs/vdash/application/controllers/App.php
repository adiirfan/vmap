<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends EB_Controller {
	public function init()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny(true, 'login');
		}
		
		$this->load->model('App_model', 'app_model');
	}
	
	public function a_clear_inv()
	{
		$token = $this->input->get('token');
		$app_id = $this->input->get('app_id');
		
		if ( !$this->system->verify_client_id($token) ) {
			$this->access_deny();
		}
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		$this->app_model->load(array(
			'app_id' => $app_id,
		));
		
		if ( $this->app_model->is_empty() ) {
			$output['error'] = 1;
			$output['message'] = lang('error_app_id_not_found');
		} else {
			$sys_user_model = $this->authentication->get_model();
			$sys_user_type = $sys_user_model->get_value('sys_user_type');
			
			if ( $sys_user_type != 'superadmin' ) {
				// Make sure the application ID is under this user's business.
				$business_model = $sys_user_model->get_business_model();
				$business_id = $business_model->get_value('business_id');
				
				$qry = $this->db->get_where('apps', array(
					'app_id' => $app_id,
					'business_id' => $business_id,
				));
				
				if ( !$qry->num_rows() ) {
					$this->access_deny();
				}
			}
		}
		
		// Now, white the user defined data.
		$this->app_model->remove_user_data();
		
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
									'app_sys_name' => 'app_sys_name',
									'app_name' => 'app_friendly_name',
									'app_license_count' => 'app_license_count',
									'app_version' => 'app_version',
									'app_license_type' => 'app_license_type',
									'app_vendor' => 'app_vendor',
									'app_purchase_date' => 'app_purchase_date',
									'app_expiry_date' => 'app_expiry_date',
									'app_virtualized' => 'app_virtualized',
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
									$this->load->model('App_model', 'app_model');
									$this->load->model('App_filter_model', 'app_filter_model');
									
									foreach ( $data as $app ) {
										$app_sys_name = array_ensure($app, 'app_sys_name', '');
										
										$qry = $this->db->get_where('apps', array(
											'app_sys_name' => $app_sys_name,
											'business_id' => $business_id,
										));
										
										if ( $qry->num_rows() ) {
											$app_row = $qry->row_array();
											$app['app_id'] = $app_row['app_id'];
										} else {
											// Filter, check if the application required filter.
											$result = $this->app_filter_model->filter_all($business_id, $app_sys_name);
												
											if ( $result ) {
												$action = array_ensure($result, 'app_filter_action', '');
											
												if ( $action == 'block' ) {
													$app['app_visible'] = 0;
												}
											}
										}
										
										$app['business_id'] = $business_id;
										
										// Ensure field values.
										if ( isset($app['app_license_count']) ) {
											$app['app_license_count'] = intval($app['app_license_count']);
										}
										
										// Ensure the date format.
										if ( isset($app['app_purchase_date']) ) {
											$t = strtotime($app['app_purchase_date']);
											
											if ( false !== $t ) {
												$app['app_purchase_date'] = db_date($t, true);
											} else {
												unset($app['app_purchase_date']);
											}
										}
										
										if ( isset($app['app_expiry_date']) ) {
											$t = strtotime($app['app_expiry_date']);
											
											if ( false !== $t ) {
												$app['app_expiry_date'] = db_date($t, true);
											} else {
												unset($app['app_expiry_date']);
											}
										}
										
										$this->app_model->set_data($app);
									}
									
									// Save/update all.
									$this->app_model->save(true);
								}
							}
						}
					}
				}
			}
		}
		
		json_output($output);
	}
	
	public function a_load_app_usage()
	{
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		$token = $this->input->get('token');
		$start = $this->input->get('date_start');
		$end = $this->input->get('date_end');
		$business_id = $this->input->get('business');
		
		if ( !$this->system->verify_client_id($token) ) {
			$this->access_deny();
		}
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		
		if ( $sys_user_type != 'superadmin' ) {
			$business_model = $sys_user_model->get_business_model();
			$business_id = $business_model->get_value('business_id');
		}
		
		$data = $this->_app_usage_chart_data($start, $end, $business_id);
		
		$output['result'] = $data;
		
		json_output($output);
	}
	
	public function a_set_visibility()
	{
		$output = array(
			'error' => 0,
			'message' => '',
		);
	
		$token = $this->input->get('token');
		$app_id = $this->input->get('app_id');
		$visibility = $this->input->get('visibility');
		$visibility = ($visibility ? 1 : 0);
	
		// Verify the token.
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->app_model->load(array(
				'app_id' => $app_id,
			));
				
			if ( $this->app_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_app_id_not_found');
			} else {
				if ( !$this->app_model->set_visibility($visibility) ) {
					$output['error'] = 1;
					$output['message'] = lang('error_app_set_visibility');
				}
			}
		}
	
		json_output($output);
	}
	
	public function detail($app_id)
	{
		$this->app_model->load(array(
			'app_id' => $app_id,
		));
		
		if ( $this->app_model->is_empty() ) {
			show_404();
		}
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		
		// Verify this user has the access to this user profile.
		if ( $sys_user_type != 'superadmin' ) {
			$business_model = $sys_user_model->get_business_model();
			$business_id = $business_model->get_value('business_id');
				
			if ( $this->app_model->get_value('business_id') != $business_id ) {
				$this->access_deny(true, 'app/index');
			}
		}
		
		$data = array(
			'app_data' => $this->app_model->get_data(),
			'total_instances' => 0,
			'max_concurrent_app' => 0,
			'most_used_user' => false,
			'most_used_machine_group' => false,
			'most_used_machine' => false,
			'top5_used_machines' => false,
			'max_concurrent_periods' => array(
				'today' => false,
				'this_week' => false,
				'this_month' => false,
				'this_year' => false,
			),
		);
		
		# Total instances
		$this->db->select('COUNT(*) AS total_instances');
		$this->db->from('app_sessions');
		$this->db->where('app_id', $app_id);
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			
			$data['total_instances'] = intval($row['total_instances']);
		}
		
		# Max concurrent instances.
		$this->db->select('COUNT(*) AS concurrent_instances');
		$this->db->from('app_sessions');
		$this->db->join('apps', 'app_sessions.app_id = apps.app_id');
		$this->db->where('app_sessions.app_id', $app_id);
		$this->db->group_by('app_session_starter_id');
		$this->db->order_by('concurrent_instances', 'desc');
		$this->db->limit(5);
		
		$max_concurrent_qry = $this->db->get();
		
		if ( $max_concurrent_qry->num_rows() ) {
			$row = $max_concurrent_qry->row_array();
			$data['max_concurrent_app'] = intval($row['concurrent_instances']);
		}
		
		# Most used user.
		$this->db->select('users.*, COUNT(*) AS instances_utilized');
		$this->db->from('app_sessions');
		$this->db->join('user_sessions', 'app_sessions.user_session_id = user_sessions.user_session_id');
		$this->db->join('users', 'user_sessions.user_id = users.user_id');
		$this->db->where('app_sessions.app_id', $app_id);
		$this->db->group_by('user_sessions.user_id');
		$this->db->order_by('instances_utilized', 'desc');
		$this->db->limit(5);
		
		$max_user_instances_qry = $this->db->get();
		
		if ( $max_user_instances_qry->num_rows() ) {
			$data['most_used_user'] = $max_user_instances_qry->row_array();
		}
		
		# Most used by machine group.
		$this->db->select('machine_groups.*, COUNT(*) AS instances_utilized');
		$this->db->from('app_sessions');
		$this->db->join('user_sessions', 'app_sessions.user_session_id = user_sessions.user_session_id');
		$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
		$this->db->join('machine_groups', 'machines.machine_group_id = machine_groups.machine_group_id');
		$this->db->where(array(
			'app_sessions.app_id' => $app_id,
			'machines.machine_group_id <>' => null,
		));
		$this->db->group_by('machines.machine_group_id');
		$this->db->order_by('instances_utilized', 'desc');
		$this->db->limit(5);
		
		$max_machine_group_qry = $this->db->get();
		
		if ( $max_machine_group_qry->num_rows() ) {
			$data['most_used_machine_group'] = $max_machine_group_qry->row_array();
		}
		
		# Most used by which machine.
		$this->db->select('machines.*, COUNT(*) AS instances_utilized');
		$this->db->from('app_sessions');
		$this->db->join('user_sessions', 'app_sessions.user_session_id = user_sessions.user_session_id');
		$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
		$this->db->where('app_sessions.app_id', $app_id);
		$this->db->group_by('user_sessions.machine_id');
		$this->db->order_by('instances_utilized', 'desc');
		$this->db->limit(5);
		
		$max_machine_qry = $this->db->get();
		
		if ( $max_machine_qry->num_rows() ) {
			$data['most_used_machine'] = $max_machine_qry->row_array();
		}
		
		# Top 5 machines that uses this application.
		if ( $max_machine_qry->num_rows() ) {
			foreach ( $max_machine_qry->result_array() as $row ) {
				$machine_name = $row['machine_name'];
				$instances_launched = intval($row['instances_utilized']);
				
				$data['top5_used_machines'][] = array($machine_name, $instances_launched);
			}
		}
		
		# Max concurrent launched over the time period.
		foreach ( $data['max_concurrent_periods'] as $period => $null ) {
			$this->db->select('COUNT(*) AS total_instances');
			$this->db->from('app_sessions');
			$this->db->where('app_id', $app_id);
			$this->db->group_by('app_session_starter_id');
			$this->db->order_by('total_instances', 'desc');
			$this->db->limit(1);
			
			switch ( $period ) {
				case 'today':
					$this->db->where('DATE(app_start)', date('Y-m-d'));
					break;
				case 'this_week':
					$monday = date('Y-m-d', strtotime('monday this week'));
					$sunday = date('Y-m-d', strtotime('sunday this week'));
					
					$this->db->where('DATE(app_start) BETWEEN "' . $monday . '" AND "' . $sunday . '"');
					break;
				case 'this_month':
					$date_1 = date('Y-m-1');
					$date_2 = date('Y-m-t');
					
					$this->db->where('DATE(app_start) BETWEEN "' . $date_1 . '" AND "' . $date_2 . '"');
					break;
				case 'this_year':
					$date_1 = date('Y-1-1');
					$date_2 = date('Y-12-31');
						
					$this->db->where('DATE(app_start) BETWEEN "' . $date_1 . '" AND "' . $date_2 . '"');
					break;
			}
			
			$qry = $this->db->get();
			
			if ( $qry->num_rows() ) {
				$row = $qry->row_array();
				
				$data['max_concurrent_periods'][$period] = intval($row['total_instances']);
			}
		}
		
		# Machine information table.
		$this->load->library('listings/app_machine_listing', array(
			'layout' => 'bootstrap_column_listing',
			'app_id' => $app_id,
		));
		
		$data['machine_list'] = $this->app_machine_listing->render();
		
		# User information table.
		$this->load->library('listings/app_user_listing', array(
			'layout' => 'bootstrap_column_listing',
			'app_id' => $app_id,
		));
		
		$data['user_list'] = $this->app_user_listing->render();
		
		// print_r($data); exit();
		
		$this->template->set_js('//www.google.com/jsapi');
		$this->template->set_js('~/js/chart_initialization.js');
		$this->template->set_page_title(lang('app_detail'));
		$this->template->set_layout('default');
		$this->template->set_content('app_detail');
		$this->template->display($data);
	}
	
	public function index()
	{
		$data = array();
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		
		$business_id = 0;
		$per_page_options = array(10, 20, 30, 50, 100);
		$per_page = $this->input->get('per_page');
		
		if ( !in_array($per_page, $per_page_options) ) {
			$per_page = array_first($per_page_options);
		}
		
		$data['per_page_options'] = $per_page_options;
		
		if ( $sys_user_type != 'superadmin' ) {
			$business_model = $sys_user_model->get_business_model();
			$business_id = $business_model->get_value('business_id');
		}
		
		$this->load->library('forms/app_filter_form', array(
			'name' => 'app_filter_form',
			'action' => 'app/index',
			'method' => 'get',
			'layout' => 'bootstrap_inline',
			'show_business_filter' => ($business_id ? false : true),
			'submit_label' => '<i class="fa fa-search"></i> ' . lang('search'),
		));
		
		$this->load->library('listings/app_listing', array(
			'layout' => 'bootstrap_column_listing',
			'business_id' => $business_id,
			'per_page' => $per_page,
		));
		
		if ( $this->input->get('export') ) {
			$export_file_type = $this->input->get('export');
			
			$header_columns = array(lang('application'));
				
			if ( $sys_user_type == 'superadmin' ) {
				$header_columns[] = lang('business');
			}
				
			$header_columns = array_merge($header_columns, array(
				lang('app_license'),
				lang('app_max_concurrent'),
				lang('app_this_week_instances'),
				lang('app_this_month_instances'),
				lang('app_utilization'),
				lang('blacklist'),
			));
			
			$last_query = $this->app_listing->get_last_query();
			
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
							$instances = intval($row['concurrent_instances']);
							$license_count = intval($row['app_license_count']);
							$percentage = 'n/a';
							$app_visible = $row['app_visible'];
							$blacklist = '';
							
							if ( $license_count ) {
								$percentage = round($instances / $license_count * 100);
									
								$percentage .= '%';
							}
							
							if ( $app_visible ) {
								$blacklist = 'no';
							} else {
								$blacklist = 'yes';
							}
							
							$data_row = array($row['app_sys_name']);
							
							if ( $sys_user_type == 'superadmin' ) {
								$data_row[] = $row['business_name'];
							}
							
							$data_row = array_merge($data_row, array(
								$row['app_license_count'],
								$row['concurrent_instances'],
								$row['this_week_instances'],
								$row['this_month_instances'],
								$percentage,
								$blacklist
							));
							
							fputcsv($fh, $data_row);
						}
					}
					
					ob_start();
					
					fseek($fh, 0);
					
					fpassthru($fh);
					
					$csv = ob_get_clean();
						
					$this->output->set_content_type('application/csv');
					$this->output->set_header('Content-Disposition: attachment; filename=app-list.csv');
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
							$instances = intval($row['concurrent_instances']);
							$license_count = intval($row['app_license_count']);
							$percentage = 'n/a';
							$app_visible = $row['app_visible'];
							$blacklist = '';
							
							if ( $license_count ) {
								$percentage = round($instances / $license_count * 100);
									
								$percentage .= '%';
							}
							
							if ( $app_visible ) {
								$blacklist = 'no';
							} else {
								$blacklist = 'yes';
							}
							
							$data_row = array($row['app_sys_name']);
							
							if ( $sys_user_type == 'superadmin' ) {
								$data_row[] = $row['business_name'];
							}
							
							$data_row = array_merge($data_row, array(
								intval($row['app_license_count']),
								intval($row['concurrent_instances']),
								intval($row['this_week_instances']),
								intval($row['this_month_instances']),
								$percentage,
								$blacklist
							));
							
							$data[] = $data_row;
						}
					}
						
					$html = $this->template->display(array(
						'header' => $header_columns,
						'data' => $data,
						'page_title' => 'App List',
					), true);
						
					require_once('mpdf60/mpdf.php');
						
					$mpdf = new mPDF();
						
					$mpdf->WriteHTML($html);
						
					$mpdf->Output('app-list.pdf', 'I');
						
					break;
			}
		} else {
			$data['filter_form'] = $this->app_filter_form->render();
			$data['list'] = $this->app_listing->render();
			
			$this->template->set_js('~/js/app_list.js');
			$this->template->set_layout('default');
			$this->template->set_content('app_list');
			$this->template->display($data);
		}
	}
	
	public function inventory()
	{
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		$business_id = 0;
		
		if ( $sys_user_type != 'superadmin' ) {
			$business_model = $sys_user_model->get_business_model();
			$business_id = $business_model->get_value('business_id');
		}
		
		$data = array();
		
		$per_page_options = array(10, 20, 30, 50, 100);
		$per_page = $this->input->get('per_page');
		
		if ( !in_array($per_page, $per_page_options) ) {
			$per_page = array_first($per_page_options);
		}
		
		$data['per_page_options'] = $per_page_options;
		
		$this->load->library('forms/app_inventory_filter_form', array(
			'name' => 'filter_form',
			'action' => 'app/inventory',
			'method' => 'get',
			'layout' => 'bootstrap_inline',
			'show_business_filter' => ($sys_user_type == 'superadmin'),
			'submit_label' => '<i class="fa fa-search"></i> ' . lang('search'),
		));
		
		$this->load->library('listings/app_inventory_listing', array(
			'layout' => 'bootstrap_column_listing',
			'business_id' => $business_id,
		));
		
		if ( $this->input->get('export') ) {
			$export_file_type = $this->input->get('export');
			
			$header_columns = array(
				lang('app_name'),
				lang('app_license_type'),
				lang('app_license_number'),
				lang('app_version'),
				lang('app_vendor'),
				lang('app_purchase_date'),
				lang('app_expiry_date'),
				lang('app_virtualized'),
			);
			
			$last_query = $this->app_inventory_listing->get_last_query();
			
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
							$data_row = array(
								$row['app_friendly_name'],
								$row['app_license_type'],
								intval($row['app_license_count']),
								$row['app_version'],
								$row['app_vendor'],
								$row['app_purchase_date'],
								$row['app_expiry_date'],
								$row['app_virtualized'],
							);
							
							fputcsv($fh, $data_row);
						}
					}
					
					ob_start();
					
					fseek($fh, 0);
					
					fpassthru($fh);
					
					$csv = ob_get_clean();
						
					$this->output->set_content_type('application/csv');
					$this->output->set_header('Content-Disposition: attachment; filename=app-inventory-list.csv');
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
							$data_row = array(
								$row['app_friendly_name'],
								$row['app_license_type'],
								intval($row['app_license_count']),
								$row['app_version'],
								$row['app_vendor'],
								$row['app_purchase_date'],
								$row['app_expiry_date'],
								$row['app_virtualized'],
							);
							
							$data[] = $data_row;
						}
					}
						
					$html = $this->template->display(array(
						'header' => $header_columns,
						'data' => $data,
						'page_title' => 'App List',
					), true);
						
					require_once('mpdf60/mpdf.php');
						
					$mpdf = new mPDF();
						
					$mpdf->WriteHTML($html);
						
					$mpdf->Output('app-inventory-list.pdf', 'I');
						
					break;
			}
		} else {
			$data['filter_form'] = $this->app_inventory_filter_form->render();
			$data['list'] = $this->app_inventory_listing->render();
			
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
			
			$this->template->set_js('~/js/app_inventory.js');
			$this->template->set_layout('default');
			$this->template->set_content('app_inventory');
			$this->template->display($data);
		}
	}
	
	public function inv_detail($app_id)
	{
		$this->app_model->load(array(
				'app_id' => $app_id,
		));
		
		if ( $this->app_model->is_empty() ) {
			show_404();
		} else {
			$sys_user_model = $this->authentication->get_model();
			$sys_user_type = $sys_user_model->get_value('sys_user_type');
				
			if ( $sys_user_type != 'superadmin' ) {
				// Make sure the application ID is under this user's business.
				$business_model = $sys_user_model->get_business_model();
				$business_id = $business_model->get_value('business_id');
		
				$qry = $this->db->get_where('apps', array(
					'app_id' => $app_id,
					'business_id' => $business_id,
				));
		
				if ( !$qry->num_rows() ) {
					$this->access_deny(true, 'app/inventory');
				}
			}
		}
		
		$this->load->library('forms/app_inventory_form', array(
			'name' => 'inventory_form',
			'action' => 'app/inv_detail/' . $app_id,
			'method' => 'post',
			'models' => array($this->app_model),
			'submit_label' => '<i class="fa fa-save"></i> ' . lang('update'),
		));
		
		if ( $this->app_inventory_form->is_submission_succeed() ) {
			$this->system->set_message('success', lang('txt_app_inventory_detail_updated'));
			
			redirect('app/inv_detail/' . $app_id);
		}
		
		$this->template->set_page_title(lang('page_title_app/inv_detail'));
		$this->template->set_layout('default');
		$this->template->set_content('app_inventory_detail');
		$this->template->display(array(
			'form' => $this->app_inventory_form->render(),
		));
	}
	
	public function overview()
	{
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		
		$business_id = 0;
		$date = strtolower(trim($this->input->get('date')));
		$date_options = array(
			'today' => 'today',
			'this_week' => 'this week',
			'this_month' => 'this month',
			'this_year' => 'this year'
		);
		
		$data = array(
			'date_options' => $date_options,
		);
		
		if ( !in_array($date, $date_options) ) {
			$date = 'today';
		}
		
		if ( $sys_user_type == 'superadmin' ) {
			// Load the business option list.
			$this->load->model('Business_model', 'business_model');
			
			$data['business_option_list'] = $this->business_model->get_option_list('business_id', 'business_name', array(
				'order_by' => array('business_name', 'asc'),
			));
			
			$business_code = $this->input->get('business');
			
			$this->business_model->load(array(
				'business_code' => $business_code,
			));
			
			if ( !$this->business_model->is_empty() ) {
				$business_id = $this->business_model->get_value('business_id');
			}
		} else {
			$business_model = $sys_user_model->get_business_model();
			
			$business_id = $business_model->get_value('business_id');
		}
		
		# Total sessions.
		$this->db->select('COUNT(*) AS total_sessions');
		$this->db->from('app_sessions');
		$this->db->join('apps', 'app_sessions.app_id = apps.app_id');
		$this->db->where('apps.app_visible', 1);
		
		if ( $business_id ) {
			$this->db->where('apps.business_id', $business_id);
		}
		
		$this->_apply_date_query($this->db, $date);
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			
			$data['total_sessions'] = intval($row['total_sessions']);
		}
		
		# Total sessions (Small charts).
		$this->db->select('COUNT(*) AS total_sessions');
		$this->db->from('app_sessions');
		$this->db->join('apps', 'app_sessions.app_id = apps.app_id');
		$this->db->where('apps.app_visible', 1);
		
		if ( $business_id ) {
			$this->db->where('apps.business_id', $business_id);
		}
		
		$this->_apply_date_query($this->db, $date);
		
		switch ( $date ) {
			case 'today':
				$this->db->select('HOUR(app_sessions.app_start) AS period');
				$this->db->group_by('HOUR(app_sessions.app_start)');
				break;
			case 'this week':
			case 'this month':
				$this->db->select('DATE(app_sessions.app_start) AS period');
				$this->db->group_by('DATE(app_sessions.app_start)');
				break;
			default:
				$this->db->select('MONTH(app_sessions.app_start) AS period');
				$this->db->group_by('MONTH(app_sessions.app_start)');
				break;
		}
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$data['total_sessions_chart'] = array();
			
			foreach ( $qry->result_array() as $row ) {
				$sessions = intval($row['total_sessions']);
				$period = $row['period'];
			
				switch ( $date ) {
					case 'today':
						$period = intval($period);
						
						if ( $period == 0 ) {
							$period = '12am';
						} else {
							if ( $period < 12 ) {
								$period .= 'am';
							} else {
								if ( $period == 12 ) {
									$period .= 'pm';
								} else {
									$period = ($period - 12) . 'pm';
								}
							}
						}
						
						break;
					case 'this week':
					case 'this month':
						$period = user_date($period, 'j/n/Y');
						break;
					default:
						$period = date('F', strtotime('2016-' . $period . '-01')) . date('Y');
						break;
				}
				
				$data['total_sessions_chart'][] = array($period, $sessions);
			}
		}
		
		# Total applications (unique application).
		$this->db->select('COUNT(DISTINCT(app_sessions.app_id)) AS total_apps');
		$this->db->from('app_sessions');
		$this->db->join('apps', 'app_sessions.app_id = apps.app_id');
		$this->db->where('apps.app_visible', 1);
		
		if ( $business_id ) {
			$this->db->where('apps.business_id', $business_id);
		}
		
		$this->_apply_date_query($this->db, $date);
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			
			$data['total_apps'] = intval($row['total_apps']);
		}
		
		# Total unique applications (Small charts).
		$this->db->select('COUNT(DISTINCT(app_sessions.app_id)) AS total_sessions');
		$this->db->from('app_sessions');
		$this->db->join('apps', 'app_sessions.app_id = apps.app_id');
		$this->db->where('apps.app_visible', 1);
		
		if ( $business_id ) {
			$this->db->where('apps.business_id', $business_id);
		}
		
		$this->_apply_date_query($this->db, $date);
		
		switch ( $date ) {
			case 'today':
				$this->db->select('HOUR(app_sessions.app_start) AS period');
				$this->db->group_by('HOUR(app_sessions.app_start)');
				break;
			case 'this week':
			case 'this month':
				$this->db->select('DATE(app_sessions.app_start) AS period');
				$this->db->group_by('DATE(app_sessions.app_start)');
				break;
			default:
				$this->db->select('MONTH(app_sessions.app_start) AS period');
				$this->db->group_by('MONTH(app_sessions.app_start)');
				break;
		}
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$data['total_apps_chart'] = array();
			
			foreach ( $qry->result_array() as $row ) {
				$sessions = intval($row['total_sessions']);
				$period = $row['period'];
			
				switch ( $date ) {
					case 'today':
						$period = intval($period);
						
						if ( $period == 0 ) {
							$period = '12am';
						} else {
							if ( $period < 12 ) {
								$period .= 'am';
							} else {
								if ( $period == 12 ) {
									$period .= 'pm';
								} else {
									$period = ($period - 12) . 'pm';
								}
							}
						}
						
						break;
					case 'this week':
					case 'this month':
						$period = user_date($period, 'j/n/Y');
						break;
					default:
						$period = date('F', strtotime('2016-' . $period . '-01')) . date('Y');
						break;
				}
				
				$data['total_apps_chart'][] = array($period, $sessions);
			}
		}
		
		# Total application utilization (duration).
		$this->db->select('SUM(IF(app_duration IS NULL, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(app_start), app_duration)) AS total_utilization', false);
		$this->db->from('app_sessions');
		$this->db->join('apps', 'app_sessions.app_id = apps.app_id');
		$this->db->where('apps.app_visible', 1);
		
		if ( $business_id ) {
			$this->db->where('apps.business_id', $business_id);
		}
		
		$this->_apply_date_query($this->db, $date);
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
		
			$application_utilization = intval($row['total_utilization']);
			$data['total_utilization'] = parse_duration($application_utilization);
		}
		
		# Total application utilization (Small charts).
		$this->db->select('SUM(IF(app_duration IS NULL, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(app_start), app_duration)) AS total_utilization', false);
		$this->db->from('app_sessions');
		$this->db->join('apps', 'app_sessions.app_id = apps.app_id');
		$this->db->where('apps.app_visible', 1);
		
		if ( $business_id ) {
			$this->db->where('apps.business_id', $business_id);
		}
		
		$this->_apply_date_query($this->db, $date);
		
		switch ( $date ) {
			case 'today':
				$this->db->select('HOUR(app_sessions.app_start) AS period');
				$this->db->group_by('HOUR(app_sessions.app_start)');
				break;
			case 'this week':
			case 'this month':
				$this->db->select('DATE(app_sessions.app_start) AS period');
				$this->db->group_by('DATE(app_sessions.app_start)');
				break;
			default:
				$this->db->select('MONTH(app_sessions.app_start) AS period');
				$this->db->group_by('MONTH(app_sessions.app_start)');
				break;
		}
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$data['total_utilization_chart'] = array();
			
			foreach ( $qry->result_array() as $row ) {
				$sessions = intval($row['total_utilization']);
				$period = $row['period'];
			
				switch ( $date ) {
					case 'today':
						$period = intval($period);
						
						if ( $period == 0 ) {
							$period = '12am';
						} else {
							if ( $period < 12 ) {
								$period .= 'am';
							} else {
								if ( $period == 12 ) {
									$period .= 'pm';
								} else {
									$period = ($period - 12) . 'pm';
								}
							}
						}
						
						break;
					case 'this week':
					case 'this month':
						$period = user_date($period, 'j/n/Y');
						break;
					default:
						$period = date('F', strtotime('2016-' . $period . '-01')) . date('Y');
						break;
				}
				
				$data['total_utilization_chart'][] = array($period, $sessions);
			}
		}
		
		# Application usage activity chart data.
		// $this->_app_usage_chart_data('2016-01-07', '2016-01-07', $business_id);
		
		# Top5 concurrent launched application.
		$this->db->select('apps.*, COUNT(*) AS concurrent_instances');
		$this->db->from('app_sessions');
		$this->db->join('apps', 'app_sessions.app_id = apps.app_id');
		$this->db->where('apps.app_visible', 1);
		$this->db->group_by('app_sessions.app_id');
		$this->db->group_by('app_sessions.app_session_starter_id');
		$this->db->order_by('concurrent_instances', 'desc');
		$this->db->order_by('apps.app_friendly_name', 'asc');
		
		if ( $business_id ) {
			$this->db->where('apps.business_id', $business_id);
		}
		
		$this->_apply_date_query($this->db, $date);
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$top5_concurrent_apps = array();
			
			foreach ( $qry->result_array() as $row ) {
				$app_id = $row['app_id'];
				
				if ( !isset($top5_concurrent_apps[$app_id]) ) {
					$top5_concurrent_apps[$app_id] = $row;
				}
				
				if ( sizeof($top5_concurrent_apps) == 5 ) {
					break ;
				}
			}
			
			$data['top5_app_concurrent'] = $top5_concurrent_apps;
		}
		
		# Top application usage. (By instances)
		$this->db->select('apps.*, COUNT(*) AS instances');
		$this->db->from('app_sessions');
		$this->db->join('apps', 'app_sessions.app_id = apps.app_id');
		$this->db->group_by('app_sessions.app_id');
		$this->db->where('apps.app_visible', 1);
		$this->db->order_by('instances', 'desc');
		$this->db->limit(5);
		
		if ( $business_id ) {
			$this->db->where('apps.business_id', $business_id);
		}
		
		$this->_apply_date_query($this->db, $date);
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$data['top5_app_usage'] = array();
			
			foreach ( $qry->result_array() as $row ) {
				$app_name = $row['app_friendly_name'];
				$instances = intval($row['instances']);
				
				$data['top5_app_usage'][] = array($app_name, $instances);
			}
		}
		
		//print_r($data); exit();
		
		$this->template->set_css('!/css/daterangepicker.css');
		$this->template->set_js('!/js/moment.min.js');
		$this->template->set_js('!/js/daterangepicker.min.js');
		$this->template->set_js('//www.google.com/jsapi');
		$this->template->set_js('~/js/chart_initialization.js');
		$this->template->set_js('~/js/app_overview.js');
		$this->template->set_layout('default');
		$this->template->set_content('app_overview');
		$this->template->display($data);
	}
	
	/**
	 * This method will apply the date filter to the database query.
	 * It will return array if the date is a ranged value or string
	 * if the date is a particular date.
	 * 
	 * @param CI_DB_query_builder $db
	 * @param string $date
	 * @param string optional $field
	 * @return string|array
	 */
	protected function _apply_date_query($db, $date, $field = 'app_sessions.app_start')
	{
		$date_1 = '';
		$date_2 = '';
		
		switch ( $date ) {
			case 'this week':
				$t1 = strtotime('monday this week');
				$t2 = strtotime('sunday this week');
				$date_1 = date('Y-m-d', $t1);
				$date_2 = date('Y-m-d', $t2);
				$db->where('DATE(' . $field . ') BETWEEN "' . $date_1 . '" AND "' . $date_2 . '"');
				
				break ;
			case 'this month':
				$date_1 = date('Y-m-1');
				$date_2 = date('Y-m-t');
				$db->where('DATE(' . $field . ') BETWEEN "' . $date_1 . '" AND "' . $date_2 . '"');
				
				break ;
			case 'this year':
				$date_1 = date('Y-1-1');
				$date_2 = date('Y-12-31');
				$db->where('DATE(' . $field . ') BETWEEN "' . $date_1 . '" AND "' . $date_2 . '"');
				
				break ;
			case 'today':
			default:
				$date_1 = $date_2 = date('Y-m-d');
				$db->where('DATE(' . $field . ')', $date_1);
				
				break;
		}
		
		if ( $date_1 == $date_2 ) {
			return $date_1;
		} else {
			return array($date_1, $date_2);
		}
	}
	
	/**
	 * This method will load the application instances launched
	 * within the specified date.
	 * This method only accept date format without time.
	 * 
	 * @param string $start_date
	 * @param string optional $end_date
	 * @param int optional $business_id
	 * @return array
	 */
	protected function _app_usage_chart_data($start_date, $end_date = '', $business_id = 0)
	{
		$result = array(
			'data' => array(),
			'columns' => array(),
		);
		
		$step = '';
		$now = time();
		$today_date = date('Y-m-d');
		$today_hour = date('Y-m-d H');
		
		if ( $start_date == $end_date || is_empty($end_date) ) {
			$step = '+1 hour';
			$start_datetime = strtotime($start_date . ' 00:00:00');
			$end_datetime = strtotime($start_date . ' 23:59:59');
			$result['columns'] = array(
				array('string', lang('hour')),
				array('number', lang('instances')),
			);
		} else {
			$step = '+1 day';
			$start_datetime = strtotime($start_date);
			$end_datetime = strtotime($end_date);
			$result['columns'] = array(
				array('string', lang('date')),
				array('number', lang('instances')),
			);
		}
		
		$time = $start_datetime;
		
		while ( $time <= $end_datetime ) {
			$end_time = strtotime($step, $time);
			$null_compare = 0;
			
			if ( $end_time < $now || 
				($step == '+1 hour' && date('Y-m-d H', $time) == $today_hour) ||
				($step == '+1 day' && date('Y-m-d', $time) == $today_date ) ) {
				$null_compare = 1;
			}
			
			$db_date_start = date('Y-m-d H:i:s', $time);
			$db_date_end = date('Y-m-d H:i:s', $end_time);
			
			$this->db->select('COUNT(*) AS instances');
			$this->db->from('app_sessions');
			$this->db->where('(UNIX_TIMESTAMP(app_sessions.app_start) BETWEEN "' . $time . '" AND "' . $end_time . '" OR 
				UNIX_TIMESTAMP(app_sessions.app_end) BETWEEN "' . $time . '" AND "' . $end_time . '" OR
				(UNIX_TIMESTAMP(app_sessions.app_start) < "' . $end_time . '" AND app_sessions.app_end IS NULL AND 1 = ' . $null_compare . '))', null, false);
						
			if ( $business_id ) {
				$this->db->join('apps', 'app_sessions.app_id = apps.app_id');
				$this->db->where('apps.business_id', $business_id);
			}
			
			$qry = $this->db->get();
			$instances = 0;
			$label = '';
			
			if ( $step == '+1 day' ) {
				$label = date('j F, Y', $time);
			} else {
				$label = date('ga', $time);
			}
			
			if ( $qry->num_rows() ) {
				$row = $qry->row_array();
				$instances = intval($row['instances']);
			}
			
			$result['data'][] = array($label, $instances);
			
			// Increment.
			$time = $end_time;
		}
		
		//print_r($result); exit();
		return $result;
	}
}