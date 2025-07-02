<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Terms_and_Conditions extends CI_Controller
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
        $this->load->model('Db_model', '', TRUE);
    }

    /*
     * Index page
     */

    public function index()
    {

        $data['title'] = "Software Terms and Conditions | HRM System";
        // $data['data_set'] = $this->Db_model->getData('RosterCode,RosterName,MonthType,CurrentYear,Data', 'tbl_rosterpatternweeklyhd');

        $this->load->view('Terms_and_Conditions/index', $data);
    }

   
}
