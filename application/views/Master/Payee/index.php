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
                                <li class="active"><a href="index.html">ADD PAYEE</a></li>

                            </ol>


                            <div class="page-tabs">
                                <ul class="nav nav-tabs">

                                    <li class="active"><a data-toggle="tab" href="#tab1">ADD PAYEE</a></li>
                                    <li><a data-toggle="tab" href="#tab2">VIEW PAYEE</a></li>
                                    <!--<li><a data-toggle="tab" href="#tab3">Success</a></li>
                                    <li><a data-toggle="tab" href="#tab4">Info</a></li>
                                    <li><a data-toggle="tab" href="#tab5">Danger</a></li>
                                    <li><a data-toggle="tab" href="#tab6">Warning</a></li>
                                    <li><a data-toggle="tab" href="#tab7">Inverse</a></li>-->

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
                                                            <div class="panel-heading"><h2>ADD PAYEE</h2></div>
                                                            <div class="panel-body">
                                                                <form action="<?php echo base_url(); ?>Master/Payee/insert_payee" class="form-horizontal" id="frmPayee" name="frmPayee" method="POST">

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
                                                                            <img class="imagecss1" src="<?php echo base_url(); ?>assets/images/payee.png" >
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Payee Name</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" required="" id="txt_Name" name="txt_Name" placeholder="Ex: Comapny Name">
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Payee Address</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="txt_address" name="txt_address" placeholder="Ex: Maharagama">
                                                                        </div>

                                                                    </div>



                                                                    <div class="form-group col-md-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Telephone</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="txt_telephone" name="txt_telephone" placeholder="Ex:0112224455">
                                                                        </div>
                                                                    </div>



                                                                    <div class="form-group col-md-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">E Mail</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="txt_Email" name="txt_Email" placeholder="Ex: email@email.com">
                                                                        </div>
                                                                    </div>

                                                                    <hr>

                                                                    <!--submit button-->
                                                                    <?php $this->load->view('template/btn_submit.php'); ?>
                                                                    <!--end submit-->



                                                                </form>






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
                                                                <h2>VIEW PAYEE</h2>
                                                                <div class="panel-ctrls">
                                                                </div>
                                                            </div>
                                                            <div class="panel-body panel-no-padding">
                                                                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Code</th>
                                                                            <th>Name</th>
                                                                            <th>Address</th>
                                                                            <th>Telephone</th>
                                                                            <th>Mobile</th>

                                                                            <th>Edit</th>
                                                                            <th>Delete</th>


                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        foreach ($data_array as $data) {


                                                                            echo "<tr class='odd gradeX'>";
//                                                                                  echo "<td width='5'><input type='checkbox' class='checkboxes' value='1' /></td>";

                                                                            echo "<td width='100'>" . $data->id . "</td>";
                                                                            echo "<td width='100'>" . $data->name . "</td>";
                                                                            echo "<td width='100'>" . $data->address . "</td>";
                                                                            echo "<td width='100'>" . $data->tel . "</td>";
                                                                            echo "<td width='100'>" . $data->email . "</td>";

                                                                            echo "<td width='15'>";
                                                                            echo "<a class='payee' data-toggle='modal' data-target='#myModal' data-id='$data->id' href='" . base_url() . "Master/Payee/branch_details" . $data->id . "'><i class='fa fa-edit fa-3x'></i></a>";
                                                                            echo "</td>";

                                                                            echo "<td width='15'>";
//                                                                            echo "<a class='action_comp' data-toggle='modal' data-target='#myModal' data-id='$data->id' href='" . base_url() . "index.php/Action_Complain/action" . $data->id . "'><i class='fa fa-edit'></i></a>";

                                                                            echo "<button  class='action_comp btn btn-danger' data-toggle='modal' href='javascript:void()' title='DELETE' onclick='delete_id($data->id)'><i class='fa fa-times-circle fa-2x'></i></a>";
                                                                            
                                                                            



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
                                                <h2 class="modal-title">Payee</h2>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="<?php echo base_url(); ?>Master/Payee/edit/" method="post">
                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Code</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->id; ?>" type="text" class="form-control" readonly="readonly" name="id" id="id" class="m-wrap span3" >
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Name</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->name; ?>" type="text" name="name" id="name"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Address</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->address; ?>" type="text" name="Address" id="Address"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Telephone</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->tel; ?>" type="text" name="TelNo" id="TelNo"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">E-mail</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->email; ?>" type="text" name="email" id="email"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>






                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" id="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
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

            <script src="<?php echo base_url(); ?>system_js/Master/Payee.js"></script>
            
            
            <!--JQuary Validation-->
            <script type="text/javascript">
                $(document).ready(function () {
                    $("#frmPayee").validate();
                    $("#spnmessage").hide("shake", {times: 6}, 3500);
                });
            </script>

    </body>


</html>