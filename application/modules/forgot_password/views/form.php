<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="my-auto page">
    <div class="main-signin-wrapper">
        <div class="main-card-signin forgot-password d-md-flex wd-100p">
            <div class="wd-md-50p  page-signin-style p-4 text-white d-none d-md-block ">
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
                    <h2>Forgot Password!</h2>
                    <h4>Please Enter Your Mobile/Email</h4>
                    <form id="form-id" class="form-horizontal" action="<?php echo base_url(forgot_password_constants::ajax_forgot_password_url); ?>" method="post">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                        <div class="form-group">
                            <label>Mobile number/Email id <span class="asterisk">*</span></label>
                            <input type="text" class="form-control no_space" id="mobile_or_email" name="mobile_or_email" value="<?php echo set_value('mobile_or_email'); ?>" data-error=".mobile_or_emailerror" required maxlength="50" autocomplete="off">
                            <div class="mobile_or_emailerror error_msg"><?php echo form_error('mobile_or_email', '<label class="error">', '</label>'); ?></div>
                        </div>
                        <button type="submit" class="btn btn-main-primary btn-block">Submit</button>
                    </form>
                </div>
                <div class="main-signup-footer mg-t-10">
                    <p>Forget it, <a href="<?php echo base_url(signin_constants::signin_url); ?>"> Send me back</a> to the sign in screen.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('otp_modal'); ?>
<?php $this->load->view('forgot_password_modal'); ?>

<script type="text/javascript">
    $('#form-id').validate({
        rules: {
            mobile_or_email: {
                required: true
            }
        },
        messages: {
            mobile_or_email: {
                required: "Please enter mobile number/e-mail id"
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

            $.ajax({
                type: "POST",
                dataType: "json",
                url: base_url+"<?php echo forgot_password_constants::ajax_forgot_password_url; ?>",
                async: false,
                data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : csrf_token, mobile_or_email : mobile_or_email, when : 'forgot_password'},
                success: function(response){
                    if(response.error == 2)
                    {
                        hideLoader();
                        if(response.message.mobile_or_email != undefined)
                        {
                            $('.mobile_or_emailerror').html('<div id="mobile_or_email-error" class="danger">'+response.message.mobile_or_email+'</div>');
                        }
                    }
                    else if(response.error == 1)
                    {
                        hideLoader();
                        load_status_popup('error', response.message);
                    }
                    else
                    {
                        $('#resend').attr('onclick', 'send_otp("'+csrf_token+'", "'+mobile_or_email+'", "resend")');
                        send_otp(csrf_token, mobile_or_email, 'send');
                    }
                }
            });
        }
    });
</script>