<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Field.php');

/**
 * Slider input field.
 * 
 * @author kflee
 */
class Slider extends Field {
	/**
	 * Overriding the default init function.
	 * 
	 * @return null
	 */
	public function init()
	{
		$this->add_valid_attribute(array("size"));
		$this->_CI->template->set_js('!/js/form.slider.js');
	}
	
	/**
	 * Overriding the default value setter function.
	 * This function will check the maximum and minimum
	 * limit has been defined by the user. If the value
	 * has exceeded, it will use the maximum value instead.
	 * Vice-versa, it will use the minimum value if the
	 * value is lesser than the limit.
	 * 
	 * @param int $value
	 * @return null
	 */
	public function set_value($value)
	{
		$min = $this->get_data_attribute('min');
		$max = $this->get_data_attribute('max');
		
		parent::set_value($value);
	}
	
	/**
	 * Check the number limit is within the range specified.
	 * The limit validation is inclusive checking.
	 * 
	 * @param Field $field
	 * @param array optional $options
	 * @param string optional $error_message
	 * @param boolean optional $stop
	 * @return boolean
	 */
	protected function _val_limit($field, $options = array(), &$error_message = '', &$stop = false)
	{
		$value = $field->get_value();
		$min = $this->get_data_attribute('min');
		$max = $this->get_data_attribute('max');
		
		if ( false !== $min && $value < $min ) {
			$error_message = sprintf(lang('_form_error_slider_min'), $min);
			return false;
		} else if ( false !== $max && $value > $max ) {
			$error_message = sprintf(lang('_form_error_slider_max'), $max);
			return false;
		}
	}
}