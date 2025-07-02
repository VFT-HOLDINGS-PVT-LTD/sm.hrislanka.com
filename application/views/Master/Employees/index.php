<!DOCTYPE html>


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
                                                        <div class="options">
                                                            <ul class="nav nav-tabs">

                                                                <li class="active"><a href="#horizontal-form" data-toggle="tab">MASTER</a></li>
                                                                <li ><a href="#vertical-form" data-toggle="tab">PERSONAL DETAILS</a></li>
                                                                <li><a href="#bordered-row" data-toggle="tab">OTHER DETAILS</a></li>
                                                                <li><a href="#tabular-form" data-toggle="tab">DOCUMENTS</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="panel-body ">
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="horizontal-form">
                                                                <form class="form-horizontal" id="frm_employee" name="frm_employee" action="<?php echo base_url(); ?>Master/Employees/insert_Data" method="POST" enctype="multipart/form-data">

                                                                    <div class="form-group col-sm-12">
                                                                        <div class="col-sm-8">
                                                                            <img class="imagecss" src="<?php echo base_url(); ?>assets/images/user-group.png" >
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Employee No</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="txt_emp_no" name="txt_emp_no" placeholder="Ex: 00001">
                                                                            </div>

                                                                        </div>
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">EPF No</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="txt_epf_no" required="" name="txt_epf_no" placeholder="Ex: 1">
                                                                            </div>

                                                                        </div>
                                                                        

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Title</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" id="cmb_emp_title" name="cmb_emp_title">

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
                                                                                <input type="text" class="form-control" id="txt_emp_name" name="txt_emp_name" required="" placeholder="Ex: Ashan Rathsara">
                                                                            </div>

                                                                        </div>

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Employee Image</label>
                                                                            <div class="col-sm-4">
                                                                                <input type="file" class="form-control" name="img_employee" id="img_employee" placeholder="Ex: ">
                                                                            </div>
                                                                            <div class="col-sm-4">
                                                                                <div id="image-holder"></div>
                                                                            </div>

                                                                        </div>


                                                                    </div>

                                                                    <div class="form-group col-md-12">

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Gender</label>
                                                                            <div class="col-sm-8">
                                                                                <select required="" class="form-control" id="cmb_gender" name="cmb_gender">

                                                                                    <option value="Male">Male</option>
                                                                                    <option value="Female">Female</option>
                                                                                </select></div>

                                                                        </div>

                                                                        <div class="form-group col-sm-6 ">
                                                                            <label class="col-sm-4 control-label">Status</label>
                                                                            <div class="col-sm-8">
                                                                                <label class="radio-inline icheck">
                                                                                    <input type="radio" id="inlineradio1" required="" value="Active" name="employee_status" > Active
                                                                                </label>
                                                                                <label class="radio-inline icheck">
                                                                                    <input type="radio" id="inlineradio2" value="Inactive" name="employee_status" > Inactive
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
                                                                                <select class="form-control" required="" id="cmb_group" name="cmb_group" >


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
                                                                                <select class="form-control" id="cmb_roster_pattern" name="cmb_roster_pattern">

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

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Branch</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" id="cmb_branch" name="cmb_branch">

                                                                                    <option >--Select--</option>
                                                                                    <option value="HIGH">HIGH</option>
                                                                                    <option value="MEDIUM">MEDIUM</option>
                                                                                    <option value="LOW">LOW</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>

<!--                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Basic Salary</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="txt_basic_sal" name="txt_basic_sal" required="" placeholder="Ex: 35500">
                                                                            </div>

                                                                        </div>-->
                                                                        
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Appoint Date</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="date" class="form-control" id="txt_appoint_date" name="txt_appoint_date" required="" placeholder="Ex: 35500">
                                                                            </div>

                                                                        </div>

                                                                    </div>







                                                                    <div class="row">

                                                                    </div>



                                                            </div>


                                                            <div class="tab-pane" id="vertical-form">

                                                                <label style="font-weight: bold; color: #000">Personal Details</label>
                                                                <hr>

                                                                <div class="form-group col-md-12">

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Full Address</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="txt_address" name="txt_address" placeholder="Ex: No: 123, Street, City">
                                                                        </div>

                                                                    </div>

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">City</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="txt_city" name="txt_city" placeholder="Ex: No: 123, Street, City">
                                                                        </div>

                                                                    </div>

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">District</label>
                                                                        <div class="col-sm-8">
                                                                           <select class="form-control" id="cmb_district" name="cmb_district">

                                                                                    <option >--Select--</option>
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
<!--
                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Provincetown</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="txt_address" name="txt_address" placeholder="Ex: No: 123, Street, City">
                                                                        </div>

                                                                    </div>-->

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Contact No (Home)</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="txt_cont_home" name="txt_cont_home" placeholder="Ex: 0112 234 567">
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Contact No (Mobile)</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="txt_cont_mobile" name="txt_cont_mobile" placeholder="Ex: 071 733 8110">
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">E Mail</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="txt_email" name="txt_email" placeholder="Ex: ashan.rathsara@gmail.com">
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-12">

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput"  class="col-sm-4 control-label">NIC</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" required="" class="form-control" id="txt_nic" name="txt_nic" placeholder="Ex: 923244786V">
                                                                        </div>

                                                                    </div>

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Birthday</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="date" class="form-control" id="txt_bday" name="txt_bday">
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                                <div class="form-group col-md-12">
                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Religion</label>
                                                                        <div class="col-sm-8">
                                                                            <select class="form-control"  id="cmb_religin" name="cmb_religin">
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

                                                                                <option value="SINGLE">SINGLE</option>
                                                                                <option value="MARRIED">MARRIED</option>
                                                                                <option value="MARRIED">DIVORCED</option>
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

                                                                                <option >--Select--</option>
                                                                                <option value="HIGH">A+</option>
                                                                                <option value="MEDIUM">A-</option>
                                                                                <option value="HIGH">B+</option>
                                                                                <option value="MEDIUM">B-</option>
                                                                                <option value="LOW">AB</option>
                                                                                <option value="LOW">AB+</option>
                                                                                <option value="LOW">O</option>
                                                                                <option value="LOW">O+</option>
                                                                            </select>
                                                                        </div>

                                                                    </div>

                                                                    
                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-2 control-label">Relation's Name</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="txt_sp_name" name="txt_sp_name" placeholder="Mr. Ashan Rathsara">
                                                                        </div>

                                                                    </div>

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-2 control-label">Relation's Contact No</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="txt_sp_name" name="txt_sp_name" placeholder="Mr. 071 111 222">
                                                                        </div>

                                                                    </div>


                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-2 control-label">No of Children</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="txt_no_child" name="txt_no_child" placeholder="Ex: 4">
                                                                        </div>

                                                                    </div>








                                                                </div>					
                                                            </div>

                                                            <div class="row">

                                                            </div>


                                                            <div class="tab-pane" id="tabular-form">
                                                                <div class="form-horizontal tabular-form">
                                                                   

                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Remarks</label>
                                                                            <div class="col-sm-8">
                                                                                <textarea type="text" class="form-control" id="txt_remarks" name="txt_remarks" placeholder="Ex: Remarks"></textarea>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Highlights</label>
                                                                            <div class="col-sm-8">
                                                                                <textarea type="text" class="form-control" id="txt_high" name="txt_high" placeholder="Ex:"></textarea>
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                </div>	

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

            <?php $this->load->view('template/js.php'); ?>							<!-- Initialize scripts for this page-->

            <!-- End loading page level scripts-->
            <!--Ajax-->
            <script src="<?php echo base_url(); ?>system_js/Master/Employee.js"></script>



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


    </body>


</html>