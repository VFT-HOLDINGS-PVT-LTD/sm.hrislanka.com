<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Br_types extends CI_Controller {

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

        $this->load->helper('url');
        $data['title'] = "Allowance | HRM SYSTEM";
        $data['data_set'] = $this->Db_model->getData('ID,Br_name,IsActive,isFixed', 'tbl_br_types');
        $this->load->view('Master/Br_Types/index', $data);
    }
    
    /*
     * Insert Data
     */

    public function insert_data() {
        
        
        $Fixed=$this->input->post('isFixed');
        if($Fixed==null){
            $Fixed=0;
            
        }

        $data = array(
            'Br_name' => $this->input->post('txt_allowance'),
            'IsActive' => 1,
            'isFixed' => $Fixed
                
        );

        $result = $this->Db_model->insertData("tbl_br_types", $data);


        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {

            $this->db->trans_commit();
            $this->session->set_flashdata('success_message', 'New Allowance has been added successfully');
        }

        redirect(base_url() . 'Master/Br_types/'); //*********Redirect to designation form
        
    }
    
       /*
     * Get data
     */

    public function get_details() {
        $id = $this->input->post('id');

//                    echo "OkM " . $id;

        $whereArray = array('ID' => $id);

        $this->Db_model->setWhere($whereArray);
        $dataObject = $this->Db_model->getData('ID,Br_name,IsActive,isFixed', 'tbl_br_types');
        
       

        $array = (array) $dataObject;
        echo json_encode($array);
    }

    /*
     * Edit Data
     */

    public function edit() {
        $ID = $this->input->post("id", TRUE);
        $Name = $this->input->post("Allowance_Name", TRUE);
        $Is_fxd = $this->input->post("is_Fixced", TRUE);
        $Is_Act = $this->input->post("is_Active", TRUE);
//        var_dump($Is_fxd.$Is_Act);die;


        $data = array("Allowance_name" => $Name,"IsActive"=>$Is_Act,"isFixed"=>$Is_fxd);
        $whereArr = array("Alw_ID" => $ID);
        $result = $this->Db_model->updateData("tbl_br_types", $data, $whereArr);
        redirect(base_url() . "Administration/Allowance_Types");
    }

    /*
     * Delete Data
     */

    public function ajax_delete($id) {
        $table = "tbl_allowance_type";
        $where = 'Alw_ID';
        $this->Db_model->delete_by_id($id, $where, $table);
        echo json_encode(array("status" => TRUE));
    }


}
