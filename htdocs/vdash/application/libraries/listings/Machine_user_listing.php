<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Listing.php');

class Machine_user_listing extends Listing {
	protected $_machine_id = 0;
	
	public function init()
	{
		$db = $this->_CI->db;
		
		$db->select('users.*, COUNT(*) AS total_sessions, MAX(user_sessions.user_session_start) AS last_login_date');
		$db->from('user_sessions');
		$db->join('users', 'user_sessions.user_id = users.user_id');
		$db->where('user_sessions.machine_id', $this->_machine_id);
		$db->where('users.user_visible', 1);
		$db->group_by('user_sessions.user_id');
		
		if ( !$this->is_sort_applied() ) {
			$db->order_by('total_sessions', 'desc');
		}
		
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
			'sessions' => array(
				'label' => lang('sessions'),
				'field' => 'total_sessions',
				'sort' => true,
				'weight' => 3,
			),
			'last_login' => array(
				'label' => lang('last_login'),
				'field' => 'last_login_date',
				'sort' => true,
				'weight' => 4,
			),
		);
		
		$this->set_columns($columns);
	}
	
	public function set_machine_id($machine_id)
	{
		$this->_machine_id = intval($machine_id);
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