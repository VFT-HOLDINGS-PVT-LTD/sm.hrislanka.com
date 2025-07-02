<!DOCTYPE html>
<?php
$currentUser = $this->session->userdata('login_user');
?>


<!--Description of Shift Allocation page

@author Ashan Rathsara-->


<html lang="en">


    <head>
        <!-- Styles -->
        <?php $this->load->view('template/css.php'); ?>

    </head>

    <body class="infobar-offcanvas ">

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
                                <li class="active"><a href="index.html">MANUAL ENTRY APPROVE</a></li>

                            </ol>

                            <div class="container-fluid">


                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">

                                        <div class="row">
                                            <div class="col-xs-12">


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-info">
                                                            <div class="panel-heading"><h2>MANUAL ENTRY APPROVE</h2></div>
                                                            <div class="panel-body">
                                                                <form class="form-horizontal" id="frm_leave_request" name="frm_leave_request" action="" method="POST">

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

                                                                    <div class="form-group col-md-6">
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">From Date</label>
                                                                            <div class="col-sm-8">


                                                                                <input type="text" class="form-control" required="" id="dpd1" name="txt_from_date" placeholder="Select Date">


                                                                            </div>

                                                                        </div>

                                                                        <div class="form-group col-sm-6" style="">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">To Date</label>
                                                                            <div class="col-sm-8">


                                                                                <input type="text" class="form-control" required="" id="dpd2" name="txt_to_date" placeholder="Select Date">


                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                </form>
                                                                <div class="col-sm-6">
                                                                    <input  type="button"  id="search" name="search" class="btn-green btn fa fa-check" value="&nbsp;&nbsp;SEARCH&nbsp; EMPLOYEES" >
                                                                    <input type="button"  id="cancel" name="cancel" class="btn-danger-alt btn fa fa-check" value="&nbsp;&nbsp;CLEAR" >    
                                                                </div>

                                                               
                                                                <div id="divmessage" class="">

                                                                    <div id="spnmessage"> </div>
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

        <!--Ajax-->
        <!--<script src="<?php echo base_url(); ?>system_js/Master/L_Types.js"></script>-->



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

                var code = $('#cmb_cat').val();
//                alert(branch_code);

                $.post('<?php echo base_url(); ?>index.php/Leave_Transaction/Leave_Entry/dropdown/',
                        {
                            cmb_cat: code

                        },
                function (data)
                {
//                            alert(data);

//                            $('#cmb_cat2').remove();
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
                $('#search_body').load("<?php echo base_url(); ?>Attendance/Attendance_Manual_Entry_ADMIN/search_employee", {'txt_emp': $('#txt_emp').val(), 'txt_emp_name': $('#txt_emp_name').val(), 'cmb_desig': $('#cmb_desig').val(), 'cmb_dep': $('#cmb_dep').val(), 'txt_nic': $('#txt_nic').val(), 'cmb_status': $('#cmb_status').val(), 'cmb_gender': $('#cmb_gender').val(),'txt_from_date': $('#dpd1').val(),'txt_to_date': $('#dpd2').val()});
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
                $("#frm_leave_request").validate();
                $("#spnmessage").hide("shake", {times: 6}, 3500);
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