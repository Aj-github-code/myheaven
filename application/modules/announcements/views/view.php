<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style type="text/css">
    .pdfobject-container {
        width: 100%;
        max-width: 100%;
        height: 600px;
        margin: 2em 0;
    }
</style>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header bd-b">
                <h5 class="card-title mb-0"><?php echo $post_data['title']; ?></h5>
            </div>
            <?php
                if(isset($post_data['description']) && !empty($post_data['description']))
                {
            ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $post_data['description']; ?>
                            </div>
                        </div>
                    </div>
            <?php
                }
            ?>
            <?php
                if(isset($post_data['thumbnail']) && !empty($post_data['thumbnail']))
                {
            ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <img class="card-img-top" src="<?php echo admin_url.'public/content/'.$post_data['thumbnail']; ?>" alt="">
                            </div>
                        </div>
                    </div>
            <?php
                }
            ?>
            <?php
                $attachment     = '';
                if(isset($post_data['file']) && !empty($post_data['file']))
                {
                    $attachment = admin_url.'public/content/'.$post_data['file'];
            ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="attachment_wrap" class="m-auto text-center"></div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            ?>
        </div>
    </div>
</div>

<script src="<?php echo assets_url(); ?>custom_plugins/pdfobject/pdfobject.min.js"></script>

<script type="text/javascript">
    var attachment = '<?php echo $attachment; ?>';
    if(attachment != '')
    {
        PDFObject.embed(attachment, "#attachment_wrap");
    }
</script>