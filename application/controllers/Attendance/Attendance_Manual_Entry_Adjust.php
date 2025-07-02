<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_Manual_Entry_Adjust extends CI_Controller {

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

        $data['title'] = "Attendance Manual Entry | HRM System";
        $data['data_set'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $data['data_dep'] = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');
        $data['data_desig'] = $this->Db_model->getData('Des_ID,Desig_Name', 'tbl_designations');
        $data['data_grp'] = $this->Db_model->getData('Grp_ID,EmpGroupName', 'tbl_emp_group');
        $data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');

        $this->load->view('Attendance/Attendance_Manual_View_Admin/index', $data);
    }

    public function search_employee() {


        $emp = $this->input->post("txt_emp");
        $emp_name = $this->input->post("txt_emp_name");
        $desig = $this->input->post("cmb_desig");
        $dept = $this->input->post("cmb_dep");
        $from_date = $this->input->post("txt_from_date");
        $to_date = $this->input->post("txt_to_date");


        // Filter Data by categories
        $filter = '';


        if (($this->input->post("txt_from_date")) && ($this->input->post("txt_to_date"))) {
            if ($filter == '') {
                $filter = " AND  le.Leave_Date between '$from_date' and '$to_date'";
            } else {
                $filter .= " AND  le.Leave_Date  between '$from_date' and '$to_date'";
            }
        }

        if (($this->input->post("txt_emp"))) {
            if ($filter == null) {
                $filter = " AND em.EmpNo = '$emp'";
            } else {
                $filter .= " AND em.EmpNo = '$emp'";
            }
        }

        if (($this->input->post("txt_emp_name"))) {
            if ($filter == null) {
                $filter = " AND em.Emp_Full_Name= '$emp_name'";
            } else {
                $filter .= " AND em.Emp_Full_Name = '$emp_name'";
            }
        }

        $currentUser = $this->session->userdata('login_user');
        $Emp = $currentUser[0]->EmpNo;

        $data['data_set'] = $this->Db_model->getfilteredData("select * from tbl_manual_entry
inner join tbl_empmaster
on tbl_empmaster.EmpNo = tbl_manual_entry.Enroll_No where Is_App_Sup_User =1 and Is_Admin_App_ID=1
  {$filter}");

        $this->load->view('Attendance/Attendance_Manual_View_Admin/search_data', $data);
    }

    public function approve($ID) {

        $currentUser = $this->session->userdata('login_user');
        $Emp = $currentUser[0]->EmpNo;

        $data = array(
            'Admin_App_ID' => 1,
            'Is_Admin_App_ID' => $Emp
        );


        $whereArr = array("M_ID" => $ID);
        $result = $this->Db_model->updateData("tbl_manual_entry", $data, $whereArr);



        $this->session->set_flashdata('success_message', 'Leave Approved successfully');
        redirect(base_url() . "Attendance/Attendance_Manual_Entry_ADMIN");
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

    /*
     * Search Employee Manual Attendance Entry
     */

    public function emp_manual_entry() {


        $emp = $this->input->post("txt_emp");
        $emp_name = $this->input->post("txt_emp_name");
        $desig = $this->input->post("cmb_desig");
        $dept = $this->input->post("cmb_dep");
        $comp = $this->input->post("cmb_comp");

        $att_date = $this->input->post("att_date");
        $in_time = $this->input->post("in_time");
        $out_time = $this->input->post("out_time");
        $reason = $this->input->post("txt_reason");


        $EmpData = $this->Db_model->getfilteredData("select EmpNo,Enroll_No from tbl_empmaster where EmpNo ='$emp' or Emp_Full_Name='$emp_name' ");



        $EnrollNo = $EmpData[0]->Enroll_No;





        $data = array(
            'Att_Date' => $att_date,
            'In_Time' => $in_time,
            'Out_Time' => $out_time,
            'Enroll_No' => $EnrollNo,
            'Reason' => $reason
        );

        $this->Db_model->insertData('tbl_manual_entry', $data);
        $this->session->set_flashdata('success_message', 'Manual Entry added successfully');

        redirect(base_url() . "Attendance/Attendance_Manual_Entry");
    }

}
