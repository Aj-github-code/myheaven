<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Binary_tree extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('binary_model', 'binary');
        }

        function index()
        {
            $data['meta_title']             = "Binary tree";
            $data['meta_description']       = "Binary tree";
            $data['meta_keywords']          = "Binary tree";
            $data['page_title']             = "Binary tree";
            $data['module']                 = "Binary tree";
            $data['menu']                   = "binary tree";
            $data['submenu']                = "b_tree";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->unshift(1, 'Binary tree', binary_constants::binary_tree_url);
            $this->breadcrumbs->unshift(2, 'Tree', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            
            if(!empty($_GET['userid']))
            {
                $user                       = $_GET['userid'];
                $userid                     = base64_decode($user);
                $data['b_lists']            = $this->check_left_right($userid);
            }
            else{
                $userid                     = $this->get_user();
                $data['b_lists']            = $userid;
            }
            
          
            
            $data['b_type']                 = $this->get_type($data['b_lists']);
            $data['b_details']              = $this->get_userdetails($data['b_lists']);
            
            
            $data['content']                = "binary_tree/form";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        
        function get_user()
        {

            $id               = $this->session->userdata('user_id');
            if(!empty($id))
            {
                $userid       = $this->binary->get_ownid($id);
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

        function get_left_right($userid)
        {
            $userid                         = strtoupper($userid);
            $rowlevel11                     = $this->binary->get_data($userid);
            $lt11                           = $rowlevel11['leftmember'];
            $rt11                           = $rowlevel11['rightmember'];

            $rowlevel21                     = $this->binary->get_data($lt11);
            $lt21                           = $rowlevel21['leftmember'];
            $rt21                           = $rowlevel21['rightmember'];

            $rowlevel22                     = $this->binary->get_data($rt11);
            $lt22                           = $rowlevel22['leftmember'];
            $rt22                           = $rowlevel22['rightmember'];

            $list                           = array(
                'userid'     => $userid,
                'lt11'       => $lt11,
                'lt21'       => $lt21,
                'lt22'       => $lt22,
                'rt11'       => $rt11,
                'rt21'       => $rt21,
                'rt22'       => $rt22,
            );
           return $list;

        }

        function check_left_right($userid)
        {

            $check                          = $this->get_left_right($userid);
            if(empty($check['rt11']) && empty($check['lt11']))
            {
                $response                   = ['error' => 1, 'message' => 'No more user'];
                $this->session->set_flashdata('status', $response);
                header("location:javascript://history.go(-1)");
            }
            else
            {
                $data                       = $check;
            }
            return $data;
            
        }
        function get_type($data)
        {            
            foreach($data as $row)
            {
                $pin                        = $this->binary->get_pin($row);
                $pins[$row]                 = $pin['pin'];      
             
            }
            return $pins;
        }
        function get_userdetails($data)
        {
            foreach($data as $userid){
                $pin                        = $this->binary->get_pinreference($userid);
                $totalleft                  = $pin['totalleft'];
                $totalright                 = $pin['totalright'];
                
                $totalunitleft              = $pin['totalunitleft'];
                $totalunitright             = $pin['totalunitright'];
                $total                      = $totalleft + $totalright;
                
                $list                       = $this->binary->get_details($userid);
                
                $pin_msg                    = (!empty($list['pin'])) ? $list['pin'] : "Not Active";
                $sponsor                    = $list['sponsorid'];
                $table                      = "<table width=300 border=0 cellpadding=5 z-index=100 cellspacing=1 bgcolor=#CCCCCC>
                <tr><td width=120px height=10px bgcolor=#336699><font color=#FFFFFF><strong>User Name:</strong></font></td><td width=180px height=10px bgcolor=#336699><font color=#FFFFFF>". ucwords($list['firstname']) . " " . ucwords($list['lastname']) ."</font></td></tr>
                <tr><td width=120px height=10px bgcolor=#336699><font color=#FFFFFF><strong>DOJ:</strong></font></td><td width=180px height=10px bgcolor=#336699><font color=#FFFFFF>".$list['createddate']."</font></td></tr>
                <tr><td width=120px height=10px bgcolor=#336699><font color=#FFFFFF><strong>Sponsor :</strong></font></td><td width=180px height=10px bgcolor=#336699><font color=#FFFFFF>".strtoupper($sponsor)."</font></td></tr>
                
                <tr><td width=120px height=10px bgcolor=#336699><font color=#FFFFFF><strong>User:</strong></font></td><td width=180px height=10px bgcolor=#336699><font color=#FFFFFF>".$totalleft.":".$totalright."</font></td></tr>
                
                <tr><td width=120px height=10px bgcolor=#336699><font color=#FFFFFF><strong>Left/Right </strong></font></td><td width=180px height=10px bgcolor=#336699><font color=#FFFFFF>".$totalunitleft."/".$totalunitright."</font></td></tr>
                
                <tr><td width=120px height=10px bgcolor=#336699><font color=#FFFFFF><strong>Package:</strong></font></td><td width=180px height=10px bgcolor=#336699><font color=#FFFFFF>".$pin_msg."</font></td></tr></table>";
                $output[$userid]            = $table;
            }    
            return $output;
        }
       
    }
?>