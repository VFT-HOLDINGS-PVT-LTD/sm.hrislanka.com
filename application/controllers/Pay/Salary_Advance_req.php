<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Salary_Advance_req extends CI_Controller {

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


        $data['title'] = "Salary Advance Request | HRM SYSTEM";
        $data['data_emp'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $currentUser = $this->session->userdata('login_user');
        $Emp = $currentUser[0]->EmpNo;

        $Basic_sal = $this->Db_model->getfilteredData("select ((60/100)*(Basic_Salary)) as Basic_Allowed from tbl_empmaster where EmpNo=$Emp");

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

    public function insert_data() {

        $Emp = $this->input->post('txt_employee');
        $Request_date = $this->input->post('txt_date');

        $advance = $this->input->post('txt_advance');
        $year = date("Y");
        $month = date("m");

//        var_dump($month);die;

        $Count = count($Emp);

        $SalPrecentage = $this->Db_model->getfilteredData("select (60/100)*(Basic_Salary+Incentive) as totsal from tbl_empmaster where EmpNo=$Emp");

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
                        'Request_Date' => $Request_date,
                        'Year' => $year,
                        'Month' => $month,
                        'Is_pending' => 1,
                ));
                $this->db->insert_batch('tbl_salary_advance', $data);
                $this->session->set_flashdata('success_message', 'New Salary advance added successfully');
            }
        }
        redirect('/Payroll/Salary_Advance_req/index');
    }

}
