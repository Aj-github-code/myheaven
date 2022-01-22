<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Genealogy_list extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('genealogy_model', 'genealogy');
        }

        function index()
        {
            $data['meta_title']             = "Genealogy list";
            $data['meta_description']       = "Genealogy list";
            $data['meta_keywords']          = "Genealogy list";
            $data['page_title']             = "Genealogy list";
            $data['module']                 = "Genealogy list";
            $data['menu']                   = "genealogy list";
            $data['submenu']                = "g_list";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->unshift(1, 'Genealogy', genealogy_constants::genealogy_url);
            $this->breadcrumbs->unshift(2, 'Genealogy List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "genealogy_list/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function my_directs()
        {

            $data['meta_title']             = "Direct list";
            $data['meta_description']       = "Direct list";
            $data['meta_keywords']          = "Direct list";
            $data['page_title']             = "Direct list";
            $data['module']                 = "Direct list";
            $data['menu']                   = "direct list";
            $data['submenu']                = "d_list";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->unshift(1, 'Genealogy', genealogy_constants::my_directs_url);
            $this->breadcrumbs->unshift(2, 'Genealogy List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "genealogy_list/direct_list";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }


        function left_list()
        {  
            $condition          = 'uo.placement = "leftmember"';
            $list               = $this->genealogy->get_data($condition, '', '', '');
            $no                 = isset($_GET['offset']) ? $_GET['offset'] : 0;
            foreach ($list as $key => $value) {
                if(isset($value->createddate) && !empty($value->createddate) && $value->createddate !== '0000-00-00 00:00:00')
                {
                    $createddate = date($this->config->item('default_date_time_format'), strtotime($value->createddate));
                }
                else
                {
                    $createddate = 'NA';
                }

                $status         = '';
                if($value->status == 0)
                {
                    $status     = '<a class="text-black" href="javascript:void(0);"><span class="badge badge-success">Active</span></a>';
                }
                else if($value->status == 1)
                {
                    $status     = '<a class="text-black" href="javascript:void(0);"><span class="badge badge-danger">In-Active</span></a>';
                }
                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['ownid']                                   = $value->ownid;
                $row['firstname']                               = $value->firstname.' '.$value->lastname.' '.$value->midname;
                $row['pin']                                     = $value->pin;
                $row['status']                                  = $status;
                $row['pin_date']                                = $value->pin_date;
                $row['date']                                    = $value->date;
                $row['sponsorid']                               = $value->sponsorid;
                $row['createddate']                             = $createddate;
           
                $tabledata[]                                    = $row;
            }

            $output             = array(
                                        "total"      => $this->genealogy->get_data($condition, '', '', 'allcount'),
                                        "rows"       => $tabledata,
                                    );

            echo json_encode($output);
        }

        function right_list()
        {  
            $condition               = 'uo.placement = "rightmember"';
            $list                    = $this->genealogy->get_data($condition, '', '', '');
            $no                      = isset($_GET['offset']) ? $_GET['offset'] : 0;
            foreach ($list as $key => $value) {
                if(isset($value->createddate) && !empty($value->createddate) && $value->createddate !== '0000-00-00 00:00:00')
                {
                    $createddate     = date($this->config->item('default_date_time_format'), strtotime($value->createddate));
                }
                else
                {
                    $createddate     = 'NA';
                }

                $status              = '';
                if($value->status == 0)
                {
                    $status          = '<a class="text-black" href="javascript:void(0);"><span class="badge badge-success">Active</span></a>';
                }
                else if($value->status == 1)
                {
                    $status          = '<a class="text-black" href="javascript:void(0);"><span class="badge badge-danger">In-Active</span></a>';
                }
                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['ownid']                                   = $value->ownid;
                $row['firstname']                               = $value->firstname.' '.$value->lastname.' '.$value->midname;
                $row['pin']                                     = $value->pin;
                $row['status']                                  = $status;
                $row['pin_date']                                = $value->pin_date;
                $row['date']                                    = $value->date;
                $row['sponsorid']                               = $value->sponsorid;
                $row['createddate']                             = $createddate;
           
                $tabledata[]                                    = $row;
            }

            $output                  = array(
                                            "total"      => $this->genealogy->get_data($condition, '', '', 'allcount'),
                                            "rows"       => $tabledata,
                                         );

            echo json_encode($output);
        }

        function my_directs_list()
        {
            $condition               = 'uo.sponsorid = "ROOT"';
            $list                    = $this->genealogy->get_data($condition, '', '', '');
            $no                      = isset($_GET['offset']) ? $_GET['offset'] : 0;
            foreach ($list as $key => $value) {
                if(isset($value->createddate) && !empty($value->createddate) && $value->createddate !== '0000-00-00 00:00:00')
                {
                    $createddate     = date($this->config->item('default_date_time_format'), strtotime($value->createddate));
                }
                else
                {
                    $createddate     = 'NA';
                }

                $status              = '';
                if($value->status == 0)
                {
                    $status          = '<a class="text-black" href="javascript:void(0);"><span class="badge badge-success">Active</span></a>';
                }
                else if($value->status == 1)
                {
                    $status          = '<a class="text-black" href="javascript:void(0);"><span class="badge badge-danger">In-Active</span></a>';
                }
                $no++;
                $row                                            = [];
                $row['pin']                                     = $value->pin;
                $row['sr_no']                                   = $no;
                $row['ownid']                                   = $value->ownid;
                $row['status']                                  = $status;
                $row['pin_date']                                = $value->pin_date;
                $row['sponsorid']                               = $value->sponsorid;
                $row['firstname']                               = $value->firstname.' '.$value->lastname.' '.$value->midname;
                $row['placement']                               = $value->placement;
                $row['placementid']                             = $value->placementid;
                $row['createddate']                             = $createddate;
           
                $tabledata[]                                    = $row;
            }
            $output                  = array(
                                            "total"      => $this->genealogy->get_data($condition, '', '', 'allcount'),
                                            "rows"       => $tabledata,
                                         );

            echo json_encode($output);
        }

     
    }
?>