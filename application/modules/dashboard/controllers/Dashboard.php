<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Dashboard extends MY_Controller {
        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('dashboard_model', 'dashboard');
        }

        function index()
        {
            $data['meta_title'] 		= "Dashboard";
    		$data['meta_description'] 	= "Dashboard";
    		$data['meta_keywords'] 		= "Dashboard";
            $data['page_title']         = "Dashboard";
            $data['module']             = "Dashboard";
            $data['menu']               = "dashboard";
            $data['submenu']            = "dashboard";
            $data['childmenu']          = "dashboard";
    		$data['loggedin'] 			= "yes";

            $data['myproducts']         = $this->dashboard->get_count(
                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1],
                                                                        my_products_table::sql_tbl_franchise_purchased_products,
                                                                        'id'
                                                                    );

            $data['orders']             = [
                                            'completed' => $this->dashboard->get_count(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['approved', 'delivered']],
                                                                                        orders_table::sql_tbl_franchise_orders
                                                                                    ),
                                            'pending'   => $this->dashboard->get_count(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['pending']],
                                                                                        orders_table::sql_tbl_franchise_orders
                                                                                    ),
                                        ];

            $data['order_summary']      = [
                                            'total_d_p' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['approved', 'delivered']],
                                                                                        orders_table::sql_tbl_franchise_orders,
                                                                                        'total_d_p'
                                                                                    ),
                                            'total_b_v' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['approved', 'delivered']],
                                                                                        orders_table::sql_tbl_franchise_orders,
                                                                                        'total_b_v'
                                                                                    ),
                                            'total_quantity' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['approved', 'delivered']],
                                                                                        orders_table::sql_tbl_franchise_orders,
                                                                                        'total_quantity'
                                                                                    ),
                                            'total_gst' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['approved', 'delivered']],
                                                                                        orders_table::sql_tbl_franchise_orders,
                                                                                        'total_gst'
                                                                                    ),
                                            'service_charge' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['approved', 'delivered']],
                                                                                        orders_table::sql_tbl_franchise_orders,
                                                                                        'service_charge'
                                                                                    ),
                                            'final_d_p' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['approved', 'delivered']],
                                                                                        orders_table::sql_tbl_franchise_orders,
                                                                                        'final_d_p'
                                                                                    ),
                                        ];

            $data['top_up_orders']      = [
                                            'completed' => $this->dashboard->get_count(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['placed', 'delivered']],
                                                                                        top_up_table::sql_tbl_top_up_orders
                                                                                    ),
                                            'pending'   => $this->dashboard->get_count(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['pending']],
                                                                                        top_up_table::sql_tbl_top_up_orders
                                                                                    ),
                                        ];

            $data['top_up_summary']     = [
                                            'total_d_p' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['placed', 'delivered']],
                                                                                        top_up_table::sql_tbl_top_up_orders,
                                                                                        'total_d_p'
                                                                                    ),
                                            'total_b_v' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['placed', 'delivered']],
                                                                                        top_up_table::sql_tbl_top_up_orders,
                                                                                        'total_b_v'
                                                                                    ),
                                            'total_quantity' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['placed', 'delivered']],
                                                                                        top_up_table::sql_tbl_top_up_orders,
                                                                                        'total_quantity'
                                                                                    ),
                                            'total_gst' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['placed', 'delivered']],
                                                                                        top_up_table::sql_tbl_top_up_orders,
                                                                                        'total_gst'
                                                                                    ),
                                            'service_charge' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['placed', 'delivered']],
                                                                                        top_up_table::sql_tbl_top_up_orders,
                                                                                        'service_charge'
                                                                                    ),
                                            'final_d_p' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['placed', 'delivered']],
                                                                                        top_up_table::sql_tbl_top_up_orders,
                                                                                        'final_d_p'
                                                                                    ),
                                        ];

            $data['repurchase_orders']  = [
                                            'completed' => $this->dashboard->get_count(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['placed', 'delivered']],
                                                                                        repurchase_table::sql_tbl_repurchase_orders
                                                                                    ),
                                            'pending'   => $this->dashboard->get_count(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['pending']],
                                                                                        repurchase_table::sql_tbl_repurchase_orders
                                                                                    ),
                                        ];

            $data['repurchase_summary'] = [
                                            'total_d_p' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['placed', 'delivered']],
                                                                                        repurchase_table::sql_tbl_repurchase_orders,
                                                                                        'total_d_p'
                                                                                    ),
                                            'total_b_v' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['placed', 'delivered']],
                                                                                        repurchase_table::sql_tbl_repurchase_orders,
                                                                                        'total_b_v'
                                                                                    ),
                                            'total_quantity' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['placed', 'delivered']],
                                                                                        repurchase_table::sql_tbl_repurchase_orders,
                                                                                        'total_quantity'
                                                                                    ),
                                            'total_gst' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['placed', 'delivered']],
                                                                                        repurchase_table::sql_tbl_repurchase_orders,
                                                                                        'total_gst'
                                                                                    ),
                                            'service_charge' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['placed', 'delivered']],
                                                                                        repurchase_table::sql_tbl_repurchase_orders,
                                                                                        'service_charge'
                                                                                    ),
                                            'final_d_p' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['placed', 'delivered']],
                                                                                        repurchase_table::sql_tbl_repurchase_orders,
                                                                                        'final_d_p'
                                                                                    ),
                                        ];

            $data['customer_orders']    = [
                                            'completed' => $this->dashboard->get_count(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['placed', 'delivered']],
                                                                                        customer_orders_table::sql_tbl_customer_orders
                                                                                    ),
                                            'pending'   => $this->dashboard->get_count(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['pending']],
                                                                                        customer_orders_table::sql_tbl_customer_orders
                                                                                    ),
                                        ];

            $data['customer_summary']   = [
                                            'total_d_p' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['placed', 'delivered']],
                                                                                        customer_orders_table::sql_tbl_customer_orders,
                                                                                        'total_d_p'
                                                                                    ),
                                            'total_b_v' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['placed', 'delivered']],
                                                                                        customer_orders_table::sql_tbl_customer_orders,
                                                                                        'total_b_v'
                                                                                    ),
                                            'total_quantity' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['placed', 'delivered']],
                                                                                        customer_orders_table::sql_tbl_customer_orders,
                                                                                        'total_quantity'
                                                                                    ),
                                            'total_gst' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['placed', 'delivered']],
                                                                                        customer_orders_table::sql_tbl_customer_orders,
                                                                                        'total_gst'
                                                                                    ),
                                            'service_charge' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['placed', 'delivered']],
                                                                                        customer_orders_table::sql_tbl_customer_orders,
                                                                                        'service_charge'
                                                                                    ),
                                            'final_d_p' => $this->dashboard->get_sum(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'status' => 1, 'order_status' => ['placed', 'delivered']],
                                                                                        customer_orders_table::sql_tbl_customer_orders,
                                                                                        'final_d_p'
                                                                                    ),
                                        ];

            $data['announcements']      = [
                                            'active'    => $this->dashboard->get_count(
                                                                                        ['status' => 1],
                                                                                        announcements_table::sql_tbl_announcements
                                                                                    ),
                                            'inactive'  => $this->dashboard->get_count(
                                                                                        ['status' => 0],
                                                                                        announcements_table::sql_tbl_announcements
                                                                                    ),
                                        ];
            $data['news']               = [
                                            'news'      => $this->dashboard->get_count(
                                                                                        ['type' => 'all', 'status' => 1],
                                                                                        news_table::sql_tbl_news
                                                                                    ),
                                            'messages'  => $this->dashboard->get_count(
                                                                                        ['user_id' => $this->session->userdata('user_id'), 'type' => 'franchise', 'status' => 1],
                                                                                        news_table::sql_tbl_news
                                                                                    ),
                                        ];

            $this->breadcrumbs->unshift(1, 'Dashboard', dashboard_constants::dashboard_url);
            $data['breadcrumb']         = $this->breadcrumbs->show();

    		$data['content']            = "dashboard/index";
    		echo Modules::run("templates/".$this->config->item('theme'), $data);
        }
    }