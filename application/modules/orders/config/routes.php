<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$route['orders'] 					= "orders/orders/index";
	$route['get-orders'] 				= "orders/orders/ajax_list";
	$route['view-order/(:any)'] 		= "orders/orders/view/$1";
	$route['print-order/(:any)'] 		= "orders/orders/print_pdf/$1";
	$route['change-order-status'] 		= "orders/orders/change";