<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$route['repurchase'] 					= "repurchase/repurchase/index";
	$route['get-repurchase'] 				= "repurchase/repurchase/ajax_list";
	$route['add-repurchase'] 				= "repurchase/repurchase/add";
	$route['place-repurchase'] 				= "repurchase/repurchase/place";
	$route['view-repurchase/(:any)'] 		= "repurchase/repurchase/view/$1";
	$route['print-repurchase/(:any)'] 		= "repurchase/repurchase/print_pdf/$1";
	$route['process-repurchase'] 			= "repurchase/repurchase/process";
	$route['change-repurchase-status'] 		= "repurchase/repurchase/change";
	$route['check-member-for-repurchase'] 	= "repurchase/repurchase/check_member";