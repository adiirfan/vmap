<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Form.php');

class Sys_user_form extends Form {
	
	public function init()
	{
		$this->_CI->load->model('Business_model', 'business_model');
		$sys_user_model = $this->get_model('sys_user_model');
		$business_model = $this->_CI->business_model;
		$current_user_model = $this->_CI->authentication->get_model();
		$is_new = $sys_user_model->is_new();
		$is_same_user = false;
		$user_type_attrs = array(
			'class' => 'form-control',
		);
		
		if ( !$is_new ) {
			$is_same_user = ($sys_user_model->get_value('sys_user_id') == $current_user_model->get_value('sys_user_id'));
			
			if ( $is_same_user ) {
				$user_type_attrs['disabled'] = 'disabled';
			}
		}
		
		$this->_CI->template->set_js('~/js/form.sys_user_form.js');
		
		$business_option_list = $business_model->get_option_list('business_id', 'business_name');
		
		$fields = array(
			'type' => array(
				'name' => 'type',
				'label' => lang('user_type'),
				'type' => 'dropdown',
				'rules' => array('required'),
				'options' => array(
					'superadmin' => lang('user_type_superadmin'),
					'admin' => lang('user_type_admin'),
					'viewer' => lang('user_type_viewer'),
				),
				'attributes' => $user_type_attrs,
			),
			'business' => array(
				'name' => 'business',
				'label' => lang('business'),
				'type' => 'dropdown',
				'rules' => array('required'),
				'attributes' => array(
					'class' => 'form-control',
				),
				'options' => $business_option_list,
			),
			'name' => array(
				'name' => 'name',
				'label' => lang('name'),
				'type' => 'text',
				'rules' => array('required'),
				'attributes' => array(
					'class' => 'form-control',
					'maxlength' => 80,
					'size' => 50,
				),
			),
			'email' => array(
				'name' => 'email',
				'label' => lang('email'),
				'type' => 'text',
				'type' => 'email',
				'rules' => array('required'),
				'attributes' => array(
					'class' => 'form-control',
					'size' => 50,
				),
			),
		);
		
		if ( $is_new ) {
			$fields['password'] = array(
				'name' => 'password',
				'label' => lang('password'),
				'type' => 'text',
				//'rules' => array('required'),
				'attributes' => array(
					'class' => 'form-control',
					'placeholder' => lang('user_new_password_tips'),
					'size' => 30,
				),
			);
		}
		
		$fields = array_merge($fields, array(
			'phone' => array(
				'name' => 'phone',
				'type' => 'text',
				'label' => lang('phone'),
				'attributes' => array(
					'class' => 'form-control',
					'size' => 20,
				),
			),
			'mobile' => array(
				'name' => 'mobile',
				'type' => 'text',
				'label' => lang('mobile'),
				'attributes' => array(
					'class' => 'form-control',
					'size' => 20,
				),
			),
			'remark' => array(
				'name' => 'remark',
				'type' => 'textarea',
				'label' => lang('remark'),
				'attributes' => array(
					'class' => 'form-control',
					'rows' => 5,
					'cols' => 50,
				),
			),
			'mobile' => array(
				'name' => 'mobile',
				'type' => 'text',
				'label' => lang('mobile'),
				'attributes' => array(
					'class' => 'form-control',
				),
			),
			'status' => array(
				'name' => 'status',
				'type' => 'dropdown',
				'label' => lang('status'),
				'options' => array(
					0 => lang('inactive'),
					1 => lang('active'),
				),
				'attributes' => array(
					'class' => 'form-control',
				),
				'value' => 1,
			),
		));
		
		$bindings = array(
			'business_id' => 'business',
			'sys_user_email' => 'email',
			'sys_user_password' => 'password',
			'sys_user_name' => 'name',
			'sys_user_phone' => 'phone',
			'sys_user_mobile' => 'mobile',
			'sys_user_remark' => 'remark',
			'sys_user_type' => 'type',
			'sys_user_valid' => 'status',
		);
		
		if ( $is_new ) {
			if ( $sys_user_model->get_value('business_id') > 0 ) {
				$fields['type']['value'] = 'admin';
				$fields['business']['value'] = $sys_user_model->get_value('business_id');
			} else if ( !is_empty($sys_user_model->get_value('sys_user_type')) ) {
				$fields['type']['value'] = $sys_user_model->get_value('sys_user_type');
			}
		} else {
			unset($bindings['sys_user_password']);
		}
		
		$this->set_fields($fields);
		$this->set_binding('sys_user_model', $bindings);
	}
	
	public function get_buttons()
	{
		$sys_user_model = $this->get_model('sys_user_model');
		$is_new = $sys_user_model->is_new();
		
		if ( !$is_new ) {
			return array(
				array(
					'label' => lang('back'),
					'link' => site_url('sys_user'),
					'type' => 'default',
					'icon' => 'fa fa-chevron-left',
				),
			);
		}
	}
	
	public function on_sys_user_model_save($sys_user_model)
	{
		$user_type = $sys_user_model->get_value('sys_user_type');
		
		if ( $user_type == 'superadmin' ) {
			$sys_user_model->set_value('business_id', null);
		}
	}
	
	protected function _prep_db_password($value, $sys_user_model)
	{
		if ( is_empty($value) ) {
			// Auto generate the password.
			$value = random_string('alnum', 10);
			
			$this->_CI->session->set_flashdata('_tmp_random_password', $value);
		}
		
		$hashed_string = password_hash($value, PASSWORD_DEFAULT);
		
		return $hashed_string;
	}
	
	protected function _prep_submit_business($value, $field)
	{
		$user_type = $this->_CI->input->post('type');
		
		if ( $user_type == 'superadmin' ) {
			// Unset the business fields.
			return 1;
		} else {
			return $value;
		}
	}
}