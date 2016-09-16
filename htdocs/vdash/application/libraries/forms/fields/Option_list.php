<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Field.php');

/**
 * Option List Class
 * Field that has a list of option as choices
 * should extend this class.
 * 
 * @abstract
 * @author kflee
 */
abstract class Option_list extends Field {
	/**
	 * This is the attribute for each options.
	 * It's a key pair array with the key as the
	 * key of the option, the value is an associated
	 * array where the key will be the attribute
	 * name, and the value will be the attribute value.
	 * 
	 * EG:
	 * array(
	 *   <option_key> => array(
	 *     <attribute_name> => <attribute_value>,
	 *     <attribute_name> => <attribute_value>,
	 *     <attribute_name> => <attribute_value>,
	 *     ...
	 *   ),
	 *   ...
	 * )
	 * 
	 * @var array
	 */
	protected $_option_attributes = array();
	
	/**
	 * The list of options that available for user to choose
	 * from.
	 * The array key will be the value which used for internal
	 * tracking purpose. The value will be the text display
	 * on the form.
	 * 
	 * @array
	 */
	protected $_options = array();
	
	public function constraint_check($value, &$error_message = '')
	{
		if ( iterable($value) ) {
			foreach ( $value as $val ) {
				if ( !$this->has_option($val) ) {
					
					$error_message = lang('_form_error_option_outofdomain');
					return false;
				}
			}
		} elseif ( !$this->has_option($value) ) {
			$error_message = lang('_form_error_option_outofdomain');
			return false;
		}
		
		return true;
	}
	
	/**
	 * To get the option text that display on the screen.
	 * If the value not found, false will be returned.
	 * 
	 * @param string $value
	 * @return string|boolean
	 */
	public function get_option_text($value)
	{
		return array_ensure($this->_options, $value, false);
	}
	
	/**
	 * Get attribute options by the option key.
	 * If it is not found, FALSE will be returned.
	 * Otherwise, an associative array will be
	 * returned.
	 * 
	 * @param string $key
	 * @return array
	 */
	public function get_option_attribute($key)
	{
		$attributes = array_ensure($this->_option_attributes, $key, false);
		
		return $attributes;
	}
	
	/**
	 * This will return the HTML string which you can
	 * use it inside the html tag. Eg:
	 * <option<?php echo $field->get_option_attribute_html('field_name'); ?>></option>
	 * 
	 * @param string $key
	 * @return string
	 */
	public function get_option_attribute_html($key)
	{
		$attributes = $this->get_option_attribute($key);
		$html = '';
		
		if ( iterable($attributes) ) {
			foreach ( $attributes as $name => $value ) {
				$html .= $name . '="' . htmlentities($value) . '" ';
			}
			
			$html = ' ' . trim($html);
		}
		
		return $html;
	}
	
	/**
	 * Return the whole list of options.
	 * 
	 * @return array
	 */
	public function get_options()
	{
		return $this->_options;
	}
	
	/**
	 * Check if the option exists with the value
	 * provided.
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function has_option($value)
	{
		return (isset($this->_options[$value]) ? true : false);
	}
	
	/**
	 * Custom error message for checkbox when the 
	 * field is empty.
	 * 
	 * @return string
	 */
	public function on_errmsg_required()
	{
		return lang('_form_error_option_empty');
	}
	
	/**
	 * To set an option into the option list object.
	 * If second parameter did not provided, the text
	 * will be used as value.
	 * 
	 * @param string $text
	 * @param string optional $value
	 * @return null
	 */
	public function set_option($text, $value = '')
	{
		if ( is_empty($value) ) {
			$value = $text;
		}
		
		$this->_options[$value] = $text;
	}
	
	public function set_option_attribute($option_key, $attribute_name, $attribute_value)
	{
		if ( !isset($this->_option_attributes[$option_key]) ) {
			$this->_option_attributes[$option_key] = array();
		}
		
		$this->_option_attributes[$option_key][$attribute_name] = $attribute_value;
	}
	
	public function set_option_attributes($attributes)
	{
		if ( iterable($attributes) ) {
			foreach ( $attributes as $key => $value ) {
				if ( iterable($value) ) {
					foreach ( $value as $attr_name => $attr_value ) {
						$this->set_option_attribute($key, $attr_name, $attr_value);
					}
				}
			}
		}
	}
	
	/**
	 * To set multiple options to the option list.
	 * The array key will be used as the option
	 * value while the value will be used as option
	 * text.
	 * 
	 * @param array $options
	 * @return null
	 */
	public function set_options($options)
	{
		if ( iterable($options) ) {
			foreach ( $options as $value => $text ) {
				$this->_options[$value] = $text;
			}
		}
	}
	
	/**
	 * Overriding the parent set_value method. This will
	 * make sure the value received is within the option
	 * list (same domain). If the value provided is not
	 * in the option list, no value will be set.
	 * 
	 * @param mixed $value
	 * @return null
	 */
	public function set_value($value)
	{
		// Check and make sure the value received as in the specified domain.
		if ( iterable($value) ) {
			foreach ( $value as $val ) {
				if ( !$this->has_option($val) ) {
					return ;
				}
			}
		} elseif ( gettype($value) == 'string' ) {
			if ( !$this->has_option($value) ) {
				return ;
			}
		}
		
		parent::set_value($value);
	}
	
	/**
	 * Return the selected option(s). It might be a single
	 * string or list of selected string in array format.
	 * Depending on the type of Field this method is
	 * extending, it might return different value.
	 * 
	 * @return string|array
	 */
	abstract public function get_selected_options();
	
	/**
	 * To check if the option is selected. Each sub class
	 * should implement this method and return the appropriate
	 * boolean value.
	 * 
	 * @param string $value
	 * @return boolean
	 */
	abstract public function is_option_selected($value);
	
	
}