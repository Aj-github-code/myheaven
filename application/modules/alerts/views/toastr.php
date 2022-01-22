<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script type="text/javascript">
    function load_status_popup(type, message) {
        if(type == 'warning')
        {
            toastr.warning(message, "Warning!", {
                progressBar: 1
            });
        }
        else if(type == 'info')
        {
            toastr.info(message, "Heads up!", {
                progressBar: 1
            });
        }
        else if(type == 'error')
        {
            toastr.error(message, "Oh snap!", {
                progressBar: 1
            });
        }
        else if(type == 'success')
        {
            toastr.success(message, "Well done!", {
                progressBar: 1
            });
        }
    }
</script>

<?php
    $status = $this->session->flashdata('status');
    if(isset($status['error']) && $status['message'] != '')
    {
?>
        <script type="text/javascript">
            $(document).ready(function() {
                var errorstatus = '<?php echo $status["error"]; ?>';
                var message = '<?php echo $status["message"]; ?>';

                if(errorstatus == 1)
                {
                    var toast_type = 'error';
                }
                else if(errorstatus == 2)
                {
                    var toast_type = 'warning';
                }
                else if(errorstatus == 3)
                {
                    var toast_type = 'info';
                }
                else
                {
                    var toast_type = 'success';
                }

                load_status_popup(toast_type, message);
            });
        </script>
<?php
    }
?>