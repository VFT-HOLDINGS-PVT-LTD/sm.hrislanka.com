<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_Employees extends CI_Controller {

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
        $data['title'] = "ADD Employees | HRM SYSTEM";
        $data['data_dep'] = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');
        $data['data_desig'] = $this->Db_model->getData('Des_ID,Desig_Name', 'tbl_designations');
        $data['data_grp'] = $this->Db_model->getData('Grp_ID,EmpGroupName', 'tbl_emp_group');
        $data['data_u_lvl'] = $this->Db_model->getData('user_level_id,user_level_name', 'tbl_user_level_master');
        $data['data_Rstr'] = $this->Db_model->getData('RosterCode,RosterName', 'tbl_rosterpatternweeklyhd');
        $data['data_bank'] = $this->Db_model->getData('Bnk_ID,bank_name', 'tbl_banks');
        $this->load->view('Employee_Management/ADD_Employees/index', $data);
    }

    public function edit($id) {

        $data['title'] = "EDIT Employees | HRM SYSTEM";
        $data['data_DS'] = $this->Db_model->getData('Des_ID,Desig_Name,Desig_Order', 'tbl_designations');
        $data['data_DP'] = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');
        $data['data_Grp'] = $this->Db_model->getData('Grp_ID,EmpGroupName', 'tbl_emp_group');
        $data['data_Rstr'] = $this->Db_model->getData('RosterCode,RosterName', 'tbl_rosterpatternweeklyhd');
        $data['data_ot'] = $this->Db_model->getData('OTCode,OTName', 'tbl_ot_pattern_hd');
        $data['data_branch'] = $this->Db_model->getData('B_id,B_name', 'tbl_branches');
        $data['data_bank'] = $this->Db_model->getData('Bnk_ID,bank_name', 'tbl_banks');
        $data['data_u_lvl'] = $this->Db_model->getData('user_level_id,user_level_name', 'tbl_user_level_master');
        $data['data_epf'] = $this->Db_model->getData('EPF_CAT,EPF_CAT_Name', 'tbl_epf_cat');
        $data['data_status'] = $this->Db_model->getData('EMP_ST_ID,EMP_ST_Name', 'tbl_emp_status');
        

        $data['data_set'] = $this->Db_model->getfilteredData("SELECT 
                                                                    tbl_empmaster.EmpNo,
                                                                    tbl_empmaster.Enroll_No,
                                                                    tbl_empmaster.EPFNO,
                                                                    tbl_empmaster.EPF_CAT,
                                                                    tbl_empmaster.Is_EPF,
                                                                    tbl_empmaster.OCP_Code,
                                                                    tbl_empmaster.EMP_ST_ID,
                                                                    tbl_empmaster.Emp_Full_Name,
                                                                    tbl_empmaster.Emp_Name_Int,
                                                                    tbl_empmaster.Title,
                                                                    tbl_empmaster.Gender,
                                                                    tbl_empmaster.DOB,
                                                                    tbl_empmaster.Status,
                                                                    tbl_empmaster.Basic_Salary,
                                                                    tbl_empmaster.Fixed_Allowance,
                                                                    tbl_empmaster.Incentive,
                                                                    tbl_empmaster.Bnk_Br_ID,
                                                                    tbl_empmaster.Image,
                                                                    tbl_empmaster.ApointDate,
                                                                    tbl_empmaster.Permanent_Date,
                                                                    tbl_empmaster.ResignDate,
                                                                    tbl_empmaster.Account_no,
                                                                    tbl_empmaster.Is_EPF,
                                                                    tbl_empmaster.NIC,
                                                                    tbl_empmaster.Passport,
                                                                    tbl_empmaster.Address,
                                                                    tbl_empmaster.City,
                                                                    tbl_empmaster.District,
                                                                    tbl_empmaster.Tel_home,
                                                                    tbl_empmaster.Tel_mobile,
                                                                    tbl_empmaster.E_mail,
                                                                    tbl_empmaster.Religion,
                                                                    tbl_empmaster.Civil_status,
                                                                    tbl_empmaster.Blood_group,
                                                                    tbl_empmaster.Relations_name,
                                                                    tbl_empmaster.Relations_Tel,
                                                                    tbl_empmaster.No_Of_Child,
                                                                    tbl_empmaster.Remarks,
                                                                    tbl_empmaster.highlights,
                                                                    tbl_empmaster.Is_allow_login,
                                                                    tbl_empmaster.username,
                                                                    tbl_empmaster.password,
                                                                    tbl_empmaster.user_p_id,
                                                                    tbl_departments.Dep_ID,
                                                                    tbl_departments.Dep_Name,
                                                                    tbl_designations.Des_ID,
                                                                    tbl_designations.Desig_Name,
                                                                    tbl_emp_group.Grp_ID,
                                                                    tbl_emp_group.EmpGroupName,
                                                                    tbl_rosterpatternweeklyhd.RosterCode,
                                                                    tbl_rosterpatternweeklyhd.RosterName,
                                                                    tbl_ot_pattern_hd.OTCode,
                                                                    tbl_ot_pattern_hd.OTName,
                                                                    tbl_branches.B_id,
                                                                    tbl_branches.B_name,
                                                                    tbl_banks.Bnk_ID,
                                                                    tbl_banks.bank_name,
                                                                    tbl_user_level_master.user_level_id,
                                                                    tbl_user_level_master.user_level_name
                                                                FROM
                                                                    tbl_empmaster
                                                                        LEFT JOIN
                                                                    tbl_departments ON tbl_empmaster.Dep_ID = tbl_departments.Dep_ID
                                                                        LEFT JOIN
                                                                    tbl_designations ON tbl_empmaster.Des_ID = tbl_designations.Des_ID
                                                                        LEFT JOIN
                                                                    tbl_emp_group ON tbl_empmaster.Grp_ID = tbl_emp_group.Grp_ID
                                                                        LEFT JOIN
                                                                    tbl_rosterpatternweeklyhd ON tbl_empmaster.RosterCode = tbl_rosterpatternweeklyhd.RosterCode
                                                                        LEFT JOIN
                                                                    tbl_ot_pattern_hd ON tbl_empmaster.OTCode = tbl_ot_pattern_hd.OTCode
                                                                        LEFT JOIN
                                                                    tbl_branches ON tbl_empmaster.B_id = tbl_branches.B_id
                                                                        LEFT JOIN
                                                                    tbl_banks ON tbl_empmaster.Bnk_ID = tbl_banks.Bnk_ID
                                                                        left join
                                                                    tbl_user_level_master on tbl_empmaster.user_p_id = tbl_user_level_master.user_level_id where EmpNo='" . $id . "'");

//        echo '<pre>' . var_export($data, true) . '</pre>';die;
//        var_dump($data);die;


        $this->load->view('Employee_Management/Edit_Employees/index', $data);
    }

    public function update_emp() {

        $Emp_No = $this->input->post('txt_emp_no');

        $Image = md5($Emp_No);


        $Is_Allow = $this->input->post('Is_Allow');

//        var_dump($Is_Allow);
//        die;
//        if ($Is_Allow == null) {
//            $Is_Allow = 0;
//        } else {
//            $Is_Allow = 1;
//        }
//
//        var_dump($Is_Allow);
//        die;

        $Is_EPF = $this->input->post('cmb_if_epf');
        if ($Is_EPF == null) {
            $Is_EPF = 0;
        }


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


        $satus = $this->input->post('employee_status');
        // echo $satus;
        $st = '';
        if($satus== 'Active'){
            $st = "1";
        }else{
            $st = "0";
        }

        $data = array(
            'Enroll_No' => $this->input->post('txt_enroll_no'),
            'EPFNO' => $this->input->post('txt_epf_no'),
            'EPF_CAT' => $this->input->post('cmb_epf_cat'),
            'OCP_Code' => $this->input->post('txt_ocp_code'),
            'EMP_ST_ID' => $this->input->post('cmb_emp_status'),
            'Title' => $this->input->post('cmb_emp_title'),
            'Emp_Full_Name' => $this->input->post('txt_emp_name'),
            'Emp_Name_Int' => $this->input->post('txt_emp_name_init'),
            'Image' => $Image . ".jpg",
            'Gender' => $this->input->post('cmb_gender'),
            'Status' => 1,
            'Dep_ID' => $this->input->post('cmb_dep'),
            'Des_ID' => $this->input->post('cmb_desig'),
            'Grp_ID' => $this->input->post('cmb_group'),
            'RosterCode' => $this->input->post('cmb_roster_pattern'),
            'OTCode' => $this->input->post('cmb_ot_pattern'),
            'B_id' => $this->input->post('cmb_branch'),
            'ApointDate' => $this->input->post('txt_appoint_date'),
            'Permanent_Date' => $this->input->post('txt_permanent_date'),
            'Basic_Salary' => $this->input->post('txt_basic_sal'),
            'Incentive' => $this->input->post('txt_Incentive'),
            'Fixed_Allowance' => $this->input->post('txt_BG_Allowance'),
            'Bnk_ID' => $this->input->post('cmb_bank'),
            'Bnk_Br_ID' => $this->input->post('txt_B_Branch'),
            'Account_no' => $this->input->post('txt_account'),
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
//            'Is_allow_login' => $Is_Allow,
            'username' => $this->input->post('txt_user_name'),
            'user_p_id' => $this->input->post('cmb_user_level'),
            'Cmp_ID' => 1,
            'Active_process' => 1,
            'Status' => $st,
        );

//        $result = $this->Db_model->insertData("tbl_empmaster", $data);

        $whereArr = array("EmpNo" => $this->input->post("txt_emp_no"));
        $result = $this->Db_model->updateData("tbl_empmaster", $data, $whereArr);


        $this->session->set_flashdata('success_message', 'Update Employee has been added successfully');


        redirect('/Employee_Management/View_Employees/');
    }

}
