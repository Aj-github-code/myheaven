<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Extract extends MY_Controller {
    function __construct() {
        parent::__construct();
    }

    function index($file_data=[])
    {
        $response           = ['error' => 1, 'message' => 'Invalid request'];
        if(isset($file_data['zip_file']) && !empty($file_data['zip_file']))
        {
            $zip            = new ZipArchive;
            if($zip->open($file_data['zip_file']) === TRUE)
            {
                $zip->extractTo($file_data['destination']);
                $zip->close();
                $response   = ['error' => 0, 'message' => 'Source file successfully extracted'];
            }
            else
            {
                $response   = ['error' => 1, 'message' => 'Unable to extract source file'];
            }
        }
        return $response;
    }
}