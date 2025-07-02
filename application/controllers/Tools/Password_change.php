<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Password_change extends CI_Controller {

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

        $data['title'] = "Departmrnt | HRM System";
        $data['data_set'] = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');
        $this->load->view('Tools/Password_change/index', $data);
    }

    public function Change() {

//        hash('sha512', $password)

        $currentUser = $this->session->userdata('login_user');
        $User = $currentUser[0]->EmpNo;

//        var_dump($currentUser);die;
//        $B_Code = $currentUser[0]->B_Code;
//        var_dump($User);die;


        $data_DB = $this->Db_model->getfilteredData("SELECT EmpNo, password FROM tbl_empmaster where EmpNo= '$User' ");

//        echo '<pre>' . var_export($data_DB, true) . '</pre>';
//        die;
//        var_dump($data_DB);
//        die;

        $DB_Pass = $data_DB[0]->password;

        $cur_pass = hash('sha512', $this->input->post('txt_cur_password'));
        $new_pass = hash('sha512', $this->input->post('txt_new_password'));





//        var_dump($DB_Pass, $cur_pass, $new_pass, $User);
//        die;


        if ($cur_pass == $cur_pass) {

            $data = array(
                'password' => $new_pass
            );

            $whereArr = array("EmpNo" => $User);
            $result = $this->Db_model->updateData("tbl_empmaster", $data, $whereArr);

            $this->session->set_flashdata('success_message', 'New Password Change has been added successfully');
        } elseif ($cur_pass !== $cur_pass) {
            $this->session->set_flashdata('error_message', 'Current Password Wrong');
        }










        redirect('/Tools/Password_change/');
    }

    /*
     * Get Department data
     */

    public function get_details() {
        $id = $this->input->post('id');

//                    echo "OkM " . $id;

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
        $table = "tbl_departments";
        $where = 'Dep_ID';
        $this->Db_model->delete_by_id($id, $where, $table);
        echo json_encode(array("status" => TRUE));
    }

}
