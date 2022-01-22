<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$route['franchise'] 							= "franchise/franchise/index";
	$route['get-franchise'] 						= "franchise/franchise/ajax_list";
	$route['add-franchise'] 						= "franchise/franchise/add";
	$route['add-new_pass'] 						    = "franchise/franchise/new_pass";
	$route['edit-franchise/(:any)'] 				= "franchise/franchise/edit/$1";
	$route['change-franchise-status'] 				= "franchise/franchise/change";
	$route['franchise_check_unique_email'] 			= "franchise/franchise/check_unique_email";
	$route['franchise_check_unique_mobile'] 		= "franchise/franchise/check_unique_mobile";

	$route['manage-kyc/(:any)'] 					= "franchise/kyc/index/$1";
	$route['get-kyc'] 								= "franchise/kyc/ajax_list";
	$route['change-kyc-status'] 					= "franchise/kyc/change";
	$route['save-kyc-status'] 						= "franchise/kyc/save";
	$route['process-kyc'] 							= "franchise/kyc/process";

	$route['messages/(:any)'] 						= "franchise/messages/index/$1";
	$route['get-messages'] 							= "franchise/messages/ajax_list";
	$route['add-message/(:any)'] 					= "franchise/messages/add/$1";
	$route['edit-message/(:any)/(:any)'] 			= "franchise/messages/edit/$1/$2";
	$route['change-message-status'] 				= "franchise/messages/change";