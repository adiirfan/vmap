<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'libraries/EB_Library.php');
require_once(dirname(__FILE__) . '/Captcha.php');
// require_once(APPPATH . 'external_libraries/recaptchalib.php');

/**
 * Google Recaptcha Library
 * 
 * Refer to here for more detail:
 * https://developers.google.com/recaptcha/docs/php
 * 
 * @author kflee
 */
class Recaptcha extends EB_Library implements Captcha {
	protected $_private_key = '';
	
	protected $_public_key = '';
	
	public function init()
	{
		$this->_CI->load->library('curl');
		
		$this->_public_key = config_item('recaptcha_public_key');
		$this->_private_key = config_item('recaptcha_private_key');
	}
	
	/**
	 * (non-PHPdoc)
	 * @see application/libraries/forms/captcha/Captcha::render()
	 */
	public function render()
	{
		$this->_CI->template->set_js('//www.google.com/recaptcha/api.js');
		
		$html = '<div class="g-recaptcha" data-sitekey="' . $this->_public_key . '"></div>';
		
		return $html;
	}
	
	public function set_private_key($private_key)
	{
		$this->_private_key = $private_key;
	}
	
	public function set_public_key($public_key)
	{
		$this->_public_key = $public_key;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see application/libraries/forms/captcha/Captcha::validate()
	 */
	public function validate(&$error_message)
	{
		$challenge = $this->_CI->input->get_post('g-recaptcha-response');
		
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$data = array(
			'secret' => $this->_private_key,
			'response' => $challenge,
			'remoteip' => $_SERVER['REMOTE_ADDR'],
		);
		
		$result = $this->_CI->curl->post_json($url, $data, array(
			CURLOPT_HEADER => 0,
		));
		
		if ( $result && isset($result['success']) && $result['success'] ) {
			return true;
		} else {
			$error_message = lang('_form_error_invalid_captcha');
			return false;
		}
	}
}