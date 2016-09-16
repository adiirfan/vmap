<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Listing.php');

class Machine_group_app_listing extends Listing {
	protected $_machine_group_id = 0;
	
	public function init()
	{
		$db = $this->_CI->db;
		
		$db->select('apps.*, COUNT(*) AS total_instances, MAX(app_sessions.app_start) AS last_used_date');
		$db->from('app_sessions');
		$db->join('apps', 'app_sessions.app_id = apps.app_id');
		$db->join('user_sessions', 'app_sessions.user_session_id = user_sessions.user_session_id');
		$db->join('users', 'user_sessions.user_id = users.user_id');
		$db->join('machines', 'user_sessions.machine_id = machines.machine_id');
		$db->where(array(
			'apps.app_visible' => 1,
			'machines.machine_group_id' => $this->_machine_group_id,
			'users.user_visible' => 1,
		));
		$db->group_by('app_sessions.app_id');
		
		if ( !$this->is_sort_applied() ) {
			$db->order_by('total_instances', 'desc');
		}
		
		$columns = array(
			'index' => array(
				'label' => '#',
				'weight' => 1,
			),
			'user_name' => array(
				'label' => lang('app_name'),
				'field' => 'app_friendly_name',
				'sort' => true,
				'weight' => 4,
			),
			'sessions' => array(
				'label' => lang('instances'),
				'field' => 'total_instances',
				'sort' => true,
				'weight' => 3,
			),
			'last_login' => array(
				'label' => lang('last_login'),
				'field' => 'last_used_date',
				'sort' => true,
				'weight' => 4,
			),
		);
		
		$this->set_columns($columns);
	}
	
	public function set_machine_group_id($machine_group_id)
	{
		$this->_machine_group_id = intval($machine_group_id);
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
	
	protected function _format_index($index)
	{
		return $index + 1;
	}
	
	protected function _format_last_login($index, $date)
	{
		return user_date($date, 'j/n/Y H:i:s');
	}
}