<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="Description" content="<?php echo (isset($meta_description) ? $meta_description : ''); ?>">
        <meta name="Author" content="<?php echo $this->config->item('company'); ?>">
        <meta name="Keywords" content="<?php echo (isset($meta_keywords) ? $meta_keywords : ''); ?>"/>

        <!-- Title -->
        <title><?php echo (isset($meta_title) ? $meta_title : ''); ?></title>

        <!--- Favicon --->
        <link rel="icon" href="<?php echo assets_url(); ?>img/logo/favicon.png" type="image/x-icon"/>

        <!--- css --->
        <link href="<?php echo assets_url(); ?>css/icons.css" rel="stylesheet">
        <link href="<?php echo assets_url(); ?>plugins/sidebar/sidebar.css" rel="stylesheet">
        <link href="<?php echo assets_url(); ?>plugins/mscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet"/>
        <?php if(isset($loggedin) && $loggedin == 'yes'){ ?>
            <link href="<?php echo assets_url(); ?>plugins/pickadate/css/default.css" rel="stylesheet" >
            <link href="<?php echo assets_url(); ?>plugins/pickadate/css/default.date.css" rel="stylesheet" >
            <link href="<?php echo assets_url(); ?>plugins/pickadate/css/default.time.css" rel="stylesheet" >
            <link href="<?php echo assets_url(); ?>plugins/bootstrap-table/css/bootstrap-table.min.css" rel="stylesheet">
            <link href="<?php echo assets_url(); ?>plugins/bootstrap-table/css/bootstrap-editable.css" rel="stylesheet">
            <link href="<?php echo assets_url(); ?>plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet"/>
        <?php } ?>
        <link href="<?php echo assets_url(); ?>css/style.css" rel="stylesheet">
        <link href="<?php echo assets_url(); ?>css/skin-modes.css" rel="stylesheet">
        <link href="<?php echo assets_url(); ?>css/sidemenu.css" rel="stylesheet">
        <link href="<?php echo assets_url(); ?>css/animate.css" rel="stylesheet">
        <link href="<?php echo assets_url(); ?>plugins/select2/css/select2.min.css" rel="stylesheet">
        <link href="<?php echo assets_url(); ?>plugins/sweet-alert/sweetalert.css" rel="stylesheet">
        <link href="<?php echo assets_url(); ?>plugins/toastr/toastr.css" rel="stylesheet">
        <link href="<?php echo assets_url(); ?>css/global.css" rel="stylesheet">
        <link href="<?php echo assets_url(); ?>css/custom.css" rel="stylesheet">
        <link href="<?php echo assets_url(); ?>css/daterangepicker.css" rel="stylesheet">

        <!--- JQuery min js --->
        <script src="<?php echo assets_url(); ?>plugins/jquery/jquery.min.js"></script>
        <script src="<?php echo assets_url(); ?>plugins/jquery_ui/jquery-ui.min.js"></script>
        <script src="<?php echo assets_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo assets_url(); ?>plugins/ionicons/ionicons.js"></script>
        <script src="<?php echo assets_url(); ?>plugins/moment/moment.js"></script>
        <script src="<?php echo assets_url(); ?>js/eva-icons.min.js"></script>
        <script src="<?php echo assets_url(); ?>plugins/select2/js/select2.min.js"></script>
        <script src="<?php echo assets_url(); ?>js/sweetalert2.all.js"></script>
        <script src="<?php echo assets_url(); ?>plugins/toastr/toastr.min.js"></script>
        <script src="<?php echo assets_url(); ?>plugins/validation/jquery.validate.min.js"></script>
        <script src="<?php echo assets_url(); ?>plugins/validation/additional-methods.min.js"></script>

        <?php if(isset($loggedin) && $loggedin == 'yes'){ ?>
            <script src="<?php echo assets_url(); ?>plugins/pickadate/js/picker.js"></script>
            <script src="<?php echo assets_url(); ?>plugins/pickadate/js/picker.date.js"></script>
            <script src="<?php echo assets_url(); ?>plugins/pickadate/js/picker.time.js"></script>
            <script src="<?php echo assets_url(); ?>plugins/pickadate/js/legacy.js"></script>
            <script src="<?php echo assets_url(); ?>plugins/bootstrap-table/js/bootstrap-table.min.js"></script>
            <script src="<?php echo assets_url(); ?>plugins/bootstrap-table/js/bootstrap-table-en-US.js"></script>
            <script src="<?php echo assets_url(); ?>plugins/bootstrap-table/js/tableExport.min.js"></script>
            <script src="<?php echo assets_url(); ?>plugins/bootstrap-table/js/bootstrap-table-export.min.js"></script>
            <script src="<?php echo assets_url(); ?>plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
            <script src="<?php echo assets_url(); ?>js/bootstrap3-typeahead.min.js"></script>
            <script src="<?php echo assets_url(); ?>js/daterangepicker.js"></script>
        <?php } ?>

        <script type="text/javascript">
            var base_url        = "<?php echo base_url(); ?>";
            var content_url     = "<?php echo content_url(); ?>";
            var assets_url      = "<?php echo assets_url(); ?>";
            var mobile_regex    = <?php echo $this->config->item("mobile"); ?>;
            var email_regex     = <?php echo $this->config->item("email"); ?>;

            var csrf_name       = '<?php echo $this->security->get_csrf_token_name(); ?>';
            var csrf_value      = '<?php echo $this->security->get_csrf_hash(); ?>';

            $.validator.addMethod("mobile_regex", function(value, element) {
                return mobile_regex.test(value);
            }, '');

            $.validator.addMethod("email_regex", function(value, element) {
                return email_regex.test(value);
            }, '');

            function get_cart_products_count() {
                $.ajax({
                    type: 'GET',
                    dataType: "json",
                    url: '<?php echo base_url(cart_constants::cart_product_count_url); ?>',
                    data: {},
                    success: function(response) {
                        $('#cart-quantity, #my-cart-quantity').html(response.count);
                    }
                });
            }
            get_cart_products_count();
        </script>

        <script src="<?php echo assets_url(); ?>js/portal.js"></script>

        <?php
            echo Modules::run("alerts/type/toastr", []);
            echo Modules::run("alerts/type/block", []);
            echo Modules::run("loader/content", []);
        ?>
    </head>
    <?php
        if(isset($loggedin) && $loggedin == 'yes')
        {
            $body_class = 'app sidebar-mini';
        }
        else
        {
            $body_class = 'bg-light';
        }
    ?>
    <body class="main-body <?php echo $body_class; ?> franchise">
        <?php echo Modules::run("loader", []); ?>