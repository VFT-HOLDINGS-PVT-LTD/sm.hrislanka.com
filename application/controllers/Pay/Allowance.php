<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Allowance extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!($this->session->userdata('login_user'))) {
            redirect(base_url() . "");
        }
        /*
         * Load Database model
         */
        $this->load->model('Db_model', '', TRUE);
    }

    /*
     * Index page
     */

    public function index()
    {

        $data['title'] = "Allowance | HRM SYSTEM";
        $data['data_dep'] = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');
        $data['data_desig'] = $this->Db_model->getData('Des_ID,Desig_Name', 'tbl_designations');
        $data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');
        $data['data_emp'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $data['data_alw'] = $this->Db_model->getData('Alw_ID,Allowance_name', 'tbl_allowance_type');
        $this->load->view('Payroll/Allowance/index', $data);
    }

    public function dropdown()
    {

        $cat = $this->input->post('cmb_cat');

        if ($cat == "Employee") {
            $query = $this->Db_model->get_dropdown();
            echo '<option value="" default>-- Select --</option>';
            foreach ($query->result() as $row) {

                echo "<option value='" . $row->EmpNo . "'>" . $row->Emp_Full_Name . "</option>";
            }
        }

        if ($cat == "Department") {
            $query = $this->Db_model->get_dropdown_dep();
            echo '<option value="" default>-- Select --</option>';
            foreach ($query->result() as $row) {
                echo "<option value='" . $row->Dep_ID . "'>" . $row->Dep_Name . "</option>";
            }
        }
        if ($cat == "Designation") {
            $query = $this->Db_model->get_dropdown_des();
            echo '<option value="" default>-- Select --</option>';
            foreach ($query->result() as $row) {
                echo "<option value='" . $row->Des_ID . "'>" . $row->Desig_Name . "</option>";
            }
        }
        if ($cat == "Employee_Group") {
            $query = $this->Db_model->get_dropdown_group();
            echo '<option value="" default>-- Select --</option>';
            foreach ($query->result() as $row) {
                echo "<option value='" . $row->Grp_ID . "'>" . $row->EmpGroupName . "</option>";
            }
        }

        if ($cat == "Company") {
            $query = $this->Db_model->get_dropdown_comp();
            echo '<option value="" default>-- Select --</option>';
            foreach ($query->result() as $row) {
                echo "<option value='" . $row->Cmp_ID . "'>" . $row->Company_Name . "</option>";
            }
        }
    }

    public function insert_data()
    {

        $cat = $this->input->post('cmb_cat');
        if ($cat == "Employee") {
            $cat2 = $this->input->post('txt_nic');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE EmpNo='$cat2'";
            $EmpData = $this->Db_model->getfilteredData($string);
        }

        if ($cat == "Department") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE Dep_ID='$cat2'";
            $EmpData = $this->Db_model->getfilteredData($string);
        }

        if ($cat == "Designation") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE Des_ID='$cat2'";
            $EmpData = $this->Db_model->getfilteredData($string);
        }
        if ($cat == "Employee_Group") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE Grp_ID='$cat2'";
            $EmpData = $this->Db_model->getfilteredData($string);
        }

        if ($cat == "Company") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE Cmp_ID='$cat2'";
            $EmpData = $this->Db_model->getfilteredData($string);
        }

        // var_dump($cat2);
        // die;

        $allowance = $this->input->post('cmb_allowance');
        $month = $this->input->post('cmb_month');
        $amount = $this->input->post('txt_amount');
        $year = date("Y");

        $Count = count($EmpData);
        $Emp = $EmpData[0]->EmpNo;
        $fixed = $this->input->post('isFixed');
        $Emp = $EmpData[0]->EmpNo;

       


        if ($fixed == 1) {
            $IsfixedAllowance = $this->Db_model->getfilteredData("select count(EmpNo) HasRow from tbl_fixed_allowance where EmpNo ='$Emp' and Alw_ID='$allowance' ");
            if ($IsfixedAllowance[0]->HasRow > 0) {
                $this->session->set_flashdata('error_message', 'Already Added This Fixed Allovance Type for This Employee');
            } else {
                for ($i = 0; $i < $Count; $i++) {
                    $data = array(
                        array(
                            'EmpNo' => $EmpData[$i]->EmpNo,
                            'Alw_ID' => $allowance,
                            'Amount' => $amount,

                        )
                    );

                    $this->db->insert_batch('tbl_fixed_allowance', $data);
                }
                $this->session->set_flashdata('success_message', 'Allovance added successfully');
            }
        } else {
            $IsAllowance = $this->Db_model->getfilteredData("select count(EmpNo) HasRow from tbl_varialble_allowance where EmpNo ='$Emp' and Alw_ID='$allowance' and month='$month' and Year = '$year' ");

            if ($IsAllowance[0]->HasRow > 0) {
                $this->session->set_flashdata('error_message', 'Already Added This Allovance Type for This Employee');
            } else {
                for ($i = 0; $i < $Count; $i++) {
                    $data = array(
                        array(
                            'EmpNo' => $EmpData[$i]->EmpNo,
                            'Alw_ID' => $allowance,
                            'Amount' => $amount,
                            'Year' => $year,
                            'Month' => $month,
                        )
                    );

                    $this->db->insert_batch('tbl_varialble_allowance', $data);
                    $this->session->set_flashdata('success_message', 'Allovance added successfully');
                }
            }
        }




        redirect(base_url() . "Pay/Allowance");
    }

    /*
     * Get Allowances Details
     */
    public function getAllowances()
    {

        $emp = $this->input->post("txt_emp");
        $emp_name = $this->input->post("txt_emp_name");
        $desig = $this->input->post("cmb_desig");
        $dept = $this->input->post("cmb_dep");
        $month = $this->input->post("cmb_month1");
        $cmb_year = $this->input->post("cmb_years");
        $cmb_allowance = $this->input->post("cmb_allowances");



        // Filter Data by categories
        $filter = '';

        if (($this->input->post("cmb_allowances"))) {
            if ($filter == null) {
                $filter = " where  v_alw.Alw_ID =$cmb_allowance";
            } else {
                $filter .= " AND  v_alw.Alw_ID =$cmb_allowance";
            }
        }

        if (($this->input->post("cmb_years"))) {
            if ($filter == null) {
                $filter = " where  v_alw.Year =$cmb_year";
            } else {
                $filter .= " AND  v_alw.Year =$cmb_year";
            }
        }

        if (($this->input->post("cmb_month1"))) {
            if ($filter == null) {
                $filter = " where v_alw.Month =$month";
            } else {
                $filter .= " AND v_alw.Month =$month";
            }
        }
        
        if (($this->input->post("txt_emp"))) {
            if ($filter == null) {
                $filter = " where v_alw.EmpNo =$emp";
            } else {
                $filter .= " AND v_alw.EmpNo =$emp";
            }
        }

        if (($this->input->post("txt_emp_name"))) {
            if ($filter == null) {
                $filter = " where Emp.Emp_Full_Name ='$emp_name'";
            } else {
                $filter .= " AND Emp.Emp_Full_Name ='$emp_name'";
            }
        }
        if (($this->input->post("cmb_desig"))) {
            if ($filter == null) {
                $filter = " where dsg.Des_ID  ='$desig'";
            } else {
                $filter .= " AND dsg.Des_ID  ='$desig'";
            }
        }
        if (($this->input->post("cmb_dep"))) {
            if ($filter == null) {
                $filter = " where dep.Dep_id  ='$dept'";
            } else {
                $filter .= " AND dep.Dep_id  ='$dept'";
            }
        }

        // echo $filter;

        $data['data_set'] = $this->Db_model->getfilteredData("SELECT 
                                                                    v_alw.ID,
                                                                    v_alw.EmpNo,
                                                                    v_alw.Alw_ID,
                                                                    v_alw.Amount,
                                                                    v_alw.Year,
                                                                    v_alw.Month,
                                                                    Emp.Emp_Full_Name,
                                                                    dsg.Desig_Name,
                                                                    dep.Dep_Name,
                                                                    alw_typ.Allowance_name
                                                                FROM
                                                                    tbl_varialble_allowance v_alw
                                                                        INNER JOIN
                                                                    tbl_empmaster Emp ON Emp.EmpNo = v_alw.EmpNo
                                                                        LEFT JOIN
                                                                    tbl_designations dsg ON dsg.Des_ID = Emp.Des_ID
                                                                        LEFT JOIN
                                                                    tbl_departments dep ON dep.Dep_id = Emp.Dep_id
                                                                        LEFT JOIN
                                                                    tbl_allowance_type alw_typ ON alw_typ.Alw_ID = v_alw.Alw_ID
                                                                    {$filter}");



        $this->load->view('Payroll/Allowance/search_data', $data);
    }

    public function getFixAllowances()
    {

        $emp = $this->input->post("txt_emp2");
        $emp_name = $this->input->post("txt_emp_name2");
        $desig = $this->input->post("cmb_desig2");
        $dept = $this->input->post("cmb_dep2");
        // $month = $this->input->post("cmb_month1");
        $cmb_year = $this->input->post("cmb_years2");
        $cmb_allowance = $this->input->post("cmb_fixedallowance2");



        // Filter Data by categories
        $filter = '';

        if (($this->input->post("cmb_fixedallowance2"))) {
            if ($filter == null) {
                $filter = " where  v_alw.Alw_ID =$cmb_allowance";
            } else {
                $filter .= " AND  v_alw.Alw_ID =$cmb_allowance";
            }
        }

        if (($this->input->post("cmb_years2"))) {
            if ($filter == null) {
                $filter = " where  v_alw.Year =$cmb_year";
            } else {
                $filter .= " AND  v_alw.Year =$cmb_year";
            }
        }

        // if (($this->input->post("cmb_month1"))) {
        //     if ($filter == null) {
        //         $filter = " where v_alw.Month =$month";
        //     } else {
        //         $filter .= " AND v_alw.Month =$month";
        //     }
        // }
        
        if (($this->input->post("txt_emp2"))) {
            if ($filter == null) {
                $filter = " where v_alw.EmpNo LIKE '%$emp%'";
            } else {
                $filter .= " AND v_alw.EmpNo LIKE '%$emp%'";
            }
        }

        if (($this->input->post("txt_emp_name2"))) {
            if ($filter == null) {
                $filter = " where Emp.Emp_Full_Name LIKE '%$emp_name%'";
            } else {
                $filter .= " AND Emp.Emp_Full_Name LIKE '%$emp_name%'";
            }
        }
        if (($this->input->post("cmb_desig2"))) {
            if ($filter == null) {
                $filter = " where dsg.Des_ID  ='$desig'";
            } else {
                $filter .= " AND dsg.Des_ID  ='$desig'";
            }
        }
        if (($this->input->post("cmb_dep2"))) {
            if ($filter == null) {
                $filter = " where dep.Dep_id  ='$dept'";
            } else {
                $filter .= " AND dep.Dep_id  ='$dept'";
            }
        }

        // echo $filter;
        // // var_dump($filter);
        // die;

        $data['data_set'] = $this->Db_model->getfilteredData("SELECT 
                                                                    v_alw.ID,
                                                                    v_alw.EmpNo,
                                                                    v_alw.Alw_ID,
                                                                    v_alw.Amount,
                                                                    Emp.Emp_Full_Name,
                                                                    dsg.Desig_Name,
                                                                    dep.Dep_Name,
                                                                    alw_typ.Allowance_name
                                                                FROM
                                                                    tbl_fixed_allowance v_alw
                                                                        INNER JOIN
                                                                    tbl_empmaster Emp ON Emp.EmpNo = v_alw.EmpNo
                                                                        LEFT JOIN
                                                                    tbl_designations dsg ON dsg.Des_ID = Emp.Des_ID
                                                                        LEFT JOIN
                                                                    tbl_departments dep ON dep.Dep_id = Emp.Dep_id
                                                                        LEFT JOIN
                                                                    tbl_allowance_type alw_typ ON alw_typ.Alw_ID = v_alw.Alw_ID
                                                                    {$filter}");



        $this->load->view('Payroll/Allowance/search_data_fixed', $data);
    }

    /*
     * Get data
     */

    public function get_details()
    {
        $id = $this->input->post('id');

        $dataObject = $this->Db_model->getfilteredData("SELECT 
                                                                    v_alw.ID,
                                                                    v_alw.EmpNo,
                                                                    v_alw.Alw_ID,
                                                                    v_alw.Amount,
                                                                    v_alw.Year,
                                                                    v_alw.Month,
                                                                    Emp.Emp_Full_Name,
                                                                    dsg.Desig_Name,
                                                                    dep.Dep_Name,
                                                                    alw_typ.Allowance_name
                                                                FROM
                                                                    tbl_varialble_allowance v_alw
                                                                        INNER JOIN
                                                                    tbl_empmaster Emp ON Emp.EmpNo = v_alw.EmpNo
                                                                        LEFT JOIN
                                                                    tbl_designations dsg ON dsg.Des_ID = Emp.Des_ID
                                                                        LEFT JOIN
                                                                    tbl_departments dep ON dep.Dep_id = Emp.Dep_id
                                                                        LEFT JOIN
                                                                    tbl_allowance_type alw_typ ON alw_typ.Alw_ID = v_alw.Alw_ID where v_alw.ID=$id
                                                                    ");

        $array = (array) $dataObject;
        echo json_encode($array);
    }

    public function get_Fixed_details()
    {
        $id = $this->input->post('id');

        $dataObject = $this->Db_model->getfilteredData("SELECT 
                                                                    v_alw.ID,
                                                                    v_alw.EmpNo,
                                                                    v_alw.Alw_ID,
                                                                    v_alw.Amount,
                                                                    Emp.Emp_Full_Name,
                                                                    dsg.Desig_Name,
                                                                    dep.Dep_Name,
                                                                    alw_typ.Allowance_name
                                                                FROM
                                                                    tbl_fixed_allowance v_alw
                                                                        INNER JOIN
                                                                    tbl_empmaster Emp ON Emp.EmpNo = v_alw.EmpNo
                                                                        LEFT JOIN
                                                                    tbl_designations dsg ON dsg.Des_ID = Emp.Des_ID
                                                                        LEFT JOIN
                                                                    tbl_departments dep ON dep.Dep_id = Emp.Dep_id
                                                                        LEFT JOIN
                                                                    tbl_allowance_type alw_typ ON alw_typ.Alw_ID = v_alw.Alw_ID where v_alw.ID=$id
                                                                    ");

        $array = (array) $dataObject;
        echo json_encode($array);
    }

    /*
     * Edit Data
     */

    public function edit()
    {
        $ID = $this->input->post("id", TRUE);
        $Name = $this->input->post("Name", TRUE);
        $allowance = $this->input->post("allowance", TRUE);
        $amount = $this->input->post("amount", TRUE);

        $dataObject = $this->Db_model->getfilteredData("SELECT * FROM `tbl_varialble_allowance` WHERE `ID`='".$ID."'");
        $oldAllowance = $dataObject[0]->Amount;
        $YearData = $dataObject[0]->Year;
        $MonthData = $dataObject[0]->Month;
        
        // Datetime
        $date = new DateTime("now", new DateTimeZone("Asia/Colombo"));
        $formattedDate = $date->format('Y-m-d H:i:s');

        $NewAmount = $oldAllowance + $amount;

        $dataAllowance  = array(
            'Allowance_ID' => $ID,
            'Allowance_Type' => 'varialble_allowance',
            'Old_Allowance' => $oldAllowance,
            'Increment_Amount' => $amount,
            'New_Allowance' => $NewAmount,
            'Year' => $YearData,
            'Month' => $MonthData,
            'Update_Date_Time'=>$formattedDate

        );

        $this->Db_model->insertData("tbl_allowance_history", $dataAllowance);


        $data = array("Amount" => $NewAmount);
        $whereArr = array("ID" => $ID);
        $result = $this->Db_model->updateData("tbl_varialble_allowance", $data, $whereArr);

        $this->session->set_flashdata('success_message', 'Allowance edit successfully');

        redirect(base_url() . "Pay/Allowance");
    }

    public function editFixed()
    {
        $ID = $this->input->post("id", TRUE);
        $Name = $this->input->post("Name", TRUE);
        $allowance = $this->input->post("allowance", TRUE);
        $amount = $this->input->post("amount", TRUE);

        $dataObject = $this->Db_model->getfilteredData("SELECT * FROM `tbl_fixed_allowance` WHERE `ID`='".$ID."'");
        $oldAllowance = $dataObject[0]->Amount;
        // $YearData = $dataObject[0]->Year;
        // $MonthData = $dataObject[0]->Month;
        
        // Datetime
        $date = new DateTime("now", new DateTimeZone("Asia/Colombo"));
        $formattedDate = $date->format('Y-m-d H:i:s');

        $NewAmount = $oldAllowance + $amount;

        $dataAllowance  = array(
            'Allowance_ID' => $ID,
            'Allowance_Type' => 'fixed_allowance',
            'Old_Allowance' => $oldAllowance,
            'Increment_Amount' => $amount,
            'New_Allowance' => $NewAmount,
            'Year' => '0000',
            'Month' => '00',
            'Update_Date_Time'=>$formattedDate

        );

        $this->Db_model->insertData("tbl_allowance_history", $dataAllowance);


        $data = array("Amount" => $NewAmount);
        $whereArr = array("ID" => $ID);
        $result = $this->Db_model->updateData("tbl_fixed_allowance", $data, $whereArr);

        $this->session->set_flashdata('success_message', 'Allowance edit successfully');

        redirect(base_url() . "Pay/Allowance");
    }


    public function getHistoryAllowances()
    {

        $emp = $this->input->post("txt_emp3");
        // $emp_name = $this->input->post("txt_emp_name3");
        // $desig = $this->input->post("cmb_desig3");
        // $dept = $this->input->post("cmb_dep3");
        // $month = $this->input->post("cmb_month1");
        // $cmb_year = $this->input->post("cmb_years3");
        $cmb_allowance = $this->input->post("cmb_fixedallowance3");
        $cmb_allowance_status = $this->input->post("cmb_allowancestatus3");



        // Filter Data by categories
        $filter = '';

        if (($this->input->post("cmb_fixedallowance3"))) {
            if ($filter == null) {
                $filter = " where  tbl_allowance_type.Alw_ID =$cmb_allowance";
            } else {
                $filter .= " AND  tbl_allowance_type.Alw_ID =$cmb_allowance";
            }
        }

        if (($this->input->post("cmb_allowancestatus3"))) {
            if ($filter == null) {
                $filter = " where  Allowance_Type ='$cmb_allowance_status'";
            } else {
                $filter .= " AND  Allowance_Type ='$cmb_allowance_status'";
            }
        }

        // if (($this->input->post("cmb_years3"))) {
        //     if ($filter == null) {
        //         $filter = " where  v_alw.Year =$cmb_year";
        //     } else {
        //         $filter .= " AND  v_alw.Year =$cmb_year";
        //     }
        // }

        // if (($this->input->post("cmb_month1"))) {
        //     if ($filter == null) {
        //         $filter = " where v_alw.Month =$month";
        //     } else {
        //         $filter .= " AND v_alw.Month =$month";
        //     }
        // }
        
        if (($this->input->post("txt_emp3"))) {
            if ($filter == null) {
                $filter = " where EmpNo LIKE '%$emp%'";
            } else {
                $filter .= " AND EmpNo LIKE '%$emp%'";
            }
        }

        // if (($this->input->post("txt_emp_name3"))) {
        //     if ($filter == null) {
        //         $filter = " where Emp.Emp_Full_Name LIKE '%$emp_name%'";
        //     } else {
        //         $filter .= " AND Emp.Emp_Full_Name LIKE '%$emp_name%'";
        //     }
        // }
        // if (($this->input->post("cmb_desig3"))) {
        //     if ($filter == null) {
        //         $filter = " where dsg.Des_ID  ='$desig'";
        //     } else {
        //         $filter .= " AND dsg.Des_ID  ='$desig'";
        //     }
        // }
        // if (($this->input->post("cmb_dep3"))) {
        //     if ($filter == null) {
        //         $filter = " where dep.Dep_id  ='$dept'";
        //     } else {
        //         $filter .= " AND dep.Dep_id  ='$dept'";
        //     }
        // }

        // echo $filter;
        // // var_dump($filter);
        // die;

        if ($cmb_allowance_status == "varialble_allowance") {
            $data['data_set'] = $this->Db_model->getfilteredData("SELECT tbl_allowance_history.Update_Date_Time,tbl_varialble_allowance.EmpNo,tbl_allowance_type.Allowance_name,tbl_allowance_history.Old_Allowance,tbl_allowance_history.Increment_Amount,tbl_allowance_history.New_Allowance,tbl_allowance_history.`Year`,tbl_allowance_history.`Month`,tbl_allowance_history.ID FROM `tbl_allowance_history` INNER JOIN `tbl_varialble_allowance` ON tbl_allowance_history.Allowance_ID = tbl_varialble_allowance.ID INNER JOIN tbl_allowance_type ON tbl_allowance_type.Alw_ID = tbl_varialble_allowance.Alw_ID {$filter}");
            $this->load->view('Payroll/Allowance/search_history_data', $data);

        }elseif ($cmb_allowance_status == "fixed_allowance") {
            $data['data_set'] = $this->Db_model->getfilteredData("SELECT tbl_allowance_history.Update_Date_Time,tbl_fixed_allowance.EmpNo,tbl_allowance_type.Allowance_name,tbl_allowance_history.Old_Allowance,tbl_allowance_history.Increment_Amount,tbl_allowance_history.New_Allowance,tbl_allowance_history.`Year`,tbl_allowance_history.`Month`,tbl_allowance_history.ID FROM `tbl_allowance_history` INNER JOIN `tbl_fixed_allowance` ON tbl_allowance_history.Allowance_ID = tbl_fixed_allowance.ID INNER JOIN tbl_allowance_type ON tbl_allowance_type.Alw_ID = tbl_fixed_allowance.Alw_ID {$filter}");
            $this->load->view('Payroll/Allowance/search_history_data', $data);

        }else{
            echo "No Data Found, Please select the 'Allowance Status'";;
        }



    }

    /*
     * Delete Data
     */

    public function ajax_delete($id)
    {
        $table = "tbl_varialble_allowance";
        $where = 'ID';
        $this->Db_model->delete_by_id($id, $where, $table);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_Fixed_delete($id)
    {
        $table = "tbl_fixed_allowance";
        $where = 'ID';
        $this->Db_model->delete_by_id($id, $where, $table);
        echo json_encode(array("status" => TRUE));
    }
}
