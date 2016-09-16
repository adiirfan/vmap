<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business_model extends EB_Model {
	protected $_table_name = 'businesses';
	
	public function on_save()
	{
		if ( $this->is_new() ) {
			$sys_user_model = $this->authentication->get_model();
			$sys_user_id = $sys_user_model->get_value('sys_user_id');
			$this->set_value('business_created', db_date());
			$this->set_value('business_created_by', $sys_user_id);
		}
		
		// Generate business code if the model's value is empty.
		if ( is_empty($this->get_value('business_code')) ) {
			$this->set_value('business_code', $this->generate_business_code());
		}
	}
	
	/**
	 * This method will generate a random code for the business
	 * account. It will ensure that the code is not duplicated.
	 * 
	 * @return string
	 */
	public function generate_business_code()
	{
		$code = '';
		
		do {
			$code = random_string('alpha', 6);
			
			$this->db->from('businesses');
			$this->db->where('business_code LIKE BINARY "' . $code . '"', null, false);
			$qry = $this->db->get();
			
			if ( !$qry->num_rows() ) {
				break;
			}
		} while(true);
		
		return $code;
	}
	
	/**
	 * This return the users who was assigned to this business.
	 * It will return the user data in array format.
	 * If there are no user found, FALSE will be returned.
	 * 
	 * @return array|boolean
	 */
	public function get_business_users()
	{
		$business_id = $this->get_value('business_id');
		
		if ( $business_id ) {
			$this->db->from('sys_users');
			$this->db->where('business_id', $business_id);
			
			$qry = $this->db->get();
			
			if ( $qry->num_rows() ) {
				return $qry->result_array();
			}
		}
		
		return false;
	}
}