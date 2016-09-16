<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Captcha Class
 * All captcha class should implement this interface
 * in order to do the validation.
 * 
 * @author kflee
 */
interface Captcha {
	/**
	 * This function should render the HTML output.
	 *
	 * @return string
	 */
	public function render();
	
	/**
	 * This will test the challenge word submitted
	 * by user and return the result. True/False.
	 * 
	 * The first parameter is passed by reference.
	 * You can return a custom error message on this
	 * variable.
	 * 
	 * @param string $error_message
	 * @return boolean
	 */
	public function validate(&$error_message);
}