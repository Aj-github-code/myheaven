<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Forgot_password extends MY_Controller {
    private $num_signin_attempts;
	private $ip_address;
	private $logged_in;
	
	function __construct() {
		parent::__construct();
		$this->load->model('forgot_password_model', 'forgot_password');
		$this->ip_address = $this->common_lib->get_client_ip();

		if($this->session->userdata('signin_'.$this->config->item('session_key')))
		{
			$this->logged_in = TRUE;
		}
		else
		{
			$this->logged_in = FALSE;
		}
	}

    function index() {
        if($this->logged_in === TRUE)
		{
			redirect(base_url() . dashboard_constants::dashboard_url);
		}
		else
		{
			$data['meta_title'] 		= "Forgot Password";
			$data['meta_description'] 	= "Forgot Password";
			$data['meta_keywords'] 		= "Forgot Password";
			$data['content']            = "forgot_password/form";
			echo Modules::run("templates/".$this->config->item('theme'), $data);
		}
    }

    function ajax_forgot_password()
    {
    	$response = ['error' => 1, 'message' => 'Access denied'];
    	if(strpos($this->input->post('mobile_or_email'), '@'))
		{
			$type = 'email';
			$this->form_validation->set_rules('mobile_or_email', 'E-mail id', 'required|max_length[50]|callback_custom_email[mobile_or_email]');
		}
		else
		{
			$type = 'mobile';
			$this->form_validation->set_rules('mobile_or_email', 'Mobile number', 'required|max_length[10]|callback_custom_mobile[mobile_or_email]');
		}
		$reset 	  = isset($_POST['reset']) ? $_POST['reset'] : '';
		if($reset == 'password')
		{
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[32]|regex_match['.$this->config->item("password_hash").']');
			$this->form_validation->set_rules('password_confirmation', 'Confirm password', 'required|min_length[8]|max_length[32]|matches[password]');
		}

		if($this->form_validation->run($this) === TRUE)
		{
			$mobile_or_email= isset($_POST['mobile_or_email']) ? strtolower($_POST['mobile_or_email']) : '';
			$password 		= isset($_POST['password']) ? $_POST['password'] : '';
			$when 			= isset($_POST['when']) ? $_POST['when'] : '';
			$otp 			= isset($_POST['otp']) ? $_POST['otp'] : '';
			$otp_type 		= $this->config->item('otp_types')['forgot_password'];
			$response 		= $this->_validate_signin($mobile_or_email, $type);

			if($response['error'] == 0 && $when == 'otp')
			{
				$user_data 	= isset($response['user_data']) ? $response['user_data'] : [];
				if(!empty($user_data))
				{
					$response 	= Modules::run('otp/otp/validate_otp', ['otp_type' => $otp_type, 'otp' => $otp, 'mobile_or_email' => $mobile_or_email]);

					if($response['error'] == 0)
					{
						if($reset == 'password')
						{
							$update['password'] 			= password_hash($password, PASSWORD_DEFAULT);
							$update['password_reset_string']= NULL;
							$update['password_reset_time'] 	= NULL;
							
							if($this->forgot_password->update_user_table($user_data['id'], $update))
							{
								$response 					= ['error' => 0, 'message' => 'Your password is successfully changed, system will take you to sign in page. Please wait...'];
							}
							else
							{
								$response 					= ['error' => 1, 'message' => 'Unable to reset password'];
							}
						}
					}
				}
				else
				{
					$response = ['error' => 1, 'message' => 'User data not found'];
				}
			}
		}
		else
		{
			$errors 		= $this->form_validation->error_array();
			$response 		= ['error' => 2, 'message' => $errors];
		}
		echo json_encode($response);
    }

    private function _validate_signin($username, $type) {
    	$response 	= ['error' => 1, 'message' => 'Invalid request'];
    	$user_signin = $this->forgot_password->get_user_data($type, $username);

		if(count($user_signin) > 0)
		{
			$user_id 				= $user_signin['id'];
			$email 					= $user_signin['email'];
			$mobile 				= $user_signin['mobile'];
			$username 				= $user_signin['username'];
			$full_name 				= $user_signin['full_name'];
			$group_id 				= $user_signin['group_id'];
			$profile_pic 			= $user_signin['profile_pic'];
			$status 				= $user_signin['status'];
			$hashed_pass 			= $user_signin['password'];
			$password_reset_string 	= $user_signin['password_reset_string'];

			if($user_signin['email_verified'] === "yes")
			{
				$email_verified = TRUE;
			}
			else
			{
				$email_verified = FALSE;
			}
			if($user_signin['mobile_verified'] === "yes")
			{
				$mobile_verified = TRUE;
			}
			else
			{
				$mobile_verified = FALSE;
			}

			if($status == 1)
			{
				$user_data = array(
									'id' 					=> $user_id,
									'email' 				=> $email,
									'mobile' 				=> $mobile,
									'username' 				=> $username,
									'full_name' 			=> $full_name,
									'group_id' 				=> $group_id,
									'profile_pic' 			=> $profile_pic,
									'status'				=> $status,
									'email_verified' 		=> $email_verified,
									'mobile_verified' 		=> $mobile_verified,
									'password_reset_string' => $password_reset_string,
								);
				$response = ['error' => 0, 'message' => 'Success', 'user_data' => $user_data];
			}
			else
			{
				$response = ['error' => 1, 'message' => 'Your account is in-active state, please contact administrator'];
			}
		}
		else
		{
			$response = ['error' => 1, 'message' => 'Invalid mobile number/email id'];
		}
		return $response;
	}

	public function custom_email($str, $func)
    {
        $this->form_validation->set_message('custom_email', 'Please enter valid e-mail id');
        return (!preg_match("".$this->config->item("email")."", $str)) ? FALSE : TRUE;
    }

    public function custom_mobile($str, $func)
    {
        $this->form_validation->set_message('custom_mobile', 'Please enter valid mobile number');
        return (!preg_match("".$this->config->item("mobile")."", $str)) ? FALSE : TRUE;
    }
}