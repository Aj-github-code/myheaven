<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$route['top-up'] 					= "top_up/top_up/index";
	$route['get-top-up'] 				= "top_up/top_up/ajax_list";
	$route['add-top-up'] 				= "top_up/top_up/add";
	$route['place-top-up'] 				= "top_up/top_up/place";
	$route['view-top-up/(:any)'] 		= "top_up/top_up/view/$1";
	$route['print-top-up/(:any)'] 		= "top_up/top_up/print_pdf/$1";
	$route['process-top-up'] 			= "top_up/top_up/process";
	$route['change-top-up-status'] 		= "top_up/top_up/change";
	$route['check-member'] 				= "top_up/top_up/check_member";