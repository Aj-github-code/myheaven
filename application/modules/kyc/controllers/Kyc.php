<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Kyc extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('kyc_model', 'kyc');
        }

        function index()
        {
            $data['meta_title']             = "Kyc";
            $data['meta_description']       = "Kyc";
            $data['meta_keywords']          = "Kyc";
            $data['page_title']             = "Kyc";
            $data['module']                 = "Kyc";
            $data['menu']                   = "kyc";
            $data['submenu']                = "list";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $data['kyc_status']             = $this->data['user_data']['kyc_status'];
            $data['kyc_message']            = $this->data['user_data']['kyc_message'];
            $data['kyc_status_class']       = 'alert-success';

            if($data['kyc_status'] == 'pending' || $data['kyc_status'] == 'rejected')
            {
                $data['kyc_status_class']   = 'alert-danger';
            }

            $this->breadcrumbs->unshift(1, 'Kyc', kyc_constants::kyc_url);
            $this->breadcrumbs->unshift(2, 'List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "kyc/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function ajax_list()
        {
            $condition                      = ['k.user_id' => $this->session->userdata('user_id'), 'k.status !' => '-1'];
            $list                           = $this->kyc->get_data($condition, '', '', '');
            $tabledata                      = [];
            $no                             = isset($_GET['offset']) ? $_GET['offset'] : 0;
            foreach ($list as $key => $value) {
                if(isset($value->created_on) && !empty($value->created_on) && $value->created_on !== '0000-00-00 00:00:00')
                {
                    $created_on             = date($this->config->item('default_date_time_format'), strtotime($value->created_on));
                }
                else
                {
                    $created_on             = 'NA';
                }

                $status                     = '';
                $kyc_id                     = $value->id;

                if($value->status == 1)
                {
                    $status                 = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$kyc_id.', 0, this);" data-type="kyc" data-function="'.base_url().kyc_constants::change_kyc_status_url.'"><span class="badge badge-success">Active</span></a>';
                }
                else if($value->status == 0)
                {
                    $status                 = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$kyc_id.', 1, this);" data-type="kyc" data-function="'.base_url().kyc_constants::change_kyc_status_url.'"><span class="badge badge-danger">In-Active</span></a>';
                }

                $action                     = '
                                                <span class="dropdown action-dropdown d-flex justify-content-center">
                                                    <button id="btnSearchDrop'.$key.'" type="button" class="btn btn-sm btn-icon btn-pure font-medium-2" data-toggle="dropdown" aria-haspopup="true"
                                                     aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <span aria-labelledby="btnSearchDrop'.$key.'" class="dropdown-menu dropdown-menu-right">';
                                                        $action .= '<a class="dropdown-item" title="Edit" href="'.base_url().kyc_constants::edit_kyc_url.'/'.$kyc_id.'">Edit</a>';
                                                        $action .= '<a class="dropdown-item" title="Delete" href="javascript:void(0);" onclick="change_status('.$kyc_id.', -1, this);" data-type="kyc" data-function="'.base_url().kyc_constants::change_kyc_status_url.'">Delete</a>';
                                                        $action .= '</span>
                                                </span>
                                            ';

                $view                       = '<a class="" href="'.base_url().kyc_constants::edit_kyc_url.'/'.$kyc_id.'" title="Edit '.ucfirst($value->type).'">'.ucfirst($value->type).'</a>';
                $file                       = '<a class="" href="'.content_url($value->file).'" target="_blank">'.basename(parse_url($value->file, PHP_URL_PATH)).'</a>';

                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['id']                                      = $kyc_id;
                $row['file']                                    = $file;
                $row['type']                                    = $view;
                $row['kyc_status']                              = ucfirst($value->kyc_status);
                $row['status']                                  = $status;
                $row['created_on']                              = $created_on;
                $row['action']                                  = $action;
            
                $tabledata[]                                    = $row;
            }

            $output                         = array(
                                                "total"      => $this->kyc->get_data($condition, '', '', 'allcount'),
                                                "rows"       => $tabledata,
                                            );

            echo json_encode($output);
        }

        private function form_validation_rules($data=[])
        {
            $this->form_validation->set_rules('type', 'Type', 'required|trim|xss_clean|strip_tags');
            if (empty($_FILES['file']['name']))
            {
                if(empty($data['id']))
                {
                    $this->form_validation->set_rules('file', 'File', 'required');
                }
            }
            $this->form_validation->set_rules('status', 'Status', 'required|trim|xss_clean|strip_tags');
        }

        function add()
        {
            $data['meta_title']             = "Add Kyc";
            $data['meta_description']       = "Add Kyc";
            $data['meta_keywords']          = "Add Kyc";
            $data['page_title']             = "Add Kyc";
            $data['module']                 = "Kyc";
            $data['menu']                   = "kyc";
            $data['submenu']                = "add";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";
            $data['id']                     = "";
            $data['post_data']              = [];
            $data['post_data']['status']    = 1;


            $this->form_validation_rules($data);

            if($this->input->post())
            {
                $data['post_data']          = $this->input->post();
            }  

            if($this->form_validation->run($this) === TRUE)
            {
                if($this->input->post())
                {
                    $response               = $this->save('', $this->security->xss_clean($this->input->post()));
                    $this->session->set_flashdata('status', $response);
                    redirect(base_url().kyc_constants::kyc_url);
                }
            }

            $this->breadcrumbs->unshift(1, 'Kyc', kyc_constants::kyc_url);
            $this->breadcrumbs->unshift(2, 'Add', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "kyc/form";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function edit($id='')
        {
            if(!empty($id))
            {
                $data['meta_title']         = "Edit Kyc";
                $data['meta_description']   = "Edit Kyc";
                $data['meta_keywords']      = "Edit Kyc";
                $data['page_title']         = "Edit Kyc";
                $data['module']             = "Kyc";
                $data['menu']               = "kyc";
                $data['submenu']            = "add";
                $data['childmenu']          = "";
                $data['loggedin']           = "yes";
                $data['id']                 = $id;
                $data['post_data']          = [];

                $this->form_validation_rules($data);

                if($this->form_validation->run($this) === TRUE)
                {
                    if($this->input->post())
                    {
                        $response           = $this->save($id, $this->security->xss_clean($this->input->post()));
                        $this->session->set_flashdata('status', $response);
                        redirect(base_url().kyc_constants::kyc_url);
                    }
                }

                if($this->input->post())
                {
                    $data['post_data']      = $this->input->post();
                }
                else
                {
                    $data['post_data']      = $this->kyc->get_details($id);

                    if(empty($data['post_data']))
                    {
                        $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Kyc not found']);
                        redirect(base_url().kyc_constants::kyc_url);
                    }
                }

                $this->breadcrumbs->unshift(1, 'Kyc', kyc_constants::kyc_url);
                $this->breadcrumbs->unshift(2, 'Edit', '#');
                $data['breadcrumb']          = $this->breadcrumbs->show();

                $data['content']             = "kyc/form";
                echo Modules::run("templates/".$this->config->item('theme'), $data);
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().kyc_constants::kyc_url);
            }
        }

        private function save($id, $post_data)
        {
            $response                                   = ['error' => 1, 'message' => 'Invalid request'];

            if(!empty($post_data))
            {
                if(isset($_FILES['file']) && !empty($_FILES['file']))
                {
                    $upload_data                        = Modules::run("file_management/file/upload", ['path' => ['files', 'documents']]);
                    if(isset($upload_data['file']) && !empty($upload_data['file']))
                    {
                        $save['file']                   = $upload_data['file'];
                    }
                }

                $save['type']                           = htmlentities($post_data['type']);
                $save['kyc_status']                     = 'pending';
                $save['reason']                         = '';
                $save['status']                         = htmlentities($post_data['status']);

                if(empty($id))
                {
                    $save['user_id']                    = $this->session->userdata('user_id');
                    $save['created_on']                 = date('Y-m-d H:i:s');
                    $save['created_by']                 = $this->session->userdata('user_id');
                    $response                           = $this->kyc->save($id, $save);
                }
                else
                {
                    $save['modified_on']                = date('Y-m-d H:i:s');
                    $save['modified_by']                = $this->session->userdata('user_id');
                    $response                           = $this->kyc->save($id, $save);
                }
            }
            return $response;
        }

        function change()
        {
            $response       = ['error' => 1, 'message' => 'Invalid request'];

            if(isset($_POST) && !empty($_POST))
            {
                $id         = isset($_POST['id']) ? $_POST['id'] : '';
                $type       = isset($_POST['type']) ? $_POST['type'] : '';
                $status     = isset($_POST['status']) ? $_POST['status'] : '';

                $details    = $this->kyc->get_details($id);

                if(!empty($details))
                {
                    if($status == '-1')
                    {
                        $message = 'deleted';
                    }
                    else if($status == 1)
                    {
                        $message = 'activated';
                    }
                    else if($status == 0)
                    {
                        $message = 'in-activated';
                    }

                    if($this->kyc->change($id, $status))
                    {
                        $response   = ['error' => 0, 'message' => ucfirst($type).' successfully '.$message];
                    }
                    else
                    {
                        $response   = ['error' => 1, 'message' => 'Unable to perform this action'];
                    }
                }
                else
                {
                    $response   = ['error' => 1, 'message' => 'No '.$type.' found'];
                }
            }
            echo json_encode($response);
        }
    }
?>