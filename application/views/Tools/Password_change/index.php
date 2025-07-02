<!DOCTYPE html>


<!--Description of dashboard page

@author Ashan Rathsara-->


<html lang="en">


    <head>
        <!-- Styles -->
        <?php $this->load->view('template/css.php'); ?>

    </head>

    <body class="infobar-offcanvas">

        <!--header-->

        <?php $this->load->view('template/header.php'); ?>

        <!--end header-->

        <div id="wrapper">
            <div id="layout-static">

                <!--dashboard side-->

                <?php $this->load->view('template/dashboard_side.php'); ?>

                <!--dashboard side end-->

                <div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">

                                <li class=""><a href="<?php echo base_url(); ?>Dashboard/">HOME</a></li>
                                <li class="active"><a href="<?php echo base_url(); ?>Master/Department/">CHANGE PASSWORD</a></li>

                            </ol>


                            <div class="page-tabs">
                                <ul class="nav nav-tabs">

                                    <li class="active"><a data-toggle="tab" href="#tab1">CHANGE PASSWORD</a></li>
                                    


                                </ul>
                            </div>
                            <div class="container-fluid">


                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">

                                        <div class="row">
                                            <div class="col-xs-12">


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-info">
                                                            <div class="panel-heading"><h2>CHANGE PASSWORD</h2></div>
                                                            <div class="panel-body">
                                                                <form class="form-horizontal" id="frm_password_change" name="frm_password_change" action="<?php echo base_url(); ?>Tools/Password_change/Change" method="POST">

                                                                    <!--success Message-->
                                                                    <?php if (isset($_SESSION['success_message']) && $_SESSION['success_message'] != '') { ?>
                                                                        <div id="spnmessage" class="alert alert-dismissable alert-success">
                                                                            <strong>Success !</strong> <?php echo $_SESSION['success_message'] ?>
                                                                        </div>
                                                                    <?php } ?>
                                                                    
                                                                    <div class="form-group col-sm-12">
                                                                        <div class="col-sm-8">
                                                                            <img class="imagecss" src="<?php echo base_url(); ?>assets/images/change_password.png" >
                                                                        </div>
                                                                    </div>

                                                                    <div class="from-group col-md-12">
                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Current Password</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="password" class="form-control" required="required" id="txt_cur_password" name="txt_cur_password" placeholder="Current Password">
                                                                        </div>

                                                                    </div>
                                                                    </div>
                                                                    <div class="from-group col-md-12">
                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">New Password</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="password" class="form-control" required="required" id="txt_new_password" name="txt_new_password" placeholder="New Password">
                                                                        </div>

                                                                    </div>
                                                                    
                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Confirm Password</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="password" class="form-control" required="required" id="txt_conf_password" name="txt_conf_password" placeholder="Confirm Password">
                                                                        </div>

                                                                    </div>
                                                                    </div>

                                                                    <!--submit button-->
                                                                    <?php $this->load->view('template/btn_submit.php'); ?>
                                                                    <!--end submit-->


                                                                </form>
                                                                <hr>

                                                            </div>

                                                            <div id="divmessage" class="">
                                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                                <div id="spnmessage"> </div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                    </div>


                                   
                                </div>

                            </div><!-- /.modal -->

                        </div> <!-- .container-fluid -->


                        <!--Footer-->
                        <?php $this->load->view('template/footer.php'); ?>	
                        <!--End Footer-->
                    </div>
                </div>
            </div>




            <!-- Load site level scripts -->

            <?php $this->load->view('template/js.php'); ?>							<!-- Initialize scripts for this page-->


            <!-- End loading page level scripts-->

            <!--Ajax-->
            <script src="<?php echo base_url(); ?>system_js/Master/Departmrnt.js"></script>

            
            
            
            <!--JQuary Validation-->
            <script type="text/javascript">
                $(document).ready(function () {
                   $("#frm_password_change").validate({
			rules: {
				
				username: {
					required: true,
					minlength: 2
				},
				txt_new_password: {
					required: true,
					minlength: 4
				},
				txt_conf_password: {
					required: true,
					minlength: 4,
					equalTo: "#txt_new_password"
				}
			},
			messages: {
				
				username: {
					required: "Please enter a username",
					minlength: "Your username must consist of at least 2 characters"
				},
				password: {
					required: "<i class='fa fa-ban'></i>Please provide a password",
					minlength: "<i class='fa fa-ban'></i>Your password must be at least 5 characters long"
				},
				confirm_password: {
					required: "<i class='fa fa-ban'></i>Please provide a password",
					minlength: "<i class='fa fa-ban'></i>Your password must be at least 5 characters long",
					equalTo: "<i class='fa fa-ban'></i>Please enter the same password as above"
				}
				
			}

		});
                });
            </script>

    </body>


</html>