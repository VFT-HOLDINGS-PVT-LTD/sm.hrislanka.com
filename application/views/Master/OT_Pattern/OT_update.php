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
                            <li class="active"><a href="index.html">OT PATTERN</a></li>

                        </ol>


                        <div class="page-tabs">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab1">OT PATTERN</a></li>

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
                                                            <h2>UPDATE OT PATTERN</h2>
                                                        </div>
                                                        <div class="panel-body">
                                                            <form class="form-horizontal" id="frm_OT_Pattern" name="frm_OT_Pattern" action="<?php echo base_url(); ?>Master/OT_Pattern/updateOt" method="POST" onsubmit="createOTPatternArr2()">

                                                                <div class="form-group col-sm-12">
                                                                    <div class="col-sm-8">
                                                                        <img class="imagecss" src="<?php echo base_url(); ?>assets/images/OT.png">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-12">

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">OT Pattern Name</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" name="txt_shift_id" value="<?php echo $_GET['id']; ?>" hidden />
                                                                            <input type="text" class="form-control" value="<?php echo $data_set[0]->OTPatternName; ?>" readonly="" id="txt_shift_name" name="txt_shift_name" placeholder="Ex: Office">
                                                                        </div>
                                                                    </div>

                                                                </div>



                                                                <div class="form-group col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="#" class="col-sm-2 control-label" style="font-weight: bold"></label>

                                                                        <div class="col-sm-1">
                                                                            <label for="#" class="col-sm-2 control-label" style="font-weight: bold">DAY</label>

                                                                        </div>


                                                                        <div class="col-sm-1">
                                                                            <label for="#" class="col-sm-2 control-label" style="font-weight: bold">BEFORE_ SHIFT</label>
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <label for="#" class="col-sm-2 control-label" style="font-weight: bold">MIN_TIME_TO_WORK</label>
                                                                        </div>
                                                                        <div class="col-sm-1">
                                                                            <label for="#" class="col-sm-2 control-label" style="font-weight: bold">AFTER_SHIFT</label>
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <label for="#" class="col-sm-2 control-label" style="font-weight: bold">MIN_TIME_TO_WORK</label>
                                                                        </div>
                                                                        <div class="col-sm-1">
                                                                            <label for="#" class="col-sm-2 control-label" style="font-weight: bold">ROUNDUP</label>
                                                                        </div>



                                                                    </div>


                                                                </div>



                                                                <div class="form-group col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="#" class="col-sm-2 control-label" style="font-weight: bold">MONDAY</label>

                                                                        <div class="col-sm-1">
                                                                            <input type="text" required="required" class="form-control" name="Day0" id="Day0" value="<?php echo $data_set[0]->DayCode; ?>" readonly="" placeholder="">

                                                                        </div>


                                                                        <div class="col-sm-1">
                                                                            <label class="checkbox green icheck col-sm-5">
                                                                                <input type="checkbox" disabled required="required" <?php if ($data_set[0]->BeforeShift == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?> name="chkBSH0" id="chkBSH0">
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <input type="text" required="required" class="form-control" value="<?php echo $data_set[0]->MinBS; ?>" name="MinTw0" id="MinTw0" placeholder="Ex: 15(should in minutes)">

                                                                        </div>
                                                                        <div class="col-sm-1">
                                                                            <label class="checkbox green icheck col-sm-5">
                                                                                <input type="checkbox" disabled required="required" <?php if ($data_set[0]->BeforeShift == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?> name="chkASH0" id="chkASH0">
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <input type="text" required="required" value="<?php echo $data_set[0]->MinAS; ?>" class="form-control" id="ASH_MinTw0" name="ASH_MinTw0" placeholder="Ex: 15(should in minutes)">

                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <input type="text" required="required" value="<?php echo $data_set[0]->RoundUp; ?>" class="form-control" id="RoundUp0" name="RoundUp0" placeholder="Ex: 15(should in minutes)">

                                                                        </div>


                                                                    </div>


                                                                </div>

                                                                <div class="form-group col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="#" class="col-sm-2 control-label" style="font-weight: bold">TUESDAY</label>



                                                                        <div class="col-sm-1">
                                                                            <input type="text" required="required" class="form-control" name="Day1" id="Day1" value="<?php echo $data_set[1]->DayCode; ?>" readonly="" placeholder="">

                                                                        </div>


                                                                        <div class="col-sm-1">
                                                                            <label class="checkbox green icheck col-sm-5">
                                                                                <input type="checkbox" disabled required="required" <?php if ($data_set[1]->BeforeShift == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?> name="chkBSH1" id="chkBSH1">
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <input type="text" required="required" class="form-control" value="<?php echo $data_set[1]->MinBS; ?>" name="MinTw1" id="MinTw1" placeholder="Ex: 15(should in minutes)">

                                                                        </div>
                                                                        <div class="col-sm-1">
                                                                            <label class="checkbox green icheck col-sm-5">
                                                                                <input type="checkbox" disabled required="required" <?php if ($data_set[1]->BeforeShift == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?> name="chkASH1" id="chkASH1">
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <input type="text" required="required" value="<?php echo $data_set[1]->MinAS; ?>" class="form-control" id="ASH_MinTw1" name="ASH_MinTw1" placeholder="Ex: 15(should in minutes)">

                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <input type="text" required="required" value="<?php echo $data_set[1]->RoundUp; ?>" class="form-control" id="RoundUp1" name="RoundUp1" placeholder="Ex: 15(should in minutes)">

                                                                        </div>


                                                                    </div>


                                                                </div>


                                                                <div class="form-group col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="#" class="col-sm-2 control-label" style="font-weight: bold">WEDNESDAY</label>
                                                                        <div class="col-sm-1">
                                                                            <input type="text" required="required" class="form-control" name="Day2" id="Day2" value="<?php echo $data_set[2]->DayCode; ?>" readonly="" placeholder="">

                                                                        </div>


                                                                        <div class="col-sm-1">
                                                                            <label class="checkbox green icheck col-sm-5">
                                                                                <input type="checkbox" disabled required="required" <?php if ($data_set[2]->BeforeShift == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?> name="chkBSH2" id="chkBSH2">
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <input type="text" required="required" class="form-control" value="<?php echo $data_set[2]->MinBS; ?>" name="MinTw2" id="MinTw2" placeholder="Ex: 15(should in minutes)">

                                                                        </div>
                                                                        <div class="col-sm-1">
                                                                            <label class="checkbox green icheck col-sm-5">
                                                                                <input type="checkbox" disabled required="required" <?php if ($data_set[2]->BeforeShift == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?> name="chkASH2" id="chkASH2">
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <input type="text" required="required" value="<?php echo $data_set[2]->MinAS; ?>" class="form-control" id="ASH_MinTw2" name="ASH_MinTw2" placeholder="Ex: 15(should in minutes)">

                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <input type="text" required="required" value="<?php echo $data_set[2]->RoundUp; ?>" class="form-control" id="RoundUp2" name="RoundUp2" placeholder="Ex: 15(should in minutes)">

                                                                        </div>



                                                                    </div>


                                                                </div>


                                                                <div class="form-group col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="#" class="col-sm-2 control-label" style="font-weight: bold">THURSDAY</label>
                                                                        <div class="col-sm-1">
                                                                            <input type="text" required="required" class="form-control" name="Day3" id="Day3" value="<?php echo $data_set[3]->DayCode; ?>" readonly="" placeholder="">

                                                                        </div>


                                                                        <div class="col-sm-1">
                                                                            <label class="checkbox green icheck col-sm-5">
                                                                                <input type="checkbox" disabled required="required" <?php if ($data_set[3]->BeforeShift == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?> name="chkBSH3" id="chkBSH3">
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <input type="text" required="required" class="form-control" value="<?php echo $data_set[3]->MinBS; ?>" name="MinTw3" id="MinTw3" placeholder="Ex: 15(should in minutes)">

                                                                        </div>
                                                                        <div class="col-sm-1">
                                                                            <label class="checkbox green icheck col-sm-5">
                                                                                <input type="checkbox" disabled required="required" <?php if ($data_set[3]->BeforeShift == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?> name="chkASH3" id="chkASH3">
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <input type="text" required="required" value="<?php echo $data_set[3]->MinAS; ?>" class="form-control" id="ASH_MinTw3" name="ASH_MinTw3" placeholder="Ex: 15(should in minutes)">

                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <input type="text" required="required" value="<?php echo $data_set[3]->RoundUp; ?>" class="form-control" id="RoundUp3" name="RoundUp3" placeholder="Ex: 15(should in minutes)">

                                                                        </div>


                                                                    </div>


                                                                </div>


                                                                <div class="form-group col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="#" class="col-sm-2 control-label" style="font-weight: bold">FRIDAY</label>
                                                                        <div class="col-sm-1">
                                                                            <input type="text" required="required" class="form-control" name="Day4" id="Day4" value="<?php echo $data_set[4]->DayCode; ?>" readonly="" placeholder="">

                                                                        </div>


                                                                        <div class="col-sm-1">
                                                                            <label class="checkbox green icheck col-sm-5">
                                                                                <input type="checkbox" disabled required="required" <?php if ($data_set[4]->BeforeShift == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?> name="chkBSH4" id="chkBSH4">
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <input type="text" required="required" class="form-control" value="<?php echo $data_set[4]->MinBS; ?>" name="MinTw4" id="MinTw4" placeholder="Ex: 15(should in minutes)">

                                                                        </div>
                                                                        <div class="col-sm-1">
                                                                            <label class="checkbox green icheck col-sm-5">
                                                                                <input type="checkbox" disabled required="required" <?php if ($data_set[4]->BeforeShift == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?> name="chkASH4" id="chkASH4">
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <input type="text" required="required" value="<?php echo $data_set[4]->MinAS; ?>" class="form-control" id="ASH_MinTw4" name="ASH_MinTw4" placeholder="Ex: 15(should in minutes)">

                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <input type="text" required="required" value="<?php echo $data_set[4]->RoundUp; ?>" class="form-control" id="RoundUp4" name="RoundUp4" placeholder="Ex: 15(should in minutes)">

                                                                        </div>


                                                                    </div>


                                                                </div>


                                                                <div class="form-group col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="#" class="col-sm-2 control-label" style="font-weight: bold">SATURDAY</label>
                                                                        <div class="col-sm-1">
                                                                            <input type="text" required="required" class="form-control" name="Day5" id="Day5" value="<?php echo $data_set[5]->DayCode; ?>" readonly="" placeholder="">

                                                                        </div>


                                                                        <div class="col-sm-1">
                                                                            <label class="checkbox green icheck col-sm-5">
                                                                                <input type="checkbox" disabled required="required" <?php if ($data_set[5]->BeforeShift == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?> name="chkBSH5" id="chkBSH5">
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <input type="text" required="required" class="form-control" value="<?php echo $data_set[5]->MinBS; ?>" name="MinTw5" id="MinTw5" placeholder="Ex: 15(should in minutes)">

                                                                        </div>
                                                                        <div class="col-sm-1">
                                                                            <label class="checkbox green icheck col-sm-5">
                                                                                <input type="checkbox" disabled required="required" <?php if ($data_set[5]->BeforeShift == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?> name="chkASH5" id="chkASH5">
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <input type="text" required="required" value="<?php echo $data_set[5]->MinAS; ?>" class="form-control" id="ASH_MinTw5" name="ASH_MinTw5" placeholder="Ex: 15(should in minutes)">

                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <input type="text" required="required" value="<?php echo $data_set[5]->RoundUp; ?>" class="form-control" id="RoundUp5" name="RoundUp5" placeholder="Ex: 15(should in minutes)">

                                                                        </div>


                                                                    </div>


                                                                </div>


                                                                <div class="form-group col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="#" class="col-sm-2 control-label" style="font-weight: bold">SUNDAY</label>
                                                                        <div class="col-sm-1">
                                                                            <input type="text" required="required" class="form-control" name="Day6" id="Day6" value="<?php echo $data_set[6]->DayCode; ?>" readonly="" placeholder="">

                                                                        </div>


                                                                        <div class="col-sm-1">
                                                                            <label class="checkbox green icheck col-sm-5">
                                                                                <input type="checkbox" disabled required="required" <?php if ($data_set[6]->BeforeShift == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?> name="chkBSH6" id="chkBSH6">
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <input type="text" required="required" class="form-control" value="<?php echo $data_set[6]->MinBS; ?>" name="MinTw6" id="MinTw6" placeholder="Ex: 15(should in minutes)">

                                                                        </div>
                                                                        <div class="col-sm-1">
                                                                            <label class="checkbox green icheck col-sm-5">
                                                                                <input type="checkbox" disabled required="required" <?php if ($data_set[6]->BeforeShift == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?> name="chkASH6" id="chkASH6">
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <input type="text" required="required" value="<?php echo $data_set[6]->MinAS; ?>" class="form-control" id="ASH_MinTw6" name="ASH_MinTw6" placeholder="Ex: 15(should in minutes)">

                                                                        </div>

                                                                        <div class="col-sm-2">
                                                                            <input type="text" required="required" value="<?php echo $data_set[6]->RoundUp; ?>" class="form-control" id="RoundUp6" name="RoundUp6" placeholder="Ex: 15(should in minutes)">

                                                                        </div>



                                                                    </div>


                                                                </div>




                                                                <!--Hidden Text-->
                                                                <input type="text" name="hdntext2" id="hdntext2" class="hidden">



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
        <script src="<?php echo base_url(); ?>system_js/Master/OT_Pattern.js"></script>
        <script>
            function createOTPatternArr2() {
                myData = [];
                $("[id^='Day'").each(function() {

                    elementIndex = this.id.replace("Day", "");

                    myData.push({
                        "Day": $("#Day" + elementIndex).val(),
                        "Type": $("#Type" + elementIndex).val(),
                        "chkBSH": $("#chkBSH" + elementIndex).val(),
                        "MinTw": $("#MinTw" + elementIndex).val(),
                        "ChkASH": $("#chkASH" + elementIndex).val(),
                        "ASH_MinTw": $("#ASH_MinTw" + elementIndex).val(),
                        "RoundUp": $("#RoundUp" + elementIndex).val()


                    });

                });

                $("#hdntext2").val(JSON.stringify(myData));
                console.log(JSON.stringify(myData));
            }
        </script>

</body>


</html>