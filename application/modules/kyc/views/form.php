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
                                <label class="form-label">Type <span class="asterisk">*</span></label>
                                <select class="select2" name="type" id="type" style="width: 100%;" data-error=".typeerror" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="Registration Form" <?php if(isset($post_data['type']) && $post_data['type'] == 'Registration Form'){ echo 'selected="selected"'; } ?>>Registration Form</option>
                                    <option value="Pan Front" <?php if(isset($post_data['type']) && $post_data['type'] == 'Pan Front'){ echo 'selected="selected"'; } ?>>Pan Front</option>
                                    <option value="Pan Back" <?php if(isset($post_data['type']) && $post_data['type'] == 'Pan Back'){ echo 'selected="selected"'; } ?>>Pan Back</option>
                                    <option value="Gst" <?php if(isset($post_data['type']) && $post_data['type'] == 'Gst'){ echo 'selected="selected"'; } ?>>Gst</option>
                                    <option value="Cross Chequebook Copy" <?php if(isset($post_data['type']) && $post_data['type'] == 'Cross Chequebook Copy'){ echo 'selected="selected"'; } ?>>Cross Chequebook Copy</option>
                                    <option value="Passbook" <?php if(isset($post_data['type']) && $post_data['type'] == 'Passbook'){ echo 'selected="selected"'; } ?>>Passbook</option>
                                    <option value="ID Proof" <?php if(isset($post_data['type']) && $post_data['type'] == 'ID Proof'){ echo 'selected="selected"'; } ?>>ID Proof</option>
                                    <option value="Passport Size Photo" <?php if(isset($post_data['type']) && $post_data['type'] == 'Passport Size Photo'){ echo 'selected="selected"'; } ?>>Passport Size Photo</option>
                                    <option value="Address Proof Copy" <?php if(isset($post_data['type']) && $post_data['type'] == 'Address Proof Copy'){ echo 'selected="selected"'; } ?>>Address Proof Copy</option>
                                    <option value="Trade License" <?php if(isset($post_data['type']) && $post_data['type'] == 'Trade License'){ echo 'selected="selected"'; } ?>>Trade License</option>
                                    <option value="Aadhar Front" <?php if(isset($post_data['type']) && $post_data['type'] == 'Aadhar Front'){ echo 'selected="selected"'; } ?>>Aadhar Front</option>
                                    <option value="Aadhar Back" <?php if(isset($post_data['type']) && $post_data['type'] == 'Aadhar Back'){ echo 'selected="selected"'; } ?>>Aadhar Back</option>
                                </select>
                                <div class="typeerror error_msg"><?php echo form_error('type', '<label class="danger">', '</label>'); ?></div>
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

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>File <span class="asterisk">*</span></label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file" name="file" required data-error=".fileerror">
                                            <label class="custom-file-label" for="file">Choose file</label>
                                        </div>
                                        <div class="fileerror error_msg"><?php echo form_error('file', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                                <?php if(isset($post_data['file']) && !empty($post_data['file'])){ ?>
                                    <div class="col-md-12" id="file_wrap">
                                        <div class="row m-b-20">
                                            <div class="col-md-12">
                                                <a href="<?php echo content_url($post_data['file']); ?>" target="_blank" id="file_tag"><?php echo basename(parse_url($post_data['file'], PHP_URL_PATH)); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-12 mg-t-10 text-right">
                            <button class="btn btn-main-primary pd-x-20 mr-2" type="submit">Save</button>
                            <a href="<?php echo base_url(kyc_constants::kyc_url); ?>" class="btn btn-secondary custom-btn-secondary">Cancel</a>
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

    $("#formId").validate({
        rules: {
            type: {
                required: true,
            },
            file: {
                required: {
                    depends: function() {
                        if($('#file_tag').is(":visible") == true)
                        {
                            return false;
                        }
                        else
                        {
                            return true;
                        }
                    }
                },
                extension: 'pdf|odt|xls|xlsx|ods|ppt|pptx|txt|doc|docx|jpg|jpeg|png'
            },
            status: {
                required: true,
            },
        },
        messages: {
            type: {
                required: 'Please select type',
            },
            file: {
                required: 'Please select file',
                extension: 'Only pdf|odt|xls|xlsx|ods|ppt|pptx|txt|doc|docx|jpg|jpeg|png files are allowed'
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
            showLoader();
            form.submit();
        }
    });
</script>