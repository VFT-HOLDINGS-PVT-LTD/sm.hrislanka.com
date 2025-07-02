<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Company_Profile extends CI_Controller {

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

        $data['title'] = "Company Profile | HRM System";
        $data['data_set'] = $this->Db_model->getData('Cmp_ID,Company_Name,comp_Address,comp_Tel,comp_Email,comp_web,comp_reg_no,comp_logo', 'tbl_companyprofile');
        $this->load->view('Company_Profile/index', $data);
    }

    /*
     * Insert
     */

    public function insert_Data() {

       $Name = $this->input->post('txt_comp_name');
        
       $Image = md5($Name);

        $config['upload_path'] = 'assets/images/company/';
        $config['allowed_types'] = 'jpg|png';
        $config['max_size'] = 100000;
        $config['max_width'] = 4000;
        $config['max_height'] = 4000;
        $config['file_name'] = $Image . ".jpg";

        $this->load->library('upload', $config);

        /*
         * 'image'  selected image id,name
         */
        if (!$this->upload->do_upload('txt_comp_logo')) {
            $error = array('error' => $this->upload->display_errors());

//            var_dump($error);
        } else {
            $data = array('upload_data' => $this->upload->data());
//            var_dump($data);
        }


        $data = array(
            'company_Name' => $this->input->post('txt_comp_name'),
            'comp_Address' => $this->input->post('txt_comp_ad'),
            'comp_Tel' => $this->input->post('txt_comp_tel'),
            'comp_web' => $this->input->post('txt_comp_email'),
            'comp_Email' => $this->input->post('txt_comp_web'),
            'comp_reg_no' => $this->input->post('txt_comp_reg'),
            'comp_logo' => $Image
        );

        $result = $this->db_model->insertData("tbl_companyprofile", $data);


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

        $whereArray = array('Cmp_ID' => $id);

        $this->db_model->setWhere($whereArray);
        
        $dataObject = $this->Db_model->getData('Cmp_ID,Company_Name,comp_Address,comp_Tel,comp_Email,comp_web,comp_reg_no,comp_logo', 'tbl_companyprofile');

        $array = (array) $dataObject;
        echo json_encode($array);
    }

    /*
     * Edit Data
     */

    public function edit() {
        $ID = $this->input->post("id", TRUE);
        $Name = $this->input->post("Company_Name", TRUE);
        $Address = $this->input->post("comp_Address", TRUE);
        $Tel = $this->input->post("comp_Tel", TRUE);
        $Email = $this->input->post("comp_Email", TRUE);
        $Web = $this->input->post("comp_web", TRUE);
        $Reg = $this->input->post("comp_reg_no", TRUE);
        $Logo = $this->input->post("comp_logo", TRUE);
        

        $data = array("Company_Name" => $Name, 'comp_Address' => $Address,'comp_Tel' => $Tel,'comp_Email' => $Email,'comp_web' => $Web,'comp_reg_no' => $Reg,'comp_logo' => $Logo);
        $whereArr = array("Cmp_ID" => $ID);
        $result = $this->Db_model->updateData("tbl_companyprofile", $data, $whereArr);
        redirect(base_url() . "Company_Profile/Company_Profile");
    }

    /*
     * Delete Data
     */

    public function ajax_delete($id) {
        $table = "tbl_companyprofile";
        $where = 'Cmp_ID';
        $this->Db_model->delete_by_id($id, $where, $table);
        echo json_encode(array("status" => TRUE));
    }

}
