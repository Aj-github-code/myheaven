<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Gallery_images_model extends CI_Model
    {
        private $table_images       = Gallery_table::sql_tbl_images;
        private $table_videos       = Gallery_table::sql_tbl_videos;

        public function __construct()
        {
            parent::__construct();
        }

        function get_data($limit='', $offset=0, $allcount='')
        {
            $search = isset($_POST['search']) ? $_POST['search'] : '';

            $this->db->select('i.*');
            $this->db->from($this->table_images.' i');
            $this->db->where('i.status !=', '-1');

            if(!empty($search))
            {
                $this->db->like('i.name', $search, 'both');
            }

            // Order
            $this->db->order_by('i.id', 'DESC');

            // Limit
            if($allcount != 'allcount')
            {
                $this->db->limit($limit, $offset);
            }
            
            $query = $this->db->get();

            // echo "<pre>";print_r($this->db->last_query());exit;

            if($allcount == 'allcount')
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
            $this->db->select('i.*');
            $this->db->from($this->table_images.' i');
            $this->db->where('i.id', $id);
            $this->db->where('i.status !=', '-1');
            
            $query = $this->db->get();
            return $query->row_array();
        }

        function save($id='', $post_data=[])
        {
            $msg = ['error' => 1, 'message' => 'Invalid request'];

            if(!empty($post_data))
            {
                if(isset($_FILES['file']) && !empty($_FILES['file']))
                {
                    $upload_data                        = Modules::run("file_management/image/upload", ['path' => ['uploads', date('Ymd')]]);
                    if(isset($upload_data['image']) && !empty($upload_data['image']))
                    {
                        $save['image']                  = $upload_data['image'];
                    }
                }

                $save['name']                           = htmlentities($post_data['image_name']);
                $save['status']                         = 1;
                $save['modified_on']                    = date('Y-m-d H:i:s');
                $save['modified_by']                    = $this->session->userdata('user_id');

                if(!empty($id))
                {
                    $this->db->where('id', $id);
                    $this->db->update($this->table_images, $save);
                }
                else
                {
                    $save['created_on']                 = date('Y-m-d H:i:s');
                    $save['created_by']                 = $this->session->userdata('user_id');
                    $this->db->insert($this->table_images, $save);
                }

                if($this->db->affected_rows())
                {
                    $msg = ['error' => 0, 'message' => 'Image successfully uploaded'];
                }
                else
                {
                    $msg = ['error' => 1, 'message' => 'Unable to upload an image'];
                }
            }
            return $msg;
        }

        function save_image($name, $image)
        {
            $save                   = [];
            $save['name']           = $name;
            $save['image']          = $image;
            $save['status']         = 1;
            $save['created_on']     = date('Y-m-d H:i:s');
            $save['created_by']     = $this->session->userdata('user_id');
            $save['modified_on']    = date('Y-m-d H:i:s');
            $save['modified_by']    = $this->session->userdata('user_id');

            $this->db->insert($this->table_images, $save);

            if($this->db->affected_rows())
            {
                $msg                = ['error' => 0, 'message' => 'Image successfully uploaded'];
            }
            else
            {
                $msg                = ['error' => 1, 'message' => 'Unable to upload an image'];
            }
            return $msg;
        }

        function change($id='', $status)
        {
            $update['status']           = $status;
            $update['modified_on']      = date('Y-m-d H:i:s');
            $update['modified_by']      = $this->session->userdata('user_id');

            $this->db->where('id', $id);
            $this->db->update($this->table_images, $update);

            return $this->db->affected_rows();
        }
    }