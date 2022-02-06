<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header bd-b">
                <h5 class="card-title mb-0"><?php echo $page_title; ?></h5>
            </div>
            <div class="card-body">
                <form id="formId" class="" method="POST" action="" enctype="multipart/form-data">
                    <div class="row">
                    <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Copy the below code to refer (left member)</label>
                            </div>
                        </div> 
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="#" onclick="copy_link()" >Click to Copy</a>
                                <input type="hidden" id="theList1" value="<?php echo base_url().signin_constants::register_url.'?sponsor_id='.base64_encode('ROOT').'&placement='.base64_encode('left')?>">
                            </div>
                        </div>
                        
                    </div>                    
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header bd-b">
                <h5 class="card-title mb-0"><?php echo $page_title; ?></h5>
            </div>
            <div class="card-body">
                <form id="formId" class="" method="POST" action="" enctype="multipart/form-data">
                    <div class="row">
                    <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Copy the below code to refer (right member)</label>
                            </div>
                        </div> 
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="#" onclick="copy_link2()" >Click to Copy</a>
                                <input type="hidden" id="theList2" value="<?php echo base_url().signin_constants::register_url.'?sponsor_id='.base64_encode('ROOT').'&placement='.base64_encode('right')?>">
                            </div>
                        </div>
                        
                    </div>                    
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    function copy_link() {
        if(navigator.clipboard.writeText($('#theList1').val()))
        {
        alert('code copied');
        }
        else{alert('sSomething wrong');}
    }
    function copy_link2() {
        if(navigator.clipboard.writeText($('#theList2').val()))
        {
        alert('code copied');
        }
        else{alert('sSomething wrong');}
    }
</script>