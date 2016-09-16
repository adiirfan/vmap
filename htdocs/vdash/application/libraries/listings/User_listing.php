<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Listing.php');

class User_listing extends Listing {
	/**
	 * The business ID of this user listing. If specified, it will
	 * only shows the users under this specific business.
	 * User will not given the choice to switch to other business
	 * users.
	 * For superadmin user, leave it as default.
	 * 
	 * @var int
	 */
	protected $_business_id = 0;
	
	public function init()
	{
		$db = $this->_CI->db;
		
		$db->select('users.*, businesses.*, (
			SELECT MAX(user_sessions.user_session_start)
			FROM user_sessions
			WHERE user_sessions.user_id = users.user_id
		) AS last_logged_in, (
			SELECT SUM(user_sessions.user_session_duration)
			FROM user_sessions
			WHERE user_sessions.user_id = users.user_id AND
				user_sessions.user_session_duration IS NOT NULL
		) AS usage_duration');
		$db->from('users');
		// $db->join('user_groups', 'users.user_group_id = user_groups.user_group_id', 'left');
		$db->join('businesses', 'users.business_id = businesses.business_id');
		
		if ( $this->_business_id ) {
			$db->where('users.business_id', $this->_business_id);
		}
		
		// Default sorting.
		if ( !$this->is_sort_applied() ) {
			$db->order_by('users.user_name', 'asc');
		}
		
		$columns = array(
			'username' => array(
				'label' => lang('user_name'),
				'field' => 'user_name',
				'sort' => true,
				'weight' => 2,
			),
		);
		
		if ( !$this->_business_id ) {
			$columns['business'] = array(
				'label' => lang('business'),
				'field' => 'business_name',
				'sort' => true,
				'weight' => 2,
			);
		}
		
		$columns = array_merge($columns, array(
			'domain' => array(
				'label' => lang('user_domain'),
				'field' => 'user_domain',
				'sort' => true,
				'weight' => 2,
			),
			'group' => array(
				'label' => lang('user_ad_group'),
				'field' => 'user_ad_group',
				'sort' => true,
				'weight' => 1,
			),
			'last_logged_in' => array(
				'label' => lang('user_last_logged_in'),
				'field' => 'last_logged_in',
				'sort' => true,
				'weight' => ($this->_business_id ? 3 : 2),
			),
			'usage' => array(
				'label' => lang('usage_duration'),
				'field' => 'usage_duration',
				'sort' => true,
				'weight' => 1,
			),
			'status' => array(
				'label' => lang('user_status'),
				'field' => 'user_status',
				'sort' => true,
				'weight' => 1,
			),
			'blacklist' => array(
				'label' => lang('blacklist'),
				'field' => 'user_visible',
				'sort' => true,
				'weight' => 1,
			),
		));
		
		$this->set_columns($columns);
		
		// Initialize filter columns.
		$this->set_filters(array(
			'keyword', 'status', 'business' => 'users.business_id'
		));
		
		// Load the necessary template scripts.
		$this->_CI->template->set_css('!/css/bootstrap-toggle.min.css');
		$this->_CI->template->set_js('!/js/bootstrap-toggle.min.js');
	}
	
	public function get_business_id()
	{
		return $this->_business_id;
	}
	
	public function set_business_id($business_id)
	{
		$this->_business_id = intval($business_id);
	}
	
	protected function _count_records($queries)
	{
		foreach ( $queries as $index => $line ) {
			if ( preg_match('/^FROM `users`/', $line) ) {
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
		$db->like('users.user_name', $keyword);
		$db->or_like('businesses.business_name', $keyword);
		$db->or_like('users.user_domain', $keyword);
		$db->or_like('users.user_ad_group', $keyword);
	}
	
	protected function _filter_status($db, $status)
	{
		if ( $status == 'online' || $status == 'offline' ) {
			$db->where('users.user_status', $status);
		} else if ( $status == 'blacklisted' || $status == 'whitelisted' ) {
			if ( $status == 'blacklisted' ) {
				$db->where('users.user_visible', 0);
			} else {
				$db->where('users.user_visible', 1);
			}
		}
	}
	
	protected function _format_blacklist($index, $visible, $row)
	{
		$user_id = $row['user_id'];
		
		$html = '<input type="checkbox"' . (!$visible ? ' checked="checked"' : '') . ' class="user-blacklist" data-toggle="toggle" data-off="' . lang('no') . '" data-on="' . lang('blacklist') . '" data-size="small" data-onstyle="danger" name="visible[' . $user_id . ']" value="1" data-user-id="' . $user_id . '" />';
		
		return $html;
	}
	
	protected function _format_group($index, $group_name)
	{
		if ( is_empty($group_name) ) {
			return 'n/a';
		} else {
			return str_truncate($group_name, 30);
		}
	}
	
	protected function _format_last_logged_in($index, $date)
	{
		if ( is_empty($date) ) {
			return 'n/a';
		} else {
			return user_date($date, 'j/n/Y g:ia');
		}
	}
	
	protected function _format_status($index, $status)
	{
		$html = '';
		
		if ( $status == 'offline' ) {
			$html = '<span class="label label-danger label-sm">' . lang('user_status_' . $status) . '</span>';
		} else {
			$html = '<span class="label label-success label-sm">' . lang('user_status_' . $status) . '</span>';
		}
		
		return $html;
	}
	
	protected function _format_usage($index, $seconds, $row)
	{
		if ( $seconds > 0 ) {
			return parse_duration($seconds);
		} else {
			return 'n/a';
		}
	}
	
	protected function _format_username($index, $username, $row)
	{
		$user_id = $row['user_id'];
		$html = '<a href="' . site_url('user/detail/' . $user_id) . '">' . $username . '</a>';
		
		return $html;
	}
}