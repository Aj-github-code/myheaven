<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class I_card extends MY_Controller {
        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
        }

        function index()
        {
            $data['meta_title'] 		= "I Card";
    		$data['meta_description'] 	= "I Card";
    		$data['meta_keywords'] 		= "I Card";
            $data['page_title']         = "I Card";
            $data['module']             = "I Card";
            $data['menu']               = "i_card";
            $data['submenu']            = "i_card";
            $data['childmenu']          = "";
    		$data['loggedin'] 			= "yes";

            $this->breadcrumbs->unshift(1, 'I Card', i_card_constants::i_card_url);
            $data['breadcrumb']         = $this->breadcrumbs->show();

    		$data['content']            = "i_card/index";
    		echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function print_pdf()
        {
            $data['meta_title']         = "Print I Card";
            $data['meta_description']   = "Print I Card";
            $data['meta_keywords']      = "Print I Card";
            $data['page_title']         = "Print I Card";
            $data['module']             = "Orders";
            $data['menu']               = "orders";
            $data['submenu']            = "list";
            $data['childmenu']          = "";
            $data['loggedin']           = "yes";
            $data['id']                 = '';

            $data['user_data']          = $this->data['user_data'];

            $this->load->library('pdf/pdf');
            $pdf_data               = [
                                        'mode'      => 'view',
                                        'file_name' => $data['user_data']['franchise_code'].'.pdf',
                                        'html'      => $this->load->view("i_card/pdf", $data, true),
                                        'file_path' => ['temp', 'user_'.$this->session->userdata('user_id'), 'i_card'],
                                    ];
            return $this->pdf->process($pdf_data);
        }
    }