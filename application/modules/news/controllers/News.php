<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class News extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('news_model', 'news');
        }

        function index()
        {
            $data['meta_title']             = "News";
            $data['meta_description']       = "News";
            $data['meta_keywords']          = "News";
            $data['page_title']             = "News";
            $data['module']                 = "News";
            $data['menu']                   = "news";
            $data['submenu']                = "list";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->push(1, 'News', news_constants::news_url);
            $this->breadcrumbs->unshift(2, 'List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "news/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function ajax_list()
        {
            $condition          = ['n.type' => 'all', 'n.status' => 1];
            $list               = $this->news->get_data($condition, '', '', '');
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
                                        <a class="" title="View" href="'.base_url().news_constants::view_news_url.'/'.$value->id.'"><i class="fa fa-eye" aria-hidden="true"></i></a>
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
                                        "total"      => $this->news->get_data($condition, '', '', 'allcount'),
                                        "rows"       => $tabledata,
                                    );

            echo json_encode($output);
        }

        function view($id='')
        {
            $response = ['error' => 1, 'message' => 'Invalid request'];
            if(!empty($id))
            {
                $data['meta_title']         = "View News";
                $data['meta_description']   = "View News";
                $data['meta_keywords']      = "View News";
                $data['page_title']         = "View News";
                $data['module']             = "News";
                $data['menu']               = "news";
                $data['submenu']            = "list";
                $data['childmenu']          = "";
                $data['loggedin']           = "yes";
                $data['id']                 = $id;
                $data['post_data']          = [];

                $data['post_data']          = $this->news->get_details($id);
                $news_seen                  = $this->news->get_news_seen($id);
                
                if(empty($news_seen))
                {
                    $this->news->save_news_seen($id, 'all');
                }

                if(empty($data['post_data']))
                {
                    $this->session->set_flashdata('status', ['error' => 1, 'message' => 'News not found']);
                    redirect(base_url().news_constants::news_url);
                }

                $this->breadcrumbs->push(1, 'News', news_constants::news_url);
                $this->breadcrumbs->unshift(2, 'Edit', '#');
                $data['breadcrumb']          = $this->breadcrumbs->show();

                $data['content']            = "news/view";
                echo Modules::run("templates/".$this->config->item('theme'), $data);
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().news_constants::news_url);
            }
        }

        function mark_seen($type)
        {
            if($type == 'news' || $type == 'messages')
            {
                $this->news->mark_seen($type);
                $this->session->set_flashdata('status', ['error' => 0, 'message' => 'Marked all read']);
                redirect(base_url().dashboard_constants::dashboard_url);
            }
        }
    }