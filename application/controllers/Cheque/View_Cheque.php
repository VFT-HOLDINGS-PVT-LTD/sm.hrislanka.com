<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class View_Cheque extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library("Pdf");
        if (!($this->session->userdata('login_user'))) {
            redirect(base_url() . "");
        }
        $this->load->model('db_model', '', TRUE);
    }

    public function index() {

        $this->load->helper('url');
        $data['title'] = 'View Cheque | Dedigama Group (PVT) Ltd.';
        $data['data_array'] = $this->db_model->getfilteredData('SELECT 
                                                                tbl_cheque.id,
                                                                tbl_cheque.amount,
                                                                tbl_cheque.cheque_no,
                                                                tbl_cheque.date,
                                                                tbl_cheque.cross,
                                                                tbl_cheque.is_cancel,
                                                                tbl_payee.name,
                                                                tbl_users.Employee_Name,
                                                                tbl_banks.bank_name,
                                                                tbl_branches.B_name
                                                            FROM
                                                                tbl_cheque
                                                                    INNER JOIN
                                                                tbl_payee ON tbl_cheque.payee = tbl_payee.id
                                                                    INNER JOIN
                                                                tbl_users ON tbl_cheque.user = tbl_users.id
                                                                    INNER JOIN
                                                                tbl_branches ON tbl_cheque.B_Code = tbl_branches.B_Code
                                                                    INNER JOIN
                                                                tbl_banks ON tbl_cheque.bank = tbl_banks.id');



        $this->load->view('Cheque/View_Cheque/index', $data);
    }

    public function add_complain() {
        
    }

    public function insert_branch() {

        $dataArr = array(
            'B_Code' => $this->input->post('txt_B_Code'),
            'B_Name' => $this->input->post('txt_B_name'),
            'Address' => $this->input->post('txt_address'),
            'TelNo' => $this->input->post('txt_tp'),
            'TelNo1' => $this->input->post('txt_mobile'),
            'FaxNo' => $this->input->post('txt_fax'),
            'Email' => $this->input->post('txt_Email')
        );

        $result = $this->db_model->insertData("tbl_branches", $dataArr);
        $condition = 0;


        if ($result) {
            $condition = 1;
        } else {
            
        }
        $info[] = array('a' => $condition);
        echo json_encode($info);
    }

    public function chq_details() {
        $id = $this->input->post('id');
//            echo "Ok " . $id;
//        $whereArray = array('id' => $id);

//        $this->db_model->setWhere($whereArray);
//        $dataObject = $this->db_model->getData('id,date,amount,cheque_no,B_Code,payee,cross,bank', 'tbl_cheque');
        $dataObject = $this->db_model->getfilteredData("select tbl_cheque.id,tbl_cheque.date,tbl_cheque.amount,tbl_cheque.cheque_no,tbl_branches.B_Name,tbl_cheque.payee,tbl_cheque.cross,tbl_cheque.bank from tbl_cheque inner join tbl_branches on  tbl_cheque.B_Code = tbl_branches.B_Code where tbl_cheque.id='" . $id . "' ");

//        var_dump($dataObject);die;

        $array = (array) $dataObject;



        echo json_encode($array);
    }

    public function edit() {

        $id = $this->input->post("id", TRUE);
        $is_cancel = $this->input->post("is_cancel", TRUE);

        if ($is_cancel == null) {
            $is_cancel = 0;
        } elseif ($is_cancel == 'on') {
            $is_cancel = 1;
        }

        $data = array("is_cancel" => $is_cancel);
//        $data = array("B_name" => $B_name,"Address" => $Address,"TelNo" => $TelNo,"TelNo1" => $TelNo1,"FaxNo" => $FaxNo,"Email" => $Email,"IsActive" => $IsActive);
        $whereArr = array("id" => $id);
        $result = $this->db_model->updateData("tbl_cheque", $data, $whereArr);
        redirect(base_url() . "index.php/View_Cheque/");
    }

    public function ajax_delete($id) {
        $table = "tbl_branches";
        $this->db_model->delete_by_code($id, $table);
        echo json_encode(array("status" => TRUE));
    }

    public function re_print() {


        $No1 = $this->input->post("txtNumber", TRUE);
        $No2 = $this->input->post("txtNumbe2", TRUE);
        $sp = ".";
        $Sum = $No1 . $sp . $No2;


        $no = $this->input->post('txt_chq');

        $Date = $this->input->post('date1');
//        $Bank = $this->input->post('bank1');
        $Payee = $this->input->post('payee1');

//        var_dump($Payee);die;
        $Chq_no = $this->input->post('txt_cheque_no');
        $Comment = $this->input->post('txt_comment');



        $Cross = $this->input->post('isCross');

        if ($Cross == null) {
            $Cross = 0;
        } elseif ($Cross == 'on') {
            $Cross = 1;
        }



//        $numwith=$this->input->post('txtNumber');
//        list($whole, $decimal) = explode('.', $numwith);
////        list($whole, $decimal) = sscanf($numwith, '%d.%d');
//
//var_dump($whole, $decimal); die;


        $data2 = $this->db_model->getfilteredData("select name from tbl_payee where id='" . $Payee . "' ");

        $data_rpt = array(
            'amount' => $this->input->post('txtNumberWith'),
            'amount_cents' => $this->input->post('txtNumbe2'),
            'in_word' => $this->input->post('txtResult'),
            'date' => $this->input->post('date1'),
            'bank' => $this->input->post('cmb_bank'),
            'branch' => $this->input->post('branch1'),
            'payee' => $data2[0]->name,
            'cross' => $Cross,
            'cheque_no' => $this->input->post('cheque_no1'),
            'comment' => $this->input->post('txt_comment')
        );




        $this->load->view('Reports/test_2016-06-14_with_sign_test_1_domnew', $data_rpt);
//        header("refresh: 1;");
    }

}
