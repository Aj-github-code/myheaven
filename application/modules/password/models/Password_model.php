<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Password_model extends CI_Model
    {
        private $table_users                = signin_table::sql_tbl_users;

        public function __construct()
        {
            parent::__construct();
        }

        function get_user_data() {
            $this->db->where('id', $this->session->userdata('user_id'));
            $this->db->where('status !=', '-1');
            $query=$this->db->get($this->table_users);
            return $query->row_array();
        }

        function update($update=[])
        {
            $response = ['error' => 1, 'message' => 'Invalid request'];

            if(!empty($update))
            {
                $this->db->where('id', $this->session->userdata('user_id'));
                $this->db->update($this->table_users, $update);

                if($this->db->affected_rows())
                {
                    $response = ['error' => 0, 'message' => 'Password successfully changed'];
                }
                else
                {
                    $response = ['error' => 1, 'message' => 'Unable to change password'];
                }
            }
            return $response;
        }
    }