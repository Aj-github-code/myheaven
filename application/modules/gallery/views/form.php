<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header bd-b">
                <h5 class="card-title mb-0">Upload Image</h5>
            </div>
            <div class="card-body">
                <form name="vasplus_form_id" id="vasplus_form_id" action="javascript:void(0);" enctype="multipart/form-data">
                    <div class="row wd-100 m-0">
                        <div class="col-lg-12 col-md-12" id="input_file_wrap">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="vasplus_multiple_files" id="vasplus_multiple_files" accept=".jpg, .png, image/jpeg, image/png" multiple> <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 d-none" id="upload_images_wrap">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <input type="hidden" id="added_class" value="vpb_blue">
                                    <span id="vpb_removed_files"></span>

                                    <div class="table-responsive">
                                        <table class="table table-bordered mg-b-1 text-md-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                    <th>Size</th>
                                                    <th>Date</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="vpb_added_files_box"></tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 mt-4">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <input type="submit" value="Upload" class="vpb_general_button btn btn-main-primary wd-100" />
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <a href="<?php echo base_url(gallery_constants::upload_image_form_url); ?>" class="btn btn-secondary custom-btn-secondary wd-100">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<link href="<?php echo assets_url(); ?>custom_plugins/multiple_file_uploader/css/uploader.css?time=<?php echo date('YmdHis'); ?>" rel="stylesheet">
<script src="<?php echo assets_url(); ?>custom_plugins/multiple_file_uploader/js/uploader.js"></script>

<script type="text/javascript">
    $(document).ready(function()
    {
        new vpb_multiple_file_uploader
        ({
            vpb_form_id: "vasplus_form_id", // Form ID
            autoSubmit: true,
            vpb_server_url: base_url+"<?php echo gallery_constants::ajax_upload_image_url; ?>" // PHP file for uploading the browsed files
            // To modify the design and display of the browsed file,
            // Open the file named js/vpb_uploader.js and search for the following: /* Display added files which are ready for upload */
            // You can modify the design and display of browsed files and also the CSS file as wish.
        });
    });
</script>