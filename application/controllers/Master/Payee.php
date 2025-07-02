<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payee extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!($this->session->userdata('login_user'))) {
            redirect(base_url() . "");
        }
        $this->load->model('Db_model', '', TRUE);
    }

    public function index() {

        $this->load->helper('url');
        $data['title'] = 'Add Payee | HRM System';
        $data['data_array'] = $this->Db_model->getData('id,name,address,tel,email', 'tbl_payee');

        $this->load->view('Master/Payee/index', $data);
    }

    public function add_complain() {
        
    }

    public function insert_payee() {

        $dataArr = array(
            'name' => $this->input->post('txt_Name'),
            'address' => $this->input->post('txt_address'),
            'tel' => $this->input->post('txt_telephone'),
            'email' => $this->input->post('txt_Email')
            
        );

        $result = $this->Db_model->insertData("tbl_payee", $dataArr);
        $this->session->set_flashdata('success_message', 'Payee added successfully');

        redirect(base_url() . "Master/Payee/");
    }

    public function get_details() {
        $id = $this->input->post('id');
        $whereArray = array('id' => $id);

        $this->Db_model->setWhere($whereArray);
        $dataObject = $this->Db_model->getData('id,name,address,tel,email', 'tbl_payee');

        $array = (array) $dataObject;
        echo json_encode($array);
    }

    public function edit() {
        $id = $this->input->post("id", TRUE);
        $name = $this->input->post("name", TRUE);
        $Address = $this->input->post("Address", TRUE);
        $TelNo = $this->input->post("TelNo", TRUE);
        $Email = $this->input->post("email", TRUE);
       

        $data = array("name" => $name,"Address" => $Address,"	tel" => $TelNo,"email" => $Email);
        $whereArr = array("id" => $id);
        $result = $this->Db_model->updateData("tbl_payee", $data, $whereArr);
        redirect(base_url() . "Master/Payee/");
    }
    
    
       public function ajax_delete($id)
	{
                $table = "tbl_payee";
                $where = 'ID';
		$this->Db_model->delete_by_id($id,$where,$table);
		echo json_encode(array("status" => TRUE));
	}

}
