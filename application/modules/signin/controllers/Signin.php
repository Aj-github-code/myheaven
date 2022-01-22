<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Signin extends MY_Controller {
    private $num_signin_attempts;
	private $ip_address;
	private $logged_in;
	
	function __construct() {
		parent::__construct();
		ini_set('memory_limit', '128M');
		$this->load->model('signin_model', 'signin');
		$this->load->model('franchise/franchise_model', 'franchise'); 

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
			$data['meta_title'] 		= "Sign In";
			$data['meta_description'] 	= "Sign In";
			$data['meta_keywords'] 		= "Sign In";
			$data['content']            = "signin/form";
			echo Modules::run("templates/".$this->config->item('theme'), $data);
		}
    }

    public function registrstion_form() {
        if($this->logged_in === TRUE)
		{
			redirect(base_url() . dashboard_constants::dashboard_url);
		}
		else
		{
			if ($this->input->post()) {
				$response=$this->post_registrstion();

				if ($response["error"]==0) {
				
				redirect(base_url() . dashboard_constants::dashboard_url);

				}else{
					$data["post_data"]=$this->input->post();
				}
			}
			$data['meta_title'] 		= "Sign In";
			$data['meta_description'] 	= "Sign In";
			$data['meta_keywords'] 		= "Sign In";
			$data['page_title'] 		= "Registrstion Form";
			$data['content']            = "signin/registrstion";
			echo Modules::run("templates/".$this->config->item('theme'), $data);
		}
    }

    function ajax_signin()
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
		if($this->input->post('signin_type') == 'password')
		{
			$this->form_validation->set_rules('password', 'Password', 'required');
		}

		if($this->form_validation->run($this) === TRUE)
		{
			$mobile_or_email= isset($_POST['mobile_or_email']) ? strtolower($_POST['mobile_or_email']) : '';
			$password 		= isset($_POST['password']) ? $_POST['password'] : '';
			$when 			= isset($_POST['when']) ? $_POST['when'] : '';
			$otp 			= isset($_POST['otp']) ? $_POST['otp'] : '';
			$signin_type 	= isset($_POST['signin_type']) ? $_POST['signin_type'] : 'password';
			$otp_type 		= $this->config->item('otp_types')['signin'];
			$response 		= $this->_validate_signin($mobile_or_email, $password, $type, $signin_type);
			$user_data 		= isset($response['user_data']) ? $response['user_data'] : [];

			if($response['error'] == 0)
			{
				if(!empty($user_data))
				{
					if($signin_type == 'password')
					{
						if($response['error'] == 0)
						{


							$this->set_user_session($user_data);
							$response = ['error' => 0, 'message' => 'You are successfully signed in, system will take you to dashboard. Please wait...'];
						}
					}
					
				/*	if($when == 'otp')
					{
						$response = Modules::run('otp/otp/validate_otp', ['otp_type' => $otp_type, 'otp' => $otp, 'mobile_or_email' => $mobile_or_email]);

						if($response['error'] == 0)
						{
							$this->set_user_session($user_data);
							$response = ['error' => 0, 'message' => 'You are successfully signed in, system will take you to dashboard. Please wait...'];
						}
					}*/
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


 	private function form_validation_rules($data=[])
    {
            $this->form_validation->set_rules('sponsor_id', 'Sponsor Id', 'required|trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('placement', 'placement', 'required|trim|xss_clean|strip_tags');
           // $this->form_validation->set_rules('pin', 'pin', 'required|trim|xss_clean|strip_tags');
            //$this->form_validation->set_rules('ownid', 'ownid', 'required|trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('your_name', 'Your Name', 'required|max_length[191]|trim|xss_clean|strip_tags');
            // $this->form_validation->set_rules('franchise_name', 'Franchise Name', 'required|max_length[191]|trim|xss_clean|strip_tags');
            // $this->form_validation->set_rules('type', 'Type', 'required|trim|xss_clean|strip_tags');
            // $this->form_validation->set_rules('mobile', 'Mobile No', 'required|max_length[10]|trim|xss_clean|strip_tags|callback_custom_mobile[mobile]|callback_unique_mobile[mobile]');
            // $this->form_validation->set_rules('email', 'Email', 'required|max_length[50]|trim|xss_clean|strip_tags|callback_custom_email[email]|callback_unique_email[email]');
            // $this->form_validation->set_rules('telephone', 'Telephone', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('dob', 'Dob', 'trim|xss_clean|strip_tags');
            // $this->form_validation->set_rules('address', 'Address', 'trim|xss_clean|strip_tags');
            if(isset($_POST['pincode']) && !empty($_POST['pincode']))
            {
                $this->form_validation->set_rules('pincode', 'Pincode', 'max_length[6]|trim|xss_clean|strip_tags');
            }
            // $this->form_validation->set_rules('pan', 'Pan', 'trim|xss_clean|strip_tags');
            // $this->form_validation->set_rules('gst', 'Gst', 'trim|xss_clean|strip_tags');
            // $this->form_validation->set_rules('trade_license_no', 'Trade License No', 'trim|xss_clean|strip_tags');
            // $this->form_validation->set_rules('bank_account', 'Bank Account', 'trim|xss_clean|strip_tags');
            // $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|xss_clean|strip_tags');
            // $this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|xss_clean|strip_tags');
            // $this->form_validation->set_rules('ifsc_code', 'IFSC Code', 'trim|xss_clean|strip_tags');
            // $this->form_validation->set_rules('status', 'Status', 'required|trim|xss_clean|strip_tags');
    }



    public function post_registrstion()
    {	
     	$response = ['error' => 1, 'message' => 'Access denied'];

		$this->form_validation->set_rules(
		'user_name', 'User id', 'trim|required|callback_isUserExist'
		);

		if($this->input->post('signin_type') == 'password')
		{
			$this->form_validation->set_rules('password', 'Password', 'required');
		}
		$user_count=$this->signin->userCount();
		
 		if ($this->input->post('user_name')!="") {
	
			$user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';


		}else{
			$user_name =  strtoupper("C".rand(100,9999) . ($user_count[id]+1)."S");
		}

		$sponsor_id = isset($_POST['sponsor_id']) ? $_POST['sponsor_id'] : '';

    	$placement = (!empty($_POST['placement'])) ? (($_POST['placement']=="right") ? "right" : "left") : "left" ;

		if (!in_array($placement, ["right","left"])) {
			$response = ['error' => 1, 'message' => 'placement not exist please choose different placement'];
		}

		if ($this->isUserExist($user_name,"u")) {
			if (!$this->isUserExist($sponsor_id,"s")) {
				
				//$data['post_data']          = $this->input->post();
				$this->form_validation_rules();

   				$date=date('Y-m-d H:i:s');  
     			$columnName=$this->getLeftRightMemberColumnName($placement);
     			$placementid=$this->signin->getPlacement($sponsor_id,$columnName);
    			//exit("ddd");
     			//echo validation_errors();

     			$_POST['placementid']=$placementid;
		if($this->form_validation->run($this) === TRUE)
		{
			
			$mobile_or_email= isset($_POST['mobile_or_email']) ? strtolower($_POST['mobile_or_email']) : '';
			$password 		= isset($_POST['password']) ? $_POST['password'] : '';
			$when 			= isset($_POST['when']) ? $_POST['when'] : '';
			$otp 			= isset($_POST['otp']) ? $_POST['otp'] : '';
			$signin_type 	= isset($_POST['signin_type']) ? $_POST['signin_type'] : 'password';
			$otp_type 		= $this->config->item('otp_types')['signin'];
			//$response 		= $this->_validate_signin($mobile_or_email, $password, $type, $signin_type);
			//$user_data 		= isset($response['user_data']) ? $response['user_data'] : [];
			 
			if($this->input->post())
			{
				$data['post_data']          = $this->input->post();
				$response               = $this->save('', $this->security->xss_clean($this->input->post()));

				$this->signin->updateSponsor($columnName, $user_name,$placementid);
				$this->signin->insertIntoPinReferenceTable($user_name);
				// $this->signin->updateUnits($ownid,$pinno);
				//$this->session->set_flashdata('status', $response);
				if ($data['post_data']["medium"]=="web") {
					$this->session->set_flashdata('status', $response);
					}
			} 

			$this->set_user_session($data['post_data']);
			$response = ['error' => 0, 'message' => 'You are successfully signed in, system will take you to dashboard. Please wait...'];
					 
			if($when == 'otp')
			{
				$response = Modules::run('otp/otp/validate_otp', ['otp_type' => $otp_type, 'otp' => $otp, 'mobile_or_email' => $mobile_or_email]);

				if($response['error'] == 0)
				{
					$this->set_user_session($data['post_data']);
					$response = ['error' => 0, 'message' => 'You are successfully signed in, system will take you to dashboard. Please wait...'];
				}
			}
			 
		}
		else
		{
			//exit("else");
			$errors 		= $this->form_validation->error_array();
			$response 		= ['error' => 2, 'message' => $errors];
		}

 			}else{
			$response = ['error' => 1, 'message' => 'sponsor_id not exist please choose different sponsor_id'];

			}
  
		}else{
			$response = ['error' => 1, 'message' => 'User already exist please choose different user_name'];
		}


	
		return $response;
    }

    public function ajax_registrstion()
    {

    	//exit("sss");
    	$response = ['error' => 1, 'message' => 'Access denied'];

		$this->form_validation->set_rules(
		'user_name', 'User id', 'trim|required|callback_isUserExist'
		);

		if($this->input->post('signin_type') == 'password')
		{
			$this->form_validation->set_rules('password', 'Password', 'required');
		}
		$user_count=$this->signin->userCount();
		
 		if ($this->input->post('user_name')!="") {
	
			$user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';

		}else{
			$user_name =  strtoupper("C".rand(100,9999) . ($user_count[id]+1)."S");
		}

		$sponsor_id = isset($_POST['sponsor_id']) ? $_POST['sponsor_id'] : '';

    	$placement = (!empty($_POST['placement'])) ? (($_POST['placement']=="right") ? "right" : "left") : "left" ;

		if (!in_array($placement, ["right","left"])) {
			$response = ['error' => 1, 'message' => 'placement not exist please choose different placement'];
		}

		if ($this->isUserExist($user_name)) {
			if (!$this->isUserExist($sponsor_id)) {
				
				//$data['post_data']          = $this->input->post();
				$this->form_validation_rules();

   				$date=date('Y-m-d H:i:s');  
     			$columnName=$this->getLeftRightMemberColumnName($placement);
     			$placementid=$this->signin->getPlacement($sponsor_id,$columnName);

     			$_POST['placementid']=$placementid;

		if($this->form_validation->run($this) === TRUE)
		{
			$mobile_or_email= isset($_POST['mobile_or_email']) ? strtolower($_POST['mobile_or_email']) : '';
			$password 		= isset($_POST['password']) ? $_POST['password'] : '';
			$when 			= isset($_POST['when']) ? $_POST['when'] : '';
			$otp 			= isset($_POST['otp']) ? $_POST['otp'] : '';
			$signin_type 	= isset($_POST['signin_type']) ? $_POST['signin_type'] : 'password';
			$otp_type 		= $this->config->item('otp_types')['signin'];
			//$response 		= $this->_validate_signin($mobile_or_email, $password, $type, $signin_type);
			//$user_data 		= isset($response['user_data']) ? $response['user_data'] : [];
			//	exit("fffa");

			// if($response['error'] == 0)
			// {
				// if(!empty($user_data))
				// {
					// if($signin_type == 'password')
					// {
						// if($response['error'] == 0)
						// {

							if($this->input->post())
							{
								$data['post_data']          = $this->input->post();
								$response               = $this->save('', $this->security->xss_clean($this->input->post()));

								   $this->signin->updateSponsor($columnName, $user_name,$placementid);
   								   $this->signin->insertIntoPinReferenceTable($user_name);
     							  // $this->signin->updateUnits($ownid,$pinno);

								//$this->session->set_flashdata('status', $response);
								if ($data['post_data']["medium"]=="web") {
									$this->session->set_flashdata('status', $response);
 								}
							} 

						 

							$this->set_user_session($data['post_data']);
							$response = ['error' => 0, 'message' => 'You are successfully signed in, system will take you to dashboard. Please wait...'];
						//}
					//}
					
					if($when == 'otp')
					{
						$response = Modules::run('otp/otp/validate_otp', ['otp_type' => $otp_type, 'otp' => $otp, 'mobile_or_email' => $mobile_or_email]);

						if($response['error'] == 0)
						{
							$this->set_user_session($data['post_data']);
							$response = ['error' => 0, 'message' => 'You are successfully signed in, system will take you to dashboard. Please wait...'];
						}
					}
				// }
				// else
				// {
				// 	$response = ['error' => 1, 'message' => 'User data not found'];
				// }
			//}
		}
		else
		{
			$errors 		= $this->form_validation->error_array();
			$response 		= ['error' => 2, 'message' => $errors];
		}


			}else{
			$response = ['error' => 1, 'message' => 'sponsor_id not exist please choose different sponsor_id'];

			}
		


		}else{
			$response = ['error' => 1, 'message' => 'User already exist please choose different user_name'];
		}


	
		echo json_encode($response);
    }


    private function save($id, $post_data)
    {
            $response                                   = ['error' => 1, 'message' => 'Invalid request'];

            if(!empty($post_data))
            {
                $save['ownid']                     = $post_data['user_name'];
                $save['sponsor_id']                     = $post_data['sponsor_id'];
                $save['placementid']                     = $post_data['placementid'];
                $save['placement']                     = $post_data['placement'];
                $save['pincode']                     = $post_data['pincode'];
                $save['your_name']                      = htmlentities($post_data['your_name']);
                $save['franchise_name']                 = htmlentities($post_data['your_name']);
                $save['type']                           = htmlentities($post_data['type']);
               // $save['email']                          = htmlentities($post_data['email']);
                $save['mobile']                         = htmlentities($post_data['mobile']);
                 // $save['telephone']                      = htmlentities($post_data['telephone']);
                $save['dob']                            = htmlentities($post_data['dob']);
                // $save['address']                        = $post_data['address'];
                $save['pincode']                        = htmlentities($post_data['pincode']);
                $save['pan']                            = htmlentities($post_data['pan']);
                // $save['gst']                            = htmlentities($post_data['gst']);
                // $save['trade_license_no']               = htmlentities($post_data['trade_license_no']);
                // $save['bank_account']                   = htmlentities($post_data['bank_account']);
                // $save['bank_name']                      = $post_data['bank_name'];
                // $save['branch_name']                    = $post_data['branch_name'];
                // $save['ifsc_code']                      = $post_data['ifsc_code'];
                // $save['status']                         = htmlentities($post_data['status']);
                $save['modified_on']                    = date('Y-m-d H:i:s');
                $save['modified_by']                    = $this->session->userdata('user_id');

                if(empty($id))
                {
                    if(isset($post_data['password']) && !empty($post_data['password']))
                    {
                        $password                       = $post_data['password'];
                    }
                    else
                    {
                       // $password                       = generatePassword();
                                                $password                       = $this->common_lib->generatePassword();

                    }

                   // $franchise_code                     = generateUniqueColumnCode(franchise_table::sql_table_franchise, 'franchise_code', 'MYHEAVEN', 6);
                    $franchise_code                     = $this->common_lib->generateUniqueColumnCode(franchise_table::sql_table_franchise, 'franchise_code', 'MYHEAVEN', 6);


                    $save['franchise_code']             = $franchise_code;
                    $save['password']                   = password_hash($password, PASSWORD_DEFAULT);
                    $save['kyc_status']                 = 'pending';
                    $save['kyc_message']                = 'Please add kyc documents';
                    $save['created_on']                 = date('Y-m-d H:i:s');
                    $save['created_by']                 = $this->session->userdata('user_id');

                    $response                           = $this->franchise->save($id, $save);
                    if($response['error'] == 0 && empty($id))
                    {
                        $save['password']               = $password;

                        /*$html                           = $this->load->view('emailers/welcome-franchise', $save, true);

                        $email_data                     = [
                                                            'to'            => [
                                                                                [
                                                                                    'name'  => $save['franchise_name'],
                                                                                    'email' => $save['email']
                                                                                ]
                                                                            ],
                                                            'cc'            => [],
                                                            'bcc'           => [],
                                                            'subject'       => 'Welcome To Myheaven',
                                                            'message'       => $html,
                                                            'altbody'       => '',
                                                            'attachments'   => [],
                                                            'html'          => true,
                                                        ];

                        Modules::run("php_mailer/send", $email_data);*/
                    }
                }
                else
                {
                    if(isset($post_data['password']) && !empty($post_data['password']))
                    {
                        $save['password']               = password_hash($post_data['password'], PASSWORD_DEFAULT);
                    }
                    $response                           = $this->franchise->save($id, $save);
                }
            }
            return $response;
    }

   private function getLeftRightMemberColumnName($placement){
        if ($placement == "left") {
            $columnName = "leftmember";
        } else {
            $columnName = "rightmember";
        }
         return $columnName;
    }

  
    private function insertIntoPinReferenceTable($randNumber){
        $query_re1 = "INSERT INTO pinreferencetable_re (ownid) VALUES('".trim($randNumber)."')";
                  mysql_query($query_re1);

        $query_re = "INSERT INTO pinreferencetable1p (ownid) VALUES('".trim($randNumber)."')";
          mysql_query($query_re);
         $query = "INSERT INTO " .PINREFERENCE_TABLE." (ownid) VALUES('".trim($randNumber)."')";
        return mysql_query($query);
    }


    private function _validate_signin($username, $password, $type, $signin_type) {
    	$response 	= ['error' => 1, 'message' => 'Invalid request'];
    	$user_signin = $this->signin->get_user_data($type, $username);

		if(count($user_signin) > 0)
		{
			$user_id 				= $user_signin['id'];
			$status 				= $user_signin['status'];
			$hashed_pass 			= $user_signin['password'];

			if($status == 1)
			{
				$user_data = array(
								'id' 		=> $user_id,
								'status'	=> $status,
							);

				if($signin_type == 'password')
				{
					if(password_verify($password, $hashed_pass) === TRUE)
					{
						$response = ['error' => 0, 'message' => 'Success', 'user_data' => $user_data];
					}
					else
					{
						$response = ['error' => 1, 'message' => 'Invalid password'];
					}
				}
				else
				{
					$response = ['error' => 0, 'message' => 'Success', 'user_data' => $user_data];
				}
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

	function set_user_session($user_data=[])
    {
    	if(!empty($user_data))
    	{
    		$session_data = array(
									'user_id' 			=> isset($user_data['id']) ? $user_data['id'] : '',
									'status'			=> isset($user_data['status']) ? $user_data['status'] : '',
									'signin_'.$this->config->item('session_key') => TRUE,
									'last_activity' 	=> time(),
									'logged_in_since' 	=> time()
								);

			$this->session->set_userdata($session_data);
    	}
    	return true;
    }

	function logout() {
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('signin_'.$this->config->item('session_key'));
		$this->session->unset_userdata('logged_in_since');
		$this->session->unset_userdata('last_activity');
		$this->session->sess_destroy();
		redirect(base_url().signin_constants::signin_url);
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

   
	public function isUserExist($user_id,$type) {
 	    $is_exist = $this->signin->isUserExist($user_id);

	    if ($is_exist) {

	    	if ($type=="s") {
	        $this->form_validation->set_message(
	            'sponsor_id', 'user_id address is already exist.'
	        );    
	    		 
	    	}elseif ($type=="u") {
	    		 $this->form_validation->set_message(
	            'user_name', 'user_id address is already exist.'
	        ); 
	    	}

	        return false;
	    } else {
	        return true;
	    }
	}

}