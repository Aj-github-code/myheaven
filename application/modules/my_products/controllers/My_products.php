<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class My_products extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('my_products_model', 'my_products');
        }

        function index()
        {
            $data['meta_title']             = "My Products";
            $data['meta_description']       = "My Products";
            $data['meta_keywords']          = "My Products";
            $data['page_title']             = "My Products";
            $data['module']                 = "My Products";
            $data['menu']                   = "my_products";
            $data['submenu']                = "list";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->push(1, 'My Products', my_products_constants::my_products_url);
            $this->breadcrumbs->unshift(2, 'List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "my_products/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function ajax_list($offset=0)
        {
            $query_params                   = array();
            parse_str($_SERVER['QUERY_STRING'], $query_params);
            $query_params                   = $this->input->post();

            // echo "<pre>";print_r($query_params);exit;
            $data                           = [];
            $limit                          = $this->input->post('limit');

            // Row position
            if($offset != 0)
            {
                $offset                     = ($offset-1) * $limit;
            }

            // All records count
            $allcount                       = $this->my_products->getMyProducts($query_params, 0, 0, 'count');

            // Get  records
            $product_records                = $this->my_products->getMyProducts($query_params, $limit, $offset, ['column' => 'id', 'sort' => 'DESC']);

            // Pagination Configuration
            $config                         = $this->custom_pagination->get_pagination_config(
                                                                                                [
                                                                                                    'total_rows'    => $allcount,
                                                                                                    'limit'         => $limit,
                                                                                                    'base_url'      => base_url(my_products_constants::get_my_products_url)
                                                                                                ]
                                                                                            );

            // Initialize
            $this->pagination->initialize($config);

            // Initialize $data Array
            $data['pagination']             = $this->pagination->create_links();
            $data['result']                 = $product_records;
            $data['row']                    = $offset;
            $this->load->view('products', $data);
        }

        function grid($result=[])
        {
            if(!empty($result))
            {
                $data['result']             = $result;
                $this->load->view("my_products/grid", $data);
            }
        }

        function view($id='')
        {
            $response = ['error' => 1, 'message' => 'Invalid request'];
            if(!empty($id))
            {
                $data['meta_title']         = "View My Product";
                $data['meta_description']   = "View My Product";
                $data['meta_keywords']      = "View My Product";
                $data['page_title']         = "View My Product";
                $data['module']             = "My Products";
                $data['menu']               = "my_products";
                $data['submenu']            = "list";
                $data['childmenu']          = "";
                $data['loggedin']           = "yes";
                $data['id']                 = $id;

                $data['details']            = $this->my_products->get_details($id);
                if(!empty($data['details']))
                {
                    $this->breadcrumbs->push(1, 'My Products', my_products_constants::my_products_url);
                    $this->breadcrumbs->unshift(2, 'View', '#');
                    $data['breadcrumb']     = $this->breadcrumbs->show();

                    $data['content']        = "my_products/view";
                    echo Modules::run("templates/".$this->config->item('theme'), $data);
                }
                else
                {
                    $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Product not found']);
                    redirect(base_url().my_products_constants::my_products_url);
                }
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().my_products_constants::my_products_url);
            }
        }
    }