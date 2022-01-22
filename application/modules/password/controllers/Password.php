<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Password extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		check_user_login(TRUE);
		$this->load->model('password_model', 'password');
	}

    private function form_validation_rules($data=[])
    {
        $this->form_validation->set_rules('old_pass', 'Old password', 'required|trim|xss_clean|strip_tags');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[32]|regex_match['.$this->config->item("password_hash").']');
        $this->form_validation->set_rules('password_confirmation', 'Confirm password', 'required|matches[password]|trim|xss_clean|strip_tags');
    }

    function index() {
        $data['meta_title'] 		= "Change Password";
		$data['meta_description'] 	= "Change Password";
		$data['meta_keywords'] 		= "Change Password";
        $data['page_title']         = "Change Password";
        $data['module']             = "Change Password";
        $data['menu']               = "password";
        $data['submenu']            = "password";
        $data['childmenu']          = "password";
		$data['loggedin'] 			= "yes";
        $data['post_data']          = [];

        $this->breadcrumbs->unshift(1, 'Change Password', password_constants::password_url);
        $data['breadcrumb']         = $this->breadcrumbs->show();

        $this->form_validation_rules($data);

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {
                $user               = $this->password->get_user_data();
                $post_data          = $this->security->xss_clean($this->input->post());
                $old_password       = htmlentities($post_data['old_pass']);
                $new_password       = htmlentities($post_data['password']);

                if(password_verify($old_password, $user['password']) === TRUE)
                {
                    $update                     = [];
                    $update['password']         = password_hash($new_password, PASSWORD_DEFAULT);
                    $update['modified_on']      = date('Y-m-d H:i:s');
                    $update['modified_by']      = $this->session->userdata('user_id');

                    $response                   = $this->password->update($update);
                }
                else
                {
                    $response                   = ['error' => 1, 'message' => 'Old password does not match'];
                }

                $this->session->set_flashdata('status', $response);
                redirect(base_url().password_constants::password_url);
            }
        }

		$data['content']            = "password/form";
		echo Modules::run("templates/".$this->config->item('theme'), $data);
    }
}