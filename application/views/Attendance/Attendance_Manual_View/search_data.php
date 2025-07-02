<!DOCTYPE html>


<!--Description of dashboard page

@author Ashan Rathsara-->


<div class="panel panel-primary">
    <div class="panel panel-default">
        <div class="panel-body panel-no-padding" >
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>EMP NO</th>
                        <th>NAME</th>
                        <th>LEVE TYPE</th>
                        <th>APPLY DATE</th>
                        <th>LEAVE DATE</th>
                        <th>REASON</th>
                        <th>LEAVE COUNT</th>
                        <th>MONTH</th>
                        <th>YEAR</th>


                        <th>STATUS</th>
                        <th>APPROVE</th>
                        <th>REJECT</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data_set as $data) {



                        echo "<tr class='odd gradeX'>";
                        echo "<td width='100'>" . $data->LV_ID . "</td>";
                        echo "<td width='100'>" . $data->EmpNo . "</td>";
                        echo "<td width='100'>" . $data->Emp_Full_Name . "</td>";
                        echo "<td width='100'>" . $data->leave_name . "</td>";
                        echo "<td width='100'>" . $data->Apply_Date . "</td>";
                        echo "<td width='100'>" . $data->Leave_Date . "</td>";
                        echo "<td width='100'>" . $data->Reason . "</td>";
                        echo "<td width='100'>" . $data->Leave_Count . "</td>";
                        echo "<td width='100'>" . $data->month . "</td>";
                        echo "<td width='100'>" . $data->Year . "</td>";


                        echo "<td width='15'>";

                        echo "<span class='get_data label label-warning'>Pending<i class='fa fa-eye'></i> </span>";
                        echo "</td>";

                        echo "<td width='15'>";
                        echo "<a class='get_data btn btn-primary' href='" . base_url() . "Leave_Transaction/Leave_Approve/approve/" . $data->LV_ID . "'>APPROVE<i class=''></i> </a>";
                        echo "</td>";
                        
                        echo "<td width='15'>";
                        echo "<a class='get_data btn btn-danger' href='" . base_url() . "Leave_Transaction/Leave_Approve/reject/" . $data->LV_ID . "'>REJECT<i class=''></i> </a>";
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
