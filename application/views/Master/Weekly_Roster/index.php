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
                                <li class="active"><a href="index.html">WEEKLY ROSTER PATTERN</a></li>

                            </ol>


                            <div class="page-tabs">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab1">WEEKLY ROSTER PATTERN</a></li>
                                    <li><a data-toggle="tab" href="#tab2">VIEW WEEKLY ROSTER PATTERN</a></li>
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
                                                            <div class="panel-heading"><h2>ADD WEEKLY ROSTER PATTERN</h2></div>
                                                            <div class="panel-body">
                                                                <form class="form-horizontal" id="frm_weekly_roster" name="frm_weekly_roster" action="<?php echo base_url(); ?>Master/Weekly_Roster/insert_data" method="POST" onsubmit="createShiftDataArr()">

                                                                    <!--success Message-->
                                                                    <?php if (isset($_SESSION['success_message']) && $_SESSION['success_message'] != '') { ?>
                                                                        <div id="spnmessage" class="alert alert-dismissable alert-success">
                                                                            <strong>Success !</strong> <?php echo $_SESSION['success_message'] ?>
                                                                        </div>
                                                                    <?php } ?>
                                                                    
                                                                    <div class="form-group col-sm-12">
                                                                        <div class="col-sm-8">
                                                                            <img class="imagecss" src="<?php echo base_url(); ?>assets/images/roster_pattern.png" >
                                                                        </div>
                                                                    </div>

                                                                    

                                                                    <div class="form-group col-md-12">

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Roster Code</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" readonly="" value="<?php echo $serial; ?>" class="form-control" id="txtRoster_Code" name="txtRoster_Code" placeholder="">
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Roster Name</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="txtRoster_Name" name="txtRoster_Name" placeholder="Ex: Office">
                                                                            </div>
                                                                        </div>

                                                                    </div><br>
                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="#" class="col-sm-2 control-label" style="font-weight: bold">MONDAY</label>
                                                                            <div class="col-sm-2">
                                                                                <select class="form-control" required="" id="SHType0" name="txtSH_MO" >


                                                                                    <option value="" default>-- Select --</option>
                                                                                    <?php foreach ($data_set_shift as $t_data) { ?>
                                                                                        <option value="<?php echo $t_data->ShiftCode; ?>" ><?php echo $t_data->ShiftName; ?></option>

                                                                                    <?php }
                                                                                    ?>        

                                                                                </select>
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="txtDayType0" name="txt_shift_name" placeholder="">
                                                                                <input id="DType0" name="txtMon" value="MON" class="hide">
                                                                            </div>



                                                                            <div class="col-sm-2">
                                                                                <select id="txtSType0" name="txtM_SType" class="form-control">
                                                                                    <option></option>
                                                                                    <option>DU</option>
                                                                                    <option>EX</option>
                                                                                    <option>OFF</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>


                                                                    </div>

                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="#" class="col-sm-2 control-label" style="font-weight: bold">TUESDAY</label>
                                                                            <div class="col-sm-2">
                                                                                <select class="form-control" required="" id="SHType1" name="txtSH_TU" >


                                                                                    <option value="" default>-- Select --</option>
                                                                                    <?php foreach ($data_set_shift as $t_data) { ?>
                                                                                        <option value="<?php echo $t_data->ShiftCode; ?>" ><?php echo $t_data->ShiftName; ?></option>

                                                                                    <?php }
                                                                                    ?>        

                                                                                </select>
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="txtDayType1" name="txt_shift_name" placeholder="">
                                                                                <input id="DType1" name="txtTue" value="TUE" class="hide">
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <select id="txtSType1" name="txtM_SType" class="form-control">
                                                                                    <option></option>
                                                                                    <option>DU</option>
                                                                                    <option>EX</option>
                                                                                    <option>OFF</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>


                                                                    </div>


                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="#" class="col-sm-2 control-label" style="font-weight: bold">WEDNESDAY</label>
                                                                            <div class="col-sm-2">
                                                                                <select class="form-control" required="" id="SHType2" name="txtSH_WE" >


                                                                                    <option value="" default>-- Select --</option>
                                                                                    <?php foreach ($data_set_shift as $t_data) { ?>
                                                                                        <option value="<?php echo $t_data->ShiftCode; ?>" ><?php echo $t_data->ShiftName; ?></option>

                                                                                    <?php }
                                                                                    ?>        

                                                                                </select>
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="txtDayType2" name="txt_shift_name" placeholder="">
                                                                                <input id="DType2" name="txtWed" value="WED" class="hide">
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <select id="txtSType2" name="txtM_SType" class="form-control">
                                                                                    <option></option>
                                                                                    <option>DU</option>
                                                                                    <option>EX</option>
                                                                                    <option>OFF</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>


                                                                    </div>


                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="#" class="col-sm-2 control-label" style="font-weight: bold">THURSDAY</label>
                                                                            <div class="col-sm-2">
                                                                                <select class="form-control" required="" id="SHType3" name="txtSH_TH" >


                                                                                    <option value="" default>-- Select --</option>
                                                                                    <?php foreach ($data_set_shift as $t_data) { ?>
                                                                                        <option value="<?php echo $t_data->ShiftCode; ?>" ><?php echo $t_data->ShiftName; ?></option>

                                                                                    <?php }
                                                                                    ?>        

                                                                                </select>
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="txtDayType3" name="txt_shift_name" placeholder="">
                                                                                <input id="DType3" name="txtThu" value="THU" class="hide">
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <select id="txtSType3" name="txtM_SType" class="form-control">
                                                                                    <option></option>
                                                                                    <option>DU</option>
                                                                                    <option>EX</option>
                                                                                    <option>OFF</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>


                                                                    </div>


                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="#" class="col-sm-2 control-label" style="font-weight: bold">FRIDAY</label>
                                                                            <div class="col-sm-2">
                                                                                <select class="form-control" required="" id="SHType4" name="txtSH_FR" >


                                                                                    <option value="" default>-- Select --</option>
                                                                                    <?php foreach ($data_set_shift as $t_data) { ?>
                                                                                        <option value="<?php echo $t_data->ShiftCode; ?>" ><?php echo $t_data->ShiftName; ?></option>

                                                                                    <?php }
                                                                                    ?>        

                                                                                </select>
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="txtDayType4" name="txt_shift_name" placeholder="">
                                                                                <input id="DType4" name="txtFri" value="FRI" class="hide">
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <select id="txtSType4" name="txtM_SType" class="form-control">
                                                                                    <option></option>
                                                                                    <option>DU</option>
                                                                                    <option>EX</option>
                                                                                    <option>OFF</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>


                                                                    </div>


                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="#" class="col-sm-2 control-label" style="font-weight: bold">SATURDAY</label>
                                                                            <div class="col-sm-2">
                                                                                <select class="form-control" required="" id="SHType5" name="txtSH_SA" >


                                                                                    <option value="" default>-- Select --</option>
                                                                                    <?php foreach ($data_set_shift as $t_data) { ?>
                                                                                        <option value="<?php echo $t_data->ShiftCode; ?>" ><?php echo $t_data->ShiftName; ?></option>

                                                                                    <?php }
                                                                                    ?>        

                                                                                </select>
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="txtDayType5" name="txt_shift_name" placeholder="">
                                                                                <input id="DType5" name="txtSat" value="SAT" class="hide">
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <select id="txtSType5" name="txtM_SType" class="form-control">
                                                                                    <option></option>
                                                                                    <option>DU</option>
                                                                                    <option>EX</option>
                                                                                    <option>OFF</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>


                                                                    </div>


                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="#" class="col-sm-2 control-label" style="font-weight: bold">SUNDAY</label>
                                                                            <div class="col-sm-2">
                                                                                <select class="form-control" required="" id="SHType6" name="txtSH_SU" >


                                                                                    <option value="" default>-- Select --</option>
                                                                                    <?php foreach ($data_set_shift as $t_data) { ?>
                                                                                        <option value="<?php echo $t_data->ShiftCode; ?>" ><?php echo $t_data->ShiftName; ?></option>

                                                                                    <?php }
                                                                                    ?>        

                                                                                </select>
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="txtDayType6" name="txt_shift_name" placeholder="">
                                                                                <input id="DType6" name="txtSun" value="SUN" class="hide">
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <select id="txtSType6" name="txtM_SType" class="form-control">
                                                                                    <option></option>
                                                                                    <option>DU</option>
                                                                                    <option>EX</option>
                                                                                    <option>OFF</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>


                                                                    </div>

                                                                    <!--Hidden Text-->
                                                                    <input type="text" name="hdntext" id="hdntext" class="">



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
                                                                <h2>WEEKLY ROSTER PATTERN DETAILS</h2>
                                                                <div class="panel-ctrls">
                                                                </div>
                                                            </div>
                                                            <div class="panel-body panel-no-padding">
                                                                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            
                                                                            <th>ROSTER CODE</th>
                                                                            <th>ROSTER NAME</th>
                                                                            
                                                                            <th>EDIT</th>
                                                                            <th>DELETE</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        foreach ($data_set as $data) {


                                                                            echo "<tr class='odd gradeX'>";


                                                                            echo "<td width='100'>" . $data->RosterCode . "</td>";
                                                                            echo "<td width='100'>" . $data->RosterName . "</td>";
                                                                            


                                                                            echo "<td width='15'>";
                                                                            echo "<button class='get_data btn btn-green'  data-toggle='modal' data-target='#myModal' title='EDIT' data-id='$data->RosterCode' href='" . base_url() . "index.php/Master/Department/get_details" . $data->RosterCode . "'><i class='fa fa-edit'></i></button>";
                                                                            echo "</td>";

                                                                            echo "<td width='15'>";

                                                                            echo "<button  class='action_comp btn btn-danger' data-toggle='modal' href='javascript:void()' title='DELETE' onclick='delete_id($data->RosterCode)'><i class='fa fa-times-circle'></i></a>";


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
<!--                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                                            <input value="<?php echo $data->ID; ?>" type="text" class="form-control" readonly="readonly" name="ShiftCode" id="ShiftCode" class="m-wrap span3" >
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
                                            <input class="btn green" type="submit" value="submit" id="submit">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" id="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                            </form>
                                        </div>

                                    </div> /.modal-content 
                                </div> /.modal-dialog -->



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
            <script src="<?php echo base_url(); ?>system_js/Master/Weekly_Roster.js"></script>
            
            <!--JQuary Validation-->
            <script type="text/javascript">
                $(document).ready(function () {
                    $("#frm_weekly_roster").validate();
                    $("#spnmessage").hide("shake", {times: 4}, 1500);
                });
            </script>

    </body>


</html>