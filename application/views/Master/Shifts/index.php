<!DOCTYPE html>


<!--Description of dashboard page

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
                                <li class="active"><a href="index.html">SHIFTS</a></li>

                            </ol>


                            <div class="page-tabs">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab1">SHIFTS</a></li>
                                    <li><a data-toggle="tab" href="#tab2">VIEW SHIFTS</a></li>
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
                                                            <div class="panel-heading"><h2>ADD SHIFTS</h2></div>
                                                            <div class="panel-body">
                                                                <form class="form-horizontal" id="frm_shifts" name="frm_shifts" action="<?php echo base_url(); ?>Master/Shifts/insert_Data" method="POST">

                                                                    <!--success Message-->
                                                                    <?php if (isset($_SESSION['success_message']) && $_SESSION['success_message'] != '') { ?>
                                                                        <div id="spnmessage" class="alert alert-dismissable alert-success">
                                                                            <strong>Success !</strong> <?php echo $_SESSION['success_message'] ?>
                                                                        </div>
                                                                    <?php } ?>
                                                                    
                                                                    <div class="form-group col-sm-12">
                                                                        <div class="col-sm-8">
                                                                            <img class="imagecss" src="<?php echo base_url(); ?>assets/images/shifts.png" >
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group col-md-12">

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Shifts Name</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" required="required" id="txt_shift_name" name="txt_shift_name" placeholder="Ex: Office">
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">From Time</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="time" class="form-control" required="required" id="txt_from_time" name="txt_from_time" placeholder="Ex: 2">
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">To Time</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="time" class="form-control" required="required" id="txt_to_time" name="txt_to_time" placeholder="Ex: 120">
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Shifts Gap</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="txt_shift_gap" name="txt_shift_gap" placeholder="Ex: 15">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group col-sm-6 ">
                                                                            <label class="col-sm-4 control-label">Day Type</label>
                                                                            <div class="col-sm-8">
                                                                                <label class="radio-inline icheck">
                                                                                    <input type="radio" id="day_type"  value="1" name="day_type" required="required"> Full Day
                                                                                </label>
                                                                                <label class="radio-inline icheck">
                                                                                    <input type="radio" id="day_type" value="0.5" name="day_type" > Half Day
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

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                    </div>


                                    <!--***************************-->
                                    <!-- Grid View -->

                                    <div class="tab-pane" id="tab2">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="panel panel-primary">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h2>VIEW SHIFT DETAILS</h2>
                                                                <div class="panel-ctrls">
                                                                </div>
                                                            </div>
                                                            <div class="panel-body panel-no-padding">
                                                                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>SHIFT CODE</th>
                                                                            <th>NAME</th>
                                                                            <th>FROM TIME</th>
                                                                            <th>TO TIME</th>
                                                                            <th>DAY TYPE</th>
                                                                            <th>SHIFT GAP</th>
                                                                            

                                                                            <th>EDIT</th>
                                                                            <th>DELETE</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        foreach ($data_set as $data) {


                                                                            echo "<tr class='odd gradeX'>";


                                                                            echo "<td width='100'>" . $data->ShiftCode . "</td>";
                                                                            echo "<td width='100'>" . $data->ShiftName . "</td>";
                                                                            echo "<td width='100'>" . $data->FromTime . "</td>";
                                                                            echo "<td width='100'>" . $data->ToTime . "</td>";
                                                                            echo "<td width='100'>" . $data->DayType . "</td>";
                                                                            echo "<td width='100'>" . $data->ShiftGap . "</td>";
                                                                           

                                                                            echo "<td width='15'>";
                                                                            echo "<button class='get_data btn btn-green'  data-toggle='modal' data-target='#myModal' title='EDIT' data-id='$data->ShiftCode' href='" . base_url() . "index.php/Master/Department/get_details" . $data->ShiftCode . "'><i class='fa fa-edit'></i></button>";
                                                                            echo "</td>";

                                                                            echo "<td width='15'>";

                                                                            echo "<button  class='action_comp btn btn-danger' data-toggle='modal' href='javascript:void()' title='DELETE' onclick='delete_id($data->ShiftCode)'><i class='fa fa-times-circle'></i></a>";


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


                                    <!-- End Grid View -->
                                    <!--***************************-->

                                </div>
                                
                                
                                  <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h2 class="modal-title">SHIFTS</h2>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="<?php echo base_url(); ?>Master/Shifts/edit" method="post">
                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">SHIFT CODE</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->ShiftCode; ?>" type="text" class="form-control" readonly="readonly" name="ShiftCode" id="ShiftCode" class="m-wrap span3" >
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">NAME</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->ShiftName; ?>" type="text" name="ShiftName" id="ShiftName"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">FROM TIME</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->FromTime; ?>" type="time" name="FromTime" id="FromTime"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">TO TIME</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->ToTime; ?>" type="time" name="ToTime" id="ToTime"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">SHIFT GAP</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->ShiftGap; ?>" type="text" name="ShiftGap" id="ShiftGap"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>


                                            </div>

                                            <br>
                                            <!--<input class="btn green" type="submit" value="submit" id="submit">-->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" id="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                            </form>
                                        </div>

                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                                
                                

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
            <script src="<?php echo base_url(); ?>system_js/Master/Shifts.js"></script>
            
            <!--JQuary Validation-->
            <script type="text/javascript">
                $(document).ready(function () {
                    $("#frm_shifts").validate();
                    $("#spnmessage").hide("shake", {times: 4}, 1500);
                });
            </script>

    </body>


</html>