<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_Allocation extends CI_Controller {

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

        $data['title'] = "Leave Allocation | HRM System";
        $data['data_set'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $data['data_leave'] = $this->Db_model->getData('Lv_T_ID,leave_name,leave_entitle', 'tbl_leave_types');
        $this->load->view('Leave_Transaction/Leave_Allocation/index', $data);
    }

    /*
     * Get data
     */

    public function get_details() {
        $ShiftCode = $this->input->post('ShiftCode');

        $whereArray = array('ShiftCode' => $ShiftCode);

        $this->Db_model->setWhere($whereArray);
        $dataObject = $this->Db_model->getData('ShiftCode,ShiftName,FromTime,ToTime,ShiftGap', 'tbl_shifts');

        $array = (array) $dataObject;
        echo json_encode($array);
    }

    /*
     * Edit Data
     */

    public function edit() {
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

    public function ajax_delete($id) {
        $table = "tbl_shifts";
        $where = 'ShiftCode';
        $this->Db_model->delete_by_id($id, $where, $table);
        echo json_encode(array("status" => TRUE));
    }

    /*
     * Dependent Dropdown
     */

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

        $cat = $this->input->post('cmb_cat');
        if ($cat == "Employee") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE EmpNo='$cat2' and Status = 1";
            $EmpData = $this->Db_model->getfilteredData($string);
        }

        if ($cat == "Department") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE Dep_ID='$cat2' and Status = 1";
            $EmpData = $this->Db_model->getfilteredData($string);
        }

        if ($cat == "Designation") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE Des_ID='$cat2' and Status = 1";
            $EmpData = $this->Db_model->getfilteredData($string);
        }
        if ($cat == "Employee_Group") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE Grp_ID='$cat2' and Status = 1";
            $EmpData = $this->Db_model->getfilteredData($string);
        }

        if ($cat == "Company") {
            $cat2 = $this->input->post('cmb_cat2');
            $string = "SELECT EmpNo FROM tbl_empmaster WHERE Cmp_ID='$cat2' and Status = 1";
            $EmpData = $this->Db_model->getfilteredData($string);
        }

        $leave_type = $this->input->post('cmb_leave_type');
        $year = $this->input->post('cmb_year');
        $entitle = $this->input->post('txt_entitle');
        date_default_timezone_set('Asia/Colombo');
        $date = date_create();
        $timestamp = date_format($date, 'Y-m-d H:i:s');

        $Emp = $EmpData[0]->EmpNo;

        $rusult = $this->Db_model->getfilteredData("select count(EmpNo) as IsAllcate from tbl_leave_allocation where EmpNo = '$Emp' and Year = '$year' and Lv_T_ID = '$leave_type' ");



        if ($rusult[0]->IsAllcate == 1) {
//            echo 'Already Allocated';
            $this->session->set_flashdata('error_message', 'Leave Already Allocated');
            redirect('/Leave_Transaction/Leave_Allocation/');
        } else {
            $Count = count($EmpData);

            for ($i = 0; $i < $Count; $i++) {
                $data = array(
                    array(
                        'EmpNo' => $EmpData[$i]->EmpNo,
                        'Lv_T_ID' => $leave_type,
                        'Entitle' => $entitle,
                        'Balance' => $entitle,
                        'Year' => $year,
                        'Trans_time' => $timestamp,
                ));

                $this->db->insert_batch('tbl_leave_allocation', $data);
            }
            // Log_Insert - Start
            $Category = $this->input->post('cmb_cat');
            $Selected_Category = $this->input->post('cmb_cat2');

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
            
            $system_page_name = "Leave_Transaction - Leave Allocation";//change action
            $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");

            $dataArray = array(
                'log_user_id' => $Emp,
                'ip_address' => $ip,
                'system_action' => 'A Leave allocation has been added. Its have these '.$Category.','.$Selected_Category.','.$leave_type.','.$year.','.$entitle.' details',//change action
                'trans_time' => $current_time,
                'system_page' => $spnID[0]->id 
            );

            $this->Db_model->insertData("tbl_audit_log_all", $dataArray);
            // Log_Insert - End

            $this->session->set_flashdata('success_message', 'Leave Allocated successfully');

            redirect(base_url() . 'Leave_Transaction/Leave_Allocation');
        }
    }

}
