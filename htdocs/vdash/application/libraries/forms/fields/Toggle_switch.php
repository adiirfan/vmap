<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Text.php');

/**
 * Toggle switch button.
 * 
 * @author kflee
 *
 */
class Toggle_switch extends Text {
	protected $_on_value = 1;
	
	protected $_off_value = 0;
	
	public function init()
	{
		$this->_CI->template->set_css('!/css/bootstrap-switch.min.css');
		$this->_CI->template->set_js('!/js/bootstrap-switch.min.js');
	}
	
	public function get_on_value()
	{
		return $this->_on_value;
	}
	
	public function get_off_value()
	{
		return $this->_off_value;
	}
	
	public function get_value()
	{
		if ( !$this->_value ) {
			return $this->_off_value;
		} else {
			return $this->_on_value;
		}
	}
	
	public function is_off()
	{
		if ( $this->get_value() == $this->_off_value ) {
			return true;
		} else {
			return false;
		}
	}
	
	public function is_on()
	{
		if ( $this->get_value() == $this->_on_value ) {
			return true;
		} else {
			return false;
		}
	}
	
	public function set_off_value($off_value)
	{
		$this->_off_value = $off_value;
	}
	
	public function set_on_value($on_value)
	{
		$this->_on_value = $on_value;
	}
}