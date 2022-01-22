<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Overview extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
        }

        function index()
        {
            $data['meta_title']             = "Welcome message";
            $data['meta_description']       = "Welcome message";
            $data['meta_keywords']          = "Welcome message";
            $data['page_title']             = "Welcome message";
            $data['module']                 = "Welcome message";
            $data['menu']                   = "overview";
            $data['submenu']                = "welcome message";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->unshift(1, 'Overview', overview_constants::overview_url);
            $this->breadcrumbs->unshift(2, 'Welcome message', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "overview/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

    }

?>