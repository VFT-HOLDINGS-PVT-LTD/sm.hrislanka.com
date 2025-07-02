<!DOCTYPE html>


<!--Description of dashboard page

@author Ashan Rathsara-->


<html lang="en">

    <title><?php echo $title ?></title>

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
                                <li class="active"><a href="<?php echo base_url(); ?>Master/Designation/">EMPLOYEE</a></li>

                            </ol>


                            <!--                            <div class="page-tabs">
                                                            <ul class="nav nav-tabs">

                                                                <li class="active"><a data-toggle="tab" href="#tab1">EMPLOYEE</a></li>
                                                                <li><a data-toggle="tab" href="#tab2">VIEW EMPLOYEE</a></li>


                                                            </ul>
                                                        </div>-->
                            <div class="container-fluid">


                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">

                                        <div class="row">
                                            <div class="col-xs-12">


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-info">
                                                            <div class="panel-heading"><h2>VIEW EMPLOYEE</h2></div>
                                                            <div class="panel-body">
                                                                <form class="form-horizontal" id="frm_employee_view" name="frm_employee_view" action="" method="POST">

                                                                    <!--success Message-->
                                                                    <?php if (isset($_SESSION['success_message']) && $_SESSION['success_message'] != '') { ?>
                                                                        <div id="spnmessage" class="alert alert-dismissable alert-success">
                                                                            <strong>Success !</strong> <?php echo $_SESSION['success_message'] ?>
                                                                        </div>
                                                                    <?php } ?>



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
<!--                                                                    <div class="form-group col-sm-3">
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

                                                                    </div>-->
                                                                    
                                                                    
                                                                    <div class="form-group col-sm-3">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">From Date</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" required="" name="from_date" id="from_date" placeholder="Ex: Select Date">
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group col-sm-3">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">To Date</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" required="" name="to_date" id="to_date" placeholder="Ex: Select Date">
                                                                        </div>

                                                                    </div>





                                                                </form>


                                                                <input  type="submit"  id="search" name="search" class="btn-green btn fa fa-check" value="&nbsp;&nbsp;SEARCH&nbsp; EMPLOYEES" >
                                                                <input type="button"  id="cancel" name="cancel" class="btn-danger-alt btn fa fa-check" value="&nbsp;&nbsp;CLEAR" >    
                                                                <hr>

                                                                <div id="divmessage" class="">

                                                                    <div id="spnmessage"> </div>
                                                                </div>


                                                                <div id="search_body">

                                                                </div>


                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                    </div>


                                    <!--***************************-->


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

            <!--Ajax-->
            <!--<script src="<?php echo base_url(); ?>system_js/Master/Designation.js"></script>-->


            <!--JQuary Validation-->
            <script type="text/javascript">
                $(document).ready(function () {
                    $("#frm_employee_view").validate();
                    $("#spnmessage").hide("shake", {times: 4}, 1500);
                });
            </script>

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

            <script>

                $(function () {
                    $('#from_date').datepicker(
                            {"setDate": new Date(),
                                "autoclose": true,
                                "todayHighlight": true,
                                format: 'yyyy/mm/dd'});

                    $('#to_date').datepicker(
                            {"setDate": new Date(),
                                "autoclose": true,
                                "todayHighlight": true,
                                format: 'yyyy/mm/dd'});

                });
                $("#success_message_my").hide("bounce", 2000, 'fast');


                $("#search").click(function () {
                    $('#search_body').html('<center><p><img style="width: 50;height: 50;" src="<?php echo base_url(); ?>assets/images/icon-loading.gif" /></p><center>');
                    $('#search_body').load("<?php echo base_url(); ?>Attendance/Attendance_Manual_Entry/search_employee", {'txt_emp': $('#txt_emp').val(), 'txt_emp_name': $('#txt_emp_name').val(), 'from_date': $('#from_date').val(), 'to_date': $('#to_date').val(), 'txt_nic': $('#txt_nic').val(), 'cmb_status': $('#cmb_status').val(), 'cmb_gender': $('#cmb_gender').val()});
                });


            </script>

            <!--Auto complete-->
            <script type="text/javascript">
                $(function () {
                    $("#txt_emp_name").autocomplete({
                        source: "<?php echo base_url(); ?>Employee_Management/View_Employees/get_auto_emp_name" // path to the get_birds method
                    });
                });

                $(function () {
                    $("#txt_emp").autocomplete({
                        source: "<?php echo base_url(); ?>Employee_Management/View_Employees/get_auto_emp_no" // path to the get_birds method
                    });
                });
            </script>

    </body>


</html>