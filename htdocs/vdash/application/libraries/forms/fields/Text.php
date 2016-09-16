<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Field.php');

/**
 * Text Field Class
 * Single line textbox.
 * 
 * @author kflee
 */
class Text extends Field {
	public function init()
	{
		$this->add_valid_attribute(array(
			'size', 'maxlength', 'readonly', 'placeholder',
		));
	}
	
	public function constraint_check($value, &$error_message = '')
	{
		if ( false !== ($maxlen = $this->get_attribute('maxlength')) ) {
			if ( strlen($value) > $maxlen ) {
				$error_message = sprintf(lang('_form_error_maxlen'), $maxlen);
				return false;
			}
		}
		
		if ( false !== ($minlen = $this->get_attribute('minlength')) ) {
			if ( strlen($value) < $minlen ) {
				$error_message = sprintf(lang('_form_error_minlen'), $minlen);
				return false;
			}
		}
		
		return true;
	}
}