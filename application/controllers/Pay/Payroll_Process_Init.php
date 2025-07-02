<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_Process_Init extends CI_Controller {

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
        $data['title'] = "Payroll Process | HRM SYSTEM";
        $data['data_emp'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $this->load->view('Payroll/Payroll_Initialize/index', $data);
    }

    /*
     * Payroll Process
     */

    public function emp_payroll_process_init() {


        $cat = $this->input->post('cmb_cat');
        if ($cat == "Employee") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE EmpNo='$cat2' and Status = 1";
            $EmpData = $this->Db_model->getfilteredData($string);
        }

        if ($cat == "Department") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE Dep_ID='$cat2' and Status = 1";
            $EmpData = $this->Db_model->getfilteredData($string);
        }

        if ($cat == "Designation") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE Des_ID='$cat2' and Status = 1";
            $EmpData = $this->Db_model->getfilteredData($string);
        }
        if ($cat == "Employee_Group") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE Grp_ID='$cat2' and Status = 1";
            $EmpData = $this->Db_model->getfilteredData($string);
        }

        if ($cat == "Company") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE Cmp_ID='$cat2' and Status = 1";
            $EmpData = $this->Db_model->getfilteredData($string);
        }


        $Month = $this->input->post('cmb_month');
        $Year = $this->input->post('cmb_year');




        $Count = count($EmpData);

        for ($i = 0; $i < $Count; $i++) {

            $EmpN = $EmpData[$i]->EmpNo;

            $this->Db_model->getfilteredDelete("DELETE FROM tbl_salary WHERE Month =  $Month and Year =$Year  and EmpNo= $EmpN");
            $this->Db_model->getfilteredDelete("DELETE FROM tbl_allowance_has_tbl_salary WHERE Month =  $Month and Year =$Year  and EmpNo= $EmpN");
            $this->Db_model->getfilteredDelete("DELETE FROM tbl_deduction_has_tbl_salary WHERE Month =  $Month and Year =$Year  and EmpNo= $EmpN");


//             $this->Db_model->getfilteredDelete("DELETE FROM tbl_ot_d WHERE OTDate between '$from_date' and '$to_date' and EmpNo= $EmpN");
        }

        $this->session->set_flashdata('success_message', 'Payroll Initialize successfully');
        redirect(base_url() . "Pay/Payroll_Process_Init");


      
    }

}
