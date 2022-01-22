<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header bd-b">
                <h5 class="card-title mb-0"><?php echo $page_title; ?></h5>
            </div>
            <div class="card-body">
                <form id="formId" class="" method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf">
                    <input type="hidden" id="id" name="id" value="<?php echo (isset($post_data['id']) ? $post_data['id'] : ''); ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Sponsor Id <span class="asterisk">*</span></label>
                                <input type='text' class="form-control" id="sponsor_id" name="sponsor_id" placeholder="" value="<?php echo set_value('sponsor_id', (isset($post_data['sponsor_id']) ? $post_data['sponsor_id'] : '')); ?>" data-error=".sponsoriderror" maxlength="11"/>
                                <div class="sponsoriderror error_msg"><?php echo form_error('sponsor_id', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Type <span class="asterisk">*</span></label>
                                <select class="select2" name="type" id="type" style="width: 100%;" data-error=".typeerror" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="Mini" <?php if(isset($post_data['type']) && $post_data['type'] == 'Mini'){ echo 'selected="selected"'; } ?>>Mini</option>
                                    <option value="Hub" <?php if(isset($post_data['type']) && $post_data['type'] == 'Hub'){ echo 'selected="selected"'; } ?>>Hub</option>
                                </select>
                                <div class="typeerror error_msg"><?php echo form_error('type', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Franchise Name <span class="asterisk">*</span></label>
                                <input type='text' class="form-control" id="franchise_name" name="franchise_name" placeholder="" value="<?php echo set_value('franchise_name', (isset($post_data['franchise_name']) ? $post_data['franchise_name'] : '')); ?>" data-error=".franchise_nameerror" maxlength="191" required/>
                                <div class="franchise_nameerror error_msg"><?php echo form_error('franchise_name', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Your Name <span class="asterisk">*</span></label>
                                <input type='text' class="form-control" id="your_name" name="your_name" placeholder="" value="<?php echo set_value('your_name', (isset($post_data['your_name']) ? $post_data['your_name'] : '')); ?>" data-error=".your_nameerror" maxlength="191" required/>
                                <div class="your_nameerror error_msg"><?php echo form_error('your_name', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Mobile <span class="asterisk">*</span></label>
                                <input type='text' class="form-control validate_integer" id="mobile" name="mobile" placeholder="" value="<?php echo set_value('mobile', (isset($post_data['mobile']) ? $post_data['mobile'] : '')); ?>" data-error=".mobileerror" maxlength="10" required/>
                                <div class="mobileerror error_msg"><?php echo form_error('mobile', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email <span class="asterisk">*</span></label>
                                <input type='text' class="form-control to_lowercase" id="email" name="email" placeholder="" value="<?php echo set_value('email', (isset($post_data['email']) ? $post_data['email'] : '')); ?>" data-error=".emailerror" maxlength="50" required/>
                                <div class="emailerror error_msg"><?php echo form_error('email', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <input type='password' class="form-control" id="password" name="password" placeholder="" value="<?php echo set_value('password'); ?>" data-error=".passworderror" maxlength="32"/>
                                <div class="passworderror error_msg"><?php echo form_error('password', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Confirm Password</label>
                                <input type='password' class="form-control" id="password_confirmation" name="password_confirmation" placeholder="" value="<?php echo set_value('password_confirmation'); ?>" data-error=".cpassworderror" maxlength="32"/>
                                <div class="cpassworderror error_msg"><?php echo form_error('password_confirmation', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Telephone</label>
                                <input type='text' class="form-control" id="telephone" name="telephone" placeholder="" value="<?php echo set_value('telephone', (isset($post_data['telephone']) ? $post_data['telephone'] : '')); ?>" data-error=".telephoneerror" maxlength="20" />
                                <div class="telephoneerror error_msg"><?php echo form_error('telephone', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Date Of Birth:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input type='text' class="form-control pickadate p-l-0" id="dob" name="dob" placeholder="" value="<?php echo set_value('dob', (isset($post_data['dob']) ? $post_data['dob'] : '')); ?>" data-error=".doberror" />
                                </div>
                                <div class="doberror error_msg"><?php echo form_error('dob', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Pan</label>
                                <input type='text' class="form-control" id="pan" name="pan" placeholder="" value="<?php echo set_value('pan', (isset($post_data['pan']) ? $post_data['pan'] : '')); ?>" data-error=".panerror" maxlength="50" />
                                <div class="panerror error_msg"><?php echo form_error('pan', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Gst</label>
                                <input type='text' class="form-control" id="gst" name="gst" placeholder="" value="<?php echo set_value('gst', (isset($post_data['gst']) ? $post_data['gst'] : '')); ?>" data-error=".gsterror" maxlength="50" />
                                <div class="gsterror error_msg"><?php echo form_error('gst', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Trade License No</label>
                                <input type='text' class="form-control" id="trade_license_no" name="trade_license_no" placeholder="" value="<?php echo set_value('trade_license_no', (isset($post_data['trade_license_no']) ? $post_data['trade_license_no'] : '')); ?>" data-error=".trade_license_noerror" maxlength="50" />
                                <div class="trade_license_noerror error_msg"><?php echo form_error('trade_license_no', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Pincode</label>
                                <input type='text' class="form-control validate_integer" id="pincode" name="pincode" placeholder="" value="<?php echo set_value('pincode', (isset($post_data['pincode']) ? $post_data['pincode'] : '')); ?>" data-error=".pincodeerror" maxlength="6"/>
                                <div class="pincodeerror error_msg"><?php echo form_error('pincode', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="address">Address</label>
                                        <textarea class="form-control" id="address" name="address"><?php echo (isset($post_data['address']) ? $post_data['address'] : ''); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Bank Name</label>
                                <input type='text' class="form-control" id="bank_name" name="bank_name" placeholder="" value="<?php echo set_value('bank_name', (isset($post_data['bank_name']) ? $post_data['bank_name'] : '')); ?>" data-error=".banknameerror" maxlength="191" />
                                <div class="banknameerror error_msg"><?php echo form_error('bank_name', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Bank Account</label>
                                <input type='text' class="form-control" id="bank_account" name="bank_account" placeholder="" value="<?php echo set_value('bank_account', (isset($post_data['bank_account']) ? $post_data['bank_account'] : '')); ?>" data-error=".bank_accounterror" maxlength="50" />
                                <div class="bank_accounterror error_msg"><?php echo form_error('bank_account', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">IFSC Code</label>
                                <input type='text' class="form-control" id="ifsc_code" name="ifsc_code" placeholder="" value="<?php echo set_value('ifsc_code', (isset($post_data['ifsc_code']) ? $post_data['ifsc_code'] : '')); ?>" data-error=".ifsccodeerror" maxlength="50" />
                                <div class="ifsccodeerror error_msg"><?php echo form_error('ifsc_code', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Branch Name</label>
                                <input type='text' class="form-control" id="branch_name" name="branch_name" placeholder="" value="<?php echo set_value('branch_name', (isset($post_data['branch_name']) ? $post_data['branch_name'] : '')); ?>" data-error=".branchnameerror" maxlength="191" />
                                <div class="branchnameerror error_msg"><?php echo form_error('branch_name', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Status <span class="asterisk">*</span></label>
                                <select class="select2" name="status" id="status" style="width: 100%;" data-error=".statuserror" required>
                                    <option value="">-- Select Status --</option>
                                    <option value="1" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'selected="selected"'; } ?>>Active</option>
                                    <option value="0" <?php if(isset($post_data['status']) && $post_data['status'] == 0){ echo 'selected="selected"'; } ?>>In-Active</option>
                                </select>
                                <div class="statuserror error_msg"><?php echo form_error('status', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-12 mg-t-10 text-right">
                            <button class="btn btn-main-primary pd-x-20 mr-2" type="submit">Save</button>
                            <a href="<?php echo base_url(franchise_constants::franchise_url); ?>" class="btn btn-secondary custom-btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(".pickadate").pickadate({
        format: 'yyyy-mm-dd',
        selectMonths: true,
        selectYears: 200
    });

    $('#status, #type').select2();

    var password_hash_regex     = <?php echo $this->config->item("password_hash"); ?>;

    $.validator.addMethod("valid_password", function(value, element) {
        return password_hash_regex.test(value);
    }, 'Password must contain atleast 1 lowercase, 1 number and 1 special character of set [!@#$%&_]');

    $("#formId").validate({
        rules: {
            sponsor_id: {
                required: true,
            },
            your_name: {
                required: true,
            },
            franchise_name: {
                required: true,
            },
            password: {
                required: {
                    depends: function (element) {if($('#password').val() != ''){return true;}else{return false;}}
                },
                minlength: {
                    depends: function (element) {if($('#password').val() != ''){return 8;}else{return false;}}
                },
                valid_password: '#password'
            },
            password_confirmation: {
                required: {
                    depends: function (element) {if($('#password').val() != ''){return true;}else{return false;}}
                },
                equalTo : "#password"
            },
            type: {
                required: true,
            },
            mobile: {
                required: true,
                mobile_regex: '#mobile',
            },
            email: {
                required: true,
                email_regex: '#email',
            },
            status: {
                required: true,
            },
        },
        messages: {
            sponsor_id: {
                required: 'Please enter sponsor id',
            },
            your_name: {
                required: 'Please enter your name',
            },
            franchise_name: {
                required: 'Please enter franchise name',
            },
            password: {
                required: 'Please enter new password',
                minlength: 'Password must be minimum 8 characters',
                valid_password: 'Password must contain atleast 1 lowercase, 1 number and 1 special character of set [!@#$%&_]'
            },
            password_confirmation:{
                required: 'Please enter confirm password',
                equalTo: 'Confirm password must be same as password'
            },
            type: {
                required: 'Please select type',
            },
            mobile:{
                required: 'Please enter mobile number',
                mobile_regex: 'Please enter valid mobile number',
            },
            email:{
                required: 'Please enter email',
                email_regex: 'Please enter valid email',
            },
            status:{
                required: 'Please select status',
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
            event.preventDefault();
            var csrf_token          = $('#<?php echo $this->security->get_csrf_token_name(); ?>').val();
            var franchise_id        = $('#id').val();
            var mobile              = $('#mobile').val();
            var email               = $('#email').val();
            var status              = $('#status').val();

            function unique_mobile() {
                var check_result = false;

                $.ajax({
                    type: "POST",
                    url: base_url+'<?php echo franchise_constants::check_franchise_mobile_url; ?>',
                    async: false,
                    data: {mobile : mobile, id : franchise_id, '<?php echo $this->security->get_csrf_token_name(); ?>' : csrf_token},
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response){
                        hideLoader();
                        check_result = response;
                    }
                });
                return check_result;
            }

            function unique_email() {
                var check_result = false;

                $.ajax({
                    type: "POST",
                    url: base_url+'<?php echo franchise_constants::check_franchise_email_url; ?>',
                    async: false,
                    data: {email : email, id : franchise_id, '<?php echo $this->security->get_csrf_token_name(); ?>' : csrf_token},
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response){
                        hideLoader();
                        check_result = response;
                    }
                });
                return check_result;
            }

            $('.mobileerror').html('');
            $('.emailerror').html('');

            var check_mobile = unique_mobile();
            if(check_mobile)
            {
                var check_email = unique_email();
                if(check_email)
                {
                    showLoader();
                    form.submit();
                }
                else
                {
                    hideLoader();
                    $('.emailerror').append('<div id="email-error" class="error" style="">Email already exist</div>');
                }
            }
            else
            {
                hideLoader();
                $('.mobileerror').append('<div id="mobile-error" class="error" style="">Mobile number already exist</div>');
            }
        }
    });
</script>