<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="modal" id="forgot-password-modal">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content modal-content-demo">
            <form id="reset-password-form-id" class="form-horizontal" action="<?php echo base_url(forgot_password_constants::ajax_forgot_password_url); ?>" method="post">
                <div class="modal-header">
                    <h6 class="modal-title">Reset Password</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <fieldset class="form-group">
                        <input type="password" id="password" name="password" class="form-control" value="<?php echo set_value('password'); ?>" placeholder="Enter password" data-error=".passworderror" required autocomplete="off">
                        <div class="passworderror error_msg"><?php echo form_error('password', '<label class="error">', '</label>'); ?></div>
                    </fieldset>
                    <fieldset class="form-group m-b-0">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Enter confirm password" data-error=".password_confirmationerror" required autocomplete="off">
                        <div class="password_confirmationerror error_msg"><?php echo form_error('password_confirmation', '<label class="error">', '</label>'); ?></div>
                    </fieldset>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-main-primary">Reset</button>
                    <button type="button" class="btn btn-secondary custom-btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    var password_hash_regex     = <?php echo $this->config->item("password_hash"); ?>;

    $.validator.addMethod("valid_password", function(value, element) {
        return password_hash_regex.test(value);
    }, 'Password must contain atleast 1 lowercase, 1 number and 1 special character of set [!@#$%&_]');

    $('#reset-password-form-id').validate({
        rules: {
            password: {
                required: true,
                valid_password: '#password'
            },
            password_confirmation: {
                required: true,
                equalTo : "#password"
            },
        },
        messages: {
            password: {
                required: 'Please enter Password',
                valid_password: 'Password must contain atleast 1 lowercase, 1 number and 1 special character of set [!@#$%&_]'
            },
            password_confirmation: {
                required: 'Please enter confirm password',
                equalTo: 'Confirm password must be same as password'
            },
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
            var fotp         = $('#otp').val();
            $('.pincode-input-error').html('');
            var fformArray   = $('#form-id').serializeArray();
            var fpostObject  = {};
            $.each(fformArray, function(i, field){
                fpostObject[field.name]  = field.value;
            });
            fpostObject['<?php echo $this->security->get_csrf_token_name(); ?>'] = $('#<?php echo $this->security->get_csrf_token_name(); ?>').val();
            fpostObject['otp']                  = fotp;
            fpostObject['when']                 = 'otp';
            fpostObject['reset']                = 'password';
            fpostObject['password']             = $('#password').val();
            fpostObject['password_confirmation']= $('#password_confirmation').val();
            showLoader();

            $.ajax({
                type: "POST",
                dataType: "json",
                url: base_url+"<?php echo forgot_password_constants::ajax_forgot_password_url; ?>",
                async: false,
                data: fpostObject,
                success: function(response){
                    if(response.error == 2)
                    {
                        hideLoader();
                        if(response.message.password != undefined)
                        {
                            $('.passworderror').html('<div id="password-error" class="danger">'+response.message.password+'</div>');
                        }
                        if(response.message.password_confirmation != undefined)
                        {
                            $('.password_confirmationerror').html('<div id="password_confirmation-error" class="danger">'+response.message.password_confirmation+'</div>');
                        }
                    }
                    else if(response.error == 1)
                    {
                        hideLoader();
                        load_status_popup('error', response.message);
                    }
                    else
                    {
                        hideLoader();
                        load_status_popup('success', response.message);
                        $('#forgot-password-modal').modal('hide');
                        setTimeout(function(){
                            $('#otp').val('');
                            $('#mobile_or_email').val('');
                            window.location = base_url+'<?php echo signin_constants::signin_url; ?>';
                        }, 1500);
                    }
                }
            });
        }
    });
</script>