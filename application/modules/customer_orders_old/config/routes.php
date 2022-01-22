<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$route['customer-orders'] 					= "customer_orders/customer_orders/index";
	$route['get-customer-orders'] 				= "customer_orders/customer_orders/ajax_list";
	$route['add-customer-order'] 				= "customer_orders/customer_orders/add";
	$route['place-customer-order'] 				= "customer_orders/customer_orders/place";
	$route['view-customer-order/(:any)'] 		= "customer_orders/customer_orders/view/$1";
	$route['print-customer-order/(:any)'] 		= "customer_orders/customer_orders/print/$1";
	$route['process-customer-order'] 			= "customer_orders/customer_orders/process";
	$route['change-customer-order-status'] 		= "customer_orders/customer_orders/change";