<html lang="en-US">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <title>Welcome</title>
    <meta name="description" content="Welcome">
    <style type="text/css">
        a:hover {text-decoration: none !important;}
        :focus {outline: none;border: 0;}
    </style>
</head>
<body style="margin: 0px; background-color: #f2f3f8;" cz-shortcut-listen="true" topmargin="0" marginwidth="0" marginheight="0" leftmargin="0" bgcolor="#eaeeef">
    <!--100% body table-->
    <table style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f2f3f8">
        <tbody>
            <tr>
                <td>
                    <table style="background-color: #f2f3f8; max-width:670px; margin:0 auto;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                        <tbody>
                            <tr>
                                <td style="height:80px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">
                                    <a href="<?php echo franchise_url; ?>" title="<?php echo $this->config->item('product_name'); ?>" target="_blank">
                                        <img src="<?php echo assets_url(); ?>img/logo/myheavenlogo.png" title="<?php echo $this->config->item('product_name'); ?>" width="210">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td height="40px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <table style="max-width:600px; background:#fff; border-radius:3px; text-align:left;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);" width="95%" cellspacing="0" cellpadding="0"
                                        border="0" align="center">
                                        <tbody>
                                            <tr>
                                                <td style="padding:40px 40px 30px 40px;">
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <h1 style="color: #1e1e2d; font-weight: 500; margin: 0; font-size: 22px;font-family:'Rubik',sans-serif;">Dear <?php echo $franchise_name; ?>,</h1>
                                                                    <p style="font-size:15px; color:#455056; line-height:24px; margin:8px 0 0;">Thank you for registering with us. Find the login details below:</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 0 40px;">
                                                    <table style="width: 100%; border: 1px solid #ededed" cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                            <tr>
                                                                <td style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">
                                                                    Franchise Name:</td>
                                                                <td style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056; font-weight: 700;">
                                                                    <?php echo $franchise_name; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">
                                                                    Mobile:</td>
                                                                <td style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056; font-weight: 700;">
                                                                    <?php echo $mobile; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">
                                                                    Email:</td>
                                                                <td style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056; font-weight: 700;">
                                                                    <?php echo $email; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 10px; border-right: 1px solid #ededed; width: 35%;font-weight:500; color:rgba(0,0,0,.64)">
                                                                    Password:</td>
                                                                <td style="padding: 10px; color: #455056; font-weight: 700;"><?php echo $password; ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:20px 40px 10px 40px;">
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <p style="font-size:15px; color:#455056; line-height:24px; margin:8px 0 30px;">You can login from the following link: <a href="<?php echo franchise_url; ?>" target="_blank"><b>Login</b></a>.</p>
                                                                    <p style="font-size:15px; color:#455056; line-height:24px; margin:8px 0 30px;">Feel free to contact us for any question.</p>
                                                                    <p style="font-size:15px; color:#455056; line-height:24px; margin:8px 0 30px;">Best Regards,<br><?php echo $this->config->item('product_name'); ?></p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:25px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">
                                    <p style="font-size:14px; color:#455056bd; line-height:18px; margin:0 0 0;">Powered by <a href="<?php echo base_url(); ?>" target="_blank"><strong><?php echo $this->config->item('product_name'); ?></strong></a></p>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:80px;">&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <!--/100% body table-->
</body>
</html>