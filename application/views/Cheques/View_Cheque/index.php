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



                                                            <div class="col-md-12">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">
                                                                        <h2>View Cheque</h2>
                                                                        <div class="panel-ctrls">
                                                                        </div>
                                                                    </div>
                                                                    <div class="panel-body panel-no-padding">
                                                                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>ID</th>
                                                                                    <th>AMOUNT</th>
                                                                                    <th>CHEQUE NO</th>
                                                                                    <th>Date</th>
                                                                                    <th>PAYEE</th>
                                                                                    <th>BANK</th>
                                                                                    <th>BRANCH</th>

                                                                                    <th>WRITER</th>
                                                                                    <th>CROSS</th>
                                                                                    <th>STATUS</th>
                                                                                    <th>EDIT</th>
                                                                                    <th>IS CANCEL</th>
                                                                                    <th>RE PRINT</th>

                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                foreach ($data_array as $userItem) {



                                                                                    $crs = $userItem->is_cancel;
                                                                                    $branch = $userItem->B_name;



                                                                                    if ($crs == 1) {
                                                                                        $crs = "CANCEL";
                                                                                    } elseif ($crs == 0) {
                                                                                        $crs = "OK";
                                                                                    }


                                                                                    if ($branch == 'HEAD OFFICE') {
                                                                                        $branch = "-";
                                                                                    } elseif ($branch == 0) {
                                                                                        $branch;
                                                                                    }

//                                                                                    var_dump($crs);

                                                                                    echo "<tr class='odd gradeX'>";

                                                                                    echo "<td width='100'>" . $userItem->id . "</td>";
                                                                                    echo "<td width='100'>" . $userItem->amount . "</td>";
                                                                                    echo "<td width='100'>" . $userItem->cheque_no . "</td>";
                                                                                    echo "<td width='100'>" . $userItem->date . "</td>";
                                                                                    echo "<td width='100'>" . $userItem->name . "</td>";
                                                                                    echo "<td width='100'>" . $userItem->bank_name . "</td>";
                                                                                    echo "<td width='100'>" . $branch . "</td>";
                                                                                    echo "<td width='100'>" . $userItem->Employee_Name . "</td>";
                                                                                    echo "<td width='100'>" . $userItem->cross . "</td>";
                                                                                    echo "<td width='100'>" . $crs . "</td>";



                                                                                    echo "<td width='15'>";
                                                                                    echo "<a class='action_comp' data-toggle='modal' data-target='#myModal' data-id='$userItem->id' href='" . base_url() . "index.php/View_Cheque/chq_details" . $userItem->id . "'><i class='fa fa-edit'></i></a>";
                                                                                    echo "</td>";
                                                                                    echo "<td width='15'>";
                                                                                    echo "<a class='action_comp' data-toggle='modal' data-target='#myModal' data-id='$userItem->id' href='" . base_url() . "index.php/View_Cheque/chq_details" . $userItem->id . "'><i class='fa fa-ban'></i></a>";
                                                                                    echo "</td>";
                                                                                    echo "<td width='15'>";
                                                                                    echo "<a class='re_print' data-toggle='modal' data-target='#myModal_chq' data-id='$userItem->id' href='" . base_url() . "index.php/View_Cheque/chq_details" . $userItem->id . "'><i class='fa fa-print'></i></a>";
                                                                                    echo "</td>";
//                                                                                        echo "<td width='15'>";
//                                                                                        echo "<a href='".base_url()."index.php/Designation/view".$userItem->B_Code."'><i class='icon-eye-open'></i></a>";
//                                                                                        echo  "</td>";
                                                                                    echo "</tr>";
                                                                                }
                                                                                ?>
                                                                            </tbody>
                                                                        </table>
                                                                        <div class="panel-footer"></div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <hr>


                                                            <br>

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
                                                <h2 class="modal-title">Cheque</h2>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?php echo base_url(); ?>index.php/View_Cheque/edit/" method="post" class="form-horizontal">
                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">ID</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $userItem->id; ?>" type="text"  readonly="readonly" name="id" id="id" class="form-control m-wrap span3" >
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Date</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $userItem->date ?>" type="text" name="date" id="date"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Cheque No</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $userItem->cheque_no ?>" type="text" name="cheque_no" id="cheque_no"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Amount</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $userItem->amount ?>" type="text" name="amount" id="amount"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">IS Cancel</label>
                                                        <div class="col-sm-8 icheck-flat">
                                                            <label class="checkbox green icheck col-sm-5">
                                                                <input type="checkbox" id="is_cancel" name="is_cancel"> 
                                                            </label>

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
                                </div><!-- /.modal -->




                                <!-- Modal -->
                                <div class="modal fade" id="myModal_chq" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h2 class="modal-title">Cheque Re Print</h2>
                                            </div>
                                            <div class="modal-body">
<!--                                                                <form action="<?php echo base_url(); ?>index.php/View_Cheque/re_print/" method="post" class="form-horizontal">
                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">ID</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $userItem->id; ?>" type="text"  readonly="readonly" name="id1" id="id1" class="form-control m-wrap span3" >
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Date</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $userItem->date ?>" type="text" name="date1" id="date1"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Cheque No</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $userItem->cheque_no ?>" type="text" name="cheque_no1" id="cheque_no1"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Amount</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $userItem->amount ?>" type="text" name="txtNumber" id="txtNumber"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group col-sm-12 hide" >
                                                        <label for="focusedinput" class="col-sm-4 control-label">Cents</label>
                                                        <div class="col-sm-8">
                                                            <input value="00" type="text" name="amount_c1" id="amount_c1"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group col-sm-12 hide" >
                                                        <label for="focusedinput" class="col-sm-4 control-label">Result</label>
                                                        <div class="col-sm-8">
                                                            <input value="" type="text" name="txtResult" id="txtResult"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Payee</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $userItem->amount ?>" type="text" name="payee1" id="payee1"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="form-group col-sm-12 hide">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Bank</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $userItem->amount ?>" type="text" name="bank1" id="bank1"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>
                                                   
                                                    <br>
                                                    <input class="btn green" type="submit" value="submit" id="submit">

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button onclick="GetNumber2d(this.form)" type="submit" id="submit" formtarget="_new" class="btn btn-primary" >Save changes</button>
                                                    </div>

                                                </form>-->

                                                <form action="<?php echo base_url(); ?>index.php/View_Cheque/re_print/" class="form-horizontal" id="test" name="test" method="POST">






                                                    <!--                                                                    <div class="form-group col-sm-6">
                                                                                                                            <label for="focusedinput" class="col-sm-4 control-label">Bank</label>
                                                                                                                            
                                                    
                                                                                                                        </div>-->
                                                    <div class="form-group col-sm-6">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Cheque Date</label>
                                                        <div class="col-sm-8">


                                                            <input value="<?php echo $userItem->date ?>" type="text" readonly="" name="date1" id="date1"  class="form-control m-wrap span6">


                                                        </div>

                                                    </div>

                                                    <div class="form-group col-sm-6 hide" >
                                                        <label for="focusedinput" class="col-sm-4 control-label">Payee</label>

                                                        <input value="<?php echo $userItem->name ?>" type="text" name="payee1" id="payee1"  class="form-control m-wrap span6"><br>       


                                                    </div>
                                                    <div class="form-group col-sm-6 color-green">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Cheque No</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $userItem->cheque_no ?>" type="text" readonly="" name="cheque_no1" id="cheque_no1"  class="form-control m-wrap span6"><br>
                                                        </div>

                                                    </div>



                                                    <div class="form-group col-sm-6">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Amount</label>
                                                        <div class="col-sm-6">
                                                            <INPUT class="form-control col-sm-4" readonly="" type="text" id="txtNumber" name="txtNumber" SIZE=20; style="font-size: 25px;"> 

                                                            <!--<BR>  <INPUT TYPE="text" NAME="txtResult1" SIZE=200>--> 
                                                        </div>



                                                        <div class="col-sm-2">
                                                            <INPUT  class="form-control"  type="text" readonly="" id="txtNumbe2" name="txtNumbe2" SIZE=2 style="font-size: 20px;"> 
                                                        </div>
                                                        <br>
                                                        <INPUT style="float: right; margin: 10px; z-index: -10" TYPE="button"  VALUE="Click to Convert" class="b2t btn btn-green" onclick="GetNumber2d(this.form)">
                                                    </div>



                                                    <div class="form-group col-sm-6">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Amount in Word</label>
                                                        <div class="col-sm-8">
                                                            <textarea style="font-size: 20px;"  required="" type="text" size="18" class="form-control" id="txtResult" name="txtResult" placeholder=""></textarea>
                                                        </div>

                                                    </div>

                                                    <div class="form-group col-sm-6">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Branch</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $branch ?>" type="text" name="branch1" id="branch1"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12 icheck-flat hide">
                                                        <label class="col-sm-2 control-label"></label>
                                                        <div class="col-sm-8 icheck-flat">
                                                            <input value="<?php echo $userItem->cross ?>" type="text" name="isCross" id="isCross"  class="form-control m-wrap span6"><br>

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


                                                    <div class="row">
                                                        <div class="col-sm-8 col-sm-offset-2">
                                                            <button type="submit" id="submit"  formtarget="_new" class="btn-primary btn fa fa-print"> &nbsp RE Print</button>
                                                            <button type="button" id="Cancel" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <INPUT class="form-control col-sm-4 hide" type="text" id="txtNumberWith" name="txtNumberWith" SIZE=20; style="font-size: 25px;"> 

                                                        <!--<BR>  <INPUT TYPE="text" NAME="txtResult1" SIZE=200>--> 
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
        </div>

        <!-- Load site level scripts -->

        <?php $this->load->view('template/js.php'); ?>							<!-- Initialize scripts for this page-->

        <!-- End loading page level scripts-->

        <!--Ajax-->


        <script>
            function selctcity()
            {
                var branch_code = $('#cmb_branch_code').val();

                $.post('<?php echo base_url(); ?>index.php/Add_Complain/branch_data/',
                        {
                            cmb_branch_code: branch_code

                        },
                function (data)
                {

                    $('#cmb_branch_name').html(data);
                });

            }

        </script>

        <script src="<?php echo base_url(); ?>system_js/Cheque/view_chq.js"></script>




    </body>


</html>