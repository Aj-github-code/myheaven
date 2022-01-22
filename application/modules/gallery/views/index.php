<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<link href="<?php echo assets_url(); ?>css/gallery.css" rel="stylesheet">

<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header bd-b">
                <h5 class="card-title mb-0">Image Gallery</h5>
            </div>
            <div class="card-body">
                <div class="row wd-100 m-0">
                    <div class="col-md-10">
                        <div class="fixed-table-toolbar wd-100">
                            <div class="search btn-group wd-100">
                                <input class="form-control search-input search-image-input" type="text" placeholder="Search image here..." id="search-image-input">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <a href="<?php echo base_url(gallery_constants::upload_image_form_url); ?>" class="btn btn-main-primary wd-100" id="load_image_form">Upload Image</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" id="image-gallery">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-12 col-lg-12" id="load_images">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).on('click', '.image-pagination a', function(e){
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        load_images(pageno);
    });

    var searchtimeout   = null;

    $(document).on('keyup', '.search-image-input', function(e) {
        clearTimeout(searchtimeout);
        searchtimeout = setTimeout(function () {
            load_images(0);
        }, 600);
    });

    function delete_gallery_image(id='') {
        if(id != '')
        {
            var postData                = {};
            postData['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
            postData['id']              = id;
            postData['status']          = '-1';

            var message                 = 'Do you really want to delete this image?';
            var btn_text                = 'Yes, Delete it!';

            swal({
                title: "Are you sure?",
                text: message,
                type: "warning",
                showCancelButton: true,
                confirmButtonText: btn_text,
            }).then(function (result) {
                if(result.value)
                {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: '<?php echo base_url(gallery_constants::change_image_status_url); ?>',
                        async: false,
                        data: postData,
                        beforeSend: function() {
                            showContentLoader('load_images');
                        },
                        success: function(response){
                            hideContentLoader('load_images');
                            if(response.error == 1)
                            {
                                load_status_popup('error', response.message);
                            }
                            else
                            {
                                load_status_popup('success', response.message);
                                load_images(0);
                            }
                        }
                    });
                }
            }, function(dismiss) {});
        }
    }

    function load_images(offset='') {
        var postData        = {};
        postData['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
        postData['search']  = $('#search-image-input').val();
        postData['offset']  = offset ? offset : 0;

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(gallery_constants::get_images_url); ?>/'+offset,
            data: postData,
            beforeSend: function() {
                showContentLoader('load_images');
            },
            success: function(html) {
                $('#load_images').html(html);
                hideContentLoader('load_images');
            }
        });
    }

    load_images(0);
</script>