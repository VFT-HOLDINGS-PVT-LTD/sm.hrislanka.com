<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DB_Backup extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!($this->session->userdata('login_user'))) {
            redirect(base_url() . "");
        }

        $this->load->model('Db_model', '', TRUE);
        $this->load->dbutil();
    }

    public function index() {

        $this->load->helper('url');
        $data['title'] = 'Database Backup | HRM System';
        $data['data_array'] = $this->Db_model->getData('Bnk_ID,bank_name', 'tbl_banks');

        $this->load->view('Tools/DB_Backup/index', $data);
    }

    /*
     * Database backup
     */

    public function db_backup() {

       
        /*
         * Download database sql file type and sql file name
         */
        date_default_timezone_set('Asia/Colombo');
        $prefs = array(
            'format' => 'zip',
            'filename' => 'HRM_System' . date("Y-m-d-H-i-s") . '.sql'
        );
        $zipPassword = 'a';

        $backup = $this->dbutil->backup($prefs);

        /*
         * Download database file name in Zip file format
         */

        $db_name = 'HRM_System_' . date("Y-m-d-H-i-s") . '.zip';


        $this->load->helper('download');
        force_download($db_name, $backup);
    }

}
