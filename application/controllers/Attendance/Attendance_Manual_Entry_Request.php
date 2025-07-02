<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_Manual_Entry_Request extends CI_Controller {

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

        $this->load->view('Attendance/Attendance_Manual_Entry_Request/index', $data);
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


        $emp = $this->input->post("txt_employee");
        $emp_name = $this->input->post("txt_emp_name");
        $desig = $this->input->post("cmb_desig");
        $dept = $this->input->post("cmb_dep");
        $comp = $this->input->post("cmb_comp");

        $att_date = $this->input->post("att_date");
        $in_time = $this->input->post("in_time");
        // $out_time = $this->input->post("out_time");
        $out_time = "00:00:00";
        $reason = $this->input->post("txt_reason");
        $satus = $this->input->post('employee_status');


        if($satus== 'Active'){
            $st = "0";
        }
        // else{
        //     $st = "1";
        // }
        if($satus== 'Inactive'){
            $st = "1";
        }
        $EmpData = $this->Db_model->getfilteredData("select EmpNo,Enroll_No from tbl_empmaster where EmpNo ='$emp' or Emp_Full_Name='$emp_name' ");

        $EnrollNo = $EmpData[0]->Enroll_No;

        $data = array(
            'Att_Date' => $att_date,
            'In_Time' => $in_time,
            'Out_Time' => $out_time,
            'Enroll_No' => $EnrollNo,
            'Reason' => $reason,
            'Status' => $st,
            'App_Sup_User' => 1,
            'Is_App_Sup_User' => 1,
        );

        $this->Db_model->insertData('tbl_manual_entry', $data);


        // $data = array(
        //     'AttDate' => $att_date,
        //     'AttTime' => $in_time,
        //     'AttDateTimeStr' => "0000-00-00 00:00:00",
        //     'Enroll_No' => $EnrollNo,
        //     'AttPlace' => "null",
        //     'Status' => $st,
        //     'verify_type' => "0",
        //     'EventName' => "null",
        // );

        // $this->Db_model->insertData('tbl_u_attendancedata', $data);
       // Get the last inserted ID
       $EmpData = $this->Db_model->getfilteredData("select EmpNo,Enroll_No from tbl_empmaster where EmpNo ='$emp' or Emp_Full_Name='$emp_name' ");
       $EnrollNo = $EmpData[0]->Enroll_No;

       $insert_id = $this->Db_model->getfilteredData("SELECT `M_ID` FROM tbl_manual_entry WHERE `Att_Date`='".$att_date."' AND `Enroll_No`='".$EnrollNo."'");//change action
       $M_ID = $insert_id[0]->M_ID;//change action

       function get_client_ips() {
           $ipaddress = '';
           if (getenv('HTTP_CLIENT_IP')) {
               $ipaddress = getenv('HTTP_CLIENT_IP');
           } else if (getenv('HTTP_X_FORWARDED_FOR')) {
               $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
           } else if (getenv('HTTP_X_FORWARDED')) {
               $ipaddress = getenv('HTTP_X_FORWARDED');
           } else if (getenv('HTTP_FORWARDED_FOR')) {
               $ipaddress = getenv('HTTP_FORWARDED_FOR');
           } else if (getenv('HTTP_FORWARDED')) {
               $ipaddress = getenv('HTTP_FORWARDED');
           } else if (getenv('REMOTE_ADDR')) {
               $ipaddress = getenv('REMOTE_ADDR');
           } else {
               $ipaddress = 'UNKNOWN';
           }
           return $ipaddress;
       }

       $ip = get_client_ips();

       $currentUser = $this->session->userdata('login_user');
       $Emp = $currentUser[0]->EmpNo;

       date_default_timezone_set('Asia/Colombo');
       $current_time = date('Y-m-d H:i:s');
       
       $system_page_name = "Attendance - Manual Attendance Request";//change action
       $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");

       $dataArray = array(
           'log_user_id' => $Emp,
           'ip_address' => $ip,
           'system_action' => 'A new manual attendance request has been added. Its ID is '.$M_ID.' and Its have these '.$EnrollNo.','.$att_date.','.$in_time.','.$reason.','.$st.' details.',//change action
           'trans_time' => $current_time,
           'system_page' => $spnID[0]->id 
       );

       $this->Db_model->insertData("tbl_audit_log_all", $dataArray);
       // Log_Insert - End

        $this->session->set_flashdata('success_message', 'Manual Entry added successfully');

        redirect(base_url() . "Attendance/Attendance_Manual_Entry_Request");
    }

}
