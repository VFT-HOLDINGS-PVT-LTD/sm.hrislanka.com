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
        $this->load->model('Db_model', '', TRUE);
    }

    /*
     * Index page in Departmrnt
     */

    public function index() {

        $data['title'] = "Pay Sheet | HRM System";
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

//        $data['f_date'] = $from_date;
//        $data['t_date'] = $to_date;
        // Filter Data by categories
        $filter = '';



        $data['data_set'] = $this->Db_model->getfilteredData("SELECT 
                                                                    tbl_salary.id,
                                                                    tbl_salary.EmpNo,
                                                                    tbl_branches.B_name,
                                                                    tbl_empmaster.Emp_Full_Name,
                                                                    (tbl_salary.Incentive) as Incentive,
                                                                  
                                                                    tbl_empmaster.Fixed_Allowance - 0 as BD_Al1,
                                                                   
                                                                    tbl_salary.EPFNO,
                                                                    tbl_salary.Month,
                                                                    tbl_salary.Year,
                                                                    tbl_salary.Basic_sal,
                                                                    tbl_salary.Basic_pay,
                                                                    tbl_salary.Late_deduction,
                                                                    tbl_salary.Early_departure,
                                                                    tbl_salary.Att_Allowance,
                                                                    tbl_salary.Late_min,
                                                                    tbl_departments.Dep_Name,
                                                                    tbl_salary.No_Pay_days,
                                                                    tbl_salary.Allowance_1,
                                                                    tbl_salary.Allowance_2,
                                                                    tbl_salary.Allowance_3,
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
                                                                    tbl_salary.Gross_sal,
                                                                    tbl_salary.Salary_advance,
                                                                    tbl_salary.Festivel_Advance,
                                                                    tbl_salary.tot_deduction,
                                                                    tbl_salary.days_worked,
                                                                    (Allowance_1+Allowance_2+Allowance_3) as Allowances,
                                                                    (Deduct_1+Deduct_2+Deduct_3) as Deductions,
                                                                    tbl_salary.D_Salary,
                                                                    tbl_salary.Net_salary
                                                                FROM
                                                                    tbl_salary
                                                                        INNER JOIN
                                                                    tbl_departments ON tbl_departments.Dep_ID = tbl_salary.Dep_ID
                                                                        LEFT JOIN
                                                                    tbl_allowance_type ON tbl_allowance_type.Alw_ID = tbl_salary.Alw_ID_1
                                                                    inner join
                                                                    tbl_empmaster on tbl_empmaster.EmpNo = tbl_salary.EmpNo
                                                                    inner join
                                                                    tbl_branches on tbl_branches.B_id = tbl_empmaster.B_id
                                                                    where tbl_salary.Month = '$Month' and tbl_empmaster.Emp_Full_Name='$emp_name'
                                                                    order by tbl_salary.EmpNo");



        $data['data_month'] = $Month;
        $data['data_year'] = $year;


//        var_dump($data);die;

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
