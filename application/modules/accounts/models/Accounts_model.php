<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Accounts_model extends CI_Model
    {
        private $table_payout_monthly   = accounts_table::sql_payout_monthly;
        private $table_userdetails      = accounts_table::sql_userdetails;
        private $table_direct_comm      = accounts_table::sql_direct_comm;
        private $table_franchise         = genealogy_table::sql_tbl_franchise;

        public function __construct()
        {
            parent::__construct();
        }

        function get_data($conditions, $limit='', $offset=0, $allcount='')
        {
            $order          = '';
            $where          = '1=1';
            $like_sql       = '';
            $limit_offset   = '';

            if(isset($_GET['search']) && !empty($_GET['search']) && $_GET['search'] != 'undefined')
            {
                $term       = $_GET['search'];
                $like_sql   = 'AND
                                (
                                    ud.firstname LIKE "%'.$term.'%" ESCAPE "!"
                                    OR ud.midname LIKE "%'.$term.'%" ESCAPE "!"
                                    OR ud.lastname LIKE "%'.$term.'%" ESCAPE "!"
                                    OR ud.ownid LIKE "%'.$term.'%" ESCAPE "!"
                                    OR ud.ifsccode LIKE "%'.$term.'%" ESCAPE "!"
                                    OR ud.accountno LIKE "%'.$term.'%" ESCAPE "!"
                                    OR ud.mobile LIKE "%'.$term.'%" ESCAPE "!"
                                    OR ud.panno LIKE "%'.$term.'%" ESCAPE "!"
                                )
                            ';
            }

            
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
                    $where      .= ' AND pm.created_on BETWEEN "'.$from_date.'" AND "'.$to_date.'"';
                }
                else if(!empty($from_date) && empty($to_date))
                {
                    $where      .= ' AND pm.modified_on >= "'.$from_date.'"';
                }
                else if(empty($from_date) && !empty($to_date))
                {
                    $where      .= ' AND pm.modified_on <= "'.$to_date.'"';
                }

            }
            if(!empty($like_sql))
            {
                $where          .= ' '.$like_sql;
            }

            if(isset($_GET['order']) && !empty($_GET['order']) && isset($_GET['sort']) && !empty($_GET['sort']))
            {
                if($_GET['sort'] == 'ownid')
                {
                    $sort_by = 'pm.ownid';
                }
                else if($_GET['sort'] == 'mobile')
                {
                    $sort_by = 'ud.mobile';
                }
                else if($_GET['sort'] == 'panno')
                {
                    $sort_by = 'ud.panno';
                }
                else if($_GET['sort'] == 'accountno')
                {
                    $sort_by = 'ud.accountno';
                }
                else if($_GET['sort'] == 'ifsccode')
                {
                    $sort_by = 'ud.ifsccode';
                }
                else if($_GET['sort'] == 'commission')
                {
                    $sort_by = 'pm.commission';
                }
                else if($_GET['sort'] == 'tds')
                {
                    $sort_by = 'pm.tds';
                }
                else if($_GET['sort'] == 'admin')
                {
                    $sort_by = 'pm.admin';
                }
                else
                {
                    $sort_by = 'pm.id';
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
                $order       = 'pm.id DESC';
            }

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



            $this->db->select('pm.*,ud.firstname,ud.midname,ud.lastname,ud.mobile,ud.panno,ud.ifsccode,ud.accountno');
            $this->db->from($this->table_payout_monthly.' pm');
            $this->db->join($this->table_userdetails.' ud', 'ud.ownid = pm.ownid', 'left');
            $this->db->where($conditions);
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



        function pay($id,$date)
        {
            $update['active']           = 1;
            $update['modified_on']      = $date;
            $this->db->where('id', $id);
            $this->db->update($this->table_payout_monthly, $update);

            return $this->db->affected_rows();
        }

       

        //////////////////////////////////////////////////////////////////////////////////////////////

        function get_payout($conditions=[], $limit='', $offset=0, $allcount='')
        {
            $order          = '';
            $where          = '1=1';
            $like_sql       = '';
            $limit_offset   = '';

            if(isset($_GET['search']) && !empty($_GET['search']) && $_GET['search'] != 'undefined')
            {
                $term       = $_GET['search'];
                $like_sql   = 'AND
                                (
                                    ud.firstname LIKE "%'.$term.'%" ESCAPE "!"
                                    OR ud.midname LIKE "%'.$term.'%" ESCAPE "!"
                                    OR ud.lastname LIKE "%'.$term.'%" ESCAPE "!"
                                    OR ud.ownid LIKE "%'.$term.'%" ESCAPE "!"
                                    OR ud.mobile LIKE "%'.$term.'%" ESCAPE "!"
                                    OR ud.panno LIKE "%'.$term.'%" ESCAPE "!"
                                )
                            ';
            }

            
            if(isset($_GET['custom_search']) && !empty($_GET['custom_search']))
            {
                $from_date      = '';
                $to_date        = '';
                $payout         = isset($_GET['custom_search']['payout']) ? $_GET['custom_search']['payout'] : '';
                $income         = isset($_GET['custom_search']['income']) ? $_GET['custom_search']['income'] : '';

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
                    $where      .= ' AND dc.date BETWEEN "'.$from_date.'" AND "'.$to_date.'"';
                }
                else if(!empty($from_date) && empty($to_date))
                {
                    $where      .= ' AND dc.date >= "'.$from_date.'"';
                }
                else if(empty($from_date) && !empty($to_date))
                {
                    $where      .= ' AND dc.date <= "'.$to_date.'"';
                }
                if($payout != '')
                {
                    $where      .= ' AND dc.active IN ('.implode(',', $payout).')';
                }
                if($income != '')
                {
                    $where      .= ' AND dc.remark = "'.$income.'"';
                }

            }
            if(!empty($like_sql))
            {
                $where          .= ' '.$like_sql;
            }

            if(isset($_GET['order']) && !empty($_GET['order']) && isset($_GET['sort']) && !empty($_GET['sort']))
            {
                if($_GET['sort'] == 'ownid')
                {
                    $sort_by    = 'dc.ownid';
                }
                else if($_GET['sort'] == 'mobile')
                {
                    $sort_by    = 'ud.mobile';
                }
                else if($_GET['sort'] == 'panno')
                {
                    $sort_by    = 'ud.panno';
                }
                else if($_GET['sort'] == 'amount')
                {
                    $sort_by    = 'dc.amount';
                }
                else if($_GET['sort'] == 'by_ownid')
                {
                    $sort_by    = 'dc.by_ownid';
                }
                else
                {
                    $sort_by    = 'dc.id';
                }

                if(isset($_GET['order']) && !empty($_GET['order']))
                {
                    $by     = $_GET['order'];
                }
                else
                {
                    $by     = 'DESC';
                }
                $order      = $sort_by.' '.$by;
            } 
            else
            {
                $order      = 'dc.id DESC';
            }

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



            $this->db->select('dc.*,ud.firstname,ud.midname,ud.lastname,ud.mobile,ud.panno');
            $this->db->from($this->table_direct_comm.' dc');
            $this->db->join($this->table_userdetails.' ud', 'ud.ownid = dc.ownid', 'left');
            $this->db->where($conditions);
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


            if($allcount == 'allcount')
            {
                return $query->num_rows();
            }
            else
            {
                return $query->result();
            }
        }

        function get_ownid($id)
        {
            $this->db->select('ownid');
            $this->db->from($this->table_franchise);
            $this->db->where('id',$id);
            $query = $this->db->get();
            return $query->row_array();
        }
    }
?>