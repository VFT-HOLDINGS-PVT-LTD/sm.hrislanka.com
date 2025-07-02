<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Banks extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!($this->session->userdata('login_user'))) {
            redirect(base_url() . "");
        }
//        if (!($this->session->userdata('login_user'))) {
//            redirect(base_url() . "");
//        }
        $this->load->model('Db_model', '', TRUE);
    }

    public function index() {

        $this->load->helper('url');
        $data['title'] = 'Banks | HRM System.';
        $data['data_array'] = $this->Db_model->getData('Bnk_ID,bank_name', 'tbl_banks');

        $this->load->view('Master/Bank/index', $data);
    }

    public function insert_data() {

        $dataArr = array(
            'bank_name' => $this->input->post('txt_bank'),
        );

        $result = $this->Db_model->insertData("tbl_banks", $dataArr);

        $this->session->set_flashdata('success_message', 'New Bank has been added successfully');
        
        redirect(base_url() . 'Master/Banks/'); //*********Redirect to index form
    }

    public function bank_details() {
        $id = $this->input->post('Bnk_ID');
//            echo "OkM " . $id;
        $whereArray = array('Bnk_ID' => $id);

        $this->Db_model->setWhere($whereArray);
        $dataObject = $this->Db_model->getData('Bnk_ID,bank_name', 'tbl_banks');

        $array = (array) $dataObject;
        echo json_encode($array);
    }

    public function edit() {
        $B_Code = $this->input->post("B_Code", TRUE);
        $B_name = $this->input->post("B_name", TRUE);
        

        $data = array("bank_name" => $B_name);
        $whereArr = array("Bnk_ID" => $B_Code);
        $result = $this->Db_model->updateData("tbl_banks", $data, $whereArr);
        redirect(base_url() . "Master/Banks/");
    }

    public function ajax_delete($id) {
        $table = "tbl_branches";
        $this->Db_model->delete_by_code($id, $table);
        echo json_encode(array("status" => TRUE));
    }

}
