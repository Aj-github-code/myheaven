<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Profile_model extends CI_Model
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

        function save($post_data=[])
        {
            $response                       = ['error' => 1, 'message' => 'Invalid request'];

            if(!empty($post_data))
            {
                $id                         = $this->session->userdata('user_id');
                $save                       = [];
                $save['franchise_name']     = htmlentities($post_data['franchise_name']);
                $save['your_name']          = htmlentities($post_data['your_name']);
                $save['email']              = htmlentities(strtolower($post_data['email']));
                $save['mobile']             = htmlentities(strtolower($post_data['mobile']));
                $save['type']               = htmlentities($post_data['type']);
                $save['dob']                = htmlentities(strtolower($post_data['dob']));
                $save['telephone']          = htmlentities(strtolower($post_data['telephone']));
                $save['pincode']            = htmlentities(strtolower($post_data['pincode']));
                $save['address']            = $post_data['address'];
                $save['pan']                = htmlentities($post_data['pan']);
                $save['gst']                = htmlentities($post_data['gst']);
                $save['trade_license_no']   = htmlentities($post_data['trade_license_no']);
                $save['bank_account']       = htmlentities($post_data['bank_account']);
                $save['bank_name']          = $post_data['bank_name'];
                $save['branch_name']        = $post_data['branch_name'];
                $save['ifsc_code']          = $post_data['ifsc_code'];
                $save['modified_on']        = date('Y-m-d H:i:s');
                $save['modified_by']        = $this->session->userdata('user_id');

                $this->db->where('id', $id);
                $this->db->update($this->table_users, $save);

                if($this->db->affected_rows())
                {
                    $user                   = $this->db->get_where($this->table_users, ['id =' => $id])->row_array();
                    $response               = ['error' => 0, 'message' => 'Profile successfully saved', 'user' => $user];
                }
                else
                {
                    $response               = ['error' => 1, 'message' => 'Unable to save profile'];
                }
            }
            return $response;
        }

        function update_avatar($profile_pic)
        {
            $response = ['error' => 1, 'message' => 'Invalid request'];

            if(!empty($profile_pic))
            {
                $id                     = $this->session->userdata('user_id');
                $update                 = [];
                $update['profile_pic']  = $profile_pic;
                $update['modified_on']  = date('Y-m-d H:i:s');
                $update['modified_by']  = $this->session->userdata('user_id');

                $this->db->where('id', $id);
                $this->db->update($this->table_users, $update);

                if($this->db->affected_rows())
                {
                    $response           = ['error' => 0, 'message' => 'Avatar successfully saved'];
                }
                else
                {
                    $response           = ['error' => 1, 'message' => 'Unable to save avatar'];
                }
            }
            return $response;
        }

        function check_unique($conditions=[])
        {
            $this->db->select('*');
            $this->db->from($this->table_users);
            if(!empty($conditions))
            {
                foreach ($conditions as $key => $value) {
                    $this->db->where($key, $value);
                }
            }
            $query = $this->db->get();
            if(!empty($query->row_array()))
            {
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
    }