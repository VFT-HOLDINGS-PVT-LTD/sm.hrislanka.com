<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report_Attendance_In_Out_Row extends CI_Controller {

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

        $data['title'] = "Attendance In Out Report Row | HRM System";
        $data['data_dep'] = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');
        $data['data_desig'] = $this->Db_model->getData('Des_ID,Desig_Name', 'tbl_designations');
        $data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');
        $data['data_branch'] = $this->Db_model->getData('B_id,B_name', 'tbl_branches');
        $this->load->view('Reports/Attendance/Report_Attendance_In_Out_Row', $data);
    }

    /*
     * Insert Departmrnt
     */

    public function Report_department() {

        $Data['data_set'] = $this->Db_model->getData('id,Dep_Name', 'tbl_departments');

        $this->load->view('Reports/Master/rpt_Departments', $Data);
    }

    public function Attendance_Report_By_Cat() {


        $data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');

        $emp = $this->input->post("txt_emp");
        $emp_name = $this->input->post("txt_emp_name");
        $desig = $this->input->post("cmb_desig");
        $dept = $this->input->post("cmb_dep");
        $from_date = $this->input->post("txt_from_date");
        $to_date = $this->input->post("txt_to_date");
        $branch = $this->input->post("cmb_branch");


        $data['f_date'] = $from_date;
        $data['t_date'] = $to_date;


        // Filter Data by categories
        $filter = '';

        if (($this->input->post("txt_from_date")) && ($this->input->post("txt_to_date"))) {
            if ($filter == '') {
                $filter = " where  iro.FDate between '$from_date' and '$to_date'";
            } else {
                $filter .= " AND  iro.FDate between '$from_date' and '$to_date'";
            }
        }
        if (($this->input->post("txt_emp"))) {
            if ($filter == null) {
                $filter = " where ir.Enroll_No =$emp";
            } else {
                $filter .= " AND ir.Enroll_No =$emp";
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

        if (($this->input->post("cmb_branch"))) {
            if ($filter == null) {
                $filter = " where br.B_id  ='$branch'";
            } else {
                $filter .= " AND br.B_id  ='$branch'";
            }
        }

        $data['data_set'] = $this->Db_model->getfilteredData("SELECT 
        Emp.Emp_Full_Name,
        iro.EmpNo,
        iro.InTime,
        iro.OutTime,
        iro.DayStatus,
        iro.FDate,
        iro.TDate
    FROM
        tbl_individual_roster iro
            LEFT JOIN
        tbl_empmaster Emp ON Emp.EmpNo = iro.EmpNo
            LEFT JOIN
        tbl_designations dsg ON dsg.Des_ID = Emp.Des_ID
            LEFT JOIN
        tbl_departments dep ON dep.Dep_id = Emp.Dep_id
            INNER JOIN
        tbl_branches br ON Emp.B_id = br.B_id
               
         
        {$filter} AND DayStatus='MS'");

//         $data['data_set'] = $this->Db_model->getfilteredData("SELECT 
//     ir.EventID,
//     Emp.Emp_Full_Name,
//     ir.Enroll_No,
//     ir.AttDate,
//     MIN(AttTime) AS InTime,
//     MAX(AttTime) AS OutTime,
//     TIMEDIFF(Max(AttTime),Min(AttTime)) as WorkHour
// FROM
//     tbl_u_attendancedata ir
//         LEFT JOIN
//     tbl_empmaster Emp ON Emp.EmpNo = ir.Enroll_No
//         LEFT JOIN
//     tbl_designations dsg ON dsg.Des_ID = Emp.Des_ID
//         LEFT JOIN
//     tbl_departments dep ON dep.Dep_id = Emp.Dep_id
//         INNER JOIN
//     tbl_branches br ON Emp.B_id = br.B_id

        
//                                                                     {$filter}  GROUP BY ir.AttDate ,  ir.Enroll_No order by ir.AttDate , Emp.EmpNo ASC");

//        var_dump($data);die;

        $this->load->view('Reports/Attendance/rpt_In_Out_row', $data);
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
