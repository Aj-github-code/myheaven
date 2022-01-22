<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Franchise_model extends CI_Model
    {
        private $table_franchise = franchise_table::sql_table_franchise;

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
                                    f.your_name LIKE "%'.$term.'%" ESCAPE "!"
                                    OR f.franchise_code LIKE "%'.$term.'%" ESCAPE "!"
                                    OR f.franchise_name LIKE "%'.$term.'%" ESCAPE "!"
                                    OR f.type LIKE "%'.$term.'%" ESCAPE "!"
                                    OR f.email LIKE "%'.$term.'%" ESCAPE "!"
                                    OR f.mobile LIKE "%'.$term.'%" ESCAPE "!"
                                    OR f.kyc_status LIKE "%'.$term.'%" ESCAPE "!"
                                    OR f.kyc_message LIKE "%'.$term.'%" ESCAPE "!"
                                    OR f.created_on LIKE "%'.$term.'%" ESCAPE "!"
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
                    $where      .= ' AND f.created_on BETWEEN "'.$from_date.'" AND "'.$to_date.'"';
                }
                else if(!empty($from_date) && empty($to_date))
                {
                    $where      .= ' AND f.created_on >= "'.$from_date.'"';
                }
                else if(empty($from_date) && !empty($to_date))
                {
                    $where      .= ' AND f.created_on <= "'.$to_date.'"';
                }

                if($status != '')
                {
                    $where      .= ' AND f.status IN ('.implode(',', $status).')';
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
                    $sort_by = 'f.created_on';
                }
                else if($_GET['sort'] == 'your_name')
                {
                    $sort_by = 'f.your_name';
                }
                else if($_GET['sort'] == 'franchise_code')
                {
                    $sort_by = 'f.franchise_code';
                }
                else if($_GET['sort'] == 'franchise_name')
                {
                    $sort_by = 'f.franchise_name';
                }
                else if($_GET['sort'] == 'type')
                {
                    $sort_by = 'f.type';
                }
                else if($_GET['sort'] == 'mobile')
                {
                    $sort_by = 'f.mobile';
                }
                else if($_GET['sort'] == 'email')
                {
                    $sort_by = 'f.email';
                }
                else if($_GET['sort'] == 'kyc_status')
                {
                    $sort_by = 'f.kyc_status';
                }
                else if($_GET['sort'] == 'kyc_message')
                {
                    $sort_by = 'f.kyc_message';
                }
                else
                {
                    $sort_by = 'f.id';
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
                $order       = 'f.id DESC';
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

            $this->db->select('f.*');
            $this->db->from($this->table_franchise.' f');
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
            $this->db->from($this->table_franchise);
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
                    $this->db->update($this->table_franchise, $save_data);
                }
                else
                {
                    $this->db->insert($this->table_franchise, $save_data);
                    $id       = $this->db->insert_id();
                }

                if($this->db->affected_rows())
                {
                    $response = ['error' => 0, 'message' => 'Franchise successfully saved'];
                }
                else
                {
                    $response = ['error' => 1, 'message' => 'Unable to save franchise'];
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
            $this->db->update($this->table_franchise, $update);

            return $this->db->affected_rows();
        }

        function check_unique($conditions=[])
        {
            $this->db->select('*');
            $this->db->from($this->table_franchise);
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