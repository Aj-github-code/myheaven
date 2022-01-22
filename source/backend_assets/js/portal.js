$(function () {
    "use strict";

    $(document).on('keyup keydown keypress change', '.to_lowercase', function () {
        $(this).val($(this).val().toLowerCase());
    });

    $(document).on('keyup keydown keypress change', '.to_uppercase', function () {
        $(this).val($(this).val().toUpperCase());
    });

    $(document).on('keyup keydown keypress change', '.no_character', function () {
        if(/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'');
    });

    $(document).on('keyup keydown keypress change', '.alphaspace', function (e) {
        var regex = new RegExp("^[a-zA-Z ]+$");
        var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if(!regex.test(key)) {
            e.preventDefault();
            return false;
        }
    });

    $(document).on('keyup keydown keypress change', '.alphanospace', function (e) {
        var regex = new RegExp("^[a-zA-Z]+$");
        var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if(!regex.test(key)) {
            e.preventDefault();
            return false;
        }
    });

    $(document).on('keydown', '.no_space', function (e) {
        if(e.which === 32)
        {
            return false;
        }
    });

    $(document).on('change', '.no_space', function (e) {
        this.value = this.value.replace(/\s/g, "");
    });

    $(document).on('keyup keydown keypress change', '.validate_money', function () {
        var amount          = this.value;
        var amountregex     = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)$/g;
        var amountregex1    = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)/g;

        if(amountregex.test(amount)){
        }else{
            amount = amountregex1.exec(amount);
            if(amount){
                this.value = amount[0];
            }else{
                this.value = "";
            }
        }
    });

    $(document).on('keyup keydown keypress change', '.validate_integer', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
});

function change_status(id, status, sel, parent_id='') {
    var type = sel.getAttribute('data-type');
    var function_url = sel.getAttribute('data-function');
    var param = {};
    if(sel.getAttribute('data-alias') != undefined)
    {
        param.alias = sel.getAttribute('data-alias');
    }
    if(sel.getAttribute('data-organization_id') != undefined)
    {
        param.organization_id = sel.getAttribute('data-organization_id');
    }

    if(id != '')
    {
        var message = '';
        if(status == 1)
        {
            var message = 'Do you really want to activate this '+type+'?';
            var btn_text = 'Yes, Activate it!';
        }
        else if(status == 0)
        {
            var message = 'Do you really want to in-activate this '+type+'?';
            var btn_text = 'Yes, In-Activate it!';
        }
        else if(status == '-1')
        {
            var message = 'Do you really want to delete this '+type+'?';
            var btn_text = 'Yes, Delete it!';
        }

        swal({
            title: "Are you sure?",
            text: message,
            type: "warning",
            showCancelButton: true,
            confirmButtonText: btn_text,
        }).then(function (result) {
            if(result.value)
            {
                var my_heaven_csrf_token = $('#my_heaven_csrf_token').val();
                
                showLoader();
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: function_url,
                    async: false,
                    data: {my_heaven_csrf_token : my_heaven_csrf_token, id : id, parent_id : parent_id, status : status, type : type, param : param},
                    success: function(response){
                        if(response.error == 1)
                        {
                            hideLoader();
                            load_status_popup('error', response.message);
                        }
                        else
                        {
                            load_status_popup('success', response.message);
                            filterTable();
                        }
                    }
                });
            }
        }, function(dismiss) {});
    }else{
        hideLoader();
        load_status_popup('error', "Access denied");        
    }
}

function remove_element(sel, column, value, id) {
    var type            = sel.getAttribute('data-type');
    var function_url    = sel.getAttribute('data-function');

    if(id != '')
    {
        var message     = 'Do you really want to delete this '+type+'?';
        var btn_text    = 'Yes, Delete it!';

        swal({
            title: "Are you sure?",
            text: message,
            type: "warning",
            showCancelButton: true,
            confirmButtonText: btn_text,
        }).then(function (result) {
            if(result.value)
            {
                var my_heaven_csrf_token = $('#my_heaven_csrf_token').val();
                
                showLoader();
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: function_url,
                    async: false,
                    data: {my_heaven_csrf_token : my_heaven_csrf_token, id : id, column : column, value : value, type : type},
                    success: function(response){
                        hideLoader();
                        if(response.error == 1)
                        {
                            load_status_popup('error', response.message);
                        }
                        else
                        {
                            load_status_popup('success', response.message);
                            $('#'+type+'_wrap').html('');
                        }
                    }
                });
            }
        }, function(dismiss) {});
    }
}

function category_select_box(get_url, category_id='', set_disable='', multiple='',parent_id='', is_in_modal='no', modal_id='') {
    $("#category_id").attr('disabled', 'disabled');
    
    $.ajax({
        type: "GET",
        dataType: "json",
        url : get_url,
        data: {category_id : category_id, parent_id:parent_id},
        success: function(response) {
            $("#category_id").removeAttr('disabled');
            $('.category_wrap').html('<select class="select2" name="category_id" id="category_id" '+multiple+' style="width: 100%;" data-error=".categoryiderror">'+response+'</select>');
            if(set_disable == 'yes')
            {
                // $("#category_id").attr('disabled', 'disabled');
                if(is_in_modal == 'yes')
                {
                    $("#category_id").select2({
                        disabled:'readonly',
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $("#category_id").select2({
                        disabled:'readonly'
                    });
                }
            }
            else
            {
                if(is_in_modal == 'yes')
                {
                    $("#category_id").select2({
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $('#category_id').select2();
                }
            }
        }
    });
}


function category_multi_select_box(get_url, category_id='', set_disable='', multiple='',parent_id='', is_in_modal='no', modal_id='') {
    $("#category_id").attr('disabled', 'disabled');
    
    $.ajax({
        type: "GET",
        dataType: "json",
        url : get_url,
        data: {category_id : category_id, parent_id:parent_id},
        success: function(response) {
            $("#category_id").removeAttr('disabled');
            $('.category_wrap').html('<select class="select2" name="category_id[]" id="category_id" '+multiple+' style="width: 100%;" data-error=".categoryiderror">'+response+'</select>');
            if(set_disable == 'yes')
            {
                // $("#category_id").attr('disabled', 'disabled');
                if(is_in_modal == 'yes')
                {
                    $("#category_id").select2({
                        disabled:'readonly',
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $("#category_id").select2({
                        disabled:'readonly'
                    });
                }
            }
            else
            {
                if(is_in_modal == 'yes')
                {
                    $("#category_id").select2({
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $('#category_id').select2({multiple: true});
                }
            }
        }
    });
}

function subcategory_select_box(get_url, category_id='', set_disable='', multiple='',parent_id='', is_in_modal='no', modal_id='') {
    $("#subcategory_id").attr('disabled', 'disabled');
    $.ajax({
        type: "GET",
        dataType: "json",
        url : get_url,
        data: {category_id : category_id, parent_id:parent_id},
        success: function(response) {
            $("#subcategory_id").removeAttr('disabled');
            $('.subcategory_wrap').html('<select class="select2" name="subcategory_id" id="subcategory_id" '+multiple+' style="width: 100%;" data-error=".subcategory_iderror">'+response+'</select>');
            if(set_disable == 'yes')
            {
                // $("#category_id").attr('disabled', 'disabled');
                if(is_in_modal == 'yes')
                {
                    $("#subcategory_id").select2({
                        disabled:'readonly',
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $("#subcategory_id").select2({
                        disabled:'readonly'
                    });
                }
            }
            else
            {
                if(is_in_modal == 'yes')
                {
                    $("#subcategory_id").select2({
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $('#subcategory_id').select2();
                }
            }
        }
    });
}

function subcategory_multi_select_box(get_url, category_id='', set_disable='', multiple='',parent_id='', is_in_modal='no', modal_id='') {
    $("#subcategory_id").attr('disabled', 'disabled');
    console.log(parent_id);
    $.ajax({
        type: "GET",
        dataType: "json",
        url : get_url,
        data: {category_id : category_id, parent_id:parent_id},
        success: function(response) {
            $("#subcategory_id").removeAttr('disabled');
            $('.subcategory_wrap').html('<select class="select2" name="subcategory_id[]" id="subcategory_id" '+multiple+' style="width: 100%;" data-error=".subcategory_iderror">'+response+'</select>');
            if(set_disable == 'yes')
            {
                // $("#category_id").attr('disabled', 'disabled');
                if(is_in_modal == 'yes')
                {
                    $("#subcategory_id").select2({
                        disabled:'readonly',
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $("#subcategory_id").select2({
                        disabled:'readonly'
                    });
                }
            }
            else
            {
                if(is_in_modal == 'yes')
                {
                    $("#subcategory_id").select2({
                        dropdownParent: $("#"+modal_id),
                        multiple: true
                    });
                }
                else
                {
                    $('#subcategory_id').select2({multiple: true});
                }
            }
        }
    });
}

function brand_select_box(get_url, brand_id='', set_disable='', multiple='', is_in_modal='no', modal_id='') {
    $("#brand_id").attr('disabled', 'disabled');
    $.ajax({
        type: "GET",
        dataType: "json",
        url : get_url,
        data: {brand_id : brand_id},
        success: function(response) {
            $("#brand_id").removeAttr('disabled');
            $('.brand_wrap').html('<select class="select2" name="brand_id" id="brand_id" '+multiple+' style="width: 100%;" data-error=".brand_iderror">'+response+'</select>');
            if(set_disable == 'yes')
            {
                // $("#category_id").attr('disabled', 'disabled');
                if(is_in_modal == 'yes')
                {
                    $("#brand_id").select2({
                        disabled:'readonly',
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $("#brand_id").select2({
                        disabled:'readonly'
                    });
                }
            }
            else
            {
                if(is_in_modal == 'yes')
                {
                    $("#brand_id").select2({
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $('#brand_id').select2();
                }
            }
        }
    });
}

function size_select_box(get_url, size_id='', set_disable='', multiple='', is_in_modal='no', modal_id='') {
    $("#size_id").attr('disabled', 'disabled');
    $.ajax({
        type: "GET",
        dataType: "json",
        url : get_url,
        success: function(response) {
            $("#size_id").removeAttr('disabled');
            $('.size_wrap').html('<select class="select2" name="size_id[]" id="size_id" '+multiple+' style="width: 100%;" data-error=".size_iderror">'+response+'</select>');
            if(set_disable == 'yes')
            {
                // $("#category_id").attr('disabled', 'disabled');
                if(is_in_modal == 'yes')
                {
                    $("#size_id").select2({
                        disabled:'readonly',
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $("#size_id").select2({
                        disabled:'readonly'
                    });
                }
            }
            else
            {
                if(is_in_modal == 'yes')
                {
                    $("#size_id").select2({
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $('#size_id').select2();
                }
            }
        }
    });
}

function size_tag_select_box(get_url, size_id='', set_disable='', multiple='',parent_id='', is_in_modal='no', modal_id='') {
    $("#size_tag_id").attr('disabled', 'disabled');
    $.ajax({
        type: "GET",
        dataType: "json",
        url : get_url,
        data: {size_tag_id : size_id,product_size_id : parent_id},
        success: function(response) {
            $("#size_tag_id").removeAttr('disabled');
            $('.size_tag_wrap').html('<select class="select2" name="size_tag_id[]" id="size_tag_id" '+multiple+' style="width: 100%;" data-error=".size_tag_iderror">'+response+'</select>');
            if(set_disable == 'yes')
            {
                // $("#category_id").attr('disabled', 'disabled');
                if(is_in_modal == 'yes')
                {
                    $("#size_tag_id").select2({
                        disabled:'readonly',
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $("#size_tag_id").select2({
                        disabled:'readonly'
                    });
                }
            }
            else
            {
                if(is_in_modal == 'yes')
                {
                    $("#size_tag_id").select2({
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $('#size_tag_id').select2();
                }
            }
        }
    });
}

function color_select_box(get_url, color_id='', set_disable='', multiple='', is_in_modal='no', modal_id='') {
    $("#color_id").attr('disabled', 'disabled');
    $.ajax({
        type: "GET",
        dataType: "json",
        url : get_url,
        data: {color_id : color_id},
        success: function(response) {
            $("#color_id").removeAttr('disabled');
            $('.color_wrap').html('<select class="select2" name="color_id" id="color_id" '+multiple+' style="width: 100%;" data-error=".color_iderror">'+response+'</select>');
            if(set_disable == 'yes')
            {
                // $("#category_id").attr('disabled', 'disabled');
                if(is_in_modal == 'yes')
                {
                    $("#color_id").select2({
                        disabled:'readonly',
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $("#color_id").select2({
                        disabled:'readonly'
                    });
                }
            }
            else
            {
                if(is_in_modal == 'yes')
                {
                    $("#color_id").select2({
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $('#color_id').select2();
                }
            }
        }
    });
}

function get_organization_select_box(get_url, organization_id='', set_disable='', multiple='', is_in_modal='no', modal_id='') {
    $("#organization_id").attr('disabled', 'disabled');
    $.ajax({
        type: "GET",
        dataType: "json",
        url : get_url,
        data: {organization_id : organization_id},
        success: function(response) {
            $("#organization_id").removeAttr('disabled');
            $('.organization_wrap').html('<select class="select2" name="organization_id" id="organization_id" '+multiple+' style="width: 100%;" data-error=".organizationiderror">'+response+'</select>');
            if(set_disable == 'yes')
            {
                // $("#category_id").attr('disabled', 'disabled');
                if(is_in_modal == 'yes')
                {
                    $("#organization_id").select2({
                        disabled:'readonly',
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $("#organization_id").select2({
                        disabled:'readonly'
                    });
                }
            }
            else
            {
                if(is_in_modal == 'yes')
                {
                    $("#organization_id").select2({
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $('#organization_id').select2();
                }
            }
        }
    });
}

function product_organization_select_box(get_url, organization_id='', set_disable='', multiple='', is_in_modal='no', modal_id='') {
    $("#product_organization_id").attr('disabled', 'disabled');
    $.ajax({
        type: "GET",
        dataType: "json",
        url : get_url,
        data: {organization_id : organization_id},
        success: function(response) {
            $("#product_organization_id").removeAttr('disabled');
            $('.product_organization_wrap').html('<select class="select2" name="product_organization_id[]" id="product_organization_id" '+multiple+' style="width: 100%;" data-error=".color_iderror">'+response+'</select>');
            if(set_disable == 'yes')
            {
                // $("#category_id").attr('disabled', 'disabled');
                if(is_in_modal == 'yes')
                {
                    $("#product_organization_id").select2({
                        disabled:'readonly',
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $("#product_organization_id").select2({
                        disabled:'readonly'
                    });
                }
            }
            else
            {
                if(is_in_modal == 'yes')
                {
                    $("#product_organization_id").select2({
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $('#product_organization_id').select2({
                        placeholder: "Select a organization",
                    });
                }
            }
        }
    });
}

function role_select_box(get_url, role_id='', set_disable='', multiple='', is_in_modal='no', modal_id='') {
    $("#role_id").attr('disabled', 'disabled');

    $.ajax({
        type: "GET",
        dataType: "json",
        url : get_url,
        data: {role_id : role_id},
        success: function(response) {
            $("#role_id").removeAttr('disabled');
            $('.role_wrap').html('<select class="select2" name="role_id" id="role_id" '+multiple+' style="width: 100%;" data-error=".roleiderror">'+response+'</select>');
            if(set_disable == 'yes')
            {
                // $("#role_id").attr('disabled', 'disabled');
                if(is_in_modal == 'yes')
                {
                    $("#role_id").select2({
                        disabled:'readonly',
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $("#role_id").select2({
                        disabled:'readonly'
                    });
                }
            }
            else
            {
                if(is_in_modal == 'yes')
                {
                    $("#role_id").select2({
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $('#role_id').select2();
                }
            }
        }
    });
}

function user_role_select_box(get_url, user_role_id='', set_disable='', multiple='', is_in_modal='no', modal_id='') {
    $("#user_role_id").attr('disabled', 'disabled');

    $.ajax({
        type: "GET",
        dataType: "json",
        url : get_url,
        data: {role_id : user_role_id},
        success: function(response) {
            $("#user_role_id").removeAttr('disabled');
            $('.user_role_wrap').html('<select class="select2" name="user_role_id" id="user_role_id" '+multiple+' style="width: 100%;" data-error=".userroleiderror">'+response+'</select>');
            if(set_disable == 'yes')
            {
                // $("#role_id").attr('disabled', 'disabled');
                if(is_in_modal == 'yes')
                {
                    $("#user_role_id").select2({
                        disabled:'readonly',
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $("#user_role_id").select2({
                        disabled:'readonly'
                    });
                }
            }
            else
            {
                if(is_in_modal == 'yes')
                {
                    $("#user_role_id").select2({
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $('#user_role_id').select2();
                }
            }
        }
    });
}

function status_select_box() {
    $('.status_wrap').html('<select class="select2" name="status" id="status" multiple style="width: 100%;"><option value="">-- Select Status --</option><option value="1">Active</option><option value="0">In-Active</option></select>');
    $('#status').select2();
    $('#status').val();
}

function clear_from_to_date() {
    $('#fromdateVal').val('');
    $('#todateVal').val('');
}

function product_select_box(get_url, product_id='', set_disable='', multiple='',category_id='',subcategory_id='', is_in_modal='no', modal_id='') {
    $("#coupon_products").attr('disabled', 'disabled');
    $.ajax({
        type: "GET",
        dataType: "json",
        url : get_url,
        data: {product_id : product_id, category_id:category_id, subcategory_id:subcategory_id,},
        success: function(response) {
            $("#coupon_products").removeAttr('disabled');
            $('.coupon_products_wrapper').html('<select class="selectsum2 SumoUnder" name="coupon_products[]" id="coupon_products" '+multiple+' style="width: 100%;" data-error=".coupon_productserror">'+response+'</select>');
            if(set_disable == 'yes')
            {
                if(is_in_modal == 'yes')
                {
                    $("#coupon_products").SumoSelect({
                        disabled:'readonly',
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $("#coupon_products").SumoSelect({
                        disabled:'readonly'
                    });
                }
            }
            else
            {
                if(is_in_modal == 'yes')
                {
                    $("#coupon_products").SumoSelect({
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $('#coupon_products').SumoSelect({ selectAll: true });
                }
            }
        }
    });
}

function user_select_box(get_url, user_id='', set_disable='', multiple='',organization_id='', is_in_modal='no', modal_id='') {
    $("#coupon_applicable_users").attr('disabled', 'disabled');
    $.ajax({
        type: "GET",
        dataType: "json",
        url : get_url,
        data: {user_id : user_id, organization_id:organization_id},
        success: function(response) {
            $("#coupon_applicable_users").removeAttr('disabled');
            $('.coupon_applicable_users_wrapper').html('<select class="select2" name="coupon_applicable_users[]" id="coupon_applicable_users" '+multiple+' style="width: 100%;" data-error=".coupon_applicable_userserror">'+response+'</select>');
            if(set_disable == 'yes')
            {
                // $("#coupon_products").attr('disabled', 'disabled');
                if(is_in_modal == 'yes')
                {
                    $("#coupon_applicable_users").select2({
                        disabled:'readonly',
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $("#coupon_applicable_users").select2({
                        disabled:'readonly'
                    });
                }
            }
            else
            {
                if(is_in_modal == 'yes')
                {
                    $("#coupon_applicable_users").select2({
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    if(multiple == 'multiple'){
                        $('#coupon_applicable_users').SumoSelect({ selectAll: true });
                    }else{
                        $('#coupon_applicable_users').select2();
                    }
                }
            }
        }
    });
}

function coupon_category_select_box(get_url, category_id='', set_disable='', multiple='',parent_id='', is_in_modal='no', modal_id='') {
    $("#coupon_category").attr('disabled', 'disabled');
    
    $.ajax({
        type: "GET",
        dataType: "json",
        url : get_url,
        data: {category_id : category_id, parent_id:parent_id},
        success: function(response) {
            console.log(response);
            $("#coupon_category").removeAttr('disabled');
            $('.coupon_category_wrap').html('<select class="selectsum2 SumoUnder coupon_category" name="coupon_category[]" id="coupon_category" '+multiple+' style="width: 100%;" data-error=".coupon_categoryerror">'+response+'</select>');
            if(set_disable == 'yes')
            {
                // $("#category_id").attr('disabled', 'disabled');
                if(is_in_modal == 'yes')
                {
                    $("#coupon_category").SumoSelect({
                        disabled:'readonly',
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $("#coupon_category").SumoSelect({
                        disabled:'readonly'
                    });
                }
            }
            else
            {
                if(is_in_modal == 'yes')
                {
                    $("#coupon_category").SumoSelect({
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $('#coupon_category').SumoSelect({ selectAll: true });
                }
            }
        }
    });
}

function coupon_subcategory_select_box(get_url, category_id='', set_disable='', multiple='',parent_id='', is_in_modal='no', modal_id='') {
    $("#coupon_subcategory").attr('disabled', 'disabled');
    
    $.ajax({
        type: "GET",
        dataType: "json",
        url : get_url,
        data: {category_id : category_id, parent_id:parent_id},
        success: function(response) {
            $("#coupon_subcategory").removeAttr('disabled');
            $('.coupon_subcategory_wrap').html('<select class="selectsum2 SumoUnder coupon_subcategory" name="coupon_subcategory[]" id="coupon_subcategory" '+multiple+' style="width: 100%;" data-error=".coupon_subcategoryerror">'+response+'</select>');
            if(set_disable == 'yes')
            {
                if(is_in_modal == 'yes')
                {
                    $("#coupon_subcategory").SumoSelect({
                        disabled:'readonly',
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $("#coupon_subcategory").SumoSelect({
                        disabled:'readonly'
                    });
                }
            }
            else
            {
                if(is_in_modal == 'yes')
                {
                    $("#coupon_subcategory").SumoSelect({
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $('#coupon_subcategory').SumoSelect({ selectAll: true });
                }
            }
        }
    });
}

function organization_select_box(get_url, organization_id='', set_disable='', multiple='',parent_id='', is_in_modal='no', modal_id='') {
    $("#organization_id").attr('disabled', 'disabled');
    
    $.ajax({
        type: "GET",
        dataType: "json",
        url : get_url,
        data: {organization_id : organization_id},
        success: function(response) {
            $("#organization_id").removeAttr('disabled');
            $('.organization_id_wrap').html('<select class="select2 organization_id" name="organization_id" id="organization_id" '+multiple+' style="width: 100%;" data-error=".organization_iderror">'+response+'</select>');
            if(set_disable == 'yes')
            {
                if(is_in_modal == 'yes')
                {
                    $("#organization_id").select2({
                        disabled:'readonly',
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $("#organization_id").select2({
                        disabled:'readonly'
                    });
                }
            }
            else
            {
                if(is_in_modal == 'yes')
                {
                    $("#organization_id").select2({
                        dropdownParent: $("#"+modal_id)
                    });
                }
                else
                {
                    $('#organization_id').select2();
                }
            }
        }
    });
}