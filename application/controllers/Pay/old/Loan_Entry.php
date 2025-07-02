<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Loan_Entry extends CI_Controller {

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
        $data['title'] = "Loan Entry | HRM SYSTEM";
        $data['data_emp'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $data['data_loan'] = $this->Db_model->getData('Loan_ID,loan_name', 'tbl_loan_types');
        $data['data_dep'] = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');
        $data['data_desig'] = $this->Db_model->getData('Des_ID,Desig_Name', 'tbl_designations');
        $data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');
        $this->load->view('Payroll/Loan_Entry/index', $data);
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

        /*
         * Set Defalt Date TimeZone
         */
        date_default_timezone_set('Asia/Colombo');
        $date = date_create();
        $timestamp = date_format($date, 'Y-m-d H:i:s');

        $loan_id = $this->input->post('cmb_loan_id');
        $month = $this->input->post('cmb_month');
        $amount = $this->input->post('txt_amount');
        $No_of_Inst = $this->input->post('txt_no_of_inst');
        $Rate = $this->input->post('txt_rate');
        $Full_Amount = $this->input->post('txt_amt_with_ins');
        $Month_Inst = $this->input->post('txt_m_inst');
        $year = date("Y");

        $Count = count($EmpData);
        $Emp = $EmpData[0]->EmpNo;

        $HasRow = $this->Db_model->getfilteredData("select count(EmpNo) as HasRow from tbl_loans where EmpNo=$Emp and Loan_ID=$loan_id and Is_Settled=0");

        if ($HasRow->HasRow>0) {
            $this->session->set_flashdata('error_message', 'Employee cannot apply new loan untill settle loans');
        } else {
            for ($i = 0; $i < $Count; $i++) {
            $data = array(
                array(
                    'Loan_ID' => $loan_id,
                    'EmpNo' => $EmpData[$i]->EmpNo,
                    'Loan_amount' => $amount,
//                    'Request_Date' => $year,
                    'Loan_date' => $timestamp,
                    'Month' => $month,
                    'Year' => $year,
                    'NoOfInst' => $No_of_Inst,
                    'Rate' => $Rate,
                    'Month_Installment' => $Month_Inst,
                    'FullAmount' => $Full_Amount,
//                    'Paid_Amount' => $month,
                    'Balance_amount' => $Full_Amount,
            ));
            $this->db->insert_batch('tbl_loans', $data);
            $this->session->set_flashdata('success_message', 'New Loan added successfully');
        }
        }
        redirect('/Pay/Loan_Entry/');

        
    }
    
    
    
    public function getLoans() {
        $emp = $this->input->post("txt_emp");
        $emp_name = $this->input->post("txt_emp_name");
        $desig = $this->input->post("cmb_desig");
        $dept = $this->input->post("cmb_dep");
        $year = $this->input->post("cmb_year");
        $loan_type = $this->input->post("cmb_loan_type");



        // Filter Data by categories
        $filter = '';

        if (($this->input->post("cmb_year")) && ($this->input->post("cmb_year"))) {
            if ($filter == '') {
                $filter = " where  tbl_loans.year =$year";
            } else {
                $filter .= " AND  tbl_loans.year =$year";
            }
        }
        if (($this->input->post("txt_emp"))) {
            if ($filter == null) {
                $filter = " where tbl_empmaster.EmpNo =$emp";
            } else {
                $filter .= " AND tbl_empmaster.EmpNo =$emp";
            }
        }

        if (($this->input->post("txt_emp_name"))) {
            if ($filter == null) {
                $filter = " where tbl_empmaster.Emp_Full_Name ='$emp_name'";
            } else {
                $filter .= " AND tbl_empmaster.Emp_Full_Name ='$emp_name'";
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
        if (($this->input->post("cmb_loan_type"))) {
            if ($filter == null) {
                $filter = " where tbl_loan_types.Loan_ID  ='$loan_type'";
            } else {
                $filter .= " AND tbl_loan_types.Loan_ID  ='$loan_type'";
            }
        }
        if (($this->input->post("cmb_year"))) {
            if ($filter == null) {
                $filter = " where tbl_loans.Year  ='$year'";
            } else {
                $filter .= " AND tbl_loans.Year  ='$year'";
            }
        }


        $data['data_set'] = $this->Db_model->getfilteredData("SELECT 
    tbl_loans.ID,
    tbl_loan_types.Loan_ID,
    tbl_loan_types.loan_name,
    tbl_empmaster.EmpNo,
    tbl_empmaster.Emp_Full_Name,
    tbl_loans.Loan_date,
    tbl_loans.Year,
    tbl_loans.FullAmount,
    tbl_loans.Paid_Amount,
    tbl_loans.Balance_amount,
    tbl_loans.Is_Settled
FROM
    tbl_loans
        LEFT JOIN
    tbl_empmaster ON tbl_empmaster.EmpNo = tbl_loans.EmpNo
        INNER JOIN
    tbl_loan_types ON tbl_loan_types.Loan_ID = tbl_loans.Loan_ID
        INNER JOIN
    tbl_designations dsg ON dsg.Des_ID = tbl_empmaster.Des_ID
        LEFT JOIN
    tbl_departments dep ON dep.Dep_id = tbl_empmaster.Dep_id
                                                                    {$filter}");

//        var_dump($data);die;

        $this->load->view('Payroll/Loan_Entry/search_data', $data);
    }
    
    
     /*
     * Delete Data
     */

    public function ajax_delete($id) {
        $table = "tbl_loans";
        $where = 'ID';
        $this->Db_model->delete_by_id($id, $where, $table);
        echo json_encode(array("status" => TRUE));
    }


}
