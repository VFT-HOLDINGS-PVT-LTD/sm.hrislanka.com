<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {

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

        $data['title'] = "Departmrnt | HRM System";
        $data['data_set'] = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');
        $this->load->view('Master/Department/index', $data);
    }

    /*
     * Insert Departmrnt
     */

    public function insertDepartment() {

        $depName = $this->input->post('txt_dep_name');
        $data = array(
            'Dep_Name' => $this->input->post('txt_dep_name')
        );

        $result = $this->Db_model->insertData("tbl_departments", $data);

        // Log_Insert - Start

        // Get the last inserted ID
        $insert_id = $this->Db_model->getfilteredData("SELECT `Dep_ID` FROM tbl_departments WHERE `Dep_Name`='".$depName."'");//change action
        $Dep_ID = $insert_id[0]->Dep_ID;//change action

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
        
        $system_page_name = "Master - Departmrnt";//change action
        $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");

        $dataArray = array(
            'log_user_id' => $Emp,
            'ip_address' => $ip,
            'system_action' => 'A new department has been added. Its ID is '.$Dep_ID.' and the name is '.$depName,//change action
            'trans_time' => $current_time,
            'system_page' => $spnID[0]->id 
        );

        $this->Db_model->insertData("tbl_audit_log_all", $dataArray);
        // Log_Insert - End


        $this->session->set_flashdata('success_message', 'New Department has been added successfully');

        
        redirect(base_url() . 'Master/Department/');
    }

    /*
     * Get Department data
     */

    public function get_details() {
        $id = $this->input->post('id');
        $whereArray = array('Dep_ID' => $id);

        $this->Db_model->setWhere($whereArray);
        $dataObject = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');

        $array = (array) $dataObject;
        echo json_encode($array);
    }

    /*
     * Edit Data
     */

    public function edit() {
        $ID = $this->input->post("id", TRUE);
        $D_Name = $this->input->post("Dep_Name", TRUE);


        $data = array("Dep_Name" => $D_Name);
        $whereArr = array("Dep_ID" => $ID);
        $result = $this->Db_model->updateData("tbl_departments", $data, $whereArr);
        redirect(base_url() . "Master/Department");
    }

    /*
     * Delete Data
     */

    public function ajax_delete($id) {
        $table = "tbl_departments";
        $where = 'Dep_ID';
        $this->Db_model->delete_by_id($id, $where, $table);
        echo json_encode(array("status" => TRUE));
    }

}
