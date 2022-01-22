<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Payout_model extends CI_Model
    {
        private $table_payout = payout_table::sql_tbl_payout;

        public function __construct()
        {
           // exit("hjh");
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
                                    c.by_ownid LIKE "%'.$term.'%" ESCAPE "!"
                                    OR c.amount LIKE "%'.$term.'%" ESCAPE "!"
                                    OR c.payout_type LIKE "%'.$term.'%" ESCAPE "!"
                                    OR c.remark LIKE "%'.$term.'%" ESCAPE "!"
                                    OR c.created_on LIKE "%'.$term.'%" ESCAPE "!"
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
                $payout_type         = isset($_GET['custom_search']['payout_type']) ? $_GET['custom_search']['payout_type'] : '';

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
                    $where      .= ' AND c.created_on BETWEEN "'.$from_date.'" AND "'.$to_date.'"';
                }
                else if(!empty($from_date) && empty($to_date))
                {
                    $where      .= ' AND c.created_on >= "'.$from_date.'"';
                }
                else if(empty($from_date) && !empty($to_date))
                {
                    $where      .= ' AND c.created_on <= "'.$to_date.'"';
                }

                if($payout_type != '')
                {
                    $where      .= ' AND c.payout_type IN ('.implode(',', $payout_type).')';
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
                    $sort_by = 'c.created_on';
                }
                else if($_GET['sort'] == 'by_ownid')
                {
                    $sort_by = 'c.by_ownid';
                }
                else if($_GET['sort'] == 'amount')
                {
                    $sort_by = 'c.amount';
                }
                else if($_GET['sort'] == 'payout_type')
                {
                    $sort_by = 'c.payout_type';
                }
                else if($_GET['sort'] == 'remark')
                {
                    $sort_by = 'c.remark';
                }
                else
                {
                    $sort_by = 'c.id';
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
                $order       = 'c.id DESC';
            }

            // Limit
            if(empty($allcount))
            {
                if(isset($_GET['limit']) && $_GET['limit'] != -1)
                {
                    $offset = $_GET['offset'];
                    $limit  = $_GET['limit'];
                }
                else if($limit)
                {
                    $limit  = $limit;
                }
                $offset     = !empty($offset) ? $offset : 0;

                if($limit > 0)
                {
                    $limit_offset = !empty($limit) ? $limit.', '.$offset : '';
                }
            }

            $this->db->select('c.*');
            $this->db->from($this->table_payout.' c');
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

        function get_details($id='')
        {
            $this->db->select('*');
            $this->db->from($this->table_payout);
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->where('id', $id);
            $this->db->where('status !=', '-1');
            $query = $this->db->get();
            return $query->row_array();
        }

        function save($id='', $save_data=[])
        {
            $response         = ['error' => 1, 'message' => 'Invalid request'];

            if(!empty($save_data))
            {
                if(!empty($id))
                {
                    $this->db->where('id', $id);
                    $this->db->update($this->table_payout, $save_data);
                }
                else
                {
                    $this->db->insert($this->table_payout, $save_data);
                    $id       = $this->db->insert_id();
                }

                if($this->db->affected_rows())
                {
                    $response = ['error' => 0, 'message' => 'Customer successfully saved'];
                }
                else
                {
                    $response = ['error' => 1, 'message' => 'Unable to save a customer'];
                }
            }
            return $response;
        }

        function change($id='', $status)
        {
            $update['status']           = $status;
            $update['modified_on']      = date('Y-m-d H:i:s');
            $update['modified_by']      = $this->session->userdata('user_id');

            $this->db->where('id', $id);
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->update($this->table_payout, $update);

            return $this->db->affected_rows();
        }

        function check_unique($conditions=[])
        {
            $this->db->select('*');
            $this->db->from($this->table_payout);
            if(!empty($conditions))
            {
                foreach ($conditions as $key => $value) {
                    $this->db->where($key, $value);
                }
            }
            $query = $this->db->get();
            $data  = $query->row_array();
            if(!empty($data))
            {
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
    }