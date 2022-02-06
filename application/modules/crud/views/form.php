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
                                <label class="form-label">Copy the below code to refer (right member)</label>
                            </div>
                        </div> 
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="#" onclick="copy_link()" >Click to Copy</a>
                                <input type="hidden" id="theList" value="left c0de">
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
        if(navigator.clipboard.writeText($('#theList').val()))
        {
        alert('code copied');
        }
        else{alert('sSomething wrong');}
    }
</script>