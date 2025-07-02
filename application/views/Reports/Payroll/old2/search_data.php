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
                <th>GENDER</th>
                <th>NIC</th>
                <th>MOBILE NO</th>
                <th>STATUS</th>
                <th>VIEW</th>
                <th>EDIT</th>

            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data_set as $data) {

                if($data->status =='1'){
                    $IsActive= 'Active';
                }
                else{
                    $IsActive= 'Inactive';
                }

                echo "<tr class='odd gradeX'>";

                echo "<td width='100'>" . $data->EmpNo . "</td>";
                echo "<td width='100'>" . $data->Emp_Full_Name . "</td>";
                echo "<td width='100'>" . $data->Desig_Name . "</td>";
                echo "<td width='100'>" . $data->Dep_Name . "</td>";
                echo "<td width='100'>" . $data->Gender . "</td>";
                echo "<td width='100'>" . $data->NIC . "</td>";
                echo "<td width='100'>" . $data->Tel_mobile . "</td>";
                echo "<td width='100'>" . $IsActive. "</td>";




                echo "<td width='15'>";
//                                                                                    echo "<a class='action_comp' data-toggle='modal' data-target='#myModal' data-id='$data->EmpNo' href='" . base_url() . "index.php/Action_Complain/complain_details" . $data->EmpNo . "'><i class='fa fa-edit'></i></a>";
                echo "<button class='get_data btn btn-primary' href='" . base_url() . "Master/Employees/edit/" . $data->EmpNo . "'> <i class='fa fa-eye'></i> </button>";
                echo "</td>";
                
                echo "<td width='15'>";
//                                                                                    echo "<a class='action_comp' data-toggle='modal' data-target='#myModal' data-id='$data->EmpNo' href='" . base_url() . "index.php/Action_Complain/complain_details" . $data->EmpNo . "'><i class='fa fa-edit'></i></a>";
                echo "<a class='get_data btn btn-green' href='" . base_url() . "Employee_Management/Edit_Employees/edit/" . $data->EmpNo . "'> <i class='fa fa-edit'></i> </a>";
                echo "</td>";
//                                                                                        echo "<td width='15'>";
//                                                                                        echo "<a href='".base_url()."index.php/Designation/view".$data->B_Code."'><i class='icon-eye-open'></i></a>";
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
