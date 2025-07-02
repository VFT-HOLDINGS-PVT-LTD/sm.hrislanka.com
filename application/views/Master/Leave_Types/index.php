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
                            <li class="active"><a href="index.html">LEAVE TYPES</a></li>

                        </ol>


                        <div class="page-tabs">
                            <ul class="nav nav-tabs">

                                <li class="active"><a data-toggle="tab" href="#tab1">LEAVE TYPES</a></li>
                                <li><a data-toggle="tab" href="#tab2">VIEW LEAVE TYPES</a></li>


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
                                                            <h2>ADD LEAVE TYPES</h2>
                                                        </div>
                                                        <div class="panel-body">
                                                            <form class="form-horizontal" id="frm_leave_type" name="frm_leave_type" action="<?php echo base_url(); ?>Master/Leave_Types/insert_Data" method="POST">

                                                                <div class="form-group col-sm-12">
                                                                    <div class="col-sm-8">
                                                                        <img class="imagecss" src="<?php echo base_url(); ?>assets/images/leave_add.png">
                                                                    </div>
                                                                </div>


                                                                <div class="form-group col-sm-6">
                                                                    <label for="focusedinput" class="col-sm-4 control-label">Leave Name</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" name="txt_L_Name" id="txt_L_Name" placeholder="Ex: Anual Leave">
                                                                    </div>

                                                                </div>

                                                                <div class="form-group col-sm-6">
                                                                    <label for="focusedinput" class="col-sm-4 control-label">Leave Entitle</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="number" class="form-control" name="txt_L_Entitle" id="txt_L_Entitle" placeholder="Ex: 14">
                                                                    </div>

                                                                </div>

                                                                <div class="form-group col-sm-6">
                                                                    <label for="focusedinput" class="col-sm-4 control-label">Leave Balance Forward</label>
                                                                    <div class="col-sm-8 icheck-flat">
                                                                        <label class="checkbox green icheck col-sm-5">
                                                                            <input type="checkbox" name="chk_BF" id="chk_BF">
                                                                        </label>
                                                                    </div>

                                                                </div>


                                                                <hr>
                                                                <div class="row">
                                                                    <div class="col-sm-8 col-sm-offset-2">
                                                                        <button type="submit" id="submit" class="btn-primary btn fa fa-check">&nbsp;&nbsp;Submit</button>
                                                                        <button type="button" id="Cancel" name="Cancel" class="btn btn-danger-alt fa fa-times-circle">&nbsp;&nbsp;Cancel</button>
                                                                    </div>
                                                                </div>
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
                                                                    <?php foreach ($data_set as $data) : ?>
                                                                        <tr class="odd gradeX">
                                                                            <td width="100"><?php echo $data->Lv_T_ID; ?></td>
                                                                            <td width="100"><?php echo $data->leave_name; ?></td>
                                                                            <td width="100"><?php echo $data->leave_entitle; ?></td>
                                                                            <td width="100"><?php echo $data->leave_BF; ?></td>
                                                                            <td width="100"><?php echo $data->IsActive; ?></td>
                                                                            <td width="15">
                                                                                <button class="get_data btn btn-green" data-toggle="modal" data-target="#myModal" title="EDIT" data-id="<?php echo $data->Lv_T_ID; ?>" href=""><i class="fa fa-edit"></i></button>
                                                                            </td>
                                                                            <td width="15">
                                                                                <button class="btn btn-danger" data-toggle="modal" href="javascript:void()" title="DELETE" onclick="delete_id(<?php echo $data->Lv_T_ID; ?>)"><i class="fa fa-times-circle"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
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

                                <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h2 class="modal-title">LEAVE TYPE</h2>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="<?php echo base_url(); ?>Master/Leave_Types/update_Data" method="post">
                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">ID</label>
                                                        <div class="col-sm-8">
                                                            <input value="" type="text" class="form-control" readonly="readonly" name="id" id="id" class="m-wrap span3">
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">leave_name</label>
                                                        <div class="col-sm-8">
                                                            <input value="" type="text" name="leave_name" id="L_Name" class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">leave_entitle</label>
                                                        <div class="col-sm-8">
                                                            <input value="" type="text" name="leave_entitle" id="L_Ent" class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">leave_BF</label>
                                                        <div class="col-sm-8">

                                                            <label class="checkbox green  col-sm-5">

                                                                <input type="checkbox" name="leavebf" id="leavebf">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">IsActive</label>
                                                        <div class="col-sm-8">
                                                            <label class="checkbox green col-sm-5">

                                                                <input type="checkbox" name="isactive" id="isactive">
                                                            </label>
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

            <?php $this->load->view('template/js.php'); ?> <!-- Initialize scripts for this page-->

            <!-- End loading page level scripts-->

            <!--Ajax-->
            <script src="<?php echo base_url(); ?>system_js/Master/L_Types.js"></script>
            <script>
                $(".get_data").click(function() {

                    var id = $(this).attr("data-id");
                    $.ajax({
                        type: "POST",
                        url: baseurl + "index.php/Master/Leave_Types/get_details",
                        data: {
                            'id': id
                        },
                        dataType: "JSON",
                        success: function(response) {

                            // alert(JSON.stringify(response[0].leave_name));

                            $('#L_Name').val(response[0].leave_name);
                            $('#L_Ent').val(response[0].leave_entitle);
                            $('#id').val(response[0].Lv_T_ID);

                            if (response[0].leave_BF == 1) {
                                document.getElementById("leavebf").checked = true;
                            } else {
                                document.getElementById("leavebf").checked = false;
                            }
                            if (response[0].IsActive == 1) {
                                document.getElementById("isactive").checked = true;
                            } else {
                                document.getElementById("isactive").checked = false;
                            }

                        }
                    });
                });
            </script>

</body>


</html>