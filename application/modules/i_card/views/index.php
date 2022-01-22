<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style type="text/css">
.bg-grid-line, .icard:after, .icard header:before {
     background-color: #333;
     background-image: linear-gradient(0deg, transparent 24%, rgba(255, 255, 255, .05) 25%, rgba(255, 255, 255, .05) 26%, transparent 27%, transparent 74%, rgba(255, 255, 255, .05) 75%, rgba(255, 255, 255, .05) 76%, transparent 77%, transparent), linear-gradient(90deg, transparent 24%, rgba(255, 255, 255, .05) 25%, rgba(255, 255, 255, .05) 26%, transparent 27%, transparent 74%, rgba(255, 255, 255, .05) 75%, rgba(255, 255, 255, .05) 76%, transparent 77%, transparent);
     height:100%;
     background-size:50px 50px;
}
 .icard {
     position:relative;
     height:100%;
     width:660px;
     margin:0 auto;
     background:#fff;
     border-radius:4px;
     box-shadow: inset 0 0 0 1px rgba(0, 0, 0, .4), 0 0 10px rgba(0, 0, 0, .55), 0 2px 10px rgba(0, 0, 0, .6) ;
}
 /*.icard:hover img {
     -webkit-filter:invert(100%);
     filter:invert(100%);
     border:5px solid rgba(0, 0, 0, .5);
     box-shadow:0 0 3px rgba(255, 255, 255, .25);
}*/
/* card stripe */
/* .icard:before {
     position:absolute;
     z-index:2;
     content:'';
     left:50%;
     top:-82px;
     margin: 0 0 0 -40px;
     height:100px;
     width:80px;
     background: rgba(255, 255, 255, .2);
     background-image: linear-gradient(left, rgba(255,255,255, .4) 0%, rgba(255,255,255, .1) 50%,rgba(255,255,255, .4) 100%), linear-gradient(bottom, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0) 40%), linear-gradient(top, rgba(255, 255, 255, .8) 0%, rgba(255, 255, 255, 0) 40%) ;
     border-radius:6px;
     box-shadow:0 0 0 1px rgba(0, 0, 0, .8);
     opacity:.5;
}*/
/* card stripe clip */
/* .icard:after {
     position:absolute;
     content:'';
     z-index:2;
     height:20px;
     width:20px;
     top:-55px;
     left:50%;
     margin:0 0 0 -10px;
     border-radius:50%;
     box-shadow: 0 0 0 5px rgba(255, 255, 255, .6), 0 0 10px rgba(0, 0, 0, .7), inset 2px 2px 2px rgba(0, 0, 0, .5) ;
}*/
 .icard header {
     position:relative;
     background: #0C0;
     /*height:90px;*/
     width:100%;
     border-top-left-radius:4px;
     border-top-right-radius:4px;
     border-bottom: 2px solid rgba(58, 109, 16, 0.5);
    border-top: 1px solid rgba(69, 218, 16, 0.8);
    box-shadow: inset 0 1px 0 0 rgba(82, 199, 39, 0.8), 0 1px 2px rgba(46, 102, 8, 0.4);
    padding: 20px 20px 15px 20px;
    opacity: .9;
    text-align: center;
}
/* top gradient */
/* .icard header:after {
     position:absolute;
     content:'';
     left:1px;
     top:1px;
     width:100%;
     height:10px;
     background: linear-gradient(bottom, rgba(255,255,255, .1) 0%, rgba(255,255,255,.05) 70%, rgba(255,255,255,0) 100%);
}*/
/* card hole */
 .icard header:before {
     position:absolute;
     z-index:1;
     content:'';
     left:50%;
     top:10px;
     margin: 0 0 0 -50px;
     height:15px;
     width:100px;
     border-radius:25px;
     box-shadow: inset 1px 1px 0 1px rgba(0, 0, 0, .3), inset -1px -1px 0 0 rgba(255, 255, 255, .5) ;
}
 .icard header h1 {
     color:#00185A;
     line-height:90%;
     font-size:24px;
     margin:20px 0 0 0;
     text-shadow:-1px -1px 1px rgba(0, 0, 0, .5);
}
 .icard article {
     padding:23px;
}
 .icard article img {
     border:5px solid #00185A;
     box-shadow:0 0 3px rgba(0, 0, 0, .25);
     float:left;
     margin-right:20px;
     width:190px;
     height:250px;
     transition:all .3s ease-in-out;
}
 .icard article h2 {
     color:#515355;
     float:left;
     margin:0 5px 5px 0;
     font-weight:normal;
     font-size: 20px;
     width:450px;
}
 .icard article .area {
     position:relative;
     height:100%;;
     width:390px;
     float:left;
     margin-bottom: 10px;
     /*overflow-y:scroll;*/
}
 .icard article .area h3 {
     margin:0;
     color:#5F6163;
     font-size:20px 
}
 .icard article .area ul {
     margin:5px 0 30px 0;
     padding:0;
     list-style:none;
}
 .icard article .area ul li {
     margin:20px 0 0 0;
     font-size:16px;
     color:#94957F;
     text-shadow:0 0 1px rgba(0, 0, 0, .3);
}
 .icard article .area ul li .bar {
     position:relative;
     width:280px;
     height:15px;
     display:inline-block;
     border-radius:50px;
     float:right;
     margin:0 15px 0 0;
     opacity:.9;
     background-color:#CACACA;
     box-shadow: inset 0 2px 2px rgba(0, 0, 0, .35);
}
 .icard article .area ul li .bar:before {
     position:absolute;
     left:0;
     width:0;
     height:15px;
     background: rgb(254,213,121);
     box-shadow: inset 0 4px 4px rgba(255, 255, 255, .3), inset 0 -2px 3px rgba(0, 0, 0, .05), 0 1px 0 0px #D29D40 ;
     display:inline-block;
     border-radius:50px;
     content:'';
     z-index:-1;
}
 .icard article .area ul li .bar.percent-100:before {
    width:280px;
}
 .icard article .area ul li .bar.percent-90:before {
    width:260px;
}
 .icard article .area ul li .bar.percent-80:before {
    width:240px;
}
 .icard article .area ul li .bar.percent-70:before {
    width:220px;
}
 .icard article .area ul li .bar.percent-60:before {
    width:200px;
}
 .icard article .area ul li .bar.percent-50:before {
    width:180px;
}
 .icard article .area ul li:before {
     content:'\2605';
     margin-right:5px;
}
 .icard article .area::-webkit-scrollbar {
     width: 10px;
}
 .icard article .area::-webkit-scrollbar-track {
     background-color: rgba(217, 217, 217, .5);
     border-radius:50px;
}
 .icard article .area::-webkit-scrollbar-thumb {
     background: rgba(184, 184, 184, .5);
     box-shadow: inset 1px 1px 0 rgba(0, 0, 0, 0.10), inset 0 -1px 0 rgba(0, 0, 0, 0.07) ;
     border-radius:50px;
}
</style>

<?php
    $profile_pic_url               = getcwd().'/source/backend_assets/img/faces/6.jpg';
    if(!empty($user_data['profile_pic']))
    {
        $profile_pic_url  = getcwd().'/'.$this->config->item('content_path').'profile/'.$user_data['profile_pic'];
    }
?>

<div class="row canvas_div_pdf">
    <div class="col-xl-12 col-lg-12">
        <div class="icard">
            <header>
                <h1>MY HEAVEN MARKETING PVT. LTD.</h1>
            </header>
            <article>
                <?php
                    $profile_pic_url = assets_url('img/faces/6.jpg');
                    if(!empty($user_data['profile_pic']))
                    {
                        $profile_pic_url = content_url('profile/'.$user_data['profile_pic']);
                    }
                ?>
                <img id="thumb" src="<?php echo $profile_pic_url; ?>" alt="<?php echo $user_data['franchise_name']; ?>">
                <div class="area">
                    <h4 style="margin-bottom: 5px;"><?php echo $user_data['franchise_name']; ?></h4>
                    <p style="font-size: 16px;margin-bottom: 5px;"><b>ID:</b> <?php echo $user_data['franchise_code']; ?></p>
                    <p style="font-size: 16px;margin-bottom: 5px;"><b>PAN:</b> <?php echo $user_data['pan']; ?></p>
                    <p style="font-size: 16px;margin-bottom: 5px;"><b>GST:</b> <?php echo $user_data['gst']; ?></p>
                    <p style="font-size: 16px;margin-bottom: 5px;"><b>License:</b> <?php echo $user_data['trade_license_no']; ?></p>
                    <p style="font-size: 16px;margin-bottom: 5px;"><b>Mob:</b> <?php echo $user_data['mobile']; ?></p>
                    <p style="font-size: 16px;margin-bottom: 5px;"><b>Email:</b> <?php echo $user_data['email']; ?></p>
                    <p style="font-size: 16px;margin-bottom: 5px;"><b>Address:</b> <?php echo $user_data['address']; ?></p>
                    <p style="font-size: 16px;margin-bottom: 5px;"><b>Pincode:</b> <?php echo $user_data['pincode']; ?></p>
                </div>
            </article>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-lg-12 text-center mt-3 mb-3">
        <a class="text-warning" title="Print" href="<?php echo base_url(i_card_constants::print_i_card_url); ?>" target="_blank" style="font-size: 40px;">
            <i class="fa fa-print" aria-hidden="true"></i>
        </a>
    </div>
</div>