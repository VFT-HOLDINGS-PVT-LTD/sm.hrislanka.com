<!DOCTYPE html>

<?php
$currentUser = $this->session->userdata('login_user');

$Image = $currentUser[0]->Image;

$User_Name = $currentUser[0]->Emp_Full_Name;

$currentUser
    ?>

<!--Description of dashboard page

@author VFT-Software-Team-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


<style>
    .marquee {
        width: 80%;
        /*overflow: hidden;*/
        white-space: nowrap;
        /*position: relative;*/
        animation: marquee 30s linear infinite;
        /* Adjust animation duration and timing function as needed */
    }

    .background_block {
        background-color: #56cb21;
    }

    .marquee div {
        display: inline-block;
        padding-right: 20px;
        /* Adjust spacing between repeated content */
        animation: slide 0s linear infinite;
        /* Adjust animation duration as needed */
    }

    .highcharts-container {
        border-radius: 20px;
    }

    @keyframes marquee {
        0% {
            transform: translateX(100%);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    @keyframes slide {

        0%,
        100% {
            transform: translateX(0);
        }

        50% {
            transform: translateX(-50%);
        }
    }

    .marquee-container {
        width: 100%;
        /* Set the desired width of the container */
        overflow: hidden;
        position: relative;
    }

    .dashboard-container {
        padding: 20px;
    }

    /* Container styling */
    .dashboard-container {
        padding: 20px;
    }

    .row {
        /* display: flex; */
    }

    /* Tile container */
    .info-tile {
        text-decoration: none;
        color: white;
    }

    /* Tile layout and appearance */
    .tile-content {
        /* width: 300px; */
        height: 150px;
        background-color: #7b6fc3;
        /* Similar to the purple shade in the image */
        border-radius: 10px;
        padding: 20px;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease;
    }

    .tile-content:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        color: white;
    }

    /* Header (Top text) */
    .tile-header {
        font-size: 1.3rem;
        font-weight: bold;
        letter-spacing: 1px;
        margin-bottom: 5px;
    }

    .tile-header:hover {
        color: white;
    }

    /* Body (Number display) */
    .tile-body {
        font-size: 2.5rem;
        font-weight: bold;
    }

    /* Icon positioning */
    .tile-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 2.5rem;
        opacity: 0.2;
    }

    .tile-icon:hover {
        color: white;
        /* background-color: white; */
    }

    .tt1:hover {
        color: white;
        /* background-color: white; */
    }

    /* Footer (Button-like text) */
    .tile-footer {
        font-size: 1rem;
        color: white;
        background-color: rgba(255, 255, 255, 0.1);
        padding: 10px;
        border-radius: 0 0 10px 10px;
        text-align: center;
    }

    /* Optional background wave */
    .tile-content::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 50%;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 0 0 10px 10px;
        z-index: 0;
    }
</style>

<html lang="en">


<head>
    <!-- Styles -->
    <?php $this->load->view('template/css.php'); ?>

</head>

<body class="infobar-offcanvas">

    <!--header-->
    <?php //echo $sdata[0]->Dep_Name;die;  ?>
    <?php $this->load->view('template/header.php'); ?>

    <!--end header-->

    <div id="wrapper">
        <div id="layout-static">

            <!--dashboard side-->

            <?php $this->load->view('template/dashboard_side.php'); ?>

            <!--dashboard side end-->


            <div class="static-content-wrapper">

                <div class="static-content">
                    <div class="marquee-container" style="">


                        <div class="marquee"><a> TODAY BIRTHDAYS :</a> &nbsp; &nbsp;
                            <?php foreach ($Bdays as $data) { ?>
                                <?php
                                echo $data->Emp_Full_Name;
                                '&nbsp;'
                                    ?>


                                <a style="color: #000000;">
                                    <?php
                                    echo $data->B_name;
                                    '&nbsp;-&nbsp;'
                                        ?>
                                </a>



                                &nbsp; &nbsp; - &nbsp; &nbsp;
                            <?php }
                            ?>
                        </div>
                    </div>
                    <div class="page-content">


                        <div style="border-radius: 20px; background-color: #e4e4e4" class="page-heading">
                            <h1>DASHBOARD</h1>



                            <div class="">
                                <div class="" style="float: right">
                                    <!--<div  style="float: left;"><h3 style="color: #81003d;"><?php echo $today_c[0]->TodayCount; ?></h3> </div>-->
                                    <!--<div  style="float: left"><h3>&nbsp;TODAY WORKING</h3></div>-->
                                </div>
                            </div>
                        </div>

                        <div class="container-fluid dashboard-container">
                            <div data-widget-group="group1">
                                <div class="row">
                                    <?php
                                    $currentUser = $this->session->userdata('login_user');
                                    ?>

                                    <?php if ($currentUser[0]->add_employee == 1): ?>
                                        <div class="col-md-3">
                                            <!-- <a style="background-color: #479cba" class="info-tile has-footer tile-content" href="<?php echo base_url(); ?>Employee_Management/ADD_Employees"> -->

                                            <a class="info-tile tile-content"
                                                href="<?php echo base_url(); ?>Employee_Management/ADD_Employees"
                                                style="background-color: #479cba">
                                                <!-- <div class="tile-content"> -->
                                                <div class="tile-header">
                                                    EMPLOYEES
                                                </div>
                                                <div class="tile-body count">
                                                    <?php echo $count[0]->count_emp ?>
                                                </div>
                                                <div class="tile-icon">
                                                    <i class="fa fa-group"></i>
                                                </div>
                                                <div class="tile-footer" style="color: white;">
                                                    ADD EMPLOYEES
                                                </div>
                                                <!-- </div> -->
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($currentUser[0]->shift_allocation == 1): ?>
                                        <div class="col-md-3">
                                            <a class="info-tile tile-content"
                                                href="<?php echo base_url(); ?>Attendance/Shift_Allocation"
                                                style="background-color: #479cba">
                                                <div class="tile-header">
                                                SHIFT ALLOCATION
                                                </div>
                                                <div class="tile-body" style="height: 60px;">
                                                    <!-- <?php echo $count[0]->count_emp ?> -->
                                                </div>
                                                <div class="tile-icon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                                <div class="tile-footer" style="color: white;">
                                                    SHIFT ALLOCATION
                                                </div>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($currentUser[0]->attendance_process == 1): ?>
                                        <div class="col-md-3">
                                            <a class="info-tile tile-content"
                                                href="<?php echo base_url(); ?>Attendance/Attendance_Process_test"
                                                style="background-color: #479cba">
                                                <div class="tile-header">
                                                    ATTENDANCE PROCESS
                                                </div>
                                                <div class="tile-body" style="height: 60px;">
                                                    <!-- <?php echo $count[0]->count_emp ?> -->
                                                </div>
                                                <div class="tile-icon">
                                                    <i class="fa fa-gears tt1"></i>
                                                </div>
                                                <div class="tile-footer" style="color: white;">
                                                    ATTENDANCE PROCESS
                                                </div>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($currentUser[0]->payroll_process == 1): ?>
                                        <div class="col-md-3">
                                            <a class="info-tile tile-content"
                                                href="<?php echo base_url(); ?>Pay/Payroll_Process/"
                                                style="background-color: #479cba">
                                                <div class="tile-header">
                                                    PAYROLL PROCESS
                                                </div>
                                                <div class="tile-body" style="height: 60px;">
                                                    <!-- <?php echo $count[0]->count_emp ?> -->
                                                </div>
                                                <div class="tile-icon">
                                                    <i class="fa fa-money"></i>
                                                </div>
                                                <div class="tile-footer" style="color: white;">
                                                    PAYROLL PROCESS
                                                </div>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="row">
                                    <?php if ($currentUser[0]->leave_request == 1): ?>
                                        <div class="col-md-3">
                                            <a class="info-tile tile-content"
                                                href="<?php echo base_url(); ?>Leave_Transaction/Leave_Request"
                                                style="background-color: #479cba">
                                                <div class="tile-header">
                                                    APPLY LEAVE
                                                </div>
                                                <div class="tile-body" style="height: 60px;">
                                                    <!-- <?php echo $count[0]->count_emp ?> -->
                                                </div>
                                                <div class="tile-icon"> <i class="fa fa-plus-square"></i>
                                                </div>
                                                <div class="tile-footer" style="color: white;">
                                                    APPLY LEAVE
                                                </div>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($currentUser[0]->leave_request == 1): ?>
                                        <div class="col-md-3">
                                            <a class="info-tile tile-content"
                                                href="<?php echo base_url(); ?>Leave_Transaction/Short_Leave_Request"
                                                style="background-color: #479cba">
                                                <div class="tile-header">
                                                    SHORT LEAVE REQUEST
                                                </div>
                                                <div class="tile-body" style="height: 60px;">
                                                    <!-- <?php echo $count[0]->count_emp ?> -->
                                                </div>
                                                <div class="tile-icon"> <i class="fa fa-plus-square"></i>
                                                </div>
                                                <div class="tile-footer" style="color: white;">
                                                    SHORT LEAVE REQUEST
                                                </div>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($currentUser[0]->manual_att_request == 1): ?>
                                        <div class="col-md-3">
                                            <a class="info-tile tile-content"
                                                href="<?php echo base_url(); ?>Attendance/Attendance_Manual_Entry_Request"
                                                style="background-color: #479cba">
                                                <div class="tile-header">
                                                    ATTENDANCE REQUEST
                                                </div>
                                                <div class="tile-body" style="height: 60px;">
                                                    <!-- <?php echo $count[0]->count_emp ?> -->
                                                </div>
                                                <div class="tile-icon"> <i class="fa fa-plus-square"></i>
                                                </div>
                                                <div class="tile-footer" style="color: white;">
                                                    ATTENDANCE REQUEST
                                                </div>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($currentUser[0]->leave_approve == 1): ?>
                                        <div class="col-md-3">
                                            <a class="info-tile tile-content"
                                                href="<?php echo base_url(); ?>Leave_Transaction/Leave_Approve"
                                                style="background-color: #479cba">
                                                <div class="tile-header">
                                                    LEAVE APPROVE
                                                </div>
                                                <div class="tile-body" style="height: 60px;">
                                                    <!-- <?php echo $count[0]->count_emp ?> -->
                                                </div>
                                                <div class="tile-icon"> <i class="fa fa-tag"></i>
                                                </div>
                                                <div class="tile-footer" style="color: white;">
                                                    LEAVE APPROVE
                                                </div>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($currentUser[0]->request_advance == 1): ?>
                                        <div class="col-md-3">
                                            <a class="info-tile tile-content"
                                                href="<?php echo base_url(); ?>Pay/Salary_Advance_req/"
                                                style="background-color: #479cba">
                                                <div class="tile-header">
                                                    REQUEST SALARY ADVANCE
                                                </div>
                                                <div class="tile-body" style="height: 60px;">
                                                    <!-- <?php echo $count[0]->count_emp ?> -->
                                                </div>
                                                <div class="tile-icon"> <i class="fa fa-plus-circle" style="color: white;"></i>
                                                </div>
                                                <div class="tile-footer" style="color: white;">
                                                    REQUEST SALARY ADVANCE
                                                </div>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>


                            </div>
                            <!--Dashboard shortcut end-->







                        </div>
                        <br>



                        <!-- Charts-->
                        <div class="row">

                            <!--Departments Chart -->
                            <?php if ($currentUser[0]->dsh_ch_1 == 1): ?>
                                <div class="col-md-4">
                                    <div id="container"></div>
                                </div>
                            <?php endif; ?>
                            <!--End Departments Chart -->


                            <!--Employee Attendance-->
                            <?php if ($currentUser[0]->dsh_ch_2 == 1): ?>
                                <!--                                                                            <div class="col-md-4">
                                                                                                                    <div id="container2"></div>
                                                                                                                </div>-->
                            <?php endif; ?>
                            <!--End Employee Attendance-->

                            <!--Company Employee by gender-->
                            <?php if ($currentUser[0]->dsh_ch_3 == 1): ?>
                                <div class="col-md-4">
                                    <div id="container3"></div>
                                </div>
                            <?php endif; ?>
                            <!--End Company Employee by gender-->

                            <!--Leave Chart -->

                            <div class="col-md-4">
                                <div id="container_leave"></div>
                            </div>

                            <!--End Departments Chart -->


                        </div>


                        <!--End Departments Chart JS-->
                        <div class="panel-body">
                            <?php if ($currentUser[0]->dsh_report == 1): ?>
                                <h4>REPORTS</h4>
                            <?php endif; ?>

                            <div class="tab-content">
                                <div class="tab-pane active" id="domshortcuttiles">
                                    <div class="row">
                                        <?php if ($currentUser[0]->dsh_rpt_in_out == 1): ?>
                                            <div class="col-md-2">
                                                <a href="<?php echo base_url(); ?>Reports/Attendance/Report_Attendance_In_Out"
                                                    class="shortcut-tile tile-info">
                                                    <div class="tile-body">
                                                        <div class="pull-left"><i class="fa fa-clock-o"></i></div>
                                                        <div class="pull-right"><span class="badge"></span></div>
                                                    </div>
                                                    <div class="tile-footer">
                                                        IN OUT REPORT
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($currentUser[0]->dsh_rpt_paysheet == 1): ?>
                                            <div class="col-md-2">
                                                <a href="<?php echo base_url(); ?>Reports/Payroll/Paysheet"
                                                    class="shortcut-tile tile-orange">
                                                    <div class="tile-body">
                                                        <div class="pull-left"><i class="fa fa-credit-card"></i></div>
                                                        <div class="pull-right"><span class="badge"></span></div>
                                                    </div>
                                                    <div class="tile-footer">
                                                        PAY SHEET
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($currentUser[0]->dsh_rpt_leave == 1): ?>
                                            <div class="col-md-2">
                                                <a href="<?php echo base_url(); ?>Reports/Attendance/Report_Leave"
                                                    class="shortcut-tile tile-success">
                                                    <div class="tile-body">
                                                        <div class="pull-left"><i class="fa fa-newspaper-o"></i></div>

                                                    </div>
                                                    <div class="tile-footer">
                                                        LEAVE REPORT
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($currentUser[0]->dsh_rpt_emp_master == 1): ?>
                                            <div class="col-md-2">
                                                <a href="<?php echo base_url(); ?>Reports/Master/Employee_Report"
                                                    class="shortcut-tile tile-magenta">
                                                    <div class="tile-body">
                                                        <div class="pull-left"><i class="fa fa-users"></i></div>
                                                        <div class="pull-right"><span class="badge"></span></div>
                                                    </div>
                                                    <div class="tile-footer">
                                                        EMPLOYEE MASTER
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($currentUser[0]->dsh_rpt_sal_advance == 1): ?>
                                            <!--                                                <div class="col-md-2">
                                                    <a href="#" class="shortcut-tile tile-midnightblue">
                                                        <div class="tile-body">
                                                            <div class="pull-left"><i class="fa fa-folder"></i></div>
                                                            <div class="pull-right"><span class="badge"></span></div>
                                                        </div>
                                                        <div class="tile-footer">
                                                            SALARY ADVANCE
                                                        </div>
                                                    </a>
                                                </div>-->
                                        <?php endif; ?>

                                        <?php if ($currentUser[0]->dsh_rpt__absence == 2): ?>
                                            <div class="col-md-2">
                                                <a href="#" class="shortcut-tile tile-green">
                                                    <div class="tile-body">
                                                        <div class="pull-left"><i class="fa fa-bell-o"></i></div>
                                                        <div class="pull-right"><span class="badge"></span></div>
                                                    </div>
                                                    <div class="tile-footer">
                                                        ABSENCE REPORT
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>


                        </div> <!-- .container-fluid -->
                    </div> <!-- #page-content -->
                </div>

                <!--Footer-->
                <?php $this->load->view('template/footer.php'); ?>
                <!--End Footer-->

            </div>
        </div>
    </div>


    <div class="infobar-wrapper scroll-pane">
        <div class="infobar scroll-content">

            <div id="widgetarea">

                <div class="widget" id="widget-sparkline">
                    <div class="widget-heading">
                        <a href="javascript:;" data-toggle="collapse" data-target="#sparklinestats">
                            <h4>Sparkline Stats</h4>
                        </a>
                    </div>
                    <div id="sparklinestats" class="collapse in">
                        <div class="widget-body">
                            <ul class="sparklinestats">
                                <li>
                                    <div class="title">Earnings</div>
                                    <div class="stats">$22,500</div>
                                    <div class="sparkline" id="infobar-earningsstats" style=""></div>
                                </li>
                                <li>
                                    <div class="title">Orders</div>
                                    <div class="stats">4,750</div>
                                    <div class="sparkline" id="infobar-orderstats" style=""></div>
                                </li>
                            </ul>
                            <a href="#" class="more">More Sparklines</a>
                        </div>
                    </div>
                </div>

                <div class="widget">
                    <div class="widget-heading">
                        <a href="javascript:;" data-toggle="collapse" data-target="#recentactivity">
                            <h4>Recent Activity</h4>
                        </a>
                    </div>
                    <div id="recentactivity" class="collapse in">
                        <div class="widget-body">
                            <ul class="recent-activities">
                                <li>
                                    <div class="avatar">
                                        <img src="assets/demo/avatar/avatar_11.png" class="img-responsive img-circle">
                                    </div>
                                    <div class="content">
                                        <span class="msg"><a href="#" class="person">Jean Alanis</a> invited 3
                                            unconfirmed members</span>
                                        <span class="time">2 mins ago</span>

                                    </div>
                                </li>
                                <li>
                                    <div class="avatar">
                                        <img src="assets/demo/avatar/avatar_09.png" class="img-responsive img-circle">
                                    </div>
                                    <div class="content">
                                        <span class="msg"><a href="#" class="person">Anthony Ware</a> is now following
                                            you</span>
                                        <span class="time">4 hours ago</span>

                                    </div>
                                </li>
                                <li>
                                    <div class="avatar">
                                        <img src="assets/demo/avatar/avatar_04.png" class="img-responsive img-circle">
                                    </div>
                                    <div class="content">
                                        <span class="msg"><a href="#" class="person">Bruce Ory</a> commented on <a
                                                href="#">Dashboard UI</a></span>
                                        <span class="time">16 hours ago</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="avatar">
                                        <img src="assets/demo/avatar/avatar_01.png" class="img-responsive img-circle">
                                    </div>
                                    <div class="content">
                                        <span class="msg"><a href="#" class="person">Roxann Hollingworth</a>is now
                                            following you</span>
                                        <span class="time">Feb 13, 2015</span>
                                    </div>
                                </li>
                            </ul>
                            <a href="#" class="more">See all activities</a>
                        </div>
                    </div>
                </div>

                <div class="widget">
                    <div class="widget-heading">
                        <a href="javascript:;" data-toggle="collapse" data-target="#widget-milestones">
                            <h4>Milestones</h4>
                        </a>
                    </div>
                    <div id="widget-milestones" class="collapse in">
                        <div class="widget-body">
                            <div class="contextual-progress">
                                <div class="clearfix">
                                    <div class="progress-title">UI Design</div>
                                    <div class="progress-percentage">12/16</div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-lime" style="width: 75%"></div>
                                </div>
                            </div>
                            <div class="contextual-progress">
                                <div class="clearfix">
                                    <div class="progress-title">UX Design</div>
                                    <div class="progress-percentage">8/24</div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-orange" style="width: 33.3%"></div>
                                </div>
                            </div>
                            <div class="contextual-progress">
                                <div class="clearfix">
                                    <div class="progress-title">Frontend Development</div>
                                    <div class="progress-percentage">8/40</div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-purple" style="width: 20%"></div>
                                </div>
                            </div>
                            <div class="contextual-progress m0">
                                <div class="clearfix">
                                    <div class="progress-title">Backend Development</div>
                                    <div class="progress-percentage">24/48</div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-danger" style="width: 50%"></div>
                                </div>
                            </div>
                            <a href="#" class="more">See All</a>
                        </div>
                    </div>
                </div>

                <div class="widget">
                    <div class="widget-heading">
                        <a href="javascript:;" data-toggle="collapse" data-target="#widget-contact">
                            <h4>Contacts</h4>
                        </a>
                    </div>
                    <div id="widget-contact" class="collapse in">
                        <div class="widget-body">
                            <ul class="contact-list">
                                <li id="contact-1">
                                    <a href="javascript:;"><img src="assets/demo/avatar/avatar_02.png"
                                            alt=""><span>Jeremy Potter</span></a>
                                    <!-- <div class="contact-card contactdetails" data-child-of="contact-1">
                                            <div class="avatar">
                                                <img src="assets/demo/avatar/avatar_11.png" class="img-responsive img-circle">
                                            </div>
                                            <span class="contact-name">Jeremy Potter</span>
                                            <span class="contact-status">Client Representative</span>
                                            <ul class="details">
                                                <li><a href="#"><i class="fa fa-envelope-o"></i>&nbsp;p.bateman@gmail.com</a></li>
                                                <li><i class="fa fa-phone"></i>&nbsp;+1 234 567 890</li>
                                                <li><i class="fa fa-map-marker"></i>&nbsp;Hollywood Hills, California</li>
                                            </ul>
                                        </div> -->
                                </li>
                                <li id="contact-2">
                                    <a href="javascript:;"><img src="assets/demo/avatar/avatar_07.png"
                                            alt=""><span>David Tennant</span></a>
                                    <!-- <div class="contact-card contactdetails" data-child-of="contact-2">
                                            <div class="avatar">
                                                <img src="assets/demo/avatar/avatar_11.png" class="img-responsive img-circle">
                                            </div>
                                            <span class="contact-name">David Tennant</span>
                                            <span class="contact-status">Client Representative</span>
                                            <ul class="details">
                                                <li><a href="#"><i class="fa fa-envelope-o"></i>&nbsp;p.bateman@gmail.com</a></li>
                                                <li><i class="fa fa-phone"></i>&nbsp;+1 234 567 890</li>
                                                <li><i class="fa fa-map-marker"></i>&nbsp;Hollywood Hills, California</li>
                                            </ul>
                                        </div> -->
                                </li>
                                <li id="contact-3">
                                    <a href="javascript:;"><img src="assets/demo/avatar/avatar_03.png" alt=""><span>Anna
                                            Johansson</span></a>
                                    <!-- <div class="contact-card contactdetails" data-child-of="contact-3">
                                            <div class="avatar">
                                                <img src="assets/demo/avatar/avatar_11.png" class="img-responsive img-circle">
                                            </div>
                                            <span class="contact-name">Anna Johansson</span>
                                            <span class="contact-status">Client Representative</span>
                                            <ul class="details">
                                                <li><a href="#"><i class="fa fa-envelope-o"></i>&nbsp;p.bateman@gmail.com</a></li>
                                                <li><i class="fa fa-phone"></i>&nbsp;+1 234 567 890</li>
                                                <li><i class="fa fa-map-marker"></i>&nbsp;Hollywood Hills, California</li>
                                            </ul>
                                        </div> -->
                                </li>
                                <li id="contact-4">
                                    <a href="javascript:;"><img src="assets/demo/avatar/avatar_09.png" alt=""><span>Alan
                                            Doyle</span></a>
                                    <!-- <div class="contact-card contactdetails" data-child-of="contact-4">
                                            <div class="avatar">
                                                <img src="assets/demo/avatar/avatar_11.png" class="img-responsive img-circle">
                                            </div>
                                            <span class="contact-name">Alan Doyle</span>
                                            <span class="contact-status">Client Representative</span>
                                            <ul class="details">
                                                <li><a href="#"><i class="fa fa-envelope-o"></i>&nbsp;p.bateman@gmail.com</a></li>
                                                <li><i class="fa fa-phone"></i>&nbsp;+1 234 567 890</li>
                                                <li><i class="fa fa-map-marker"></i>&nbsp;Hollywood Hills, California</li>
                                            </ul>
                                        </div> -->
                                </li>
                                <li id="contact-5">
                                    <a href="javascript:;"><img src="assets/demo/avatar/avatar_05.png"
                                            alt=""><span>Simon Corbett</span></a>
                                    <!-- <div class="contact-card contactdetails" data-child-of="contact-5">
                                            <div class="avatar">
                                                <img src="assets/demo/avatar/avatar_11.png" class="img-responsive img-circle">
                                            </div>
                                            <span class="contact-name">Simon Corbett</span>
                                            <span class="contact-status">Client Representative</span>
                                            <ul class="details">
                                                <li><a href="#"><i class="fa fa-envelope-o"></i>&nbsp;p.bateman@gmail.com</a></li>
                                                <li><i class="fa fa-phone"></i>&nbsp;+1 234 567 890</li>
                                                <li><i class="fa fa-map-marker"></i>&nbsp;Hollywood Hills, California</li>
                                            </ul>
                                        </div> -->
                                </li>
                                <li id="contact-6">
                                    <a href="javascript:;"><img src="assets/demo/avatar/avatar_01.png"
                                            alt=""><span>Polly Paton</span></a>
                                    <!-- <div class="contact-card contactdetails" data-child-of="contact-6">
                                            <div class="avatar">
                                                <img src="assets/demo/avatar/avatar_11.png" class="img-responsive img-circle">
                                            </div>
                                            <span class="contact-name">Polly Paton</span>
                                            <span class="contact-status">Client Representative</span>
                                            <ul class="details">
                                                <li><a href="#"><i class="fa fa-envelope-o"></i>&nbsp;p.bateman@gmail.com</a></li>
                                                <li><i class="fa fa-phone"></i>&nbsp;+1 234 567 890</li>
                                                <li><i class="fa fa-map-marker"></i>&nbsp;Hollywood Hills, California</li>
                                            </ul>
                                        </div> -->
                                </li>
                            </ul>
                            <a href="#" class="more">See All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Load site level scripts -->

    <?php $this->load->view('template/js.php'); ?> <!-- Initialize scripts for this page-->

    <!-- End loading page level scripts-->


    <script src="<?php echo base_url(); ?>assets/js/jquery.marquee.min.js" type="text/javascript"></script>
    <!--            <script type="text/javascript">
            $(function () {


                $('.marqueeheader').marquee({
                    duration: 10000,
                    gap: 30,
                    //time in milliseconds before the marquee will start animating
                    delayBeforeStart: 0,
                    //'left' or 'right'
                    //                direction: 'left',
                    //true or false - should the marquee be duplicated to show an effect of continues flow
                    duplicated: true
                });
            });
        </script>-->


    <!--Leave Chart-->
    <script type="text/javascript">
        $(function () {
            var dep_data = [];
            <?php foreach ($data_leave as $leavesss) { ?>
                s = eval('<?php echo $leavesss->Balance ?>'.toString().replace(/"/g, ""));
                dep_data.push({ name: '<?php echo $leavesss->leave_name ?>', y: s });

            <?php } ?>
            $('#container_leave').highcharts({
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45,
                        beta: 0
                    }
                },
                title: {
                    text: 'Leave Balance'
                },

                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        depth: 35,
                        dataLabels: {
                            enabled: true,
                            distance: -50,
                            style: {
                                fontWeight: 'bold',
                                color: 'white',
                                textShadow: '0px 1px 2px black'
                            }
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Leave',
                    data: dep_data
                }]
            });
        });
    </script>

    <!--Department Chart-->
    <script type="text/javascript">
        $(function () {
            var dep_data = [];
            <?php foreach ($sdata as $sales) { ?>
                s = eval('<?php echo $sales->EmpCount ?>'.toString().replace(/"/g, ""));
                dep_data.push({ name: '<?php echo $sales->Dep_Name ?>', y: s });

            <?php } ?>
            $('#container').highcharts({
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45,
                        beta: 0
                    }
                },
                title: {
                    text: 'Company Departments'
                },

                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        depth: 35,
                        dataLabels: {
                            enabled: true,
                            distance: -50,
                            style: {
                                fontWeight: 'bold',
                                color: 'white',
                                textShadow: '0px 1px 2px black'
                            }
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Employee',
                    data: dep_data
                }]
            });
        });



        //               <script type="text/javascript">

        //                $('#container').highcharts({//
        //                    chart: {
        //                        type: 'pie',
        //                        options3d: {
        //                            enabled: true,
        //                            alpha: 45,
        //                            beta: 0
        //                        }
        //                    },
        // title: {//
        //                        text: 'Company Departments'
        //                    },

        //                    plotOptions: {//
        //                        pie: {
        //                            allowPointSelect: true,
        //                            cursor: 'pointer',
        //                            depth: 35,
        //                            dataLabels: {
        //                                enabled: true,
        //                                format: '{point.name}'
        //                            }
        //                        }
        //                    },
        //                    series: [{//
        //                            type: 'pie',
        //                            name: 'Employee',
        //                            data: dep_data
        //                        }]
        //                });
        //            });


    </script>


    <script type="text/javascript">
        $(function () {
            $('#container2').highcharts({
                title: {
                    text: 'Employee Attendance'
                },
                xAxis: {
                    categories: ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATERDAY', 'SUNDAY']
                },
                labels: {
                    items: []
                },
                series: [{
                    type: 'column',
                    name: 'Present',
                    data: [17, 18, 16, 18, 18, 16, 5]
                }, {
                    type: 'column',
                    name: 'Absence',
                    data: [1, 0, 2, 0, 0, 2, 13]
                },]
            });
        });


    </script>

    <script type="text/javascript">
        $(function () {
            $('#container3').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: 0,
                    plotShadow: false
                },
                title: {
                    text: 'TOTAL EMPLOYEES : <?php echo $sdata_gender[0]->total_count ?>',
                    //                        align: 'center',
                    verticalAlign: 'top'
                    //                        y: 40
                },
                //                                            tooltip: {
                //                                                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                //                                            },
                plotOptions: {
                    pie: {
                        dataLabels: {
                            enabled: true,
                            distance: -50,
                            style: {
                                fontWeight: 'bold',
                                color: 'white',
                                textShadow: '0px 1px 2px black'
                            }
                        },
                        startAngle: -90,
                        endAngle: 90,
                        center: ['50%', '75%']
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Employee',
                    innerSize: '50%',
                    data: [
                        ['Male', <?php echo $sdata_gender[0]->male_count ?>],
                        ['Female', <?php echo $sdata_gender[0]->female_count ?>]


                    ]
                }]
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            const countElement = document.querySelector('.count');
            const countValue = parseInt(countElement.textContent);

            let currentCount = 0;
            const interval = setInterval(() => {
                if (currentCount < countValue) {
                    currentCount++;
                    countElement.textContent = currentCount;
                } else {
                    clearInterval(interval);
                }
            }, 50);
        });


    </script>
    <script src="<?php echo base_url(); ?>assets/plugins/highcharts/exporting.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/highcharts/highcharts-3d.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/highcharts/highcharts.js" type="text/javascript"></script>
</body>


</html>