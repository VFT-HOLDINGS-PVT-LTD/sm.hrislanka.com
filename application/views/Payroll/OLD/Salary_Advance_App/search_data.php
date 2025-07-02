<!DOCTYPE html>


<!--Description of dashboard page

@author Ashan Rathsara-->

<div class="panel panel-primary">
    <div class="panel panel-default">
        <div class="panel-body panel-no-padding">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>EMP NO</th>
                        <th>NAME</th>
                        
                        <th>YEAR</th>
                        <th>MONTH</th>
                        <th>AMOUNT</th>
                        <th>REQUEST DATE</th>
                        <th>IS APPROVE</th>
                        
                        <th>APPROVE</th>
                        <th>REJECT</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data_set as $data) {



                        echo "<tr class='odd gradeX'>";
                        echo "<td width='100'>" . $data->id . "</td>";
                        echo "<td width='100'>" . $data->EmpNo . "</td>";
                        echo "<td width='100'>" . $data->Emp_Full_Name . "</td>";
                        
                        echo "<td width='100'>" . $data->Year . "</td>";
                        echo "<td width='100'>" . $data->Month . "</td>";
                        echo "<td width='100'>" . $data->Amount . "</td>";
                        echo "<td width='100'>" . $data->Request_Date . "</td>";
                        echo "<td width='100'>" . $data->Is_Approve . "</td>";
                        




                        echo "<td width='15'>";
                        echo "<a class='get_data btn btn-primary' href='" . base_url() . "Pay/Salary_Advance/approve/" . $data->id . "'>APPROVE<i class=''></i> </a>";
                        echo "</td>";
                        
                        echo "<td width='15'>";
                        echo "<a class='get_data btn btn-danger' href='" . base_url() . "Pay/Salary_Advance/reject/" . $data->id . "'>REJECT<i class=''></i> </a>";
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




<script type="text/javascript">
    function delete_id(id)
    {
        swal({title: "Are you sure?", text: "You will not be able to recover this data!", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Yes, Delete This!", cancelButtonText: "No, Cancel This!", closeOnConfirm: false, closeOnCancel: false},
                function (isConfirm) {
                    if (isConfirm) {

                        $.ajax({
                            url: baseurl + "index.php/Payroll/Loan_Entry/ajax_delete/" + id,
                            type: "POST",
                            dataType: "JSON",
                            success: function (data)
                            {

                                //if success reload ajax table
                                $('#modal_form').modal('hide');
                                reload_table();
                            }

                        });


                        swal("Deleted!", "Selected data has been deleted.", "success");


                        $(document).ready(function () {
                            setTimeout(function () {
                                window.location.replace(baseurl + "Payroll/Loan_Entry/");
                            }, 1000);
                        });


                    } else {
                        swal("Cancelled", "Selected data Cancelled", "error");

                    }

                });

    }
</script>