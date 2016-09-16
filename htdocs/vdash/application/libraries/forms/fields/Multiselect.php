<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Option_list.php');

/**
 * Multiselect Class
 * 
 * @author kflee
 *
 */
class Multiselect extends Option_list {
	public function init()
	{
		$this->add_valid_attribute(array(
			'size',
		));
	}
	
	/**
	 * Return the selected item(s) from the multiselect
	 * list. It will return false if there is no
	 * checkbox selected.
	 * 
	 * @return array
	 */
	public function get_selected_options()
	{
		if ( iterable($this->_value) ) {
			return $this->_value;
		} else {
			return false;
		}
	}
	
	/**
	 * Return TRUE if the item value was
	 * selected.
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function is_option_selected($value)
	{
		$selected_options = $this->get_selected_options();
		
		if ( false !== $selected_options && in_array($value, $selected_options) ) {
			return true;
		} else {
			return false;
		}
	}
}