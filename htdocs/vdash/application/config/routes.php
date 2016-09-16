<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'user/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'user/login';
$route['logout'] = 'user/logout';
$route['dashboard'] = 'dashboard';
$route['license'] = 'license';
$route['business/user'] = 'sys_user/index/business';
$route['sys_user/change-password/(\d+)'] = 'sys_user/change_password/$1';

/* User Controller */
$route['user/a_user_sessions_weekly'] = 'user/a_user_session/weekly';
$route['user/a_user_sessions_monthly'] = 'user/a_user_session/monthly';

/* API Routes */
$route['api/machine-start'] = 'api/machine_start';
$route['api/machine-off'] = 'api/machine_off';
$route['api/machine-register'] = 'api/machine_register';
$route['api/machine-unregister'] = 'api/machine_unregister';
$route['api/user-signin'] = 'api/user_signin';
$route['api/user-signout'] = 'api/user_signout';
$route['api/app-start'] = 'api/app_start';
$route['api/app-close'] = 'api/app_close';