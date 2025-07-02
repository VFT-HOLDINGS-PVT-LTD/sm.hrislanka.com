<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shift_Allocation extends CI_Controller {

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
     * Index page
     */

    public function index() {

        $data['title'] = "Shift Allocation | HRM System";
        $data['data_set'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $data['data_shift'] = $this->Db_model->getData('ShiftCode,ShiftName', 'tbl_shifts');
        $data['data_roster'] = $this->Db_model->getData('RosterCode,RosterName', 'tbl_rosterpatternweeklyhd');
        $this->load->view('Attendance/Shift_Allocation/index', $data);
    }

    public function dropdown() {

        $cat = $this->input->post('cmb_cat');

        if ($cat == "Employee") {
            $query = $this->Db_model->get_dropdown();
            echo '<option value="" default>-- Select --</option>';
            foreach ($query->result() as $row) {

                echo "<option value='" . $row->EmpNo . "'>" . $row->Emp_Full_Name . "</option>";
            }
        }

        if ($cat == "Department") {
            $query = $this->Db_model->get_dropdown_dep();
            echo '<option value="" default>-- Select --</option>';
            foreach ($query->result() as $row) {
                echo "<option value='" . $row->Dep_ID . "'>" . $row->Dep_Name . "</option>";
            }
        }
        if ($cat == "Designation") {
            $query = $this->Db_model->get_dropdown_des();
            echo '<option value="" default>-- Select --</option>';
            foreach ($query->result() as $row) {
                echo "<option value='" . $row->Des_ID . "'>" . $row->Desig_Name . "</option>";
            }
        }
        if ($cat == "Employee_Group") {
            $query = $this->Db_model->get_dropdown_group();
            echo '<option value="" default>-- Select --</option>';
            foreach ($query->result() as $row) {
                echo "<option value='" . $row->Grp_ID . "'>" . $row->EmpGroupName . "</option>";
            }
        }

        if ($cat == "Company") {
            $query = $this->Db_model->get_dropdown_comp();
            echo '<option value="" default>-- Select --</option>';
            foreach ($query->result() as $row) {
                echo "<option value='" . $row->Cmp_ID . "'>" . $row->Company_Name . "</option>";
            }
        }
    }

    /*
     * Insert Data
     */

    public function shift_allocations() {

        $cat = $this->input->post('cmb_cat');

        //*** Employee Filters
        //*** By Employee
        if ($cat == "Employee") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE EmpNo='$cat2' and Status = 1 and Active_process=1";
            $EmpData = $this->Db_model->getfilteredData($string);
        }

        //*** By Department
        if ($cat == "Department") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE Dep_ID='$cat2' and Status = 1 and Active_process=1";
            $EmpData = $this->Db_model->getfilteredData($string);
        }

        //*** By Designation
        if ($cat == "Designation") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE Des_ID='$cat2' and Status = 1 and Active_process=1";
            $EmpData = $this->Db_model->getfilteredData($string);
        }

        //*** By Employee_Group
        if ($cat == "Employee_Group") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE Grp_ID='$cat2' and Status = 1 and Active_process=1";
            $EmpData = $this->Db_model->getfilteredData($string);
        }

        //*** By Company
        if ($cat == "Company") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE Cmp_ID='$cat2' and Status = 1 and Active_process=1";
            $EmpData = $this->Db_model->getfilteredData($string);
        }
        
        
        
//        $string = "SELECT EmpNo FROM tbl_empmaster WHERE EmpNo='3316'";
        
        
        
        

        $roster = $this->input->post('cmb_roster');
        $from_date = $this->input->post('txt_from_date');
        $to_date = $this->input->post('txt_to_date');

        $d1 = new DateTime($from_date);
        $d2 = new DateTime($to_date);

        $interval = $d2->diff($d1)->days;

        for ($x = 0; $x <= $interval; $x++) {

            /*
             * Get Day Type in weekly roster
             */
            $Current_date = "";
            $num = date("N", strtotime($from_date));

            switch ($num) {

                //**********If $Num = 1 Day is Monday
                case 1:
                    $Current_date = "MON";
                    break;
                case 2:
                    $Current_date = "TUE";
                    break;
                case 3:
                    $Current_date = "WED";
                    break;
                case 4:
                    $Current_date = "THU";
                    break;
                case 5:
                    $Current_date = "FRI";
                    break;
                case 6:
                    $Current_date = "SAT";
                    break;
                case 7:
                    $Current_date = "SUN";
                    break;
                default:
                    break;
            }

            /*
             * Get Holiday Days
             */

            $var = $from_date;
            $date = str_replace('/', '-', $var);
            $from_date = date('Y-m-d', strtotime($date));

            $Holiday = $this->Db_model->getfilteredData("select count(Hdate) as HasRow from tbl_holidays where Hdate = '$from_date' ");
            $year = date("Y");

            $ros['i'] = $this->Db_model->getfilteredData("SELECT 
                                                                tr.ShiftCode,
                                                                tr.DayName,
                                                                tr.ShiftType,
                                                                ts.FromTime,
                                                                ts.ToTime,
                                                                ts.DayType,
                                                                ts.ShiftGap,
                                                                ts.NextDay
                                                            FROM
                                                                tbl_rosterpatternweeklydtl tr
                                                                    INNER JOIN
                                                                tbl_shifts ts ON ts.ShiftCode = tr.ShiftCode
                                                            WHERE
                                                                tr.RosterCode = '$roster'
                                                                    AND tr.DayName = '$Current_date'");




            $ShiftCode = $ros['i'][0]->ShiftCode;
            //Week Days  MON | TUE
            $DayName = $ros['i'][0]->DayName;
            $FromTime = $ros['i'][0]->FromTime;
            $ToTime = $ros['i'][0]->ToTime;
            //Shift Type DU | EX
            $ShiftType = $ros['i'][0]->ShiftType;
            $ShiftGap = $ros['i'][0]->ShiftGap;
            $DayType = $ros['i'][0]->DayType;
            $Next_Day = $ros['i'][0]->NextDay;

//            var_dump($Next_Day);die;

            $DayStatus = 'AB';
            if ($ShiftType == "EX") {
                $NoPay = 0;
                $DayStatus = 'EX';
            } else if ($Holiday[0]->HasRow == 1) {
                $ShiftType = 'EX';
                //**** Day status is Holiday | Late | Early Departure | AB | PR ******
                $DayStatus = 'HD';
                $NoPay = 0;
            } else {
                $NoPay = 1;
            }

            
            


            $Count = count($EmpData);

            for ($i = 0; $i < $Count; $i++) {


                $EmpGrp = $EmpData[$i]->EmpNo;


                $Group_Data = $this->Db_model->getfilteredData("SELECT Grp_ID from tbl_empmaster where EmpNo = $EmpGrp");
                $GroupID = $Group_Data[0]->Grp_ID;


                $Group_Grace = $this->Db_model->getfilteredData("SELECT GracePeriod FROM tbl_emp_group where Grp_ID = $GroupID");
                $GracePeriod = $Group_Grace[0]->GracePeriod;
//                var_dump($GracePeriod);die;
//               echo '<pre>' . var_export($Group_Data, true) . '</pre>'; die;
//            var_dump($EmpData);die;
//            var_dump($Group_Data);die;





                if ($Next_Day == 1) {
//                    $to_date = strtotime($from_date . '+1 day');
                    $to_date_sh = date('Y-m-d H:i:s', strtotime($from_date . ' +1 day'));
                } else {
                    $to_date_sh = $from_date;
                }



                $Em = $EmpData[$i]->EmpNo;
                $dataArray = array(
                    'RYear' => $year,
                    'EmpNo' => $EmpData[$i]->EmpNo,
                    'ShiftCode' => $ShiftCode,
                    'ShiftDay' => $DayName,
                    'Day_Type' => $DayType,
                    'ShiftIndex' => 1,
                    'FDate' => $from_date,
                    'FTime' => $FromTime,
                    'TDate' => $to_date_sh,
                    'TTime' => $ToTime,
                    'ShType' => $ShiftType,
                    'DayStatus' => $DayStatus,
                    'GapHrs' => $ShiftGap,
                    'GracePrd' => $GracePeriod,
                    'nopay' => $NoPay,
                );

//                var_dump($to_date);die;
                /*
                 * Check If Allocated Shift in Individual Roster Table
                 */
                $HasR = $this->Db_model->getfilteredData("SELECT 
                                                        COUNT(EmpNo) AS HasRow
                                                    FROM
                                                        tbl_individual_roster
                                                    WHERE
                                                        EmpNo = '$Em' AND FDate = '$from_date' ");

                if ($HasR[0]->HasRow == 1) {
                    $this->session->set_flashdata('error_message', 'Already Shift Allocated');
                } else {
                    $this->Db_model->insertData("tbl_individual_roster", $dataArray);
                    
                    $this->session->set_flashdata('success_message', 'Shift Allocation Processed successfully');
                }
            }

            $from_date = date("Y-m-d", strtotime("+1 day", strtotime($from_date)));
        }
        // Log_Insert - Start
        if ($HasR[0]->HasRow == 1) {
            // $this->session->set_flashdata('error_message', 'Already Shift Allocated');
            // Log_Insert - Start
            $Category = $this->input->post('cmb_cat');
            $Selected_Category = $this->input->post('cmb_cat2');
            $roster = $this->input->post('cmb_roster');
            $from_date = $this->input->post('txt_from_date');
            $to_date = $this->input->post('txt_to_date');

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
            
            $system_page_name = "Attendance - Shift Allocation";//change action
            $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");

            $dataArray = array(
                'log_user_id' => $Emp,
                'ip_address' => $ip,
                'system_action' => '(Not Inserted) A new shift allocation hasnt been added. Its have these '.$Category.','.$Selected_Category.','.$roster.','.$from_date.','.$to_date.' details',//change action
                'trans_time' => $current_time,
                'system_page' => $spnID[0]->id 
            );

            $this->Db_model->insertData("tbl_audit_log_all", $dataArray);
            // Log_Insert - End
        } else {
            // Log_Insert - Start
            $Category = $this->input->post('cmb_cat');
            $Selected_Category = $this->input->post('cmb_cat2');
            $roster = $this->input->post('cmb_roster');
            $from_date = $this->input->post('txt_from_date');
            $to_date = $this->input->post('txt_to_date');

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
            
            $system_page_name = "Attendance - Shift Allocation";//change action
            $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");

            $dataArray = array(
                'log_user_id' => $Emp,
                'ip_address' => $ip,
                'system_action' => 'A new shift allocation has been added. Its have these '.$Category.','.$Selected_Category.','.$roster.','.$from_date.','.$to_date.' details',//change action
                'trans_time' => $current_time,
                'system_page' => $spnID[0]->id 
            );

            $this->Db_model->insertData("tbl_audit_log_all", $dataArray);
            // Log_Insert - End
        }
        // Log_Insert - End
        
        redirect('/Attendance/Shift_Allocation');
    }

}
