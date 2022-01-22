<?php
	if(!defined('BASEPATH')) exit('No direct script access allowed');

	class Signin_constants {
		const num_signin_attempts 			= 10;
		const user_timeout 					= 240;
		const black_list_timeout 			= 15;
		const black_list_reset_time 		= 60;
		const mobile_ver_string_time 		= 15; // Minutes
		const email_signin_allowed 			= TRUE;

	 	/***** Auth Uri *****/
		
		const register_url 					= "registrstion/";
		const signin_url 					= "signin/";
		const ajax_signin_url 				= "ajax_signin/";
		const logout_url 					= "signout/";
	}