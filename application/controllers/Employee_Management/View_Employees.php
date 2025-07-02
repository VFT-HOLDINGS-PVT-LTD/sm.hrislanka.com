<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class View_Employees extends CI_Controller {

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

    public function index() {

        $this->load->helper('url');
        $data['title'] = "ADD Employees | HRM SYSTEM";
        $data['data_dep'] = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');
        $data['data_desig'] = $this->Db_model->getData('Des_ID,Desig_Name', 'tbl_designations');
        $data['data_grp'] = $this->Db_model->getData('Grp_ID,EmpGroupName', 'tbl_emp_group');
        $data['data_u_lvl'] = $this->Db_model->getData('user_level_id,user_level_name', 'tbl_user_level_master');
        $data['data_bank'] = $this->Db_model->getData('Bnk_ID,bank_name', 'tbl_banks');
        $data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');
        $data['data_branch'] = $this->Db_model->getData('B_id,B_name', 'tbl_branches');
        $this->load->view('Employee_Management/View_Employee/index', $data);
    }

    /*
     * Search Employees by cat
     */

    public function search_employee() {


        $emp = $this->input->post("txt_emp");
        $emp_name = $this->input->post("txt_emp_name");
        $desig = $this->input->post("cmb_desig");
        $dept = $this->input->post("cmb_dep");
        $comp = $this->input->post("cmb_comp");
        $nic = $this->input->post("txt_nic");
        $gender = $this->input->post("cmb_gender");
        $status = $this->input->post("cmb_status");
        $branch = $this->input->post("cmb_branch");

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

        if (($this->input->post("cmb_branch"))) {
            if ($filter == null) {
                $filter = " where tbl_empmaster.B_id = '$branch'";
            } else {
                $filter .= " AND tbl_empmaster.B_id = '$branch'";
            }
        }

        if (($this->input->post("cmb_gender"))) {
            if ($filter == '') {
                $filter = " where tbl_empmaster.Gender = '$gender'";
            } else {
                $filter .= " AND tbl_empmaster.Gender = '$gender'";
            }
        }

        $data['data_set'] = $this->Db_model->getfilteredData("SELECT 
                                                                    tbl_empmaster.EmpNo,
                                                                    tbl_empmaster.Emp_Full_Name,
                                                                    tbl_designations.Desig_Name,
                                                                    tbl_branches.`B_name`,
                                                                    tbl_departments.Dep_Name,
                                                                    tbl_empmaster.Tel_mobile,
                                                                    tbl_empmaster.Gender,
                                                                    tbl_empmaster.NIC,
                                                                    tbl_empmaster.status,
                                                                    tbl_empmaster.Cmp_ID,
                                                                    tbl_empmaster.Image
                                                                FROM
                                                                    tbl_empmaster
                                                                        LEFT JOIN
                                                                    tbl_designations ON tbl_empmaster.Des_ID = tbl_designations.Des_ID
                                                                        LEFT JOIN
                                                                    tbl_departments ON tbl_empmaster.Dep_ID = tbl_departments.Dep_ID
                                                                    INNER JOIN
                                                                    `tbl_branches` ON `tbl_branches`.`B_id` = `tbl_empmaster`.`B_id` {$filter}");

        $this->load->view('Employee_Management/View_Employee/search_data', $data);
    }

    /*
     * Auto Complete by Employee Name
     */

    function get_auto_emp_name() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->Db_model->get_auto_emp_name($q);
        }
    }

    /*
     * Auto Complete by Employee No
     */

    function get_auto_emp_no() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->Db_model->get_auto_emp_no($q);
        }
    }

}
