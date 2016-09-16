<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends EB_Controller {
	public function init()
	{
		$this->load->model('Machine_model', 'machine_model');
		$this->load->model('User_model', 'user_model');
		$this->load->model('App_model', 'app_model');
		
		log_message('debug', print_r($this->input->get(), true));
	}
	
	public function test()
	{
		$time = time();
		$code = 'QObYXz';
		$hashed = md5($code . $time);
		
		$uri = 'code=' . urlencode($code) . '&timestamp=' . $time . '&hash=' . urlencode($hashed);
		
		echo htmlentities($uri);
	}
	
	public function app_close()
	{
		$output = array(
			'success' => true,
			'reason' => '',
			'error_code' => 0,
		);
		
		if ( false !== ($business_data = $this->_validate_code($output['error_code'], $output['reason'])) ) {
			$business_id = $business_data['business_id'];
			$user_session_id = $this->input->get('user_session_id');
			$app_id = $this->input->get('app_id');
			$timestamp = $this->input->get('timestamp');
				
			if ( is_empty($user_session_id) ) {
				$output['success'] = false;
				$output['error_code'] = 301;
				$output['reason'] = lang('error_api_301');
			} else if ( is_empty($app_id) ) {
				$output['success'] = false;
				$output['error_code'] = 102;
				$output['reason'] = lang('error_api_102');
			} else {
				// Check user session exists.
				$this->db->from('user_sessions');
				$this->db->where(array(
					'user_session_id' => $user_session_id,
					'user_session_status' => 'online',
				));
				
				$qry = $this->db->get();
				
				if ( $qry->num_rows() ) {
					// Check if the application exists.
					$this->db->from('app_sessions');
					$this->db->where(array(
						'user_session_id' => $user_session_id,
						'app_local_system_id' => $app_id,
					));
					
					$qry = $this->db->get();
					
					if ( !$qry->num_rows() ) {
						// The application has not started.
						$output['success'] = false;
						$output['error_code'] = 402;
						$output['reason'] = lang('error_api_402');
					} else {
						$app_session_data = $qry->row_array();
						
						if ( !is_empty($app_session_data['app_end']) ) {
							// The session already killed.
							$output['success'] = false;
							$output['error_code'] = 403;
							$output['reason'] = lang('error_api_403');
						} else {
							$this->app_model->close(array(
								'app_local_system_id' => $app_id,
								'user_session_id' => $user_session_id,
								'app_end' => db_date($timestamp),
							));
						}
					}
				} else {
					$output['success'] = false;
					$output['error_code'] = 301;
					$output['reason'] = lang('error_api_301');
				}
			}
		} else {
			$output['success'] = false;
		}
		
		json_output($output);
	}
	
	public function app_start()
	{
		$output = array(
			'success' => true,
			'reason' => '',
			'app_session_id' => null,
			'error_code' => 0,
		);
		
		if ( false !== ($business_data = $this->_validate_code($output['error_code'], $output['reason'])) ) {
			$business_id = $business_data['business_id'];
			$user_session_id = $this->input->get('user_session_id');
			$app_name = $this->input->get('app_name');
			$app_id = $this->input->get('app_id');
			$timestamp = $this->input->get('timestamp');
				
			if ( is_empty($user_session_id) ) {
				$output['success'] = false;
				$output['error_code'] = 301;
				$output['reason'] = lang('error_api_301');
			} else if ( is_empty($app_name) || is_empty($app_id) ) {
				$output['success'] = false;
				$output['error_code'] = 102;
				$output['reason'] = lang('error_api_102');
			} else {
				// Check user session exists.
				$this->db->from('user_sessions');
				$this->db->where(array(
					'user_session_id' => $user_session_id,
					'user_session_status' => 'online',
				));
				
				$qry = $this->db->get();
				
				if ( $qry->num_rows() ) {
					// Check if the application exists.
					$this->db->from('app_sessions');
					$this->db->where(array(
						'user_session_id' => $user_session_id,
						'app_local_system_id' => $app_id,
					));
					
					$qry = $this->db->get();
					
					if ( $qry->num_rows() ) {
						// The application already started.
						$output['success'] = false;
						$output['error_code'] = 400;
						$output['reason'] = lang('error_api_400');
					} else {
						$app_session_id = $this->app_model->start(array(
							'app_local_system_id' => $app_id,
							'app_name' => $app_name,
							'user_session_id' => $user_session_id,
							'app_start' => db_date($timestamp),
						));
						
						if ( $app_session_id ) {
							$output['app_session_id'] = $app_session_id;
						}
					}
				} else {
					$output['success'] = false;
					$output['error_code'] = 301;
					$output['reason'] = lang('error_api_301');
				}
			}
		} else {
			$output['success'] = false;
		}
		
		json_output($output);
	}
	
	public function machine_off()
	{
		$output = array(
			'success' => true,
			'reason' => '',
			'machine_session_id' => null,
			'error_code' => 0,
		);
		
		if ( false !== ($business_data = $this->_validate_code($output['error_code'], $output['reason'])) ) {
			$mac_address = $this->input->get('mac_address');
			$timestamp = $this->input->get('timestamp');
			
			if ( is_empty($mac_address) ) {
				$output['success'] = false;
				$output['error_code'] = 102;
				$output['reason'] = lang('error_api_102');
			} else if ( !preg_match('/^[0-9a-zA-Z]+$/', $mac_address) ) {
				$output['success'] = false;
				$output['error_code'] = 300;
				$output['reason'] = lang('error_api_300');
			} else {
				// Check the machine detail.
				$business_id = $business_data['business_id'];
				
				$this->db->from('machines');
				$this->db->where(array(
					'business_id' => $business_id,
					'machine_mac_address' => $mac_address,
				));
				
				$qry = $this->db->get();
				
				if ( $qry->num_rows() ) {
					$machine_data = $qry->row_array();
					
					$this->machine_model->set_data($machine_data);
					
					if ( $this->machine_model->is_started() ) {
						$machine_session_id = $this->machine_model->off(db_date($timestamp));
						
						$output['machine_session_id'] = $machine_session_id;
					} else {
						$output['success'] = false;
						$output['error_code'] = 202;
						$output['reason'] = lang('error_api_202');
					}
				} else {
					$output['success'] = false;
					$output['error_code'] = 200;
					$output['reason'] = lang('error_api_200');
				}
			}
		} else {
			$output['success'] = false;
		}
		
		json_output($output);
	}
	
	public function machine_register()
	{
		$output = array(
			'success' => true,
			'reason' => '',
			'machine_id' => null,
			'error_code' => 0,
		);
		
		if ( false !== ($business_data = $this->_validate_code($output['error_code'], $output['reason'])) ) {
			$mac_address = $this->input->get('mac_address');
			$ip_address = $this->input->get('ip_address');
			$os = $this->input->get('os');
			$domain = $this->input->get('domain');
			$pc_name = $this->input->get('pc_name');
			$processor = $this->input->get('processor');
			$ram = $this->input->get('ram');
			$timestamp = $this->input->get('timestamp');
			$model = $this->input->get('model');
			$bios_serial_number = $this->input->get('machineserialnumber');
			
			if ( $ram > 0 ) {
				$ram = intval($ram);
				$ram /= pow(1024, 3);
				$ram = round($ram);
				$ram .= 'GB';
			}
			
			if ( is_empty($mac_address) || is_empty($ip_address) || is_empty($os) || is_empty($pc_name) ) {
				$output['success'] = false;
				$output['error_code'] = 102;
				$output['reason'] = lang('error_api_102');
			} else if ( !preg_match('/^[0-9a-zA-Z]+$/', $mac_address) ) {
				$output['success'] = false;
				$output['error_code'] = 300;
				$output['reason'] = lang('error_api_300');
			} else {
				$business_id = $business_data['business_id'];
				
				// Check if the machine already registered.
				$this->db->from('machines');
				$this->db->where(array(
					'business_id' => $business_id,
					'machine_mac_address' => $mac_address,
					'machine_visible' => 1,
				));
				
				$qry = $this->db->get();
				
				if ( $qry->num_rows() ) {
					$output['success'] = false;
					$output['error_code'] = 203;
					$output['reason'] = lang('error_api_203');
					
					$machine_data = $qry->row_array();
					
					$output['machine_id'] = $machine_data['machine_id'];
				} else {
					/* Register the machine */
					if ( $this->machine_model->register_machine(array(
						'business_id' => $business_id,
						'machine_mac_address' => $mac_address,
						'machine_ip_address' => $ip_address,
						'machine_os_name' => $os,
						'machine_name' => $pc_name,
						'machine_domain_name' => (is_empty($domain) ? null : $domain),
						'machine_serial_number' => (is_empty($bios_serial_number) ? null : $bios_serial_number),
						'machine_model' => (is_empty($model) ? null : $model),
						'machine_processor' => (is_empty($processor) ? null : $processor),
						'machine_ram' => (is_empty($ram) ? null : $ram),
						'machine_visible' => 1,
						'machine_created' => db_date($timestamp),
					)) ) {
						$output['machine_id'] = $this->machine_model->get_value('machine_id');
					} else {
						// Failed to create.
						$output['success'] = false;
						$output['error_code'] = 204;
						$output['reason'] = lang('error_api_204');
					}
				}
			}
		} else {
			$output['success'] = false;
		}
		
		json_output($output);
	}
	
	public function machine_start()
	{
		$output = array(
			'success' => true,
			'reason' => '',
			'machine_session_id' => null,
			'error_code' => 0,
		);
		
		if ( false !== ($business_data = $this->_validate_code($output['error_code'], $output['reason'])) ) {
			$mac_address = $this->input->get('mac_address');
			$ip_address = $this->input->get('ip_address');
			$timestamp = $this->input->get('timestamp');
			
			if ( is_empty($mac_address) || is_empty($ip_address) ) {
				$output['success'] = false;
				$output['error_code'] = 102;
				$output['reason'] = lang('error_api_102');
			} else if ( !preg_match('/^[0-9a-zA-Z]+$/', $mac_address) ) {
				$output['success'] = false;
				$output['error_code'] = 300;
				$output['reason'] = lang('error_api_300');
			} else {
				// Check the machine detail.
				$business_id = $business_data['business_id'];
				
				$this->db->from('machines');
				$this->db->where(array(
					'business_id' => $business_id,
					'machine_mac_address' => $mac_address,
				));
				
				$qry = $this->db->get();
				
				if ( $qry->num_rows() ) {
					$machine_data = $qry->row_array();
					
					$this->machine_model->set_data($machine_data);
					
					if ( !$this->machine_model->is_started() ) {
						$machine_session_id = $this->machine_model->start(db_date($timestamp));
						
						if ( $this->machine_model->get_value('machine_ip_address') != $ip_address ) {
							// Update the machine model's IP Address.
							$this->machine_model->set_value('machine_ip_address', $ip_address);
							$this->machine_model->save();
						}
						
						$output['machine_session_id'] = $machine_session_id;
					} else {
						$output['success'] = false;
						$output['error_code'] = 201;
						$output['reason'] = lang('error_api_201');
					}
				} else {
					$output['success'] = false;
					$output['error_code'] = 200;
					$output['reason'] = lang('error_api_200');
				}
			}
		} else {
			$output['success'] = false;
		}
		
		json_output($output);
	}
	
	public function machine_unregister()
	{
		$output = array(
			'success' => true,
			'reason' => '',
			'machine_id' => null,
			'error_code' => 0,
		);
		
		if ( false !== ($business_data = $this->_validate_code($output['error_code'], $output['reason'])) ) {
			$mac_address = $this->input->get('mac_address');
			$timestamp = $this->input->get('timestamp');
			
			if ( is_empty($mac_address) ) {
				$output['success'] = false;
				$output['error_code'] = 102;
				$output['reason'] = lang('error_api_102');
			} else if ( !preg_match('/^[0-9a-zA-Z]+$/', $mac_address) ) {
				$output['success'] = false;
				$output['error_code'] = 300;
				$output['reason'] = lang('error_api_300');
			} else {
				$business_id = $business_data['business_id'];
				
				// Check if the machine already registered.
				$this->db->from('machines');
				$this->db->where(array(
					'business_id' => $business_id,
					'machine_mac_address' => $mac_address,
				));
				
				$qry = $this->db->get();
				
				if ( !$qry->num_rows() ) {
					$output['success'] = false;
					$output['error_code'] = 200;
					$output['reason'] = lang('error_api_200');
				} else {
					$machine_data = $qry->row_array();
					$machine_id = $machine_data['machine_id'];
					
					if ( !$this->machine_model->unregister_machine($machine_id) ) {
						// Failed to create.
						$output['success'] = false;
						$output['error_code'] = 205;
						$output['reason'] = lang('error_api_205');
					}
				}
			}
		} else {
			$output['success'] = false;
		}
		
		json_output($output);
	}
	
	public function user_signin()
	{
		$output = array(
			'success' => true,
			'reason' => '',
			'user_session_id' => null,
			'error_code' => 0,
		);
		
		if ( false !== ($business_data = $this->_validate_code($output['error_code'], $output['reason'])) ) {
			$business_id = $business_data['business_id'];
			$mac_address = $this->input->get('mac_address');
			$username = $this->input->get('username');
			$domain = $this->input->get('domain');
			$groups = $this->input->get('groups');
			$timestamp = $this->input->get('timestamp');
			
			if ( is_empty($mac_address) || is_empty($username) ) {
				$output['success'] = false;
				$output['error_code'] = 102;
				$output['reason'] = lang('error_api_102');
			} else if ( !preg_match('/^[0-9a-zA-Z]+$/', $mac_address) ) {
				$output['success'] = false;
				$output['error_code'] = 300;
				$output['reason'] = lang('error_api_300');
			} else {
				$this->db->from('machines');
				$this->db->where(array(
					'business_id' => $business_id,
					'machine_mac_address' => $mac_address,
				));
				
				$qry = $this->db->get();
				
				if ( $qry->num_rows() ) {
					$machine_data = $qry->row_array();
					$machine_id = $machine_data['machine_id'];
					
					// Check machine status.
					if ( $machine_data['machine_status'] == 'offline' ) {
						// Machine is not online.
						$output['success'] = false;
						$output['error_code'] = 202;
						$output['reason'] = lang('error_api_202');
					} else {
						// Sign in the user.
						if ( false !== ($user_session_id = $this->user_model->sign_in(array(
							'machine_data' => $machine_data,
							'username' => $username,
							'domain' => (is_empty($domain) ? null : $domain),
							'groups' => (is_empty($groups) ? null : $groups),
							'login_time' => db_date($timestamp),
						))) ) {
							$output['user_session_id'] = $user_session_id;
						} else {
							$output['success'] = false;
							$output['error_code'] = 302;
							$output['reason'] = lang('error_api_302');
						}
					}
				} else {
					// machine not found.
					$output['success'] = false;
					$output['error_code'] = 200;
					$output['reason'] = lang('error_api_200');
				}
			}
		} else {
			$output['success'] = false;
		}
		
		json_output($output);
	}
	
	public function user_signout()
	{
		$output = array(
			'success' => true,
			'reason' => '',
			'user_session_id' => null,
			'error_code' => 0,
		);
		
		if ( false !== ($business_data = $this->_validate_code($output['error_code'], $output['reason'])) ) {
			$business_id = $business_data['business_id'];
			$mac_address = $this->input->get('mac_address');
			$user_session_id = $this->input->get('user_session_id');
			$timestamp = $this->input->get('timestamp');
			
			if ( is_empty($mac_address) || is_empty($user_session_id) ) {
				$output['success'] = false;
				$output['error_code'] = 102;
				$output['reason'] = lang('error_api_102');
			} else if ( !preg_match('/^[0-9a-zA-Z]+$/', $mac_address) ) {
				$output['success'] = false;
				$output['error_code'] = 300;
				$output['reason'] = lang('error_api_300');
			} else {
				// Check if the user session ID exists and valid.
				$this->db->select('user_sessions.*');
				$this->db->from('user_sessions');
				$this->db->join('machines', 'user_sessions.machine_id = machines.machine_id');
				$this->db->where(array(
					'user_session_id' => $user_session_id,
					'machines.business_id' => $business_id,
					'machines.machine_mac_address' => $mac_address,
				));
				
				$qry = $this->db->get();
				
				if ( $qry->num_rows() ) {
					$user_session_data = $qry->row_array();
					
					if ( $user_session_data['user_session_status'] == 'offline' ) {
						// User already offline.
						$output['success'] = false;
						$output['error_code'] = 303;
						$output['reason'] = lang('error_api_303');
					} else {
						$user_session_data['user_session_end'] = db_date($timestamp);
						
						$this->user_model->sign_out($user_session_data);
						
						$output['user_session_id'] = $user_session_id;
					}
				} else {
					// No such session found.
					$output['success'] = false;
					$output['error_code'] = 301;
					$output['reason'] = lang('error_api_301');
				}
			}
		} else {
			$output['success'] = false;
		}
		
		json_output($output);
	}
	
	/**
	 * This method will validate the input code against the
	 * merchant code and timestamp.
	 * 
	 * It will return the business data row if the validation
	 * is passed. FALSE otherwise. 
	 * 
	 * @param int optional $error_code
	 * @param string optional $error_message
	 * @return boolean|array
	 */
	protected function _validate_code(&$error_code = 0, &$error_message = '')
	{
		$code = $this->input->get('code');
		$hash = $this->input->get('hash');
		$timestamp = $this->input->get('timestamp');
		
		if ( is_empty($timestamp) || !is_pure_digits($timestamp) ) {
			$error_code = 103;
			$error_message = lang('error_api_103');
		} else {
			$this->db->from('businesses');
			$this->db->where('business_code', $code);
			$qry = $this->db->get();
			
			if ( $qry->num_rows() ) {
				$business_data = $qry->row_array();
				$hashed = md5($code . $timestamp);
				
				if ( $hash == $hashed ) {
					return $business_data;
				} else {
					$error_code = 101;
					$error_message = lang('error_api_101');
				}
			} else {
				$error_code = 100;
				$error_message = lang('error_api_100');
				
				return false;
			}
		}
	}
}