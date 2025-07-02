<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!($this->session->userdata('login_user'))) {
            redirect(base_url() . "");
        }
        $this->load->model('Db_model', '', TRUE);
    }

    public function index() {
        
        date_default_timezone_set('Asia/Colombo');
        $now = new DateTime();
        $Date = $now->format('Y-m-d'); 
        $month_day = $now->format('m-d');

        $data['title'] = "Dashboard | HRM System";
        $data['count'] = $this->Db_model->getfilteredData('select count(EmpNo) as count_emp from tbl_empmaster WHERE tbl_empmaster.EmpNo != "00009000" AND tbl_empmaster.EmpNo != "000000009999"');
        $data['Bdays'] = $this->Db_model->getfilteredData("SELECT Emp_Full_Name, Tel_mobile, tbl_branches.B_name FROM tbl_empmaster INNER JOIN tbl_branches ON tbl_branches.B_id = tbl_empmaster.B_id WHERE DATE_FORMAT(DOB, '%m-%d') = '$month_day'");


        //**** Employee department chart data
        $data['sdata'] = $this->Db_model->getfilteredData("SELECT 
                                                            COUNT(EmpNo)as EmpCount , Dep_Name
                                                        FROM
                                                            tbl_empmaster
                                                                INNER JOIN
                                                            tbl_departments ON tbl_empmaster.Dep_ID = tbl_departments.Dep_ID
                                                        group by tbl_departments.Dep_ID");
        
        $data['sdata_gender'] = $this->Db_model->getfilteredData("SELECT
            COUNT(*) AS total_count,
    COUNT(CASE WHEN Gender = 'Male' THEN 1 END) AS male_count,
    COUNT(CASE WHEN Gender = 'Female' THEN 1 END) AS female_count
FROM
    tbl_empmaster where Status=1");
        
     

        //**** Employee day present (PR) count
        $data['today_c'] = $this->Db_model->getfilteredData("select count(ID_Roster) as TodayCount from tbl_individual_roster where FDate = curdate() and DayStatus='PR' ");



        $currentUser = $this->session->userdata('login_user');
        $Emp = $currentUser[0]->EmpNo;

        $data['data_leave'] = $this->Db_model->getfilteredData("SELECT 
                                                                        lv_typ.Lv_T_ID,
                                                                        lv_typ.leave_name,
                                                                        lv_al.Balance
                                                                    FROM
                                                                        tbl_leave_allocation lv_al
                                                                        right join
                                                                        tbl_leave_types lv_typ on lv_al.Lv_T_ID = lv_typ.Lv_T_ID
                                                                        where EmpNo='$Emp'
                                                                    ");
        
//        var_dump($data['data_leave'] );die;



        $this->load->view('Dashboard/index', $data);
    }

}
