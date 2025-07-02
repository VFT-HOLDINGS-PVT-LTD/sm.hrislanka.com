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
                            <li class="active"><a href="index.html">EMPLOYEE GROUPS</a></li>

                        </ol>


                        <div class="page-tabs">
                            <ul class="nav nav-tabs">

                                <li class="active"><a data-toggle="tab" href="#tab1">EMPLOYEE GROUPS</a></li>
                                <li><a data-toggle="tab" href="#tab2">VIEW EMPLOYEE GROUPS</a></li>


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
                                                            <h2>ADD EMPLOYEE GROUPS</h2>
                                                        </div>
                                                        <div class="panel-body">
                                                            <form class="form-horizontal" id="frm_emp_group" name="frm_emp_group" action="<?php echo base_url(); ?>Master/Employee_Groups/insert_Data" method="POST">
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
                                                                        <img class="imagecss" src="<?php echo base_url(); ?>assets/images/employee_group.png">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-12">

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Group Name</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="txt_group_name" name="txt_group_name" placeholder="Ex: Office">
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Group Supervisor</label>
                                                                        <div class="col-sm-8">
                                                                            <select class="form-control" id="cmb_Supervisor" name="cmb_Supervisor">

                                                                                <option value="" default>-- Select --</option>
                                                                                <?php foreach ($emp_sup as $t_data) { ?>
                                                                                    <option value="<?php echo $t_data->EmpNo; ?>"><?php echo $t_data->Emp_Full_Name; ?></option>

                                                                                <?php }
                                                                                ?>



                                                                            </select>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-12">
                                                                    <div class="form-group col-sm-6">
                                                                        <!-- <label for="focusedinput" class="col-sm-4 control-label">OT Morning</label>
                                                                        <div class="col-sm-2 icheck-flat">
                                                                            <div class="checkbox green icheck">
                                                                                <label><input type="checkbox" name="ot_m" id="chk_1st"></label>
                                                                            </div>
                                                                        </div> -->
                                                                        <label for="focusedinput" class="col-sm-4 control-label">OT Evening</label>
                                                                        <div class="col-sm-2 icheck-flat">
                                                                            <div class="checkbox green icheck">
                                                                                <label><input type="checkbox" name="ot_e" id="chk_1st"></label>
                                                                            </div>
                                                                        </div>
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Min Time to Evening OT</label>
                                                                        <div class="col-sm-2">
                                                                            <input type="number" class="form-control" id="txt_max_l_size" name="min_t_e_ot" placeholder="Ex: 120">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-sm-6">
                                                                    <label for="focusedinput" class="col-sm-4 control-label">Late</label>
                                                                        <div class="col-sm-2 icheck-flat">
                                                                            <div class="checkbox green icheck">
                                                                                <label><input type="checkbox" name="late" id="chk_1st"></label>
                                                                            </div>
                                                                        </div>
                                                                        <label for="focusedinput" class="col-sm-4 control-label">ED</label>
                                                                        <div class="col-sm-2 icheck-flat">
                                                                            <div class="checkbox green icheck">
                                                                                <label><input type="checkbox" name="ed" id="chk_1st"></label>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <!-- <div class="form-group col-sm-6">
                                                                        
                                                                    </div> -->
                                                                    <!-- <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-5 control-label">Late decuct for Leave in Half Day</label>
                                                                        <div class="col-sm-1 icheck-flat">
                                                                            <div class="checkbox green icheck">
                                                                                <label><input type="checkbox" name="sh_lv" id="chk_1st"></label>
                                                                            </div>
                                                                        </div>
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Late deduct from OT</label>
                                                                        <div class="col-sm-2 icheck-flat">
                                                                            <div class="checkbox green icheck">
                                                                                <label><input type="checkbox" name="late_ot" id="chk_1st"></label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Double OT for Holiday</label>
                                                                        <div class="col-sm-2 icheck-flat">
                                                                            <div class="checkbox green icheck">
                                                                                <label><input type="checkbox" name="dot_holyday" id="chk_1st"></label>
                                                                            </div>
                                                                        </div>
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Double OT for OFF Day</label>
                                                                        <div class="col-sm-2 icheck-flat">
                                                                            <div class="checkbox green icheck">
                                                                                <label><input type="checkbox" name="dot_offday" id="chk_1st"></label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Round Up</label>
                                                                        <div class="col-sm-2">
                                                                            <input type="number" class="form-control" id="txt_max_l_size" name="round" placeholder="Ex: 120">
                                                                        </div>
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Late Grace Period</label>
                                                                        <div class="col-sm-2">
                                                                        <input type="number"  class="form-control" id="txt_max_l_size" name="late_gp" placeholder="Ex: 120">
                                                                        </div>

                                                                    </div> -->

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
                                                            <h2>USER LEVEL DETAILS</h2>
                                                            <div class="panel-ctrls">
                                                            </div>
                                                        </div>
                                                        <div class="panel-body panel-no-padding">
                                                            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>NAME</th>
                                                                        <th>OT MORNING</th>
                                                                        <th>OT EVENING</th>
                                                                        <th>LATE</th>
                                                                        <th>EARLY DEPARTURE</th>
                                                                        <th>GRACE PERIOD</th>
                                                                        <th>SUPERVISOR NAME</th>

                                                                        <!--<th>EDIT</th>-->
                                                                        <!--<th>DELETE</th>-->

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    foreach ($data_set as $data) {
                                                                    ?>
                                                                        <tr class='odd gradeX'>
                                                                            <td width='100'><?php echo $data->Grp_ID; ?></td>
                                                                            <td width='100'><?php echo $data->EmpGroupName; ?></td>
                                                                            <td width='50'><?php echo $data->Ot_m; ?></td>
                                                                            <td width='50'><?php echo $data->Ot_e; ?></td>
                                                                            <td width='100'><?php echo $data->Late; ?></td>
                                                                            <td width='50'><?php echo $data->Ed; ?></td>
                                                                            <td width='50'><?php echo $data->late_Grs_prd; ?></td>
                                                                            <td width='200'><?php echo $data->Emp_Full_Name; ?></td>
                                                                            <!--<td width='15'>-->
                                                                            <!--<?php $url = base_url() . "Master/Employee_Groups/updateAttView?id=$data->Grp_ID"; ?>-->
                                                                            <!--    <a class="edit_data btn btn-green"-->
                                                                            <!--        href="<?php echo $url; ?>" title="EDIT">-->
                                                                            <!--        <i class="fa fa-edit"></i> </a>-->
                                                                            <!--</td>-->
                                                                            <!--<td width='15'>-->
                                                                            <!--    <button class='action_comp btn btn-danger' data-toggle='modal' href='javascript:void()' title='DELETE' onclick='delete_id([Grp_ID])'>-->
                                                                            <!--        <i class='fa fa-times-circle'></i>-->
                                                                            <!--    </button>-->
                                                                            <!--</td>-->
                                                                        </tr>
                                                                    <?php
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
        <!-- <script src="<?php echo base_url(); ?>system_js/Master/Emp_Group.js"></script> -->

</body>

<script>
    $("#success_message_my").hide("bounce", 2000, 'fast');
    $("#submit").click(function() {
        $('#search_body').html('<center><p><img style="width: 50;height: 50;" src="<?php echo base_url(); ?>assets/images/processing.gif" /></p><center>');

    });
</script>

</html>