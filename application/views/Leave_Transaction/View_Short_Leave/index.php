<!DOCTYPE html>


<!--Description of dashboard page

@author Ashan Rathsara-->


<html lang="en">

<title>
    <?php echo $title ?>
</title>

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
                            <li class="active"><a href="<?php echo base_url(); ?>Leave_Transaction/View_Short_Leave/">VIEW SHORT
                                    LEAVE</a>
                            </li>

                        </ol>


                        <div class="page-tabs">
                            <ul class="nav nav-tabs">

                                <li class="active"><a data-toggle="tab" href="#tab1">VIEW SHORT LEAVE</a></li>
                                <!-- <li><a data-toggle="tab" href="#tab2">VIEW DESIGNATION</a></li> -->


                            </ul>
                        </div>
                        <div class="container-fluid">


                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">

                                    <div class="tab-content">
                                        <!--***************************-->
                                        <div class="tab-pane active" id="tab2">

                                            <div class="row">
                                                <div class="col-xs-12">


                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    <h2>VIEW SHORT LEAVE</h2>
                                                                </div>
                                                                <div class="panel-body panel-no-padding">
                                                                    <table id="example"
                                                                        class="table table-striped table-bordered"
                                                                        cellspacing="0" width="100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th>EMP NO</th>
                                                                                <th>EMP Name</th>
                                                                                <th>DATE</th>
                                                                                <th>IN TIME</th>
                                                                                <th>OUT TIME</th>
                                                                                <th>ACTION</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            foreach ($data_set_att as $data) {


                                                                                echo "<tr class='odd gradeX'>";
                                                                                    echo "<td width='100'>" . $data->ID . "</td>";
                                                                                    echo "<td width='100'>" . $data->EmpNo . "</td>";
                                                                                    echo "<td width='100'>" . $data->Emp_Full_Name . "</td>";
                                                                                    echo "<td width='100'>" . $data->Date . "</td>";
                                                                                    echo "<td width='100'>" . $data->from_time . "</td>";
                                                                                    echo "<td width='100'>" . $data->to_time . "</td>";
                                                                                    echo "<td width='100'>";
                                                                                    echo "<a class='get_data btn btn-primary' href='" . base_url() . "Leave_Transaction/View_Short_Leave/ajax_Status_Aprove/" . $data->ID . "'>APPROVE<i class=''></i> </a>";
                                                                                    echo " <a class='get_data btn btn-danger' href='" . base_url() . "Leave_Transaction/View_Short_Leave/delete/" . $data->ID . "'>DELETE<i class=''></i> </a>";
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


                                    </div>

                                    <!-- End Grid View-->


                                </div>


                                <!-- Modal -->




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

        <?php $this->load->view('template/js.php'); ?> <!-- Initialize scripts for this page-->

        <!-- End loading page level scripts-->

        <!--Ajax-->
        <!-- <script src="<?php echo base_url(); ?>system_js/Master/Designation.js"></script> -->


        <!--JQuary Validation-->
        <script type="text/javascript">
            $(document).ready(function () {
                $("#frm_designation").validate();
                $("#spnmessage").hide("shake", { times: 6 }, 3000);
            });
        </script>

        <script>
            function delete(id) {
                $.ajax({
                    url: baseurl + "index.php/Leave_Transaction/View_Short_Leave/delete/" + id,
                    type: "POST",
                    data: { id: id },
                    success: function (response) {
                        console.log(response);
                        // alert("success");
                        // window.location = "<?php echo base_url(); ?>Leave_Transaction/View_Short_Leave/";
                    }
                });
            }

            function ajaxStatusAprove(id) {
                $.ajax({
                    url: baseurl + "index.php/Leave_Transaction/View_Short_Leave/delete/" + id,
                    type: "POST",
                    data: { id: id },
                    success: function (response) {
                        alert("success");
                        window.location = "<?php echo base_url(); ?>Leave_Transaction/View_Short_Leave/";
                    }
                });
            }

        </script>


</body>


</html>