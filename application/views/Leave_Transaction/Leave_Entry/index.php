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
                                <li class="active"><a href="index.html">LEAVE ENTRY</a></li>

                            </ol>


                            <div class="page-tabs">
                                <ul class="nav nav-tabs">

                                    <li class="active"><a data-toggle="tab" href="#tab1">LEAVE ENTRY</a></li>
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
                                                            <div class="panel-heading"><h2>LEAVE ENTRY</h2></div>
                                                            <div class="panel-body">
                                                                <form class="form-horizontal" id="frm_leave_entry" name="frm_leave_entry" action="<?php echo base_url(); ?>Leave_Transaction/Leave_Entry/insert_Data" method="POST">


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

                                                                    <div class="form-group col-sm-12">
                                                                        <div class="col-sm-8">
                                                                            <img class="imagecss" src="<?php echo base_url(); ?>assets/images/leave_entry.png" >
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Category</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" required="" id="cmb_cat" name="cmb_cat" onchange="selctcity()">


                                                                                    <option value="" default>-- Select --</option>
                                                                                    <option value="Employee">Employee</option>
                                                                                    <!--                                                                                <option value="Department">Department</option>
                                                                                                                                                                    <option value="Designation">Designation</option>
                                                                                                                                                                    <option value="Employee_Group">Employee_Group</option>
                                                                                                                                                                    <option value="Company">Company</option>   -->

                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" id="change" class="col-sm-4 control-label"></label>
                                                                            <div class="col-sm-8" id="cat_div">
                                                                                <select class="form-control" required="" id="cmb_cat2" name="cmb_cat2" onchange="check_leave()">

                                                                                </select>
                                                                            </div>

                                                                        </div>

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Leave Type</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" required="" id="cmb_leave_type" name="cmb_leave_type" >


                                                                                    <option value="" default>-- Select --</option>
                                                                                    <?php foreach ($data_leave as $t_data) { ?>
                                                                                        <option value="<?php echo $t_data->Lv_T_ID; ?>" ><?php echo $t_data->leave_name; ?></option>

                                                                                    <?php }
                                                                                    ?>        

                                                                                </select>
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label date">From Date</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" required="required" id="dpd1" name="txt_from_date">
                                                                            </div>

                                                                        </div>
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label date">To Date</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" required="required" id="dpd2" name="txt_to_date">
                                                                            </div>

                                                                        </div>

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Leave Day</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" required="" id="cmb_day" name="cmb_day" >

                                                                                    <option value="" default>-- Select --</option>
                                                                                    <option value="1">Full Day</option>
                                                                                    <option value="0.5">Half Day</option>

                                                                                </select>
                                                                            </div>

                                                                        </div>

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label date">Leave Reason</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" required="required" id="txt_reason" name="txt_reason">
                                                                            </div>

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

                                                <!--					<div class="tab-content">
                                                                                        <div class="tab-pane active" id="horizontal-form">
                                                                                                <form class="form-horizontal">
                                                                                                        <div class="form-group">
                                                                                                                <label for="focusedinput" class="col-sm-3 control-label">Designation Code</label>
                                                                                                                <div class="col-sm-8">
                                                                                                                        <input type="text" class="form-control" id="focusedinput" placeholder="Default Input">
                                                                                                                </div>
                                                                                                                
                                                                                                        </div>
                                                                                                </form>
                                                                                        </div>
                                                                                        
                                                                                </div>-->
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
                $("#frm_leave_entry").validate();
//                $("#spnmessage").hide("shake", {times: 6}, 3500);
            });
        </script>






    </body>


</html>