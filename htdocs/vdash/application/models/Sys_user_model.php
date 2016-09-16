<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'models/Authenticated_user.php');

class Sys_user_model extends EB_Model implements Authenticated_user {
	protected $_session_name = '_USER';
	
	protected $_table_name = 'sys_users';
	
	/**
	 * This will verify the user login detail. It will return
	 * true if the email and password is valid.
	 * 
	 * The password has to be plain text.
	 * 
	 * The last parameter is optional. If the authentication is
	 * valid, it will assign the user data to the last parameter.
	 * 
	 * @param string $email
	 * @param string $password
	 * @param string optional $user_data
	 * @return boolean
	 */
	public function authenticate($email, $password, &$user_data = null)
	{
		$this->db->from('sys_users');
		$this->db->where('sys_user_email', $email);
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			
			$hashed_password = $row['sys_user_password'];
			
			if ( password_verify($password, $hashed_password) ) {
				$user_data = $row;
				
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * This method will verify the password string before
	 * updating the database. If the password has invalid
	 * character, it will return false. The last parameter
	 * will return the error message.
	 * 
	 * @param string $password
	 * @param string optional $error_message
	 * @return boolean
	 */
	public function change_password($password, &$error_message = '')
	{
		if ( !preg_match('/^\S+$/', $password) ) {
			$error_message = lang('error_invalid_password');
			return false;
		} else {
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
			
			$this->set_value('sys_user_password', $hashed_password);
			$this->save();
			
			return true;
		}
	}
	
	/**
	 * This method will return the business model that this user
	 * belongs to. If this user is not belongs to any business
	 * model, it will return NULL.
	 * 
	 * @return Business_model|null
	 */
	public function get_business_model()
	{
		$business_id = $this->get_value('business_id');
		
		if ( $business_id ) {
			$this->db->from('businesses');
			$this->db->where('business_id', $business_id);
			
			$qry = $this->db->get();
			
			if ( $qry->num_rows() ) {
				$business_data = $qry->row_array();
				
				$this->load->model('Business_model');
				
				$business_model = new Business_model();
				$business_model->set_data($business_data);
				
				return $business_model;
			}
		}
		
		return null;
	}
	
	public function get_roles()
	{
		$user_type = $this->get_value('user_type');
		
		return array($user_type);
	}
	
	public function initialize_from_session()
	{
		$user_data = $this->session->userdata($this->_session_name);
		
		if ( iterable($user_data) ) {
			$this->set_data($user_data);
		}
	}
	
	/**
	 * This will authenticate the user and set the user detail
	 * into session if valid.
	 * 
	 * @param string $email
	 * @param string $password
	 * @param string optional $error_message
	 */
	public function login($email, $password, &$error_message = '')
	{
		if ( $this->authenticate($email, $password, $user_data) ) {
			$this->db->update('sys_users', array(
				'sys_user_last_login' => db_date(),
			), array(
				'sys_user_id' => $user_data['sys_user_id'],
			));
			
			$this->set_session($user_data);
			
			return true;
		} else {
			$error_message = lang('error_login_failed');
			
			return false;
		}
	}
	
	/**
	 * This will destory the current user session.
	 * 
	 * @return null
	 */
	public function logout()
	{
		$this->session->unset_userdata($this->_session_name);
	}
	
	public function on_save()
	{
		if ( $this->is_new() ) {
			$sys_user_model = $this->authentication->get_model();
			$sys_user_id = $sys_user_model->get_value('sys_user_id');
			
			$this->set_value('sys_user_created', db_date());
			$this->set_value('sys_user_created_by', $sys_user_id);
		}
	}
	
	/**
	 * To set the user's data into the session.
	 * 
	 * @param array $user_data
	 * @return null
	 */
	public function set_session($user_data)
	{
		if ( isset($user_data['sys_user_password']) ) {
			unset($user_data['sys_user_password']);
		}
		
		$this->session->set_userdata($this->_session_name, $user_data);
	}
}