<!DOCTYPE html>


<!--Description of Attendance Collection page

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

                                <li class=""><a href="index.html">HOME</a></li>
                                <li class="active"><a href="index.html">ATTENDANCE COLLECTION</a></li>

                            </ol>


                            <div class="page-tabs">
                                <ul class="nav nav-tabs">

                                    <li class="active"><a data-toggle="tab" href="#tab1">DOWNLOAD ATTENDANCE</a></li>
                                    <li class=""><a data-toggle="tab" href="#tab2">ATTENDANCE DEVICE</a></li>

                                </ul>
                            </div>
                            <div class="container-fluid">


                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">

                                        <div class="row">
                                            <div class="col-xs-12">


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-primary">
                                                            <div class="panel-heading"><h2>DOWNLOAD ATTENDANCE</h2></div>
                                                            <div class="panel-body">
                                                                <form action="<?php echo base_url(); ?>index.php/Attendance/Attendance_Collection/get_from_table" class="form-horizontal" id="frm_att_collection" name="frm_att_collection" method="POST" enctype="multipart/form-data">


                                                                    <!--success Message-->
                                                                    <?php if (isset($_SESSION['success_message']) && $_SESSION['success_message'] != '') { ?>
                                                                        <div id="spnmessage" class="alert alert-dismissable alert-success success_redirect">
                                                                            <strong>Success !</strong> <?php echo $_SESSION['success_message'] ?>
                                                                        </div>
                                                                    <?php } ?>

                                                                    <!--Error Message-->
                                                                    <?php if (isset($_SESSION['error_message']) && $_SESSION['error_message'] != '') { ?>
                                                                        <div id="spnmessage" class="alert alert-dismissable alert-danger error_redirect">
                                                                            <strong>Error !</strong> <?php echo $_SESSION['error_message'] ?>
                                                                        </div>
                                                                    <?php } ?>


                                                                    <div id="search_body">

                                                                    </div>


                                                                    <div class="form-group col-sm-12">
                                                                        <div class="col-sm-8">
                                                                            <img class="" style="width: 200px; margin-left: 20%;" src="<?php echo base_url(); ?>assets/images/fingerprint_collection.png" >
                                                                        </div>
                                                                    </div>
                                                                    <br><br><br><br><br><br><br><br>




<!--                                                                    
                                                                                                                                        <div class="form-group">
                                                                                                                                            <label class="col-sm-2 control-label"> Attendance File</label>
                                                                                                                                            <div class="col-sm-8">
                                                                                                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                                                                                                    <div class="input-group">
                                                                                                                                                        <div class="form-control uneditable-input" data-trigger="fileinput">
                                                                                                                                                            <i class="fa fa-file fileinput-exists"></i>&nbsp;<span class="fileinput-filename"></span>
                                                                                                                                                        </div>
                                                                                                                                                        <span class="input-group-btn">
                                                                                                                                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                                                                                                                            <span class="btn btn-default btn-file">
                                                                                                                                                                <span class="fileinput-new">Select file</span>
                                                                                                                                                                <span class="fileinput-exists">Change</span>
                                                                                                                                                                <input type="file" name="text_file_upload" id="text_file_upload">
                                                                                                                                                            </span>
                                                                    
                                                                                                                                                        </span>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                        </div>-->
                                                                    <!--submit button-->
                                                                    <hr>
                                                                    <div class="row">
                                                                        <div class="col-sm-8 col-sm-offset-2">
                                                                            <button type="submit" id="submit" name="submit" class="btn-primary btn fa fa-check">&nbsp;&nbsp;DOWNLOAD</button>
                                                                            <button type="button" id="Cancel" name="Cancel" class="btn btn-danger-alt fa fa-times-circle">&nbsp;&nbsp;CANCEL</button>
                                                                        </div>
                                                                    </div>
                                                                    <!--end submit-->


                                                                </form>

                                                                <hr>

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

                                    <div class="tab-pane" id="tab2">

                                        <div class="row">
                                            <div class="col-xs-12">


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-primary">
                                                            <div class="panel-heading"><h2>ATTENDANCE DEVICE</h2></div>
                                                            <div class="panel-body">
                                                                <form action="<?php echo base_url(); ?>index.php/Attendance/Attendance_Collection/insert_data" class="form-horizontal" id="frm_att_collection" name="frm_att_collection" method="POST" enctype="multipart/form-data">


                                                                    <!--success Message-->
                                                                    <?php if (isset($_SESSION['success_message']) && $_SESSION['success_message'] != '') { ?>
                                                                        <div id="spnmessage" class="alert alert-dismissable alert-success success_redirect">
                                                                            <strong>Success !</strong> <?php echo $_SESSION['success_message'] ?>
                                                                        </div>
                                                                    <?php } ?>

                                                                    <!--Error Message-->
                                                                    <?php if (isset($_SESSION['error_message']) && $_SESSION['error_message'] != '') { ?>
                                                                        <div id="spnmessage" class="alert alert-dismissable alert-danger error_redirect">
                                                                            <strong>Error !</strong> <?php echo $_SESSION['error_message'] ?>
                                                                        </div>
                                                                    <?php } ?>


                                                                    <div id="search_body">

                                                                    </div>


                                                                    <div class="form-group col-sm-12">
                                                                        <div class="col-sm-8">
                                                                            <img class="" style="width: 200px; margin-left: 20%;" src="<?php echo base_url(); ?>assets/images/fingerprint_collection.png" >
                                                                        </div>
                                                                    </div>
                                                                    <br><br><br><br><br><br><br><br>


                                                                    
                                                                                                                                        <div class="form-group">
                                                                                                                                            <label class="col-sm-2 control-label"> Attendance File</label>
                                                                                                                                            <div class="col-sm-8">
                                                                                                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                                                                                                    <div class="input-group">
                                                                                                                                                        <div class="form-control uneditable-input" data-trigger="fileinput">
                                                                                                                                                            <i class="fa fa-file fileinput-exists"></i>&nbsp;<span class="fileinput-filename"></span>
                                                                                                                                                        </div>
                                                                                                                                                        <span class="input-group-btn">
                                                                                                                                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                                                                                                                            <span class="btn btn-default btn-file">
                                                                                                                                                                <span class="fileinput-new">Select file</span>
                                                                                                                                                                <span class="fileinput-exists">Change</span>
                                                                                                                                                                <input type="file" name="text_file_upload" id="text_file_upload">
                                                                                                                                                            </span>
                                                                    
                                                                                                                                                        </span>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                        </div>


<!--                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Device IP / Domain</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" required="required" id="txt_dep_name" name="txt_dep_name" placeholder="Ex: 192.168.1.201">
                                                                        </div>

                                                                    </div>-->
                                                                    <!--submit button-->
                                                                    <?php $this->load->view('template/btn_submit.php'); ?>
                                                                    <!--end submit-->


                                                                </form>

                                                                <hr>

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

                                </div>




                            </div> <!-- .container-fluid -->
                        </div>

                        <!--Footer-->
                        <?php $this->load->view('template/footer.php'); ?>
                        <!--End Footer-->

                    </div>
                </div>
            </div>




            <!-- Load site level scripts -->

            <?php $this->load->view('template/js.php'); ?>							<!-- Initialize scripts for this page-->

            <!-- End loading page level scripts-->



            <script src="<?php echo base_url(); ?>assets/plugins/form-jasnyupload/fileinput.min.js"></script>               			<!-- File Input -->


            <!--JQuary Validation-->
            <script type="text/javascript">
                $(document).ready(function () {
                    $("#frm_att_collection").validate();
                    $("#spnmessage").hide("shake", {times: 6}, 3500);
                });
            </script>

            <script>
                $("#success_message_my").hide("bounce", 2000, 'fast');
                $("#submit").click(function () {
                    $('#search_body').html('<center><p><img style="width: 50;height: 50;" src="<?php echo base_url(); ?>assets/images/processing.gif" /></p><center>');

                });
            </script>

    </body>


</html>