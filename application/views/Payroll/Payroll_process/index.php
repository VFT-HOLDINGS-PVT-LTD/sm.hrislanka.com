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

                            <li class=""><a href="<?php echo base_url(); ?>Dashboard/">HOME</a></li>
                            <li class="active"><a href="#">PAYROLL PAYROLL</a></li>

                        </ol>


                        <div class="page-tabs">
                            <ul class="nav nav-tabs">

                                <li class="active"><a data-toggle="tab" href="#tab1">PAYROLL PAYROLL</a></li>


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
                                                        <div style="background: rgb(59,105,129);
                                                                 background: linear-gradient(60deg, rgba(59,105,129,1) 0%, rgba(54,120,150,0.644782913165266) 100%);" class="panel-heading">
                                                            <h2>PAYROLL PROCESS</h2>
                                                        </div>
                                                        <div class="panel-body">
                                                            <form action="<?php echo base_url(); ?>index.php/Pay/Payroll_Process/emp_payroll_process" class="form-horizontal" id="frm_Payroll_Process" name="frm_Payroll_Process" method="POST">

                                                                <!--success Message-->
                                                                <?php if (isset($_SESSION['success_message']) && $_SESSION['success_message'] != '') { ?>
                                                                    <div id="spnmessage" class="alert alert-dismissable alert-success">
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
                                                                        <img style="width: 150px; height: 150px; margin-left: 30%" style="width: 200px; margin-left: 20%;" src="<?php echo base_url(); ?>assets/images/payroll_p.jpg">
                                                                    </div>
                                                                </div>
                                                                <br><br><br><br><br><br><br><br>


                                                                 <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Year</label>
                                                                        <div class="col-sm-8">
                                                                            <select required="" class="form-control" id="cmb_year" name="cmb_year">
                                                                                <option value="" default>-- Select --</option>
                                                                                
                                                                                <option value="2023">2023</option>
                                                                                <option value="2024">2024</option>
                                                                                <option value="2025">2025</option>
                                                                                <option value="2026">2026</option>
                                                                                <option value="2027">2027</option>
                                                                                <option value="2028">2028</option>
                                                                                <option value="2029">2029</option>
                                                                                <option value="2030">2030</option>

                                                                            </select>
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Month</label>
                                                                        <div class="col-sm-8">
                                                                            <select required="" class="form-control" id="cmb_month" name="cmb_month">
                                                                                <option value="">--Select--</option>
                                                                                <option value="1">January</option>
                                                                                <option value="2">February</option>
                                                                                <option value="3">March</option>
                                                                                <option value="4">April</option>
                                                                                <option value="5">May</option>
                                                                                <option value="6">June</option>
                                                                                <option value="7">July</option>
                                                                                <option value="8">August</option>
                                                                                <option value="9">September</option>
                                                                                <option value="10">October</option>
                                                                                <option value="11">November</option>
                                                                                <option value="12">December</option>
                                                                            </select>
                                                                        </div>

                                                                    </div>


                                                                <br>
                                                                <!--submit button-->
                                                                <div class="row">
                                                                    <div class="col-sm-8 col-sm-offset-2">
                                                                        <button type="submit" id="submit" name="submit" class="btn-success btn-lg fa fa-money">&nbsp;&nbsp;PAYROLL PROCESS</button>
                                                                        <!--<button type="button" id="Cancel" name="Cancel" class="btn btn-danger-alt fa fa-times-circle">&nbsp;&nbsp;CANCEL</button>-->
                                                                    </div>
                                                                </div>
                                                                <!--end submit-->


                                                            </form>

                                                            <hr>




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

        <?php $this->load->view('template/js.php'); ?> <!-- Initialize scripts for this page-->

        <!-- End loading page level scripts-->



        <script src="<?php echo base_url(); ?>assets/plugins/form-jasnyupload/fileinput.min.js"></script> <!-- File Input -->

        <!--JQuary Validation-->
        <script type="text/javascript">
            $(document).ready(function() {
                $("#frm_Payroll_Process").validate();
                $("#spnmessage").hide(5500);
            });
        </script>
        <script>
            $('#dpd1').datepicker({
                format: "dd/mm/yyyy",
                "todayHighlight": true,
                autoclose: true,
                format: 'yyyy/mm/dd'
            }).on('changeDate', function(ev) {
                $(this).datepicker('hide');
            });
            $('#dpd2').datepicker({
                format: "dd/mm/yyyy",
                "todayHighlight": true,
                autoclose: true,
                format: 'yyyy/mm/dd'
            }).on('changeDate', function(ev) {
                $(this).datepicker('hide');
            });
        </script>

        <script>
            $("#success_message_my").hide("bounce", 2000, 'fast');


            $("#submit").click(function() {
                $('#search_body').html('<center><p><img style="width: 50;height: 50;" src="<?php echo base_url(); ?>assets/images/processing.gif" /></p><center>');

            });
        </script>


        <!--<script src="<?php echo base_url(); ?>system_js/Master/add_bank.js"></script>-->

</body>


</html>