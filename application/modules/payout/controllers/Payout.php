<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Payout extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
             $this->load->model('Payout_model', 'payout');
            //exit("ssss");

        }

        function index()
        {
            $data['meta_title']             = "Payout";
            $data['meta_description']       = "Payout";
            $data['meta_keywords']          = "Payout";
            $data['page_title']             = "Payout";
            $data['module']                 = "payout";
            $data['menu']                   = "payout";
            $data['submenu']                = "list";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->unshift(1, 'Payout', payout_constants::payout_url);
            $this->breadcrumbs->unshift(2, 'List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();
            $data['content']                = "payout/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function ajax_list()
        {
            $condition          = ['c.status !' => '-1', 'c.user_id' => $this->session->userdata('user_id')];
            $list               = $this->payout->get_data($condition, '', '', '');
            $tabledata          = [];
            $no                 = isset($_GET['offset']) ? $_GET['offset'] : 0;
             $payment_type= $this->config->item('payment_type');
                                        //$this->config->item('1', 'payment_type');//1st key from array

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
                $customer_id    = $value->id;

                if($value->status == 1)
                {
                    $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$customer_id.', 0, this);" data-type="customer" data-function="'.base_url().payout_constants::change_payout_status_url.'"><span class="badge badge-success">Active</span></a>';
                }
                else if($value->status == 0)
                {
                    $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$customer_id.', 1, this);" data-type="customer" data-function="'.base_url().payout_constants::change_payout_status_url.'"><span class="badge badge-danger">In-Active</span></a>';
                }
 

                $view   = '<a class="" href="'.base_url().payout_constants::edit_payout_url.'/'.$value->id.'" title="Edit '.$value->id.'">'.$value->id.'</a>';

                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['id']                                      = $value->id;
                $row['name']                                    = $view;
                $row['by_ownid']                                = $value->by_ownid;
                $row['amount']                                  = $value->amount;
                $row['payout_type']                             = ($payment_type[$value->payout_type] !="") ? $payment_type[$value->payout_type] : "NA";
                $row['remark']                                  = $value->remark;
                $row['status']                                  = $status;
                $row['created_on']                              = $created_on;
             
                $tabledata[]                                    = $row;
            }

            $output             = array(
                                        "total"      => $this->payout->get_data($condition, '', '', 'allcount'),
                                        "rows"       => $tabledata,
                                    );

            echo json_encode($output);
        }

        private function form_validation_rules($data=[])
        {
            $this->form_validation->set_rules('member_id', 'Member Id', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('name', 'Name', 'required|max_length[191]|trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('mobile', 'Mobile No', 'required|max_length[10]|trim|xss_clean|strip_tags|callback_custom_mobile[mobile]|callback_unique_mobile[mobile]');
            $this->form_validation->set_rules('email', 'Email', 'required|max_length[50]|trim|xss_clean|strip_tags|callback_custom_email[email]|callback_unique_email[email]');
            if(isset($_POST['pincode']) && !empty($_POST['pincode']))
            {
                $this->form_validation->set_rules('pincode', 'Pincode', 'min_length[6]|max_length[6]trim|xss_clean|strip_tags');
            }
            $this->form_validation->set_rules('address', 'Address', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('status', 'Status', 'required|trim|xss_clean|strip_tags');
        }

        function add()
        {
            $data['meta_title']             = "Add payout";
            $data['meta_description']       = "Add payout";
            $data['meta_keywords']          = "Add payout";
            $data['page_title']             = "Add payout";
            $data['module']                 = "payout";
            $data['menu']                   = "payout";
            $data['submenu']                = "add";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";
            $data['id']                     = "";
            $data['post_data']              = [];
            $data['post_data']['status']    = 1;


            $this->form_validation_rules($data);

            if($this->input->post())
            {
                $data['post_data']          = $this->input->post();
            }  

            if($this->form_validation->run($this) === TRUE)
            {
                if($this->input->post())
                {
                    $response               = $this->save('', $this->security->xss_clean($this->input->post()));
                    $this->session->set_flashdata('status', $response);
                    redirect(base_url().payout_constants::payout_url);
                }
            }

            $this->breadcrumbs->unshift(1, 'payout', payout_constants::payout_url);
            $this->breadcrumbs->unshift(2, 'Add', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "payout/form";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function edit($id='')
        {
            $response = ['error' => 1, 'message' => 'Invalid request'];

            if(!empty($id))
            {
                $data['meta_title']         = "Edit Customer";
                $data['meta_description']   = "Edit Customer";
                $data['meta_keywords']      = "Edit Customer";
                $data['page_title']         = "Edit Customer";
                $data['module']             = "payout";
                $data['menu']               = "payout";
                $data['submenu']            = "add";
                $data['childmenu']          = "";
                $data['loggedin']           = "yes";
                $data['id']                 = $id;
                $data['post_data']          = [];

                $this->form_validation_rules($data);

                if($this->form_validation->run($this) === TRUE)
                {
                    if($this->input->post())
                    {
                        $response           = $this->save($id, $this->security->xss_clean($this->input->post()));
                        $this->session->set_flashdata('status', $response);
                        redirect(base_url().payout_constants::payout_url);
                    }
                }

                if($this->input->post())
                {
                    $data['post_data']      = $this->input->post();
                }
                else
                {
                    $data['post_data']      = $this->payout->get_details($id);

                    if(empty($data['post_data']))
                    {
                        $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Customer not found']);
                        redirect(base_url().payout_constants::payout_url);
                    }
                }

                $this->breadcrumbs->unshift(1, 'Customer', payout_constants::payout_url);
                $this->breadcrumbs->unshift(2, 'Edit', '#');
                $data['breadcrumb']          = $this->breadcrumbs->show();

                $data['content']            = "payout/form";
                echo Modules::run("templates/".$this->config->item('theme'), $data);
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().payout_constants::payout_url);
            }
        }

        private function save($id, $post_data)
        {
            $response                                   = ['error' => 1, 'message' => 'Access denied'];

            if(!empty($post_data))
            {
                $save['member_id']                      = htmlentities($post_data['member_id']);
                $save['name']                           = htmlentities($post_data['name']);
                $save['email']                          = htmlentities($post_data['email']);
                $save['mobile']                         = htmlentities($post_data['mobile']);
                $save['pincode']                        = htmlentities($post_data['pincode']);
                $save['address']                        = $post_data['address'];
                $save['status']                         = htmlentities($post_data['status']);

                if(empty($id))
                {
                    if(isset($post_data['password']) && !empty($post_data['password']))
                    {
                        $password                       = $post_data['password'];
                    }
                    else
                    {
                        $password                       = $this->common_lib->generatePassword();
                    }

                    $save['user_id']                    = $this->session->userdata('user_id');
                    $save['password']                   = password_hash($password, PASSWORD_DEFAULT);
                    $save['created_on']                 = date('Y-m-d H:i:s');
                    $save['created_by']                 = $this->session->userdata('user_id');

                    $response                           = $this->payout->save($id, $save);
                    if($response['error'] == 0 && empty($id))
                    {
                        $save['password']               = $password;
                    }
                }
                else
                {
                    $save['modified_on']                = date('Y-m-d H:i:s');
                    $save['modified_by']                = $this->session->userdata('user_id');
                    $response                           = $this->payout->save($id, $save);
                }
            }
            return $response;
        }

        function change()
        {
            $response       = ['error' => 1, 'message' => 'Invalid request'];

            if(isset($_POST) && !empty($_POST))
            {
                $id         = isset($_POST['id']) ? $_POST['id'] : '';
                $type       = isset($_POST['type']) ? $_POST['type'] : '';
                $status     = isset($_POST['status']) ? $_POST['status'] : '';

                $details    = $this->payout->get_details($id);

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

                    if($this->payout->change($id, $status))
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

        function check_unique_mobile()
        {
            if($this->input->post())
            {
                $result = $this->unique_mobile($this->input->post('mobile'), '');
                echo $result;exit;
            }
        }

        function check_unique_email()
        {
            if($this->input->post())
            {
                $result = $this->unique_email($this->input->post('email'), '');
                echo $result;exit;
            }
        }

        function unique_mobile($str, $func)
        {
            $id             = '';
            $conditions     = ['status !=' => '-1', 'mobile' => $str, 'user_id' => $this->session->userdata('user_id')];

            if(isset($_POST['id']) && !empty($_POST['id']))
            {
                $conditions = ['status !=' => '-1', 'mobile' => $str, 'id !=' => $_POST['id'], 'user_id' => $this->session->userdata('user_id')];
            }

            $this->form_validation->set_message('unique_mobile', 'Mobile already exist');
            $result         = $this->payout->check_unique($conditions);
            return $result;
        }

        function unique_email($str, $func)
        {
            $id             = '';
            $conditions     = ['status !=' => '-1', 'email' => $str, 'user_id' => $this->session->userdata('user_id')];

            if(isset($_POST['id']) && !empty($_POST['id']))
            {
                $conditions = ['status !=' => '-1', 'email' => $str, 'id !=' => $_POST['id'], 'user_id' => $this->session->userdata('user_id')];
            }

            $this->form_validation->set_message('unique_email', 'Email already exist');
            $result         = $this->payout->check_unique($conditions);
            return $result;
        }
    }
?>