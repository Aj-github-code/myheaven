<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="my-auto page page-h">
    <div class="main-signin-wrapper">
        <div class="main-card-signin d-md-flex wd-100p">
            <div class="wd-md-50p login d-none d-md-block page-signin-style p-4 text-white" >
                <div class="my-auto authentication-pages">
                    <div>
                        <a href="<?php echo base_url(); ?>" class="text-center d-block mb-4">
                            <img src="<?php echo assets_url(); ?>img/logo/myheavenlogo.png" class=" m-0" alt="<?php echo $this->config->item('product_name'); ?>" style="width: 160px;">
                        </a>
                        <h5 class="mb-2">Welcome to My Heaven!</h5>
                        <p class="mb-2">Dear distributor/Franchises
                        Our aim is that our franchise will be made available to all the cities and villages of India. The objective of this franchise through MY Heaven Marketing Pvt Ltd is to provide employment to people in India. This franchise has to prove the right way to increase sales of products, present tax GST bill, remove adulteration and black market.
                        Through direct selling, I feel that a revolution can be brought in India. Many abusive topics like corruption, unemployment, poverty, black marketing, violence, adulteration can be erased. For this, all of us must together play our role in this mission.</p>
                        <h5 class="mb-2">Always with you, MY HEAVEN™</h5>
                    </div>
                </div>
            </div>
            <div class="p-4 wd-md-50p">
                <div class="main-signin-header">
                    <h2>Welcome back!</h2>
                    <h4>Please sign in to continue</h4>
                    <div id="error_wrap"></div>
                    <form id="form-id" action="<?php echo base_url(signin_constants::signin_url); ?>">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="signin_type" id="signin_type" value="password">

                        <div class="form-group">
                            <label>Mobile number/Email id <span class="asterisk">*</span></label>
                            <input type="text" class="form-control no_space" id="mobile_or_email" name="mobile_or_email" value="<?php echo set_value('mobile_or_email'); ?>" placeholder="" data-error=".mobile_or_emailerror" required maxlength="50" value="<?php echo set_value('mobile_or_email'); ?>">
                            <div class="mobile_or_emailerror error_msg"><?php echo form_error('mobile_or_email', '<label class="error">', '</label>'); ?></div>
                        </div>
                        
                        <div class="form-group" id="password_wrap">
                            <label>Password <span class="asterisk">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control no_space" id="password" name="password" value="<?php echo set_value('password'); ?>" placeholder="" data-error=".passworderror" maxlength="50">
                                <div class="input-group-append" onclick="view_password('password');" style="cursor: pointer;">
                                    <span class="input-group-text" id="basic-addon2"><i class="far fa-eye"></i></span>
                                </div>
                            </div>
                            <div class="passworderror error_msg"><?php echo form_error('password', '<label class="error">', '</label>'); ?></div>
                        </div>
                        
                        <button class="btn btn-main-primary btn-block">Sign In</button>
                    </form>
                </div>
                <?php  ?>
                                       </br> 
                                       <a href="<?php echo base_url(signin_constants::register_url); ?>"><button class="btn btn-main-primary btn-block">Register</button></a>
                                       

                <div class="main-signin-footer mt-3 mg-t-5">
                    <p> <a href="<?php echo base_url(forgot_password_constants::forgot_password_url); ?>" class="float-right">Forgot password?</a>
                    </p>
                </div>


                <?php  ?>
            </div>
        </div>
    </div>
</div>

<?php
    $error_wrap             = 'error_wrap';
    $hasError               = 'no';
    $hasErrorMessage        = '';

    if(isset($timeout_left) && $timeout_left !== FALSE)
    {
        $error_wrap         = 'signin_btn';
        $hasError           = 'yes';
        $hasErrorMessage    = 'You have been locked out for too many incorrect sign in attempts. Please wait '.ceil($timeout_left).' minutes before attempting to sign in again. If you have forgotten your password then click on Forgot Password.';
    }
    if($this->session->flashdata('timed_out'))
    {
        if($this->session->flashdata('timed_out') === 'TRUE')
        {
            $hasError           = 'yes';
            $hasErrorMessage    = 'Session timed out';
        }
    }
    if($this->session->flashdata('message') !== FALSE && !empty($this->session->flashdata('message')))
    {
        $msg                    = $this->session->flashdata('message');
        if(isset($msg['message']) && !empty($msg['message']))
        {
            $hasError           = 'yes';
            $hasErrorMessage    = $msg['message'];
        }
    }
?>

<script type="text/javascript">
    var error_wrap      = '<?php echo $error_wrap; ?>';
    var hasError        = '<?php echo $hasError; ?>';
    var hasErrorMessage = '<?php echo $hasErrorMessage; ?>';

    $(document).ready(function() {
        if(hasError == 'yes')
        {
            show_content_alert(error_wrap, 'error', hasErrorMessage);
        }
    });

    function view_password(id) {
        var password = document.getElementById(id);
        if(password.type === "password")
        {
            password.type = "text";
        }
        else
        {
            password.type = "password";
        }
    }

    $('#form-id').validate({
        rules: {
            mobile_or_email: {
                required: true
            },
            password: {
                required: {
                    depends: function() {
                        if($('#password_wrap').is(":visible") == true)
                        {
                            return true;
                        }
                        else
                        {
                            return false;
                        }
                    }
                },
            },
        },
        messages: {
            mobile_or_email: {
                required: "Please enter mobile number/e-mail id"
            },
            password: {
                required: "Please enter password"
            }
        },
        ignore: "input[type=hidden]",
        errorClass: "danger",
        successClass: "success",
        highlight: function(e, t) {
            $(e).removeClass(t)
        },
        unhighlight: function(e, t) {
            $(e).removeClass(t)
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            showLoader();
            var csrf_token      = $('#<?php echo $this->security->get_csrf_token_name(); ?>').val();
            var mobile_or_email = $('#mobile_or_email').val();
            var password        = $('#password').val();
            var signin_type     = $('#signin_type').val();

            $.ajax({
                type: "POST",
                dataType: "json",
                url: base_url+"<?php echo signin_constants::ajax_signin_url; ?>",
                async: false,
                data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : csrf_token, mobile_or_email : mobile_or_email, password : password, signin_type : signin_type, when : 'signin'},
                success: function(response){
                    if(response.error == 2)
                    {
                        hideLoader();
                        if(response.message.mobile_or_email != undefined)
                        {
                            $('.mobile_or_emailerror').html('<div id="mobile_or_email-error" class="danger">'+response.message.mobile_or_email+'</div>');
                        }
                        if(response.message.password != undefined)
                        {
                            if($('#password_wrap').is(":visible") == true)
                            {
                                $('.passworderror').html('<div id="password-error" class="danger">'+response.message.password+'</div>');
                            }
                            else
                            {
                                load_status_popup('error', response.message.password);
                            }
                        }
                    }
                    else if(response.error == 1)
                    {
                        hideLoader();
                        load_status_popup('error', response.message);
                    }
                    else
                    {
                        if($('#signin_type').val() == 'password')
                        {
                            hideLoader();
                            load_status_popup("success", response.message);
                            setTimeout(function(){
                                location.reload();
                            }, 2000);
                        }
                        else
                        {
                            $('#resend').attr('onclick', 'send_otp("'+csrf_token+'", "'+mobile_or_email+'", "resend")');
                            send_otp(csrf_token, mobile_or_email, 'send');
                        }
                    }
                }
            });
        }
    });

    function switch_signin(sel) {
        $('#password_wrap').toggleClass('d-none');
        if($(sel).html() == 'Sign In With OTP?')
        {
            $(sel).html('Sign In With Password?');
            $('#signin_type').val('otp');
        }
        else
        {
            $(sel).html('Sign In With OTP?');
            $('#signin_type').val('password');
        }
    }
</script>