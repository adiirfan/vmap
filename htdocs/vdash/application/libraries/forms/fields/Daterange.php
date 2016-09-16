<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Field.php');

/**
 * Daterange Class
 * https://bootstrap-datepicker.readthedocs.org/
 * 
 * @author kflee
 * @version 3.0
 */
class Daterange extends Field {
	protected $_value = array();
	
	/**
	 * Default initialization.
	 * 
	 * @return null
	 */
	public function init()
	{
		$this->add_valid_attribute(array(
			'size',
		));
		
		$template = $this->_CI->template;
		
		$template->set_css('!/css/bootstrap-datepicker3.min.css');
		
		$template->set_js('!/js/bootstrap-datepicker.min.js');
		$template->set_js('!/js/form.daterange.js');
	}
	
	/**
	 * Get the from date in unix format. Y-m-d
	 * If the date is not valid, FALSE will be return.
	 * 
	 * @return boolean|string
	 */
	public function get_from()
	{
		$from_date = $this->get_value('sys_from');
		
		if ( is_empty($from_date) ) {
			return false;
		} else {
			$time = strtotime($from_date);
			
			if ( false === $time ) {
				return false;
			} else {
				return $from_date;
			}
		}
	}
	
	/**
	 * Get the till date in unix format. Y-m-d
	 * If the date is not valid, FALSE will be return.
	 *
	 * @return boolean|string
	 */
	public function get_till()
	{
		$till_date = $this->get_value('sys_till');
		
		if ( is_empty($till_date) ) {
			return false;
		} else {
			$time = strtotime($till_date);
				
			if ( false === $time ) {
				return false;
			} else {
				return $till_date;
			}
		}
	}
	
	public function get_value($key = '')
	{
		if ( is_empty($key) ) {
			return $this->_value;
		} else {
			return array_ensure($this->_value, $key, '');
		}
	}
	
	/**
	 * To check whether there is a range for the
	 * received date.
	 * 
	 * @return boolean
	 */
	public function has_range()
	{
		$from = $this->get_value('sys_from');
		$till = $this->get_value('sys_till');
		
		if ( $from == $till ) {
			return false;
		} else {
			return true;
		}
	}
}