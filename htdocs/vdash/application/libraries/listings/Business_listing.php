<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Listing.php');

class Business_listing extends Listing {
	public function init()
	{
		$db = $this->_CI->db;
		
		$db->from('businesses');
		
		if ( !$this->is_sort_applied() ) {
			$db->order_by('business_name', 'asc');
		}
		
		$columns = array(
			'name' => array(
				'label' => lang('business_name'),
				'field' => 'business_name',
				'sort' => true,
				'weight' => 2,
			),
			'code' => array(
				'label' => lang('business_code'),
				'field' => 'business_code',
				'sort' => true,
				'weight' => 1,
			),
			'domain' => array(
				'label' => lang('business_domain'),
				'field' => 'business_site_domain',
				'sort' => true,
				'weight' => 2,
			),
			'phone' => array(
				'label' => lang('business_phone'),
				'field' => 'business_phone',
				'sort' => true,
				'weight' => 1,
			),
			'fax' => array(
				'label' => lang('business_fax'),
				'field' => 'business_fax',
				'sort' => true,
				'weight' => 1,
			),
			'email' => array(
				'label' => lang('business_email'),
				'field' => 'business_email',
				'sort' => true,
				'weight' => 2,
			),
			'max_agents' => array(
				'label' => lang('business_max_agents'),
				'field' => 'business_max_agent',
				'sort' => true,
				'weight' => 1,
			),
			'connected_agents' => array(
				'label' => lang('connected_agents'),
				'field' => 'business_connected_agent',
				'sort' => true,
				'weight' => 2,
			),
		);
		
		$this->set_columns($columns);
		$this->set_filter('keyword');
	}
	
	protected function _filter_keyword($db, $value)
	{
		$db->like('business_name', $value);
		$db->or_like('business_code', $value);
	}
	
	protected function _format_connected_agents($index, $value)
	{
		return intval($value);
	}
	
	protected function _format_max_agents($index, $value)
	{
		if ( $value <= 0 ) {
			return 'n/a';
		} else {
			return intval($value);
		}
	}
	
	protected function _format_name($index, $value, $row)
	{
		$business_id = $row['business_id'];
		$url = site_url('business/profile/' . $business_id);
		$anchor = '<a href="' . $url . '">' . htmlentities($value) . '</a>';
		
		return $anchor;
	}
}