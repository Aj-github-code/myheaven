<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
    $profile_pic_url = assets_url('img/faces/6.jpg');
    if(!empty($user_data['profile_pic']))
    {
        $profile_pic_url = content_url('profile/'.$user_data['profile_pic']);
    }
?>

<link rel="stylesheet" type="text/css" href="<?php echo assets_url(); ?>plugins/croppie/croppie.css" />
<link rel="stylesheet" type="text/css" href="<?php echo assets_url(); ?>plugins/croppie/custom_croppie.css" />
<script type="text/javascript" src="<?php echo assets_url(); ?>plugins/croppie/croppie.js"></script>

<div class="card mg-b-20">
    <div class="card-body">
        <div class="pl-0">
            <div class="main-profile-overview">
                <div class="main-img-user profile-user">
                    <img alt="<?php echo $user_data['franchise_name']; ?>" src="<?php echo $profile_pic_url; ?>" id="avatar">
                    <a href="JavaScript:void(0);" class="fas fa-camera profile-edit" id="avatar-camera"></a>
                    <input id="avatar_upload_image" type="file" class="d-none" capture>
                </div>
                <h5 class="main-profile-name"><?php echo $user_data['franchise_name']; ?></h5>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="uploadimageModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Crop Avatar</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body p-b-15">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div id="profile_image_demo" style=""></div>
                    </div>
                    <div class="col-md-4 p-t-0"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-main-primary crop_avatar pd-x-20 mr-2" type="button">Crop & Save</button>
                <button class="btn btn-secondary custom-btn-secondary" id="skip" data-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $image_crop = $('#profile_image_demo').croppie({
            enableExif: true,
            viewport: {
                width: 200,
                height: 200,
                type: 'circle',
            },
            boundary: {
                width: 450,
                height: 300
            }
        });

        $('#avatar_upload_image').on('change', function() {
            var reader = new FileReader();
            var nam;
            if (event.target.value.length > 0) {
                nam = event.target.files[0].name;

                reader.onload = function(event) {
                    $image_crop.croppie('bind', {
                        url: event.target.result
                    }).then(function() {
                    });
                }
                reader.readAsDataURL(this.files[0]);
                $('#uploadimageModal').appendTo("body").modal('show');
            }
        });

        $('.crop_avatar').click(function(event) {
            $image_crop.croppie('result', {
                circle: false,
                type: 'canvas',
                size: 'viewport'
            }).then(function(cropresponse) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: base_url+'<?php echo profile_constants::profile_avatar_url; ?>',
                    data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : $('#<?php echo $this->security->get_csrf_token_name(); ?>').val(), image : cropresponse},
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response){
                        hideLoader();
                        if(response.error == 0)
                        {
                            $('#uploadimageModal').modal('hide');
                            $('#avatar').attr('src', response.profile_pic);
                            $('.mCS_img_loaded').attr('src', response.profile_pic);
                            load_status_popup('success', response.message);
                        }
                        else
                        {
                            load_status_popup('error', response.message);
                        }
                    }
                });
            })
        });
    });

    $("#avatar-camera").click(function(e) {
        $("#avatar_upload_image").click();
    });
</script>