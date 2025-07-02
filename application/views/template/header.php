<meta name="apple-mobile-web-app-capable" content="yes"> 
<meta name="mobile-web-app-capable" content="yes">
<?php
$currentUser = $this->session->userdata('login_user');





$receiver = $currentUser[0]->EmpNo;

$result ['MessageData'] = $this->Db_model->getfilteredData("SELECT 
                                                                    id,
                                                                    tbl_empmaster.Emp_Full_Name,
                                                                    tbl_empmaster.Image,
                                                                    sender,
                                                                    message,
                                                                    tbl_messages.Status,
                                                                    Trans_time,
                                                                    recever
                                                                FROM
                                                                    tbl_messages
                                                                        INNER JOIN
                                                                    tbl_empmaster ON tbl_empmaster.EmpNo = tbl_messages.sender
                                                                    where recever=$receiver order by Trans_time DESC ");

$result ['Messagecount'] = $this->Db_model->getfilteredData("SELECT count(id) as Count FROM tbl_messages WHERE status='0' and recever='$receiver'");
$Messagecount = $result ['Messagecount'];
$MessageData = $result ['MessageData'];


//var_dump($Messagecount);die;


$result ['Notifications'] = $this->Db_model->getfilteredData("select * from tbl_notifications where Is_Display = 1 order by ID desc");

$result1['countnoti'] = $this->Db_model->getfilteredData("select count(id) as noti from tbl_notifications where Is_Display = 1");

$Noti = $result1['countnoti'];
$Not = $Noti[0]->noti;

//var_dump($Not);die;

$Notifications = $result ['Notifications'];

//var_dump($MessageData);die;
?>



<!-- <div id="headerbar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-6 col-sm-2">
                        <a href="#" class="shortcut-tile tile-brown">
                            <div class="tile-body">
                                <div class="pull-left"><i class="fa fa-pencil"></i></div>
                            </div>
                            <div class="tile-footer">
                                Create Post
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-2">
                        <a href="#" class="shortcut-tile tile-grape">
                            <div class="tile-body">
                                <div class="pull-left"><i class="fa fa-group"></i></div>
                                <div class="pull-right"><span class="badge">2</span></div>
                            </div>
                            <div class="tile-footer">
                                Contacts
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-2">
                        <a href="#" class="shortcut-tile tile-primary">
                            <div class="tile-body">
                                <div class="pull-left"><i class="fa fa-envelope-o"></i></div>
                                <div class="pull-right"><span class="badge">10</span></div>
                            </div>
                            <div class="tile-footer">
                                Messages
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-2">
                        <a href="#" class="shortcut-tile tile-inverse">
                            <div class="tile-body">
                                <div class="pull-left"><i class="fa fa-camera"></i></div>
                                <div class="pull-right"><span class="badge">3</span></div>
                            </div>
                            <div class="tile-footer">
                                Gallery
                            </div>
                        </a>
                    </div>

                    <div class="col-xs-6 col-sm-2">
                        <a href="#" class="shortcut-tile tile-midnightblue">
                            <div class="tile-body">
                                <div class="pull-left"><i class="fa fa-cog"></i></div>
                            </div>
                            <div class="tile-footer">
                                Settings
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-2">
                        <a href="#" class="shortcut-tile tile-orange">
                            <div class="tile-body">
                                <div class="pull-left"><i class="fa fa-wrench"></i></div>
                            </div>
                            <div class="tile-footer">
                                Plugins
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>-->
<header style="border-bottom-left-radius: 20px;border-bottom-right-radius: 20px; margin-bottom: 100px; background-color: #ffffff" id="topnav" class="navbar navbar-midnightblue navbar-fixed-top clearfix" role="banner">

    <span id="trigger-sidebar" class="toolbar-trigger toolbar-icon-bg">
        <a data-toggle="tooltips" data-placement="right" title="Toggle Sidebar"><span class="icon-bg"><i class="fa fa-fw fa-bars"></i></span></a>
    </span>

    <!--<a class="navbar-brand" href="<?php echo base_url(); ?>Dashboard">HRMS</a>-->
    <img style="width: 50px;" src="<?php echo base_url(); ?>assets/images/company/VTF-Logo.png"><a style="font-size: 20px; margin-top: 150px; color: #000; "  href="<?php echo base_url(); ?>Dashboard">VFT PAYROLL SYSTEM</a>
    <!--<a class="marquee"> TODAY BIRTHDAYS :</a>-->
<!--    <div class="">
        <div class="marqu" style="">


            <div class="" >  dsdsd




                &nbsp;  &nbsp; - &nbsp;  &nbsp;

            </div>
        </div>
    </div>-->
<!--            <span id="trigger-infobar" class="toolbar-trigger toolbar-icon-bg">
                <a data-toggle="tooltips" data-placement="left" title="Toggle Infobar"><span class="icon-bg"><i class="fa fa-fw fa-bars"></i></span></a>
            </span>-->


    <!--            <div class="yamm navbar-left navbar-collapse collapse in">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Megamenu<span class="caret"></span></a>
                            <ul class="dropdown-menu" style="width: 900px;">
                                <li>
                                    <div class="yamm-content container-sm-height">
                                        <div class="row row-sm-height yamm-col-bordered">
                                            <div class="col-sm-3 col-sm-height yamm-col">
    
                                                <h3 class="yamm-category">Sidebar</h3>
                                                <ul class="list-unstyled mb20">
                                                    <li><a href="layout-fixed-sidebars.html">Stretch Sidebars</a></li>
                                                    <li><a href="layout-sidebar-scroll.html">Scroll Sidebar</a></li>
                                                    <li><a href="layout-static-leftbar.html">Static Sidebar</a></li>
                                                    <li><a href="layout-leftbar-widgets.html">Sidebar Widgets</a></li>   
                                                </ul>
    
                                                <h3 class="yamm-category">Infobar</h3>
                                                <ul class="list-unstyled">
                                                    <li><a href="layout-infobar-offcanvas.html">Offcanvas Infobar</a></li>
                                                    <li><a href="layout-infobar-overlay.html">Overlay Infobar</a></li>
                                                    <li><a href="layout-chatbar-overlay.html">Chatbar</a></li>
                                                    <li><a href="layout-rightbar-widgets.html">Infobar Widgets</a></li>   
                                                </ul>
    
                                            </div>
                                            <div class="col-sm-3 col-sm-height yamm-col">
    
                                                <h3 class="yamm-category">Page Content</h3>
                                                <ul class="list-unstyled mb20">
                                                    <li><a href="layout-breadcrumb-top.html">Breadcrumbs on Top</a></li>
                                                    <li><a href="layout-page-tabs.html">Page Tabs</a></li>
                                                    <li><a href="layout-fullheight-panel.html">Full-Height Panel</a></li>
                                                    <li><a href="layout-fullheight-content.html">Full-Height Content</a></li>
                                                </ul>
    
                                                <h3 class="yamm-category">Misc</h3>
                                                <ul class="list-unstyled">
                                                    <li><a href="layout-topnav-options.html">Topnav Options</a></li>
                                                    <li><a href="layout-horizontal-small.html">Horizontal Small</a></li>
                                                    <li><a href="layout-horizontal-large.html">Horizontal Large</a></li>
                                                    <li><a href="layout-boxed.html">Boxed</a></li>
                                                </ul>
    
                                            </div>
                                            <div class="col-sm-3 col-sm-height yamm-col">
    
                                                <h3 class="yamm-category">Analytics</h3>
                                                <ul class="list-unstyled mb20">
                                                    <li><a href="charts-flot.html">Flot</a></li>
                                                    <li><a href="charts-sparklines.html">Sparklines</a></li>
                                                    <li><a href="charts-morris.html">Morris</a></li>
                                                    <li><a href="charts-easypiechart.html">Easy Pie Charts</a></li>
                                                </ul>
    
                                                <h3 class="yamm-category">Components</h3>
                                                <ul class="list-unstyled">
                                                    <li><a href="ui-tiles.html">Tiles</a></li>
                                                    <li><a href="custom-knob.html">jQuery Knob</a></li>
                                                    <li><a href="custom-jqueryui.html">jQuery Slider</a></li>
                                                    <li><a href="custom-ionrange.html">Ion Range Slider</a></li>
                                                </ul>
    
                                            </div>
                                            <div class="col-sm-3 col-sm-height yamm-col">
                                                <h3 class="yamm-category">Rem</h3>
                                                <img src="assets/demo/stockphoto/communication_12_carousel.jpg" class="mb20 img-responsive" style="width: 100%;">
                                                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium. totam rem aperiam eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown" id="widget-classicmenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                                <li class="divider"></li>
                                <li><a href="#">One more separated link</a></li>
                            </ul>
                        </li>
                        <li><a href="#" target="_blank">Link</a></li>
                        <li><a href="#" target="_blank">Another Link</a></li>
                    </ul>
                </div>-->

    <ul class="nav navbar-nav toolbar pull-right">
<!--        <li class="dropdown toolbar-icon-bg">
            <a href="#" id="navbar-links-toggle" data-toggle="collapse" data-target="header>.navbar-collapse">
                <span class="icon-bg">
                    <i class="fa fa-fw fa-ellipsis-h"></i>
                </span>
            </a>
        </li>-->

        <!--                <li class="dropdown toolbar-icon-bg demo-search-hidden">
                            <a href="#" class="dropdown-toggle tooltips" data-toggle="dropdown"><span class="icon-bg"><i class="fa fa-fw fa-search"></i></span></a>
        
                            <div class="dropdown-menu dropdown-alternate arrow search dropdown-menu-form">
                                <div class="dd-header">
                                    <span>Search</span>
                                    <span><a href="#">Advanced search</a></span>
                                </div>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="">
        
                                    <span class="input-group-btn">
        
                                        <a class="btn btn-primary" href="#">Search</a>
                                    </span>
                                </div>
                            </div>
                        </li>-->

        <!--                <li class="toolbar-icon-bg demo-headerdrop-hidden">
                            <a href="#" id="headerbardropdown"><span class="icon-bg"><i class="fa fa-fw fa-level-down"></i></span></i></a>
                        </li>-->

        <li class="toolbar-icon-bg hidden-xs" id="trigger-fullscreen">
            <a href="#" class="toggle-fullscreen"><span class="icon-bg"><i class="fa fa-fw fa-arrows-alt"></i></span></i></a>
        </li>



        <?php if ($currentUser[0]->header_lv_nt == 1): ?>


            <li class="dropdown toolbar-icon-bg">
                <a href="#" class="hasnotifications dropdown-toggle" data-toggle='dropdown'><span class="icon-bg"><i class="fa fa-fw fa-bell"></i></span><span class="badge badge-info"><?php echo $Not ?></span></a>
                <div class="dropdown-menu dropdown-alternate notifications arrow">
                    <div class="dd-header">
                        <span>Notifications</span>
                        <!--<span><a href="#">Settings</a></span>-->
                    </div>
                    <div class="scrollthis scroll-pane">
                        <ul class="scroll-content">

                            <?php foreach ($Notifications as $t_data) { ?>

                                <?php
//          var_dump($t_data);
                                ?>

                                <li class="">
                                    <a href="<?php echo base_url(); ?>Leave_Transaction/Leave_Approve/noti/<?php echo $t_data->ID; ?>" class="notification-info">
                                        <div class="notification-icon"><i class="fa fa-user fa-fw"></i></div>
                                        <div class="notification-content"><?php echo $t_data->Notification; ?></div>

                                    </a>
                                </li>

                            <?php }
                            ?>    



                            <!--                                <li class="">
                                                                <a href="#" class="notification-success">
                                                                    <div class="notification-icon"><i class="fa fa-check fa-fw"></i></div>
                                                                    <div class="notification-content">Updates pushed successfully</div>
                                                                    <div class="notification-time">12m</div>
                                                                </a>
                                                            </li>
                                                            <li class="">
                                                                <a href="#" class="notification-primary">
                                                                    <div class="notification-icon"><i class="fa fa-users fa-fw"></i></div>
                                                                    <div class="notification-content">New users request to join</div>
                                                                    <div class="notification-time">35m</div>
                                                                </a>
                                                            </li>
                                                            <li class="">
                                                                <a href="#" class="notification-danger">
                                                                    <div class="notification-icon"><i class="fa fa-shopping-cart fa-fw"></i></div>
                                                                    <div class="notification-content">More orders are pending</div>
                                                                    <div class="notification-time">11h</div>
                                                                </a>
                                                            </li>
                                                            <li class="">
                                                                <a href="#" class="notification-primary">
                                                                    <div class="notification-icon"><i class="fa fa-arrow-up fa-fw"></i></div>
                                                                    <div class="notification-content">Pending Membership approval</div>
                                                                    <div class="notification-time">2d</div>
                                                                </a>
                                                            </li>
                                                            <li class="">
                                                                <a href="#" class="notification-info">
                                                                    <div class="notification-icon"><i class="fa fa-check fa-fw"></i></div>
                                                                    <div class="notification-content">Succesfully updated to version 1.0.1</div>
                                                                    <div class="notification-time">40m</div>
                                                                </a>
                                                            </li>-->
                        </ul>
                    </div>
                    <div class="dd-footer">
                        <a href="#">View all notifications</a>
                    </div>
                </div>
            </li>


        <?php endif; ?>

        <li class="dropdown toolbar-icon-bg hidden-xs">
            <a href="#" class="hasnotifications dropdown-toggle" data-toggle='dropdown'><span class="icon-bg"><i class="fa fa-fw fa-envelope"></i></span><span class="badge badge-grape"><?php echo $Messagecount[0]->Count; ?></span></a>
            <div class="dropdown-menu dropdown-alternate messages arrow">
                <div class="dd-header">
                    <span>Messages</span>
                    <!--<span><a href="#">Settings</a></span>-->
                </div>

                <div class="scrollthis scroll-pane">
                    <ul class="scroll-content">



                        <?php foreach ($MessageData as $m_data) { ?>
                            <li class="">
                                <a href="<?php echo base_url(); ?>Message/Receive_Message">
                                    <img class="msg-avatar" src="<?php echo base_url(); ?>assets/images/Employees/<?php echo $m_data->Image; ?>" alt="avatar" />
                                    <div class="msg-content">
                                        <span class="name"><?php echo $m_data->Emp_Full_Name; ?></span>
                                        <span class="msg"><?php echo $m_data->message; ?></span>
                                    </div>

                                </a>
                            </li>
                        <?php }
                        ?> 




                    </ul>
                </div>

                <div class="dd-footer"><a href="<?php echo base_url(); ?>Message/Receive_Message">View all messages</a></div>
            </div>
        </li>



        <li class="dropdown toolbar-icon-bg">
            <a href="#" class="dropdown-toggle" data-toggle='dropdown'><span class="icon-bg"><i class="fa fa-fw fa-user"></i></span></a>
            <ul class="dropdown-menu userinfo arrow">
                <li><a href="<?php echo base_url(); ?>Tools/Profile_Manage"><span class="pull-left">My Profile</span> <span><i class="pull-right fa fa-user"></i></span></a></li>
                <li><a href="<?php echo base_url(); ?>Tools/Password_change"><span class="pull-left">Change Password</span> <i class="pull-right fa fa-key"></i></a></li>

                <li><a href="<?php echo base_url() . "index.php/login/logout/" ?>"><span class="pull-left">Sign Out</span> <i class="pull-right fa fa-sign-out"></i></a></li>
            </ul>
        </li>

        <li class="dropdown toolbar-icon-bg">
            <!--<div style="color:  #ffffff">Assds</div>-->
        </li>

    </ul>

</header>
<br><br><br>