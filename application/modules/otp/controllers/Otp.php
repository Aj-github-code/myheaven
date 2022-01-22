<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Otp extends MX_Controller {

        function __construct() {
            parent::__construct();
            $this->load->model('otp/otp_model', 'otp');
        }

        function otp()
        {
            return mt_rand(100000, 999999);
        }

        function send()
        {
            $response       = ['error' => 1, 'message' => 'Invalid request'];
            $type           = isset($_POST['type']) ? $_POST['type'] : '';
            $for            = isset($_POST['for']) ? $_POST['for'] : '';
            $carrier        = isset($_POST['carrier']) ? $_POST['carrier'] : '';

            if(!empty($type) && !empty($for) && !empty($carrier))
            {
                $response   = $this->generate(
                                                [
                                                    'type'      => $type,
                                                    'for'       => $for,
                                                    'carrier'   => $carrier,
                                                ]
                                            );
                if(isset($response['error']) && $response['error'] == 0)
                {
                    Modules::run("sms/send", ['mobile' => $carrier, 'sms' => otp_message($response['otp'])]);
                }
            }
            echo json_encode($response);exit;
        }

        function generate($otp_data=[])
        {
            $response                   = ['error' => 1, 'message' => 'Unable to generate an OTP'];
            if(isset($_POST) && !empty($_POST))
            {
                $conditions             = [
                                            'mode'      => 'ADMIN',
                                            'type'      => $otp_data['type'],
                                            'for'       => $otp_data['for'],
                                            'carrier'   => $otp_data['carrier'],
                                            'status'    => 1,
                                        ];
                $update                 = ['status' => '-1', 'deleted_on' => date('Y-m-d H:i:s')];
                $this->otp->inactivateOtp($conditions, $update);

                $save                   = [];
                $save['mode']           = 'ADMIN';
                $save['type']           = $otp_data['type'];
                $save['for']            = $otp_data['for'];
                $save['carrier']        = $otp_data['carrier'];
                $save['otp']            = $this->otp();
                $save['status']         = 1;
                $save['created_on']     = date('Y-m-d H:i:s');

                if($this->otp->saveOtp($save))
                {
                    $response           = ['error' => 0, 'message' => 'OTP successfully sent', 'otp' => $save['otp']];
                }
            }
            return $response;
        }

        function verify($otp_data=[])
        {
            $response                   = ['error' => 1, 'message' => 'Invalid OTP'];
            if(isset($_POST) && !empty($_POST))
            {
                $conditions             = [
                                            'mode'      => 'ADMIN',
                                            'type'      => $otp_data['type'],
                                            'for'       => $otp_data['for'],
                                            'carrier'   => $otp_data['carrier'],
                                            'otp'       => $otp_data['otp'],
                                            'status'    => 1,
                                        ];
                $otpdata                = $this->otp->get_otp_data($conditions);

                if(isset($otpdata['status']) && !empty($otpdata['status']))
                {
                    $date_diff_in_min   = round(abs(strtotime(date("Y-m-d H:i:s")) - strtotime($otpdata['created_on'])) / 60, 2);
                    if($date_diff_in_min > 15)
                    {
                        $response       = ['error' => 1, 'message' => 'OTP expired'];
                    }
                    else
                    {
                        $response       = ['error' => 0, 'message' => 'OTP verified', 'otpdata' => $otpdata];
                        $update         = ['status' => 0, 'modified_on' => date('Y-m-d H:i:s')];
                        $this->otp->inactivateOtp(['id' => $otpdata['id']], $update);
                    }
                }
            }
            return $response;
        }
    }