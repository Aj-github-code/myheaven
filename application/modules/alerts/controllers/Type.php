<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Type extends MY_Controller {
    function __construct() {
        parent::__construct();
    }

    function block() {
        $this->load->view('block');
    }

    function toastr() {
        $this->load->view('toastr');
    }
}