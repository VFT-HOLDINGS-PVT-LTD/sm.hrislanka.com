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

                                <li class=""><a href="<?php echo base_url(); ?>Dashboard/">HOME</a></li>
                                <li class="active"><a href="<?php echo base_url(); ?>Master/Designation/">HOLIDAY TYPES</a></li>

                            </ol>


                            <div class="page-tabs">
                                <ul class="nav nav-tabs">

                                    <li class="active"><a data-toggle="tab" href="#tab1">HOLIDAY TYPES</a></li>
                                    <li><a data-toggle="tab" href="#tab2">VIEW HOLIDAY TYPES</a></li>


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
                                                            <div class="panel-heading"><h2>ADD HOLIDAYS</h2></div>
                                                            <div class="panel-body">
                                                                <form class="form-horizontal" id="frm_Holidays" name="frm_Holidays" action="<?php echo base_url(); ?>Master/Holidays/insert_data" method="POST">

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
                                                                            <img class="imagecss" src="<?php echo base_url(); ?>assets/images/holidays.png" >
                                                                        </div>
                                                                    </div>


                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Holiday Type</label>
                                                                        <div class="col-sm-8">
                                                                            <select class="form-control" required="" id="cmb_HDay_type" name="cmb_HDay_type" >


                                                                                <option value="" default>-- Select --</option>
                                                                                <?php foreach ($data_set as $t_data) { ?>
                                                                                    <option value="<?php echo $t_data->HTCode; ?>" ><?php echo $t_data->HTDescription; ?></option>

                                                                                <?php }
                                                                                ?>        

                                                                            </select>
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Holiday</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" required="required" name="txt_HDate" id="txt_HDate" placeholder="Select Date">
                                                                        </div>

                                                                    </div>

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Description</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" required="required" name="txt_Description" id="txt_Description" placeholder="Ex: Wesak Poya Day">
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
                                                                <h2>HOLIDAY TYPE DETAILS</h2>
                                                                <div class="panel-ctrls">
                                                                </div>
                                                            </div>
                                                            <div class="panel-body panel-no-padding">
                                                                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>HOLIDAY</th>
                                                                            <th>HOLIDAY CODE</th>
                                                                            <th>DESCRIPTION</th>

                                                                            <th>EDIT</th>
                                                                            <th>DELETE</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        foreach ($data_set_H as $data) {


                                                                            echo "<tr class='odd gradeX'>";


                                                                            echo "<td width='100'>" . $data->Holy_ID . "</td>";
                                                                            echo "<td width='100'>" . $data->Hdate . "</td>";
                                                                            echo "<td width='100'>" . $data->HTCode . "</td>";
                                                                            echo "<td width='100'>" . $data->H_description . "</td>";

                                                                            echo "<td width='15'>";
                                                                            echo "<button class='get_data btn btn-green'  data-toggle='modal' data-target='#myModal' title='EDIT' data-id='$data->Holy_ID' href='" . base_url() . "index.php/Master/Department/get_details" . $data->Holy_ID . "'><i class='fa fa-edit'></i></button>";
                                                                            echo "</td>";

                                                                            echo "<td width='15'>";


                                                                            echo "<button  class=' btn btn-danger' data-toggle='modal' href='javascript:void()' title='DELETE' onclick='delete_id($data->Holy_ID)'><i class='fa fa-times-circle'></i></a>";


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

                                    <!-- End Grid View-->


                                </div>


                                <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h2 class="modal-title">HOLIDAY</h2>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="<?php echo base_url(); ?>Master/Holidays/edit" method="post">
                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">ID</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->Holy_ID; ?>" type="text" class="form-control" readonly="readonly" name="id" id="id" class="m-wrap span3" >
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">HOLIDAY</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->H_description; ?>" type="text" name="H_Date" id="H_Date"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">CODE</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->Hdate; ?>" type="text" name="H_Code" id="H_Code"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">DESCRIPTION</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->HTCode; ?>" type="text" name="H_Desc" id="H_Desc"  class="form-control m-wrap span6"><br>
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
                <script src="<?php echo base_url(); ?>system_js/Master/H_Days.js"></script>

                <!--JQuary Validation-->
                <script type="text/javascript">
                    $(document).ready(function () {
                        $("#frm_Holidays").validate();
                        $("#spnmessage").hide("shake", {times: 6}, 3500);
                    });
                </script>

                <!--Date Format-->
                <script>

                    $('#txt_HDate').datepicker({
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

                </body>


                </html>