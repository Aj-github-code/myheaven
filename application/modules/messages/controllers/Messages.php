<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Messages extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('messages_model', 'messages');
        }

        function index()
        {
            $data['meta_title']             = "Messages";
            $data['meta_description']       = "Messages";
            $data['meta_keywords']          = "Messages";
            $data['page_title']             = "Messages";
            $data['module']                 = "Messages";
            $data['menu']                   = "messages";
            $data['submenu']                = "list";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->push(1, 'Messages', messages_constants::messages_url);
            $this->breadcrumbs->unshift(2, 'List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "messages/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function ajax_list()
        {
            $condition          = ['n.type' => 'franchise', 'n.user_id' => $this->session->userdata('user_id'), 'n.status' => 1];
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

                $seenstatus     = '';
                if(!empty($value->news_seen_id))
                {
                    $seenstatus = '<span class="badge badge-success">Seen</span>';
                }
                else
                {
                    $seenstatus = '<span class="badge badge-warning">Not Seen</span>';
                }

                $action         = '
                                    <span class="d-flex justify-content-center">
                                        <a class="" title="View" href="'.base_url().messages_constants::view_message_url.'/'.$value->id.'"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    </span>
                                ';

                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['id']                                      = $value->id;
                $row['description']                             = $value->description;
                $row['seenstatus']                              = $seenstatus;
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

        function view($id='')
        {
            $response = ['error' => 1, 'message' => 'Invalid request'];
            if(!empty($id))
            {
                $data['meta_title']         = "View Message";
                $data['meta_description']   = "View Message";
                $data['meta_keywords']      = "View Message";
                $data['page_title']         = "View Message";
                $data['module']             = "Messages";
                $data['menu']               = "messages";
                $data['submenu']            = "list";
                $data['childmenu']          = "";
                $data['loggedin']           = "yes";
                $data['id']                 = $id;
                $data['post_data']          = [];

                $data['post_data']          = $this->messages->get_details($id);
                $news_seen                  = $this->messages->get_news_seen($id);
                
                if(empty($news_seen))
                {
                    $this->messages->save_news_seen($id, 'franchise');
                }

                if(empty($data['post_data']))
                {
                    $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Message not found']);
                    redirect(base_url().messages_constants::messages_url);
                }

                $this->breadcrumbs->push(1, 'Messages', messages_constants::messages_url);
                $this->breadcrumbs->unshift(2, 'Edit', '#');
                $data['breadcrumb']          = $this->breadcrumbs->show();

                $data['content']            = "messages/view";
                echo Modules::run("templates/".$this->config->item('theme'), $data);
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().messages_constants::messages_url);
            }
        }
    }