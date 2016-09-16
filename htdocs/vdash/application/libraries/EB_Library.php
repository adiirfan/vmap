<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This is the standard library class. All EB library should extends
 * from this library.
 * 
 * @author Kent Lee
 * @abstract
 */
abstract class EB_Library {
	/**
	 * @var CI_Controller
	 */
	protected $_CI;
	
	/**
	 * This is the default constructor
	 * 
	 * @param array optional $options
	 * @return null
	 */
	public function __construct($options = array())
	{
		$this->_CI =& get_instance();
		
		$this->_initialize_options($options);
		
		if ( method_exists($this, 'init') ) {
			$this->init($options);
		}
	}
	
	/**
	 * To return the configuration value from the config folders.
	 * 
	 * The second parameter will be returned if the value not found.
	 * 
	 * @param string $config_name
	 * @param mixed optional $default_value
	 * @return mixed
	 */
	protected function _get_config($config_name, $default_value = '')
	{
		$config_value = $this->_CI->config->item($config_name);
		
		if ( is_empty($config_value) ) {
			return $default_value;
		} else {
			return $config_value;
		}
	}
	
	/**
	 * This will initialize the options when initializing the library.
	 * Each options key will used as the setter name.
	 * 
	 * E.g.:
	 * array("name" => "my value");
	 * Then the function will search for the function named "set_name" and
	 * pass the "my value" as the first parameter.
	 * 
	 * This function will return the number of setter method found.
	 * 
	 * @param array $options
	 * @return int
	 */
	protected function _initialize_options($options)
	{
		$found = 0;
		
		if ( is_array($options) && sizeof($options) ) {
			foreach ( $options as $option_name => $option_value ) {
				$setter_method = 'set_' . $option_name;
				
				if ( method_exists($this, $setter_method) ) {
					$this->$setter_method($option_value);
					
					$found ++;
				}
			}
		}
		
		return $found;
	}
}