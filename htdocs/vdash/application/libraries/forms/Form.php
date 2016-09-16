<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/../EB_Library.php');

/**
 * Form Class
 * 
 * -------------------------------------
 * Dependencies
 * -------------------------------------
 * + System (Library)
 * + Template (Library)
 * + URL (Helper)
 * 
 * @author kflee
 */
class Form extends EB_Library {
	/**
	 * The form action URL. This URL will automatically
	 * converted to full site url using the site_url()
	 * function.
	 * 
	 * @var string
	 */
	protected $_action = '';
	
	/**
	 * Binding between the database model's property
	 * and the field. The key will be the model's
	 * property and the value will be the field's name.
	 * 
	 * @var array
	 */
	protected $_bindings = array();
	
	/**
	 * The captcha library name.
	 * 
	 * @var string
	 */
	protected $_captcha = '';
	
	/**
	 * The captcha object after initialized from the
	 * constructor. It will be null if there are no
	 * captcha used in this form.
	 * 
	 * @var Captcha
	 */
	protected $_captcha_object = null;
	
	/**
	 * The form encoding type. There are three possible
	 * values:
	 * - application/x-www-form-urlencoded
	 * - multipart/form-data
	 * - text/plain
	 * 
	 * @var string
	 */
	protected $_enctype = 'application/x-www-form-urlencoded';
	
	/**
	 * The list of error message associated with the
	 * field's name. Each field can have more than one
	 * error message.
	 * 
	 * A special keys named used for form error called:
	 * _form. This is a reserved key for form error message.
	 * _captcha. This is reserved key for captcha error message.
	 * 
	 * @var array
	 */
	protected $_errors = array();
	
	/**
	 * The extra button HTML code here. It will appear along with
	 * the submit buttons.
	 * 
	 * @var string
	 */
	protected $_extra_button = '';
	
	/**
	 * The fields added to this form. The field's order
	 * are followed as it defined in the array.
	 * 
	 * The key of the array will be the form field's name.
	 * 
	 * @var array
	 */
	protected $_fields = array();
	
	/**
	 * Form groups. The array key will be the group's ID.
	 * The value will be an associative array consists of
	 * the following elements:
	 * - label   : A string that represent the label and will appear in the page.
	 * - fields  : An array list of the field's name that should appear in this group.
	 * 
	 * Example:
	 * array(
	 *     'user_detail' => array(
	 *         'label'  => 'User Detail',
	 *         'fields' => array(
	 *             'firstname', 'lastname', 'email', 'gender', 'dob',
	 *             'address', ... more
	 *         )
	 *     ),
	 *     'user_picture' => array(
	 *         'label' => 'Photos',
	 *         'fields' => array(
	 *             'photo_attachment'
	 *         ),
	 *     ),
	 * )
	 * 
	 * @var array
	 */
	protected $_groups = array();
	
	/**
	 * The form layout view script.
	 * It has to stored relatively under /views/forms/
	 * folder. If theme folder had same layout name
	 * under the forms folder, it will be used.
	 * 
	 * @var string
	 */
	protected $_layout = 'default';
	
	/**
	 * This data will send to the layout script file.
	 * 
	 * @var array
	 */
	protected $_layout_data = array();
	
	/**
	 * The form submission method. It can be either
	 * "get" or "post"
	 * 
	 * @var string
	 */
	protected $_method = 'post';
	
	/**
	 * The database model. They key will be
	 * the model's ID. The model can be the
	 * model class name.
	 * 
	 * @var array
	 */
	protected $_models = array();
	
	/**
	 * The forms name.
	 * 
	 * @var string
	 */
	protected $_name = '';
	
	/**
	 * Toggle the reset button.
	 * 
	 * @var boolean
	 */
	protected $_reset_button = false;
	
	/**
	 * The reset button label.
	 * 
	 * @var string
	 */
	protected $_reset_label = '';
	
	/**
	 * The submit button's label.
	 * 
	 * @var string
	 */
	protected $_submit_label = '';
	
	/**
	 * Cross site request forgery prevention
	 * feature. To prevent unauthorized
	 * request to submit a form.
	 * 
	 * @var boolean
	 */
	protected $_xsrf_protection = true;
	
	/**
	 * Overriding the default constructor. The form
	 * library will process after the "init" function
	 * being called. You should do the form initialization
	 * in the "init" function.
	 * 
	 * @param array optional $options
	 * @return null
	 */
	public function __construct($options = array())
	{
		parent::__construct($options);
		
		if ( is_empty($this->_submit_label) ) {
			// Use default submit label.
			$this->_submit_label = lang('_form_button_submit');
		}
		
		if ( is_empty($this->_reset_label) ) {
			$this->_reset_label = lang('_form_button_reset');
		}
		
		if ( !is_empty($this->_captcha) ) {
			$this->_initialize_captcha();
		}
		
		// Process the form.
		$this->_process();
	}
	
	/**
	 * To generate the HTML closing form.
	 * 
	 * @return string
	 * 
	 */
	public function form_close()
	{
		return '</form>';
	}
	
	/**
	 * To generate the HTML form header
	 * 
	 * @return string
	 */
	public function form_open()
	{
		$action = $this->_action;
		
		if ( !is_absolute_url($action) ) {
			$action = site_url($action);
		}
		
		$str = '<form';
		$str .= ' name="' . $this->_name . '"';
		$str .= ' method="' . $this->_method . '" action="' . $action . '"';
		$str .= ' enctype="' . $this->_enctype . '"';
		$str .= '>';
		
		return $str;
	}
	
	/**
	 * Return the action URL of this form.
	 * 
	 * @return string
	 */
	public function get_action()
	{
		return $this->_action;
	}
	
	/**
	 * Return the binding for a model in this form.
	 * 
	 * If the model ID was not found, FALSE will be
	 * returned.
	 * 
	 * @param string $model_id
	 * @return array|boolean
	 */
	public function get_binding($model_id)
	{
		return array_ensure($this->_bindings, $model_id, false);
	}
	
	/**
	 * Return all model bindings of this form.
	 * 
	 * @return array
	 */
	public function get_bindings()
	{
		return $this->_bindings;
	}
	
	/**
	 * Return the captcha object.
	 * 
	 * @return string
	 */
	public function get_captcha()
	{
		return $this->_captcha_object;
	}
	
	/**
	 * Return the encoding type of this form.
	 * 
	 * @return string
	 */
	public function get_enctype()
	{
		return $this->_enctype;
	}
	
	/**
	 * Return the error of a field. It will return
	 * FALSE if there is no error for the field.
	 * 
	 * @param string optional $field_name
	 * @return array|false
	 */
	public function get_error($field_name)
	{
		return array_ensure($this->_errors, $field_name, false);
	}
	
	/**
	 * Return all error messages
	 * 
	 * @return array
	 */
	public function get_errors()
	{
		return $this->_errors;
	}
	
	/**
	 * Get the error message for a field. It will combine
	 * all error message with prefix and suffix on each 
	 * error.
	 * 
	 * @param string $field_name
	 * @param string optional $glue
	 * @return string
	 */
	public function get_error_message($field_name, $prefix = '', $suffix = '<br />')
	{
		$error = $this->get_error($field_name);
		
		if ( false !== $error && iterable($error) ) {
			$error_messages = array_values($error);
			$output = '';
			
			for ( $i=0; $i<sizeof($error_messages); $i++ ) {
				$error_message = $error_messages[$i];
				
				if ( $i != 0 ) {
					$output .= $prefix;
				}
				
				$output .= $error_message;
				
				if ( $i < (sizeof($error_messages) - 1) ) {
					$output .= $suffix;
				}
			}
			
			return $output;
		} else {
			return '';
		}
	}
	
	/**
	 * Return all error messages that associated to the 
	 * form field name and special token name:
	 * _form
	 * _captcha.
	 * 
	 * @return array
	 */
	public function get_error_messages()
	{
		return $this->_errors;
	}
	
	/**
	 * Return the extra button HTML codes.
	 * 
	 * @return string
	 */
	public function get_extra_button()
	{
		return $this->_extra_button;
	}
	
	/**
	 * Get the field object by the field's name.
	 * 
	 * If the field name is not exists in the form, it
	 * will return FALSE.
	 * 
	 * @param string $field_name
	 * @return Field|boolean
	 */
	public function get_field($field_name)
	{
		return array_ensure($this->_fields, $field_name, false);
	}
	
	/**
	 * Return the field's value. If the field name
	 * is not found, FALSE will be returned.
	 * 
	 * @param string $field_name
	 * @return mixed
	 */
	public function get_field_value($field_name)
	{
		$field = $this->get_field($field_name);
		
		if ( false !== $field ) {
			return $field->get_value();
		} else {
			return false;
		}
	}
	
	/**
	 * Return all Field objects. The array
	 * key will be the field's name.
	 * 
	 * @return Field[]
	 */
	public function get_fields()
	{
		return $this->_fields;
	}
	
	/**
	 * Return the list of fields by the
	 * group specified in the first parameter.
	 * 
	 * If there are no field found for the group,
	 * FALSE will be returned.
	 * 
	 * @param string $group_name
	 * @return array|boolean
	 */
	public function get_fields_by_group($group_name)
	{
		$group = $this->get_group($group_name);
		
		if ( false !== $group ) {
			$field_names = array_ensure($group, 'fields', array());
			
			if ( iterable($field_names) ) {
				$field_list = array();
				
				foreach ( $field_names as $field_name ) {
					$field_object = $this->get_field($field_name);
					
					if ( false !== $field_object ) {
						$field_list[$field_name] = $field_object;
					}
				}
				
				if ( iterable($field_list) ) {
					return $field_list;
				}
			}
		}
		
		return false;
	}
	
	/**
	 * Return the list of fields that is not belong
	 * to any group.
	 * 
	 * @return array
	 */
	public function get_fields_without_group()
	{
		// Consolidate all group's fields into a single array list.
		$group_fields = $this->get_group_fields();
		
		$orphan_fields = array();
		
		if ( iterable($this->_fields) ) {
			foreach ( $this->_fields as $field_name => $field_object ) {
				if ( $field_object instanceof Hidden ) {
					// Skip for hidden field.
					continue ;
				}
				
				if ( !in_array($field_name, $group_fields) ) {
					$orphan_fields[$field_name] = $field_object;
				}
			}
		}
		
		return $orphan_fields;
	}
	
	/**
	 * Return a particular group with the name provided
	 * in the first parameter. If the group is not found,
	 * FALSE will be returned. An associative array
	 * consists of label and fields will be returned if
	 * the group's name is found.
	 * 
	 * @param string $group_name
	 * @return array|boolean
	 */
	public function get_group($group_name)
	{
		if ( isset($this->_groups[$group_name]) ) {
			return $this->_groups[$group_name];
		} else {
			return false;
		}
	}
	
	/**
	 * Return all form groups in associative array.
	 * The array key will be the group name followed
	 * by the array value consists of label and fields.
	 * 
	 * @return array
	 */
	public function get_groups()
	{
		return $this->_groups;
	}
	
	/**
	 * Return the array list of all field's name
	 * that belong to a group in this form.
	 * 
	 * @return array
	 */
	public function get_group_fields()
	{
		$group_field_names = array();
		
		if ( iterable($this->_groups) ) {
			foreach ( $this->_groups as $group ) {
				$group_fields = array_ensure($group, 'fields', array());
				
				if ( iterable($group_fields) ) {
					foreach ( $group_fields as $field_name ) {
						if ( !in_array($field_name, $group_field_names) ) {
							$group_field_names[] = $field_name;
						}
					}
				}
			}
		}
		
		return $group_field_names;
	}
	
	/**
	 * Return the list of group's labels in string
	 * 
	 * @return array
	 */
	public function get_group_labels()
	{
		$labels = array();
		
		if ( iterable($this->_groups) ) {
			foreach ( $this->_groups as $group_name => $group ) {
				$label = array_ensure($group, 'label', '');
				$labels[$group_name] = $label;
			}
		}
		
		return $labels;
	}
	
	/**
	 * Return all hidden field objects.
	 * 
	 * @return array
	 */
	public function get_hidden_fields()
	{
		if ( iterable($this->_fields) ) {
			$hidden_fields = array();
			
			foreach ( $this->_fields as $field_name => $field ) {
				if ( $field instanceof Hidden ) {
					$hidden_fields[$field_name] = $field;
				}
			}
			
			return $hidden_fields;
		} else {
			return array();
		}
	}
	
	/**
	 * Return all hidden field and it's HTML output.
	 * 
	 * @return string
	 */
	public function get_hidden_field_text()
	{
		if ( iterable($this->_fields) ) {
			$output = '';
			
			foreach ( $this->_fields as $field_name => $field ) {
				if ( $field instanceof Hidden ) {
					$output .= $field->render() . PHP_EOL;
				}
			}
			
			return $output;
		} else {
			return '';
		}
	}
	
	/**
	 * Return the layout script used on this
	 * form.
	 * 
	 * @return string
	 */
	public function get_layout()
	{
		return $this->_layout;
	}
	
	/**
	 * Return a specific layout data or the entire layout data.
	 * 
	 * Leave the first parameter as empty to return entire
	 * layout data.
	 * 
	 * @param string optional $key
	 * @param mixed optional $default If there are no such key found, this value will be returned.
	 * @return array
	 */
	public function get_layout_data($key = '', $default = '')
	{
		if ( is_empty($key) ) {
			return $this->_layout_data;
		} else {
			return array_ensure($this->_layout_data, $key, $default);
		}
	}
	
	/**
	 * Return the form submission method.
	 * 
	 * @return string
	 */
	public function get_method()
	{
		return $this->_method;
	}
	
	/**
	 * Get the model object by it's model id.
	 * It will return FALSE if model ID not found.
	 * 
	 * @param string $model_id
	 * @return EB_Model|boolean
	 */
	public function get_model($model_id)
	{
		return array_ensure($this->_models, strtolower($model_id), false);
	}
	
	/**
	 * Return all models that has been set
	 * to this form.
	 * 
	 * @return array
	 */
	public function get_models()
	{
		return $this->_models;
	}
	
	/**
	 * Return the form name.
	 * 
	 * @return string
	 */
	public function get_name()
	{
		return $this->_name;
	}
	
	/**
	 * Get the reset button.
	 * 
	 * @return boolean
	 */
	public function get_reset_button()
	{
		return $this->_reset_button;
	}
	
	/**
	 * Return the reset button label.
	 * 
	 * @return string
	 */
	public function get_reset_label()
	{
		return $this->_reset_label;
	}
	
	/**
	 * Return the submit label string.
	 * 
	 * @return string
	 */
	public function get_submit_label()
	{
		return $this->_submit_label;
	}
	
	/**
	 * Return the status of cross site request
	 * forgery stats.
	 * 
	 * @return boolean
	 */
	public function get_xsrf_protection()
	{
		return $this->_xsrf_protection;
	}
	
	/**
	 * Return the total number of group found in this
	 * form.
	 * 
	 * @return @int
	 */
	public function group_count()
	{
		return sizeof($this->_groups);
	}
	
	/**
	 * Return TRUE if there is a captcha bot
	 * prevention library exists in this form.
	 * 
	 * @return boolean
	 */
	public function has_captcha()
	{
		return (null !== $this->_captcha_object);
	}
	
	/**
	 * Check if there is an error message found for
	 * a particular field or the entire form. Leave
	 * the first parameter as empty to check if there
	 * is any error found in the form.
	 * 
	 * @param string optional $field_name
	 * @return boolean
	 */
	public function has_error($field_name = '')
	{
		if ( !is_empty($field_name) ) {
			if ( isset($this->_errors[$field_name]) && iterable($this->_errors[$field_name]) ) {
				return true;
			} else {
				return false;
			}
		} else {
			// Check and see if there is any error message found.
			if ( iterable($this->_errors) ) {
				foreach ( $this->_errors as $error_messages ) {
					if ( iterable($error_messages) ) {
						return true;
					}
				}
			}
			
			return false;
		}
	}
	
	/**
	 * To check whether this group has an error
	 * or not.
	 * 
	 * @param string $group_name
	 * @return boolean
	 */
	public function has_group_error($group_name)
	{
		$group = $this->get_group($group_name);
		
		if ( false !== $group ) {
			$fields = array_ensure($group, 'fields', array());
			
			if ( iterable($fields) ) {
				foreach ( $fields as $field_name ) {
					if ( $this->has_error($field_name) ) {
						return true;
					}
				}
			}
		}
		
		return false;
	}
	
	/**
	 * This will return TRUE if the submission is
	 * error free. 
	 * 
	 * @return boolean
	 */
	public function is_submission_succeed()
	{
		return ($this->is_submitted() && !$this->has_error());
	}
	
	/**
	 * This will return TRUE if the form has submitted.
	 * Please use this method to determine whether the
	 * form has submitted or not as this library has a
	 * unique way to determine whether the form has 
	 * submitted or not.
	 * 
	 * @return boolean
	 */
	public function is_submitted()
	{
		$unique_id = $this->_generate_unique_form_id();
		$unique_value = $this->_CI->input->get_post($unique_id);
		
		return ($unique_value !== null);
	}
	
	/**
	 * This method is called when the form has submitted
	 * but failed to pass some of the validation rules.
	 * 
	 * @return null
	 */
	public function on_failure()
	{
		
	}
	
	/**
	 * This method used to initialize the form field's
	 * value with the model data based on it's binding.
	 * This is called before the form submitted.
	 * 
	 * You can override this function to define your
	 * custom initialization.
	 * 
	 * @return null
	 */
	public function on_initialize()
	{
		if ( iterable($this->_models) ) {
			foreach ( $this->_models as $model_id => $model_object ) {
				$bindings = array_ensure($this->_bindings, $model_id, array());
				
				if ( null === $model_object || false === ($model_object instanceof EB_Model) ) {
					// Invalid model object.
					log_message('error', 'Invalid model object or not found during initialization.');
					show_error(lang('_error_form_invalid_model_object'));
				}
				
				// The model is empty, nothing you need to set for the field's value.
				if ( $model_object->is_empty() ) {
					continue ;
				}
				
				if ( iterable($bindings) ) {
					foreach ( $bindings as $model_property => $field_name ) {
						// Retrieve the model's value.
						$model_value = $model_object->get_value($model_property);
						// Get the field object.
						$field_object = $this->get_field($field_name);
						
						// Check if there is any data preping method in this class.
						$user_defined_method = '_prep_field_' . strtolower($field_name);
						
						if ( method_exists($this, $user_defined_method) ) {
							$model_value = call_user_func(array($this, $user_defined_method), $model_value, $field_object);
						} else {
							// Check if there is any preping method defined by the field class type (classname).
							$field_type_method = '_prep_field_' . strtolower(get_class($field_object));
							
							if ( method_exists($this, $field_type_method) ) {
								$model_value = call_user_func(array($this, $field_type_method), $model_value, $field_object);
							}
						}
						
						if ( !is_empty($model_value) ) {
							// Set the model value into the field.
							$field_object->set_value($model_value);
						}
					}
				}
			}
		}
	}
	
	/**
	 * This method used to initialize the form
	 * field's value after client's has submited
	 * the form back to server.
	 * 
	 * This function is called right after the form
	 * has submitted.
	 * 
	 * @return null
	 */
	public function on_submitted()
	{
		if ( iterable($this->_fields) ) {
			foreach ( $this->_fields as $field_name => $field_object ) {
				// Get the field's value.
				if ( $field_object instanceof File ) {
					$field_value = array_ensure($_FILES, $field_name, array());
				} else {
					$field_value = $this->_CI->input->get_post($field_name);
				}
				
				// Prepare the submitted value.
				$method_name = '_prep_submit_' . $field_name;
				
				if ( method_exists($this, $method_name) ) {
					$field_value = call_user_func(array($this, $method_name), $field_value, $field_object);
				}
				
				$error_message = '';
				$constraint_checked = call_user_func_array(array($field_object, 'constraint_check'), array(
					$field_value,
					&$error_message,
				));
				
				if ( false === $constraint_checked ) {
					$this->set_error($field_name, $error_message);
				} else {
					// Set the field object with the field value.
					$field_object->set_value($field_value);
				}
			}
		}
	}
	
	/**
	 * This method is called when the form data
	 * has passed all the validation rules.
	 * It will initialize the model property with
	 * the field's value.
	 * 
	 * This function will trigger two event each
	 * time a model is about to save and after a
	 * model has been saved.
	 * on_save($model, $model_id) & on_saved($model, $model_id)
	 * 
	 * To allow the programmer to isolate the model
	 * on save event, this library will trigger the
	 * event based on the model's ID/name.
	 * on_user_model_save($model) & on_user_model_saved($model)
	 * 
	 * @return null
	 */
	public function on_success()
	{
		if ( iterable($this->_models) ) {
			foreach ( $this->_models as $model_id => $model_object ) {
				$bindings = array_ensure($this->_bindings, $model_id, array());
				
				if ( null === $model_object || false === ($model_object instanceof EB_Model) ) {
					// Invalid model object.
					log_message('error', 'Invalid model object or not found during initialization.');
					show_error(lang('_error_form_invalid_model_object'));
				}
				
				if ( iterable($bindings) ) {
					foreach ( $bindings as $model_property => $field_name ) {
						// Get the field object.
						$field_object = $this->get_field($field_name);
						// Get the field value.
						$field_value = $field_object->get_value();
						
						// Check if there is any data preping method in this class.
						$user_defined_method = '_prep_db_' . strtolower($field_name);
						
						if ( method_exists($this, $user_defined_method) ) {
							$field_value = call_user_func(array($this, $user_defined_method), $field_value, $model_object);
						} else {
							// Check if there is any preping method defined by the field class type (classname).
							$field_type_method = '_prep_db_' . strtolower(get_class($field_object));
							
							if ( method_exists($this, $field_type_method) ) {
								$field_value = call_user_func(array($this, $field_type_method), $field_value, $model_object);
							}
						}
						
						if ( false !== $field_value ) {
							$model_object->set_value($model_property, $field_value);
						}
					}
				}
				
				// Skip the saving process if no value found.
				if ( $model_object->is_empty() ) {
					continue ;
				}
				
				// Trigger on_<model_name>_save.
				$on_model_save = 'on_' . $model_id . '_save';
				if ( method_exists($this, $on_model_save) ) {
					call_user_func(array($this, $on_model_save), $model_object);
				}
				
				// Trigger on_save event in the form context.
				if ( method_exists($this, 'on_save') ) {
					$this->on_save($model_object, $model_id);
				}
				
				// Save the model object.
				$model_object->save(true);
				
				// Trigger on_<model_name>_saved.
				$on_model_saved = 'on_' . $model_id . '_saved';
				if ( method_exists($this, $on_model_saved) ) {
					call_user_func(array($this, $on_model_saved), $model_object);
				}
				
				// Trigger on_saved event in the form context.
				if ( method_exists($this, 'on_saved') ) {
					$this->on_saved($model_object, $model_id);
				}
			}
		}
	}
	
	/**
	 * To remove all input fields from the form
	 * library.
	 * 
	 * @return null
	 */
	public function remove_all_fields()
	{
		$this->_fields = array();
	}
	
	/**
	 * Remove an error message from the field list.
	 * If error message not found for the field,
	 * FALSE will be returned.
	 * 
	 * @param string $field_name
	 * @return boolean
	 */
	public function remove_error($field_name)
	{
		if ( isset($this->_errors[$field_name]) ) {
			unset($this->_errors[$field_name]);
			
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Remove a particular field specified in the first parameter.
	 * It return true if the field found.
	 * 
	 * @param string $field_name
	 * @return boolean
	 */
	public function remove_field($field_name)
	{
		if ( iterable($this->_fields) && isset($this->_fields[$field_name]) ) {
			unset($this->_fields[$field_name]);
			
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * To remove a model from the Form object.
	 * It will return TRUE if the model has found
	 * and removed or FALSE otherwise.
	 * 
	 * @param string $model_id
	 * @return boolean
	 */
	public function remove_model($model_id)
	{
		if ( isset($this->_models[$model_id]) ) {
			unset($this->_models[$model_id]);
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Render the form with the layout.
	 * It allow path token to be used in the template
	 * script, eg: !/ or ~/
	 * 
	 * @return string
	 */
	public function render()
	{
		// Generate the form id.
		$this->set_field($this->_generate_unique_form_id(), 'hidden', array(
			'value' => time(),
		));
		
		if ( $this->_xsrf_protection ) {
			// Generate the xsrf challenge field.
			$this->set_field('xsrf', 'hidden', array(
				'value' => $this->_CI->system->get_client_id(),
			));
		}
		
		// Get the form view script.
		$script_path = $this->_CI->template->get_view_path('forms/' . $this->_layout);
		
		if ( false !== $script_path ) {
			$data = $this->_layout_data;
			$data['form'] = $this;
			
			$output = $this->_CI->load->view($script_path, $data, true);
			
			return $this->_CI->template->get_base_url($output);
		} else {
			// Form layout not found.
			log_message('error', 'No view found for form layout.');
			show_error(lang('_error_form_view_not_found'));
		}
	}
	
	/**
	 * To set the action URL of this form.
	 * 
	 * @param string $action
	 * @return null
	 */
	public function set_action($action)
	{
		$this->_action = $action;
	}
	
	/**
	 * To set the binding for the model and
	 * the field. The binding is an associative array
	 * between the model's property name while the
	 * value will be the field's name.
	 * 
	 * @param string $model_id
	 * @param array $bindings
	 * @return null
	 */
	public function set_binding($model_id, $bindings)
	{
		if ( iterable($bindings) ) {
			$this->_bindings[$model_id] = $bindings;
		} else {
			$this->_bindings[$model_id] = array();
		}
	}
	
	/**
	 * To set multiple model and it's binding for
	 * this form. The array key must be the model's
	 * ID while the value is an associative array
	 * between the model's property and the field's
	 * name.
	 * 
	 * @param array $model_bindings
	 */
	public function set_bindings($model_bindings)
	{
		if ( iterable($model_bindings) ) {
			foreach ( $model_bindings as $model_id => $bindings ) {
				if ( !iterable($bindings) ) {
					$bindings = array();
				}
				
				$this->_bindings[$model_id] = $bindings;
			}
		}
	}
	
	/**
	 * Set the captcha library name. It has to
	 * be same name as the class.
	 * 
	 * @param string $captcha_name
	 * @return null
	 */
	public function set_captcha($captcha_name)
	{
		$this->_captcha = strtolower($captcha_name);
	}
	
	/**
	 * Set the encoding type for the form.
	 * 
	 * @param string $enctype
	 * @return null
	 */
	public function set_enctype($enctype)
	{
		$this->_enctype = $enctype;
	}
	
	/**
	 * To set an error message to a field. The field
	 * name can be also '_form' or '_captcha'.
	 * 
	 * @param string $field_name
	 * @param string $message
	 * @return null
	 */
	public function set_error($field_name, $message)
	{
		if ( !isset($this->_errors[$field_name]) ) {
			$this->_errors[$field_name] = array();
		}
		
		$this->_errors[$field_name][] = $message;
	}
	
	/**
	 * To set multiple error messages into the form.
	 * It accept multiple error messages to be assigned
	 * to a field.
	 * It accept multiple error messages to be assigned
	 * to multiple fields.
	 * 
	 * @param array|string $field_name
	 * @param array|string optional $messages
	 * @return null
	 */
	public function set_errors($field_name, $messages = array())
	{
		if ( iterable($field_name) ) {
			foreach ( $field_name as $fname => $message ) {
				$this->set_errors($fname, $message);
			}
		} else {
			if ( iterable($messages) ) {
				foreach ( $messages as $msg ) {
					$this->set_error($field_name, $msg);
				}
			} else {
				$this->set_error($field_name, $messages);
			}
		}
	}
	
	/**
	 * Set the extra HTML button codes
	 * 
	 * @param string $html_button
	 * @return null
	 */
	public function set_extra_button($html_button)
	{
		$this->_extra_button = $html_button;
	}
	
	/**
	 * To create a form field and add it into the form.
	 * The name must be unique as each form field should
	 * able to uniquely identified. The type must be the
	 * exact class name in the libraries/form/fields folder.
	 * 
	 * @param string $name
	 * @param string $type
	 * @param array optional $options
	 * @return null
	 */
	public function set_field($name, $type, $options = array())
	{
		// Check if the type exists.
		$class_name = ucfirst(strtolower($type));
		
		$class_file = APPPATH . 'libraries/forms/fields/' . $class_name . '.php';
		//$this->_CI->load->library('forms/fields/' . $type);
		if ( file_exists($class_file) ) {
			require_once($class_file);
		} else {
			log_message('error', 'Form field type not found: ' . $class_name);
			show_error(sprintf(lang('_error_form_field_invalid_type'), $class_name));
		}
		
		if ( class_exists($class_name, false) ) {
			// Let's instantiate a new object.
			$options['name'] = $name;
			$options['form'] = $this;
			$field_object = new $class_name($options);
			
			if ( false !== ($field_object instanceof Field) ) {
				if ( $field_object instanceof File ) {
					// Set encryption type to form data.
					$this->set_enctype('multipart/form-data');
				}
				
				$this->_fields[$name] = $field_object;
			} else {
				log_message('error', 'Invalid type of form field specified. No such field class found: ' . $class_name);
				show_error(sprintf(lang('_error_form_field_invalid_type'), $class_name));
			}
		} else {
			log_message('error', 'Invalid type of form field specified. No such field class found: ' . $class_name);
			show_error(sprintf(lang('_error_form_field_invalid_type'), $class_name));
		}
	}
	
	/**
	 * To set the field with the value specified
	 * in the second parameter. If the field name
	 * not found, FALSE will be returned. Otherwise,
	 * it will return TRUE.
	 * 
	 * @param $name
	 * @param $value
	 * @return boolean
	 */
	public function set_field_value($name, $value)
	{
		$field = $this->get_field($name);
		
		if ( $field && $field instanceof Field ) {
			$field->set_value($value);
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * To set multiple fields to the form.
	 * The array key will be the field's name
	 * followed by the associative array. The
	 * array must have an element called type.
	 * 
	 * @param array $fields
	 * @return null
	 */
	public function set_fields($fields)
	{
		if ( iterable($fields) ) {
			foreach ( $fields as $field_name => $field ) {
				$type = array_ensure($field, 'type', false);
				$name = array_ensure($field, 'name', false);
				
				if ( false !== $name ) {
					$field_name = $name;
				}
				
				if ( false !== $type ) {
					unset($field['type']);
					
					$this->set_field($field_name, $type, $field);
				}
			}
		}
	}
	
	/**
	 * To set a group into the form. If the group name
	 * has already existed, it will replace the existing
	 * one with the new one.
	 * 
	 * The second parameter must consist of the 'label'
	 * and 'fields' elements.
	 * 
	 * FALSE will be returned if the group was unable
	 * to set.
	 * 
	 * @param string $group_name
	 * @param array $options
	 * @return boolean
	 */
	public function set_group($group_name, $options)
	{
		$label = array_ensure($options, 'label', false);
		$fields = array_ensure($options, 'fields', false);
		
		if ( false === $label || is_empty($label) || false === $fields || !iterable($fields) ) {
			return false;
		}
		
		$this->_groups[$group_name] = array(
			'label' => $label,
			'fields' => $fields,
		);
		
		return true;
	}
	
	/**
	 * To set multiple groups. The first parameter
	 * must be an assosictive array. The array key
	 * has to be the group's name. The array value
	 * has to be an array consists of label and
	 * fields.
	 * 
	 * This method will return the number of group
	 * successfully added.
	 * 
	 * @param array $groups
	 * @return int
	 */
	public function set_groups($groups)
	{
		if ( iterable($groups) ) {
			$group_count = 0;
			
			foreach ( $groups as $group_name => $group_options ) {
				if ( is_pure_digits($group_name) || !iterable($group_options) ) {
					continue ;
				}
				
				if ( $this->set_group($group_name, $group_options) ) {
					$group_count ++;
				}
			}
			
			return $group_count;
		} else {
			return false;
		}
	}
	
	/**
	 * Set the layout script for this form.
	 * Used for HTML rendering use.
	 * 
	 * Optionally, you can pass the layout data
	 * on the second parameter.
	 * 
	 * @param string $layout
	 * @param array optional $data
	 * @return null
	 */
	public function set_layout($layout, $data = false)
	{
		$this->_layout = $layout;
		
		if ( iterable($data) ) {
			$this->set_layout_data($data);
		}
	}
	
	/**
	 * To set layout data. You can pass array in the first parameter.
	 * 
	 * @param string|array $data
	 * @param string optional $value
	 * @return null
	 */
	public function set_layout_data($data, $value = '')
	{
		if ( iterable($data) ) {
			foreach ( $data as $key => $val ) {
				$this->_layout_data[$key] = $val;
			}
		} else {
			$this->_layout_data[$data] = $value;
		}
	}
	
	/**
	 * To set the form submit method. It can
	 * be either get or post only.
	 * 
	 * @param string $method
	 * @return null
	 */
	public function set_method($method)
	{
		if ( strtolower($method) == 'get' ) {
			$this->_method = 'get';
		} else {
			$this->_method = 'post';
		}
	}
	
	/**
	 * To set the model into the form. The model
	 * can have an unique ID for binding purpose.
	 * 
	 * If no ID specified in second parameter, the
	 * class name of the model will be used. But
	 * it might ran into a risk of name clashing.
	 * 
	 * @param string|EB_Model $model
	 * @param string optional $model_id
	 * @return null
	 */
	public function set_model($model, $model_id = '')
	{
		if ( gettype($model) == 'string' ) {
			// Load the model.
			$class_name = ucfirst($model);
			
			$this->_CI->load->model($class_name);
			
			$model = new $class_name();
		}
		
		if ( false === ($model instanceof EB_Model) ) {
			log_message('error', 'Invalid variable type passed to set_model function in form.');
			show_error(lang('_error_form_invalid_model_object'));
		}
		
		if ( is_empty($model_id) ) {
			$model_id = strtolower(get_class($model));
		}
		
		$this->_models[$model_id] = $model;
	}
	
	/**
	 * To set multiple models into the form.
	 * The array key can be the model's ID. In
	 * this method, it will validate if the array
	 * key is pure digits number. If true, it will
	 * assume that model's ID did not specified and
	 * thus model's name will be used as ID.
	 * 
	 * @param array $models
	 * @return null
	 */
	public function set_models($models)
	{
		if ( iterable($models) ) {
			foreach ( $models as $model_id => $model ) {
				// Make sure the model's ID is not pure number.
				if ( preg_match('/^\d+$/', $model_id) ) {
					$model_id = '';
				}
				
				$this->set_model($model, $model_id);
			}
		}
	}
	
	/**
	 * Set the form name.
	 * 
	 * @param string $name
	 * @return null
	 */
	public function set_name($name)
	{
		$this->_name = $name;
	}
	
	/**
	 * Toggle the reset button.
	 * 
	 * @param boolean $reset_button
	 * @return null
	 */
	public function set_reset_button($reset_button)
	{
		$this->_reset_button = ($reset_button ? true : false);
	}
	
	/**
	 * Set the reset button label.
	 * 
	 * @param string $label
	 * @return null
	 */
	public function set_reset_label($label)
	{
		$this->_reset_button_label = $label;
	}
	
	/**
	 * Set the submit label.
	 * 
	 * @param string $label
	 * @return null
	 */
	public function set_submit_label($label)
	{
		$this->_submit_label = $label;
	}
	
	/**
	 * Toggle the cross site request forgery
	 * protection feature.
	 * 
	 * @param boolean $protection
	 * @return null
	 */
	public function set_xsrf_protection($protection)
	{
		if ( $protection ) {
			$this->_xsrf_protection = true;
		} else {
			$this->_xsrf_protection = false;
		}
	}
	
	/**
	 * Return the total number of fields
	 * in this form.
	 * 
	 * @return int
	 */
	public function total_fields()
	{
		return sizeof($this->_fields);
	}
	
	/**
	 * To generate a unique ID that represent this
	 * form class file. By default, this method return
	 * the md5 hashed of the current class name.
	 * 
	 * You can override this on sub form class to return
	 * custom unique form ID.
	 * 
	 * @return string
	 */
	protected function _generate_unique_form_id()
	{
		return md5(get_class($this));
	}
	
	/**
	 * This function will initialize the captcha library
	 * and instantiate it based on the _captcha library
	 * name.
	 * 
	 * @return null
	 */
	protected function _initialize_captcha()
	{
		$class_name = ucfirst($this->_captcha);
		$class_path = APPPATH . 'libraries/forms/captcha/' . $class_name . '.php';
		
		if ( file_exists($class_path) ) {
			require_once($class_path);
			
			$captcha_object = new $class_name();
			
			$this->_captcha_object = $captcha_object;
		} else if ( !is_empty($this->_captcha) ) {
			log_message('error', 'Invalid captcha library specified. No such captcha library found: ' . $class_name);
			show_error(sprintf(lang('_error_form_invalid_captcha_library'), $class_name));
		}
		
	}
	
	/**
	 * This is where the form process the fields and
	 * the data received from client side. Try not to
	 * override this method as you can use most of the
	 * event functions to customize your process.
	 * 
	 * @return null
	 */
	protected function _process()
	{
		if ( $this->is_submitted() ) {
			$this->on_submitted();
			
			$error_count = $this->_validate();
			
			if ( $error_count > 0 || $this->has_error() ) {
				// Error found.
				$this->on_failure();
			} else {
				// Error free.
				$this->on_success();
			}
		} else {
			$this->on_initialize();
		}
	}
	
	/**
	 * To validate the form and it's fields based
	 * on the rules set. This method will assign
	 * the error message accordingly when a rule
	 * failed to passed.
	 * 
	 * It will return the number of errors found.
	 * It will return 0 if there are no error found.
	 * 
	 * @return int
	 */
	protected function _validate()
	{
		$count = 0;
		
		// validate xsrf
		if ( $this->_xsrf_protection ) {
			// XSRF/cross site request forgery
			$xsrf_value = $this->_CI->input->get_post('xsrf');
			
			if ( false === $xsrf_value || $xsrf_value != $this->_CI->system->get_client_id() ) {
				$this->set_error('_form', lang('_form_error_request_forgery'));
				
				$count ++;
				
				return $count;
			}
		}
		
		$error_message = '';
		
		if ( $this->has_captcha() && !$this->_captcha_object->validate($error_message) ) {
			
			$this->set_error('_captcha', $error_message);
			
			$count ++;
		}
		
		if ( iterable($this->_fields) ) {
			foreach ( $this->_fields as $field_name => $field ) {
				// Skip validation if there is already an error occurred.
				if ( $this->has_error($field_name) ) {
					continue ;
				}
				
				$rules = $field->get_rules();
				$undefined_rules = $field->get_undefined_rules();
				
				if ( iterable($rules) ) {
					foreach ( $rules as $rule_name => $rule_param ) {
						$stop = false;
						$method_name = '_val_' . $rule_name;
						$return_value = true;
						$error_message = '';
						
						if ( isset($undefined_rules[$rule_name]) ) {
							// An undefined rule, let's call it from the form object.
							if ( method_exists($this, $method_name) ) {
								$return_value = call_user_func_array(array($this, $method_name), array(
									$field,
									$rule_param,
									&$error_message,
									&$stop,
								));
							}
						} else {
							// The field has this rule, let's call the field object.
							$return_value = call_user_func_array(array($field, 'validate'), array(
								$rule_name,
								$rule_param,
								&$error_message,
								&$stop,
							));
						}
						
						if ( $return_value === false ) {
							// Check if there is any custom error message method.
							$custom_error_message_method = 'on_errmsg_' . $rule_name;
							
							if ( method_exists($field, $custom_error_message_method) ) {
								$error_message = call_user_func(array($field, $custom_error_message_method));
							} elseif ( method_exists($this, $custom_error_message_method) ) {
								$error_message = call_user_func(array($this, $custom_error_message_method));
							}
							
							$this->set_error($field_name, $error_message);
							
							$count ++;
							
							if ( $stop ) {
								// Stop validating the next rule.
								break ;
							}
						}
					}
				}
				
			}
		}
		
		return $count;
	}
	
	/**
	 * To validate whether the field's value is
	 * a valid email address or not.
	 * 
	 * @param Field $field
	 * @param array optional $options
	 * @param string optional $error_message
	 * @param boolean optional $stop
	 * @return boolean
	 */
	protected function _val_email($field, $options = array(), &$error_message = '', &$stop = false)
	{
		$field_value = $field->get_value();
		
		if ( is_empty($field_value) ) {
			return true;
		}
		
		if ( filter_var($field_value, FILTER_VALIDATE_EMAIL) ) {
			return true;
		} else {
			$error_message = lang('_form_error_invalid_email');
			
			return false;
		}
	}
	
	/**
	 * To make sure the field value match with
	 * the one specified in the options. To
	 * specify, use "field_name" in the options
	 * array.
	 * 
	 * @param Field $field
	 * @param array optional $options
	 * @param string optional $error_message
	 * @param boolean optional $stop
	 * @return boolean
	 */
	protected function _val_match($field, $options = array(), &$error_message = '', &$stop = false)
	{
		$field_to_match = array_ensure($options, 'field_name', '');
		
		if ( !is_empty($field_to_match) ) {
			$field_to_match = $this->get_field($field_to_match);
			
			if ( false !== $field_to_match ) {
				$field_to_match_value = $field_to_match->get_value();
				
				if ( $field->get_value() !== $field_to_match_value ) {
					$error_message = sprintf(lang('_form_error_field_not_match'), $field_to_match->get_label());
					
					return false;
				}
			}
		}
		
		return true;
	}
	
	/**
	 * To make sure the string is a number.
	 * Available options:
	 * min : Minimum value. Inclusive
	 * max : Maximum value. Inclusive
	 * integer : Toggle integer only value (boolean type).
	 * 
	 * @param Field $field
	 * @param array optional $options
	 * @param string optional $error_message
	 * @param boolean optional $stop
	 * @return boolean
	 */
	protected function _val_number($field, $options = array(), &$error_message = '', &$stop = false)
	{
		$value = trim($field->get_value());
		
		if ( is_empty($value) ) {
			return true;
		}
		
		$stop = true;	// stop it from validating.
		
		// Make sure this is a number.
		$value = preg_replace('/\,/', '', $value);
		
		if ( !preg_match('/^[0-9\.]+$/', $value) ) {
			$error_message = lang('_form_error_number_invalid');
			
			return false;
		} else {
			$value = floatval($value);
			$min = array_ensure($options, 'min', false);
			$max = array_ensure($options, 'max', false);
			$integer = array_ensure($options, 'integer', false);
			
			if ( false !== $min && $value < $min ) {
				$error_message = sprintf(lang('_form_error_number_minimum'), $min);
				return false;
			}
			
			if ( false !== $max && $value > $max ) {
				$error_message = sprintf(lang('_form_error_number_maximum'), $max);
				return false;
			}
			
			if ( $integer && !preg_match('/^\d+$/', $value) ) {
				$error_message = lang('_form_error_integer_only');
				return false;
			}
		}
		
		return true;
	}
	
	/**
	 * To validate whether the field's value is
	 * empty or not.
	 * 
	 * @param Field $field
	 * @param array optional $options
	 * @param string optional $error_message
	 * @param boolean optional $stop
	 * @return boolean
	 */
	protected function _val_required($field, $options = array(), &$error_message = '', &$stop = false)
	{
		// Stop the next validation if this failed.
		$stop = true;
		
		if ( $field->is_empty() ) {
			$error_message = lang('_form_error_empty');
			return false;
		} else {
			return true;
		}
	}
}