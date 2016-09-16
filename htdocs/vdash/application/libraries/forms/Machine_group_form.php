<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Form.php');

class Machine_group_form extends Form {
	
	protected $_allow_change_business = false;
	
	public function init()
	{
		$fields = array(
			array(
				'name' => 'name',
				'label' => lang('machine_group_name'),
				'type' => 'text',
				'rules' => array('required'),
				'attributes' => array(
					'class' => 'form-control',
					'size' => 50,
				),
			),
		);
		
		if ( $this->_allow_change_business ) {
			$this->_CI->load->model('Business_model', 'business_model');
			$business_option_list = $this->_CI->business_model->get_option_list('business_id', 'business_name', array(
				'order_by' => array('business_name', 'asc'),
			));
			
			$fields[] = array(
				'name' => 'business',
				'label' => lang('business'),
				'type' => 'dropdown',
				'attributes' => array(
					'class' => 'form-control',
				),
				'options' => $business_option_list,
			);
		}
		
		$fields[] = array(
			'name' => 'desc',
			'label' => lang('machine_group_desc'),
			'type' => 'textarea',
			'attributes' => array(
				'class' => 'form-control',
				'rows' => 5,
				'cols' => 35,
			),
		);
		
		$bindings = array(
			'machine_group_name' => 'name',
			'machine_group_desc' => 'desc',
		);
		
		if ( $this->_allow_change_business ) {
			$bindings['business_id'] = 'business';
		}
		
		$this->set_fields($fields);
		$this->set_binding('machine_group_model', $bindings);
	}
	
	public function get_buttons()
	{
		$machine_group_model = $this->get_model('machine_group_model');
		
		if ( $machine_group_model->is_new() ) {
			$url = site_url('machine_group/index');
		} else {
			$url = site_url('machine_group/detail/' . $machine_group_model->get_value('machine_group_id'));
		}
		
		return array(
			array(
				'label' => lang('back'),
				'icon' => 'fa fa-chevron-left',
				'link' => $url,
			)
		);
	}
	
	public function set_allow_change_business($allow_change)
	{
		$this->_allow_change_business = ($allow_change ? true : false);
	}
	
	protected function _prep_db_desc($value, $model)
	{
		if ( is_empty($value) ) {
			return null;
		} else {
			return $value;
		}
	}
}