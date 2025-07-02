<!DOCTYPE html>


<!--Description of Shift Allocation page

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
                            <li class="active"><a href="index.html">Short LEAVE ALLOCATION</a></li>

                        </ol>


                        <div class="page-tabs">
                            <ul class="nav nav-tabs">

                                <li class="active"><a data-toggle="tab" href="#tab1">Short LEAVE ALLOCATION</a></li>
                                <!--<li><a data-toggle="tab" href="#tab2">VIEW LEAVE TYPES</a></li>-->


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
                                                            <h2>LEAVE ALLOCATION</h2>
                                                        </div>
                                                        <div class="panel-body">
                                                            <form class="form-horizontal" id="frm_leave_allocatione" name="frm_leave_allocatione" action="<?php echo base_url(); ?>Leave_Transaction/Short_Leave_Allocation/insert_Data" method="POST">

                                                                <!--success Message-->
                                                                <?php if (isset($_SESSION['success_message']) && $_SESSION['success_message'] != '') { ?>
                                                                    <div id="spnmessage" class="alert alert-dismissable alert-success">
                                                                        <strong>Success !</strong> <?php echo $_SESSION['success_message'] ?>
                                                                    </div>
                                                                <?php } ?>

                                                                <!--Error Message-->
                                                                <?php if (isset($_SESSION['error_message']) && $_SESSION['error_message'] != '') { ?>
                                                                    <div id="spnmessage" class="alert alert-dismissable alert-danger">
                                                                        <strong>Error !</strong> <?php echo $_SESSION['error_message'] ?>
                                                                    </div>
                                                                <?php } ?>


                                                                <div class="form-group col-sm-12">
                                                                    <div class="col-sm-8">
                                                                        <img class="imagecss" src="<?php echo base_url(); ?>assets/images/leave_allocation.png">
                                                                    </div>
                                                                </div>


                                                                <div class="form-group col-sm-6">
                                                                    <label for="focusedinput" class="col-sm-4 control-label">Category</label>
                                                                    <div class="col-sm-8">
                                                                        <select class="form-control" required="" id="cmb_roster" name="cmb_roster">

                                                                            <option value="" default>-- Select --</option>
                                                                            <?php foreach ($data_roster as $t_data) { ?>
                                                                                <option value="<?php echo $t_data->RosterCode; ?>"><?php echo $t_data->RosterName; ?></option>

                                                                            <?php }
                                                                            ?>

                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                
                                                                <div class="form-group col-sm-6">
                                                                    <label for="focusedinput" class="col-sm-4 control-label">Leave Entitle</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" name="txt_entitle" id="txt_entitle">
                                                                    </div>

                                                                </div>

                                                                <div class="form-group col-sm-6">
                                                                    <label for="focusedinput" class="col-sm-4 control-label">Leave Year</label>
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




                                                                <hr>
                                                                <!--submit button-->
                                                                <?php $this->load->view('template/btn_submit.php'); ?>
                                                                <!--end submit-->
                                                            </form>

                                                            <hr>
                                                            <div id="divmessage" class="">

                                                                <div id="spnmessage"> </div>
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

    <?php $this->load->view('template/js.php'); ?> <!-- Initialize scripts for this page-->

    <!-- End loading page level scripts-->

    <!--Ajax-->
    <script src="<?php echo base_url(); ?>system_js/Master/L_Types.js"></script>



    <!-- Load page level scripts-->



    <script src="<?php echo base_url(); ?>assets/plugins/clockface/js/clockface.js"></script>

    <script src="<?php echo base_url(); ?>assets/plugins/form-colorpicker/js/bootstrap-colorpicker.min.js"></script> <!-- Color Picker -->

    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script> <!-- Datepicker -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-timepicker/bootstrap-timepicker.js"></script> <!-- Timepicker -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script> <!-- DateTime Picker -->
    <script src="<?php echo base_url(); ?>assets/plugins/form-daterangepicker/moment.min.js"></script> <!-- Moment.js for Date Range Picker -->
    <script src="<?php echo base_url(); ?>assets/plugins/form-daterangepicker/daterangepicker.js"></script> <!-- Date Range Picker -->

    <script src="<?php echo base_url(); ?>assets/demo/demo-pickers.js"></script>

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


    <!--JQuary Validation-->
    <script type="text/javascript">
        $(document).ready(function() {
            $("#frm_leave_allocatione").validate();
            $("#spnmessage").hide("shake", {
                times: 6
            }, 3000);
        });
    </script>


</body>


</html>