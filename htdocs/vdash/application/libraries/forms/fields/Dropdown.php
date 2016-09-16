<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Option_list.php');

/**
 * Dropdown Class
 * 
 * @author kflee
 *
 */
class Dropdown extends Option_list {
	
	public function init()
	{
		$this->add_valid_attribute(array(
			'disabled',
		));
	}
	
	/**
	 * Return the selected dropdown's value.
	 * It will return FALSE if there is no selected
	 * value found.
	 * 
	 * @return string
	 */
	public function get_selected_options()
	{
		if ( !is_empty($this->_value) && isset($this->_options[$this->_value]) ) {
			return $this->_value;
		} else {
			return false;
		}
	}
	
	/**
	 * Check if the first parameter value was selected
	 * in the dropdwon list.
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function is_option_selected($value)
	{
		$selected_option = strval($this->get_selected_options());
		
		if ( $selected_option === strval($value) ) {
			return true;
		} else {
			return false;
		}
	}
}