<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Listing.php');

class App_inventory_listing extends Listing {
	
	protected $_business_id = 0;
	
	public function init()
	{
		$db = $this->_CI->db;
		
		$db->from('apps');
		
		if ( $this->_business_id ) {
			$db->where('apps.business_id', $this->_business_id);
		}
		
		if ( !$this->is_sort_applied() ) {
			$db->order_by('apps.app_friendly_name', 'asc');
		}
		
		$columns = array(
			'app_name' => array(
				'label' => lang('app_name'),
				'field' => 'app_friendly_name',
				'sort' => true,
				'weight' => 2,
			),
			'license_type' => array(
				'label' => lang('app_license_type'),
				'field' => 'app_license_type',
				'sort' => true,
				'weight' => 1,
			),
			'license_count' => array(
				'label' => lang('app_license_number'),
				'field' => 'app_license_count',
				'sort' => true,
				'weight' => 1,
			),
			'app_version' => array(
				'label' => lang('app_version'),
				'field' => 'app_version',
				'sort' => true,
				'weight' => 1,
			),
			'app_vendor' => array(
				'label' => lang('app_vendor'),
				'field' => 'app_vendor',
				'sort' => true,
				'weight' => 1,
			),
			'purchase_date' => array(
				'label' => lang('app_purchase_date'),
				'field' => 'app_purchase_date',
				'sort' => true,
				'weight' => 1,
			),
			'expiry_date' => array(
				'label' => lang('app_expiry_date'),
				'field' => 'app_expiry_date',
				'sort' => true,
				'weight' => 2,
			),
			'app_virtualized' => array(
				'label' => lang('app_virtualized'),
				'field' => 'app_virtualized',
				'sort' => true,
				'weight' => 1,
			),
			'actions' => array(
				'label' => lang('actions'),
				'weight' => 2,
			),
		);
		
		$this->set_columns($columns);
		$this->set_filter('keyword');
		
		if ( !$this->_business_id ) {
			$this->set_filter('business', 'business_id');
		}
	}
	
	public function set_business_id($business_id)
	{
		$this->_business_id = intval($business_id);
	}
	
	protected function _filter_keyword($db, $keyword)
	{
		$db->like('app_sys_name', $keyword);
		$db->or_like('app_friendly_name', $keyword);
		$db->or_like('app_license_count', $keyword);
		$db->or_like('app_version', $keyword);
		$db->or_like('app_license_type', $keyword);
		$db->or_like('app_vendor', $keyword);
		$db->or_like('app_purchase_date', $keyword);
		$db->or_like('app_expiry_date', $keyword);
		$db->or_like('app_virtualized', $keyword);
	}
	
	protected function _format_actions($index, $null, $row)
	{
		$html = '<a href="' . site_url('app/inv_detail/' . $row['app_id']) . '" class="btn btn-primary btn-sm"><i class="fa fa-list"></i> ' . lang('view') . '</a> ';
		$html .= '<a href="' . site_url('app/a_clear_inv?app_id=' . $row['app_id']) . '" class="btn btn-danger btn-sm clear-info"><i class="fa fa-times"></i> ' . lang('clear_info') . '</a>';
		
		return $html;
	}
	
	protected function _format_app_name($index, $app_name, $row)
	{
		$sys_name = $row['app_sys_name'];
		$html = '<strong>' . htmlentities($app_name) . '</strong><br />';
		$html .= '<span class="small">' . htmlentities($sys_name) . '</span>';
		
		return $html;
	}
	
	protected function _format_app_vendor($index, $value, $row)
	{
		if ( is_empty($value) ) {
			return 'n/a';
		} else {
			return trim($value);
		}
	}
	
	protected function _format_app_version($index, $value, $row)
	{
		if ( is_empty($value) ) {
			return 'n/a';
		} else {
			return trim($value);
		}
	}
	
	protected function _format_expiry_date($index, $value, $row)
	{
		if ( is_empty($value) ) {
			return 'n/a';
		} else {
			return trim($value);
		}
	}
	
	protected function _format_license_count($index, $count)
	{
		$count = intval($count);
		
		if ( !$count ) {
			return 'n/a';
		} else {
			return $count;
		}
	}
	
	protected function _format_license_type($index, $license_type, $row)
	{
		if ( is_empty($license_type) ) {
			return 'n/a';
		} else {
			return trim($license_type);
		}
	}
	
	protected function _format_purchase_date($index, $value, $row)
	{
		if ( is_empty($value) ) {
			return 'n/a';
		} else {
			return trim($value);
		}
	}
	
	protected function _format_app_virtualized($index, $value, $row)
	{
		if ( is_empty($value) ) {
			return 'n/a';
		} else {
			return trim($value);
		}
	}
}