<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Machine_model extends EB_Model {
	protected $_table_name = 'machines';
	
	public function clear_user_data()
	{
		if ( $this->is_empty() ) {
			return false;
		}
		
		$machine_default_name = $this->get_value('machine_default_name');
		
		$this->set_value(array(
			'machine_name' => $machine_default_name,
			'machine_serial_number' => null,
			'machine_model' => null,
			'machine_processor' => null,
			'machine_ram' => null,
			'machine_year' => null,
			'machine_support_expiry' => null,
			'machine_physical_status' => null,
		));
		
		$this->save();
		
		return true;
	}
	
	public function get_machine_group_model()
	{
		$machine_group_id = $this->get_value('machine_group_id');
		
		if ( $machine_group_id ) {
			$qry = $this->db->get_where('machine_groups', array(
				'machine_group_id' => $machine_group_id,
			));
			
			if ( $qry->num_rows() ) {
				$mg_data = $qry->row_array();
				
				$this->load->model('Machine_group_model', 'machine_group_model');
				
				$mg_model = new Machine_group_model();
				
				$mg_model->set_data($mg_data);
				
				return $mg_model;
			}
		}
		
		return false;
	}
	
	/**
	 * This method check if the machine has started
	 * already or not.
	 *  
	 *  @return boolean
	 */
	public function is_started()
	{
		if ( $this->get_value('machine_status') == 'offline' ) {
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * This method will triggered when the machine is
	 * turned off. This method will return the machine_session_id
	 * of which it turned off.
	 * If there are no machine session found for this machine,
	 * it will return false.
	 * 
	 * @param string $off_time optional
	 * @return int|boolean
	 */
	public function off($off_time = '')
	{
		$this->load->model('Machine_session_model', 'machine_session_model');
		$this->load->model('User_session_model', 'user_session_model');
		
		if ( $this->get_value('machine_status') == 'offline' ) {
			return false;
		} else {
			// Get the session which is alive.
			$machine_id = $this->get_value('machine_id');
			
			$this->db->from('machine_sessions');
			$this->db->where(array(
				'machine_id' => $machine_id,
				'machine_session_end' => null,
			));
			
			$qry = $this->db->get();
			
			if ( $qry->num_rows() ) {
				$machine_session_data = $qry->row_array();
				
				if ( is_empty($off_time) ) {
					$off_time = db_date();
				}
				
				$machine_session_id = $machine_session_data['machine_session_id'];
				$start_time = strtotime($machine_session_data['machine_session_start']);
				$end_time = strtotime($off_time);
				$duration = $end_time - $start_time;
				
				if ( $duration < 0 ) {
					$duration = 0;
				}
				
				$this->machine_session_model->set_value(array(
					'machine_session_id' => $machine_session_id,
					'machine_session_end' => $off_time,
					'machine_session_duration' => $duration,
				));
				$this->machine_session_model->save();
				
				// Update the machine status.
				$this->set_value('machine_status', 'offline');
				$this->save();
				
				$this->user_session_model->load(array(
					'machine_id' => $machine_id,
					'user_session_end' => null,
				));
				
				if ( !$this->user_session_model->is_empty() ) {
					foreach ( $this->user_session_model as $user_session_model ) {
						// Call the user session model's set_offline method.
						$user_session_model->set_offline($off_time);
					}
				}
				
				return $machine_session_id;
			} else {
				return false;
			}
		}
	}
	
	public function on_save()
	{
		if ( $this->is_new() ) {
			if ( is_empty($this->get_value('machine_created')) ) {
				$this->set_value('machine_created', db_date());
			}
		}
	}
	
	/**
	 * This method will register a new machine to the
	 * database. It will check if the agent's quote
	 * has exceeded or not for this machine's business owner.
	 * If do, it will automatically assign 0 to machine_visible.
	 * 
	 * This method will also do the filtering. If there is a
	 * blacklist filter applied to this machine, it will assign
	 * 0 to the machine_visible as well.
	 * 
	 * Upon successful, this method will assign the current model
	 * to the saved data.
	 * 
	 * This method will return TRUE if the creation is successful
	 * or false otherweise.
	 * 
	 * The first parameter consists of the fields held in the
	 * machines table eg: machine_mac_address, machine_ip_address ...
	 * 
	 * @param array $machine_data
	 * @return boolean
	 */
	public function register_machine($machine_data)
	{
		$this->load->model('Business_model', 'business_model');
		$this->load->model('Machine_category_model', 'machine_category_model');
		$this->load->model('Machine_filter_model', 'machine_filter_model');
		
		$mac_address = $machine_data['machine_mac_address'];
		
		// Validate if the machine exists.
		$this->db->from('machines');
		$this->db->where('machine_mac_address', $mac_address);
		$qry = $this->db->get();
		$machine_row = array();
		
		if ( $qry->num_rows() ) {
			$machine_row = $qry->row_array();
			
			if ( $machine_row['machine_visible'] == 1 ) {
				return false;
			} else {
				$machine_data = array_merge($machine_row, $machine_data);
			}
		}
		
		$business_id = array_ensure($machine_data, 'business_id', 0);
			
		$this->business_model->load(array(
			'business_id' => $business_id,
		));
			
		if ( $this->business_model->is_empty() ) {
			return false;
		}
			
		// If status not specified, turn it to offline.
		if ( !isset($machine_data['machine_status']) ) {
			$machine_data['machine_status'] = 'offline';
		}
			
		// Ensure the default name are same with the pc name.
		if ( !isset($machine_data['machine_default_name']) ) {
			$machine_data['machine_default_name'] = array_ensure($machine_data, 'machine_name', '');
		}
			
		// Assign machine categories.
		$os_name = $machine_data['machine_os_name'];
		$machine_category_data = $this->machine_category_model->match_category($os_name);
			
		if ( false === $machine_category_data ) {
			return false;
		}
			
		$machine_data['machine_category_id'] = $machine_category_data['machine_category_id'];
		
			
		// Check max agents.
		$max_agents = intval($this->business_model->get_value('business_max_agent'));
		$connected_agents = intval($this->business_model->get_value('business_connected_agent'));
			
		if ( $connected_agents >= $max_agents ) {
			$machine_data['machine_visible'] = 0;
		} else {
			$machine_data['machine_visible'] = 1;
		}
			
		// Machine filtering here.
		$machine_filters = $this->machine_filter_model->filter_all($business_id, $machine_data);
		
		if ( iterable($machine_filters) ) {
			foreach ( $machine_filters as $filter ) {
				$action = $filter['machine_filter_action'];
					
				if ( $action == 'block' ) {
					$machine_data['machine_visible'] = 0;
				} else if ( $action == 'allow' && $connected_agents < $max_agents ) {
					$machine_data['machine_visible'] = 1;
				} else if ( $action == 'group' ) {
					$machine_group_id = $filter['machine_filter_group_assigned'];
		
					$machine_data['machine_group_id'] = $machine_group_id;
				}
			}
		}
		
		// Update the connected agents only if these conditions are true.
		if ( $machine_data['machine_visible'] && $connected_agents <= $max_agents ) {
			$this->business_model->set_value('business_connected_agent', $connected_agents + 1);
			$this->business_model->save();
		}
		
		$this->set_value($machine_data);
		$this->save();
			
		return true;
	}
	
	/**
	 * This method actually will update this current machine_model
	 * visibility status to the specified status in first parameter.
	 *
	 * @param boolean $visibility
	 * @return boolean
	 */
	public function set_visibility($visibility)
	{
		$machine_id = $this->get_value('machine_id');
	
		if ( !$machine_id ) {
			return false;
		}
	
		$this->db->update('machines', array(
			'machine_visible' => ($visibility ? 1 : 0),
		), array(
			'machine_id' => $machine_id,
		));
	
		return true;
	}
	
	/**
	 * This should be call if the machine is started.
	 * This method will return the machine_session_id
	 * from the database.
	 * 
	 * It will return false if the machine is already
	 * started.
	 * 
	 * @param string $start_time optional The start time in MySQL datetime standard format.
	 * @return int|boolean
	 */
	public function start($start_time = '')
	{
		$this->load->model('Machine_session_model', 'machine_session_model');
		
		if ( $this->is_started() ) {
			return false;
		} else {
			$machine_id = $this->get_value('machine_id');
			
			if ( is_empty($start_time) ) {
				$start_time = db_date();
			}
			
			// Find the session starter id.
			$this->db->select('machine_session_id');
			$this->db->from('machine_sessions');
			$this->db->join('machines', 'machine_sessions.machine_id = machines.machine_id');
			$this->db->where('machines.machine_status <>', 'offline');
			$this->db->order_by('machine_session_start', 'asc');
			$this->db->limit(1);
			
			$qry = $this->db->get();
			$machine_session_starter_id = 0;
			
			if ( $qry->num_rows() ) {
				$row = $qry->row_array();
				$machine_session_starter_id = intval($row['machine_session_id']);
			} else {
				// Not found, use the next increment value as the starter id.
				$machine_session_starter_id = $this->machine_session_model->get_next_increment_value();
				// Set back the primary key ID.
				$this->machine_session_model->set_value('machine_session_id', $machine_session_starter_id);
			}
			
			$this->machine_session_model->set_value(array(
				'machine_id' => $machine_id,
				'machine_session_start' => $start_time,
				'machine_session_starter_id' => $machine_session_starter_id,
			));
			
			$this->machine_session_model->save();
			
			// Now update the machine's status and the last_connected date/time.
			$this->set_value('machine_last_connected', $start_time);
			$this->set_value('machine_status', 'online');
			$this->save();
			
			return $this->machine_session_model->get_value('machine_session_id');
		}
	}
	
	/**
	 * This method will change the machine_visible flag to 0 and
	 * deduct one agent connected from this business.
	 * 
	 * This method will return false if the machine is already
	 * not vieweable.
	 * 
	 * Unregister a machine will not stop all the apps or user sessions
	 * running on that machine. It will only turn the visible flag to 0
	 * and deduct 1 from the connected agents from the businesses table.
	 * 
	 * @param int optional $machine_id
	 * @return boolean
	 */
	public function unregister_machine($machine_id = 0)
	{
		if ( $machine_id <= 0 ) {
			$machine_id = $this->get_value('machine_id');
		}
		
		$qry = $this->db->get_where('machines', array(
			'machine_id' => $machine_id,
		));
		
		if ( $qry->num_rows() ) {
			$machine_data = $qry->row_array();
			
			$business_id = $machine_data['business_id'];
			$visible = $machine_data['machine_visible'];
			
			if ( !$visible ) {
				return false;
			}
			
			$this->db->update('machines', array(
				'machine_visible' => 0,
			), array(
				'machine_id' => $machine_id,
			));
			
			// Deduct one from the business.
			$update = 'UPDATE businesses SET business_connected_agent = business_connected_agent - 1 WHERE business_id = ' . $business_id;
			$this->db->query($update);
			
			return true;
		} else {
			return false;
		}
	}
}