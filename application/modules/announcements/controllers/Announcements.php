<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Announcements extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('announcements_model', 'announcements');
        }

        function index()
        {
            $data['meta_title']             = "Announcements";
            $data['meta_description']       = "Announcements";
            $data['meta_keywords']          = "Announcements";
            $data['page_title']             = "Announcements";
            $data['module']                 = "Announcements";
            $data['menu']                   = "announcements";
            $data['submenu']                = "list";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->push(1, 'Announcements', announcements_constants::announcements_url);
            $this->breadcrumbs->unshift(2, 'List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "announcements/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function ajax_list()
        {
            $condition          = ['a.status' => 1];
            $list               = $this->announcements->get_data($condition, '', '', '');
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

                $action = '
                            <span class="d-flex justify-content-center">
                                <a class="" title="View" href="'.base_url().announcements_constants::view_announcement_url.'/'.$value->id.'"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </span>
                        ';

                $view   = '<a class="" href="'.base_url().announcements_constants::view_announcement_url.'/'.$value->id.'" title="Edit '.$value->title.'">'.$value->title.'</a>';

                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['id']                                      = $value->id;
                $row['title']                                   = $view;
                $row['description']                             = $value->description;
                $row['created_on']                              = $created_on;
                $row['action']                                  = $action;
            
                $tabledata[]                                    = $row;
            }

            $output             = array(
                                        "total"      => $this->announcements->get_data($condition, '', '', 'allcount'),
                                        "rows"       => $tabledata,
                                    );

            echo json_encode($output);
        }

        function view($id='')
        {
            $response = ['error' => 1, 'message' => 'Invalid request'];
            if(!empty($id))
            {
                $data['meta_title']         = "View Announcement";
                $data['meta_description']   = "View Announcement";
                $data['meta_keywords']      = "View Announcement";
                $data['page_title']         = "View Announcement";
                $data['module']             = "Announcements";
                $data['menu']               = "announcements";
                $data['submenu']            = "list";
                $data['childmenu']          = "";
                $data['loggedin']           = "yes";
                $data['id']                 = $id;
                $data['post_data']          = [];

                $data['post_data']          = $this->announcements->get_details($id);
                $announcements_seen         = $this->announcements->get_announcements_seen($id);
                
                if(empty($announcements_seen))
                {
                    $this->announcements->save_announcements_seen($id);
                }

                $this->breadcrumbs->push(1, 'Announcements', announcements_constants::announcements_url);
                $this->breadcrumbs->unshift(2, 'View', '#');
                $data['breadcrumb']         = $this->breadcrumbs->show();

                $data['content']            = "announcements/view";
                echo Modules::run("templates/".$this->config->item('theme'), $data);
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().announcements_constants::announcements_url);
            }
        }
    }