<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Salary_Advance extends CI_Controller {

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

        $this->load->helper('url');
        $data['title'] = "Salary Advance Entry | HRM SYSTEM";
        $data['data_emp'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');

//        $data['data_loan'] = $this->Db_model->getData('id,loan_name', 'tbl_loan_types');
        $this->load->view('Payroll/Salary_Advance/index', $data);
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

//        if ($cat == "Department") {
//            $query = $this->Db_model->get_dropdown_dep();
//            
//            echo"<select class='form-control' id='Dep' name='Dep'>";
//            foreach ($query->result() as $row) {
//                echo "<option value='" . $row->ID . "'>" . $row->Dep_Name . "</option>";
//            }
//            echo"</select>";
//        }
    }

    public function insert_data() {

        $currentUser = $this->session->userdata('login_user');
        $ApproveUser = $currentUser[0]->EmpNo;

        $cat = $this->input->post('cmb_cat');
        if ($cat == "Employee") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE EmpNo='$cat2'";
            $EmpData = $this->Db_model->getfilteredData($string);
        }

        if ($cat == "Department") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE Dep_ID='$cat2'";
            $EmpData = $this->Db_model->getfilteredData($string);
        }

        if ($cat == "Designation") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE Des_ID='$cat2'";
            $EmpData = $this->Db_model->getfilteredData($string);
        }
        if ($cat == "Employee_Group") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE Grp_ID='$cat2'";
            $EmpData = $this->Db_model->getfilteredData($string);
        }

        if ($cat == "Company") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE Cmp_ID='$cat2'";
            $EmpData = $this->Db_model->getfilteredData($string);
        }

        date_default_timezone_set('Asia/Colombo');
        $date = date_create();
        $timestamp = date_format($date, 'Y-m-d H:i:s');


//        $Request_date = $this->input->post('txt_date');

        $advance = $this->input->post('txt_advance');
        $year = date("Y");
//        $month = date("m");
         $month = $this->input->post('cmb_month');

        $Emp = $EmpData[0]->EmpNo;
//        var_dump($Emp);die;

        $Count = count($EmpData);
//        var_dump($Count);die;

        $SalPrecentage = $this->Db_model->getfilteredData("select (60/100)*(Basic_Salary+Incentive+Fixed_Allowance) as totsal from tbl_empmaster where EmpNo=$Emp");

        $HasRow = $this->Db_model->getfilteredData("select count(EmpNo) as HasRow from tbl_salary_advance where EmpNo=$Emp and Year=$year and month=$month");

//        if ($advance > $SalPrecentage[0]->totsal) {
//            $this->session->set_flashdata('error_message', 'Employee cannot apply more than salary precentage (60%)');
//        }
        if ($HasRow[0]->HasRow > 0) {
            $this->session->set_flashdata('error_message', 'Employee already applied salary advance');
        } else {
            for ($i = 0; $i < $Count; $i++) {
                $data = array(
                    array(
                        'EmpNo' => $Emp,
                        'Amount' => $advance,
                        'Year' => $year,
                        'Month' => $month,
                        'Is_pending' => 0,
                        'Approved_by' => $ApproveUser,
                        'Is_Approve' => 1,
                        'Is_Approve' => $timestamp,
                ));
                $this->db->insert_batch('tbl_salary_advance', $data);
                $this->session->set_flashdata('success_message', 'New Salary advance added successfully');
            }
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
         
         $system_page_name = "Payroll - Salary Advance";//change action
         $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");
 
         $dataArray = array(
             'log_user_id' => $Emp,
             'ip_address' => $ip,
             'system_action' => 'A Salary Advance has been added. Its have these '.$Category.','.$Selected_Category.','.$advance.','.$month.','.$year.' details',//change action
             'trans_time' => $current_time,
             'system_page' => $spnID[0]->id 
         );
 
         $this->Db_model->insertData("tbl_audit_log_all", $dataArray);
         // Log_Insert - End
        redirect('/Pay/Salary_Advance');
    }

    /*
     * Get Data
     */

    public function getSal_Advance() {

        $emp = $this->input->post("txt_emp");
        $emp_name = $this->input->post("txt_emp_name");
        $desig = $this->input->post("cmb_desig");
        $dept = $this->input->post("cmb_dep");
        $month = $this->input->post("cmb_months");
        $cmb_year = $this->input->post("cmb_years");



        // Filter Data by categories
        $filter = '';

        if (($this->input->post("cmb_years"))) {
            if ($filter == '') {
                $filter = " AND sal_ad.Year ='$cmb_year'";
            } else {
                $filter .= " AND sal_ad.Year ='$cmb_year'";
            }
        }

        if (($this->input->post("cmb_months"))) {
            if ($filter == '') {
                $filter = " AND sal_ad.Month ='$month'";
            } else {
                $filter .= " AND sal_ad.Month ='$month'";
            }
        }
        if (($this->input->post("txt_emp"))) {
            if ($filter == null) {
                $filter = " AND Emp.EmpNo ='$emp'";
            } else {
                $filter .= " AND Emp.EmpNo ='$emp'";
            }
        }

        if (($this->input->post("txt_emp_name"))) {
            if ($filter == null) {
                $filter = " AND Emp.Emp_Full_Name ='$emp_name'";
            } else {
                $filter .= " AND Emp.Emp_Full_Name ='$emp_name'";
            }
        }
        // if (($this->input->post("cmb_desig"))) {
        //     if ($filter == null) {
        //         $filter = " AND dsg.Des_ID  ='$desig'";
        //     } else {
        //         $filter .= " AND dsg.Des_ID  ='$desig'";
        //     }
        // }
        // if (($this->input->post("cmb_dep"))) {
        //     if ($filter == null) {
        //         $filter = " AND dep.Dep_id  ='$dept'";
        //     } else {
        //         $filter .= " AND dep.Dep_id  ='$dept'";
        //     }
        // }


        $data['data_set'] = $this->Db_model->getfilteredData("SELECT 
                                                                    sal_ad.id,
                                                                    sal_ad.EmpNo,
                                                                    Emp.Emp_Full_Name,
                                                                    sal_ad.Amount,
                                                                    sal_ad.Year,
                                                                    sal_ad.Month,
                                                                    sal_ad.Request_Date,
                                                                    sal_ad.Is_pending,
                                                                    sal_ad.Is_Approve,
                                                                    sal_ad.Approved_by,
                                                                    sal_ad.Is_Cancel,
                                                                    sal_ad.Approved_Timestamp,
                                                                    dsg.Desig_Name,
                                                                    dep.Dep_Name
                                                                FROM
                                                                    tbl_salary_advance sal_ad
                                                                        INNER JOIN
                                                                    tbl_empmaster Emp ON Emp.EmpNo = sal_ad.EmpNo
                                                                        LEFT JOIN
                                                                    tbl_designations dsg ON dsg.Des_ID = Emp.Des_ID
                                                                        LEFT JOIN
                                                                    tbl_departments dep ON dep.Dep_id = Emp.Dep_id
                                                                    WHERE
                                                                    sal_ad.Is_pending = 1 {$filter}
                                                                     ");

        // echo $filter;


        $this->load->view('Payroll/Salary_Advance/search_data', $data);
    }

    /*
     * Approve salary advance request
     */

    public function approve($ID) {

        $currentUser = $this->session->userdata('login_user');
        $Emp = $currentUser[0]->EmpNo;

        $data = array(
            'Is_pending' => 0,
            'Is_Approve' => 1,
            'Approved_by' => $Emp,
        );

        $whereArr = array("id" => $ID);
        $result = $this->Db_model->updateData("tbl_salary_advance", $data, $whereArr);

        // Log_Insert - Start

        // Get the last inserted ID
        // $insert_id = $this->Db_model->getfilteredData("SELECT `M_ID` FROM tbl_manual_entry WHERE `Att_Date`='".$att_date."' AND `Enroll_No`='".$EnrollNo."'");//change action
        // $M_ID = $insert_id[0]->M_ID;//change action

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
        
        $system_page_name = "Payroll - Approve Salary Advance";//change action
        $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");

        $dataArray = array(
            'log_user_id' => $Emp,
            'ip_address' => $ip,
            'system_action' => 'Salary Advance is Approved. Its ID is '.$ID.'',//change action
            'trans_time' => $current_time,
            'system_page' => $spnID[0]->id 
        );

        $this->Db_model->insertData("tbl_audit_log_all", $dataArray);
        // Log_Insert - End


        $this->session->set_flashdata('success_message', 'Salary Advance Approved successfully');
        redirect(base_url() . "Pay/Salary_Advance/index");
    }

    /*
     * Reject salary advance request
     */

    public function reject($ID) {


        $currentUser = $this->session->userdata('login_user');
        $Emp = $currentUser[0]->EmpNo;

        $data = array(
            'Is_pending' => 0,
            'Is_Approve' => 0,
            'Is_Cancel' => 1,
            'Approved_by' => $Emp,
        );

        $whereArr = array("id" => $ID);
        $result = $this->Db_model->updateData("tbl_salary_advance", $data, $whereArr);

        // Log_Insert - Start

        // Get the last inserted ID
        // $insert_id = $this->Db_model->getfilteredData("SELECT `M_ID` FROM tbl_manual_entry WHERE `Att_Date`='".$att_date."' AND `Enroll_No`='".$EnrollNo."'");//change action
        // $M_ID = $insert_id[0]->M_ID;//change action

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
        
        $system_page_name = "Payroll - Approve Salary Advance";//change action
        $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");

        $dataArray = array(
            'log_user_id' => $Emp,
            'ip_address' => $ip,
            'system_action' => 'Salary Advance is Rejected. Its ID is '.$ID.'',//change action
            'trans_time' => $current_time,
            'system_page' => $spnID[0]->id 
        );

        $this->Db_model->insertData("tbl_audit_log_all", $dataArray);
        // Log_Insert - End

        $this->session->set_flashdata('success_message', 'Salary Advance Reject successfully');
        redirect(base_url() . "Pay/Salary_Advance/index");
    }

    public function delete($ID) {

        // echo $ID;

        $table = "tbl_salary_advance";
        $where = 'id';
        $this->Db_model->delete_by_id($ID, $where, $table);

        // Log_Insert - Start

        // Get the last inserted ID
        // $insert_id = $this->Db_model->getfilteredData("SELECT `M_ID` FROM tbl_manual_entry WHERE `Att_Date`='".$att_date."' AND `Enroll_No`='".$EnrollNo."'");//change action
        // $M_ID = $insert_id[0]->M_ID;//change action

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
        
        $system_page_name = "Payroll - Approve Salary Advance";//change action
        $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");

        $dataArray = array(
            'log_user_id' => $Emp,
            'ip_address' => $ip,
            'system_action' => 'Salary Advance is Deleted. Its ID is '.$ID.'',//change action
            'trans_time' => $current_time,
            'system_page' => $spnID[0]->id 
        );

        $this->Db_model->insertData("tbl_audit_log_all", $dataArray);
        // Log_Insert - End
        // echo json_encode(array("status" => TRUE));

        // $currentUser = $this->session->userdata('login_user');
        // $Emp = $currentUser[0]->EmpNo;

        // $data = array(
        //     'Is_pending' => 0,
        //     'Is_Approve' => 0,
        //     'Is_Cancel' => 1,
        //     'Approved_by' => $Emp,
        // );

        // $whereArr = array("id" => $ID);
        // $result = $this->Db_model->updateData("tbl_salary_advance", $data, $whereArr);

        $this->session->set_flashdata('success_message', 'Delete successfully');
        redirect(base_url() . "Pay/Salary_Advance/index");
    }

}
