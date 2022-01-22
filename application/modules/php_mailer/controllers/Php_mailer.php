<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Php_mailer extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('Php_email_library');
    }

    function send($email_data){
    	return $this->php_email_library->send($email_data);
    }
}