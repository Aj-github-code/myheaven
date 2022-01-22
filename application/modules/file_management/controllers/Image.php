<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Image extends MY_Controller {
    function __construct() {
        parent::__construct();
    }

    function base64_to_image($image_data='', $path='') {
    	$image_name 		= '';
    	$path 				= !empty($path) ? $path : $this->config->item('content_path');
    	
    	if(!empty($image_data))
        {
        	$image_parts 	= explode(";base64,", $image_data);
		    $image_type_aux = explode("image/", $image_parts[0]);
		    $image_type 	= $image_type_aux[1];
		    $image_base64 	= base64_decode($image_parts[1]);
		    $image_name 	= uniqid().'.'.$image_type;
		    $file 			= $path.'/'.$image_name;
		    file_put_contents($file, $image_base64);
        }
	    return $image_name;
    }

    function upload($image_data=[])
    {
        $response = ['status' => 'failure', 'error' => 'Invalid request'];
        if(isset($image_data['path']) && !empty($image_data['path']))
        {
            $path           = Modules::run("file_management/folder/make", $image_data['path']);
            $absolute_path  = isset($path['absolute_path']) ? $path['absolute_path'] : '';
            $relative_path  = isset($path['relative_path']) ? $path['relative_path'] : '';
            
            $config = [
                        // 'file_name' => time(),
                        'upload_path' => $absolute_path,
                        // 'upload_url' => $uploadurl,
                        'remove_spaces' => true,
                        'overwrite' => false,
                        'encrypt_name' => false,
                        'allowed_types' => "gif|jpg|png|jpeg"
                    ];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if(!$this->upload->do_upload('file'))
            {
                $response   = ['status' => 'failure', 'error' => $this->upload->display_errors()];
            }
            else
            {
                $image      = isset($this->upload->data()['file_name']) ? $this->upload->data()['file_name'] : '';
                $response   = ['status' => 'success', 'uploaded_data' => $this->upload->data(), 'image' => $relative_path.$image];
            }
        }
        return $response;
    }
}