<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
    $order_errors = $this->session->flashdata('order_errors');
?>

<div class="row">
    <div class="col-md-12">
        <?php if(!empty($order_errors)){ ?>
            <div class="card">
                <div class="card-header bd-b">
                    <h6 class="card-title text-danger mb-0">Order Error</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mg-b-1 text-md-nowrap bg-danger">
                            <thead>
                                <tr>
                                    <th class="text-left tx-black">Product</th>
                                    <th class="text-right tx-black">Available Stock</th>
                                    <th class="text-right tx-black">Order Quantity</th>
                                    <th class="text-left tx-black">Error</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($order_errors as $key => $value) {
                                ?>
                                        <tr>
                                            <th class="text-left"><?php echo $value['product_name']; ?></th>
                                            <td class="text-right"><?php echo $value['product_stock']; ?></td>
                                            <td class="text-right"><?php echo $value['order_quantity']; ?></td>
                                            <th class="text-left"><?php echo $value['error']; ?></th>
                                        </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<form id="productFormId" method="POST" action="">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header bd-b">
                    <h3 class="card-title mb-0">Products</h3>
                </div>
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-control select2" id="product_id" name="product_id" data-error=".productiderror" style="width: 100%;">
                                    <option value="">-- Select Product --</option>
                                    <?php
                                        if(isset($products) && !empty($products))
                                        {
                                            foreach ($products as $key => $value) {
                                    ?>
                                                <option value="<?php echo $value['product_id']; ?>" data-price="<?php echo $value['d_p']; ?>" data-bv="<?php echo $value['b_v']; ?>" data-thumbnail="<?php echo $value['thumbnail']; ?>"><?php echo $value['name']; ?> (<?php echo $value['opening_stock']; ?>)</option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
                                <div class="productiderror error_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control productquantity validate_integer text-center" id="productquantity" name="productquantity" value="" data-error=".productquantityerror" placeholder="Quantity">
                                <div class="productquantityerror error_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button type="submit" class="btn btn-main-primary mr-2">Add</button>
                            <button type="button" class="btn btn-secondary custom-btn-secondary" onclick="clearProduct();">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="formId" method="POST" action="<?php echo base_url().repurchase_constants::place_repurchase_url; ?>">
    <input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bd-b">
                    <h3 class="card-title mb-0">Cart</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="product-details table-responsive text-nowrap">
                                <table class="table table-bordered table-hover mb-0 text-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="text-left w-100">Product</th>
                                            <th class="w-150">Quantity</th>
                                            <th class="text-right">B. V.</th>
                                            <th class="text-right">D. P.</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="render_product_row">
                                        <tr class="empty_cart">
                                            <td colspan="5" class="text-center">Cart is empty!</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Member Code: <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="member_code" name="member_code" value="" data-error=".membercodeerror">
                                <div class="membercodeerror error_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-4 d-none">
                            <div class="form-group">
                                <label class="form-label">GST Type: <span class="asterisk">*</span></label>
                                <select class="select2" name="gst_type" id="gst_type" style="width: 100%;" data-error=".gsttypeerror">
                                    <option value="">-- Select GST Type --</option>
                                    <option value="cgst_sgst">CGST+SGST</option>
                                    <option value="igst">IGST</option>
                                </select>
                                <div class="gsttypeerror error_msg"><?php echo form_error('gst_type', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Service Charge</label>
                                <input type="text" class="form-control" id="service_charge" name="service_charge" value="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
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
                                    <td>Order Quantity</td>
                                    <td class="text-right"><span id="final_quantity"><?php echo (isset($order_quantity) ? $order_quantity : '0.00'); ?></span></td>
                                </tr>
                                <tr>
                                    <td><span>Order Subtotal</span></td>
                                    <td class="text-right text-muted">₹<span id="final_sub_total"><?php echo (isset($order_total) ? $order_total : '0.00'); ?></span></td>
                                </tr>
                                <tr>
                                    <td><span>Order Total B.V.</span></td>
                                    <td><h2 class="price text-right mb-0">₹<span id="final_total_bv" style="color: #3b4863;"><?php echo (isset($order_total) ? $order_total : '0.00'); ?></span></h2></td>
                                </tr>
                                <tr>
                                    <td><span>Order Total (Total D.P.)</span></td>
                                    <td><h2 class="price text-right mb-0">₹<span id="final_total" style="color: #3b4863;"><?php echo (isset($order_total) ? $order_total : '0.00'); ?></span></h2></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-success mt-2 mb-4 w-100" type="submit" value="Request Order" style="font-size: 20px;font-weight: 700;">Request Order</button>
        </div>
    </div>
</form>

<script type="text/javascript">
    var admin_url               = '<?php echo admin_url; ?>';
    var default_thumbnail_url   = '<?php echo assets_url('img/ecommerce/01.jpg'); ?>';

    $('#product_id, #gst_type').select2();

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

    function remove_from_cart(product_id) {
        $('#product_table_row_'+product_id).remove();
        if($('.product_table_row').length == 0)
        {
            var product_row     = `
                                    <tr class="empty_cart">
                                        <td colspan="4" class="text-center">Cart is empty!</td>
                                    </tr>
                                `;
            $('#render_product_row').append(product_row);
        }
        calculate_table_total();
    }

    function calculate_table_total()
    {
        var final_quantity          = 0;
        var final_total             = 0;
        var final_total_bv          = 0;

        $('.orderproductquantity').each(function() {
            var product_quantity    = parseInt($(this).val());
            final_quantity          = parseInt(final_quantity) + parseInt(product_quantity);
        });

        $('.orderproducttotalamount').each(function() {
            var product_total       = parseInt($(this).val());
            final_total             = parse_float(final_total) + parse_float(product_total);
        });

        $('.orderproducttotalbv').each(function() {
            var product_bv_total    = parseInt($(this).val());
            final_total_bv          = parse_float(final_total_bv) + parse_float(product_bv_total);
        });

        $('#final_quantity').html(final_quantity);
        $('#final_sub_total').html(final_total);
        $('#final_total').html(final_total);
        $('#final_total_bv').html(final_total_bv);
    }

    $("#productFormId").validate({
        rules: {
            product_id: {
                required: true,
            },
            productquantity: {
                required: true,
                digits: true,
                min: 1,
            }
        },
        messages: {
            product_id: {
                required: 'Please select product',
            },
            productquantity: {
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
            event.preventDefault();
            showLoader();

            var product_id              = $("#product_id").val();
            var product_name            = $('#product_id option:selected').text();
            var product_bv              = parse_float($('#product_id option:selected').attr('data-bv'));
            var product_price           = parse_float($('#product_id option:selected').attr('data-price'));
            var product_thumbnail       = $('#product_id option:selected').attr('data-thumbnail');
            var product_quantity        = parseInt($('#productquantity').val());

            var order_product_quantity  = $('#product_quantity_'+product_id).val();

            var new_quantity            = 0;
            var new_bv                  = 0;
            var new_amount              = 0;

            if(order_product_quantity != undefined && $('#product_quantity_'+product_id).length)
            {
                new_quantity            = parseInt(order_product_quantity) + product_quantity;
                new_bv                  = parse_float(new_quantity * product_bv);
                new_amount              = parse_float(new_quantity * product_price);
            }
            else
            {
                new_quantity            = product_quantity;
                new_bv                  = parse_float(new_quantity * product_bv);
                new_amount              = parse_float(new_quantity * product_price);
            }

            var image                   = default_thumbnail_url;
            if(product_thumbnail != '')
            {
                var image               = admin_url+'public/content/'+product_thumbnail;
            }

            var product_row             = `
                                            <tr class="product_table_row" id="product_table_row_`+product_id+`">
                                                <input type="hidden" name="orderproductid[]" value="`+product_id+`">
                                                <input type="hidden" class="orderproductquantity" name="orderproductquantity[]" id="product_quantity_`+product_id+`" value="`+new_quantity+`">
                                                <input type="hidden" name="orderproductamount[]" value="`+product_price+`">
                                                <input type="hidden" class="orderproducttotalbv" name="orderproducttotalbv[]" value="`+new_bv+`">
                                                <input type="hidden" class="orderproducttotalamount" name="orderproducttotalamount[]" value="`+new_amount+`">
                                                <td class="text-left">
                                                    <div class="media">
                                                        <div class="card-aside-img">
                                                            <img src="`+image+`" alt="`+product_name+`" class="h-60 w-60">
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="card-item-desc mt-0">
                                                                <h6 class="font-weight-semibold mt-0 text-uppercase">`+product_name+`</h6>
                                                                <dl class="card-item-desc-1">
                                                                  <dt>D. P.: </dt>
                                                                  <dd>₹`+product_price+`</dd>
                                                                </dl>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group text-right">
                                                        `+new_quantity+`
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group text-right">
                                                        `+new_bv+`
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group text-right">
                                                        `+new_amount+`
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm text-white" data-toggle="tooltip" data-original-title="Delete" onclick="remove_from_cart(`+product_id+`);"><i class="fe fe-trash"></i></a>
                                                </td>
                                            </tr>
                                        `;
            if($('.empty_cart').length)
            {
                $('.empty_cart').remove();
            }
            if(order_product_quantity != undefined && $('#product_quantity_'+product_id).length)
            {
                $('#product_table_row_'+product_id).remove();
            }
            $("#product_id").select2().val('').trigger("change");
            $("#productquantity").val('');
            $('#render_product_row').append(product_row);
            calculate_table_total();
            hideLoader();
        }
    });

    $("#formId").validate({
        rules: {
            member_code: {
                required: true,
            },
            // gst_type: {
            //     required: true,
            // },
            service_charge: {
                number: true,
            },
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
            member_code: {
                required: 'Please enter member code',
            },
            gst_type: {
                required: 'Please select package',
            },
            service_charge: {
                number: 'Please enter valid amount',
            },
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
            if($('.product_table_row').length == 0)
            {
                load_status_popup('error', 'Please add at least 1 product');
            }
            else
            {
                showLoader();
                $.ajax({
                    type: 'POST',
                    dataType: "json",
                    url: '<?php echo base_url(repurchase_constants::check_member_url); ?>',
                    data: {[csrf_name]: csrf_value, member_code: $('#member_code').val()},
                    success: function(response) {
                        if(response.error == 1)
                        {
                            hideLoader();
                            load_status_popup('error', response.message);
                        }
                        else
                        {
                            showLoader();
                            form.submit();
                        }
                    }
                });
            }
        }
    });
</script>