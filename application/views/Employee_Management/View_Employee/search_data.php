<!DOCTYPE html>


<!--Description of dashboard page

@author Ashan Rathsara-->

<div class="panel panel-primary">
    <div class="panel panel-default">
        <div class="panel-body panel-no-padding">
            <table id="example" class="table table-striped " cellspacing="0" width="100%">
                <thead style="background-color: #8bd945; color: #ffffff; border-top-left-radius: 20px;">
                    <tr>
                        <th>EMP NO</th>
                        <th>NAME</th>
                        <th>DESIGNATION</th>
                        <th>DEPARTMENT</th>
                        <th>BRANCH</th>
                        <th>GENDER</th>
                        <th>NIC</th>
                        <th>MOBILE NO</th>
                        <th>STATUS</th>
                        <th>IMAGE</th>
                        <!--<th>VIEW</th>-->
                        <th>EDIT</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data_set as $data) {


//                        var_dump($data_set);

                        if ($data->status == '1') {
                            $IsActive = 'Active';
                        } else {
                            $IsActive = 'Inactive';
                        }
                        ?>

                        <tr class='odd gradeX'>

                            <td width='100'><?php echo $data->EmpNo ?></td>
                            <td width='100'><?php echo $data->Emp_Full_Name ?></td>
                            <td width='100'><?php echo $data->Desig_Name ?></td>

                            <td width='100'><?php echo $data->Dep_Name ?></td>
                            <td width='100'><?php echo $data->B_name ?></td>
                            <td width='100'><?php echo $data->Gender ?></td>
                            <td width='100'><?php echo $data->NIC ?></td>
                            <td width='100'><?php echo $data->Tel_mobile ?></td>

                            <td width='100'><?php echo $IsActive ?></td>




                            <td width='15'>
            <!--////                                                                                    echo "<a class='action_comp' data-toggle='modal' data-target='#myModal' data-id='$data->EmpNo' href='" . base_url() . "index.php/Action_Complain/complain_details" . $data->EmpNo . "'><i class='fa fa-edit'></i></a>";-->
                                <a class='get_data' formtarget='_new' href="<?php echo base_url(); ?>assets/images/Employees/<?php echo $data->Image ?>" data-rel="popup"> <img style='width: 60px; height: 60px;' src="<?php echo base_url(); ?>assets/images/Employees/<?php echo $data->Image ?>" </a>
                            </td>
                            <!--//-->                
                            <td width='15'>
            <!--//                                                                                    echo "<a class='action_comp' data-toggle='modal' data-target='#myModal' data-id='$data->EmpNo' href='" . base_url() . "index.php/Action_Complain/complain_details" . $data->EmpNo . "'><i class='fa fa-edit'></i></a>";-->
                                <a class='get_data btn btn-green' href='<?php echo base_url(); ?>Employee_Management/Edit_Employees/edit/<?php echo $data->EmpNo ?>'> <i class='fa fa-edit'></i> </a>
                            </td>
            <!--//                                                                                        echo "<td width='15'>";
            //                                                                                        echo "<a href='".base_url()."index.php/Designation/view".$data->B_Code."'><i class='icon-eye-open'></i></a>";
            //                                                                                        echo  "</td>";-->
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!--<div class="panel-footer"></div>-->
        </div>
    </div>
</div>


