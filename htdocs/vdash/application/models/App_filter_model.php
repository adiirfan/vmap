<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App_filter_model extends EB_Model {
	protected $_table_name = 'app_filters';
	
	/**
	 * This method will match the filter rules from a business
	 * against the application name provided in the second parameter.
	 * 
	 * The last parameter is passed by reference. It contained all filter
	 * data row. An additional element will added to each row to indicate
	 * whether the filter has matched or not. "matched" => true/false
	 * 
	 * This method will return the last matched filter data row. If there
	 * are no filter matched, FALSE will be return.
	 * 
	 * @param int $business_id
	 * @param string $app_name
	 * @return boolean|array
	 */
	public function filter_all($business_id, $app_name, &$result = array())
	{
		$return = false;
		
		$this->db->from('app_filters');
		$this->db->where('business_id', $business_id);
		$this->db->order_by('app_filter_order', 'asc');
		$qry = $this->db->get();
		$skip_filter = false;
		
		if ( $qry->num_rows() ) {
			$app_data = array(
				'app_sys_name' => $app_name,
			);
			
			$app_filter_model = new App_filter_model();
			
			$app_filter_model->set_data($qry->result_array());
			
			foreach ( $app_filter_model as $model ) {
				$model_data = $model->get_data();
				
				if ( !$skip_filter ) {
					if ( $model->filter($app_data) ) {
						// Matched.
						if ( $model->get_value('app_filter_on_success') == 'stop' ) {
							$skip_filter = true;
						}
						
						$model_data['matched'] = true;
						$return = $model_data;
					} else {
						// Not matched.
						if ( $model->get_value('app_filter_on_fail') == 'stop' ) {
							$skip_filter = true;
						}
						
						$model_data['matched'] = false;
					}
				} else {
					$model_data['matched'] = false;
				}
				
				$result[] = $model_data;
			}
		}
		
		return $return;
	}
	
	/**
	 * This will evaluate the data provided against this filter
	 * model. If it matched, it will return TRUE, otherwise FALSE.
	 * 
	 * @param array $data
	 * @return boolean
	 */
	public function filter($data)
	{
		if ( $this->is_empty() ) {
			return false;
		}
		
		$pattern = trim($this->get_value('app_filter_sys_name'));
		$pattern = preg_quote($pattern);
		$pattern = preg_replace('/\\\\\\*/', '.*', $pattern);
		
		$negate = ($this->get_value('app_filter_negate') ? true : false);
		
		$app_name = array_ensure($data, 'app_sys_name', '');
		
		$match = preg_match('/' . $pattern . '/i', $app_name);
		
		if ( ($match && !$negate) || (!$match && $negate) ) {
			return true;
		} else {
			return false;
		}
	}
	
	public function on_deleted($data)
	{
		$business_id = $data['business_id'];
		
		$this->db->from('app_filters');
		$this->db->where('business_id', $business_id);
		$this->db->order_by('app_filter_order', 'asc');
		
		$qry = $this->db->get();
		$order = 0;
		
		foreach ( $qry->result_array() as $row ) {
			$app_filter_id = $row['app_filter_id'];
			$this->db->update('app_filters', array(
				'app_filter_order' => $order ++,
			), array(
				'app_filter_id' => $app_filter_id,
			));
		}
	}
	
	public function on_save()
	{
		if ( $this->is_new() ) {
			$sys_user_model = $this->authentication->get_model();
			$sys_user_id = $sys_user_model->get_value('sys_user_id');
			
			$this->set_value('app_filter_created', db_date());
			$this->set_value('app_filter_created_by', $sys_user_id);
			
			// Find out the sequence if not set.
			if ( false === $this->get_value('app_filter_order') ) {
				$business_id = $this->get_value('business_id');
				
				$this->db->from('app_filters');
				$this->db->where('business_id', $business_id);
				$this->db->order_by('app_filter_order', 'desc');
				$this->db->limit(1);
				$qry = $this->db->get();
				$order = 0;
				
				if ( $qry->num_rows() ) {
					$row = $qry->row_array();
					$order = intval($row['app_filter_order']) + 1;
				}
				
				$this->set_value('app_filter_order', $order);
			}
		}
	}
}