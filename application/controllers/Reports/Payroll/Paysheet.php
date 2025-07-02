<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Paysheet extends CI_Controller
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
        $this->load->library("pdf_library");
        $this->load->model('Db_model', '', TRUE);
    }

    /*
     * Index page in Departmrnt
     */

    public function index()
    {

        $data['title'] = "Pay Sheet | HRM System";
        $data['data_dep'] = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');
        $data['data_desig'] = $this->Db_model->getData('Des_ID,Desig_Name', 'tbl_designations');
        $data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');
        $data['data_branch'] = $this->Db_model->getData('B_id,B_name', 'tbl_branches');
        // $data['data_dep'] = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');
        $this->load->view('Reports/Payroll/Paysheet_report', $data);
    }

    /*
     * Insert Departmrnt
     */

    public function Report_department()
    {

        $Data['data_set'] = $this->Db_model->getData('id,Dep_Name', 'tbl_departments');

        $this->load->view('Reports/Master/rpt_Departments', $Data);
    }

    public function Pay_sheet_Report_By_Cat()
    {

        $data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');
        date_default_timezone_set('Asia/Colombo');

        $emp = $this->input->post("txt_emp");
        $emp_name = $this->input->post("txt_emp_name");
        $desig = $this->input->post("cmb_desig");
        $year1 = $this->input->post("cmb_year");
        $Month = $this->input->post("cmb_month");
        $branch = $this->input->post("cmb_branch");
        $departments = $this->input->post("cmb_departments");

        $filter = '';

        if (($this->input->post("cmb_year"))) {
            $filter = " WHERE tbl_salary.Month = '$Month' AND tbl_salary.Year = '$year1'";
        }

        if (($this->input->post("cmb_departments"))) {
            if ($filter == '') {
                $filter = " WHERE tbl_departments.Dep_ID = '$departments'";
            } else {
                $filter .= " AND tbl_departments.Dep_ID = '$departments'";
            }
        }

        // Get raw joined data with allowances and deductions
        $raw_data = $this->Db_model->getfilteredData("SELECT 
                    tbl_salary.id,
                    tbl_salary.EmpNo,
                    tbl_branches.B_name,
                    tbl_empmaster.Emp_Full_Name,
                    tbl_salary.Incentive,
                    tbl_salary.Late_deduction,
                    tbl_salary.EPFNO,
                    tbl_salary.Br_pay,
                    tbl_salary.Total_F_Epf,
                    tbl_salary.Month,
                    tbl_salary.Year,
                    tbl_salary.Basic_sal,
                    tbl_salary.Payee_amount,
                    tbl_salary.Basic_pay,
                    tbl_salary.Late_min,
                    tbl_departments.Dep_Name,
                    tbl_salary.No_Pay_days,
                    tbl_salary.no_pay_deduction,
                    tbl_salary.Normal_OT_Hrs,
                    tbl_salary.Normal_OT_Pay,
                    tbl_salary.Double_OT_Hrs,
                    tbl_salary.Double_OT_Pay,
                    tbl_salary.EPF_Worker_Rate,
                    tbl_salary.EPF_Worker_Amount,
                    tbl_salary.EPF_Employee_Rate,
                    tbl_salary.EPF_Employee_Amount,
                    tbl_salary.ETF_Rate,
                    tbl_salary.ETF_Amount,
                    tbl_salary.Loan_Instalment,
                    tbl_salary.Wellfare,
                    tbl_salary.Stamp_duty,
                    tbl_salary.Uniform,
                    tbl_salary.Gross_sal,
                    tbl_salary.Gross_pay,
                    tbl_salary.Salary_advance,
                    tbl_salary.Ed_deduction,
                    tbl_salary.tot_deduction,
                    tbl_salary.days_worked,
                    tbl_salary.D_Salary,
                    tbl_salary.Net_salary,
                    tbl_assigned_department.ass_dep_name,
                    tbl_assigned_department.ass_dep_id,
                    tbl_allowance_has_tbl_salary.Alw_Name,
                    tbl_allowance_has_tbl_salary.Alw_Amount,
                    tbl_deduction_has_tbl_salary.Ded_Name,
                    tbl_deduction_has_tbl_salary.Ded_Amount
                    FROM tbl_salary
                    INNER JOIN tbl_empmaster ON tbl_empmaster.EmpNo = tbl_salary.EmpNo
                    INNER JOIN tbl_departments ON tbl_departments.Dep_ID = tbl_empmaster.Dep_ID
                    INNER JOIN tbl_branches ON tbl_branches.B_id = tbl_empmaster.B_id
                    INNER JOIN tbl_assigned_department ON tbl_assigned_department.ass_dep_id = tbl_empmaster.assigned_department_id
                    LEFT JOIN tbl_allowance_has_tbl_salary ON tbl_allowance_has_tbl_salary.EmpNo = tbl_salary.EmpNo AND tbl_allowance_has_tbl_salary.Month = tbl_salary.Month AND tbl_allowance_has_tbl_salary.Year = tbl_salary.Year
                    LEFT JOIN tbl_deduction_has_tbl_salary ON tbl_deduction_has_tbl_salary.EmpNo = tbl_salary.EmpNo AND tbl_deduction_has_tbl_salary.Month = tbl_salary.Month AND tbl_deduction_has_tbl_salary.Year = tbl_salary.Year
                    {$filter}
                    ORDER BY tbl_departments.Dep_Name ASC");

        // Restructure data: group by EmpNo with allowances and deductions mapped by name
        $employees = [];
        foreach ($raw_data as $record) {
            $empNo = $record->EmpNo;
            if (!isset($employees[$empNo])) {
                $employees[$empNo] = [
                    'info' => $record,
                    'allowances' => [],
                    'deductions' => [],
                ];
            }
            if (!empty($record->Alw_Name)) {
                $employees[$empNo]['allowances'][$record->Alw_Name] = $record->Alw_Amount;
            }
            if (!empty($record->Ded_Name)) {
                $employees[$empNo]['deductions'][$record->Ded_Name] = $record->Ded_Amount;
            }
        }

        // Load distinct allowances and deductions (for header columns)
        $allowances = $this->Db_model->getfilteredData("SELECT DISTINCT Alw_Name FROM tbl_allowance_has_tbl_salary WHERE Month = '$Month' AND Year = '$year1'");
        $deductions = $this->Db_model->getfilteredData("SELECT DISTINCT Ded_Name FROM tbl_deduction_has_tbl_salary WHERE Month = '$Month' AND Year = '$year1'");

        $data['employees'] = $employees;
        $data['allowanceNames'] = array_map(function ($a) {
            return $a->Alw_Name; }, $allowances);
        $data['deductionNames'] = array_map(function ($d) {
            return $d->Ded_Name; }, $deductions);
        $data['data_month'] = $Month;
        $data['data_year'] = $year1;
        $data['data_cmp'] = $data['data_cmp'];

        $this->load->view('Reports/Payroll/rpt_paysheet', $data);
    }


    function get_auto_emp_name()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->Db_model->get_auto_emp_name($q);
        }
    }

    function get_auto_emp_no()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->Db_model->get_auto_emp_no($q);
        }
    }

}
