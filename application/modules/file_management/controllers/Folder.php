<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Folder extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->root_directory = $this->config->item('app_root_path');
        $this->content_directory = $this->config->item('content_path');
    }

    function make($path=[]) {
        $directory = ['absolute_path' => $this->content_directory, 'relative_path' => ''];
    	if(!empty($path))
        {
            $absolute_path          = $this->content_directory;
            $relative_path          = '';
            foreach ($path as $key => $value) 
            {
                $absolute_path      = $absolute_path.$value.'/';
                $relative_path      = $relative_path.$value.'/';
                if (!is_dir($absolute_path)) 
                {
                    mkdir($absolute_path, 0777, true);
                }
            }
            $directory = ['absolute_path' => $absolute_path, 'relative_path' => $relative_path];
        }
        return $directory;
    }

    function make_dir($path=[]) {
        $directory = ['absolute_path' => $this->root_directory, 'relative_path' => ''];
        if(!empty($path))
        {
            $absolute_path          = $this->root_directory;
            $relative_path          = '';
            foreach ($path as $key => $value) 
            {
                $absolute_path      = $absolute_path.$value.'/';
                $relative_path      = $relative_path.$value.'/';
                if (!is_dir($absolute_path)) 
                {
                    mkdir($absolute_path, 0777, true);
                }
            }
            $directory = ['absolute_path' => $absolute_path, 'relative_path' => $relative_path];
        }
        return $directory;
    }
}