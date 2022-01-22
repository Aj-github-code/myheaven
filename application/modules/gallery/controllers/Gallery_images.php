<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Gallery_images extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('gallery_images_model', 'images');
        }

        function modal()
        {
            $data['thumbnails']         = [];
            $this->load->view("images/modal", $data);
        }

        function ajax_list($offset=0)
        {
            $limit                      = 18;

            // Row position
            if($offset != 0)
            {
                $offset                 = ($offset-1) * $limit;
            }

            // All records count
            $allcount                   = $this->images->get_data(0, 0, 'allcount');
            $images                     = $this->images->get_data($limit, $offset, '');

            // Pagination Configuration
            $config                     = $this->common_lib->get_pagination_config(['total_rows' => $allcount, 'limit' => $limit, 'base_url' => base_url(gallery_constants::get_images_url), 'module' => 'images']);

            // Initialize
            $this->pagination->initialize($config);

            // Initialize $data Array
            $data['pagination']         = $this->pagination->create_links();
            $data['see_all']            = false;
            $data['images']             = $images;
            $data['row']                = $offset;
            
            $this->load->view('images/grid', $data);
        }

        function change()
        {
            $response       = ['error' => 1, 'message' => 'Access denied'];

            if(isset($_POST) && !empty($_POST))
            {
                $id         = isset($_POST['id']) ? $_POST['id'] : '';
                $status     = isset($_POST['status']) ? $_POST['status'] : '';

                $details    = $this->images->get_details($id);

                if(!empty($details))
                {
                    if($status == '-1')
                    {
                        $message = 'deleted';
                    }
                    else if($status == 1)
                    {
                        $message = 'activated';
                    }
                    else if($status == 0)
                    {
                        $message = 'in-activated';
                    }

                    if($this->images->change($id, $status))
                    {
                        $response= ['error' => 0, 'message' => 'Image successfully '.$message];
                    }
                    else
                    {
                        $response= ['error' => 1, 'message' => 'Unable to perform this action'];
                    }
                }
                else
                {
                    $response    = ['error' => 1, 'message' => 'No image found'];
                }
            }
            echo json_encode($response);
        }

        private function form_validation_rules($data=[])
        {
            $this->form_validation->set_rules('image_name', 'Image name', 'required|max_length[255]|trim|xss_clean|strip_tags');
        }

        function form()
        {
            $this->load->view("images/form");
        }

        function upload()
        {
            $response = ['error' => 1, 'message' => 'Access denied'];
            $this->form_validation_rules();

            if($this->form_validation->run($this) === TRUE)
            {
                if(isset($_POST['image_name']) && !empty($_POST['image_name']))
                {
                    if(isset($_FILES['file']) && !empty($_FILES['file']))
                    {
                        $response = $this->images->save('', $this->security->xss_clean($this->input->post()));
                    }
                    else
                    {
                        $response = ['error' => 1, 'message' => 'Please browse image first'];
                    }
                }
            }
            else
            {
                $errors         = $this->form_validation->error_array();
                $response       = ['error' => 2, 'message' => implode(',', $errors)];
            }
            echo json_encode($response);exit;
        }
    }