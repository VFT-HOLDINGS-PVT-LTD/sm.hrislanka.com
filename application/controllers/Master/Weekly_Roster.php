<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Weekly_Roster extends CI_Controller {

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

        $data['title'] = "Weekly Roster Pattern | HRM System";
        $data['data_set_shift'] = $this->Db_model->getData('ShiftCode,ShiftName', 'tbl_shifts');
        $data['data_set'] = $this->Db_model->getData('RosterCode,RosterName', 'tbl_rosterpatternweeklyhd');


        $serialdata = $this->Db_model->getData('serial', 'tbl_serials', array('code' => 'Roster'));
        $serial = "RS" . substr(("0000" . (int) $serialdata[0]->serial), strlen("0000" . $serialdata[0]->serial) - 4, 4);
        $data['serial'] = ++$serial;

        $this->load->view('Master/Weekly_Roster/index', $data, $serial);
//        $this->load->view('Master/Weekly_Roster/index', $data, $serial);
    }

    /*
     * Insert Data
     */

    public function insert_data() {

        $RosterName = $this->input->post('txtRoster_Name');
        $serial = $this->Db_model->getData('serial', 'tbl_serials', array("code" => "Roster"));
        $serialNo = $serial[0]->serial + 1;

        $dataset = json_decode($_POST['hdntext']);

        foreach ($dataset as $dataitems) {
            $shiftarray = array(
                "RosterCode" => $this->input->post('txtRoster_Code'),
                'RosterName' => $this->input->post('txtRoster_Name'),
                'ShiftCode' => $dataitems->SHType,
                'DayName' => $dataitems->Day,
                'ShiftType' => $dataitems->SType,
            );
            $result = $this->Db_model->insertData('tbl_rosterpatternweeklydtl', $shiftarray);
        }
        $this->session->set_flashdata('success_message', 'New Weekly Roster has been added successfully');

        $data = array(
            'RosterCode' => $this->input->post('txtRoster_Code'),
            'RosterName' => $this->input->post('txtRoster_Name')
        );

        $result = $this->Db_model->insertData("tbl_rosterpatternweeklyhd", $data);


        $serialdata = "";
        $condition = 0;
        $data = array("serial" => $serialNo);

        if ($result) {
            $condition = 1;


            $whereArr = array("code" => "Roster");
            $result = $this->Db_model->updateData('tbl_serials', $data, $whereArr);

            //Genarate next designation code

            $serialdata = $this->Db_model->getData('serial', 'tbl_serials', array('code' => 'Designation'));
            $serial = "DS" . substr(("0000" . (int) $serialdata[0]->serial), strlen("0000" . $serialdata[0]->serial) - 4, 4);
            $data['serial'] = ++$serial;
        } else {
            $serialdata = $this->Db_model->getData('serial', 'tbl_serials', array('code' => 'Designation'));
            $serial = "DS" . substr(("0000" . (int) $serialdata[0]->serial), strlen("0000" . $serialdata[0]->serial) - 4, 4);
            $data['serial'] = ++$serial;
        }
        // Log_Insert - Start

        // Get the last inserted ID
        $insert_id = $this->Db_model->getfilteredData("SELECT `RosterCode` FROM tbl_rosterpatternweeklyhd WHERE `RosterName`='".$RosterName."'");//change action
        $RosterCode = $insert_id[0]->RosterCode;//change action

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
        
        $system_page_name = "Master - Roster Pattern";//change action
        $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");

        $dataArray = array(
            'log_user_id' => $Emp,
            'ip_address' => $ip,
            'system_action' => 'A new roster pattern has been added. Its ID is '.$RosterCode.' and the name is '.$RosterName,//change action
            'trans_time' => $current_time,
            'system_page' => $spnID[0]->id 
        );

        $this->Db_model->insertData("tbl_audit_log_all", $dataArray);
        // Log_Insert - End

        redirect('/Master/Weekly_Roster/');
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



        $data = array("ShiftName" => $ShiftName, "FromTime" => $FromTime, "ToTime" => $ToTime, "ShiftGap" => $ShiftGap,);
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

    /*
     * Get Bank account number
     */

    function get_data() {
        $state = $this->input->post('cmb_bank');
        $query = $this->Db_model->get_bank_info();
        echo '<option value="" default>-- Select --</option>';
        foreach ($query->result() as $row) {

            echo "<option value='" . $row->Acc_no . "'>" . $row->Acc_no . "</option>";
        }
    }

    /*
     * Get last cheque number according to bank account number
     */

    function get_data_chq() {
        $state = $this->input->post('cmb_acc_no');
        $query = $this->Db_model->get_chqno_info();

        foreach ($query->result() as $row) {
//                 echo "< value='".$row->lc_no."'>".$row->lc_no."";

            echo $row->lc_no;
        }
    }

    public function getShiftData() {
        $shiftcode = $this->input->post("shiftCode");
        $string = "SELECT FromTime,ToTime FROM tbl_shifts WHERE ShiftCode='$shiftcode'";
        $shfitData = $this->Db_model->getfilteredData($string);

        echo json_encode($shfitData);
    }

}
