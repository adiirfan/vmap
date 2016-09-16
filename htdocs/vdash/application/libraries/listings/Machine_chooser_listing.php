<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Listing.php');

class Machine_chooser_listing extends Listing {
	
	protected $_business_id = 0;
	
	protected $_machine_group_id = 0;
	
	public function init()
	{
		$db = $this->_CI->db;
		
		if ( $this->_business_id ) {
			// Show those unchoose machines.
			$db->from('machines');
			$db->where(array(
				'business_id' => $this->_business_id,
				'machine_group_id' => null,
			));
		} else if ( $this->_machine_group_id ) {
			// Show those chosen machines.
			$db->from('machines');
			$db->where('machine_group_id', $this->_machine_group_id);
		} else {
			show_error('Unable to generate result.', 500);
		}
		
		if ( !$this->is_sort_applied() ) {
			$db->order_by('machine_name', 'asc');
		}
		
		$this->set_filter('keyword');
	}
	
	public function set_business_id($business_id)
	{
		$this->_business_id = intval($business_id);
	}
	
	public function set_machine_group_id($mg_id)
	{
		$this->_machine_group_id = intval($mg_id);
	}
	
	protected function _filter_keyword($db, $value)
	{
		$db->like('machine_name', $value);
		$db->or_like('machine_ip_address', $value, 'after');
		$db->or_like('machine_mac_address', $value, 'after');
	}
}