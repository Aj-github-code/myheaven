<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

		<?php if(isset($loggedin) && $loggedin == 'yes'){ ?>
            <script src="<?php echo assets_url(); ?>plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
            <script src="<?php echo assets_url(); ?>plugins/perfect-scrollbar/p-scroll.js"></script>
			<script src="<?php echo assets_url(); ?>plugins/side-menu/sidemenu.js"></script>
        <?php } ?>

        <script src="<?php echo assets_url(); ?>js/custom.js"></script>
    </body>
</html>