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

                                <li class=""><a href="<?php echo base_url(); ?>Dashboard/">HOME</a></li>
                                <li class="active"><a href="<?php echo base_url(); ?>Master/Designation/">ATTENDANCE ROW DATA</a></li>

                            </ol>


                            <div class="page-tabs">
                                <ul class="nav nav-tabs">

                                    <li class="active"><a data-toggle="tab" href="#tab1">ATTENDANCE ROW DATA</a></li>
                                    <!--<li><a data-toggle="tab" href="#tab2">VIEW DESIGNATION</a></li>-->


                                </ul>
                            </div>
                            <div class="container-fluid">


                                <div class="tab-content">



                                    <!--***************************-->
                                    <!-- Grid View -->
                                    <div class="tab-pane active" id="tab1">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="panel panel-primary">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h2>ATTENDANCE ROW DATA</h2>
                                                                <div class="panel-ctrls">
                                                                </div>
                                                            </div>
                                                            <div class="panel-body panel-no-padding">
                                                                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>DATE</th>
                                                                            <th>EMP NO</th>
                                                                            <th>EMP Name</th>
                                                                            <th>IN TIME</th>
                                                                            <th>OUT TIME</th>


                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        foreach ($data_set as $data) {


                                                                            echo "<tr class='odd gradeX'>";

                                                                            echo "<td width='100'>" . $data->AttDate . "</td>";
                                                                            echo "<td width='100'>" . $data->Enroll_No . "</td>";
                                                                            echo "<td width='100'>" . $data->Emp_Full_Name . "</td>";
                                                                            echo "<td width='100'>" . $data->InTime . "</td>";
                                                                            echo "<td width='100'>" . $data->OutTime . "</td>";

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
            <script src="<?php echo base_url(); ?>system_js/Master/Designation.js"></script>

    </body>


</html>