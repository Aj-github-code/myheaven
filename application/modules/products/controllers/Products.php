<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Products extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('products_model', 'products');
        }

        function index()
        {
            $data['meta_title']             = "Products";
            $data['meta_description']       = "Products";
            $data['meta_keywords']          = "Products";
            $data['page_title']             = "Products";
            $data['module']                 = "Products";
            $data['menu']                   = "products";
            $data['submenu']                = "list";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->push(1, 'Products', products_constants::products_url);
            $this->breadcrumbs->unshift(2, 'List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "products/index";
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
            $allcount                       = $this->products->getProducts($query_params, 0, 0, 'count');

            // Get  records
            $product_records                = $this->products->getProducts($query_params, $limit, $offset, ['column' => 'id', 'sort' => 'DESC']);

            // Pagination Configuration
            $config                         = $this->custom_pagination->get_pagination_config(
                                                                                                [
                                                                                                    'total_rows'    => $allcount,
                                                                                                    'limit'         => $limit,
                                                                                                    'base_url'      => base_url(products_constants::get_products_url)
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
                $this->load->view("products/grid", $data);
            }
        }

        function view($id='')
        {
            $response = ['error' => 1, 'message' => 'Invalid request'];
            if(!empty($id))
            {
                $data['meta_title']         = "View Product";
                $data['meta_description']   = "View Product";
                $data['meta_keywords']      = "View Product";
                $data['page_title']         = "View Product";
                $data['module']             = "Products";
                $data['menu']               = "products";
                $data['submenu']            = "list";
                $data['childmenu']          = "";
                $data['loggedin']           = "yes";
                $data['id']                 = $id;
                $data['post_data']          = [];

                $data['post_data']          = $this->products->get_details($id);

                $this->breadcrumbs->push(1, 'Products', products_constants::products_url);
                $this->breadcrumbs->unshift(2, 'View', '#');
                $data['breadcrumb']         = $this->breadcrumbs->show();

                $data['content']            = "products/view";
                echo Modules::run("templates/".$this->config->item('theme'), $data);
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().products_constants::products_url);
            }
        }
    }