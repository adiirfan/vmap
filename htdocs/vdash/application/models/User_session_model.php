<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_session_model extends EB_Model {
	protected $_table_name = 'user_sessions';
	
	/**
	 * To set the user session to offline. This method will
	 * also check if there are any application session running by
	 * this user session. If yes, it will terminate it and calculate
	 * the duration.
	 * 
	 * @param string optional $off_time MySQL standard datetime format
	 * @return boolean
	 */
	public function set_offline($off_time = '')
	{
		$start_time = strtotime($this->get_value('user_session_start'));
		$end_time = strtotime($off_time);
		$duration = $end_time - $start_time;
		
		if ( $duration < 0 ) {
			$duration = 0;
		}
		
		$this->set_value(array(
			'user_session_end' => $off_time,
			'user_session_duration' => $duration,
			'user_session_status' => 'offline',
		));
		
		$this->save();
		
		// Check if there are any application running in this session.
		$user_session_id = $this->get_value('user_session_id');
		
		$this->db->from('app_sessions');
		$this->db->where(array(
			'user_session_id' => $user_session_id,
			'app_end' => null,
		));
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			// Set those application session to close.
			foreach ( $qry->result_array() as $row ) {
				$app_session_id = $row['app_session_id'];
				$app_start_time = strtotime($row['app_start']);
				$duration = $end_time - $app_start_time;
				
				if ( $duration < 0 ) {
					$duration = 0;
				}
				
				$this->db->update('app_sessions', array(
					'app_end' => $off_time,
					'app_duration' => $duration,
				), array(
					'app_session_id' => $app_session_id,
				));
			}
		}
	}
}