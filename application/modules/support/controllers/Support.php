<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Support extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('support_model', 'supports');
        }

        function index()
        {
            $data['meta_title']             = "Support";
            $data['meta_description']       = "Support";
            $data['meta_keywords']          = "Support";
            $data['page_title']             = "Support";
            $data['module']                 = "Support";
            $data['menu']                   = "support";
            $data['submenu']                = "support request";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";



            $this->form_validation_rules($data);

            if($this->input->post())
            {
                $data['post_data']          = $this->input->post();
            }  

            if($this->form_validation->run($this) === TRUE)
            {
                if($this->input->post())
                {
                    $response               = $this->save('', $this->security->xss_clean($this->input->post()));
                    $this->session->set_flashdata('status', $response);
                    redirect(base_url().supports_constants::support_url);
                }
            }


            $this->breadcrumbs->unshift(1, 'Support', supports_constants::support_url);
            $this->breadcrumbs->unshift(2, 'Support resquest', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();


            $data['content']                = "support/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }
        
        private function form_validation_rules($data=[])
        {
            $this->form_validation->set_rules('subject', 'Subject', 'required|trim|xss_clean|strip_tags');
            if (empty($_FILES['file']['name']))
            {
                if(empty($data['id']))
                {
                    $this->form_validation->set_rules('file', 'File', 'required');
                }
            }
        }


        private function save($id, $post_data)
        {
            $response                                   = ['error' => 1, 'message' => 'Invalid request'];

            if(!empty($post_data))
            {
                if(isset($_FILES['file']) && !empty($_FILES['file']))
                {
                    $upload_data                = Modules::run("file_management/file/upload", ['path' => ['support']]);
                    if(isset($upload_data['file']) && !empty($upload_data['file']))
                    {
                        $save['image']                  = $upload_data['file'];
                    }
                }

                $save['subject']                        = htmlentities($post_data['subject']);
                $save['message']                        = htmlentities($post_data['message']);

                if(empty($id))
                {
                    $save['ownid']                      = $this->session->userdata('user_id');
                    $save['active']                     = '0';
                    $save['created_on']                 = date('Y-m-d H:i:s');
                    $save['created_by']                 = $this->session->userdata('user_id');
                    $response                           = $this->supports->save($id, $save);
                }
                else
                {
                    $save['ownid']                      = $this->session->userdata('user_id');
                    $save['active']                     = '0';
                    $save['modified_on']                = date('Y-m-d H:i:s');
                    $save['modified_by']                = $this->session->userdata('user_id');
                    $response                           = $this->supports->save($id, $save);
                }
            }
            return $response;
        }

    }
