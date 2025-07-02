<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Deduction_Report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!($this->session->userdata('login_user'))) {
            redirect(base_url() . "");
        }

        /*
         * Load Database model
         */
        $this->load->library("pdf_library");
        $this->load->model('Db_model', '', TRUE);
    }

    /*
     * Index page
     */

    public function index() {

        $data['title'] = "Deduction Report | HRM System";
        $data['data_dep'] = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');
        $data['data_desig'] = $this->Db_model->getData('Des_ID,Desig_Name', 'tbl_designations');
        $data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');
        $data['data_emp'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $data['data_alw'] = $this->Db_model->getData('Alw_ID,Allowance_name', 'tbl_allowance_type');
        $this->load->view('Reports/Payroll/Report_deductions', $data);
    }

    /*
     * Insert data
     */

    public function Report_department() {

        $Data['data_set'] = $this->Db_model->getData('id,Dep_Name', 'tbl_departments');

        $this->load->view('Reports/Master/rpt_Departments', $Data);
    }

    public function Report_Ded_by_cat() {

        $data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');

        $emp = $this->input->post("txt_emp");
        $emp_name = $this->input->post("txt_emp_name");
        $desig = $this->input->post("cmb_desig");
        $dept = $this->input->post("cmb_dep");
        $month = $this->input->post("cmb_month");


        // Filter Data by categories
        $filter = '';

        if (($this->input->post("cmb_month")) && ($this->input->post("cmb_month"))) {
            if ($filter == '') {
                $filter = " where  v_ded.Month =$month";
            } else {
                $filter .= " AND  v_ded.Month =$month";
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

        $this->load->view('Reports/Payroll/rpt_deductions', $data);
    }

    function get_auto_emp_name() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->Db_model->get_auto_emp_name($q);
        }
    }

    function get_auto_emp_no() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->Db_model->get_auto_emp_no($q);
        }
    }

}
