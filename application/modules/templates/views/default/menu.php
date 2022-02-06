<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="main-sidebar app-sidebar sidebar-scroll">
    <div class="main-sidebar-header">
        <a class="desktop-logo logo-light active" href="<?php echo base_url(); ?>" class="text-center mx-auto">
            <img src="<?php echo assets_url(); ?>img/logo/mycomlogo.png" class="main-logo">
        </a>
        <a class="desktop-logo icon-logo active" href="<?php echo base_url(); ?>">
            <img src="<?php echo assets_url(); ?>img/logo/mycomlogo.png" class="logo-icon">
        </a>
        <a class="desktop-logo logo-dark active" href="<?php echo base_url(); ?>">
            <img src="<?php echo assets_url(); ?>img/logo/mycomlogo.png" class="main-logo dark-theme" alt="logo">
        </a>
        <a class="logo-icon mobile-logo icon-dark active" href="<?php echo base_url(); ?>">
            <img src="<?php echo assets_url(); ?>img/logo/mycomlogo.png" class="logo-icon dark-theme" alt="logo">
        </a>
    </div>
    <div class="main-sidebar-loggedin">
        <div class="app-sidebar__user">
            <div class="dropdown user-pro-body text-center">
                <div class="user-pic">
                    <?php
                        $profile_pic_url = assets_url('img/faces/6.jpg');
                        if(!empty($user_data['profile_pic']))
                        {
                            $profile_pic_url = content_url('profile/'.$user_data['profile_pic']);
                        }
                    ?>
                    <img src="<?php echo $profile_pic_url; ?>" alt="<?php echo $user_data['franchise_name']; ?>" class="rounded-circle mCS_img_loaded">
                </div>
                <div class="user-info">
                    <h6 class=" mb-0 text-dark"><?php echo $user_data['franchise_name']; ?></h6>
                    <!-- <span class="text-muted app-sidebar__user-name text-sm">Super Admin</span> -->
                </div>
            </div>
        </div>
    </div><!-- /user -->
    <div class="sidebar-navs">
        <ul class="nav  nav-pills-circle">
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="My Profile" aria-describedby="tooltip365540">
                <a class="nav-link text-center m-2" href="<?php echo base_url(profile_constants::profile_url); ?>">
                    <i class="far fa-user"></i>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Change Password">
                <a class="nav-link text-center m-2" href="<?php echo base_url(password_constants::password_url); ?>">
                    <i class="fas fa-unlock-alt"></i>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sign Out">
                <a class="nav-link text-center m-2" href="<?php echo base_url(signin_constants::logout_url); ?>">
                    <i class="fe fe-power"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="main-sidebar-body">
        <ul class="side-menu ">
            <li class="slide <?php if(isset($menu) && $menu == 'dashboard'){ echo 'active'; } ?>">
                <a class="side-menu__item" href="<?php echo base_url(dashboard_constants::dashboard_url); ?>">
                    <i class="side-menu__icon fe fe-airplay"></i>
                    <span class="side-menu__label">Dashboard</span>
                </a>
            </li>
            <li class="slide <?php if(isset($menu) && $menu == 'overview'){ echo 'active'; } ?>">
                <a class="side-menu__item" href="<?php echo base_url(overview_constants::overview_url); ?>">
                    <i class="side-menu__icon fas fa-dolly-flatbed"></i>
                    <span class="side-menu__label">Overview</span>
                </a>
            </li>
           
            <li class="slide <?php if(isset($menu) && $menu == 'genealogy list'){ echo 'active-menu-expanded is-expanded'; } ?>">
                <a class="side-menu__item <?php if(isset($menu) && $menu == 'genealogy list'){ echo 'active'; } ?>" data-toggle="slide" href="javascript:void(0);">
                    <i class="side-menu__icon icon fa fa-users"></i>
                    <span class="side-menu__label">Genealogy</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li class="<?php if(isset($menu) && $menu == 'left member list' && isset($submenu) && $submenu == 'l_list'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'left member list' && isset($submenu) && $submenu == 'l_list'){ echo 'active'; } ?>" href="<?php echo base_url(genealogy_constants::left_member_url); ?>">Left List</a>
                    </li>
                    <li class="<?php if(isset($menu) && $menu == 'right member' && isset($submenu) && $submenu == 'r_list'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'right member' && isset($submenu) && $submenu == 'r_list'){ echo 'active'; } ?>" href="<?php echo base_url(genealogy_constants::right_member_url); ?>">Right List</a>
                    </li>
                    <li class="<?php if(isset($menu) && $menu == 'direct list' && isset($submenu) && $submenu == 'd_list'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'direct list' && isset($submenu) && $submenu == 'd_list'){ echo 'active'; } ?>" href="<?php echo base_url(genealogy_constants::my_directs_url); ?>">Direct List</a>
                    </li>
                </ul>
            </li>
            <li class="slide <?php if(isset($menu) && $menu == 'binary tree'){ echo 'active-menu-expanded is-expanded'; } ?>">
                <a class="side-menu__item <?php if(isset($menu) && $menu == 'binary tree'){ echo 'active'; } ?>" data-toggle="slide" href="javascript:void(0);">
                    <i class="side-menu__icon icon fa fa-users"></i>
                    <span class="side-menu__label">Network</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li class="<?php if(isset($menu) && $menu == 'binary tree' && isset($submenu) && $submenu == 'b_tree'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'binary tree' && isset($submenu) && $submenu == 'b_tree'){ echo 'active'; } ?>" href="<?php echo base_url(binary_constants::binary_tree_url); ?>">Binary Tree</a>
                    </li>
                    <li class="<?php if(isset($menu) && $menu == 'dircet tree' && isset($submenu) && $submenu == 'd_tree'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'dircet tree' && isset($submenu) && $submenu == 'd_tree'){ echo 'active'; } ?>" href="<?php echo base_url(binary_constants::direct_tree_url); ?>">Direct Tree</a>
                    </li>
                </ul>
            </li>
            <li class="slide <?php if(isset($menu) && $menu == 'payout records'){ echo 'active-menu-expanded is-expanded'; } ?>">
                <a class="side-menu__item <?php if(isset($menu) && $menu == 'payout records'){ echo 'active'; } ?>" data-toggle="slide" href="javascript:void(0);">
                    <i class="side-menu__icon icon fa fa-users"></i>
                    <span class="side-menu__label">Payout</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li class="<?php if(isset($menu) && $menu == 'payout income' && isset($submenu) && $submenu == 'd_tree'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'payout income' && isset($submenu) && $submenu == 'payout'){ echo 'active'; } ?>" href="<?php echo base_url(accounts_constants::payouts_url); ?>">Payout Income</a>
                    </li>
                    <li class="<?php if(isset($menu) && $menu == 'payout records' && isset($submenu) && $submenu == 'payout_records'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'payout records' && isset($submenu) && $submenu == 'payout_records'){ echo 'active'; } ?>" href="<?php echo base_url(accounts_constants::payouts_records_url); ?>">Payout Income Records</a>
                    </li>
                </ul>
            </li>

            <li class="slide <?php if(isset($menu) && $menu == 'join'){ echo 'active'; } ?>">
                <a class="side-menu__item" href="<?php echo base_url(joins_constants::join_link_url); ?>">
                    <i class="side-menu__icon icon ion-ios-list-box"></i>
                    <span class="side-menu__label">Join</span>
                </a>
            </li>
            <li class="slide <?php if(isset($menu) && $menu == 'i_card'){ echo 'active'; } ?>">
                <a class="side-menu__item" href="<?php echo base_url(i_card_constants::i_card_url); ?>">
                    <i class="side-menu__icon icon ion-ios-list-box"></i>
                    <span class="side-menu__label">I Card</span>
                </a>
            </li>
            <li class="slide <?php if(isset($menu) && $menu == 'kyc'){ echo 'active'; } ?>">
                <a class="side-menu__item" href="<?php echo base_url(kyc_constants::kyc_url); ?>">
                    <i class="side-menu__icon icon ion-ios-list-box"></i>
                    <span class="side-menu__label">My Kyc</span>
                </a>
            </li>
            <li class="slide <?php if(isset($menu) && $menu == 'support'){ echo 'active'; } ?>">
                <a class="side-menu__item" href="<?php echo base_url(supports_constants::support_url); ?>">
                    <i class="side-menu__icon icon fa fa-users"></i>
                    <span class="side-menu__label">Support</span>
                </a>
            </li>
            <!-- <li class="slide <?php if(isset($menu) && $menu == 'products'){ echo 'active'; } ?>">
                <a class="side-menu__item" href="<?php echo base_url(products_constants::products_url); ?>">
                    <i class="side-menu__icon fas fa-dolly-flatbed"></i>
                    <span class="side-menu__label">Order Products</span>
                </a>
            </li>
            <li class="slide <?php if(isset($menu) && $menu == 'cart'){ echo 'active'; } ?>">
                <a class="side-menu__item" href="<?php echo base_url(cart_constants::cart_url); ?>">
                    <i class="side-menu__icon icon fa fa-cart-plus"></i>
                    <span class="side-menu__label">My Cart</span>
                    <span class="badge badge-info side-badge" id="my-cart-quantity">0</span>
                </a>
            </li>
            <li class="slide <?php if(isset($menu) && $menu == 'orders'){ echo 'active'; } ?>">
                <a class="side-menu__item" href="<?php echo base_url(orders_constants::orders_url); ?>">
                    <i class="side-menu__icon fe fe-shopping-cart"></i>
                    <span class="side-menu__label">My Product Stock</span>
                </a>
            </li>
            <li class="slide <?php if(isset($menu) && $menu == 'my_products'){ echo 'active'; } ?>">
                <a class="side-menu__item" href="<?php echo base_url(my_products_constants::my_products_url); ?>">
                    <i class="side-menu__icon fas fa-dolly-flatbed"></i>
                    <span class="side-menu__label">My Products</span>
                </a>
            </li>
           
            <li class="slide <?php if(isset($menu) && $menu == 'top_up'){ echo 'active'; } ?>">
                <a class="side-menu__item" href="<?php echo base_url(top_up_constants::top_up_url); ?>">
                    <i class="side-menu__icon fe fe-shopping-cart"></i>
                    <span class="side-menu__label">Top Ups</span>
                </a>
            </li>
            <li class="slide <?php if(isset($menu) && $menu == 'repurchase'){ echo 'active'; } ?>">
                <a class="side-menu__item" href="<?php echo base_url(repurchase_constants::repurchase_url); ?>">
                    <i class="side-menu__icon fe fe-shopping-cart"></i>
                    <span class="side-menu__label">Repurchase</span>
                </a>
            </li>
            <li class="slide <?php if(isset($menu) && $menu == 'customers'){ echo 'active-menu-expanded is-expanded'; } ?>">
                <a class="side-menu__item <?php if(isset($menu) && $menu == 'customers'){ echo 'active'; } ?>" data-toggle="slide" href="javascript:void(0);">
                    <i class="side-menu__icon icon fa fa-users"></i>
                    <span class="side-menu__label">Customers</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li class="<?php if(isset($menu) && $menu == 'customers' && isset($submenu) && $submenu == 'list'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'customers' && isset($submenu) && $submenu == 'list'){ echo 'active'; } ?>" href="<?php echo base_url(customers_constants::customers_url); ?>">List</a>
                    </li>
                    <li class="<?php if(isset($menu) && $menu == 'customers' && isset($submenu) && $submenu == 'add'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'customers' && isset($submenu) && $submenu == 'add'){ echo 'active'; } ?>" href="<?php echo base_url(customers_constants::add_customer_url); ?>">Add</a>
                    </li>
                </ul>
            </li>
            <li class="slide <?php if(isset($menu) && $menu == 'crud'){ echo 'active-menu-expanded is-expanded'; } ?>">
                <a class="side-menu__item <?php if(isset($menu) && $menu == 'crud'){ echo 'active'; } ?>" data-toggle="slide" href="javascript:void(0);">
                    <i class="side-menu__icon icon fa fa-users"></i>
                    <span class="side-menu__label">Crud</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li class="<?php if(isset($menu) && $menu == 'crud' && isset($submenu) && $submenu == 'list'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'crud' && isset($submenu) && $submenu == 'list'){ echo 'active'; } ?>" href="<?php echo base_url(cruds_constants::crud_all_url); ?>">List</a>
                    </li>
                    <li class="<?php if(isset($menu) && $menu == 'crud' && isset($submenu) && $submenu == 'add'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'crud' && isset($submenu) && $submenu == 'add'){ echo 'active'; } ?>" href="<?php echo base_url(cruds_constants::crud_add_url); ?>">Add</a>
                    </li>
                </ul>
            </li>
            <li class="slide <?php if(isset($menu) && $menu == 'payout'){ echo 'active-menu-expanded is-expanded'; } ?>">
                <a class="side-menu__item <?php if(isset($menu) && $menu == 'payout'){ echo 'active'; } ?>" data-toggle="slide" href="javascript:void(0);">
                    <i class="side-menu__icon icon fa fa-users"></i>
                    <span class="side-menu__label">Payout</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li class="<?php if(isset($menu) && $menu == 'payout' && isset($submenu) && $submenu == 'list'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'payout' && isset($submenu) && $submenu == 'list'){ echo 'active'; } ?>" href="<?php echo base_url(payout_constants::payout_url); ?>">List</a>
                    </li>
                    <li class="<?php if(isset($menu) && $menu == 'customers' && isset($submenu) && $submenu == 'add'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'customers' && isset($submenu) && $submenu == 'add'){ echo 'active'; } ?>" href="<?php echo base_url(payout_constants::add_payout_url); ?>">Add</a>
                    </li>
                </ul>
            </li>
            <li class="slide <?php if(isset($menu) && $menu == 'customer_orders'){ echo 'active'; } ?>">
                <a class="side-menu__item" href="<?php echo base_url(customer_orders_constants::customer_orders_url); ?>">
                    <i class="side-menu__icon fe fe-shopping-cart"></i>
                    <span class="side-menu__label">Customer Orders</span>
                </a>
            </li>
            <li class="slide <?php if(isset($menu) && $menu == 'announcements'){ echo 'active'; } ?>">
                <a class="side-menu__item" href="<?php echo base_url(announcements_constants::announcements_url); ?>">
                    <i class="side-menu__icon icon fa fa-bullhorn"></i>
                    <span class="side-menu__label">Announcements</span>
                    <span class="badge badge-info side-badge"><?php echo $announcements_not_seen; ?></span>
                </a>
            </li> -->
        </ul>
    </div>
</aside>