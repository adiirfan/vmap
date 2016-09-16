<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( !function_exists('application_usage') ) {
	/**
	 * This function returns the application usage data.
	 * It counts the number of instances launched by
	 * particular business and date range.
	 * 
	 * * * * * *
	 * Options *
	 * * * * * *
	 * + business_id:integer
	 *   Specify the business ID. If not specified, all business will shows.
	 *   
	 * + machine_group:integer
	 *   Specify the machine group. If specified, only those applications launched
	 *   by these machines will be included.
	 *   
	 * + visible_only:boolean
	 *   Flag to determine whether show visible only or show all. By default, it is 1.
	 *   
	 * + date:string|array
	 *   eg: single date = 2015-03-31, date range = array('2015-03-01', '2015-03-31'),
	 *   	 predefined date range = 'today', 'this week', 'this month', 'this year'
	 * 
	 * + return_overall:boolean
	 *   Flag to determine whether to return the overall statistic of instances launched.
	 *   By default, it is true.
	 * 
	 * + return_chart_data:boolean
	 *   Flag to determine whether to return the chart data in associative array. This data
	 *   is used for google chart. By default, it is true.
	 * 
	 * + return_top_app:boolean
	 *   Flag to determine whether to return the list of applications that launched the most.
	 *   By defaut, it is true.
	 * 
	 * + max_top_app:int
	 *   Default is 5. This number determine the maximum top application list to be returned.
	 * 
	 * @param array optional $options
	 * @return array
	 */
	function application_usage($options = array())
	{
		$business_id = array_ensure($options, 'business_id', 0);
		$machine_group = array_ensure($options, 'machine_group', 0);
		$visible_only = (array_ensure($options, 'visible_only', 1) ? 1 : 0);
		$date = array_ensure($options, 'date', 'all time');
		$return_overall = array_ensure($options, 'return_overall', true);
		$return_chart_data = array_ensure($options, 'return_chart_data', true);
		$return_top_app = array_ensure($options, 'return_top_app', true);
		$max_top_app = array_ensure($options, 'max_top_app', 5);
		$result = array(
			'overall' => null,
			'chart_data' => null,
			'top_apps' => null,
			'date' => false,
		);
		
		$CI =& get_instance();
		$db = $CI->db;
		
		// Overall statistics.
		if ( $return_overall ) {
			$db->select('COUNT(*) AS total_instances');
			$db->from('app_sessions');
			$db->join('apps', 'app_sessions.app_id = apps.app_id');
			$db->where('apps.app_visible', $visible_only);
			
			if ( $machine_group ) {
				$db->where('app_sessions.user_session_id IN (
					SELECT user_sessions.user_session_id
					FROM user_sessions
					WHERE user_sessions.machine_id IN (
						SELECT machines.machine_id
						FROM machines
						WHERE machines.machine_group_id = ' . $machine_group . '
					)
				)');
			} else if ( $business_id ) {
				$db->where('apps.business_id', $business_id);
			}
			
			if ( !is_empty($date) ) {
				$result['date'] = build_query_date($db, 'app_sessions.app_start', $date);
			}
			
			$qry = $db->get();
			
			if ( $qry->num_rows() ) {
				$row = $qry->row_array();
				$result['overall'] = intval($row['total_instances']);
			} else {
				$result['overall'] = 0;
			}
		}
		
		// Chart data.
		if ( $return_chart_data ) {
			$db->select('COUNT(*) instances');
			$db->from('app_sessions');
			$db->join('apps', 'app_sessions.app_id = apps.app_id');
			$db->where('apps.app_visible', $visible_only);
			
			if ( $machine_group ) {
				$db->where('app_sessions.user_session_id IN (
					SELECT user_sessions.user_session_id
					FROM user_sessions
					WHERE user_sessions.machine_id IN (
						SELECT machines.machine_id
						FROM machines
						WHERE machines.machine_group_id = ' . $machine_group . '
					)
				)');
			} else if ( $business_id ) {
				$db->where('apps.business_id', $business_id);
			}
			
			if ( !is_empty($date) ) {
				$result['date'] = build_query_date($db, 'app_sessions.app_start', $date);
				
				if ( iterable($date) ) {
					$db->select('DATE(app_sessions.app_start) AS period');
					$db->group_by('DATE(app_sessions.app_start)');
				} else {
					switch ( strtolower($date) ) {
						case 'this week':
						case 'this month':
						case 'all time':
							$db->select('DATE(app_sessions.app_start) AS period');
							$db->group_by('DATE(app_sessions.app_start)');
							break;
						case 'this year':
							$db->select('MONTH(app_sessions.app_start) AS period');
							$db->group_by('MONTH(app_sessions.app_start)');
							break;
						default:
							// For particular day.
							$db->select('HOUR(app_sessions.app_start) AS period');
							$db->group_by('HOUR(app_sessions.app_start)');
							break;
					}
				}
			} else {
				$db->select('DATE(app_sessions.app_start) AS period');
				$db->group_by('DATE(app_sessions.app_start)');
			}
			
			$qry = $db->get();
			
			if ( $qry->num_rows() ) {
				$result['chart_data'] = array();
				$last_hour = 0;
				$this_year = date('Y');
				
				foreach ( $qry->result_array() as $row ) {
					$instances = intval($row['instances']);
					$period = $row['period'];
					
					if ( $date == 'today' ) {
						$period = intval($period);
						
						if ( $period - 1 > $last_hour ) {
							// Fill up the chart data with hours.
							for ( $i = $last_hour + 1; $i < $period; $i ++ ) {
								$next_hour = $i + 1;
								$hour_str = user_date('1990-01-01 ' . $next_hour . ':00:00', 'ga');
								
								$result['chart_data'][] = array($hour_str, 0);
							}
						} else {
							$hour_str = user_date('1990-01-01 ' . $period . ':00:00', 'ga');
							
							$result['chart_data'][] = array($hour_str, $instances);
						}
						
						$last_hour = $period;
					} else if ( $date == 'this year' ) {
						$period = user_date($this_year . '-' . $period . '-01', 'M');
						
						$result['chart_data'][] = array($period, $instances);
					} else {
						$period = user_date($period, 'j/n');
						
						$result['chart_data'][] = array($period, $instances);
					}
				}
			}
		}
		
		// Top application list.
		if ( $return_top_app ) {
			$db->select('apps.*, COUNT(app_sessions.app_session_id) AS total_instances');
			$db->from('app_sessions');
			$db->join('apps', 'app_sessions.app_id = apps.app_id');
			$db->where('apps.app_visible', $visible_only);
			$db->group_by('app_sessions.app_id');
			$db->order_by('total_instances', 'desc');
			$db->limit($max_top_app);
				
			if ( $machine_group ) {
				$db->where('app_sessions.user_session_id IN (
					SELECT user_sessions.user_session_id
					FROM user_sessions
					WHERE user_sessions.machine_id IN (
						SELECT machines.machine_id
						FROM machines
						WHERE machines.machine_group_id = ' . $machine_group . '
					)
				)');
			} else if ( $business_id ) {
				$db->where('apps.business_id', $business_id);
			}
			
			if ( !is_empty($date) ) {
				$result['date'] = build_query_date($db, 'app_sessions.app_start', $date);
			}
			
			$qry = $db->get();
			
			if ( $qry->num_rows() ) {
				$result['top_apps'] = array();
				
				foreach ( $qry->result_array() as $row ) {
					$app_name = $row['app_friendly_name'];
					$instances = $row['total_instances'];
					
					$result['top_apps'][] = array(
						'id' => $row['app_id'],
						'code_name' => $row['app_sys_name'],
						'name' => $row['app_friendly_name'],
						'instances' => intval($row['total_instances']),
						'instance_word' => _lang('_launch_count', intval($row['total_instances'])),
					);
				}
			}
		}
		
		return $result;
	}
}

if ( !function_exists('build_query_date') ) {
	/**
	 * This function will examine the date provided and apply it to
	 * the database query builder.
	 * 
	 * This function will return the date. It can be a single date
	 * in string or ranged date in array.
	 * 
	 * @param CI_DB_query_builder $db
	 * @param string $field
	 * @param string|array $date
	 * @param array optional $options
	 * @return string|array
	 */
	function build_query_date($db, $field, $date, $options = array())
	{
		$compare_time = array_ensure($options, 'compare_time', false);
		
		if ( iterable($date) ) {
			$start_date = $date[0];
			$end_date = $date[1];
			
			if ( $start_date == $end_date ) {
				return build_query_date($db, $field, $start_date);
			} else {
				if ( $compare_time ) {
					$db->where($field . ' BETWEEN "' . $start_date . '" AND "' . $end_date . '"');
				} else {
					$db->where('DATE(' . $field . ') BETWEEN "' . $start_date . '" AND "' . $end_date . '"');
				}
				
				return array(
					$start_date, $end_date,
				);
			}
		} else {
			switch ( $date ) {
				case 'today':
					$today = db_date(false, true);
					$db->where('DATE(' . $field . ')', $today);
					
					return $today;
				case 'this week':
					$monday = date('Y-m-d', strtotime('monday this week'));
					$sunday = date('Y-m-d', strtotime('sunday this week'));
					
					$db->where('DATE(' . $field . ') BETWEEN "' . $monday . '" AND "' . $sunday . '"');
					
					return array(
						$monday, $sunday,
					);
				case 'this month':
					$start = date('Y-m') . '-01';
					$end = date('Y-m-t');
					
					$db->where('DATE(' . $field . ') BETWEEN "' . $start . '" AND "' . $end . '"');
					
					return array($start, $end);
				case 'this year':
					$start = date('Y') . '-01-01';
					$end = date('Y') . '-12-31';
					
					$db->where('DATE(' . $field . ') BETWEEN "' . $start . '" AND "' . $end . '"');
					
					return array($start, $end);
				case 'all time':
					return lang('all_time');
				default:
					if ( $compare_time ) {
						$db->where($field, $date);
					} else {
						$db->where('DATE(' . $date . ')', $date);
					}
					
					return $date;
			}
		}
	}
}

if ( !function_exists('machine_usage') ) {
	/**
	 * This function returns the machine logon sessions statistics.
	 * 
	 *
	 * * * * * *
	 * Options *
	 * * * * * *
	 * + business_id:integer
	 *   Specify the business ID. If not specified, all business will shows.
	 *
	 * + machine_group:integer
	 *   Specify the machine group. If specified, only those applications launched
	 *   by these machines will be included.
	 *
	 * + visible_only:boolean
	 *   Flag to determine whether show visible only or show all. By default, it is 1.
	 *
	 * + date:string|array
	 *   eg: single date = 2015-03-31, date range = array('2015-03-01', '2015-03-31'),
	 *   	 predefined date range = 'today', 'this week', 'this month', 'this year'
	 *
	 * + return_overall:boolean
	 *   Flag to determine whether to return the overall statistic of instances launched.
	 *   By default, it is true.
	 *
	 * + return_chart_data:boolean
	 *   Flag to determine whether to return the chart data in associative array. This data
	 *   is used for google chart. By default, it is true.
	 *
	 * + return_top_machine:boolean
	 *   Flag to determine whether to return the list of applications that launched the most.
	 *   By defaut, it is true.
	 *
	 * + max_top_machine:int
	 *   Default is 5. This number determine the maximum top application list to be returned.
	 *
	 * @param array optional $options
	 * @return array
	 */
	function machine_usage($options = array())
	{
		$business_id = array_ensure($options, 'business_id', 0);
		$machine_group = array_ensure($options, 'machine_group', 0);
		$visible_only = (array_ensure($options, 'visible_only', 1) ? 1 : 0);
		$date = array_ensure($options, 'date', 'all time');
		$return_overall = array_ensure($options, 'return_overall', true);
		$return_chart_data = array_ensure($options, 'return_chart_data', true);
		$return_top_machine = array_ensure($options, 'return_top_machine', true);
		$max_top_machine = array_ensure($options, 'max_top_machine', 5);
		$result = array(
			'overall' => null,
			'chart_data' => null,
			'top_machines' => null,
			'date' => false,
		);
		
		$CI =& get_instance();
		$db = $CI->db;
		
		// Overall statistics.
		if ( $return_overall ) {
			$db->select('COUNT(*) AS total_sessions');
			$db->from('user_sessions');
			$db->join('machines', 'user_sessions.machine_id = machines.machine_id');
			$db->where('machines.machine_visible', $visible_only);
			
			if ( $machine_group ) {
				$db->where('machines.machine_group_id', $machine_group);
			} else if ( $business_id ) {
				$db->where('machines.business_id', $business_id);
			}
			
			if ( !is_empty($date) ) {
				$result['date'] = build_query_date($db, 'user_sessions.user_session_start', $date);
			}
				
			$qry = $db->get();
				
			if ( $qry->num_rows() ) {
				$row = $qry->row_array();
				$result['overall'] = intval($row['total_sessions']);
			} else {
				$result['overall'] = 0;
			}
		}
		
		// Chart data.
		if ( $return_chart_data ) {
			$db->select('COUNT(*) instances');
			$db->from('user_sessions');
			$db->join('machines', 'user_sessions.machine_id = machines.machine_id');
			$db->where('machines.machine_visible', $visible_only);
				
			if ( $machine_group ) {
				$db->where('machines.machine_group_id', $machine_group);
			} else if ( $business_id ) {
				$db->where('machines.business_id', $business_id);
			}
				
			if ( !is_empty($date) ) {
				$result['date'] = build_query_date($db, 'user_sessions.user_session_start', $date);
		
				if ( iterable($date) ) {
					$db->select('DATE(user_sessions.user_session_start) AS period');
					$db->group_by('DATE(user_sessions.user_session_start)');
				} else {
					switch ( strtolower($date) ) {
						case 'this week':
						case 'this month':
						case 'all time':
							$db->select('DATE(user_sessions.user_session_start) AS period');
							$db->group_by('DATE(user_sessions.user_session_start)');
							break;
						case 'this year':
							$db->select('MONTH(user_sessions.user_session_start) AS period');
							$db->group_by('MONTH(user_sessions.user_session_start)');
							break;
						default:
							// For particular day.
							$db->select('HOUR(user_sessions.user_session_start) AS period');
							$db->group_by('HOUR(user_sessions.user_session_start)');
							break;
					}
				}
			} else {
				$db->select('DATE(user_sessions.user_session_start) AS period');
				$db->group_by('DATE(user_sessions.user_session_start)');
			}
				
			$qry = $db->get();
				
			if ( $qry->num_rows() ) {
				$result['chart_data'] = array();
				$this_year = date('Y');
				$last_hour = 0;
				
				foreach ( $qry->result_array() as $row ) {
					$instances = intval($row['instances']);
					$period = $row['period'];
					
					if ( $date == 'today' ) {
						$period = intval($period);
						
						if ( $period - 1 > $last_hour ) {
							// Fill up the chart data with hours.
							for ( $i = $last_hour + 1; $i < $period; $i ++ ) {
								$next_hour = $i + 1;
								$hour_str = user_date('1990-01-01 ' . $next_hour . ':00:00', 'g a');
								
								$result['chart_data'][] = array($hour_str, 0);
							}
						} else {
							$hour_str = user_date('1990-01-01 ' . $period . ':00:00', 'g a');
							
							$result['chart_data'][] = array($hour_str, $instances);
						}
						
						$last_hour = $period;
					} else if ( $date == 'this year' ) {
						$period = user_date($this_year . '-' . $period . '-01', 'M Y');
						
						$result['chart_data'][] = array($period, $instances);
					} else {
						$period = user_date($period, 'j/n/Y');
						
						$result['chart_data'][] = array($period, $instances);
					}
					
					//$result['chart_data'][] = array($period, $instances);
				}
			}
		}
		
		// Top machine list.
		if ( $return_top_machine ) {
			$db->select('machines.*, COUNT(user_sessions.user_session_id) AS total_sessions');
			$db->from('user_sessions');
			$db->join('machines', 'user_sessions.machine_id = machines.machine_id');
			$db->where('machines.machine_visible', $visible_only);
			$db->group_by('user_sessions.machine_id');
			$db->order_by('total_sessions', 'desc');
			$db->limit($max_top_machine);
		
			if ( $machine_group ) {
				$db->where('machines.machine_group_id', $machine_group);
			} else if ( $business_id ) {
				$db->where('machines.business_id', $business_id);
			}
				
			if ( !is_empty($date) ) {
				$result['date'] = build_query_date($db, 'user_sessions.user_session_start', $date);
			}
				
			$qry = $db->get();
				
			if ( $qry->num_rows() ) {
				$result['top_machines'] = array();
		
				foreach ( $qry->result_array() as $row ) {
					$machine_name = $row['machine_name'];
					$machine_id = $row['machine_id'];
					$machine_mac_address = $row['machine_mac_address'];
					$total_sessions = intval($row['total_sessions']);
						
					$result['top_machines'][] = array(
						'id' => $machine_id,
						'name' => $machine_name,
						'mac_address' => $machine_mac_address,
						'sessions' => $total_sessions,
						'session_word' => _lang('_session_count', $total_sessions),
					);
				}
			}
		}
		
		return $result;
	}
}