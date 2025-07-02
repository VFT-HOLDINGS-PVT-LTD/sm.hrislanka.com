<?php

/* -------ASHAN RATHSARA---------
 * 
 * Database model
 */

class db_model extends CI_Model {
    /*
     * Insert data
     */

    public function insertData($table, $data) {

        try {
            $this->db->trans_start();
            $result = $this->db->insert($table, $data);
            $this->db->trans_complete();
            return $result;
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $error;
        }
    }

    /*
     * Update Data
     */

    public function updateData($tableName, $dataArray, $whereArray) {

        $this->db->where($whereArray);
        $result = $this->db->update($tableName, $dataArray);
        return $result;
    }

    public function getUpdateData($query) {
        // This will allow you to run a raw SQL query
        $result = $this->db->query($query);
        return $result;
    }

    /*
     * Get Data
     */

    public function getData($fieldset, $tableName) {

        $this->db->select($fieldset)->from($tableName);
        $query = $this->db->get();
        return $query->result();
    }

    /*
     * Get Data Advance
     */

    function getData2($tablename = '', $columns_arr = array(), $where_arr = array(), $limit = 0, $offset = 0, $orderby = array()) {
        $limit = ($limit == 0) ? Null : $limit;

        if (!empty($columns_arr)) {
            $this->db->select(implode(',', $columns_arr), FALSE);
        }

        if ($tablename == '') {
            return array();
        } else {
            $this->db->from($tablename);

            if (!empty($where_arr)) {
                $this->db->where($where_arr);
            }

            if ($limit > 0 AND $offset > 0) {
                $this->db->limit($limit, $offset);
            } elseif ($limit > 0 AND $offset == 0) {
                $this->db->limit($limit);
            }

            if (count($orderby) > 0) {
                $orderbyString = '';

                foreach ($orderby as $orderclause) {

                    $orderbyString .= $orderclause["field"] . ' ' . $orderclause["order"] . ', ';
                }
                if (strlen($orderbyString) > 2) {
                    $orderbyString = substr($orderbyString, 0, strlen($orderbyString) - 2);
                }
                $this->db->order_by($orderbyString);
            }

            $query = $this->db->get();


            return $query->result();
        }
    }

    /*
     * Get Number of Rows
     */

    public function get_num_rows($strSQL) {

        $query = $this->db->query($strSQL);
        return $query->num_rows();
    }

    /*
     * Get SQL Quary Filter Data
     */

    public function getfilteredData($strSQL) {

        $query = $this->db->query($strSQL);
        return $query->result();
    }

    /*
     * Get SQL Quary Delete
     */

    public function getfilteredDelete($strSQL) {

        $query = $this->db->query($strSQL);
    }

    /*
     * Delete By
     */

    public function delete_by_id($id, $where, $table) {

        $this->db->where($where, $id);
        $this->db->delete($table);
    }

    public function setWhere($whereArray) {

        $this->db->where($whereArray);
    }

    public function get_dropdown() {

        $query = "select EmpNo,Emp_Full_Name from tbl_empmaster where status =1 AND tbl_empmaster.EmpNo != '000000009999'";
        $city_info = $this->db->query($query);
        return $city_info;
    }

    public function get_dropdown_dep() {

        $query = "select Dep_ID,Dep_Name from tbl_departments";
        $city_info = $this->db->query($query);
        return $city_info;
    }

    public function get_dropdown_des() {

        $query = "select Des_ID,Desig_Name from tbl_designations";
        $city_info = $this->db->query($query);
        return $city_info;
    }

    public function get_dropdown_group() {

        $query = "select Grp_ID,EmpGroupName from tbl_emp_group";
        $city_info = $this->db->query($query);
        return $city_info;
    }

    public function get_dropdown_comp() {

        $query = "select Cmp_ID,Company_Name from tbl_companyprofile";
        $city_info = $this->db->query($query);
        return $city_info;
    }

    public function verification($fieldset, $tableName, $where = '') {
        /*
         * Get Date time
         */
        date_default_timezone_set('Asia/Colombo');
        $date = date('Y-M-d   h:i:s a', time());

        $username = $where['username'];
        $password = $where['password'];

        /*
         * Select Table Data
         */
        $this->db->select($fieldset)->from($tableName)->where($where);
        $data = $this->db->get();



        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {

                /*
                 * Set data to Session
                 */
//                $data = $this->getfilteredData("select * from tbl_empmaster
//                Where username='$username' and password='$password' and Is_allow_login=1");


                $query = ("SELECT 
                                    tbl_empmaster.EmpNo,
                                    tbl_empmaster.Emp_Full_Name,
                                    tbl_empmaster.username,
                                    tbl_empmaster.Image,
                                    tbl_user_permisions.Dashboard,
                                    tbl_user_permisions.master_data,
                                    tbl_user_permisions.designation,
                                    tbl_user_permisions.department,
                                    tbl_user_permisions.holiday_types,
                                    tbl_user_permisions.holidays,
                                    tbl_user_permisions.shifts,
                                    tbl_user_permisions.weekly_roster,
                                    tbl_user_permisions.user_level,
                                    tbl_user_permisions.leave_types,
                                    tbl_user_permisions.banks,
                                    tbl_user_permisions.bank_accounts,
                                    tbl_user_permisions.payees,
                                    tbl_user_permisions.loan_types,
                                    tbl_user_permisions.allowance_types,
                                    tbl_user_permisions.deduction_types,
                                    tbl_user_permisions.branches,
                                    tbl_user_permisions.employee_groups,
                                    tbl_user_permisions.Employee_mgt,
                                    tbl_user_permisions.add_employee,
                                    tbl_user_permisions.view_employee,
                                    tbl_user_permisions.add_employee_branch,
                                    tbl_user_permisions.Attendance,
                                    tbl_user_permisions.shift_allocation,
                                    tbl_user_permisions.attendance_collection,
                                    tbl_user_permisions.attendance_row_data,
                                    tbl_user_permisions.manual_attendance,
                                    tbl_user_permisions.manual_att_request,
                                     tbl_user_permisions.Is_manual_Sup,
                                     tbl_user_permisions.Is_manual_Admin,
                                    tbl_user_permisions.attendance_process,
                                    tbl_user_permisions.Leave_Transaction,
                                    tbl_user_permisions.view_lv_balance,
                                    tbl_user_permisions.header_lv_nt,
                                    tbl_user_permisions.leave_allocation,
                                    tbl_user_permisions.leave_approve,
                                    tbl_user_permisions.leave_entry,
                                    tbl_user_permisions.leave_request,
                                    tbl_user_permisions.leave_adj,
                                    tbl_user_permisions.Payroll,
                                    tbl_user_permisions.allowance,
                                    tbl_user_permisions.deduction,
                                    tbl_user_permisions.loan_entry,
                                    tbl_user_permisions.salary_increment,
                                    tbl_user_permisions.salary_advance,
                                    tbl_user_permisions.request_advance,
                                    tbl_user_permisions.approve_advance,
                                    tbl_user_permisions.payroll_process,
                                    tbl_user_permisions.Cheque,
                                    tbl_user_permisions.write_cheque,
                                    tbl_user_permisions.view_cheque,
                                    tbl_user_permisions.Messages,
                                    tbl_user_permisions.send_message,
                                    tbl_user_permisions.view_message,
                                    tbl_user_permisions.company,
                                    tbl_user_permisions.company_profile,
                                    tbl_user_permisions.Reports,
                                    tbl_user_permisions.Master_Reports,
                                    tbl_user_permisions.employee_report,
                                    tbl_user_permisions.designation_report,
                                    tbl_user_permisions.department_report,
                                    tbl_user_permisions.holidays_report,
                                    tbl_user_permisions.employee_birthdays,
                                    tbl_user_permisions.Attendance_Report,
                                    tbl_user_permisions.in_out_report,
                                    tbl_user_permisions.overtime_report,
                                    tbl_user_permisions.absence_report,
                                    tbl_user_permisions.leave_report,
                                    tbl_user_permisions.late_report,
                                    tbl_user_permisions.monthly_summery_report,
                                    tbl_user_permisions.leave_summery_report,
                                    tbl_user_permisions.ot_summery_report,
                                    tbl_user_permisions.Payroll_reports,
                                    tbl_user_permisions.allowance_report,
                                    tbl_user_permisions.deduction_report,
                                    tbl_user_permisions.salary_advance_report,
                                    tbl_user_permisions.paysheet_report,
                                    tbl_user_permisions.payslip_report,
                                    tbl_user_permisions.Analysis_Report,
                                    tbl_user_permisions.month_absence_rpt,
                                    tbl_user_permisions.attendance_rpt,
                                    tbl_user_permisions.leave_rpt,
                                    tbl_user_permisions.Tools,
                                    tbl_user_permisions.System_backup,
                                    
                                    tbl_user_permisions.dsh_report,
                                    tbl_user_permisions.dsh_ch_1,
                                    tbl_user_permisions.dsh_ch_2,
                                    tbl_user_permisions.dsh_ch_3,
                                    tbl_user_permisions.dsh_rpt_in_out,
                                    tbl_user_permisions.dsh_rpt_paysheet,
                                    tbl_user_permisions.dsh_rpt_leave,
                                    tbl_user_permisions.dsh_rpt_emp_master,
                                    tbl_user_permisions.dsh_rpt_sal_advance,
                                    tbl_user_permisions.dsh_rpt__absence
                                FROM
                                    tbl_user_permisions as tbl_user_permisions
                                        inner JOIN
                                    tbl_empmaster ON tbl_user_permisions.user_p_id = tbl_empmaster.user_p_id
                                    where username='$username' and password='$password' and Is_allow_login=1
                                ");

                $data = $this->getfilteredData($query);

                $this->session->set_userdata('login_user', $data);

                return "success";
            }
        } else {
            return "invalid";
        }
    }

    function get_auto_cus_name($q) {
        $this->db->select('*');
        $this->db->like('Emp_Full_Name', $q);
        $query = $this->db->get('tbl_empmaster');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['Emp_Full_Name']));
                $new_row['aa'] = htmlentities(stripslashes($row['Emp_Full_Name']));
                $new_row['value'] = htmlentities(stripslashes($row['EmpNo']));
                $row_set[] = $new_row; //build an array
            }
//            var_dump($row_set);die;
            echo json_encode($row_set); //format the array into json data
        }
    }

    // function get_auto_emp_name($q) {
    //     $this->db->select('*');
    //     $this->db->like('Emp_Full_Name', $q);
    //     $query = $this->db->get('tbl_empmaster');
    //     if ($query->num_rows() > 0) {
    //         foreach ($query->result_array() as $row) {
    //             $new_row['label'] = htmlentities(stripslashes($row['Emp_Full_Name']));
    //             $new_row['value'] = htmlentities(stripslashes($row['Emp_Full_Name']));
    //             $row_set[] = $new_row; //build an array
    //         }
    //         echo json_encode($row_set); //format the array into json data
    //     }
    // }
    
    function get_auto_emp_name($q) {
    $this->db->select('*');
    $this->db->like('Emp_Full_Name', $q);
    
    // Adding the WHERE conditions
    $this->db->where('Status', '1'); // Adjust the column name and value as needed
    $this->db->where('Emp_Full_Name !=', 'admin2'); // Adding condition to exclude 'admin2'
    
    $query = $this->db->get('tbl_empmaster');
    
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['Emp_Full_Name']));
                $new_row['value'] = htmlentities(stripslashes($row['Emp_Full_Name']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
    }


    // function get_auto_emp_no($q) {
    //     $this->db->select('*');
    //     $this->db->like('EmpNo', $q);
    //     $query = $this->db->get('tbl_empmaster');
    //     if ($query->num_rows() > 0) {
    //         foreach ($query->result_array() as $row) {
    //             $new_row['label'] = htmlentities(stripslashes($row['EmpNo']));
    //             $new_row['value'] = htmlentities(stripslashes($row['EmpNo']));
    //             $row_set[] = $new_row; //build an array
    //         }
    //         echo json_encode($row_set); //format the array into json data
    //     }
    // }
    
    function get_auto_emp_no($q) {
    $this->db->select('*');
    $this->db->like('EmpNo', $q);
    
    // Adding the WHERE conditions
    $this->db->where('Status', '1'); // Adjust the column name and value as needed
    $this->db->where('EmpNo !=', '000000009999'); // Adding condition to exclude EmpNo '00009000'
    
    $query = $this->db->get('tbl_empmaster');
    
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['EmpNo']));
                $new_row['value'] = htmlentities(stripslashes($row['EmpNo']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
    }


    public function get_emp_info() {
        $name = $this->input->post("txt_emp_name");
        $query = "select EmpNo from tbl_empmaster where Emp_Full_Name ='$name' ";
        $info = $this->db->query($query);
        return $info;
    }

    public function get_bank_info() {
        $cmb_bank_id = $this->input->post("cmb_bank");
        $query = "select distinct Acc_no from tbl_accounts where id ='$cmb_bank_id' ";
        $bank_info = $this->db->query($query);
        return $bank_info;
    }

    public function get_chqno_info() {
        $cmb_acc_id = $this->input->post("cmb_acc_no");
        $query = "select distinct lc_no from tbl_cheque_no where id ='$cmb_acc_id' ";
        $bank_info = $this->db->query($query);
        return $bank_info;
    }

}
