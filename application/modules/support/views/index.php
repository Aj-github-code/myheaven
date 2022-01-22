<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

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
                                <label class="form-label">Subject <span class="asterisk">*</span></label>
                                <input style="color:red" type="text" required maxlength="100" placeholder="Your Subject" required name="subject" data-error=".subjecterror" class="form-control" />
                                <div class="subjecterror error_msg"><?php echo form_error('subject', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Message <span class="asterisk">*</span></label>
                                <input style="color:red" type="text" required maxlength="100" placeholder="Your Message" required name="message" data-error=".messageerror" class="form-control" />
                                <div class="messageerror error_msg"><?php echo form_error('message', '<label class="danger">', '</label>'); ?></div>
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
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-12 mg-t-10 text-right">
                            <button class="btn btn-main-primary pd-x-20 mr-2" type="submit">Save</button>
                            <a href="<?php echo base_url(supports_constants::support_url); ?>" class="btn btn-secondary custom-btn-secondary">Cancel</a>
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

    $("#formId").validate({
        rules: {
            subject: {
                required: true,
            },
            file: {
                required: {
                    depends: function() {
                        if ($('#file_tag').is(":visible") == true) {
                            return false;
                        } else {
                            return true;
                        }
                    }
                },
                extension: 'gif|jpg|jpeg|png'
            },
            message: {
                required: true,
            },
        },
        messages: {
            subject: {
                required: 'Please enter subject',
            },
            file: {
                required: 'Please select file',
                extension: 'Only gif|jpg|jpeg|png files are allowed'
            },
            message: {
                required: 'Please enter message',
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
        errorElement: 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form, event) {
            showLoader();
            form.submit();
        }
    });
</script>