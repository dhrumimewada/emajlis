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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['vendor-partners'] = 'vendor_Partners/index';
$route['vendor-partners/add'] = 'vendor_Partners/add';
$route['vendor-partners/edit/(:any)'] = 'vendor_Partners/edit/$1';
$route['vendor-partners/edit'] = 'vendor_Partners/edit';
$route['industry-looking-for'] = 'industry_Looking/index';
$route['industry-looking-for/add'] = 'industry_Looking/add';
$route['industry-looking-for/edit/(:any)'] = 'industry_Looking/edit/$1';
$route['industry-looking-for/edit'] = 'industry_Looking/edit';

$route['industry/add'] = 'industry/add';
$route['industry/edit/(:any)'] = 'industry/edit/$1';
$route['industry/edit'] = 'industry/edit';

$route['meeting-preference'] = 'meeting_preference';
$route['meeting-preference/add'] = 'meeting_preference/add';
$route['meeting-preference/edit/(:any)'] = 'meeting_preference/edit/$1';
$route['meeting-preference/edit'] = 'meeting_preference/edit';

// admin profile
$route['myprofile'] = 'Admin_profile/admin_profile';
$route['change-password'] = 'Admin_profile/admin_change_password';

// Admin_management 
$route['admins'] = 'Admin_management/index';
$route['admins/add'] = 'Admin_management/post';
$route['admins/edit/(:any)'] = 'Admin_management/put/$1';

$route['reset-password/(:any)'] = 'Login/reset_password/$1';
$route['success_msg'] = 'Login/success_reset_password/';
