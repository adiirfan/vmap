<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Form.php');

class Business_form extends Form {
	public function init()
	{
		$fields = array(
			array(
				'name' => 'business_name',
				'type' => 'text',
				'label' => lang('business_name'),
				'tips' => lang('business_name_tips'),
				'rules' => array('required'),
				'attributes' => array(
					'class' => 'form-control',
					'size' => 50,
				),
			),
			array(
				'name' => 'business_code',
				'type' => 'text',
				'label' => lang('business_code'),
				'tips' => lang('business_code_tips'),
				'rules' => array('unique_code'),
				'attributes' => array(
					'class' => 'form-control',
					'size' => 20,
					'maxlength' => 6,
				),
			),
			array(
				'name' => 'business_domain',
				'type' => 'text',
				'label' => lang('business_domain'),
				'tips' => lang('business_domain_tips'),
				'attributes' => array(
					'class' => 'form-control',
					'placeholder' => 'eg: vdash.company.com',
					'size' => 30,
				),
			),
			array(
				'name' => 'max_agents',
				'type' => 'text',
				'label' => lang('business_max_agents'),
				'tips' => lang('business_max_agents_tips'),
				'attributes' => array(
					'class' => 'form-control',
					'size' => 10,
				),
				'value' => 0,
			),
			array(
				'name' => 'business_phone',
				'type' => 'text',
				'label' => lang('business_phone'),
				'attributes' => array(
					'class' => 'form-control',
					'size' => 25,
				),
			),
			array(
				'name' => 'business_fax',
				'type' => 'text',
				'label' => lang('business_fax'),
				'attributes' => array(
					'class' => 'form-control',
					'size' => 25,
				),
			),
			array(
				'name' => 'business_email',
				'type' => 'text',
				'label' => lang('business_email'),
				'attributes' => array(
					'class' => 'form-control',
					'size' => 40,
				),
			),
			array(
				'name' => 'business_profile',
				'type' => 'textarea',
				'label' => lang('business_profile'),
				'tips' => lang('business_profile_tips'),
				'attributes' => array(
					'class' => 'form-control',
					'rows' => 5,
					'cols' => 50,
				),
			),
		);
		
		$this->set_binding('business_model', array(
			'business_code' => 'business_code',
			'business_name' => 'business_name',
			'business_site_domain' => 'business_domain',
			'business_phone' => 'business_phone',
			'business_fax' => 'business_fax',
			'business_email' => 'business_email',
			'business_profile' => 'business_profile',
			'business_max_agent' => 'max_agents',
		));
		
		$this->set_fields($fields);
	}
	
	public function get_buttons()
	{
		$business_model = $this->get_model('business_model');
		
		if ( !$business_model->is_new() ) {
			$business_id = $business_model->get_value('business_id');
			
			return array(
				array(
					'label' => lang('back_to_business_profile'),
					'type' => 'default',
					'link' => site_url('business/profile/' . $business_id),
					'icon' => 'fa fa-chevron-left',
				)
			);
		}
	}
	
	protected function _prep_field_max_agents($value, $field)
	{
		return intval($value);
	}
	
	protected function _val_unique_code($field, $options = array(), &$error_message = '', &$stop = false)
	{
		$code = $field->get_value();
		$business_model = $this->get_model('business_model');
		$is_new = $business_model->is_new();
		
		$db = $this->_CI->db;
		
		$db->from('businesses');
		$db->where('business_code', $code);
		
		if ( !$is_new ) {
			$db->where('business_id <>', $business_model->get_value('business_id'));
		}
		
		$qry = $db->get();
		return true;
		if ( $qry->num_rows() ) {
			$error_message = lang('error_business_code_duplicated');
			
			return false;
		} else {
			return true;
		}
	}
}