<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/../../EB_Library.php');

/**
 * Form Field Class
 * All field should extend from this class in order
 * to use on the Form class.
 * 
 * @author kflee
 * @abstract
 */
abstract class Field extends EB_Library {
	/**
	 * The HTML input attribute. The key will
	 * be the name of the attribute. If these
	 * attributes is not in the valid attribute
	 * list, it will be parsed as data attribute.
	 * A data- prefix will be added. Eg:
	 * $_attributes = array('name', 'class', 'myname')
	 * Will generate the following input element:
	 * <input name="" class="" data-myname="" />
	 * 
	 * @var array
	 */
	protected $_attributes = array();
	
	/**
	 * This will atuo assign an ID to the form field
	 * when the set_name method has been called. Set
	 * this to FALSE to disable this feature.
	 * 
	 * The system will not set the ID attribute if
	 * there is already an ID assigned.
	 * 
	 * @var boolean
	 */
	protected $_auto_assign_id = true;
	
	/**
	 * The reference to the form object that
	 * this field has added to.
	 * 
	 * @var Form
	 */
	protected $_form = null;
	
	/**
	 * The label of this field.
	 * 
	 * @var string
	 */
	protected $_label = '';
	
	/**
	 * Name of the field.
	 * 
	 * @var string
	 */
	protected $_name = '';
	
	/**
	 * The validation rules associated to this field.
	 * The key of the array is the validation rule's
	 * name while the value will be an associative 
	 * array that act as an option or parameter to the
	 * validation rule.
	 * 
	 * @var array
	 */
	protected $_rules = array();
	
	/**
	 * The tooltips or help message about this field.
	 * Similar to label, it only display a string of
	 * text.
	 * 
	 * @var string
	 */
	protected $_tips = '';
	
	/**
	 * The list of allowed attributes for this field.
	 * If the attribute did not defined here, the 
	 * attribute will stored in the data attribute
	 * where it will prepend a prefix "data-" to each
	 * data attribute.
	 * 
	 * @var array
	 */
	protected $_valid_attributes = array(
		// These are the global attribute that available to all HTML element.
		'accesskey', 'class', 'contenteditable', 'contextmenu', 'dir', 'draggable',
		'dropzone', 'hidden', 'id' ,'lang', 'spellcheck', 'style',
		'tabindex', 'title', 'translate'
	);
	
	/**
	 * This will be the form field's value. It
	 * can accept string or array. By default,
	 * when it was not initialized, the value
	 * will be NULL.
	 * 
	 * This value is only used to interpret on the
	 * form, not for database or model use.
	 * 
	 * @var mixed
	 */
	protected $_value = null;
	
	/**
	 * 
	 * 
	 * @param array optional $options
	 * @return null
	 *
	public function __construct($options = array())
	{
		
	}*/
	
	/**
	 * To add one or more than one attributes to the 
	 * field.
	 * 
	 * @param string|array $attr
	 * @return null
	 */
	public function add_valid_attribute($attr)
	{
		if ( iterable($attr) ) {
			foreach ( $attr as $attr_name ) {
				$this->_valid_attributes[] = $attr_name;
			}
		} else {
			$this->_valid_attributes[] = $attr;
		}
	}
	
	/**
	 * This method will called everytime the form
	 * has been submitted. This method is used to
	 * verify the posted back value and make sure
	 * is a valid constraint.
	 * 
	 * This is different from validation rule as 
	 * validation rule can be optional based on the
	 * programmer's preference.
	 * 
	 * While this constraint check will executed
	 * everytime that the form is posted.
	 * 
	 * Application:
	 * - maxlength
	 * - minlength
	 * - max_filesize
	 * - option list (dropdown or checkbox domain)
	 * 
	 * If FALSE is return, an error will be set to the
	 * field. No validation rules will be executed and
	 * the value will not be set into the field object.
	 * 
	 * @param mixed $value
	 * @param string optional $error_message
	 * @return boolean
	 */
	public function constraint_check($value, &$error_message = '')
	{
		return true;
	}
	
	/**
	 * This will generate the HTML attribute string
	 * for the HTML output. Beware, it will not include
	 * the following attributes:
	 * 'name' and 'type'
	 * 
	 * @return string
	 */
	public function generate_html_attribute()
	{
		$output = '';
		
		if ( iterable($this->_attributes) ) {
			foreach ( $this->_attributes as $attr_name => $attr_value ) {
				if ( !$this->is_valid_attribute($attr_name) ) {
					$attr_name = 'data-' . $attr_name;
				}
				
				$output .= $attr_name . '="' . htmlentities($attr_value) . '" ';
			}
		}
		
		return rtrim($output);
	}
	
	/**
	 * Return a attribute value if it exists or
	 * FALSE if it does not exists.
	 * 
	 * If first paramter did not provided, an 
	 * array will be returned.
	 * 
	 * @param string optional $attr_name
	 * @return string|array|boolean
	 */
	public function get_attribute($attr_name = '')
	{
		if ( !is_empty($attr_name) ) {
			return array_ensure($this->_attributes, $attr_name, false);
		} else {
			return $this->_attributes;
		}
	}
	
	/**
	 * Check and see if the auto ID assign feature has
	 * turned on/off
	 * 
	 * @return boolean
	 */
	public function get_auto_assign_id()
	{
		return $this->_auto_assign_id;
	}
	
	/**
	 * Return the Form object that this field
	 * is assigned to. It will return NULL if
	 * this field has no form assigned.
	 * 
	 * @return Form
	 */
	public function get_form()
	{
		return $this->_form;
	}
	
	/**
	 * Return the label of the field.
	 * 
	 * @return string
	 */
	public function get_label()
	{
		return $this->_label;
	}
	
	/**
	 * Get the form field's name.
	 * 
	 * @return string
	 */
	public function get_name()
	{
		return $this->_name;
	}
	
	/**
	 * This function will return the rule's parameter
	 * if the rule's name exists.
	 * 
	 * If the rule does not exists, it will return FALSE.
	 * 
	 * @param string $rule_name
	 * @return mixed
	 */
	public function get_rule($rule_name)
	{
		return array_ensure($this->_rules, $rule_name, false);
	}
	
	/**
	 * Return all rules in array format.
	 * The array key will be the rule's name
	 * while the value will be the parameter.
	 * 
	 * @return array
	 */
	public function get_rules()
	{
		return $this->_rules;
	}
	
	/**
	 * Get the field's tips.
	 * 
	 * @return string
	 */
	public function get_tips()
	{
		return $this->_tips;
	}
	
	/**
	 * Return the list of rules that was not defined
	 * in this Field class. The returned array consists
	 * of the rule's name and it's parameters in associative
	 * array format.
	 * 
	 * @return array
	 */
	public function get_undefined_rules()
	{
		if ( iterable($this->_rules) ) {
			$undefined_rules = array();
			
			foreach ( $this->_rules as $rule_name => $rule_param ) {
				$method_name = '_val_' . $rule_name;
				
				if ( !method_exists($this, $method_name) ) {
					$undefined_rules[$rule_name] = $rule_param;
				}
			}
			
			return $undefined_rules;
		} else {
			return array();
		}
	}
	
	/**
	 * Return all valid attributes for this field.
	 * 
	 * @return array
	 */
	public function get_valid_attributes()
	{
		return $this->_valid_attributes;
	}
	
	/**
	 * Return the field's value.
	 * 
	 * @return mixed
	 */
	public function get_value()
	{
		return $this->_value;
	}
	
	/**
	 * Check if an attribute name exists in this field.
	 * 
	 * @param string $attr_name
	 * @return boolean
	 */
	public function has_attribute($attr_name)
	{
		return isset($this->_attributes[$attr_name]);
	}
	
	/**
	 * Check if the rule name has added to this
	 * field object or not.
	 * 
	 * @param string $rule_name
	 * @return boolean
	 */
	public function has_rule($rule_name)
	{
		return isset($this->_rules[$rule_name]);
	}
	
	/**
	 * Return TRUE if there is tips for this
	 * field
	 * 
	 * @return boolean
	 */
	public function has_tips()
	{
		return !is_empty($this->_tips);
	}
	
	/**
	 * Check if the attribute provided is valid.
	 * 
	 * @param string $attr
	 */
	public function is_attribute_valid($attr)
	{
		return in_array($attr, $this->_attributes);
	}
	
	/**
	 * Check if the field's value is empty.
	 * 
	 * @return boolean
	 */
	public function is_empty()
	{
		if ( is_array($this->_value) ) {
			return !iterable($this->_value);
		} else {
			return is_empty($this->_value);
		}
	}
	
	/**
	 * Check if the attribute name is a valid attribute
	 * in this form field.
	 * 
	 * @param string $attr_name
	 * @return boolean
	 */
	public function is_valid_attribute($attr_name)
	{
		return in_array($attr_name, $this->_valid_attributes);
	}
	
	/**
	 * To remove all attributes that has 
	 * been set to this field.
	 * 
	 * @return null
	 */
	public function remove_all_attributes()
	{
		$this->_attributes = array();
	}
	
	/**
	 * Remove a particular rule from the field.
	 * It will return TRUE if the rule was exists in the
	 * field or FALSE otherwise.
	 * 
	 * @param string $rule_name
	 * @return boolean
	 */
	public function remove_rule($rule_name)
	{
		if ( isset($this->_rules[$rule_name]) ) {
			unset($this->_rules[$rule_name]);
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * To remove all valid attribute's names.
	 * 
	 * @return null
	 */
	public function remove_all_valid_attributes()
	{
		$this->_valid_attributes = array();
	}
	
	/**
	 * To remove a particular attribute from this
	 * field object. It will return FALSE if the
	 * attribute name was not found on this field.
	 * 
	 * @param string $attr_name
	 * @return boolean
	 */
	public function remove_attribute($attr_name)
	{
		if ( isset($this->_attributes[$attr_name]) ) {
			unset($this->_attributes[$attr_name]);
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * To remove a valid attribute name from the field.
	 * It will return FALSE if the attribute name does
	 * not exists in the field.
	 * 
	 * @param string $attr_name
	 * @return boolean
	 */
	public function remove_valid_attribute($attr_name)
	{
		$index = array_search($attr_name, $this->_valid_attributes);
		
		if ( false !== $index ) {
			unset($this->_valid_attributes[$index]);
			$this->_valid_attributes = array_values($this->_valid_attributes);
			
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * The form field's rendering function.
	 * It will be called when the form is being
	 * rendered. This function will pass the necessary
	 * variable to the template view script according
	 * to the element's name. Eg: Input will use the 
	 * view script: /views/forms/fields/input.php
	 * 
	 * It accept path token to be used in the script.
	 * 
	 * You may override this method to return a custom
	 * HTML output.
	 * 
	 * @return string
	 */
	public function render()
	{
		// Generate the HTML attribute string.
		$html_attribute = $this->generate_html_attribute();
		
		// Get the view script path.
		$script_path = $this->_CI->template->get_view_path('forms/fields/' . strtolower(get_class($this)));
		
		if ( false !== $script_path ) {
			$output = $this->_CI->load->view($script_path, array(
				'form' => $this->get_form(),
				'field' => $this,
				'name' => $this->get_name(),
				'html_attribute' => $html_attribute,
			), true);
			
			return $this->_CI->template->get_base_url($output);
		} else {
			log_message('error', 'No view found for the HTML input element: ' . get_class($this));
			show_error(lang('_error_form_field_view_not_found'));
		}
	}
	
	/**
	 * To set an form field's attribute. It has to
	 * be valid attribute otherwise, it will be
	 * ignored.
	 * 
	 * @param string $name
	 * @param string $value
	 * @return null
	 */
	public function set_attribute($name, $value)
	{
		// Transform the name to lowercase.
		$name = strtolower($name);
		
		$this->_attributes[$name] = $value;
	}
	
	/**
	 * To set multiple attributes to the form field
	 * object. Invalid attribute will be ignored.
	 * 
	 * @param array $attributes
	 * @return null
	 */
	public function set_attributes($attributes)
	{
		if ( iterable($attributes) ) {
			foreach ( $attributes as $name => $value ) {
				$this->set_attribute($name, $value);
			}
		}
	}
	
	/**
	 * To turn on/off the auto ID assign feature.
	 * 
	 * @param boolean $auto
	 * @return null
	 */
	public function set_auto_assign_id($auto)
	{
		$this->_auto_assign_id = $auto;
	}
	
	/**
	 * Set the Form object reference.
	 * 
	 * @param Form $form
	 * @return null
	 */
	public function set_form($form)
	{
		if ( $form instanceof Form ) {
			$this->_form = $form;
		} else {
			log_message('error', 'Invalid object set to the field\'s reference to the form. Please check on this class file: ' . get_class($this));
			show_error(lang('_error_form_invalid_form_object'));
		}
	}
	
	/**
	 * To set the field's label.
	 * 
	 * @param string $label
	 * @return null
	 */
	public function set_label($label)
	{
		$this->_label = $label;
	}
	
	/**
	 * Set the field's name. This will automatically
	 * assign the name as the ID if there isn't any
	 * ID specified for this field and the auto_assign_id
	 * has turned to TRUE.
	 * 
	 * @param string $name
	 * @return null
	 */
	public function set_name($name)
	{
		$this->_name = $name;
		
		if ( $this->_auto_assign_id && false === $this->get_attribute('id') ) {
			$this->set_attribute('id', $this->_generate_id());
		}
	}
	
	/**
	 * To set a validation rule for this field.
	 * 
	 * @param string $rule_name
	 * @param array optional $rule_param
	 * @return null
	 */
	public function set_rule($rule_name, $rule_param = array())
	{
		$this->_rules[$rule_name] = $rule_param;
	}
	
	/**
	 * To set multiple validation rules to this field.
	 * The array value can be the validation parameter
	 * while the array key is the validation name. If
	 * the validation rule has no parameter, just pass
	 * the validation name as the array value.
	 * 
	 * @param array $rules
	 * @return null
	 */
	public function set_rules($rules)
	{
		if ( iterable($rules) ) {
			foreach ( $rules as $name => $param ) {
				if ( preg_match('/^\d+$/', $name) ) {
					$name = $param;
					$param = array();
				}
				
				$this->set_rule($name, $param);
			}
		}
	}
	
	/**
	 * Set the tips for this field.
	 * 
	 * @param string $tips
	 * @return null
	 */
	public function set_tips($tips)
	{
		$this->_tips = $tips;
	}
	
	/**
	 * To remove the current valid attribute and set a new
	 * set of valid attributes.
	 * 
	 * @param array $attribute
	 * @return null
	 */
	public function set_valid_attributes($attributes)
	{
		$this->remove_all_valid_attributes();
		
		$this->_valid_attributes = $attributes;
	}
	
	/**
	 * Set the form field's value.
	 * 
	 * @param mixed $value
	 * @return null
	 */
	public function set_value($value)
	{
		$this->_value = $value;
	}
	
	/**
	 * A proxy to call up the validation method.
	 * 
	 * @param string $rule_name The name without prefix _val_
	 * @param array $param
	 * @param string optional $error_messages
	 * @param boolean optional $stop
	 * @return boolean
	 */
	public function validate($rule_name, $param, &$error_messages = '', &$stop = false)
	{
		$method_name = '_val_' . $rule_name;
		
		if ( method_exists($this, $method_name) ) {
			return call_user_func_array(array($this, $method_name), array(
				$this,
				$param,
				&$error_messages,
				&$stop,
			));
		}
	}
	
	/**
	 * This will generate the ID attribute for the
	 * field if no ID was specified. By default,
	 * it will use the same value as the field's name.
	 * The function will convert underscore (_) to 
	 * dash (-).
	 * 
	 * If field's name was not provided, a random string
	 * will be generated.
	 * 
	 * @return string
	 */
	protected function _generate_id()
	{
		if ( !is_empty($this->_name) ) {
			$id = preg_replace('/_/', '-', $this->_name);
			
			return $id;
		} else {
			return hashids_encrypt(rand(1000, 9999), null, 8);
		}
	}
}