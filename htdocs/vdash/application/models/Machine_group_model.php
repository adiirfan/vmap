<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Machine_group_model extends EB_Model {
	protected $_table_name = 'machine_groups';
	
	/**
	 * This will add a new machine to this machine group.
	 * 
	 * @param int $machine_id
	 * @return boolean
	 */
	public function add_machine($machine_id)
	{
		$machine_group_id = $this->get_value('machine_group_id');
		
		if ( !$machine_group_id ) {
			return false;
		}
		
		$this->db->update('machines', array(
			'machine_group_id' => $machine_group_id,
		), array(
			'machine_id' => $machine_id,
		));
		
		if ( $this->db->affected_rows() ) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Return the total machines in this machine group.
	 * 
	 * @return int
	 */
	public function get_total_machines()
	{
		$mg_id = $this->get_value('machine_group_id');
		
		if ( $mg_id ) {
			$this->db->select('COUNT(*) AS total_machines');
			$this->db->from('machines');
			$this->db->where('machine_group_id', $mg_id);
			
			$qry = $this->db->get();
			
			if ( $qry->num_rows() ) {
				$row = $qry->row_array();
				return intval($row['total_machines']);
			}
		}
		
		return 0;
	}
	
	/**
	 * Get the total number of machine which is offline.
	 * 
	 * @return int
	 */
	public function get_total_offline_machines()
	{
		$mg_id = $this->get_value('machine_group_id');
		
		if ( $mg_id ) {
			$this->db->select('COUNT(*) AS total_machines');
			$this->db->from('machines');
			$this->db->where('machine_group_id', $mg_id);
			$this->db->where('machine_status', 'offline');
				
			$qry = $this->db->get();
				
			if ( $qry->num_rows() ) {
				$row = $qry->row_array();
				return intval($row['total_machines']);
			}
		}
		
		return 0;
	}
	
	/**
	 * Get the total number of machine which is online
	 * or occupied.
	 * 
	 * @return int
	 */
	public function get_total_online_machines()
	{
		$mg_id = $this->get_value('machine_group_id');
		
		if ( $mg_id ) {
			$this->db->select('COUNT(*) AS total_machines');
			$this->db->from('machines');
			$this->db->where('machine_group_id', $mg_id);
			$this->db->where('machine_status <>', 'offline');
				
			$qry = $this->db->get();
				
			if ( $qry->num_rows() ) {
				$row = $qry->row_array();
				return intval($row['total_machines']);
			}
		}
		
		return 0;
	}
	
	/**
	 * Update the machines table row to null.
	 * 
	 * @param array $machine_group_data
	 */
	public function on_deleted($machine_group_data)
	{
		$mg_id = $machine_group_data['machine_group_id'];
		
		$this->db->update('machines', array(
			'machine_group_id' => null,
		), array(
			'machine_group_id' => $mg_id,
		));
	}
	
	public function on_save()
	{
		if ( $this->is_new() ) {
			$sys_user_model = $this->authentication->get_model();
			$sys_user_id = $sys_user_model->get_value('sys_user_id');
			$mg_name = $this->get_value('machine_group_name');
			$mg_code = sanitize_filename($mg_name);
			
			$this->set_value(array(
				'machine_group_code' => $mg_code,
				'machine_group_created' => db_date(),
				'machine_group_created_by' => $sys_user_id,
			));
		}
	}
	
	/**
	 * This will remove a machine from this machine group.
	 *
	 * @param int $machine_id
	 * @return boolean
	 */
	public function remove_machine($machine_id)
	{
		$machine_group_id = $this->get_value('machine_group_id');
	
		if ( !$machine_group_id ) {
			return false;
		}
	
		$this->db->update('machines', array(
			'machine_group_id' => null,
		), array(
			'machine_id' => $machine_id,
			'machine_group_id' => $machine_group_id,
		));
	
		if ( $this->db->affected_rows() ) {
			return true;
		} else {
			return false;
		}
	}
}