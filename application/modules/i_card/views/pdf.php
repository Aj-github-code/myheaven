<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html style="width:100%;font-family:tahoma, verdana, segoe, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;margin:0;">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <meta name="x-apple-disable-message-reformatting">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="telephone=no" name="format-detection">
        <title>I-Card</title>
    </head>
    <body style="width:100%;font-family:tahoma, verdana, segoe, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;margin:0;">
        <div style="background-color:#fff;">
            <table align="center" class="es-wrapper" width="500" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;">
                <tr style="border-collapse:collapse;">
                    <td valign="top" style="padding:0;margin:0;">
                        <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
                            <tr style="border-collapse:collapse;">
                                <td align="center" style="padding:0;margin:0;">
                                    <table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;font-size: 14px;">
                                        <tr style="border-collapse:collapse;">
                                            <td align="center" style="margin:0;padding-top:0;padding-bottom:0;padding-left:0;padding-right:0;">
                                                <table cellpadding="0" width="100%" cellspacing="0" class="es-left" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;">
                                                    <tr style="border-collapse:collapse;">
                                                        <td width="100%" class="es-m-p20b" align="center" style="padding: 0; margin: 0;">
                                                            <br/><br/>
                                                            <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                                                <tr style="border-collapse:collapse;">
                                                                    <th align="center" style="padding:0;margin:0; color: #000;text-align: center;margin-top: 0;background-color: #00CC00; color: #002060;">
                                                                        <div style="line-height:18px;text-align: center;font-size: 18px;font-weight: bold;">MY HEAVEN MARKETING PVT. LTD.<br/></div>
                                                                    </th>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <br/>

                            <tr style="border-collapse:collapse;">
                                <td align="center" style="padding:0;margin:0;">
                                    <table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;border-bottom: none;">
                                        <tr style="border-collapse:collapse;">
                                            <td align="left" style="margin:0;padding:0 15px 0 15px;" width="225">
                                                <table cellpadding="0" cellspacing="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;">
                                                    <tr style="border-collapse:collapse;" >
                                                        <td width="385" align="left" style="padding: 0 25px 0 0; margin: 0;">
                                                            <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                                                <tr style="border-collapse:collapse;">
                                                                    <td align="center" style="padding:0;margin:0;">
                                                                        <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                                                            <tr style="border-collapse:collapse;">
                                                                                <td align="left" style="padding:40px 0 0 0;margin:0;text-align: left;">
                                                                                    <?php
                                                                                        $profile_pic_url = getcwd().'/source/backend_assets/img/faces/6.jpg';
                                                                                        if(!empty($user_data['profile_pic']))
                                                                                        {
                                                                                            $profile_pic_url = getcwd().'/'.$this->config->item('content_path').'profile/'.$user_data['profile_pic'];
                                                                                        }
                                                                                    ?>
                                                                                    <img src="<?php echo $profile_pic_url; ?>" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;" width="180">
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td align="left" style="margin:0;padding:0 15px 0 15px; " width="315">
                                                <table cellpadding="0" cellspacing="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;">
                                                    <tr style="border-collapse:collapse;">
                                                        <td align="left" style="padding: 25px 0 25px 25px; margin: 0;">
                                                            <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                                                <tr style="border-collapse:collapse;">
                                                                    <td align="center" style="padding:0;margin:0;">
                                                                        <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                                                            <tr style="border-collapse:collapse;">
                                                                                <td align="center" style="padding:0;margin:0; font-size: 13px;">
                                                                                    <h2 style="font-size: 13px;margin: 0; padding: 0;text-align: center;color: #fd6600;text-align: left;line-height: 8px;"><?php echo $user_data['franchise_name']; ?></h2>
                                                                                    <p style="margin: 0 0 0 0;text-align: left;"><?php
                                                                                            echo '<b>ID:</b> '.$user_data['franchise_code'];
                                                                                            echo '<br>';
                                                                                            echo '<b>PAN:</b> '.$user_data['pan'];
                                                                                            echo '<br>';
                                                                                            echo '<b>GST:</b> '.$user_data['gst'];
                                                                                            echo '<br>';
                                                                                            echo '<b>License:</b> '.$user_data['trade_license_no'];
                                                                                            echo '<br>';
                                                                                            echo '<b>Mob:</b> '.$user_data['mobile'];
                                                                                            echo '<br>';
                                                                                            echo '<b>Email:</b> '.$user_data['email'];
                                                                                            echo '<br>';
                                                                                            echo '<b>Address:</b> '.$user_data['address'];
                                                                                            echo '<br>';
                                                                                            echo '<b>Pincode:</b> '.$user_data['pincode'];
                                                                                            echo '<br>';
                                                                                        ?></p>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>