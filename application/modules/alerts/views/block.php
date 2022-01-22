<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script type="text/javascript">
    function show_content_alert(id, type, message) {
        var bg_class    = '';
        var alert_icon  = '';
        var alert_head  = '';

        if(type == 'warning')
        {
            bg_class    = 'bg-warning';
            alert_icon  = 'ft-watch';
            alert_head  = 'Warning';
        }
        else if(type == 'info')
        {
            bg_class    = 'bg-info';
            alert_icon  = 'ft-video';
            alert_head  = 'Heads up';
        }
        else if(type == 'error')
        {
            bg_class    = 'bg-danger';
            alert_icon  = 'ft-thumbs-down';
            alert_head  = 'Oh snap';
        }
        else if(type == 'success')
        {
            bg_class    = 'bg-success';
            alert_icon  = 'ft-thumbs-up';
            alert_head  = 'Well done';
        }

        var alert_content = '<div class="alert '+bg_class+' alert-icon-left alert-dismissible mb-2" role="alert"><span class="alert-icon"><i class="'+alert_icon+'"></i></span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>'+alert_head+'!</strong> '+message+'</div>';

        $('#'+id).html(alert_content);
    }
</script>