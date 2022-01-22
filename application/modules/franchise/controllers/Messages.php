<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Messages extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('messages_model', 'messages');
        }

        function index($franchise_id)
        {
            $data['meta_title']             = "Messages";
            $data['meta_description']       = "Messages";
            $data['meta_keywords']          = "Messages";
            $data['page_title']             = "Messages";
            $data['module']                 = "Messages";
            $data['menu']                   = "franchise";
            $data['submenu']                = "list";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";
            $data['franchise_id']           = $franchise_id;

            $this->breadcrumbs->push(1, 'Messages', franchise_constants::messages_url.'/'.$franchise_id);
            $this->breadcrumbs->unshift(2, 'List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "franchise/messages/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function ajax_list()
        {
            $franchise_id       = $_GET['custom_search']['franchise_id'];
            $condition          = ['n.user_id' => $_GET['custom_search']['franchise_id'], 'n.type' => 'franchise', 'n.status !' => '-1'];
            $list               = $this->messages->get_data($condition, '', '', '');
            $tabledata          = [];
            $no                 = isset($_GET['offset']) ? $_GET['offset'] : 0;

            foreach ($list as $key => $value) {
                if(isset($value->created_on) && !empty($value->created_on) && $value->created_on !== '0000-00-00 00:00:00')
                {
                    $created_on = date($this->config->item('default_date_time_format'), strtotime($value->created_on));
                }
                else
                {
                    $created_on = 'NA';
                }

                $status         = '';
                if($value->status == 1)
                {
                    $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$value->id.', 0, this);" data-type="message" data-function="'.base_url().franchise_constants::change_message_status_url.'"><span class="badge badge-success">Active</span></a>';
                }
                else if($value->status == 0)
                {
                    $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$value->id.', 1, this);" data-type="message" data-function="'.base_url().franchise_constants::change_message_status_url.'"><span class="badge badge-danger">In-Active</span></a>';
                }

                $action = '
                            <span class="dropdown action-dropdown d-flex justify-content-center">
                                <button id="btnSearchDrop'.$key.'" type="button" class="btn btn-sm btn-icon btn-pure font-medium-2" data-toggle="dropdown" aria-haspopup="true"
                                 aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <span aria-labelledby="btnSearchDrop'.$key.'" class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" title="Edit" href="'.base_url().franchise_constants::edit_message_url.'/'.$franchise_id.'/'.$value->id.'">Edit</a>
                                    <a class="dropdown-item" title="Delete" href="javascript:void(0);" onclick="change_status('.$value->id.', -1, this);" data-type="message" data-function="'.base_url().franchise_constants::change_message_status_url.'">Delete</a>
                                </span>
                            </span>
                        ';

                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['id']                                      = $value->id;
                $row['description']                             = $value->description;
                $row['status']                                  = $status;
                $row['created_on']                              = $created_on;
                $row['action']                                  = $action;
            
                $tabledata[]                                    = $row;
            }

            $output             = array(
                                        "total"      => $this->messages->get_data($condition, '', '', 'allcount'),
                                        "rows"       => $tabledata,
                                    );

            echo json_encode($output);
        }

        private function form_validation_rules($data=[])
        {
            $this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('status', 'Status', 'required');
        }

        function add($franchise_id)
        {
            $data['meta_title']             = "Add Message";
            $data['meta_description']       = "Add Message";
            $data['meta_keywords']          = "Add Message";
            $data['page_title']             = "Add Message";
            $data['module']                 = "Messages";
            $data['menu']                   = "franchise";
            $data['submenu']                = "list";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";
            $data['id']                     = "";
            $data['post_data']              = [];
            $data['post_data']['status']    = 1;
            $data['franchise_id']           = $franchise_id;

            $this->form_validation_rules($data);

            if($this->input->post())
            {
                $data['post_data']          = $this->input->post();
            }

            if($this->form_validation->run($this) === TRUE)
            {
                if($this->input->post())
                {
                    $response               = $this->messages->save($franchise_id, '', $this->security->xss_clean($this->input->post()));
                    $this->session->set_flashdata('status', $response);
                    redirect(base_url().franchise_constants::messages_url.'/'.$franchise_id);
                }
            }

            $this->breadcrumbs->push(1, 'Messages', franchise_constants::messages_url.'/'.$franchise_id);
            $this->breadcrumbs->unshift(2, 'Add', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "franchise/messages/form";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function edit($franchise_id, $id)
        {
            $response = ['error' => 1, 'message' => 'Invalid request'];
            if(!empty($id))
            {
                $data['meta_title']         = "Edit Message";
                $data['meta_description']   = "Edit Message";
                $data['meta_keywords']      = "Edit Message";
                $data['page_title']         = "Edit Message";
                $data['module']             = "Messages";
                $data['menu']               = "franchise";
                $data['submenu']            = "list";
                $data['childmenu']          = "";
                $data['loggedin']           = "yes";
                $data['id']                 = $id;
                $data['post_data']          = [];
                $data['franchise_id']       = $franchise_id;

                $this->form_validation_rules($data);

                if($this->form_validation->run($this) === TRUE)
                {
                    if($this->input->post())
                    {
                        $response           = $this->messages->save($franchise_id, $id, $this->security->xss_clean($this->input->post()));
                        $this->session->set_flashdata('status', $response);
                        redirect(base_url().franchise_constants::messages_url.'/'.$franchise_id);
                    }
                }

                if($this->input->post())
                {
                    $data['post_data']      = $this->input->post();
                }
                else
                {
                    $data['post_data']      = $this->messages->get_details($id);

                    if(empty($data['post_data']))
                    {
                        $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Message not found']);
                        redirect(base_url().franchise_constants::messages_url.'/'.$franchise_id);
                    }
                }

                $this->breadcrumbs->push(1, 'Messages', franchise_constants::messages_url.'/'.$franchise_id);
                $this->breadcrumbs->unshift(2, 'Edit', '#');
                $data['breadcrumb']          = $this->breadcrumbs->show();

                $data['content']             = "franchise/messages/form";
                echo Modules::run("templates/".$this->config->item('theme'), $data);
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().franchise_constants::franchise_url);
            }
        }

        function change()
        {
            $response       = ['error' => 1, 'message' => 'Access denied'];

            if(isset($_POST) && !empty($_POST))
            {
                $id         = isset($_POST['id']) ? $_POST['id'] : '';
                $type       = isset($_POST['type']) ? $_POST['type'] : '';
                $status     = isset($_POST['status']) ? $_POST['status'] : '';

                $details    = $this->messages->get_details($id);

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

                    if($this->messages->change($id, $status))
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