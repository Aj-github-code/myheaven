<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('table'); ?>

<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
<input type="hidden" id="franchise_id" name="franchise_id" value="<?php echo $franchise_id; ?>">

<div class="modal" id="kyc-process-modal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content modal-content-demo">
            <form id="kyc-form-id" action="">
                <input type="hidden" name="kyc_id" id="kyc_id" value="">

                <div class="modal-header">
                    <h6 class="modal-title">Process Kyc</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Status <span class="asterisk">*</span></label>
                                <div class="kyc_status_wrap"></div>
                                <div class="kyc_statuserror error_msg"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group m-b-5">
                                <label class="form-label">Reason</label>
                                <textarea class="form-control" id="reason" name="reason" rows="2" data-error=".reasonerror"></textarea>
                                <div class="reasonerror error_msg"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button class="btn btn-main-primary" type="submit">Submit</button>
                    <button class="btn btn-secondary custom-btn-secondary" type="button" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#status').select2();
    $(".pickadate").pickadate({
        // selectYears: 20
    });

    function loadTable() {
        setTimeout(function(){
            initTable();
            hideLoader();
        }, 500);
    }

    function filterTable() {
        showLoader();
        $('#dataTableWrap').html('<div class="table-responsive"><table id="dataTableId"></table></div>');
        loadTable();
    }

    function clearTable() {
        showLoader();
        clear_from_to_date();
        role_select_box(role_url, '', '', 'multiple');
        status_select_box();
        $('#dataTableWrap').html('<div class="table-responsive"><table id="dataTableId"></table></div>');
        loadTable();
    }

    function initTable() {
        $('#dataTableId').bootstrapTable({
            url: base_url+'<?php echo franchise_constants::get_kyc_url; ?>',
            method: 'GET',                
            queryParams: function (params) {
                q = {
                    limit           : params.limit,
                    offset          : params.offset,
                    search          : params.search,
                    sort            : (params.sort ? params.sort : ''),
                    order           : (params.order ? params.order : ''),
                    custom_search   : {
                                        from_date               : $('#fromdateVal').val(),
                                        to_date                 : $('#todateVal').val(),
                                        franchise_id            : $('#franchise_id').val(),
                                        status                  : $('#status').val(),
                                      }
                }
                return q;
            },
            cache: false,
            // height: 580,
            striped: true,
            toolbar: true,
            search: true,
            showRefresh: true,
            showToggle: true,
            showColumns: true,
            detailView: false,
            exportOptions: { ignoreColumn: ['action'], fileName: 'Kyc' },
            showExport: true,
            exportDataType: 'all',
            minimumCountColumns: 2,
            showPaginationSwitch: true,
            pagination: true,
            sidePagination: 'server',
            idField: 'id',
            pageSize: 10,
            pageList: [10, 25, 50, 100, 200],
            showFooter: false,
            clickToSelect: false,
            columns: [
                [
                    {
                        field: 'sr_no',
                        title: 'Sr No.',
                        align: 'center',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'type',
                        title: 'Type',
                        align: 'left',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'file',
                        title: 'File',
                        align: 'left',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'kyc_status',
                        title: 'Kyc Status',
                        align: 'left',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'reason',
                        title: 'Reason',
                        align: 'left',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    // {
                    //     field: 'status',
                    //     title: 'Status',
                    //     align: 'center',
                    //     valign: 'middle',
                    //     sortable: false,
                    //     editable: false,
                    //     footerFormatter: false,
                    // },
                    {
                        field: 'created_on',
                        title: 'Created On',
                        align: 'center',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'action',
                        title: 'Action',
                        align: 'center',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    }
                ]
            ]
        });
    }

    initTable();

    $("#kycStatusForm").validate({
        rules: {
            kyc_status: {
                required: true,
            },
        },
        messages: {
            kyc_status: {
                required: 'Please select status',
            },
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
            
            var csrf_token      = $('#<?php echo $this->security->get_csrf_token_name(); ?>').val();
            var csrf_name       = '<?php echo $this->security->get_csrf_token_name(); ?>';
            var franchise_id    = $('#franchise_id').val();
            var kyc_status      = $('#kyc_status').val();
            var kyc_message     = $('#kyc_message').val();

            $.ajax({
                type: "POST",
                dataType: "json",
                url: base_url+"<?php echo franchise_constants::save_kyc_status_url; ?>",
                async: false,
                data: {[csrf_name] : csrf_token, franchise_id : franchise_id, kyc_status : kyc_status, kyc_message : kyc_message},
                success: function(response){
                    hideLoader();
                    if(response.error == 1)
                    {
                        load_status_popup('error', response.message);
                    }
                    else
                    {
                        load_status_popup("success", response.message);
                        // setTimeout(function(){
                        //     location.reload();
                        // }, 2000);
                    }
                }
            });
        }
    });

    function process_kyc(kyc_id, kyc_status, reason, sel) {
        $('#kyc-process-modal').modal('show');
        $('.kyc_status_wrap').html('<select class="select2" name="kycstatus" id="kycstatus" style="width: 100%;" data-error=".kyc_statuserror"><option value="">-- Select Status --</option><option value="pending">Pending</option><option value="approved">Approve</option><option value="rejected">Reject</option></select>');
        $('#kycstatus').select2({
            dropdownParent: $("#kyc-process-modal"),
        });
        $('#kyc_id').val(kyc_id);
        $("#kycstatus").val(kyc_status).trigger('change');
        $('#reason').val(reason);
    }

    $("#kyc-form-id").validate({
        rules: {
            kycstatus: {
                required: true,
            },
        },
        messages: {
            kycstatus: {
                required: 'Please select status',
            },
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
            
            var csrf_token      = $('#<?php echo $this->security->get_csrf_token_name(); ?>').val();
            var csrf_name       = '<?php echo $this->security->get_csrf_token_name(); ?>';

            $.ajax({
                type: "POST",
                dataType: "json",
                url: base_url+"<?php echo franchise_constants::process_kyc_url; ?>",
                async: false,
                data: {[csrf_name] : csrf_token, franchise_id : $('#franchise_id').val(), kyc_id : $('#kyc_id').val(), kyc_status : $('#kycstatus').val(), reason : $('#reason').val()},
                success: function(response){
                    hideLoader();
                    if(response.error == 1)
                    {
                        load_status_popup('error', response.message);
                    }
                    else
                    {
                        load_status_popup("success", response.message);
                        $('#kyc-process-modal').modal('hide');
                        filterTable();
                    }
                }
            });
        }
    });
</script>