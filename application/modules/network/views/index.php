<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> Variance Tree</h2>
</div>
<!-- END PAGE TITLE -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">



    <div class="row">



        <!-- START DATATABLE EXPORT -->
        <form style="overflow-x: auto;overflow-y: hidden;height: 600px;background: #fff;" action="" method="post" enctype='multipart/form-data' class="form-horizontal">
            <div class="panel panel-default">


                <style>
                    @media screen and (max-width: 480px) {
                        .row-list {
                            overflow-x: scroll;
                            overflow-y: scroll;
                            height: 600px;
                        }
                    }
                </style>
                <section style="height: 600px;width: 1000px;" class="content row-list">
                    <div class="row ">
                        <div class="col-md-12">
                            <div style="position:absolute; display:block; left: 46%; width: 100px; height: 100px; top: 44px;">
                                <div align='center' rel='htmltooltip'>

                                    <?php
                                    $userid = strtoupper($userid);
                                    $userownid = strtoupper($userownid);
                                    $type = paidtype($userid);
                                    if ($type == true) {
                                        if ($type == 5) {
                                            $img = 'male-green.png';
                                        }

                                        if ($type == 10) {
                                            $img = 'blue.jpg';
                                        }
                                    } else {
                                        $img = 'red.png';
                                    }
                                   ?>
                                    <?php

                                    $table1 = $objuserClass->getUserDetails($userid);

                                    ?>

                                    <a class="tree" href='binary_tree.php?userid=<?php echo strtoupper($userid); ?>' id='<?php echo $table1; ?>' onmouseover='getTip1(this)'>
                                        <img src='../admin/image/<?php echo $img; ?>' style='border:none;z-index:-100;     margin-left: -158px !important;' /><br />
                                        <span style="margin-left: -158px !important;"> <?php echo strtoupper($userid); ?></span> </a>

                                    <?php
                                    $rowlevel111 = $objuserClass->getUser($userid);
                                    $lt1 = $rowlevel111['leftmember'];
                                    $rt1 = $rowlevel111['rightmember'];


                                    ?>

                                </div>
                            </div>



                            <div align="center" style="position:absolute; top: 130px; right:27%; width: 50%;  color:#FF6600; border-top:1px solid black;"></div>
                            <div style="position:absolute; display:block; left:18%; width: 100px; height: 100px; top: 139px;">

                                <?php if ($memberid1 == '') {
                                    $image = "../img/member/adduser.png";
                                    $href = "add_member.php?sid=" . $post_mid;
                                } else {
                                    $image = "../img/member/user.png";
                                    $href = "?user=" . $memberid1;
                                } ?>
                                <div align='center' rel='htmltooltip'>

                                    <?php
                                    if ($lt1 == NULL) { ?>
                                        <a class="tree" target="_bkank" href='../registration.php?placeid=<?php echo $userid; ?>&placement=left'> <img src='../admin/image/addnew2.png' style='border:none' /><br />
                                            Add&nbsp;New
                                            LEFT
                                        </a>
                                    <?php     } else {
                                        $table2 = $objuserClass->getUserDetails($lt1);
                                        $type = paidtype($lt1);
                                        if ($type == true) {
                                            if ($type == 5) {
                                                $img = 'male-green.png';
                                            }

                                            if ($type == 10) {
                                                $img = 'blue.jpg';
                                            }
                                        } else {
                                            $img = 'red.png';
                                        }

                                    ?>
                                        <a class="tree" href='binary_tree.php?userid=<?php echo strtoupper($lt1); ?>' id='<?php echo $table2; ?>' onmouseover='getTip2(this)'> <img src='../admin/image/<?php echo $img; ?>' style='border:none' /><br />
                                            <?php echo strtoupper($lt1); ?> </a>
                                    <?php }

                                    $rowlevel222 = $objuserClass->getUser($lt1);
                                    $lt21 = $rowlevel222['leftmember'];
                                    $rt21 = $rowlevel222['rightmember'];

                                    ?>


                                </div>


                                <div align="left" style="position:absolute; top: 100px; left:4%; width: 185%;  color:#FF6600; border-top:1px solid black;"></div>
                                <div style="position:absolute; display:block; right: 64%; width: 100px; height: 100px; top: 112px;">
                                    <!--node 2-->


                                    <div align='center' rel='htmltooltip'>

                                        <?php
                                        if ($lt1 == NULL) { ?>
                                            <img src='../admin/image/addnew2.png' style='border:none' />
                                            <?php   } else {
                                            if ($lt21 == NULL) { ?>
                                                <a class="tree" target="_bkank" href='../registration.php?placeid=<?php echo $lt1; ?>&placement=left'>
                                                    <img src='../admin/image/addnew2.png' style='border:none' /><br />
                                                    Add&nbsp;New
                                                    LEFT </a>
                                            <?php       } else {
                                                $table4 = $objuserClass->getUserDetails($lt21);
                                                $type = paidtype($lt21);
                                                if ($type == true) {
                                                    if ($type == 5) {
                                                        $img = 'male-green.png';
                                                    }

                                                    if ($type == 10) {
                                                        $img = 'blue.jpg';
                                                    }
                                                } else {
                                                    $img = 'red.png';
                                                }

                                            ?>
                                                <a class="tree" href='binary_tree.php?userid=<?php echo strtoupper($lt21); ?>' id='<?php echo $table4; ?>' onmouseover='getTip4(this)'>
                                                    <img src='../admin/image/<?php echo $img; ?>' style='border:none' /><br />
                                                    <?php echo strtoupper($lt21); ?> </a>
                                        <?php   }

                                            $rowlevel444 = $objuserClass->getUser($lt21);
                                            $lt31 = $rowlevel444['leftmember'];
                                            $rt31 = $rowlevel444['rightmember'];
                                        }
                                        ?>





                                    </div>





                                    <!--down member-->

                                    <div align="left" style="position:absolute; top: 80px; right:10%; width: 145%;  color:#FF6600; border-top:1px solid black;"></div>
                                    <div style="position:absolute; display:block; right: 99%; width: 100px; height: 100px; top: 85px;">



                                        <div align='center' rel='htmltooltip'>


                                            <?php
                                            if ($lt31 == NULL) { ?>
                                                <img src='../admin/image/addnew2.png' style='border:none' />
                                                <?php   } else {
                                                if ($lt31 == NULL) { ?>
                                                    <a class="tree" target="_bkank" href='../registration.php?placeid=<?php echo $lt1; ?>&placement=left'>
                                                        <img src='../admin/image/addnew2.png' style='border:none' /><br />
                                                        Add&nbsp;New
                                                        LEFT </a>
                                                <?php       } else {
                                                    $table4 = $objuserClass->getUserDetails($lt31);
                                                    $type = paidtype($lt31);
                                                    if ($type == true) {
                                                        if ($type == 5) {
                                                            $img = 'male-green.png';
                                                        }

                                                        if ($type == 10) {
                                                            $img = 'blue.jpg';
                                                        }
                                                    } else {
                                                        $img = 'red.png';
                                                    }

                                                ?>
                                                    <a class="tree" href='binary_tree.php?userid=<?php echo strtoupper($lt31); ?>' id='<?php echo $table4; ?>' onmouseover='getTip4(this)'>
                                                        <img src='../admin/image/<?php echo $img; ?>' style='border:none' /><br />
                                                        <?php echo strtoupper($lt31); ?> </a>
                                            <?php   }

                                                /*      no down member now in the try                       $rowlevel444 = $objuserClass->getUser($lt31);
                                $lt31 = $rowlevel444['leftmember']; 
                                $rt31 = $rowlevel444['rightmember']; */
                                            }
                                            ?>



                                        </div>
                                    </div>

                                    <div style="position:absolute; display:block; left: 40%; width: 100px; height: 100px; top: 85px;">

                                        <div align='center' rel='htmltooltip'>


                                            <?php
                                            if ($rt31 == NULL) { ?>
                                                <img src='../admin/image/addnew2.png' style='border:none' />
                                                <?php   } else {
                                                if ($rt31 == NULL) { ?>
                                                    <a class="tree" target="_bkank" href='../registration.php?placeid=<?php echo $lt1; ?>&placement=left'>
                                                        <img src='../admin/image/addnew2.png' style='border:none' /><br />
                                                        Add&nbsp;New
                                                        LEFT </a>
                                                <?php       } else {
                                                    $table4 = $objuserClass->getUserDetails($rt31);
                                                    $type = paidtype($rt31);
                                                    if ($type == true) {
                                                        if ($type == 5) {
                                                            $img = 'male-green.png';
                                                        }

                                                        if ($type == 10) {
                                                            $img = 'blue.jpg';
                                                        }
                                                    } else {
                                                        $img = 'red.png';
                                                    }

                                                ?>
                                                    <a class="tree" href='binary_tree.php?userid=<?php echo strtoupper($rt31); ?>' id='<?php echo $table4; ?>' onmouseover='getTip4(this)'>
                                                        <img src='../admin/image/<?php echo $img; ?>' style='border:none' /><br />
                                                        <?php echo strtoupper($rt31); ?> </a>
                                            <?php   }

                                                /*      no down member now in the try                       $rowlevel444 = $objuserClass->getUser($lt31);
                                $lt31 = $rowlevel444['leftmember']; 
                                $rt31 = $rowlevel444['rightmember']; */
                                            }
                                            ?>



                                        </div>
                                    </div>

                                </div>

                                <div style="position:absolute; display:block; left: 135%; width: 100px; height: 100px; top: 112px;">

                                    <div align='center' rel='htmltooltip'>






                                        <?php
                                        if ($lt1 == NULL) { ?>
                                            <img src='../admin/image/addnew2.png' style='border:none' />
                                            <?php   } else {
                                            if ($rt21 == NULL) { ?>
                                                <a class="tree" target="_bkank" href='../registration.php?placeid=<?php echo $lt1; ?>&placement=right'>
                                                    <img src='../admin/image/addnew2.png' style='border:none' /><br />Add&nbsp;New RIGHT </a>
                                            <?php       } else {
                                                $table5 = $objuserClass->getUserDetails($rt21);
                                                $type = paidtype($rt21);
                                                if ($type == true) {
                                                    if ($type == 5) {
                                                        $img = 'male-green.png';
                                                    }

                                                    if ($type == 10) {
                                                        $img = 'blue.jpg';
                                                    }
                                                } else {
                                                    $img = 'red.png';
                                                }
                                            ?>
                                                <a class="tree" href='binary_tree.php?userid=<?php echo strtoupper($rt21); ?>' id='<?php echo $table5; ?>' onmouseover='getTip5(this)'>
                                                    <img src='../admin/image/<?php echo $img; ?>' style='border:none' /><br />
                                                    <?php echo strtoupper($rt21); ?> </a>
                                        <?php   }

                                            $rowlevel555 = $objuserClass->getUser($rt21);
                                            $lt32 = $rowlevel555['leftmember'];
                                            $rt32 = $rowlevel555['rightmember'];
                                        }
                                        ?>


                                    </div>

                                    <!--down member-->

                                    <div align="left" style="position:absolute; top: 80px; left:10%; width: 145%;  color:#FF6600; border-top:1px solid black;"></div>
                                    <div style="position:absolute; display:block; right: 50%; width: 100px; height: 100px; top: 85px;">

                                        <div align='center' rel='htmltooltip'>


                                            <?php
                                            if ($lt32 == NULL) { ?>
                                                <img src='../admin/image/addnew2.png' style='border:none' />
                                                <?php   } else {
                                                if ($lt32 == NULL) { ?>
                                                    <a class="tree" target="_bkank" href='../registration.php?placeid=<?php echo $lt32; ?>&placement=right'>
                                                        <img src='../admin/image/addnew2.png' style='border:none' /><br />
                                                        Add&nbsp;New
                                                        RIGHT </a>
                                                <?php       } else {
                                                    $table5 = $objuserClass->getUserDetails($lt32);
                                                    $type = paidtype($lt32);
                                                    if ($type == true) {
                                                        if ($type == 5) {
                                                            $img = 'male-green.png';
                                                        }

                                                        if ($type == 10) {
                                                            $img = 'blue.jpg';
                                                        }
                                                    } else {
                                                        $img = 'red.png';
                                                    }
                                                ?>
                                                    <a class="tree" href='binary_tree.php?userid=<?php echo strtoupper($lt32); ?>' id='<?php echo $table5; ?>' onmouseover='getTip5(this)'>
                                                        <img src='../admin/image/<?php echo $img; ?>' style='border:none' /><br />
                                                        <?php echo strtoupper($lt32); ?> </a>
                                            <?php   }

                                                /* $rowlevel555 = $objuserClass->getUser($lt32);
                            $lt32 = $rowlevel555['leftmember']; 
                            $rt32 = $rowlevel555['rightmember']; */
                                            }
                                            ?>

                                        </div>
                                    </div>

                                    <div style="position:absolute; display:block; left: 110%; width: 100px; height: 100px; top: 85px;">

                                        <div align='center' rel='htmltooltip'>
                                            <?php
                                            if ($rt32 == NULL) { ?>
                                                <img src='../admin/image/addnew2.png' style='border:none' />
                                                <?php   } else {
                                                if ($rt32 == NULL) { ?>
                                                    <a class="tree" target="_bkank" href='../registration.php?placeid=<?php echo $rt32; ?>&placement=right'>
                                                        <img src='../admin/image/addnew2.png' style='border:none' /><br />
                                                        Add&nbsp;New
                                                        RIGHT </a>
                                                <?php       } else {
                                                    $table5 = $objuserClass->getUserDetails($rt32);
                                                    $type = paidtype($rt32);
                                                    if ($type == true) {
                                                        if ($type == 5) {
                                                            $img = 'male-green.png';
                                                        }

                                                        if ($type == 10) {
                                                            $img = 'blue.jpg';
                                                        }
                                                    } else {
                                                        $img = 'red.png';
                                                    }
                                                ?>
                                                    <a class="tree" href='binary_tree.php?userid=<?php echo strtoupper($rt32); ?>' id='<?php echo $table5; ?>' onmouseover='getTip5(this)'>
                                                        <img src='../admin/image/<?php echo $img; ?>' style='border:none' /><br />
                                                        <?php echo strtoupper($rt32); ?> </a>
                                            <?php   }

                                                /* $rowlevel555 = $objuserClass->getUser($lt32);
                            $lt32 = $rowlevel555['leftmember']; 
                            $rt32 = $rowlevel555['rightmember']; */
                                            }
                                            ?>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <!--right side-->
                            <div style="position:absolute; display:block; left: 69%; width: 100px; height: 100px; top: 139px;">
                                <?php if ($memberid8 == '') {
                                    $image = "../img/member/adduser.png";
                                    $href = "add_member.php?sid=" . $post_mid;
                                } else {
                                    $image = "../img/member/user.png";
                                    $href = "?user=" . $memberid8;
                                } ?>
                                <div align='center' rel='htmltooltip'><?php
                                                                        if ($rt1 == NULL) { ?>
                                        <a class="tree" target="_bkank" href='../registration.php?placeid=<?php echo $userid; ?>&placement=right'>
                                            <img src='../admin/image/addnew2.png' style='border:none' /><br />
                                            Add&nbsp;New
                                            RIGHT </a>
                                    <?php       } else {
                                                                            $table3 = $objuserClass->getUserDetails($rt1);
                                                                            $type = paidtype($rt1);
                                                                            if ($type == true) {
                                                                                if ($type == 5) {
                                                                                    $img = 'male-green.png';
                                                                                }

                                                                                if ($type == 10) {
                                                                                    $img = 'blue.jpg';
                                                                                }
                                                                            } else {
                                                                                $img = 'red.png';
                                                                            }

                                    ?>
                                        <a class="tree" href='binary_tree.php?userid=<?php echo strtoupper($rt1); ?>' id='<?php echo $table3; ?>' onmouseover='getTip3(this)'>
                                            <img src='../admin/image/<?php echo $img; ?>' style='border:none' /><br />
                                            <?php echo strtoupper($rt1); ?>
                                        </a>
                                    <?php   }

                                                                        $rowlevel333 = $objuserClass->getUser($rt1);
                                                                        $lt22 = $rowlevel333['leftmember'];
                                                                        $rt22 = $rowlevel333['rightmember'];

                                    ?>
                                </div>

                                <div align="right" style="position:absolute; top: 100px; left:14%; width: 195%;  color:#FF6600; border-top:1px solid black;"></div>
                                <div style="position:absolute; display:block; right: 44%; width: 100px; height: 100px; top: 112px;">



                                    <div align='center' rel='htmltooltip'>



                                        <?php
                                        if ($rt1 == NULL) { ?>
                                            <img src='../admin/image/addnew2.png' style='border:none' />
                                            <?php       } else {
                                            if ($lt22 == NULL) { ?>
                                                <a class="tree" target="_bkank" href='../registration.php?placeid=<?php echo $rt1; ?>&placement=left'>
                                                    <img src='../admin/image/addnew2.png' style='border:none' /><br />
                                                    Add&nbsp;New
                                                    LEFT </a>
                                            <?php       } else {
                                                $table6 = $objuserClass->getUserDetails($lt22);
                                                $type = paidtype($lt22);
                                                if ($type == true) {
                                                    if ($type == 5) {
                                                        $img = 'male-green.png';
                                                    }

                                                    if ($type == 10) {
                                                        $img = 'blue.jpg';
                                                    }
                                                } else {
                                                    $img = 'red.png';
                                                }
                                            ?>
                                                <a class="tree" href='binary_tree.php?userid=<?php echo strtoupper($lt22); ?>' id='<?php echo $table6; ?>' onmouseover='getTip6(this)'>
                                                    <img src='../admin/image/<?php echo $img; ?>' style='border:none' /><br />
                                                    <?php echo strtoupper($lt22); ?> </a>
                                        <?php   }

                                            $rowlevel666 = $objuserClass->getUser($lt22);
                                            $lt33 = $rowlevel666['leftmember'];
                                            $rt33 = $rowlevel666['rightmember'];
                                        }
                                        ?>





                                    </div>




                                    <div align="right" style="position:absolute; top: 80px; right:10%; width: 145%;  color:#FF6600; border-top:1px solid black;"></div>
                                    <div style="position:absolute; display:block; right: 110%; width: 100px; height: 100px; top: 85px;">

                                        <div align='center' rel='htmltooltip'>


                                            <?php
                                            if ($lt33 == NULL) { ?>
                                                <img src='../admin/image/addnew2.png' style='border:none' />
                                                <?php       } else {
                                                if ($lt33 == NULL) { ?>
                                                    <a class="tree" target="_bkank" href='../registration.php?placeid=<?php echo $lt33; ?>&placement=left'>
                                                        <img src='../admin/image/addnew2.png' style='border:none' /><br />
                                                        Add&nbsp;New
                                                        LEFT </a>
                                                <?php       } else {
                                                    $table6 = $objuserClass->getUserDetails($lt33);
                                                    $type = paidtype($lt33);
                                                    if ($type == true) {
                                                        if ($type == 5) {
                                                            $img = 'male-green.png';
                                                        }

                                                        if ($type == 10) {
                                                            $img = 'blue.jpg';
                                                        }
                                                    } else {
                                                        $img = 'red.png';
                                                    }
                                                ?>
                                                    <a class="tree" href='binary_tree.php?userid=<?php echo strtoupper($lt33); ?>' id='<?php echo $table6; ?>' onmouseover='getTip6(this)'>
                                                        <img src='../admin/image/<?php echo $img; ?>' style='border:none' /><br />
                                                        <?php echo strtoupper($lt33); ?> </a>
                                            <?php   }

                                                /* $rowlevel666 = $objuserClass->getUser($lt22);
                                $lt33 = $rowlevel666['leftmember']; 
                                $rt33 = $rowlevel666['rightmember']; */
                                            }
                                            ?>




                                        </div>
                                    </div>

                                    <div style="position:absolute; display:block; left: 44%; width: 100px; height: 100px; top: 85px;">

                                        <div align='center' rel='htmltooltip'>

                                            <?php
                                            if ($rt33 == NULL) { ?>
                                                <img src='../admin/image/addnew2.png' style='border:none' />
                                                <?php       } else {
                                                if ($rt33 == NULL) { ?>
                                                    <a class="tree" target="_bkank" href='../registration.php?placeid=<?php echo $rt33; ?>&placement=left'>
                                                        <img src='../admin/image/addnew2.png' style='border:none' /><br />
                                                        Add&nbsp;New
                                                        LEFT </a>
                                                <?php       } else {
                                                    $table6 = $objuserClass->getUserDetails($rt33);
                                                    $type = paidtype($rt33);
                                                    if ($type == true) {
                                                        if ($type == 5) {
                                                            $img = 'male-green.png';
                                                        }

                                                        if ($type == 10) {
                                                            $img = 'blue.jpg';
                                                        }
                                                    } else {
                                                        $img = 'red.png';
                                                    }
                                                ?>
                                                    <a class="tree" href='binary_tree.php?userid=<?php echo strtoupper($rt33); ?>' id='<?php echo $table6; ?>' onmouseover='getTip6(this)'>
                                                        <img src='../admin/image/<?php echo $img; ?>' style='border:none' /><br />
                                                        <?php echo strtoupper($rt33); ?> </a>
                                            <?php   }

                                                /* $rowlevel666 = $objuserClass->getUser($lt22);
                                $lt33 = $rowlevel666['leftmember']; 
                                $rt33 = $rowlevel666['rightmember']; */
                                            }
                                            ?>



                                        </div>
                                    </div>


                                </div>

                                <!--right sideicon-->





                                <div style="position:absolute; display:block; left: 149%; width: 100px; height: 100px; top: 112px;">

                                    <div align='right' rel='htmltooltip'>
                                        <?php
                                        if ($rt1 == NULL) { ?>
                                            <img src='../admin/image/addnew2.png' height='60' width='60' style='border:none' />
                                            <?php           } else {
                                            if ($rt22 == NULL) { ?>
                                                <a class="tree" target="_bkank" href='../registration.php?placeid=<?php echo $rt1; ?>&placement=right'>
                                                    <img src='../admin/image/addnew2.png' height='60' width='60' style='border:none' /><br />
                                                    Add&nbsp;New
                                                    RIGHT </a>
                                            <?php       } else {
                                                $table7 = $objuserClass->getUserDetails($rt22);
                                                $type = paidtype($rt22);
                                                if ($type == true) {
                                                    if ($type == 5) {
                                                        $img = 'male-green.png';
                                                    }

                                                    if ($type == 10) {
                                                        $img = 'blue.jpg';
                                                    }
                                                } else {
                                                    $img = 'red.png';
                                                }
                                            ?>
                                                <a class="tree" href='binary_tree.php?userid=<?php echo strtoupper($rt22); ?>' id='<?php echo $table7; ?>' onmouseover='getTip7(this)'>
                                                    <img src='../admin/image/<?php echo $img; ?>' style='border:none' /><br />
                                                    <?php echo strtoupper($rt22); ?> </a>
                                        <?php   }

                                            $rowlevel777 = $objuserClass->getUser($rt22);
                                            $lt34 = $rowlevel777['leftmember'];
                                            $rt34 = $rowlevel777['rightmember'];
                                        }
                                        ?>



                                    </div>


                                    <div align="right" style="position:absolute; top: 80px; lefts:10%; width: 145%;  color:#FF6600; border-top:1px solid black;"></div>

                                    <div style="position:absolute; display:block; right: 58%; width: 100px; height: 100px; top: 85px;">

                                        <div align='center' rel='htmltooltip'>

                                            <?php
                                            if ($lt34 == NULL) { ?>
                                                <img src='../admin/image/addnew2.png' height='60' width='60' style='border:none' />
                                                <?php           } else {
                                                if ($lt34 == NULL) { ?>
                                                    <a class="tree" target="_bkank" href='../registration.php?placeid=<?php echo $lt34; ?>&placement=right'>
                                                        <img src='../admin/image/addnew2.png' height='60' width='60' style='border:none' /><br />
                                                        Add&nbsp;New
                                                        RIGHT </a>
                                                <?php       } else {
                                                    $table7 = $objuserClass->getUserDetails($lt34);
                                                    $type = paidtype($lt34);
                                                    if ($type == true) {
                                                        if ($type == 5) {
                                                            $img = 'male-green.png';
                                                        }

                                                        if ($type == 10) {
                                                            $img = 'blue.jpg';
                                                        }
                                                    } else {
                                                        $img = 'red.png';
                                                    }
                                                ?>
                                                    <a class="tree" href='binary_tree.php?userid=<?php echo strtoupper($lt34); ?>' id='<?php echo $table7; ?>' onmouseover='getTip7(this)'>
                                                        <img src='../admin/image/<?php echo $img; ?>' style='border:none' /><br />
                                                        <?php echo strtoupper($lt34); ?> </a>
                                            <?php   }
                                                /*                          
                            $rowlevel777 = $objuserClass->getUser($rt22);
                            $lt34 = $rowlevel777['leftmember']; 
                            $rt34 = $rowlevel777['rightmember']; */
                                            }
                                            ?>




                                        </div>
                                    </div>



                                    <div style="position:absolute; display:block; left: 99%; width: 100px; height: 100px; top: 85px;">

                                        <div align='center' rel='htmltooltip'> <?php
                                                                                if ($rt34 == NULL) { ?>
                                                <img src='../admin/image/addnew2.png' height='60' width='60' style='border:none' />
                                                <?php           } else {
                                                                                    if ($rt34 == NULL) { ?>
                                                    <a class="tree" target="_bkank" href='../registration.php?placeid=<?php echo $rt34; ?>&placement=right'>
                                                        <img src='../admin/image/addnew2.png' height='60' width='60' style='border:none' /><br />
                                                        Add&nbsp;New
                                                        RIGHT </a>
                                                <?php       } else {
                                                                                        $table7 = $objuserClass->getUserDetails($rt34);
                                                                                        $type = paidtype($rt34);
                                                                                        if ($type == true) {

                                                                                            if ($type == 5) {
                                                                                                $img = 'male-green.png';
                                                                                            }

                                                                                            if ($type == 10) {
                                                                                                $img = 'blue.jpg';
                                                                                            }
                                                                                        } else {
                                                                                            $img = 'red.png';
                                                                                        }
                                                ?>
                                                    <a class="tree" href='binary_tree.php?userid=<?php echo strtoupper($rt34); ?>' id='<?php echo $table7; ?>' onmouseover='getTip7(this)'>
                                                        <img src='../admin/image/<?php echo $img; ?>' style='border:none' /><br />
                                                        <?php echo strtoupper($rt34); ?> </a>
                                            <?php   }
                                                                                    /*                          
                            $rowlevel777 = $objuserClass->getUser($rt22);
                            $lt34 = $rowlevel777['leftmember']; 
                            $rt34 = $rowlevel777['rightmember']; */
                                                                                }
                                            ?>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </section>

            </div>

    </div>
    </form>

    <!-- END DATATABLE EXPORT -->


</div>
</div>

</div>
<!-- END PAGE CONTENT WRAPPER -->
</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<?php require_once("footer_new.php"); ?>
<!--         <script src="../admin/js/jquery.js" type="text/javascript" charset="utf-8"></script>
 -->
<!-- <script src="../admin/js/jquery.tipbox.js" type="text/javascript"></script> -->
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

    $(function() {


        $('#button').click(function(e) {

            //alert("clicked");
            e.preventDefault();
            var datastring = $("#searchForm").serialize();
            /* alert(datastring);  */

            $.ajax({
                type: 'post',
                data: datastring,
                url: 'ajax/ajax_validate_Downline.php',
                success: function(result) {
                    /* alert(result); */
                    if (result == "1") {
                        //window.location.href="registrating_form1.php?"+datastring;
                        $("#ContentPlaceHolder1_ValidationSummary1").html("");
                        $("#searchForm").submit();

                    } else {
                        $("#ContentPlaceHolder1_ValidationSummary1").css({
                            'color': '#F00058'
                        });
                        $("#ContentPlaceHolder1_ValidationSummary1").html(result);

                        $('#ContentPlaceHolder1_ValidationSummary1').show();
                    }
                }
            });
        });


    });
</script>
<script>
    $(document).ready(function() {
        var placementRight = 'right';
        var placementLeft = 'left';

        if ($('body').hasClass('rtl')) {
            placementRight = 'left';
            placementLeft = 'right';
        }

        // Define the tour!
        var tour = {
            id: "AFRO-intro",
            steps: [{
                    target: "user-left-box",
                    title: "Your tree ",
                    content: "You can find here status of your tree",
                    placement: placementRight,
                    yOffset: 10
                },

            ],
            showPrevButton: true
        };

        // Start the tour!
        hopscotch.startTour(tour);
    });
</script>