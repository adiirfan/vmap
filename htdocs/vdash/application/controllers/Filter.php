<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filter extends EB_Controller {
	
	public function a_app_delete()
	{
		$app_filter_id = $this->input->get('id');
		$token = $this->input->get('token');
	
		$this->_validate_app_filter($app_filter_id);
	
		$output = array(
			'error' => 0,
			'message' => '',
		);
	
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('App_filter_model', 'app_filter_model');
				
			$this->app_filter_model->load(array(
				'app_filter_id' => $app_filter_id,
			));
				
			if ( $this->app_filter_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_filter_id_not_found');
			} else {
				$this->app_filter_model->delete();
			}
		}
	
		json_output($output);
	}
	
	public function a_app_evaluate()
	{
		$output = array(
			'error' => 0,
			'message' => '',
			'html' => '',
		);
		
		$business_id = $this->input->get('business_id');
		$token = $this->input->get('token');
		
		if ( !$this->system->verify_client_id($token) ) {
			$this->access_deny();
		}
		
		$this->_validate_business($business_id);
		
		$this->db->from('apps');
		$this->db->where('business_id', $business_id);
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$this->load->model('App_filter_model', 'app_filter_model');
			$html = '<ul class="filter-result">';
			
			foreach ( $qry->result_array() as $row ) {
				$app_id = $row['app_id'];
				$app_name = $row['app_sys_name'];
				$app_visible = $row['app_visible'];
				
				$result = $this->app_filter_model->filter_all($business_id, $app_name);
				
				if ( $result ) {
					$filter_action = array_ensure($result, 'app_filter_action', '');
					
					if ( ($filter_action == 'block' && $app_visible) || ($filter_action == 'allow' && !$app_visible) ) {
						$li_class = '';
						$icon = 'icon fa fa-';
						$status = '';
						
						if ( $app_visible ) {
							$li_class = 'text-danger';
							$icon .= 'minus-circle';
							$status = lang('filter_action_block');
						} else {
							$li_class = 'text-success';
							$icon .= 'check-square';
							$status = lang('filter_action_allow');
						}
						
						$html .= '<li class="' . $li_class . '">';
						$html .= '<i class="' . $icon . '"></i> ';
						$html .= '<span class="filter-name">' . htmlentities($app_name) . '</span>';
						$html .= '<span class="filter-status">' . $status . '</span>';
						$html .= '</li>';
					}
				}
			}
			
			$html .= '</ul>';
			
			$output['html'] = $html;
			
			// Generate a token.
			$new_token = md5(time() . 'process-filter');
			$output['token'] = $new_token;
			
			$this->session->set_userdata('_app_filter_token', $new_token);
		}
		
		json_output($output);
	}
	
	public function a_app_modify_pattern()
	{
		$app_filter_id = $this->input->get('id');
		$token = $this->input->get('token');
		$app_filter_pattern = $this->input->get('pattern');
		
		$this->_validate_app_filter($app_filter_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('App_filter_model', 'app_filter_model');
				
			$this->app_filter_model->load(array(
				'app_filter_id' => $app_filter_id,
			));
				
			if ( $this->app_filter_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_filter_id_not_found');
			} else {
				$this->app_filter_model->set_value('app_filter_sys_name', $app_filter_pattern);
				$this->app_filter_model->save();
			}
		}
		
		json_output($output);
	}
	
	public function a_app_new_filter()
	{
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		$post_data = $this->input->post();
		
		$token = array_ensure($post_data, 'token', '');
		$business_id = array_ensure($post_data, 'business_id', 0);
		$app_filter_name = array_ensure($post_data, 'filter_name', '');
		$app_filter_pattern = array_ensure($post_data, 'filter_pattern', '');
		$app_filter_negate = array_ensure($post_data, 'filter_negate', 0);
		$app_filter_action = array_ensure($post_data, 'filter_action', 'block');
		$app_filter_success = array_ensure($post_data, 'filter_success', 'stop');
		$app_filter_fail = array_ensure($post_data, 'filter_fail', 'stop');
		
		$this->_validate_business($business_id);
		
		if ( !$this->system->verify_client_id($token) ) {
			$this->access_deny();
		}
		
		$this->load->model('App_filter_model', 'app_filter_model');
		
		$this->app_filter_model->set_data(array(
			'business_id' => $business_id,
			'app_filter_name' => $app_filter_name,
			'app_filter_sys_name' => $app_filter_pattern,
			'app_filter_negate' => $app_filter_negate,
			'app_filter_action' => $app_filter_action,
			'app_filter_on_success' => $app_filter_success,
			'app_filter_on_fail' => $app_filter_fail,
		));
		
		$this->app_filter_model->save();
		
		$app_filter_id = $this->app_filter_model->get_value('app_filter_id');
		
		$output['app_filter_id'] = $app_filter_id;
		
		json_output($output);
	}
	
	public function a_app_process()
	{
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		$business_id = $this->input->get('business_id');
		// This token is the session generated token.
		$token = $this->input->get('token');
		
		$this->_validate_business($business_id);
		
		if ( $this->session->userdata('_app_filter_token') != $token ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			// Clear the session first.
			$this->session->unset_userdata('_app_filter_token');
			
			$this->db->from('apps');
			$this->db->where('business_id', $business_id);
			
			$qry = $this->db->get();
			
			if ( $qry->num_rows() ) {
				$this->load->model('App_filter_model', 'app_filter_model');
					
				foreach ( $qry->result_array() as $row ) {
					$app_id = $row['app_id'];
					$app_name = $row['app_sys_name'];
					$app_visible = $row['app_visible'];
				
					$result = $this->app_filter_model->filter_all($business_id, $app_name);
				
					if ( $result ) {
						$filter_action = array_ensure($result, 'app_filter_action', '');
							
						if ( ($filter_action == 'block' && $app_visible) || ($filter_action == 'allow' && !$app_visible) ) {
							$new_app_visible = ($app_visible ? 0 : 1);
							
							// Update it.
							$this->db->update('apps', array(
								'app_visible' => $new_app_visible,
							), array(
								'app_id' => $app_id,
							));
						}
					}
				}
			}
		}
		
		json_output($output);
	}
	
	public function a_app_rename()
	{
		$app_filter_id = $this->input->get('id');
		$token = $this->input->get('token');
		$app_filter_name = $this->input->get('name');
		
		$this->_validate_app_filter($app_filter_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('App_filter_model', 'app_filter_model');
			
			$this->app_filter_model->load(array(
				'app_filter_id' => $app_filter_id,
			));
			
			if ( $this->app_filter_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_filter_id_not_found');
			} else {
				$this->app_filter_model->set_value('app_filter_name', $app_filter_name);
				$this->app_filter_model->save();
			}
		}
		
		json_output($output);
	}
	
	public function a_app_reorder()
	{
		$business_id = $this->input->get('business');
		$token = $this->input->get('token');
		
		if ( !$this->system->verify_client_id($token) ) {
			$this->access_deny();
		}
		
		$this->_validate_business($business_id);
		
		$filter_ids = $this->input->get('filter_ids');
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !iterable($filter_ids) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_filter_id');
		} else {
			$filter_ids = array_values($filter_ids);
			
			foreach ( $filter_ids as $index => $filter_id ) {
				$this->db->update('app_filters', array(
					'app_filter_order' => $index,
				), array(
					'app_filter_id' => $filter_id,
					'business_id' => $business_id,
				));
			}
		}
		
		json_output($output);
	}
	
	public function a_app_set_action()
	{
		$app_filter_id = $this->input->get('id');
		$token = $this->input->get('token');
		$action = $this->input->get('action');
		
		$this->_validate_app_filter($app_filter_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('App_filter_model', 'app_filter_model');
				
			$this->app_filter_model->load(array(
				'app_filter_id' => $app_filter_id,
			));
				
			if ( $this->app_filter_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_filter_id_not_found');
			} else {
				$this->app_filter_model->set_value('app_filter_action', ($action == 'allow' ? 'allow' : 'block'));
				$this->app_filter_model->save();
			}
		}
		
		json_output($output);
	}
	
	public function a_app_set_fail()
	{
		$app_filter_id = $this->input->get('id');
		$token = $this->input->get('token');
		$action = $this->input->get('action');
		
		$this->_validate_app_filter($app_filter_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('App_filter_model', 'app_filter_model');
				
			$this->app_filter_model->load(array(
				'app_filter_id' => $app_filter_id,
			));
				
			if ( $this->app_filter_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_filter_id_not_found');
			} else {
				$this->app_filter_model->set_value('app_filter_on_fail', ($action == 'pass' ? 'pass' : 'stop'));
				$this->app_filter_model->save();
			}
		}
		
		json_output($output);
	}
	
	public function a_app_set_negate()
	{
		$app_filter_id = $this->input->get('id');
		$token = $this->input->get('token');
		$negate = $this->input->get('negate');
		
		$this->_validate_app_filter($app_filter_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('App_filter_model', 'app_filter_model');
				
			$this->app_filter_model->load(array(
				'app_filter_id' => $app_filter_id,
			));
				
			if ( $this->app_filter_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_filter_id_not_found');
			} else {
				$this->app_filter_model->set_value('app_filter_negate', ($negate ? 1 : 0));
				$this->app_filter_model->save();
			}
		}
		
		json_output($output);
	}
	
	public function a_app_set_success()
	{
		$app_filter_id = $this->input->get('id');
		$token = $this->input->get('token');
		$action = $this->input->get('action');
		
		$this->_validate_app_filter($app_filter_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('App_filter_model', 'app_filter_model');
				
			$this->app_filter_model->load(array(
				'app_filter_id' => $app_filter_id,
			));
				
			if ( $this->app_filter_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_filter_id_not_found');
			} else {
				$this->app_filter_model->set_value('app_filter_on_success', ($action == 'pass' ? 'pass' : 'stop'));
				$this->app_filter_model->save();
			}
		}
		
		json_output($output);
	}
	
	public function a_app_simulate()
	{
		$token = $this->input->get('token');
		$business_id = $this->input->get('business');
		$app_name = $this->input->get('app_name');
		
		$this->_validate_business($business_id);
		
		if ( !$this->system->verify_client_id($token) ) {
			$this->access_deny();
		}
		
		$output = array(
			'error' => 0,
			'message' => '',
			'html' => '',
		);
		
		$this->load->model('App_filter_model', 'app_filter_model');
		
		$result = array();
		$html = '';
		
		$this->app_filter_model->filter_all($business_id, $app_name, $result);
		
		if ( iterable($result) ) {
			$last_not_match = false;
			
			$html = '<ul class="filter-result">';
			
			foreach ( $result as $filter_row ) {
				$filter_name = array_ensure($filter_row, 'app_filter_name', '');
				$filter_action = array_ensure($filter_row, 'app_filter_action', '');
				$matched = array_ensure($filter_row, 'matched', true);
				$list_class = '';
				$icon_class = '';
				$action_class = 'filter-action label label-';
				$status_label = '';
				
				if ( $matched ) {
					$list_class = 'text-success';
					$icon_class = 'fa fa-check-square icon';
					$status_label = lang('filter_matched');
				} else {
					if ( $last_not_match ) {
						$list_class = 'text-skipped';
						$icon_class = 'fa fa-minus-square icon';
						$status_label = lang('filter_skipped');
					} else {
						$list_class = 'text-danger';
						$icon_class = 'fa fa-times-circle icon';
						$status_label = lang('filter_not_matched');
					}
					
					$last_not_match = $filter_row;
				}
				
				if ( $filter_action == 'allow' ) {
					$action_class .= 'success';
				} else if ( $filter_action == 'block' ) {
					$action_class .= 'danger';
				}
				
				if ( !$matched ) {
					$action_class = 'filter-action label label-default';
				}
				
				$html .= '<li class="' . $list_class . '">';
				$html .= '<i class="' . $icon_class . '"></i> ';
				$html .= '<span class="filter-name">' . $filter_name . '</span> ';
				$html .= '<span class="' . $action_class . '">' . ($matched ? lang('filter_action_' . $filter_action) : 'n/a') . '</span>';
				$html .= '<span class="filter-status">' . $status_label . '</span>';
				$html .= '</li>';
			}
			
			$html .= '</ul>';
			
			$output['html'] = $html;
		}
		
		json_output($output);
	}
	
	public function a_app_test()
	{
		$app_filter_id = $this->input->get('id');
		$token = $this->input->get('token');
		$test_app_name = $this->input->get('name');
		
		$this->_validate_app_filter($app_filter_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('App_filter_model', 'app_filter_model');
			
			$this->app_filter_model->load(array(
				'app_filter_id' => $app_filter_id,
			));
			
			if ( $this->app_filter_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_filter_id_not_found');
			} else {
				$app_data = array(
					'app_sys_name' => $test_app_name,
				);
				
				if ( $this->app_filter_model->filter($app_data) ) {
					$output['matched'] = true;
				} else {
					$output['matched'] = false;
				}
			}
		}
		
		json_output($output);
	}
	
	public function a_machine_change_name()
	{
		$filter_id = $this->input->get('filter_id');
		$token = $this->input->get('token');
		$filter_name = $this->input->get('name');
		
		$this->_validate_machine_filter($filter_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('Machine_filter_model', 'machine_filter_model');
		
			$this->machine_filter_model->load(array(
				'machine_filter_id' => $filter_id,
			));
		
			if ( $this->machine_filter_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_filter_id_not_found');
			} else {
				$this->machine_filter_model->set_value('machine_filter_name', $filter_name);
				$this->machine_filter_model->save();
			}
		}
		
		json_output($output);
	}
	
	public function a_machine_delete()
	{
		$filter_id = $this->input->get('filter_id');
		$token = $this->input->get('token');
		
		$this->_validate_machine_filter($filter_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('Machine_filter_model', 'machine_filter_model');
		
			$this->machine_filter_model->load(array(
				'machine_filter_id' => $filter_id,
			));
		
			if ( $this->machine_filter_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_filter_id_not_found');
			} else {
				$this->machine_filter_model->delete();
			}
		}
		
		json_output($output);
	}
	
	public function a_machine_evaluate()
	{
		$output = array(
			'error' => 0,
			'message' => '',
			'html' => '',
		);
		
		$business_id = $this->input->get('business_id');
		$token = $this->input->get('token');
		
		if ( !$this->system->verify_client_id($token) ) {
			$this->access_deny();
		}
		
		$this->_validate_business($business_id);
		
		$this->db->from('machines');
		$this->db->where('business_id', $business_id);
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$this->load->model('Machine_filter_model', 'machine_filter_model');
			$html = '<ul class="filter-result">';
			
			foreach ( $qry->result_array() as $machine_data ) {
				$machine_name = $machine_data['machine_name'];
				$machine_ip_address = $machine_data['machine_ip_address'];
				$machine_mac_address = $machine_data['machine_mac_address'];
				$result = $this->machine_filter_model->filter_all($business_id, $machine_data);
				
				if ( $result ) {
					$action_allow_block = '';
					$action_move_group = '';
					
					foreach ( $result as $machine_filter_data ) {
						$filter_action = array_ensure($machine_filter_data, 'machine_filter_action', '');
						$new_machine_group_id = array_ensure($machine_filter_data, 'machine_filter_group_assigned', 0);
						
						if ( $filter_action == 'allow' || $filter_action == 'block' ) {
							$action_allow_block = $filter_action;
						} else {
							$action_move_group = $new_machine_group_id;
							if ( $new_machine_group_id != $machine_data['machine_group_id'] ) {
								
							}
						}
					}
					
					if ( !is_empty($action_allow_block) && (($action_allow_block == 'allow' && $machine_data['machine_visible']) || ($action_allow_block == 'block' && !$machine_data['machine_visible'])) ) {
						$action_allow_block = '';
					}
					
					if ( $action_move_group > 0 && $action_move_group == $machine_data['machine_group_id'] ) {
						$action_move_group = '';
					}
					
					if ( is_empty($action_allow_block) && is_empty($action_move_group) ) {
						continue ;
					}
					
					$html .= '<li>';
					$html .= '<i class="fa fa-desktop"></i> <span class="filter-name">' . $machine_name . '</span> (' . $machine_ip_address . ')';
					
					if ( !is_empty($action_allow_block) ) {
						$label_class = 'label label-' . ($action_allow_block == 'allow' ? 'success' : 'danger');
						$html .= '<span class="filter-status ' . $label_class . '">' . lang('filter_action_' . $action_allow_block) . '</span>';
					}
					
					if ( $action_move_group > 0 ) {
						$machine_group_name = '';
						
						$sub_qry = $this->db->get_where('machine_groups', array(
							'machine_group_id' => $action_move_group,
						));
						
						if ( $sub_qry->num_rows() ) {
							$sub_row = $sub_qry->row_array();
							
							$machine_group_name = $sub_row['machine_group_name'];
						}
						
						$html .= '<span class="filter-status label label-warning">' . _lang('_filter_action_group', $machine_group_name) . '</span>';
					}
					
					$html .= '</li>';
				}
			}
			
			$html .= '</ul>';
			
			$output['html'] = $html;
			
			// Generate a token.
			$new_token = md5(time() . 'process-filter');
			$output['token'] = $new_token;
			
			$this->session->set_userdata('_machine_filter_token', $new_token);
		}
		
		json_output($output);
	}
	
	public function a_machine_modify_pattern()
	{
		$filter_id = $this->input->get('filter_id');
		$token = $this->input->get('token');
		$filter_pattern = $this->input->get('pattern');
		$column_name = $this->input->get('column_name');
		
		$this->_validate_machine_filter($filter_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('Machine_filter_model', 'machine_filter_model');
				
			$this->machine_filter_model->load(array(
				'machine_filter_id' => $filter_id,
			));
				
			if ( $this->machine_filter_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_filter_id_not_found');
			} else {
				$filter_column_maps = array(
					'machine_name' => 'machine_filter_pc_name',
					'ip_address' => 'machine_filter_ip_address',
					'mac_address' => 'machine_filter_mac_address',
				);
				
				$db_column = array_ensure($filter_column_maps, $column_name, '');
				
				if ( is_empty($db_column) ) {
					$output['error'] = 1;
					$output['message'] = lang('error_invalid_column_name');
				} else {
					if ( is_empty($filter_pattern) ) {
						$filter_pattern = null;
					}
					
					$this->machine_filter_model->set_value($db_column, $filter_pattern);
					$this->machine_filter_model->save();
				}
			}
		}
		
		json_output($output);
	}
	
	public function a_machine_new_filter()
	{
		$filter_id = $this->input->post('filter_id');
		$token = $this->input->post('token');
		$business_id = $this->input->post('business_id');
		$filter_action = $this->input->post('filter_action');
		$filter_name = $this->input->post('filter_name');
		$filter_machine_name = $this->input->post('filter_machine_name');
		$filter_ip_address = $this->input->post('filter_machine_ip_address');
		$filter_mac_address = $this->input->post('filter_machine_mac_address');
		$filter_machine_group_id = $this->input->post('filter_assigned_group');
		$filter_negate = $this->input->post('filter_negate');
		$filter_on_success = $this->input->post('filter_success');
		$filter_on_fail = $this->input->post('filter_fail');
		
		$this->_validate_business($business_id);
		$this->_validate_machine_filter($filter_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else if ( is_empty($filter_name) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_filter_invalid_parameter');
		} else {
			$this->load->model('Machine_filter_model', 'machine_filter_model');
			
			$machine_filter_data = array(
				'business_id' => $business_id,
				'machine_filter_name' => $filter_name,
				'machine_filter_mac_address' => string_ensure($filter_mac_address, null),
				'machine_filter_pc_name' => string_ensure($filter_machine_name, null),
				'machine_filter_ip_address' => string_ensure($filter_ip_address, null),
				'machine_filter_action' => $filter_action,
				'machine_filter_negate' => ($filter_negate ? 1 : 0),
				'machine_filter_group_assigned' => ($filter_action == 'group' ? intval($filter_machine_group_id) : null),
				'machine_filter_on_success' => ($filter_on_success ? 'pass' : 'stop'),
				'machine_filter_on_fail' => ($filter_on_fail ? 'pass' : 'stop'),
			);
			
			$this->machine_filter_model->set_data($machine_filter_data);
			$this->machine_filter_model->save();
		}
		
		json_output($output);
	}
	
	public function a_machine_process()
	{
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		$business_id = $this->input->get('business_id');
		// This token is the session generated token.
		$token = $this->input->get('token');
		
		$this->_validate_business($business_id);
		
		if ( $this->session->userdata('_machine_filter_token') != $token ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			// Clear the session first.
			$this->session->unset_userdata('_machine_filter_token');
			
			$this->db->from('machines');
			$this->db->where('business_id', $business_id);
			
			$qry = $this->db->get();
			
			if ( $qry->num_rows() ) {
				$this->load->model('Machine_filter_model', 'machine_filter_model');
					
				foreach ( $qry->result_array() as $machine_data ) {
					$machine_id = $machine_data['machine_id'];
					$result = $this->machine_filter_model->filter_all($business_id, $machine_data);
				
					if ( iterable($result) ) {
						$toggle_status = '';
						$machine_group_id = 0; // only if available.
						$machine_update_data = array();
						
						foreach ( $result as $machine_filter_data ) {
							$filter_action = $machine_filter_data['machine_filter_action'];
							
							if ( $filter_action == 'allow' || $filter_action == 'block' ) {
								$toggle_status = $filter_action;
							} else {
								$machine_group_id = $machine_filter_data['machine_filter_group_assigned'];
							}
						}
						
						if ( $toggle_status == 'allow' && !$machine_data['machine_visible'] ) {
							$machine_update_data['machine_visible'] = 1;
						} else if ( $toggle_status == 'block' && $machine_data['machine_visible' ] ) {
							$machine_update_data['machine_visible'] = 0;
						}
						
						if ( $machine_group_id > 0 && $machine_data['machine_group_id'] != $machine_group_id ) {
							$machine_update_data['machine_group_id'] = $machine_group_id;
						}
						
						if ( iterable($machine_update_data) ) {
							$this->db->update('machines', $machine_update_data, array(
								'machine_id' => $machine_id,
							));
						}
					}
				}
			}
		}
		
		json_output($output);
	}
	
	public function a_machine_reorder()
	{
		$business_id = $this->input->get('business');
		$token = $this->input->get('token');
		
		if ( !$this->system->verify_client_id($token) ) {
			$this->access_deny();
		}
		
		$this->_validate_business($business_id);
		
		$filter_ids = $this->input->get('filter_ids');
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !iterable($filter_ids) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_filter_id');
		} else {
			$filter_ids = array_values($filter_ids);
			
			foreach ( $filter_ids as $index => $filter_id ) {
				$this->db->update('machine_filters', array(
					'machine_filter_order' => $index,
				), array(
					'machine_filter_id' => $filter_id,
					'business_id' => $business_id,
				));
			}
		}
		
		json_output($output);
	}
	
	public function a_machine_set_action()
	{
		$filter_id = $this->input->get('filter_id');
		$token = $this->input->get('token');
		$action = $this->input->get('action');
		$machine_group_id = $this->input->get('machine_group_id');
		
		$this->_validate_machine_filter($filter_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('Machine_filter_model', 'machine_filter_model');
		
			$this->machine_filter_model->load(array(
				'machine_filter_id' => $filter_id,
			));
		
			if ( $this->machine_filter_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_filter_id_not_found');
			} else {
				if ( $action == 'allow' || $action == 'block' ) {
					$this->machine_filter_model->set_value('machine_filter_action', $action);
					$this->machine_filter_model->set_value('machine_filter_group_assigned', null);
					$this->machine_filter_model->save();
				} else if ( $action == 'group' && $machine_group_id > 0 ) {
					// Verify this machine group is belongs to the admin user.
					$sys_user_model = $this->authentication->get_model();
					$sys_user_type = $sys_user_model->get_value('sys_user_type');
					
					if ( $sys_user_type != 'superadmin' ) {
						$sys_user_business_id = $sys_user_model->get_value('business_id');
						
						$this->db->from('machine_groups');
						$this->db->where(array(
							'machine_group_id' => $machine_group_id,
							'business_id' => $sys_user_business_id,
						));
						$qry = $this->db->get();
						
						if ( !$qry->num_rows() ) {
							$output['error'] = 1;
							$output['message'] = '';
						}
					}
					
					if ( !$output['error'] ) {
						$this->machine_filter_model->set_value('machine_filter_action', 'group');
						$this->machine_filter_model->set_value('machine_filter_group_assigned', $machine_group_id);
						$this->machine_filter_model->save();
					}
				}
			}
		}
		
		json_output($output);
	}
	
	public function a_machine_set_option()
	{
		$filter_id = $this->input->get('filter_id');
		$token = $this->input->get('token');
		$option_value = $this->input->get('value');
		$option_name = $this->input->get('option');
		
		$this->_validate_machine_filter($filter_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('Machine_filter_model', 'machine_filter_model');
		
			$this->machine_filter_model->load(array(
					'machine_filter_id' => $filter_id,
			));
		
			if ( $this->machine_filter_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_filter_id_not_found');
			} else {
				$filter_option_maps = array(
					'negate' => 'machine_filter_negate',
					// 'action' => 'machine_filter_action',
					'on_success' => 'machine_filter_on_success',
					'on_fail' => 'machine_filter_on_fail',
				);
		
				$db_column = array_ensure($filter_option_maps, $option_name, '');
				
				if ( is_empty($db_column) ) {
					$output['error'] = 1;
					$output['message'] = lang('error_invalid_option_name');
				} else {
					$db_value = '';
					
					switch ( $option_name ) {
						case 'negate':
							$db_value = ($option_value ? 1 : 0);
							break;
						case 'on_success':
						case 'on_fail':
							$db_value = ($option_value ? 'pass' : 'stop');
							break;
					}
					
					if ( $db_value !== '' ) {
						$this->machine_filter_model->set_value($db_column, $db_value);
						$this->machine_filter_model->save();
					}
				}
			}
		}
		
		json_output($output);
	}
	
	public function a_machine_simulate()
	{
		$token = $this->input->get('token');
		$business_id = $this->input->get('business_id');
		$machine_name = $this->input->get('machine_name');
		$ip_address = $this->input->get('ip_address');
		$mac_address = $this->input->get('mac_address');
		
		$this->_validate_business($business_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
			'html' => false,
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('Machine_filter_model', 'machine_filter_model');
		
			$machine_data = array(
				'machine_mac_address' => $mac_address,
				'machine_ip_address' => $ip_address,
				'machine_name' => $machine_name,
			);
			
			$result = array();
			
			$this->machine_filter_model->filter_all($business_id, $machine_data, $result);
			
			if ( iterable($result) ) {
				$html = '<ul class="filter-result">';
				$skip = false;
				
				foreach ( $result as $filter_row ) {
					$filter_name = array_ensure($filter_row, 'machine_filter_name', '');
					$filter_action = array_ensure($filter_row, 'machine_filter_action', '');
					$filter_success = $filter_row['machine_filter_on_success'];
					$filter_fail = $filter_row['machine_filter_on_fail'];
					$machine_group_id = $filter_row['machine_filter_group_assigned'];
					$matched = array_ensure($filter_row, 'matched', true);
					$list_class = '';
					$icon_class = '';
					$action_class = 'filter-action label label-';
					$action_label = 'n/a';
					$status_label = '';
					
					if ( $skip ) {
						$list_class = 'text-skipped';
						$icon_class = 'fa fa-minus-square icon';
						$status_label = lang('filter_skipped');
						$action_class .= 'default';
					} else {
						if ( $matched ) {
							$list_class = 'text-success';
							$icon_class = 'fa fa-check-square icon';
							$status_label = lang('filter_matched');
							
							if ( $filter_action == 'allow' ) {
								$action_label = lang('filter_action_allow');
								$action_class .= 'success';
							} else if ( $filter_action == 'block' ) {
								$action_label = lang('filter_action_block');
								$action_class .= 'danger';
							} else {
								// Find the machine group name.
								$machine_group_name = '';
								$sub_qry = $this->db->get_where('machine_groups', array(
									'machine_group_id' => $machine_group_id,
								));
								
								if ( $sub_qry->num_rows() ) {
									$sub_row = $sub_qry->row_array();
									
									$machine_group_name = $sub_row['machine_group_name'];
								}
								
								$action_label = _lang('_filter_action_group', $machine_group_name);
								$action_class .= 'warning';
							}
						} else {
							$list_class = 'text-danger';
							$icon_class = 'fa fa-times-circle icon';
							$status_label = lang('filter_not_matched');
							$action_class .= 'default';
						}
					}
					
					if ( ($matched && $filter_success == 'stop') ||
						 (!$matched && $filter_fail == 'stop') ) {
						$skip = true;
					}
					
					$html .= '<li class="' . $list_class . '">';
					$html .= '<i class="' . $icon_class . '"></i> ';
					$html .= '<span class="filter-name">' . $filter_name . '</span> ';
					$html .= '<span class="' . $action_class . '">' . $action_label . '</span>';
					$html .= '<span class="filter-status">' . $status_label . '</span>';
					$html .= '</li>';
				}
				
				$html .= '</ul>';
				
				$output['html'] = $html;
			}
		}
		
		json_output($output);
	}
	
	public function a_machine_test()
	{
		$filter_id = $this->input->get('filter_id');
		$token = $this->input->get('token');
		$machine_name = $this->input->get('machine_name');
		$ip_address = $this->input->get('ip_address');
		$mac_address = $this->input->get('mac_address');
		
		$this->_validate_machine_filter($filter_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
			'matched' => false,
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('Machine_filter_model', 'machine_filter_model');
		
			$this->machine_filter_model->load(array(
				'machine_filter_id' => $filter_id,
			));
		
			if ( $this->machine_filter_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_filter_id_not_found');
			} else {
				$matched = $this->machine_filter_model->filter(array(
					'machine_default_name' => $machine_name,
					'machine_ip_address' => $ip_address,
					'machine_mac_address' => $mac_address,
				));
				
				if ( false !== $matched ) {
					$output['matched'] = true;
				}
			}
		}
		
		json_output($output);
	}
	
	public function a_user_change_name()
	{
		$filter_id = $this->input->get('filter_id');
		$token = $this->input->get('token');
		$filter_name = $this->input->get('name');
		
		$this->_validate_user_filter($filter_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('User_filter_model', 'user_filter_model');
		
			$this->user_filter_model->load(array(
				'user_filter_id' => $filter_id,
			));
		
			if ( $this->user_filter_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_filter_id_not_found');
			} else {
				$this->user_filter_model->set_value('user_filter_name', $filter_name);
				$this->user_filter_model->save();
			}
		}
		
		json_output($output);
	}
	
	public function a_user_delete()
	{
		$filter_id = $this->input->get('filter_id');
		$token = $this->input->get('token');
		
		$this->_validate_user_filter($filter_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('User_filter_model', 'user_filter_model');
		
			$this->user_filter_model->load(array(
				'user_filter_id' => $filter_id,
			));
		
			if ( $this->user_filter_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_filter_id_not_found');
			} else {
				$this->user_filter_model->delete();
			}
		}
		
		json_output($output);
	}
	
	public function a_user_evaluate()
	{
		$output = array(
			'error' => 0,
			'message' => '',
			'html' => '',
		);
		
		$business_id = $this->input->get('business_id');
		$token = $this->input->get('token');
		
		if ( !$this->system->verify_client_id($token) ) {
			$this->access_deny();
		}
		
		$this->_validate_business($business_id);
		
		$this->db->from('users');
		$this->db->where('business_id', $business_id);
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$this->load->model('User_filter_model', 'user_filter_model');
			
			$html = '<ul class="filter-result">';
			
			foreach ( $qry->result_array() as $user_data ) {
				$user_name = $user_data['user_name'];
				$user_domain = $user_data['user_domain'];
				$user_ad_group = $user_data['user_ad_group'];
				$result = $this->user_filter_model->filter_all($business_id, $user_data);
				
				if ( $result ) {
					$action_allow_block = '';
					$action_move_group = '';
					
					foreach ( $result as $user_filter_data ) {
						$filter_action = array_ensure($user_filter_data, 'user_filter_action', '');
						//$new_machine_group_id = array_ensure($user_filter_data, 'user_filter_group_assigned', 0);
						
						if ( $filter_action == 'allow' || $filter_action == 'block' ) {
							$action_allow_block = $filter_action;
						}/* else {
							$action_move_group = $new_machine_group_id;
							if ( $new_machine_group_id != $machine_data['machine_group_id'] ) {
								
							}
						}*/
					}
					
					if ( !is_empty($action_allow_block) && (($action_allow_block == 'allow' && $user_data['user_visible']) || ($action_allow_block == 'block' && !$user_data['user_visible'])) ) {
						$action_allow_block = '';
					}
					
					/*if ( $action_move_group > 0 && $action_move_group == $user_data['machine_group_id'] ) {
						$action_move_group = '';
					}*/
					
					if ( is_empty($action_allow_block) && is_empty($action_move_group) ) {
						continue ;
					}
					
					$html .= '<li>';
					$html .= '<i class="fa fa-user"></i> <span class="filter-name">' . $user_name . '</span> (' . $user_domain . ')';
					
					if ( !is_empty($action_allow_block) ) {
						$label_class = 'label label-' . ($action_allow_block == 'allow' ? 'success' : 'danger');
						$html .= '<span class="filter-status ' . $label_class . '">' . lang('filter_action_' . $action_allow_block) . '</span>';
					}
					
					/*if ( $action_move_group > 0 ) {
						$machine_group_name = '';
						
						$sub_qry = $this->db->get_where('machine_groups', array(
							'machine_group_id' => $action_move_group,
						));
						
						if ( $sub_qry->num_rows() ) {
							$sub_row = $sub_qry->row_array();
							
							$machine_group_name = $sub_row['machine_group_name'];
						}
						
						$html .= '<span class="filter-status label label-warning">' . _lang('_filter_action_group', $machine_group_name) . '</span>';
					}*/
					
					$html .= '</li>';
				}
			}
			
			$html .= '</ul>';
			
			$output['html'] = $html;
			
			// Generate a token.
			$new_token = md5(time() . 'process-filter');
			$output['token'] = $new_token;
			
			$this->session->set_userdata('_user_filter_token', $new_token);
		}
		
		json_output($output);
	}
	
	public function a_user_modify_pattern()
	{
		$filter_id = $this->input->get('filter_id');
		$token = $this->input->get('token');
		$filter_pattern = $this->input->get('pattern');
		$column_name = $this->input->get('column_name');
		
		$this->_validate_user_filter($filter_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('User_filter_model', 'user_filter_model');
				
			$this->user_filter_model->load(array(
				'user_filter_id' => $filter_id,
			));
				
			if ( $this->user_filter_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_filter_id_not_found');
			} else {
				$filter_column_maps = array(
					'username' => 'user_filter_username',
					'domain' => 'user_filter_domain',
					'ad_group' => 'user_filter_ad_group',
				);
				
				$db_column = array_ensure($filter_column_maps, $column_name, '');
				
				if ( is_empty($db_column) ) {
					$output['error'] = 1;
					$output['message'] = lang('error_invalid_column_name');
				} else {
					if ( is_empty($filter_pattern) ) {
						$filter_pattern = null;
					}
					
					$this->user_filter_model->set_value($db_column, $filter_pattern);
					$this->user_filter_model->save();
				}
			}
		}
		
		json_output($output);
	}
	
	public function a_user_new_filter()
	{
		$token = $this->input->post('token');
		$business_id = $this->input->post('business_id');
		$filter_name = $this->input->post('filter_name');
		$filter_username = $this->input->post('filter_user_name');
		$filter_domain = $this->input->post('filter_user_domain');
		$filter_ad_group = $this->input->post('filter_user_ad_group');
		$filter_action = $this->input->post('filter_action');
		$filter_negate = $this->input->post('filter_negate');
		$filter_on_success = $this->input->post('filter_success');
		$filter_on_fail = $this->input->post('filter_fail');
		
		$this->_validate_business($business_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else if ( is_empty($filter_name) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_filter_invalid_parameter');
		} else {
			$this->load->model('User_filter_model', 'user_filter_model');
			
			$user_filter_data = array(
				'business_id' => $business_id,
				'user_filter_name' => $filter_name,
				'user_filter_username' => string_ensure($filter_username, null),
				'user_filter_domain' => string_ensure($filter_domain, null),
				'user_filter_ad_group' => string_ensure($filter_ad_group, null),
				'user_filter_action' => ($filter_action == 'allow' ? 'allow' : 'block'),
				'user_filter_negate' => ($filter_negate ? 1 : 0),
				// 'machine_filter_group_assigned' => ($filter_action == 'group' ? intval($filter_machine_group_id) : null),
				'user_filter_on_success' => ($filter_on_success ? 'pass' : 'stop'),
				'user_filter_on_fail' => ($filter_on_fail ? 'pass' : 'stop'),
			);
			
			$this->user_filter_model->set_data($user_filter_data);
			$this->user_filter_model->save();
		}
		
		json_output($output);
	}
	
	public function a_user_process()
	{
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		$business_id = $this->input->get('business_id');
		
		// This token is the session generated token.
		$token = $this->input->get('token');
		
		$this->_validate_business($business_id);
		
		if ( $this->session->userdata('_user_filter_token') != $token ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			// Clear the session first.
			$this->session->unset_userdata('_user_filter_token');
			
			$this->db->from('users');
			$this->db->where('business_id', $business_id);
			
			$qry = $this->db->get();
			
			if ( $qry->num_rows() ) {
				$this->load->model('User_filter_model', 'user_filter_model');
					
				foreach ( $qry->result_array() as $user_data ) {
					$user_id = $user_data['user_id'];
					$result = $this->user_filter_model->filter_all($business_id, $user_data);
				
					if ( iterable($result) ) {
						$toggle_status = '';
						// $machine_group_id = 0;
						$user_update_data = array();
						
						foreach ( $result as $user_filter_data ) {
							$filter_action = $user_filter_data['user_filter_action'];
							
							if ( $filter_action == 'allow' || $filter_action == 'block' ) {
								$toggle_status = $filter_action;
							}/* else {
								$machine_group_id = $machine_filter_data['machine_filter_group_assigned'];
							}*/
						}
						
						if ( $toggle_status == 'allow' && !$user_data['user_visible'] ) {
							$user_update_data['user_visible'] = 1;
						} else if ( $toggle_status == 'block' && $user_data['user_visible' ] ) {
							$user_update_data['user_visible'] = 0;
						}
						
						/*if ( $machine_group_id > 0 && $machine_data['machine_group_id'] != $machine_group_id ) {
							$machine_update_data['machine_group_id'] = $machine_group_id;
						}*/
						
						if ( iterable($user_update_data) ) {
							$this->db->update('users', $user_update_data, array(
								'user_id' => $user_id,
							));
						}
					}
				}
			}
		}
		
		json_output($output);
	}
	
	public function a_user_reorder()
	{
		$business_id = $this->input->get('business');
		$token = $this->input->get('token');
		
		if ( !$this->system->verify_client_id($token) ) {
			$this->access_deny();
		}
		
		$this->_validate_business($business_id);
		
		$filter_ids = $this->input->get('filter_ids');
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !iterable($filter_ids) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_filter_id');
		} else {
			$filter_ids = array_values($filter_ids);
			
			foreach ( $filter_ids as $index => $filter_id ) {
				$this->db->update('user_filters', array(
					'user_filter_order' => $index,
				), array(
					'user_filter_id' => $filter_id,
					'business_id' => $business_id,
				));
			}
		}
		
		json_output($output);
	}
	
	public function a_user_set_option()
	{
		$filter_id = $this->input->get('filter_id');
		$token = $this->input->get('token');
		$option_value = $this->input->get('value');
		$option_name = $this->input->get('option');
		
		$this->_validate_user_filter($filter_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('User_filter_model', 'user_filter_model');
		
			$this->user_filter_model->load(array(
				'user_filter_id' => $filter_id,
			));
		
			if ( $this->user_filter_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_filter_id_not_found');
			} else {
				$filter_option_maps = array(
					'negate' => 'user_filter_negate',
					'action' => 'user_filter_action',
					'on_success' => 'user_filter_on_success',
					'on_fail' => 'user_filter_on_fail',
				);
		
				$db_column = array_ensure($filter_option_maps, $option_name, '');
				
				if ( is_empty($db_column) ) {
					$output['error'] = 1;
					$output['message'] = lang('error_invalid_option_name');
				} else {
					$db_value = '';
					
					switch ( $option_name ) {
						case 'negate':
							$db_value = ($option_value ? 1 : 0);
							break;
						case 'action':
							$db_value = ($option_value ? 'allow' : 'block');
							break;
						case 'on_success':
						case 'on_fail':
							$db_value = ($option_value ? 'pass' : 'stop');
							break;
					}
					
					if ( $db_value !== '' ) {
						$this->user_filter_model->set_value($db_column, $db_value);
						$this->user_filter_model->save();
					}
				}
			}
		}
		
		json_output($output);
	}
	
	public function a_user_simulate()
	{
		$token = $this->input->get('token');
		$business_id = $this->input->get('business_id');
		$username = $this->input->get('user_name');
		$domain = $this->input->get('domain');
		$ad_group = $this->input->get('ad_group');
		
		$this->_validate_business($business_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
			'html' => false,
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('User_filter_model', 'user_filter_model');
		
			$machine_data = array(
				'user_name' => $username,
				'user_domain' => $domain,
				'user_ad_group' => $ad_group,
			);
			
			$result = array();
			
			$this->user_filter_model->filter_all($business_id, $machine_data, $result);
			
			if ( iterable($result) ) {
				$html = '<ul class="filter-result">';
				
				foreach ( $result as $filter_row ) {
					$filter_name = array_ensure($filter_row, 'user_filter_name', '');
					$filter_action = array_ensure($filter_row, 'user_filter_action', '');
					$filter_success = $filter_row['user_filter_on_success'];
					$filter_fail = $filter_row['user_filter_on_fail'];
					$matched = array_ensure($filter_row, 'matched', '');
					$list_class = '';
					$icon_class = '';
					$action_class = 'filter-action label label-';
					$action_label = 'n/a';
					$status_label = '';
					
					if ( $matched == 'matched' ) {
						if ( $filter_action == 'allow' ) {
							$action_class .= 'success';
						} else if ( $filter_action == 'block' ) {
							$action_class .= 'danger';
						}
						
						$action_label = lang('filter_action_' . $filter_action);
					} else {
						$action_class .= 'default';
					}
					
					if ( $matched == 'matched' ) {
						$list_class = 'text-success';
						$icon_class = 'fa fa-check-square icon';
						$status_label = lang('filter_matched');
					} else if ( $matched == 'not_matched') {
						$list_class = 'text-danger';
						$icon_class = 'fa fa-times-circle icon';
						$status_label = lang('filter_not_matched');
					} else if ( $matched == 'skipped' ) {
						$list_class = 'text-skipped';
						$icon_class = 'fa fa-minus-square icon';
						$status_label = lang('filter_skipped');
					}
					
					$html .= '<li class="' . $list_class . '">';
					$html .= '<i class="' . $icon_class . '"></i> ';
					$html .= '<span class="filter-name">' . $filter_name . '</span> ';
					$html .= '<span class="' . $action_class . '">' . $action_label . '</span>';
					$html .= '<span class="filter-status">' . $status_label . '</span>';
					$html .= '</li>';
				}
				
				$html .= '</ul>';
				
				$output['html'] = $html;
			}
		}
		
		json_output($output);
	}
	
	public function a_user_test()
	{
		$filter_id = $this->input->get('filter_id');
		$token = $this->input->get('token');
		$user_name = $this->input->get('username');
		$domain = $this->input->get('domain');
		$ad_group = $this->input->get('ad_group');
		
		$this->_validate_user_filter($filter_id);
		
		$output = array(
			'error' => 0,
			'message' => '',
			'matched' => false,
		);
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('User_filter_model', 'user_filter_model');
		
			$this->user_filter_model->load(array(
				'user_filter_id' => $filter_id,
			));
		
			if ( $this->user_filter_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_filter_id_not_found');
			} else {
				$matched = $this->user_filter_model->filter(array(
					'user_name' => $user_name,
					'user_domain' => $domain,
					'user_ad_group' => $ad_group,
				));
				
				if ( false !== $matched ) {
					$output['matched'] = true;
				}
			}
		}
		
		json_output($output);
	}
	
	public function app()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny(true, 'dashboard');
		}
		
		/*$this->load->model('App_filter_model', 'app_filter_model');
		$this->app_filter_model->load(array(
			'app_filter_id' => 1,
		));*/
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		$business_id = 0;
		$data = array();
		
		if ( $sys_user_type != 'superadmin' && $sys_user_type != 'admin' ) {
			$this->access_deny(true, 'dashboard');
		} else if ( $sys_user_type == 'admin' ) {
			$business_model = $sys_user_model->get_business_model();
			$business_id = $business_model->get_value('business_id');
		} else if ( $sys_user_type == 'superadmin' ) {
			$business_id = $this->input->get('business');
			
			if ( !$business_id ) {
				$business_id = 0;
			}
			
			// Load the business option list.
			$this->load->model('Business_model', 'business_model');
			
			$data['business_option_list'] = $this->business_model->get_option_list('business_id', 'business_name', array(
				'order_by' => array('business_name', 'asc'),
			));
			
			$data['business_option_list'] = array('- ' . lang('business_selection') . ' -') + $data['business_option_list'];
		}
		
		// Load the list of app filters.
		if ( $business_id ) {
			$this->db->from('app_filters');
			$this->db->where('business_id', $business_id);
			$this->db->order_by('app_filter_order', 'asc');
			
			$qry = $this->db->get();
			
			if ( $qry->num_rows() ) {
				$data['filters'] = $qry->result_array();
			}
			
			$data['business_id'] = $business_id;
		} else {
			$data['business_id'] = 0;
		}
		
		$this->template->set_page_title(lang('app_filters'));
		$this->template->set_css('!/js/jquery-ui-sortable/jquery-ui.min.css');
		$this->template->set_css('!/js/jquery-ui-sortable/jquery-ui.structure.min.css');
		$this->template->set_css('!/css/bootstrap-toggle.min.css');
		$this->template->set_js('!/js/jquery.slimscroll.min.js');
		$this->template->set_js('!/js/jquery-ui-sortable/jquery-ui.min.js');
		$this->template->set_js('!/js/bootstrap-toggle.min.js');
		$this->template->set_js('~/js/filter_app.js');
		$this->template->set_layout('default');
		$this->template->set_content('filter_apps');
		$this->template->display($data);
	}
	
	public function machine()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny(true, 'dashboard');
		}
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		$business_id = 0;
		$data = array();
		
		if ( $sys_user_type != 'superadmin' && $sys_user_type != 'admin' ) {
			$this->access_deny(true, 'dashboard');
		} else if ( $sys_user_type == 'admin' ) {
			$business_model = $sys_user_model->get_business_model();
			$business_id = $business_model->get_value('business_id');
		} else if ( $sys_user_type == 'superadmin' ) {
			$business_id = $this->input->get('business');
			
			if ( !$business_id ) {
				$business_id = 0;
			}
			
			// Load the business option list.
			$this->load->model('Business_model', 'business_model');
			
			$data['business_option_list'] = $this->business_model->get_option_list('business_id', 'business_name', array(
				'order_by' => array('business_name', 'asc'),
			));
			
			$data['business_option_list'] = array('- ' . lang('business_selection') . ' -') + $data['business_option_list'];
		}
		
		if ( $business_id ) {
			$this->db->from('machine_filters');
			$this->db->where('business_id', $business_id);
			$this->db->order_by('machine_filter_order', 'asc');
			
			$qry = $this->db->get();
			
			if ( $qry->num_rows() ) {
				$data['filters'] = $qry->result_array();
			}
			
			$data['business_id'] = $business_id;
			
			// Load machine group option list.
			$this->load->model('Machine_group_model', 'machine_group_model');
			$machine_group_option_list = $this->machine_group_model->get_option_list('machine_group_id', 'machine_group_name', array(
				'where' => array('business_id', $business_id),
				'order_by' => array('machine_group_name', 'asc'),
			));
			
			if ( iterable($machine_group_option_list) ) {
				$data['machine_group_option_list'] = $machine_group_option_list;
			}
		} else {
			$data['business_id'] = 0;
		}
		
		$this->template->set_page_title(lang('machine_filters'));
		$this->template->set_css('!/js/jquery-ui-sortable/jquery-ui.min.css');
		$this->template->set_css('!/js/jquery-ui-sortable/jquery-ui.structure.min.css');
		$this->template->set_css('!/css/bootstrap-toggle.min.css');
		$this->template->set_js('!/js/jquery.slimscroll.min.js');
		$this->template->set_js('!/js/jquery-ui-sortable/jquery-ui.min.js');
		$this->template->set_js('!/js/bootstrap-toggle.min.js');
		$this->template->set_js('~/js/filter_machine.js');
		$this->template->set_layout('default');
		$this->template->set_content('filter_machines');
		$this->template->display($data);
	}
	
	public function user()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny(true, 'dashboard');
		}
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		$business_id = 0;
		$data = array();
		
		if ( $sys_user_type != 'superadmin' && $sys_user_type != 'admin' ) {
			$this->access_deny(true, 'dashboard');
		} else if ( $sys_user_type == 'admin' ) {
			$business_model = $sys_user_model->get_business_model();
			$business_id = $business_model->get_value('business_id');
		} else if ( $sys_user_type == 'superadmin' ) {
			$business_id = $this->input->get('business');
			
			if ( !$business_id ) {
				$business_id = 0;
			}
			
			// Load the business option list.
			$this->load->model('Business_model', 'business_model');
			
			$data['business_option_list'] = $this->business_model->get_option_list('business_id', 'business_name', array(
				'order_by' => array('business_name', 'asc'),
			));
			
			$data['business_option_list'] = array('- ' . lang('business_selection') . ' -') + $data['business_option_list'];
		}
		
		if ( $business_id ) {
			$this->db->from('user_filters');
			$this->db->where('business_id', $business_id);
			$this->db->order_by('user_filter_order', 'asc');
			
			$qry = $this->db->get();
			
			if ( $qry->num_rows() ) {
				$data['filters'] = $qry->result_array();
			}
			
			$data['business_id'] = $business_id;
		} else {
			$data['business_id'] = 0;
		}
		
		$this->template->set_page_title(lang('user_filters'));
		$this->template->set_css('!/js/jquery-ui-sortable/jquery-ui.min.css');
		$this->template->set_css('!/js/jquery-ui-sortable/jquery-ui.structure.min.css');
		$this->template->set_css('!/css/bootstrap-toggle.min.css');
		$this->template->set_js('!/js/jquery.slimscroll.min.js');
		$this->template->set_js('!/js/jquery-ui-sortable/jquery-ui.min.js');
		$this->template->set_js('!/js/bootstrap-toggle.min.js');
		$this->template->set_js('~/js/filter_user.js');
		$this->template->set_layout('default');
		$this->template->set_content('filter_users');
		$this->template->display($data);
	}
	
	protected function _validate_app_filter($filter_id)
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny();
		}
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		
		if ( $sys_user_type != 'superadmin' ) {
			$business_model = $sys_user_model->get_business_model();
			$business_id = $business_model->get_value('business_id');
			
			$qry = $this->db->get_where('app_filters', array(
				'app_filter_id' => $filter_id,
				'business_id' => $business_id,
			));
			
			if ( !$qry->num_rows() ) {
				$this->access_deny();
			}
		}
	}
	
	protected function _validate_machine_filter($filter_id)
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny();
		}
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		
		if ( $sys_user_type != 'superadmin' ) {
			$business_model = $sys_user_model->get_business_model();
			$business_id = $business_model->get_value('business_id');
			
			$qry = $this->db->get_where('machine_filters', array(
				'machine_filter_id' => $filter_id,
				'business_id' => $business_id,
			));
			
			if ( !$qry->num_rows() ) {
				$this->access_deny();
			}
		}
	}
	
	protected function _validate_user_filter($filter_id)
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny();
		}
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		
		if ( $sys_user_type != 'superadmin' ) {
			$business_model = $sys_user_model->get_business_model();
			$business_id = $business_model->get_value('business_id');
			
			$qry = $this->db->get_where('user_filters', array(
				'user_filter_id' => $filter_id,
				'business_id' => $business_id,
			));
			
			if ( !$qry->num_rows() ) {
				$this->access_deny();
			}
		}
	}
	
	protected function _validate_business($bid)
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny();
		}
		
		$sys_user_model = $this->authentication->get_model();
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		
		if ( $sys_user_type != 'superadmin' ) {
			$business_model = $sys_user_model->get_business_model();
			$business_id = $business_model->get_value('business_id');
			
			if ( $business_id != $bid ) {
				$this->access_deny();
			}
		}
	}
}