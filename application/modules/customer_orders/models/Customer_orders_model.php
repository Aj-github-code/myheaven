<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Customer_orders_model extends CI_Model
    {
        private $table_customer_orders          = customer_orders_table::sql_tbl_customer_orders;
        private $table_customer_order_products  = customer_orders_table::sql_tbl_customer_order_products;
        private $table_my_products              = my_products_table::sql_tbl_franchise_purchased_products;
        private $table_customers                = customers_table::sql_tbl_customers;
        private $table_userdetails              = top_up_table::sql_tbl_userdetails;
        private $table_useroption               = top_up_table::sql_tbl_useroption;

        public function __construct()
        {
            parent::__construct();
            $this->myheavendb                   = $this->load->database('myheavendb', TRUE);
        }

        function get_data($conditions=[], $limit='', $offset=0, $allcount='')
        {
            $order          = '';
            $where          = '1=1';
            $like_sql       = '';
            $limit_offset   = '';

            // Like
            if(isset($_GET['search']) && !empty($_GET['search']) && $_GET['search'] != 'undefined')
            {
                $term       = $_GET['search'];
                $like_sql   = ' AND
                                (
                                    co.order_number LIKE "%'.$term.'%" ESCAPE "!"
                                    OR co.total_d_p LIKE "%'.$term.'%" ESCAPE "!"
                                    OR co.total_quantity LIKE "%'.$term.'%" ESCAPE "!"
                                    OR co.order_status LIKE "%'.$term.'%" ESCAPE "!"
                                    OR co.processed_on LIKE "%'.$term.'%" ESCAPE "!"
                                    OR co.created_on LIKE "%'.$term.'%" ESCAPE "!"
                                    OR c.name LIKE "%'.$term.'%" ESCAPE "!"
                                )
                            ';
            }

            // Where
            if(!empty($conditions))
            {
                foreach ($conditions as $key => $value) {
                    $where .= ' AND '.$key.'='.$value;
                }
            }

            // Custom Filter
            if(isset($_GET['custom_search']) && !empty($_GET['custom_search']))
            {
                $from_date      = '';
                $to_date        = '';
                $status         = isset($_GET['custom_search']['status']) ? $_GET['custom_search']['status'] : '';
                $order_status   = isset($_GET['custom_search']['order_status']) ? $_GET['custom_search']['order_status'] : '';

                if(isset($_GET['custom_search']['from_date']) && !empty($_GET['custom_search']['from_date']))
                {
                    $from_date  = date("Y-m-d", strtotime($_GET['custom_search']['from_date'])).' 00:00:00';
                }

                if(isset($_GET['custom_search']['to_date']) && !empty($_GET['custom_search']['to_date']))
                {
                    $to_date    = date("Y-m-d", strtotime($_GET['custom_search']['to_date'])).' 23:59:59';
                }

                if(!empty($from_date) && !empty($to_date))
                {
                    $where      .= ' AND co.created_on BETWEEN "'.$from_date.'" AND "'.$to_date.'"';
                }
                else if(!empty($from_date) && empty($to_date))
                {
                    $where      .= ' AND co.created_on >= "'.$from_date.'"';
                }
                else if(empty($from_date) && !empty($to_date))
                {
                    $where      .= ' AND co.created_on <= "'.$to_date.'"';
                }

                if($order_status != '')
                {
                    $where      .= ' AND co.order_status IN ("' .implode('", "', $order_status). '")';
                }

                if($status != '')
                {
                    $where      .= ' AND co.status IN ('.implode(',', $status).')';
                }
            }

            if(!empty($like_sql))
            {
                $where          .= ' '.$like_sql;
            }

            // Order
            if(isset($_GET['order']) && !empty($_GET['order']) && isset($_GET['sort']) && !empty($_GET['sort']))
            {
                if($_GET['sort'] == 'created_on')
                {
                    $sort_by = 'co.created_on';
                }
                else if($_GET['sort'] == 'order_number')
                {
                    $sort_by = 'co.order_number';
                }
                else if($_GET['sort'] == 'total_d_p')
                {
                    $sort_by = 'co.total_d_p';
                }
                else if($_GET['sort'] == 'total_quantity')
                {
                    $sort_by = 'co.total_quantity';
                }
                else if($_GET['sort'] == 'address')
                {
                    $sort_by = 'co.address';
                }
                else if($_GET['sort'] == 'order_status')
                {
                    $sort_by = 'co.order_status';
                }
                else if($_GET['sort'] == 'message')
                {
                    $sort_by = 'co.message';
                }
                else if($_GET['sort'] == 'processed_on')
                {
                    $sort_by = 'co.processed_on';
                }
                else if($_GET['sort'] == 'status')
                {
                    $sort_by = 'co.status';
                }
                else if($_GET['sort'] == 'customer_name')
                {
                    $sort_by = 'c.name';
                }
                else
                {
                    $sort_by = 'co.id';
                }

                if(isset($_GET['order']) && !empty($_GET['order']))
                {
                    $by      = $_GET['order'];
                }
                else
                {
                    $by      = 'DESC';
                }
                $order       = $sort_by.' '.$by;
            } 
            else
            {
                $order       = 'co.id DESC';
            }

            // Limit
            if(empty($allcount))
            {
                if(isset($_GET['limit']) && $_GET['limit'] != -1)
                {
                    $offset = $_GET['offset'];
                    $limit = $_GET['limit'];
                }
                else if($limit)
                {
                    $limit = $limit;
                }
                $offset = !empty($offset) ? $offset : 0;

                if($limit > 0)
                {
                    $limit_offset = !empty($limit) ? $limit.', '.$offset : '';
                }
            }

            $this->db->select('co.*, c.name as customer_name');
            $this->db->from($this->table_customer_orders.' co');
            $this->db->join($this->table_customers.' c', 'co.customer_id=c.id', 'INNER');
            $this->db->where($where);
            $this->db->order_by($order);
            if($allcount != 'allcount')
            {
                if($limit > 0 && $offset > 0)
                {
                    $this->db->limit($limit, $offset);
                }
                else
                {
                    if(!empty($limit))
                    {
                        $this->db->limit($limit);
                    }
                }
            }
            $query = $this->db->get();

            // echo "<pre>";print_r($this->db->last_query());exit;

            if($allcount == 'allcount')
            {
                return $query->num_rows();
            }
            else
            {
                return $query->result();
            }
        }

        function get_members()
        {
            $this->myheavendb->select('u.*, uo.sponsorid, uo.pin');
            $this->myheavendb->from($this->table_userdetails.' u');
            $this->myheavendb->join($this->table_useroption.' uo', 'u.ownid=uo.ownid', 'INNER');
            $query = $this->myheavendb->get();
            return $query->result_array();
        }

        function get_member($member_code)
        {
            $this->myheavendb->select('u.*, uo.sponsorid, uo.pin');
            $this->myheavendb->from($this->table_userdetails.' u');
            $this->myheavendb->join($this->table_useroption.' uo', 'u.ownid=uo.ownid', 'INNER');
            $this->myheavendb->where('u.ownid', $member_code);
            $query = $this->myheavendb->get();
            return $query->row_array();
        }

        function get_customers()
        {
            $this->db->select('*');
            $this->db->from($this->table_customers);
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->where('status', 1);
            $query = $this->db->get();
            return $query->result_array();
        }

        function get_customer($id)
        {
            $this->db->select('*');
            $this->db->from($this->table_customers);
            $this->db->where('id', $id);
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->where('status', 1);
            $query = $this->db->get();
            return $query->row_array();
        }

        function get_my_products()
        {
            $this->db->select('*');
            $this->db->from($this->table_my_products);
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->where('opening_stock >', 0);
            $this->db->where('status', 1);
            $query = $this->db->get();
            return $query->result_array();
        }

        function get_product($product_id)
        {
            $this->db->select('*');
            $this->db->from($this->table_my_products);
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->where('product_id', $product_id);
            $this->db->where('status', 1);
            $query = $this->db->get();
            // echo "<pre>";print_r($this->db->last_query());//exit;
            return $query->row_array();
        }

        function get_details($order_number)
        {
            $this->db->select('*');
            $this->db->from($this->table_customer_orders);
            $this->db->where('order_number', $order_number);
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->where('status', 1);
            $query = $this->db->get();
            // echo "<pre>";print_r($this->db->last_query());exit;
            return $query->row_array();
        }

        function get_order_products($order_id)
        {
            $this->db->select('rop.*, p.name, p.p_code, p.hsn_sac, p.slug, p.description, p.thumbnail, p.mrp, p.d_p, p.b_v, p.opening_stock');
            $this->db->from($this->table_customer_order_products.' rop');
            $this->db->join($this->table_my_products.' p', 'rop.product_id=p.product_id', 'INNER');
            $this->db->where('rop.order_id', $order_id);
            $this->db->where('rop.user_id', $this->session->userdata('user_id'));
            $this->db->where('rop.status', 1);
            $this->db->where('p.user_id', $this->session->userdata('user_id'));
            $this->db->where('p.status', 1);
            $this->db->order_by('rop.id', 'ASC');
            $query = $this->db->get();
            return $query->result_array();
        }

        function place($save_order, $order_request)
        {
            $response                   = ['error' => 1, 'message' => 'Unable to request order'];
            $this->db->insert($this->table_customer_orders, $save_order);
            if($this->db->affected_rows())
            {
                $order_id               = $this->db->insert_id();

                foreach ($order_request as $key => $value) {
                    $product                                = $value['product'];
                    $product_id                             = $value['product_id'];
                    $order_quantity                         = $value['order_quantity'];
                    $amount                                 = $value['order_amount'];
                    $order_total_amount                     = $value['order_total_amount'];
                    $d_p_amount                             = $value['order_d_p_amount'];
                    $order_total_d_p_amount                 = $value['order_total_d_p_amount'];
                    $b_v_amount                             = $value['order_b_v_amount'];
                    $order_total_b_v_amount                 = $value['order_total_b_v_amount'];
                    $gst_rate                               = $value['gst_rate'];
                    $total_gst                              = $value['total_gst'];
                    $total_cgst                             = $value['total_cgst'];
                    $total_sgst                             = $value['total_sgst'];
                    $total_igst                             = $value['total_igst'];
                    $final_d_p                              = $value['final_d_p'];

                    $save_order_products                    = [];
                    $save_order_products['order_id']        = $order_id;
                    $save_order_products['user_id']         = $this->session->userdata('user_id');
                    $save_order_products['customer_id']     = $save_order['customer_id'];
                    $save_order_products['product_id']      = $product_id;
                    $save_order_products['quantity']        = $order_quantity;
                    $save_order_products['amount']          = $amount;
                    $save_order_products['total_amount']    = $order_total_amount;
                    $save_order_products['d_p']             = $d_p_amount;
                    $save_order_products['total_d_p']       = $order_total_d_p_amount;
                    $save_order_products['b_v']             = $b_v_amount;
                    $save_order_products['total_b_v']       = $order_total_b_v_amount;
                    $save_order_products['gst_rate']        = $gst_rate;
                    $save_order_products['total_gst']       = $total_gst;
                    $save_order_products['total_cgst']      = $total_cgst;
                    $save_order_products['total_sgst']      = $total_sgst;
                    $save_order_products['total_igst']      = $total_igst;
                    $save_order_products['final_d_p']       = $final_d_p;
                    $save_order_products['status']          = 1;
                    $save_order_products['created_on']      = date('Y-m-d H:i:s');
                    $save_order_products['created_by']      = $this->session->userdata('user_id');

                    $this->db->insert($this->table_customer_order_products, $save_order_products);
                    if($this->db->affected_rows())
                    {
                        $this->deduct_stock($product, $order_quantity);
                    }
                }

                $response               = ['error' => 0, 'message' => 'Order request successfully placed', 'order_number' => $save_order['order_number'], 'order_id' => $order_id];
            }
            return $response;
        }

        function deduct_stock($product, $order_quantity)
        {
            $update                     = [];
            $update['opening_stock']    = $product['opening_stock'] - $order_quantity;
            $update['modified_on']      = date('Y-m-d H:i:s');
            $update['modified_by']      = $this->session->userdata('user_id');

            $this->db->reset_query();
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->where('product_id', $product['product_id']);
            $this->db->where('id', $product['id']);
            $this->db->update($this->table_my_products, $update);
            return $this->db->affected_rows();
        }

        function process($order, $post_data)
        {
            $response                   = ['error' => 1, 'message' => 'Unable to process order'];

            $order_id                   = $post_data['order_id'];
            $order_number               = $post_data['order_number'];
            $order_status               = $post_data['order_status'];
            $message                    = $post_data['message'];

            $update                     = [];
            $update['order_status']     = $order_status;
            $update['message']          = $message;
            $update['processed_on']     = date('Y-m-d H:i:s');
            $update['processed_by']     = $this->session->userdata('user_id');
            $update['modified_on']      = date('Y-m-d H:i:s');
            $update['modified_by']      = $this->session->userdata('user_id');

            $this->db->where('id', $order_id);
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->update($this->table_customer_orders, $update);

            if($this->db->affected_rows())
            {
                if($update['order_status'] == 'cancelled')
                {
                    $order_products     = $this->get_order_products($order_id);
                    $this->revert_stock($order_products);
                }
                $response               = ['error' => 0, 'message' => 'Top up successfully processed'];
            }
            return $response;
        }

        function revert_stock($order_products)
        {
            foreach ($order_products as $key => $value) {
                $product_id             = $value['product_id'];
                $order_quantity         = $value['quantity'];

                $my_product             = $this->get_product($product_id);

                if(!empty($my_product))
                {
                    $update                     = [];
                    $update['opening_stock']    = $my_product['opening_stock'] + $order_quantity;
                    $update['modified_on']      = date('Y-m-d H:i:s');
                    $update['modified_by']      = $this->session->userdata('user_id');

                    $this->db->reset_query();
                    $this->db->where('user_id', $this->session->userdata('user_id'));
                    $this->db->where('product_id', $product_id);
                    $this->db->where('status', 1);
                    $this->db->update($this->table_my_products, $update);
                    $this->db->affected_rows();
                }
            }
        }

        function change($details, $status)
        {
            $order_id                   = $details['id'];
            $order_number               = $details['order_number'];

            $order_products             = $this->get_order_products($order_id);

            $update                     = [];
            $update['order_status']     = 'deleted';
            $update['status']           = $status;
            $update['modified_on']      = date('Y-m-d H:i:s');
            $update['modified_by']      = $this->session->userdata('user_id');

            $this->db->where('id', $order_id);
            $this->db->where('order_number', $order_number);
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->update($this->table_customer_orders, $update);
            $affected_rows              = $this->db->affected_rows();

            if($affected_rows)
            {
                unset($update['order_status']);

                $this->db->reset_query();
                $this->db->where('order_id', $order_id);
                $this->db->where('user_id', $this->session->userdata('user_id'));
                $this->db->update($this->table_customer_order_products, $update);

                $this->revert_stock($order_products);
            }
            return $affected_rows;
        }
    }