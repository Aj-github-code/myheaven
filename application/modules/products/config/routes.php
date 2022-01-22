<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$route['products'] 					= "products/products/index";
	$route['get-products/(:any)'] 		= "products/products/ajax_list/$1";
	$route['view-product/(:any)'] 		= "products/products/view/$1";