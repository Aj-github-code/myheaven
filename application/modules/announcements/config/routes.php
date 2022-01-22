<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$route['announcements'] 					= "announcements/announcements/index";
	$route['get-announcements'] 				= "announcements/announcements/ajax_list";
	$route['view-announcement/(:any)'] 			= "announcements/announcements/view/$1";