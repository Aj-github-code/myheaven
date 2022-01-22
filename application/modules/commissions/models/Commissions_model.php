<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Commissions_model extends CI_Model
    {
        private $table_franchise_business_volume        = commissions_table::sql_tbl_franchise_business_volume;
        private $table_franchise_business_volume_parts  = commissions_table::sql_tbl_franchise_business_volume_parts;
        private $table_sponsor_business_volume          = commissions_table::sql_tbl_sponsor_business_volume;
        private $table_top_up_orders                    = top_up_table::sql_tbl_top_up_orders;
        private $table_top_up_order_products            = top_up_table::sql_tbl_top_up_order_products;
        private $table_repurchase_orders                = repurchase_table::sql_tbl_repurchase_orders;
        private $table_repurchase_order_products        = repurchase_table::sql_tbl_repurchase_order_products;
        private $table_customer_orders                  = customer_orders_table::sql_tbl_customer_orders;
        private $table_customer_order_products          = customer_orders_table::sql_tbl_customer_order_products;

        public function __construct()
        {
            parent::__construct();
        }

        function get_order($table, $order_id)
        {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where('id', $order_id);
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->where('status', 1);
            $query                      = $this->db->get();
            return $query->row_array();
        }

        function get_order_products($table, $order_id)
        {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where('order_id', $order_id);
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->where('status', 1);
            $this->db->order_by('id', 'ASC');
            $query = $this->db->get();
            return $query->result_array();
        }

        function franchise_and_sponsor($type, $order_id, $franchise)
        {
            $franchise_type             = $franchise['type'];
            $sponsor_id                 = $franchise['sponsor_id'];
            $sponsor_rate               = $this->config->item('sponsor_business_volume_rate');
            $franchise_rate             = $this->config->item('business_volume_rates')[$franchise_type];

            if($type == 'top_up')
            {
                $table_orders           = $this->table_top_up_orders;
                $table_order_products   = $this->table_top_up_order_products;
            }
            else if($type == 'repurchase')
            {
                $table_orders           = $this->table_repurchase_orders;
                $table_order_products   = $this->table_repurchase_order_products;
            }
            else if($type == 'customer_order')
            {
                $table_orders           = $this->table_customer_orders;
                $table_order_products   = $this->table_customer_order_products;
            }

            $order                      = $this->get_order($table_orders, $order_id);

            if(!empty($order))
            {
                $order_number                                       = $order['order_number'];
                $order_total_b_v                                    = $order['total_b_v'];
                $total_business_volume                              = ($order_total_b_v*$franchise_rate)/100;
                $total_sponsor_volume                               = ($total_business_volume*$sponsor_rate)/100;

                $business_volume                                    = [];
                $business_volume['user_id']                         = $this->session->userdata('user_id');
                $business_volume['type']                            = $type;
                $business_volume['order_id']                        = $order_id;
                $business_volume['order_number']                    = $order_number;
                $business_volume['total_b_v']                       = $order_total_b_v;
                $business_volume['business_volume_rate']            = $franchise_rate;
                $business_volume['total_business_volume']           = $total_business_volume;
                $business_volume['paid']                            = 0;
                $business_volume['status']                          = 1;
                $business_volume['created_on']                      = date('Y-m-d H:i:s');
                $business_volume['created_by']                      = $this->session->userdata('user_id');

                $this->db->insert($this->table_franchise_business_volume, $business_volume);
                $franchise_business_volume_id                       = $this->db->insert_id();

                $order_products                                     = $this->get_order_products($table_order_products, $order_id);

                foreach ($order_products as $key => $value) {
                    $order_products_id                              = $value['id'];
                    $product_id                                     = $value['product_id'];
                    $order_product_total_b_v                        = $value['total_b_v'];
                    $order_product_total_business_volume            = ($order_product_total_b_v*$franchise_rate)/100;

                    $business_parts                                 = [];
                    $business_parts['user_id']                      = $this->session->userdata('user_id');
                    $business_parts['franchise_business_volume_id'] = $franchise_business_volume_id;
                    $business_parts['type']                         = $type;
                    $business_parts['order_id']                     = $order_id;
                    $business_parts['order_number']                 = $order_number;
                    $business_parts['order_products_id']            = $order_products_id;
                    $business_parts['product_id']                   = $product_id;
                    $business_parts['total_b_v']                    = $order_product_total_b_v;
                    $business_parts['business_volume_rate']         = $franchise_rate;
                    $business_parts['total_business_volume']        = $order_product_total_business_volume;
                    $business_parts['paid']                         = 0;
                    $business_parts['status']                       = 1;
                    $business_parts['created_on']                   = date('Y-m-d H:i:s');
                    $business_parts['created_by']                   = $this->session->userdata('user_id');

                    $this->db->insert($this->table_franchise_business_volume_parts, $business_parts);
                }

                $sponsor_business_volume                                    = [];
                $sponsor_business_volume['sponsor_id']                      = $sponsor_id;
                $sponsor_business_volume['user_id']                         = $this->session->userdata('user_id');
                $sponsor_business_volume['franchise_business_volume_id']    = $franchise_business_volume_id;
                $sponsor_business_volume['type']                            = $type;
                $sponsor_business_volume['order_id']                        = $order_id;
                $sponsor_business_volume['order_number']                    = $order_number;
                $sponsor_business_volume['total_b_v']                       = $order_total_b_v;
                $sponsor_business_volume['total_franchise_business_volume'] = $total_business_volume;
                $sponsor_business_volume['business_volume_rate']            = $sponsor_rate;
                $sponsor_business_volume['total_sponsor_business_volume']   = $total_sponsor_volume;
                $sponsor_business_volume['paid']                            = 0;
                $sponsor_business_volume['status']                          = 1;
                $sponsor_business_volume['created_on']                      = date('Y-m-d H:i:s');
                $sponsor_business_volume['created_by']                      = $this->session->userdata('user_id');

                $this->db->insert($this->table_sponsor_business_volume, $sponsor_business_volume);
                return $this->db->affected_rows();
            }
        }

        function remove_franchise_sponsor_commission($type, $order, $franchise)
        {
            $order_id                   = $order['id'];

            $update                     = [];
            $update['status']           = '-1';
            $update['modified_on']      = date('Y-m-d H:i:s');
            $update['modified_by']      = $this->session->userdata('user_id');

            $this->db->reset_query();
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->where('type', $type);
            $this->db->where('order_id', $order_id);
            $this->db->where('status', 1);
            $this->db->update($this->table_franchise_business_volume, $update);

            $this->db->reset_query();
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->where('type', $type);
            $this->db->where('order_id', $order_id);
            $this->db->where('status', 1);
            $this->db->update($this->table_franchise_business_volume_parts, $update);

            $this->db->reset_query();
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->where('type', $type);
            $this->db->where('order_id', $order_id);
            $this->db->where('status', 1);
            $this->db->update($this->table_sponsor_business_volume, $update);
        }
    }