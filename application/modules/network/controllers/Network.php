<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Network extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            // $this->load->model('cruds_model', 'crud');
        }

        function index()
        {
            $data['meta_title']             = "Network";
            $data['meta_description']       = "Network";
            $data['meta_keywords']          = "Network";
            $data['page_title']             = "Network";
            $data['module']                 = "Network";
            $data['menu']                   = "network";
            $data['submenu']                = "binary tree";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->unshift(1, 'Network', networks_constants::network_url);
            $this->breadcrumbs->unshift(2, 'Binary tree', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "network/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }
    }
?>