<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Listing.php');

class Machine_group_listing extends Listing {
	protected $_business_id = 0;
	
	public function init()
	{
		$show_business_column = ($this->_business_id ? false : true);
		
		$db = $this->_CI->db;
		
		$db->select('machine_groups.*, businesses.business_name, (
				SELECT COUNT(*)
				FROM machines
				WHERE machines.machine_group_id = machine_groups.machine_group_id
			) AS total_machines, (
				SELECT COUNT(*)
				FROM machines
				WHERE machines.machine_group_id = machine_groups.machine_group_id AND
					machines.machine_status <> "offline"
			) AS online_machines, (
				SELECT COUNT(*)
				FROM machines
				WHERE machines.machine_group_id = machine_groups.machine_group_id AND
					machines.machine_status = "offline"
			) AS offline_machines');
		$db->from('machine_groups');
		$db->join('businesses', 'machine_groups.business_id = businesses.business_id');
		
		if ( $this->_business_id ) {
			$db->where('machine_groups.business_id', $this->_business_id);
		}
		
		$columns = array(
			'group_name' => array(
				'label' => lang('machine_group_name'),
				'field' => 'machine_group_name',
				'sort' => true,
				'weight' => 2,
			),
			'desc' => array(
				'label' => lang('machine_group_desc'),
				'field' => 'machine_group_desc',
				'sort' => true,
				'weight' => ($show_business_column ? 2 : 3),
			),
			'total_machines' => array(
				'label' => lang('total_machines'),
				'field' => 'total_machines',
				'sort' => true,
				'weight' => ($show_business_column ? 1 : 2),
			),
			'machine_online' => array(
				'label' => lang('online_offline'),
				'field' => 'online_machines',
				'sort' => true,
				'weight' => 2,
			),
			'actions' => array(
				'label' => lang('actions'),
				'weight' => 3,
			),
		);
		
		if ( $show_business_column ) {
			$columns = array_slice($columns, 0, 1) + array(
				'business' => array(
					'label' => lang('business'),
					'field' => 'business_name',
					'sort' => true,
					'weight' => 2,
				),
			) + array_slice($columns, 1);
		}
		
		$this->set_columns($columns);
		$this->set_filters(array(
			'keyword', 'business' => 'businesses.business_id'
		));
	}
	
	public function set_business_id($business_id)
	{
		$this->_business_id = intval($business_id);
	}
	
	protected function _count_records($queries)
	{
		foreach ( $queries as $index => $line ) {
			if ( preg_match('/^FROM /', $line) ) {
				$queries = array_slice($queries, $index);
				break;
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
		$db->like('machine_groups.machine_group_name', $keyword);
		$db->or_like('machine_groups.machine_group_desc', $keyword);
	}
	
	protected function _format_actions($index, $null, $row)
	{
		$mg_id = $row['machine_group_id'];
		
		$html = '<button class="btn btn-danger btn-sm delete-machine-group" data-machine-group-id="' . $mg_id . '"><i class="fa fa-trash"></i> ' . lang('machine_group_delete') . '</button>&nbsp;';
		$html .= '<button class="btn btn-primary btn-sm manage-machines" data-machine-group-id="' .  $mg_id. '"><i class="fa fa-exchange"></i> ' . lang('machine_group_manage') . '</button>';
		
		return $html;
	}
	
	protected function _format_desc($index, $desc)
	{
		if ( is_empty($desc) ) {
			return 'n/a';
		} else {
			return str_truncate($desc, 30);
		}
	}
	
	protected function _format_group_name($index, $name, $row)
	{
		$html = '<a href="' . site_url('machine_group/detail/' . $row['machine_group_id']) . '">' . htmlentities($name) . '</a>';
		
		return $html;
	}
	
	protected function _format_machine_online($index, $online_count, $row)
	{
		$offline_count = intval($row['offline_machines']);
		$html = '<span class="text-success cursor-default" data-toggle="tooltip" data-placement="left" title="' . lang('online_machines') . '"><i class="fa fa-desktop"></i> <span class="online-count">' . $online_count . '</span></span>&nbsp;&nbsp;';
		$html .= '<span class="text-danger cursor-default" data-toggle="tooltip" data-placement="right" title="' . lang('offline_machines') . '"><i class="fa fa-desktop"></i> <span class="offline-count">' . $offline_count . '</span></span>';
		
		return $html;
	}
	
	protected function _format_total_machines($index, $total)
	{
		$html = '<span class="total-machines">' . intval($total) . '</span>';
		
		return $html;
	}
}