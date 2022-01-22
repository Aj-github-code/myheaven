<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Cart extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('cart_model', 'cart');
        }

        function index()
        {
            $data['meta_title']             = "Cart";
            $data['meta_description']       = "Cart";
            $data['meta_keywords']          = "Cart";
            $data['page_title']             = "Cart";
            $data['module']                 = "Cart";
            $data['menu']                   = "cart";
            $data['submenu']                = "list";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $data['products']               = $this->cart->getProducts();
            $cart_errors                    = [];
            // echo "<pre>";print_r($data);exit;

            if(isset($_POST['address']) && !empty($_POST['address']))
            {
                $request                    = [];
                $totalquantity              = 0;
                $totalamount                = 0;
                $totalbv                    = 0;
                $totaldp                    = 0;
                $totalgst                   = 0;
                $totalcgst                  = 0;
                $totalsgst                  = 0;
                $totaligst                  = 0;
                $finaldp                    = 0;

                foreach ($_POST['product_id'] as $key => $value) {
                    $product_id             = $value;
                    $quantity               = isset($_POST['quantity'][$key]) ? $_POST['quantity'][$key] : 0;

                    $product                = $this->cart->get_product($product_id);

                    $gst                    = $product['gst'];
                    $mrp                    = $product['mrp'];
                    $d_p                    = $product['d_p'];
                    $b_v                    = $product['b_v'];
                    $stock                  = $product['opening_stock'];
                    $check_quantity         = $stock - $quantity;

                    if($check_quantity < 0)
                    {
                        $cart_errors['error_'.$product_id] = 'Product stock is low';
                    }

                    $total_amount           = $quantity*$mrp;
                    $total_d_p              = $quantity*$d_p;
                    $total_b_v              = $quantity*$b_v;
                    $total_gst              = ($total_d_p*$gst)/100;
                    $total_cgst             = $total_gst/2;
                    $total_sgst             = $total_cgst;
                    $total_igst             = $total_gst;
                    $final_d_p              = $total_d_p+$total_gst;

                    $request[]              = [
                                                'product_id'    => $product_id,
                                                'quantity'      => $quantity,
                                                'amount'        => $mrp,
                                                'total_amount'  => $total_amount,
                                                'd_p'           => $d_p,
                                                'total_d_p'     => $total_d_p,
                                                'b_v'           => $b_v,
                                                'total_b_v'     => $total_b_v,
                                                'gst_rate'      => $gst,
                                                'total_gst'     => $total_gst,
                                                'total_cgst'    => $total_cgst,
                                                'total_sgst'    => $total_sgst,
                                                'total_igst'    => $total_igst,
                                                'final_d_p'     => $final_d_p,
                                            ];

                    $totalquantity          = $totalquantity+$quantity;
                    $totalamount            = $totalamount+$total_amount;
                    $totaldp                = $totaldp+$total_d_p;
                    $totalbv                = $totalbv+$total_b_v;
                    $totalgst               = $totalgst+$total_gst;
                    $totalcgst              = $totalcgst+$total_cgst;
                    $totalsgst              = $totalsgst+$total_sgst;
                    $totaligst              = $totaligst+$total_igst;
                    $finaldp                = $finaldp+$final_d_p;
                }

                if(empty($cart_errors))
                {
                    $order_request          = [
                                                'total_quantity'    => $totalquantity,
                                                'total_amount'      => $totalamount,
                                                'total_d_p'         => $totaldp,
                                                'total_b_v'         => $totalbv,
                                                'total_gst'         => $totalgst,
                                                'total_cgst'        => $totalcgst,
                                                'total_sgst'        => $totalsgst,
                                                'total_igst'        => $totaligst,
                                                'final_d_p'         => $finaldp,
                                                'order_products'    => $request,
                                                'address'           => $_POST['address'],
                                            ];
                    $response               = $this->cart->order_request($order_request);
                    if($response['error'] == 0)
                    {
                        $redirect           = base_url(orders_constants::view_order_url.'/'.$response['order_number']);
                    }
                    else
                    {
                        $redirect           = base_url(cart_constants::cart_url);
                    }

                    $this->session->set_flashdata('status', $response);
                    redirect($redirect);
                }
            }
            $data['cart_errors']            = $cart_errors;

            $this->breadcrumbs->push(1, 'Cart', cart_constants::cart_url);
            $this->breadcrumbs->unshift(2, 'List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "cart/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function add()
        {
            $response                       = ['error' => 1, 'message' => 'Invalid request'];
            if(isset($_POST['product_id']) && !empty($_POST['product_id']))
            {
                $product_id                 = $_POST['product_id'];
                $check_product              = $this->cart->check_product($product_id);
                if(empty($check_product))
                {
                    $product                = $this->cart->get_product($product_id);
                    if(!empty($product))
                    {
                        $stock              = $product['opening_stock'];
                        $check_quantity     = $stock - 1;
                        if($check_quantity > -1)
                        {
                            $response       = $this->cart->add($product_id);
                        }
                        else
                        {
                            $response       = ['error' => 1, 'message' => 'Product stock is low'];
                        }
                    }
                    else
                    {
                        $response           = ['error' => 1, 'message' => 'Product not found'];
                    }
                }
                else
                {
                    $response               = ['error' => 1, 'message' => 'Product already exist in cart'];
                }
            }
            echo json_encode($response);
        }

        function remove()
        {
            $response                       = ['error' => 1, 'message' => 'Invalid request'];
            if(isset($_POST['product_id']) && !empty($_POST['product_id']))
            {
                $cart_id                    = $_POST['cart_id'];
                $product_id                 = $_POST['product_id'];
                $check_product              = $this->cart->check_product($product_id);
                if(!empty($check_product))
                {
                    $response               = $this->cart->remove($cart_id);
                }
                else
                {
                    $response               = ['error' => 1, 'message' => 'Product does not exist in cart'];
                }
            }
            echo json_encode($response);
        }

        function cart_count()
        {
            $response                       = ['error' => 0, 'message' => '', 'count' => $this->cart->cart_count()];
            echo json_encode($response);
        }
    }