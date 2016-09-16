<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends EB_Model {
	protected $_table_name = 'users';
	
	/**
	 * This method actually will update this current user_model
	 * visibility status to the specified status in first parameter.
	 * 
	 * @param boolean $visibility
	 * @return boolean
	 */
	public function set_visibility($visibility)
	{
		$user_id = $this->get_value('user_id');
		
		if ( !$user_id ) {
			return false;
		}
		
		$this->db->update('users', array(
			'user_visible' => ($visibility ? 1 : 0),
		), array(
			'user_id' => $user_id,
		));
		
		return true;
	}
	
	/**
	 * This method will sign in the user provided in the first
	 * parameter. It should contains the following elements:
	 * machine_data - The database row of machines table. This represent the machine the user currently logged in.
	 * username - The username of the user.
	 * domain - The AD domain name. Optional.
	 * groups - The user groups. Optional.
	 * login_time - The login date/time in MySQL standard format.
	 * 
	 * If the user session successfully created, it will
	 * return the user_session_id. Otherwise, false will be returned.
	 * 
	 * This method will also calculate the starter user_session_id for
	 * concurrent calculation purpose.
	 * 
	 * @param array $data
	 * @return int|boolean
	 */
	public function sign_in($data)
	{
		$this->load->model('User_filter_model', 'user_filter_model');
		$this->load->model('User_session_model', 'user_session_model');
		
		$machine_data = array_ensure($data, 'machine_data', false);
		$username = array_ensure($data, 'username', false);
		$domain = array_ensure($data, 'domain', false);
		$groups = array_ensure($data, 'groups', false);
		$login_time = array_ensure($data, 'login_time', false);
		$current_datetime = db_date();
		
		if ( !$machine_data || !$username ) {
			return false;
		}
		
		if ( !$login_time ) {
			$login_time = $current_datetime;
		}
		
		$machine_id = $machine_data['machine_id'];
		$pc_name = $machine_data['machine_default_name'];
		$business_id = $machine_data['business_id'];
		$username_full = trim(is_empty($domain) ? $pc_name . '\\' . $username : $domain . '\\' . $username);
		
		// Check if the user exists.
		$qry = $this->db->get_where('users', array(
			'user_name_full' => $username_full,
			'business_id' => $business_id,
		));
		
		$user_data = false;
		
		if ( $qry->num_rows() ) {
			// Assign the user data into the array.
			$user_data = $qry->row_array();
			
			// Update the user last connected date/time and machine and also the status.
			$this->db->update('users', array(
				'user_last_connected' => $login_time,
				'user_last_connected_machine' => $machine_id,
				'user_status' => 'online',
			), array(
				'user_id' => $user_data['user_id'],
			));
		} else {
			// User not found, let's create it.
			$user_data = array(
				'business_id' => $business_id,
				'user_group_id' => null,
				'user_name_full' => $username_full,
				'user_domain' => (is_empty($domain) ? $pc_name : $domain),
				'user_name' => $username,
				'user_ad_group' => $groups,
				'user_remark' => null,
				'user_visible' => 1,
				'user_status' => 'online',
				'user_last_connected' => $current_datetime,
				'user_last_connected_machine' => $machine_id,
				'user_created' => $current_datetime,
			);
			
			// Filter.
			//$filters = $this->user_filter_model->filter($business_id, $user_data);
			$filters = false;
			
			if ( iterable($filters) ) {
				foreach ( $filters as $filter ) {
					$action = $filter['user_filter_action'];
					
					if ( $action == 'blacklist' ) {
						$user_data['user_visible'] = 0;
					} else if ( $action == 'group' ) {
						$user_group_id = intval(array_ensure($filter, 'user_filter_group_assigned', 0));
						
						if ( $user_group_id ) {
							$user_data['user_group_id'] = $user_group_id;
						}
					}
				}
			}
			
			// Save the data to database.
			$user_model = new User_model();
			$user_model->set_data($user_data);
			
			$user_model->save();
			
			$user_data['user_id'] = $user_model->get_value('user_id');
		}
		
		# User sessions.
		$user_id = $user_data['user_id'];
		// Prepare the user session data to be insert.
		$user_session_data = array(
			'machine_id' => $machine_id,
			'user_id' => $user_id,
			'user_session_start' => $login_time,
			'user_session_status' => 'online',
		);
		
		// Find the starter session.
		$this->db->from('user_sessions');
		$this->db->where(array(
			'user_session_status' => 'online',
		));
		$this->db->order_by('user_session_start', 'asc');
		$this->db->limit(1);
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			
			$user_session_data['user_session_starter'] = $row['user_session_id'];
		} else {
			$user_session_data['user_session_id'] = $this->user_session_model->get_next_increment_value();
			$user_session_data['user_session_starter'] = $user_session_data['user_session_id'];
		}
		
		$this->user_session_model->set_data($user_session_data);
		$this->user_session_model->save();
		
		// Update the machine's last logged in user and date/time.
		$this->db->update('machines', array(
			'machine_last_login' => $login_time,
			'machine_last_login_user' => $user_id,
			'machine_status' => 'occupied',
		), array(
			'machine_id' => $machine_id,
		));
		
		return $this->user_session_model->get_value('user_session_id');
	}
	
	/**
	 * Sign out the specified user session ID. The first parameter should
	 * be the user_sessions table row data.
	 * 
	 * This method will return TRUE if the sign out was success or
	 * false otherwise.
	 * 
	 * This method will also calculate the duration based on the start datetime
	 * and the end datetime.
	 * 
	 * This method will also close all application under this session.
	 * 
	 * If there are no more session running for this user, this method will update
	 * the user's status to offline.
	 * 
	 * @param array $user_session_data
	 * @param string $signout_datetime optional The signout date time in MySQL standard format.
	 * @return boolean
	 */
	public function sign_out($user_session_data)
	{
		$user_session_id = array_ensure($user_session_data, 'user_session_id', 0);
		$start_time = array_ensure($user_session_data, 'user_session_start', '');
		$end_time = array_ensure($user_session_data, 'user_session_end', '');
		$user_id = array_ensure($user_session_data, 'user_id', 0);
		$machine_id = array_ensure($user_session_data, 'machine_id', 0);
		
		if ( !$user_session_id ) {
			return false;
		}
		
		if ( is_empty($end_time) ) {
			$end_time = db_date();
		}
		
		$end_datetime = strtotime($end_time);
		
		$duration = $end_datetime - strtotime($start_time);
		
		if ( $duration < 0 ) {
			$duration = 0;
		}
		
		// Update the user sessions.
		$this->db->update('user_sessions', array(
			'user_session_end' => $end_time,
			'user_session_duration' => $duration,
			'user_session_status' => 'offline',
		), array(
			'user_session_id' => $user_session_id,
		));
		
		// Close all application that under this session ID.
		$this->db->from('app_sessions');
		$this->db->where(array(
			'user_session_id' => $user_session_id,
			'app_end' => null,
		));
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			foreach ( $qry->result_array() as $row ) {
				$duration = $end_datetime - strtotime($row['app_start']);
				
				if ( $duration < 0 ) {
					$duration = 0;
				}
				
				$this->db->update('app_sessions', array(
					'app_end' => $end_time,
					'app_duration' => $duration,
				), array(
					'app_session_id' => $row['app_session_id'],
				));
			}
		}
		
		// Now check if this is the last online session of the user.
		$this->db->from('user_sessions');
		$this->db->where(array(
			'user_id' => $user_id,
			'user_session_status' => 'online',
		));
		$qry = $this->db->get();
		
		if ( !$qry->num_rows() ) {
			// The user has no more online session, let's update the user's table.
			$this->db->update('users', array(
				'user_status' => 'offline',
			), array(
				'user_id' => $user_id,
			));
		}
		
		// Check the machine has any active session running, otherwise, set the status to online.
		$this->db->from('user_sessions');
		$this->db->where(array(
			'machine_id' => $machine_id,
			'user_session_status' => 'online',
		));
		$qry = $this->db->get();
		
		if ( !$qry->num_rows() ) {
			// No more, let's update it to online.
			$this->db->update('machines', array(
				'machine_status' => 'online',
			), array(
				'machine_id' => $machine_id,
			));
		}
	}
}