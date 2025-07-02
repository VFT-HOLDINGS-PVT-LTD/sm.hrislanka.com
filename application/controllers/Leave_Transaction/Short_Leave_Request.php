<?php

defined('BASEPATH') or exit ('No direct script access allowed');

class Short_Leave_Request extends CI_Controller
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
        $data['title'] = "Leave Entry | HRM System";
        $data['data_set'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $data['data_leave'] = $this->Db_model->getData('Lv_T_ID,leave_name,leave_entitle', 'tbl_leave_types');
        $data['data_set_att'] = $this->Db_model->getfilteredData("select * from tbl_shortlive inner join tbl_empmaster on tbl_empmaster.EmpNo = tbl_shortlive.EmpNo where tbl_empmaster.EmpNo=$Emp order by ID desc");
        
        $this->load->view('Leave_Transaction/Short_Leave_Request/index', $data);

        // $this->load->view('Leave_Transaction/Short_Leave_Entry/index', $data);

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
     * Insert Leave Data
     */



    public function insert_data()
    {

        $currentUser = $this->session->userdata('login_user');
        $ApproveUser = $currentUser[0]->EmpNo;
        $Emp = $this->input->post('txt_employee');
        $date1 = $this->input->post('att_date');
        $from_time = $this->input->post('in_time');
        $to_time = $this->input->post('out_time');

        date_default_timezone_set('Asia/Colombo');
        $date = new DateTime();
        $timestamp1 = date_format($date, 'Y-m-d');

        $orderdate1 = explode('/', $date1);
        $year1 = $orderdate1[0];

        $month2 = $orderdate1[1];

        $date = $date1;
        $H = explode("/", $date);
        $month = $H[1];


        // $Monthonly = date('Y/m/d');
        // $M = explode("/", $Monthonly);
        // $Month1 = $M[1];

        // $leaveentity = $this->Db_model->getfilteredData("SELECT * FROM tbl_emp_group INNER JOIN tbl_empmaster ON tbl_emp_group.Grp_ID = tbl_empmaster.Grp_ID WHERE tbl_empmaster.EmpNo = '$Emp' ");
        // $shortleaveDate = $useentity["sh"][0]->Date;
        // if (empty($useentity["sh"])) {

        $dateTime = date('Y/m/d h:i:s', time());
        $useentity["sh"] = $this->Db_model->getfilteredData("SELECT * FROM tbl_shortlive WHERE `EmpNo` = '$Emp' AND `Month`='$month'");

        if (!empty($useentity["sh"])) {
            // echo "thiywa2";
            foreach ($useentity["sh"] as $data) {
                // echo json_encode($data);
                // echo "1";
                // thiynwanam
                if ($data != null) {
                    $shortleaveDate = $data->Date;
                    $ID = $data->ID;
                    $MonthData = $data->Month;

                    $this->session->set_flashdata('error_message', 'Already Have a Short Leave');
                    redirect('Leave_Transaction/Short_Leave_Request/index');
                 
                } else {

                    $data = array(
                        'EmpNo' => $Emp,
                        'from_time' => $from_time,
                        'to_time' => $to_time,
                        'Date' => $date1,
                        'Month' => $month,
                        'used' => 1,
                        // 'balance' => $leaveentity[0]->NosLeaveForMonth - 1,
                        'balance' => '0',
                        'Apply_Date' => $dateTime,
                        'Is_pending' => '1',
                        'Is_Approve' => '0',
                    );
                    $this->Db_model->insertData('tbl_shortlive', $data);
                    $this->session->set_flashdata('success_message', 'Employee Short Leave Added');
                }
            }
        } else {
            // echo "nee2";
            // echo "<br>";
            $data = array(
                'EmpNo' => $Emp,
                'from_time' => $from_time,
                'to_time' => $to_time,
                'Date' => $date1,
                'Month' => $month,
                'used' => 1,
                // 'balance' => $leaveentity[0]->NosLeaveForMonth - 1,
                'balance' => '0',
                'Apply_Date' => $dateTime,
                'Is_pending' => '1',
                'Is_Approve' => '0',
            );
            $this->Db_model->insertData('tbl_shortlive', $data);
            $this->session->set_flashdata('success_message', 'Employee Short Leave Added');

        }
        // Log_Insert - Start
        $Category = $this->input->post('cmb_cat');
        $Selected_Category = $this->input->post('cmb_cat2');

       //  $leave_type = $this->input->post('cmb_leave_type');
       //  $reason = $this->input->post('txt_reason');
       //  $orderdate = $this->input->post('txt_from_date');
       //  $from_date = $this->input->post('txt_from_date');
       //  $to_date = $this->input->post('txt_to_date');
       //  $Day_type = $this->input->post('cmb_day');

        // Get the last inserted ID
        // $insert_id = $this->Db_model->getfilteredData("SELECT `Lv_T_ID` FROM tbl_leave_types WHERE `leave_name`='".$LeaveName."'");//change action
        // $Lv_T_ID = $insert_id[0]->Lv_T_ID;//change action

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

        // $ip = "111";
        $currentUser = $this->session->userdata('login_user');
        $Emp = $currentUser[0]->EmpNo;

        date_default_timezone_set('Asia/Colombo');
        $current_time = date('Y-m-d H:i:s');
        
        $system_page_name = "Leave_Transaction - Short Leave Request";//change action
        $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");

        $dataArray = array(
            'log_user_id' => $Emp,
            'ip_address' => $ip,
            'system_action' => 'A Short Leave Request has been added. Its have these '.$Emp.','.$date1.','.$from_time.','.$to_time.' details',//change action
            'trans_time' => $current_time,
            'system_page' => $spnID[0]->id 
        );

        $this->Db_model->insertData("tbl_audit_log_all", $dataArray);
        // Log_Insert - End

        redirect('Leave_Transaction/Short_Leave_Request/index');

    }
}
