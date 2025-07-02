<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_Levels extends CI_Controller {

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
     * Index page in Departmrnt
     */

    public function index() {

        $data['title'] = "User Levels | HRM System";
        $data['data_set'] = $this->Db_model->getData('user_level_id,user_level_name', 'tbl_user_level_master');
        $this->load->view('Master/User_Levels/index', $data);
    }

    /*
     * Insert Departmrnt
     */

    public function insert_data() {

        $user_level_name = $this->input->post('txt_user_level');
        $data = array(
            'user_level_name' => $this->input->post('txt_user_level')
        );

        $result = $this->Db_model->insertData("tbl_user_level_master", $data);

        // Log_Insert - Start

        // Get the last inserted ID
        $insert_id = $this->Db_model->getfilteredData("SELECT `user_level_id` FROM tbl_user_level_master WHERE `user_level_name`='".$user_level_name."'");//change action
        $user_level_id = $insert_id[0]->user_level_id;//change action

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
        
        $system_page_name = "Master - User Level";//change action
        $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");

        $dataArray = array(
            'log_user_id' => $Emp,
            'ip_address' => $ip,
            'system_action' => 'A new user level has been added. Its ID is '.$user_level_id.' and the name is '.$user_level_name,//change action
            'trans_time' => $current_time,
            'system_page' => $spnID[0]->id 
        );

        $this->Db_model->insertData("tbl_audit_log_all", $dataArray);
        // Log_Insert - End


        if ($result) {
            $condition = 1;
        } else {
            
        }

        $info[] = array('a' => $condition);
        echo json_encode($info);
    }

    /*
     * Get Department data
     */

    public function get_details() {
        $id = $this->input->post('id');

        $whereArray = array('user_level_id' => $id);

        $this->Db_model->setWhere($whereArray);
        $dataObject = $this->Db_model->getData('user_level_id,user_level_name', 'tbl_user_level_master');

        $array = (array) $dataObject;
        echo json_encode($array);
    }

    /*
     * Edit Data
     */

    public function edit() {
        $ID = $this->input->post("id", TRUE);
        $UL = $this->input->post("user_level_name", TRUE);


        $data = array("user_level_name" => $UL);
        $whereArr = array("user_level_id" => $ID);
        $result = $this->Db_model->updateData("tbl_user_level_master", $data, $whereArr);
        redirect(base_url() . "Master/User_Levels");
    }

    /*
     * Delete Data
     */

    public function ajax_delete($id) {
        $table = "tbl_user_level_master";
        $where = 'user_level_id';
        $this->Db_model->delete_by_id($id, $where, $table);
        echo json_encode(array("status" => TRUE));
    }

}
