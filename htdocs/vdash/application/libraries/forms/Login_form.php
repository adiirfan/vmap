<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Form.php');

class Login_form extends Form {
	public function init()
	{
		$fields = array(
			array(
				'name' => 'email',
				'type' => 'text',
				'label' => lang('email'),
				'rules' => array('required'),
				'attributes' => array(
					'class' => 'form-control',
				),
			),
			array(
				'name' => 'password',
				'type' => 'password',
				'label' => lang('password'),
				'rules' => array('required'),
				'attributes' => array(
					'class' => 'form-control',
				),
			),
		);
		
		if ( ENVIRONMENT == 'production' ) {
			$this->set_captcha('recaptcha');
		}
		
		$this->set_fields($fields);
	}
	
	public function on_success()
	{
		$sys_user_model = $this->get_model('sys_user_model');
		
		$email = $this->get_field_value('email');
		$password = $this->get_field_value('password');
		$error_message = '';
		
		if ( !$sys_user_model->login($email, $password, $error_message) ) {
			$this->set_error('_form', $error_message);
		}
	}
}