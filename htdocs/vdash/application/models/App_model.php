<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App_model extends EB_Model {
	protected $_table_name = 'apps';
	
	/**
	 * This method will end an application session.
	 * The parameter should consist the following elements:
	 * + app_local_system_id
	 * + user_session_id
	 * + app_end
	 *
	 * If the application is successfully closed, it will return the
	 * app_session_id. Otherwise, false will be returned.
	 *
	 * @param array $data
	 * @return int|boolean
	 */
	public function close($data)
	{
		$this->load->model('App_session_model', 'app_session_model');
		
		$app_sys_id = array_ensure($data, 'app_local_system_id', 0);
		$user_session_id = array_ensure($data, 'user_session_id', 0);
		$app_end_time = array_ensure($data, 'app_end', '');
		
		if ( !$app_sys_id || !$user_session_id ) {
			return false;
		}
		
		if ( is_empty($app_end_time) ) {
			$app_end_time = db_date();
		}
		
		// Find the app_sessions row.
		$this->db->from('app_sessions');
		$this->db->where(array(
			'user_session_id' => $user_session_id,
			'app_local_system_id' => $app_sys_id,
		));
		
		$qry = $this->db->get();
		
		if ( !$qry->num_rows() ) {
			return false;
		}
		
		$app_session_data = $qry->row_array();
		
		$app_start_time = $app_session_data['app_start'];
		
		$duration = strtotime($app_end_time) - strtotime($app_start_time);
		
		if ( $duration < 0 ) {
			$duration = 0;
		}
		
		$app_session_data['app_end'] = $app_end_time;
		$app_session_data['app_duration'] = $duration;
		
		$this->app_session_model->set_data($app_session_data);
		$this->app_session_model->save();
		
		return $app_session_data['app_session_id'];
	}
	
	public function on_save()
	{
		if ( $this->is_new() ) {
			$this->set_value('app_created', db_date());
		}
	}
	
	/**
	 * This method will remove those user defined data
	 * and update the database.
	 * 
	 * @return boolean
	 */
	public function remove_user_data()
	{
		$app_id = $this->get_value('app_id');
		
		if ( !$app_id ) {
			return false;
		}
		
		$app_name = $this->get_value('app_sys_name');
		
		$this->set_value(array(
			'app_friendly_name' => $app_name,
			'app_license_count' => 0,
			'app_version' => null,
			'app_license_type' => null,
			'app_vendor' => null,
			'app_purchase_date' => null,
			'app_expiry_date' => null,
			'app_virtualized' => null,
		));
		
		$this->save();
		
		return true;
	}
	
	/**
	 * This method actually will update this current app_model
	 * visibility status to the specified status in first parameter.
	 *
	 * @param boolean $visibility
	 * @return boolean
	 */
	public function set_visibility($visibility)
	{
		$app_id = $this->get_value('app_id');
	
		if ( !$app_id ) {
			return false;
		}
	
		$this->db->update('apps', array(
			'app_visible' => ($visibility ? 1 : 0),
		), array(
			'app_id' => $app_id,
		));
	
		return true;
	}
	
	/**
	 * This method will create a start session for the application.
	 * The parameter should consist the following elements:
	 * + app_local_system_id
	 * + app_name
	 * + user_session_id
	 * + app_start
	 * 
	 * This method will return the app_session_id if successfully created.
	 * Otherwise, false will be returned.
	 * 
	 * @param array $data
	 * @return int|boolean
	 */
	public function start($data)
	{
		$this->load->model('App_filter_model', 'app_filter_model');
		$this->load->model('App_session_model', 'app_session_model');
		
		$app_name = array_ensure($data, 'app_name', '');
		$user_session_id = array_ensure($data, 'user_session_id', 0);
		$app_start_time = array_ensure($data, 'app_start', '');
		$app_sys_id = array_ensure($data, 'app_local_system_id', 0);
		
		if ( is_empty($app_name) || !$user_session_id ) {
			return false;
		}
		
		if ( is_empty($app_start_time) ) {
			$app_start_time = db_date();
		}
		
		// Get the user session detail first.
		$this->db->from('user_sessions');
		$this->db->join('users', 'user_sessions.user_id = users.user_id');
		$this->db->where('user_sessions.user_session_id', $user_session_id);
		
		$qry = $this->db->get();
		
		if ( !$qry->num_rows() ) {
			return false;
		}
		
		$user_session_data = $qry->row_array();
		
		$user_id = $user_session_data['user_id'];
		$business_id = $user_session_data['business_id'];
		
		// Find the application name.
		$this->db->from('apps');
		$this->db->where(array(
			'business_id' => $business_id,
			'app_sys_name' => $app_name,
		));
		
		$qry = $this->db->get();
		$app_data = array();
		
		if ( $qry->num_rows() ) {
			$app_data = $qry->row_array();
		} else {
			// No app data found. Create one.
			$app_data = array(
				'business_id' => $business_id,
				'app_sys_name' => $app_name,
				'app_friendly_name' => $app_name,
				'app_license_count' => 0,
				'app_visible' => 1,
				'app_created' => $app_start_time,
			);
			
			// Filter here.
			$result = $this->app_filter_model->filter_all($business_id, $app_name);
			
			if ( $result ) {
				$action = array_ensure($result, 'app_filter_action', '');
				
				if ( $action == 'block' ) {
					$app_data['app_visible'] = 0;
				}
			}
			
			$app_model = new App_model();
			$app_model->set_data($app_data);
			
			$app_model->save();
			
			$app_data['app_id'] = $app_model->get_value('app_id');
		}
		
		# App_sessions.
		
		// Find the starter ID.
		$app_session_starter = 0;
		$this->db->from('app_sessions');
		$this->db->where('app_end', null);
		$this->db->order_by('app_start', 'asc');
		$this->db->limit(1);
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			$app_session_starter = intval($row['app_session_id']);
		} else {
			$app_session_starter = $this->app_session_model->get_next_increment_value();
		}
		
		$app_id = $app_data['app_id'];
		$app_session_data = array(
			'app_id' => $app_id,
			'user_session_id' => $user_session_id,
			'app_session_starter_id' => $app_session_starter,
			'app_local_system_id' => $app_sys_id,
			'app_start' => $app_start_time,
		);
		
		$this->app_session_model->set_data($app_session_data);
		$this->app_session_model->save();
		
		return $this->app_session_model->get_value('app_session_id');
	}
}