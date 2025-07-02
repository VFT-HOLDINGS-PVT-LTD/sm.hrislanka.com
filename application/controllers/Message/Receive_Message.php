<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Receive_Message extends CI_Controller {

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
        
        $data['title'] = "Receive Message | HRM System";
        $currentUser = $this->session->userdata('login_user');
        $receiver = $currentUser[0]->EmpNo;
        
        
        $data['Employee'] = $currentUser[0]->Emp_Full_Name;
        $data['data_set'] = $this->Db_model->getfilteredData("SELECT 
                                                                    id,
                                                                    tbl_empmaster.Emp_Full_Name,
                                                                    sender,
                                                                    message,
                                                                    tbl_messages.Status,
                                                                    Trans_time,
                                                                    recever
                                                                FROM
                                                                    tbl_messages
                                                                        INNER JOIN
                                                                    tbl_empmaster ON tbl_empmaster.EmpNo = tbl_messages.sender
                                                                    where recever=$receiver
                                                                    ");
        $this->load->view('Message/Receive_Message/index', $data);
    }
    
    
    public function view_message() {
        
        $id = $this->input->post('id');
        var_dump($id);die;
        
        $this->Db_model->getfilteredData("update tbl_messages set status=1 where id=$id");
        
    }
    

    /*
     * Get Data
     */

    function emp_data() {
        $state = $this->input->post('txt_emp_name');
        $query = $this->Db_model->get_emp_info();

        foreach ($query->result() as $row) {
            echo $row->EmpNo;
        }
    }

    /*
     * Insert Departmrnt
     */

    public function insertMessage() {
        date_default_timezone_set('Asia/Colombo');
        
        $date = date_create();
        $timestamp = date_format($date, 'Y-m-d H:i:s');
        
        $currentUser = $this->session->userdata('login_user');

        $sender = $currentUser[0]->EmpNo;

        $data = array(
            'recever' => $this->input->post('txt_emp'),
            'message' => $this->input->post('txt_message'),
            'sender' => $sender,
            'status'=>0,
            'Trans_time' =>$timestamp
        );

        $result = $this->Db_model->insertData("tbl_messages", $data);
        $this->session->set_flashdata('success_message', 'New Message has been send successfully');


        redirect(base_url() . 'Message/Send_Message/');
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
        $table = "tbl_messages";
        $where = 'id';
        $this->Db_model->delete_by_id($id, $where, $table);
        echo json_encode(array("status" => TRUE));
    }

}
