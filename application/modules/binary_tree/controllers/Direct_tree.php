<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Direct_tree extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('binary_model', 'binary');
        }
        function direct_tree()
        {
            $data['meta_title']             = "Direct tree";
            $data['meta_description']       = "Direct tree";
            $data['meta_keywords']          = "Direct tree";
            $data['page_title']             = "Direct tree";
            $data['module']                 = "Direct tree";
            $data['menu']                   = "Direct tree";
            $data['submenu']                = "d_tree";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->unshift(1, 'Direct tree', binary_constants::direct_tree_url);
            $this->breadcrumbs->unshift(2, 'Tree', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $user       = $_GET['userid'];
            if(!empty($user))
            {
                $data['d_private_id']       =  $user;
            }
            else{
                $data['d_private_id']       = $this->get_user();
            }
            $data['d_user']                 = $this->binary->get_user($data['d_private_id']);
            $data['d_lists']                = $this->binary->get_direct($data['d_private_id']);
            $data['d_type']                 = $this->get_type($data['d_lists']);
            $data['d_details']              = $this->get_userdetails($data['d_lists']);

           
            $data['content']                = "binary_tree/direct_tree";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }


        function get_user()
        {

            $id         = $this->session->userdata('user_id');
            if(!empty($id))
            {
                $userid         = $this->binary->get_ownid($id);
                if(!empty($userid))
                {
                    $response   = ['error' => 0, 'message' => 'User data found'];
                    $this->session->set_flashdata('status', $response);
                }
                else{
                    $response   = ['error' => 1, 'message' => 'User data not found'];
                    $this->session->set_flashdata('status', $response);
                }
            }
            return $userid['ownid'];
        }


        function get_type($data)
        {
            foreach($data as $key => $value)
            {
               
                $pin             = $this->binary->get_pin($value['ownid']);
                $pins[$value['ownid']]      = $pin['pin'];  
            }
            return $pins;
        }
        function get_userdetails($data)
        {
            foreach($data as $key => $userid){

                $pin            = $this->binary->get_pinreference($userid['ownid']);
                $totalleft      = $pin['totalleft'];
                $totalright     = $pin['totalright'];
                
                $totalunitleft  = $pin['totalunitleft'];
                $totalunitright = $pin['totalunitright'];
                $total          = $totalleft + $totalright;
                $list           = $this->binary->get_details($userid['ownid']);
                
                $pin_msg        = (!empty($list['pin'])) ? $list['pin'] : "Not Active";
                $sponsor        = $list['sponsorid'];
                $table          = "<table width=300 border=0 cellpadding=5 z-index=100 cellspacing=1 bgcolor=#CCCCCC>
                <tr><td width=120px height=10px bgcolor=#336699><font color=#FFFFFF><strong>User Name:</strong></font></td><td width=180px height=10px bgcolor=#336699><font color=#FFFFFF>". ucwords($list['firstname']) . " " . ucwords($list['lastname']) ."</font></td></tr>
                <tr><td width=120px height=10px bgcolor=#336699><font color=#FFFFFF><strong>DOJ:</strong></font></td><td width=180px height=10px bgcolor=#336699><font color=#FFFFFF>".$list['createddate']."</font></td></tr>
                <tr><td width=120px height=10px bgcolor=#336699><font color=#FFFFFF><strong>Sponsor :</strong></font></td><td width=180px height=10px bgcolor=#336699><font color=#FFFFFF>".strtoupper($sponsor)."</font></td></tr>
                
                <tr><td width=120px height=10px bgcolor=#336699><font color=#FFFFFF><strong>User:</strong></font></td><td width=180px height=10px bgcolor=#336699><font color=#FFFFFF>".$totalleft.":".$totalright."</font></td></tr>
                
                <tr><td width=120px height=10px bgcolor=#336699><font color=#FFFFFF><strong>Left/Right </strong></font></td><td width=180px height=10px bgcolor=#336699><font color=#FFFFFF>".$totalunitleft."/".$totalunitright."</font></td></tr>
                
                <tr><td width=120px height=10px bgcolor=#336699><font color=#FFFFFF><strong>Package:</strong></font></td><td width=180px height=10px bgcolor=#336699><font color=#FFFFFF>".$pin_msg."</font></td></tr></table>";
                $output[$userid['ownid']] = $table;
            }    
            return $output;
        }
    }
    ?>