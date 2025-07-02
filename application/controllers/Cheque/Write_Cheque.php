<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Write_Cheque extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!($this->session->userdata('login_user'))) {
            redirect(base_url() . "");
        }
        $this->load->model('db_model', '', TRUE);
    }

    public function index() {

        $this->load->helper('url');
        $data['title'] = 'Cheque Write | Dedigama Group (PVT) Ltd.';
//        $data['data_array'] = $this->db_model->getData('B_Code,B_name,Address,TelNo,TelNo1,FaxNo,Email,IsActive', 'tbl_branches');
        $data['data_payee'] = $this->db_model->getData('id,name,address', 'tbl_payee');
        $data['data_bank'] = $this->db_model->getData('Bnk_ID,bank_name', 'tbl_banks');
//        $data['data_branch'] = $this->db_model->getfilteredData('select B_Code,B_name from tbl_branches order by B_name ASC');



        $serialdata = $this->db_model->getfilteredData('SELECT    id
        FROM      tbl_cheque
        ORDER BY  id DESC
        LIMIT     1;');

        $new_id = ($serialdata[0]->id);
        $data['serial'] = ++$new_id;



//        $serial = "" . substr(("00000000" . (int) $serialdata[1]->serial), strlen("00000000" . $serialdata[1]->serial) - 8, 8);
//        $data['serial'] = ++$serial;
//        var_dump($new_id); die;

        $this->load->view('Cheques/Write_Cheque/index', $data);
    }

    public function add_complain() {
        
    }

    public function cheque_print() {


        $No1 = $this->input->post("txtNumber", TRUE);
        $No2 = $this->input->post("txtNumbe2", TRUE);
        $sp = ".";
        $Sum = $No1 . $sp . $No2;


        $no = $this->input->post('txt_chq');

        $Date = $this->input->post('txt_Date');
        $Bank = $this->input->post('cmb_bank');
        $Acc_No = $this->input->post('cmb_acc_no');
        $Branch = $this->input->post('cmb_branch');
        $Payee = $this->input->post('cmb_Payee');
        $Chq_no = $this->input->post('txt_cheque_no');
        $Comment = $this->input->post('txt_comment');




        $Cross = $this->input->post('isCross');

        if ($Cross == null) {
            $Cross = 0;
        } elseif ($Cross == 'on') {
            $Cross = 1;
        }


        date_default_timezone_set('Asia/Colombo');

        $date_now = date('Y-m-d   H:i:s', time());

        $currentUser = $this->session->userdata('login_user');

        $User_Name = $currentUser[0]->EmpNo;



        $dataArr = array("amount" => $Sum, "date" => $Date, "bank" => $Bank, "Acc_no" => $Acc_No,  "payee" => $Payee, "cheque_no" => $Chq_no, "comment" => $Comment, "cross" => $Cross, "print_time" => $date_now, "user" => $User_Name);


        $data2 = $this->db_model->getfilteredData("select name from tbl_payee where id=$Payee");


        $data_rpt = array(
            'amount' => $this->input->post('txtNumberWith'),
            'amount_cents' => $this->input->post('txtNumbe2'),
            'in_word' => $this->input->post('txtResult'),
            'date' => $this->input->post('txt_Date'),
            'bank' => $this->input->post('cmb_bank'),
            'payee' => $data2[0]->name,
            'cross' => $Cross,
            'cheque_no' => $this->input->post('txt_cheque_no'),
            'comment' => $this->input->post('txt_comment')
        );


        $result = $this->db_model->insertData("tbl_cheque", $dataArr);


        /*
         * Insert Cheque Last No
         */

        $Account = $this->input->post('cmb_acc_no');
        $Chq_No = $this->input->post('txt_cheque_no');

        $l_c_No = $Chq_No + 1;


        $data = array("lc_no" => $l_c_No);
        $whereArr = array("id" => $Account);
        $result = $this->db_model->updateData('tbl_cheque_no', $data, $whereArr);


        $condition = 0;



        if ($result) {
            $condition = 1;

        } else {
            
        }
        $info[] = array('a' => $condition);
        echo json_encode($info);

        //Commercial 1180035500
        if ($Acc_No === '1180035500') {
            $this->load->view('Reports/Cheques/com_1180035500', $data_rpt);
        }

        //Commercial 1850031401
        if ($Acc_No === '1850031401') {
            $this->load->view('Reports/Cheques/com_1850031401', $data_rpt);
        }

        //BOC 0000607598
        if ($Acc_No === '0000607598') {
            $this->load->view('Reports/Cheques/boc_0000607598', $data_rpt);
        }

        //NTB 013100010460
        if ($Acc_No === '013100010460') {
            $this->load->view('Reports/Cheques/ntb_013100010460', $data_rpt);
        }

        //Sampath 001310000074
        if ($Acc_No === '001310000074') {
            $this->load->view('Reports/Cheques/sam_001310000074', $data_rpt);
        }

        //Sampath 001310004711
        if ($Acc_No === '001310004711') {
            $this->load->view('Reports/Cheques/sam_001310004711', $data_rpt);
        }


        //Sampath 001310009632
        if ($Acc_No === '001310009632') {
            $this->load->view('Reports/Cheques/sam_001310009632', $data_rpt);
        }


        //Sampath 001310012226
        if ($Acc_No === '001310012226') {
            $this->load->view('Reports/Cheques/sam_001310012226', $data_rpt);
        }

        //Union 9970101000001912
        if ($Acc_No === '9970101000001912') {
            $this->load->view('Reports/Cheques/unb_9970101000001912', $data_rpt);
        }


        //Sampath 001350028621
        if ($Acc_No === '001350028621') {
            $this->load->view('Reports/Cheques/sam_001350028621', $data_rpt);
        }

        //Sampath 001350010730
        if ($Acc_No === '001350010730') {
            $this->load->view('Reports/Cheques/sam_001350010730', $data_rpt);
        }

        //NTB 013100000028
        if ($Acc_No === '013100000028') {
            $this->load->view('Reports/Cheques/ntb_013100000028', $data_rpt);
        }


        //Peoples 306100170017303
        if ($Acc_No === '306100170017303') {
            $this->load->view('Reports/Cheques/ppb_306100170017303', $data_rpt);
        }

        //Peoples 306100130536612
        if ($Acc_No === '306100130536612') {
            $this->load->view('Reports/Cheques/ppb_306100130536612', $data_rpt);
        }

        //Cargills 005950000001
        if ($Acc_No === '005950000001') {
            $this->load->view('Reports/Cheques/crb_005950000001', $data_rpt);
        }



        $this->load->view('Reports/Cheques/ntb_13100010460', $data_rpt);
        header("refresh: 1;");
    }

//    testing for loop
    public function cheque_print_loop() {


        $No1 = $this->input->post("txtNumber", TRUE);
        $No2 = $this->input->post("txtNumbe2", TRUE);
        $sp = ".";
        $Sum = $No1 . $sp . $No2;

        $no = $this->input->post('txt_chq');

        $Date = $this->input->post('txt_Date');
        $Bank = $this->input->post('cmb_bank');
        $Acc_No = $this->input->post('cmb_acc_no');
        $Branch = $this->input->post('cmb_branch');
        $Payee = $this->input->post('cmb_Payee');
        $Chq_no = $this->input->post('txt_cheque_no');
        $Comment = $this->input->post('txt_comment');




        $Cross = $this->input->post('isCross');

        if ($Cross == null) {
            $Cross = 0;
        } elseif ($Cross == 'on') {
            $Cross = 1;
        }


        date_default_timezone_set('Asia/Colombo');

        $date_now = date('Y-m-d   H:i:s', time());

        $currentUser = $this->session->userdata('login_user');

        $User_Name = $currentUser[0]->id;




        $data2 = $this->db_model->getfilteredData("select name from tbl_payee where id=$Payee");
        $data_rpt = array(
            'amount' => $this->input->post('txtNumberWith'),
            'amount_cents' => $this->input->post('txtNumbe2'),
            'in_word' => $this->input->post('txtResult'),
            'date' => $this->input->post('txt_Date'),
            'bank' => $this->input->post('cmb_bank'),
            'payee' => $data2[0]->name,
//            'branch' => $B_Name,
            'cross' => $Cross,
            'cheque_no' => $this->input->post('txt_cheque_no'),
            'comment' => $this->input->post('txt_comment'));

//        $x = 749550;
//        for ($i = 0; $i < $Count; $i++) {



        for ($x = 749551; $x <= 749600; $x++) {
            
            $dataArr = array(
                array(
                    "amount" => $Sum,
                    "date" => $Date,
                    "bank" => $Bank,
                    "Acc_no" => $Acc_No,
                    "B_Code" => $Branch,
                    "payee" => $Payee,
                    "cheque_no" => $Chq_no,
                    "comment" => $Comment,
                    "cross" => $Cross,
                    "print_time" => $date_now,
                    "user" => $User_Name,
                    "no" => $no));
//            var_dump($Chq_no);die;

            $result = $this->db->insert_batch("tbl_cheque", $dataArr);
            ++$Chq_no;

//            var_dump($result);die;
        }


        


        /*
         * Insert Cheque Last No
         */

        $Account = $this->input->post('cmb_acc_no');
        $Chq_No = $this->input->post('txt_cheque_no');

        $l_c_No = $Chq_No + 1;


        $data = array("lc_no" => $l_c_No);
        $whereArr = array("id" => $Account);
        $result = $this->db_model->updateData('tbl_cheque_no', $data, $whereArr);


        $condition = 0;



        if ($result) {
            $condition = 1;
        } else {
            
        }
        $info[] = array('a' => $condition);
        echo json_encode($info);

        if ($Acc_No === '1180035500') {
            $this->load->view('Reports/com_1180035500', $data_rpt);
        }

        //Commercial 1850031401
        if ($Acc_No === '1850031401') {
            $this->load->view('Reports/com_1850031401', $data_rpt);
        }

        //BOC 0000607598
        if ($Acc_No === '0000607598') {
            $this->load->view('Reports/boc_0000607598', $data_rpt);
        }

        //NTB 013100010460
        if ($Acc_No === '013100010460') {
            $this->load->view('Reports/ntb_013100010460', $data_rpt);
        }

        //Sampath 001310000074
        if ($Acc_No === '001310000074') {
            $this->load->view('Reports/sam_001310000074', $data_rpt);
        }

        //Sampath 001310004711
        if ($Acc_No === '001310004711') {
            $this->load->view('Reports/sam_001310004711', $data_rpt);
        }


        //Sampath 001310009632
        if ($Acc_No === '001310009632') {
            $this->load->view('Reports/sam_001310009632', $data_rpt);
        }


        //Sampath 001310012226
        if ($Acc_No === '001310012226') {
            $this->load->view('Reports/sam_001310012226', $data_rpt);
        }

        //Union 9970101000001912
        if ($Acc_No === '9970101000001912') {
            $this->load->view('Reports/unb_9970101000001912', $data_rpt);
        }


        //Sampath 001350028621
        if ($Acc_No === '001350028621') {
            $this->load->view('Reports/sam_001350028621', $data_rpt);
        }

        //Sampath 001350010730
        if ($Acc_No === '001350010730') {
            $this->load->view('Reports/sam_001350010730', $data_rpt);
        }

        //NTB 013100000028
        if ($Acc_No === '013100000028') {
            $this->load->view('Reports/ntb_013100000028', $data_rpt);
        }


        //Peoples 306100170017303
        if ($Acc_No === '306100170017303') {
            $this->load->view('Reports/ppb_306100170017303', $data_rpt);
        }

        //Peoples 306100130536612
        if ($Acc_No === '306100130536612') {
            $this->load->view('Reports/ppb_306100130536612', $data_rpt);
        }

        //Cargills 005950000001
        if ($Acc_No === '005950000001') {
            $this->load->view('Reports/crb_005950000001', $data_rpt);
        }



        $this->load->view('Reports/ntb_13100010460', $data_rpt);
//        header("refresh: 1;");
    }

    public function re_print() {
        
    }

    /*
     * Get Bank account number
     */

    function get_data() {
        $state = $this->input->post('cmb_bank');
        $query = $this->db_model->get_bank_info();
        echo '<option value="" default>-- Select --</option>';
        foreach ($query->result() as $row) {

            echo "<option value='" . $row->Acc_no . "'>" . $row->Acc_no . "</option>";
        }
    }

    /*
     * Get last cheque number according to bank account number
     */

    function get_data_chq() {
        $state = $this->input->post('cmb_acc_no');
        $query = $this->db_model->get_chqno_info();

        foreach ($query->result() as $row) {
//                 echo "< value='".$row->lc_no."'>".$row->lc_no."";

            echo $row->lc_no;
        }
    }

}
