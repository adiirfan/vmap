<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_filter_model extends EB_Model {
	protected $_table_name = 'user_filters';
	
	/**
	 * This method will filter all rules against the user data passed in the
	 * second parameter.
	 * 
	 * The last parameter is passed by reference. An extra array element will
	 * be added: matched. It might contact the following values:
	 * matched
	 * not_matched
	 * skipped
	 * 
	 * This method will return the matched filter rules data row in array format.
	 * Otherwise, FALSE will be returned.
	 * 
	 * @param int $business_id
	 * @param array $user_data
	 * @param array optional $result
	 * @return boolean|array
	 */
	public function filter_all($business_id, $user_data, &$result = array())
	{
		$return = false;
		
		$this->db->from('user_filters');
		$this->db->where('business_id', $business_id);
		$this->db->order_by('user_filter_order', 'asc');
		
		$qry = $this->db->get();
		$filters = array();
		
		if ( $qry->num_rows() ) {
			$user_filter_model = new User_filter_model();
			
			$user_filter_model->set_data($qry->result_array());
			
			$stop = false;
			
			foreach ( $user_filter_model as $filter_model ) {
				$test_result = $filter_model->filter($user_data);
				$filter_data = $filter_model->get_data();
				$on_success = $filter_model->get_value('user_filter_on_success');
				$on_fail = $filter_model->get_value('user_filter_on_fail');
				
				if ( $test_result ) {
					if ( !$return ) {
						$return = array();
					}
					
					if ( !$stop ) {
						$return[] = $filter_data;
						$filter_data['matched'] = 'matched';
					} else {
						$filter_data['matched'] = 'skipped';
					}
					
					if ( $on_success == 'stop' ) {
						$stop = true;
					}
				} else {
					if ( $stop ) {
						$filter_data['matched'] = 'skipped';
					} else {
						$filter_data['matched'] = 'not_matched';
					}
					
					if ( $on_fail == 'stop' ) {
						$stop = true;
					}
				}
				
				$result[] = $filter_data;
			}
		}
		
		return $return;
	}
	
	public function filter($user_data)
	{
		$user_filter_maps = array(
			// 'user_filter_username_full' => 'user_name_full',
			'user_filter_domain' => 'user_domain',
			'user_filter_username' => 'user_name',
			'user_filter_ad_group' => 'user_ad_group',
		);
		
		$negate = $this->get_value('user_filter_negate');
		
		foreach ( $user_filter_maps as $filter_field => $user_field ) {
			$filter_value = $this->get_value($filter_field);
			
			if ( !is_empty($filter_value) ) {
				$user_value = array_ensure($user_data, $user_field, '');
				
				$pattern = preg_quote($filter_value);
				$pattern = preg_replace('/\\\\\\*/', '.*', $pattern);
				
				$regex = '/' . $pattern . '/i';
				
				$match = preg_match($regex, $user_value);
				
				if ( (!$match && !$negate) || ($match && $negate) ) {
					return false;
				}
			}
		}
		
		return true;
	}
	
	public function on_save()
	{
		if ( $this->is_new() ) {
			$sys_user_model = $this->authentication->get_model();
			$sys_user_id = $sys_user_model->get_value('sys_user_id');
			$db_date = db_date();
			
			// Find the order.
			$this->db->select('COUNT(*) AS last_index');
			$this->db->from('user_filters');
			$this->db->where('business_id', $this->get_value('business_id'));
			$qry = $this->db->get();
			$last_index = 0;
			
			if ( $qry->num_rows() ) {
				$row = $qry->row_array();
				
				$last_index = $row['last_index'];
			}
			
			$this->set_value(array(
				'user_filter_order' => $last_index,
				'user_filter_created' => $db_date,
				'user_filter_created_by' => $sys_user_id,
			));
		}
	}
}