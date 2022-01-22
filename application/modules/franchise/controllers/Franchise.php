<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Franchise extends MY_Controller {

        function __construct() {
          

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

            parent::__construct();
           check_user_login(TRUE);
            
            $this->load->model('franchise_model', 'franchise'); 
            
            //exit("test");
        }

        function index()
        {
            $data['meta_title']             = "Franchise";
            $data['meta_description']       = "Franchise";
            $data['meta_keywords']          = "Franchise";
            $data['page_title']             = "Franchise";
            $data['module']                 = "Franchise";
            $data['menu']                   = "franchise";
            $data['submenu']                = "list";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->unshift(1, 'Franchise', franchise_constants::franchise_url);
            $this->breadcrumbs->unshift(2, 'List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "franchise/franchise/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function ajax_list()
        {
            $condition                      = ['f.status !' => '-1'];
            $list                           = $this->franchise->get_data($condition, '', '', '');
            $tabledata                      = [];
            $no                             = isset($_GET['offset']) ? $_GET['offset'] : 0;
            foreach ($list as $key => $value) {
                if(isset($value->created_on) && !empty($value->created_on) && $value->created_on !== '0000-00-00 00:00:00')
                {
                    $created_on             = date($this->config->item('default_date_time_format'), strtotime($value->created_on));
                }
                else
                {
                    $created_on             = 'NA';
                }

                $status                     = '';
                $franchise_id               = $value->id;

                if($value->status == 1)
                {
                    $status                 = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$franchise_id.', 0, this);" data-type="franchise" data-function="'.base_url().franchise_constants::change_franchise_status_url.'"><span class="badge badge-success">Active</span></a>';
                }
                else if($value->status == 0)
                {
                    $status                 = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$franchise_id.', 1, this);" data-type="franchise" data-function="'.base_url().franchise_constants::change_franchise_status_url.'"><span class="badge badge-danger">In-Active</span></a>';
                }

                $action                     = '
                                                <span class="dropdown action-dropdown d-flex justify-content-center">
                                                    <button id="btnSearchDrop'.$key.'" type="button" class="btn btn-sm btn-icon btn-pure font-medium-2" data-toggle="dropdown" aria-haspopup="true"
                                                     aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <span aria-labelledby="btnSearchDrop'.$key.'" class="dropdown-menu dropdown-menu-right">';
                                                        $action .= '<a class="dropdown-item" title="Edit" href="'.base_url().franchise_constants::edit_franchise_url.'/'.$value->id.'">Edit</a>';
                                                        $action .= '<a class="dropdown-item" title="Kyc" href="'.base_url().franchise_constants::manage_kyc_url.'/'.$value->id.'">Kyc</a>';
                                                        $action .= '<a class="dropdown-item" title="Kyc" href="'.base_url().franchise_constants::messages_url.'/'.$value->id.'">Messages</a>';
                                                        $action .= '<a class="dropdown-item" title="Delete" href="javascript:void(0);" onclick="change_status('.$value->id.', -1, this);" data-type="franchise" data-function="'.base_url().franchise_constants::change_franchise_status_url.'">Delete</a>';
                                                        $action .= '</span>
                                                </span>
                                            ';

                $view                       = '<a class="" href="'.base_url().franchise_constants::edit_franchise_url.'/'.$value->id.'" title="Edit '.$value->franchise_name.'">'.$value->franchise_name.'</a>';
                $kyc_status                 = '<a class="" href="'.base_url().franchise_constants::manage_kyc_url.'/'.$value->id.'" title="Kyc '.$value->franchise_name.'">'.ucfirst($value->kyc_status).'</a>';

                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['id']                                      = $value->id;
                $row['your_name']                               = $value->your_name;
                $row['franchise_code']                          = $value->franchise_code;
                $row['franchise_name']                          = $view;
                $row['type']                                    = $value->type;
                $row['email']                                   = $value->email;
                $row['mobile']                                  = $value->mobile;
                $row['telephone']                               = $value->telephone;
                $row['dob']                                     = $value->dob;
                $row['address']                                 = $value->address;
                $row['pincode']                                 = $value->pincode;
                $row['pan']                                     = $value->pan;
                $row['gst']                                     = $value->gst;
                $row['trade_license_no']                        = $value->trade_license_no;
                $row['bank_account']                            = $value->bank_account;
                $row['kyc_status']                              = $kyc_status;
                $row['kyc_message']                             = $value->kyc_message;
                $row['status']                                  = $status;
                $row['created_on']                              = $created_on;
                $row['action']                                  = $action;
            
                $tabledata[]                                    = $row;
            }

            $output                         = array(
                                                "total"      => $this->franchise->get_data($condition, '', '', 'allcount'),
                                                "rows"       => $tabledata,
                                            );

            echo json_encode($output);
        }

        private function form_validation_rules($data=[])
        {
            $this->form_validation->set_rules('sponsor_id', 'Sponsor Id', 'required|trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('your_name', 'Your Name', 'required|max_length[191]|trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('franchise_name', 'Franchise Name', 'required|max_length[191]|trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('type', 'Type', 'required|trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('mobile', 'Mobile No', 'required|max_length[10]|trim|xss_clean|strip_tags|callback_custom_mobile[mobile]|callback_unique_mobile[mobile]');
            $this->form_validation->set_rules('email', 'Email', 'required|max_length[50]|trim|xss_clean|strip_tags|callback_custom_email[email]|callback_unique_email[email]');
            $this->form_validation->set_rules('telephone', 'Telephone', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('dob', 'Dob', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('address', 'Address', 'trim|xss_clean|strip_tags');
            if(isset($_POST['pincode']) && !empty($_POST['pincode']))
            {
                $this->form_validation->set_rules('pincode', 'Pincode', 'max_length[6]|trim|xss_clean|strip_tags');
            }
            $this->form_validation->set_rules('pan', 'Pan', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('gst', 'Gst', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('trade_license_no', 'Trade License No', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('bank_account', 'Bank Account', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('ifsc_code', 'IFSC Code', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('status', 'Status', 'required|trim|xss_clean|strip_tags');
        }

        function add()
        {
            $data['meta_title']             = "Add Franchise";
            $data['meta_description']       = "Add Franchise";
            $data['meta_keywords']          = "Add Franchise";
            $data['page_title']             = "Add Franchise";
            $data['module']                 = "Franchise";
            $data['menu']                   = "franchise";
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
                    redirect(base_url().franchise_constants::franchise_url);
                }
            }

            $this->breadcrumbs->unshift(1, 'Franchise', franchise_constants::franchise_url);
            $this->breadcrumbs->unshift(2, 'Add', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "franchise/franchise/form";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function edit($id='')
        {
            if(!empty($id))
            {
                $data['meta_title']         = "Edit Franchise";
                $data['meta_description']   = "Edit Franchise";
                $data['meta_keywords']      = "Edit Franchise";
                $data['page_title']         = "Edit Franchise";
                $data['module']             = "Franchise";
                $data['menu']               = "franchise";
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
                        redirect(base_url().franchise_constants::franchise_url);
                    }
                }

                if($this->input->post())
                {
                    $data['post_data']      = $this->input->post();
                }
                else
                {
                    $data['post_data']      = $this->franchise->get_details($id);

                    if(empty($data['post_data']))
                    {
                        $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Franchise not found']);
                        redirect(base_url().franchise_constants::franchise_url);
                    }
                }

                $this->breadcrumbs->unshift(1, 'Franchise', franchise_constants::franchise_url);
                $this->breadcrumbs->unshift(2, 'Edit', '#');
                $data['breadcrumb']          = $this->breadcrumbs->show();

                $data['content']             = "franchise/franchise/form";
                echo Modules::run("templates/".$this->config->item('theme'), $data);
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().franchise_constants::franchise_url);
            }
        }
        
        public function new_pass(){
            $password="Admin@123";
            echo password_hash($password, PASSWORD_DEFAULT);

        }

        private function save($id, $post_data)
        {
            $response                                   = ['error' => 1, 'message' => 'Invalid request'];

            if(!empty($post_data))
            {
                $save['sponsor_id']                     = $post_data['sponsor_id'];
                $save['your_name']                      = htmlentities($post_data['your_name']);
                $save['franchise_name']                 = htmlentities($post_data['franchise_name']);
                $save['type']                           = htmlentities($post_data['type']);
                $save['email']                          = htmlentities($post_data['email']);
                $save['mobile']                         = htmlentities($post_data['mobile']);
                $save['telephone']                      = htmlentities($post_data['telephone']);
                $save['dob']                            = htmlentities($post_data['dob']);
                $save['address']                        = $post_data['address'];
                $save['pincode']                        = htmlentities($post_data['pincode']);
                $save['pan']                            = htmlentities($post_data['pan']);
                $save['gst']                            = htmlentities($post_data['gst']);
                $save['trade_license_no']               = htmlentities($post_data['trade_license_no']);
                $save['bank_account']                   = htmlentities($post_data['bank_account']);
                $save['bank_name']                      = $post_data['bank_name'];
                $save['branch_name']                    = $post_data['branch_name'];
                $save['ifsc_code']                      = $post_data['ifsc_code'];
                $save['status']                         = htmlentities($post_data['status']);
                $save['modified_on']                    = date('Y-m-d H:i:s');
                $save['modified_by']                    = $this->session->userdata('user_id');

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

                    $franchise_code                     = $this->common_lib->generateUniqueColumnCode(franchise_table::sql_table_franchise, 'franchise_code', 'MYHEAVEN', 6);

                    $save['franchise_code']             = $franchise_code;
                    $save['password']                   = password_hash($password, PASSWORD_DEFAULT);
                    $save['kyc_status']                 = 'pending';
                    $save['kyc_message']                = 'Please add kyc documents';
                    $save['created_on']                 = date('Y-m-d H:i:s');
                    $save['created_by']                 = $this->session->userdata('user_id');

                    $response                           = $this->franchise->save($id, $save);
                    if($response['error'] == 0 && empty($id))
                    {
                        $save['password']               = $password;

                        /*$html                           = $this->load->view('emailers/welcome-franchise', $save, true);

                        $email_data                     = [
                                                            'to'            => [
                                                                                [
                                                                                    'name'  => $save['franchise_name'],
                                                                                    'email' => $save['email']
                                                                                ]
                                                                            ],
                                                            'cc'            => [],
                                                            'bcc'           => [],
                                                            'subject'       => 'Welcome To Myheaven',
                                                            'message'       => $html,
                                                            'altbody'       => '',
                                                            'attachments'   => [],
                                                            'html'          => true,
                                                        ];

                        Modules::run("php_mailer/send", $email_data);*/
                    }
                }
                else
                {
                    if(isset($post_data['password']) && !empty($post_data['password']))
                    {
                        $save['password']               = password_hash($post_data['password'], PASSWORD_DEFAULT);
                    }
                    $response                           = $this->franchise->save($id, $save);
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

                $details    = $this->franchise->get_details($id);

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

                    if($this->franchise->change($id, $status))
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
            $conditions     = ['status !=' => '-1', 'mobile' => $str];

            if(isset($_POST['id']) && !empty($_POST['id']))
            {
                $conditions = ['status !=' => '-1', 'mobile' => $str, 'id !=' => $_POST['id']];
            }

            $this->form_validation->set_message('unique_mobile', 'Mobile already exist');
            $result         = $this->franchise->check_unique($conditions);
            return $result;
        }

        function unique_email($str, $func)
        {
            $id             = '';
            $conditions     = ['status !=' => '-1', 'email' => $str];

            if(isset($_POST['id']) && !empty($_POST['id']))
            {
                $conditions = ['status !=' => '-1', 'email' => $str, 'id !=' => $_POST['id']];
            }

            $this->form_validation->set_message('unique_email', 'Email already exist');
            $result         = $this->franchise->check_unique($conditions);
            return $result;
        }
    }
?>