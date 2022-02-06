<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Payouts extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('accounts_model', 'accounts');
        }

        function index()
        {
            $data['meta_title']             = "Payout Income";
            $data['meta_description']       = "Payout Income";
            $data['meta_keywords']          = "Payout Income";
            $data['page_title']             = "Payout Income";
            $data['module']                 = "Payout Income";
            $data['menu']                   = "Payout Income";
            $data['submenu']                = "payout";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->unshift(1, 'Payout', accounts_constants::payouts_records_url);
            $this->breadcrumbs->unshift(2, 'List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "accounts/payout";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function get_user()
        {

            $id         = $this->session->userdata('user_id');
            if(!empty($id))
            {
                $userid = $this->accounts->get_ownid($id);
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

        function ajax_list()
        {
            $ownid              = $this->get_user();
            $condition          = 'ud.ownid = "'.$ownid.'"';
            $list               = $this->accounts->get_payout($condition, '', '', '');
            $no                 = isset($_GET['offset']) ? $_GET['offset'] : 0;

            foreach ($list as $key => $value) {

                $ownid          = $value->ownid;
                $id             = $value->id;
                if($value->active == 1)
                {
                    $active     = '<a class="text-black"><span class="badge badge-success">Paid</span></a>';
                }
                else if($value->active == 0)
                {
                    $active     = '<a class="text-black"><span class="badge badge-danger">Un-Paid</span></a>';
                }

                $no++;
                $row                         = [];
                $row['sr_no']                = $no;
                $row['name']                 = $value->firstname.' '.$value->lastname;
                $row['ownid']                = $value->ownid;
                $row['mobile']               = $value->mobile;
                $row['panno']                = $value->panno;
                $row['by_ownid']             = $value->by_ownid;
                $row['remark']               = $value->remark;
                $row['date']                 = $value->date;
                $row['amount']               = $value->amount;
                $row['active']               = $active;
            
                $tabledata[]                 = $row;
            }

            $output     = array(
                                "total"      => $this->accounts->get_payout($condition, '', '', 'allcount'),
                                "rows"       => $tabledata,
                            );

            echo json_encode($output);
        }
    }
?>