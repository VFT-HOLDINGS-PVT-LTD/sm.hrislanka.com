<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Leave_Approve_Adj extends CI_Controller
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
        $currentUser = $this->session->userdata('login_user');
        $Emp = $currentUser[0]->EmpNo;
        $data['title'] = "Leave Apply | HRM System";
        $data['data_dep'] = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');
        $data['data_desig'] = $this->Db_model->getData('Des_ID,Desig_Name', 'tbl_designations');
        $data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');
        $data['data_set'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $data['data_leave'] = $this->Db_model->getfilteredData("SELECT 
                                                                        lv_typ.Lv_T_ID,
                                                                        lv_typ.leave_name
                                                                    FROM
                                                                        tbl_leave_allocation lv_al
                                                                        right join
                                                                        tbl_leave_types lv_typ on lv_al.Lv_T_ID = lv_typ.Lv_T_ID
                                                                        where EmpNo='$Emp'
                                                                    ");
        $this->load->view('Leave_Transaction/Leave_Approve_Adj/index', $data);
    }

    /*
     * Check Leave Balance
     */

    public function check_Leave()
    {


        $cat = $this->input->post('cmb_cat2');

        $query = $this->Db_model->getfilteredData("select Used, Balance from tbl_leave_allocation where EmpNo='" . $cat . "' ");

        $query;
    }

    /*
     * Dependent Dropdown
     */

    public function dropdown()
    {

        $cat = $this->input->post('cmb_cat');

        if ($cat == "Employee") {
            $query = $this->Db_model->get_dropdown();
            echo '<option value="" default>-- Select --</option>';
            foreach ($query->result() as $row) {

                echo "<option value='" . $row->EmpNo . "'>" . $row->Emp_Full_Name . "</option>";
            }
        }
    }

    /*
     * Search Employees by cat
     */

    public function search_employee()
    {


        $emp = $this->input->post("txt_emp");
        $emp_name = $this->input->post("txt_emp_name");
        $desig = $this->input->post("cmb_desig");
        $dept = $this->input->post("cmb_dep");
        $from_date = $this->input->post("txt_from_date");
        $to_date = $this->input->post("txt_to_date");


        // Filter Data by categories
        $filter = '';


        if (($this->input->post("txt_from_date")) && ($this->input->post("txt_to_date"))) {
            if ($filter == '') {
                $filter = " AND  le.Leave_Date between '$from_date' and '$to_date'";
            } else {
                $filter .= " AND  le.Leave_Date  between '$from_date' and '$to_date'";
            }
        }

        if (($this->input->post("txt_emp"))) {
            if ($filter == null) {
                $filter = " AND em.EmpNo = '$emp'";
            } else {
                $filter .= " AND em.EmpNo = '$emp'";
            }
        }

        if (($this->input->post("txt_emp_name"))) {
            if ($filter == null) {
                $filter = " AND em.Emp_Full_Name= '$emp_name'";
            } else {
                $filter .= " AND em.Emp_Full_Name = '$emp_name'";
            }
        }

        $currentUser = $this->session->userdata('login_user');
        $Emp = $currentUser[0]->EmpNo;

        $data['data_set'] = $this->Db_model->getfilteredData("SELECT
    le.LV_ID,
    le.EmpNo,
    em.Emp_Full_Name,
    lt.leave_name,
    le.Apply_Date,
    le.month,
    le.Year,
    le.Sup_AD_APP,
    le.Is_Sup_AD_APP,
    le.Is_pending,
    le.Leave_Date,
    le.Reason,
    le.Leave_Count
FROM
    tbl_leave_entry le
    INNER JOIN tbl_empmaster em ON em.EmpNo = le.EmpNo
    INNER JOIN tbl_leave_types lt ON lt.Lv_T_ID = le.Lv_T_ID
    left JOIN tbl_emp_group ON tbl_emp_group.Sup_ID = em.Emp_Full_Name WHERE (le.Is_Approve = 1 OR le.Is_pending = 1) {$filter} ORDER BY le.LV_ID DESC");

    // echo json_encode($data['data_set']);
        $this->load->view('Leave_Transaction/Leave_Approve_Adj/search_data', $data);
    }

    /*
     * Approve Leave request
     */

    public function approve($ID)
    {

        $currentUser = $this->session->userdata('login_user');
        $Emp = $currentUser[0]->EmpNo;

        $data = array(
            'Is_pending' => 1,
            'Is_Sup_AD_APP' => 1,
            'Sup_AD_APP' => $Emp,
        );


        $Emp_Data = $this->Db_model->getfilteredData("select * from tbl_leave_entry where LV_ID=$ID");
        $Emp_No = $Emp_Data[0]->EmpNo;

        //Get Employee Contact Details

        $Emp_cont_Data = $this->Db_model->getfilteredData(" select EmpNo,Emp_Full_Name,Tel_mobile from tbl_empmaster where EmpNo=$Emp_No");
        $Tel = $Emp_cont_Data[0]->Tel_mobile;
        $Emp_Fullname = $Emp_cont_Data[0]->Emp_Full_Name;


        //***Get leave date by Leave ID 
        $Leave_data = $this->Db_model->getfilteredData("select * from tbl_leave_entry where LV_ID=$ID and EmpNo=$Emp_No");

        //        $from_date = $Leave_data[0]->Leave_Date;

        /*
         * Update Individual Roster Table Is Leave status and Leave Type
         */
        //Start
        //        $Roster_ID = $this->Db_model->getfilteredData("select ID_Roster from tbl_individual_roster where EmpNo ='$Emp_No' and Fdate = '$from_date' ");
        //        $DayStatus = 'LV'; //****** IF Apply Leave Update Individual Roster DayStatus As 'LV'
        //        $data_RS = array("Lv_T_ID" => $leave_type, "Is_Leave" => 1, "nopay" => 0, "DayStatus" => $DayStatus, 'Is_processed' => 1, "Att_Allow" =>0);
        //        $whereArray = array("ID_Roster" => $Roster_ID[0]->ID_Roster);
        //        $results = $this->Db_model->updateData("tbl_individual_roster", $data_RS, $whereArray);

        $whereArr = array("LV_ID" => $ID);
        $result = $this->Db_model->updateData("tbl_leave_entry", $data, $whereArr);
        //End
        //****** Send message to leave request employee
        /*
         * SMS Server configuration
         */




        $this->session->set_flashdata('success_message', 'Leave Approved successfully');
        redirect(base_url() . "Leave_Transaction/Leave_Approve_Sup");
    }

    public function edit_lv($ID)
    {

        $data['title'] = "Leave Apply | HRM System";

        $this->load->view('Leave_Transaction/Leave_Edit/index', $data);



        //        $currentUser = $this->session->userdata('login_user');
        //        $Emp = $currentUser[0]->EmpNo;
        //
        //        $data = array(
        //            'Is_pending' => 0,
        //            'Is_Approve' => 1,
        //            'Approved_by' => $Emp,
        //        );
        //
        //
        //        $Emp_Data = $this->Db_model->getfilteredData("select * from tbl_leave_entry where LV_ID=$ID");
        //        $Emp_No = $Emp_Data[0]->EmpNo;
        //        
        //        //Get Employee Contact Details
        //       
        //        $Emp_cont_Data = $this->Db_model->getfilteredData(" select EmpNo,Emp_Full_Name,Tel_mobile from tbl_empmaster where EmpNo=$Emp_No");
        //        $Tel = $Emp_cont_Data[0]->Tel_mobile;
        //        $Emp_Fullname = $Emp_cont_Data[0]->Emp_Full_Name;
        //                
        //
        //        //***Get leave date by Leave ID 
        //        $Leave_data = $this->Db_model->getfilteredData("select * from tbl_leave_entry where LV_ID=$ID and EmpNo=$Emp_No");
        //
        //        $from_date = $Leave_data[0]->Leave_Date;
        //
        //        /*
        //         * Update Individual Roster Table Is Leave status and Leave Type
        //         */
        //        //Start
        //        $Roster_ID = $this->Db_model->getfilteredData("select ID_Roster from tbl_individual_roster where EmpNo ='$Emp_No' and Fdate = '$from_date' ");
        //        $DayStatus = 'LV'; //****** IF Apply Leave Update Individual Roster DayStatus As 'LV'
        //        $data_RS = array("Lv_T_ID" => $leave_type, "Is_Leave" => 1, "nopay" => 0, "DayStatus" => $DayStatus, 'Is_processed' => 1);
        //        $whereArray = array("ID_Roster" => $Roster_ID[0]->ID_Roster);
        //        $results = $this->Db_model->updateData("tbl_individual_roster", $data_RS, $whereArray);
        //
        //        $whereArr = array("LV_ID" => $ID);
        //        $result = $this->Db_model->updateData("tbl_leave_entry", $data, $whereArr);
        //        //End
        //
        //        //****** Send message to leave request employee
        //        /*
        //         * SMS Server configuration
        //         */
        //        $sender = "HRM SYSTEM";
        //        $recipient = $Tel;
        //        $message = 'System Response : ' . $Emp_Fullname .' '. 'Your Leave Request on'. ' '.$from_date.' '. 'is Approved';
        //
        //        $url = 'http://127.0.0.1:9333/ozeki?';
        //        $url .= "action=sendMessage";
        //        $url .= "&login=admin";
        //        $url .= "&password=abc123";
        //        $url .= "&recepient=" . urlencode($recipient);
        //        $url .= "&messageData=" . urlencode($message);
        //        $url .= "&sender=" . urlencode($sender);
        //        file($url);
        //
        //
        //
        //
        //        $this->session->set_flashdata('success_message', 'Leave Approved successfully');
        //        redirect(base_url() . "Leave_Transaction/Leave_Approve");
    }

    //sms
    // public function sms()
    // {

    //     $sender = "Name";
    //     $recipient = $user_details[$x]->contact_no;
    //     $message = 'Dear Customer';

    //     $url = 'http://127.0.0.1:9333/ozeki?';
    //     $url .= "action=sendMessage";
    //     $url .= "&login=admin";
    //     $url .= "&password=abc123";
    //     $url .= "&recepient=" . urlencode($recipient);
    //     $url .= "&messageData=" . urlencode($message);
    //     $url .= "&sender=" . urlencode($sender);
    //     file($url);
    // }

    /*
     * Reject Leave request
     */

    public function reject($ID)
    {


        $currentUser = $this->session->userdata('login_user');
        $Emp = $currentUser[0]->EmpNo;

        $data = array(
            'Is_pending' => 0,
            'Is_Approve' => 0,
            'Is_Cancel' => 1,
            'Approved_by' => $Emp,
        );


        //        -------- Leave Allocation Update
        date_default_timezone_set('Asia/Colombo');
        $date = date_create();
        $year = date("Y");

        $LTYpe = $this->Db_model->getfilteredData("select * from tbl_leave_entry where LV_ID = $ID");

        $LeaveType = $LTYpe[0]->Lv_T_ID;

        $Balance_Usd = $this->Db_model->getfilteredData("select Balance,Used,Lv_T_ID from tbl_leave_allocation where EmpNo=$Emp and Year=$year and Lv_T_ID=$LeaveType ");
        //                    var_dump($Balance_Usd);die;
        $Day_type = 1;
        $Balance = $Balance_Usd[0]->Balance - $Day_type;



        $Used = $Balance_Usd[0]->Used + $Day_type;
        $Lv_T_ID = $Balance_Usd[0]->Lv_T_ID;

        $data_arr = array("Balance" => $Balance, "Used" => $Used);

        $whereArray = array("EmpNo" => $Emp, "Lv_T_ID" => $Lv_T_ID);
        $result = $this->Db_model->updateData("tbl_leave_allocation", $data_arr, $whereArray);

        $whereArr = array("LV_ID" => $ID);
        $result = $this->Db_model->updateData("tbl_leave_entry", $data, $whereArr);

        $this->session->set_flashdata('success_message', 'Leave Reject successfully');
        redirect(base_url() . "Leave_Transaction/Leave_Approve");
    }

    /*
     * Reject Leave request
     */

    public function delete($ID)
    {

        $currentUser = $this->session->userdata('login_user');
        $Emp = $currentUser[0]->EmpNo;

        // $data = array(
        //     'Is_delete' => 1,
        //     'delete_ID' => $Emp
        // );

        

        //        -------- Leave Allocation Update
        date_default_timezone_set('Asia/Colombo');
        $date = date_create();
        $year = date("Y");

        $LTYpe = $this->Db_model->getfilteredData("select * from tbl_leave_entry where LV_ID = $ID");
        $Emp_LV = $LTYpe[0]->EmpNo;
        $LeaveType = $LTYpe[0]->Lv_T_ID;
        $tbl_leave_count = $LTYpe[0]->Leave_Count;

        $Balance_Usd = $this->Db_model->getfilteredData("select Balance,Used,Lv_T_ID from tbl_leave_allocation where EmpNo=$Emp_LV and Year=$year and Lv_T_ID=$LeaveType ");
        //                    var_dump($Balance_Usd);die;
        $Day_type = $tbl_leave_count;
        $Balance = $Balance_Usd[0]->Balance + $Day_type;

        $Used = $Balance_Usd[0]->Used - $Day_type;
        if($Used < 0){
            $Used = 0;  
        }
        $Lv_T_ID = $Balance_Usd[0]->Lv_T_ID;

        $data_arr = array("Balance" => $Balance, "Used" => $Used);

        $whereArray = array("EmpNo" => $Emp_LV, "Lv_T_ID" => $Lv_T_ID);
        $result = $this->Db_model->updateData("tbl_leave_allocation", $data_arr, $whereArray);

        // $whereArr = array("LV_ID" => $ID);
        // $result = $this->Db_model->updateData("tbl_leave_entry", $data, $whereArr);

        // New update the delete code
        $table = "tbl_leave_entry";
        $where = 'LV_ID';
        $this->Db_model->delete_by_id($ID, $where, $table);

        // Log_Insert - Start

        // Get the last inserted ID
        // $insert_id = $this->Db_model->getfilteredData("SELECT `Dep_ID` FROM tbl_departments WHERE `Dep_Name`='".$depName."'");//change action
        // $Dep_ID = $insert_id[0]->Dep_ID;//change action

        function get_client_ips() {
            $ipaddress = '';
            if (getenv('HTTP_CLIENT_IP')) {
                $ipaddress = getenv('HTTP_CLIENT_IP');
            } else if (getenv('HTTP_X_FORWARDED_FOR')) {
                $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
            } else if (getenv('HTTP_X_FORWARDED')) {
                $ipaddress = getenv('HTTP_X_FORWARDED');
            } else if (getenv('HTTP_FORWARDED_FOR')) {
                $ipaddress = getenv('HTTP_FORWARDED_FOR');
            } else if (getenv('HTTP_FORWARDED')) {
                $ipaddress = getenv('HTTP_FORWARDED');
            } else if (getenv('REMOTE_ADDR')) {
                $ipaddress = getenv('REMOTE_ADDR');
            } else {
                $ipaddress = 'UNKNOWN';
            }
            return $ipaddress;
        }

        $ip = get_client_ips();

        $currentUser = $this->session->userdata('login_user');
        $Emp = $currentUser[0]->EmpNo;

        date_default_timezone_set('Asia/Colombo');
        $current_time = date('Y-m-d H:i:s');
        
        $system_page_name = "Leave_Transaction - Leave Adjustment(Delete)";//change action
        $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");

        $dataArray = array(
            'log_user_id' => $Emp,
            'ip_address' => $ip,
            'system_action' => 'Leave adjustment(Delete) is successfully. Its ID is '.$ID.'',//change action
            'trans_time' => $current_time,
            'system_page' => $spnID[0]->id 
        );

        $this->Db_model->insertData("tbl_audit_log_all", $dataArray);
        // Log_Insert - End

        $this->session->set_flashdata('success_message', 'Leave Delete successfully');
        redirect(base_url() . "Leave_Transaction/Leave_Approve_Adj");
    }
}
