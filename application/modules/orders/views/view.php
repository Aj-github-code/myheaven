<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
    $orderstatus            = '';
    $orderstatusclass       = '';
    $order_status           = $order['order_status'];
    if($order_status == 'pending')
    {
        $orderstatus        = 'Pending';
        $orderstatusclass   = 'info';
    }
    else if($order_status == 'approved')
    {
        $orderstatus        = 'Approved';
        $orderstatusclass   = 'success';
    }
    else if($order_status == 'rejected')
    {
        $orderstatus        = 'Rejected';
        $orderstatusclass   = 'danger';
    }
    else if($order_status == 'delivered')
    {
        $orderstatus        = 'Delivered';
        $orderstatusclass   = 'success';
    }
?>
<div class="row">
    <div class="col-md-12">
        <div class="card custom-card" id="additional-alerts">
            <div class="card-header bd-b">
                <h6 class="card-title mb-0">Order Status</h6>
            </div>
            <div class="card-body">
                <div class="text-wrap">
                    <div class="example p-0" style="border: none;">
                        <div class="alert alert-<?php echo $orderstatusclass; ?> mb-0" role="alert">
                            <h4 class="alert-heading"><?php echo $orderstatus; ?>!</h4>
                            <?php if(!empty($order['message'])){ ?>
                                <hr>
                                <p class="mb-0"><?php echo $order['message']; ?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="product-details table-responsive text-nowrap">
                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                        <thead>
                            <tr>
                                <th class="text-left w-100">Product</th>
                                <th class="w-150">Quantity</th>
                                <th class="text-right">Total B. V.</th>
                                <th class="text-right">Total D. P.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(isset($order_products) && !empty($order_products))
                                {
                                    foreach ($order_products as $key => $value) {
                                        $product_id         = $value['product_id'];
                                        $product_name       = $value['name'];
                                        $product_quantity   = $value['quantity'];
                                        $product_amount     = handle_number_format($value['d_p']);
                                        $total_b_v          = handle_number_format($value['total_b_v']);
                                        $product_total      = handle_number_format($value['total_d_p']);
                                        $image              = assets_url('img/ecommerce/01.jpg');
                                        if(!empty($value['thumbnail']))
                                        {
                                            $image          = admin_url.'public/content/'.$value['thumbnail'];
                                        }
                            ?>
                                        <tr>
                                            <td class="text-left">
                                                <div class="media">
                                                    <div class="card-aside-img">
                                                        <img src="<?php echo $image; ?>" alt="<?php echo $product_name; ?>" class="h-60 w-60">
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="card-item-desc mt-0">
                                                            <h6 class="font-weight-semibold mt-0 text-uppercase"><?php echo $product_name; ?></h6>
                                                            <dl class="card-item-desc-1">
                                                              <dt>D. P.: </dt>
                                                              <dd>₹<?php echo $product_amount; ?></dd>
                                                            </dl>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group text-right">
                                                    <?php echo $product_quantity; ?>
                                                </div>
                                            </td>
                                            <td class="text-right">₹<?php echo $total_b_v; ?></td>
                                            <td class="text-right">₹<?php echo $product_total; ?></td>
                                        </tr>
                            <?php
                                    }
                                }
                                else
                                {
                            ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No product found!</td>
                                    </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-6">
        <div class="card">
            <div class="card-header bd-b">
                <h3 class="card-title mb-0">Address</h3>
            </div>
            <div class="card-body">
                <p><?php echo (isset($order['address']) ? $order['address'] : ''); ?></p>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bd-b">
                <div class="card-title mb-0">Order Summery</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Order Quantity</td>
                                <td class="text-right"><?php echo $order['total_quantity']; ?></td>
                            </tr>
                            <tr>
                                <td><span>Order Subtotal</span></td>
                                <td class="text-right text-muted"><span>₹<?php echo handle_number_format($order['total_d_p']); ?></span></td>
                            </tr>
                            <tr>
                                <td><span>GST Type</span></td>
                                <td class="text-right text-muted">
                                    <span>
                                        <?php
                                            if(isset($order['gst_type']) && !empty($order['gst_type']))
                                            {
                                                if($order['gst_type'] == 'cgst_sgst')
                                                {
                                                    echo 'CGST+SGST';
                                                }
                                                else
                                                {
                                                    echo 'IGST';
                                                }
                                            }
                                            else
                                            {
                                                echo 'NA';
                                            }
                                        ?>
                                    </span>
                                </td>
                            </tr>
                            <?php
                                if($order['gst_type'] == 'cgst_sgst')
                                {
                                    $cgst       = '0.00';
                                    $sgst       = '0.00';
                                    
                                    if(isset($order['gst_type']) && !empty($order['gst_type']))
                                    {
                                        $cgst   = $order['total_cgst'];
                                        $sgst   = $order['total_sgst'];
                                    }
                            ?>
                                    <tr>
                                        <td><span>CGST</span></td>
                                        <td class="text-right text-muted"><span>₹<?php echo handle_number_format($cgst); ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><span>SGST</span></td>
                                        <td class="text-right text-muted"><span>₹<?php echo handle_number_format($sgst); ?></span></td>
                                    </tr>
                            <?php
                                }
                                else if($order['gst_type'] == 'igst')
                                {
                                    $igst       = $order['total_igst'];
                            ?>
                                    <tr>
                                        <td><span>IGST</span></td>
                                        <td class="text-right text-muted"><span>₹<?php echo handle_number_format($igst); ?></span></td>
                                    </tr>
                            <?php
                                }
                                else
                                {
                                    $gst        = $order['total_gst'];
                            ?>
                                    <tr>
                                        <td><span>GST</span></td>
                                        <td class="text-right text-muted"><span>₹<?php echo handle_number_format($gst); ?></span></td>
                                    </tr>
                            <?php
                                }
                            ?>
                            <tr>
                                <td><span>Service Charge</span></td>
                                <td class="text-right text-muted"><span>₹<?php echo handle_number_format($order['service_charge']); ?></span></td>
                            </tr>
                            <tr>
                                <td><span>Order Total</span></td>
                                <td><h2 class="price text-right mb-0">₹<?php echo handle_number_format($order['final_d_p']); ?></h2></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>