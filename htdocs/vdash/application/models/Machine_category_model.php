<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Machine_category_model extends EB_Model {
	protected $_table_name = 'machine_categories';
	
	/**
	 * This method will match the operating system name
	 * with the machine categories available. If it found,
	 * it will return the machine category row data. Otherwise,
	 * false will be returned.
	 * 
	 * @param string $os_name
	 * @return boolean|array
	 */
	public function match_category($os_name)
	{
		$this->db->from('machine_categories');
		$this->db->order_by('machine_category_order', 'asc');
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			foreach ( $qry->result_array() as $row ) {
				$regex = $row['machine_category_regex'];
				
				if ( preg_match('/' . $regex . '/', $os_name) ) {
					return $row;
				}
			}
		}
		
		return false;
	}
}
