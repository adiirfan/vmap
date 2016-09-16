<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Listing.php');

class App_listing extends Listing {
	protected $_business_id = 0;
	
	protected $_concurrent_instances = array();
	
	public function init()
	{
		$show_business_column = (!$this->_business_id ? true : false);
		
		$db = $this->_CI->db;
		
		$db->select('apps.*');
		$db->from('apps');
		
		if ( $this->_business_id ) {
			$db->where('apps.business_id', $this->_business_id);
		} else {
			$db->select('businesses.business_name');
			$db->join('businesses', 'apps.business_id = businesses.business_id');
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
		);
		
		if ( $show_business_column ) {
			$columns += array(
				'business' => array(
					'label' => lang('business'),
					'field' => 'business_name',
					'sort' => true,
					'weight' => 2,
				),
			);
		}
		
		$columns += array(
			'license' => array(
				'label' => lang('app_license'),
				'field' => 'app_license_count',
				'sort' => true,
				'weight' => 2,
			),
			'concurrent' => array(
				'label' => lang('app_max_concurrent'),
				// 'field' => 'concurrent_instances',
				'sort' => false,
				'weight' => 2,
			),
			'this_week' => array(
				'label' => lang('app_this_week_instances'),
				// 'field' => 'this_week_instances',
				'sort' => false,
				'weight' => ($show_business_column ? 1 : 2),
			),
			'this_month' => array(
				'label' => lang('app_this_month_instances'),
				// 'field' => 'this_month_instances',
				'sort' => false,
				'weight' => ($show_business_column ? 1 : 2),
			),
			'utilization' => array(
				'label' => lang('app_utilization'),
				//'field' => 'concurrent_instances',
				'sort' => true,
				'sort_field' => 'concurrent_instances',
				'weight' => 1,
			),
			'blacklist' => array(
				'label' => lang('blacklist'),
				'field' => 'app_visible',
				'sort' => true,
				'weight' => 1,
			),
		);
		
		$this->set_columns($columns);
		$this->set_filters(array('keyword', 'status', 'business' => 'apps.business_id'));
		
		// Load the necessary template scripts.
		$this->_CI->template->set_css('!/css/bootstrap-toggle.min.css');
		$this->_CI->template->set_js('!/js/bootstrap-toggle.min.js');
	}
	
	public function set_business_id($business_id)
	{
		$this->_business_id = intval($business_id);
	}
	
	protected function _count_records($queries)
	{
		foreach ( $queries as $index => $line ) {
			if ( preg_match('/^FROM /', $line) ) {
				$queries = array_slice($queries, $index);
			}
		}
		
		$sql = implode(PHP_EOL, $queries);
		$sql = 'SELECT COUNT(*) AS total_records ' . $sql;
		$qry = $this->_CI->db->query($sql);
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			
			$this->_total_records = intval($row['total_records']);
		}
	}
	
	protected function _filter_keyword($db, $keyword)
	{
		$db->like('apps.app_sys_name', $keyword);
		$db->or_like('apps.app_friendly_name', $keyword);
		$db->or_like('apps.app_vendor', $keyword);
	}
	
	protected function _filter_status($db, $status)
	{
		if ( $status == 'blacklisted' ) {
			$db->where('apps.app_visible', 0);
		} else {
			$db->where('apps.app_visible', 1);
		}
	}
	
	protected function _format_app_name($index, $name, $row)
	{
		$app_id = $row['app_id'];
		$html = '<a href="' . site_url('app/detail/' . $app_id) . '">' . htmlentities($name) . '</a>';
		
		return $html;
	}
	
	protected function _format_blacklist($index, $visible, $row)
	{
		$app_id = $row['app_id'];
		
		$html = '<input type="checkbox"' . (!$visible ? ' checked="checked"' : '') . ' class="app-blacklist" data-toggle="toggle" data-off="' . lang('no') . '" data-on="' . lang('blacklist') . '" data-size="small" data-onstyle="danger" name="visible[' . $app_id . ']" value="1" data-app-id="' . $app_id . '" />';
		
		return $html;
	}
	
	protected function _format_concurrent($index, $null, $row)
	{
		$db = $this->_CI->db;
		$db->select('COUNT(*) AS concurrent_count');
		$db->from('app_sessions');
		$db->where('app_id', $row['app_id']);
		$db->group_by('app_session_starter_id');
		$db->order_by('concurrent_count', 'desc');
		$db->limit(1);
		
		$qry = $db->get();
		$concurrent_instances = 0;
		
		if ( $qry->num_rows() ) {
			$result = $qry->row();
			$concurrent_instances = intval($result->concurrent_count);
		}
		
		$this->_concurrent_instances[$row['app_id']] = $concurrent_instances;
		
		return $concurrent_instances;
	}
	
	protected function _format_license($index, $license)
	{
		$license = intval($license);
		
		if ( !$license ) {
			return 'n/a';
		} else {
			return $license;
		}
	}
	
	protected function _format_this_month($index, $null, $row)
	{
		$date_1 = date('Y-m-1');
		$date_2 = date('Y-m-t');
		$db = $this->_CI->db;
		
		$db->select('COUNT(*) AS instances');
		$db->from('app_sessions');
		$db->where('app_id', $row['app_id']);
		$db->where('DATE(app_start) BETWEEN "' . $date_1 . '" AND "' . $date_2 . '"');
		$qry = $db->get();
		
		if ( $qry->num_rows() ) {
			$result = $qry->row();
			
			return intval($result->instances);
		} else {
			return null;
		}
	}
	
	protected function _format_this_week($index, $null, $row)
	{
		$monday_time = strtotime('monday this week');
		$sunday_time = strtotime('sunday this week');
		$monday = date('Y-m-d', $monday_time);
		$sunday = date('Y-m-d', $sunday_time);
		$db = $this->_CI->db;
		
		$db->select('COUNT(*) AS instances');
		$db->from('app_sessions');
		$db->where('app_id', $row['app_id']);
		$db->where('DATE(app_start) BETWEEN "' . $monday . '" AND "' . $sunday . '"');
		$qry = $db->get();
		
		if ( $qry->num_rows() ) {
			$result = $qry->row();
			
			return intval($result->instances);
		} else {
			return null;
		}
	}
	
	protected function _format_utilization($index, $null, $row)
	{
		$license_count = intval($row['app_license_count']);
		
		if ( $license_count ) {
			$instances = array_ensure($this->_concurrent_instances, $row['app_id'], 0);
			$percentage = round($instances / $license_count * 100);
			
			return $percentage . '%';
		} else {
			return 'n/a';
		}
	}
}