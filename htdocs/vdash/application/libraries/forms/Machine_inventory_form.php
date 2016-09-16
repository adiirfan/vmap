<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Form.php');

class Machine_inventory_form extends Form {
	public function init()
	{
		$this->set_layout('machine_inventory');
		
		$fields = array(
			array(
				'name' => 'machine_name',
				'label' => lang('machine_name'),
				'type' => 'text',
				'rules' => array('required'),
				'attributes' => array(
					'class' => 'form-control',
					'size' => 45,
				),
			),
			array(
				'name' => 'machine_serial_number',
				'label' => lang('machine_serial_number'),
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control',
					'size' => 25,
				),
			),
			array(
				'name' => 'machine_model',
				'label' => lang('machine_model'),
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control',
					'size' => 30,
				),
			),
			array(
				'name' => 'machine_processor',
				'label' => lang('machine_processor'),
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control',
					'size' => 15,
				),
			),
			array(
				'name' => 'machine_ram',
				'label' => lang('machine_ram'),
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control',
					'size' => 15,
				),
			),
			array(
				'name' => 'machine_year',
				'label' => lang('machine_year'),
				'type' => 'text',
				'rules' => array('number' => array('min' => 1970)),
				'attributes' => array(
					'class' => 'form-control',
					'size' => 10,
				),
			),
			array(
				'name' => 'machine_expiry',
				'label' => lang('machine_year_expired'),
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control',
					'size' => 10,
				),
			),
			array(
				'name' => 'machine_physical_status',
				'label' => lang('machine_condition'),
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control',
					'size' => 50,
				),
			),
		);
		
		$this->set_fields($fields);
		$this->set_binding('machine_model', array(
			'machine_name' => 'machine_name',
			'machine_serial_number' => 'machine_serial_number',
			'machine_model' => 'machine_model',
			'machine_processor' => 'machine_processor',
			'machine_ram' => 'machine_ram',
			'machine_year' => 'machine_year',
			'machine_support_expiry' => 'machine_expiry',
			'machine_physical_status' => 'machine_physical_status',
		));
	}
	
	protected function _prep_db_machine_name($value, $model)
	{
		if ( is_empty($value) ) {
			$machine_name = $model->get_value('machine_default_name');
			return trim($machine_name);
		} else {
			return $value;
		}
	}
	
	protected function _prep_db_machine_serial_number($value, $model)
	{
		if ( is_empty($value) ) {
			return null;
		} else {
			return $value;
		}
	}
	
	protected function _prep_db_machine_model($value, $model)
	{
		if ( is_empty($value) ) {
			return null;
		} else {
			return $value;
		}
	}
	
	protected function _prep_db_machine_processor($value, $model)
	{
		if ( is_empty($value) ) {
			return null;
		} else {
			return $value;
		}
	}
	
	protected function _prep_db_machine_ram($value, $model)
	{
		if ( is_empty($value) ) {
			return null;
		} else {
			return $value;
		}
	}
	
	protected function _prep_db_machine_year($value, $model)
	{
		if ( is_empty($value) ) {
			return null;
		} else {
			return intval($value);
		}
	}
	
	protected function _prep_db_machine_expiry($value, $model)
	{
		if ( is_empty($value) ) {
			return null;
		} else {
			return intval($value);
		}
	}
	
	protected function _prep_db_machine_physical_status($value, $model)
	{
		if ( is_empty($value) ) {
			return null;
		} else {
			return $value;
		}
	}
}