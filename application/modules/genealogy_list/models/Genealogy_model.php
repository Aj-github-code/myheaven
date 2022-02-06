<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Genealogy_model extends CI_Model
    {
        private $table_userdetails       = genealogy_table::sql_userdetails;
        private $table_useroption        = genealogy_table::sql_useroption;
        private $table_franchise         = genealogy_table::sql_tbl_franchise;
        
        public function __construct()
        {
            parent::__construct();
        }
        
        function get_data($conditions, $limit, $offset, $allcount)
        {
            $order          = '';
            $where          = '1=1';
            $like_sql       = '';
            $limit_offset   = '';
        
            
            if(isset($_GET['search']) && !empty($_GET['search']) && $_GET['search'] != 'undefined')
            {
                $term       = $_GET['search'];
                $like_sql   = ' AND
                                (
                                    uo.ownid LIKE "%'.$term.'%" ESCAPE "!"
                                    OR uo.sponsorid LIKE "%'.$term.'%" ESCAPE "!"
                                    OR ud.firstname LIKE "%'.$term.'%" ESCAPE "!"
                                    OR ud.lastname LIKE "%'.$term.'%" ESCAPE "!"
                                )
                            ';
            }
            if(!empty($like_sql))
            {
                $where     .= ' '.$like_sql;
            }
            if(isset($_GET['order']) && !empty($_GET['order']) && isset($_GET['sort']) && !empty($_GET['sort']))
            {
                if($_GET['sort'] == 'createddate')
                {
                    $sort_by = 'uo.createddate';
                }
                else if($_GET['sort'] == 'firstname')
                {
                    $sort_by = 'uo.firstname';
                }
                else if($_GET['sort'] == 'ownid')
                {
                    $sort_by = 'uo.ownid';
                }
                else if($_GET['sort'] == 'date')
                {
                    $sort_by = 'uo.date';
                }
                else if($_GET['sort'] == 'sponsorid')
                {
                    $sort_by = 'uo.sponsorid';
                }
                else if($_GET['sort'] == 'pin_date')
                {
                    $sort_by = 'uo.pin_date';
                }
                else
                {
                    $sort_by = 'uo.id';
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
                $order       = 'uo.createddate DESC';
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

            if($allcount != 'allcount')
            {
                if($limit > 0 && $offset > 0)
                {
                    $limits =''.$limit.', offset '.$offset.'';
                }
                else
                {
                    if(!empty($limit))
                    {
                        $limits = ''.$limit.'';
                    }
                }
            }
            foreach($conditions as $id)
            {
                    $str="'".$id."'";
                    $ids[] =$str;
            }
                $query_string=implode(",",$ids);
            $sql_query="select uo.ownid,ud.firstname,ud.lastname,uo.sponsorid,uo.`date`,uo.createddate,uo.pin,uo.pin_date from useroption uo,userdetails ud  where uo.ownid=ud.ownid and ".$where." and uo.ownid in (".$query_string.") order by ".$order." limit 10";
            // print_r($sql_query);exit();
            $re_data = $this->db->query($sql_query);
            
            if($allcount == 'allcount')
            {
                return $re_data->num_rows();
            }
            else
            {
                return $re_data->result();
            }
            
        }
        function get_user($userid,$condition){
            $this->db->select('ownid');
            $this->db->from($this->table_useroption.' uo');
            $this->db->where('uo.placementid',$userid);
            $this->db->where($condition);
            $query = $this->db->get();
            return $query->result();
        }

        function search_user($userid)
        {
            $this->db->select('ownid');
            $this->db->from($this->table_useroption);
            $this->db->where('placementid',$userid);
            $query = $this->db->get();
            return $query->result();
        }

        function get_direct($conditions, $limit='', $offset=0, $allcount='')
        {
            $order          = '';
            $where          = '1=1';
            $like_sql       = '';
            $limit_offset   = '';
        
            
            if(isset($_GET['search']) && !empty($_GET['search']) && $_GET['search'] != 'undefined')
            {
                $term       = $_GET['search'];
                $like_sql   = ' AND
                                (
                                    uo.ownid LIKE "%'.$term.'%" ESCAPE "!"
                                    OR uo.sponsorid LIKE "%'.$term.'%" ESCAPE "!"
                                    OR ud.firstname LIKE "%'.$term.'%" ESCAPE "!"
                                    OR ud.lastname LIKE "%'.$term.'%" ESCAPE "!"
                                )
                            ';
            }
            if(!empty($like_sql))
            {
                $where      .= ' '.$like_sql;
            }
            if(isset($_GET['order']) && !empty($_GET['order']) && isset($_GET['sort']) && !empty($_GET['sort']))
            {
                if($_GET['sort'] == 'createddate')
                {
                    $sort_by = 'uo.createddate';
                }
                else if($_GET['sort'] == 'firstname')
                {
                    $sort_by = 'uo.firstname';
                }
                else if($_GET['sort'] == 'ownid')
                {
                    $sort_by = 'uo.ownid';
                }
                else if($_GET['sort'] == 'date')
                {
                    $sort_by = 'uo.date';
                }
                else if($_GET['sort'] == 'sponsorid')
                {
                    $sort_by = 'uo.sponsorid';
                }
                else if($_GET['sort'] == 'pin_date')
                {
                    $sort_by = 'uo.pin_date';
                }
                else
                {
                    $sort_by = 'uo.id';
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
                $order       = 'uo.createddate DESC';
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
            $this->db->select('*');
            $this->db->from($this->table_useroption.' uo');
            $this->db->join($this->table_userdetails.' ud', 'ud.ownid=uo.ownid','left');
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
            $query          = $this->db->get();

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