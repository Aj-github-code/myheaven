<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row" id="image-list">
    <?php
        if(isset($images) && !empty($images))
        {
            foreach ($images as $key => $value) {
    ?>
                <div class="col-sm-4 col-md-3 col-lg-2 text-center gallery-img">
                    <div class="tile-basic">
                        <div class="tile-image">
                            <img src="<?php echo content_url($value['image']); ?>" alt="" class="small-img img-fluid">
                            <div class="tile-image-title">
                                <p><?php echo $value['name']; ?></p>
                            </div>
                            <div class="tile-image-hover">
                                <button type="button" class="btn btn-danger delete-img gallery-img-delete" onclick="delete_gallery_image('<?php echo $value['id']; ?>');">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <div class="tile-image-container-vertical text-center">
                                    <button type="button" class="btn btn-info btn-sm btn-icon-fixed copy-path original-path" data-clipboard-text="<?php echo $value['image']; ?>" onclick="select_gallery_image('<?php echo $value['image']; ?>');">
                                        <i class="ft-copy" aria-hidden="true"></i> Select Image
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <?php
            }
        }
        else
        {
    ?>
            <div class="col-sm-12 col-md-12 col-lg-12 text-center p-b-25">
                <img src="<?php echo assets_url('img/defaults/no-image-available.jpg'); ?>" alt="">
            </div>
    <?php
        }
    ?>
</div>

<div class="row">
    <div class="col-lg-12 image-pagination" id="pagination">
        <?php
            if(isset($pagination) && !empty($pagination))
            {
                echo $pagination;
            }
            else
            {
                if(isset($see_all) && !empty($see_all))
                {
        ?>
                    <a class="see_all" href="<?php echo $see_all; ?>">See All</a>
        <?php
                }
            }
        ?>
    </div>
</div>