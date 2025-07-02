<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Payroll_Process extends CI_Controller
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

        $this->load->helper('url');
        $data['title'] = "Payroll Process | HRM SYSTEM";
        $data['data_emp'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $this->load->view('Payroll/Payroll_process/index', $data);
    }

    /*
     * Payroll Process
     */

    public function emp_payroll_process()
    {
        //die;
        date_default_timezone_set('Asia/Colombo');
        $year = date("Y");
        $month = $this->input->post('cmb_month');

        $date = date_create();
        $timestamp = date_format($date, 'Y-m-d H:i:s');


        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("SELECT EmpNo,EMP_ST_ID,Enroll_No,BR1,BR2, EPFNO,Dep_ID,Des_ID,RosterCode, Status  FROM  tbl_empmaster where status=1 and Active_process=1");
        //        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("SELECT EmpNo,Enroll_No, EPFNO,Dep_ID,Des_ID,RosterCode, Status  FROM  tbl_empmaster where EmpNo=3316");
        //For loop for All active employees 
        for ($x = 0; $x < count($dtEmp['EmpData']); $x++) {



            $EmpNo = $dtEmp['EmpData'][$x]->EmpNo;
            $EpfNo = $dtEmp['EmpData'][$x]->EPFNO;
            $Dep_ID = $dtEmp['EmpData'][$x]->Dep_ID;
            $Des_ID = $dtEmp['EmpData'][$x]->Des_ID;
            $br1 = $dtEmp['EmpData'][$x]->BR1;
            $br2 = $dtEmp['EmpData'][$x]->BR2;

            $Emp_ST = $dtEmp['EmpData'][$x]->EMP_ST_ID;


            $HasRow = $this->Db_model->getfilteredData("select count(EmpNo) as HasRow from tbl_salary where EmpNo=$EmpNo and month=$month and year=$year");

            //            var_dump($HasRow);die;
            //IF Salary records have in Salary table update salary records into salary table

            if ($HasRow[0]->HasRow > 0) {

                //            var_dump($dtEmp['EmpData']);die;
                //Get Employee Basic Salary | Incentive
                $SalData = $this->Db_model->getfilteredData("select EmpNo,EPFNO, Is_EPF,Dep_ID, Des_ID,Basic_Salary,Fixed_Allowance,Incentive,is_nopay_calc from tbl_empmaster where EmpNo=$EmpNo");
                $BasicSal = $SalData[0]->Basic_Salary;
                $Incentive = $SalData[0]->Incentive;
                $Fixed_Allowance = $SalData[0]->Fixed_Allowance;
                $Is_EPF = $SalData[0]->Is_EPF;
                $is_no_pay = $SalData[0]->is_nopay_calc;


                //**** Get Nopay days
                $Nopay = $this->Db_model->getfilteredData("select sum(nopay) as nopay, sum(nopay_hrs) nopay_hrs,sum(Att_Allow) as Att_Allow from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and EXTRACT(YEAR FROM FDate)=$year AND ShType = 'DU' ");
                $NopayDays = $Nopay[0]->nopay;

                if ($NopayDays == null) {
                    $NopayDays = 0;
                }

                //**** Calculate no pay amount
                $NopayRate = ($BasicSal + $Incentive) / 22;


                if ($is_no_pay == 1) {
                    $NopayDays = 0;
                }
                
                

                $Nopay_Deduction = $NopayRate * $NopayDays;


                //**** Get Allowance Details
                $budget_relevance = $this->Db_model->getfilteredData("select Br_ID, Amount from tbl_varialble_br where EmpNo=$EmpNo and Month=$month and Year=$year");
                $welfair = $this->Db_model->getfilteredData("select welfair_id, Amount from tbl_variable_welfair where EmpNo=$EmpNo and Month=$month and Year=$year");

                //Get Variable Allowances details
                $Allowances = $this->Db_model->getfilteredData("select Alw_ID, Amount from tbl_varialble_allowance where EmpNo=$EmpNo and Month=$month and Year=$year ORDER BY tbl_varialble_allowance.Alw_ID");
                $FixedAllowances = $this->Db_model->getfilteredData("select Alw_ID, Amount from tbl_fixed_allowance where EmpNo=$EmpNo ORDER BY tbl_fixed_allowance.Alw_ID");
                $Att_Allowance = 0;
                $tbPerformance = 0;
                $tbAttendances = 0;
                $tbFuel = 0;
                $tbTransport = 0;
                $tbTraveling = 0;
                $tbSPAllowance = 0;
                $Allowance_2 = 0;
                $Allowance_3 = 0;
                // $Allowances[0]->Alw_ID = 0;
                // $Allowances[1]->Alw_ID = 0;
                
                
                $welfair_1 = 0;
                if (!empty($welfair)) {
                    $welfair_1 = $welfair[0]->Amount;
                }
                /*
                 * Allowence special types
                 */

                // if (!empty($Allowances[6]->Alw_ID)) {
                //     if ($Allowances[6]->Alw_ID == 1) {
                //         $tbPerformance = $Allowances[6]->Amount;
                //     } else if ($Allowances[6]->Alw_ID == 2) {
                //         $tbAttendances = $Allowances[6]->Amount;
                //     } else if ($Allowances[6]->Alw_ID == 3) {
                //         $tbFuel = $Allowances[6]->Amount;
                //     } else if ($Allowances[6]->Alw_ID == 4) {
                //         $tbTransport = $Allowances[6]->Amount;
                //     } else if ($Allowances[6]->Alw_ID == 5) {
                //         $tbTraveling = $Allowances[6]->Amount;
                //     } else if ($Allowances[6]->Alw_ID == 6) {
                //         $tbSPAllowance = $Allowances[6]->Amount;
                //     } else if ($Allowances[6]->Alw_ID == 7) {
                //         $Allowance_2 = $Allowances[6]->Amount;
                //     } else if ($Allowances[6]->Alw_ID == 8) {
                //         $Allowance_3 = $Allowances[6]->Amount;
                //     }
                // } else if (empty($Allowances[6]->Alw_ID) && !empty($FixedAllowances[6]->Alw_ID)) {
                //     if ($FixedAllowances[6]->Alw_ID == 1) {
                //         $tbPerformance = $FixedAllowances[6]->Amount;
                //     } else if ($FixedAllowances[6]->Alw_ID == 2) {
                //         $tbAttendances = $FixedAllowances[6]->Amount;
                //     } else if ($FixedAllowances[6]->Alw_ID == 3) {
                //         $tbFuel = $FixedAllowances[6]->Amount;
                //     } else if ($FixedAllowances[6]->Alw_ID == 4) {
                //         $tbTransport = $FixedAllowances[6]->Amount;
                //     } else if ($FixedAllowances[6]->Alw_ID == 5) {
                //         $tbTraveling = $FixedAllowances[6]->Amount;
                //     } else if ($FixedAllowances[6]->Alw_ID == 6) {
                //         $tbSPAllowance = $FixedAllowances[6]->Amount;
                //     } else if ($FixedAllowances[6]->Alw_ID == 7) {
                //         $Allowance_2 = $FixedAllowances[6]->Amount;
                //     } else if ($FixedAllowances[6]->Alw_ID == 8) {
                //         $Allowance_3 = $FixedAllowances[6]->Amount;
                //     }
                // }
               
                
                // if (!empty($Allowances[5]->Alw_ID)) {
                //     if ($Allowances[5]->Alw_ID == 1) {
                //         $tbPerformance = $Allowances[5]->Amount;
                //     } else if ($Allowances[5]->Alw_ID == 2) {
                //         $tbAttendances = $Allowances[5]->Amount;
                //     } else if ($Allowances[5]->Alw_ID == 3) {
                //         $tbFuel = $Allowances[5]->Amount;
                //     } else if ($Allowances[5]->Alw_ID == 4) {
                //         $tbTransport = $Allowances[5]->Amount;
                //     } else if ($Allowances[5]->Alw_ID == 5) {
                //         $tbTraveling = $Allowances[5]->Amount;
                //     } else if ($Allowances[5]->Alw_ID == 6) {
                //         $tbSPAllowance = $Allowances[5]->Amount;
                //     } else if ($Allowances[5]->Alw_ID == 7) {
                //         $Allowance_2 = $Allowances[5]->Amount;
                //     } else if ($Allowances[5]->Alw_ID == 8) {
                //         $Allowance_3 = $Allowances[5]->Amount;
                //     }
                // } else if (empty($Allowances[5]->Alw_ID) && !empty($FixedAllowances[5]->Alw_ID)) {
                //     if ($FixedAllowances[5]->Alw_ID == 1) {
                //         $tbPerformance = $FixedAllowances[5]->Amount;
                //     } else if ($FixedAllowances[5]->Alw_ID == 2) {
                //         $tbAttendances = $FixedAllowances[5]->Amount;
                //     } else if ($FixedAllowances[5]->Alw_ID == 3) {
                //         $tbFuel = $FixedAllowances[5]->Amount;
                //     } else if ($FixedAllowances[5]->Alw_ID == 4) {
                //         $tbTransport = $FixedAllowances[5]->Amount;
                //     } else if ($FixedAllowances[5]->Alw_ID == 5) {
                //         $tbTraveling = $FixedAllowances[5]->Amount;
                //     } else if ($FixedAllowances[5]->Alw_ID == 6) {
                //         $tbSPAllowance = $FixedAllowances[5]->Amount;
                //     } else if ($FixedAllowances[5]->Alw_ID == 7) {
                //         $Allowance_2 = $FixedAllowances[5]->Amount;
                //     } else if ($FixedAllowances[5]->Alw_ID == 8) {
                //         $Allowance_3 = $FixedAllowances[5]->Amount;
                //     }
                // }
                // if (!empty($Allowances[4]->Alw_ID)) {
                //     if ($Allowances[4]->Alw_ID == 1) {
                //         $tbPerformance = $Allowances[4]->Amount;
                //     } else if ($Allowances[4]->Alw_ID == 2) {
                //         $tbAttendances = $Allowances[4]->Amount;
                //     } else if ($Allowances[4]->Alw_ID == 3) {
                //         $tbFuel = $Allowances[4]->Amount;
                //     } else if ($Allowances[4]->Alw_ID == 4) {
                //         $tbTransport = $Allowances[4]->Amount;
                //     } else if ($Allowances[4]->Alw_ID == 5) {
                //         $tbTraveling = $Allowances[4]->Amount;
                //     } else if ($Allowances[4]->Alw_ID == 6) {
                //         $tbSPAllowance = $Allowances[4]->Amount;
                //     } else if ($Allowances[4]->Alw_ID == 7) {
                //         $Allowance_2 = $Allowances[4]->Amount;
                //     } else if ($Allowances[4]->Alw_ID == 8) {
                //         $Allowance_3 = $Allowances[4]->Amount;
                //     }
                // } else if (empty($Allowances[4]->Alw_ID) && !empty($FixedAllowances[4]->Alw_ID)) {
                //     if ($FixedAllowances[4]->Alw_ID == 1) {
                //         $tbPerformance = $FixedAllowances[4]->Amount;
                //     } else if ($FixedAllowances[4]->Alw_ID == 2) {
                //         $tbAttendances = $FixedAllowances[4]->Amount;
                //     } else if ($FixedAllowances[4]->Alw_ID == 3) {
                //         $tbFuel = $FixedAllowances[4]->Amount;
                //     } else if ($FixedAllowances[4]->Alw_ID == 4) {
                //         $tbTransport = $FixedAllowances[4]->Amount;
                //     } else if ($FixedAllowances[4]->Alw_ID == 5) {
                //         $tbTraveling = $FixedAllowances[4]->Amount;
                //     } else if ($FixedAllowances[4]->Alw_ID == 6) {
                //         $tbSPAllowance = $FixedAllowances[4]->Amount;
                //     } else if ($FixedAllowances[4]->Alw_ID == 7) {
                //         $Allowance_2 = $FixedAllowances[4]->Amount;
                //     } else if ($FixedAllowances[4]->Alw_ID == 8) {
                //         $Allowance_3 = $FixedAllowances[4]->Amount;
                //     }
                // }
                // if (!empty($Allowances[3]->Alw_ID)) {
                //     if ($Allowances[3]->Alw_ID == 1) {
                //         $tbPerformance = $Allowances[3]->Amount;
                //     } else if ($Allowances[3]->Alw_ID == 2) {
                //         $tbAttendances = $Allowances[3]->Amount;
                //     } else if ($Allowances[3]->Alw_ID == 3) {
                //         $tbFuel = $Allowances[3]->Amount;
                //     } else if ($Allowances[3]->Alw_ID == 4) {
                //         $tbTransport = $Allowances[3]->Amount;
                //     } else if ($Allowances[3]->Alw_ID == 5) {
                //         $tbTraveling = $Allowances[3]->Amount;
                //     } else if ($Allowances[3]->Alw_ID == 6) {
                //         $tbSPAllowance = $Allowances[3]->Amount;
                //     } else if ($Allowances[3]->Alw_ID == 7) {
                //         $Allowance_2 = $Allowances[3]->Amount;
                //     } else if ($Allowances[3]->Alw_ID == 8) {
                //         $Allowance_3 = $Allowances[3]->Amount;
                //     }
                // } else if (empty($Allowances[3]->Alw_ID) && !empty($FixedAllowances[3]->Alw_ID)) {
                //     if ($FixedAllowances[3]->Alw_ID == 1) {
                //         $tbPerformance = $FixedAllowances[3]->Amount;
                //     } else if ($FixedAllowances[3]->Alw_ID == 2) {
                //         $tbAttendances = $FixedAllowances[3]->Amount;
                //     } else if ($FixedAllowances[3]->Alw_ID == 3) {
                //         $tbFuel = $FixedAllowances[3]->Amount;
                //     } else if ($FixedAllowances[3]->Alw_ID == 4) {
                //         $tbTransport = $FixedAllowances[3]->Amount;
                //     } else if ($FixedAllowances[3]->Alw_ID == 5) {
                //         $tbTraveling = $FixedAllowances[3]->Amount;
                //     } else if ($FixedAllowances[3]->Alw_ID == 6) {
                //         $tbSPAllowance = $FixedAllowances[3]->Amount;
                //     } else if ($FixedAllowances[3]->Alw_ID == 7) {
                //         $Allowance_2 = $FixedAllowances[3]->Amount;
                //     } else if ($FixedAllowances[3]->Alw_ID == 8) {
                //         $Allowance_3 = $FixedAllowances[3]->Amount;
                //     }
                // }
                
                // 2
            //     if (
            //     isset($Allowances[2], $FixedAllowances[2]) &&
            //     (($Allowances[2]->Alw_ID == 1 && $FixedAllowances[2]->Alw_ID == 1) ||
            //      ($Allowances[2]->Alw_ID == 2 && $FixedAllowances[2]->Alw_ID == 2) ||
            //      ($Allowances[2]->Alw_ID == 3 && $FixedAllowances[2]->Alw_ID == 3) ||
            //      ($Allowances[2]->Alw_ID == 4 && $FixedAllowances[2]->Alw_ID == 4) ||
            //      ($Allowances[2]->Alw_ID == 5 && $FixedAllowances[2]->Alw_ID == 5) ||
            //      ($Allowances[2]->Alw_ID == 6 && $FixedAllowances[2]->Alw_ID == 6) ||
            //      ($Allowances[2]->Alw_ID == 7 && $FixedAllowances[2]->Alw_ID == 7) ||
            //      ($Allowances[2]->Alw_ID == 8 && $FixedAllowances[2]->Alw_ID == 8))
            // ) {
            //     switch ($Allowances[2]->Alw_ID) {
            //         case 1: $tbPerformance = $Allowances[2]->Amount; break;
            //         case 2: $tbAttendances = $Allowances[2]->Amount; break;
            //         case 3: $tbFuel = $Allowances[2]->Amount; break;
            //         case 4: $tbTransport = $Allowances[2]->Amount; break;
            //         case 5: $tbTraveling = $Allowances[2]->Amount; break;
            //         case 6: $tbSPAllowance = $Allowances[2]->Amount; break;
            //         case 7: $Allowance_2 = $Allowances[2]->Amount; break;
            //         case 8: $Allowance_3 = $Allowances[2]->Amount; break;
            //     }
            // } else {
            //     if (!empty($Allowances[2])) {
            //         switch ($Allowances[2]->Alw_ID) {
            //             case 1: $tbPerformance = $Allowances[2]->Amount; break;
            //             case 2: $tbAttendances = $Allowances[2]->Amount; break;
            //             case 3: $tbFuel = $Allowances[2]->Amount; break;
            //             case 4: $tbTransport = $Allowances[2]->Amount; break;
            //             case 5: $tbTraveling = $Allowances[2]->Amount; break;
            //             case 6: $tbSPAllowance = $Allowances[2]->Amount; break;
            //             case 7: $Allowance_2 = $Allowances[2]->Amount; break;
            //             case 8: $Allowance_3 = $Allowances[2]->Amount; break;
            //         }
            //     }
            //     if (!empty($FixedAllowances[2])) {
            //         switch ($FixedAllowances[2]->Alw_ID) {
            //             case 1: $tbPerformance = $FixedAllowances[2]->Amount; break;
            //             case 2: $tbAttendances = $FixedAllowances[2]->Amount; break;
            //             case 3: $tbFuel = $FixedAllowances[2]->Amount; break;
            //             case 4: $tbTransport = $FixedAllowances[2]->Amount; break;
            //             case 5: $tbTraveling = $FixedAllowances[2]->Amount; break;
            //             case 6: $tbSPAllowance = $FixedAllowances[2]->Amount; break;
            //             case 7: $Allowance_2 = $FixedAllowances[2]->Amount; break;
            //             case 8: $Allowance_3 = $FixedAllowances[2]->Amount; break;
            //         }
            //     }
            // }

                
            //     // 1
            //     if (
            //         isset($Allowances[1], $FixedAllowances[1]) &&
            //         (
            //             ($Allowances[1]->Alw_ID == 1 && $FixedAllowances[1]->Alw_ID == 1) ||
            //             ($Allowances[1]->Alw_ID == 2 && $FixedAllowances[1]->Alw_ID == 2) ||
            //             ($Allowances[1]->Alw_ID == 3 && $FixedAllowances[1]->Alw_ID == 3) ||
            //             ($Allowances[1]->Alw_ID == 4 && $FixedAllowances[1]->Alw_ID == 4) ||
            //             ($Allowances[1]->Alw_ID == 5 && $FixedAllowances[1]->Alw_ID == 5) ||
            //             ($Allowances[1]->Alw_ID == 6 && $FixedAllowances[1]->Alw_ID == 6) ||
            //             ($Allowances[1]->Alw_ID == 7 && $FixedAllowances[1]->Alw_ID == 7) ||
            //             ($Allowances[1]->Alw_ID == 8 && $FixedAllowances[1]->Alw_ID == 8)
            //         )
            //     ) {
            //         // Fix eka witharak ganna
            //         if (!empty($Allowances[1]->Alw_ID)) {
            //             switch ($Allowances[1]->Alw_ID) {
            //                 case 1:
            //                     $tbPerformance = $Allowances[1]->Amount;
            //                     break;
            //                 case 2:
            //                     $tbAttendances = $Allowances[1]->Amount;
            //                     break;
            //                 case 3:
            //                     $tbFuel = $Allowances[1]->Amount;
            //                     break;
            //                 case 4:
            //                     $tbTransport = $Allowances[1]->Amount;
            //                     break;
            //                 case 5:
            //                     $tbTraveling = $Allowances[1]->Amount;
            //                     break;
            //                 case 6:
            //                     $tbSPAllowance = $Allowances[1]->Amount;
            //                     break;
            //                 case 7:
            //                     $Allowance_2 = $Allowances[1]->Amount;
            //                     break;
            //                 case 8:
            //                     $Allowance_3 = $Allowances[1]->Amount;
            //                     break;
            //             }
            //         }
            //     } else {
            //         if (!empty($Allowances[1]->Alw_ID)) {
            //             switch ($Allowances[1]->Alw_ID) {
            //                 case 1:
            //                     $tbPerformance = $Allowances[1]->Amount;
            //                     break;
            //                 case 2:
            //                     $tbAttendances = $Allowances[1]->Amount;
            //                     break;
            //                 case 3:
            //                     $tbFuel = $Allowances[1]->Amount;
            //                     break;
            //                 case 4:
            //                     $tbTransport = $Allowances[1]->Amount;
            //                     break;
            //                 case 5:
            //                     $tbTraveling = $Allowances[1]->Amount;
            //                     break;
            //                 case 6:
            //                     $tbSPAllowance = $Allowances[1]->Amount;
            //                     break;
            //                 case 7:
            //                     $Allowance_2 = $Allowances[1]->Amount;
            //                     break;
            //                 case 8:
            //                     $Allowance_3 = $Allowances[1]->Amount;
            //                     break;
            //             }
            //         }
            //         if (empty($Allowances[1]->Alw_ID) && !empty($FixedAllowances[1]->Alw_ID)) {
            //             switch ($FixedAllowances[1]->Alw_ID) {
            //                 case 1:
            //                     $tbPerformance = $FixedAllowances[1]->Amount;
            //                     break;
            //                 case 2:
            //                     $tbAttendances = $FixedAllowances[1]->Amount;
            //                     break;
            //                 case 3:
            //                     $tbFuel = $FixedAllowances[1]->Amount;
            //                     break;
            //                 case 4:
            //                     $tbTransport = $FixedAllowances[1]->Amount;
            //                     break;
            //                 case 5:
            //                     $tbTraveling = $FixedAllowances[1]->Amount;
            //                     break;
            //                 case 6:
            //                     $tbSPAllowance = $FixedAllowances[1]->Amount;
            //                     break;
            //                 case 7:
            //                     $Allowance_2 = $FixedAllowances[1]->Amount;
            //                     break;
            //                 case 8:
            //                     $Allowance_3 = $FixedAllowances[1]->Amount;
            //                     break;
            //             }
            //         }
            //     }
                
            //     // 0
            //     if (
            //         isset($Allowances[0], $FixedAllowances[0]) &&
            //         (($Allowances[0]->Alw_ID == 1 && $FixedAllowances[0]->Alw_ID == 1) ||
            //          ($Allowances[0]->Alw_ID == 2 && $FixedAllowances[0]->Alw_ID == 2) ||
            //          ($Allowances[0]->Alw_ID == 3 && $FixedAllowances[0]->Alw_ID == 3) ||
            //          ($Allowances[0]->Alw_ID == 4 && $FixedAllowances[0]->Alw_ID == 4) ||
            //          ($Allowances[0]->Alw_ID == 5 && $FixedAllowances[0]->Alw_ID == 5) ||
            //          ($Allowances[0]->Alw_ID == 6 && $FixedAllowances[0]->Alw_ID == 6) ||
            //          ($Allowances[0]->Alw_ID == 7 && $FixedAllowances[0]->Alw_ID == 7) ||
            //          ($Allowances[0]->Alw_ID == 8 && $FixedAllowances[0]->Alw_ID == 8))
            //     ) {
            //         switch ($Allowances[0]->Alw_ID) {
            //             case 1: $tbPerformance = $Allowances[0]->Amount; break;
            //             case 2: $tbAttendances = $Allowances[0]->Amount; break;
            //             case 3: $tbFuel = $Allowances[0]->Amount; break;
            //             case 4: $tbTransport = $Allowances[0]->Amount; break;
            //             case 5: $tbTraveling = $Allowances[0]->Amount; break;
            //             case 6: $tbSPAllowance = $Allowances[0]->Amount; break;
            //             case 7: $Allowance_2 = $Allowances[0]->Amount; break;
            //             case 8: $Allowance_3 = $Allowances[0]->Amount; break;
            //         }
            //     } else {
            //         if (!empty($Allowances[0])) {
            //             switch ($Allowances[0]->Alw_ID) {
            //                 case 1: $tbPerformance = $Allowances[0]->Amount; break;
            //                 case 2: $tbAttendances = $Allowances[0]->Amount; break;
            //                 case 3: $tbFuel = $Allowances[0]->Amount; break;
            //                 case 4: $tbTransport = $Allowances[0]->Amount; break;
            //                 case 5: $tbTraveling = $Allowances[0]->Amount; break;
            //                 case 6: $tbSPAllowance = $Allowances[0]->Amount; break;
            //                 case 7: $Allowance_2 = $Allowances[0]->Amount; break;
            //                 case 8: $Allowance_3 = $Allowances[0]->Amount; break;
            //             }
            //         }
            //         if (!empty($FixedAllowances[0])) {
            //             switch ($FixedAllowances[0]->Alw_ID) {
            //                 case 1: $tbPerformance = $FixedAllowances[0]->Amount; break;
            //                 case 2: $tbAttendances = $FixedAllowances[0]->Amount; break;
            //                 case 3: $tbFuel = $FixedAllowances[0]->Amount; break;
            //                 case 4: $tbTransport = $FixedAllowances[0]->Amount; break;
            //                 case 5: $tbTraveling = $FixedAllowances[0]->Amount; break;
            //                 case 6: $tbSPAllowance = $FixedAllowances[0]->Amount; break;
            //                 case 7: $Allowance_2 = $FixedAllowances[0]->Amount; break;
            //                 case 8: $Allowance_3 = $FixedAllowances[0]->Amount; break;
            //             }
            //         }
            //     }
            
            // Easy code
                $allowanceIndices = range(0, 8); // Indices from 0 to 8

                foreach ($allowanceIndices as $index) {
                    if (
                        isset($Allowances[$index], $FixedAllowances[$index]) &&
                        (($Allowances[$index]->Alw_ID == 1 && $FixedAllowances[$index]->Alw_ID == 1) ||
                         ($Allowances[$index]->Alw_ID == 2 && $FixedAllowances[$index]->Alw_ID == 2) ||
                         ($Allowances[$index]->Alw_ID == 3 && $FixedAllowances[$index]->Alw_ID == 3) ||
                         ($Allowances[$index]->Alw_ID == 4 && $FixedAllowances[$index]->Alw_ID == 4) ||
                         ($Allowances[$index]->Alw_ID == 5 && $FixedAllowances[$index]->Alw_ID == 5) ||
                         ($Allowances[$index]->Alw_ID == 6 && $FixedAllowances[$index]->Alw_ID == 6) ||
                         ($Allowances[$index]->Alw_ID == 7 && $FixedAllowances[$index]->Alw_ID == 7) ||
                         ($Allowances[$index]->Alw_ID == 8 && $FixedAllowances[$index]->Alw_ID == 8))
                    ) {
                        switch ($Allowances[$index]->Alw_ID) {
                            case 1: $tbPerformance = $Allowances[$index]->Amount; break;
                            case 2: $tbAttendances = $Allowances[$index]->Amount; break;
                            case 3: $tbFuel = $Allowances[$index]->Amount; break;
                            case 4: $tbTransport = $Allowances[$index]->Amount; break;
                            case 5: $tbTraveling = $Allowances[$index]->Amount; break;
                            case 6: $tbSPAllowance = $Allowances[$index]->Amount; break;
                            case 7: $Allowance_2 = $Allowances[$index]->Amount; break;
                            case 8: $Allowance_3 = $Allowances[$index]->Amount; break;
                        }
                    } else {
                        if (!empty($Allowances[$index])) {
                            switch ($Allowances[$index]->Alw_ID) {
                                case 1: $tbPerformance = $Allowances[$index]->Amount; break;
                                case 2: $tbAttendances = $Allowances[$index]->Amount; break;
                                case 3: $tbFuel = $Allowances[$index]->Amount; break;
                                case 4: $tbTransport = $Allowances[$index]->Amount; break;
                                case 5: $tbTraveling = $Allowances[$index]->Amount; break;
                                case 6: $tbSPAllowance = $Allowances[$index]->Amount; break;
                                case 7: $Allowance_2 = $Allowances[$index]->Amount; break;
                                case 8: $Allowance_3 = $Allowances[$index]->Amount; break;
                            }
                        }
                        if (!empty($FixedAllowances[$index])) {
                            switch ($FixedAllowances[$index]->Alw_ID) {
                                case 1: $tbPerformance = $FixedAllowances[$index]->Amount; break;
                                case 2: $tbAttendances = $FixedAllowances[$index]->Amount; break;
                                case 3: $tbFuel = $FixedAllowances[$index]->Amount; break;
                                case 4: $tbTransport = $FixedAllowances[$index]->Amount; break;
                                case 5: $tbTraveling = $FixedAllowances[$index]->Amount; break;
                                case 6: $tbSPAllowance = $FixedAllowances[$index]->Amount; break;
                                case 7: $Allowance_2 = $FixedAllowances[$index]->Amount; break;
                                case 8: $Allowance_3 = $FixedAllowances[$index]->Amount; break;
                            }
                        }
                    }
                }
                // Easy code - end

                // uda ewaye therumganna puluwan version eka - start
                 //   0
                // if ($Allowances[0]->Alw_ID == 1 && $FixedAllowances[0]->Alw_ID == 1 || $Allowances[0]->Alw_ID == 2 && $FixedAllowances[0]->Alw_ID == 2 || $Allowances[0]->Alw_ID == 3 && $FixedAllowances[0]->Alw_ID == 3 || $Allowances[0]->Alw_ID == 4 && $FixedAllowances[0]->Alw_ID == 4 || $Allowances[0]->Alw_ID == 5 && $FixedAllowances[0]->Alw_ID == 5 || $Allowances[0]->Alw_ID == 6 && $FixedAllowances[0]->Alw_ID == 6 || $Allowances[0]->Alw_ID == 7 && $FixedAllowances[0]->Alw_ID == 7 || $Allowances[0]->Alw_ID == 8 && $FixedAllowances[0]->Alw_ID == 8) {
                //     // Fix eka witharak ganna
                //     if ($Allowances[0]->Alw_ID == 1) {
                //         $tbPerformance = $Allowances[0]->Amount;
                //     } else if ($Allowances[0]->Alw_ID == 2) {
                //         $tbAttendances = $Allowances[0]->Amount;
                //     } else if ($Allowances[0]->Alw_ID == 3) {
                //         $tbFuel = $Allowances[0]->Amount;
                //     } else if ($Allowances[0]->Alw_ID == 4) {
                //         $tbTransport = $Allowances[0]->Amount;
                //     } else if ($Allowances[0]->Alw_ID == 5) {
                //         $tbTraveling = $Allowances[0]->Amount;
                //     } else if ($Allowances[0]->Alw_ID == 6) {
                //         $tbSPAllowance = $Allowances[0]->Amount;
                //     } else if ($Allowances[0]->Alw_ID == 7) {
                //         $Allowance_2 = $Allowances[0]->Amount;
                //     } else if ($Allowances[0]->Alw_ID == 8) {
                //         $Allowance_3 = $Allowances[0]->Amount;
                //     }
                
                // } else {
                //     if (!empty($Allowances[0]->Alw_ID)) {
                //         if ($Allowances[0]->Alw_ID == 1) {
                //             $tbPerformance = $Allowances[0]->Amount;
                //         } else if ($Allowances[0]->Alw_ID == 2) {
                //             $tbAttendances = $Allowances[0]->Amount;
                //         } else if ($Allowances[0]->Alw_ID == 3) {
                //             $tbFuel = $Allowances[0]->Amount;
                //         } else if ($Allowances[0]->Alw_ID == 4) {
                //             $tbTransport = $Allowances[0]->Amount;
                //         } else if ($Allowances[0]->Alw_ID == 5) {
                //             $tbTraveling = $Allowances[0]->Amount;
                //         } else if ($Allowances[0]->Alw_ID == 6) {
                //             $tbSPAllowance = $Allowances[0]->Amount;
                //         } else if ($Allowances[0]->Alw_ID == 7) {
                //             $Allowance_2 = $Allowances[0]->Amount;
                //         } else if ($Allowances[0]->Alw_ID == 8) {
                //             $Allowance_3 = $Allowances[0]->Amount;
                //         }
                //     }
                //     if (!empty($FixedAllowances[0]->Alw_ID)) {
                //         //   if($Allowances[0]->Alw_ID == 1){
                //         if ($FixedAllowances[0]->Alw_ID == 1) {
                //             $tbPerformance = $FixedAllowances[0]->Amount;
                //         } else if ($FixedAllowances[0]->Alw_ID == 2) {
                //             $tbAttendances = $FixedAllowances[0]->Amount;
                //         } else if ($FixedAllowances[0]->Alw_ID == 3) {
                //             $tbFuel = $FixedAllowances[0]->Amount;
                //         } else if ($FixedAllowances[0]->Alw_ID == 4) {
                //             $tbTransport = $FixedAllowances[0]->Amount;
                //         } else if ($FixedAllowances[0]->Alw_ID == 5) {
                //             $tbTraveling = $FixedAllowances[0]->Amount;
                //         } else if ($FixedAllowances[0]->Alw_ID == 6) {
                //             $tbSPAllowance = $FixedAllowances[0]->Amount;
                //         } else if ($FixedAllowances[0]->Alw_ID == 7) {
                //             $Allowance_2 = $FixedAllowances[0]->Amount;
                //         } else if ($FixedAllowances[0]->Alw_ID == 8) {
                //             $Allowance_3 = $FixedAllowances[0]->Amount;
                //         }
                //     }
                // }
                // uda ewaye therumganna puluwan version eka - end

                
                // Repeat similar checks for index 0 or other indices.

                
                // echo "<br/>";
                // echo "<br/>";
                // echo $Allowances[0]->Alw_ID.'/'.$Allowances[1]->Alw_ID;
                // echo "<br/>";
                // echo $EmpNo . ' '. $month . ' '. $year;
                 

                //Get Variable Deductions details
                $Deductions = $this->Db_model->getfilteredData("select Ded_ID,Amount from tbl_variable_deduction where EmpNo=$EmpNo and Month=$month and Year=$year");
                $FixedDeductions = $this->Db_model->getfilteredData("select Deduction_ID,Amount from tbl_fixed_deduction where EmpNo=$EmpNo ORDER BY tbl_fixed_deduction.Deduction_ID");

                $payee = $this->Db_model->getfilteredData("SELECT * FROM tbl_payee");
                $stamp_Duty = $this->Db_model->getfilteredData("select ID, Amount from tbl_variable_stamp where EmpNo=$EmpNo and Month=$month and Year=$year");
                $fixed_stamp_Duty = $this->Db_model->getfilteredData("select ID, Amount from tbl_variable_stamp where EmpNo=$EmpNo and Month='0' ");

                //Get Salary Advance details
                $Sal_Advance = $this->Db_model->getfilteredData("select Amount from tbl_salary_advance where Is_Approve=1 and EmpNo=$EmpNo and month=$month and year = $year");

                $Fest_Advance = $this->Db_model->getfilteredData("SELECT Amount from tbl_festivel_advance where EmpNo=$EmpNo and Month=$month and Year = $year");
                $uniform = 0;
                $other = 0;
                $deduction1 = 0;
                $deduction2 = 0;

                $stamp_Duty1 = 0;
                if (!empty($stamp_Duty)) {
                    $stamp_Duty1 =  $stamp_Duty[0]->Amount;
                } else if (empty($stamp_Duty) && !empty($fixed_stamp_Duty)) {
                    $stamp_Duty1 =  $fixed_stamp_Duty[0]->Amount;
                }

                if (empty($Deductions[3]->Ded_ID) && !empty($FixedDeductions[3]->Deduction_ID)) {
                    if ($FixedDeductions[3]->Deduction_ID == 1) {
                        $uniform = $FixedDeductions[3]->Amount;
                    } else if ($FixedDeductions[3]->Deduction_ID == 2) {
                        $other = $FixedDeductions[3]->Amount;
                    } else if ($FixedDeductions[3]->Deduction_ID == 3) {
                        $deduction1 = $FixedDeductions[3]->Amount;
                    } else if ($FixedDeductions[3]->Deduction_ID == 4) {
                        $deduction2 = $FixedDeductions[3]->Amount;
                    }
                } else if (!empty($Deductions[3]->Ded_ID)) {
                    if ($Deductions[3]->Ded_ID == 1) {
                        $uniform = $Deductions[3]->Amount;
                    } else if ($Deductions[3]->Ded_ID == 2) {
                        $other = $Deductions[3]->Amount;
                    } else if ($Deductions[3]->Ded_ID == 3) {
                        $deduction1 = $Deductions[3]->Amount;
                    } else if ($Deductions[3]->Ded_ID == 4) {
                        $deduction2 = $Deductions[3]->Amount;
                    }
                }
                if (empty($Deductions[2]->Ded_ID) && !empty($FixedDeductions[2]->Deduction_ID)) {
                    if ($FixedDeductions[2]->Deduction_ID == 1) {
                        $uniform = $FixedDeductions[2]->Amount;
                    } else if ($FixedDeductions[2]->Deduction_ID == 2) {
                        $other = $FixedDeductions[2]->Amount;
                    } else if ($FixedDeductions[2]->Deduction_ID == 3) {
                        $deduction1 = $FixedDeductions[2]->Amount;
                    } else if ($FixedDeductions[2]->Deduction_ID == 4) {
                        $deduction2 = $FixedDeductions[2]->Amount;
                    }
                } else if (!empty($Deductions[2]->Ded_ID)) {
                    if ($Deductions[2]->Ded_ID == 1) {
                        $uniform = $Deductions[2]->Amount;
                    } else if ($Deductions[2]->Ded_ID == 2) {
                        $other = $Deductions[2]->Amount;
                    } else if ($Deductions[2]->Ded_ID == 3) {
                        $deduction1 = $Deductions[2]->Amount;
                    } else if ($Deductions[2]->Ded_ID == 4) {
                        $deduction2 = $Deductions[2]->Amount;
                    }
                }
                if (empty($Deductions[1]->Ded_ID) && !empty($FixedDeductions[1]->Deduction_ID)) {
                    if ($FixedDeductions[1]->Deduction_ID == 1) {
                        $uniform = $FixedDeductions[1]->Amount;
                    } else if ($FixedDeductions[1]->Deduction_ID == 2) {
                        $other = $FixedDeductions[1]->Amount;
                    } else if ($FixedDeductions[1]->Deduction_ID == 3) {
                        $deduction1 = $FixedDeductions[1]->Amount;
                    } else if ($FixedDeductions[1]->Deduction_ID == 4) {
                        $deduction2 = $FixedDeductions[1]->Amount;
                    }
                } else if (!empty($Deductions[1]->Ded_ID)) {
                    if ($Deductions[1]->Ded_ID == 1) {
                        $uniform = $Deductions[1]->Amount;
                    } else if ($Deductions[1]->Ded_ID == 2) {
                        $other = $Deductions[1]->Amount;
                    } else if ($Deductions[1]->Ded_ID == 3) {
                        $deduction1 = $Deductions[1]->Amount;
                    } else if ($Deductions[1]->Ded_ID == 4) {
                        $deduction2 = $Deductions[1]->Amount;
                    }
                }
                if (empty($Deductions[0]->Ded_ID) && !empty($FixedDeductions[0]->Deduction_ID)) {
                    if ($FixedDeductions[0]->Deduction_ID == 1) {
                        $uniform = $FixedDeductions[0]->Amount;
                    } else if ($FixedDeductions[0]->Deduction_ID == 2) {
                        $other = $FixedDeductions[0]->Amount;
                    } else if ($FixedDeductions[0]->Deduction_ID == 3) {
                        $deduction1 = $FixedDeductions[0]->Amount;
                    } else if ($FixedDeductions[0]->Deduction_ID == 4) {
                        $deduction2 = $FixedDeductions[0]->Amount;
                    }
                } else if (!empty($Deductions[0]->Ded_ID)) {
                    if ($Deductions[0]->Ded_ID == 1) {
                        $uniform = $Deductions[0]->Amount;
                    } else if ($Deductions[0]->Ded_ID == 2) {
                        $other = $Deductions[0]->Amount;
                    } else if ($Deductions[0]->Ded_ID == 3) {
                        $deduction1 = $Deductions[0]->Amount;
                    } else if ($Deductions[0]->Ded_ID == 4) {
                        $deduction2 = $Deductions[0]->Amount;
                    }
                }

                if ($Fest_Advance == null) {
                    $Festivel_Advance = 0;
                } else {
                    $Festivel_Advance = $Fest_Advance[0]->Amount;
                }

                //Get loan details
                $Loan = $this->Db_model->getfilteredData("select Loan_ID,Loan_amount,Month_Installment,FullAmount,Paid_Amount from tbl_loans where Is_Settled=0 and EmpNo=$EmpNo");

                /*
                 * Loan Details
                 */

                if (empty($Loan[0]->Loan_ID)) {
                    $LoanID = 0;
                } else {
                    $LoanID = $Loan[0]->Loan_ID;
                }


                if (empty($Loan[0]->Month_Installment)) {
                    $LoanMonth = 0;
                } else {
                    $LoanMonth = $Loan[0]->Month_Installment;
                }

                /*
                 * Salary Advance Details
                 */


                if (empty($Sal_Advance[0]->Amount)) {
                    $Sal_advance = 0;
                } else {
                    $Sal_advance = $Sal_Advance[0]->Amount;
                }
                /*
                 * Budget relevances
                 */


                if (empty($br1)) {
                    $budgetrelevance1 = 0;
                } else {
                    $budgetrelevance1 = $br1;
                }



                if (empty($br2)) {
                    $budgetrelevance2 = 0;
                } else {
                    $budgetrelevance2 = $br2;
                }

                /*
                 * Allowance Details
                 */


                if (empty($Allowances[6]->Alw_ID)) {
                    $Allowance_ID_1 = 0;
                } else {
                    $Allowance_ID_1 = $Allowances[0]->Alw_ID;
                }

                if (empty($Allowances[7]->Alw_ID)) {
                    $Allowance_ID_2 = 0;
                } else {
                    $Allowance_ID_2 = $Allowances[1]->Alw_ID;
                }

                if (empty($Allowances[8]->Alw_ID)) {
                    $Allowance_ID_3 = 0;
                } else {
                    $Allowance_ID_3 = $Allowances[2]->Alw_ID;
                }

                if (empty($Allowances[9]->Alw_ID)) {
                    $Allowance_ID_4 = 0;
                } else {
                    $Allowance_ID_4 = $Allowances[3]->Alw_ID;
                }

                if (empty($Allowances[10]->Alw_ID)) {
                    $Allowance_ID_5 = 0;
                } else {
                    $Allowance_ID_5 = $Allowances[4]->Alw_ID;
                }

                /*
                 * Deduction Details
                 */

                if (empty($Deductions[0]->Ded_ID)) {
                    $Deduction_ID_1 = 0;
                } else {
                    $Deduction_ID_1 = $Deductions[0]->Ded_ID;
                }

                if (empty($Deductions[1]->Ded_ID)) {
                    $Deduction_ID_2 = 0;
                } else {
                    $Deduction_ID_2 = $Deductions[1]->Ded_ID;
                }

                if (empty($Deductions[2]->Ded_ID)) {
                    $Deduction_ID_3 = 0;
                } else {
                    $Deduction_ID_3 = $Deductions[2]->Ded_ID;
                }

                $Overtime_DB = $this->Db_model->getfilteredData("select sum(DOT) as D_OT from tbl_individual_roster where EmpNo='$EmpNo' and EXTRACT(MONTH FROM FDate)=$month and  EXTRACT(YEAR FROM FDate) =$year");
                $Overtime = $this->Db_model->getfilteredData("select sum(AfterExH) as N_OT from tbl_individual_roster where EmpNo='$EmpNo' and EXTRACT(MONTH FROM FDate)=$month and  EXTRACT(YEAR FROM FDate) =$year");

                $N_OT_Hours = $Overtime[0]->N_OT;

                $D_OT_Hours = $Overtime_DB[0]->D_OT;

                $OT_Rate = ((($BasicSal + $Fixed_Allowance) / 187) * 1.5);
                $N_OT_Amount = $OT_Rate * ($N_OT_Hours / 60);

                $OT_Rate_2 = ((($BasicSal + $Fixed_Allowance) / 187) * 2);
                $D_OT_Amount = $OT_Rate_2 * ($D_OT_Hours / 60);

                //*** Get Late Minutes
                $Late_Amount = 0;
                $Late_Min = $this->Db_model->getfilteredData("select sum(LateM) as LateMin from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and RYear=$year AND ShType = 'DU' ");

                //*** Late Min
                if (empty($Late_Min[0]->LateMin)) {
                    $Late_Min = 0;
                } else {
                    $Late_Min = $Late_Min[0]->LateMin;
                }

                $Late_rate = (($BasicSal / 187)) / 60;
                $Late_Amount = ($Late_rate * $Late_Min);

                $ed_amount = 0;
                $earlydepature = $this->Db_model->getfilteredData("select SUM(EarlyDepMin) as ed from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and RYear=$year AND ShType = 'DU' ");
                if (empty($earlydepature[0]->ed)) {
                    $ed_min = 0;
                } else {
                    $ed_min = $earlydepature[0]->ed;
                }

                $ed_rate = ((($BasicSal/ 187)) /60);
                $ed_amount = $ed_min * $ed_rate;

                //All budgetrelevances
                $budgetrelevances = $budgetrelevance1 + $budgetrelevance2;
                //All Allowances
                $Allowances = $tbSPAllowance + $tbTraveling + $tbTransport + $tbFuel + $tbAttendances + $tbPerformance + $Allowance_2 + $Allowance_3;

                //Calculate Gross salary
                $Gross_sal = ($BasicSal + $Fixed_Allowance + $Incentive + $budgetrelevances);

                /*
                *payee tax calculate start
                */
                $st_gross_Pay = $Gross_sal * 12;

                $free_rate = 100000;
                $anual_freee_rate = $free_rate * 12;
                $payee_now_amount = 0;

                $calculate_gross_pay = $st_gross_Pay - $anual_freee_rate;

                if (0 > $calculate_gross_pay) {
                    $payee_now_amount = 0;
                } else {
                    if (0 < $calculate_gross_pay) {
                        if ($calculate_gross_pay >= 500000) {
                            $payeeamount = (500000 / 12) * ($payee[0]->Tax_rate / 100);
                            $calculate_gross_pay -= 500000;
                            $payee_now_amount += $payeeamount;
                        } else if (0 < $calculate_gross_pay && $calculate_gross_pay < 500000) {
                            $payeeamount = ($calculate_gross_pay / 12) * ($payee[0]->Tax_rate / 100);
                            $calculate_gross_pay -= 500000;
                            $payee_now_amount += $payeeamount;
                        }
                    }
                    if (0 < $calculate_gross_pay) {
                        if ($calculate_gross_pay >= 500000) {
                            $payeeamount = (500000 / 12) * ($payee[1]->Tax_rate / 100);
                            $calculate_gross_pay -= 500000;
                            $payee_now_amount += $payeeamount;
                        } else if (0 < $calculate_gross_pay && $calculate_gross_pay < 500000) {
                            $payeeamount = ($calculate_gross_pay / 12) * ($payee[1]->Tax_rate / 100);
                            $calculate_gross_pay -= 500000;
                            $payee_now_amount += $payeeamount;
                        }
                    }
                    if (0 < $calculate_gross_pay) {
                        if ($calculate_gross_pay >= 500000) {
                            $payeeamount = (500000 / 12) * ($payee[2]->Tax_rate / 100);
                            $calculate_gross_pay -= 500000;
                            $payee_now_amount += $payeeamount;
                        } else if (0 < $calculate_gross_pay && $calculate_gross_pay < 500000) {
                            $payeeamount = ($calculate_gross_pay / 12) * ($payee[2]->Tax_rate / 100);
                            $calculate_gross_pay -= 500000;
                            $payee_now_amount += $payeeamount;
                        }
                    }
                    if (0 < $calculate_gross_pay) {
                        if ($calculate_gross_pay >= 500000) {
                            $payeeamount = (500000 / 12) * ($payee[3]->Tax_rate / 100);
                            $calculate_gross_pay -= 500000;
                            $payee_now_amount += $payeeamount;
                        } else if (0 < $calculate_gross_pay && $calculate_gross_pay < 500000) {
                            $payeeamount = ($calculate_gross_pay / 12) * ($payee[3]->Tax_rate / 100);
                            $calculate_gross_pay -= 500000;
                            $payee_now_amount += $payeeamount;
                        }
                    }
                    if (0 < $calculate_gross_pay) {
                        if ($calculate_gross_pay >= 500000) {
                            $payeeamount = (500000 / 12) * ($payee[4]->Tax_rate / 100);
                            $calculate_gross_pay -= 500000;
                            $payee_now_amount += $payeeamount;
                        } else if (0 < $calculate_gross_pay && $calculate_gross_pay < 500000) {
                            $payeeamount = ($calculate_gross_pay / 12) * ($payee[4]->Tax_rate / 100);
                            $calculate_gross_pay -= 500000;
                            $payee_now_amount += $payeeamount;
                        }
                    }
                    if (0 < $calculate_gross_pay) {
                        $payeeamount = ($calculate_gross_pay / 12) * ($payee[5]->Tax_rate / 100);
                        $calculate_gross_pay -= 500000;
                        $payee_now_amount += $payeeamount;
                    }
                }
                /*
                *payee tax calculate end
                */

                //Calculate EPF Employee
                $EPF_Worker = (8 / 100) * ($BasicSal + $Fixed_Allowance + $budgetrelevances);

                //Total for epf
                $tottal_for_epf = $BasicSal + $Fixed_Allowance + $budgetrelevances;

                //Calculate EPF Employer
                $EPF_Employer = (12 / 100) * ($BasicSal + $Fixed_Allowance + $budgetrelevances);

                //Calculate ETF Employee
                $ETF = (3 / 100) * ($BasicSal + $Fixed_Allowance + $budgetrelevances);

                //Calculate Total Deductions
                $Tot_deductions = $payee_now_amount + $EPF_Worker + $Sal_advance + $Festivel_Advance + $uniform + $other + $deduction1 + $deduction2 + $LoanMonth + $Late_Amount + $Nopay_Deduction + $ed_amount;

                //Calculate Net Salary
                $netSal = ($Gross_sal + $N_OT_Amount + $D_OT_Amount + $Att_Allowance + $Allowances) - $Tot_deductions;

                //calculate Gross pay
                $grosspay = $Gross_sal + $Allowances;

                $D_Salary = $grosspay - $Tot_deductions;

                $data = array(
                    'EmpNo' => $EmpNo,
                    'EPFNO' => $EpfNo,
                    'Basic_sal' => $BasicSal,
                    'Total_F_Epf' => $tottal_for_epf,
                    'Br_pay' => $budgetrelevances,
                    'Incentive' => $Incentive,
                    'Dep_ID' => $Dep_ID,
                    'Des_ID' => $Des_ID,
                    'No_Pay_days' => $NopayDays,
                    'no_pay_deduction' => $Nopay_Deduction,
                    'EPF_Worker_Rate' => 8,
                    'EPF_Worker_Amount' => $EPF_Worker,
                    'EPF_Employee_Rate' => 12,
                    'EPF_Employee_Amount' => $EPF_Employer,
                    'ETF_Rate' => 3,
                    'ETF_Amount' => $ETF,
                    'Loan_Instalment' => $LoanMonth,
                    'Salary_advance' => $Sal_advance,
                    'Ed_min' => $ed_min,
                    'Late_min' => $Late_Min,
                    'Ed_deduction' => $ed_amount,
                    'Late_deduction' => $Late_Amount,
                    'Alw_ID_1' => 0,
                    'Allowance_1' => 0,
                    'Alw_ID_2' => $Allowance_ID_2,
                    'Increment' => $Allowance_2,
                    'Alw_ID_3' => $Allowance_ID_3,
                    'Other_OT' => $Allowance_3,
                    'Alw_ID_4' => $Allowance_ID_4,
                    'Allowance_4' => 0,
                    'Alw_ID_5' => $Allowance_ID_5,
                    'Allowance_5' => 0,
                    'Performance' => $tbPerformance,
                    'Attendances' => $tbAttendances,
                    'Fuel' => $tbFuel,
                    'Transport' => $tbTransport,
                    'Traveling' => $tbTraveling,
                    'SPAllowance' => $tbSPAllowance,
                    'Normal_OT_Hrs' => ($N_OT_Hours / 60),
                    'Normal_OT_Pay' => $N_OT_Amount,
                    'Double_OT_Hrs' => ($D_OT_Hours / 60),
                    'Double_OT_Pay' => $D_OT_Amount,
                    'Uniform' => $uniform,
                    'Ded_ID_1' => $Deduction_ID_1,
                    'Deduct_1' => $other,
                    'Ded_ID_2' => $Deduction_ID_2,
                    'Deduct_2' => $deduction1,
                    'Ded_ID_3' => $Deduction_ID_3,
                    'Deduct_3' => $deduction2,
                    'Wellfare' => $welfair_1,
                    'Payee_amount' => $payee_now_amount,
                    'Stamp_duty' => $stamp_Duty1,
                    'tot_deduction' => $Tot_deductions,
                    'Gross_pay' => $grosspay,
                    'Gross_sal' => $Gross_sal,
                    'D_Salary' => $D_Salary,
                    'Net_salary' => $netSal
                );


                //***** Update Salary Table
                $whereArray = array("EmpNo" => $EmpNo, 'Month' => $month, 'Year' => $year);
                $result = $this->Db_model->updateData("tbl_salary", $data, $whereArray);


                /*
                 * Loan Amount
                 */
                if (empty($Loan[0]->Paid_Amount)) {
                    $PaidAmount = 0;
                } else {
                    $PaidAmount = $Loan[0]->Paid_Amount;
                }

                if (empty($Loan[0]->FullAmount)) {
                    $Full_Amount = 0;
                } else {
                    $Full_Amount = $Loan[0]->FullAmount;
                }

                //****** Loan Amount deduction process
                $PaidAmount_to = $PaidAmount + $LoanMonth;
                $BalanceAmount = $Full_Amount - $PaidAmount_to;

                if ($BalanceAmount <= 0) {
                    $Is_Settele = 1;
                } else {
                    $Is_Settele = 0;
                }

                $data_loan = array(
                    'EmpNo' => $EmpNo,
                    'Paid_Amount' => $PaidAmount_to,
                    'Balance_amount' => $BalanceAmount,
                    'Is_Settled' => $Is_Settele,
                );

                $HasRow = $this->Db_model->getfilteredData("select count(EmpNo) as HasRow from tbl_loan_trans where EmpNo=$EmpNo and month=$month and year=$year");


                if ($LoanMonth == 0) {
                } {
                    $dataArray = array(
                        'Year' => $year,
                        'EmpNo' => $EmpNo,
                        'Month' => $month,
                        'Amount_month' => $LoanMonth,
                        'Loan_ID' => $LoanID,
                        'Time_Trans' => $timestamp,
                    );

                    $this->Db_model->insertData("tbl_loan_trans", $dataArray);
                }

                $HasRow = $this->Db_model->getfilteredData("select count(EmpNo) as HasRow from tbl_loan_trans where EmpNo=$EmpNo and month=$month and year=$year ");

                if ($HasRow[0]->HasRow) {
                } else {
                    $whereArray_loan = array("EmpNo" => $EmpNo);
                    $result = $this->Db_model->updateData("tbl_loans", $data_loan, $whereArray_loan);
                }

                //*******Else Salary records haven't in Salary table insert salary records into salary table
            } else {

                $SalData = $this->Db_model->getfilteredData("select EmpNo,EPFNO,Is_EPF, Dep_ID, Des_ID,Basic_Salary,Fixed_Allowance,Incentive,is_nopay_calc from tbl_empmaster where EmpNo=$EmpNo");
                $BasicSal = $SalData[0]->Basic_Salary;
                $Incentive = $SalData[0]->Incentive;
                $Fixed_Allowance = $SalData[0]->Fixed_Allowance;
                $Is_EPF = $SalData[0]->Is_EPF;
                $is_no_pay = $SalData[0]->is_nopay_calc;

                //**** Get Nopay days
                $Nopay = $this->Db_model->getfilteredData("select sum(nopay) as nopay, sum(nopay_hrs) nopay_hrs,sum(Att_Allow) as Att_Allow from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and EXTRACT(YEAR FROM FDate)=$year AND ShType = 'DU'");
                $NopayDays = $Nopay[0]->nopay;

                $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

                $Att_Allowance = 0;
                
                if ($NopayDays == null) {
                    $NopayDays = 0;
                }

                //**** Calculate no pay amount
                $NopayRate = ($BasicSal + $Incentive) / 22;

                if ($is_no_pay == 1) {
                    $NopayDays = 0;
                }

                $Nopay_Deduction = $NopayRate * $NopayDays;

                //**** Get Allowance Details
                // $budget_relevance = $this->Db_model->getfilteredData("select Br_ID, Amount from tbl_varialble_br where EmpNo=$EmpNo and Month=$month and Year=$year");
                $welfair = $this->Db_model->getfilteredData("select welfair_id, Amount from tbl_variable_welfair where EmpNo=$EmpNo and Month=$month and Year=$year");

                //**** Get Allowance Details
                // $Allowancescount = $this->Db_model->getfilteredData("select count(Alw_ID) as HasRow from tbl_varialble_allowance where EmpNo=$EmpNo and Month=$month and Year=$year");
                $Allowances = $this->Db_model->getfilteredData("select Alw_ID, Amount from tbl_varialble_allowance where EmpNo=$EmpNo and Month=$month and Year=$year ORDER BY tbl_varialble_allowance.Alw_ID");
                $FixedAllowances = $this->Db_model->getfilteredData("select Alw_ID, Amount from tbl_fixed_allowance where EmpNo=$EmpNo ORDER BY tbl_fixed_allowance.Alw_ID");

                $tbPerformance = 0;
                $tbAttendances = 0;
                $tbFuel = 0;
                $tbTransport = 0;
                $tbTraveling = 0;
                $tbSPAllowance = 0;
                $Allowance_2 = 0;
                $Allowance_3 = 0;
                $welfair_1 = 0;

                if (!empty($welfair)) {
                    $welfair_1 = $welfair[0]->Amount;
                }

                /*
                 * Allowence special types
                 */

                if (!empty($Allowances[6]->Alw_ID)) {
                    if ($Allowances[6]->Alw_ID == 1) {
                        $tbPerformance = $Allowances[6]->Amount;
                    } else if ($Allowances[6]->Alw_ID == 2) {
                        $tbAttendances = $Allowances[6]->Amount;
                    } else if ($Allowances[6]->Alw_ID == 3) {
                        $tbFuel = $Allowances[6]->Amount;
                    } else if ($Allowances[6]->Alw_ID == 4) {
                        $tbTransport = $Allowances[6]->Amount;
                    } else if ($Allowances[6]->Alw_ID == 5) {
                        $tbTraveling = $Allowances[6]->Amount;
                    } else if ($Allowances[6]->Alw_ID == 6) {
                        $tbSPAllowance = $Allowances[6]->Amount;
                    } else if ($Allowances[6]->Alw_ID == 7) {
                        $Allowance_2 = $Allowances[6]->Amount;
                    } else if ($Allowances[6]->Alw_ID == 8) {
                        $Allowance_3 = $Allowances[6]->Amount;
                    }
                } else if (empty($Allowances[6]->Alw_ID) && !empty($FixedAllowances[6]->Alw_ID)) {
                    if ($FixedAllowances[6]->Alw_ID == 1) {
                        $tbPerformance = $FixedAllowances[6]->Amount;
                    } else if ($FixedAllowances[6]->Alw_ID == 2) {
                        $tbAttendances = $FixedAllowances[6]->Amount;
                    } else if ($FixedAllowances[6]->Alw_ID == 3) {
                        $tbFuel = $FixedAllowances[6]->Amount;
                    } else if ($FixedAllowances[6]->Alw_ID == 4) {
                        $tbTransport = $FixedAllowances[6]->Amount;
                    } else if ($FixedAllowances[6]->Alw_ID == 5) {
                        $tbTraveling = $FixedAllowances[6]->Amount;
                    } else if ($FixedAllowances[6]->Alw_ID == 6) {
                        $tbSPAllowance = $FixedAllowances[6]->Amount;
                    } else if ($FixedAllowances[6]->Alw_ID == 7) {
                        $Allowance_2 = $FixedAllowances[6]->Amount;
                    } else if ($FixedAllowances[6]->Alw_ID == 8) {
                        $Allowance_3 = $FixedAllowances[6]->Amount;
                    }
                }
                if (!empty($Allowances[5]->Alw_ID)) {
                    if ($Allowances[5]->Alw_ID == 1) {
                        $tbPerformance = $Allowances[5]->Amount;
                    } else if ($Allowances[5]->Alw_ID == 2) {
                        $tbAttendances = $Allowances[5]->Amount;
                    } else if ($Allowances[5]->Alw_ID == 3) {
                        $tbFuel = $Allowances[5]->Amount;
                    } else if ($Allowances[5]->Alw_ID == 4) {
                        $tbTransport = $Allowances[5]->Amount;
                    } else if ($Allowances[5]->Alw_ID == 5) {
                        $tbTraveling = $Allowances[5]->Amount;
                    } else if ($Allowances[5]->Alw_ID == 6) {
                        $tbSPAllowance = $Allowances[5]->Amount;
                    } else if ($Allowances[5]->Alw_ID == 7) {
                        $Allowance_2 = $Allowances[5]->Amount;
                    } else if ($Allowances[5]->Alw_ID == 8) {
                        $Allowance_3 = $Allowances[5]->Amount;
                    }
                } else if (empty($Allowances[5]->Alw_ID) && !empty($FixedAllowances[5]->Alw_ID)) {
                    if ($FixedAllowances[5]->Alw_ID == 1) {
                        $tbPerformance = $FixedAllowances[5]->Amount;
                    } else if ($FixedAllowances[5]->Alw_ID == 2) {
                        $tbAttendances = $FixedAllowances[5]->Amount;
                    } else if ($FixedAllowances[5]->Alw_ID == 3) {
                        $tbFuel = $FixedAllowances[5]->Amount;
                    } else if ($FixedAllowances[5]->Alw_ID == 4) {
                        $tbTransport = $FixedAllowances[5]->Amount;
                    } else if ($FixedAllowances[5]->Alw_ID == 5) {
                        $tbTraveling = $FixedAllowances[5]->Amount;
                    } else if ($FixedAllowances[5]->Alw_ID == 6) {
                        $tbSPAllowance = $FixedAllowances[5]->Amount;
                    } else if ($FixedAllowances[5]->Alw_ID == 7) {
                        $Allowance_2 = $FixedAllowances[5]->Amount;
                    } else if ($FixedAllowances[5]->Alw_ID == 8) {
                        $Allowance_3 = $FixedAllowances[5]->Amount;
                    }
                }
                if (!empty($Allowances[4]->Alw_ID)) {
                    if ($Allowances[4]->Alw_ID == 1) {
                        $tbPerformance = $Allowances[4]->Amount;
                    } else if ($Allowances[4]->Alw_ID == 2) {
                        $tbAttendances = $Allowances[4]->Amount;
                    } else if ($Allowances[4]->Alw_ID == 3) {
                        $tbFuel = $Allowances[4]->Amount;
                    } else if ($Allowances[4]->Alw_ID == 4) {
                        $tbTransport = $Allowances[4]->Amount;
                    } else if ($Allowances[4]->Alw_ID == 5) {
                        $tbTraveling = $Allowances[4]->Amount;
                    } else if ($Allowances[4]->Alw_ID == 6) {
                        $tbSPAllowance = $Allowances[4]->Amount;
                    } else if ($Allowances[4]->Alw_ID == 7) {
                        $Allowance_2 = $Allowances[4]->Amount;
                    } else if ($Allowances[4]->Alw_ID == 8) {
                        $Allowance_3 = $Allowances[4]->Amount;
                    }
                } else if (empty($Allowances[4]->Alw_ID) && !empty($FixedAllowances[4]->Alw_ID)) {
                    if ($FixedAllowances[4]->Alw_ID == 1) {
                        $tbPerformance = $FixedAllowances[4]->Amount;
                    } else if ($FixedAllowances[4]->Alw_ID == 2) {
                        $tbAttendances = $FixedAllowances[4]->Amount;
                    } else if ($FixedAllowances[4]->Alw_ID == 3) {
                        $tbFuel = $FixedAllowances[4]->Amount;
                    } else if ($FixedAllowances[4]->Alw_ID == 4) {
                        $tbTransport = $FixedAllowances[4]->Amount;
                    } else if ($FixedAllowances[4]->Alw_ID == 5) {
                        $tbTraveling = $FixedAllowances[4]->Amount;
                    } else if ($FixedAllowances[4]->Alw_ID == 6) {
                        $tbSPAllowance = $FixedAllowances[4]->Amount;
                    } else if ($FixedAllowances[4]->Alw_ID == 7) {
                        $Allowance_2 = $FixedAllowances[4]->Amount;
                    } else if ($FixedAllowances[4]->Alw_ID == 8) {
                        $Allowance_3 = $FixedAllowances[4]->Amount;
                    }
                }
                if (!empty($Allowances[3]->Alw_ID)) {
                    if ($Allowances[3]->Alw_ID == 1) {
                        $tbPerformance = $Allowances[3]->Amount;
                    } else if ($Allowances[3]->Alw_ID == 2) {
                        $tbAttendances = $Allowances[3]->Amount;
                    } else if ($Allowances[3]->Alw_ID == 3) {
                        $tbFuel = $Allowances[3]->Amount;
                    } else if ($Allowances[3]->Alw_ID == 4) {
                        $tbTransport = $Allowances[3]->Amount;
                    } else if ($Allowances[3]->Alw_ID == 5) {
                        $tbTraveling = $Allowances[3]->Amount;
                    } else if ($Allowances[3]->Alw_ID == 6) {
                        $tbSPAllowance = $Allowances[3]->Amount;
                    } else if ($Allowances[3]->Alw_ID == 7) {
                        $Allowance_2 = $Allowances[3]->Amount;
                    } else if ($Allowances[3]->Alw_ID == 8) {
                        $Allowance_3 = $Allowances[3]->Amount;
                    }
                } else if (empty($Allowances[3]->Alw_ID) && !empty($FixedAllowances[3]->Alw_ID)) {
                    if ($FixedAllowances[3]->Alw_ID == 1) {
                        $tbPerformance = $FixedAllowances[3]->Amount;
                    } else if ($FixedAllowances[3]->Alw_ID == 2) {
                        $tbAttendances = $FixedAllowances[3]->Amount;
                    } else if ($FixedAllowances[3]->Alw_ID == 3) {
                        $tbFuel = $FixedAllowances[3]->Amount;
                    } else if ($FixedAllowances[3]->Alw_ID == 4) {
                        $tbTransport = $FixedAllowances[3]->Amount;
                    } else if ($FixedAllowances[3]->Alw_ID == 5) {
                        $tbTraveling = $FixedAllowances[3]->Amount;
                    } else if ($FixedAllowances[3]->Alw_ID == 6) {
                        $tbSPAllowance = $FixedAllowances[3]->Amount;
                    } else if ($FixedAllowances[3]->Alw_ID == 7) {
                        $Allowance_2 = $FixedAllowances[3]->Amount;
                    } else if ($FixedAllowances[3]->Alw_ID == 8) {
                        $Allowance_3 = $FixedAllowances[3]->Amount;
                    }
                }
                if (!empty($Allowances[2]->Alw_ID)) {
                    if ($Allowances[2]->Alw_ID == 1) {
                        $tbPerformance = $Allowances[2]->Amount;
                    } else if ($Allowances[2]->Alw_ID == 2) {
                        $tbAttendances = $Allowances[2]->Amount;
                    } else if ($Allowances[2]->Alw_ID == 3) {
                        $tbFuel = $Allowances[2]->Amount;
                    } else if ($Allowances[2]->Alw_ID == 4) {
                        $tbTransport = $Allowances[2]->Amount;
                    } else if ($Allowances[2]->Alw_ID == 5) {
                        $tbTraveling = $Allowances[2]->Amount;
                    } else if ($Allowances[2]->Alw_ID == 6) {
                        $tbSPAllowance = $Allowances[2]->Amount;
                    } else if ($Allowances[2]->Alw_ID == 7) {
                        $Allowance_2 = $Allowances[2]->Amount;
                    } else if ($Allowances[2]->Alw_ID == 8) {
                        $Allowance_3 = $Allowances[2]->Amount;
                    }
                } else if (empty($Allowances[2]->Alw_ID) && !empty($FixedAllowances[2]->Alw_ID)) {
                    if ($FixedAllowances[2]->Alw_ID == 1) {
                        $tbPerformance = $FixedAllowances[2]->Amount;
                    } else if ($FixedAllowances[2]->Alw_ID == 2) {
                        $tbAttendances = $FixedAllowances[2]->Amount;
                    } else if ($FixedAllowances[2]->Alw_ID == 3) {
                        $tbFuel = $FixedAllowances[2]->Amount;
                    } else if ($FixedAllowances[2]->Alw_ID == 4) {
                        $tbTransport = $FixedAllowances[2]->Amount;
                    } else if ($FixedAllowances[2]->Alw_ID == 5) {
                        $tbTraveling = $FixedAllowances[2]->Amount;
                    } else if ($FixedAllowances[2]->Alw_ID == 6) {
                        $tbSPAllowance = $FixedAllowances[2]->Amount;
                    } else if ($FixedAllowances[2]->Alw_ID == 7) {
                        $Allowance_2 = $FixedAllowances[2]->Amount;
                    } else if ($FixedAllowances[2]->Alw_ID == 8) {
                        $Allowance_3 = $FixedAllowances[2]->Amount;
                    }
                }
                if (!empty($Allowances[1]->Alw_ID)) {
                    if ($Allowances[1]->Alw_ID == 1) {
                        $tbPerformance = $Allowances[1]->Amount;
                    } else if ($Allowances[1]->Alw_ID == 2) {
                        $tbAttendances = $Allowances[1]->Amount;
                    } else if ($Allowances[1]->Alw_ID == 3) {
                        $tbFuel = $Allowances[1]->Amount;
                    } else if ($Allowances[1]->Alw_ID == 4) {
                        $tbTransport = $Allowances[1]->Amount;
                    } else if ($Allowances[1]->Alw_ID == 5) {
                        $tbTraveling = $Allowances[1]->Amount;
                    } else if ($Allowances[1]->Alw_ID == 6) {
                        $tbSPAllowance = $Allowances[1]->Amount;
                    } else if ($Allowances[1]->Alw_ID == 7) {
                        $Allowance_2 = $Allowances[1]->Amount;
                    } else if ($Allowances[1]->Alw_ID == 8) {
                        $Allowance_3 = $Allowances[1]->Amount;
                    }
                } else if (empty($Allowances[1]->Alw_ID) && !empty($FixedAllowances[1]->Alw_ID)) {
                    if ($FixedAllowances[1]->Alw_ID == 1) {
                        $tbPerformance = $FixedAllowances[1]->Amount;
                    } else if ($FixedAllowances[1]->Alw_ID == 2) {
                        $tbAttendances = $FixedAllowances[1]->Amount;
                    } else if ($FixedAllowances[1]->Alw_ID == 3) {
                        $tbFuel = $FixedAllowances[1]->Amount;
                    } else if ($FixedAllowances[1]->Alw_ID == 4) {
                        $tbTransport = $FixedAllowances[1]->Amount;
                    } else if ($FixedAllowances[1]->Alw_ID == 5) {
                        $tbTraveling = $FixedAllowances[1]->Amount;
                    } else if ($FixedAllowances[1]->Alw_ID == 6) {
                        $tbSPAllowance = $FixedAllowances[1]->Amount;
                    } else if ($FixedAllowances[1]->Alw_ID == 7) {
                        $Allowance_2 = $FixedAllowances[1]->Amount;
                    } else if ($FixedAllowances[1]->Alw_ID == 8) {
                        $Allowance_3 = $FixedAllowances[1]->Amount;
                    }
                }
                if (!empty($Allowances[0]->Alw_ID)) {
                    if ($Allowances[0]->Alw_ID == 1) {
                        $tbPerformance = $Allowances[0]->Amount;
                    } else if ($Allowances[0]->Alw_ID == 2) {
                        $tbAttendances = $Allowances[0]->Amount;
                    } else if ($Allowances[0]->Alw_ID == 3) {
                        $tbFuel = $Allowances[0]->Amount;
                    } else if ($Allowances[0]->Alw_ID == 4) {
                        $tbTransport = $Allowances[0]->Amount;
                    } else if ($Allowances[0]->Alw_ID == 5) {
                        $tbTraveling = $Allowances[0]->Amount;
                    } else if ($Allowances[0]->Alw_ID == 6) {
                        $tbSPAllowance = $Allowances[0]->Amount;
                    } else if ($Allowances[0]->Alw_ID == 7) {
                        $Allowance_2 = $Allowances[0]->Amount;
                    } else if ($Allowances[0]->Alw_ID == 8) {
                        $Allowance_3 = $Allowances[0]->Amount;
                    }
                } else if (empty($Allowances[0]->Alw_ID) && !empty($FixedAllowances[0]->Alw_ID)) {
                    if ($FixedAllowances[0]->Alw_ID == 1) {
                        $tbPerformance = $FixedAllowances[0]->Amount;
                    } else if ($FixedAllowances[0]->Alw_ID == 2) {
                        $tbAttendances = $FixedAllowances[0]->Amount;
                    } else if ($FixedAllowances[0]->Alw_ID == 3) {
                        $tbFuel = $FixedAllowances[0]->Amount;
                    } else if ($FixedAllowances[0]->Alw_ID == 4) {
                        $tbTransport = $FixedAllowances[0]->Amount;
                    } else if ($FixedAllowances[0]->Alw_ID == 5) {
                        $tbTraveling = $FixedAllowances[0]->Amount;
                    } else if ($FixedAllowances[0]->Alw_ID == 6) {
                        $tbSPAllowance = $FixedAllowances[0]->Amount;
                    } else if ($FixedAllowances[0]->Alw_ID == 7) {
                        $Allowance_2 = $FixedAllowances[0]->Amount;
                    } else if ($FixedAllowances[0]->Alw_ID == 8) {
                        $Allowance_3 = $FixedAllowances[0]->Amount;
                    }
                }

                //**** Get deduction Details
                $Deductions = $this->Db_model->getfilteredData("select Ded_ID,Amount from tbl_variable_deduction where EmpNo=$EmpNo and Month=$month and Year=$year");
                $FixedDeductions = $this->Db_model->getfilteredData("select Deduction_ID,Amount from tbl_fixed_deduction where EmpNo=$EmpNo ORDER BY tbl_fixed_deduction.Deduction_ID");

                $payee = $this->Db_model->getfilteredData("SELECT * FROM tbl_payee");
                $stamp_Duty = $this->Db_model->getfilteredData("select ID, Amount from tbl_variable_stamp where EmpNo=$EmpNo and Month=$month and Year=$year");
                $fixed_stamp_Duty = $this->Db_model->getfilteredData("select ID, Amount from tbl_variable_stamp where EmpNo=$EmpNo and Month='0' ");

                //**** Get salary advance
                $Sal_Advance = $this->Db_model->getfilteredData("select Amount from tbl_salary_advance where Is_Approve=1 and EmpNo=$EmpNo and month=$month and year = $year");

                $Fest_Advance = $this->Db_model->getfilteredData("SELECT Amount from tbl_festivel_advance where EmpNo=$EmpNo and Month=$month and Year = $year");
                $uniform = 0;
                $other = 0;
                $deduction1 = 0;
                $deduction2 = 0;

                $stamp_Duty1 = 0;
                if (!empty($stamp_Duty)) {
                    $stamp_Duty1 =  $stamp_Duty[0]->Amount;
                } else if (empty($stamp_Duty) && !empty($fixed_stamp_Duty)) {
                    $stamp_Duty1 =  $fixed_stamp_Duty[0]->Amount;
                }

                if (empty($Deductions[3]->Ded_ID) && !empty($FixedDeductions[3]->Deduction_ID)) {
                    if ($FixedDeductions[3]->Deduction_ID == 1) {
                        $uniform = $FixedDeductions[3]->Amount;
                    } else if ($FixedDeductions[3]->Deduction_ID == 2) {
                        $other = $FixedDeductions[3]->Amount;
                    } else if ($FixedDeductions[3]->Deduction_ID == 3) {
                        $deduction1 = $FixedDeductions[3]->Amount;
                    } else if ($FixedDeductions[3]->Deduction_ID == 4) {
                        $deduction2 = $FixedDeductions[3]->Amount;
                    }
                } else if (!empty($Deductions[3]->Ded_ID)) {
                    if ($Deductions[3]->Ded_ID == 1) {
                        $uniform = $Deductions[3]->Amount;
                    } else if ($Deductions[3]->Ded_ID == 2) {
                        $other = $Deductions[3]->Amount;
                    } else if ($Deductions[3]->Ded_ID == 3) {
                        $deduction1 = $Deductions[3]->Amount;
                    } else if ($Deductions[3]->Ded_ID == 4) {
                        $deduction2 = $Deductions[3]->Amount;
                    }
                }
                if (empty($Deductions[2]->Ded_ID) && !empty($FixedDeductions[2]->Deduction_ID)) {
                    if ($FixedDeductions[2]->Deduction_ID == 1) {
                        $uniform = $FixedDeductions[2]->Amount;
                    } else if ($FixedDeductions[2]->Deduction_ID == 2) {
                        $other = $FixedDeductions[2]->Amount;
                    } else if ($FixedDeductions[2]->Deduction_ID == 3) {
                        $deduction1 = $FixedDeductions[2]->Amount;
                    } else if ($FixedDeductions[2]->Deduction_ID == 4) {
                        $deduction2 = $FixedDeductions[2]->Amount;
                    }
                } else if (!empty($Deductions[2]->Ded_ID)) {
                    if ($Deductions[2]->Ded_ID == 1) {
                        $uniform = $Deductions[2]->Amount;
                    } else if ($Deductions[2]->Ded_ID == 2) {
                        $other = $Deductions[2]->Amount;
                    } else if ($Deductions[2]->Ded_ID == 3) {
                        $deduction1 = $Deductions[2]->Amount;
                    } else if ($Deductions[2]->Ded_ID == 4) {
                        $deduction2 = $Deductions[2]->Amount;
                    }
                }
                if (empty($Deductions[1]->Ded_ID) && !empty($FixedDeductions[1]->Deduction_ID)) {
                    if ($FixedDeductions[1]->Deduction_ID == 1) {
                        $uniform = $FixedDeductions[1]->Amount;
                    } else if ($FixedDeductions[1]->Deduction_ID == 2) {
                        $other = $FixedDeductions[1]->Amount;
                    } else if ($FixedDeductions[1]->Deduction_ID == 3) {
                        $deduction1 = $FixedDeductions[1]->Amount;
                    } else if ($FixedDeductions[1]->Deduction_ID == 4) {
                        $deduction2 = $FixedDeductions[1]->Amount;
                    }
                } else if (!empty($Deductions[1]->Ded_ID)) {
                    if ($Deductions[1]->Ded_ID == 1) {
                        $uniform = $Deductions[1]->Amount;
                    } else if ($Deductions[1]->Ded_ID == 2) {
                        $other = $Deductions[1]->Amount;
                    } else if ($Deductions[1]->Ded_ID == 3) {
                        $deduction1 = $Deductions[1]->Amount;
                    } else if ($Deductions[1]->Ded_ID == 4) {
                        $deduction2 = $Deductions[1]->Amount;
                    }
                }
                if (empty($Deductions[0]->Ded_ID) && !empty($FixedDeductions[0]->Deduction_ID)) {
                    if ($FixedDeductions[0]->Deduction_ID == 1) {
                        $uniform = $FixedDeductions[0]->Amount;
                    } else if ($FixedDeductions[0]->Deduction_ID == 2) {
                        $other = $FixedDeductions[0]->Amount;
                    } else if ($FixedDeductions[0]->Deduction_ID == 3) {
                        $deduction1 = $FixedDeductions[0]->Amount;
                    } else if ($FixedDeductions[0]->Deduction_ID == 4) {
                        $deduction2 = $FixedDeductions[0]->Amount;
                    }
                } else if (!empty($Deductions[0]->Ded_ID)) {
                    if ($Deductions[0]->Ded_ID == 1) {
                        $uniform = $Deductions[0]->Amount;
                    } else if ($Deductions[0]->Ded_ID == 2) {
                        $other = $Deductions[0]->Amount;
                    } else if ($Deductions[0]->Ded_ID == 3) {
                        $deduction1 = $Deductions[0]->Amount;
                    } else if ($Deductions[0]->Ded_ID == 4) {
                        $deduction2 = $Deductions[0]->Amount;
                    }
                }

                if ($Fest_Advance == null) {
                    $Festivel_Advance = 0;
                } else {
                    $Festivel_Advance = $Fest_Advance[0]->Amount;
                }

                //**** Get loan Details
                $Loan = $this->Db_model->getfilteredData("select Loan_ID,Loan_amount,Month_Installment,FullAmount,Paid_Amount from tbl_loans where Is_Settled=0 and EmpNo=$EmpNo");

                /*
                 * Loan Details
                 */

                if (empty($Loan[0]->Loan_ID)) {
                    $LoanID = 0;
                } else {
                    $LoanID = $Loan[0]->Loan_ID;
                }


                if (empty($Loan[0]->Month_Installment)) {
                    $LoanMonth = 0;
                } else {
                    $LoanMonth = $Loan[0]->Month_Installment;
                }

                /*
                 * Salary Advance Details
                 */

                if (empty($Sal_Advance[0]->Amount)) {
                    $Sal_advance = 0;
                } else {
                    $Sal_advance = $Sal_Advance[0]->Amount;
                }

                /*
                 * Budget relevances
                 */
                if (empty($br1)) {
                    $budgetrelevance1 = 0;
                } else {
                    $budgetrelevance1 = $br1;
                }

                if (empty($br2)) {
                    $budgetrelevance2 = 0;
                } else {
                    $budgetrelevance2 = $br2;
                }

                /*
                 * Allowance Details
                 */
                if (empty($Allowances[6]->Alw_ID)) {
                    $Allowance_ID_1 = 0;
                } else {
                    $Allowance_ID_1 = $Allowances[0]->Alw_ID;
                }

                if (empty($Allowances[7]->Alw_ID)) {
                    $Allowance_ID_2 = 0;
                } else {
                    $Allowance_ID_2 = $Allowances[1]->Alw_ID;
                }

                if (empty($Allowances[8]->Alw_ID)) {
                    $Allowance_ID_3 = 0;
                } else {
                    $Allowance_ID_3 = $Allowances[2]->Alw_ID;
                }


                if (empty($Allowances[9]->Alw_ID)) {
                    $Allowance_ID_4 = 0;
                } else {
                    $Allowance_ID_4 = $Allowances[3]->Alw_ID;
                }

                if (empty($Allowances[10]->Alw_ID)) {
                    $Allowance_ID_5 = 0;
                } else {
                    $Allowance_ID_5 = $Allowances[4]->Alw_ID;
                }

                /*
                 * Deduction Details
                 */

                if (empty($Deductions[0]->Ded_ID)) {
                    $Deduction_ID_1 = 0;
                } else {
                    $Deduction_ID_1 = $Deductions[0]->Ded_ID;
                }

                if (empty($Deductions[1]->Ded_ID)) {
                    $Deduction_ID_2 = 0;
                } else {
                    $Deduction_ID_2 = $Deductions[1]->Ded_ID;
                }

                if (empty($Deductions[2]->Ded_ID)) {
                    $Deduction_ID_3 = 0;
                } else {
                    $Deduction_ID_3 = $Deductions[2]->Ded_ID;
                }

                //Get Overtime details
                $Overtime_DB = $this->Db_model->getfilteredData("select sum(DOT) as D_OT from tbl_individual_roster where EmpNo='$EmpNo' and EXTRACT(MONTH FROM FDate)=$month and  EXTRACT(YEAR FROM FDate) =$year");
                $Overtime = $this->Db_model->getfilteredData("select sum(AfterExH) as N_OT from tbl_individual_roster where EmpNo='$EmpNo' and EXTRACT(MONTH FROM FDate)=$month and  EXTRACT(YEAR FROM FDate) =$year");

                $N_OT_Hours = $Overtime[0]->N_OT;

                $D_OT_Hours = $Overtime_DB[0]->D_OT;

                $OT_Rate = ((($BasicSal + $Fixed_Allowance) / 187) * 1.5);
                $N_OT_Amount = $OT_Rate * ($N_OT_Hours / 60);

                $OT_Rate_2 = ((($BasicSal + $Fixed_Allowance) / 187) * 2);
                $D_OT_Amount = $OT_Rate_2 * ($D_OT_Hours / 60);

                //*** Get Late Minutes
                $Late_Amount = 0;
                $Late_Min = $this->Db_model->getfilteredData("select sum(LateM) as LateMin from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and RYear=$year AND ShType = 'DU' ");

                //*** Late Min
                if (empty($Late_Min[0]->LateMin)) {
                    $Late_Min = 0;
                } else {
                    $Late_Min = $Late_Min[0]->LateMin;
                }

                $Late_rate = (($BasicSal / 187)) / 60;
                $Late_Amount = ($Late_rate * $Late_Min);

                $ed_amount = 0;
                $earlydepature = $this->Db_model->getfilteredData("select SUM(EarlyDepMin) as ed from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and RYear=$year AND ShType = 'DU' ");
                if (empty($earlydepature[0]->ed)) {
                    $ed_min = 0;
                } else {
                    $ed_min = $earlydepature[0]->ed;
                }

                $ed_rate = ((($BasicSal/ 187)) /60);
                $ed_amount = $ed_min * $ed_rate;

                //All budgetrelevances
                $budgetrelevances = $budgetrelevance1 + $budgetrelevance2;
                //All Allowances
                $Allowances = $tbSPAllowance + $tbTraveling + $tbTransport + $tbFuel + $tbAttendances + $tbPerformance + $Allowance_2 + $Allowance_3;

                //Calculate Gross salary
                $Gross_sal = ($BasicSal + $Fixed_Allowance + $Incentive + $budgetrelevances);

                /*
                *payee tax calculate start
                */
                $st_gross_Pay = $Gross_sal * 12;


                $free_rate = 100000;
                $anual_freee_rate = $free_rate * 12;
                $payee_now_amount = 0;

                $calculate_gross_pay = $st_gross_Pay - $anual_freee_rate;

                if (0 > $calculate_gross_pay) {
                    $payee_now_amount = 0;
                } else {
                    if (0 < $calculate_gross_pay) {
                        if ($calculate_gross_pay >= 500000) {
                            $payeeamount = (500000 / 12) * ($payee[0]->Tax_rate / 100);
                            $calculate_gross_pay -= 500000;
                            $payee_now_amount += $payeeamount;
                        } else if (0 < $calculate_gross_pay && $calculate_gross_pay < 500000) {
                            $payeeamount = ($calculate_gross_pay / 12) * ($payee[0]->Tax_rate / 100);
                            $calculate_gross_pay -= 500000;
                            $payee_now_amount += $payeeamount;
                        }
                    }
                    if (0 < $calculate_gross_pay) {
                        if ($calculate_gross_pay >= 500000) {
                            $payeeamount = (500000 / 12) * ($payee[1]->Tax_rate / 100);
                            $calculate_gross_pay -= 500000;
                            $payee_now_amount += $payeeamount;
                        } else if (0 < $calculate_gross_pay && $calculate_gross_pay < 500000) {
                            $payeeamount = ($calculate_gross_pay / 12) * ($payee[1]->Tax_rate / 100);
                            $calculate_gross_pay -= 500000;
                            $payee_now_amount += $payeeamount;
                        }
                    }
                    if (0 < $calculate_gross_pay) {
                        if ($calculate_gross_pay >= 500000) {
                            $payeeamount = (500000 / 12) * ($payee[2]->Tax_rate / 100);
                            $calculate_gross_pay -= 500000;
                            $payee_now_amount += $payeeamount;
                        } else if (0 < $calculate_gross_pay && $calculate_gross_pay < 500000) {
                            $payeeamount = ($calculate_gross_pay / 12) * ($payee[2]->Tax_rate / 100);
                            $calculate_gross_pay -= 500000;
                            $payee_now_amount += $payeeamount;
                        }
                    }
                    if (0 < $calculate_gross_pay) {
                        if ($calculate_gross_pay >= 500000) {
                            $payeeamount = (500000 / 12) * ($payee[3]->Tax_rate / 100);
                            $calculate_gross_pay -= 500000;
                            $payee_now_amount += $payeeamount;
                        } else if (0 < $calculate_gross_pay && $calculate_gross_pay < 500000) {
                            $payeeamount = ($calculate_gross_pay / 12) * ($payee[3]->Tax_rate / 100);
                            $calculate_gross_pay -= 500000;
                            $payee_now_amount += $payeeamount;
                        }
                    }
                    if (0 < $calculate_gross_pay) {
                        if ($calculate_gross_pay >= 500000) {
                            $payeeamount = (500000 / 12) * ($payee[4]->Tax_rate / 100);
                            $calculate_gross_pay -= 500000;
                            $payee_now_amount += $payeeamount;
                        } else if (0 < $calculate_gross_pay && $calculate_gross_pay < 500000) {
                            $payeeamount = ($calculate_gross_pay / 12) * ($payee[4]->Tax_rate / 100);
                            $calculate_gross_pay -= 500000;
                            $payee_now_amount += $payeeamount;
                        }
                    }
                    if (0 < $calculate_gross_pay) {
                        $payeeamount = ($calculate_gross_pay / 12) * ($payee[5]->Tax_rate / 100);
                        $calculate_gross_pay -= 500000;
                        $payee_now_amount += $payeeamount;
                    }
                }
                /*
                *payee tax calculate end
                */

                //Calculate EPF Employee
                $EPF_Worker = (8 / 100) * ($BasicSal + $Fixed_Allowance + $budgetrelevances);

                //Total for epf
                $tottal_for_epf = $BasicSal + $Fixed_Allowance + $budgetrelevances;

                //Calculate EPF Employer
                $EPF_Employer = (12 / 100) * ($BasicSal + $Fixed_Allowance + $budgetrelevances);

                //Calculate ETF Employee
                $ETF = (3 / 100) * ($BasicSal + $Fixed_Allowance + $budgetrelevances);

                //Calculate Total Deductions
                $Tot_deductions = $payee_now_amount + $EPF_Worker + $Sal_advance + $Festivel_Advance + $uniform + $other + $deduction1 + $deduction2 + $LoanMonth + $Late_Amount + $Nopay_Deduction + $ed_amount;

                //Calculate Net Salary
                $netSal = ($Gross_sal + $N_OT_Amount + $D_OT_Amount + $Att_Allowance + $Allowances) - $Tot_deductions;

                //calculate Gross pay
                $grosspay = $Gross_sal + $Allowances;

                $D_Salary = $grosspay - $Tot_deductions;

                $data = array(
                    array(
                        'EmpNo' => $EmpNo,
                        'EPFNO' => $EpfNo,
                        'Month' => $month,
                        'Year' => $year,
                        'Basic_sal' => $BasicSal,
                        'Total_F_Epf' => $tottal_for_epf,
                        'Br_pay' => $budgetrelevances,
                        'Incentive' => $Incentive,
                        'Dep_ID' => $Dep_ID,
                        'Des_ID' => $Des_ID,
                        'No_Pay_days' => $NopayDays,
                        'no_pay_deduction' => $Nopay_Deduction,
                        'EPF_Worker_Rate' => 8,
                        'EPF_Worker_Amount' => $EPF_Worker,
                        'EPF_Employee_Rate' => 12,
                        'EPF_Employee_Amount' => $EPF_Employer,
                        'ETF_Rate' => 3,
                        'ETF_Amount' => $ETF,
                        'Loan_Instalment' => $LoanMonth,
                        'Salary_advance' => $Sal_advance,
                        'Ed_min' => $ed_min,
                        'Late_min' => $Late_Min,
                        'Ed_deduction' => $ed_amount,
                        'Late_deduction' => $Late_Amount,
                        'Alw_ID_1' => 0,
                        'Allowance_1' => 0,
                        'Alw_ID_2' => $Allowance_ID_2,
                        'Increment' => $Allowance_2,
                        'Alw_ID_3' => $Allowance_ID_3,
                        'Other_OT' => $Allowance_3,
                        'Alw_ID_4' => $Allowance_ID_4,
                        'Allowance_4' => 0,
                        'Alw_ID_5' => $Allowance_ID_5,
                        'Allowance_5' => 0,
                        'Performance' => $tbPerformance,
                        'Attendances' => $tbAttendances,
                        'Fuel' => $tbFuel,
                        'Transport' => $tbTransport,
                        'Traveling' => $tbTraveling,
                        'SPAllowance' => $tbSPAllowance,
                        'Normal_OT_Hrs' => ($N_OT_Hours / 60),
                        'Normal_OT_Pay' => $N_OT_Amount,
                        'Double_OT_Hrs' => ($D_OT_Hours / 60),
                        'Double_OT_Pay' => $D_OT_Amount,
                        'Uniform' => $uniform,
                        'Ded_ID_1' => $Deduction_ID_1,
                        'Deduct_1' => $other,
                        'Ded_ID_2' => $Deduction_ID_2,
                        'Deduct_2' => $deduction1,
                        'Ded_ID_3' => $Deduction_ID_3,
                        'Deduct_3' => $deduction2,
                        'Wellfare' => $welfair_1,
                        'Payee_amount' => $payee_now_amount,
                        'Stamp_duty' => $stamp_Duty1,
                        'tot_deduction' => $Tot_deductions,
                        'Gross_pay' => $grosspay,
                        'Gross_sal' => $Gross_sal,
                        'D_Salary' => $D_Salary,
                        'Net_salary' => $netSal
                    )
                );

                $this->db->insert_batch('tbl_salary', $data);

                if (empty($Loan[0]->Paid_Amount)) {
                    $PaidAmount = 0;
                } else {
                    $PaidAmount = $Loan[0]->Paid_Amount;
                }

                $PaidAmount_to = $PaidAmount + $LoanMonth;

                if (empty($Loan[0]->FullAmount)) {
                    $Full_Amount = 0;
                } else {
                    $Full_Amount = $Loan[0]->FullAmount;
                }

                $BalanceAmount = $Full_Amount - $PaidAmount_to;

                if ($BalanceAmount <= 0) {
                    $Is_Settele = 1;
                } else {
                    $Is_Settele = 0;
                }

                $data_loan = array(
                    'EmpNo' => $EmpNo,
                    'Paid_Amount' => $PaidAmount_to,
                    'Balance_amount' => $BalanceAmount,
                    'Is_Settled' => $Is_Settele,
                );

                $whereArray_loan = array("EmpNo" => $EmpNo);
                $result = $this->Db_model->updateData("tbl_loans", $data_loan, $whereArray_loan);

                $this->session->set_flashdata('success_message', 'Allovance added successfully');
            }
        }
  
        $this->session->set_flashdata('success_message', 'Payroll Process successfully');
        redirect(base_url() . 'Pay/Payroll_Process');
    }
}