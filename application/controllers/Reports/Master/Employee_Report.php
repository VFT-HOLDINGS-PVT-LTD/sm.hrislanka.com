<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_Report extends CI_Controller {

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

        $data['title'] = "Employee All Report | HRM System";
        $data['data_dep'] = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');
        $data['data_desig'] = $this->Db_model->getData('Des_ID,Desig_Name', 'tbl_designations');
        $data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');
        $this->load->view('Reports/Master/Report_Employee_All', $data);
    }

    public function Report_employee_all() {

        $Data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');

        $emp = $this->input->post("txt_emp");
        $emp_name = $this->input->post("txt_emp_name");
        $desig = $this->input->post("cmb_desig");
        $dept = $this->input->post("cmb_dep");
        $comp = $this->input->post("cmb_comp");
        $nic = $this->input->post("txt_nic");
        $gender = $this->input->post("cmb_gender");
        $status = $this->input->post("cmb_status");

        if ($status == 2) {
            $status = 0;
        }


        // Filter Data by categories
        $filter = '';

        if (($this->input->post("txt_emp"))) {
            if ($filter == null) {
                $filter = " where EmpNo like '$emp%'";
            } else {
                $filter .= " AND EmpNo like '$emp%'";
            }
        }

        if (($this->input->post("txt_emp_name"))) {
            if ($filter == null) {
                $filter = " where Emp_Full_Name like '$emp_name%'";
            } else {
                $filter .= " AND Emp_Full_Name like '$emp_name%'";
            }
        }
        if (($this->input->post("cmb_desig"))) {
            if ($filter == null) {
                $filter = " where tbl_designations.Des_ID like '$desig%'";
            } else {
                $filter .= " AND tbl_designations.Des_ID like '$desig%'";
            }
        }
        if (($this->input->post("cmb_dep"))) {
            if ($filter == null) {
                $filter = " where tbl_departments.Dep_ID like '$dept%'";
            } else {
                $filter .= " AND tbl_departments.Dep_ID like '$dept%'";
            }
        }
        if (($this->input->post("txt_nic"))) {
            if ($filter == null) {
                $filter = " where NIC like '$nic%'";
            } else {
                $filter .= " AND NIC like '$nic%'";
            }
        }

        if (($this->input->post("cmb_status"))) {
            if ($filter == '') {
                $filter = " where Status = $status";
            } else {
                $filter .= " AND Status = $status";
            }
        }

        if (($this->input->post("cmb_gender"))) {
            if ($filter == '') {
                $filter = " where tbl_empmaster.Gender = '$gender'";
            } else {
                $filter .= " AND tbl_empmaster.Gender = '$gender'";
            }
        }

        $Data['data_set'] = $this->Db_model->getfilteredData("SELECT 
                                                                    tbl_empmaster.EmpNo,
                                                                    tbl_empmaster.Title,
                                                                    tbl_empmaster.Emp_Full_Name,
                                                                    tbl_designations.Desig_Name,
                                                                    tbl_departments.Dep_Name,
                                                                    tbl_empmaster.Tel_mobile,
                                                                    tbl_empmaster.Gender,
                                                                    tbl_empmaster.NIC,
                                                                    tbl_empmaster.Address,
                                                                    tbl_empmaster.status,
                                                                    tbl_empmaster.ApointDate,
                                                                    tbl_empmaster.Cmp_ID
                                                                FROM
                                                                    tbl_empmaster
                                                                        Left JOIN
                                                                    tbl_designations ON tbl_empmaster.Des_ID = tbl_designations.Des_ID
                                                                        Left JOIN
                                                                    tbl_departments ON tbl_empmaster.Dep_ID = tbl_departments.Dep_ID {$filter} order by tbl_empmaster.EmpNo");



        $this->load->view('Reports/Master/rpt_employee_all', $Data);
    }

}
