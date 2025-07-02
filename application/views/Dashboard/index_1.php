<!DOCTYPE html>

<?php
$currentUser = $this->session->userdata('login_user');

$Image = $currentUser[0]->Image;

$User_Name = $currentUser[0]->Emp_Full_Name;



$currentUser
?>

<!--Description of dashboard page

@author Ashan Rathsara-->

<style>
  .marquee {
    width: 80%;
    /*overflow: hidden;*/
    white-space: nowrap;
    /*position: relative;*/
    animation: marquee 30s linear infinite; /* Adjust animation duration and timing function as needed */
  }
  
  .marquee div {
    display: inline-block;
    padding-right: 20px; /* Adjust spacing between repeated content */
    animation: slide 0s linear infinite; /* Adjust animation duration as needed */
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
    0%, 100% {
      transform: translateX(0);
    }
    50% {
      transform: translateX(-50%);
    }
  }
  .marquee-container {
    width: 100%; /* Set the desired width of the container */
    overflow: hidden;
    position: relative;
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


                            <div class="marquee" ><a> TODAY BIRTHDAYS :</a>  &nbsp;  &nbsp; <?php foreach ($Bdays as $data) { ?>
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



                                    &nbsp;  &nbsp; - &nbsp;  &nbsp;
                                <?php }
                                ?> </div>
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

                            <div class="container-fluid">

                                <!--Dashboard shortcut start-->
                                <div data-widget-group="group1">
                                    <div class="row">

                                        <?php
                                        $currentUser = $this->session->userdata('login_user');
                                        ?>

                                        <?php if ($currentUser[0]->add_employee == 1): ?>
                                        <div  class="col-md-3" >
                                            <a style="background: rgb(88,203,28);
background: linear-gradient(90deg, rgba(88,203,28,1) 0%, rgba(54,204,138,1) 100%, rgba(71,145,64,0.5217437316723564) 100%, rgba(57,205,106,1) 100%, rgba(109,190,107,1) 100%);" class="info-tile has-footer" href="<?php echo base_url(); ?>Employee_Management/ADD_Employees">
                                                    <div class="tile-heading" style="">
                                                        <div style="color: #ffffff" class="pull-left">EMPLOYEES</div>
                                                        <div class="pull-right">
                                                            <div id="tileorders" class="sparkline-block"></div>
                                                        </div>
                                                    </div>
                                                    <div class="tile-body">
                                                        <div class="pull-left"><i class="fa fa-group"></i></div>
                                                        <div style="color: #ffffff" class="pull-right"><?php echo $count[0]->count_emp ?></div>
                                                    </div>
                                                    <div class="tile-footer" style="background: rgb(39,115,0);
background: linear-gradient(90deg, rgba(39,115,0,1) 0%, rgba(54,204,138,1) 100%, rgba(71,145,64,0.5217437316723564) 100%, rgba(57,205,106,1) 100%, rgba(109,190,107,1) 100%);">
                                                        <div class="pull-left">ADD EMPLOYEES</div>
                                                        <div class="pull-right percent-change"></div>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endif; ?>



                                        <?php if ($currentUser[0]->shift_allocation == 1): ?>
                                            <div class="col-md-3">
                                                <a style="background: rgb(231,213,0);
background: linear-gradient(90deg, rgba(231,213,0,1) 0%, rgba(239,249,76,0.8352591036414566) 100%);" class="info-tile has-footer" href="<?php echo base_url(); ?>Attendance/Shift_Allocation">
                                                    <div class="tile-heading">
                                                        <div style="color: #ffffff"  class="pull-left">Shift Allocation</div>
                                                        <div class="pull-right">
                                                            <div id="tiletickets" class="sparkline-block"></div>
                                                        </div>
                                                    </div>
                                                    <div class="tile-body">
                                                        <div class="pull-left"><i class="fa fa-clock-o"></i></div>
                                                        <div class="pull-right"></div>
                                                    </div>
                                                    <div style="background: rgb(177,163,0);
background: linear-gradient(90deg, rgba(177,163,0,1) 0%, rgba(239,250,35,0.6475840336134453) 100%);" class="tile-footer">
                                                        <div style="color: #ffffff"  class="pull-left">SHIFT ALLOCATION</div>
                                                        <div class="pull-right percent-change"></div>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($currentUser[0]->attendance_process == 1): ?>
                                            <div class="col-md-3">
                                                <a style="background: rgb(34,193,195);
background: linear-gradient(36deg, rgba(34,193,195,1) 0%, rgba(45,253,202,0.8688725490196079) 100%);" class="info-tile has-footer" href="<?php echo base_url(); ?>Attendance/Attendance_Process_test">
                                                    <div class="tile-heading">
                                                        <div style="color: #ffffff"  class="pull-left">ATTENDANCE PROCESS</div>
                                                        <div class="pull-right">
                                                            <div id="tilerevenues" class="sparkline-block"></div>
                                                        </div>
                                                    </div>
                                                    <div class="tile-body">
                                                        <div class="pull-left"><i class="fa fa-gears"></i></div>
                                                        <div class="pull-right"></div>
                                                    </div>
                                                    <div style="background: rgb(0,178,180);
background: linear-gradient(36deg, rgba(0,178,180,1) 0%, rgba(95,246,232,0.7372198879551821) 100%);" class="tile-footer">
                                                        <div style="color: #ffffff"  class="pull-left">ATTENDANCE PROCESS</div>
                                                        <div class="pull-right percent-change"></div>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($currentUser[0]->payroll_process == 1): ?>
                                            <div class="col-md-3">
                                                <a style="background: rgb(0,84,98);
background: linear-gradient(36deg, rgba(0,84,98,1) 0%, rgba(114,159,179,0.9445028011204482) 100%);" class="info-tile has-footer" href="<?php echo base_url(); ?>Pay/Payroll_Process/">
                                                    <div class="tile-heading">
                                                        <div style="color: #ffffff"  class="pull-left">PAYROLL PROCESS</div>
                                                        <div class="pull-right">
                                                            <div id="tilemembers" class="sparkline-block"></div>
                                                        </div>
                                                    </div>
                                                    <div class="tile-body">
                                                        <div class="pull-left"><i class="fa fa-money"></i></div>
                                                        <div class="pull-right"></div>
                                                    </div>
                                                    <div style="background: rgb(0,71,83);
background: linear-gradient(36deg, rgba(0,71,83,1) 0%, rgba(128,197,227,0.8800770308123249) 100%);" class="tile-footer">
                                                        <div style="color: #ffffff"  class="pull-left">PAYROLL PROCESS</div>
                                                        <div class="pull-right percent-change"></div>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                    
                                      <div class="row">
                                    <?php if ($currentUser[0]->leave_request == 1): ?>
                                      
                                            <div class="col-md-3">
                                                <a style="background: rgb(119,37,17);
background: linear-gradient(36deg, rgba(119,37,17,1) 0%, rgba(235,136,103,0.8800770308123249) 100%);" class="info-tile has-footer" href="<?php echo base_url(); ?>Leave_Transaction/Leave_Request">
                                                    <div class="tile-heading">
                                                        <div style="color: #ffffff"  class="pull-left">APPLY LEAVE</div>
                                                        <div class="pull-right">
                                                            <div id="tileorders" class="sparkline-block"></div>
                                                        </div>
                                                    </div>
                                                    <div class="tile-body">
                                                        <div class="pull-left"><i class="fa fa-plus-square"></i></div>
                                                        <div class="pull-right"></div>
                                                    </div>
                                                    <div style="background: rgb(88,21,4);
background: linear-gradient(36deg, rgba(88,21,4,1) 0%, rgba(255,148,112,0.8408613445378151) 100%);" class="tile-footer">
                                                        <div style="color: #ffffff"  class="pull-left">APPLY LEAVE</div>
                                                        <div class="pull-right percent-change"></div>
                                                    </div>
                                                </a>
                                            </div>
                                            
                                        <?php endif; ?>


                                        <?php if ($currentUser[0]->manual_att_request == 1): ?>
                                  
                                                <div class="col-md-3">
                                                    <a style="background: rgb(128,23,114);
background: linear-gradient(36deg, rgba(128,23,114,1) 0%, rgba(255,94,192,0.8940826330532213) 100%);" class="info-tile has-footer" href="<?php echo base_url(); ?>Attendance/Attendance_Manual_Entry_Request">
                                                        <div class="tile-heading">
                                                            <div style="color: #ffffff"  class="pull-left">ATTENDANCE REQUEST</div>
                                                            <div class="pull-right">
                                                                <div id="tileorders" class="sparkline-block"></div>
                                                            </div>
                                                        </div>
                                                        <div class="tile-body">
                                                            <div class="pull-left"><i class="fa fa-plus-square"></i></div>
                                                            <div class="pull-right"></div>
                                                        </div>
                                                        <div style="background: rgb(82,6,72);
background: linear-gradient(36deg, rgba(82,6,72,1) 0%, rgba(255,94,192,0.7008053221288515) 100%);" class="tile-footer">
                                                            <div style="color: #ffffff"  class="pull-left">ATTENDANCE REQUEST</div>
                                                            <div class="pull-right percent-change"></div>
                                                        </div>
                                                    </a>
                                                </div>
                                   
                                            <?php endif; ?>

                                            <?php if ($currentUser[0]->leave_approve == 1): ?>
                                                <div class="col-md-3">
                                                    <a style="background: rgb(96,96,96);
background: linear-gradient(36deg, rgba(96,96,96,1) 0%, rgba(181,181,181,0.9108893557422969) 100%);" class="info-tile has-footer" href="<?php echo base_url(); ?>Leave_Transaction/Leave_Approve">
                                                        <div class="tile-heading">
                                                            <div style="color: #ffffff"  class="pull-left">LEAVE APPROVE</div>
                                                            <div class="pull-right">
                                                                <div id="tiletickets" class="sparkline-block"></div>
                                                            </div>
                                                        </div>
                                                        <div class="tile-body">
                                                            <div class="pull-left"><i class="fa fa-tag"></i></div>
                                                            <div class="pull-right"></div>
                                                        </div>
                                                        <div style="background: rgb(71,71,71);
background: linear-gradient(36deg, rgba(71,71,71,1) 0%, rgba(201,201,201,0.7008053221288515) 100%);" class="tile-footer">
                                                            <div style="color: #ffffff"  class="pull-left">LEAVE APPROVE</div>
                                                            <div class="pull-right percent-change"></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            <?php endif; ?>



                                            <?php if ($currentUser[0]->request_advance == 1): ?>
                                                <div class="col-md-3">
                                                    <a style="background: rgb(209,227,30);
background: linear-gradient(36deg, rgba(209,227,30,1) 0%, rgba(238,250,123,0.7624299719887955) 100%);" class="info-tile has-footer" href="<?php echo base_url(); ?>Pay/Salary_Advance_req/">
                                                        <div class="tile-heading">
                                                            <div style="color: #ffffff"  class="pull-left">REQUEST SALARY ADVANCE</div>
                                                            <div class="pull-right">
                                                                <div id="tilemembers" class="sparkline-block"></div>
                                                            </div>
                                                        </div>
                                                        <div class="tile-body">
                                                            <div class="pull-left"><i class="fa fa-plus-circle"></i></div>
                                                            <!--<div class="pull-right">7,112</div>-->
                                                        </div>
                                                        <div style="background: rgb(167,184,0);
background: linear-gradient(36deg, rgba(167,184,0,1) 0%, rgba(242,252,145,0.59156162464986) 100%);" class="tile-footer">
                                                            <div style="color: #ffffff"  class="pull-left">REQUEST SALARY ADVANCE</div>
                                                            <!--<div class="pull-right percent-change">-11.1%</div>-->
                                                        </div>
                                                    </a>
                                                </div>
                                            <?php endif; ?>


                                            <div  class="col-md-3">
                                                <a class="info-tile tile-das4 has-footer" href="">
                                                    <div class="tile-heading">
                                                        <div style="color: #ffffff"  class="pull-left"><h6>Leave Balance</h6></div>
                                                        <div class="pull-right">
                                                            <div id="tilemembers" class="sparkline-block"></div>
                                                        </div>
                                                    </div>
                                                    <div style="color: #000000">
                                                        <ul>
                                                            <?php foreach ($data_leave as $t_data) { ?>
                                                                <li>   <?php echo $t_data->leave_name . ' - ' . $t_data->Balance; ?> </li>
                                                            <?php }
                                                            ?> 
                                                        </ul>
                                                        <!--<div class="pull-right">7,112</div>-->
                                                    </div>
                                                </a>
                                            </div>





                                        </div>

                                    </div>
                                    <!--Dashboard shortcut end-->







                                </div>



                                <!-- Charts-->
                                <div class="row">

                                    <!--Departments Chart -->
                                    <?php if ($currentUser[0]->dsh_ch_1 == 1): ?>
                                        <div class="col-md-6">
                                            <div id="container" ></div>
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
                                        <div class="col-md-6">
                                            <div id="container3"></div>
                                        </div>
                                    <?php endif; ?>
                                    <!--End Company Employee by gender-->
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
                                                        <a href="<?php echo base_url(); ?>Reports/Attendance/Report_Attendance_In_Out" class="shortcut-tile tile-info">
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
                                                        <a href="#" class="shortcut-tile tile-orange">
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
                                                        <a href="#" class="shortcut-tile tile-success">
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
                                                        <a href="#" class="shortcut-tile tile-magenta">
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
                                                    <div class="col-md-2">
                                                        <a href="#" class="shortcut-tile tile-midnightblue">
                                                            <div class="tile-body">
                                                                <div class="pull-left"><i class="fa fa-folder"></i></div>
                                                                <div class="pull-right"><span class="badge"></span></div>
                                                            </div>
                                                            <div class="tile-footer">
                                                                SALARY ADVANCE
                                                            </div>
                                                        </a>
                                                    </div>
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
                                <a href="javascript:;" data-toggle="collapse" data-target="#sparklinestats"><h4>Sparkline Stats</h4></a>
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
                                <a href="javascript:;" data-toggle="collapse" data-target="#recentactivity"><h4>Recent Activity</h4></a>
                            </div>
                            <div id="recentactivity" class="collapse in">
                                <div class="widget-body">
                                    <ul class="recent-activities">
                                        <li>
                                            <div class="avatar">
                                                <img src="assets/demo/avatar/avatar_11.png" class="img-responsive img-circle">
                                            </div>
                                            <div class="content">
                                                <span class="msg"><a href="#" class="person">Jean Alanis</a> invited 3 unconfirmed members</span>
                                                <span class="time">2 mins ago</span>

                                            </div>
                                        </li>
                                        <li>
                                            <div class="avatar">
                                                <img src="assets/demo/avatar/avatar_09.png" class="img-responsive img-circle">
                                            </div>
                                            <div class="content">
                                                <span class="msg"><a href="#" class="person">Anthony Ware</a> is now following you</span>
                                                <span class="time">4 hours ago</span>

                                            </div>
                                        </li>
                                        <li>
                                            <div class="avatar">
                                                <img src="assets/demo/avatar/avatar_04.png" class="img-responsive img-circle">
                                            </div>
                                            <div class="content">
                                                <span class="msg"><a href="#" class="person">Bruce Ory</a> commented on <a href="#">Dashboard UI</a></span>
                                                <span class="time">16 hours ago</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="avatar">
                                                <img src="assets/demo/avatar/avatar_01.png" class="img-responsive img-circle">
                                            </div>
                                            <div class="content">
                                                <span class="msg"><a href="#" class="person">Roxann Hollingworth</a>is now following you</span>
                                                <span class="time">Feb 13, 2015</span>
                                            </div>
                                        </li>
                                    </ul>
                                    <a href="#" class="more">See all activities</a>
                                </div>
                            </div>
                        </div>

                        <div class="widget" >
                            <div class="widget-heading">
                                <a href="javascript:;" data-toggle="collapse" data-target="#widget-milestones"><h4>Milestones</h4></a>
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
                                <a href="javascript:;" data-toggle="collapse" data-target="#widget-contact"><h4>Contacts</h4></a>
                            </div>
                            <div id="widget-contact" class="collapse in">
                                <div class="widget-body">
                                    <ul class="contact-list">
                                        <li id="contact-1">
                                            <a href="javascript:;"><img src="assets/demo/avatar/avatar_02.png" alt=""><span>Jeremy Potter</span></a>
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
                                            <a href="javascript:;"><img src="assets/demo/avatar/avatar_07.png" alt=""><span>David Tennant</span></a>
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
                                            <a href="javascript:;"><img src="assets/demo/avatar/avatar_03.png" alt=""><span>Anna Johansson</span></a>
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
                                            <a href="javascript:;"><img src="assets/demo/avatar/avatar_09.png" alt=""><span>Alan Doyle</span></a>
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
                                            <a href="javascript:;"><img src="assets/demo/avatar/avatar_05.png" alt=""><span>Simon Corbett</span></a>
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
                                            <a href="javascript:;"><img src="assets/demo/avatar/avatar_01.png" alt=""><span>Polly Paton</span></a>
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

            <?php $this->load->view('template/js.php'); ?>							<!-- Initialize scripts for this page-->

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



            <!--Department Chart-->
            <script type="text/javascript">


                $(function () {

                    var dep_data = [];
<?php foreach ($sdata as $sales) { ?>
                        s = eval('<?php echo $sales->EmpCount ?>'.toString().replace(/"/g, ""));
                        dep_data.push({name: '<?php echo $sales->Dep_Name ?>', y: s});

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
                                    format: '{point.name}'
                                }
                            }
                        },
                        series: [{
                                type: 'pie',
                                name: 'Employee',
                                data: dep_data
                            }]
                    });
                    //                    alert(dep_data);

                });
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
                            }, ]
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


            </script>
            <script src="<?php echo base_url(); ?>assets/plugins/highcharts/exporting.js" type="text/javascript"></script>
            <script src="<?php echo base_url(); ?>assets/plugins/highcharts/highcharts-3d.js" type="text/javascript"></script>
            <script src="<?php echo base_url(); ?>assets/plugins/highcharts/highcharts.js" type="text/javascript"></script>
    </body>


</html>