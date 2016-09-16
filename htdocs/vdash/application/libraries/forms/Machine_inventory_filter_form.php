<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Form.php');

class Machine_inventory_filter_form extends Form {
	
	/**
	 * This will turn on / off the business dropdown list.
	 * 
	 * @var boolean
	 */
	protected $_show_business_filter = false;
	
	public function init()
	{
		$fields = array(
			array(
				'name' => 'filter_keyword',
				'type' => 'text',
				'label' => lang('search_all_columns'),
				'attributes' => array(
					'class' => 'form-control',
					'placeholder' => lang('keywords'),
				),
			),
		);
		
		if ( $this->_show_business_filter ) {
			$this->_CI->load->model('Business_model', 'business_model');
			$business_option_list = $this->_CI->business_model->get_option_list('business_id', 'business_name', array(
				'order_by' => array('business_name', 'asc'),
			));
			
			$business_option_list = array('' => '- ' . lang('business_selection') . ' -') + $business_option_list;
			
			$fields[] = array(
				'name' => 'filter_business',
				'type' => 'dropdown',
				'attributes' => array(
					'class' => 'form-control',
				),
				'options' => $business_option_list,
			);
		}
		
		$this->set_fields($fields);
	}
	
	public function set_show_business_filter($filter)
	{
		$this->_show_business_filter = ($filter ? true : false);
	}
}