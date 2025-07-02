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


<!--                            <div class="page-tabs">
                                <ul class="nav nav-tabs">

                                    <li class="active"><a data-toggle="tab" href="#tab1">LEAVE ENTRY</a></li>
                                    <li><a data-toggle="tab" href="#tab2">VIEW LEAVE TYPES</a></li>


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
                                                            <div class="panel-heading"><h2>LEAVE ENTRY</h2></div>
                                                            <div class="panel-body">
                                                                <form class="form-horizontal" id="frm_leave_request" name="frm_leave_request" action="<?php echo base_url(); ?>Leave_Transaction/Leave_Request/insert_data" method="POST">


                                                                    <!--success Message-->
                                                                    <?php if (isset($_SESSION['success_message']) && $_SESSION['success_message'] != '') { ?>
                                                                        <div id="spnmessage" class="alert alert-dismissable alert-success">
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
                                                                        <div class="col-sm-6">
                                                                            <img class="imagecss" src="<?php echo base_url(); ?>assets/images/leave_entry.png" >
                                                                        </div>
                                                                        
                                                                        <div class="col-sm-2" style="font-size: 20px;">
                                                                        Leave Balance
                                                                        </div>
                                                                        
                                                                        <?php foreach ($data_leave as $t_data) { ?>
                                                                    <div class="col-sm-4" style="color: red; float: right; font-size: 20px;"><?php echo $t_data->leave_name .' - '. $t_data->Balance; ?> &nbsp;&nbsp;&nbsp;&nbsp;</div>
                                                                     

                                                                                    <?php }
                                                                                    ?> 
                                                                        
                                                                    </div>
                                                                    
                                                                    
                                                                    
                                                                    
                                                                    
                                                                    

                                                                    <div class="form-group col-md-12">
                                                                        
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" id="change" class="col-sm-4 control-label">Employee</label>
                                                                            <div class="col-sm-8" id="cat_div">
                                                                                <input type="text" class="form-control" readonly="" value="<?php echo "" . $currentUser[0]->Emp_Full_Name; ?>" required="required">
                                                                                <input type="text" class="form-control hidden" value="<?php echo "" . $currentUser[0]->EmpNo; ?>" required="required" id="txt_employee" name="txt_employee">
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
                                    <!--***************************-->
                                    <!-- Grid View -->
                                    <!--                                    <div class="tab-pane" id="tab2">
                                    
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="panel panel-primary">
                                                                                        <div class="col-md-12">
                                                                                            <div class="panel panel-default">
                                                                                                <div class="panel-heading">
                                                                                                    <h2>DESIGNATION DETAILS</h2>
                                                                                                    <div class="panel-ctrls">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="panel-body panel-no-padding">
                                                                                                    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                                                        <thead>
                                                                                                            <tr>
                                                                                                                <th>ID</th>
                                                                                                                <th>LEAVE</th>
                                                                                                                <th>ENTITLE</th>
                                                                                                                <th>LEAVE BF</th>
                                                                                                                <th>IS ACTIVE</th>
                                                                                                                <th>EDIT</th>
                                                                                                                <th>DELETE</th>
                                    
                                                                                                            </tr>
                                                                                                        </thead>
                                                                                                        <tbody>
                                    <?php
                                    foreach ($data_set as $data) {


                                        echo "<tr class='odd gradeX'>";


                                        echo "<td width='100'>" . $data->id . "</td>";
                                        echo "<td width='100'>" . $data->leave_name . "</td>";
                                        echo "<td width='100'>" . $data->leave_entitle . "</td>";
                                        echo "<td width='100'>" . $data->leave_BF . "</td>";
                                        echo "<td width='100'>" . $data->IsActive . "</td>";

                                        echo "<td width='15'>";
                                        echo "<button class='get_data btn btn-green'  data-toggle='modal' data-target='#myModal' title='EDIT' data-id='$data->id' href='" . base_url() . "index.php/Master/Department/get_details" . $data->id . "'><i class='fa fa-edit'></i></button>";
                                        echo "</td>";

                                        echo "<td width='15'>";


                                        echo "<button  class=' btn btn-danger' data-toggle='modal' href='javascript:void()' title='DELETE' onclick='delete_id($data->id)'><i class='fa fa-times-circle'></i></a>";


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
                                    
                                                                        </div>-->

                                    <!-- End Grid View-->

                                    <!-- Modal -->
                                    <!--                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                                        <h2 class="modal-title">LEAVE TYPE</h2>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <form class="form-horizontal" action="<?php echo base_url(); ?>Master/Leave_Types/edit" method="post">
                                                                                            <div class="form-group col-sm-12">
                                                                                                <label for="focusedinput" class="col-sm-4 control-label">ID</label>
                                                                                                <div class="col-sm-8">
                                                                                                    <input value="<?php echo $data->id; ?>" type="text" class="form-control" readonly="readonly" name="id" id="id" class="m-wrap span3" >
                                                                                                </div>
                                                                                            </div>
                                    
                                                                                            <div class="form-group col-sm-12">
                                                                                                <label for="focusedinput" class="col-sm-4 control-label">LEAVE NAME</label>
                                                                                                <div class="col-sm-8">
                                                                                                    <input value="<?php echo $data->leave_name; ?>" type="text" name="L_Name" id="L_Name"  class="form-control m-wrap span6"><br>
                                                                                                </div>
                                                                                            </div>
                                    
                                                                                            <div class="form-group col-sm-12">
                                                                                                <label for="focusedinput" class="col-sm-4 control-label">LEAVE ENTITLE</label>
                                                                                                <div class="col-sm-8">
                                                                                                    <input value="<?php echo $data->leave_entitle; ?>" type="text" name="L_Ent" id="L_Ent"  class="form-control m-wrap span6"><br>
                                                                                                </div>
                                                                                            </div>
                                    
                                                                                            <div class="form-group col-sm-12">
                                    
                                                                                                <label for="focusedinput" class="col-sm-4 icheck checkbox green control-label">LEAVE BF</label>
                                                                                                <div class="col-sm-8"><?php
                                    $BF = $data->leave_BF;

                                    var_dump($BF);

                                    if ($BF == '1') {
                                        $BF = 'checked';
//                                                                    var_dump($BF);
                                    } elseif ($BF == 0) {
                                        $BF = '';
                                    }
                                    ?>
                                                                                                    <input type="checkbox" value="<?php echo $BF; ?>"  id="L_BF" name="L_BF" <?php echo $BF; ?>
                                                                                                </div>
                                    
                                    
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class="form-group col-sm-12">
                                    
                                                                                        <label for="focusedinput" class="col-sm-4 icheck checkbox green control-label">IS ACTIVE</label>
                                                                                        <div class="col-sm-8">
                                    
                                    <?php
                                    $Active = $data->leave_BF;


                                    var_dump($Active);

                                    if ($Active == '1') {
                                        $Active = 'checked';
//                                                                    var_dump($BF);
                                    } elseif ($Active == 0) {
                                        $Active = '';
                                    }
                                    ?>
                                    
                                    
                                                                                            <input type="checkbox" value="<?php echo $data->IsActive; ?>" id="is_active" name="is_active" 
                                                                                        </div>
                                    
                                    
                                                                                                                                                <label class="checkbox green icheck col-sm-4">
                                                                                                                                                        <input type="checkbox" value="<?php echo $data->IsActive; ?>" id="is_active" name="is_active" 
                                    <?php echo $data->IsActive;
                                    ?>> IS ACTIVE
                                                                                                                                                    </label>
                                                                                    </div>
                                    
                                    
                                                                                </div>
                                    
                                                                                <br>
                                                                                <input class="btn green" type="submit" value="submit" id="submit">
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                    <button type="submit" id="submit" class="btn btn-primary">Save changes</button>
                                                                                </div>
                                                                                </form>
                                                                            </div>
                                    
                                                                        </div> /.modal-content 
                                                                    </div> /.modal-dialog 
                                    
                                    
                                    
                                    
                                                                </div>  .container-fluid -->
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
                $("#frm_leave_request").validate();
                $("#spnmessage").hide("shake", {times: 6}, 3500);
            });
        </script>



<!--            <script>
                var nowTemp = new Date();
                var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

                var checkin = $('#dpd1').datepicker({
                    onRender: function (date) {
                        return date.valueOf() < now.valueOf() ? 'disabled' : '';
                    }
                }).on('changeDate', function (ev) {
                    if (ev.date.valueOf() > checkout.date.valueOf()) {
                        var newDate = new Date(ev.date)
                        newDate.setDate(newDate.getDate() + 1);
                        checkout.setValue(newDate);
                    }
                    checkin.hide();
                    $('#dpd2')[0].focus();
                }).data('datepicker');
                var checkout = $('#dpd2').datepicker({
                    onRender: function (date) {
                        return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
                    }
                }).on('changeDate', function (ev) {
                    checkout.hide();
                }).data('datepicker');
            </script>-->




    </body>


</html>