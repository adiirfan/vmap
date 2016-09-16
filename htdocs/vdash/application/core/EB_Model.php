<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * EB_Model
 * 
 * This is the extension of the default CodeIgniter database model class.
 * It provide additional features. This class has converted to iterator
 * class where you can store multiple records into the model and loop it
 * using the object itself.
 * 
 * -------------------------------------
 * Dependencies
 * -------------------------------------
 * + URI (CI Library)
 * 
 * --------------------------------------
 * Events
 * --------------------------------------
 * on_all_saved()
 * Called when the model function save(true) was called. This will called after all data has been saved into database.
 * This function only called when true was passed to save function.
 * 
 * on_data_set(data)
 * Called when the model function set_data called. This is call before the data was set. The data in first parameter
 * is an associative array and passed by reference. You can manipulate the array data before it set into the model.
 * Parameters:
 * data - Model data that was about to set and it was passed by reference. You can modify it!
 * 
 * on_delete(data)
 * Called before a data being delete from the database.
 * Parameter:
 * data - Array. The detail of the deleted record.
 * 
 * on_deleted(data)
 * Called after a data has been deleted from the database.
 * Parameter:
 * data - Array. The detail of the deleted record.
 * 
 * on_data_removed(position)
 * Called when a data was removed from this model.
 * Parameters:
 * position - Integer. The position of the data being removed.
 * 
 * on_loaded(result)
 * Called when the model had called up the load function and data was retrieved.
 * Parameters:
 * result - Multidimension array. Same as $qry->result_array();
 * 
 * on_save()
 * Called right before the data being saved into the database.
 * 
 * on_saved()
 * Called when a record has been saved into the database. This function will called up first before the on_all_saved().
 * 
 * ----------------------------------------------------------------------
 *  
 *  @author Kent Lee
 */
class EB_Model extends CI_Model implements Iterator {
	/**
	 * The database table's name.
	 * 
	 * @var string
	 */
	protected $_table_name = '';
	
	/**
	 * The current iterated position.
	 * Default 0
	 * 
	 * @var int
	 */
	protected $_position = 0;
	
	/**
	 * The list of iterable data in this model.
	 * 
	 * @var mixed
	 */
	protected $_data = array();
	
	/**
	 * The table field's meta data. This variable shouldn't be
	 * access directly as it will not initialize until
	 * necessary.
	 * 
	 * @var mixed
	 */
	protected $_meta = array();
	
	/**
	 * Default constructor
	 * 
	 * @return null
	 */
	public function __construct()
	{
		parent::__construct();
		
		// Initialize the iterator.
		$this->_position = 0;
		
		if ( method_exists($this, 'init') ) {
			$this->init();
		}
	}
	
	# Iterator implementations.
	/**
	 * Rewind the iterator to the first element.
	 * 
	 * @see Iterator::rewind()
	 * @return null
	 */
	public function rewind()
	{
		$this->_position = 0;
	}
	
	/**
	 * Return the model with current iterated position.
	 * 
	 * @see Iterator::current()
	 * @return EB_Model
	 */
	public function current()
	{
		return $this;
	}
	
	/**
	 * Return the current position index.
	 * 
	 * @see Iterator::key()
	 * @return int
	 */
	public function key()
	{
		return $this->_position;
	}
	
	/**
	 * Move to next record.
	 * 
	 * @see Iterator::next()
	 * @return null
	 */
	public function next()
	{
		++ $this->_position;
	}
	
	/**
	 * Return true if the current position has data.
	 * 
	 * @see Iterator::valid()
	 * @return boolean
	 */
	public function valid()
	{
		return isset($this->_data[$this->_position]);
	}
	# End of iterator implementation
	
	/**
	 * Reset the model data and related data. This function will
	 * also move the cursor to the first position.
	 * 
	 * @return null
	 */
	public function clear()
	{
		$this->_position = 0;
		$this->_data = array();
	}
	
	/**
	 * To delete the current model's record from the database.
	 * It will only delete if this row of record is exists in
	 * the database. So is better you check it with "is_new"
	 * function.
	 * 
	 * @param boolean optional $delete_all
	 * @return null
	 */
	public function delete($delete_all = false)
	{
		if ( $delete_all ) {
			foreach ( $this as $model ) {
				$model->delete(false);
			}
			
			// Event: on_all_deleted
			if ( method_exists($this, 'on_all_deleted') ) {
				$this->on_all_deleted();
			}
		} else {
			if ( !$this->is_new() ) {
				$data = $this->get_data();
				
				// Event: on_delete
				if ( method_exists($this, 'on_delete') ) {
					$this->on_delete($data);
				}
				
				$where = $this->get_primary_keys_value();
				$this->db->delete($this->_table_name, $where);
				// Remove the current row of records.
				$this->remove_data();
				
				// Event: on_deleted
				if ( method_exists($this, 'on_deleted') ) {
					$this->on_deleted($data);
				}
			} else {
				// Unable to delete.
				log_message('error', 'No data to be delete from this model: ' . get_class($this));
				show_error('No data to be delete.', 500);
			}
		}
	}
	
	/**
	 * To get a list of field that has been changed with the current
	 * model value. It will return with the current and new data of
	 * a particular field.
	 * 
	 * @return boolean|array It will return FALSE if this model has no data exists in the database.
	 */
	public function get_changed_fields()
	{
		if ( $this->is_new() ) {
			return false;
		} else {
			$class_name = get_class($this);
			$model = new $class_name();
			$model->load($this->get_primary_keys_value());
			$db_data = $model->get_data();
			// Multidimension array. Key will be the field name. Containing an array with two elements: current, new.
			$changed_fields = array();
			
			foreach ( $db_data as $field => $value ) {
				$current_value = $this->get_value($field, false);
				
				if ( false === $current_value ) {
					continue ;
				}
				
				// Compare
				if ( $current_value != $value ) {
					$changed_fields[$field] = array(
						'current' => $value,
						'new' => $current_value,
					);
				}
			}
			
			return $changed_fields;
		}
	}
	
	/**
	 * Return the current iterated data set.
	 * 
	 * @return array|boolean Return false if no data found on this position.
	 */
	public function get_data()
	{
		if ( isset($this->_data[$this->_position]) ) {
			return $this->_data[$this->_position];
		} else {
			return false;
		}
	}
	
	/**
	 * To return the model which has relevant field with the current model.
	 * This is similar to INNER JOIN statement in the SQL. It will match
	 * one or more field from existing model with another model. If all fields
	 * matched, then it will initialize the model with the result generated.
	 * 
	 * @param string $model_file Relative path from the models folder. Eg: transactions/sales (without extension)
	 * @param array $conditions Matching conditions. The key will be this model's field name while the value will be the matching field's name on the other model.
	 * @return EB_Model Use is_empty to check whether the model has initialized or not.
	 */
	public function get_joined_model($model_file, $conditions)
	{
		$path_segments = preg_split('/\//', $model_file);
		$segments_size = sizeof($path_segments);
		$model_name = strtolower($path_segments[$segments_size - 1]);
		$model_classname = ucfirst($model_name);
		$model_filename = '';
		
		for ( $i = 0; $i < ($segments_size - 1); $i++ ) {
			$model_filename .= $path_segments[$i] . '/';
		}
		
		$model_filename .= $model_name . '.php';
		$model_filename = APPPATH . 'models/' . $model_filename;
		
		if ( file_exists($model_filename) ) {
			if ( !class_exists($model_classname) ) {
				require_once($model_filename);
				log_message('debug', 'Model file loaded: ' . $model_filename);
			}
			
			$model = new $model_classname();
			
			// Initialize the conditions data.
			$data = array();
			
			foreach ( $conditions as $field_name => $match_field ) {
				// Get the field value.
				$field_value = $this->get_value($field_name, false);
				
				if ( false !== $field_value ) {
					$data[$match_field] = $field_value;
				} else {
					log_message('error', sprintf('Unable to find such field %s in the %s model.', $field_name, get_class($this)));
					show_error(lang('_error_db_model'));
				}
			}
			
			log_message('debug', sprintf('Loading %s model with these data:' . PHP_EOL . print_r($data, true), get_class($model)));
			$model->load($data);
			
			return $model;
		} else {
			log_message('error', 'System unable to locate such model file: ' . $model_filename);
			show_error(lang('_error_db_model'));
		}
	}
	
	/**
	 * Get the table's meta data.
	 * 
	 * @return array
	 */
	public function get_meta()
	{
		$this->load_meta();
		return $this->_meta;
	}
	
	/**
	 * This method return the next auto increment value.
	 * If this table do not have any auto increment value,
	 * false will be returned.
	 * 
	 * @return int|boolean
	 */
	public function get_next_increment_value()
	{
		$sql = 'SELECT `AUTO_INCREMENT` AS `value`
			FROM INFORMATION_SCHEMA.TABLES
			WHERE TABLE_SCHEMA = "' . $this->db->database . '" AND
				 TABLE_NAME = "' . $this->_table_name . '"';
		$qry = $this->db->query($sql);
		
		if ( $qry->num_rows() ) {
			$row = $qry->row_array();
			$value = intval($row['value']);
			
			if ( !$value ) {
				$value = 1;
			}
			
			return intval($value);
		} else {
			return false;
		}
	}
	
	/**
	 * This will return the option list for this model.
	 * 
	 * The first parameter is to specify the filed name
	 * for the option value and the second parameter is
	 * for the option text.
	 * 
	 * The last parameter is used to specify the query
	 * options.
	 * 
	 * @param string $value_field
	 * @param string $text_field
	 * @param array optional $options
	 * @return array
	 */
	public function get_option_list($value_field, $text_field, $options = array())
	{
		$result = $this->get_result($options);
		$option_list = array();
		
		if ( iterable($result) ) {
			foreach ( $result as $row ) {
				$value = array_ensure($row, $value_field, '');
				$text = array_ensure($row, $text_field, '');
				
				if ( method_exists($this, '_render_option_text') ) {
					$text = $this->_render_option_text($text, $row);
				}
				
				$option_list[$value] = $text;
			}
		}
		
		return $option_list;
	}
	
	/**
	 * Get the list of primary keys.
	 * 
	 * @return array
	 */
	public function get_primary_keys()
	{
		$this->load_meta();
		
		$pk = array();
		
		foreach ( $this->_meta as $field ) {
			if ( $field->primary_key ) {
				$pk[] = $field->name;
			}
		}
		
		return $pk;
	}
	
	/**
	 * Return the list of primary keys with the value of it.
	 * The array key will be the field's name whlie the value
	 * will be the pk's value. Suitable for where statement.
	 * 
	 * @return array
	 */
	public function get_primary_keys_value()
	{
		$this->load_meta();
		
		$pk = $this->get_primary_keys();
		
		$values = array();
		
		foreach ( $pk as $field_name ) {
			$pk_value = $this->get_value($field_name, false);
			
			if ( false !== $pk_value ) {
				$values[$field_name] = $pk_value;
			}
		}
		
		return $values;
	}
	
	/**
	 * This will return the database result based on
	 * the options provided. It accept any database
	 * builder's method such as join, where, order,
	 * group, select and so on. By default, this 
	 * function will select the database from the
	 * table name specified in $_table_name.
	 * 
	 * It will return FALSE when there are no data
	 * found.
	 * 
	 * @param array optional $options
	 * @return array
	 */
	public function get_result($options = array())
	{
		$table_name = $this->_table_name;
		
		if ( is_empty($table_name) ) {
			$table_name = array_ensure($options, 'table_name', '');
		}
		
		if ( is_empty($table_name) ) {
			return false;
		}
		
		$option_names = array(
			'select', 'where', 'order_by', 'join', 'group_by'
		);
		
		$this->db->from($table_name);
		
		foreach ( $option_names as $name ) {
			$option_value = array_ensure($options, $name, false);
			
			if ( false === $option_value ) {
				continue;
			}
			
			if ( !iterable($option_value) ) {
				$option_value = array($option_value);
			}
			
			call_user_func_array(array($this->db, $name), $option_value);
		}
		
		$qry = $this->db->get();
		
		if ( $qry->num_rows() ) {
			return $qry->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * Get the table name.
	 * 
	 * @return string
	 */
	public function get_table()
	{
		return $this->_table_name;
	}
	
	/**
	 * Return the current iterator's data field.
	 * 
	 * @param string $field Column name.
	 * @param mixed $default If the field is not found or empty result, this default value will be returned.
	 * @return mixed
	 */
	public function get_value($field, $default = false)
	{
		$current_data = $this->get_data();
		
		if ( false === $current_data ) {
			log_message('error', 'There are no data found on this model: ' . get_class($this) . '. Iteration problem. Please check looping logic.');
			show_error(lang('_error_db_data_not_found'));
		}
		
		if ( isset($current_data[$field]) ) {
			$value = $current_data[$field];
			
			if ( is_empty($value) ) {
				return $default;
			} else {
				return $value;
			}
		} else {
			return $default;
		}
	}
	
	/**
	 * To check whether this table has initialized the meta
	 * data.
	 * 
	 * @return boolean
	 */
	public function has_meta()
	{
		return (sizeof($this->_meta) > 0);
	}
	
	/**
	 * To check whether the current records has
	 * all the primary keys.
	 * 
	 * @return booolean
	 */
	public function has_primary_keys()
	{
		if ( $this->is_empty() ) {
			return false;
		}
		
		$pk = $this->get_primary_keys();
		
		foreach ( $pk as $field_name ) {
			if ( false === ($pk_value = $this->get_value($field_name, false)) || is_empty($pk_value) ) {
				return false;
			}
		}
		
		return true;
	}
	
	/**
	 * To check whether the current row of records
	 * is a new records. It will return true if this
	 * record does not exists in the database.
	 * 
	 * @return boolean
	 */
	public function is_new()
	{
		if ( $this->has_primary_keys() ) {
			// Check from db.
			$where = $this->get_primary_keys_value();
			
			$qry = $this->db->get_where($this->_table_name, $where);
			
			return ($qry->num_rows() == 0);
		} else {
			// New.
			return true;
		}
	}
	
	/**
	 * Check whether the current model is empty.
	 * 
	 * @return boolean
	 */
	public function is_empty()
	{
		return (sizeof($this->_data) == 0);
	}
	
	
	
	
	/**
	 * Initialize the model with the data from the
	 * database. If the first parameter was not 
	 * provided, it will load all data from the table.
	 * 
	 * @param array optional $where
	 * @return null
	 */
	public function load($where = array())
	{
		if ( is_empty($this->_table_name) ) {
			// No table found.
			log_message('error', 'Function EB_Model::load called without specifying the table\'s name. Model name: ' . get_class($this));
			show_error(lang('_error_db_table_name_not_specified'));
		}
		
		// Generate the query resource.
		$query = null;
		if ( iterable($where) ) {
			$query = $this->db->get_where($this->_table_name, $where);
		} else {
			$query =  $this->db->get($this->_table_name);
		}
		
		if ( $query ) {
			if ( $query->num_rows() > 0 ) {
				// Retrieve the result in multidimension native array.
				$result = $query->result_array();
				
				// Set these result into the model object.
				$this->set_data($result);
				
				// Event: on_loaded
				if ( method_exists($this, 'on_loaded') ) {
					$this->on_loaded($result);
				}
			} else {
				// Just clear the data.
				$this->clear();
			}
		}
	}
	
	/**
	 * To load the table field's meta data.
	 * 
	 * @return null
	 */
	public function load_meta()
	{
		if ( !is_empty($this->_table_name) ) {
			if ( !$this->has_meta() ) {
				$this->_meta = $this->db->field_data($this->_table_name);
			}
		} else {
			log_message('error', 'Function EB_Model::load called without specifying the table\'s name. Model name: ' . get_class($this));
			show_error(lang('_error_db_table_name_not_specified'));
		}
	}
	
	/**
	 * Move the iterator to the matched field and value.
	 * It will stop at the first occurrence of the matched
	 * values. 
	 * 
	 * @param array $values The key will be the database field and the value is the field's value.
	 * @return boolean
	 */
	public function move_to($values)
	{
		foreach ( $this->_data as $index => $row ) {
			$matched = true;
			
			foreach ( $values as $field => $value ) {
				if ( !isset($row[$field]) ) {
					$matched = false;
					break ;
				} else {
					$field_value = $row[$field];
					
					if ( $field_value != $value ) {
						$matched = false;
						break ;
					}
				}
			}
			
			if ( $matched ) {
				$this->_position = $index;
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * Create a new piece of records.
	 * 
	 * @return null
	 */
	public function new_data()
	{
		$this->_data[] = array();
		
		// move the position to the last array.
		$array_keys = array_keys($this->_data);
		$this->_position = $array_keys[sizeof($array_keys) - 1];
	}
	
	/**
	 * Get the total number of rows in this model.
	 * 
	 * @return int
	 */
	public function num_rows()
	{
		return sizeof($this->_data);
	}
	
	/**
	 * Remove the current set of data.
	 * 
	 * Note: This will not remove any data from the database but just from the memory.
	 * 
	 * @return null
	 */
	public function remove_data()
	{
		if ( isset($this->_data[$this->_position]) ) {
			unset($this->_data[$this->_position]);
			
			// Event: on_data_removed
			if ( method_exists($this, 'on_data_removed') ) {
				$this->on_data_removed($this->_position);
			}
			
			$this->_data = array_values($this->_data);
			
			if ( $this->_position > (sizeof($this->_data) - 1) ) {
				// Move to the last position.
				$this->_position = sizeof($this->_data) - 1;
			}
		} else {
			log_message('error', 'Index out of bound. Unable to remove model data at the current position: ' . $this->_position);
			show_error(lang('_error_db_data_remove_failed'));
		}
	}
	
	/**
	 * This method will save all the data from this model
	 * into the database. It will check whether the primary
	 * key that set is exists. If yes, it will update, else
	 * it will insert a new record.
	 * 
	 * If new record added, this model's primary key will be
	 * updated as well.
	 * 
	 * @param boolean optional $save_all Setting this to true will save all data in this model.
	 * @return null
	 */
	public function save($save_all = false)
	{
		if ( $save_all ) {
			$tmp_position = $this->_position;
			foreach ( $this as $model ) {
				$model->save(false);
			}
			$this->_position = $tmp_position;
			
			// Event: on_all_saved
			if ( method_exists($this, 'on_all_saved') ) {
				$this->on_all_saved();
			}
		} else {
			// Event: on_save
			if ( method_exists($this, 'on_save') ) {
				$this->on_save();
			}
			
			// Prepare the data.
			$data = $this->get_data();
			
			if ( false !== $data && iterable($data) ) {
				foreach ( $data as $field => $value ) {
					if ( false === $value ) {
						// Skip this field.
						unset($data[$field]);
					}
				}
			}
			
			if ( $this->is_new() ) {
				$this->db->insert($this->_table_name, $data);
				// Get the last inserted primary key.
				$primay_keys = $this->get_primary_keys();
				
				// Check if the records is still new, if yes, it will initialize the primary key.
				if ( $this->is_new() ) {
					$pk = array_first($primay_keys);
					$pk_value = $this->db->insert_id();
					$this->set_value($pk, $pk_value);
				}
			} else {
				$where = $this->get_primary_keys_value();
				$this->db->update($this->_table_name, $data, $where);
			}
			
			// Event: on_saved
			if ( method_exists($this, 'on_saved') ) {
				$this->on_saved();
			}
		}
	}
	
	/**
	 * To set a single row of records or multiple rows
	 * of records into the model. You can pass an
	 * associative array into the first parameter to set
	 * a single row of record or multiple dimension array
	 * to set mulitple records of data.
	 * 
	 * @param mixed $data Multidimension array
	 * @return null
	 */
	public function set_data($data)
	{
		if ( iterable($data) ) {
			// Check whether the first key is integer value.
			reset($data);
			$first_key = key($data);
			
			if ( is_int($first_key) ) {
				// Multiple data passed in the parameter.
				foreach ( $data as $row ) {
					// Event: on_data_set
					if ( method_exists($this, 'on_data_set') ) {
						$this->on_data_set($row);
					}
					
					$this->_data[] = $row;
				}
			} else {
				// Single row of data record.
				// Event: on_data_set
				if ( method_exists($this, 'on_data_set') ) {
					$this->on_data_set($data);
				}
				
				$this->_data[] = $data;
			}
			
			/* else {
				// Not integer.
				log_message('error', 'Parameter passed to EB_Model::set_data was not a multidimension array. Model name: ' . get_class($this));
				show_error(lang('_error_invalid_model_data_parameter'));
			}*/
		} else {
			// Invalid data format.
			log_message('error', 'Parameter passed to EB_Model::set_data was not a multidimension array. Model name: ' . get_class($this));
			show_error(sprintf(lang('_error_invalid_model_data'), get_class($this)));
		}
	}
	
	/**
	 * Set the table name.
	 * 
	 * @param string $table_name
	 * @return null
	 */
	public function set_table($table_name)
	{
		$this->_table_name = $table_name;
	}
	
	
	/**
	 * Set a value to a field on this model.
	 * The value set will be saved directly into database.
	 * Special value:
	 * false - skip this field from insert/updating the database
	 * null - replace with NULL in database.
	 * 
	 * @param string|array $field If array is provided, it will loop through all elements and set the values.
	 * @param string optional $value
	 * @return null
	 */
	public function set_value($field, $value = '')
	{
		if ( iterable($field) ) {
			foreach ( $field as $f => $v ) {
				$this->set_value($f, $v);
			}
		} else {
			if ( $this->is_empty() ) {
				// Create a new data set.
				$this->new_data();
			}
			
			// Set the field value.
			$this->_data[$this->_position][$field] = $value;
		}
	}
	
	/**
	 * Similar to the sprintf function. Only different is 
	 * the parameters is the field's name. The field's 
	 * name will be replaced in the formatting string.
	 * Eg: sprintf("Welcome %s!", "user_name") will translate
	 * into "Welcome Kent Lee!" 
	 * 
	 * @param string $format
	 * @param string optional $params
	 * @return string
	 */
	public function sprintf($format)
	{
		$args = func_get_args();
		if ( sizeof($args) <= 0 ) {
			// Unable to process.
			return '';
		}
		
		// Combine all field's value in an array.
		$params = array($format);
		
		for ( $i = 1; $i < sizeof($args); $i++ ) {
			$params[] = $this->get_value($args[$i], '');
		}
		
		return call_user_func_array('sprintf', $params);
	}
}