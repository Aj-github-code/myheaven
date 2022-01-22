<?php
class MY_Controller extends MX_Controller {
    protected $data;
    function __construct() {
    	parent::__construct();
    	$this->load->module('template', $this->data);
    }

    public function custom_alphanospace($str, $func)
    {
        $this->form_validation->set_message('custom_alphanospace', 'Invalid input value');
        return (!preg_match("".$this->config->item("alphanospace")."", $str)) ? FALSE : TRUE;
    }

    public function custom_alphabets_hyphen($str, $func)
    {
        $this->form_validation->set_message('custom_alphabets_hyphen', 'Only alphabets & hyphen are allowed');
        return (!preg_match("".$this->config->item("alphahyphen")."", $str)) ? FALSE : TRUE;
    }

    public function custom_email($str, $func)
    {
        $this->form_validation->set_message('custom_email', 'Please enter valid e-mail id');
        return (!preg_match("".$this->config->item("email")."", $str)) ? FALSE : TRUE;
    }

    public function custom_mobile($str, $func)
    {
        $this->form_validation->set_message('custom_mobile', 'Please enter valid mobile number');
        return (!preg_match("".$this->config->item("mobile")."", $str)) ? FALSE : TRUE;
    }
}

