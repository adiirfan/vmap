<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Listing.php');

class User_machine_listing extends Listing {
	protected $_user_id = 0;
	
	public function init()
	{
		if ( !$this->_user_id ) {
			show_error('Unable to show the machine login information without the user ID.', 500);
		}
		
		$db = $this->_CI->db;
		
		$db->select('machines.*,
			COUNT(*) AS total_login_sessions,
			MAX(user_sessions.user_session_start) AS last_login,
			SUM(IF(user_sessions.user_session_duration IS NULL, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(user_sessions.user_session_start), user_sessions.user_session_duration)) AS login_duration', false);
		$db->from('user_sessions');
		$db->join('machines', 'user_sessions.machine_id = machines.machine_id');
		$db->group_by('user_sessions.machine_id');
		$db->where(array(
			'machines.machine_visible' => 1,
			'user_sessions.user_id' => $this->_user_id,
		));
		
		if ( !$this->is_sort_applied() ) {
			$db->order_by('total_login_sessions', 'desc');
		}
		
		$columns = array(
			'machine_index' => array(
				'label' => '#',
				'weight' => 1,
			),
			'machine_name' => array(
				'label' => lang('machine_name'),
				'field' => 'machine_name',
				'sort' => true,
				'weight' => 3,
			),
			'total_login_sessions' => array(
				'label' => lang('logon_sessions'),
				'field' => 'total_login_sessions',
				'sort' => true,
				'weight' => 2,
			),
			'login_duration' => array(
				'label' => lang('login_duration'),
				'field' => 'login_duration',
				'sort' => true,
				'weight' => 3,
			),
			'last_login' => array(
				'label' => lang('last_login'),
				'field' => 'last_login',
				'sort' => true,
				'weight' => 3,
			),
		);
		
		$this->set_columns($columns);
	}
	
	public function get_user_id()
	{
		return $this->_user_id;
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
	
	protected function _format_machine_index($index)
	{
		return $index + 1;
	}
	
	protected function _format_last_login($index, $login_date)
	{
		return user_date($login_date, 'j/n/Y h:ia');
	}
	
	protected function _format_login_duration($index, $duration)
	{
		return parse_duration($duration);
	}
}