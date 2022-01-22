<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="main-content-label tx-13 mg-b-25">Details</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="main-profile-contact-list">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-12 mg-b-30">
                                    <div class="media">
                                        <div class="media-icon bg-primary-transparent text-primary">
                                            <i class="la la-bar-chart"></i>
                                        </div>
                                        <div class="media-body">
                                            <span>Name</span>
                                            <div><?php echo $user_data['franchise_name']; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-12 mg-b-30">
                                    <div class="media">
                                        <div class="media-icon bg-success-transparent text-success">
                                            <i class="la la-hashtag"></i>
                                        </div>
                                        <div class="media-body">
                                            <span>ID</span>
                                            <div><?php echo $user_data['franchise_code']; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-12 mg-b-30">
                                    <div class="media">
                                        <div class="media-icon bg-success-transparent text-success">
                                            <i class="icon ion-logo-slack"></i>
                                        </div>
                                        <div class="media-body">
                                            <span>Holder Name</span>
                                            <div><?php echo $user_data['your_name']; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-12 mg-b-30">
                                    <div class="media">
                                        <div class="media-icon bg-info-transparent text-info">
                                            <i class="la la-user"></i>
                                        </div>
                                        <div class="media-body">
                                            <span>Type</span>
                                            <div><?php echo $user_data['type']; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-12 mg-b-30">
                                    <div class="media">
                                        <div class="media-icon bg-primary-transparent text-primary">
                                            <i class="la la-envelope"></i>
                                        </div>
                                        <div class="media-body">
                                            <span>Email</span>
                                            <div><?php echo $user_data['email']; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-12 mg-b-30">
                                    <div class="media">
                                        <div class="media-icon bg-success-transparent text-success">
                                            <i class="la la-phone"></i>
                                        </div>
                                        <div class="media-body">
                                            <span>Mobile</span>
                                            <div><?php echo $user_data['mobile']; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-12 mg-b-30">
                                    <div class="media">
                                        <div class="media-icon bg-success-transparent text-success">
                                            <i class="la la-hashtag"></i>
                                        </div>
                                        <div class="media-body">
                                            <span>PAN</span>
                                            <div><?php echo $user_data['pan']; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-12 mg-b-30">
                                    <div class="media">
                                        <div class="media-icon bg-info-transparent text-info">
                                            <i class="la la-hashtag"></i>
                                        </div>
                                        <div class="media-body">
                                            <span>GST</span>
                                            <div><?php echo $user_data['gst']; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-12 mg-b-30">
                                    <div class="media">
                                        <div class="media-icon bg-info-transparent text-info">
                                            <i class="la la-hashtag"></i>
                                        </div>
                                        <div class="media-body">
                                            <span>License</span>
                                            <div><?php echo $user_data['trade_license_no']; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-12 mg-b-30">
                                    <div class="media">
                                        <div class="media-icon bg-info-transparent text-info">
                                            <i class="icon ion-md-locate"></i>
                                        </div>
                                        <div class="media-body">
                                            <span>Address</span>
                                            <div><?php echo $user_data['address']; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-12 mg-b-30">
                                    <div class="media">
                                        <div class="media-icon bg-info-transparent text-info">
                                            <i class="icon ion-md-locate"></i>
                                        </div>
                                        <div class="media-body">
                                            <span>Pincode</span>
                                            <div><?php echo $user_data['pincode']; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="card overflow-hidden project-card">
            <a href="<?php echo base_url(my_products_constants::my_products_url); ?>">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="my-auto">
                            <i class="fas fa-dolly-flatbed" style="margin: 0 10px 0 -10px;opacity: 1;color: #000 !important;font-size: 50px;"></i>
                        </div>
                        <div class="project-content">
                            <h6 style="color: #000;">My Products</h6>
                            <ul>
                                <li>
                                    <b class="tx-success">Active</b>
                                    <span style="color: #0ba360 !important;"><?php echo $myproducts; ?></span>
                                </li>
                                <li>
                                    <b class="tx-danger">&nbsp;</b>
                                    <span style="color: #f53c5b !important;">&nbsp;</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="card overflow-hidden project-card">
            <a href="<?php echo base_url(orders_constants::orders_url); ?>">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="my-auto">
                            <i class="fe fe-shopping-cart" style="margin: 0 10px 0 -10px;opacity: 1;color: #000 !important;font-size: 55px;"></i>
                        </div>
                        <div class="project-content">
                            <h6 style="color: #000;">My Orders</h6>
                            <ul>
                                <li>
                                    <b class="tx-success">Completed</b>
                                    <span style="color: #0ba360 !important;"><?php echo $orders['completed']; ?></span>
                                </li>

                                <li>
                                    <b class="tx-danger">Pending</b>
                                    <span style="color: #f53c5b !important;"><?php echo $orders['pending']; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="card overflow-hidden project-card">
            <a href="<?php echo base_url(top_up_constants::top_up_url); ?>">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="my-auto">
                            <i class="fe fe-shopping-cart" style="margin: 0 10px 0 -10px;opacity: 1;color: #000 !important;font-size: 55px;"></i>
                        </div>
                        <div class="project-content">
                            <h6 style="color: #000;">Topup Orders</h6>
                            <ul>
                                <li>
                                    <b class="tx-success">Completed</b>
                                    <span style="color: #0ba360 !important;"><?php echo $top_up_orders['completed']; ?></span>
                                </li>

                                <li>
                                    <b class="tx-danger">Pending</b>
                                    <span style="color: #f53c5b !important;"><?php echo $top_up_orders['pending']; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="card overflow-hidden project-card">
            <a href="<?php echo base_url(repurchase_constants::repurchase_url); ?>">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="my-auto">
                            <i class="fe fe-shopping-cart" style="margin: 0 10px 0 -10px;opacity: 1;color: #000 !important;font-size: 55px;"></i>
                        </div>
                        <div class="project-content">
                            <h6 style="color: #000;">Repurchase Orders</h6>
                            <ul>
                                <li>
                                    <b class="tx-success">Completed</b>
                                    <span style="color: #0ba360 !important;"><?php echo $repurchase_orders['completed']; ?></span>
                                </li>

                                <li>
                                    <b class="tx-danger">Pending</b>
                                    <span style="color: #f53c5b !important;"><?php echo $repurchase_orders['pending']; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="card overflow-hidden project-card">
            <a href="<?php echo base_url(customer_orders_constants::customer_orders_url); ?>">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="my-auto">
                            <i class="fe fe-shopping-cart" style="margin: 0 10px 0 -10px;opacity: 1;color: #000 !important;font-size: 55px;"></i>
                        </div>
                        <div class="project-content">
                            <h6 style="color: #000;">Customer Orders</h6>
                            <ul>
                                <li>
                                    <b class="tx-success">Completed</b>
                                    <span style="color: #0ba360 !important;"><?php echo $customer_orders['completed']; ?></span>
                                </li>

                                <li>
                                    <b class="tx-danger">Pending</b>
                                    <span style="color: #f53c5b !important;"><?php echo $customer_orders['pending']; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="card overflow-hidden project-card">
            <a href="<?php echo base_url(announcements_constants::announcements_url); ?>">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="my-auto">
                            <i class="fa fa-bullhorn" style="margin: 0 10px 0 -10px;opacity: 1;color: #000 !important;font-size: 55px;"></i>
                        </div>
                        <div class="project-content">
                            <h6 style="color: #000;">Announcements</h6>
                            <ul>
                                <li>
                                    <b class="tx-success">Active</b>
                                    <span style="color: #0ba360 !important;"><?php echo $announcements['active']; ?></span>
                                </li>

                                <li>
                                    <b class="tx-danger">In-Active</b>
                                    <span style="color: #f53c5b !important;"><?php echo $announcements['inactive']; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="card overflow-hidden project-card">
            <a href="<?php echo base_url(news_constants::news_url); ?>">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="my-auto">
                            <i class="fa fa-bullhorn" style="margin: 0 10px 0 -10px;opacity: 1;color: #000 !important;font-size: 55px;"></i>
                        </div>
                        <div class="project-content">
                            <h6 style="color: #000;">News</h6>
                            <ul>
                                <li>
                                    <b class="tx-success">Active</b>
                                    <span style="color: #0ba360 !important;"><?php echo $news['news']; ?></span>
                                </li>

                                <li>
                                    <b class="tx-danger">&nbsp;</b>
                                    <span style="color: #f53c5b !important;">&nbsp;</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="card overflow-hidden project-card">
            <a href="<?php echo base_url(messages_constants::messages_url); ?>">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="my-auto">
                            <i class="fa fa-bullhorn" style="margin: 0 10px 0 -10px;opacity: 1;color: #000 !important;font-size: 55px;"></i>
                        </div>
                        <div class="project-content">
                            <h6 style="color: #000;">Messages</h6>
                            <ul>
                                <li>
                                    <b class="tx-success">Active</b>
                                    <span style="color: #0ba360 !important;"><?php echo $news['messages']; ?></span>
                                </li>

                                <li>
                                    <b class="tx-danger">&nbsp;</b>
                                    <span style="color: #f53c5b !important;">&nbsp;</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-header pt-4 pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-10 ">Purchase Statistics</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
            </div>
            <div class="pl-4 pr-4 pt-4 pb-3">
                <div class="">
                    <div class="row">
                        <div class="col-md-6 col-6 text-center">
                            <div class="task-box primary mb-0">
                                <p class="mb-0 tx-12">Total Orders</p>
                                <h3 class="mb-0"><?php echo $orders['completed']; ?></h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-6 text-center">
                            <div class="task-box danger mb-0">
                                <p class="mb-0 tx-12">Total Expense</p>
                                <h3 class="mb-0">₹ <?php echo handle_number_format($order_summary['final_d_p']); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="task-stat pb-0">
                <div class="d-flex tasks">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total Quantity</div>
                    </div>
                    <span class="float-right ml-auto"><?php echo $order_summary['total_quantity']; ?></span>
                </div>
                <div class="d-flex tasks">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total D.P.</div>
                    </div>
                    <span class="float-right ml-auto">₹ <?php echo handle_number_format($order_summary['total_d_p']); ?></span>
                </div>
                <div class="d-flex tasks">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total B.V.</div>
                    </div>
                    <span class="float-right ml-auto">₹ <?php echo handle_number_format($order_summary['total_b_v']); ?></span>
                </div>
                <div class="d-flex tasks">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total GST</div>
                    </div>
                    <span class="float-right ml-auto">₹ <?php echo handle_number_format($order_summary['total_gst']); ?></span>
                </div>
                <div class="d-flex tasks mb-0 border-bottom-0">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total Service Charge</div>
                    </div>
                    <span class="float-right ml-auto">₹ <?php echo handle_number_format($order_summary['service_charge']); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-header pt-4 pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-10 ">Top Up Statistics</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
            </div>
            <div class="pl-4 pr-4 pt-4 pb-3">
                <div class="">
                    <div class="row">
                        <div class="col-md-6 col-6 text-center">
                            <div class="task-box primary mb-0">
                                <p class="mb-0 tx-12">Total Orders</p>
                                <h3 class="mb-0"><?php echo $top_up_orders['completed']; ?></h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-6 text-center">
                            <div class="task-box danger mb-0" style="background: linear-gradient(45deg, #0C890C, #4BEC1E);box-shadow: 0 7px 30px #4BEC1E82;">
                                <p class="mb-0 tx-12">Total Sale</p>
                                <h3 class="mb-0">₹ <?php echo handle_number_format($top_up_summary['final_d_p']); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="task-stat pb-0">
                <div class="d-flex tasks">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total Quantity</div>
                    </div>
                    <span class="float-right ml-auto"><?php echo $top_up_summary['total_quantity']; ?></span>
                </div>
                <div class="d-flex tasks">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total D.P.</div>
                    </div>
                    <span class="float-right ml-auto">₹ <?php echo handle_number_format($top_up_summary['total_d_p']); ?></span>
                </div>
                <div class="d-flex tasks">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total B.V.</div>
                    </div>
                    <span class="float-right ml-auto">₹ <?php echo handle_number_format($top_up_summary['total_b_v']); ?></span>
                </div>
                <div class="d-flex tasks">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total GST</div>
                    </div>
                    <span class="float-right ml-auto">₹ <?php echo handle_number_format($top_up_summary['total_gst']); ?></span>
                </div>
                <div class="d-flex tasks mb-0 border-bottom-0">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total Service Charge</div>
                    </div>
                    <span class="float-right ml-auto">₹ <?php echo handle_number_format($top_up_summary['service_charge']); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-header pt-4 pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-10 ">Repurchase Statistics</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
            </div>
            <div class="pl-4 pr-4 pt-4 pb-3">
                <div class="">
                    <div class="row">
                        <div class="col-md-6 col-6 text-center">
                            <div class="task-box primary mb-0">
                                <p class="mb-0 tx-12">Total Orders</p>
                                <h3 class="mb-0"><?php echo $repurchase_orders['completed']; ?></h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-6 text-center">
                            <div class="task-box danger mb-0" style="background: linear-gradient(45deg, #0C890C, #4BEC1E);box-shadow: 0 7px 30px #4BEC1E82;">
                                <p class="mb-0 tx-12">Total Sale</p>
                                <h3 class="mb-0">₹ <?php echo handle_number_format($repurchase_summary['final_d_p']); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="task-stat pb-0">
                <div class="d-flex tasks">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total Quantity</div>
                    </div>
                    <span class="float-right ml-auto"><?php echo $repurchase_summary['total_quantity']; ?></span>
                </div>
                <div class="d-flex tasks">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total D.P.</div>
                    </div>
                    <span class="float-right ml-auto">₹ <?php echo handle_number_format($repurchase_summary['total_d_p']); ?></span>
                </div>
                <div class="d-flex tasks">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total B.V.</div>
                    </div>
                    <span class="float-right ml-auto">₹ <?php echo handle_number_format($repurchase_summary['total_b_v']); ?></span>
                </div>
                <div class="d-flex tasks">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total GST</div>
                    </div>
                    <span class="float-right ml-auto">₹ <?php echo handle_number_format($repurchase_summary['total_gst']); ?></span>
                </div>
                <div class="d-flex tasks mb-0 border-bottom-0">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total Service Charge</div>
                    </div>
                    <span class="float-right ml-auto">₹ <?php echo handle_number_format($repurchase_summary['service_charge']); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-header pt-4 pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-10 ">Customer Order Statistics</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
            </div>
            <div class="pl-4 pr-4 pt-4 pb-3">
                <div class="">
                    <div class="row">
                        <div class="col-md-6 col-6 text-center">
                            <div class="task-box primary mb-0">
                                <p class="mb-0 tx-12">Total Orders</p>
                                <h3 class="mb-0"><?php echo $customer_orders['completed']; ?></h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-6 text-center">
                            <div class="task-box danger mb-0" style="background: linear-gradient(45deg, #0C890C, #4BEC1E);box-shadow: 0 7px 30px #4BEC1E82;">
                                <p class="mb-0 tx-12">Total Sale</p>
                                <h3 class="mb-0">₹ <?php echo handle_number_format($customer_summary['final_d_p']); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="task-stat pb-0">
                <div class="d-flex tasks">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total Quantity</div>
                    </div>
                    <span class="float-right ml-auto"><?php echo $customer_summary['total_quantity']; ?></span>
                </div>
                <div class="d-flex tasks">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total D.P.</div>
                    </div>
                    <span class="float-right ml-auto">₹ <?php echo handle_number_format($customer_summary['total_d_p']); ?></span>
                </div>
                <div class="d-flex tasks">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total B.V.</div>
                    </div>
                    <span class="float-right ml-auto">₹ <?php echo handle_number_format($customer_summary['total_b_v']); ?></span>
                </div>
                <div class="d-flex tasks">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total GST</div>
                    </div>
                    <span class="float-right ml-auto">₹ <?php echo handle_number_format($customer_summary['total_gst']); ?></span>
                </div>
                <div class="d-flex tasks mb-0 border-bottom-0">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total Service Charge</div>
                    </div>
                    <span class="float-right ml-auto">₹ <?php echo handle_number_format($customer_summary['service_charge']); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>