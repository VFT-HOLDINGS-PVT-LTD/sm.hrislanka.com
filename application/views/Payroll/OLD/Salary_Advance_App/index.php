<!DOCTYPE html>


<!--Description of dashboard page

@author Ashan Rathsara-->


<html lang="en">

    <title><?php echo $title ?></title>

    <head>
        <!-- Styles -->
        <?php $this->load->view('template/css.php');?>


    </head>

    <body class="infobar-offcanvas">

        <!--header-->

        <?php $this->load->view('template/header.php');?>

        <!--end header-->

        <div id="wrapper">
            <div id="layout-static">

                <!--dashboard side-->

                <?php $this->load->view('template/dashboard_side.php');?>

                <!--dashboard side end-->

                <div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">

                                <li class=""><a href="index.html">HOME</a></li>
                                <li class="active"><a href="index.html">SALARY ADVANCE APPROVE</a></li>

                            </ol>


                            <div class="page-tabs">
                                <ul class="nav nav-tabs">

                                    <li class="active"><a data-toggle="tab" href="#tab1">SALARY ADVANCE APPROVE</a></li>
                                    <!--<li><a data-toggle="tab" href="#tab2">VIEW SALARY ADVANCE</a></li>-->

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
                                                            <div class="panel-heading"><h2>VIEW SALARY ADVANCE</h2></div>
                                                            <div class="panel-body">

                                                            <div class="panel panel-primary">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-body panel-no-padding">
                                                                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>ID</th>
                                                                                    <th>EMP NO</th>
                                                                                    <th>NAME</th>

                                                                                    <th>YEAR</th>
                                                                                    <th>MONTH</th>
                                                                                    <th>AMOUNT</th>
                                                                                    <th>REQUEST DATE</th>
                                                                                    <th>STATUS</th>
                                                                                    <?php
                                                                                    // foreach ($data_set as $data) {
                                                                                        // if ($data->Is_pending == 1) {
                                                                                            // ?>
                                                                                        <!-- <th>APPROVE</th> -->
                                                                                        <!-- <th>REJECT</th> -->
                                                                                    <?php
                                                                                    // } elseif ($data->Is_Approve == 1) {
                                                                                        ?>
                                                                                    <?php
                                                                                    // } elseif ($data->Is_Cancel == 1) {
                                                                                        ?>
                                                                                    <?php
                                                                                    // }
                                                                                    // }
                                                                                    ?>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <?php
                                                                            foreach ($data_set as $data) {

                                                                                echo "<tr class='odd gradeX'>";
                                                                                echo "<td width='100'>" . $data->id . "</td>";
                                                                                echo "<td width='100'>" . $data->EmpNo . "</td>";
                                                                                echo "<td width='100'>" . $data->Emp_Full_Name . "</td>";

                                                                                echo "<td width='100'>" . $data->Year . "</td>";
                                                                                echo "<td width='100'>" . $data->Month . "</td>";
                                                                                echo "<td width='100'> Rs." . $data->Amount . ".00</td>";
                                                                                echo "<td width='100'>" . $data->Request_Date . "</td>";
                                                                                // echo "<td width='100'>" . $data->Is_Approve . "</td>";

                                                                                if ($data->Is_pending == 1) {
                                                                                    echo "<td width='100'>" . "<span class='get_data label label-warning'>Pending &nbsp;<i class='fa fa-eye'></i> </span>" . "</td>";

                                                                                    // echo "<td width='180'>" ;
                                                                                    // echo "<a class='get_data btn btn-primary' href='" . base_url() . "Pay/Salary_Advance/approve/" . $data->id . "'>APPROVE<i class=''></i> </a> "; 
                                                                                    // echo " <a class='get_data btn btn-warning' href='" . base_url() . "Pay/Salary_Advance/reject/" . $data->id . "'>REJECT<i class=''></i> </a>";
                                                                                    // echo " <a class='get_data btn btn-danger' href='" . base_url() . "Pay/Salary_Advance/delete/" . $data->id . "'>Delete<i class=''></i> </a>";

                                                                                    // echo "</td>";
                                                                                } elseif ($data->Is_Approve == 1) {
                                                                                    echo "<td width='100'>" . "<span class='get_data label label-success'>Approve &nbsp;<i class='fa fa-eye'></i> </span>" . "</td>";
                                                                                }elseif ($data->Is_Cancel == 1) {
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
                                                            <div id="search_body">

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
                        <?php $this->load->view('template/footer.php');?>
                        <!--End Footer-->
                    </div>
                </div>
            </div>







            <!-- Load site level scripts -->

            <?php $this->load->view('template/js.php');?>							<!-- Initialize scripts for this page-->

            <!-- End loading page level scripts-->

            <script src="<?php echo base_url(); ?>system_js/Payroll/loan_entry.js"></script>

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



            </script>

            <!--JQuary Validation-->
            <script type="text/javascript">
                $(document).ready(function () {
                    $("#frm_salary_advance").validate();
                    $("#spnmessage").hide("shake", {times: 6}, 3500);
                });
            </script>

            <!--Dropdown selected text into label-->
            <script type="text/javascript">
                $(function () {
                    $("#cmb_cat").on("change", function () {
                        $("#change").text($("#cmb_cat").find(":selected").text());
                    }).trigger("change");
                });
            </script>


            <script>
                function selctcity()
                {

                    var branch_code = $('#cmb_cat').val();
//                alert(branch_code);

                    $.post('<?php echo base_url(); ?>index.php/Pay/Deduction/dropdown/',
                            {
                                cmb_cat: branch_code



                            },
                            function (data)
                            {

                                $('#cmb_cat2').html(data);
                            });

                }

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
                    $('#search_body').load("<?php echo base_url(); ?>Pay/Salary_Advance/getSal_Advance", {'txt_emp': $('#txt_emp').val(), 'txt_emp_name': $('#txt_emp_name').val(), 'cmb_desig': $('#cmb_desig').val(), 'cmb_dep': $('#cmb_dep').val(), 'cmb_loan_type': $('#cmb_loan_type').val(), 'cmb_years': $('#cmb_years').val(), 'cmb_months': $('#cmb_months').val()});
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

    </body>


</html>