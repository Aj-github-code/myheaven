<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$route['news'] 					= "news/news/index";
	$route['get-news'] 				= "news/news/ajax_list";
	$route['view-news/(:any)'] 		= "news/news/view/$1";
	$route['mark-all-seen/(:any)'] 	= "news/news/mark_seen/$1";