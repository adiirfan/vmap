<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( !function_exists('parse_duration') ) {
	function parse_duration($etime)
	{
		if ($etime < 1)
		{
			return '0 ' . lang('second');
		}
		
		$a = array( 365 * 24 * 60 * 60  =>  'year',
			30 * 24 * 60 * 60  =>  'month',
			24 * 60 * 60  =>  'day',
			60 * 60  =>  'hour',
			60  =>  'minute',
			1  =>  'second'
		);
		$a_plural = array(
			'year'   => 'years',
			'month'  => 'months',
			'day'    => 'days',
			'hour'   => 'hours',
			'minute' => 'minutes',
			'second' => 'seconds'
		);
		
		foreach ($a as $secs => $str)
		{
			$d = $etime / $secs;
			if ($d >= 1)
			{
				$r = round($d);
				$unit = ($r > 1 ? $a_plural[$str] : $str);
				$unit_name = strtolower(lang($unit));
				
				return $r . ' ' . $unit_name;
			}
		}
	}
}

if ( !function_exists('parse_machine_group') ) {
	/**
	 * This function will decode the string provided by the
	 * machine group drop down to array.
	 * 
	 * @param string $machine_group
	 * @return array
	 */
	function parse_machine_group($machine_group)
	{
		$type = '';
		$id = 0;
		$b_id = 0;
		
		$CI =& get_instance();
		$db = clone $CI->db;
		$db->reset_query();
		$sys_user_model = $CI->authentication->get_model();
		
		if ( !$sys_user_model ) {
			return false;
		}
		
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		
		if ( !is_empty($machine_group) && preg_match('/^([A-Z])\:(\d+)$/', $machine_group, $matches) ) {
			$type = $matches[1];
			$id = intval($matches[2]);
				
			if ( $type == 'B' ) {
				$type = 'business';
				$b_id = $id;
			} else if ( $type == 'G' ) {
				$type = 'machine_group';
				
				// Find the business ID from the machine group's ID.
				$db->select('business_id');
				$db->from('machine_groups');
				$db->where('machine_group_id', $id);
				$qry = $db->get();
				
				if ( $qry->num_rows() ) {
					$row = $qry->row_array();
						
					$b_id = intval($row['business_id']);
				}
			}
				
			if ( $sys_user_type != 'superadmin' ) {
				$business_model = $sys_user_model->get_business_model();
				$business_id = $business_model->get_value('business_id');
				
				// Make sure it's not business type and the machine group is under the business.
				if ( $type == 'business' || is_empty($type) ) {
					$type = '';
					$b_id = $business_model->get_value('business_id');
				} else if ( $type == 'machine_group') {
					// Check if the machine group is belongs to this user's business ID.
					
					$db->from('machine_groups');
					$db->where(array(
						'business_id' => $business_id,
						'machine_group_id' => $id,
					));
						
					$qry = $db->get();
						
					if ( !$qry->num_rows() ) {
						$type = '';
						$id = 0;
					}
				}
			}
		}
		
		return array(
			'type' => $type,
			'id' => $id,
			'business_id' => $b_id,
		);
	}
}

if ( !function_exists('filter_date_range') ) {
	/**
	 * Convert the date passed from the date range input to
	 * the desired format output. By default, it convert to
	 * mysql standard date format.
	 * 
	 * @param string $filter_date
	 * @param string optional $start_date
	 * @param string optional $end_date
	 * @return boolean
	 */
	function filter_date_range($filter_date, &$start_date = '', &$end_date = '', $format = 'Y-m-d')
	{
		if ( !is_empty($filter_date) && preg_match('/([^ ]+) \- ([^ ]+)/', $filter_date, $matches) ) {
			$data['start_date'] = trim($matches[1]);
			$data['end_date'] = trim($matches[2]);
				
			$start_date = date($format, strtotime(str_replace('/', '-', $data['start_date'])));
			$end_date = date($format, strtotime(str_replace('/', '-', $data['end_date'])));
			
			return true;
		} else {
			return false;
		}
	}
}

if ( !function_exists('filter_mac_address') ) {
	function filter_mac_address($mac_address)
	{
		$mac_address = preg_replace('/[:\-]/', '', $mac_address);
		$mac_address = trim($mac_address);
		
		return $mac_address;
	}
}

if ( !function_exists('friendly_appname') ) {
	/**
	 * This function return the friendly application name
	 * based on the system app name.
	 *
	 * @return string
	 */
	function friendly_appname($app_name)
	{
		$CI =& get_instance();
		$db = $CI->db;
		
		$qry = $db->get_where('app_names', array(
			'app_system_name' => $app_name,
		));
	
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
	
			return array_ensure($row, 'app_friendly_name', $app_name);
		} else {
			return $app_name;
		}
	}
}

if ( !function_exists('get_machine_group_option_list') ) {
	/**
	 * This function will prepare the list of machine groups for
	 * the user to choose from. It will based on the user credential
	 * to return the array list.
	 * 
	 * @return array
	 */
	function get_machine_group_option_list()
	{
		$CI =& get_instance();
		$sys_user_model = $CI->authentication->get_model();
		$db = $CI->db;
		
		if ( !$sys_user_model ) {
			return false;
		}
		
		$sys_user_type = $sys_user_model->get_value('sys_user_type');
		
		$machine_groups = array();
		
		if ( $sys_user_type == 'superadmin' ) {
			// Retrieve all business name and their machine group.
			$db->from('businesses');
			$db->order_by('business_name', 'asc');
			$qry = $db->get();
				
			if ( $qry->num_rows() ) {
				foreach ( $qry->result_array() as $row ) {
					$business_id = $row['business_id'];
					$business_name = $row['business_name'];
					$business_value = 'B:' . $business_id;
						
					$machine_groups[$business_value] = $business_name;
						
					// Find the machine groups under this business.
					$db->from('machine_groups');
					$db->where('business_id', $business_id);
					$db->order_by('machine_group_order', 'asc');
						
					$sub_qry = $db->get();
						
					if ( $sub_qry->num_rows() ) {
						foreach ( $sub_qry->result_array() as $machine_group_row ) {
							$mg_id = $machine_group_row['machine_group_id'];
							$mg_name = $machine_group_row['machine_group_name'];
							$mg_value = 'G:' . $mg_id;
								
							$machine_groups[$mg_value] = '- ' . $mg_name;
						}
					}
				}
			}
		} else {
			$business_id = $sys_user_model->get_value('business_id');
			
			// Retrieve all machine groups for this business user.
			$db->from('machine_groups');
			$db->where('business_id', $business_id);
			$db->order_by('machine_group_order', 'asc');
				
			$qry = $db->get();
				
			if ( $qry->num_rows() ) {
				foreach ( $qry->result_array() as $row ) {
					$mg_id = $row['machine_group_id'];
					$mg_name = $row['machine_group_name'];
					$mg_value = 'G:' . $mg_id;
						
					$machine_groups[$mg_value] = $mg_name;
				}
			}
		}
		
		return $machine_groups;
	}
}

if ( !function_exists('get_max_concurrent_user_sessions') ) {
	/**
	 * This function return the maximum concurrent sessions within time
	 * period. It accept additional options at second parameter:
	 * start_date - The standard MySQL date format. Eg: 2015-4-30
	 * end_date - The standard MySQL date format. Eg: 2015-5-31
	 * 
	 * The returned value consists of two element in the array:
	 * date - The moment of which it happens to be the highest concurrent sessions
	 * sessions - The maximum number of sessions connected at that moment.
	 * 
	 * If there are no record found, FALSE will be returned.
	 * 
	 * @param int $business_id
	 * @param array $options
	 * @return array|boolean
	 */
	function get_max_concurrent_user_sessions($business_id, $options = array())
	{
		$start_date = array_ensure($options, 'start_date', '');
		$end_date = array_ensure($options, 'end_date', '');
		
		$CI =& get_instance();
		$db = $CI->db;
		
		$db->select('MAX(user_session_start) AS `date`, COUNT(DISTINCT(user_sessions.machine_id)) AS sessions', false);
		$db->from('user_sessions');
		$db->join('machines', 'user_sessions.machine_id = machines.machine_id');
		$db->where('machines.business_id', $business_id);
		$db->group_by('user_session_starter');
		$db->order_by('sessions', 'desc');
		$db->limit(1);
		
		if ( $start_date ) {
			$db->where('DATE(user_session_start) >=', $start_date);
		}
		
		if ( $end_date ) {
			$db->where('DATE(user_session_end) <=', $end_date);
		}
		
		$qry = $db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			
			return $row;
		} else {
			return false;
		}
	}
}

if ( !function_exists('get_total_agent') ) {
	/**
	 * This function return the total number of agents
	 * connected. If business ID is not specified, all
	 * agents will be sum up.
	 * 
	 * @param int optional $business_id
	 * @return int
	 */
	function get_total_agent($business_id = '')
	{
		$CI =& get_instance();
		$db = $CI->db;
		$db->select('SUM(business_connected_agent) AS total_agents');
		$db->from('businesses');
		
		if ( $business_id > 0 ) {
			$db->where('business_id', $business_id);
		}
		
		$qry = $db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			
			return intval($row['total_agents']);
		} else {
			return 0;
		}
	}
}

if ( !function_exists('get_total_business') ) {
	/**
	 * This function return the total number of business
	 * created in the database.
	 * 
	 * @return int
	 */
	function get_total_business()
	{
		$CI =& get_instance();
		$db = $CI->db;
		
		$db->select('COUNT(*) AS total_business');
		$db->from('businesses');
		$qry = $db->get();
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			
			return intval($row['total_business']);
		} else {
			return 0;
		}
	}
}

if ( !function_exists('get_total_machines') ) {
	function get_total_machines()
	{
		$CI =& get_instance();
		$db = $CI->db;
		
		$db->select('COUNT(*) AS total_machines');
		$db->from('machines');
		db_machine_blacklist($db);
			
		$qry = $db->get();
			
		$total_machines = 0;
			
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
		
			return intval($row['total_machines']);
		} else {
			return 0;
		}
	}
}