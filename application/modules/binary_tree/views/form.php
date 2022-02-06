<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header bd-b">
                <h5 class="card-title mb-0"><?php echo $page_title; ?></h5>
            </div>
            <div class="card-body">
                <form id="formId" class="" method="GET" action="<?php echo base_url(binary_constants::binary_tree_list_url); ?>" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf">
                    <input type="hidden" id="id" name="id" value="<?php echo (isset($post_data['id']) ? $post_data['id'] : ''); ?>">


                    
                    <div class="tree d-flex justify-content-center">
                        <ul>
                            <li>
                                <div class="family">
                                 
                                        <div class="person">
                                            <?php $userid = (isset($b_lists['userid']) ? $b_lists['userid'] : '');
                                            $img = color_type($b_type[$userid]); ?>
                                            <?php if (empty($userid)) { ?>
                                                <a class="tree" href="<?php echo base_url(genealogy_constants::left_member_url); ?>"'>
                                                <img src=' <?php echo assets_url('img/tree/addnew2.png'); ?>' /><br />
                                                <span>Add New User</span>
                                                </a>
                                            <?php } else { ?>
                                                <a class="tree" href="<?php echo base_url(binary_constants::binary_tree_url) . '?userid=' . base64_encode($userid); ?>" id='<?php echo $b_details[$userid]; ?>' onmouseover='getTip1(this)'>
                                                    <img src='<?php echo assets_url('img/tree/' . $img . ' '); ?>' /><br />
                                                    <span><?php echo strtoupper($userid); ?></span>
                                                </a>
                                            <?php } ?>
                                        </div>
                                        <ul>
                                            <li>
                                                <div class="family">
                                      
                                                        <div class="person">
                                                            <?php $lt11 = (isset($b_lists['lt11']) ? $b_lists['lt11'] : '');
                                                            $img = color_type($b_type[$lt11]); ?>
                                                            <?php if (empty($lt11)) { ?>
                                                                <a class="tree" href="<?php echo base_url(genealogy_constants::left_member_url); ?>"'>
                                                                <img src=' <?php echo assets_url('img/tree/addnew2.png'); ?>' /><br />
                                                                <span>Add New User</span>
                                                                </a>
                                                            <?php } else { ?>
                                                                <a class="tree" href="<?php echo base_url(binary_constants::binary_tree_url) . '?userid=' .base64_encode($lt11); ?>" id='<?php echo $b_details[$lt11]; ?>' onmouseover='getTip2(this)'>
                                                                    <img src='<?php echo assets_url('img/tree/' . $img . ' '); ?>' /><br />
                                                                    <span><?php echo strtoupper($lt11); ?></span>
                                                                </a>
                                                            <?php } ?>
                                                        </div>

                                                        <ul>
                                                            <li>

                                                                <div class="person child male">
                                                                    <?php $lt21 = (isset($b_lists['lt21']) ? $b_lists['lt21'] : '');
                                                                    $img = color_type($b_type[$lt21]); ?>
                                                                    <?php if (empty($lt21)) { ?>
                                                                        <a class="tree" href="<?php echo base_url(genealogy_constants::left_member_url); ?>"'>
                                                                        <img src=' <?php echo assets_url('img/tree/addnew2.png');?>' /><br />
                                                                        <span>Add New User</span>
                                                                        </a>
                                                                    <?php } else { ?>
                                                                        <a class="tree" href="<?php echo base_url(binary_constants::binary_tree_url) . '?userid=' . base64_encode($lt21); ?>" id='<?php echo $b_details[$lt21]; ?>' onmouseover='getTip4(this)'>
                                                                            <img src='<?php echo assets_url('img/tree/' . $img . ' '); ?>' /><br />
                                                                            <span> <?php echo strtoupper($lt21); ?></span>
                                                                        </a>
                                                                    <?php } ?>

                                                                </div>
                                                            </li>
                                                            <li>

                                                                <div class="person child male">
                                                                    <?php $rt21 = (isset($b_lists['rt21']) ? $b_lists['rt21'] : '');
                                                                    $img = color_type($b_type[$rt21]); ?>
                                                                    <?php if (empty($rt21)) { ?>
                                                                        <a class="tree" href="<?php echo base_url(genealogy_constants::left_member_url); ?>"'>
                                                                        <img src=' <?php echo assets_url('img/tree/addnew2.png'); ?>' /><br />
                                                                        <span>Add New User</span>
                                                                        </a>
                                                                    <?php } else { ?>
                                                                        <a class="tree" href="<?php echo base_url(binary_constants::binary_tree_url) . '?userid=' . base64_encode($rt21); ?>" id='<?php echo $b_details[$rt21]; ?>' onmouseover='getTip5(this)'>
                                                                            <img src='<?php echo assets_url('img/tree/' . $img . ' '); ?>' /><br />
                                                                            <span> <?php echo strtoupper($rt21); ?></span>
                                                                        </a>
                                                                    <?php } ?>

                                                                </div>
                                                            </li>

                                                        </ul>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="family">
                                                    <div class="person">
                                                        <?php $rt11 = (isset($b_lists['rt11']) ? $b_lists['rt11'] : '');
                                                        $img = color_type($b_type[$rt11]); ?>
                                                        <?php if (empty($rt11)) { ?>
                                                            <a class="tree" href="<?php echo base_url(genealogy_constants::left_member_url); ?>"'>
                                                            <img src=' <?php echo assets_url('img/tree/addnew2.png'); ?>' /><br />
                                                            <span>Add New User</span>
                                                            </a>
                                                        <?php } else { ?>
                                                            <a class="tree" href="<?php echo base_url(binary_constants::binary_tree_url) . '?userid=' . base64_encode($rt11); ?>" id='<?php echo $b_details[$rt11]; ?>' onmouseover='getTip3(this)'>
                                                                <img src='<?php echo assets_url('img/tree/' . $img . ' '); ?>' /><br />
                                                                <span> <?php echo strtoupper($rt11); ?></span>
                                                            </a>
                                                        <?php } ?>
                                                    </div>
                                                    <ul>
                                                        <li>
                                                        <div class="person child male">
                                                                <?php $lt22 = (isset($b_lists['lt22']) ? $b_lists['lt22'] : '');
                                                                $img = color_type($b_type[$lt22]); ?>
                                                                <?php if (empty($lt22)) { ?>
                                                                    <a class="tree" href="<?php echo base_url(genealogy_constants::left_member_url); ?>"'>
                                                                    <img src=' <?php echo assets_url('img/tree/addnew2.png'); ?>' /><br />
                                                                    <span>Add New User</span>
                                                                    </a>
                                                                <?php } else { ?>
                                                                    <a class="tree" href="<?php echo base_url(binary_constants::binary_tree_url) . '?userid=' . base64_encode($lt22); ?>" id='<?php echo $b_details[$lt22]; ?>' onmouseover='getTip6(this)'>
                                                                        <img src='<?php echo assets_url('img/tree/' . $img . ' '); ?>' /><br />
                                                                        <span> <?php echo strtoupper($lt22); ?></span>
                                                                    </a>
                                                                <?php } ?>

                                                            </div>
                                                        </li>
                                                        <li>

                                                            <div class="person child male">
                                                                <?php $rt22 = (isset($b_lists['rt22']) ? $b_lists['rt22'] : '');
                                                                $img = color_type($b_type[$rt22]); ?>
                                                                <?php if (empty($rt22)) { ?>
                                                                    <a class="tree" href="<?php echo base_url(genealogy_constants::left_member_url); ?>"'>
                                                                    <img src=' <?php echo assets_url('img/tree/addnew2.png'); ?>' /><br />
                                                                    <span>Add New User</span>
                                                                    </a>
                                                                <?php } else { ?>
                                                                    <a class="tree" href="<?php echo base_url(binary_constants::binary_tree_url) . '?userid=' . base64_encode($rt22); ?>" id='<?php echo $b_details[$rt22]; ?>' onmouseover='getTip7(this)'>
                                                                        <img src='<?php echo assets_url('img/tree/' . $img . ' '); ?>' /><br />
                                                                        <span> <?php echo strtoupper($rt22); ?></span>
                                                                    </a>
                                                                <?php } ?>
                                                            </div>

                                                        </li>

                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                   
                                </div>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    function getTip1(element) {
        $(element).tipbox(element.id, 1);
    }

    function getTip2(element) {
        $(element).tipbox(element.id, 1);
    }

    function getTip3(element) {
        $(element).tipbox(element.id, 1);
    }

    function getTip4(element) {
        $(element).tipbox(element.id, 1);
    }

    function getTip5(element) {
        $(element).tipbox(element.id, 1);
    }

    function getTip6(element) {
        $(element).tipbox(element.id, 1);
    }

    function getTip7(element) {
        $(element).tipbox(element.id, 1);
    }
</script>