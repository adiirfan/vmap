<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Overidding the CodeIgniter default controller.
 * 
 * @author kflee
 * @version 2.0
 */
class EB_Controller extends CI_Controller {
	
	/**
	 * Default constructor
	 * 
	 * @return null
	 */
	public function __construct()
	{
		parent::__construct();
		
		if ( method_exists($this, 'init') ) {
			$this->init();
		}
	}
	
	/**
	 * To deny the current user's access to
	 * the page requested. By default, user will
	 * be redirected to a page where an error 
	 * message has been set to the flash data.
	 * 
	 * Please refer to System class to retrieve the
	 * message.
	 * 
	 * You can enable the standard error page as well
	 * by passing FALSE to the first parameter.
	 * 
	 * @param boolean optional $redirect To indicate whether the page should be indicate or not.
	 * @param string optional $url The custom URL to be redirected if TRUE was set to the first parameter. 
	 * 
	 * @return null
	 */
	public function access_deny($redirect = false, $url = '/')
	{
		if ( $redirect ) {
			// Set the 401 unauthorized header
			$this->output->set_header('HTTP/1.1 401 Unauthorized');
			
			// Set the error message.
			$this->system->set_message('error', lang('_HTTP_401_title') . ' : ' . lang('_HTTP_401_message'));
			
			redirect($url);
		} else {
			// Show a standard error page.
			show_error(lang('_HTTP_401_message'), 401, lang('_HTTP_401_title'));
		}
	}
	
	// public function _remap($method, $args) {}
}