<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Holidays_Report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!($this->session->userdata('login_user'))) {
            redirect(base_url() . "");
        }
        
        /*
         * Load Database model
         */
        $this->load->library("pdf_library");
        $this->load->model('Db_model', '', TRUE);
    }

    /*
     * Index page in Departmrnt
     */

    public function index() {

        $data['title'] = "Departmrnt | HRM System";
        $data['data_set'] = $this->Db_model->getData('id,Dep_Name', 'tbl_departments');
        $this->load->view('Master/Department/index', $data);
    }

    /*
     * Insert Departmrnt
     */

    public function Report_holidays() {
        
        $Data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');

        $Data['data_set'] = $this->Db_model->getfilteredData("SELECT 
                                                                        *
                                                                    FROM
                                                                        tbl_holidays
                                                                            INNER JOIN
                                                                        tbl_holiday_types ON tbl_holiday_types.HTCode = tbl_holidays.HTCode");
        
        $this->load->view('Reports/Master/rpt_Holidays', $Data);
    }
    
    
    /*
     * Get Department data
     */

    public function get_details() {
        $id = $this->input->post('id');

//                    echo "OkM " . $id;
        
        $whereArray = array('ID' => $id);

        $this->Db_model->setWhere($whereArray);
        $dataObject = $this->Db_model->getData('ID,Dep_Name', 'tbl_departments');

        $array = (array) $dataObject;
        echo json_encode($array);
    }
    
    
    public function edit() {
        $ID = $this->input->post("id", TRUE);
        $D_Name = $this->input->post("Dep_Name", TRUE);
        

        $data = array("Dep_Name" => $D_Name);
        $whereArr = array("Dep_ID" => $ID);
        $result = $this->Db_model->updateData("tbl_departments", $data, $whereArr);
        redirect(base_url() . "Master/Department");
    }
    
    
    public function ajax_delete($id)
	{
                $table = "tbl_departments";
                $where ='id';
		$this->Db_model->delete_by_id($id,$where,$table);
		echo json_encode(array("status" => TRUE));
	}

}
