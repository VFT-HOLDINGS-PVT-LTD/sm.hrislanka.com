<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Loan_Types extends CI_Controller {

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
        $data['title'] = "Loan Types | HRM SYSTEM";
        $data['data_set'] = $this->Db_model->getData('Loan_ID,loan_name', 'tbl_loan_types');
        $this->load->view('Master/Loan_Types/index', $data);
    }
    
    
    /*
     * Insert Data
     */

    public function insert_data() {

        
        $Active=$this->input->post('chk_active');
        if($Active==null){
            $Active=0;
            
        }
        
        $data = array(
            'loan_name' => $this->input->post('txt_loan_type'),
            'IsActive' => $Active
            
                
        );

        $result = $this->Db_model->insertData("tbl_loan_types", $data);

        // Log_Insert - Start
        $LoanTypeName = $this->input->post('txt_loan_type');

        // Get the last inserted ID
        $insert_id = $this->Db_model->getfilteredData("SELECT `Loan_ID` FROM tbl_loan_types WHERE `loan_name`='".$LoanTypeName."'");//change action
        $Loan_ID = $insert_id[0]->Loan_ID;//change action

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

        $system_page_name = "Master - Loan Type";//change action
        $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");

        $dataArray = array(
            'log_user_id' => $Emp,
            'ip_address' => $ip,
            'system_action' => 'A new Loan Type Name Name has been added. Its ID is '.$Loan_ID.' and the name is '.$LoanTypeName,//change action
            'trans_time' => $current_time,
            'system_page' => $spnID[0]->id 
        );

        $this->Db_model->insertData("tbl_audit_log_all", $dataArray);
        // Log_Insert - End


       $this->session->set_flashdata('success_message', 'New Loan Types has been added successfully');

        
        redirect(base_url() . 'Master/Loan_Types/');
    }
    public function get_details() {
        $id = $this->input->post('id');
//                    echo "OkM " . $id;
        $whereArray = array('Loan_ID' => $id);
        $this->Db_model->setWhere($whereArray);
        $dataObject = $this->Db_model->getData('Loan_ID,loan_name', 'tbl_loan_types');
        $array = (array) $dataObject;
        echo json_encode($array);
        
    }
    public function update_Data() {
        
        $data = array(
           
            'loan_name' => $this->input->post('loan_name'),
            'IsActive' => 0,
        );
        // $result = $this->Db_model->insertData("tbl_leave_types", $data);
        $whereArr = array("Loan_ID" => $this->input->post('id'));
            $this->Db_model->updateData("tbl_loan_types", $data, $whereArr);
            redirect(base_url() . "Master/Loan_Types");
        
    }

}
