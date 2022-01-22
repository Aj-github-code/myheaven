<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="card-header bd-b">
                <h5 class="card-title mb-0"><?php echo $page_title; ?></h5>
            </div>
            <div class="card-body">
                <form id="formId" class="" method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Old Password: <span class="asterisk">*</span></label>
                                <input type='password' class="form-control" id="old_pass" name="old_pass" placeholder="" value="<?php echo set_value('old_pass', (isset($post_data['old_pass']) ? $post_data['old_pass'] : '')); ?>" data-error=".oldpasserror" maxlength="32" required/>
                                <div class="oldpasserror error_msg"><?php echo form_error('old_pass', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">New Password: <span class="asterisk">*</span></label>
                                <input type='password' class="form-control" id="password" name="password" placeholder="" value="<?php echo set_value('password', (isset($post_data['password']) ? $post_data['password'] : '')); ?>" data-error=".passworderror" maxlength="32" required/>
                                <div class="passworderror error_msg"><?php echo form_error('password', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Confirm New Password: <span class="asterisk">*</span></label>
                                <input type='password' class="form-control" id="password_confirmation" name="password_confirmation" placeholder="" value="<?php echo set_value('password_confirmation', (isset($post_data['password_confirmation']) ? $post_data['password_confirmation'] : '')); ?>" data-error=".cpassworderror" maxlength="32" required/>
                                <div class="cpassworderror error_msg"><?php echo form_error('password_confirmation', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-12">
                            <button class="btn btn-main-primary pd-x-20 mg-t-5" type="submit">Change</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var password_hash_regex     = <?php echo $this->config->item("password_hash"); ?>;

    $.validator.addMethod("valid_password", function(value, element) {
        return password_hash_regex.test(value);
    }, 'Password must contain atleast 1 lowercase, 1 number and 1 special character of set [!@#$%&_]');

    $("#formId").validate({
        rules: {
            old_pass: {
                required: true,
            },
            password: {
                required: true,
                minlength: 8,
                valid_password: '#password'
            },
            password_confirmation: {
                required: true,
                equalTo : "#password"
            },
        },
        messages: {
            old_pass: {
                required: 'Please enter old password',
            },
            password: {
                required: 'Please enter new password',
                minlength: 'New password must be minimum 8 characters',
                valid_password: 'New password must contain atleast 1 lowercase, 1 number and 1 special character of set [!@#$%&_]'
            },
            password_confirmation:{
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
        submitHandler: function(form, event){
            showLoader();
            form.submit();
        }
    });
</script>