<!DOCTYPE html>


<!--Description of dashboard page

@author Ashan Rathsara-->


<html lang="en">



    <head>
        <!-- Styles -->
        <title><?php echo $title ?></title>
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
                                <li class="active"><a href="index.html">BUDGET RELEVANCE</a></li>

                            </ol>


                            <div class="page-tabs">
                                <ul class="nav nav-tabs">

                                    <li class="active"><a data-toggle="tab" href="#tab1">BUDGET RELEVANCE</a></li>
                                    <li><a data-toggle="tab" href="#tab2">VIEW BUDGET RELEVANCE</a></li>

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
                                                            <div class="panel-heading"><h2>ADD BUDGET RELEVANCE</h2></div>
                                                            <div class="panel-body">
                                                                <form class="form-horizontal" id="frm_allowance_types" name="frm_allowance_types" action="<?php echo base_url(); ?>Master/Br_types/insert_data" method="POST">

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
                                                                        <div class="col-sm-8">
                                                                            <img class="imagecss" src="<?php echo base_url(); ?>assets/images/allowance_types.png" >
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Budget Relevance Name</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="txt_allowance" name="txt_allowance" placeholder="Ex: Budget Relevance I">
                                                                        </div>

                                                                    </div>


                                                                    <div class="form-group col-sm-6 icheck-flat">
                                                                        <label class="col-sm-2 control-label"></label>
                                                                        <div class="col-sm-8 icheck-flat">
                                                                            <label class="checkbox green icheck col-sm-5">
                                                                                <input type="checkbox" id="isFixed" name="isFixed" value="1"> IS FIXED
                                                                            </label>
                                                                            <!--                                                                            <label class="checkbox-inline icheck col-sm-5">
                                                                                                                                                            <input type="checkbox" id="isActive" name="isActive" value="1"> IS ACTIVE
                                                                                                                                                        </label>-->
                                                                        </div>
                                                                    </div>



                                                                    <div class="row">
                                                                        <div class="col-sm-8 col-sm-offset-2">
                                                                            <button type="submit" id="submit"  class="btn-primary btn fa fa-check">&nbsp;&nbsp;Submit</button>
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
                                                                <h2>ALLOWANCE DETAILS</h2>
                                                                <div class="panel-ctrls">
                                                                </div>
                                                            </div>
                                                            <div class="panel-body panel-no-padding">
                                                                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>ALLOWANCE NAME</th>
                                                                            <th>IS FIXED</th>
                                                                            <th>IS ACTIVE</th>
                                                                            <th>EDIT</th>
                                                                            <th>DELETE</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        foreach ($data_set as $data) {


                                                                            echo "<tr class='odd gradeX'>";


                                                                            echo "<td width='100'>" . $data->ID . "</td>";
                                                                            echo "<td width='100'>" . $data->Br_name . "</td>";
                                                                            echo "<td width='100'>" . $data->isFixed . "</td>";
                                                                            echo "<td width='100'>" . $data->IsActive . "</td>";

                                                                            echo "<td width='15'>";
                                                                            echo "<button class='get_data btn btn-green'  data-toggle='modal' data-target='#myModal' title='EDIT' data-id='$data->ID' href='" . base_url() . "index.php/Master/Department/get_details" . $data->ID . "'><i class='fa fa-edit'></i></button>";
                                                                            echo "</td>";

                                                                            echo "<td width='15'>";


                                                                            echo "<button  class=' btn btn-danger' data-toggle='modal' href='javascript:void()' title='DELETE' onclick='delete_id($data->ID)'><i class='fa fa-times-circle'></i></a>";


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

                                    <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h2 class="modal-title">BUDGET RELEVANCE</h2>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="<?php echo base_url(); ?>Master/Holiday_Types/edit" method="post">
                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">ID</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->ID; ?>" type="text" class="form-control" readonly="readonly" name="id" id="id" class="m-wrap span3" >
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">CODE</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->Br_name; ?>" type="text" name="H_Code" id="H_Code"  class="form-control m-wrap span6"><br>
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


                                </div>

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
                <script src="<?php echo base_url(); ?>system_js/Administration/Allowance_types.js"></script>
                <script type="text/javascript">
                $(document).ready(function () {
                    $("#frm_designation").validate();
                    $("#spnmessage").hide("shake", {times: 6}, 3000);
                });
            </script>

                </body>


                </html>