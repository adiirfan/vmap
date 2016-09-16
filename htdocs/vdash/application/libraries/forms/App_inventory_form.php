<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Form.php');

class App_inventory_form extends Form {
	public function init()
	{
		$this->set_layout('app_inventory');
		
		$fields = array(
			array(
				'name' => 'friendly_name',
				'label' => lang('app_friendly_name'),
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control',
					'size' => 35,
				),
			),
			array(
				'name' => 'license_count',
				'label' => lang('app_license_number'),
				'type' => 'text',
				'rules' => array('number' => array('min' => 0)),
				'attributes' => array(
					'class' => 'form-control',
					'size' => 10,
				),
			),
			array(
				'name' => 'version',
				'label' => lang('app_version'),
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control',
					'size' => 10,
				),
			),
			array(
				'name' => 'license_type',
				'label' => lang('app_license_type'),
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control',
					'size' => 30,
				),
			),
			array(
				'name' => 'vendor',
				'label' => lang('app_vendor'),
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control',
					'size' => 35
				),
			),
			array(
				'name' => 'purchase_date',
				'label' => lang('app_purchase_date'),
				'type' => 'date',
				'attributes' => array(
					'class' => 'form-control',
					'size' => 20,
					'show-clear' => 'true',
				),
			),
			array(
				'name' => 'expiry_date',
				'label' => lang('app_expiry_date'),
				'type' => 'date',
				'attributes' => array(
					'class' => 'form-control',
					'size' => 20,
					'show-clear' => 'true',
				),
			),
			array(
				'name' => 'virtualized',
				'label' => lang('app_virtualized'),
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control',
					'size' => 35,
				),
			),
		);
		
		$this->set_fields($fields);
		$this->set_binding('app_model', array(
			'app_friendly_name' => 'friendly_name',
			'app_license_count' => 'license_count',
			'app_version' => 'version',
			'app_license_type' => 'license_type',
			'app_vendor' => 'vendor',
			'app_purchase_date' => 'purchase_date',
			'app_expiry_date' => 'expiry_date',
			'app_virtualized' => 'virtualized',
		));
	}
	
	protected function _prep_db_friendly_name($value, $model)
	{
		if ( is_empty($value) ) {
			$app_model = $this->get_model('app_model');
			return $app_model->get_value('app_sys_name');
		} else {
			return $value;
		}
	}
	
	protected function _prep_db_license_count($value, $model)
	{
		if ( is_empty($value) ) {
			return false;
		} else {
			return $value;
		}
	}
	
	protected function _prep_db_version($value, $model)
	{
		if ( is_empty($value) ) {
			return false;
		} else {
			return $value;
		}
	}
	
	protected function _prep_db_license_type($value, $model)
	{
		if ( is_empty($value) ) {
			return false;
		} else {
			return $value;
		}
	}
	
	protected function _prep_db_vendor($value, $model)
	{
		if ( is_empty($value) ) {
			return false;
		} else {
			return $value;
		}
	}
	
	protected function _prep_db_purchase_date($value, $model)
	{
		$sys_date = array_ensure($value, 'system', '');
		
		if ( is_empty($sys_date) ) {
			return null;
		} else {
			$sys_time = strtotime($sys_date);
			
			if ( false !== $sys_time ) {
				return $sys_date;
			} else {
				return false;
			}
		}
	}
	
	protected function _prep_db_expiry_date($value, $model)
	{
		$sys_date = array_ensure($value, 'system', '');
		
		if ( is_empty($sys_date) ) {
			return null;
		} else {
			$sys_time = strtotime($sys_date);
			
			if ( false !== $sys_time ) {
				return $sys_date;
			} else {
				return false;
			}
		}
	}
	
	protected function _prep_db_virtualized($value, $model)
	{
		if ( is_empty($value) ) {
			return false;
		} else {
			return $value;
		}
	}
	
	protected function _prep_field_license_count($value, $field)
	{
		return intval($value);
	}
}