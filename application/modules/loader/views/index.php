<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style type="text/css">
    .loader { position: fixed; width: 100%; height: 100%; background: #ffffffb8; z-index: 99999; top: 0px; left: 0px; text-align: center; }
    .loader_visible { display: block; }
    .loader_hidden { display: none; }
    .loader img { position: relative; top: 45%; }
</style>

<div class="loader loader_hidden">
    <img src="<?php echo assets_url(); ?>img/loaders/loader.gif" alt="<?php echo $this->config->item('product_name'); ?>">
</div>

<script type="text/javascript">
    function showLoader() {
        $('.loader').removeClass('loader_hidden');
        $('.loader').removeAttr('style');
    }

    function hideLoader() {
        setTimeout(function() {
            $(".loader").fadeOut("slow");
        }, 200);
    }

    showLoader();

    $(window).on('load', function(){
        hideLoader();
    });
</script>