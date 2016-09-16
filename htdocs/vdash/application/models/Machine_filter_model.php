<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Machine_filter_model extends EB_Model {
	protected $_table_name = 'machine_filters';
	
	/**
	 * This method will run all the filters under the business ID specified
	 * in the first parameter.
	 * 
	 * The second parameter is a single row data of the machine table.
	 * 
	 * The last parameter is passed by reference. It will store all the filters
	 * regardless it match or not. Each array element will be append a key call
	 * "matched" => true/false
	 * 
	 * This method will return the matched filter row. If no filter matched, false
	 * will return
	 * 
	 * @param int $business_id
	 * @param array $machine_data
	 * @param array optional $result
	 * @return array|boolean
	 */
	public function filter_all($business_id, $machine_data, &$result = array())
	{
		$return = false;
		
		$this->db->from('machine_filters');
		$this->db->where('business_id', $business_id);
		$this->db->order_by('machine_filter_order', 'asc');
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			$machine_filter_model = new Machine_filter_model();
			$machine_filter_model->set_data($qry->result_array());
			$break = false;
			
			foreach ( $machine_filter_model as $filter_model ) {
				$on_success = $filter_model->get_value('machine_filter_on_success');
				$on_fail = $filter_model->get_value('machine_filter_on_fail');
				$test_result = $filter_model->filter($machine_data);
				$filter_data = $filter_model->get_data();
				$result_data = $filter_data;
				$result_data['matched'] = $test_result;
				
				$result[] = $result_data;
				
				// echo $filter_model->get_value('machine_filter_name') . ' (' . $on_success . ')' . ' ' . ($test_result ? ' matched' : ' not matched') . PHP_EOL;
				
				if ( !$break ) {
					if ( $test_result ) {
						if ( $return === false ) {
							$return = array();
						}
						
						$return[] = $filter_data;
						
						if ( $on_success == 'stop' ) {
							$break = true;
						}
					} else {
						if ( $on_fail == 'stop' ) {
							$break = true;
						}
					}
				}
			}
		}
		
		return $return;
	}
	
	/**
	 * This will match the machine data provided against this
	 * filter model.
	 * 
	 * @param array $machine_data
	 * @return boolean
	 */
	public function filter($machine_data)
	{
		$filter_row = $this->get_data();
		
		$filters['machine_mac_address'] = array_ensure($filter_row, 'machine_filter_mac_address', '');
		$filters['machine_ip_address'] = array_ensure($filter_row, 'machine_filter_ip_address', '');
		$filters['machine_default_name'] = array_ensure($filter_row, 'machine_filter_pc_name', '');
		$negate = array_ensure($filter_row, 'machine_filter_negate', 0);
		
		foreach ( $filters as $machine_field => $filter_pattern ) {
			$value = array_ensure($machine_data, $machine_field, '');
			
			if ( !is_empty($filter_pattern) ) {
				$filter_pattern = preg_quote($filter_pattern);
				$filter_pattern = preg_replace('/\\\\\\*/', '.*', $filter_pattern);
				
				$regex = '/' . $filter_pattern . '/i';
				
				$match = preg_match($regex, $value);
				
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
			
			// Find the last order number.
			$this->db->select('COUNT(*) AS last_count');
			$this->db->from('machine_filters');
			$this->db->where('business_id', $this->get_value('business_id'));
			
			$qry = $this->db->get();
			
			$last_index = 0;
			
			if ( $qry->num_rows() ) {
				$row = $qry->row_array();
				
				$last_index = intval($row['last_count']);
			}
			
			$this->set_value(array(
				'machine_filter_order' => $last_index,
				'machine_filter_created' => $db_date,
				'machine_filter_created_by' => $sys_user_id,
			));
		}
	}
}