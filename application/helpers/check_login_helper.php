<?php
	defined('BASEPATH') or exit ('No direct script access allowed');

	if(!function_exists('check_user_login'))
	{
		function check_user_login($email_verification = TRUE, $ajax_call = FALSE)
		{
			$CI =& get_instance();
			$user_session_data = $CI->session->userdata();

			if(isset($user_session_data['signin_'.$CI->config->item('session_key')]) && $user_session_data['signin_'.$CI->config->item('session_key')])
			{
				$last_activity = $user_session_data['last_activity'];
				$current_time = time();
				$time_since_last_activity = ($current_time - $last_activity) / 60;
				
				if($time_since_last_activity > signin_constants::user_timeout)
				{
					$CI->session->unset_userdata('user_id');
					$CI->session->unset_userdata('signin_'.$CI->config->item('session_key'));
					$CI->session->unset_userdata('logged_in_since');
					$CI->session->unset_userdata('last_activity');
					
					$CI->session->set_flashdata('timed_out', 'TRUE');
					
					$requested_url = current_url();
					$CI->session->set_userdata('requested_url', $requested_url);
					$CI->session->set_flashdata('status', ['error' => 1, 'message' => 'Session timeout!']);

					if($ajax_call == TRUE)
					{
						$CI->session->set_userdata('requested_url', base_url() . dashboard_constants::dashboard_url);
						return FALSE;
					}
					else
					{
						redirect(base_url() . signin_constants::signin_url);
					}
				}
				else
				{

					$CI->session->unset_userdata('last_activity');
					$CI->session->set_userdata('last_activity', time());
					return TRUE;
				}
			}
			else
			{
				$requested_url = current_url();
				$CI->session->set_userdata('requested_url', $requested_url);
				
				if($ajax_call == TRUE)
				{
					return FALSE;
				}
				else
				{
					redirect(base_url() . signin_constants::signin_url);
				}
			}
		}
	}