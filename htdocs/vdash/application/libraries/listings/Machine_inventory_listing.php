<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Listing.php');

class Machine_inventory_listing extends Listing {
	
	protected $_business_id = 0;
	
	public function init()
	{
		$db = $this->_CI->db;
		
		$db->from('machines');
		$db->join('machine_groups', 'machines.machine_group_id = machine_groups.machine_group_id', 'left');
		
		if ( $this->_business_id ) {
			$db->where('machines.business_id', $this->_business_id);
		}
		
		if ( !$this->is_sort_applied() ) {
			$db->order_by('machines.machine_name', 'asc');
		}
		
		$columns = array(
			'machine_name' => array(
				'label' => lang('machine_name'),
				'field' => 'machine_name',
				'sort' => true,
				'weight' => 2,
			),
			'serial_number' => array(
				'label' => lang('machine_serial_number'),
				'field' => 'machine_serial_number',
				'sort' => true,
				'weight' => 1,
			),
			'mac_address' => array(
				'label' => lang('machine_mac_address'),
				'field' => 'machine_mac_address',
				'sort' => true,
				'weight' => 2,
			),
			'model' => array(
				'label' => lang('machine_model'),
				'field' => 'machine_model',
				'sort' => true,
				'weight' => 1,
			),
			'os' => array(
				'label' => lang('machine_os'),
				'field' => 'machine_os_name',
				'sort' => true,
				'weight' => 1,
			),
			'group' => array(
				'label' => lang('machine_group'),
				'field' => 'machine_group_name',
				'sort' => true,
				'weight' => 1,
			),
			'year' => array(
				'label' => lang('machine_year'),
				'field' => 'machine_year',
				'sort' => true,
				'weight' => 1,
			),
			'year_expiry' => array(
				'label' => lang('machine_year_expired'),
				'field' => 'machine_support_expiry',
				'sort' => true,
				'weight' => 1,
			),
			'status' => array(
				'label' => lang('machine_condition'),
				'field' => 'machine_physical_status',
				'sort' => true,
				'weight' => 1,
			),
			'actions' => array(
				'label' => lang('actions'),
				'weight' => 1,
			),
		);
		
		$this->set_columns($columns);
		$this->set_filter('keyword');
		
		if ( !$this->_business_id ) {
			$this->set_filter('business', 'machines.business_id');
		}
	}
	
	public function set_business_id($business_id)
	{
		$this->_business_id = intval($business_id);
	}
	
	protected function _filter_keyword($db, $keyword)
	{
		$db->like('machines.machine_name', $keyword);
		$db->or_like('machines.machine_mac_address', $keyword);
		$db->or_like('machines.machine_ip_address', $keyword);
		$db->or_like('machines.machine_os_name', $keyword);
		$db->or_like('machines.machine_default_name', $keyword);
		$db->or_like('machines.machine_name', $keyword);
		$db->or_like('machines.machine_model', $keyword);
		$db->or_like('machines.machine_processor', $keyword);
		$db->or_like('machines.machine_year', $keyword);
		$db->or_like('machines.machine_support_expiry', $keyword);
		$db->or_like('machines.machine_physical_status', $keyword);
	}
	
	protected function _format_actions($index, $null, $row)
	{
		$machine_id = $row['machine_id'];
		$html = '<button class="btn btn-danger btn-sm clear-info" data-machine-id="' . $machine_id . '"><i class="fa fa-times"></i> ' . lang('clear_info') . '</button>';
		
		return $html;
	}
	
	protected function _format_group($index, $value)
	{
		if ( is_empty($value) ) {
			return 'n/a';
		} else {
			return '<span class="reset-field">' . htmlentities($value) . '</span>';
		}
	}
	
	protected function _format_machine_name($index, $name, $row)
	{
		$machine_id = $row['machine_id'];
		$html = '<strong><a href="' . site_url('machine/inv_detail/' . $machine_id) . '" class="machine-default-name">' . htmlentities($name) . '</a></strong><br />';
		$html .= '<span class="small">(' . _lang('_default_name', $row['machine_default_name']) . ')</span>';
		
		return $html;
	}
	
	protected function _format_model($index, $value)
	{
		if ( is_empty($value) ) {
			return 'n/a';
		} else {
			return '<span class="reset-field">' . htmlentities($value) . '</span>';
		}
	}
	
	protected function _format_serial_number($index, $value)
	{
		if ( is_empty($value) ) {
			return 'n/a';
		} else {
			return '<span class="reset-field">' . htmlentities($value) . '</span>';
		}
	}
	
	protected function _format_status($index, $value)
	{
		if ( is_empty($value) ) {
			return 'n/a';
		} else {
			return '<span class="reset-field">' . htmlentities($value) . '</span>';
		}
	}
	
	protected function _format_year($index, $value)
	{
		if ( is_empty($value) ) {
			return 'n/a';
		} else {
			return '<span class="reset-field">' . htmlentities($value) . '</span>';
		}
	}
	
	protected function _format_year_expiry($index, $value)
	{
		if ( is_empty($value) ) {
			return 'n/a';
		} else {
			return '<span class="reset-field">' . htmlentities($value) . '</span>';
		}
	}
}