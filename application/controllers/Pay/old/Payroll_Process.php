<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_Process extends CI_Controller {

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

        $this->load->helper('url');
        $data['title'] = "Payroll Process | HRM SYSTEM";
        $data['data_emp'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $this->load->view('Payroll/Payroll_process/index', $data);
    }

    /*
     * Payroll Process
     */

   public function emp_payroll_process() {

    date_default_timezone_set('Asia/Colombo');
        $year = date("Y");
        $month = $this->input->post('cmb_month');

        $date = date_create();
        $timestamp = date_format($date, 'Y-m-d H:i:s');

        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("SELECT EmpNo,Enroll_No, EPFNO,Dep_ID,Des_ID,RosterCode, Status  FROM  tbl_empmaster where status=1");

        //For loop for All active employees 
        for ($x = 0; $x < count($dtEmp['EmpData']); $x++) {

            $EmpNo = $dtEmp['EmpData'][$x]->EmpNo;
            $EpfNo = $dtEmp['EmpData'][$x]->EPFNO;
            $Dep_ID = $dtEmp['EmpData'][$x]->Dep_ID;
            $Des_ID = $dtEmp['EmpData'][$x]->Des_ID;


            $HasRow = $this->Db_model->getfilteredData("select count(EmpNo) as HasRow from tbl_salary where EmpNo=$EmpNo and month=$month and year=$year");


            //            var_dump($HasRow);die;
            //IF Salary records have in Salary table update salary records into salary table

            if ($HasRow[0]->HasRow > 0) {

                //            var_dump($dtEmp['EmpData']);die;
                //Get Employee Basic Salary | Incentive
                $SalData = $this->Db_model->getfilteredData("select EmpNo,EPFNO, Is_EPF,Dep_ID, Des_ID,Basic_Salary,Fixed_Allowance,Incentive,is_nopay_calc from tbl_empmaster where EmpNo=$EmpNo");
                $BasicSal = $SalData[0]->Basic_Salary;
                $Incentive = $SalData[0]->Incentive;
                // echo $Incentive;
                $Fixed_Allowance = $SalData[0]->Fixed_Allowance;
                $Is_EPF = $SalData[0]->Is_EPF;
                $is_no_pay = $SalData[0]->is_nopay_calc;
                

                //Get Nopay days in Individual Roster table
                $Nopay = $this->Db_model->getfilteredData("select sum(nopay) as nopay, sum(nopay_hrs) nopay_hrs,sum(Att_Allow) as Att_Allow from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and EXTRACT(YEAR FROM FDate)=$year");
                
                $Nopay_Hrs = $Nopay[0]->nopay_hrs;

                $NopayDays = $Nopay[0]->nopay;

                if ($NopayDays == null) {
                    $NopayDays = 0;
                }
                //**** Calculate no pay amount
                $NopayRate = ($BasicSal+$Incentive) / 30;
                $Nopay_Deduction = $NopayRate * $NopayDays;

                //Get Variable Allowances details
                $Allowances = $this->Db_model->getfilteredData("select Alw_ID, Amount from tbl_varialble_allowance where EmpNo=$EmpNo and Month=$month and Year=$year");

                //Get Variable Deductions details
                $Deductions = $this->Db_model->getfilteredData("select Ded_ID,Amount from tbl_variable_deduction where EmpNo=$EmpNo and Month=$month and Year=$year");

                //Get Salary Advance details
                $Sal_Advance = $this->Db_model->getfilteredData("select Amount from tbl_salary_advance where Is_Approve=1 and EmpNo=$EmpNo and month=$month and year = $year");

                $Fest_Advance = $this->Db_model->getfilteredData("SELECT Amount from tbl_festivel_advance where EmpNo=$EmpNo and Month=$month and Year = $year");

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
                 * Allowance Details
                 */


                if (empty($Allowances[0]->Alw_ID)) {
                    $Allowance_ID_1 = 0;
                } else {
                    $Allowance_ID_1 = $Allowances[0]->Alw_ID;
                }

                if (empty($Allowances[0]->Amount)) {
                    $Allowance_1 = 0;
                } else {
                    $Allowance_1 = $Allowances[0]->Amount;
                }

                if (empty($Allowances[1]->Alw_ID)) {
                    $Allowance_ID_2 = 0;
                } else {
                    $Allowance_ID_2 = $Allowances[1]->Alw_ID;
                }

                if (empty($Allowances[1]->Amount)) {
                    $Allowance_2 = 0;
                } else {
                    $Allowance_2 = $Allowances[1]->Amount;
                }

                if (empty($Allowances[2]->Alw_ID)) {
                    $Allowance_ID_3 = 0;
                } else {
                    $Allowance_ID_3 = $Allowances[2]->Alw_ID;
                }

                if (empty($Allowances[2]->Amount)) {
                    $Allowance_3 = 0;
                } else {
                    $Allowance_3 = $Allowances[2]->Amount;
                }

                /*
                 * Deduction Details
                 */

                if (empty($Deductions[0]->Ded_ID)) {
                    $Deduction_ID_1 = 0;
                } else {
                    $Deduction_ID_1 = $Deductions[0]->Ded_ID;
                }

                if (empty($Deductions[0]->Amount)) {
                    $Deduction_1 = 0;
                } else {
                    $Deduction_1 = $Deductions[0]->Amount;
                }

                if (empty($Deductions[1]->Ded_ID)) {
                    $Deduction_ID_2 = 0;
                } else {
                    $Deduction_ID_2 = $Deductions[1]->Ded_ID;
                }

                if (empty($Deductions[1]->Amount)) {
                    $Deduction_2 = 0;
                } else {
                    $Deduction_2 = $Deductions[1]->Amount;
                }

                if (empty($Deductions[2]->Ded_ID)) {
                    $Deduction_ID_3 = 0;
                } else {
                    $Deduction_ID_3 = $Deductions[2]->Ded_ID;
                }

                if (empty($Deductions[2]->Amount)) {
                    $Deduction_3 = 0;
                } else {
                    $Deduction_3 = $Deductions[2]->Amount;
                }





                //Get Overtime details
                //                $Overtime = $this->Db_model->getfilteredData("select sum(ApprovedExH) as OT from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and RYear=$year");
                //---------Normal OT Calculation
                //                $Overtime = $this->Db_model->getfilteredData("select sum(OT_Min) as N_OT from tbl_ot_d where EmpNo='$EmpNo' and RateCode = 1.5 and EXTRACT(MONTH FROM OTDate)=$month and  EXTRACT(YEAR FROM OTDate) =$year");
                //
                //                $N_OT_Hours = $Overtime[0]->N_OT;

                //Get Overtime details
                $Overtime = $this->Db_model->getfilteredData("select sum(AfterExH) as OT from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and RYear=$year");
                // $Overtime = $this->Db_model->getfilteredData("SELECT SUM(AfterExH) AS OT FROM tbl_individual_roster WHERE EmpNo = $EmpNo AND RYear = '2024' AND FDate >= '2024-02-01' AND TDate <= '2024-02-29' AND ShType = 'DU' AND AfterExH > 0");

                $OT_Hours = $Overtime[0]->OT;
                $OTHH =  $OT_Hours / 60;


                // Petco
                $OT_Rate = ((($BasicSal+$Incentive) / 30 / 9) * 1);
                // $OT_Rate = 173.5;

                // IF Employee work less than 30min they havent Over time
                // if ($OT_Hours < 30) {
                //     $OT_Hours = 0;
                //     $OT_Amount = 0;
                // }
                //Else calculate Over time
                // else {
                $OT_Amount = $OT_Rate * $OTHH;
                // }
                // Non Ot Workers
                if ($EmpNo == 10 || $EmpNo == 15 || $EmpNo == 7) {
                    $OTHH = 0;
                    $OT_Amount = 0;
                }
                //petco lanka late deduction process start
                $Late_rate = 0;
                $Late_Amount = 0;
                $attbchance = 3;
                $rounded_number = 0;
                $latealldata = $this->Db_model->getfilteredData("select InTime,LateM from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and RYear=$year AND ShType = 'DU' ");

                foreach ($latealldata as $ld) {
                    if ($ld->LateM <= 10 && $ld->LateM > 0) {
                        if ($attbchance <= 0) {
                            $Late_rate = (($BasicSal+$Incentive) / 540);
                            $Late_Amount = ($Late_rate * 1) + $Late_Amount;
                            $attbchance = 0;
                        }
                        $attbchance = $attbchance - 1;
                    } else if ($ld->LateM <= 15 && $ld->LateM > 10) {
                        $Late_rate = (($BasicSal+$Incentive) / 540);
                        $Late_Amount = ($Late_rate * 1) + $Late_Amount;
                        $attbchance = 0;
                    } else if ($ld->LateM <= 30 && $ld->LateM > 15) {
                        $Late_rate = (($BasicSal+$Incentive) / 270);
                        $Late_Amount = ($Late_rate * 1) + $Late_Amount;
                        $attbchance = 0;
                    } else if ($ld->LateM <= 120 && $ld->LateM > 30) {
                        $Late_rate = (($BasicSal+$Incentive) / 270);
                        $rounded_number = ceil(($ld->LateM) / 30);
                        $Late_Amount = ($Late_rate * $rounded_number) + $Late_Amount;
                        $attbchance = 0;
                    } else if ($ld->LateM > 120) {
                        $Late_rate = (($BasicSal+$Incentive) / 60);
                        $Late_Amount = ($Late_rate * 1) + $Late_Amount;
                        $attbchance = 0;
                    }
                }

                //early depature amount
                $ed_amount = 0;
                $earlydepature = $this->Db_model->getfilteredData("select SUM(EarlyDepMin) as ed from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and RYear=$year AND ShType = 'DU' ");
                if (empty($earlydepature[0]->ed)) {
                    $ed_min = 0;
                } else {
                    $ed_min = $earlydepature[0]->ed;
                }
                $edhours =  $ed_min / 60;
                $ed_rate = ((($BasicSal+$Incentive) / 30 / 9) * 1);
                $ed_amount = $edhours * $ed_rate;
                //early depature amount

                //attendence allowence
                if ($attbchance > 0) {
                    $Att_Allowance = 7500;
                } else {
                    $Att_Allowance = 0;
                }

                //petco lanka late deduction process end

                // //*** Get Late Minutes
                // $Late_Min = $this->Db_model->getfilteredData("SELECT sum(LateM) as LateMin FROM tbl_individual_roster WHERE EmpNo = $EmpNo AND RYear = '2024' AND FDate >= '2024-02-01' AND TDate <= '2024-02-29' AND ShType = 'DU'");
                $Late_Min = $this->Db_model->getfilteredData("select sum(LateM) as LateMin from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and RYear=$year");


                // // *** Late Min

                if (empty($Late_Min[0]->LateMin)) {
                    $Late_Min = 0;
                } else {
                    $Late_Min = $Late_Min[0]->LateMin;
                }


                // $Late_rate = (($BasicSal / 240)/60 );
                // //** Late Amount
                // $Late_Amount = $Late_rate * $Late_Min;


                //All Allowances
                $Allowances = $Allowance_1 + $Allowance_2 + $Allowance_3;



                //Calculate Gross salary
                $Gross_sal = $BasicSal + $Incentive + $Fixed_Allowance;

                
                //Calculate EPF Employee
                $EPF_Worker = (8 / 100) * ($BasicSal + $Fixed_Allowance);
                //Calculate EPF Employer
                $EPF_Employer = (12 / 100) * ($BasicSal + $Fixed_Allowance);

                //Calculate ETF Employee
                $ETF = (3 / 100) * ($BasicSal + $Fixed_Allowance);
                



                $SalData = $this->Db_model->getfilteredData("select EmpNo,EPFNO, Is_EPF,Dep_ID, Des_ID,Basic_Salary,Fixed_Allowance,Incentive,is_nopay_calc from tbl_empmaster where EmpNo=$EmpNo");
                $Is_EPF = $SalData[0]->Is_EPF;

                if ($Is_EPF == 0) {
                    $EPF_Worker = 0;
                    $EPF_Employer = 0;
                    $ETF = 0;
                }
                //Calculate Total Deductions
                $Tot_deductions = $EPF_Worker + $Sal_advance + $Festivel_Advance + $Deduction_1 + $Deduction_2 + $Deduction_3 + $LoanMonth + $Late_Amount + $Nopay_Deduction + $ed_amount;

                //Calculate Net Salary
                $netSal = ($Gross_sal + $OT_Amount + $Att_Allowance + $Allowances) - $Tot_deductions;

                $data = array(
                    'EmpNo' => $EmpNo,
                    'EPFNO' => $EpfNo,
                    'Basic_sal' => $BasicSal,
                    'Incentive' => $Incentive,
                    'Dep_ID' => $Dep_ID,
                    'Des_ID' => $Des_ID,
                    'No_Pay_days' => $NopayDays,
                    'No_Pay_Hrs' => $Nopay_Hrs,
                    'no_pay_deduction' => $Nopay_Deduction,
                    'EPF_Worker_Rate' => 8,
                    'EPF_Worker_Amount' => $EPF_Worker,
                    'EPF_Employee_Rate' => 12,
                    'EPF_Employee_Amount' => $EPF_Employer,
                    'ETF_Rate' => 3,
                    'ETF_Amount' => $ETF,
                    'Loan_Instalment' => $LoanMonth,
                    'Salary_advance' => $Sal_advance,
                    'Late_min' => $Late_Min,
                    'Late_deduction' => round($Late_Amount, 2),
                    'Early_departure' => round($ed_amount, 2),
                    'Ed_min' => $ed_min,
                    'Alw_ID_1' => $Allowance_ID_1,
                    'Allowance_1' => $Allowance_1,
                    'Alw_ID_2' => $Allowance_ID_2,
                    'Allowance_2' => $Allowance_2,
                    'Alw_ID_3' => $Allowance_ID_3,
                    'Allowance_3' => $Allowance_3,
                    'Att_Allowance' => $Att_Allowance,
                    'Normal_OT_Hrs' => $OTHH,
                    'Normal_OT_Pay' => $OT_Amount,
                    'Ded_ID_1' => $Deduction_ID_1,
                    'Deduct_1' => $Deduction_1,
                    'Ded_ID_2' => $Deduction_ID_2,
                    'Deduct_2' => $Deduction_2,
                    'Ded_ID_3' => $Deduction_ID_3,
                    'Deduct_3' => $Deduction_3,

                    'tot_deduction' => $Tot_deductions,
                    'Gross_sal' => $Gross_sal,
                    'Net_salary' => $netSal,
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

                if ($BalanceAmount == 0) {
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


                //die;
                //*******Else Salary records haven't in Salary table insert salary records into salary table

            } else {


                $SalData = $this->Db_model->getfilteredData("select EmpNo,EPFNO, Dep_ID, Des_ID,Basic_Salary,Incentive,Fixed_Allowance,Is_EPF,is_nopay_calc from tbl_empmaster where EmpNo=$EmpNo");
                $BasicSal = $SalData[0]->Basic_Salary;
                $Incentive = $SalData[0]->Incentive;
                $Fixed_Allowance = $SalData[0]->Fixed_Allowance;
                $Is_EPF = $SalData[0]->Is_EPF;
                $is_no_pay = $SalData[0]->is_nopay_calc;

                //**** Get Nopay days
                // $Nopay = $this->Db_model->getfilteredData("SELECT sum(nopay) as nopay FROM tbl_individual_roster WHERE EmpNo = $EmpNo AND RYear = '2024' AND FDate >= '2024-02-01' AND TDate <= '2024-02-29' AND ShType = 'DU'");
                $Nopay = $this->Db_model->getfilteredData("select sum(nopay) as nopay, sum(nopay_hrs) nopay_hrs,sum(Att_Allow) as Att_Allow from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and EXTRACT(YEAR FROM FDate)=$year");
                $Nopay_Hrs = $Nopay[0]->nopay_hrs;
                $NopayDays = $Nopay[0]->nopay;

                if ($NopayDays == null) {
                    $NopayDays = 0;
                }
                //**** Calculate no pay amount
                $NopayRate = ($BasicSal+$Incentive) / 30;
                $Nopay_Deduction = $NopayRate * $NopayDays;

                //**** Get Allowance Details
                $Allowances = $this->Db_model->getfilteredData("select Alw_ID, Amount from tbl_varialble_allowance where EmpNo=$EmpNo and Month=$month and Year=$year");

                //**** Get deduction Details
                $Deductions = $this->Db_model->getfilteredData("select Ded_ID,Amount from tbl_variable_deduction where EmpNo=$EmpNo and Month=$month and Year=$year");

                //**** Get salary advance
                $Sal_Advance = $this->Db_model->getfilteredData("select Amount from tbl_salary_advance where Is_Approve=1 and EmpNo=$EmpNo and month=$month and year = $year");
                $Fest_Advance = $this->Db_model->getfilteredData("SELECT Amount from tbl_festivel_advance where EmpNo=$EmpNo and Month=$month and Year = $year");

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
                 * Allowance Details
                 */


                if (empty($Allowances[0]->Alw_ID)) {
                    $Allowance_ID_1 = 0;
                } else {
                    $Allowance_ID_1 = $Allowances[0]->Alw_ID;
                }

                if (empty($Allowances[0]->Amount)) {
                    $Allowance_1 = 0;
                } else {
                    $Allowance_1 = $Allowances[0]->Amount;
                }

                if (empty($Allowances[1]->Alw_ID)) {
                    $Allowance_ID_2 = 0;
                } else {
                    $Allowance_ID_2 = $Allowances[1]->Alw_ID;
                }

                if (empty($Allowances[1]->Amount)) {
                    $Allowance_2 = 0;
                } else {
                    $Allowance_2 = $Allowances[1]->Amount;
                }

                if (empty($Allowances[2]->Alw_ID)) {
                    $Allowance_ID_3 = 0;
                } else {
                    $Allowance_ID_3 = $Allowances[2]->Alw_ID;
                }

                if (empty($Allowances[2]->Amount)) {
                    $Allowance_3 = 0;
                } else {
                    $Allowance_3 = $Allowances[2]->Amount;
                }

                /*
                 * Deduction Details
                 */

                if (empty($Deductions[0]->Ded_ID)) {
                    $Deduction_ID_1 = 0;
                } else {
                    $Deduction_ID_1 = $Deductions[0]->Ded_ID;
                }

                if (empty($Deductions[0]->Amount)) {
                    $Deduction_1 = 0;
                } else {
                    $Deduction_1 = $Deductions[0]->Amount;
                }

                if (empty($Deductions[1]->Ded_ID)) {
                    $Deduction_ID_2 = 0;
                } else {
                    $Deduction_ID_2 = $Deductions[1]->Ded_ID;
                }

                if (empty($Deductions[1]->Amount)) {
                    $Deduction_2 = 0;
                } else {
                    $Deduction_2 = $Deductions[1]->Amount;
                }

                if (empty($Deductions[2]->Ded_ID)) {
                    $Deduction_ID_3 = 0;
                } else {
                    $Deduction_ID_3 = $Deductions[2]->Ded_ID;
                }

                if (empty($Deductions[2]->Amount)) {
                    $Deduction_3 = 0;
                } else {
                    $Deduction_3 = $Deductions[2]->Amount;
                }

                //Get Overtime details
                $Overtime = $this->Db_model->getfilteredData("select sum(AfterExH) as OT from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and RYear=$year");
                // $Overtime = $this->Db_model->getfilteredData("SELECT SUM(AfterExH) AS OT FROM tbl_individual_roster WHERE EmpNo = $EmpNo AND RYear = '2024' AND FDate >= '2024-02-01' AND TDate <= '2024-02-29' AND ShType = 'DU' AND AfterExH > 0");

                $OT_Hours = $Overtime[0]->OT;
                $OTHH =  $OT_Hours / 60;


                // Petco
                $OT_Rate = ((($BasicSal+$Incentive) / 30 / 9) * 1);
                // $OT_Rate = 173.5;

                // IF Employee work less than 30min they havent Over time
                // if ($OT_Hours < 30) {
                //     $OT_Hours = 0;
                //     $OT_Amount = 0;
                // }
                //Else calculate Over time
                // else {
                $OT_Amount = $OT_Rate * $OTHH;
                // }
                // Non Ot Workers
                if ($EmpNo == 10 || $EmpNo == 15 || $EmpNo == 7) {
                    $OTHH = 0;
                    $OT_Amount = 0;
                }
                //petco lanka late deduction process start
                $Late_rate = 0;
                $Late_Amount = 0;
                $attbchance = 3;
                $rounded_number = 0;
                $latealldata = $this->Db_model->getfilteredData("select InTime,LateM from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and RYear=$year AND ShType = 'DU' ");

                foreach ($latealldata as $ld) {
                    if ($ld->LateM <= 10 && $ld->LateM > 0) {
                        if ($attbchance <= 0) {
                            $Late_rate = (($BasicSal+$Incentive) / 540);
                            $Late_Amount = ($Late_rate * 1) + $Late_Amount;
                            $attbchance = 0;
                        }
                        $attbchance = $attbchance - 1;
                    } else if ($ld->LateM <= 15 && $ld->LateM > 10) {
                        $Late_rate = (($BasicSal+$Incentive) / 540);
                        $Late_Amount = ($Late_rate * 1) + $Late_Amount;
                        $attbchance = 0;
                    } else if ($ld->LateM <= 30 && $ld->LateM > 15) {
                        $Late_rate = (($BasicSal+$Incentive) / 270);
                        $Late_Amount = ($Late_rate * 1) + $Late_Amount;
                        $attbchance = 0;
                    } else if ($ld->LateM <= 120 && $ld->LateM > 30) {
                        $Late_rate = (($BasicSal+$Incentive) / 270);
                        $rounded_number = ceil(($ld->LateM) / 30);
                        $Late_Amount = ($Late_rate * $rounded_number) + $Late_Amount;
                        $attbchance = 0;
                    } else if ($ld->LateM > 120) {
                        $Late_rate = (($BasicSal+$Incentive) / 60);
                        $Late_Amount = ($Late_rate * 1) + $Late_Amount;
                        $attbchance = 0;
                    }
                }

                //early depature amount
                $ed_amount = 0;
                $earlydepature = $this->Db_model->getfilteredData("select SUM(EarlyDepMin) as ed from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and RYear=$year AND ShType = 'DU' ");
                if (empty($earlydepature[0]->ed)) {
                    $ed_min = 0;
                } else {
                    $ed_min = $earlydepature[0]->ed;
                }
                $edhours =  $ed_min / 60;
                $ed_rate = ((($BasicSal+$Incentive) / 30 / 9) * 1);
                $ed_amount = $edhours * $ed_rate;
                //early depature amount

                //attendence allowence
                if ($attbchance > 0) {
                    $Att_Allowance = 7500;
                } else {
                    $Att_Allowance = 0;
                }

                //petco lanka late deduction process end

                // //*** Get Late Minutes
                // $Late_Min = $this->Db_model->getfilteredData("SELECT sum(LateM) as LateMin FROM tbl_individual_roster WHERE EmpNo = $EmpNo AND RYear = '2024' AND FDate >= '2024-02-01' AND TDate <= '2024-02-29' AND ShType = 'DU'");
                $Late_Min = $this->Db_model->getfilteredData("select sum(LateM) as LateMin from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and RYear=$year");


                // // *** Late Min

                if (empty($Late_Min[0]->LateMin)) {
                    $Late_Min = 0;
                } else {
                    $Late_Min = $Late_Min[0]->LateMin;
                }


                // $Late_rate = (($BasicSal / 240)/60 );
                // //** Late Amount
                // $Late_Amount = $Late_rate * $Late_Min;


                //All Allowances
                $Allowances = $Allowance_1 + $Allowance_2 + $Allowance_3;



                //Calculate Gross salary
                $Gross_sal = $BasicSal + $Incentive + $Fixed_Allowance;

                //Calculate EPF Employee
                $EPF_Worker = (8 / 100) * ($BasicSal + $Fixed_Allowance);
                //Calculate EPF Employer
                $EPF_Employer = (12 / 100) * ($BasicSal + $Fixed_Allowance);

                //Calculate ETF Employee
                $ETF = (3 / 100) * ($BasicSal + $Fixed_Allowance);




                $SalData = $this->Db_model->getfilteredData("select EmpNo,EPFNO, Is_EPF,Dep_ID, Des_ID,Basic_Salary,Fixed_Allowance,Incentive,is_nopay_calc from tbl_empmaster where EmpNo=$EmpNo");
                $Is_EPF = $SalData[0]->Is_EPF;

                if ($Is_EPF == 0) {
                    $EPF_Worker = 0;
                    $EPF_Employer = 0;
                    $ETF = 0;
                }
                //Calculate Total Deductions
                $Tot_deductions = $EPF_Worker + $Sal_advance + $Festivel_Advance + $Deduction_1 + $Deduction_2 + $Deduction_3 + $LoanMonth + $Late_Amount + $Nopay_Deduction + $ed_amount;

                //Calculate Net Salary
                $netSal = ($Gross_sal + $OT_Amount + $Att_Allowance + $Allowances) - $Tot_deductions;

                $data = array(
                    array(
                        'EmpNo' => $EmpNo,
                        'EPFNO' => $EpfNo,
                        'Month' => $month,
                        'Year' => $year,
                        'Basic_sal' => $BasicSal,
                        'Incentive' => $Incentive,
                        'Dep_ID' => $Dep_ID,
                        'Des_ID' => $Des_ID,
                        'No_Pay_days' => $NopayDays,
                        'No_Pay_Hrs' => $Nopay_Hrs,
                        'no_pay_deduction' => $Nopay_Deduction,
                        'EPF_Worker_Rate' => 8,
                        'EPF_Worker_Amount' => $EPF_Worker,
                        'EPF_Employee_Rate' => 12,
                        'EPF_Employee_Amount' => $EPF_Employer,
                        'ETF_Rate' => 3,
                        'ETF_Amount' => $ETF,
                        'Loan_Instalment' => $LoanMonth,
                        'Salary_advance' => $Sal_advance,
                        'Late_min' => $Late_Min,
                        'Late_deduction' => round($Late_Amount, 2),
                        'Early_departure' => round($ed_amount, 2),
                        'Ed_min' => $ed_min,
                        'Alw_ID_1' => $Allowance_ID_1,
                        'Allowance_1' => $Allowance_1,
                        'Alw_ID_2' => $Allowance_ID_2,
                        'Allowance_2' => $Allowance_2,
                        'Alw_ID_3' => $Allowance_ID_3,
                        'Allowance_3' => $Allowance_3,
                        'Att_Allowance' => $Att_Allowance,
                        'Normal_OT_Hrs' => $OTHH,
                        'Normal_OT_Pay' => $OT_Amount,
                        'Ded_ID_1' => $Deduction_ID_1,
                        'Deduct_1' => $Deduction_1,
                        'Ded_ID_2' => $Deduction_ID_2,
                        'Deduct_2' => $Deduction_2,
                        'Ded_ID_3' => $Deduction_ID_3,
                        'Deduct_3' => $Deduction_3,
                        'tot_deduction' => $Tot_deductions,
                        'Gross_sal' => $Gross_sal,
                        'Net_salary' => $netSal,
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

                if ($BalanceAmount == 0) {
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
