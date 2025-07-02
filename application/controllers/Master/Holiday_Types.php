<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday_Types extends CI_Controller {

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

        $data['title'] = "Holiday Types | HRM System";
        $data['data_set'] = $this->Db_model->getData('id,HTCode,HTDescription', 'tbl_holiday_types');
        $this->load->view('Master/Holiday_Types/index', $data);
    }

    /*
     * Insert
     */

    public function insert_H_Types() {

        $HTDescription = $this->input->post('txt_H_Name');
        $data = array(
            'HTCode' => $this->input->post('txt_H_Types'),
            'HTDescription' => $this->input->post('txt_H_Name')
        );

        $result = $this->Db_model->insertData("tbl_holiday_types", $data);

        // Log_Insert - Start

        // Get the last inserted ID
        $insert_id = $this->Db_model->getfilteredData("SELECT `ID` FROM tbl_holiday_types WHERE `HTDescription`='".$HTDescription."'");//change action
        $HTDescription_ID = $insert_id[0]->ID;//change action

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
        
        $system_page_name = "Master - Holiday Type";//change action
        $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");

        $dataArray = array(
            'log_user_id' => $Emp,
            'ip_address' => $ip,
            'system_action' => 'A new holiday type has been added. Its ID is '.$HTDescription_ID.' and the name is '.$HTDescription,//change action
            'trans_time' => $current_time,
            'system_page' => $spnID[0]->id 
        );

        $this->Db_model->insertData("tbl_audit_log_all", $dataArray);
        // Log_Insert - End

        $this->session->set_flashdata('success_message', 'New Holiday type has been added successfully');


        redirect('/Master/Holiday_Types/');
    }

    /*
     * Get data
     */

    public function get_details() {
        $id = $this->input->post('id');

//                    echo "OkM " . $id;

        $whereArray = array('ID' => $id);

        $this->Db_model->setWhere($whereArray);
        $dataObject = $this->Db_model->getData('ID,HTCode,HTDescription', 'tbl_holiday_types');

        $array = (array) $dataObject;
        echo json_encode($array);
    }

    /*
     * Edit Data
     */

    public function edit() {
        $ID = $this->input->post("id", TRUE);
        $H_T = $this->input->post("H_Code", TRUE);
        $H_D = $this->input->post("H_Desc", TRUE);

        $data = array("HTCode" => $H_T, 'HTDescription' => $H_D);
        $whereArr = array("id" => $ID);
        $result = $this->Db_model->updateData("tbl_holiday_types", $data, $whereArr);
        redirect(base_url() . "Master/Holiday_Types");
    }

    /*
     * Delete Data
     */

    public function ajax_delete($id) {
        $table = "tbl_holiday_types";
        $where = 'id';
        $this->Db_model->delete_by_id($id, $where, $table);
        echo json_encode(array("status" => TRUE));
    }

}
