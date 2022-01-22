<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Orders_model extends CI_Model
    {
        private $table_franchise_orders         = orders_table::sql_tbl_franchise_orders;
        private $table_franchise_order_products = orders_table::sql_tbl_franchise_order_products;
        private $table_products                 = products_table::sql_tbl_franchise_products;

        public function __construct()
        {
            parent::__construct();
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
                                    fo.order_number LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fo.total_d_p LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fo.total_quantity LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fo.gst_rate LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fo.total_gst LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fo.service_charge LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fo.final_d_p LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fo.order_status LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fo.processed_on LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fo.created_on LIKE "%'.$term.'%" ESCAPE "!"
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
                    $where      .= ' AND fo.created_on BETWEEN "'.$from_date.'" AND "'.$to_date.'"';
                }
                else if(!empty($from_date) && empty($to_date))
                {
                    $where      .= ' AND fo.created_on >= "'.$from_date.'"';
                }
                else if(empty($from_date) && !empty($to_date))
                {
                    $where      .= ' AND fo.created_on <= "'.$to_date.'"';
                }

                if($order_status != '')
                {
                    $where      .= ' AND fo.order_status IN ("' .implode('", "', $order_status). '")';
                }

                if($status != '')
                {
                    $where      .= ' AND fo.status IN ('.implode(',', $status).')';
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
                    $sort_by = 'fo.created_on';
                }
                else if($_GET['sort'] == 'order_number')
                {
                    $sort_by = 'fo.order_number';
                }
                else if($_GET['sort'] == 'total_d_p')
                {
                    $sort_by = 'fo.total_d_p';
                }
                else if($_GET['sort'] == 'total_quantity')
                {
                    $sort_by = 'fo.total_quantity';
                }
                else if($_GET['sort'] == 'gst_rate')
                {
                    $sort_by = 'fo.gst_rate';
                }
                else if($_GET['sort'] == 'total_gst')
                {
                    $sort_by = 'fo.total_gst';
                }
                else if($_GET['sort'] == 'service_charge')
                {
                    $sort_by = 'fo.service_charge';
                }
                else if($_GET['sort'] == 'final_d_p')
                {
                    $sort_by = 'fo.final_d_p';
                }
                else if($_GET['sort'] == 'address')
                {
                    $sort_by = 'fo.address';
                }
                else if($_GET['sort'] == 'order_status')
                {
                    $sort_by = 'fo.order_status';
                }
                else if($_GET['sort'] == 'message')
                {
                    $sort_by = 'fo.message';
                }
                else if($_GET['sort'] == 'processed_on')
                {
                    $sort_by = 'fo.processed_on';
                }
                else if($_GET['sort'] == 'status')
                {
                    $sort_by = 'fo.status';
                }
                else
                {
                    $sort_by = 'fo.id';
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
                $order       = 'fo.id DESC';
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

            $this->db->select('fo.*');
            $this->db->from($this->table_franchise_orders.' fo');
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

        function get_details($order_number)
        {
            $this->db->select('*');
            $this->db->from($this->table_franchise_orders);
            $this->db->where('order_number', $order_number);
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->where('status', 1);
            $query = $this->db->get();
            // echo "<pre>";print_r($this->db->last_query());exit;
            return $query->row_array();
        }

        function get_order_products($order_id)
        {
            $this->db->select('fop.*, p.name, p.p_code, p.hsn_sac, p.slug, p.description, p.thumbnail, p.mrp, p.d_p, p.b_v, p.opening_stock');
            $this->db->from($this->table_franchise_order_products.' fop');
            $this->db->join($this->table_products.' p', 'fop.product_id=p.id', 'INNER');
            $this->db->where('fop.order_id', $order_id);
            $this->db->where('fop.user_id', $this->session->userdata('user_id'));
            $this->db->where('fop.status', 1);
            $this->db->where('p.status', 1);
            $this->db->order_by('fop.id', 'ASC');
            $query = $this->db->get();
            return $query->result_array();
        }

        function change($order_number='', $status)
        {
            $update['status']           = $status;
            $update['modified_on']      = date('Y-m-d H:i:s');
            $update['modified_by']      = $this->session->userdata('user_id');

            $this->db->where('order_number', $order_number);
            $this->db->update($this->table_franchise_orders, $update);
            $affected_rows = $this->db->affected_rows();

            return $affected_rows;
        }
    }