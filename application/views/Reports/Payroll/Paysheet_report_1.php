<!DOCTYPE html>


<!--Description of dashboard page

@author Ashan Rathsara-->


<html lang="en">



    <head>
        <title><?php echo $title ?></title>
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

                                <li class=""><a href="">HOME</a></li>
                                <li class="active"><a href="">PAY SHEET REPORT</a></li>

                            </ol>

                            <div class="container-fluid">


                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">

                                        <div class="row">
                                            <div class="col-xs-12">


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-primary">
                                                            <div class="panel-heading"><h2>PAY SHEET REPORT</h2></div>

                                                            <div class="panel-body">
                                                                <div style="font-size: 15px; font-weight: bold;" class="bg-bright">REPORT BY CATEGORIES</div>
                                                                <form action="<?php echo base_url(); ?>Reports/Payroll/Paysheet/Pay_sheet_Report_By_Cat" class="form-horizontal" id="frm_in_out_rpt" name="frm_in_out_rpt" method="POST">




                                                                    <div class="form-group col-sm-12">
                                                                        <div class="col-sm-6">
                                                                            <img class="imagecss" src="<?php echo base_url(); ?>assets/images/paysheet.png" >
                                                                        </div>

                                                                    </div>


                                                                    <div class="form-group col-sm-3">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Year</label>
                                                                        <div class="col-sm-8">
                                                                            <select required="" class="form-control" id="cmb_year" name="cmb_year">
                                                                                <option value="" default>-- Select --</option>
                                                                                <option value="2016">2016</option>
                                                                                <option value="2017">2017</option>
                                                                                <option value="2016">2018</option>
                                                                                <option value="2017">2019</option>
                                                                                <option value="2016">2020</option>
                                                                                <option value="2017">2021</option>
                                                                                <option value="2016">2022</option>
                                                                                <option value="2017">2023</option>
                                                                                <option value="2016">2024</option>
                                                                                <option value="2017">2025</option>
                                                                                <option value="2016">2026</option>
                                                                                <option value="2017">2027</option>
                                                                                <option value="2016">2028</option>
                                                                                <option value="2017">2029</option>
                                                                                <option value="2016">2030</option>

                                                                            </select>
                                                                        </div>

                                                                    </div>

                                                                    <div class="form-group col-sm-3">
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



                                                                    <div class="form-group col-sm-3">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Branch</label>
                                                                        <div class="col-sm-8">
                                                                            <select class="form-control" id="cmb_branch" name="cmb_branch" >


                                                                                <option value="" default>-- Select --</option>
                                                                                <?php foreach ($data_branch as $t_data) { ?>
                                                                                    <option value="<?php echo $t_data->B_id; ?>" ><?php echo $t_data->B_name; ?></option>

                                                                                <?php }
                                                                                ?>

                                                                            </select>
                                                                        </div>

                                                                    </div>



                                                                    <div class="col-sm-6">
                                                                        <input  type="submit"  id="search" name="search" formtarget="_new" class="btn-green btn fa fa-check" value="&nbsp;&nbsp;VIEW&nbsp; REPORT" >
                                                                        <input type="button"  id="cancel" name="cancel" class="btn-danger-alt btn fa fa-check" value="&nbsp;&nbsp;CLEAR" >    
                                                                    </div>
                                                                </form>
                                                                <hr>


                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                </div> <!-- .container-fluid -->
                            </div>
                        </div>
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

        <!--Clear Text Boxes-->
        <script type="text/javascript">

            $("#cancel").click(function () {

                $("#txt_emp").val("");
                $("#txt_emp_name").val("");
                $("#cmb_desig").val("");
                $("#cmb_dep").val("");
                $("#cmb_comp").val("");
                $("#txt_nic").val("");
                $("#cmb_gender").val("");
                $("#cmb_status").val("");


            });
        </script>

        <!--Date Format-->
        <script>

            $('#dpd1').datepicker({
                format: "dd/mm/yyyy",
                "todayHighlight": true,
                autoclose: true,
                format: 'yyyy/mm/dd'
            }).on('changeDate', function (ev) {
                $(this).datepicker('hide');
            });
            $('#dpd2').datepicker({
                format: "dd/mm/yyyy",
                "todayHighlight": true,
                autoclose: true,
                format: 'yyyy/mm/dd'
            }).on('changeDate', function (ev) {
                $(this).datepicker('hide');
            });


        </script>

        <!--JQuary Validation-->
        <script type="text/javascript">
            $(document).ready(function () {
                $("#frm_in_out_rpt").validate();
                $("#spnmessage").hide("shake", {times: 4}, 1500);
            });
        </script>


        <!--Auto complete-->
        <script type="text/javascript">
            $(function () {
                $("#txt_emp_name").autocomplete({
                    source: "<?php echo base_url(); ?>Reports/Attendance/Report_Attendance_In_Out/get_auto_emp_name" // path to the get_birds method
                });
            });

            $(function () {
                $("#txt_emp").autocomplete({
                    source: "<?php echo base_url(); ?>Reports/Attendance/Report_Attendance_In_Out/get_auto_emp_no" // path to the get_birds method
                });
            });
        </script>





    </body>


</html>