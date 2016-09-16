<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Listing.php');

class App_user_listing extends Listing {
	protected $_app_id = 0;
	
	public function init()
	{
		if ( !$this->_app_id ) {
			show_error('Unable to proceed the machine listing without the application ID.', 500);
		}
		
		$db = $this->_CI->db;
		
		$db->select('users.*, COUNT(*) AS total_instances, MAX(app_sessions.app_start) AS last_used');
		$db->from('app_sessions');
		$db->join('user_sessions', 'app_sessions.user_session_id = user_sessions.user_session_id');
		$db->join('users', 'user_sessions.user_id = users.user_id');
		$db->group_by('user_sessions.user_id');
		$db->where(array(
			'app_sessions.app_id' => $this->_app_id,
			'users.user_visible' => 1,
		));
		
		$columns = array(
			'index' => array(
				'label' => '#',
				'weight' => 1,
			),
			'user_name' => array(
				'label' => lang('user_name'),
				'field' => 'user_name',
				'sort' => true,
				'weight' => 4,
			),
			'machine_instances' => array(
				'label' => lang('instances'),
				'field' => 'total_instances',
				'sort' => true,
				'weight' => 3,
			),
			'machine_last_used' => array(
				'label' => lang('app_last_used'),
				'field' => 'last_used',
				'sort' => true,
				'weight' => 4,
			),
		);
		
		$this->set_columns($columns);
	}
	
	public function set_app_id($app_id)
	{
		$this->_app_id = intval($app_id);
	}
	
	protected function _count_records($queries)
	{
		$sql = implode(PHP_EOL, $queries);
		$sql = 'SELECT COUNT(*) AS total_records FROM (' . $sql . ') tbl_1';
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
}