<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pay_slip extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!($this->session->userdata('login_user'))) {
            redirect(base_url() . "");
        }

        /*
         * Load Database model
         */
        $this->load->library("pdf_library");
        $this->load->model('Db_model');
    }

    /*
     * Index page in Departmrnt
     */

    public function index() {

        $data['title'] = "Pay Slip | HRM System";
        $data['data_dep'] = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');
        $data['data_desig'] = $this->Db_model->getData('Des_ID,Desig_Name', 'tbl_designations');
        $data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');
        $this->load->view('Reports/Payroll/Pay_slip_report', $data);
    }

    /*
     * Insert Departmrnt
     */

    public function Report_department() {

        $Data['data_set'] = $this->Db_model->getData('id,Dep_Name', 'tbl_departments');

        $this->load->view('Reports/Master/rpt_Departments', $Data);
    }

    public function Pay_slip_Report_By_Cat() {
        
        $data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');

        date_default_timezone_set('Asia/Colombo');
        $year = date("Y");

        $emp = $this->input->post("txt_emp");
        $emp_name = $this->input->post("txt_emp_name");
        $desig = $this->input->post("cmb_desig");
        $dept = $this->input->post("cmb_dep");
        $Month = $this->input->post("cmb_month");
        $to_date = $this->input->post("txt_to_date");

        $EmpNo = $this->Db_model->getfilteredData("
            SELECT EmpNo 
            FROM tbl_empmaster 
            WHERE Emp_Full_Name = '$emp_name'
        ")[0]->EmpNo ?? null;

//        $data['f_date'] = $from_date;
//        $data['t_date'] = $to_date;
        // Filter Data by categories
        $filter = '';

        $data['data_set'] = $this->Db_model->getfilteredData("
        SELECT 
        s.id,
        s.EmpNo,
        e.Emp_Full_Name,
        b.B_name,
        d.Dep_Name,
        s.Month,
        s.Year,
        s.Basic_sal,
        s.Br_pay,
        s.Salary_advance,
        s.EPF_Worker_Amount,
        s.EPF_Employee_Amount,
        s.ETF_Amount,
        s.Payee_amount,
        s.Stamp_duty,
        s.Gross_pay,
        s.no_pay_deduction,
        s.Late_deduction,
        s.Ed_deduction,
        s.Normal_OT_Pay,
        s.Incentive,
        s.tot_deduction,
        s.Net_salary
        FROM tbl_salary s
        INNER JOIN tbl_empmaster e ON e.EmpNo = s.EmpNo
        INNER JOIN tbl_departments d ON d.Dep_ID = e.Dep_ID
        INNER JOIN tbl_branches b ON b.B_id = e.B_id
        WHERE s.Month = '$Month' AND e.Emp_Full_Name = '$emp_name'
        ORDER BY s.EmpNo
        ");

        // get allowances
        $data['allowances'] = [
          'fixed' => $this->Db_model->getfilteredData("
              SELECT a.Allowance_name, b.Amount 
              FROM tbl_allowance_type a 
              JOIN tbl_allowance_has_tbl_salary c 
              ON a.Alw_ID = c.tbl_varialble_allowance_ID 
              JOIN tbl_fixed_allowance b 
              ON b.EmpNo = c.EmpNo
              WHERE c.EmpNo = '$EmpNo' AND c.Allowance_Status = 'fixed_allowance'
              GROUP BY c.tbl_varialble_allowance_ID
          "),
          'variable' => $this->Db_model->getfilteredData("
              SELECT a.Allowance_name, b.Amount
              FROM tbl_allowance_has_tbl_salary c
              JOIN tbl_allowance_type a 
              ON c.tbl_varialble_allowance_ID = a.Alw_ID
              JOIN tbl_varialble_allowance b 
              ON b.Alw_ID = a.Alw_ID AND b.EmpNo = c.EmpNo
              WHERE c.EmpNo = '$EmpNo' 
              AND c.Allowance_Status = 'varialble_allowance'
              AND b.Month = '$Month' AND b.Year = '$year'
              GROUP BY c.tbl_varialble_allowance_ID
          ")
        ];

        // get deductions
        $data['deductions'] = [
          'fixed' => $this->Db_model->getfilteredData("
              SELECT a.Deduction_name, c.Amount 
              FROM tbl_deduction_types a 
              JOIN tbl_deduction_has_tbl_salary b 
              ON a.Ded_ID = b.tbl_varialble_deduction_ID 
              JOIN tbl_fixed_deduction c 
              ON c.Deduction_ID = a.Ded_ID
              WHERE b.Deduction_Status = 'fixed_deduction' 
              AND b.EmpNo = '$EmpNo'
              GROUP BY b.tbl_varialble_deduction_ID
          "),
          'variable' => $this->Db_model->getfilteredData("
              SELECT a.Deduction_name, c.Amount 
              FROM tbl_deduction_types a 
              JOIN tbl_deduction_has_tbl_salary b 
              ON a.Ded_ID = b.tbl_varialble_deduction_ID 
              JOIN tbl_variable_deduction c 
              ON c.Ded_ID = a.Ded_ID
              WHERE b.Deduction_Status = 'varialble_deduction' 
              AND b.EmpNo = '$EmpNo' 
              AND c.Month = '$Month' AND c.Year = '$year'
              GROUP BY b.tbl_varialble_deduction_ID
          ")
        ];

        $data['data_month'] = $Month;
        $data['data_year'] = $year;

        // var_dump($data['allowances']);die;

        $this->load->view('Reports/Payroll/rpt_pay_slip', $data);
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
