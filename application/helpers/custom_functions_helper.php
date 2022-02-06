<?php
	defined('BASEPATH') or exit ('No direct script access allowed');

	if(!function_exists('handle_number_format'))
	{
		function handle_number_format($number)
		{
			return number_format($number, 2, '.', ',');
		}
		function color_type($var)
		{
		 return ($var==500) ? "red.png" : (($var==1000) ? "male-green.png" : (($var==2000) ? "male-green.png" : "addnew2.png"));
		}
	}