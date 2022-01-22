<?php
	defined('BASEPATH') or exit ('No direct script access allowed');

	if(!function_exists('handle_number_format'))
	{
		function handle_number_format($number)
		{
			return number_format($number, 2, '.', ',');
		}
	}