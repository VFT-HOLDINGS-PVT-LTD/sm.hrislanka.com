<!DOCTYPE html>


<!--Description of dashboard page

@author Ashan Rathsara-->


<html lang="en">

<title>
    <?php echo $title ?>
</title>

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
                            <!--<li class="active"><a href="<?php echo base_url(); ?>Master/Designation/">EMPLOYEE</a></li>-->

                        </ol>


                        <div class="page-tabs">
                            <ul class="nav nav-tabs">

                                <li class="active"><a data-toggle="tab" href="#tab1">MANUAL ATTENDANCE</a></li>
                                <li><a data-toggle="tab" href="#tab2">VIEW MANUAL ATTENDANCE</a></li>


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
                                                            <h2>MANUAL ATTENDANCE</h2>
                                                        </div>
                                                        <div class="panel-body">
                                                            <form class="form-horizontal" id="frm_employee_view"
                                                                name="frm_employee_view"
                                                                action="<?php echo base_url(); ?>Attendance/Attendance_Manual_Entry/emp_manual_entry"
                                                                method="POST">

                                                                <!--success Message-->
                                                                <?php if (isset($_SESSION['success_message']) && $_SESSION['success_message'] != '') { ?>
                                                                    <div id="spnmessage"
                                                                        class="alert alert-dismissable alert-success">
                                                                        <strong>Success !</strong>
                                                                        <?php echo $_SESSION['success_message'] ?>
                                                                    </div>
                                                                <?php } ?>


                                                                <div class="from-group col-md-12">
                                                                    <div class="form-group col-sm-3">
                                                                        <label for="focusedinput"
                                                                            class="col-sm-4 control-label">Emp
                                                                            No</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control"
                                                                                name="txt_emp" id="txt_emp"
                                                                                placeholder="Ex: 0001">
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group col-sm-3">
                                                                        <label for="focusedinput"
                                                                            class="col-sm-4 control-label">Emp
                                                                            Name</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control"
                                                                                name="txt_emp_name" id="txt_emp_name"
                                                                                placeholder="Ex: Ashan">
                                                                        </div>

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

                                                                <div class="from-group col-md-12">
                                                                    <div class="form-group col-sm-3">
                                                                        <label for="focusedinput"
                                                                            class="col-sm-4 control-label">Date</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control"
                                                                                required="" name="att_date"
                                                                                id="att_date"
                                                                                placeholder="Ex: Select Date">
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group col-sm-3">
                                                                        <label for="focusedinput"
                                                                            class="col-sm-4 control-label">
                                                                            Time</label>
                                                                        <div class="col-sm-8">
                                                                            <input type=time class="form-control"
                                                                                required="" name="in_time" id="in_time"
                                                                                placeholder="Ex: Select Date">
                                                                        </div>

                                                                    </div>
                                                                    <!-- <div class="form-group col-sm-3">
                                                                        <label for="focusedinput"
                                                                            class="col-sm-4 control-label">Out
                                                                            Time</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="time" class="form-control"
                                                                                required="" name="out_time"
                                                                                id="out_time"
                                                                                placeholder="Ex: Select Date">
                                                                        </div>

                                                                    </div> -->
                                                                </div>.
                                                                <div class="from-group col-md-12">
                                                                    <div class="form-group col-sm-3">
                                                                        <label for="focusedinput"
                                                                            class="col-sm-4 control-label">Reason</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control"
                                                                                required="" name="txt_reason"
                                                                                id="txt_reason"
                                                                                placeholder="Ex: Enter Reason">
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group col-sm-4">
                                                                        <label
                                                                            class="col-sm-4 control-label">Status</label>
                                                                        <div class="col-sm-8">
                                                                            <label class="radio-inline icheck">
                                                                                <input type="radio" id="inlineradio1"
                                                                                    required="" value="Active"
                                                                                    name="employee_status">Check In
                                                                            </label>
                                                                            <label class="radio-inline icheck">
                                                                                <input type="radio" id="inlineradio2"
                                                                                    value="Inactive" name="employee_status">
                                                                                Check Out
                                                                            </label>
                                                                        </div>

                                                                    </div>
                                                                </div>


                                                                <!--submit button-->
                                                                <?php $this->load->view('template/btn_submit.php'); ?>
                                                                <!--end submit-->


                                                            </form>



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
                                <div class="tab-pane" id="tab2">

                                    <div class="row">
                                        <div class="col-xs-12">


                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel panel-primary">
                                                        <div class="panel-heading">
                                                            <h2>ATTENDANCE DEVICE</h2>
                                                        </div>
                                                        <div class="panel-body panel-no-padding">
                                                            <table id="example"
                                                                class="table table-striped table-bordered"
                                                                cellspacing="0" width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ID</th>

                                                                        <th>EMP NO</th>
                                                                        <th>EMP Name</th>

                                                                        <th>DATE</th>
                                                                        <th>TIME</th>
                                                                        <th>CHECK IN / OUT</th>
                                                                        <th>REASON</th>
                                                                        <th>STATUS</th>


                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                     <?php
                                                                    foreach ($data_set_att as $data) {
                                                                        if ($data->Status == 0) {
                                                                            $dataV = "Check IN";
                                                                        }elseif ($data->Status == 1){
                                                                            $dataV = "Check OUT";
                                                                        }

                                                                        echo "<tr class='odd gradeX'>";

                                                                        echo "<td width='100'>" . $data->M_ID . "</td>";
                                                                        echo "<td width='100'>" . $data->EmpNo . "</td>";
                                                                        echo "<td width='100'>" . $data->Emp_Full_Name . "</td>";
                                                                        echo "<td width='100'>" . $data->Att_Date . "</td>";
                                                                        echo "<td width='100'>" . $data->In_Time . "</td>";
                                                                        echo "<td width='100'>" . $dataV . "</td>";
                                                                        echo "<td width='100'>" . $data->Reason . "</td>";
                                                                        if ($data->Is_Admin_App_ID == 0 && $data->Is_Cancel == 0) {
                                                                            echo "<td width='100'>" . "<span class='get_data label label-warning'>Pending &nbsp;<i class='fa fa-eye'></i> </span>" . "</td>";

                                                                            // echo "<td width='180'>" ;
                                                                            // echo "<a class='get_data btn btn-primary' href='" . base_url() . "Pay/Salary_Advance/approve/" . $data->id . "'>APPROVE<i class=''></i> </a> "; 
                                                                            // echo " <a class='get_data btn btn-warning' href='" . base_url() . "Pay/Salary_Advance/reject/" . $data->id . "'>REJECT<i class=''></i> </a>";
                                                                            // echo " <a class='get_data btn btn-danger' href='" . base_url() . "Pay/Salary_Advance/delete/" . $data->id . "'>Delete<i class=''></i> </a>";

                                                                            // echo "</td>";
                                                                        } else
                                                                        
                                                                        if ($data->Is_Admin_App_ID == 1) {
                                                                            echo "<td width='100'>" . "<span class='get_data label label-success'>Approve &nbsp;<i class='fa fa-eye'></i> </span>" . "</td>";
                                                                        }elseif ($data->Is_Cancel == 1 && $data->Is_Admin_App_ID == 0) {
                                                                            echo "<td width='100'>" . "<span class='get_data label label-danger'>Cancel &nbsp;<i class='fa fa-eye'></i> </span>" . "</td>";
                                                                        }
                                                                        echo "</tr>";
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                            <div class="panel-footer"></div>
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

        <!--Ajax-->
        <!--<script src="<?php echo base_url(); ?>system_js/Master/Designation.js"></script>-->


        <!--JQuary Validation-->
        <script type="text/javascript">
            $(document).ready(function () {
                $("#frm_employee_view").validate();
                $("#spnmessage").hide("shake", { times: 6 }, 3500);
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
                $('#att_date').datepicker(
                    {
                        "setDate": new Date(),
                        "autoclose": true,
                        "todayHighlight": true,
                        format: 'yyyy/mm/dd'
                    });

                $('#to_date').datepicker(
                    {
                        "setDate": new Date(),
                        "autoclose": true,
                        "todayHighlight": true,
                        format: 'yyyy/mm/dd'
                    });

            });
            $("#success_message_my").hide("bounce", 2000, 'fast');


            $("#search").click(function () {
                $('#search_body').html('<center><p><img style="width: 50;height: 50;" src="<?php echo base_url(); ?>assets/images/icon-loading.gif" /></p><center>');
                $('#search_body').load("<?php echo base_url(); ?>Attendance/Attendance_Manual_Entry/search_employee", { 'txt_emp': $('#txt_emp').val(), 'txt_emp_name': $('#txt_emp_name').val(), 'from_date': $('#from_date').val(), 'to_date': $('#to_date').val(), 'txt_nic': $('#txt_nic').val(), 'cmb_status': $('#cmb_status').val(), 'cmb_gender': $('#cmb_gender').val() });
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