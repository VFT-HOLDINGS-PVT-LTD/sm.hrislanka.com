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


                //Get Employee Basic Salary | Incentive
                $SalData = $this->Db_model->getfilteredData("select EmpNo,EPFNO, Dep_ID, Des_ID,Basic_Salary,Incentive from tbl_empmaster where EmpNo=$EmpNo");
                $BasicSal = $SalData[0]->Basic_Salary;
                $Incentive = $SalData[0]->Incentive;


                //Get Nopay days in Individual Roster table
                $Nopay = $this->Db_model->getfilteredData("select sum(nopay) as nopay from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month");
                $NopayDays = $Nopay[0]->nopay;

                if ($NopayDays == null) {
                    $NopayDays = 0;
                }

                //Calculate Nopay deduction
                $NopayRate = $BasicSal+$Incentive / 30;
                $Nopay_Deduction = $NopayRate * $NopayDays;

                //Get Variable Allowances details
                $Allowances = $this->Db_model->getfilteredData("select Alw_ID, Amount from tbl_varialble_allowance where EmpNo=$EmpNo and Month=$month and Year=$year");

                //Get Variable Deductions details
                $Deductions = $this->Db_model->getfilteredData("select Ded_ID,Amount from tbl_variable_deduction where EmpNo=$EmpNo and Month=$month and Year=$year");

                //Get Salary Advance details
                $Sal_Advance = $this->Db_model->getfilteredData("select Amount from tbl_salary_advance where Is_Approve=1 and EmpNo=$EmpNo and month=$month and year = $year");

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
                $Overtime = $this->Db_model->getfilteredData("select sum(ApprovedExH) as OT from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and RYear=$year");
                $OT_Hours = $Overtime[0]->OT;
                
                
                var_dump($OT_Hours);

                $OT_Rate = (($BasicSal / 240) * 1.5);

                //IF Employee work less than 30min they havent Over time
                if ($OT_Hours < 30) {
                    $OT_Hours = 0;
                    $OT_Amount = 0;
                }
                //Else calculate Over time
                else {
                    $OT_Amount = $OT_Rate * $OT_Hours;
                }


                //*** Get Late Minutes
                $Late_Min = $this->Db_model->getfilteredData("select sum(LateM) as LateMin from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and RYear=$year");

                //*** Late Min
                if (empty($Late_Min[0]->LateMin)) {
                    $Late_Min = 0;
                } else {
                    $Late_Min = $Late_Min[0]->LateMin;
                }

                $Late_rate = (($BasicSal / 240) );
                //** Late Amount
                $Late_Amount = $Late_rate * $Late_Min;


                //All Allowances
                $Allowances = $Allowance_1 + $Allowance_2 + $Allowance_3;


                //Calculate Gross salary
                $Gross_sal = $BasicSal + $Incentive + $Allowances;

                //Calculate EPF Employee
                $EPF_Worker = (8 / 100) * $BasicSal;

                //Calculate EPF Employer
                $EPF_Employer = (12 / 100) * $BasicSal;

                //Calculate ETF Employee
                $ETF = (3 / 100) * $BasicSal;

                //Calculate Total Deductions
                $Tot_deductions = $EPF_Worker + $Nopay_Deduction + $Sal_advance + $Deduction_1 + $Deduction_2 + $Deduction_3 + $LoanMonth + $Late_Amount;

                //Calculate Net Salary
                $netSal = ($BasicSal + $Incentive + $OT_Amount + $Allowances) - $Nopay_Deduction - $LoanMonth - $EPF_Worker - $Sal_advance - $Deduction_1 - $Deduction_2 - $Deduction_3 - $Late_Amount;

                $data = array(
                    'EmpNo' => $EmpNo,
                    'EPFNO' => $EpfNo,
                    'Basic_sal' => $BasicSal,
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
                    'Late_min' => $Late_Min,
                    'Late_deduction' => $Late_Amount,
                    'Alw_ID_1' => $Allowance_ID_1,
                    'Allowance_1' => $Allowance_1,
                    'Alw_ID_2' => $Allowance_ID_2,
                    'Allowance_2' => $Allowance_2,
                    'Alw_ID_3' => $Allowance_ID_3,
                    'Allowance_3' => $Allowance_3,
                    'Normal_OT_Hrs' => $OT_Hours,
                    'Normal_OT_Pay' => $OT_Amount,
                    'Ded_ID_1' => $Deduction_ID_1,
                    'Deduct_1' => $Deduction_1,
                    'Ded_ID_2' => $Deduction_ID_2,
                    'Deduct_2' => $Deduction_2,
                    'Ded_ID_3' => $Deduction_ID_3,
                    'Deduct_3' => $Deduction_3,
                    'tot_deduction' => $Tot_deductions,
                    'Gross_sal' => $Gross_sal,
                    'Net_salary' => $netSal);


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

                If ($BalanceAmount == 0) {
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


                $SalData = $this->Db_model->getfilteredData("select EmpNo,EPFNO, Dep_ID, Des_ID,Basic_Salary,Incentive from tbl_empmaster where EmpNo=$EmpNo");
                $BasicSal = $SalData[0]->Basic_Salary;
                $Incentive = $SalData[0]->Incentive;


                //**** Get Nopay days
                $Nopay = $this->Db_model->getfilteredData("select sum(nopay) as nopay from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month");
                $NopayDays = $Nopay[0]->nopay;

                if ($NopayDays == null) {
                    $NopayDays = 0;
                }
                //**** Calculate no pay amount
                $NopayRate = $BasicSal+$Incentive / 30;
                $Nopay_Deduction = $NopayRate * $NopayDays;

                //**** Get Allowance Details
                $Allowances = $this->Db_model->getfilteredData("select Alw_ID, Amount from tbl_varialble_allowance where EmpNo=$EmpNo and Month=$month and Year=$year");

                //**** Get deduction Details
                $Deductions = $this->Db_model->getfilteredData("select Ded_ID,Amount from tbl_variable_deduction where EmpNo=$EmpNo and Month=$month and Year=$year");

                //**** Get salary advance
                $Sal_Advance = $this->Db_model->getfilteredData("select Amount from tbl_salary_advance where Is_Approve=1 and EmpNo=$EmpNo and month=$month and year = $year");

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
                $OT_Hours = $Overtime[0]->OT;

                $OT_Rate = (($BasicSal / 240) * 1.5);

                //IF Employee work less than 30min they havent Over time
                if ($OT_Hours < 30) {
                    $OT_Hours = 0;
                    $OT_Amount = 0;
                }
                //Else calculate Over time
                else {
                    $OT_Amount = $OT_Rate * $OT_Hours;
                }


                //*** Get Late Minutes
                $Late_Min = $this->Db_model->getfilteredData("select sum(LateM) as LateMin from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and RYear=$year");

                //*** Late Min

                if (empty($Late_Min[0]->LateMin)) {
                    $Late_Min = 0;
                } else {
                    $Late_Min = $Late_Min[0]->LateMin;
                }


                $Late_rate = (($BasicSal / 240) );
                //** Late Amount
                $Late_Amount = $Late_rate * $Late_Min;


                //All Allowances
                $Allowances = $Allowance_1 + $Allowance_2 + $Allowance_3;



                //Calculate Gross salary
                $Gross_sal = $BasicSal + $Incentive + $Allowances;

                //Calculate EPF Employee
                $EPF_Worker = (8 / 100) * $BasicSal;

                //Calculate EPF Employer
                $EPF_Employer = (12 / 100) * $BasicSal;

                //Calculate ETF Employee
                $ETF = (3 / 100) * $BasicSal;

                //Calculate Total Deductions
                $Tot_deductions = $EPF_Worker + $Nopay_Deduction + $Sal_advance + $Deduction_1 + $Deduction_2 + $Deduction_3 + $LoanMonth + $Late_Amount;

                //Calculate Net Salary
                $netSal = ($BasicSal + $Incentive + $OT_Amount + $Allowances) - $Nopay_Deduction - $LoanMonth - $EPF_Worker - $Sal_advance - $Deduction_1 - $Deduction_2 - $Deduction_3 - $Late_Amount;



                $data = array(
                    array(
                        'EmpNo' => $EmpNo,
                        'EPFNO' => $EpfNo,
                        'Month' => $month,
                        'Year' => $year,
                        'Basic_sal' => $BasicSal,
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
                        'Late_min' => $Late_Min,
                        'Late_deduction' => $Late_Amount,
                        'Alw_ID_1' => $Allowance_ID_1,
                        'Allowance_1' => $Allowance_1,
                        'Alw_ID_2' => $Allowance_ID_2,
                        'Allowance_2' => $Allowance_2,
                        'Alw_ID_3' => $Allowance_ID_3,
                        'Allowance_3' => $Allowance_3,
                        'Normal_OT_Hrs' => $OT_Hours,
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
                ));


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

                If ($BalanceAmount == 0) {
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
        die;

        $this->session->set_flashdata('success_message', 'Payroll Process successfully');
        redirect(base_url() . 'Payroll/Payroll_Process');
    }

}
