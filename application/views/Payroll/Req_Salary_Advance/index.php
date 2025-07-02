<!DOCTYPE html>

<?php
$currentUser = $this->session->userdata('login_user');
?>

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
                                <li class="active"><a href="index.html">SALARY ADVANCE</a></li>

                            </ol>


                            <div class="page-tabs">
                                <ul class="nav nav-tabs">

                                    <li class="active"><a data-toggle="tab" href="#tab1">SALARY ADVANCE</a></li>
                                    <li><a data-toggle="tab" href="#tab2">VIEW SALARY ADVANCE</a></li>

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
                                                            <div class="panel-heading"><h2>ADD SALARY ADVANCE</h2></div>
                                                            <div class="panel-body">
                                                                <form class="form-horizontal" id="frm_sal_advance" name="frm_sal_advance" action="<?php echo base_url(); ?>Payroll/Salary_Advance_req/insert_data" method="POST">

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
                                                                            <img style="margin-left: 30%; width: 100px; height: 100px;" src="<?php echo base_url(); ?>assets/images/salary_advance_reg.png" >
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" id="change" class="col-sm-4 control-label">Employee</label>
                                                                        <div class="col-sm-8" id="cat_div">
                                                                            <input type="text" class="form-control" readonly="" value="<?php echo "" . $currentUser[0]->Emp_Full_Name; ?>" required="required">
                                                                            <input type="text" class="form-control hidden" value="<?php echo "" . $currentUser[0]->EmpNo; ?>" required="required" id="txt_employee" name="txt_employee">
                                                                        </div>

                                                                    </div>
                                                                    <label style="color: red; font-size: 14px;" for="focusedinput" class="col-sm-4 control-label">Maximun Amount can apply  Rs: <?php echo $sal_advace; ?></label>
                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Advance Amount</label>
                                                                        
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="txt_advance" name="txt_advance" placeholder="Ex: 15000">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Request Date</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" name="txt_date" id="dpd1">
                                                                        </div>

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
                                    <div class="tab-pane" id="tab2">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading"><h2>Primary</h2></div>
                                                    <div class="panel-body">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</div>
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

            <script src="<?php echo base_url(); ?>system_js/Pay/loan_entry.js"></script>


            <!--Dropdown selected text into label-->
            <script type="text/javascript">
                $(function () {
                    $("#cmb_cat").on("change", function () {
                        $("#change").text($("#cmb_cat").find(":selected").text());
                    }).trigger("change");
                });
            </script>


            <!--JQuary Validation-->
            <script type="text/javascript">
                $(document).ready(function () {
                    $("#frm_sal_advance").validate();
                    $("#spnmessage").hide("shake", {times: 6}, 3500);
                });
            </script>

            <!--Date Format-->
            <script>

                $('#dpd1').datepicker({
                    format: "dd/mm/yyyy",
                    "todayHighlight": true,
                    autoclose: true,
                    format: 'yyyy/mm/dd'
                }).on('changeDate', function (ev) {
                    $(this).datepicker('hide');
                });
                


            </script>


            <script>
                function selctcity()
                {

                    var branch_code = $('#cmb_cat').val();
//                alert(branch_code);

                    $.post('<?php echo base_url(); ?>index.php/Pay/Deduction/dropdown/',
                            {
                                cmb_cat: branch_code



                            },
                    function (data)
                    {
//                            alert(data);

//                            $('#cmb_cat2').remove();
                        $('#cmb_cat2').html(data);
                    });

                }

            </script>

    </body>


</html>