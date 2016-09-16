<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Listing.php');

class Machine_listing extends Listing {
	/**
	 * The business ID of the machines.
	 * If this is specified, only the machines within this business is returned.
	 * If not specified, there will be an additional column called business.
	 * 
	 * @var int
	 */
	protected $_business_id = 0;
	
	public function init()
	{
		$show_business_column = (!$this->_business_id);
		
		$db = $this->_CI->db;
		
		$db->from('machines');
		$db->join('machine_categories', 'machines.machine_category_id = machine_categories.machine_category_id');
		$db->join('businesses', 'machines.business_id = businesses.business_id');
		$db->join('machine_groups', 'machines.machine_group_id = machine_groups.machine_group_id', 'left');
		
		if ( $this->_business_id ) {
			$db->where('machines.business_id', $this->_business_id);
		}
		
		$columns = array(
			'machine_name' => array(
				'label' => lang('machine_name'),
				'field' => 'machine_name',
				'sort' => true,
				'weight' => 2,
			),
		);
		
		if ( $show_business_column ) {
			$columns['business'] = array(
				'label' => lang('business'),
				'field' => 'business_name',
				'sort' => true,
				'weight' => 1,
			);
		}
		
		$columns += array(
			'os' => array(
				'label' => lang('machine_os'),
				'field' => 'machine_os_name',
				'sort' => true,
				'weight' => ($show_business_column ? 1 : 2),
			),
			'ip_address' => array(
				'label' => lang('machine_ip_address'),
				'field' => 'machine_ip_address',
				'sort' => true,
				'weight' => 2,
			),
			'mac_address' => array(
				'label' => lang('machine_mac_address'),
				'field' => 'machine_mac_address',
				'sort' => true,
				'weight' => 2,
			),
			'category' => array(
				'label' => lang('machine_category'),
				'field' => 'machine_category_name',
				'sort' => true,
				'weight' => 1,
			),
			'machine_group' => array(
				'label' => lang('machine_group'),
				'field' => 'machine_group_name',
				'sort' => true,
				'weight' => 1,
			),
			'status' => array(
				'label' => lang('status'),
				'field' => 'machine_status',
				'sort' => true,
				'weight' => 1,
			),
			'blacklist' => array(
				'label' => lang('blacklist'),
				'field' => 'machine_visible',
				'sort' => true,
				'weight' => 1,
			),
		);
		
		$this->set_columns($columns);
		$this->set_filters(array(
			'keyword', 'machine_group', 'status',
		));
		
		// Load the necessary template scripts.
		$this->_CI->template->set_css('!/css/bootstrap-toggle.min.css');
		$this->_CI->template->set_js('!/js/bootstrap-toggle.min.js');
	}
	
	public function set_business_id($business_id)
	{
		$this->_business_id = intval($business_id);
	}
	
	protected function _filter_keyword($db, $value)
	{
		$db->like('machines.machine_name', $value);
		$db->or_like('machines.machine_ip_address', $value);
		$db->or_like('machines.machine_mac_address', $value);
		$db->or_like('machines.machine_os_name', $value);
		$db->or_like('machine_categories.machine_category_name', $value);
	}
	
	protected function _filter_machine_group($db, $value)
	{
		$info = parse_machine_group($value);
		
		if ( $info['type'] == 'machine_group' ) {
			$db->where('machines.machine_group_id', $info['id']);
		} else if ( $info['type'] == 'business' ) {
			$db->where('machines.business_id', $info['business_id']);
		}
	}
	
	protected function _filter_status($db, $value)
	{
		if ( $value == 'blacklisted' ) {
			$db->where('machines.machine_visible', 0);
		} else if ( $value == 'whitelisted' ) {
			$db->where('machines.machine_visible', 1);
		}
	}
	
	protected function _format_blacklist($index, $visible, $row)
	{
		$machine_id = $row['machine_id'];
		
		$html = '<input type="checkbox"' . (!$visible ? ' checked="checked"' : '') . ' class="machine-blacklist" data-toggle="toggle" data-off="' . lang('no') . '" data-on="' . lang('blacklist') . '" data-size="small" data-onstyle="danger" name="visible[' . $machine_id . ']" value="1" data-machine-id="' . $machine_id . '" />';
		
		return $html;
	}
	
	protected function _format_machine_group($index, $machine_group, $row)
	{
		if ( is_empty($machine_group) ) {
			return 'n/a';
		} else {
			return $machine_group;
		}
	}
	
	protected function _format_machine_name($index, $name, $row)
	{
		$machine_id = $row['machine_id'];
		$html = '<a href="' . site_url('machine/detail/' . $machine_id) . '">' . $name . '</a>';
		
		return $html;
	}
	
	protected function _format_status($index, $status)
	{
		$label = 'label label-';
		
		switch ( $status ) {
			case 'online':
				$label .= 'success';
				break;
			case 'occupied':
				$label .= 'warning';
				break;
			case 'offline':
				$label .= 'danger';
				break;
			default:
				$label .= 'default';
				break;
		}
		
		$text = lang('machine_status_' . $status);
		
		$html = '<span class="' . $label . '">' . $text . '</span>';
		
		return $html;
	}
}