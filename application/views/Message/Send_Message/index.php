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
                                <li class="active"><a href="index.html">SEND MESSAGE</a></li>

                            </ol>


                            <div class="page-tabs">
                                <ul class="nav nav-tabs">

                                    <li class="active"><a data-toggle="tab" href="#tab1">SEND MESSAGE</a></li>
                                    <li><a data-toggle="tab" href="#tab2">SEND MESSAGE</a></li>


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
                                                            <div class="panel-heading"><h2>SEND MESSAGE</h2></div>
                                                            <div class="panel-body">
                                                                <form action="<?php echo base_url(); ?>index.php/Message/Send_Message/insertMessage" class="form-horizontal" id="frmBank" name="frmBank" method="POST">




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
                                                                            <img class="imagecss" src="<?php echo base_url(); ?>assets/images/message_icon.jpg" >
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Message</label>
                                                                        <div class="col-sm-8">
                                                                            <textarea type="text" class="form-control" id="txt_message" name="txt_message" placeholder="Ex: Your Message"></textarea>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Employee Name</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="txt_emp_name" name="txt_emp_name" placeholder="Ex: Enter Employee Name">                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Employee No</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="txt_emp" name="txt_emp" placeholder="Ex: Enter Employee Name">
                                                                        </div>
                                                                    </div>




                                                                    <!--submit button-->
                                                                    <?php $this->load->view('template/btn_submit.php'); ?>
                                                                    <!--end submit-->



                                                                </form>

                                                                <hr>

                                                                <div id="divmessage" class="">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                                    <div id="spnmessage"> </div>

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
                                            <div class="col-md-12">
                                                <div class="panel panel-primary">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h2>VIEW BANK</h2>
                                                                <div class="panel-ctrls">
                                                                </div>
                                                            </div>
                                                            <div class="panel-body panel-no-padding">
                                                                <table id="example" class="table table-striped table-bordered" class="btn btn-primary" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>EMP NO</th>
                                                                            <th>NAME</th>
                                                                            <th>MESSAGE</th>
                                                                            <th>VIEW</th>
                                                                            <th>DELETE</th>


                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        foreach ($data_set as $data) {


                                                                            echo "<tr class='odd gradeX'>";
//                                                                                  echo "<td width='5'><input type='checkbox' class='checkboxes' value='1' /></td>";

                                                                            echo "<td width='100'>" . $data->id . "</td>";
                                                                            echo "<td width='100'>" . $data->recever . "</td>";
                                                                            echo "<td width='100'>" . $data->Emp_Full_Name . "</td>";

                                                                            echo "<td width='100'>" . $data->message . "</td>";


                                                                            echo "<td width='15'>";
                                                                            echo "<a class='branch btn btn-primary' data-toggle='modal' data-target='#myModal' data-id='$data->id' href='" . base_url() . "Master/Banks/bank_details" . $data->id . "'><i class='fa fa-eye'></i></a>";
                                                                            echo "</td>";

                                                                            echo "<td width='15'>";
//                                                                            echo "<a class='action_comp' data-toggle='modal' data-target='#myModal' data-id='$data->id' href='" . base_url() . "index.php/Action_Complain/action" . $data->id . "'><i class='fa fa-edit'></i></a>";

                                                                            echo "<a class='action_comp btn btn-danger' data-toggle='modal' href='javascript:void()' title='Edit' onclick='delete_id($data->id)'><i class='fa fa-times-circle'></i></a>";


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

                                </div>


                                <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h2 class="modal-title">BANK</h2>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="<?php echo base_url(); ?>index.php/Add_Branch/edit/" method="post">
                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Code</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->sender; ?>" type="text" class="form-control" readonly="readonly" name="B_Code" id="B_Code" class="m-wrap span3" >
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Name</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->sender; ?>" type="text" name="B_name" id="B_name"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>



                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" id="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                    <br>
                                                </form>
                                            </div>




                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

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

            <script src="<?php echo base_url(); ?>system_js/Master/banks.js"></script>










            <script type="text/javascript">
//                $(function () {
//                    $("#txt_customer").autocomplete({
//                        source: "<?php echo base_url(); ?>Invoice/Invoice/get_auto_cus_name" // path to the get_birds method
//                    });
//                });


                $(function () {
                    $("#txt_customer").autocomplete({
                        source: "<?php echo base_url(); ?>Invoice/Invoice/get_auto_cus_name",
                        select: function (event, ui) {
                            $("#txt_customer").val(ui.item.label);
                            $("#cust_id").val(ui.item.value);


                            $.ajax({
                                type: "post",
                                url: baseurl + "Invoice/Invoice/get_resp",
                                data: {'id': ui.item.value},
                                dataType: "JSON",
                                success: function (response) {
                                    setTimeout(function () {
//                                        alert("asaaaaa");
                                    }, 1000);


                                }
                            });




                            return false;
                        }
                    });
                });

                $(function () {
                    $("#txt_commission_id").autocomplete({
                        source: "<?php echo base_url(); ?>Invoice/Invoice/get_auto_commission" // path to the get_birds method
                    });
                });




            </script>

























            <!--JQuary Validation-->
            <script type="text/javascript">
                $(document).ready(function () {
                    $("#frmBank").validate();
                    $("#spnmessage").hide("shake", {times: 6}, 3500);
                });
            </script>


            <!--Auto complete-->
            <script type="text/javascript">
                $(function () {
                    $("#txt_emp_name").autocomplete({
                        source: "<?php echo base_url(); ?>Reports/Attendance/Report_Attendance_In_Out/get_auto_emp_name"

                    });
                    //                selctcity();

                });

                $(function () {
                $("#txt_emp").autocomplete({
                source: "<?php echo base_url(); ?>Reports/Attendance/Report_Attendance_In_Out/get_auto_emp_no"
                        ////                });
                                ////            });
                                        //            


                                                function selctcity()
                                                {
                                                var name = $('#txt_emp_name').val();
                                                        $.post('<?php echo base_url(); ?>Message/Send_Message/emp_data/',
                                                        {
                                                        txt_emp_name: name

                                                        },
                                                                function (data)
                                                                {
                                                                $('#txt_emp').val(data);
                                                                });
                                                }





            </script>

    </body>


</html>