<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$route['messages'] 					= "messages/messages/index";
	$route['get-messages'] 				= "messages/messages/ajax_list";
	$route['view-message/(:any)'] 		= "messages/messages/view/$1";