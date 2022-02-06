<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Payouts_records extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('accounts_model', 'accounts');
        }

        function index()
        {
            $data['meta_title']             = "Payout records";
            $data['meta_description']       = "Payout records";
            $data['meta_keywords']          = "Payout records";
            $data['page_title']             = "Payout records";
            $data['module']                 = "Payout records";
            $data['menu']                   = "Payout records";
            $data['submenu']                = "payout_records";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->unshift(1, 'Payout records', accounts_constants::payouts_records_url);
            $this->breadcrumbs->unshift(2, 'List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "accounts/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function get_user()
        {

            $id = $this->session->userdata('user_id');
            if(!empty($id))
            {
                $userid = $this->accounts->get_ownid($id);
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
        function ajax_list()
        {
            $ownid                   = $this->get_user();
            $condition               = 'ud.ownid = "'.$ownid.'"';
            $list                    = $this->accounts->get_data($condition, '', '', '');
            $no                      = isset($_GET['offset']) ? $_GET['offset'] : 0;

            foreach ($list as $key => $value) {

                $ownid               = $value->ownid;
                $id                  = $value->id;
                if($value->active == 1)
                {
                    $active          = '<a class="text-black"><span class="badge badge-success">Paid</span></a>';
                }
                else if($value->active == 0)
                {
                   
                    $active          = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$id.', 1, this);" data-type="accounts" data-function="'.base_url().accounts_constants::payouts_records_update_url.'"><span class="badge badge-danger">Click to Pay</span></a>';
                }

                $no++;
                $row                        = [];
                $row['sr_no']               = $no;
                $row['ownid']               = $value->ownid;
                $row['mobile']              = $value->mobile;
                $row['panno']               = $value->panno;
                $row['commission']          = $value->commission;
                $row['tds']                 = $value->tds;
                $row['admin']               = $value->admin;
                $row['payable_amt']         = $value->payable_amt;
                $row['name']                = $value->firstname.' '.$value->lastname;
                $row['accountno']           = $value->accountno;
                $row['ifsccode']            = $value->ifsccode;
                $row['modified_on']         = $value->modified_on;
                $row['active']              = $active;
            
                $tabledata[]                = $row;
            }

            $output     = array(
                                "total"     => $this->accounts->get_data($condition, '', '', 'allcount'),
                                "rows"      => $tabledata,
                            );

            echo json_encode($output);
        }

        function update()
        {
            $response           = ['error' => 1, 'message' => 'Invalid request'];

            if(isset($_POST) && !empty($_POST))
            {
                $id             = isset($_POST['id']) ? $_POST['id'] : '';
                $date           = date("Y-m-d h:s:i");
                

                if($this->accounts->pay($id,$date))
                {
                    $response   = ['error' => 0, 'message' => 'Payment successfully '];
                }
                else
                {
                    $response   = ['error' => 1, 'message' => 'Unable to perform this action'];
                }
              
            }
            echo json_encode($response);
        }
        
    }
?>