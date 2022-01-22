<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends MY_Controller {
    function __construct() {
        parent::__construct();
      //  $this->load->config('sms');
    }

    function send($sms_data=[])
    {
        $mobile     = $sms_data['mobile'];
        $sms        = $sms_data['sms'];
        $type        = $sms_data['type'];

        $TemplateID["kyc_pending"]      ="1507163842893178916";
        $TemplateID["otp"]              ="1507163842922093412";
        $TemplateID["credited_payout"]  ="1507163842900320725";
        $TemplateID["kyc_approved"]     ="1507163842906577085";
        $TemplateID["welcome"]          ="1507163842868236678";

        /*Template ID:
        1507163842893178916
        Dear {#var#}
        You are just 1 step away! Complete KYC to get a payout.
        {#var#}
        https://www.cubicalsoft.in/*/

        /*Template ID:
        1507163842922093412
        Dear
        Your OTP is {#var#} and is valid for 5 minutes.
        {#var#}
        https://www.cubicalsoft.in/*/

        /*Template ID:
        1507163842900320725
        Dear {#var#}
        Your payout {#var#} is credited to your bank account transaction id is {#var#}
        {#var#}
        https://www.cubicalsoft.in/*/


        /*Template ID:
        1507163842906577085
        Dear {#var#},
        Your KYC is approved. Now you are eligible to request a payout
        https://www.cubicalsoft.in/*/

        /*Template ID:
        1507163842868236678
        Welcome {#var#} to the world of {#var#} You have successfully registered,User ID :{#var#},Pass: {#var#}
        {#var#}
        https://www.cubicalsoft.in/*/

        //https://www.alots.in/sms-panel/api/http/index.php?username=Cubicalsoft&apikey=12906-F73EA&apirequest=Text&sender=CUBCAL&mobile=9146657848&message=Dear%20Your%20OTP%20is%2012345%20and%20is%20valid%20for%205%20minutes.%20jattar.in%20https://www.cubicalsoft.in/&route=OTP&TemplateID=1507163842922093412&format=JSON
 
        $url        = "http://www.alots.in/sms-panel/api/http/index.php?";
        $url        .= "username=Cubicalsoft&apikey=12906-F73EA";
        $url        .= "&sender=CUBCAL&route=OTP"."&mobile=".$mobile;
        $url        .= "&apirequest=Text";
        $url        .= "TemplateID=".$TemplateID[$type]."&format=JSON";
        $url        .= "&message=".urlencode($sms);

        $ch         = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output     = curl_exec($ch);
        curl_close($ch);

        return $output;
    }
}