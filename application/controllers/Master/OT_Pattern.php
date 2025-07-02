<?php

defined('BASEPATH') or exit('No direct script access allowed');

class OT_Pattern extends CI_Controller
{

    public function __construct()
    {
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

    public function index()
    {

        $data['title'] = "OT Pattern | HRM System";
        $data['data_set_shift'] = $this->Db_model->getData('OTCode', 'tbl_ot_pattern_hd');
        $data['data_set'] = $this->Db_model->getData('OTCode,OTName', 'tbl_ot_pattern_hd');
        $this->load->view('Master/OT_Pattern/index', $data);
    }

    /*
     * Insert Data
     */

    public function insert_Data()
    {

        $last_record = $this->Db_model->get_last_record('tbl_ot_pattern_hd','OTCode');

        $last_id_numeric = intval(substr($last_record->OTCode, 2)); // Extract numeric part
        $next_id_numeric = $last_id_numeric + 1; // Increment the numeric part
        $next_ot_id = "OT" . str_pad($next_id_numeric, 4, '0', STR_PAD_LEFT); // Format the next I

        $otpatternhd = array(
            "OTCode" => $next_ot_id,
            'OTName' => $this->input->post('txt_shift_name'),

        );
        $this->Db_model->insertData('tbl_ot_pattern_hd', $otpatternhd);
        $dataset = json_decode($_POST['hdntext']);
        

        foreach ($dataset as $dataitems) {
            $shiftarray = array(
                "OTCode" => $next_ot_id,
                'OTPatternName' => $this->input->post('txt_shift_name'),
                'DayCode' => $dataitems->Day,
                'DUEX' => 'DU',
                'BeforeShift' => $dataitems->chkBSH,
                'MinBS' => $dataitems->MinTw,
                'AfterShift' => $dataitems->ChkASH,
                'MinAS' => $dataitems->ASH_MinTw,
                'RoundUp' => $dataitems->RoundUp,
            );

            $this->Db_model->insertData('tbl_ot_pattern_dtl', $shiftarray);
        }
        //  Log_Insert - Start
        // $OTName = $this->input->post('txt_shift_name');

        // // Get the last inserted ID
        // $insert_id = $this->Db_model->getfilteredData("SELECT `OTCode` FROM tbl_ot_pattern_hd WHERE `OTName`='".$OTName."'");//change action
        // $OTCode = $insert_id[0]->OTCode;//change action

        // function get_client_ips() {
        //     $ipaddress = '';
        //     if (getenv('HTTP_CLIENT_IP')) {
        //         $ipaddress = getenv('HTTP_CLIENT_IP');
        //     } else if (getenv('HTTP_X_FORWARDED_FOR')) {
        //         $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        //     } else if (getenv('HTTP_X_FORWARDED')) {
        //         $ipaddress = getenv('HTTP_X_FORWARDED');
        //     } else if (getenv('HTTP_FORWARDED_FOR')) {
        //         $ipaddress = getenv('HTTP_FORWARDED_FOR');
        //     } else if (getenv('HTTP_FORWARDED')) {
        //         $ipaddress = getenv('HTTP_FORWARDED');
        //     } else if (getenv('REMOTE_ADDR')) {
        //         $ipaddress = getenv('REMOTE_ADDR');
        //     } else {
        //         $ipaddress = 'UNKNOWN';
        //     }
        //     return $ipaddress;
        // }

        // $ip = get_client_ips();

        // $currentUser = $this->session->userdata('login_user');
        // $Emp = $currentUser[0]->EmpNo;
        
        // $system_page_name = "Master - OT Pattern";//change action
        // $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");

        // $dataArray = array(
        //     'log_user_id' => $Emp,
        //     'ip_address' => $ip,
        //     'system_action' => 'A new OT Pattern has been added. Its ID is '.$OTCode.' and the name is '.$OTName,//change action
        //     'trans_time' => date('Y-m-d H:i:s'),
        //     'system_page' => $spnID[0]->id 
        // );

        // $this->Db_model->insertData("tbl_audit_log_all", $dataArray);
        // Log_Insert - End
        redirect('Master/OT_Pattern/index');
    }

    /*
     * Get data
     */

    public function get_details()
    {
        $ShiftCode = $this->input->post('OTCode');

        $whereArray = array('ID' => $ShiftCode);

        $this->Db_model->setWhere($whereArray);
        $dataObject = $this->Db_model->getData('OTCode,OTPatternName,DayCode,DUEX,BeforeShift,MinBS,AfterShift,MinAS', 'tbl_ot_pattern_dtl');

        $array = (array) $dataObject;
        echo json_encode($array);
        // echo $dataObject;

    }

    /*
     * Edit Data
     */

    public function edit()
    {
        $ShiftCode = $this->input->post("ShiftCode", TRUE);
        $ShiftName = $this->input->post("ShiftName", TRUE);
        $FromTime = $this->input->post("FromTime", TRUE);
        $ToTime = $this->input->post("ToTime", TRUE);
        $ShiftGap = $this->input->post("ShiftGap", TRUE);



        $data = array("ShiftName" => $ShiftName, "FromTime" => $FromTime, "ToTime" => $ToTime, "ShiftGap" => $ShiftGap,);
        $whereArr = array("ShiftCode" => $ShiftCode);
        $result = $this->Db_model->updateData("tbl_shifts", $data, $whereArr);
        redirect(base_url() . "Master/Shifts");
    }

    /*
     * Delete Data
     */

    public function ajax_delete($id)
    {
        $table = "tbl_shifts";
        $where = 'ShiftCode';
        $this->Db_model->delete_by_id($id, $where, $table);
        echo json_encode(array("status" => TRUE));
    }

    /*
     * Get Bank account number
     */

    function get_data()
    {
        $state = $this->input->post('cmb_bank');
        $query = $this->Db_model->get_bank_info();
        echo '<option value="" default>-- Select --</option>';
        foreach ($query->result() as $row) {

            echo "<option value='" . $row->Acc_no . "'>" . $row->Acc_no . "</option>";
        }
    }

    /*
     * Get last cheque number according to bank account number
     */

    function get_data_chq()
    {
        $state = $this->input->post('cmb_acc_no');
        $query = $this->Db_model->get_chqno_info();

        foreach ($query->result() as $row) {
            //                 echo "< value='".$row->lc_no."'>".$row->lc_no."";

            echo $row->lc_no;
        }
    }


    public function updateOtView()
    {
        $state = $this->input->get('id');
        $whereArray = array('OTCode' => $state);

        $this->Db_model->setWhere($whereArray);
        $data['data_set'] = $this->Db_model->getData('OTCode,OTPatternName,DayCode,DUEX,BeforeShift,MinBS,AfterShift,MinAS,RoundUp', 'tbl_ot_pattern_dtl');
        $data['title'] = "OT Pattern | HRM System";


        $this->load->view('Master/OT_Pattern/OT_update', $data);
    }
    public function updateOt()
    {
        $last_recordname = $this->input->post('txt_shift_name');
        $last_recordid = $this->input->post('txt_shift_id');
        
        $dataset = json_decode($_POST['hdntext2']);
        

        foreach ($dataset as $dataitems) {
            $shiftarray = array(
                "OTCode" => $last_recordid,
                'OTPatternName' => $last_recordname,
                'DayCode' => $dataitems->Day,
                'DUEX' => 'DU',
                'BeforeShift' => $dataitems->chkBSH,
                'MinBS' => $dataitems->MinTw,
                'AfterShift' => $dataitems->ChkASH,
                'MinAS' => $dataitems->ASH_MinTw,
                'RoundUp' => $dataitems->RoundUp,
            );

            // echo $last_recordid;
            // echo $last_recordname;
            // echo $dataitems->Day;
            // echo $dataitems->chkBSH;
            // echo $dataitems->MinTw;
            // echo $dataitems->ChkASH;
            // echo $dataitems->ASH_MinTw;
            // echo $dataitems->RoundUp;
            
            $whereArr = array("OTCode" => $last_recordid,"DayCode"=> $dataitems->Day);
            $this->Db_model->updateData("tbl_ot_pattern_dtl", $shiftarray, $whereArr);

        }
        
            redirect(base_url() . "Master/OT_Pattern/");
    }
}
