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
                        <th>DATE</th>
                        <th>TIME</th>
                        <!--<th>OUT TIME</th>-->
                        <th>REASON</th>
                       


                        <th>STATUS</th>
                        <!--<th>EDIT</th>-->
                        <th>APPROVE</th>
                        <th>REJECT</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data_set as $data) {
                        $dataV;
                        if ($data->Status == 0) {
                            $dataV = "Check IN";
                        }elseif ($data->Status == 1){
                            $dataV = "Check OUT";
                        }


                        echo "<tr class='odd gradeX'>";
                        echo "<td width='100'>" . $data->M_ID . "</td>";
                        echo "<td width='100'>" . $data->EmpNo . "</td>";
                        echo "<td width='100'>" . $data->Emp_Full_Name . "</td>";
                        
                        echo "<td width='100'>" . $data->Att_Date . "</td>";
                        echo "<td width='100'>" . $data->In_Time . " - ".$dataV ."</td>";
                        echo "<td width='100'>" . $data->Reason . "</td>";
                     


                        echo "<td width='15'>";

                        echo "<span class='get_data label label-warning'>Pending<i class='fa fa-eye'></i> </span>";
                        echo "</td>";

//                        echo "<td width='15'>";
//                        echo "<a class='get_data btn btn-green' href='" . base_url() . "Leave_Transaction/Leave_Approve/edit_lv/" . $data->LV_ID . "'>EDIT<i class=''></i> </a>";
//                        echo "</td>";

                        echo "<td width='15'>";
                        echo "<a class='get_data btn btn-primary' href='" . base_url() . "Attendance/Attendance_Manual_Entry_ADMIN/approve/" . $data->M_ID . "'>APPROVE<i class=''></i> </a>";
                        echo "</td>";

                       echo "<td width='15'>";
                       echo "<a class='get_data btn btn-danger' href='" . base_url() . "Attendance/Attendance_Manual_Entry_ADMIN/ajax_StatusReject/" . $data->M_ID . "'>REJECT<i class=''></i> </a>";
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
