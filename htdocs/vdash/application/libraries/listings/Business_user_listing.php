<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Listing.php');

class Business_user_listing extends Listing {
	protected $_business_id = 0;
	
	public function init()
	{
		if ( !$this->_business_id ) {
			show_error('No business id specified.', 500);
		}
		
		$db = $this->_CI->db;
		
		$db->from('sys_users');
		$db->where('business_id', $this->_business_id);
		
		if ( !$this->is_sort_applied() ) {
			$db->order_by('sys_user_name', 'asc');
		}
		
		$columns = array(
			'id' => array(
				'label' => 'ID',
				'field' => 'sys_user_id',
				'sort' => true,
				'weight' => 1,
			),
			'name' => array(
				'label' => lang('user_name'),
				'field' => 'sys_user_name',
				'sort' => true,
				'weight' => 4,
			),
			'email' => array(
				'label' => lang('email'),
				'field' => 'sys_user_email',
				'sort' => true,
				'weight' => 4,
			),
			'type' => array(
				'label' => lang('user_type'),
				'field' => 'sys_user_type',
				'sort' => true,
				'weight' =>3,
			),
		);
		
		$this->set_columns($columns);
	}
	
	public function set_business_id($business_id)
	{
		$this->_business_id = intval($business_id);
	}
	
	protected function _format_type($index, $user_type)
	{
		return lang('user_type_' . $user_type);
	}
}