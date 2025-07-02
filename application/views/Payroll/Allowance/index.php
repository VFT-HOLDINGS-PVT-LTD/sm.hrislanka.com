<!DOCTYPE html>


<!--Description of dashboard page

@author Ashan Rathsara-->


<html lang="en">

<title><?php echo $title ?></title>

<head>
    <!-- Styles -->
    <?php $this->load->view('template/css.php'); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

</head>

<body class="infobar-offcanvas">

    <!--header-->

    <?php $this->load->view('template/header.php'); ?>

    <!--end header-->
    <style>
        /* Basic styles for visibility */
        .form-group {
            margin-bottom: 15px;
        }
    </style>
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
                            <li class="active"><a href="index.html">ALLOWANCES</a></li>

                        </ol>


                        <div class="page-tabs">
                            <ul class="nav nav-tabs">

                                <li class="active"><a data-toggle="tab" href="#tab1">ALLOWANCES</a></li>
                                <li><a data-toggle="tab" href="#tab2">EDIT ALLOWANCES</a></li>
                                <li><a data-toggle="tab" href="#tab3">EDIT FIXED ALLOWANCES</a></li>
                                <li><a data-toggle="tab" href="#tab4">ALLOWANCES HISTORY</a></li>


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
                                                        <div class="panel-heading">
                                                            <h2>ADD ALLOWANCES</h2>
                                                        </div>
                                                        <div class="panel-body">
                                                            <form class="form-horizontal" id="frm_variable_allowances" name="frm_variable_allowances" action="<?php echo base_url(); ?>Pay/Allowance/insert_data" method="POST">

                                                                <!--success Message-->
                                                                <?php if (isset($_SESSION['success_message']) && $_SESSION['success_message'] != '') {?>
                                                                    <div id="spnmessage" class="alert alert-dismissable alert-success success_redirect">
                                                                        <strong>Success !</strong>                                                                                                   <?php echo $_SESSION['success_message'] ?>
                                                                    </div>
                                                                <?php }?>

                                                                <!--Error Message-->
                                                                <?php if (isset($_SESSION['error_message']) && $_SESSION['error_message'] != '') {?>
                                                                    <div id="spnmessage" class="alert alert-dismissable alert-danger error_redirect">
                                                                        <strong>Error !</strong>                                                                                                 <?php echo $_SESSION['error_message'] ?>
                                                                    </div>
                                                                <?php }?>

                                                                <div class="form-group col-sm-12">
                                                                    <div class="col-sm-8">
                                                                        <img style="margin-left: 30%; width: 100px; height: 100px;" src="<?php echo base_url(); ?>assets/images/allowance.png">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-sm-6">
                                                                    <label for="focusedinput" class="col-sm-4 control-label">Category</label>
                                                                    <div class="col-sm-8">
                                                                        <select class="form-control" required="" id="cmb_cat" name="cmb_cat" onchange="selctcity()">


                                                                            <option value="" default>-- Select --</option>
                                                                            <option value="Employee">Employee</option>
                                                                            <option value="Department">Department</option>
                                                                            <option value="Designation">Designation</option>
                                                                            <option value="Employee_Group">Employee_Group</option>
                                                                            <option value="Company">Company</option>

                                                                        </select>
                                                                    </div>

                                                                </div>

                                                                <div id="dynamic-fields"></div>

                                                                <!-- <div class="form-group col-sm-6">
                                                                    <label for="focusedinput" id="change" class="col-sm-4 control-label"></label>
                                                                    <div class="col-sm-8" id="cat_div">
                                                                        <select class="form-control" required="" id="cmb_cat2" name="cmb_cat2">

                                                                        </select>
                                                                    </div>

                                                                </div> -->

                                                                <div class="form-group col-sm-6">
                                                                    <label for="focusedinput" class="col-sm-4 control-label">Allowance Type</label>
                                                                    <div class="col-sm-8">
                                                                        <select class="form-control" required="" id="cmb_allowance" name="cmb_allowance">


                                                                            <option value="" default>-- Select --</option>
                                                                            <?php foreach ($data_alw as $t_data) {?>
                                                                                <option value="<?php echo $t_data->Alw_ID; ?>"><?php echo $t_data->Allowance_name; ?></option>

                                                                            <?php }
                                                                            ?>

                                                                        </select>
                                                                    </div>

                                                                </div>


                                                                <div class="form-group col-sm-6">
                                                                    <label for="focusedinput" class="col-sm-4 control-label">Amount</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="number" class="form-control" required="required" id="txt_amount" name="txt_amount" placeholder="Ex: 1500">
                                                                    </div>
                                                                </div>




                                                                <!--                                                                    <div class="form-group col-sm-6">
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

                                                                    </div>-->



                                                                <div class="form-group col-sm-6" id="monthDiv">
                                                                    <label for="focusedinput" class="col-sm-4 control-label">Month</label>
                                                                    <div class="col-sm-8">
                                                                        <select  class="form-control" id="cmb_month" name="cmb_month">
                                                                            <option value="" default>--Select Month--</option>
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

                                                                <div class="form-group col-sm-6 icheck-flat">
                                                                    <label class="col-sm-4 control-label"></label>
                                                                    <div class="col-sm-8 icheck-flat">
                                                                        <label class="checkbox green icheck1 col-sm-5">
                                                                            <input type="checkbox" id="isFixed" name="isFixed" value="1"> IS FIXED
                                                                        </label>
                                                                    </div>
                                                                </div>





                                                                <!--submit button-->
                                                                <?php $this->load->view('template/btn_submit.php'); ?>
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
                                <div class="tab-pane" id="tab2">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    <h2>EDIT ALLOWANCES</h2>
                                                </div>
                                                <div class="panel-body">

                                                    <form class="form-horizontal" id="frm_in_out_rpt" name="frm_in_out_rpt" method="POST">


                                                        <div class="form-group col-md-12">
                                                            <div class="form-group col-sm-3">
                                                                <label for="focusedinput" class="col-sm-4 control-label">Emp No</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" name="txt_emp" id="txt_emp" placeholder="Ex: 0001">
                                                                </div>

                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <label for="focusedinput" class="col-sm-4 control-label">Emp Name</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" name="txt_emp_name" id="txt_emp_name" placeholder="Ex: Ashan">
                                                                </div>

                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <label for="focusedinput" class="col-sm-4 control-label">Designation</label>
                                                                <div class="col-sm-8">
                                                                    <select class="form-control" id="cmb_desig" name="cmb_desig">

                                                                        <option value="" default>-- Select --</option>
                                                                        <?php foreach ($data_desig as $t_data) {?>
                                                                            <option value="<?php echo $t_data->Des_ID; ?>"><?php echo $t_data->Desig_Name; ?></option>

                                                                        <?php }
                                                                        ?>

                                                                    </select>
                                                                </div>

                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <label for="focusedinput" class="col-sm-4 control-label">Department</label>
                                                                <div class="col-sm-8">
                                                                    <select class="form-control" id="cmb_dep" name="cmb_dep">


                                                                        <option value="" default>-- Select --</option>
                                                                        <?php foreach ($data_dep as $t_data) {?>
                                                                            <option value="<?php echo $t_data->Dep_ID; ?>"><?php echo $t_data->Dep_Name; ?></option>

                                                                        <?php }
                                                                        ?>

                                                                    </select>
                                                                </div>

                                                            </div>


                                                        </div>

                                                        <div class="form-group col-md-12">

                                                            <div class="form-group col-sm-3">
                                                                <label for="focusedinput" class="col-sm-4 control-label">Company</label>
                                                                <div class="col-sm-8">
                                                                    <select class="form-control" id="cmb_comp" name="cmb_comp">


                                                                        <option value="" default>-- Select --</option>
                                                                        <?php foreach ($data_cmp as $t_data) {?>
                                                                            <option value="<?php echo $t_data->Cmp_ID; ?>"><?php echo $t_data->Company_Name; ?></option>

                                                                        <?php }
                                                                        ?>

                                                                    </select>
                                                                </div>

                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <label for="focusedinput" class="col-sm-4 control-label">Year</label>
                                                                <div class="col-sm-8">
                                                                    <select required="" class="form-control" id="cmb_years" name="cmb_years">
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


                                                            <div class="form-group col-sm-3">
                                                                <label for="focusedinput" class="col-sm-4 control-label">Month</label>
                                                                <div class="col-sm-8">
                                                                    <select class="form-control" id="cmb_month1" name="cmb_month1">
                                                                    <option value="" default>--Select Month--</option>
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
                                                                    <label for="focusedinput" class="col-sm-4 control-label">Allowance Type</label>
                                                                    <div class="col-sm-8">
                                                                        <select class="form-control" required="" id="cmb_allowances" name="cmb_allowances">


                                                                            <option value="" default>-- Select --</option>
                                                                            <?php foreach ($data_alw as $t_data) {?>
                                                                                <option value="<?php echo $t_data->Alw_ID; ?>"><?php echo $t_data->Allowance_name; ?></option>

                                                                            <?php }
                                                                            ?>

                                                                        </select>
                                                                    </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-sm-6">
                                                            <input type="button" id="search" name="search" class="btn-green btn fa fa-check" value="&nbsp;&nbsp;VIEW&nbsp; REPORT">
                                                            <input type="button" id="cancel" name="cancel" class="btn-danger-alt btn fa fa-check" value="&nbsp;&nbsp;CLEAR">
                                                        </div>
                                                    </form>
                                                    <hr>


                                                </div>
                                                <div id="search_body">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane" id="tab3">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    <h2>EDIT FIXED ALLOWANCES</h2>
                                                </div>
                                                <div class="panel-body">

                                                    <form class="form-horizontal" id="frm_in_out_rpt" name="frm_in_out_rpt" method="POST">


                                                        <div class="form-group col-md-12">
                                                            <div class="form-group col-sm-3">
                                                                <label for="focusedinput" class="col-sm-4 control-label">Emp No</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" name="txt_emp2" id="txt_emp2" placeholder="Ex: 0001">
                                                                </div>

                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <label for="focusedinput" class="col-sm-4 control-label">Emp Name</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" name="txt_emp_name2" id="txt_emp_name2" placeholder="Ex: Ashan">
                                                                </div>

                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <label for="focusedinput" class="col-sm-4 control-label">Designation</label>
                                                                <div class="col-sm-8">
                                                                    <select class="form-control" id="cmb_desig2" name="cmb_desig2">

                                                                        <option value="" default>-- Select --</option>
                                                                        <?php foreach ($data_desig as $t_data) {?>
                                                                            <option value="<?php echo $t_data->Des_ID; ?>"><?php echo $t_data->Desig_Name; ?></option>

                                                                        <?php }
                                                                        ?>

                                                                    </select>
                                                                </div>

                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <label for="focusedinput" class="col-sm-4 control-label">Department</label>
                                                                <div class="col-sm-8">
                                                                    <select class="form-control" id="cmb_dep2" name="cmb_dep2">


                                                                        <option value="" default>-- Select --</option>
                                                                        <?php foreach ($data_dep as $t_data) {?>
                                                                            <option value="<?php echo $t_data->Dep_ID; ?>"><?php echo $t_data->Dep_Name; ?></option>

                                                                        <?php }
                                                                        ?>

                                                                    </select>
                                                                </div>

                                                            </div>


                                                        </div>

                                                        <div class="form-group col-md-12">

                                                            <div class="form-group col-sm-3">
                                                                <label for="focusedinput" class="col-sm-4 control-label">Company</label>
                                                                <div class="col-sm-8">
                                                                    <select class="form-control" id="cmb_comp2" name="cmb_comp2">


                                                                        <option value="" default>-- Select --</option>
                                                                        <?php foreach ($data_cmp as $t_data) {?>
                                                                            <option value="<?php echo $t_data->Cmp_ID; ?>"><?php echo $t_data->Company_Name; ?></option>

                                                                        <?php }
                                                                        ?>

                                                                    </select>
                                                                </div>

                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                    <label for="focusedinput" class="col-sm-4 control-label">Allowance Type</label>
                                                                    <div class="col-sm-8">
                                                                        <select class="form-control" required="" id="cmb_fixedallowance2" name="cmb_fixedallowance2">


                                                                            <option value="" default>-- Select --</option>
                                                                            <?php foreach ($data_alw as $t_data) {?>
                                                                                <option value="<?php echo $t_data->Alw_ID; ?>"><?php echo $t_data->Allowance_name; ?></option>

                                                                            <?php }
                                                                            ?>

                                                                        </select>
                                                                    </div>

                                                            </div>




                                                        </div>

                                                        <div class="col-sm-6">
                                                            <input type="button" id="search2" name="search2" class="btn-green btn fa fa-check" value="&nbsp;&nbsp;VIEW&nbsp; REPORT">
                                                            <input type="button" id="cancel2" name="cancel2" class="btn-danger-alt btn fa fa-check" value="&nbsp;&nbsp;CLEAR">
                                                        </div>
                                                    </form>
                                                    <hr>


                                                </div>
                                                <!-- <div id="search_body">

                                                </div> -->
                                                <div id="search_body2">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane" id="tab4">

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2>ALLOWANCES HISTORY</h2>
            </div>
            <div class="panel-body">

                <form class="form-horizontal" id="frm_in_out_rpt" name="frm_in_out_rpt" method="POST">


                    <div class="form-group col-md-12">
                        <div class="form-group col-sm-3">
                            <label for="focusedinput" class="col-sm-4 control-label">Emp No</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="txt_emp3" id="txt_emp3" placeholder="Ex: 0001">

                            </div>

                        </div>

                        <div class="form-group col-sm-3">
                                <label for="focusedinput" class="col-sm-4 control-label">Allowance Type</label>
                                <div class="col-sm-8">
                                    <select class="form-control" required="" id="cmb_fixedallowance3" name="cmb_fixedallowance3">


                                        <option value="" default>-- Select --</option>
                                        <?php foreach ($data_alw as $t_data) {?>
                                            <option value="<?php echo $t_data->Alw_ID; ?>"><?php echo $t_data->Allowance_name; ?></option>

                                        <?php }
                                        ?>

                                    </select>
                                </div>

                        </div>

                        <div class="form-group col-sm-6">
                                <label for="focusedinput" class="col-sm-4 control-label">Allowance Status <span style="color: red;">*</span></label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="cmb_allowancestatus3" name="cmb_allowancestatus3" required="required">


                                        <option value="" default>-- Select --</option>
                                        <option value="varialble_allowance">Varialble Allowance</option>
                                        <option value="fixed_allowance">Fixed Allowance</option>

                                    </select>
                                </div>

                        </div>

                    </div>


                    <div class="col-sm-6">
                        <input type="button" id="search3" name="search3" class="btn-green btn fa fa-check" value="&nbsp;&nbsp;VIEW&nbsp; REPORT">
                        <input type="button" id="cancel3" name="cancel3" class="btn-danger-alt btn fa fa-check" value="&nbsp;&nbsp;CLEAR">
                    </div>
                </form>
                <hr>


            </div>
            <!-- <div id="search_body">

            </div> -->
            <div id="search_body3">

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

        <?php $this->load->view('template/js.php'); ?>

        <!-- End loading page level scripts-->

        <script src="<?php echo base_url(); ?>system_js/Payroll/allowance.js" type="text/javascript"></script>
        <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
        <!--Dropdown selected text into label-->
        <script type="text/javascript">
            $(function() {
                $("#cmb_cat").on("change", function() {
                    $("#change").text($("#cmb_cat").find(":selected").text());
                }).trigger("change");
            });
        </script>

        <script>
            function selctcity() {

                var branch_code = $('#cmb_cat').val();
                //                alert(branch_code);

                $.post('<?php echo base_url(); ?>index.php/Pay/Allowance/dropdown/', {
                        cmb_cat: branch_code



                    },
                    function(data) {
                        //                            alert(data);

                        //                            $('#cmb_cat2').remove();
                        $('#cmb_cat2').html(data);
                    });

            }
        </script>

        <!--Date Format-->
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

        <!--JQuary Validation-->
        <script type="text/javascript">
            $(document).ready(function() {
                $("#frm_variable_allowances").validate();
                $("#spnmessage").hide("shake", {
                    times: 6
                }, 3000);
            });
        </script>


        <!--Auto complete-->
        <script type="text/javascript">
            $(function() {
                $("#txt_emp_name").autocomplete({
                    source: "<?php echo base_url(); ?>Reports/Attendance/Report_Attendance_In_Out/get_auto_emp_name"
                });
            });

            $(function() {
                $("#txt_emp").autocomplete({
                    source: "<?php echo base_url(); ?>Reports/Attendance/Report_Attendance_In_Out/get_auto_emp_no"
                });
            });

            // $(function() {
            //     $("#txt_emp3").autocomplete({
            //         source: "<?php echo base_url(); ?>Reports/Attendance/Report_Attendance_In_Out/get_auto_emp_no"
            //     });
            // });

            // $(function() {
            //     $("#txt_emp_name2").autocomplete({
            //         source: "<?php echo base_url(); ?>Reports/Attendance/Report_Attendance_In_Out/get_auto_emp_name"
            //     });
            // });

            // $(function() {
            //     $("#txt_emp2").autocomplete({
            //         source: "<?php echo base_url(); ?>Reports/Attendance/Report_Attendance_In_Out/get_auto_emp_no"
            //     });
            // });
        </script>


        <script>
            $(function() {
                $('#from_date').datepicker({
                    "setDate": new Date(),
                    "autoclose": true,
                    "todayHighlight": true,
                    format: 'yyyy/mm/dd'
                });


                $('#to_date').datepicker({
                    "setDate": new Date(),
                    "autoclose": true,
                    "todayHighlight": true,
                    format: 'yyyy/mm/dd'
                });

            });
            $("#success_message_my").hide("bounce", 2000, 'fast');


            $("#search").click(function() {
                $('#search_body').html('<center><p><img style="width: 50;height: 50;" src="<?php echo base_url(); ?>assets/images/icon-loading.gif" /></p><center>');
                $('#search_body').load("<?php echo base_url(); ?>Pay/Allowance/getAllowances", {
                    'txt_emp': $('#txt_emp').val(),
                    'txt_emp_name': $('#txt_emp_name').val(),
                    'cmb_desig': $('#cmb_desig').val(),
                    'cmb_dep': $('#cmb_dep').val(),
                    'cmb_month1': $('#cmb_month1').val(),
                    'cmb_years': $('#cmb_years').val(),
                    'cmb_allowances': $('#cmb_allowances').val()
                });
            });

            $("#search2").click(function() {
                $('#search_body2').html('<center><p><img style="width: 50;height: 50;" src="<?php echo base_url(); ?>assets/images/icon-loading.gif" /></p><center>');
                $('#search_body2').load("<?php echo base_url(); ?>Pay/Allowance/getFixAllowances", {
                    'txt_emp2': $('#txt_emp2').val(),
                    'txt_emp_name2': $('#txt_emp_name2').val(),
                    'cmb_desig2': $('#cmb_desig2').val(),
                    'cmb_dep2': $('#cmb_dep2').val(),
                    'cmb_fixedallowance2': $('#cmb_fixedallowance2').val()
                });
            });

            $("#search3").click(function() {
                // alert("OK");
                $('#search_body3').html('<center><p><img style="width: 50;height: 50;" src="<?php echo base_url(); ?>assets/images/icon-loading.gif" /></p><center>');
                $('#search_body3').load("<?php echo base_url(); ?>Pay/Allowance/getHistoryAllowances", {
                    'txt_emp3': $('#txt_emp3').val(),
                    // 'txt_emp_name3': $('#txt_emp_name3').val(),
                    // 'cmb_desig3': $('#cmb_desig3').val(),
                    // 'cmb_dep3': $('#cmb_dep3').val(),
                    'cmb_fixedallowance3': $('#cmb_fixedallowance3').val(),
                    'cmb_allowancestatus3': $('#cmb_allowancestatus3').val()

                });
            });
        </script>

        <!--Clear Text Boxes-->
        <script type="text/javascript">
            $("#cancel").click(function() {

                $("#txt_emp").val("");
                $("#txt_emp_name").val("");
                $("#cmb_desig").val("");
                $("#cmb_dep").val("");
                $("#cmb_comp").val("");
                $("#cmb_month").val("");
                $("#cmb_allowances").val("");
                $("#cmb_status").val("");


            });

            $("#cancel2").click(function() {

                $("#txt_emp2").val("");
                $("#txt_emp_name2").val("");
                $("#cmb_desig2").val("");
                $("#cmb_dep2").val("");
                $("#cmb_comp2").val("");
                $("#cmb_month2").val("");
                $("#cmb_allowances2").val("");
                $("#cmb_status2").val("");


            });


            $("#cancel3").click(function() {

$("#txt_emp3").val("");
$("#cmb_allowances3").val("");
$("#cmb_allowancestatus3").val("");


});
        </script>

        <script>
            $(document).ready(function() {
                var $checkbox = $('#isFixed');
                var $monthDiv = $('#monthDiv');

                function updateVisibility() {
                    if ($checkbox.is(':checked')) {
                        $monthDiv.hide();
                        console

                    } else {
                        $monthDiv.show();
                    }
                }


                updateVisibility();


                $checkbox.change(updateVisibility);
            });
        </script>

        <!--Ajax-->
    <script src="<?php echo base_url(); ?>system_js/Master/L_Types.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.itemName').select2({
                placeholder: '--- Find ---',
                ajax: {
                    url: "<?php echo base_url(); ?>Leave_Transaction/Leave_Entry/search",
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });

            $('#txt_nic').on('change', function() {
                var empNo = $(this).val();
                if (empNo) {
                    $.ajax({
                        url: '<?php echo base_url(); ?>Leave_Transaction/Leave_Entry/get_mem_data/' + empNo,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            if (data.length > 0) {
                                $('#txt_emp_name').val(data[0].Emp_Full_Name);
                            }
                        }
                    });
                }
            });

            $('#cmb_cat').on('change', function() {
                var selectedValue = $(this).val();
                var dynamicFields = $('#dynamic-fields');
                dynamicFields.empty();

                if (selectedValue === 'Employee') {
                    dynamicFields.html(`
                        <div class="form-group col-sm-6">
                            <label for="" class="col-sm-4 control-label">Emp Number</label>
                            <div class="col-sm-8">
                                <select type="text" required="required" autocomplete="off" class="form-control txt_nic itemName" name="txt_nic" id="txt_nic" placeholder="">
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="txt_emp_name" class="col-sm-4 control-label">Selected Emp Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="txt_emp_name" name="txt_emp_name" placeholder="Selected Emp Name" readonly>
                            </div>
                        </div>
                    `);

                    $('.itemName').select2({
                        placeholder: '--- Find ---',
                        ajax: {
                            url: "<?php echo base_url(); ?>Leave_Transaction/Leave_Entry/search",
                            dataType: 'json',
                            delay: 250,
                            processResults: function(data) {
                                return {
                                    results: data
                                };
                            },
                            cache: true
                        }
                    });

                    $('#txt_nic').on('change', function() {
                        var empNo = $(this).val();
                        if (empNo) {
                            $.ajax({
                                url: '<?php echo base_url(); ?>Leave_Transaction/Leave_Entry/get_mem_data/' + empNo,
                                type: "GET",
                                dataType: "json",
                                success: function(data) {
                                    if (data.length > 0) {
                                        $('#txt_emp_name').val(data[0].Emp_Full_Name);
                                    }
                                }
                            });
                        }
                    });
                } else {
                    dynamicFields.html(`
                        <div class="form-group col-sm-6">
                            <label for="" class="col-sm-4 control-label">Select</label>
                            <div class="col-sm-8" id="cat_div">
                                <select class="form-control" required id="cmb_cat2" name="cmb_cat2">
                                </select>
                            </div>
                        </div>
                    `);

                    $.post('<?php echo base_url(); ?>index.php/Pay/Allowance/dropdown/', { cmb_cat: selectedValue }, function(data) {
                        $('#cmb_cat2').html(data);
                    });
                }
            });

            $("#cmb_cat").trigger("change");
        });
    </script>


</html>


</body>


</html>