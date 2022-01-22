<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Customer_orders extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('customer_orders_model', 'customer_orders');
            $this->load->model('commissions/commissions_model', 'commissions');
        }

        function index()
        {
            $data['meta_title']             = "Customer Order";
            $data['meta_description']       = "Customer Order";
            $data['meta_keywords']          = "Customer Order";
            $data['page_title']             = "Customer Order";
            $data['module']                 = "Customer Order";
            $data['menu']                   = "customer_orders";
            $data['submenu']                = "list";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->push(1, 'Customer Order', customer_orders_constants::customer_orders_url);
            $this->breadcrumbs->unshift(2, 'List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "customer_orders/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function ajax_list()
        {
            $condition              = ['co.status !' => '-1', 'co.created_by' => $this->session->userdata('user_id')];
            $list                   = $this->customer_orders->get_data($condition, '', '', '');
            $tabledata              = [];
            $no                     = isset($_GET['offset']) ? $_GET['offset'] : 0;

            foreach ($list as $key => $value) {
                if(isset($value->created_on) && !empty($value->created_on) && $value->created_on !== '0000-00-00 00:00:00')
                {
                    $created_on     = date($this->config->item('default_date_time_format'), strtotime($value->created_on));
                }
                else
                {
                    $created_on     = 'NA';
                }
                if(isset($value->processed_on) && !empty($value->processed_on) && $value->processed_on !== '0000-00-00 00:00:00')
                {
                    $processed_on   = date($this->config->item('default_date_time_format'), strtotime($value->processed_on));
                }
                else
                {
                    $processed_on   = 'NA';
                }

                $order_delete       = '
                                        <a class="text-danger m-l-10" title="Delete" href="javascript:void(0);" onclick="change_status(`'.$value->order_number.'`, -1, this);" data-type="customer order" data-function="'.base_url().customer_orders_constants::change_customer_order_status_url.'"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    ';
                $order_status       = '';
                $order_print        = '
                                        <a class="text-warning m-l-10" title="Print" href="'.base_url().customer_orders_constants::print_customer_order_url.'/'.$value->order_number.'" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>
                                    ';

                if($value->order_status == 'placed')
                {
                    $order_status   = '<span class="badge badge-info">Placed</span>';
                }
                else if($value->order_status == 'delivered')
                {
                    $order_delete   = '';
                    $order_status   = '<span class="badge badge-success">Delivered</span>';
                }
                else if($value->order_status == 'cancelled')
                {
                    $order_print    = '';
                    $order_delete   = '';
                    $order_status   = '<span class="badge badge-danger">Cancelled</span>';
                }
                $order_delete       = '';

                $action             = '
                                        <span class="d-flex justify-content-center">
                                            <a class="" title="View" href="'.base_url().customer_orders_constants::view_customer_order_url.'/'.$value->order_number.'"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            '.$order_print.'
                                            '.$order_delete.'
                                        </span>
                                    ';

                $view               = '<a class="" href="'.base_url().customer_orders_constants::view_customer_order_url.'/'.$value->order_number.'" title="View '.$value->order_number.'">'.$value->order_number.'</a>';

                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['id']                                      = $value->id;
                $row['customer_name']                           = $value->customer_name;
                $row['order_number']                            = $view;
                $row['total_amount']                            = handle_number_format($value->total_amount);
                $row['total_d_p']                               = handle_number_format($value->total_d_p);
                $row['total_b_v']                               = handle_number_format($value->total_b_v);
                $row['total_quantity']                          = $value->total_quantity;
                $row['address']                                 = $value->address;
                $row['order_status']                            = $order_status;
                $row['message']                                 = $value->message;
                $row['processed_on']                            = $processed_on;
                $row['created_on']                              = $created_on;
                $row['action']                                  = $action;
            
                $tabledata[]                                    = $row;
            }

            $output                 = array(
                                        "total"      => $this->customer_orders->get_data($condition, '', '', 'allcount'),
                                        "rows"       => $tabledata,
                                    );

            echo json_encode($output);
        }

        private function form_validation_rules($data=[])
        {
            $this->form_validation->set_rules('customer_id', 'Customer', 'required|trim|xss_clean|strip_tags');
        }

        function add()
        {
            $data['meta_title']             = "Add Customer Order";
            $data['meta_description']       = "Add Customer Order";
            $data['meta_keywords']          = "Add Customer Order";
            $data['page_title']             = "Add Customer Order";
            $data['module']                 = "Customer Order";
            $data['menu']                   = "customer_orders";
            $data['submenu']                = "add";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->unshift(1, 'Customer Order', customer_orders_constants::customer_orders_url);
            $this->breadcrumbs->unshift(2, 'Add', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['customers']              = $this->customer_orders->get_customers();
            $data['products']               = $this->customer_orders->get_my_products();
            $data['content']                = "customer_orders/form";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function place()
        {
            $response                       = ['error' => 1, 'message' => 'All fields are required'];
            $this->form_validation_rules();

            if($this->form_validation->run($this) === TRUE)
            {
                if((isset($_POST['orderproductid']) && !empty($_POST['orderproductid'])) && (isset($_POST['customer_id']) && !empty($_POST['customer_id'])))
                {
                    $order_errors           = [];
                    $order_request          = [];
                    $totalquantity          = 0;
                    $totalamount            = 0;
                    $totalbv                = 0;
                    $totaldp                = 0;
                    $totalgst               = 0;
                    $totalcgst              = 0;
                    $totalsgst              = 0;
                    $totaligst              = 0;
                    $finaldp                = 0;

                    $order_products         = $this->input->post('orderproductid');

                    foreach ($order_products as $key => $value) {
                        $product_id         = $value;
                        $quantity           = $_POST['orderproductquantity'][$key];
                        // $amount             = $_POST['orderproductamount'][$key];
                        // $total_amount       = $_POST['orderproducttotalamount'][$key];

                        $product            = $this->customer_orders->get_product($product_id);

                        $gst                = $product['gst'];
                        $mrp                = $product['mrp'];
                        $d_p                = $product['d_p'];
                        $b_v                = $product['b_v'];
                        $stock              = $product['opening_stock'];
                        $check_quantity     = $stock - $quantity;

                        $total_amount       = $quantity*$mrp;
                        $total_d_p          = $quantity*$d_p;
                        $total_b_v          = $quantity*$b_v;
                        $total_gst          = ($total_d_p*$gst)/100;
                        $total_cgst         = $total_gst/2;
                        $total_sgst         = $total_cgst;
                        $total_igst         = $total_gst;
                        $final_d_p          = $total_d_p+$total_gst;

                        if($check_quantity < 0)
                        {
                            $order_errors[] = [
                                                'product_id'        => $product_id,
                                                'product_name'      => $product['name'],
                                                'product_stock'     => $stock,
                                                'order_quantity'    => $quantity,
                                                'error'             => 'Product stock is low',
                                            ];
                        }
                        else
                        {
                            $order_request[]= [
                                                'product'               => $product,
                                                'product_id'            => $product_id,
                                                'order_quantity'        => $quantity,
                                                'order_amount'          => $mrp,
                                                'order_total_amount'    => $total_amount,
                                                'order_d_p_amount'      => $d_p,
                                                'order_total_d_p_amount'=> $total_d_p,
                                                'order_b_v_amount'      => $b_v,
                                                'order_total_b_v_amount'=> $total_b_v,
                                                'gst_rate'              => $gst,
                                                'total_gst'             => $total_gst,
                                                'total_cgst'            => $total_cgst,
                                                'total_sgst'            => $total_sgst,
                                                'total_igst'            => $total_igst,
                                                'final_d_p'             => $final_d_p,
                                            ];
                        }

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

                    if(!empty($order_errors))
                    {
                        $this->session->set_flashdata('order_errors', $order_errors);
                        redirect(base_url().customer_orders_constants::add_customer_order_url);
                    }

                    if(!empty($_POST['service_charge']))
                    {
                        $finaldp                    = $finaldp+$_POST['service_charge'];
                    }

                    $order_number                   = 'CUSTOMER-ORDER-'.strtoupper($this->common_lib->generate_random_string(6));
                    $save_order                     = [];
                    $save_order['user_id']          = $this->session->userdata('user_id');
                    $save_order['customer_id']      = $_POST['customer_id'];
                    $save_order['order_number']     = $order_number;
                    $save_order['total_quantity']   = $totalquantity;
                    $save_order['gst_type']         = $_POST['gst_type'];
                    $save_order['gst_rate']         = 0;
                    $save_order['total_amount']     = $totalamount;
                    $save_order['total_d_p']        = $totaldp;
                    $save_order['total_b_v']        = $totalbv;
                    $save_order['total_gst']        = $totalgst;
                    $save_order['total_cgst']       = $totalcgst;
                    $save_order['total_sgst']       = $totalsgst;
                    $save_order['total_igst']       = $totaligst;
                    $save_order['service_charge']   = $_POST['service_charge'];
                    $save_order['final_d_p']        = $finaldp;
                    $save_order['address']          = $_POST['address'];
                    $save_order['order_status']     = 'placed';
                    $save_order['message']          = NULL;
                    $save_order['status']           = 1;
                    $save_order['processed_on']     = date('Y-m-d H:i:s');
                    $save_order['created_on']       = date('Y-m-d H:i:s');
                    $save_order['created_by']       = $this->session->userdata('user_id');

                    $response                       = $this->customer_orders->place($save_order, $order_request);

                    $redirect                       = base_url(customer_orders_constants::add_customer_order_url);
                    if($response['error'] == 0)
                    {
                        $this->commissions->franchise_and_sponsor('customer_order', $response['order_id'], $this->data['user_data']); // Commission
                        $redirect                   = base_url(customer_orders_constants::view_customer_order_url.'/'.$response['order_number']);
                    }
                    $this->session->set_flashdata('status', $response);
                    redirect($redirect);
                }
                else
                {
                    $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Invalid request']);
                    redirect(base_url().customer_orders_constants::add_customer_order_url);
                }
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().customer_orders_constants::add_customer_order_url);
            }
        }

        function view($order_number)
        {
            $response                       = ['error' => 1, 'message' => 'Invalid request'];
            if(!empty($order_number))
            {
                $data['meta_title']         = "View Customer Order";
                $data['meta_description']   = "View Customer Order";
                $data['meta_keywords']      = "View Customer Order";
                $data['page_title']         = "View Customer Order";
                $data['module']             = "Customer Order";
                $data['menu']               = "customer_orders";
                $data['submenu']            = "list";
                $data['childmenu']          = "";
                $data['loggedin']           = "yes";
                $data['id']                 = '';

                $data['order']              = $this->customer_orders->get_details($order_number);
                
                if(!empty($data['order']))
                {
                    $order_id               = $data['order']['id'];
                    $data['id']             = $order_id;
                    $data['order_products'] = $this->customer_orders->get_order_products($order_id);

                    $this->breadcrumbs->push(1, 'Customer Order', customer_orders_constants::customer_orders_url);
                    $this->breadcrumbs->unshift(2, 'View', '#');
                    $data['breadcrumb']     = $this->breadcrumbs->show();

                    $data['content']        = "customer_orders/view";
                    echo Modules::run("templates/".$this->config->item('theme'), $data);
                }
                else
                {
                    $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Customer order not found']);
                    redirect(base_url().customer_orders_constants::customer_orders_url);
                }
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().customer_orders_constants::customer_orders_url);
            }
        }

        function print_pdf($order_number)
        {
            $response                       = ['error' => 1, 'message' => 'Invalid request'];
            if(!empty($order_number))
            {
                $data['meta_title']         = "Print Customer Order";
                $data['meta_description']   = "Print Customer Order";
                $data['meta_keywords']      = "Print Customer Order";
                $data['page_title']         = "Print Customer Order";
                $data['module']             = "Customer Order";
                $data['menu']               = "customer_orders";
                $data['submenu']            = "list";
                $data['childmenu']          = "";
                $data['loggedin']           = "yes";
                $data['id']                 = '';

                $data['franchise_data']     = $this->data['user_data'];
                $data['order']              = $this->customer_orders->get_details($order_number);
                
                if(!empty($data['order']))
                {
                    $order_id               = $data['order']['id'];
                    $data['id']             = $order_id;
                    $data['customer_details']= $this->customer_orders->get_customer($data['order']['customer_id']);
                    $data['order_products'] = $this->customer_orders->get_order_products($order_id);
                    // echo "<pre>";print_r($data);exit;

                    $this->load->library('pdf/pdf');
                    $pdf_data               = [
                                                'mode'      => 'view',
                                                'file_name' => $order_number.'.pdf',
                                                'html'      => $this->load->view("customer_orders/pdf/invoice", $data, true),
                                                'file_path' => ['temp', 'user_'.$this->session->userdata('user_id'), 'invoices'],
                                            ];
                    return $this->pdf->process($pdf_data);
                }
                else
                {
                    $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Customer order not found']);
                    redirect(base_url().customer_orders_constants::customer_orders_url);
                }
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().customer_orders_constants::customer_orders_url);
            }
        }

        function process()
        {
            $response                       = ['error' => 1, 'message' => 'Invalid request'];
            if(isset($_POST['order_number']) && !empty($_POST['order_number']))
            {
                $order_number               = $_POST['order_number'];
                $order_status               = $_POST['order_status'];
                $order                      = $this->customer_orders->get_details($order_number);

                if(!empty($order))
                {
                    $response               = $this->customer_orders->process($order, $_POST);
                    if($response['error'] == 0 && $order_status == 'cancelled')
                    {
                        $this->commissions->remove_franchise_sponsor_commission('customer_order', $order, $this->data['user_data']);
                    }
                    $this->session->set_flashdata('status', $response);
                    redirect(base_url().customer_orders_constants::view_customer_order_url.'/'.$order_number);
                }
                else
                {
                    $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Customer order not found']);
                    redirect(base_url().customer_orders_constants::customer_orders_url);
                }
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().customer_orders_constants::customer_orders_url);
            }
        }

        function change()
        {
            $response           = ['error' => 1, 'message' => 'Invalid request'];

            if(isset($_POST) && !empty($_POST))
            {
                $order_number   = isset($_POST['id']) ? $_POST['id'] : '';
                $type           = isset($_POST['type']) ? $_POST['type'] : '';
                $status         = isset($_POST['status']) ? $_POST['status'] : '';

                $details        = $this->customer_orders->get_details($order_number);

                if(!empty($details))
                {
                    if($status == '-1')
                    {
                        $message = 'deleted';
                    }
                    else if($status == 1)
                    {
                        $message = 'activated';
                    }
                    else if($status == 0)
                    {
                        $message = 'in-activated';
                    }

                    if($this->customer_orders->change($details, $status))
                    {
                        $response= ['error' => 0, 'message' => ucfirst($type).' successfully '.$message];
                    }
                    else
                    {
                        $response= ['error' => 1, 'message' => 'Unable to perform this action'];
                    }
                }
                else
                {
                    $response   = ['error' => 1, 'message' => 'No '.$type.' found'];
                }
            }
            echo json_encode($response);
        }
    }