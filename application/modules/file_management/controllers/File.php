<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class File extends MY_Controller {
    function __construct() {
        parent::__construct();
    }

    function upload($file_data=[])
    {
        $response           = ['status' => 'failure', 'error' => 'Invalid request'];
        if(isset($file_data['path']) && !empty($file_data['path']))
        {
            $path           = Modules::run("file_management/folder/make", $file_data['path']);
            $absolute_path  = isset($path['absolute_path']) ? $path['absolute_path'] : '';
            $relative_path  = isset($path['relative_path']) ? $path['relative_path'] : '';
            
            $config = [
                        // 'file_name' => time(),
                        'upload_path'   => $absolute_path,
                        // 'upload_url' => $uploadurl,
                        'remove_spaces' => true,
                        'overwrite'     => false,
                        'encrypt_name'  => false,
                        'allowed_types' => "*"
                    ];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if(!$this->upload->do_upload('file'))
            {
                $response   = ['status' => 'failure', 'error' => $this->upload->display_errors()];
            }
            else
            {
                $file       = isset($this->upload->data()['file_name']) ? $this->upload->data()['file_name'] : '';
                $response   = ['status' => 'success', 'uploaded_data' => $this->upload->data(), 'file' => $relative_path.$file];
            }
        }
        return $response;
    }
}