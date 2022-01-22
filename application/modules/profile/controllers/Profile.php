<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		check_user_login(TRUE);
		$this->load->model('profile_model', 'profile');
	}

    function index() {
        $data['meta_title'] 		= "Profile";
		$data['meta_description'] 	= "Profile";
		$data['meta_keywords'] 		= "Profile";
        $data['page_title']         = "Profile";
        $data['module']             = "Profile";
        $data['menu']               = "profile";
        $data['submenu']            = "profile";
        $data['childmenu']          = "profile";
		$data['loggedin'] 			= "yes";
        $data['post_data']['id']    = $this->session->userdata('user_id');

        $this->breadcrumbs->unshift(1, 'Profile', profile_constants::profile_url);
        $data['breadcrumb']         = $this->breadcrumbs->show();

        $this->form_validation_rules($data);

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {
                $response 			= $this->profile->save($this->security->xss_clean($this->input->post()));
                $this->session->set_flashdata('status', $response);
                redirect(base_url().profile_constants::profile_url);
            }
        }

        if($this->input->post())
        {
            $data['post_data']      = $this->input->post();
        }
        else
        {
        	$data['post_data']      = $this->profile->get_user_data();
        }

		$data['content']            = "profile/form";
		echo Modules::run("templates/".$this->config->item('theme'), $data);
    }

    function avatar()
    {
        $response                       = ['error' => 1, 'message' => 'Invalid request'];
        if(isset($_POST['image']) && !empty($_POST['image']))
        {
            $profile_pic                = Modules::run("file_management/image/base64_to_image", $_POST['image'], $this->config->item('content_path').'profile');
            $response                   = $this->profile->update_avatar($profile_pic);
            if($response['error'] == 0)
            {
                $this->session->set_userdata('profile_pic', $profile_pic);
                $response['profile_pic']= content_url('profile/'.$profile_pic);
            }
        }
        echo json_encode($response);exit;
    }

    private function form_validation_rules($data=[])
    {
        $this->form_validation->set_rules('franchise_name', 'Franchise Name', 'required|max_length[64]|trim|xss_clean|strip_tags');
        $this->form_validation->set_rules('your_name', 'Your Name', 'required|max_length[64]|trim|xss_clean|strip_tags');
        $this->form_validation->set_rules('type', 'Type', 'required|trim|xss_clean|strip_tags');
        $this->form_validation->set_rules('email', 'Email', 'required|max_length[50]|callback_custom_email[email]|callback_unique_email[email]|trim|xss_clean|strip_tags');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|max_length[10]|callback_custom_mobile[mobile]|callback_unique_mobile[mobile]|trim|xss_clean|strip_tags');
        $this->form_validation->set_rules('dob', 'Date Of Birth', 'trim|xss_clean|strip_tags');
        $this->form_validation->set_rules('address', 'Address', 'trim|xss_clean|strip_tags');
        $this->form_validation->set_rules('bank_account', 'Bank Account', 'trim|xss_clean|strip_tags');
        $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|xss_clean|strip_tags');
        $this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|xss_clean|strip_tags');
        $this->form_validation->set_rules('ifsc_code', 'IFSC Code', 'trim|xss_clean|strip_tags');
    }

	public function custom_email($str, $func)
    {
        $this->form_validation->set_message('custom_email', 'Please enter valid email');
        return (!preg_match("".$this->config->item("email")."", $str)) ? FALSE : TRUE;
    }

    public function custom_mobile($str, $func)
    {
        $this->form_validation->set_message('custom_mobile', 'Please enter valid mobile');
        return (!preg_match("".$this->config->item("mobile")."", $str)) ? FALSE : TRUE;
    }

    function unique_mobile($str, $func)
    {
        $conditions = ['status !=' => '-1', 'mobile' => $str, 'id !=' => $this->session->userdata('user_id')];

        $this->form_validation->set_message('unique_mobile', 'This mobile already exist');
        return $this->profile->check_unique($conditions);
    }

    function unique_email($str, $func)
    {
        $conditions = ['status !=' => '-1', 'email' => $str, 'id !=' => $this->session->userdata('user_id')];

        $this->form_validation->set_message('unique_email', 'This email already exist');
        return $this->profile->check_unique($conditions);
    }
}