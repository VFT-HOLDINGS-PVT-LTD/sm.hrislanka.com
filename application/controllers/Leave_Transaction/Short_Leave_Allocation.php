<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Short_Leave_Allocation extends CI_Controller {

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

        
        $data['title'] = "Short Leave Allocation | HRM System";
        $data['data_roster'] = $this->Db_model->getData('RosterCode,RosterName', 'tbl_rosterpatternweeklyhd');
        
        $this->load->view('Leave_Transaction/Short_Leave_Allocation/index', $data);
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
        // if ($cat == "Employee") {
        //     $cat2 = $this->input->post('cmb_cat2');
        //     $string = "SELECT EmpNo FROM tbl_empmaster WHERE EmpNo='$cat2' and Status = 1";
        //     $EmpData = $this->Db_model->getfilteredData($string);
        // }

        // if ($cat == "Department") {
        //     $cat2 = $this->input->post('cmb_cat2');
        //     $string = "SELECT EmpNo FROM tbl_empmaster WHERE Dep_ID='$cat2' and Status = 1";
        //     $EmpData = $this->Db_model->getfilteredData($string);
        // }

        // if ($cat == "Designation") {
        //     $cat2 = $this->input->post('cmb_cat2');
        //     $string = "SELECT EmpNo FROM tbl_empmaster WHERE Des_ID='$cat2' and Status = 1";
        //     $EmpData = $this->Db_model->getfilteredData($string);
        // }
        // if ($cat == "Employee_Group") {
        //     $cat2 = $this->input->post('cmb_cat2');
        //     $string = "SELECT EmpNo FROM tbl_empmaster WHERE Grp_ID='$cat2' and Status = 1";
        //     $EmpData = $this->Db_model->getfilteredData($string);
        // }

        // if ($cat == "Company") {
        //     $cat2 = $this->input->post('cmb_cat2');
        //     $string = "SELECT EmpNo FROM tbl_empmaster WHERE Cmp_ID='$cat2' and Status = 1";
        //     $EmpData = $this->Db_model->getfilteredData($string);
        // }

        // $leave_type = $this->input->post('cmb_leave_type');
        $year = $this->input->post('cmb_year');
        $entitle = $this->input->post('txt_entitle');
        $roster_id = $this->input->post('cmb_roster');
        date_default_timezone_set('Asia/Colombo');
        $date = date_create();
        $timestamp = date_format($date, 'Y-m-d H:i:s');

        // $Emp = $EmpData[0]->EmpNo;

        $rusult = $this->Db_model->getfilteredData("select count(ID) as IsAllcate from tbl_Short_leave_allocation WHERE Year = '$year' AND `Roster_id`='$roster_id' ");



        if ($rusult[0]->IsAllcate == 1) {
//            echo 'Already Allocated';
            $this->session->set_flashdata('error_message', 'Leave Already Allocated');
            redirect('/Leave_Transaction/Leave_Allocation/');
        } else {
            $data = array(
                        array(
                            'Entitle' => $entitle,
                            'Roster_id'=>$roster_id,
                            'Year' => $year,
                            'Trans_time' => $timestamp,
                    ));
            // $Count = count($EmpData);

            // for ($i = 0; $i < $Count; $i++) {
            //     $data = array(
            //         array(
            //             'EmpNo' => $EmpData[$i]->EmpNo,
            //             'Lv_T_ID' => $leave_type,
            //             'Entitle' => $entitle,
            //             'Balance' => $entitle,
            //             'Year' => $year,
            //             'Trans_time' => $timestamp,
            //     ));

            //     $this->db->insert_batch('tbl_leave_allocation', $data);
            // }
            $this->db->insert_batch('tbl_short_leave_allocation', $data);
            $this->session->set_flashdata('success_message', 'Leave Allocated successfully');

            redirect(base_url() . 'Leave_Transaction/Short_Leave_Allocation');
        }
    }

}
