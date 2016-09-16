<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Option_list.php');

/**
 * Radio Class
 * The native HTML Radio Button Input Element
 * 
 * @author kflee
 */
class Radio extends Option_list {
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
	 * Return the selected radio button's value.
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
	 * in the radio button list.
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