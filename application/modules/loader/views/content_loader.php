<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style type="text/css">
    .content_loader_wrap { position: relative; }
    .content_loader { position: absolute; width: 100%; height: 100%; background: #ffffffb8; z-index: 99999; top: 0px; left: 0px; text-align: center; }
    .content_loader_visible { display: block; }
    .content_loader_hidden { display: none; }
    .content_loader img { position: relative; top: 27%; width: 70px; }
</style>

<script type="text/javascript">
    var loader_content = '<div class="content_loader content_loader_hidden"><img src="<?php echo assets_url(); ?>img/loaders/loader.gif" alt="<?php echo $this->config->item('product_name'); ?>"></div>';

    function showContentLoader(id) {
        $('#'+id).addClass('content_loader_wrap');
        $('#'+id).append(loader_content);
        $('.content_loader').removeClass('content_loader_hidden');
        $('.content_loader').removeAttr('style');
    }

    function hideContentLoader(id) {
        $('#'+id).find('.content_loader').remove();
        $('#'+id).removeClass('content_loader_wrap');
    }
</script>