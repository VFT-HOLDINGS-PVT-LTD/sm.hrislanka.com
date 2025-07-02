
<!DOCTYPE html>
<html lang="en" class="coming-soon">
    
    
    <style>
        @keyframes move {
    100% {
        transform: translate3d(0, 0, 1px) rotate(360deg);
    }
}

.background {
        position: absolute;
    width: 100vw;
    height: 100vh;
    top: 0;
    left: 0;
    background: #ffffff;
    overflow: hidden;
}

.background span {
    width: 4vmin;
    height: 4vmin;
    border-radius: 4vmin;
    backface-visibility: hidden;
    position: absolute;
    animation: move;
    animation-duration: 45;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
}


.background span:nth-child(0) {
    color: #12356e;
    top: 49%;
    left: 25%;
    animation-duration: 6s;
    animation-delay: -1s;
    transform-origin: -16vw -21vh;
    /*box-shadow: 8vmin 0 1.4186442300627542vmin currentColor;*/
}
.background span:nth-child(1) {
    color: #12356e;
    top: 84%;
    left: 100%;
    animation-duration: 36s;
    animation-delay: -11s;
    transform-origin: 19vw -3vh;
    /*box-shadow: 8vmin 0 1.391545523556691vmin currentColor;*/
}
.background span:nth-child(2) {
    color: #12356e;
    top: 30%;
    left: 69%;
    animation-duration: 22s;
    animation-delay: -47s;
    transform-origin: -10vw 9vh;
    /*box-shadow: 8vmin 0 1.2005750917031792vmin currentColor;*/
}
.background span:nth-child(3) {
    color: #12356e;
    top: 18%;
    left: 28%;
    animation-duration: 8s;
    animation-delay: -23s;
    transform-origin: 17vw -18vh;
    box-shadow: 8vmin 0 1.612199475688239vmin currentColor;
}
.background span:nth-child(4) {
    color: #12356e;
    top: 15%;
    left: 33%;
    animation-duration: 15s;
    animation-delay: -13s;
    transform-origin: -9vw 6vh;
    box-shadow: 8vmin 0 1.3501641201182912vmin currentColor;
}
.background span:nth-child(5) {
    color: #12356e;
    top: 30%;
    left: 59%;
    animation-duration: 13s;
    animation-delay: -31s;
    transform-origin: 13vw -16vh;
    box-shadow: 8vmin 0 1.3377567223146034vmin currentColor;
}
.background span:nth-child(6) {
    color: #12356e;
    top: 92%;
    left: 68%;
    animation-duration: 18s;
    animation-delay: -10s;
    transform-origin: 1vw 5vh;
    box-shadow: -8vmin 0 1.1364672433301497vmin currentColor;
}
.background span:nth-child(7) {
    color: #12356e;
    top: 77%;
    left: 55%;
    animation-duration: 53s;
    animation-delay: -10s;
    transform-origin: -18vw 20vh;
    box-shadow: 8vmin 0 1.646028685896595vmin currentColor;
}
.background span:nth-child(8) {
    color: #12356e;
    top: 91%;
    left: 28%;
    animation-duration: 40s;
    animation-delay: -17s;
    transform-origin: 1vw 7vh;
    box-shadow: -8vmin 0 1.833738561490397vmin currentColor;
}
.background span:nth-child(9) {
    color: #12356e;
    top: 22%;
    left: 86%;
    animation-duration: 43s;
    animation-delay: -27s;
    transform-origin: -12vw -5vh;
    box-shadow: 8vmin 0 1.646226164587309vmin currentColor;
}
.background span:nth-child(10) {
    color: #12356e;
    top: 14%;
    left: 22%;
    animation-duration: 17s;
    animation-delay: -10s;
    transform-origin: 6vw 16vh;
    box-shadow: 8vmin 0 1.6424478228371775vmin currentColor;
}
.background span:nth-child(11) {
    color: #12356e;
    top: 86%;
    left: 80%;
    animation-duration: 34s;
    animation-delay: -8s;
    transform-origin: 0vw 25vh;
    box-shadow: -8vmin 0 1.8357665940270185vmin currentColor;
}
.background span:nth-child(12) {
    color: #12356e;
    top: 89%;
    left: 95%;
    animation-duration: 22s;
    animation-delay: -45s;
    transform-origin: -3vw 3vh;
    box-shadow: 8vmin 0 1.7164503731464786vmin currentColor;
}
.background span:nth-child(13) {
    color: #12356e;
    top: 43%;
    left: 5%;
    animation-duration: 55s;
    animation-delay: -18s;
    transform-origin: -24vw -5vh;
    box-shadow: 8vmin 0 1.2905870881837542vmin currentColor;
}
.background span:nth-child(14) {
    color: #12356e;
    top: 90%;
    left: 61%;
    animation-duration: 52s;
    animation-delay: -28s;
    transform-origin: -11vw -11vh;
    box-shadow: -8vmin 0 1.5598452756782315vmin currentColor;
}
.background span:nth-child(15) {
    color: #12356e;
    top: 73%;
    left: 52%;
    animation-duration: 45s;
    animation-delay: -50s;
    transform-origin: 21vw -12vh;
    box-shadow: -8vmin 0 1.3944417006647836vmin currentColor;
}
.background span:nth-child(16) {
    color: #12356e;
    top: 45%;
    left: 11%;
    animation-duration: 30s;
    animation-delay: -46s;
    transform-origin: -11vw 18vh;
    box-shadow: -8vmin 0 1.1908988572391292vmin currentColor;
}
.background span:nth-child(17) {
    color: #12356e;
    top: 27%;
    left: 9%;
    animation-duration: 43s;
    animation-delay: -21s;
    transform-origin: 0vw 13vh;
    /*box-shadow: -8vmin 0 1.6412290800691307vmin currentColor;*/
}
.background span:nth-child(18) {
    color: #12356e;
    top: 80%;
    left: 31%;
    animation-duration: 10s;
    animation-delay: -18s;
    transform-origin: 13vw -18vh;
    /*box-shadow: -8vmin 0 1.8080641416801682vmin currentColor;*/
}
.background span:nth-child(19) {
    color: #12356e;
    top: 46%;
    left: 84%;
    animation-duration: 46s;
    animation-delay: -3s;
    transform-origin: -8vw -6vh;
    box-shadow: -8vmin 0 1.4788046419374512vmin currentColor;
}
.background span:nth-child(20) {
    color: #12356e;
    top: 91%;
    left: 84%;
    animation-duration: 54s;
    animation-delay: -4s;
    transform-origin: 19vw 23vh;
    box-shadow: 8vmin 0 1.3015675998120173vmin currentColor;
}
.background span:nth-child(21) {
    color: #12356e;
    top: 82%;
    left: 53%;
    animation-duration: 32s;
    animation-delay: -12s;
    transform-origin: -7vw -11vh;
    box-shadow: -8vmin 0 1.8461214042629424vmin currentColor;
}
.background span:nth-child(22) {
    color: #12356e;
    top: 29%;
    left: 8%;
    animation-duration: 38s;
    animation-delay: -16s;
    transform-origin: -12vw 3vh;
    box-shadow: -8vmin 0 1.8146853591644252vmin currentColor;
}
.background span:nth-child(23) {
    color: #12356e;
    top: 32%;
    left: 35%;
    animation-duration: 54s;
    animation-delay: -42s;
    transform-origin: 17vw 18vh;
    box-shadow: -8vmin 0 1.0973991288261693vmin currentColor;
}
.background span:nth-child(24) {
    color: #12356e;
    top: 63%;
    left: 8%;
    animation-duration: 40s;
    animation-delay: -17s;
    transform-origin: 12vw -24vh;
    box-shadow: 8vmin 0 1.0324952241912324vmin currentColor;
}
.background span:nth-child(25) {
    color: #12356e;
    top: 74%;
    left: 67%;
    animation-duration: 10s;
    animation-delay: -13s;
    transform-origin: -3vw -4vh;
    box-shadow: 8vmin 0 1.057677271040118vmin currentColor;
}
.background span:nth-child(26) {
    color: #12356e;
    top: 25%;
    left: 77%;
    animation-duration: 33s;
    animation-delay: -14s;
    transform-origin: -13vw 16vh;
    box-shadow: 8vmin 0 1.8838187557404735vmin currentColor;
}
.background span:nth-child(27) {
    color: #12356e;
    top: 4%;
    left: 24%;
    animation-duration: 41s;
    animation-delay: -14s;
    transform-origin: -14vw -13vh;
    box-shadow: -8vmin 0 1.6834231141317824vmin currentColor;
}
.background span:nth-child(28) {
    color: #12356e;
    top: 28%;
    left: 63%;
    animation-duration: 23s;
    animation-delay: -50s;
    transform-origin: -21vw 2vh;
    box-shadow: -8vmin 0 1.6024936500004554vmin currentColor;
}
.background span:nth-child(29) {
    color: #12356e;
    top: 46%;
    left: 49%;
    animation-duration: 34s;
    animation-delay: -27s;
    transform-origin: -23vw 10vh;
    box-shadow: 8vmin 0 1.208135188740776vmin currentColor;
}

        </style>


    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="description" content="HRM_SYETEM">

        <link href="<?php echo base_url(); ?>assets/plugins/iCheck/skins/minimal/blue.css" type="text/css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/fonts/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/styles.css" type="text/css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/custom_css.css" type="text/css" rel="stylesheet">   
    </head>

    <body class="focused-form" style="
          background: url(<?php echo base_url(); ?>assets/images/company/header-left.svg) left top no-repeat, linear-gradient(to bottom, #00adf1 0%, #08236b 100%);
    background-size: 83%;
          
/*          background: rgb(13,99,131);
background: linear-gradient(90deg, rgba(13,99,131,0.8858893899356618) 0%, rgba(4,125,175,0.7010154403558299) 28%, rgba(235,235,235,1) 100%);*/
">
<div class="background">
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
</div>

        <div class="container" id="login-form" >
            <a class="login-logo"><h3 style="color: black;">
                    <?php
                    if ($logo == null) {
                        $logo_hr = 'Company Name (pvt) Ltd';
                    } else {
                        $logo_hr = $logo[0]->company_Name;
                    }

//                    echo $logo_hr;
                    ?>

                </h3><img style="width: 365px; height: 110px; " src="<?php base_url(); ?>

                          <?php
                          if ($logo == null) {
                              $logo_img = 'empty_logo';
                          } else {
                              $logo_img = $logo[0]->comp_logo;
                          }

                          echo "assets/images/company/" . $logo_img . ".png"
                          ?>"></a>
            <div class="row" >
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default" style=" border: #bbbbbb 1px solid ; border-radius: 10px;
  padding: 10px;
  box-shadow: 1px 3px 5px 5px #6283a5;">
                        <div style="text-align: center" class=""><h4>- Login To HR SYSTEM -</h4></div>
                        <div class="panel-body" >


                            <form class="form-horizontal" id="frmLogin" name="frmLogin" action="<?php echo base_url() ?>Login/verifyUser" method="POST">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group">							
                                            <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </span>


                                            <input type="text" class="form-control" id="txt_username" name="txt_username" placeholder="Username" data-parsley-minlength="6" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-key"></i>
                                            </span>
                                            <input type="password" class="form-control" id="txt_password" name="txt_password" placeholder="Password" required="">
                                        </div>
                                    </div>
                                </div>

                                <!--success Message-->
                                <?php if (isset($_SESSION['success_message']) && $_SESSION['success_message'] != '') { ?>
                                    <div id="spnmessagelogin" class=" error_redirect alert alert-dismissable alert-success">
                                        <strong>Success !</strong> <?php echo $_SESSION['success_message'] ?>
                                    </div>
                                <?php } ?>

                                <!--Error Message-->
                                <?php if (isset($_SESSION['error_message']) && $_SESSION['error_message'] != '') { ?>
                                    <div id="spnmessagelogin" class="error_redirect alert alert-dismissable alert-danger ">
                                        <strong>Error !</strong> <?php echo $_SESSION['error_message'] ?>
                                    </div>
                                <?php } ?>
                                <div class="panel-footer">
                                    <div class="clearfix">

                                        <button type="submit" id="btnSubmit" name="btnSubmit" class="btn btn-info pull-right fa fa-lock">&nbsp;&nbsp;&nbsp;&nbsp;LOGIN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                                        <input type="button"  id="cancel" name="cancel" class="btn-danger-alt btn fa fa-check" value="&nbsp;&nbsp;CLEAR" >    

                                    </div>
                                </div>

                            </form>

                        </div>

                    </div>
                    <div style="text-align: center; color: #000">ERP Version 1.4.1 By <a  style="text-align: center; color: #000" href="http://vftholdings.lk" >VFT HOLDINGS (PVT) LTD</a></div>
                    <!--<marquee  behavior="alternate" scrolldelay="150" style="color: #ffffff"><?php echo $logo_hr; ?></marquee>-->


                </div>
            </div>
        </div>

    </body>

    <script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.min.js"></script> 							<!-- Load jQuery -->
    <script src="<?php echo base_url(); ?>assets/js/jqueryui-1.9.2.min.js"></script> 							<!-- Load jQueryUI -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script> 								<!-- Load Bootstrap -->
    <script src="<?php echo base_url(); ?>assets/plugins/easypiechart/jquery.easypiechart.js"></script> 		<!-- EasyPieChart-->
    <script src="<?php echo base_url(); ?>assets/plugins/sparklines/jquery.sparklines.min.js"></script>  		<!-- Sparkline -->
    <script src="<?php echo base_url(); ?>assets/plugins/jstree/dist/jstree.min.js"></script>  				<!-- jsTree -->
    <script src="<?php echo base_url(); ?>assets/plugins/codeprettifier/prettify.js"></script> 				<!-- Code Prettifier  -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-switch/bootstrap-switch.js"></script> 		<!-- Swith/Toggle Button -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js"></script>  <!-- Bootstrap Tabdrop -->
    <script src="<?php echo base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script>     					<!-- iCheck -->
    <script src="<?php echo base_url(); ?>assets/js/enquire.min.js"></script> 									<!-- Enquire for Responsiveness -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootbox/bootbox.js"></script>							<!-- Bootbox -->
    <script src="<?php echo base_url(); ?>assets/plugins/simpleWeather/jquery.simpleWeather.min.js"></script> <!-- Weather plugin-->
    <script src="<?php echo base_url(); ?>assets/plugins/nanoScroller/js/jquery.nanoscroller.min.js"></script> <!-- nano scroller -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-mousewheel/jquery.mousewheel.min.js"></script> 	<!-- Mousewheel support needed for jScrollPane -->
    <script src="<?php echo base_url(); ?>assets/js/application.js"></script>
    <script src="<?php echo base_url(); ?>assets/demo/demo.js"></script>
    <script src="<?php echo base_url(); ?>assets/demo/demo-switcher.js"></script>
    <script src="<?php echo base_url(); ?>system_js/utility.js" type="text/javascript"></script>
    <!--Ajax-->
    <!--<script src="<?php echo base_url(); ?>system_js/login/login.js"></script>-->

    <!--Jquary Validation-->
    <script src="<?php echo base_url(); ?>assets/plugins/validation/jquery.validate.js"></script>

    <!--JQuary Validation-->
    <script type="text/javascript">
        $(document).ready(function () {
            $("#frmLogin").validate({
                rules: {
                    txt_username: {
                        required: true,
                        minlength: 1
                    },
                    txt_password: {
                        required: true,
                        minlength: 1
                    },
                },
                messages: {
                    txt_username: {
                        required: "<i class='fa fa-user'></i>  Please enter Username !",
                        minlength: "Your username must consist of at least 1 characters"
                    },
                    txt_password: {
                        required: "<i class='fa fa-key'></i> Please enter your Password !",
                        minlength: "Your password must be at least 1 characters long"
                    }

                }
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#frm_departmrnt").validate();
            $("#spnmessagelogin").hide("shake", {times: 6}, 3500);
        });
    </script>

    <!--Clear Text Boxes-->
    <script type="text/javascript">

        $("#cancel").click(function () {

            $("#txt_username").val("");
            $("#txt_password").val("");

        });
    </script>





</html>