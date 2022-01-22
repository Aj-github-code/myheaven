<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
    $product_name           = $details['name'];
    $product_description    = $details['description'];
    $product_opening_stock  = $details['opening_stock'];
    $product_hsn_sac        = $details['hsn_sac'];
    $product_p_code         = $details['p_code'];
    $product_d_p            = $details['d_p'];
    $product_b_v            = $details['b_v'];
    $product_cgst           = $details['cgst'];
    $product_sgst           = $details['sgst'];
    $product_igst           = $details['igst'];
    $product_mrp            = handle_number_format($details['mrp']);
    $image                  = assets_url('img/ecommerce/5.jpg');
    if(!empty($details['thumbnail']))
    {
        $image              = admin_url.'public/content/'.$details['thumbnail'];
    }
?>

<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body h-100">
                <div class="row row-sm ">
                    <div class=" col-xl-5 col-lg-12 col-md-12">
                        <div class="preview-pic tab-content">
                            <div class="tab-pane active" id="pic-1">
                                <img src="<?php echo $image; ?>" alt="<?php echo $product_name; ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="details col-xl-7 col-lg-12 col-md-12 mt-4 mt-xl-0">
                        <h4 class="product-title"><?php echo $product_name; ?></h4>
                        <?php if(!empty($product_description)){ ?>
                            <p class="product-description"><?php echo $product_description; ?></p>
                        <?php } ?>

                        <div class="row">
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-4">
                                <label class="mb-0"><span class="font-weight-bold">Mrp:</span></label>
                            </div>
                            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-9 col-8 mb-0">
                                <span class="h4 text-danger mb-0">₹<?php echo $product_mrp; ?></span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-4">
                                <label class="mb-0"><span class="font-weight-bold">HSN/SAC:</span></label>
                            </div>
                            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-9 col-8">
                                <label class="mb-0">
                                    <span class="font-weight-bold">
                                        <?php
                                            if(!empty($product_hsn_sac))
                                            {
                                                echo $product_hsn_sac;
                                            }
                                            else
                                            {
                                                echo 'NA';
                                            }
                                        ?>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-4">
                                <label class="mb-0"><span class="font-weight-bold">P. Code:</span></label>
                            </div>
                            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-9 col-8">
                                <label class="mb-0">
                                    <span class="font-weight-bold">
                                        <?php
                                            if(!empty($product_p_code))
                                            {
                                                echo $product_p_code;
                                            }
                                            else
                                            {
                                                echo 'NA';
                                            }
                                        ?>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-4">
                                <label class="mb-0"><span class="font-weight-bold">D. P.:</span></label>
                            </div>
                            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-9 col-8">
                                <label class="mb-0">
                                    <span class="font-weight-bold">
                                        <?php
                                            if(!empty($product_d_p))
                                            {
                                                echo $product_d_p;
                                            }
                                            else
                                            {
                                                echo 'NA';
                                            }
                                        ?>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-4">
                                <label class="mb-0"><span class="font-weight-bold">B. V.:</span></label>
                            </div>
                            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-9 col-8">
                                <label class="mb-0">
                                    <span class="font-weight-bold">
                                        <?php
                                            if(!empty($product_b_v))
                                            {
                                                echo $product_b_v;
                                            }
                                            else
                                            {
                                                echo 'NA';
                                            }
                                        ?>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-4">
                                <label class="mb-0"><span class="font-weight-bold">CGST:</span></label>
                            </div>
                            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-9 col-8">
                                <label class="mb-0">
                                    <span class="font-weight-bold">
                                        <?php
                                            if(!empty($product_cgst))
                                            {
                                                echo $product_cgst.'%';
                                            }
                                            else
                                            {
                                                echo 'NA';
                                            }
                                        ?>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-4">
                                <label class="mb-0"><span class="font-weight-bold">SGST:</span></label>
                            </div>
                            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-9 col-8">
                                <label class="mb-0">
                                    <span class="font-weight-bold">
                                        <?php
                                            if(!empty($product_sgst))
                                            {
                                                echo $product_sgst.'%';
                                            }
                                            else
                                            {
                                                echo 'NA';
                                            }
                                        ?>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-4">
                                <label class="mb-0"><span class="font-weight-bold">IGST:</span></label>
                            </div>
                            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-9 col-8">
                                <label class="mb-0">
                                    <span class="font-weight-bold">
                                        <?php
                                            if(!empty($product_igst))
                                            {
                                                echo $product_igst.'%';
                                            }
                                            else
                                            {
                                                echo 'NA';
                                            }
                                        ?>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-4">
                                <label class="mb-0"><span class="font-weight-bold">Quantity:</span></label>
                            </div>
                            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-9 col-8 price mb-0">
                                <span class="h4 mb-0"><?php echo $product_opening_stock; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>