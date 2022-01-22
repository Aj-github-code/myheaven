<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card custom-card" id="additional-alerts">
            <div class="card-header bd-b">
                <h6 class="card-title mb-0">Kyc Status</h6>
            </div>
            <div class="card-body">
                <form class="" action="" id="kycStatusForm">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Kyc Status</label>
                                <select class="form-control select2" name="kyc_status" id="kyc_status" data-error=".kycstatuserror" style="width: 100%;">
                                    <option value="">-- Select Kyc Status --</option>
                                    <option value="pending" <?php if(isset($kyc_status) && $kyc_status == 'pending'){ echo 'selected="selected"'; } ?>>Pending</option>
                                    <option value="approved" <?php if(isset($kyc_status) && $kyc_status == 'approved'){ echo 'selected="selected"'; } ?>>Approve</option>
                                    <option value="rejected" <?php if(isset($kyc_status) && $kyc_status == 'rejected'){ echo 'selected="selected"'; } ?>>Reject</option>
                                </select>
                                <div class="kycstatuserror error_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Kyc Message</label>
                                <textarea class="form-control" id="kyc_message" name="kyc_message"><?php echo (isset($kyc_message) ? $kyc_message : ''); ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-main-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header bd-b">
                <div class="row">
                    <div class="col-md-12"><h5 class="card-title m-t-8 mb-0"><?php echo $page_title; ?></h5></div>
                </div>
            </div>
            <div class="card-body">
                <div id="dataTableWrap">
                    <div class="table-responsive">
                        <table id="dataTableId"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>