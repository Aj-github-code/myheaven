<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Common extends MY_Controller {
        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('commonmodel');
        }
    }