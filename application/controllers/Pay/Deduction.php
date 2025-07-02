<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Deduction extends CI_Controller {

    public function __construct() {
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

    public function index() {

        $this->load->helper('url');
        $data['title'] = "Deduction | HRM SYSTEM";
        $data['data_dep'] = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');
        $data['data_desig'] = $this->Db_model->getData('Des_ID,Desig_Name', 'tbl_designations');
        $data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');
        $data['data_emp'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $data['data_ded'] = $this->Db_model->getData('Ded_ID,Deduction_name', 'tbl_deduction_types');
        $this->load->view('Payroll/Deduction/index', $data);
    }

    public function dropdown() {

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

//        if ($cat == "Department") {
//            $query = $this->Db_model->get_dropdown_dep();
//            
//            echo"<select class='form-control' id='Dep' name='Dep'>";
//            foreach ($query->result() as $row) {
//                echo "<option value='" . $row->ID . "'>" . $row->Dep_Name . "</option>";
//            }
//            echo"</select>";
//        }
    }

    public function insert_data() {

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

        $deduction = $this->input->post('cmb_deduction');
        $month = $this->input->post('cmb_month');
        $amount = $this->input->post('txt_amount');
        $year = date("Y");

        $Count = count($EmpData);

        $Emp = $EmpData[0]->EmpNo;


        $Emp = $EmpData[0]->EmpNo;
        $fixed = $this->input->post('isFixed');
        if ($fixed == 1) {
            $IsfixedAllowance = $this->Db_model->getfilteredData("select count(EmpNo) HasRow from tbl_fixed_deduction where EmpNo ='$Emp' and Deduction_ID='$deduction' ");
            if ($IsfixedAllowance[0]->HasRow > 0) {
                $this->session->set_flashdata('error_message', 'Already Added This Fixed Deduction Type for This Employee');
            } else {
                for ($i = 0; $i < $Count; $i++) {
                    $data = array(
                        array(
                            'EmpNo' => $EmpData[$i]->EmpNo,
                            'Deduction_ID' => $deduction,
                            'Amount' => $amount,

                        )
                    );

                    $this->db->insert_batch('tbl_fixed_deduction', $data);
                }
                $this->session->set_flashdata('success_message', 'Allovance added successfully');
            }
        }else{
            $IsDeduction = $this->Db_model->getfilteredData("select count(EmpNo) HasRow from tbl_variable_deduction where EmpNo =$Emp and Ded_ID=$deduction and month=$month and year = $year");


            if ($IsDeduction[0]->HasRow > 0) {
                $this->session->set_flashdata('error_message', 'Already Added This Deduction Type for This Employee');
            } else {
    
                for ($i = 0; $i < $Count; $i++) {
                    $data = array(
                        array(
                            'EmpNo' => $EmpData[$i]->EmpNo,
                            'Ded_ID' => $deduction,
                            'Amount' => $amount,
                            'Year' => $year,
                            'Month' => $month,
                    ));
                    $this->db->insert_batch('tbl_variable_deduction', $data);
                    $this->session->set_flashdata('success_message', 'Deduction added successfully');
                }
            }
        }

        
        redirect('/Pay/Deduction');
    }

    public function getDeductions() {

        $emp = $this->input->post("txt_emp");
        $emp_name = $this->input->post("txt_emp_name");
        $desig = $this->input->post("cmb_desig");
        $dept = $this->input->post("cmb_dep");
        $month = $this->input->post("cmb_months");
        $cmb_year = $this->input->post("cmb_years");
        $cmb_deductions = $this->input->post("cmb_deductions");

        // Filter Data by categories
        $filter = '';

        if (($this->input->post("cmb_deductions"))) {
            if ($filter == '') {
                $filter = " where  v_ded.Ded_ID =$cmb_deductions";
            } else {
                $filter .= " AND  v_ded.Ded_ID =$cmb_deductions";
            }
        }

        if (($this->input->post("cmb_years"))) {
            if ($filter == '') {
                $filter = " where  v_ded.Year =$cmb_year";
            } else {
                $filter .= " AND  v_ded.Year =$cmb_year";
            }
        }

        if (($this->input->post("cmb_months"))) {
            if ($filter == '') {
                $filter = " where   v_ded.Month =$month";
            } else {
                $filter .= " AND   v_ded.Month =$month";
            }
        }
        if (($this->input->post("txt_emp"))) {
            if ($filter == null) {
                $filter = " where v_ded.EmpNo =$emp";
            } else {
                $filter .= " AND v_ded.EmpNo =$emp";
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


        $data['data_set'] = $this->Db_model->getfilteredData("SELECT 
    v_ded.ID,
    v_ded.EmpNo,
    v_ded.Ded_ID,
    v_ded.Amount,
    v_ded.Year,
    v_ded.Month,
    Emp.Emp_Full_Name,
    dsg.Desig_Name,
    dep.Dep_Name,
    ded_typ.Deduction_name
FROM
    tbl_variable_deduction v_ded
        INNER JOIN
    tbl_empmaster Emp ON Emp.EmpNo = v_ded.EmpNo
        LEFT JOIN
    tbl_designations dsg ON dsg.Des_ID = Emp.Des_ID
        LEFT JOIN
    tbl_departments dep ON dep.Dep_id = Emp.Dep_id
        LEFT JOIN
    tbl_deduction_types ded_typ ON ded_typ.Ded_ID = v_ded.Ded_ID

                                                                    {$filter}");

//        var_dump($data);die;

        $this->load->view('Payroll/Deduction/search_data', $data);
    }

    /*
     * Get data
     */

    public function get_details() {

        $id = $this->input->post('id');

//        var_dump($id);die;

        $dataObject = $this->Db_model->getfilteredData("SELECT 
                                                                    v_ded.ID,
                                                                    v_ded.EmpNo,
                                                                    v_ded.Ded_ID,
                                                                    v_ded.Amount,
                                                                    v_ded.Year,
                                                                    v_ded.Month,
                                                                    Emp.Emp_Full_Name,
                                                                    dsg.Desig_Name,
                                                                    dep.Dep_Name,
                                                                    ded_typ.Deduction_name
                                                                FROM
                                                                    tbl_variable_deduction v_ded
                                                                        INNER JOIN
                                                                    tbl_empmaster Emp ON Emp.EmpNo = v_ded.EmpNo
                                                                        LEFT JOIN
                                                                    tbl_designations dsg ON dsg.Des_ID = Emp.Des_ID
                                                                        LEFT JOIN
                                                                    tbl_departments dep ON dep.Dep_id = Emp.Dep_id
                                                                        LEFT JOIN
                                                                    tbl_deduction_types ded_typ ON ded_typ.Ded_ID = v_ded.Ded_ID
                                                                    where v_ded.ID=$id
                                                                    ");

        $array = (array) $dataObject;
        echo json_encode($array);
    }

    /*
     * Edit Data
     */

    public function edit() {
        $ID = $this->input->post("id", TRUE);
        $Name = $this->input->post("Name", TRUE);
        $allowance = $this->input->post("deduction", TRUE);
        $amount = $this->input->post("amount", TRUE);

        $dataObject = $this->Db_model->getfilteredData("SELECT * FROM `tbl_variable_deduction` WHERE `ID`='".$ID."'");
        $oldDed = $dataObject[0]->Amount;
        $YearData = $dataObject[0]->Year;
        $MonthData = $dataObject[0]->Month;
        
        // Datetime
        $date = new DateTime("now", new DateTimeZone("Asia/Colombo"));
        $formattedDate = $date->format('Y-m-d H:i:s');

        $NewAmount = $oldDed + $amount;

        $dataAllowance  = array(
            'Deduction_ID' => $ID,
            'Deduction_Type' => 'varialble_deduction',
            'Old_Deduction' => $oldDed,
            'Increment_Amount' => $amount,
            'New_Deduction' => $NewAmount,
            'Year' => $YearData,
            'Month' => $MonthData,
            'Update_Date_Time'=>$formattedDate

        );

        $this->Db_model->insertData("tbl_deduction_history", $dataAllowance);

        $data = array("Amount" => $NewAmount);
        $whereArr = array("ID" => $ID);
        $result = $this->Db_model->updateData("tbl_variable_deduction", $data, $whereArr);

        $this->session->set_flashdata('success_message', 'Deduction edit successfully');

        redirect(base_url() . "Pay/Deduction");
    }

    public function getHistoryDeductions()
    {

        $emp = $this->input->post("txt_emp3");
        // $emp_name = $this->input->post("txt_emp_name3");
        // $desig = $this->input->post("cmb_desig3");
        // $dept = $this->input->post("cmb_dep3");
        // $month = $this->input->post("cmb_month1");
        // $cmb_year = $this->input->post("cmb_years3");
        $cmb_allowance = $this->input->post("cmb_fixedDeduction3");
        $cmb_allowance_status = $this->input->post("cmb_Deductionstatus3");



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

        if ($cmb_allowance_status == "varialble_deduction") {
            $data['data_set'] = $this->Db_model->getfilteredData("SELECT tbl_variable_deduction.EmpNo,tbl_deduction_types.Deduction_name,tbl_deduction_history.Old_Deduction,tbl_deduction_history.Increment_Amount,tbl_deduction_history.New_Deduction,tbl_deduction_history.`Year`,tbl_deduction_history.`Month`,tbl_deduction_history.ID FROM `tbl_deduction_history` INNER JOIN `tbl_variable_deduction` ON tbl_deduction_history.Deduction_ID = tbl_variable_deduction.ID INNER JOIN tbl_deduction_types ON tbl_deduction_types.Ded_ID = tbl_variable_deduction.Ded_ID {$filter}");
            $this->load->view('Payroll/Deduction/search_history_data', $data);

        }elseif ($cmb_allowance_status == "fixed_deduction") {
            // $data['data_set'] = $this->Db_model->getfilteredData("SELECT tbl_fixed_allowance.EmpNo,tbl_allowance_type.Allowance_name,tbl_allowance_history.Old_Allowance,tbl_allowance_history.Increment_Amount,tbl_allowance_history.New_Allowance,tbl_allowance_history.`Year`,tbl_allowance_history.`Month`,tbl_allowance_history.ID FROM `tbl_allowance_history` INNER JOIN `tbl_fixed_allowance` ON tbl_allowance_history.Allowance_ID = tbl_fixed_allowance.ID INNER JOIN tbl_allowance_type ON tbl_allowance_type.Alw_ID = tbl_fixed_allowance.Alw_ID {$filter}");
            // $this->load->view('Payroll/Allowance/search_history_data', $data);

        }else{
            echo "No Data Found, Please select the 'Deduction Status'";;
        }



    }

    /*
     * Delete Data
     */

    public function ajax_delete($id) {
        $table = "tbl_variable_deduction";
        $where = 'ID';
        $this->Db_model->delete_by_id($id, $where, $table);
        echo json_encode(array("status" => TRUE));
    }

}
