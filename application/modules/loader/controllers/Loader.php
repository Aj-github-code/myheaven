<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Loader extends MY_Controller {
    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->load->view('index');
    }

    function content() {
        $this->load->view('content_loader');
    }
}