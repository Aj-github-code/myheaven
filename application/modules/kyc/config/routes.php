<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$route['kyc'] 							= "kyc/kyc/index";
	$route['get-kyc'] 						= "kyc/kyc/ajax_list";
	$route['add-kyc'] 						= "kyc/kyc/add";
	$route['edit-kyc/(:any)'] 				= "kyc/kyc/edit/$1";
	$route['change-kyc-status'] 			= "kyc/kyc/change";