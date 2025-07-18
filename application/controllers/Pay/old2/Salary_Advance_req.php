<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Salary_Advance_req extends CI_Controller
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
        $this->load->model('Db_model', '', true);
    }

    /*
     * Index page
     */

    public function index()
    {

        $data['title'] = "Salary Advance Request | HRM SYSTEM";
        $data['data_emp'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $currentUser = $this->session->userdata('login_user');
        $Emp = $currentUser[0]->EmpNo;

        $Basic_sal = $this->Db_model->getfilteredData("select ((60/100)*(Basic_Salary+Incentive)) as Basic_Allowed from tbl_empmaster where EmpNo=$Emp");

        $Basic = $Basic_sal[0]->Basic_Allowed;

        $Salary_advance = $this->Db_model->getfilteredData("select Amount from tbl_salary_advance where EmpNo=$Emp and Month=MONTH(CURDATE())");

        if (empty($Salary_advance[0]->Amount)) {
            $sal_ad = 0;
        } else {
            $sal_ad = $Salary_advance[0]->Amount;
        }

//        var_dump($sal_ad);

        $Allow_ad = ($Basic) - $sal_ad;

//        var_dump($Allow_ad);die;

        $data['sal_advace'] = $Allow_ad;

        $data['Sal_Advance'] = $this->Db_model->getfilteredData("select tbl_empmaster.EmpNo,((60/100)*(tbl_empmaster.Basic_Salary)) as Basic_Allowed,tbl_empmaster.Basic_Salary ,tbl_salary_advance.Amount, tbl_salary_advance.Month  from tbl_empmaster
                                                                inner join
                                                                tbl_salary_advance on tbl_salary_advance.EmpNo = tbl_empmaster.EmpNo
                                                                where tbl_salary_advance.EmpNo = $Emp and tbl_salary_advance.Month=MONTH(CURDATE())");

        $this->load->view('Payroll/Req_Salary_Advance/index', $data);
    }

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

    public function insert_data()
    {

        $Emp = $this->input->post('txt_employee');
        $Request_date = $this->input->post('txt_date');

        $advance = $this->input->post('txt_advance');
        $year = date("Y");
        $month = date("m");

        // echo $Emp;
        // echo "<br/>";
        // echo $Request_date;
        // echo "<br/>";
        // echo $advance;
        // echo "<br/>";

//        var_dump($month);die;
        $string = "SELECT EmpNo FROM tbl_empmaster WHERE EmpNo='$Emp'";
        $EmpData = $this->Db_model->getfilteredData($string);

        $Count = count($EmpData);

        // echo $Count;

        $SalPrecentage = $this->Db_model->getfilteredData("select (60/100)*(Basic_Salary+Incentive) as totsal from tbl_empmaster where EmpNo=$Emp");

        $HasRow = $this->Db_model->getfilteredData("select count(EmpNo) as HasRow from tbl_salary_advance where EmpNo=$Emp and Year=$year and month=$month");

        if ($advance > $SalPrecentage[0]->totsal) {
            // redirect('Payroll/Salary_Advance_req/index');
            $this->session->set_flashdata('error_message', 'Employee cannot apply more than salary precentage (60%)');
            redirect(base_url() . 'Pay/Salary_Advance_req');
        } else {
            if ($HasRow[0]->HasRow > 0) {
                $this->session->set_flashdata('error_message', 'Employee already applied salary advance');
                // $this->load->view('Payroll/Req_Salary_Advance/index');
                echo "Employee already applied salary advance";
            } else {
                for ($i = 0; $i < $Count; $i++) {
                    $data = array(
                        array(
                            'EmpNo' => $Emp,
                            'Amount' => $advance,
                            'Request_Date' => $Request_date,
                            'Year' => $year,
                            'Month' => $month,
                            'Is_pending' => 1,
                        ));
                    $this->db->insert_batch('tbl_salary_advance', $data);
                }
                // redirect('Payroll/Salary_Advance_req/index');
                
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
                    $Emp1 = $currentUser[0]->EmpNo;

                    date_default_timezone_set('Asia/Colombo');
                    $current_time = date('Y-m-d H:i:s');
                    
                    $system_page_name = "Payroll - Request Salary Advance";//change action
                    $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");

                    $dataArray = array(
                        'log_user_id' => $Emp1,
                        'ip_address' => $ip,
                        'system_action' => 'A Request Salary Advance has been added. Its have these '.$Emp.','.$advance.','.$Request_date.' details',//change action
                        'trans_time' => $current_time,
                        'system_page' => $spnID[0]->id 
                    );

                    $this->Db_model->insertData("tbl_audit_log_all", $dataArray);
                    // Log_Insert - End

                $this->session->set_flashdata('success_message', 'New Salary advance added successfully');
                redirect(base_url() . 'Pay/Salary_Advance_req');
                // echo "New Salary advance added successfully";
            }
        }


    }

}
