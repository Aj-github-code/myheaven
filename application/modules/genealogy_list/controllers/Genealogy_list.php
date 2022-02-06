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
            $data['meta_title']             = "Left member";
            $data['meta_description']       = "Left member";
            $data['meta_keywords']          = "Left member";
            $data['page_title']             = "Left member";
            $data['module']                 = "Left member";
            $data['menu']                   = "left member";
            $data['submenu']                = "l_list";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->unshift(1, 'Genealogy', genealogy_constants::left_member_url);
            $this->breadcrumbs->unshift(2, 'Genealogy List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

        
            $data['content']                = "genealogy_list/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function right_member()
        {

            $data['meta_title']             = "Right member";
            $data['meta_description']       = "Right member";
            $data['meta_keywords']          = "Right member";
            $data['page_title']             = "Right member";
            $data['module']                 = "Right member";
            $data['menu']                   = "right member";
            $data['submenu']                = "r_list";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->unshift(1, 'Genealogy', genealogy_constants::right_member_url);
            $this->breadcrumbs->unshift(2, 'Right list', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "genealogy_list/right_list";
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

        function get_user()
        {

            $id = $this->session->userdata('user_id');
            if(!empty($id))
            {
                $userid = $this->genealogy->get_ownid($id);
                if(!empty($userid))
                {
                    $response = ['error' => 0, 'message' => 'User data found'];
                    $this->session->set_flashdata('status', $response);
                }
                else{
                    $response = ['error' => 1, 'message' => 'User data not found'];
                    $this->session->set_flashdata('status', $response);
                }
            }
            return $userid['ownid'];
        }

        function left_list()
        {  
            $condition          = 'uo.placement = "leftmember"';
            $ownid              = $this->get_user();
            $conditions         = $this->get_list($ownid,$condition);
            $list               = $this->genealogy->get_data($conditions, '', '', '');
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
                                        "total"      => $this->genealogy->get_data($conditions, '', '', 'allcount'),
                                        "rows"       => $tabledata,
                                    );

            echo json_encode($output);
        }

        function right_list()
        {  
            $condition               = 'uo.placement = "leftmember"';
            $ownid                   = $this->get_user();
            $conditions              = $this->get_list($ownid['ownid'],$condition);
            $list                    = $this->genealogy->get_data($conditions,'', '', '');
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
                                            "total"      => $this->genealogy->get_data($conditions, '', '', 'allcount'),
                                            "rows"       => $tabledata,
                                         );

            echo json_encode($output);
        }

        function my_directs_list()
        {
            $ownid                   = $this->get_user();
            $condition               = 'uo.sponsorid = "'.$ownid['ownid'].'"';
            $list                    = $this->genealogy->get_direct($condition, '', '', '');
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
                                            "total"      => $this->genealogy->get_direct($condition, '', '', 'allcount'),
                                            "rows"       => $tabledata,
                                         );

            echo json_encode($output);
        }

     
        function get_list($userid,$condition)
        {
            $list                    = $this->genealogy->get_user($userid,$condition);
            foreach ($list as $key => $value) {
                $data = $this->search_member($value->ownid);
            }
            return $data;
        }

        function search_member($userid)
        {
            $ownid_Array             = array();
            $ownid_Array[]           =$userid;
            $list = $this->genealogy->search_user($userid);
            foreach ($list as $key => $value) {
                if(!empty($value->ownid)){
                    $ownid_Array     = array_merge($ownid_Array, $this->search_member($value->ownid));
                }
            }
            return $ownid_Array;
    
        }
    }
?>