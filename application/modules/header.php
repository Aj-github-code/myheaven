<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="main-content">
    <div class="main-header  side-header">
        <div class="container-fluid">
            <div class="main-header-left ">
                <div class="app-sidebar__toggle mobile-toggle" data-toggle="sidebar">
                    <a class="open-toggle" href="javascript:void(0);"><i class="header-icons" data-eva="menu-outline"></i></a>
                    <a class="close-toggle" href="javascript:void(0);"><i class="header-icons" data-eva="close-outline"></i></a>
                </div>
                <div class="responsive-logo">
                    <a href="<?php echo base_url(); ?>"><img src="<?php echo assets_url(); ?>img/logo/myheavenlogo.png" class="logo-1"></a>
                    <a href="<?php echo base_url(); ?>"><img src="<?php echo assets_url(); ?>img/logo/myheavenlogo.png" class="logo-11"></a>
                    <a href="<?php echo base_url(); ?>"><img src="<?php echo assets_url(); ?>img/logo/myheavenlogo.png" class="logo-2"></a>
                    <a href="<?php echo base_url(); ?>"><img src="<?php echo assets_url(); ?>img/logo/myheavenlogo.png" class="logo-12"></a>
                </div>
            </div>
            <div class="main-header-right">
                <div class="nav nav-item  navbar-nav-right ml-auto">
                    <!-- <div class="nav-item full-screen fullscreen-button">
                        <a class="new nav-link full-screen-link" href="#"><i class="fe fe-maximize"></i></span></a>
                    </div> -->
                    <div class="nav-item main-header-message ">
                        <a class="new nav-link" href="<?php echo cart_constants::cart_url; ?>">
                            <i class="fa fa-cart-plus text-left"></i>
                            <span class="pulse-danger text-white" id="cart-quantity" style="font-weight: 700;font-size: 13px;">0</span>
                        </a>
                    </div>

                    <!-- News Start -->
                    <div class="dropdown  nav-item main-header-message ">
                        <a class="new nav-link" href="javascript:void(0);">
                            <i class="fe fe-mail"></i>
                            <span class="pulse-danger text-white" style="font-weight: 700;font-size: 13px;"><?php echo $news_not_seen_count; ?></span>
                        </a>
                        <div class="dropdown-menu">
                            <?php
                                if($news_not_seen_count > 0)
                                {
                            ?>
                                    <div class="menu-header-content bg-primary-gradient text-left d-flex">
                                        <div class="">
                                            <h6 class="menu-header-title text-white mb-0">News</h6>
                                        </div>
                                        <div class="my-auto ml-auto">
                                            <a class="badge badge-pill badge-warning float-right" href="<?php echo news_constants::mark_all_news_seen_url.'/news'; ?>">Mark All Read</a>
                                        </div>
                                    </div>
                                    <div class="main-message-list chat-scroll">
                                        <?php
                                            foreach ($news_not_seen as $key => $value) {
                                                $description        = strip_tags($value['description']);
                                                if(strlen($description) > 40)
                                                {
                                                    $stringCut      = substr($description, 0, 40);
                                                    $endPoint       = strrpos($stringCut, ' ');
                                                    $description    = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                    $description    .= '...';
                                                }
                                        ?>
                                                <a href="<?php echo news_constants::view_news_url.'/'.$value['id']; ?>" class="p-3 d-flex border-bottom">
                                                    <div class="wd-100p">
                                                        <p class="mb-0 desc"><?php echo $description; ?></p>
                                                    </div>
                                                </a>
                                        <?php
                                            }
                                        ?>
                                    </div>
                            <?php
                                }
                                else
                                {
                            ?>
                                    <div class="menu-header-content bg-primary-gradient text-left d-flex">
                                        <div class="">
                                            <h6 class="menu-header-title text-white mb-0">No Latest News</h6>
                                        </div>
                                    </div>
                                    <div class="main-message-list chat-scroll"></div>
                            <?php
                                }
                            ?>
                            <div class="text-center dropdown-footer">
                                <a href="<?php echo news_constants::news_url; ?>">VIEW ALL</a>
                            </div>
                        </div>
                    </div>
                    <!-- News End -->

                    <div class="dropdown nav-item main-header-notification">
                        <a class="new nav-link" href="javascript:void(0);">
                            <i class="fe fe-bell"></i>
                            <span class="pulse-danger text-white" style="font-weight: 700;font-size: 13px;"><?php echo $messages_not_seen_count; ?></span>
                        </a>
                        <div class="dropdown-menu">
                            <?php
                                if($messages_not_seen_count > 0)
                                {
                            ?>
                                    <div class="menu-header-content bg-primary-gradient text-left d-flex">
                                        <div class="">
                                            <h6 class="menu-header-title text-white mb-0">Messages</h6>
                                        </div>
                                        <div class="my-auto ml-auto">
                                            <a class="badge badge-pill badge-warning float-right" href="<?php echo news_constants::mark_all_news_seen_url.'/messages'; ?>">Mark All Read</a>
                                        </div>
                                    </div>
                                    <div class="main-message-list chat-scroll">
                                        <?php
                                            foreach ($messages_not_seen as $key => $value) {
                                                $description        = strip_tags($value['description']);
                                                if(strlen($description) > 40)
                                                {
                                                    $stringCut      = substr($description, 0, 40);
                                                    $endPoint       = strrpos($stringCut, ' ');
                                                    $description    = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                    $description    .= '...';
                                                }
                                        ?>
                                                <a href="<?php echo messages_constants::view_message_url.'/'.$value['id']; ?>" class="p-3 d-flex border-bottom">
                                                    <div class="wd-100p">
                                                        <p class="mb-0 desc"><?php echo $description; ?></p>
                                                    </div>
                                                </a>
                                        <?php
                                            }
                                        ?>
                                    </div>
                            <?php
                                }
                                else
                                {
                            ?>
                                    <div class="menu-header-content bg-primary-gradient text-left d-flex">
                                        <div class="">
                                            <h6 class="menu-header-title text-white mb-0">No Latest Message</h6>
                                        </div>
                                    </div>
                                    <div class="main-message-list chat-scroll"></div>
                            <?php
                                }
                            ?>
                            <div class="text-center dropdown-footer">
                                <a href="<?php echo messages_constants::messages_url; ?>">VIEW ALL</a>
                            </div>
                        </div>
                    </div>
                    <?php
                        $profile_pic_url = assets_url('img/faces/6.jpg');
                        if(!empty($user_data['profile_pic']))
                        {
                            $profile_pic_url = content_url('profile/'.$user_data['profile_pic']);
                        }
                    ?>
                    <div class="dropdown main-profile-menu nav nav-item nav-link">
                        <a class="profile-user d-flex" href="">
                            <img src="<?php echo $profile_pic_url; ?>" alt="<?php echo $user_data['franchise_name']; ?>" class="rounded-circle mCS_img_loaded"><span></span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="main-header-profile header-img">
                                <div class="main-img-user">
                                    <img alt="<?php echo $user_data['franchise_name']; ?>" src="<?php echo $profile_pic_url; ?>">
                                </div>
                                <h6><?php echo $user_data['franchise_name']; ?></h6>
                                <!-- <span>Super Admin</span> -->
                            </div>
                            <a class="dropdown-item" href="<?php echo base_url(profile_constants::profile_url); ?>"><i class="far fa-user"></i> My Profile</a>
                            <a class="dropdown-item" href="<?php echo base_url(password_constants::password_url); ?>"><i class="fas fa-unlock-alt"></i> Change Password</a>
                            <a class="dropdown-item" href="<?php echo base_url(signin_constants::logout_url); ?>"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>