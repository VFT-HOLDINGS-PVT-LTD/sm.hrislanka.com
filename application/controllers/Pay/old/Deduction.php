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

        $deduction = $this->input->post('cmb_deduction');
        $month = $this->input->post('cmb_month');
        $amount = $this->input->post('txt_amount');
        $year = date("Y");

        $Count = count($EmpData);


        $Emp = $EmpData[0]->EmpNo;

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

        $data = array("Amount" => $amount);
        $whereArr = array("ID" => $ID);
        $result = $this->Db_model->updateData("tbl_variable_deduction", $data, $whereArr);

        $this->session->set_flashdata('success_message', 'Deduction edit successfully');

        redirect(base_url() . "Pay/Deduction");
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
