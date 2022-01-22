<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$route['my-products'] 					= "my_products/my_products/index";
	$route['get-my-products/(:any)'] 		= "my_products/my_products/ajax_list/$1";
	$route['view-my-product/(:any)'] 		= "my_products/my_products/view/$1";