<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/EB_Library.php');

class Authentication extends EB_Library {
	/**
	 * Whether the user has authenticated or not.
	 * 
	 * @var boolean
	 */
	protected $_authenticated = false;
	
	/**
	 * The model's name
	 * 
	 * @var string
	 */
	protected $_model_name = '';
	
	/**
	 * The model object that implement the Authenticated_user interface.
	 * 
	 * @var EB_Model
	 */
	protected $_model;
	
	/**
	 * The list of permissions with the appropriate parameters.
	 * Two-dimension array
	 * 
	 * @var mixed
	 */
	protected $_permissions = array();
	
	/**
	 * List of roles that available to current user.
	 * 
	 * @var array
	 */
	protected $_roles = array();
	
	/**
	 * The source of roles and permissions.
	 * Either database or config
	 * 
	 * @var string
	 */
	protected $_source = 'database';
	
	/**
	 * The database table's prefix for this
	 * library.
	 * 
	 * @var string
	 */
	protected $_table_prefix = '';
	
	/**
	 * Default constructor.
	 * 
	 * @param array optional $options
	 * @return null
	 */
	public function __construct($options = array())
	{
		parent::__construct($options);
		
		// Load the config file.
		$this->_CI->load->config('authentication');
		
		// Ensure settings.
		$this->_ensure_options($options, 'model_name', 'auth_model_name');
		$this->_ensure_options($options, 'source', 'auth_source');
		$this->_ensure_options($options, 'table_prefix', 'auth_prefix');
		
		// Load the model object.
		$this->_CI->load->model($this->_model_name);
		$model = $this->_CI->{$this->_model_name};
		
		if ( false === ($model instanceof EB_Model) || false === ($model instanceof Authenticated_user) ) {
			log_message('error', 'The model must be extends from EB_Model and must implement the Authenticated_user model interface.');
			show_error(lang('_error_invalid_authentication_model'), 500);
		}
		
		// Now, let's initialize the object itself.
		$model->initialize_from_session();
		
		// Check whether the model has records in it.
		if ( !$model->is_empty() ) {
			// Let's grabs the roles and permissions.
			$this->_model = $model;
			$this->_authenticated = true;
			$this->_initialize();
		}
	}
	
	/**
	 * To append a list of permissions into the existing permission list.
	 * 
	 * @param array $permissions
	 * @param boolean optional $override
	 * @return null
	 */
	public function append_permissions($permissions, $override = true)
	{
		if ( iterable($permissions) ) {
			foreach ( $permissions as $permission ) {
				$name = array_ensure($permission, 'name', '');
				$params = array_ensure($permission, 'params', array());
				
				$this->set_permission($name, $params, $override);
			}
		}
	}
	
	/**
	 * To check whether the user can perform such permission.
	 * The additional options is separated by a pipe symbol "|".
	 * The system will match if any of the option exists in the
	 * user's permission.
	 * 
	 * @param string $perm_name
	 * @param string optional $options
	 * @return boolean
	 */
	public function can($perm_name, $options = '')
	{
		$index = $this->_permission_index($perm_name);
		
		if ( false !== $index ) {
			if ( is_empty($options) ) {
				// Nothing else to check, this is allowed.
				return true;
			} else {
				$allowed_options = preg_split('/\|/', $options);
				$permission = $this->_permissions[$index];
				$params = array_ensure($permission, 'params', array());
				
				if ( iterable($params) ) {
					foreach ( $params as $param ) {
						if ( in_array($param, $allowed_options) ) {
							// In one of the allowed list.
							return true;
						}
					}
				}
			}
		}
		
		return false;
	}
	
	/**
	 * Return the model object.
	 * 
	 * @return EB_Model
	 */
	public function get_model()
	{
		return $this->_model;
	}
	
	/**
	 * Return the roles of this user.
	 * 
	 * @return array
	 */
	public function get_roles()
	{
		return $this->_roles;
	}
	
	/**
	 * To check if the user has the roles.
	 * 
	 * @param string $role_name
	 * @return boolean
	 */
	public function is($role_name)
	{
		$role_name = strtolower($role_name);
		return in_array($role_name, $this->_roles);
	}
	
	/**
	 * Return TRUE if the user has authenticated.
	 * 
	 * @return boolean
	 */
	public function is_authenticated()
	{
		return $this->_authenticated;
	}
	
	/**
	 * To add a permission into the authentication object.
	 * 
	 * @param string $perm_name
	 * @param array optional $perm_param
	 * @param boolean optional $override To specify whether to override the permission if exists.
	 * @return null
	 */
	public function set_permission($perm_name, $perm_param = array(), $override = true)
	{
		$perm_index = $this->_permission_index($perm_name);
		
		if ( false === $perm_index ) {
			// Just add in the permission.
			$this->_permissions[] = array(
				'name' => $perm_name,
				'params' => $perm_param,
			);
		} else {
			// See if it's should override it.
			if ( $override ) {
				$this->_permissions[$perm_index] = array(
					'name' => $perm_name,
					'params' => $perm_param,
				);
			}
		}
	}
	
	/**
	 * To add a particular role into the authentication object.
	 * This will add any related permissions into the object
	 * as well.
	 * 
	 * @param string $role_name
	 * @return null
	 */
	public function set_role($role_name)
	{
		return ;
		
		$this->_roles[] = strtolower($role_name);
		
		// Get the permissions of this role.
		$permissions = $this->_get_permissions($role_name, $parent_role);
		
		if ( false !== $permissions && iterable($permissions) ) {
			$this->append_permissions($permissions, !is_empty($parent_role));
		}
	}
	
	/**
	 * To set a list of roles into the object.
	 * 
	 * @param array $roles
	 * @return null
	 */
	public function set_roles($roles)
	{
		if ( iterable($roles) ) {
			foreach ( $roles as $role_name ) {
				$this->set_role($role_name);
			}
		}
	}
	
	/**
	 * To initialize the roles and permissions property based on the
	 * model object.
	 * 
	 * @return null
	 */
	protected function _initialize()
	{
		if ( null === $this->_model || $this->_model->is_empty() ) {
			return ;
		}
		
		$roles = $this->_model->get_roles();
		
		if ( iterable($roles) ) {
			foreach ( $roles as $role_name ) {
				// Add role.
				$this->set_role($role_name);
			}
		}
	}
	
	/**
	 * Return the list of permissions for particular role.
	 * It will return FALSE if there is no permission defined
	 * for such role.
	 * 
	 * @param string $role_name
	 * @param string optional $parent_name The parent's role name. This variable is pass by reference.
	 * @return array
	 */
	protected function _get_permissions($role_name, &$parent_role = '')
	{
		$CI =& get_instance();
		
		if ( $this->_source == 'config' ) {
			// Getting permissions from configuration file.
			$roles = $CI->config->item('auth_roles');
			
			foreach ( $roles as $rname => $permissions ) {
				if ( preg_match('/^(' . $role_name . '|' . $role_name . '\:(\S+))$/', $rname, $matches) ) {
					// The result array list.
					$result = array();
					// The list of permission name.
					$permission_names = array();
					
					if ( sizeof($matches) == 3 ) {
						$parent_role = $matches[2];
						$parent_permissions = $this->_get_permissions($parent_role);
					}
					
					if ( iterable($permissions) ) {
						foreach ( $permissions as $permission ) {
							$perm_segments = preg_split('/\:/', $permission);
							
							if ( sizeof($perm_segments) == 1 ) {
								// No parameters, just permission.
								$result[] = array(
									'name' => $permission,
									'params' => array(), 
								);
								$permission_names[] = $permission;
							} elseif ( sizeof($perm_segments) == 2) {
								// With params.
								$params = preg_split('/\|/', $perm_segments[1]);
								
								$result[] = array(
									'name' => $perm_segments[0],
									'params' => $params,
								);
								$permission_names[] = $perm_segments[0];
							}
						}
					}
					
					if ( isset($parent_permissions) && iterable($parent_permissions) ) {
						foreach ( $parent_permissions as $permission ) {
							$perm_name = array_ensure($permission, 'name', '');
							$perm_params = array_ensure($permission, 'params', array());
							
							if ( !in_array($perm_name, $permission_names) ) {
								// Not in array, add it.
								$result[] = array(
									'name' => $perm_name,
									'params' => $perm_params, 
								);
							}
						}
					}
					
					return $result;
				}
			}
		} else {
			// Database.
			$db_prefix = $this->_table_prefix;
			$sql  = "SELECT * FROM `{$db_prefix}role_perm_maps` ";
			$sql .= "LEFT JOIN `{$db_prefix}permissions` ON `{$db_prefix}role_perm_maps`.`permission_id` = `{$db_prefix}permissions`.`permission_id` ";
			$sql .= "LEFT JOIN `{$db_prefix}roles` ON `{$db_prefix}role_perm_maps`.`role_id` = `{$db_prefix}roles`.`role_id` ";
			$sql .= "WHERE `{$db_prefix}roles`.`role_name` = ?";
			
			$qry = $CI->db->query($sql, array($role_name));
			
			if ( $qry->num_rows() > 0 ) {
				$result = array();
				$permission_names = array();
				$qry_result = $qry->result_array();
				$parent_role_id = $qry_result[0]['inherit_role'];
				$parent_permissions = array();
				
				if ( !is_empty($parent_role_id) ) {
					// Get the parent role.
					$sql = "SELECT * FROM `{$db_prefix}roles` WHERE `role_id` = ?";
					$qry = $CI->db->query($sql, array($parent_role_id));
					
					if ( $qry->num_rows() == 1 ) {
						$qry_result_parent = $qry->result_array();
						$qry_result_parent = $qry_result_parent[0];
						// Assign the parent role's name.
						$parent_role = $qry_result_parent['role_name'];
						// Return the set of parent permissions.
						$parent_permissions = $this->_get_permissions($parent_role);
					}
				}
				
				foreach ( $qry_result as $row ) {
					$code = $row['permission_code'];
					$parameter = $row['options'];
					
					if ( is_empty($parameter) ) {
						$parameter = array();
					} else {
						$parameter = preg_split('/\|/', $parameter);
					}
					
					$result[] = array(
						'name' => $code,
						'params' => $parameter,
					);
					// Add into the permission name array for later use.
					$permission_names[] = $code;
				}
				
				// Check parent permissions.
				if ( iterable($parent_permissions) ) {
					foreach ( $parent_permissions as $permission ) {
						$perm_name = array_ensure($permission, 'name', false);
						
						if ( false !== $perm_name && !in_array($perm_name, $permission_names) ) {
							$result[] = $permission;
						}
					}
				}
				
				return $result;
			}
		}
		
		return false;
	}
	
	/**
	 * Return the permission index in the current permissions array.
	 * It will return FALSE if the permission name not found.
	 * 
	 * @param string $perm_name
	 * @return int|boolean
	 */
	protected function _permission_index($perm_name)
	{
		if ( iterable($this->_permissions) ) {
			foreach ( $this->_permissions as $index => $permission ) {
				$name = array_ensure($permission, 'name', '');
				
				if ( $name == $perm_name ) {
					return $index;
				}
			}
		}
		
		return false;
	}
	
	/**
	 * To ensure the property value in this class is properly setup.
	 * It allowed value to be set during class initialization or 
	 * predefine in the authentication config file.
	 * 
	 * @param array $user_option The initialization option array.
	 * @param string $option_name The array element's key that represent the property value. It should be same as the property's name without the underscore.
	 * @param string $config_name The array element's key in the configuration file that represent this property.
	 * @return null
	 */
	private function _ensure_options($user_option, $option_name, $config_name)
	{
		$CI =& get_instance();
		
		// Define the property name.
		$property_name = '_' . $option_name;
		
		// Check if user has this option specified in the parameters.
		if ( isset($user_option[$option_name]) ) {
			$this->$property_name = $user_option[$property_name];
		} elseif ( false !== ($config_value = $CI->config->item($config_name)) ) {
			$this->$property_name = $config_value;
		}
	}
}