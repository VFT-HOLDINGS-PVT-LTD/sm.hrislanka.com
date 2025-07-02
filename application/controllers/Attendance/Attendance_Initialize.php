<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_Initialize extends CI_Controller {

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

        $data['title'] = "Attendance Initialize | HRM System";
        $this->load->view('Attendance/Attendance_Initialize/index', $data);
    }

    /*
     * initialize Data
     */

    public function initialize() {



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


        $from_date = $this->input->post('txt_from_date');
        $to_date = $this->input->post('txt_to_date');

        $Count = count($EmpData);

        for ($i = 0; $i < $Count; $i++) {

            $EmpN = $EmpData[$i]->EmpNo;

            $this->Db_model->getfilteredDelete("DELETE FROM tbl_individual_roster WHERE FDate between '$from_date' and '$to_date' and EmpNo= $EmpN");


            $this->Db_model->getfilteredDelete("DELETE FROM tbl_ot_d WHERE OTDate between '$from_date' and '$to_date' and EmpNo= $EmpN");
        }

        // Log_Insert - Start
        $Category = $this->input->post('cmb_cat');
        $Selected_Category = $this->input->post('cmb_cat2');
        // $roster = $this->input->post('cmb_roster');
        $from_date = $this->input->post('txt_from_date');
        $to_date = $this->input->post('txt_to_date');

        // Get the last inserted ID
        // $insert_id = $this->Db_model->getfilteredData("SELECT `Lv_T_ID` FROM tbl_leave_types WHERE `leave_name`='".$LeaveName."'");//change action
        // $Lv_T_ID = $insert_id[0]->Lv_T_ID;//change action

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

        // $ip = "111";
        $currentUser = $this->session->userdata('login_user');
        $Emp = $currentUser[0]->EmpNo;

        date_default_timezone_set('Asia/Colombo');
        $current_time = date('Y-m-d H:i:s');
        
        $system_page_name = "Attendance - Attendance Initialize";//change action
        $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");

        $dataArray = array(
            'log_user_id' => $Emp,
            'ip_address' => $ip,
            'system_action' => 'Attendance Initialize successfully. Its have these '.$Category.','.$Selected_Category.','.$from_date.','.$to_date.' details',//change action
            'trans_time' => $current_time,
            'system_page' => $spnID[0]->id 
        );

        $this->Db_model->insertData("tbl_audit_log_all", $dataArray);
        // Log_Insert - End

        $this->session->set_flashdata('success_message', 'Attendance Initialize successfully');
        redirect(base_url() . "Attendance/Attendance_Initialize");
    }

}
