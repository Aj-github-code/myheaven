<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$route['gallery'] 				= "gallery/gallery/index";
	$route['gallery/upload'] 		= "gallery/gallery/upload";
	$route['gallery/ajax_upload'] 	= "gallery/gallery/ajax_upload";
	$route['get-images/(:any)'] 	= "gallery/gallery_images/ajax_list/$1";
	$route['load-image-form'] 		= "gallery/gallery_images/form";
	$route['upload-image'] 			= "gallery/gallery_images/upload";
	$route['change-image-status'] 	= "gallery/gallery_images/change";
