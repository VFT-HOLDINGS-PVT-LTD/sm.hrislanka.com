<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ADD_Employees_Branch extends CI_Controller {

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


        $data['title'] = "ADD Employees | HRM SYSTEM";
        $data['data_dep'] = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');
        $data['data_desig'] = $this->Db_model->getData('Des_ID,Desig_Name', 'tbl_designations');
        $data['data_grp'] = $this->Db_model->getData('Grp_ID,EmpGroupName', 'tbl_emp_group');
        $data['data_u_lvl'] = $this->Db_model->getData('user_level_id,user_level_name', 'tbl_user_level_master');
        $data['data_Rstr'] = $this->Db_model->getData('RosterCode,RosterName', 'tbl_rosterpatternweeklyhd');
        $data['data_ot'] = $this->Db_model->getData('OTCode,OTName', 'tbl_ot_pattern_hd');
        $data['data_branch'] = $this->Db_model->getData('B_id,B_name', 'tbl_branches');
        $data['data_bank'] = $this->Db_model->getData('Bnk_ID,bank_name', 'tbl_banks');
        $this->load->view('Employee_Management/ADD_Employees_Branch/index', $data);
    }

    public function check_emp() {
        //get the username  
        $EmpNo = $this->input->post('txt_emp_no');

        $result = $this->Db_model->getfilteredData("select count(EmpNo) as EmpNo from tbl_empmaster where EmpNo = '$EmpNo' ");


//if number of rows fields is bigger them 0 that means it's NOT available '  
        if ($result[0]->EmpNo == 0) {

            echo 0;
        } else {
            //else if it's not bigger then 0, then it's available '  
            //and we send 1 to the ajax request  
            echo 1;
        }
    }

    //***** INsert Employee
    public function insert_Data() {

        $Emp_No = $this->input->post('txt_emp_no');

        $Image = md5($Emp_No);
        $Image_ath = md5($Emp_No);


        $config['upload_path'] = 'assets/images/Employees/';
        $config['allowed_types'] = 'jpg|png|docx';
        $config['max_size'] = 100000;
        $config['max_width'] = 4000;
        $config['max_height'] = 4000;
//      $config['file_name'] = $Image;
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

        $Password = $this->input->post('txt_nic');


        $Is_Allow = $this->input->post('Is_Allow');
        if ($Is_Allow == null) {
            $Is_Allow = 1;
        } else {
            $Is_Allow = 1;
        }

        $Is_EPF = $this->input->post('chk_epf');
        if ($Is_EPF == null) {
            $Is_EPF = 0;
        }

        $data = array(
            'EmpNo' => $this->input->post('txt_emp_no'),
            'Enroll_No' => $this->input->post('txt_enroll_no'),
            'EPFNO' => $this->input->post('txt_epf_no'),
            'Title' => $this->input->post('cmb_emp_title'),
            'Emp_Full_Name' => $this->input->post('txt_emp_name'),
            'Emp_Name_Int' => $this->input->post('txt_emp_name_init'),
            'Image' => $Image . ".jpg",
            'Gender' => $this->input->post('cmb_gender'),
            'Status' => 1,
            'Dep_ID' => $this->input->post('cmb_dep'),
            'Des_ID' => $this->input->post('cmb_desig'),
//            'Grp_ID' => $this->input->post('cmb_group'),
//            'RosterCode' => $this->input->post('cmb_roster_pattern'),
//            'OTCode' => $this->input->post('cmb_roster_pattern'),
            'B_id' => $this->input->post('cmb_branch'),
            'ApointDate' => $this->input->post('txt_appoint_date'),
//            'Permanent_Date' => $this->input->post('txt_permanent_date'),
//            'Basic_Salary' => $this->input->post('txt_basic_sal'),
            'Bnk_ID' => $this->input->post('cmb_bank'),
//            'Account_no' => $this->input->post('txt_account'),
            'Is_EPF' => $Is_EPF,
            'Address' => $this->input->post('txt_address'),
            'District' => $this->input->post('cmb_district'),
            'City' => $this->input->post('txt_city'),
            'Tel_home' => $this->input->post('txt_cont_home'),
            'Tel_mobile' => $this->input->post('txt_cont_mobile'),
            'E_mail' => $this->input->post('txt_email'),
            'NIC' => $this->input->post('txt_nic'),
            'Passport' => $this->input->post('txt_passport'),
            'DOB' => $this->input->post('txt_dob'),
            'Religion' => $this->input->post('cmb_religin'),
            'Civil_status' => $this->input->post('cmb_civil_status'),
            'Blood_group' => $this->input->post('cmb_blood'),
            'Relations_name' => $this->input->post('txt_rel_name'),
            'Relations_Tel' => $this->input->post('txt_rel_cont'),
            'No_Of_Child' => $this->input->post('txt_no_child'),
            'Is_allow_login' => 1,
            'username' => $this->input->post('txt_user_name'),
            'Password' => hash('sha512', $Password),
            'user_p_id' => 4,
//            'user_p_id' => $this->input->post('cmb_user_level'),
            'Cmp_ID' => 1,
        );

        $result = $this->Db_model->insertData("tbl_empmaster", $data);

        $this->session->set_flashdata('success_message', 'New Employee has been added successfully');

        redirect('/Employee_Management/ADD_Employees_Branch/');
    }

}
