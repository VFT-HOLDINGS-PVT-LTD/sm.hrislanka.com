<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();

        /*
         * Load Database model
         */
        $this->load->model('db_model', '', TRUE);
    }

    public function index() {
        $data['title'] = "Login To System";
        $data['logo'] = $this->db_model->getData('Cmp_ID,company_Name,comp_Address,comp_Tel,comp_logo', 'tbl_companyprofile');
        $this->load->view('login/login', $data);
    }

    /*
     * User Verification
     */

    public function checkUser() {
        // **** Getting user name and password entering by user
        $username = $this->input->post('txt_username');
        $password = sha512($this->input->post('txtpassword'));

        // **** Getting All Details reguarding to the user  
        $user = $this->Generic_model->getData("tbl_user", '', array("username" => $username, "password" => $password, "status" => '0'));
        $employee = $this->Generic_model->getData("tbl_employee", '', array("emp_id" => $user[0]->u_id));
        $user_level = $this->Generic_model->getData("tbl_access_level", array('ac_level'), array("ac_id" => $user[0]->user_level));

        date_default_timezone_set('Asia/Colombo');
        $date = date('Y-M-d   h:i:s a', time());
        //Creating Session array
        $user_data = array(
            "user_id" => $user[0]->u_id,
            "user_name" => $user[0]->username,
            "employee_name" => $employee[0]->emp_name,
            "employee_number" => $employee[0]->emp_no,
            'is_logged' => TRUE,
            "user_level" => $user_level[0]->ac_level,
            "log_time" => $date
        );
        $this->session->set_userdata($user_data);

        // **** If user name and password is in the database directing to the dash board ****
        if (count($user) > 0) {
            header("location:" . base_url() . "Dashboard/index");
        }
        // **** If user name and password is not in the database directing to the Login with error ****
        else {
            header("location:" . base_url() . "login/index?err=1");
        }
    }

    /*
     * User login verification
     */

    public function verifyUser() {

        /*
         * Get Username and Password from data
         */

        date_default_timezone_set('Asia/Colombo');
        $date = date_create();
        $timestamp = date_format($date, 'Y-m-d H:i:s');


        $username = $this->input->post('txt_username', TRUE);
        $password = $this->input->post('txt_password', TRUE);


        $fieldset = array('username', 'Emp_Full_Name', 'user_p_id', 'B_id');
        $whereArr = array("username" => $username, "password" => hash('sha512', $password), "Is_allow_login" => 1);

        $result = $this->db_model->verification($fieldset, 'tbl_empmaster', $whereArr);

        // Function to get the client IP address
        function get_client_ip() {
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

        //*** Get Ip Address
        $ip = get_client_ip();


        $dataArray = array(
            'log_user' => $username,
            'ip_address' => $ip,
            'trans_tine' => $timestamp,
            'action' => 'Login to System'
        );

        $this->db_model->insertData("tbl_audit_log", $dataArray);

        if ($result == "success") {
            echo 1;
        } else {
            echo 0;
        }
    }

    function get_client_ip() {
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

    /*
     * System logout
     */

    public function logout() {

        if (!($this->session->userdata('login_user'))) {
            redirect(base_url() . "");
        }

        date_default_timezone_set('Asia/Colombo');
        $date = date_create();
        $timestamp = date_format($date, 'Y-m-d H:i:s');

        $currentUser = $this->session->userdata('login_user');
        $User = $currentUser[0]->username;

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

        //*** Get Ip Address
        $ip = get_client_ips();


        $dataArray = array(
            'log_user' => $User,
            'ip_address' => $ip,
            'trans_tine' => $timestamp,
            'action' => 'Logout in System'
        );

        $this->db_model->insertData("tbl_audit_log", $dataArray);


        $this->session->sess_destroy();
        redirect(base_url() . "");
    }

}
