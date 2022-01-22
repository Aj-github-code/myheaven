<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body p-2">
                <div class="input-group">
                    <input type="text" class="form-control" id="term" placeholder="Search ..." value="">
                    <span class="input-group-append">
                        <button class="btn btn-primary" type="button" onclick="get_products(0);">Search</button>
                        <button class="btn btn-secondary custom-btn-secondary" type="button" onclick="clear_search();">Clear</button>
                    </span>
                </div>
            </div>
        </div>
        <div class="row row-sm" id="render_product_grid"></div>
    </div>
</div>

<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

<script type="text/javascript">
    var csrf_name                   = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrf_value                  = '<?php echo $this->security->get_csrf_hash(); ?>';

    $('body').on('click', '#pagination a.page-link',function(e){
        e.preventDefault();
        var pageno = $(this).attr('data-ci-pagination-page');
        get_products(pageno);
    });

    function clear_search() {
        $('#term').val('');
        get_products(0);
    }

    function get_products(offset='') {
        offset                      = offset ? offset : 0;
        var limit                   = 12;
        var term_value              = $('#term').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(products_constants::get_products_url); ?>/'+offset,
            data: 'offset=' + offset + '&'+csrf_name+'='+csrf_value +'&limit='+ limit +'&term=' + term_value,
            beforeSend: function() {
                showLoader();
            },
            success: function(html) {
                $('#render_product_grid').html(html);
                hideLoader();
            }
        });
    }
    get_products(0);

    function add_to_cart(product_id) {
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: '<?php echo base_url(cart_constants::add_to_cart_url); ?>',
            data: {product_id: product_id, [csrf_name]: csrf_value},
            beforeSend: function() {
                showLoader();
            },
            success: function(response) {
                hideLoader();
                if(response.error == 1)
                {
                    load_status_popup('error', response.message);
                }
                else
                {
                    load_status_popup("success", response.message);
                    get_cart_products_count();
                }
            }
        });
    }
</script>