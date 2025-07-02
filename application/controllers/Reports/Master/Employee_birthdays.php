<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_birthdays extends CI_Controller {

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

        $data['title'] = "Employee Birthday | HRM System";
        $this->load->view('Master/Department/index', $data);
    }

    /*
     * Insert data
     */

    public function Report_DOB() {
        
        $Data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');
        $Data['data_set'] = $this->Db_model->getfilteredData("select EmpNo,Emp_Full_Name,DOB from tbl_empmaster");

        $this->load->view('Reports/Master/rpt_Emp_birthdays', $Data);
    }

}
