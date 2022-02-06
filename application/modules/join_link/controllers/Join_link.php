<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Join_link extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('joins_model', 'join');
	}

    function index() {
        $data['meta_title']             = "Join";
		$data['meta_description']       = "Join";
		$data['meta_keywords']          = "Join";
		$data['page_title']             = "Join";
		$data['module']                 = "Join";
		$data['menu']                   = "join";
		$data['submenu']                = "join";
		$data['childmenu']              = "";
		$data['loggedin']               = "yes";

		$data['content']                = "join_link/join_link";
		echo Modules::run("templates/".$this->config->item('theme'), $data); 
    }
    

}