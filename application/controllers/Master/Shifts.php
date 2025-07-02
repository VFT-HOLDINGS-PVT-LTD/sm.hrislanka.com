<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shifts extends CI_Controller {

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

        $data['title'] = "Shifts | HRM System";
        $data['data_set'] = $this->Db_model->getData('ShiftCode,ShiftName,FromTime,ToTime,NextDay,DayType,FHDSessionEndTime,SHDSessionStartTime,ShiftGap', 'tbl_shifts');
        $this->load->view('Master/Shifts/index', $data);
    }

    /*
     * Insert Data
     */

    public function insert_data() {

//        $FSt = $this->input->post('chk_1st');
//        if ($FSt == null) {
//            $FSt = 0;
//        } elseif ($FSt == 'on') {
//            $FSt = 1;
//        }
//
//        $Snd = $this->input->post('chk_2nd');
//        if ($Snd == null) {
//            $Snd = 0;
//        } elseif ($Snd == 'on') {
//            $Snd = 1;
//        }

        $shift = $this->input->post('txt_shift_name');
        $data = array(
            'ShiftName' => $this->input->post('txt_shift_name'),
            'FromTime' => $this->input->post('txt_from_time'),
            'ToTime' => $this->input->post('txt_to_time'),
            'ShiftGap' => $this->input->post('txt_shift_gap'),
            'DayType' => $this->input->post('day_type')
        );

        $result = $this->Db_model->insertData("tbl_shifts", $data);

        // Log_Insert - Start

        // Get the last inserted ID
        $insert_id = $this->Db_model->getfilteredData("SELECT `ShiftCode` FROM tbl_shifts WHERE `ShiftName`='".$shift."'");//change action
        $ShiftCode = $insert_id[0]->ShiftCode;//change action

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
        
        $system_page_name = "Master - Shifts";//change action
        $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");

        $dataArray = array(
            'log_user_id' => $Emp,
            'ip_address' => $ip,
            'system_action' => 'A new shifts has been added. Its ID is '.$ShiftCode.' and the name is '.$shift,//change action
            'trans_time' => $current_time,
            'system_page' => $spnID[0]->id 
        );

        $this->Db_model->insertData("tbl_audit_log_all", $dataArray);
        // Log_Insert - End

        $this->session->set_flashdata('success_message', 'New Shift has been added successfully');


        redirect('/Master/Shifts/');
    }

    /*
     * Get data
     */

    public function get_details() {
        $ShiftCode = $this->input->post('ShiftCode');

        $whereArray = array('ShiftCode' => $ShiftCode);

        $this->Db_model->setWhere($whereArray);
        $dataObject = $this->Db_model->getData('ShiftCode,ShiftName,FromTime,ToTime,ShiftGap', 'tbl_shifts');

        $array = (array) $dataObject;
        echo json_encode($array);
    }

    /*
     * Edit Data
     */

    public function edit() {
        $ShiftCode = $this->input->post("ShiftCode", TRUE);
        $ShiftName = $this->input->post("ShiftName", TRUE);
        $FromTime = $this->input->post("FromTime", TRUE);
        $ToTime = $this->input->post("ToTime", TRUE);
        $ShiftGap = $this->input->post("ShiftGap", TRUE);
        
        
        
        $data = array("ShiftName" => $ShiftName,"FromTime"=>$FromTime,"ToTime"=>$ToTime,"ShiftGap"=>$ShiftGap,);
        $whereArr = array("ShiftCode" => $ShiftCode);
        $result = $this->Db_model->updateData("tbl_shifts", $data, $whereArr);
        redirect(base_url() . "Master/Shifts");
    }

    /*
     * Delete Data
     */

    public function ajax_delete($id) {
        $table = "tbl_shifts";
        $where = 'ShiftCode';
        $this->Db_model->delete_by_id($id, $where, $table);
        echo json_encode(array("status" => TRUE));
    }

}
