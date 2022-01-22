<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row row-sm">
    <?php
        if(isset($result) && !empty($result))
        {
            foreach ($result as $key => $value) {
                $product_name   = $value['name'];
                $product_mrp    = handle_number_format($value['mrp']);
                $product_d_p    = handle_number_format($value['d_p']);
                $image          = assets_url('img/ecommerce/01.jpg');
                if(!empty($value['thumbnail']))
                {
                    $image      = admin_url.'public/content/'.$value['thumbnail'];
                }
    ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                    <div class="product-card card product-grid-card">
                        <div class="card-body h-100">
                            <h3 class="h6 mb-2 font-weight-bold text-uppercase"><?php echo $product_name; ?></h3>
                            <div class="d-flex">
                                <h4 class="h5 w-50 font-weight-bold text-danger">₹<?php echo $product_d_p; ?></h4>
                                <?php
                                    if($value['opening_stock'] > 0)
                                    {
                                ?>
                                        <h4 class="h5 font-weight-bold text-success tx-15 ml-auto">In Stock</h4>
                                <?php
                                    }
                                    else
                                    {
                                ?>
                                        <h4 class="h5 font-weight-bold text-danger tx-15 ml-auto">Out Of Stock</h4>
                                <?php
                                    }
                                ?>
                                
                                <!-- <h4 class="h5 font-weight-bold text-warning tx-15 ml-auto">Stock: <?php //echo $value['opening_stock']; ?></h4> -->
                            </div>
                            <img class="w-100 mt-2 mb-3" src="<?php echo $image; ?>" alt="<?php echo $product_name; ?>"/>
                            <button class="btn btn-primary btn-block mb-0" onclick="add_to_cart('<?php echo $value['id']; ?>');">
                                <i class="fe fe-shopping-cart mr-1"></i>
                                Add To Cart
                            </button>
                        </div>
                    </div>
                </div>
    <?php
            }
        }
        else
        {
    ?>
            <div class="col-12">
                <div class="row">
                    Sorry, No product found.
                </div>
            </div>
    <?php
        }
    ?>
</div>