<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row text-left m-b-5">
    <div class="col-lg-12">
        <form id="imageFormId" class="" method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

            <div class="row">
                <div class="col-md-4 text-left">
                    <div class="form-group">
                        <label class="form-label">Browse Image <span class="asterisk">*</span></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="file" required data-error=".imageerror">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                        <div class="imageerror error_msg"><?php echo form_error('image', '<label class="danger">', '</label>'); ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Name <span class="asterisk">*</span></label>
                        <input type='text' class="form-control" id="image_name" name="image_name" placeholder="" value="" data-error=".imagenameerror" maxlength="255" required/>
                        <div class="imagenameerror error_msg"><?php echo form_error('image_name', '<label class="danger">', '</label>'); ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-main-primary mr-1 m-t-25">Upload</button>
                    <button type="button" class="btn btn-secondary custom-btn-secondary m-t-25" onclick="load_images(0);">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $('#image').change(function() {
        var file = $('#image')[0].files[0];
        if(file)
        {
            var image_data  = file.name.split('.');
            var image_name  = image_data[0];
            var image_ext   = image_data[1];

            if(image_ext == 'jpg' || image_ext == 'jpeg' || image_ext == 'png')
            {
                $('#image_name').val(image_name);
            }
        }
    });

    $("#imageFormId").validate({
        rules: {
            image_name: {
                required: true,
            },
            image: {
                required: true,
                extension: 'png|jpg|jpeg'
            },
        },
        messages: {
            image_name: {
                required: 'Please enter name',
            },
            image: {
                required: 'Please browse image',
                extension: 'Only png|jpg|jpeg are allowed'
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
            var formData = new FormData(form);

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(gallery_constants::upload_image_url); ?>',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    showContentLoader('load_images');
                },
                success: function(data){
                    hideContentLoader('load_images');
                    if(data.error == 2)
                    {
                        load_status_popup('error', data.message);
                    }
                    else if(data.error == 1)
                    {
                        load_status_popup('error', data.message);
                    }
                    else
                    {
                        load_status_popup('success', data.message);
                        load_images(0);
                    }
                }
            });
        }
    });
</script>