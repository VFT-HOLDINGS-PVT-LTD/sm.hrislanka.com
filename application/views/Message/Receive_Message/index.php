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
                                <li class="active"><a href="index.html">RECEIVE MESSAGE</a></li>

                            </ol>


                            <div class="page-tabs">
                                <ul class="nav nav-tabs">

                                    <li class="active"><a data-toggle="tab" href="#tab1">RECEIVE MESSAGE</a></li>
                                    


                                </ul>
                            </div>
                            <div class="container-fluid">


                                <div class="tab-content">
                                  

                                    <div class="tab-pane active" id="tab1">

                                          <div class="row">
                                            <div class="col-md-12">
                                                <div class="panel panel-primary">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h2>RECEIVE MESSAGE</h2>
                                                                <div class="panel-ctrls">
                                                                </div>
                                                            </div>
                                                            <div class="panel-body panel-no-padding">
                                                                <table id="example" class="table table-striped table-bordered" class="btn btn-primary" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>EMP NO</th>
                                                                            <th>NAME</th>
                                                                            <th>MESSAGE</th>
                                                                            <th>VIEW</th>
                                                                            <th>DELETE</th>
                                                                            

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        foreach ($data_set as $data) {


                                                                            echo "<tr class='odd gradeX'>";
//                                                                                  echo "<td width='5'><input type='checkbox' class='checkboxes' value='1' /></td>";

                                                                            echo "<td width='100'>" . $data->id . "</td>";
                                                                            echo "<td width='100'>" . $data->sender . "</td>";
                                                                            echo "<td width='100'>" . $data->Emp_Full_Name . "</td>";
                                                                            
                                                                            echo "<td width='100'>" . $data->message . "</td>";
                                                                            

                                                                            echo "<td width='15'>";
                                                                            echo "<a class='branch btn btn-primary' data-toggle='modal' data-id='$data->id' href='" . base_url() . "Message/Receive_Message/view_message" . $data->id . "'><i class='fa fa-eye'></i></a>";
                                                                            echo "</td>";

                                                                            echo "<td width='15'>";
//                                                                            echo "<a class='action_comp' data-toggle='modal' data-target='#myModal' data-id='$data->id' href='" . base_url() . "index.php/Action_Complain/action" . $data->id . "'><i class='fa fa-edit'></i></a>";

                                                                            echo "<a class='action_comp btn btn-danger' data-toggle='modal' href='javascript:void()' title='Edit' onclick='delete_id($data->id)'><i class='fa fa-times-circle'></i></a>";


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
                                
                                
                                 <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h2 class="modal-title">BANK</h2>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="<?php echo base_url(); ?>index.php/Add_Branch/edit/" method="post">
                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Code</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->sender; ?>" type="text" class="form-control" readonly="readonly" name="B_Code" id="B_Code" class="m-wrap span3" >
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Name</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->sender; ?>" type="text" name="B_name" id="B_name"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>
                                                    
                                              
                                                    
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" id="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                    <br>
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




            <!-- Load site level scripts -->

            <?php $this->load->view('template/js.php'); ?>							<!-- Initialize scripts for this page-->

            <!-- End loading page level scripts-->

            <script src="<?php echo base_url(); ?>system_js/Message/receive_message.js"></script>
            
            <!--JQuary Validation-->
            <script type="text/javascript">
                $(document).ready(function () {
                    $("#frmBank").validate();
                    $("#spnmessage").hide("shake", {times: 6}, 3500);
                });
            </script>
            
            
            <!--Auto complete-->
        <script type="text/javascript">
            $(function () {
                $("#txt_emp_name").autocomplete({
                    source: "<?php echo base_url(); ?>Reports/Attendance/Report_Attendance_In_Out/get_auto_emp_name"
                    
                });
//                selctcity();
                
            });

            $(function () {
                $("#txt_emp").autocomplete({
                    source: "<?php echo base_url(); ?>Reports/Attendance/Report_Attendance_In_Out/get_auto_emp_no"
                });
            });
            
            
            
            function selctcity()
            {
                var name = $('#txt_emp_name').val();

                $.post('<?php echo base_url(); ?>Message/Send_Message/emp_data/',
                        {
                            txt_emp_name: name

                        },
                        function (data)
                        {
                            $('#txt_emp').val(data);
                          
                        });

            }

        
    
            
            
        </script>

    </body>


</html>