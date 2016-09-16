<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Listing.php');

class User_app_listing extends Listing {
	protected $_user_id = 0;
	
	public function init()
	{
		if ( !$this->_user_id ) {
			show_error('Unable to show the application usage information without the user ID.', 500);
		}
		
		$db = $this->_CI->db;
		
		$db->select('apps.*,
			COUNT(*) AS total_instances,
			MAX(app_sessions.app_start) AS last_launch,
			SUM(IF(app_sessions.app_duration IS NULL, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(app_sessions.app_start), app_sessions.app_duration)) AS usage_duration', false);
		$db->from('app_sessions');
		$db->join('apps', 'app_sessions.app_id = apps.app_id');
		$db->join('user_sessions', 'app_sessions.user_session_id = user_sessions.user_session_id');
		$db->where(array(
			'user_sessions.user_id' => $this->_user_id,
			'apps.app_visible' => 1,
		));
		$db->group_by('app_sessions.app_id');
		
		if ( !$this->is_sort_applied() ) {
			$db->order_by('total_instances', 'desc');
		}
		
		$columns = array(
			'app_index' => array(
				'label' => '#',
				'weight' => 1,
			),
			'app_name' => array(
				'label' => lang('app_name'),
				'field' => 'app_friendly_name',
				'sort' => true,
				'weight' => 3,
			),
			'instances' => array(
				'label' => lang('instances'),
				'field' => 'total_instances',
				'sort' => true,
				'weight' => 2,
			),
			'duration' => array(
				'label' => lang('duration'),
				'field' => 'usage_duration',
				'sort' => true,
				'weight' => 3,
			),
			'last_launch' => array(
				'label' => lang('last_launched'),
				'field' => 'last_launch',
				'sort' => true,
				'weight' => 3,
			),
		);
		
		$this->set_columns($columns);
	}
	
	public function set_user_id($user_id)
	{
		$this->_user_id = intval($user_id);
	}
	
	protected function _count_records($queries)
	{
		$sql = implode(PHP_EOL, $queries);
		$sql = 'SELECT COUNT(*) AS total_records FROM (' . $sql . ') tbl';
		$qry = $this->_CI->db->query($sql);
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			
			$this->_total_records = intval($row['total_records']);
		}
	}
	
	protected function _format_app_index($index)
	{
		return $index + 1;
	}
}