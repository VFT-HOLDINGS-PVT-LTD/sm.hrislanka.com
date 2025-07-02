<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Salary_Increment extends CI_Controller {

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

        $data['title'] = "Salary Increment | HRM SYSTEM";
        $data['data_dep'] = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');
        $data['data_desig'] = $this->Db_model->getData('Des_ID,Desig_Name', 'tbl_designations');
        $data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');
        $data['data_emp'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $data['data_alw'] = $this->Db_model->getData('Alw_ID,Allowance_name', 'tbl_allowance_type');
        $this->load->view('Payroll/Salary_Increment/index', $data);
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
    }

    public function insert_data() {

        $cat = $this->input->post('cmb_cat');
        if ($cat == "Employee") {
            $cat2 = $this->input->post('cmb_cat2');
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

        $allowance = $this->input->post('cmb_allowance');
        $month = $this->input->post('cmb_month');
        $amount = $this->input->post('txt_amount');
        $year = date("Y");

        $Count = count($EmpData);
        $Emp = $EmpData[0]->EmpNo;



//        $IsAllowance = $this->Db_model->getfilteredData("select count(EmpNo) HasRow from tbl_varialble_allowance where EmpNo ='$Emp' and Alw_ID='$allowance' and month='$month' and Year = '$year' ");

        $BasicS = $this->Db_model->getfilteredData("select Basic_Salary from tbl_empmaster where EmpNo ='$Emp' ");

        $BasicSal = $BasicS[0]->Basic_Salary;


        $data = array(
            'EmpNo' => $Emp,
            'Old_Salary' => $BasicSal,
            'Increment_amount' => $amount,
            'New_Salary' => $BasicSal + $amount,
            'iYear' => $year,
            'iMonth' => $month
        );

        $result = $this->Db_model->insertData("tbl_salary_increments", $data);

        $data1 = array("Basic_Salary" => $BasicSal + $amount);
        $whereArr = array("EmpNo" => $Emp);
        $result = $this->Db_model->updateData("tbl_empmaster", $data1, $whereArr);

        $this->session->set_flashdata('success_message', 'Salary Increment added successfully');




        redirect(base_url() . "Pay/Salary_Increment");
    }

    /*
     * Get Allowances Details
     */

    public function getAllIncrements() {

        $emp = $this->input->post("txt_emp");
        $emp_name = $this->input->post("txt_emp_name");
        $desig = $this->input->post("cmb_desig");
        $dept = $this->input->post("cmb_dep");
        $month = $this->input->post("cmb_month");
        $cmb_year = $this->input->post("cmb_years");
        $cmb_allowance = $this->input->post("cmb_allowances");



        // Filter Data by categories
        $filter = '';

        if (($this->input->post("cmb_allowances"))) {
            if ($filter == '') {
                $filter = " where  si.Alw_ID =$cmb_allowance";
            } else {
                $filter .= " AND  v_alw.Alw_ID =$cmb_allowance";
            }
        }

        if (($this->input->post("cmb_years"))) {
            if ($filter == '') {
                $filter = " where  si.Year =$cmb_year";
            } else {
                $filter .= " AND  si.Year =$cmb_year";
            }
        }

        if (($this->input->post("cmb_month"))) {
            if ($filter == '') {
                $filter = " where  si.Month =$month";
            } else {
                $filter .= " AND  si.Month =$month";
            }
        }
        if (($this->input->post("txt_emp"))) {
            if ($filter == null) {
                $filter = " where si.EmpNo =$emp";
            } else {
                $filter .= " AND si.EmpNo =$emp";
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
    si.SI_ID,
    Emp.EmpNo,
    Emp.Emp_Full_Name,
    dsg.Desig_Name,
    dep.Dep_Name,
    si.Old_Salary,
    si.New_Salary,
    si.Increment_amount,
    si.iYear,
    si.iMonth
FROM
    tbl_salary_increments si
        INNER JOIN
    tbl_empmaster Emp ON Emp.EmpNo = si.EmpNo
        LEFT JOIN
    tbl_designations dsg ON dsg.Des_ID = Emp.Des_ID
        LEFT JOIN
    tbl_departments dep ON dep.Dep_id = Emp.Dep_id


                                                                    {$filter}");



        $this->load->view('Payroll/Salary_Increment/search_data', $data);
    }

    /*
     * Get data
     */

    public function get_details() {
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

    /*
     * Edit Data
     */

    public function edit() {
        $ID = $this->input->post("id", TRUE);
        $Name = $this->input->post("Name", TRUE);
        $allowance = $this->input->post("allowance", TRUE);
        $amount = $this->input->post("amount", TRUE);

        $data = array("Amount" => $amount);
        $whereArr = array("ID" => $ID);
        $result = $this->Db_model->updateData("tbl_varialble_allowance", $data, $whereArr);

        $this->session->set_flashdata('success_message', 'Allowance edit successfully');

        redirect(base_url() . "Pay/Allowance");
    }

    /*
     * Delete Data
     */

    public function ajax_delete($id) {
        $table = "tbl_varialble_allowance";
        $where = 'ID';
        $this->Db_model->delete_by_id($id, $where, $table);
        echo json_encode(array("status" => TRUE));
    }

}
