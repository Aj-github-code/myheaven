<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$route['payout'] 								= "payout/payout/index";
	$route['get-payout'] 							= "payout/payout/ajax_list";
	$route['add-payout'] 							= "payout/payout/add";
	$route['edit-payout/(:any)'] 					= "payout/payout/edit/$1";
	$route['change-payout-status'] 					= "payout/payout/change";
	$route['payout_check_unique_email'] 			= "payout/payout/check_unique_email";
	$route['payout_check_unique_mobile'] 			= "payout/payout/check_unique_mobile";