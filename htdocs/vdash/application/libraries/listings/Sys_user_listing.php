<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Listing.php');

class Sys_user_listing extends Listing {
	/**
	 * The user listing type. Available options:
	 * + all
	 * + superadmin
	 * + business
	 * + admin
	 * + viewer
	 * 
	 * @var string
	 */
	protected $_listing_type = 'all';
	
	public function init()
	{
		$db = $this->_CI->db;
		
		$db->from('sys_users');
		$db->join('businesses', 'sys_users.business_id = businesses.business_id', 'left');
		
		if ( $this->_listing_type != 'all' ) {
			if ( $this->_listing_type == 'business' ) {
				$db->where('sys_users.business_id IS NOT NULL');
			} else {
				$db->where('sys_user_type', $this->_listing_type);
			}
		}
		
		$columns = array(
			'name' => array(
				'label' => lang('name'),
				'field' => 'sys_user_name',
				'sort' => true,
				'weight' => 2,
			),
			'email' => array(
				'label' => lang('email'),
				'field' => 'sys_user_email',
				'sort' => true,
				'weight' => 2,
			),
			'business' => array(
				'label' => lang('business'),
				'field' => 'business_name',
				'sort' => true,
				'weight' => 1,
			),
			'phone' => array(
				'label' => lang('phone'),
				'field' => 'sys_user_phone',
				'sort' => true,
				'weight' => 1,
			),
			'mobile' => array(
				'label' => lang('mobile'),
				'field' => 'sys_user_mobile',
				'sort' => true,
				'weight' => 1,
			),
			'type' => array(
				'label' => lang('user_type'),
				'field' => 'sys_user_type',
				'sort' => true,
				'weight' => 1,
			),
			'last_login' => array(
				'label' => lang('last_login'),
				'field' => 'sys_user_last_login',
				'sort' => true,
				'weight' => 2,
			),
			'status' => array(
				'label' => lang('status'),
				'field' => 'sys_user_valid',
				'sort' => true,
				'weight' => 2,
			),
		);
		
		if ( $this->_listing_type != 'business' && $this->_listing_type != 'all' ) {
			unset($columns['type']);
		}
		
		if ( $this->_listing_type == 'superadmin' ) {
			unset($columns['business']);
		}
		
		$this->set_columns($columns);
		$this->set_filter('keyword');
	}
	
	public function get_listing_type($listing_type)
	{
		return $this->_listing_type;
	}
	
	public function set_listing_type($listing_type)
	{
		$this->_listing_type = $listing_type;
	}
	
	protected function _filter_keyword($db, $value)
	{
		$db->like('sys_user_name', $value);
		$db->or_like('sys_user_email', $value);
		$db->or_like('sys_user_phone', $value);
		$db->or_like('sys_user_mobile', $value);
		$db->or_like('sys_user_remark', $value);
	}
	
	protected function _format_business($index, $value)
	{
		if ( is_empty($value) ) {
			return '-';
		} else {
			return htmlentities($value);
		}
	}
	
	protected function _format_mobile($index, $value)
	{
		if ( is_empty($value) ) {
			return '-';
		} else {
			return $value;
		}
	}
	
	protected function _format_name($index, $value, $row)
	{
		$sys_user_id = $row['sys_user_id'];
		$url = site_url('sys_user/profile/' . $sys_user_id);
		$anchor = '<a href="' . $url . '">' . $value . '</a>';
		
		return $anchor;
	}
	
	protected function _format_phone($index, $value)
	{
		if ( is_empty($value) ) {
			return '-';
		} else {
			return $value;
		}
	}
	
	protected function _format_status($index, $status)
	{
		if ( $status ) {
			return '<span class="label label-success">' . lang('active') . '</span>';
		} else {
			return '<span class="label label-danger">' . lang('inactive') . '</span>';
		}
	}
}