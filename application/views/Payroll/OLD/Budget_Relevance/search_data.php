<!DOCTYPE html>


<!--Description of dashboard page

@author Ashan Rathsara-->

<div class="panel panel-primary">
    <div class="panel panel-default">
        <div class="panel-body panel-no-padding">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>EMP NO</th>
                        <th>NAME</th>
                        <th>DESIGNATION</th>
                        <th>DEPARTMENT</th>
                        <th>BUDGET RELEVANCE</th>
                        <th>AMOUNT</th>
                        <th>MONTH</th>


                        <th>EDIT</th>
                        <th>DELETE</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data_set as $data) {
                    ?>


                        <tr class='odd gradeX'>
                            <td width='100'><?= $data->EmpNo; ?></td>
                            <td width='100'><?= $data->Emp_Full_Name; ?></td>
                            <td width='100'><?= $data->Desig_Name; ?></td>
                            <td width='100'><?= $data->Dep_Name; ?></td>
                            <td width='100'><?= $data->Br_name; ?></td>
                            <td width='100'><?= $data->Amount; ?></td>
                            <td width='100'><?= $data->Month; ?></td>
                            <td width='15'>
                                <button class='get_data btn btn-green' data-toggle='modal' data-target='#myModal2' title='EDIT' data-id='<?= $data->ID; ?>'>
                                    <i class='fa fa-edit'></i>
                                </button>
                            </td>
                            <td width='15'>
                                <button class='btn btn-danger' data-toggle='modal' href='javascript:void()' title='DELETE' onclick='delete_id(<?= $data->ID; ?>)'>
                                    <i class='fa fa-times-circle'></i>
                                </button>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <div class="panel-footer"></div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h2 class="modal-title">EDIT BUDGET RELEVANCE</h2>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="<?php echo base_url(); ?>Pay/Budget_Relevance/edit" method="post">
                    <div class="form-group col-sm-12">
                        <label for="focusedinput" class="col-sm-4 control-label">ID</label>
                        <div class="col-sm-8">
                            <input value="<?php echo $data->ID; ?>" type="text" class="form-control" readonly="readonly" name="id" id="id" class="m-wrap span3">
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="focusedinput" class="col-sm-4 control-label">NAME</label>
                        <div class="col-sm-8">
                            <input value="<?php echo $data->Emp_Full_Name; ?>" type="text" name="Name" id="Name" class="form-control m-wrap span6"><br>
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="focusedinput" class="col-sm-4 control-label">BUDGET RELEVANCE NAME</label>
                        <div class="col-sm-8">
                            <input value="<?php echo $data->Br_name; ?>" type="text" name="allowance" id="allowance" class="form-control m-wrap span6"><br>
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="focusedinput" class="col-sm-4 control-label">AMOUNT</label>
                        <div class="col-sm-8">
                            <input value="<?php echo $data->Amount; ?>" type="text" name="amount" id="amount" class="form-control m-wrap span6"><br>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>

            </div>

            <br>
            <!--<input class="btn green" type="submit" value="submit" id="submit">-->

        </div>

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script type="text/javascript">
    //Get  Data
    $(".get_data").click(function() {

        var ID = $(this).attr("data-id");
        // alert(ID);
        $.ajax({
            url: baseurl + "index.php/Pay/Budget_Relevance/get_details/" + ID,
            type: "POST",
            dataType: "JSON",
            success: function(response) {
                                //    alert(jsonencode(response));

                $('#id').val(response[0].ID);
                $('#Name').val(response[0].Emp_Full_Name);
                $('#allowance').val(response[0].Br_name);
                $('#amount').val(response[0].Amount);
                // alert("ok");


            }
        });
    });
</script>


<script type="text/javascript">
    function delete_id(id) {
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this data!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Delete This!",
                cancelButtonText: "No, Cancel This!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {

                    $.ajax({
                        url: baseurl + "index.php/Pay/Budget_Relevance/ajax_delete/" + id,
                        type: "POST",
                        dataType: "JSON",
                        success: function(data) {

                            //if success reload ajax table
                            $('#modal_form').modal('hide');
                            reload_table();
                        }

                    });


                    swal("Deleted!", "Selected data has been deleted.", "success");


                    $(document).ready(function() {
                        setTimeout(function() {
                            window.location.replace(baseurl + "Pay/Budget_Relevance");
                        }, 1000);
                    });


                } else {
                    swal("Cancelled", "Selected data Cancelled", "error");

                }

            });

    }
</script>