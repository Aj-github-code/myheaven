<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$route['customers'] 							= "customers/customers/index";
	$route['get-customers'] 						= "customers/customers/ajax_list";
	$route['add-customer'] 							= "customers/customers/add";
	$route['edit-customer/(:any)'] 					= "customers/customers/edit/$1";
	$route['change-customer-status'] 				= "customers/customers/change";
	$route['customer_check_unique_email'] 			= "customers/customers/check_unique_email";
	$route['customer_check_unique_mobile'] 			= "customers/customers/check_unique_mobile";