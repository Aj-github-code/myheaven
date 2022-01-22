<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<link href="<?php echo assets_url(); ?>css/gallery.css" rel="stylesheet">

<!-- Modal -->
<div class="modal" id="image_gallery_modal">
    <input type="hidden" name="image_target_id" id="image_target_id" value="">

    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <div class="container wd-100 max-wd-100 m-0">
                    <div class="row wd-100 m-0">
                        <div class="col-md-3 text-left">
                            <h4 class="modal-title white m-t-7">Image Gallery</h4>
                        </div>
                        <div class="col-md-6" id="image_search"></div>
                        <div class="col-md-2" id="image_buttons"></div>
                        <div class="col-md-1">
                            <button aria-label="Close" class="close m-t-10" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card m-b-0" style="box-shadow: 0px 0px 15px -5px #796eb1;">
                            <div class="card-content">
                                <div class="card-body text-center p-25 p-b-0" id="load_images">
                                </div>
                            </div>
                        </div>
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

    function open_image_gallery(target_id='', sel='') {
        $('#image_gallery_modal').modal('show');
        if(typeof target_id == 'string' || target_id instanceof String) {
            target_id = target_id;
        }
        else
        {
            target_id = $(sel).attr('data-id');
        }
        $('#image_target_id').val(target_id);
    }

    function load_images(offset='') {
        var postData                = {};
        postData['<?php echo $this->security->get_csrf_token_name(); ?>'] = $('#<?php echo $this->security->get_csrf_token_name(); ?>').val();
        postData['search']          = $('#search-image-input').val();
        postData['offset']          = offset ? offset : 0;

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(gallery_constants::get_images_url); ?>/'+offset,
            data: postData,
            beforeSend: function() {
                if($('#search-image-input').val() == undefined || $('#search-image-input').val() == '')
                {
                    $('#image_search').html('');
                }
                $('#image_buttons').html('');
                showContentLoader('load_images');
            },
            success: function(html) {
                if($('#search-image-input').val() == undefined || $('#search-image-input').val() == '')
                {
                    $('#image_search').html('<div class="fixed-table-toolbar"><div class="float-right search btn-group"><input class="form-control search-input search-image-input" type="text" placeholder="Search image here..." id="search-image-input"></div></div>');
                }
                
                $('#image_buttons').append('<button type="button" class="btn btn-main-primary wd-100" id="load_image_form" onclick="load_image_form();">Upload Image</button>');
                $('#load_images').html(html);
                hideContentLoader('load_images');
            }
        });
    }

    function load_image_form() {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url(gallery_constants::load_image_form_url); ?>',
            dataType: 'HTML',
            data: {},
            beforeSend: function() {
                $('#image_search').html('');
                $('#image_buttons').html('');
                showContentLoader('load_images');
            },
            success: function(data){
                $('#load_images').html(data);
                $('#image_buttons').append('<button type="button" class="btn btn-main-primary wd-100" id="load_images_list" onclick="load_images(0);">Open Images</button>');
                hideContentLoader('load_images');
            }
        });
    }

    function delete_gallery_image(id='') {
        if(id != '')
        {
            var postData                = {};
            postData['<?php echo $this->security->get_csrf_token_name(); ?>'] = $('#<?php echo $this->security->get_csrf_token_name(); ?>').val();
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

    function select_gallery_image(image) {
        $('#'+$('#image_target_id').val()).val(image);
        $('#image_gallery_modal').modal('hide');
    }

    $("#image_gallery_modal").on("show.bs.modal", function(e) {
        load_images(0);
    });

    $("#image_gallery_modal").on("hide.bs.modal", function(e) {
        $('#image_search').html('');
        $('#image_buttons').html('');
        $('#load_images').html('');
    });
</script>