<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Forgot_password_model extends CI_Model
    {
        private $table_users                = signin_table::sql_tbl_users;
        private $table_user_ip_blacklist    = signin_table::sql_tbl_user_ip_blacklist;

        public function __construct()
        {
            parent::__construct();
            $this->search = '';
        }

        function get_user_data($type, $paramvalue) {
            if($type == 'email')
            {
                $this->db->where('email', $paramvalue);
            }
            else
            {
                $this->db->where('mobile', $paramvalue);
            }
            $this->db->where('status !=', '-1');
            $query=$this->db->get($this->table_users);
            return $query->row_array();
        }

        function update_user_table($id, $data) {
            $this->db->where('id', $id);
            $this->db->update($this->table_users, $data);
            return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
        }
    }