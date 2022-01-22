<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$config['whitespace'] 		= '/^(?:\S.{0,256}\S)?$/';
	$config['alphanumeric'] 	= '/^[A-Za-z0-9 ]+$/';
	$config['alphadash'] 		= '/^[a-z0-9_-]+$/i';
	$config['alphaspace'] 		= '/^[A-Za-z ]+$/';
	$config['alphahyphen'] 		= '/^[A-Za-z-]+$/';
	$config['alphanospace'] 	= '/^[A-Za-z]+$/';
	$config['numeric'] 			= '/^[0-9]*$/';
	$config['mobile'] 			= '/^\(?([7-9]{1})\)?[-. ]?([0-9]{2})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/';
	// $config['email'] 			= '/^[^@\s]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)+$/i';
	$config['email'] 			= '/^[a-zA-Z0-9._-]+@[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,5})$/i';
	$config['password_hash'] 	= '/^(?=.*[a-z])(?=.*\d)(?=.*[!@#$%&_])[A-Za-z\d!@#$%&_]/';
	$config['pan'] 				= '/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/';
	$config['gst'] 				= '/^([0]{1}[1-9]{1}|[1-2]{1}[0-9]{1}|[3]{1}[0-7]{1})([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/';
	$config['pincode'] 			= '/^[1-9][0-9]{5}$/';
	$config['upto_two_decimal'] = '/^(\d{1,5}|\d{0,5}\.\d{1,2})$/';