<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<form id="formId" method="POST" action="">
    <input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="product-details table-responsive text-nowrap">
                        <table class="table table-bordered table-hover mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-left w-100">Product</th>
                                    <th class="w-150">Quantity</th>
                                    <th class="text-right">D. P.</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $cart_quantity              = 0;
                                    $cart_total                 = 0;
                                    if(isset($products) && !empty($products))
                                    {
                                        foreach ($products as $key => $value) {
                                            $product_id         = $value['product_id'];
                                            $product_name       = $value['name'];
                                            $product_quantity   = $value['quantity'];
                                            $product_d_p        = handle_number_format($value['d_p']);
                                            $product_total      = handle_number_format($value['d_p']*$product_quantity);
                                            $image              = assets_url('img/ecommerce/01.jpg');
                                            if(!empty($value['thumbnail']))
                                            {
                                                $image          = admin_url.'public/content/'.$value['thumbnail'];
                                            }
                                            $cart_quantity      = $cart_quantity+$product_quantity;
                                            $cart_total         = ($cart_total)+($value['d_p']*$product_quantity);
                                ?>
                                            <input type="hidden" name="product_id[]" value="<?php echo $product_id; ?>">
                                            <input type="hidden" class="base_d_p" id="base_d_p_<?php echo $product_id; ?>" name="base_d_p[]" value="<?php echo $value['d_p']; ?>">
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
                                                                  <dd>₹<?php echo $product_d_p; ?></dd>
                                                                </dl>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control product_quantity validate_integer text-center" id="product_quantity_<?php echo $product_id; ?>" name="quantity[]" value="<?php echo $product_quantity; ?>" data-productid="<?php echo $product_id; ?>" data-error=".productquantity<?php echo $product_id; ?>error">
                                                        <div class="productquantity<?php echo $product_id; ?>error error_msg">
                                                            <?php echo (isset($cart_errors['error_'.$product_id]) ? $cart_errors['error_'.$product_id] : ''); ?>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-right">₹<span id="product_total_<?php echo $product_id; ?>"><?php echo $product_total; ?></span></td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm text-white" data-toggle="tooltip" data-original-title="Delete" onclick="remove_from_cart('<?php echo $value['cart_id']; ?>', '<?php echo $product_id; ?>');"><i class="fe fe-trash"></i></a>
                                                </td>
                                            </tr>
                                <?php
                                        }
                                    }
                                    else
                                    {
                                ?>
                                        <tr>
                                            <td colspan="4" class="text-center">Cart is empty!</td>
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
                    <div class="form-group mb-0">
                        <textarea class="form-control" name="address" data-error=".addresserror" rows="6"><?php echo (isset($_POST['address']) ? $_POST['address'] : ''); ?></textarea>
                        <div class="addresserror error_msg"></div>
                    </div>
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
                                    <td>Cart Quantity</td>
                                    <td class="text-right"><span id="final_quantity"><?php echo $cart_quantity; ?></span></td>
                                </tr>
                                <tr>
                                    <td><span>Cart Subtotal</span></td>
                                    <td class="text-right text-muted">₹<span id="final_sub_total"><?php echo handle_number_format($cart_total); ?></span></td>
                                </tr>
                                <tr>
                                    <td><span>Order Total</span></td>
                                    <td><h2 class="price text-right mb-0">₹<span id="final_total" style="color: #3b4863;"><?php echo handle_number_format($cart_total); ?></span></h2></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(isset($products) && !empty($products)){ ?>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-success mt-2 mb-4 w-100" type="submit" value="Request Order" style="font-size: 20px;font-weight: 700;">Request Order</button>
            </div>
        </div>
    <?php } ?>
</form>

<script type="text/javascript">
    function remove_from_cart(cart_id, product_id) {
        showLoader();
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: '<?php echo base_url(cart_constants::remove_from_cart_url); ?>',
            data: {[csrf_name]: csrf_value, cart_id: cart_id, product_id: product_id},
            success: function(response) {
                if(response.error == 1)
                {
                    hideLoader();
                    load_status_popup('error', response.message);
                }
                else
                {
                    load_status_popup("success", response.message);
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }
            }
        });
    }

    $("#formId").validate({
        rules: {
            address: {
                required: true,
            },
            'quantity[]': {
                required: true,
                digits: true,
                min: 1,
            }
        },
        messages: {
            address: {
                required: 'Please enter address',
            },
            'quantity[]': {
                required: 'Enter quantity',
                digits: 'Enter valid quantity',
                min: 'Enter min 1',
            }
        },
        ignore: "input[type=hidden]",
        errorClass: "danger",
        successClass: "success",
        highlight: function(e, t) {
            $(e).removeClass(t)
        },
        unhighlight: function(e, t) {
            $(e).removeClass(t)
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form, event){
            showLoader();
            form.submit();
        }
    });

    function parse_float(val)
    {
        if(isNaN(val))
        {
            return 0;
        }
        return parseFloat(val);
    }

    function getFixedNum(val, fixed=2)
    {
        var val = parse_float(val);
        if(isNaN(val))
        {
            return 0;
        }
        return val.toFixed(fixed);
    }

    function calculate_table_total()
    {
        var final_quantity          = 0;
        var final_total             = 0;

        $('.product_quantity').each(function() {
            var product_id          = $(this).attr('data-productid');
            var product_amount      = parse_float($('#base_d_p_'+product_id).val());
            var product_quantity    = parse_float($(this).val());

            var product_total       = parse_float(product_quantity) * parse_float(product_amount);
            $('#product_total_'+product_id).html(product_total);

            final_quantity          = parse_float(final_quantity) + parse_float(product_quantity);
            final_total             = parse_float(final_total) + parse_float(product_total);
        });

        $('#final_quantity').html(final_quantity);
        $('#final_sub_total').html(final_total);
        $('#final_total').html(final_total);
    }

    $(document).on('change keyup blur', '.product_quantity', function() {
        calculate_table_total();
    });
</script>