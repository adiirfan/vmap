<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Field.php');

/**
 * Date Class
 * This class provide the input field for date and time.
 * You can turn this element to datetime picker by supplying
 * the following attributes:
 * pick-time => true
 * 
 * For more option info, check out:
 * http://eonasdan.github.io/bootstrap-datetimepicker/
 * 
 * Check out this also, the datetimepicker is derived from this
 * scripts:
 * https://bootstrap-datepicker.readthedocs.org/en/release/options.html
 * 
 * @author kflee
 * @version 2.0
 */
class Date extends Field {
	protected $_value = array();
	
	public function init()
	{
		$this->add_valid_attribute(array(
			'size', 'readonly',
		));
		
		$this->_CI->template->set_css('!/css/bootstrap-datetimepicker.min.css');
		$this->_CI->template->set_js('!/js/moment.min.js');
		
		// Load the locale file.
		$locale = $this->get_locale();
		
		if ( !is_empty($locale) ) {
			$this->_CI->template->set_js('!/js/moment-locale/' . $locale . '.js');
		}
		
		$this->_CI->template->set_js('!/js/bootstrap-datetimepicker.min.js');
		$this->_CI->template->set_js('!/js/form.date.js');
	}
	
	/**
	 * Return the date in specified format. If date
	 * format was not provided, the default ISO date
	 * format will be returned
	 * 
	 * @param string optional $date_format
	 * @return string
	 */
	public function get_date($date_format = '')
	{
		$system_date = $this->get_system_date();
		
		if ( !is_empty($system_date) ) {
			if ( !is_empty($date_format) ) {
				$time = strtotime($system_date);
				
				if ( false !== $time ) {
					return date($date_format, $time);
				}
			}
			
			return $system_date;
		} else {
			return '';
		}
	}
	
	/**
	 * Return the display date. If not set, empty
	 * string will be returned.
	 * 
	 * @return string
	 */
	public function get_display_date()
	{
		return array_ensure($this->_value, 'display', '');
	}
	
	/**
	 * Return the locale code.
	 * 
	 * @return string
	 */
	public function get_locale()
	{
		return '';
	}
	
	/**
	 * Get the system date. The format is in system
	 * format.
	 * 
	 * @return string
	 */
	public function get_system_date()
	{
		return array_ensure($this->_value, 'system', '');
	}
	
	/**
	 * Check if the field's value is empty.
	 * 
	 * @return boolean
	 */
	public function is_empty()
	{
		$sys_date = array_ensure($this->_value, 'system', '');
		
		return is_empty($sys_date);
	}
	
	/**
	 * To set the date value. It accept two types of value.
	 * Array: It must consist of two items: system and display
	 *   The system date format is for internal use.
	 *   The display date format is for user display date.
	 * String: It has to be a valid string format within PHP application.
	 * 
	 * @param array|string $value
	 * @return null
	 */
	public function set_value($value)
	{
		if ( iterable($value) ) {
			parent::set_value($value);
		} elseif ( gettype($value) == 'string' ) {
			$time = strtotime($value);
			
			if ( false !== $time ) {
				$date_format = $this->get_attribute('format');
				$date = '';
				
				if ( is_empty($date_format) ) {
					$date = date('Y-m-d', $time);
				} else {
					$sys_format = $this->_to_system_format($date_format);
					$date = date($sys_format, $time);
				}
				
				$this->_value = array(
					'system' => $date,
				);
			}
		}
	}
	
	/**
	 * Convert a moment date/time format to php system
	 * format.
	 * 
	 * @param string $format
	 * @return string
	 */
	protected function _to_system_format($format)
	{
		$date_token = array('M', 'D', 'd', 'Y', 'g', 'G');
		$time_token = array('A', 'a', 'H', 'h', 'm', 's', 'S');
		$has_date = false;
		$has_time = false;
		$system_format = '';
		
		foreach ( $date_token as $token ) {
			if ( preg_match('/' . $token . '/', $format) ) {
				$has_date = true;
				break ;
			}
		}
		
		foreach ( $time_token as $token ) {
			if ( preg_match('/' . $token . '/', $format) ) {
				$has_time = true;
				break ;
			}
		}
		
		if ( $has_date ) {
			$system_format = 'Y-m-d';
		}
		
		if ( $has_time ) {
			if ( !is_empty($system_format) ) {
				$system_format .= ' ';
			}
			
			$system_format .= 'H:i:s';
		}
		
		return $system_format;
	}
}