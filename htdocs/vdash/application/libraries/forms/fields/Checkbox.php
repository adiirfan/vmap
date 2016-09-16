<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Option_list.php');

/**
 * Checkbox Class
 * 
 * @author kflee
 *
 */
class Checkbox extends Option_list {
	/**
	 * To define the position of the label. Whether
	 * it should display before or after the radio
	 * button. By default after
	 * 
	 * @var string
	 */
	protected $_label_position = 'after';
	
	/**
	 * The layout of the radio buttons.
	 * Available options:
	 * - inline: All in one line.
	 * - list: Separated by a link break.
	 * 
	 * @var string
	 */
	protected $_layout = 'inline';
	
	/**
	 * Return the label position
	 * 
	 * @return string
	 */
	public function get_label_position()
	{
		return $this->_label_position;
	}
	
	/**
	 * Return the layout.
	 * 
	 * @return string
	 */
	public function get_layout()
	{
		return $this->_layout;
	}
	
	/**
	 * Return the selected checkboxes from the checkbox
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
	 * Return TRUE if the checkbox value was
	 * checked.
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
	
	/**
	 * To set the label position. The acceptable
	 * value can be either after and before only.
	 * 
	 * @param string $position
	 * @return null
	 */
	public function set_label_position($position)
	{
		if ( strtolower($position) == 'before' ) {
			$this->_label_position = 'before';
		} else {
			$this->_label_position = 'after';
		}
	}
	
	/**
	 * Set the radio button layout. Available value
	 * is inline and list.
	 * 
	 * @param string $layout
	 * @return null
	 */
	public function set_layout($layout)
	{
		$this->_layout = $layout;
	}
}