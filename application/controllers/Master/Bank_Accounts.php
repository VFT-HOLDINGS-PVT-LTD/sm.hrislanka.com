<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bank_Accounts extends CI_Controller {

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
        $data['title'] = 'Add Account Details | Dedigama Group (PVT) Ltd.';
        $data['data_array'] = $this->Db_model->getData('B_id,B_name,Address,Tel1,Tel2,Fax,Email', 'tbl_branches');
        $data['data_bank'] = $this->Db_model->getData('Bnk_ID,bank_name', 'tbl_banks');

        $this->load->view('Master/Account/index', $data);
    }

    public function add_complain() {
        
    }

    public function insert_account() {

      $bank_id = $this->input->post('cmb_bank');
      $acc_no = $this->input->post('txt_account');
        
        $dataArr = array(
            'id' => $bank_id,
            
            'Acc_no' => $this->input->post('txt_account'),
//            'Address' => $this->input->post('txt_lst_cq'),
            
        );

        $result = $this->Db_model->insertData("tbl_accounts", $dataArr);
        
        
        $dataArr1 = array(
            'id' => $acc_no,
            
            'lc_no' => $this->input->post('txt_lst_cq'),
//            'Address' => $this->input->post('txt_lst_cq'),
            
        );

        $result1 = $this->Db_model->insertData("tbl_cheque_no", $dataArr1);
        

//        $serialdata = $this->Db_model->getfilteredData('SELECT    id
//         FROM      tbl_banks
//         ORDER BY  id DESC
//         LIMIT     1;');
//        
//        $new_id = ($serialdata[0]->id);
//        
//        
//        
//        var_dump($new_id);die;
//        
//        $dataArr = array(
//            'bank_name' => $new_id,
////            'B_Name' => $this->input->post('txt_account'),
////            'Address' => $this->input->post('txt_lst_cq'),
//            
//        );
//
//        $result = $this->Db_model->insertData("tbl_banks", $dataArr);
        

        $condition = 0;


        if ($result) {
            $condition = 1;
        } else {
//            $serialdata = $this->Db_model->getData('serial', 'tbl_serials', array('code' => 'Department'));
//            $serial= "DP" . substr(("0000" . (int)  $serialdata[1]->serial), strlen("0000" . $serialdata[0]->serial) - 4, 4);
//            $data['serial'] = ++$serial;
        }
        $info[] = array('a' => $condition);
        echo json_encode($info);
    }

    public function branch_details() {
        $id = $this->input->post('B_Code');
//            echo "OkM " . $id;
        $whereArray = array('B_Code' => $id);

        $this->Db_model->setWhere($whereArray);
        $dataObject = $this->Db_model->getData('B_Code,B_name,Address,TelNo,TelNo1,FaxNo,Email,IsActive', 'tbl_branches');

        $array = (array) $dataObject;
        echo json_encode($array);
    }

    public function edit() {
        $B_Code = $this->input->post("B_Code", TRUE);
        $B_name = $this->input->post("B_name", TRUE);
        $Address = $this->input->post("Address", TRUE);
        $TelNo = $this->input->post("TelNo", TRUE);
        $TelNo1 = $this->input->post("TelNo1", TRUE);
        $FaxNo = $this->input->post("FaxNo", TRUE);
        $Email = $this->input->post("Email", TRUE);
        $IsActive = $this->input->post("IsActive", TRUE);

        $data = array("B_name" => $B_name,"Address" => $Address,"TelNo" => $TelNo,"TelNo1" => $TelNo1,"FaxNo" => $FaxNo,"Email" => $Email,"IsActive" => $IsActive);
        $whereArr = array("B_Code" => $B_Code);
        $result = $this->Db_model->updateData("tbl_branches", $data, $whereArr);
        redirect(base_url() . "index.php/Add_Branch/");
    }
    
    
       public function ajax_delete($id)
	{
                $table = "tbl_branches";
		$this->Db_model->delete_by_code($id,$table);
		echo json_encode(array("status" => TRUE));
	}

}
