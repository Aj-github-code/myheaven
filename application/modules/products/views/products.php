<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
    if(isset($result) && !empty($result))
    {
?>
        <div class="col-lg-12">
            <?php echo Modules::run("products/grid", $result); ?>
        </div>
        
        <div class="col-lg-12" id="pagination">
            <?php if(isset($pagination) && !empty($pagination)){ echo $pagination; } ?>
        </div>
<?php
    }
    else
    {
?>
        <div class="col-lg-12">
            <h3><center>Sorry, no product found.</center></h3>
        </div>
<?php
    }
?>