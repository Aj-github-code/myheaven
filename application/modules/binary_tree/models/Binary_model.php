<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Binary_model extends CI_Model
    {
        private $table_useroption       = binary_table::sql_useroption;
		private $table_userdetails      = binary_table::sql_userdetails;
        private $table_pinreference     = binary_table::sql_tbl_pinreferencetable;
        private $table_franchise        = binary_table::sql_tbl_franchise;


        public function __construct()
        {
            parent::__construct();
        }

        function get_data($userid)
        {
           $this->db->select('leftmember,rightmember');
           $this->db->from($this->table_useroption);
           $this->db->where('ownid',$userid);
           $query = $this->db->get();
           return $query->row_array();
        }

        function get_direct($userid)
        {
            $this->db->select('ownid');
            $this->db->from($this->table_useroption);
            $this->db->where('sponsorid',$userid);
            $query = $this->db->get();
            return $query->result_array();
        }

        function get_user($userid)
        {
            $this->db->select('*');
            $this->db->from($this->table_useroption);
            $this->db->where('ownid',$userid);
            $query = $this->db->get();
            return $query->row_array();
        }

        function get_pin($userid)
        {
            $this->db->select('pin');
            $this->db->from($this->table_useroption);
            $this->db->where('ownid',$userid);
            $query = $this->db->get();
            return $query->row_array();
        }
      
        function get_pinreference($userid)
        {
            $this->db->select('totalleft,totalright,totalunitleft,totalunitright');
            $this->db->from($this->table_pinreference);
            $this->db->where('ownid',$userid);
            $query = $this->db->get();
            return $query->row_array();
        }
        function get_details($userid)
        {
            $this->db->select('*');
            $this->db->from($this->table_useroption.' uo');
            $this->db->join($this->table_userdetails.' ud',' ud.ownid = uo.ownid ', 'left');
            $this->db->where('uo.ownid',$userid);
            $query = $this->db->get();
            return $query->row_array();
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