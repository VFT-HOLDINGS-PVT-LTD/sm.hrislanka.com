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
                                <li class="active"><a href="">EMPLOYEE ALL REPORT</a></li>

                            </ol>

                            <div class="container-fluid">


                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">

                                        <div class="row">
                                            <div class="col-xs-12">


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-primary">
                                                            <div class="panel-heading"><h2>EMPLOYEE ALL REPORT</h2></div>

                                                            <div class="panel-body">
                                                                <div style="font-size: 15px; font-weight: bold;" class="bg-bright">REPORT BY CATEGORIES</div>
                                                                <form action="<?php echo base_url(); ?>Reports/Master/Employee_Report/Report_employee_all" class="form-horizontal" id="frm_in_out_rpt" name="frm_in_out_rpt" method="POST">




                                                                    <div class="form-group col-sm-12">
                                                                        <div class="col-sm-6">
                                                                            <img class="imagecss1" src="<?php echo base_url(); ?>assets/images/employee_all.png" >
                                                                        </div>

                                                                    </div>

                                                                    <div class="form-group col-md-12">
                                                                        
                                                                        
                                                                        <div class="form-group col-sm-3">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Designation</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" id="cmb_desig" name="cmb_desig" >


                                                                                    <option value="" default>-- Select --</option>
                                                                                    <?php foreach ($data_desig as $t_data) { ?>
                                                                                        <option value="<?php echo $t_data->Des_ID; ?>" ><?php echo $t_data->Desig_Name; ?></option>

                                                                                    <?php }
                                                                                    ?>

                                                                                </select>
                                                                            </div>

                                                                        </div>
                                                                        <div class="form-group col-sm-3">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Department</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" id="cmb_dep" name="cmb_dep" >


                                                                                    <option value="" default>-- Select --</option>
                                                                                    <?php foreach ($data_dep as $t_data) { ?>
                                                                                        <option value="<?php echo $t_data->Dep_ID; ?>" ><?php echo $t_data->Dep_Name; ?></option>

                                                                                    <?php }
                                                                                    ?>

                                                                                </select>
                                                                            </div>

                                                                        </div>
                                                                        <div class="form-group col-sm-3">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Company</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control"  id="cmb_comp" name="cmb_comp" >


                                                                                    <option value="" default>-- Select --</option>
                                                                                    <?php foreach ($data_cmp as $t_data) { ?>
                                                                                        <option value="<?php echo $t_data->Cmp_ID; ?>" ><?php echo $t_data->Company_Name; ?></option>

                                                                                    <?php }
                                                                                    ?>

                                                                                </select>
                                                                            </div>

                                                                        </div>
                                                                        
                                                                        <div class="form-group col-sm-3">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Status</label>
                                                                        <div class="col-sm-8">
                                                                            <select class="form-control"  id="cmb_status" name="cmb_status" >

                                                                                <option value="" default>-- Select --</option>
                                                                                <option value="1">Active</option>
                                                                                <option value="2">Inactive</option>

                                                                            </select>
                                                                        </div>

                                                                    </div>

                                                                    <div class="form-group col-sm-3">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Gender</label>
                                                                        <div class="col-sm-8">
                                                                            <select class="form-control"  id="cmb_gender" name="cmb_gender" >


                                                                                <option value="" default>-- Select --</option>
                                                                                <option value="Male">Male</option>
                                                                                <option value="Female">Female</option>

                                                                            </select>
                                                                        </div>

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