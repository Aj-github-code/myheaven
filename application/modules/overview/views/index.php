<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="page-content-wrap">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">  
                            <div class="panel-body">                                                                        
                                <div class="content-frame">                                    
                                    <div class="content-frame-top d-flex justify-content-between">                        
                                        <div class="page-title">                    
                                            <h2><span class="fa fa-file-text"></span>Welcome Message</h2>
                                        </div>                                                                                
                                        <div class="pull-right">                                                                                    
                                            <a href="#" onclick="printDiv('printableArea')"> <button class="btn btn-default"><span class="fa fa-print"></span> Print</button></a>
                                            <!-- <button class="btn btn-default content-frame-left-toggle" ><span class="fa fa-bars"></span></button> -->
                                        </div>                        
                                    </div>
                                    <div class="panel panel-default" id="printableArea">
                                        
                                        <div class="panel-body">
                                            <h3><strong>Dear Associate, <?php echo ($row["gender"]=="female") ? "Mrs" : "Mr." ; ?> <?php echo $row["firstname"]." ".$row["midname"]." ".$row["lastname"]." ". $userid;?></strong> <small class="pull-right text-muted"><span class="fa fa-clock-o"></span></small></h3>
                                            
                                            <br/><br/>
                                                                On Behalf of the entire team of <i>My Heaven</i>  we welcome you for taking the great decision of joining our ever
                                                growing <i>My Heaven</i> family. We take great pride that you have taken this opportunity to be with us and serve you for your
                                                business needs.<br/><br/>
                                                At <i>My Heaven</i> we pride our self on offering our Associate responsive, competent, and excellent services
                                                towards the most important part of our business – Our Associates. At <i>My Heaven</i>, we strive tirelessly with the utmost
                                                commitment to help achieve your goals, fulfilling all your dreams and ensure you complete satisfaction. This is the
                                                beginning of a new era of relationship and contacts in the field of Healthcare and Wellness Industry.<br/><br/>
                                                You are now a part of the opportunity of the Millennium with the most lucrative and exciting business that has the
                                                potential to turn your dreams into reality, building your business, establishing lifelong relationships combined with
                                                development of support systems unparalleled in any other business. <br/><br/>
                                                We thank you for entrusting the <i>My Heaven</i> team with your most important business needs, ensuring to serve you better
                                                at each Step. <br/><br/>
                                                Wishing you all the best for your future achievements. <br/><br/>
                                                Warmest Welcome and Regards.
                                            <br/><br/>Truly Yours,<br/>
                                            <strong>The <i>My Heaven</i></strong>

                                            
                                            <div class="form-group push-up-20">
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>        
                            </div>                        
                        </div>                       
                    </div>
                </div>
            </div>         
        </div>            
    </div>
</div>


<script >
    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
    </script>