<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends CI_Controller {

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
        $data['title'] = "Employees | HRM SYSTEM";
        $data['data_dep'] = $this->Db_model->getData('id,Dep_Name', 'tbl_departments');
        $data['data_desig'] = $this->Db_model->getData('id,Desig_Name,Desig_Order', 'tbl_designations');
        $this->load->view('Master/Employees/index', $data);
    }
    
    
    public function insert_Data() {

        $Emp_No = $this->input->post('txt_emp_no');

        $Image = md5($Emp_No);
        $Image_ath = md5($Emp_No);


        $config['upload_path'] = 'assets/images/Employee/';
        $config['allowed_types'] = 'jpg|png|docx';
        $config['max_size'] = 100000;
        $config['max_width'] = 4000;
        $config['max_height'] = 4000;
//        $config['file_name'] = $Image;
        $config['file_name'] = $Image . ".jpg";
        $this->load->library('upload', $config);



        /*
         * 'image'  selected image id,name
         */
        if (!$this->upload->do_upload('img_employee')) {
            $error = array('error' => $this->upload->display_errors());

//            var_dump($error);
        } else {
            $data = array('upload_data' => $this->upload->data());
//            var_dump($data);
        }
       


        $data = array(
            'EmpNo' => $this->input->post('txt_emp_no'),
            'EPFNO' => $this->input->post('txt_epf_no'),
            'Title' => $this->input->post('cmb_emp_title'),
            'Emp_Full_Name' => $this->input->post('txt_emp_name'),
            'Emp_Full_Name' => $this->input->post('cmb_gender'),
            'Emp_Full_Name' => $this->input->post('employee_status'),
            'Emp_Full_Name' => $this->input->post('cmb_desig'),
            'Emp_Full_Name' => $this->input->post('cmb_dep'),
            'Emp_Full_Name' => $this->input->post('cmb_group'),
            'Emp_Full_Name' => $this->input->post('cmb_roster_pattern'),
            'Emp_Full_Name' => $this->input->post('cmb_ot_pattern'),
            'Emp_Full_Name' => $this->input->post('cmb_branch'),
            'Emp_Full_Name' => $this->input->post('txt_basic_sal'),
            'Emp_Full_Name' => $this->input->post('txt_appoint_date'),
            'Emp_Full_Name' => $this->input->post('txt_address'),
            'Emp_Full_Name' => $this->input->post('txt_city'),
            'Emp_Full_Name' => $this->input->post('cmb_district'),
            'Emp_Full_Name' => $this->input->post('txt_cont_home'),
            'Emp_Full_Name' => $this->input->post('txt_cont_mobile'),
            'Emp_Full_Name' => $this->input->post('txt_email'),
            'Emp_Full_Name' => $this->input->post('txt_nic'),
            'Emp_Full_Name' => $this->input->post('txt_bday'),
            'Emp_Full_Name' => $this->input->post('cmb_religin'),
            'Emp_Full_Name' => $this->input->post('cmb_civil_status'),
            'Emp_Full_Name' => $this->input->post('cmb_blood'),
            'Emp_Full_Name' => $this->input->post('txt_emp_name'),
            'Emp_Full_Name' => $this->input->post('txt_emp_name'),
            'Emp_Full_Name' => $this->input->post('txt_emp_name'),
            'Emp_Full_Name' => $this->input->post('txt_emp_name'),
            'Emp_Full_Name' => $this->input->post('txt_emp_name'),
            'Emp_Full_Name' => $this->input->post('txt_emp_name'),
            'Emp_Full_Name' => $this->input->post('txt_emp_name'),
            'Emp_Full_Name' => $this->input->post('txt_emp_name'),
            'Emp_Full_Name' => $this->input->post('txt_emp_name'),
            
            
            
            
            
            
            );

        $result = $this->Db_model->insertData("tbl_empmaster", $data);


        if ($result) {
            $condition = 1;
        } else {
            
        }

        $info[] = array('a' => $condition);
        echo json_encode($info);
    }

}
