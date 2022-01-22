<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="modal" id="otp-modal">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Password Verification</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <h6>Enter an OTP which was sent to</h6>
                        <p id="entered_mobile_or_email"></p>
                        <p><a href="javascript:void(0);" onclick="close_popup();">Want to change?</a></p>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group m-t-20 m-b-0">
                            <input type="password" name="otp" id="otp" maxlength="6" class="form-control validate_integer text-center f-s-20" value="">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 pincode-input-error text-red"></div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button class="btn btn-main-primary" type="button" onclick="verify_otp();">Verify</button>
                <button class="btn btn-secondary custom-btn-secondary" type="button" id="resend">Resend</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function close_popup() {
        $('#otp-modal').modal('hide');
        setTimeout(function(){
            document.getElementById('mobile_or_email').focus();
        }, 100);
    }
    
    function send_otp(csrf_token, mobile_or_email, type) {
        $('.pincode-input-error').html('');

        showLoader();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: base_url+"<?php echo otp_constants::generate_otp_url; ?>",
            data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : csrf_token, mobile_or_email : mobile_or_email, otp_for : 'forgot password', otp_type : '<?php echo $this->config->item("otp_types")["forgot_password"]; ?>'},
            success: function(response) {
                hideLoader();

                if(response.error == 0)
                {
                    if(type == 'send')
                    {
                        $('#otp-modal').modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                        $('#entered_mobile_or_email').html(mobile_or_email);

                        load_status_popup("success", response.message);
                        setTimeout(function(){
                            $('#otp').focus();
                        }, 500);
                    }
                    else
                    {
                        $('#otp').val('');
                        $('#otp').focus();
                        load_status_popup("success", response.message);
                    }
                }
                else
                {
                    load_status_popup("error", response.message);
                }
            }
        });
    }

    function verify_otp() {
        var otp             = $('#otp').val();
        $('.pincode-input-error').html('');

        if(otp.length < 6)
        {
            $('.pincode-input-error').html('Please enter valid otp');
        }
        else
        {
            var formArray   = $('#form-id').serializeArray();
            var postObject  = {};
            $.each(formArray, function(i, field){
                postObject[field.name]      = field.value;
            });
            postObject['<?php echo $this->security->get_csrf_token_name(); ?>'] = $('#<?php echo $this->security->get_csrf_token_name(); ?>').val();
            postObject['otp']               = otp;
            postObject['when']              = 'otp';
            showLoader();

            $.ajax({
                type: "POST",
                dataType: "json",
                url: base_url+"<?php echo forgot_password_constants::ajax_forgot_password_url; ?>",
                data: postObject,
                success: function(response) {
                    hideLoader();

                    if(response.error == 0)
                    {
                        $('#otp-modal').modal('hide');
                        load_status_popup("success", response.message);
                        $('#forgot-password-modal').modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                        setTimeout(function(){
                            $('#password').focus();
                        }, 500);
                    }
                    else
                    {
                        load_status_popup("error", response.message);
                    }
                }
            });
        }
    }
</script>