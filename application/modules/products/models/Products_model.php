<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Products_model extends CI_Model
    {
        private $table_products = products_table::sql_tbl_franchise_products;

        public function __construct()
        {
            parent::__construct();
        }

        function getProducts($data='', $limit='', $offset='', $is_count='', $order_by='')
        {
            $where              = '(p.status=1)';

            if(isset($data['min_price_value']) && !empty($data['min_price_value']))
            {
                $where          .= ' AND (p.d_p >= '.$data['min_price_value'].')';
            }

            if(isset($data['max_price_value']) && !empty($data['max_price_value']))
            {
                $where          .= ' AND (p.d_p <= '.$data['max_price_value'].')';
            }

            if(isset($data['term']) && !empty($data['term']))
            {
                $where          .= ' AND
                                    (
                                        p.name LIKE "%'.$data['term'].'%" ESCAPE "!"
                                        OR p.d_p LIKE "%'.$data['term'].'%" ESCAPE "!"
                                    )
                                ';
            }

            $order              = '';
            if(!empty($order_by))
            {
                $order          = 'p.'.$order_by['column'].' '.$order_by['sort'];
            }
            else
            {
                $order          = 'p.id DESC';
            }

            $orderby            = '';
            if(!empty($order))
            {
                $orderby        = ' ORDER BY '.$order;
            }

            if($offset == '' || empty($offset))
            {
                $offset         = 0;
            }

            $limit_offset       = '';
            if($is_count != 'count')
            {
                $limit_offset   = 'LIMIT '.$limit.' OFFSET '.$offset;
            }

            $sql                = '
                                    SELECT p.*
                                    FROM '.$this->table_products.' p
                                    WHERE '.$where.'
                                    GROUP BY p.id
                                    '.$orderby.'
                                    '.$limit_offset.'
                                ';
            $query              = $this->db->query($sql);
            
            // echo "<pre>";print_r($this->db->last_query());exit;
            if($is_count == 'count')
            {
                return $query->num_rows();
            }
            else
            {
                return $query->result_array();
            }
        }

        function get_details($id='')
        {
            $this->db->select('*');
            $this->db->from($this->table_products);
            $this->db->where('id', $id);
            $this->db->where('status !=', '-1');
            $query = $this->db->get();
            return $query->row_array();
        }
    }