<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Cart_model extends CI_Model
    {
        private $table_cart                     = cart_table::sql_tbl_franchise_cart;
        private $table_products                 = products_table::sql_tbl_franchise_products;
        private $table_franchise_orders         = orders_table::sql_tbl_franchise_orders;
        private $table_franchise_order_products = orders_table::sql_tbl_franchise_order_products;

        public function __construct()
        {
            parent::__construct();
        }

        function getProducts()
        {
            $this->db->select('c.product_id, c.quantity, c.id as cart_id, p.*');
            $this->db->from($this->table_cart.' c');
            $this->db->join($this->table_products.' p', 'c.product_id=p.id', 'INNER');
            $this->db->where('c.user_id', $this->session->userdata('user_id'));
            $this->db->where('c.status', 1);
            $this->db->where('p.status', 1);
            $this->db->order_by('c.id', 'DESC');
            $query = $this->db->get();
            return $query->result_array();
        }

        function check_product($product_id)
        {
            $this->db->select('*');
            $this->db->from($this->table_cart);
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->where('product_id', $product_id);
            $this->db->where('status', 1);
            $query = $this->db->get();
            return $query->row_array();
        }

        function cart_count()
        {
            $this->db->select('count(*) as cart_count');
            $this->db->from($this->table_cart);
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->where('status', 1);
            $query = $this->db->get();
            $cart = $query->row_array();
            if(isset($cart['cart_count']) && !empty($cart['cart_count']))
            {
                return $cart['cart_count'];
            }
            else
            {
                return 0;
            }
        }

        function get_product($product_id)
        {
            $this->db->select('*');
            $this->db->from($this->table_products);
            $this->db->where('id', $product_id);
            $this->db->where('status', 1);
            $query = $this->db->get();
            return $query->row_array();
        }

        function add($product_id)
        {
            $response               = ['error' => 1, 'message' => 'Unable to add to cart'];
            $save                   = [];
            $save['user_id']        = $this->session->userdata('user_id');
            $save['product_id']     = $product_id;
            $save['quantity']       = 1;
            $save['status']         = 1;
            $save['created_on']     = date('Y-m-d H:i:s');
            $save['created_by']     = $this->session->userdata('user_id');

            $this->db->insert($this->table_cart, $save);
            if($this->db->affected_rows())
            {
                $response           = ['error' => 0, 'message' => 'Product successfully added to cart'];
            }
            return $response;
        }

        function remove($cart_id)
        {
            $response               = ['error' => 1, 'message' => 'Unable to remove product from cart'];
            $save                   = [];
            $save['status']         = '-1';
            $save['modified_on']    = date('Y-m-d H:i:s');
            $save['modified_by']    = $this->session->userdata('user_id');

            $this->db->where('id', $cart_id);
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->update($this->table_cart, $save);
            if($this->db->affected_rows())
            {
                $response           = ['error' => 0, 'message' => 'Product successfully removed from cart'];
            }
            return $response;
        }

        function order_request($order_request)
        {
            $response                       = ['error' => 1, 'message' => 'Unable to request order'];
            $order_number                   = 'F-ORDER-'.strtoupper($this->common_lib->generate_random_string(6));
            $save_order                     = [];
            $save_order['user_id']          = $this->session->userdata('user_id');
            $save_order['order_number']     = $order_number;
            $save_order['total_quantity']   = $order_request['total_quantity'];
            $save_order['gst_rate']         = 0;
            $save_order['total_amount']     = $order_request['total_amount'];
            $save_order['total_d_p']        = $order_request['total_d_p'];
            $save_order['total_b_v']        = $order_request['total_b_v'];
            $save_order['total_gst']        = $order_request['total_gst'];
            $save_order['total_cgst']       = $order_request['total_cgst'];
            $save_order['total_sgst']       = $order_request['total_sgst'];
            $save_order['total_igst']       = $order_request['total_igst'];
            $save_order['service_charge']   = 0;
            $save_order['final_d_p']        = $order_request['final_d_p'];
            $save_order['address']          = $order_request['address'];
            $save_order['order_status']     = 'pending';
            $save_order['message']          = NULL;
            $save_order['status']           = 1;
            $save_order['processed_on']     = date('Y-m-d H:i:s');
            $save_order['created_on']       = date('Y-m-d H:i:s');
            $save_order['created_by']       = $this->session->userdata('user_id');

            $this->db->insert($this->table_franchise_orders, $save_order);
            if($this->db->affected_rows())
            {
                $response                   = ['error' => 0, 'message' => 'Your order request successfully sent', 'order_number' => $order_number];
                $order_id                   = $this->db->insert_id();

                foreach ($order_request['order_products'] as $key => $value) {
                    $save_order_products                    = [];
                    $save_order_products['order_id']        = $order_id;
                    $save_order_products['user_id']         = $this->session->userdata('user_id');
                    $save_order_products['product_id']      = $value['product_id'];
                    $save_order_products['quantity']        = $value['quantity'];
                    $save_order_products['amount']          = $value['amount'];
                    $save_order_products['total_amount']    = $value['total_amount'];
                    $save_order_products['d_p']             = $value['d_p'];
                    $save_order_products['total_d_p']       = $value['total_d_p'];
                    $save_order_products['b_v']             = $value['b_v'];
                    $save_order_products['total_b_v']       = $value['total_b_v'];
                    $save_order_products['gst_rate']        = $value['gst_rate'];
                    $save_order_products['total_gst']       = $value['total_gst'];
                    $save_order_products['total_cgst']      = $value['total_cgst'];
                    $save_order_products['total_sgst']      = $value['total_sgst'];
                    $save_order_products['total_igst']      = $value['total_igst'];
                    $save_order_products['final_d_p']       = $value['final_d_p'];
                    $save_order_products['status']          = 1;
                    $save_order_products['created_on']      = date('Y-m-d H:i:s');
                    $save_order_products['created_by']      = $this->session->userdata('user_id');

                    $this->db->insert($this->table_franchise_order_products, $save_order_products);
                }

                $update                     = [];
                $update['status']           = '-1';
                $update['modified_on']      = date('Y-m-d H:i:s');
                $update['modified_by']      = $this->session->userdata('user_id');

                $this->db->where('user_id', $this->session->userdata('user_id'));
                $this->db->where('status !=', '-1');
                $this->db->update($this->table_cart, $update);
            }

            return $response;
        }
    }