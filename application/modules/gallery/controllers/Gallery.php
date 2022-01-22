<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Gallery extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('gallery_images_model', 'images');
        }

        function index() {
            $data['meta_title']         = "Gallery";
            $data['meta_description']   = "Gallery";
            $data['meta_keywords']      = "Gallery";
            $data['page_title']         = "Gallery";
            $data['module']             = "Gallery";
            $data['menu']               = "gallery";
            $data['submenu']            = "list";
            $data['childmenu']          = "";
            $data['loggedin']           = "yes";

            $this->breadcrumbs->unshift(1, 'Gallery', gallery_constants::gallery_url);
            $data['breadcrumb']         = $this->breadcrumbs->show();

            $data['content']            = "gallery/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function upload() {
            $data['meta_title']         = "Upload Image";
            $data['meta_description']   = "Upload Image";
            $data['meta_keywords']      = "Upload Image";
            $data['page_title']         = "Upload Image";
            $data['module']             = "Upload Image";
            $data['menu']               = "gallery";
            $data['submenu']            = "add";
            $data['childmenu']          = "";
            $data['loggedin']           = "yes";

            $this->breadcrumbs->unshift(1, 'Gallery', gallery_constants::gallery_url);
            $this->breadcrumbs->unshift(2, 'Upload Image', gallery_constants::upload_image_form_url);
            $data['breadcrumb']         = $this->breadcrumbs->show();

            $data['content']            = "gallery/form";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function ajax_upload()
        {
            $path                           = Modules::run("file_management/folder/make", ['uploads', date('Ymd')]);
            $absolute_path                  = isset($path['absolute_path']) ? $path['absolute_path'] : '';

            $vpb_file_name                  = strip_tags($_FILES['upload_file']['name']); //File Name
            $vpb_file_id                    = strip_tags($_POST['upload_file_ids']); // File id is gotten from the file name
            $vpb_file_size                  = $_FILES['upload_file']['size']; // File Size
            $vpb_uploaded_files_location    = $absolute_path; //This is the directory where uploaded files are saved on your server
            $vpb_final_location             = $vpb_uploaded_files_location . $vpb_file_name; //Directory to save file plus the file to be saved

            $vpb_file_extensions            = pathinfo($vpb_file_name, PATHINFO_EXTENSION); // File Extension
            $vpb_allowed_file_extensions    = array("jpg","jpeg","gif","png");  //Allowed file types
            
            $vpb_maximum_allowed_file_size  = 1024*1024; // 1MB - You may change the maximum allowed upload file size here if you wish
            
            //Validation for File Type
            if (!in_array($vpb_file_extensions, $vpb_allowed_file_extensions)) 
            {
                echo 'file_type_error&'.$vpb_file_name;
            }
            else 
            {
                if($vpb_file_size > $vpb_maximum_allowed_file_size)
                {
                    echo 'file_size_error&'.$vpb_file_name;
                }
                else
                {
                    if(move_uploaded_file(strip_tags($_FILES['upload_file']['tmp_name']), $vpb_final_location))
                    {
                        $image      = str_replace('public/content/', '', $vpb_final_location);
                        $response   = $this->images->save_image($vpb_file_id, $image);

                        if($response['error'] == 0)
                        {
                            echo $vpb_file_id;
                        }
                        else
                        {
                            echo 'general_system_error';
                        }
                    }
                    else
                    {
                        echo 'general_system_error';
                    }
                }
            }
        }
    }