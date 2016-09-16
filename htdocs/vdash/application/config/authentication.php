<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Source
|--------------------------------------------------------------------------
|
| This will be the source of where the Authentication class should get the
| permission list.
|
|	Available values: config | database
|
*/
$config['auth_source'] = 'database';

/*
|--------------------------------------------------------------------------
| Table Prefix
|--------------------------------------------------------------------------
|
| Table prefix name. This will be added to the each table name when working
| with the authentication model
|
| Leave empty if there is no prefix.
|
*/
$config['auth_prefix'] = 'auth_';

/*
|--------------------------------------------------------------------------
| Model Name
|--------------------------------------------------------------------------
|
| The Authentication class will initialize the model object of this name.
| This model must extends from EB_Model and implement the Authenticated_user
| interface.
|
*/
$config['auth_model_name'] = 'sys_user_model';

/*
|--------------------------------------------------------------------------
| Roles (For "config" source usage only)
|--------------------------------------------------------------------------
|
| Two-dimension Array
| 
| The array key will be the role's name while each array has a list of 
| permissions.
|
| Role can inherit from any other role by putting a semi-colon symbol after
| the role's name. Eg: child_role:parent_role.
|
| Permissions can have options after the semi-colon. Each option can be
| separated by a pipe symbol "|". Eg:
| array("permission:option1|option2", ... more permissions);
| 
|
*/
$config['auth_roles'] = array(
	/*'user' => array(
		// Use of colon in permission allowed specified additional parameters.
		// Parameter can be separated with pipe "|".
		'view_review', 'add_review:self', 'edit_review:self',
		'view_profile:self', 'edit_profile:self',
	),
	// Use of colon in role's name to inherit permission from another role.
	'manager:user' => array(
		'create_profile:everyone', 'edit_profile:everyone', 'view_profile:everyone',
		'edit_review:all',
		'force_logout:everyone',
	),
	'admin:manager' => array(
		'create_manager', 'edit_manager', 'delete_manager',
		'add_review:everyone',
		'delete_profile:everyone',
	),*/
);