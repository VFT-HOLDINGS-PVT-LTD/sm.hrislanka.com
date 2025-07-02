<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_Types extends CI_Controller {

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

        $data['title'] = "LEAVE TYPES | HRM SYSEM";
        $data['data_set'] = $this->Db_model->getData('Lv_T_ID,leave_name,leave_entitle,leave_BF,IsActive', 'tbl_leave_types');
        $this->load->view('Master/Leave_Types/index', $data);
    }

    /*
     * Insert Data
     */

    public function insert_Data() {
        
        $BF=$this->input->post('chk_BF');
        if ($BF == null) {
            $BF = 0;
        } elseif ($BF == 'on') {
            $BF=1;
        }

        $data = array(
           
            'leave_name' => $this->input->post('txt_L_Name'),
            'leave_entitle' => $this->input->post('txt_L_Entitle'),
            'leave_BF' => $BF,
            'IsActive' => 1,
        );

        $result = $this->Db_model->insertData("tbl_leave_types", $data);

        // Log_Insert - Start
        $LeaveName = $this->input->post('txt_L_Name');

        // Get the last inserted ID
        $insert_id = $this->Db_model->getfilteredData("SELECT `Lv_T_ID` FROM tbl_leave_types WHERE `leave_name`='".$LeaveName."'");//change action
        $Lv_T_ID = $insert_id[0]->Lv_T_ID;//change action

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
        
        $system_page_name = "Master - Leave Types";//change action
        $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");

        $dataArray = array(
            'log_user_id' => $Emp,
            'ip_address' => $ip,
            'system_action' => 'A new Leave Type Name has been added. Its ID is '.$Lv_T_ID.' and the name is '.$LeaveName,//change action
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
     * Get data
     */

    public function get_details() {
        $id = $this->input->post('id');

//                    echo "OkM " . $id;
        
        $whereArray = array('Lv_T_ID' => $id);

        $this->Db_model->setWhere($whereArray);
        $dataObject = $this->Db_model->getData('Lv_T_ID,leave_name,leave_entitle,leave_BF,IsActive', 'tbl_leave_types');

  
        $array = (array) $dataObject;
        echo json_encode($array);
    }
    
    
    /*
     * Edit Data
     */
    public function edit() {
        $ID = $this->input->post("id", TRUE);
        $L_Name = $this->input->post("L_Name", TRUE);
        $L_Ent = $this->input->post("L_Ent", TRUE);
        $L_BF = $this->input->post("L_BF", TRUE);
        $is_active = $this->input->post("is_active", TRUE);
        

        $data = array("leave_name" => $L_Name,'leave_entitle'=>$L_Ent,"leave_BF" => $L_BF,"IsActive" => $is_active);
        $whereArr = array("Lv_T_ID" => $ID);
        $result = $this->Db_model->updateData("tbl_leave_types", $data, $whereArr);
        redirect(base_url() . "Master/Leave_Types");
    }
    
   /*
    * Delete Data
    */
    public function ajax_delete($id)
	{
                $table = "tbl_designations";
                $where ='Lv_T_ID';
		$this->Db_model->delete_by_id($id,$where,$table);
		echo json_encode(array("status" => TRUE));
	}
    public function update_Data() {

        $BF=$this->input->post('leavebf');
        if ($BF == null) {
            $BF = 0;
        } elseif ($BF == 'on') {
            $BF=1;
        }
        
        $data = array(
           
            'leave_name' => $this->input->post('leave_name'),
            'leave_entitle' => $this->input->post('leave_entitle'),
            'leave_BF' => $BF,
            'IsActive' => 1,
        );
        // $result = $this->Db_model->insertData("tbl_leave_types", $data);
        $whereArr = array("Lv_T_ID" => $this->input->post('id'));
            $this->Db_model->updateData("tbl_leave_types", $data, $whereArr);
            redirect(base_url() . "Master/Leave_Types");
        
    }
    

}
