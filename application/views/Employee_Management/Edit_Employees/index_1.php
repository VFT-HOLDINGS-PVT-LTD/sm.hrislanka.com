<!DOCTYPE html>


<!--Description of dashboard page

@author Ashan Rathsara-->


<html lang="en">


    <head>
        <title><?php echo $title ?></title>
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

                                <li class=""><a href="#">HOME</a></li>
                                <li class="active"><a href="#">EMPLOYEES</a></li>

                            </ol>


                            <div class="page-tabs">
                                <ul class="nav nav-tabs">

                                    <li class="active"><a data-toggle="tab" href="#tab1">EMPLOYEES</a></li>
                                    <li><a data-toggle="tab" href="#tab2">VIEW EMPLOYEES</a></li>


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
                                                            <div class="panel-heading"><h2>ADD EMPLOYEES</h2></div>
                                                            <div class="panel-body">
                                                                <form class="form-horizontal">

                                                                    <div class="form-group col-sm-12">
                                                                        <div class="col-sm-8">
                                                                            <img class="imagecss" src="<?php echo base_url(); ?>assets/images/user-group.png" >
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Employee No</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="focusedinput" placeholder="00001">
                                                                            </div>

                                                                        </div>
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">EPF No</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="focusedinput" placeholder="Ex: 00001">
                                                                            </div>

                                                                        </div>

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Title</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" id="cmb_ot_pattern" name="cmb_ot_pattern">

                                                                                    <option value="Unknown.">Unknown</option>
                                                                                    <option value="Mr.">Mr.</option>
                                                                                    <option value="Mrs.">Mrs.</option>
                                                                                    <option value="Miss.">Miss.</option>
                                                                                    <option value="Dr.">Dr.</option>


                                                                                </select></div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-12">

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">First Name</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="focusedinput" placeholder="Ex: Ashan">
                                                                            </div>

                                                                        </div>

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Last Name</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="focusedinput" placeholder="Ex: Rathsara">
                                                                            </div>

                                                                        </div>
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Name with Initials</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="number" class="form-control" id="focusedinput" placeholder="Ex: L. Ashan Rathsara">
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group col-md-12">

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Gender</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" id="cmb_ot_pattern" name="cmb_ot_pattern">

                                                                                    <option value="Male">Male</option>
                                                                                    <option value="Female">Female</option>
                                                                                </select></div>

                                                                        </div>

                                                                        <div class="form-group col-sm-6 ">
                                                                            <label class="col-sm-4 control-label">Status</label>
                                                                            <div class="col-sm-8">
                                                                                <label class="radio-inline icheck">
                                                                                    <input type="radio" id="inlineradio1" value="option1" name="optionsRadiosInline" > Active
                                                                                </label>
                                                                                <label class="radio-inline icheck">
                                                                                    <input type="radio" id="inlineradio2" value="option2" name="optionsRadiosInline" > Inactive
                                                                                </label>

                                                                            </div>

                                                                        </div>
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Designation</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" required="" id="cmb_desig" name="cmb_desig" >


                                                                                    <option value="" default>-- Select --</option>
                                                                                    <?php foreach ($data_desig as $t_data) { ?>
                                                                                        <option value="<?php echo $t_data->id; ?>" ><?php echo $t_data->Desig_Name; ?></option>

                                                                                    <?php }
                                                                                    ?>        

                                                                                </select>
                                                                            </div>

                                                                        </div>
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Department</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" required="" id="cmb_dep" name="cmb_dep" >


                                                                                    <option value="" default>-- Select --</option>
                                                                                    <?php foreach ($data_dep as $t_data) { ?>
                                                                                        <option value="<?php echo $t_data->id; ?>" ><?php echo $t_data->Dep_Name; ?></option>

                                                                                    <?php }
                                                                                    ?>        

                                                                                </select>
                                                                            </div>

                                                                        </div>

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Employee Group</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" required="" id="cmb_desig" name="cmb_dep" >


                                                                                    <option value="" default>-- Select --</option>
                                                                                    <?php foreach ($data_dep as $t_data) { ?>
                                                                                        <option value="<?php echo $t_data->id; ?>" ><?php echo $t_data->Dep_Name; ?></option>

                                                                                    <?php }
                                                                                    ?>        

                                                                                </select>
                                                                            </div>

                                                                        </div>
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Roster Pattern</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" id="cmb_ot_pattern" name="cmb_ot_pattern">

                                                                                    <option >--Select--</option>
                                                                                    <option value="HIGH">HIGH</option>
                                                                                    <option value="MEDIUM">MEDIUM</option>
                                                                                    <option value="LOW">LOW</option>
                                                                                </select></div>

                                                                        </div>
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">OT Pattern</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" id="cmb_ot_pattern" name="cmb_ot_pattern">

                                                                                    <option >--Select--</option>
                                                                                    <option value="HIGH">HIGH</option>
                                                                                    <option value="MEDIUM">MEDIUM</option>
                                                                                    <option value="LOW">LOW</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group col-md-12">

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Address</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="focusedinput" placeholder="Ex: No:123, Street, City">
                                                                            </div>

                                                                        </div>

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Telephone</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="focusedinput" placeholder="Ex: 011 456 789">
                                                                            </div>

                                                                        </div>
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">E Mail</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="number" class="form-control" id="focusedinput" placeholder="Ex: abc@abc.com">
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group col-md-12">

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">NIC</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="focusedinput" placeholder="Ex: 924578951V">
                                                                            </div>

                                                                        </div>

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Birthday</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="date" class="form-control" id="datepicker">
                                                                            </div>

                                                                        </div>



                                                                    </div>


                                                                    <div class="form-group col-md-12">


                                                                        <div class="form-group col-sm-12 icheck-flat">
                                                                            <label class="col-sm-2 control-label"></label>
                                                                            <div class="col-sm-8 icheck-flat">
                                                                                <label class="checkbox green icheck col-sm-5">
                                                                                    <input type="checkbox" id="inlinecheckbox1" value="cctv"> IS ACTIVE
                                                                                </label>

                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Username</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="focusedinput" placeholder="Ex: Ashan">
                                                                            </div>

                                                                        </div>

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Password</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="password" class="form-control" id="datepicker">
                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-sm-8 col-sm-offset-2">
                                                                            <button class="btn-primary btn fa fa-check">Submit</button>
                                                                            <button class="btn-default btn">Cancel</button>
                                                                        </div>
                                                                    </div>

                                                                </form>
                                                                <hr>




                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                                <!--					<div class="tab-content">
                                                                                        <div class="tab-pane active" id="horizontal-form">
                                                                                                <form class="form-horizontal">
                                                                                                        <div class="form-group">
                                                                                                                <label for="focusedinput" class="col-sm-3 control-label">Designation Code</label>
                                                                                                                <div class="col-sm-8">
                                                                                                                        <input type="text" class="form-control" id="focusedinput" placeholder="Default Input">
                                                                                                                </div>
                                                                                                                
                                                                                                        </div>
                                                                                                </form>
                                                                                        </div>
                                                                                        
                                                                                </div>-->
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

            <?php $this->load->view('template/js.php'); ?>							<!-- Initialize scripts for this page-->

            <!-- End loading page level scripts-->



    </body>


</html>