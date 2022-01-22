<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	// $route['customers'] 							= "customers/customers/index";

	// $route['add-customer'] 							= "customers/customers/add";
	// $route['edit-customer/(:any)'] 					= "customers/customers/edit/$1";
	// $route['change-customer-status'] 				= "customers/customers/change";
	// $route['customer_check_unique_email'] 			= "customers/customers/check_unique_email";
	// $route['customer_check_unique_mobile'] 			= "customers/customers/check_unique_mobile";

	$route['crud_all'] 							= "crud/crud";
	$route['crud_list'] 						= "crud/crud/ajax_list";
	$route['crud_add'] 							= "crud/crud/add";
	$route['crud_edit/(:any)'] 					= "crud/crud/edit/$1";
	$route['crud_status'] 						= "crud/crud/change";
	$route['crud_check_unique_email'] 			= "crud/crud/check_unique_email";
	$route['crud_check_unique_mobile'] 			= "crud/crud/check_unique_mobile";
	