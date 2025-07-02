<!DOCTYPE html>


<!--Description of dashboard page

@author Ashan Rathsara-->

<!--<script src="<?php echo base_url(); ?>system_js/Cheque/new.js"></script>
<script src="<?php echo base_url(); ?>system_js/Cheque/toword.js"></script>-->
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

                                <li class=""><a href="index.html">HOME</a></li>
                                <li class="active"><a href="index.html">ADD COMPLAIN</a></li>

                            </ol>

                            <div class="container-fluid">


                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">

                                        <div class="row">
                                            <div class="col-xs-12">


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-primary">
                                                            <div class="panel-heading"><h2>WRITE CHEQUE</h2></div>
                                                            <div class="panel-body">
                                                                <form action="<?php echo base_url(); ?>Cheque/Write_Cheque/cheque_print" class="form-horizontal" id="test" name="test" method="POST">

                                                                    <div id="divmessage" class="">
                                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                                        <div id="spnmessage"> </div>

                                                                    </div>


                                                                    <div class="form-group col-sm-12">
                                                                        <div class="col-sm-6">
                                                                            <img class="imagecss" src="<?php echo base_url(); ?>assets/images/wite_cheque.png" >
                                                                        </div>
                                                                        <!--                                                                        <div class="form-group col-sm-6">
                                                                                                                                                    <label for="focusedinput" class="col-sm-4 control-label">Cheque</label>
                                                                                                                                                    <div class="col-sm-8" >
                                                                        
                                                                                                                                                        <input style="color: #cc0000; font-size: 22px; font-weight: bold" type="text" readonly="" value="<?php echo $serial; ?>" class="form-control" id="txt_chq" name="txt_chq" placeholder="Ex: 00000001">
                                                                                                                                                    </div>
                                                                                                                                                </div>-->
                                                                    </div>
                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Cheque Date</label>
                                                                            <div class="col-sm-8">


                                                                                <input type="text" class="form-control" required="required" id="txt_Date" name="txt_Date" placeholder="Select Date">


                                                                            </div>

                                                                        </div>


                                                                    </div>

                                                                    <div class="form-group col-md-12" style="margin-top: -30px">
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Bank</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" required="" id="cmb_bank" name="cmb_bank" onchange="selctcity()">


                                                                                    <option value="" default>-- Select --</option>
                                                                                    <?php foreach ($data_bank as $t_data) { ?>
                                                                                        <option value="<?php echo $t_data->Bnk_ID; ?>" ><?php echo $t_data->bank_name; ?></option>

                                                                                    <?php }
                                                                                    ?>        

                                                                                </select>
                                                                            </div>

                                                                        </div>
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Account NO</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" required="" id="cmb_acc_no" name="cmb_acc_no" onchange="get_lc_no()" >


                                                                                    <option value="" default>-- Select --</option>

                                                                                </select>
                                                                            </div>

                                                                        </div>
                                                                    </div>


                                                                    <div class="form-group col-md-12" style="margin-top: -30px">
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Payee</label>


                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" required=""  id="cmb_Payee" name="cmb_Payee" >


                                                                                    <option value="" default>-- Select --</option>

                                                                                    <?php foreach ($data_payee as $t_data) { ?>
                                                                                        <option value="<?php echo $t_data->id; ?>" > <?php echo $t_data->name; ?></option>

                                                                                    <?php }
                                                                                    ?>


                                                                                </select>
                                                                            </div>


                                                                        </div>
                                                                        <div class="form-group col-sm-6 color-green">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Cheque No</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" readonly=""   required="" class="form-control" id="txt_cheque_no" name="txt_cheque_no" >
                                                                            </div>



                                                                        </div>
                                                                    </div>


                                                                    <div class="form-group col-md-12" style="margin-top: -30px">
                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Amount</label>
                                                                            <div class="col-sm-6">
                                                                                <INPUT class="form-control col-sm-4" required="" type="text" id="txtNumber" name="txtNumber" SIZE=20; style="font-size: 25px;"> 

                                                                                <!--<BR>  <INPUT TYPE="text" NAME="txtResult1" SIZE=200>--> 
                                                                            </div>



                                                                            <div class="col-sm-2">
                                                                                <INPUT  class="form-control" value="00" type="text" name="txtNumbe2" name="txtNumbe2" SIZE=2 style="font-size: 25px;"> 
                                                                            </div>
                                                                            <br>
                                                                            <INPUT style="float: right; margin: 10px; z-index: -10" TYPE="button"  VALUE="Click to Convert" class="b2t btn btn-green" onclick="GetNumber2d(this.form)">
                                                                        </div>



                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Amount in Word</label>
                                                                            <div class="col-sm-8">
                                                                                <textarea style="font-size: 20px;" type="text" required="" size="18" class="form-control" id="txtResult" name="txtResult" placeholder=""></textarea>
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group col-sm-12 icheck-flat" style="margin-top: -50px">
                                                                        <label class="col-sm-2 control-label"></label>
                                                                        <div class="col-sm-8 icheck-flat">
                                                                            <label class="checkbox green icheck col-sm-5 black">
                                                                                <input type="checkbox" id="isCross" name="isCross" > IS CROSS
                                                                            </label>

                                                                        </div>
                                                                    </div>


                                                                    
                                                                    <div class="form-group col-md-12">
<!--                                                                        <div class="form-group col-sm-6" style="margin-left: 250px;">
                                                                            <div class="col-sm-8">
                                                                                <label class="radio-inline icheck">
                                                                                    <input type="radio" id="inlineradio1" required="" value="Active" name="employee_status" checked=""> With Seal
                                                                                </label>
                                                                                <label class="radio-inline icheck">
                                                                                    <input type="radio" id="inlineradio2" value="Inactive" name="employee_status" > Without Seal
                                                                                </label>

                                                                            </div>
                                                                        </div>-->

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">Comment</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="txt_comment" name="txt_comment" placeholder="Ex: Some comment if needed">
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-sm-8 col-sm-offset-2">
                                                                            <button type="submit" id="submit"  formtarget="_new" class="btn-primary btn fa fa-check"> &nbsp PRINT & SAVE</button>
                                                                            <button type="button" id="Cancel" class="btn-default btn">Cancel</button>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <INPUT class="form-control col-sm-4 hide" type="text" id="txtNumberWith" name="txtNumberWith" SIZE=20; style="font-size: 25px;"> 

                                                                        <!--<BR>  <INPUT TYPE="text" NAME="txtResult1" SIZE=200>--> 
                                                                    </div>
                                                                </form>
                                                                <hr>


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

        <?php $this->load->view('template/js.php'); ?>							<!-- Initialize scripts for this page-->

        <!-- End loading page level scripts-->

        <script>
            function selctcity()
            {
                var id = $('#cmb_bank').val();

                $.post('<?php echo base_url(); ?>Cheque/Write_Cheque/get_data/',
                        {
                            cmb_bank: id

                        },
                function (data)
                {


                    $('#cmb_acc_no').html(data);
                });

            }


            function get_lc_no()
            {
                var Acc_no = $('#cmb_acc_no').val();

                $.post('<?php echo base_url(); ?>Cheque/Write_Cheque/get_data_chq/',
                        {
                            cmb_acc_no: Acc_no

                        },
                function (data)
                {


                    $('#txt_cheque_no').val(data);
                });

            }

        </script>
        
        
        <!--Date Format-->
        <script>

            $('#txt_Date').datepicker({
                format: "dd/mm/yyyy",
                "todayHighlight": true,
                autoclose: true,
                format: 'yyyy/mm/dd'
            }).on('changeDate', function (ev) {
                $(this).datepicker('hide');
            });
            $('#dpd2').datepicker({
                format: "dd/mm/yyyy",
                "todayHighlight": true,
                autoclose: true,
                format: 'yyyy/mm/dd'
            }).on('changeDate', function (ev) {
                $(this).datepicker('hide');
            });


        </script>

        <!--JQuary Validation-->
        <script type="text/javascript">
            $(document).ready(function () {
                $("#test").validate();
                $("#spnmessage").hide("shake", {times: 4}, 1500);
            });
        </script>

        <!--Ajax-->
        <script src="<?php echo base_url(); ?>system_js/Cheque/chq.js"></script>

        <script src="<?php echo base_url(); ?>system_js/Cheque/chq_write.js"></script>
        <!--<script src="<?php echo base_url(); ?>system_js/Cheque/chq.js"></script>-->


        <script>
            function reload() {
                location.reload();
            }
        </script>





    </body>


</html>