<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Support_model extends CI_Model
    {
        private $table_support      = supports_table::sql_support_request;

        public function __construct()
        {
            parent::__construct();
        }
        function save($id='', $save_data=[])
        {
            $response         = ['error' => 1, 'message' => 'Invalid request'];

            if(!empty($save_data))
            {
                if(!empty($id))
                {
                    $this->db->where('id', $id);
                    $this->db->update($this->table_support, $save_data);
                }
                else
                {
                    $this->db->insert($this->table_support, $save_data);
                    $id       = $this->db->insert_id();
                }

                if($this->db->affected_rows())
                {
                    // $this->set_kyc_pending();
                    $response = ['error' => 0, 'message' => 'Support successfully requested'];
                }
                else
                {
                    $response = ['error' => 1, 'message' => 'Unable to request support.'];
                }
            }
            return $response;
        }
    }
