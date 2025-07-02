<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Budget_Relevance extends CI_Controller {

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

        $data['title'] = "Allowance | HRM SYSTEM";
        $data['data_dep'] = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');
        $data['data_desig'] = $this->Db_model->getData('Des_ID,Desig_Name', 'tbl_designations');
        $data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');
        $data['data_emp'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $data['data_alw'] = $this->Db_model->getData('ID,Br_name', 'tbl_br_types');
        $this->load->view('Payroll/Budget_Relevance/index', $data);
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

        $IsAllowance = $this->Db_model->getfilteredData("select count(EmpNo) HasRow from tbl_varialble_br where EmpNo ='$Emp' and Br_ID='$allowance' and month='$month' and Year = '$year' ");

        if ($IsAllowance[0]->HasRow > 0) {
            $this->session->set_flashdata('error_message', 'Already Added This Allovance Type for This Employee');
        } else {
            for ($i = 0; $i < $Count; $i++) {
                $data = array(
                    array(
                        'EmpNo' => $EmpData[$i]->EmpNo,
                        'Br_ID' => $allowance,
                        'Amount' => $amount,
                        'Year' => $year,
                        'Month' => $month,
                ));
                
                $this->db->insert_batch('tbl_varialble_br', $data);
                $this->session->set_flashdata('success_message', 'Budget Relevance added successfully');
            }
        }
        
        
        redirect(base_url() . "Pay/Budget_Relevance");
    }

    /*
     * Get Allowances Details
     */
    public function getAllowances() {
        
        $emp = $this->input->post("txt_emp");
        $emp_name = $this->input->post("txt_emp_name");
        $desig = $this->input->post("cmb_desig");
        $dept = $this->input->post("cmb_dep");
        $month = $this->input->post("cmb_month");
        $cmb_year= $this->input->post("cmb_years");
        $cmb_allowance= $this->input->post("cmb_allowances");
        
        
        
        // Filter Data by categories
        $filter = '';
        
        if (($this->input->post("cmb_allowances"))) {
            if ($filter == '') {
                $filter = " where  v_alw.Alw_ID =$cmb_allowance";
            } else {
                $filter .= " AND  v_alw.Alw_ID =$cmb_allowance";
            }
        }

        if (($this->input->post("cmb_years"))) {
            if ($filter == '') {
                $filter = " where  v_alw.Year =$cmb_year";
            } else {
                $filter .= " AND  v_alw.Year =$cmb_year";
            }
        }
        
        if (($this->input->post("cmb_month"))) {
            if ($filter == '') {
                $filter = " where  v_alw.Month =$month";
            } else {
                $filter .= " AND  v_alw.Month =$month";
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


        $data['data_set'] = $this->Db_model->getfilteredData("SELECT 
                                                                    v_alw.ID,
                                                                    v_alw.EmpNo,
                                                                    v_alw.Br_ID,
                                                                    v_alw.Amount,
                                                                    v_alw.Year,
                                                                    v_alw.Month,
                                                                    Emp.Emp_Full_Name,
                                                                    dsg.Desig_Name,
                                                                    dep.Dep_Name,
                                                                    alw_typ.Br_name
                                                                FROM
                                                                tbl_varialble_br v_alw
                                                                        INNER JOIN
                                                                    tbl_empmaster Emp ON Emp.EmpNo = v_alw.EmpNo
                                                                        LEFT JOIN
                                                                    tbl_designations dsg ON dsg.Des_ID = Emp.Des_ID
                                                                        LEFT JOIN
                                                                    tbl_departments dep ON dep.Dep_id = Emp.Dep_id
                                                                        LEFT JOIN
                                                                        tbl_br_types alw_typ ON alw_typ.ID = v_alw.Br_ID
                                                                    {$filter}");



        $this->load->view('Payroll/Budget_Relevance/search_data', $data);
    }

    /*
     * Get data
     */

    public function get_details() {
        $id = $this->input->post('id');

        $dataObject = $this->Db_model->getfilteredData("SELECT 
                                                                    v_alw.ID,
                                                                    v_alw.EmpNo,
                                                                    v_alw.Br_ID,
                                                                    v_alw.Amount,
                                                                    v_alw.Year,
                                                                    v_alw.Month,
                                                                    Emp.Emp_Full_Name,
                                                                    dsg.Desig_Name,
                                                                    dep.Dep_Name,
                                                                    alw_typ.Allowance_name
                                                                FROM
                                                                tbl_varialble_br v_alw
                                                                        INNER JOIN
                                                                    tbl_empmaster Emp ON Emp.EmpNo = v_alw.EmpNo
                                                                        LEFT JOIN
                                                                    tbl_designations dsg ON dsg.Des_ID = Emp.Des_ID
                                                                        LEFT JOIN
                                                                    tbl_departments dep ON dep.Dep_id = Emp.Dep_id
                                                                        LEFT JOIN
                                                                        tbl_br_types alw_typ ON alw_typ.ID = v_alw.ID where v_alw.ID=$id
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
        $result = $this->Db_model->updateData("tbl_varialble_br", $data, $whereArr);
        
        $this->session->set_flashdata('success_message', 'Allowance edit successfully');
        
        redirect(base_url() . "Pay/Allowance");
    }

    /*
     * Delete Data
     */

    public function ajax_delete($id) {
        $table = "tbl_varialble_br";
        $where = 'ID';
        $this->Db_model->delete_by_id($id, $where, $table);
        echo json_encode(array("status" => TRUE));
    }

}
