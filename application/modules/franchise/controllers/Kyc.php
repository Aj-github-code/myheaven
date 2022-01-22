<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Kyc extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('franchise_model', 'franchise');
            $this->load->model('kyc_model', 'kyc');
        }

        function index($id)
        {
            $response                       = ['error' => 1, 'message' => 'Invalid request'];
            if(empty($id))
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().franchise_constants::franchise_url);
            }
            $franchise                      = $this->franchise->get_details($id);
            if(empty($franchise))
            {
                $response                   = ['error' => 1, 'message' => 'Franchise not found'];
                $this->session->set_flashdata('status', $response);
                redirect(base_url().franchise_constants::franchise_url);
            }

            $data['franchise_id']           = $id;
            $data['kyc_status']             = $franchise['kyc_status'];
            $data['kyc_message']            = $franchise['kyc_message'];
            $data['kyc_status_class']       = 'alert-success';

            if($data['kyc_status'] == 'pending' || $data['kyc_status'] == 'rejected')
            {
                $data['kyc_status_class']   = 'alert-danger';
            }

            $data['meta_title']             = "Kyc";
            $data['meta_description']       = "Kyc";
            $data['meta_keywords']          = "Kyc";
            $data['page_title']             = "Kyc";
            $data['module']                 = "Franchise";
            $data['menu']                   = "franchise";
            $data['submenu']                = "list";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->unshift(1, 'Franchise', franchise_constants::franchise_url);
            $this->breadcrumbs->unshift(2, 'Kyc', franchise_constants::manage_kyc_url.'/'.$id);
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "franchise/kyc/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function ajax_list()
        {
            $franchise_id                       = isset($_GET['custom_search']['franchise_id']) ? $_GET['custom_search']['franchise_id'] : '';
            if(!empty($franchise_id))
            {
                $condition                      = ['k.user_id' => $franchise_id, 'k.status !' => '-1'];
                $list                           = $this->kyc->get_data($condition, '', '', '');
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
                    $kyc_id                     = $value->id;

                    if($value->status == 1)
                    {
                        $status                 = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$kyc_id.', 0, this);" data-type="kyc" data-function="'.base_url().franchise_constants::change_kyc_status_url.'"><span class="badge badge-success">Active</span></a>';
                    }
                    else if($value->status == 0)
                    {
                        $status                 = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$kyc_id.', 1, this);" data-type="kyc" data-function="'.base_url().franchise_constants::change_kyc_status_url.'"><span class="badge badge-danger">In-Active</span></a>';
                    }

                    $action                     = '
                                                    <span class="dropdown action-dropdown d-flex justify-content-center">
                                                        <button id="btnSearchDrop'.$key.'" type="button" class="btn btn-sm btn-icon btn-pure font-medium-2" data-toggle="dropdown" aria-haspopup="true"
                                                         aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <span aria-labelledby="btnSearchDrop'.$key.'" class="dropdown-menu dropdown-menu-right">';
                                                            $action .= '<a class="dropdown-item" title="Process" href="javascript:void(0);" onclick="process_kyc('.$kyc_id.', `'.$value->kyc_status.'`, `'.$value->reason.'`, this);">Process</a>';
                                                            $action .= '<a class="dropdown-item" title="Delete" href="javascript:void(0);" onclick="change_status('.$kyc_id.', -1, this);" data-type="kyc" data-function="'.base_url().franchise_constants::change_kyc_status_url.'">Delete</a>';
                                                            $action .= '</span>
                                                    </span>
                                                ';

                    if($value->kyc_status == 'pending' || $value->kyc_status == 'rejected')
                    {
                        $kyc_status             = '<span class="badge badge-danger">'.ucfirst($value->kyc_status).'</span>';
                    }
                    else
                    {
                        $kyc_status             = '<span class="badge badge-success">'.ucfirst($value->kyc_status).'</span>';
                    }

                    $kyc_status                 = '<a class="" href="javascript:void(0);" onclick="process_kyc('.$kyc_id.', `'.$value->kyc_status.'`, `'.$value->reason.'`, this);">'.$kyc_status.'</a>';
                    $file                       = '<a class="" href="'.franchise_url.'public/content/'.$value->file.'" target="_blank">'.basename(parse_url($value->file, PHP_URL_PATH)).'</a>';

                    $no++;
                    $row                                            = [];
                    $row['sr_no']                                   = $no;
                    $row['id']                                      = $kyc_id;
                    $row['file']                                    = $file;
                    $row['type']                                    = ucfirst($value->type);
                    $row['kyc_status']                              = $kyc_status;
                    $row['reason']                                  = $value->reason;
                    $row['status']                                  = $status;
                    $row['created_on']                              = $created_on;
                    $row['action']                                  = $action;
                
                    $tabledata[]                                    = $row;
                }
                $total                                              = $this->kyc->get_data($condition, '', '', 'allcount');
            }
            else
            {
                $total                                              = 0;
                $tabledata                                          = [];
            }

            $output                         = array(
                                                "total"      => $total,
                                                "rows"       => $tabledata,
                                            );

            echo json_encode($output);
        }

        function save()
        {
            $response                                   = ['error' => 1, 'message' => 'Invalid request'];
            $post_data                                  = isset($_POST) ? $_POST : [];
            if(!empty($post_data))
            {
                $franchise_id                           = $post_data['franchise_id'];

                $save                                   = [];
                $save['kyc_status']                     = $post_data['kyc_status'];
                $save['kyc_message']                    = $post_data['kyc_message'];

                $response                               = $this->kyc->save($franchise_id, $save);
            }
            echo json_encode($response);
        }

        function process()
        {
            $response                                   = ['error' => 1, 'message' => 'Invalid request'];
            $post_data                                  = isset($_POST) ? $_POST : [];
            if(!empty($post_data))
            {
                $kyc_id                                 = $post_data['kyc_id'];

                $save                                   = [];
                $save['kyc_status']                     = $post_data['kyc_status'];
                $save['reason']                         = $post_data['reason'];

                $response                               = $this->kyc->process($kyc_id, $save);
            }
            echo json_encode($response);
        }

        function change()
        {
            $response       = ['error' => 1, 'message' => 'Invalid request'];

            if(isset($_POST) && !empty($_POST))
            {
                $id         = isset($_POST['id']) ? $_POST['id'] : '';
                $type       = isset($_POST['type']) ? $_POST['type'] : '';
                $status     = isset($_POST['status']) ? $_POST['status'] : '';

                $details    = $this->kyc->get_details($id);

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

                    if($this->kyc->change($id, $status))
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
    }
?>