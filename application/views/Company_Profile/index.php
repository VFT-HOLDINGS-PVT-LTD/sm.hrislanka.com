<!DOCTYPE html>


<!--Description of dashboard page

@author Ashan Rathsara-->


<html lang="en">

    <title><?php echo $title ?></title>

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
                                <li class="active"><a href="index.html">COMPANY PROFILE</a></li>

                            </ol>


                            <div class="page-tabs">
                                <ul class="nav nav-tabs">

                                    <li class="active"><a data-toggle="tab" href="#tab1">COMPANY PROFILE</a></li>
                                    <li><a data-toggle="tab" href="#tab2">COMPANY PROFILE</a></li>


                                </ul>
                            </div>
                            <div class="container-fluid">


                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">

                                        <div class="row">
                                            <div class="col-xs-12">

                                                <img src=""
                                                     <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-primary">
                                                            <div class="panel-heading"><h2>ADD COMPANY PROFILE</h2></div>
                                                            <div class="panel-body">
                                                                <form class="form-horizontal" id="frm_comp_pro" name="frm_comp_pro" action="<?php echo base_url(); ?>Company_Profile/Company_Profile/insert_Data" method="POST" enctype="multipart/form-data">

                                                                    <div class="form-group col-sm-12">
                                                                        <div class="col-sm-8">
                                                                            <img class="imagecss" src="<?php echo base_url(); ?>assets/images/company.png" >
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Company Name</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" required="" name="txt_comp_name" id="txt_comp_name" placeholder="Ex: ABC Company (PVT) Ltd.">
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Company Address</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" required="" name="txt_comp_ad" id="txt_comp_ad" placeholder="Ex: No:123, Blank Road, Country">
                                                                        </div>

                                                                    </div>

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Company Telephone</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" required="" name="txt_comp_tel" id="txt_comp_tel" placeholder="Ex: 0112242321">
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Company E Mail</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" name="txt_comp_email" id="txt_comp_email" placeholder="Ex: info@abc.com">
                                                                        </div>

                                                                    </div>

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Company Web</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" name="txt_comp_web" id="txt_comp_web" placeholder="www.company.com">
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Company Business Registration</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" name="txt_comp_reg" id="txt_comp_reg" placeholder="Ex: ">
                                                                        </div>

                                                                    </div>

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Company Logo</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="file" class="form-control" name="txt_comp_logo" id="txt_comp_logo" placeholder="Ex: ">
                                                                        </div>

                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-sm-8 col-sm-offset-2">
                                                                            <button type="submit" id="submit"  class="btn-primary btn fa fa-check">&nbsp;&nbsp;SUBMIT</button>
                                                                            <button type="button" id="Cancel" name="Cancel" class="btn btn-danger-alt fa fa-times-circle">&nbsp;&nbsp;CANCEL</button>
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
                                                                            <th>COMPANY NAME</th>
                                                                            <th>ADDRESS</th>
                                                                            <th>TELEPHONE</th>
                                                                            <th>E-MAIL</th>
                                                                            <th>REG. NO</th>
                                                                            <th>LOGO</th>
                                                                            <th>EDIT</th>
                                                                            <th>DELETE</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        foreach ($data_set as $data) {


                                                                            echo "<tr class='odd gradeX'>";


                                                                            echo "<td width='100'>" . $data->Cmp_ID . "</td>";
                                                                            echo "<td width='100'>" . $data->Company_Name . "</td>";
                                                                            echo "<td width='100'>" . $data->comp_Address . "</td>";
                                                                            echo "<td width='100'>" . $data->comp_Tel . "</td>";
                                                                            echo "<td width='100'>" . $data->comp_Email . "</td>";
                                                                            echo "<td width='100'>" . $data->comp_reg_no . "</td>";
                                                                            echo "<td width='100'>" . $data->comp_logo . "</td>";

                                                                            echo "<td width='15'>";
                                                                            echo "<button class='get_data btn btn-green'  data-toggle='modal' data-target='#myModal' title='EDIT' data-id='$data->Cmp_ID' href='" . base_url() . "index.php/Master/Department/get_details" . $data->Cmp_ID . "'><i class='fa fa-edit'></i></button>";
                                                                            echo "</td>";

                                                                            echo "<td width='15'>";


                                                                            echo "<button  class=' btn btn-danger' data-toggle='modal' href='javascript:void()' title='DELETE' onclick='delete_id($data->Cmp_ID)'><i class='fa fa-times-circle'></i></a>";


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
                                                    <h2 class="modal-title">COMPANY PROFILE</h2>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" action="<?php echo base_url(); ?>Company_Profile/Company_Profile/edit" method="post">
                                                        <div class="form-group col-sm-12">
                                                            <label for="focusedinput" class="col-sm-4 control-label">ID</label>
                                                            <div class="col-sm-8">
                                                                <input value="<?php echo $data->Cmp_ID; ?>" type="text" class="form-control" readonly="readonly" name="id" id="id" class="m-wrap span3" >
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-sm-12">
                                                            <label for="focusedinput" class="col-sm-4 control-label">COMPANY NAME</label>
                                                            <div class="col-sm-8">
                                                                <input value="<?php echo $data->Company_Name; ?>" type="text" name="Company_Name" id="Company_Name"  class="form-control m-wrap span6"><br>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm-12">
                                                            <label for="focusedinput" class="col-sm-4 control-label">ADDRESS</label>
                                                            <div class="col-sm-8">
                                                                <input value="<?php echo $data->comp_Address; ?>" type="text" name="comp_Address" id="comp_Address"  class="form-control m-wrap span6"><br>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm-12">
                                                            <label for="focusedinput" class="col-sm-4 control-label">TELEPHONE</label>
                                                            <div class="col-sm-8">
                                                                <input value="<?php echo $data->comp_Tel; ?>" type="text" name="comp_Tel" id="comp_Tel"  class="form-control m-wrap span6"><br>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm-12">
                                                            <label for="focusedinput" class="col-sm-4 control-label">E-MAIL</label>
                                                            <div class="col-sm-8">
                                                                <input value="<?php echo $data->comp_Email; ?>" type="text" name="comp_Email" id="comp_Email"  class="form-control m-wrap span6"><br>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm-12">
                                                            <label for="focusedinput" class="col-sm-4 control-label">WEB</label>
                                                            <div class="col-sm-8">
                                                                <input value="<?php echo $data->comp_web; ?>" type="text" name="comp_web" id="comp_web"  class="form-control m-wrap span6"><br>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm-12">
                                                            <label for="focusedinput" class="col-sm-4 control-label">REG. NO</label>
                                                            <div class="col-sm-8">
                                                                <input value="<?php echo $data->comp_reg_no; ?>" type="text" name="comp_reg_no" id="comp_reg_no"  class="form-control m-wrap span6"><br>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm-12">
                                                            <label for="focusedinput" class="col-sm-4 control-label">LOGO</label>
                                                            <div class="col-sm-8">
                                                                <input value="<?php echo $data->comp_logo; ?>" type="text" name="comp_logo" id="comp_logo"  class="form-control m-wrap span6"><br>
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
            <script src="<?php echo base_url(); ?>system_js/Company_Profile/profile.js"></script>

    </body>


</html>