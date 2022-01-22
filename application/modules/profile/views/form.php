<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row row-sm">
    <div class="col-lg-3 text-center">
        <?php $this->load->view('avatar'); ?>
    </div>

    <div class="col-lg-9">
        <div class="card">
            <div class="card-header bd-b">
                <h5 class="card-title mb-0"><?php echo $page_title; ?></h5>
            </div>
            <div class="card-body">
                <form id="formId" class="" method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Franchise Name: <span class="asterisk">*</span></label>
                                <input type='text' class="form-control" id="franchise_name" name="franchise_name" placeholder="" value="<?php echo set_value('franchise_name', (isset($post_data['franchise_name']) ? $post_data['franchise_name'] : '')); ?>" data-error=".franchisenameerror" maxlength="64" required/>
                                <div class="franchisenameerror error_msg"><?php echo form_error('franchise_name', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Your Name: <span class="asterisk">*</span></label>
                                <input type='text' class="form-control" id="your_name" name="your_name" placeholder="" value="<?php echo set_value('your_name', (isset($post_data['your_name']) ? $post_data['your_name'] : '')); ?>" data-error=".yournameerror" maxlength="64" required/>
                                <div class="yournameerror error_msg"><?php echo form_error('your_name', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email: <span class="asterisk">*</span></label>
                                <input type='text' class="form-control to_lowercase" id="email" name="email" placeholder="" value="<?php echo set_value('email', (isset($post_data['email']) ? $post_data['email'] : '')); ?>" data-error=".emailerror" maxlength="50" required/>
                                <div class="emailerror error_msg"><?php echo form_error('email', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Mobile: <span class="asterisk">*</span></label>
                                <input type='text' class="form-control validate_integer" id="mobile" name="mobile" placeholder="" value="<?php echo set_value('mobile', (isset($post_data['mobile']) ? $post_data['mobile'] : '')); ?>" data-error=".mobileerror" maxlength="10" required/>
                                <div class="mobileerror error_msg"><?php echo form_error('mobile', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
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
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Telephone:</label>
                                <input type='text' class="form-control validate_integer" id="telephone" name="telephone" placeholder="" value="<?php echo set_value('telephone', (isset($post_data['telephone']) ? $post_data['telephone'] : '')); ?>" data-error=".telephoneerror" maxlength="20" />
                                <div class="telephoneerror error_msg"><?php echo form_error('telephone', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Pincode:</label>
                                <input type='text' class="form-control validate_integer" id="pincode" name="pincode" placeholder="" value="<?php echo set_value('pincode', (isset($post_data['pincode']) ? $post_data['pincode'] : '')); ?>" data-error=".pincodeerror" maxlength="6" />
                                <div class="pincodeerror error_msg"><?php echo form_error('pincode', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="2" data-error=".addresserror"><?php echo (isset($post_data['address']) ? $post_data['address'] : ''); ?></textarea>
                                <div class="addresserror error_msg"><?php echo form_error('address', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Pan:</label>
                                <input type='text' class="form-control" id="pan" name="pan" placeholder="" value="<?php echo set_value('pan', (isset($post_data['pan']) ? $post_data['pan'] : '')); ?>" data-error=".panerror" maxlength="50" />
                                <div class="panerror error_msg"><?php echo form_error('pan', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Gst:</label>
                                <input type='text' class="form-control" id="gst" name="gst" placeholder="" value="<?php echo set_value('gst', (isset($post_data['gst']) ? $post_data['gst'] : '')); ?>" data-error=".gsterror" maxlength="50" />
                                <div class="gsterror error_msg"><?php echo form_error('gst', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Trade License No:</label>
                                <input type='text' class="form-control" id="trade_license_no" name="trade_license_no" placeholder="" value="<?php echo set_value('trade_license_no', (isset($post_data['trade_license_no']) ? $post_data['trade_license_no'] : '')); ?>" data-error=".tradelicensenoerror" maxlength="50" />
                                <div class="tradelicensenoerror error_msg"><?php echo form_error('trade_license_no', '<label class="danger">', '</label>'); ?></div>
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
                    <div class="row row-sm">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Branch Name</label>
                                <input type='text' class="form-control" id="branch_name" name="branch_name" placeholder="" value="<?php echo set_value('branch_name', (isset($post_data['branch_name']) ? $post_data['branch_name'] : '')); ?>" data-error=".branchnameerror" maxlength="191" />
                                <div class="branchnameerror error_msg"><?php echo form_error('branch_name', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Bank Account:</label>
                                <input type='text' class="form-control" id="bank_account" name="bank_account" placeholder="" value="<?php echo set_value('bank_account', (isset($post_data['bank_account']) ? $post_data['bank_account'] : '')); ?>" data-error=".bankaccounterror" maxlength="50" />
                                <div class="bankaccounterror error_msg"><?php echo form_error('bank_account', '<label class="danger">', '</label>'); ?></div>
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
                    <div class="row row-sm">
                        <div class="col-12">
                            <button class="btn btn-main-primary pd-x-20 mg-t-10" type="submit">Save</button>
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

    $('#type').select2();

    $("#formId").validate({
        rules: {
            franchise_name: {
                required: true,
            },
            your_name: {
                required: true,
            },
            email: {
                required: true,
                email_regex: '#email',
            },
            mobile: {
                required: true,
                mobile_regex: '#mobile',
            },
        },
        messages: {
            franchise_name: {
                required: 'Please enter franchise name',
            },
            your_name: {
                required: 'Please enter your name',
            },
            email:{
                required: 'Please enter email',
                email_regex: 'Please enter valid email',
            },
            mobile:{
                required: 'Please enter mobile number',
                mobile_regex: 'Please enter valid mobile number',
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