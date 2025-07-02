<!--Add Employee

@author Ashan Rathsara-->


<html lang="en">


    <head>
        <title><?php echo $title ?></title>
        <!-- Styles -->
        <?php $this->load->view('template/css.php'); ?>


    </head>

    <style type="text/css">.thumb-image{float:left;width:200px; height: 250px;position:relative;padding:5px;}</style>

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

                                <li class=""><a href="#">HOME</a></li>
                                <li class="active"><a href="#">EMPLOYEES</a></li>

                            </ol>


                            <div class="page-tabs">
                                <ul class="nav nav-tabs">

                                    <li class="active"><a data-toggle="tab" href="#tab1">EMPLOYEES</a></li>



                                </ul>
                            </div>
                            <div class="container-fluid">


                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">

                                        <div class="row">
                                            <div class="col-xs-12">


                                                <div class="panel panel-midnightblue">
                                                    <div class="panel-heading">
                                                        <h2>EMPLOYEE</h2>
                                                        <!--                                                        <div class="options">
                                                                                                                    <ul class="nav nav-tabs">
                                                        
                                                                                                                        <li class="active"><a href="#horizontal-form" data-toggle="tab">MASTER</a></li>
                                                                                                                        <li ><a href="#vertical-form" data-toggle="tab">PERSONAL DETAILS</a></li>
                                                                                                                        <li><a href="#bordered-row" data-toggle="tab">OTHER DETAILS</a></li>
                                                                                                                        <li><a href="#login" data-toggle="tab">LOGIN DETAILS</a></li>
                                                                                                                        <li><a href="#tabular-form" data-toggle="tab">DOCUMENTS</a></li>
                                                                                                                    </ul>
                                                                                                                </div>-->
                                                    </div>
                                                    <div class="panel-body ">
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="horizontal-form">
                                                                <form class="form-horizontal" id="frm_employee_update" name="frm_employee_update" action="<?php echo base_url(); ?>Employee_Management/Edit_Employees/update_emp" method="POST" enctype="multipart/form-data">

                                                                    <!--success Message-->
                                                                    <?php if (isset($_SESSION['success_message']) && $_SESSION['success_message'] != '') { ?>
                                                                        <div id="spnmessage" class="alert alert-dismissable alert-success">
                                                                            <strong>Success !</strong> <?php echo $_SESSION['success_message'] ?>
                                                                        </div>
                                                                    <?php } ?>

                                                                    <div class="form-group col-sm-12">
                                                                        <div class="col-sm-8">
                                                                            <img class="imagecss" src="<?php echo base_url(); ?>assets/images/user-group.png" >
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="form-group col-sm-6" style="margin-left: -15px;">
                                                                    <label for="focusedinput" class="col-sm-4 control-label">Company Emp No</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" id="companyNo" name="companyNo" placeholder="Company No" required="" value="<?php echo $data_set[0]->Company_No ?>">
                                                                        <div id="username_availability_result"></div>
                                                                        <!--<input class="btn btn-green" type="button" id="check_username_availability" value="Check Availability">-->
                                                                    </div>
                                                                     </div>

                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Employee No</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" value="<?php echo $data_set[0]->EmpNo ?>" id="txt_emp_no" name="txt_emp_no" placeholder="Ex: 00001">
                                                                            </div>

                                                                        </div>

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Enroll No</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" value="<?php echo $data_set[0]->Enroll_No ?>" id="txt_enroll_no" name="txt_enroll_no" placeholder="Ex: 1">
                                                                            </div>

                                                                        </div>

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">EPF No</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" value="<?php echo $data_set[0]->EPFNO ?>" id="txt_epf_no" required="" name="txt_epf_no" placeholder="Ex: 1">
                                                                            </div>

                                                                        </div>



                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">EPF Category</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" id="cmb_epf_cat" name="cmb_epf_cat" >


                                                                                    <option value="" default>-- Select --</option>


                                                                                    <?php
                                                                                    foreach ($data_epf as $t_data) {
                                                                                        if ($t_data->EPF_CAT == $data_set[0]->EPF_CAT) {
                                                                                            echo "<option selected value='" . $t_data->EPF_CAT . "'>" . $t_data->EPF_CAT_Name . "</option>";
                                                                                        } else {
                                                                                            echo "<option value='" . $t_data->EPF_CAT . "'>" . $t_data->EPF_CAT_Name . "</option>";
                                                                                        }
                                                                                    }
                                                                                    ?>

                                                                                </select>
                                                                            </div>

                                                                        </div>


                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Occupation Code</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" value="<?php echo $data_set[0]->OCP_Code ?>" id="txt_ocp_code" required="" name="txt_ocp_code" placeholder="Ex: 15">
                                                                            </div>

                                                                        </div>


                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Title</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" id="cmb_emp_title" name="cmb_emp_title">
                                                                                    <option value="<?php echo $data_set[0]->Title ?>"><?php echo $data_set[0]->Title ?></option>
                                                                                    <option value="Unknown.">Unknown</option>
                                                                                    <option value="Mr.">Mr.</option>
                                                                                    <option value="Mrs.">Mrs.</option>
                                                                                    <option value="Miss.">Miss.</option>
                                                                                    <option value="Dr.">Dr.</option>
                                                                                </select>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-12">

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Full Name</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" value="<?php echo $data_set[0]->Emp_Full_Name ?>" id="txt_emp_name" name="txt_emp_name" required="" placeholder="Ex: Ashan Rathsara">
                                                                            </div>

                                                                        </div>


                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Initials</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" value="<?php echo $data_set[0]->Emp_Name_Int ?>" id="txt_emp_name_init" name="txt_emp_name_init" required="" placeholder="Ex: L.A.R">
                                                                            </div>

                                                                        </div>


                                                                        <div class="form-group col-sm-6">

                                                                            <label for="focusedinput" class="col-sm-4 control-label">Image</label>
                                                                            <div class="col-sm-6">
                                                                                <div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
                                                                                    <div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 100%; height: 150px;"><img src="<?php echo base_url() . 'assets/images/Employees/' . $data_set[0]->Image ?>"></div>
                                                                                    <div>
                                                                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                                                        <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="img_employee" id="img_employee"></span>

                                                                                    </div>
                                                                                </div>
                                                                            </div>


                                                                        </div>


                                                                    </div>

                                                                    <div class="form-group col-md-12">

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Gender</label>
                                                                            <div class="col-sm-8">
                                                                                <select required="" class="form-control" id="cmb_gender" name="cmb_gender">
                                                                                    <option value="<?php echo $data_set[0]->Gender ?>"><?php echo $data_set[0]->Gender ?></option>
                                                                                    <option value="Male">Male</option>
                                                                                    <option value="Female">Female</option>
                                                                                </select>
                                                                            </div>

                                                                        </div>


                                                                        <div class="form-group col-sm-6 ">
                                                                            <label class="col-sm-4 control-label">Status</label>
                                                                            <div class="col-sm-8">
                                                                                <label class="radio-inline icheck">
                                                                                    <input type="radio" id="inlineradio1" required="" value="Active" <?php echo ($data_set[0]->Status == '1') ? 'checked' : '' ?> name="employee_status" > Active
                                                                                </label>
                                                                                <label class="radio-inline icheck">
                                                                                    <input type="radio" id="inlineradio2" value="Inactive" <?php echo ($data_set[0]->Status == '0') ? 'checked' : '' ?> name="employee_status" > Inactive
                                                                                </label>

                                                                            </div>

                                                                        </div>

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Designation</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" required="" id="cmb_desig" name="cmb_desig" >




                                                                                    <?php
                                                                                    foreach ($data_DS as $t_data) {
                                                                                        if ($t_data->Des_ID == $data_set[0]->Des_ID) {
                                                                                            echo "<option selected value='" . $t_data->Des_ID . "'>" . $t_data->Desig_Name . "</option>";
                                                                                        } else {
                                                                                            echo "<option value='" . $t_data->Des_ID . "'>" . $t_data->Desig_Name . "</option>";
                                                                                        }
                                                                                    }
                                                                                    ?>



                                                                                </select>
                                                                            </div>

                                                                        </div>
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Department</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" required="" id="cmb_dep" name="cmb_dep" >


                                                                                    <?php
                                                                                    foreach ($data_DP as $t_data) {
                                                                                        if ($t_data->Dep_ID == $data_set[0]->Dep_ID) {
                                                                                            echo "<option selected value='" . $t_data->Dep_ID . "'>" . $t_data->Dep_Name . "</option>";
                                                                                        } else {
                                                                                            echo "<option value='" . $t_data->Dep_ID . "'>" . $t_data->Dep_Name . "</option>";
                                                                                        }
                                                                                    }
                                                                                    ?>

                                                                                </select>
                                                                            </div>

                                                                        </div>
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Employee Group</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" required="" id="cmb_group" name="cmb_group" >

                                                                                    <?php
                                                                                    foreach ($data_Grp as $t_data) {
                                                                                        if ($t_data->Grp_ID == $data_set[0]->Grp_ID) {
                                                                                            echo "<option selected value='" . $t_data->Grp_ID . "'>" . $t_data->EmpGroupName . "</option>";
                                                                                        } else {
                                                                                            echo "<option value='" . $t_data->Grp_ID . "'>" . $t_data->EmpGroupName . "</option>";
                                                                                        }
                                                                                    }
                                                                                    ?>       

                                                                                </select>
                                                                            </div>

                                                                        </div>


                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Roster Pattern</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" id="cmb_roster_pattern" name="cmb_roster_pattern">
                                                                                    <?php
                                                                                    foreach ($data_Rstr as $t_data) {
                                                                                        if ($t_data->RosterCode == $data_set[0]->RosterCode) {
                                                                                            echo "<option selected value='" . $t_data->RosterCode . "'>" . $t_data->RosterName . "</option>";
                                                                                        } else {
                                                                                            echo "<option value='" . $t_data->RosterCode . "'>" . $t_data->RosterName . "</option>";
                                                                                        }
                                                                                    }
                                                                                    ?>     
                                                                                </select></div>

                                                                        </div>


                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Branch</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" id="cmb_branch" name="cmb_branch">



                                                                                    <?php
                                                                                    foreach ($data_branch as $t_data) {
                                                                                        if ($t_data->B_id == $data_set[0]->B_id) {
                                                                                            echo "<option selected value='" . $t_data->B_id . "'>" . $t_data->B_name . "</option>";
                                                                                        } else {
                                                                                            echo "<option value='" . $t_data->B_id . "'>" . $t_data->B_name . "</option>";
                                                                                        }
                                                                                    }
                                                                                    ?> 

                                                                                </select>
                                                                            </div>
                                                                        </div>



                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">OT Pattern</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" id="cmb_ot_pattern" name="cmb_ot_pattern">
                                                                                    <?php
                                                                                    foreach ($data_ot as $t_data) {
                                                                                        if ($t_data->OTCode == $data_set[0]->OTCode) {
                                                                                            echo "<option selected value='" . $t_data->OTCode . "'>" . $t_data->OTName . "</option>";
                                                                                        } else {
                                                                                            echo "<option value='" . $t_data->OTCode . "'>" . $t_data->OTName . "</option>";
                                                                                        }
                                                                                    }
                                                                                    ?>   
                                                                                </select>
                                                                            </div>
                                                                        </div>




                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Appoint Date</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" value="<?php echo $data_set[0]->ApointDate ?>" id="txt_appoint_date" name="txt_appoint_date" required="" placeholder="Ex: 35500">
                                                                            </div>

                                                                        </div>


                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Permanent Date</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="txt_permanent_date" value="<?php echo $data_set[0]->Permanent_Date ?>" name="txt_permanent_date"  placeholder="Select Date">
                                                                            </div>

                                                                        </div>








                                                                    </div>






<!--                                                                    <div class="tab-pane" id="vertical-form">

                                                                        <label style="font-weight: bold; color: #000">Payroll Details</label>
                                                                        <hr>



                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Basic Salary</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" value="<?php echo $data_set[0]->Basic_Salary ?>" id="txt_basic_sal" name="txt_basic_sal" required="" placeholder="Ex: 35500">
                                                                            </div>

                                                                        </div>



                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Incentive</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" value="<?php echo $data_set[0]->Incentive ?>" id="txt_Incentive" name="txt_Incentive" required="" placeholder="Ex: 15500">
                                                                            </div>

                                                                        </div>


                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Budgetary Allowance</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" value="<?php echo $data_set[0]->Fixed_Allowance ?>" id="txt_BG_Allowance" name="txt_BG_Allowance" required="" placeholder="Ex: 5500">
                                                                            </div>

                                                                        </div>




                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Bank</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" id="cmb_bank" name="cmb_bank">

                                                                                    <?php
                                                                                    foreach ($data_bank as $t_data) {
                                                                                        if ($t_data->Bnk_ID == $data_set[0]->Bnk_ID) {
                                                                                            echo "<option selected value='" . $t_data->Bnk_ID . "'>" . $t_data->bank_name . "</option>";
                                                                                        } else {
                                                                                            echo "<option value='" . $t_data->Bnk_ID . "'>" . $t_data->bank_name . "</option>";
                                                                                        }
                                                                                    }
                                                                                    ?>  

                                                                                </select>
                                                                            </div>
                                                                        </div>



                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Branch ID</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" value="<?php echo $data_set[0]->Bnk_Br_ID ?>" id="txt_B_Branch" name="txt_B_Branch" placeholder="Ex: 023">
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Account No</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" value="<?php echo $data_set[0]->Account_no ?>" id="txt_account" name="txt_account" placeholder="Ex: 112457854">
                                                                            </div>
                                                                        </div>

                                                                    </div>-->














                                                                    <div class="row">

                                                                    </div>






                                                                    <div class="tab-pane" id="vertical-form">

                                                                        <label style="font-weight: bold; color: #000">Personal Details</label>
                                                                        <hr>

                                                                        <div class="form-group col-md-12">

                                                                            <div class="form-group col-sm-6">
                                                                                <label for="focusedinput" class="col-sm-4 control-label">Full Address</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="text" class="form-control" value="<?php echo $data_set[0]->Address ?>" id="txt_address" name="txt_address" placeholder="Ex: No: 123, Street, City">
                                                                                </div>

                                                                            </div>

                                                                            <div class="form-group col-sm-6">
                                                                                <label for="focusedinput" class="col-sm-4 control-label">City</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="text" class="form-control" value="<?php echo $data_set[0]->City ?>" id="txt_city" name="txt_city" placeholder="Ex: No: 123, Street, City">
                                                                                </div>

                                                                            </div>

                                                                            <div class="form-group col-sm-6">
                                                                                <label for="focusedinput" class="col-sm-4 control-label">District</label>
                                                                                <div class="col-sm-8">
                                                                                    <select class="form-control" id="cmb_district" name="cmb_district">

                                                                                        <option value="<?php echo $data_set[0]->District ?>"><?php echo $data_set[0]->District ?></option>
                                                                                        <option value="Unknown">Unknown</option>
                                                                                        <option value="Ampara">Ampara</option>
                                                                                        <option value="Anuradhapura">Anuradhapura</option>
                                                                                        <option value="Badulla">Badulla</option>
                                                                                        <option value="Batticaloa">Batticaloa</option>
                                                                                        <option value="Colombo">Colombo</option>
                                                                                        <option value="Galle">Galle</option>
                                                                                        <option value="Gampaha">Gampaha</option>
                                                                                        <option value="Hambantota">Hambantota</option>
                                                                                        <option value="Jaffna">Jaffna</option>
                                                                                        <option value="Kalutara">Kalutara</option>
                                                                                        <option value="Kegalle">Kegalle</option>
                                                                                        <option value="Kilinochchi">Kilinochchi</option>
                                                                                        <option value="Kurunegala">Kurunegala</option>
                                                                                        <option value="Kandy">Kandy</option>
                                                                                        <option value="Mannar">Mannar</option>
                                                                                        <option value="Matale">Matale</option>
                                                                                        <option value="Moneragala">Moneragala</option>
                                                                                        <option value="Mullaitivu">Mullaitivu</option>
                                                                                        <option value="NuwaraEliya">NuwaraEliya</option>
                                                                                        <option value="Polonnaruwa">Polonnaruwa</option>
                                                                                        <option value="Puttalam">Puttalam</option>
                                                                                        <option value="Ratnapura">Ratnapura</option>
                                                                                        <option value="Trincomalee">Trincomalee</option>
                                                                                        <option value="Vavuniya">Vavuniya</option>

                                                                                    </select>
                                                                                </div>

                                                                            </div>


                                                                            <div class="form-group col-sm-6">
                                                                                <label for="focusedinput" class="col-sm-4 control-label">Contact No (Home)</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="text" class="form-control" value="<?php echo $data_set[0]->Tel_home ?>" id="txt_cont_home" name="txt_cont_home" placeholder="Ex: 0112 234 567">
                                                                                </div>

                                                                            </div>
                                                                            <div class="form-group col-sm-6">
                                                                                <label for="focusedinput" class="col-sm-4 control-label">Contact No (Mobile)</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="text" class="form-control" value="<?php echo $data_set[0]->Tel_mobile ?>" id="txt_cont_mobile" name="txt_cont_mobile" placeholder="Ex: 071 733 8110">
                                                                                </div>

                                                                            </div>
                                                                            <div class="form-group col-sm-6">
                                                                                <label for="focusedinput" class="col-sm-4 control-label">E Mail</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="text" class="form-control" value="<?php echo $data_set[0]->E_mail ?>" id="txt_email" name="txt_email" placeholder="Ex: ashan.rathsara@gmail.com">
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group col-md-12">

                                                                            <div class="form-group col-sm-6">
                                                                                <label for="focusedinput"  class="col-sm-4 control-label">NIC</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="text" required="" value="<?php echo $data_set[0]->NIC ?>" class="form-control" id="txt_nic" name="txt_nic" placeholder="Ex: 923244786V">
                                                                                </div>

                                                                            </div>
                                                                            <div class="form-group col-sm-6">
                                                                                <label for="focusedinput"  class="col-sm-4 control-label">Passport No</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="text" value="<?php echo $data_set[0]->Passport ?>" class="form-control" id="txt_passport" name="txt_passport" placeholder="Ex: 923244786">
                                                                                </div>

                                                                            </div>

                                                                            <div class="form-group col-sm-6">
                                                                                <label for="focusedinput" class="col-sm-4 control-label">Date of Birth</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="date" class="form-control" value="<?php echo $data_set[0]->DOB ?>" id="txt_dob" name="txt_dob">
                                                                                </div>

                                                                            </div>

                                                                        </div>

                                                                        <div class="form-group col-md-12">
                                                                            <div class="form-group col-sm-6">
                                                                                <label for="focusedinput" class="col-sm-4 control-label">Religion</label>
                                                                                <div class="col-sm-8">
                                                                                    <select class="form-control"  id="cmb_religin" name="cmb_religin">
                                                                                        <option value="<?php echo $data_set[0]->Religion ?>"><?php echo $data_set[0]->Religion ?></option>
                                                                                        <option value="Catholic">Unknown</option>
                                                                                        <option value="Buddhist">Buddhist</option>
                                                                                        <option value="Catholic">Catholic</option>
                                                                                        <option value="Catholic">Hindu</option>
                                                                                        <option value="Catholic">ISLAM</option>
                                                                                        <option value="Catholic">Other</option>

                                                                                    </select></div>

                                                                            </div>

                                                                        </div>

                                                                        <div class="form-group col-md-12">
                                                                            <div class="form-group col-sm-6">
                                                                                <label for="focusedinput" class="col-sm-4 control-label">Civil Status</label>
                                                                                <div class="col-sm-8">
                                                                                    <select class="form-control" id="cmb_civil_status" name="cmb_civil_status">

                                                                                        <option value="<?php echo $data_set[0]->Civil_status ?>"><?php echo $data_set[0]->Civil_status ?></option>
                                                                                        <option value="SINGLE">SINGLE</option>
                                                                                        <option value="MARRIED">MARRIED</option>
                                                                                        <option value="DIVORCED">DIVORCED</option>
                                                                                    </select></div>

                                                                            </div>

                                                                        </div>








                                                                    </div>



                                                                    <div class="row">

                                                                    </div>

                                                                    <div class="tab-pane" id="bordered-row">

                                                                        <label style="font-weight: bold; color: #000">Family Details</label>
                                                                        <hr>
                                                                        <div class="form-horizontal">

                                                                            <div class="form-group col-sm-6">
                                                                                <label for="focusedinput" class="col-sm-2 control-label">Blood Group</label>
                                                                                <div class="col-sm-8">
                                                                                    <select class="form-control" id="cmb_blood" name="cmb_blood">

                                                                                         <option value="<?php echo $data_set[0]->Blood_group ?>"><?php echo $data_set[0]->Blood_group ?></option>
                                                                                        <!--<option >--Select--</option>-->
                                                                                        <option value="A+">A+</option>
                                                                                        <option value="A-">A-</option>
                                                                                        <option value="B+">B+</option>
                                                                                        <option value="B-">B-</option>
                                                                                        <option value="AB">AB</option>
                                                                                        <option value="AB+">AB+</option>
                                                                                        <option value="O">O</option>
                                                                                        <option value="O+">O+</option>
                                                                                    </select>
                                                                                </div>

                                                                            </div>


                                                                            <div class="form-group col-sm-6">
                                                                                <label for="focusedinput" class="col-sm-2 control-label">Relation's Name</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="text" class="form-control" value="<?php echo $data_set[0]->Relations_name ?>" id="txt_rel_name" name="txt_rel_name" placeholder="Mr. Ashan Rathsara">
                                                                                </div>

                                                                            </div>

                                                                            <div class="form-group col-sm-6">
                                                                                <label for="focusedinput" class="col-sm-2 control-label">Relation's Contact No</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="text" class="form-control" value="<?php echo $data_set[0]->Relations_Tel ?>" id="txt_rel_cont" name="txt_rel_cont" placeholder="Mr. 071 111 222">
                                                                                </div>

                                                                            </div>


                                                                            <div class="form-group col-sm-6">
                                                                                <label for="focusedinput" class="col-sm-2 control-label">No of Children</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="text" class="form-control" value="<?php echo $data_set[0]->No_Of_Child ?>" id="txt_no_child" name="txt_no_child" placeholder="Ex: 4">
                                                                                </div>

                                                                            </div>


                                                                        </div>					
                                                                    </div>







                                                                    <div class="tab-pane" id="login">

                                                                        <label style="font-weight: bold; color: #000">Login Details</label>
                                                                        <hr>
                                                                        <div class="form-horizontal">

                                                                            <div class="form-group col-md-12">
                                                                                <div class="form-group col-sm-6">
                                                                                    <div class="form-group icheck-flat">
                                                                                        <label class="col-sm-2 control-label">Is Allow Login</label>
                                                                                        <div class="col-sm-8 icheck-flat">

                                                                                            <label class="checkbox-inline icheck ">
                                                                                                <input type="checkbox" id="Is_Allow" name="Is_Allow">
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>


                                                                                <div class="form-group col-sm-6">
                                                                                    <label for="focusedinput" class="col-sm-2 control-label">User Name</label>
                                                                                    <div class="col-sm-8">
                                                                                        <input type="text" autocomplete="off" class="form-control" value="<?php echo $data_set[0]->username ?>" id="txt_user_name" name="txt_user_name" placeholder="Ashan">
                                                                                    </div>
                                                                                     <div class="col-sm-8">
                                                                                         <a href="<?php echo base_url(); ?>Employee_Management/Edit_Employees/ChangePass/<?php echo $data_set[0]->EmpNo ?>"  class="btn btn-green">Change Password</a>
                                                                                     </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group col-md-12">

                                                                                <!--                                                                        <div class="form-group col-sm-6">
                                                                                                                                                            <label for="focusedinput" class="col-sm-2 control-label">Password</label>
                                                                                                                                                            <div class="col-sm-8">
                                                                                                                                                                <input type="password" class="form-control" value="<?php echo $data_set[0]->password ?>" id="txt_password" name="txt_password" placeholder="user login password">
                                                                                                                                                            </div>
                                                                                
                                                                                                                                                        </div>-->


                                                                                <div class="form-group col-sm-6">
                                                                                    <label for="focusedinput" class="col-sm-2 control-label">User Level</label>
                                                                                    <div class="col-sm-8">
                                                                                        <select class="form-control" required="" id="cmb_user_level" name="cmb_user_level" >

                                                                                            <?php
                                                                                            foreach ($data_u_lvl as $t_data) {
                                                                                                if ($t_data->user_level_id == $data_set[0]->user_level_id) {
                                                                                                    echo "<option selected value='" . $t_data->user_level_id . "'>" . $t_data->user_level_name . "</option>";
                                                                                                } else {
                                                                                                    echo "<option value='" . $t_data->user_level_id . "'>" . $t_data->user_level_name . "</option>";
                                                                                                }
                                                                                            }
                                                                                            ?>  

                                                                                        </select>
                                                                                    </div>

                                                                                </div>

                                                                            </div>


                                                                        </div>					
                                                                    </div>





                                                                    <div class="row">

                                                                    </div>


                                                                  
                                                                  


                                                                            <div class="form-group col-md-12">
                                                                                <div class="form-group col-sm-6">
                                                                                    <label for="focusedinput" class="col-sm-4 control-label">Remarks</label>
                                                                                    <div class="col-sm-8">
                                                                                        <textarea type="text" class="form-control"  id="txt_remarks" name="txt_remarks" placeholder="Ex: Remarks"><?php echo $data_set[0]->Remarks ?></textarea>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group col-md-12">
                                                                                <div class="form-group col-sm-6">
                                                                                    <label for="focusedinput" class="col-sm-4 control-label">Highlights</label>
                                                                                    <div class="col-sm-8">
                                                                                        <textarea type="text" class="form-control" id="txt_high" name="txt_high" placeholder="Ex:"><?php echo $data_set[0]->highlights ?></textarea>
                                                                                    </div>

                                                                                </div>
                                                                            </div>

                                                                   

                                                              

                                                                    <div class="row">

                                                                    </div>

                                                            </div>


                                                            <!--submit button-->
                                                            <?php $this->load->view('template/btn_submit.php'); ?>
                                                            <!--end submit-->

                                                            </form>

                                                            <br>

                                                            <div id="divmessage" class="">

                                                                <div id="spnmessage"> </div>
                                                            </div>

                                                        </div>
                                                    </div>



                                                </div>
                                            </div>

                                        </div>


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

                <?php $this->load->view('template/js.php'); ?>	

                <!-- Initialize scripts for this page-->
                <script src="<?php echo base_url(); ?>assets/plugins/form-jasnyupload/fileinput.min.js"></script>   
                <!-- End loading page level scripts-->
                <!-- Initialize scripts for this page-->

                <!-- End loading page level scripts-->
                <!--Ajax-->
                <!--<script src="<?php echo base_url(); ?>system_js/Master/Employee.js"></script>-->

                <script>

                    $('#txt_appoint_date').datepicker({
                        format: "dd/mm/yyyy",
                        "todayHighlight": true,
                        autoclose: true,
                        format: 'yyyy/mm/dd'
                    }).on('changeDate', function (ev) {
                        $(this).datepicker('hide');
                    });

                    $('#txt_permanent_date').datepicker({
                        format: "dd/mm/yyyy",
                        "todayHighlight": true,
                        autoclose: true,
                        format: 'yyyy/mm/dd'
                    }).on('changeDate', function (ev) {
                        $(this).datepicker('hide');
                    });

                    $('#txt_dob').datepicker({
                        format: "dd/mm/yyyy",
                        "todayHighlight": true,
                        autoclose: true,
                        format: 'yyyy/mm/dd'
                    }).on('changeDate', function (ev) {
                        $(this).datepicker('hide');
                    });


                </script>

                <script>
                    $(document).ready(function () {
                        $("#img_employee").on('change', function () {
                            //Get count of selected files
                            var countFiles = $(this)[0].files.length;
                            var imgPath = $(this)[0].value;
                            var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                            var image_holder = $("#image-holder");
                            image_holder.empty();
                            if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                                if (typeof (FileReader) != "undefined") {
                                    //loop for each file selected for uploaded.
                                    for (var i = 0; i < countFiles; i++)
                                    {
                                        var reader = new FileReader();
                                        reader.onload = function (e) {
                                            $("<img />", {
                                                "src": e.target.result,
                                                "class": "thumb-image"
                                            }).appendTo(image_holder);
                                        }
                                        image_holder.show();
                                        reader.readAsDataURL($(this)[0].files[i]);
                                    }
                                } else {
                                    alert("This browser does not support FileReader.");
                                }
                            } else {
                                alert("Pls select only images");
                            }
                        });
                    });
                </script>


                <!--JQuary Validation-->
                <script type="text/javascript">
                    $(document).ready(function () {
                        $("#frm_employee_update").validate();
                        $("#spnmessage").hide("shake", {times: 4}, 1500);
                    });
                </script>


                </body>


                </html>