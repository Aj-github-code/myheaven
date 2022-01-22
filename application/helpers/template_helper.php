<?php
    defined('BASEPATH') or exit ('No direct script access allowed');
    
    function kyc_pending($otp)
    {
        return "Dear {$otp}
        You are just 1 step away! Complete KYC to get a payout.
        cubicalsoft
        https://www.cubicalsoft.in/";
    } 
 /*    function otp_message($otp)
    {
        return "Dear
        Your OTP is {$otp} and is valid for 5 minutes.
        cubicalsoft
        https://www.cubicalsoft.in/";
    }  */
    function otp_message($otp)
    {
        return "{$otp} is your OTP & valid for 15 minutes. Do not share it with anyone.";
    } 
    function credited_payout($otp)
    {
        return "Dear {$otp}
        Your payout {#var#} is credited to your bank account transaction id is {#var#}
        cubicalsoft
        https://www.cubicalsoft.in/";
    } 
    function kyc_approved($otp)
    {
        return "Dear {$otp},
        Your KYC is approved. Now you are eligible to request a payout
        https://www.cubicalsoft.in/";
    } 
    function welcome_message($otp)
    {
        return "Welcome {$otp} to the world of cubicalsoft You have successfully registered,User ID :{$otp},Pass: {$otp}
        cubicalsoft
        https://www.cubicalsoft.in/";
    } 


 
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