<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Text.php');

/**
 * Email Field Class
 * Nothing much different from text. But it allow mobile
 * user to have the alias symbol in their on-screen keyboard.
 * 
 * @author kflee
 */
class Email extends Text {
	public function constraint_check($value, &$error_message = '')
	{
		if ( parent::constraint_check($value, $error_message) ) {
			// Make sure the email address is valid.
			if ( filter_var($value, FILTER_VALIDATE_EMAIL) ) {
				return true;
			} else {
				$error_message = lang('_form_error_invalid_email');
				return false;
			}
		}
		
		return false;
	}
}