<!DOCTYPE html>
<?php
$currentUser = $this->session->userdata('login_user');
?>

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
                                <li class="active"><a data-toggle="tab" href="#tab1">SHORT LEAVE ENTRY</a></li>
                                <li><a data-toggle="tab" href="#tab2">VIEW SHORT LEAVE</a></li>
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
                                                            <h2>SHORT LEAVE ENTRY</h2>
                                                        </div>
                                                        <div class="panel-body">
                                                            <form class="form-horizontal" id="frm_employee_view"
                                                                name="frm_employee_view"
                                                                action="<?php echo base_url(); ?>Leave_Transaction/Short_Leave_Request/insert_Data"
                                                                method="POST">

                                                                <!--success Message-->
                                                                <?php if (isset($_SESSION['success_message']) && $_SESSION['success_message'] != '') { ?>
                                                                    <div id="spnmessage"
                                                                        class="alert alert-dismissable alert-success success_redirect">
                                                                        <strong>Success !</strong>
                                                                        <?php echo $_SESSION['success_message'] ?>
                                                                    </div>
                                                                <?php } ?>

                                                                <!--Error Message-->
                                                                <?php if (isset($_SESSION['error_message']) && $_SESSION['error_message'] != '') { ?>
                                                                    <div id="spnmessage"
                                                                        class="alert alert-dismissable alert-danger error_redirect">
                                                                        <strong>Error !</strong>
                                                                        <?php echo $_SESSION['error_message'] ?>
                                                                    </div>
                                                                <?php } ?>


                                                                <div class="from-group col-md-12">
                                                                    <div class="form-group col-sm-3">
                                                                    <label for="focusedinput" id="change" class="col-sm-4 control-label">Employee</label>
                                                                            <div class="col-sm-8" id="cat_div">
                                                                                <input type="text" class="form-control" readonly="" value="<?php echo "" . $currentUser[0]->Emp_Full_Name; ?>" required="required">
                                                                                <input type="text" class="form-control hidden" value="<?php echo "" . $currentUser[0]->EmpNo; ?>" required="required" id="txt_employee" name="txt_employee">
                                                                            </div>

                                                                    </div>
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
                                                                            class="col-sm-4 control-label">From</label>
                                                                        <div class="col-sm-8">
                                                                            <input type=time class="form-control"
                                                                                required="" name="in_time" id="in_time"
                                                                                placeholder="Ex: Select Date">
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group col-sm-3">
                                                                        <label for="focusedinput"
                                                                            class="col-sm-4 control-label">To</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="time" class="form-control"
                                                                                required="" name="out_time"
                                                                                id="out_time"
                                                                                placeholder="Ex: Select Date">
                                                                        </div>

                                                                    </div>
                                                                </div>.
                                                                <!-- <div class="from-group col-md-12">
                                                                        <div class="form-group col-sm-3">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Reason</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" required="" name="txt_reason" id="txt_reason" placeholder="Ex: Enter Reason">
                                                                            </div>

                                                                        </div>
                                                                    </div> -->


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

                                <div class="tab-pane" id="tab2">

                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel panel-primary">
                                                        <div class="panel-heading">
                                                            <h2>VIEW SHORT LEAVE</h2>
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
                                                                        <th>IN TIME</th>
                                                                        <th>OUT TIME</th>
                                                                        <th>STATUS</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    foreach ($data_set_att as $data) {


                                                                        echo "<tr class='odd gradeX'>";
                                                                        echo "<td width='100'>" . $data->ID . "</td>";
                                                                        echo "<td width='100'>" . $data->EmpNo . "</td>";
                                                                        echo "<td width='100'>" . $data->Emp_Full_Name . "</td>";
                                                                        echo "<td width='100'>" . $data->Date . "</td>";
                                                                        echo "<td width='100'>" . $data->from_time . "</td>";
                                                                        echo "<td width='100'>" . $data->to_time . "</td>";
                                                                        echo "<td width='100'>";
                                                                        if ($data->Is_pending) {
                                                                            echo "<span class='get_data label label-warning'>Pending &nbsp;<i class='fa fa-eye'></i> </span>";
                                                                        }elseif ($data->Is_Approve) {
                                                                            echo "<span class='get_data label label-success'>Approve &nbsp;<i class='fa fa-eye'></i> </span>";
                                                                        }elseif ($data->Is_Cancel) {
                                                                            echo "<span class='get_data label label-danger'>Cancel &nbsp;<i class='fa fa-eye'></i> </span>";
                                                                        }
                                                                        echo "</td>";
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
        
        <script>
        document.getElementById('out_time').addEventListener('change', function () {
            const inTime = document.getElementById('in_time').value;
            const outTime = document.getElementById('out_time').value;
    
            if (inTime && outTime) {
                // Convert the time to Date objects
                const inTimeDate = new Date(`1970-01-01T${inTime}:00`);
                const outTimeDate = new Date(`1970-01-01T${outTime}:00`);
    
                // Calculate the difference in milliseconds
                const timeDiff = outTimeDate - inTimeDate;
    
                // Convert milliseconds to hours
                const hoursDiff = timeDiff / (1000 * 60 * 60);
    
                // Check if the difference is more than 2 hours or negative (in_time > out_time)
                if (hoursDiff > 2 || hoursDiff < 0) {
                    alert("The 'To' time must be within 2 hours or less from the 'From' time.");
                    document.getElementById('out_time').value = ''; // Clear the "To" time input
                }
            }
        });
    </script>

</body>


</html>