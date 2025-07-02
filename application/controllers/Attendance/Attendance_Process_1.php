<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_Process_1 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!($this->session->userdata('login_user'))) {
            redirect(base_url() . "");
        }
        /*
         * Load Database model
         */
        $this->load->model('db_model', '', TRUE);
    }

    /*
     * Index page
     */

    public function index() {

        $data['title'] = "Attendance Process | HRM System";
        $data['data_set'] = $this->db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $data['data_shift'] = $this->db_model->getData('ShiftCode,ShiftName', 'tbl_shifts');
        $data['data_roster'] = $this->db_model->getData('RosterCode,RosterName', 'tbl_rosterpatternweeklyhd');



        $data['sh_employees'] = $this->db_model->getfilteredData("SELECT 
                                                                    tbl_empmaster.EmpNo
                                                                FROM
                                                                    tbl_empmaster
                                                                        LEFT JOIN
                                                                    tbl_individual_roster ON tbl_individual_roster.EmpNo = tbl_empmaster.EmpNo
                                                                    where tbl_individual_roster.EmpNo is null AND tbl_empmaster.status=1");


        $this->load->view('Attendance/Attendance_Process/index', $data);
    }

    /*
     * Insert Data
     */

    public function emp_attendance_process() {

        date_default_timezone_set('Asia/Colombo');

        /*
         * Get Employee Data
         * Emp no , EPF No, Roster Type, Roster Pattern Code, Status
         */
        $dtEmp['EmpData'] = $this->db_model->getfilteredData("SELECT EmpNo,Enroll_No, EPFNO,RosterCode, Status  FROM  tbl_empmaster where status=1");

        /*
         * For Loop untill all employee and where employee status = 1
         */

//        var_dump(count($dtEmp['EmpData']));die;

        for ($x = 0; $x < count($dtEmp['EmpData']); $x++) {

            $EmpNo = $dtEmp['EmpData'][$x]->EmpNo;
            $EnrollNO = $dtEmp['EmpData'][$x]->Enroll_No;
            $EpfNO = $dtEmp['EmpData'][$x]->EPFNO;
            $roster = $dtEmp['EmpData'][$x]->RosterCode;





            /*
             * Get Process From Date and To date(To day is currunt date)
             */
            $dtRs['dt'] = $this->db_model->getfilteredData("SELECT  Max(FDate) AS FDate, CURDATE() as ToDate  FROM tbl_individual_roster where Is_processed=0 GROUP BY EmpNo HAVING  EmpNo='$EmpNo'");



            //Last Shift Allocated Date
            $FDate = $dtRs['dt'][0]->FDate;
            //Current Date
            $TDate = $dtRs['dt'][0]->ToDate;

            var_dump($FDate);die;




            $FromDate = new DateTime($FDate);
            $TODate = new DateTime($TDate);



            $interval1 = $FromDate->diff($TODate)->days;


//            var_dump($FDate, $TDate, $interval1);
            //***** 
            If ($FDate < $TDate) {

                print_r($EmpNo);

                $d1 = new DateTime($FDate);
                $d2 = new DateTime($TDate);

                $interval = $d1->diff($d2)->days;



                for ($x = 0; $x <= $interval; $x++) {

                    
                    
                    /*
                     * Get Day Type in weekly roster
                     */
                    $Current_date = "";
                    $num = date("N", strtotime($FDate));

                    switch ($num) {

                        //If $Num = 1 Day is Monday
                        case 1:
                            $Current_date = "MON";
                            break;
                        case 2:
                            $Current_date = "TUE";
                            break;
                        case 3:
                            $Current_date = "WED";
                            break;
                        case 4:
                            $Current_date = "THU";
                            break;
                        case 5:
                            $Current_date = "FRI";
                            break;
                        case 6:
                            $Current_date = "SAT";
                            break;
                        case 7:
                            $Current_date = "SUN";
                            break;
                        default:
                            break;
                    }



                    /*
                     * Get Holiday Days
                     */

                    $var = $FDate;
                    $date = str_replace('/', '-', $var);
                    $FDate = date('Y-m-d', strtotime($date));

                    $Holiday = $this->db_model->getfilteredData("select count(Hdate) as HasRow from tbl_holidays where Hdate = '$FDate' ");

                    $year = date("Y");

                    $ros = $this->db_model->getfilteredData("SELECT 
                                                                tr.ShiftCode,
                                                                tr.DayName,
                                                                tr.ShiftType,
                                                                ts.FromTime,
                                                                ts.ToTime,
                                                                ts.DayType,
                                                                ts.ShiftGap
                                                            FROM
                                                                tbl_rosterpatternweeklydtl tr
                                                                    INNER JOIN
                                                                tbl_shifts ts ON ts.ShiftCode = tr.ShiftCode
                                                            WHERE
                                                                tr.RosterCode = '$roster'
                                                                    AND tr.DayName = '$Current_date'");




                    $ShiftCode = $ros[0]->ShiftCode;
                    //Week Days  MON | TUE
                    $DayName = $ros[0]->DayName;
                    $FromTime = $ros[0]->FromTime;
                    $ToTime = $ros[0]->ToTime;
                    //Shift Type DU | EX
                    $ShiftType = $ros[0]->ShiftType;
                    $ShiftGap = $ros[0]->ShiftGap;
                    $DayType = $ros[0]->DayType;



                    $DayStatus = 'AB';
                    if ($ShiftType == "EX") {
                        $NoPay = 0;
                    } else if ($Holiday[0]->HasRow == 1) {
                        $ShiftType = 'EX';
                        //**** Day status is Holiday | Late | Early Departure | AB | PR ******
                        $DayStatus = 'HD';
                        $NoPay = 0;
                    } else {
                        $NoPay = 1;
                    }



//                    var_dump($interval . ":");
//                    die;
                    

//                    $Count=$this->db_model->getfilteredData('select count(EmpNo) as Count from tbl_empmaster where Status=1');
                   
                    
//                    var_dump($Count);die;

//                    for ($i = 0; $i < $Count[0]->Count; $i++) {

                        $dataArray = array(
                            'RYear' => $year,
                            'EmpNo' => $EmpNo,
                            'ShiftCode' => $ShiftCode,
                            'ShiftDay' => $DayName,
                            'Day_Type' => $DayType,
                            'ShiftIndex' => 1,
                            'FDate' => $FDate,
                            'FTime' => $FromTime,
                            'TDate' => $FDate,
                            'TTime' => $ToTime,
                            'ShType' => $ShiftType,
                            'DayStatus' => $DayStatus,
                            'GapHrs' => $ShiftGap,
                            'nopay' => $NoPay,
                        );

                        /*
                         * Check If Allocated Shift in Individual Roster Table
                         */
//                        $HasR = $this->db_model->getfilteredData("SELECT 
//                                                        COUNT(EmpNo) AS HasRow
//                                                    FROM
//                                                        tbl_individual_roster
//                                                    WHERE
//                                                        EmpNo = '$EmpNo' AND FDate = '$FDate' ");

                        
//                            print_r($EmpNo);die;
                            $this->db_model->insertData("tbl_individual_roster", $dataArray);
//                                $this->session->set_flashdata('success_message', 'Shift Allocation Processed successfully');
//                                die;
                        
//                    }
                    echo $FDate;

                    $FDate = date("Y-m-d", strtotime("+1 day", strtotime($FDate)));

                    echo $FDate;
                }


//                break;
                //****** Else do attendance Process



                $dtRs['dt'] = $this->db_model->getfilteredData("SELECT  Min(FDate) AS FromDate, Max(TDate) as ToDate  FROM tbl_individual_roster where Is_processed=0 GROUP BY EmpNo HAVING  EmpNo='$EmpNo'");

                $FromDate = $dtRs['dt'][0]->FromDate;
                $ToDate = $dtRs['dt'][0]->ToDate;

                /*
                 * ******Get Employee IN Details
                 */
                $dt_in_Records['dt_Records'] = $this->db_model->getfilteredData("select min(AttTime) as INTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EnrollNO' and AttDate='$FromDate' ");


//                var_dump($dt_in_Records);

                $InDate = $dt_in_Records['dt_Records'][0]->AttDate;
                $InTime = $dt_in_Records['dt_Records'][0]->INTime;
                $InRecID = $dt_in_Records['dt_Records'][0]->EventID;
                $InRec = 1;

                /*
                 * ******Get Employee OUT Details
                 */
                $dt_out_Records['dt_out_Records'] = $this->db_model->getfilteredData("select max(AttTime) as OutTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EnrollNO' and AttDate='$FromDate' ");


                $OutDate = $dt_out_Records['dt_out_Records'][0]->AttDate;
                $OutTime = $dt_out_Records['dt_out_Records'][0]->OutTime;
                $OutRecID = $dt_out_Records['dt_out_Records'][0]->EventID;
                $OutRec = 1;

                /*
                 * ***** Get Shift Code
                 */
                $SH['SH'] = $this->db_model->getfilteredData("select ID_roster,EmpNo,ShiftCode,ShType,Day_Type,FDate,FTime,TDate,TTime,ShType from tbl_individual_roster where Is_processed=0 and EmpNo='$EmpNo'");
                $SH_Code = $SH['SH'][0]->ShiftCode;
                $ShiftType = $SH['SH'][0]->ShType;
                $ID_Roster = $SH['SH'][0]->ID_roster;
                $SHFT = $SH['SH'][0]->FTime;
                $SHTT = $SH['SH'][0]->TTime;
                $DayType = $SH['SH'][0]->Day_Type;

                /*
                 * If In Available
                 */
                if ($InTime != '') {

                    echo 'in Av';

//                    var_dump($SHFT, $InTime);

                    $InTimeSrt = strtotime($InTime);

                    $SHStartTime = strtotime($SHFT);

                    $iCalc = round(( $SHStartTime - $InTimeSrt) / 60);



                    if ($iCalc >= 0) {

                        $BeforeShift = $iCalc;
                    } else {

                        if ($ShiftType = 'DU') {
                            $Late = true;
                            $lateM = 0 - $iCalc;
                        }
                    }
                    
                    //test
                    $Status = 1;
                    $AfterShift=1;
                    
                    $data_arr = array("InRec" => 1, "InDate" => $FromDate, "InTime" => $InTime, "OutRec" => 1, "OutDate" => $FromDate, "OutTime" => $OutTime, "nopay" => 0, "Is_processed" => 1, "DayStatus" => $Status, "LateM" => $lateM,  "BeforeExH" => $BeforeShift, "AfterExH" => $AfterShift);
                    $whereArray = array("ID_roster" => $ID_Roster);
                    $result = $this->db_model->updateData("tbl_individual_roster", $data_arr, $whereArray);
                } else {

                    if ($ShiftType = 'DU') {

                        $NoPay = $DayType;
                    }
                }


                /*
                 * If Out Available 
                 */
                if ($OutTime != '') {


//                    var_dump($SHTT);

                    $OutTimeSrt = strtotime($OutTime);
                    $SHEndTime = strtotime($SHTT);
                    //Get Hours
                    //$iCalc1= round(round(($OutTime1 - $SHEndTime1) / 60)/60);
                    //*******Get Minutes
                    $iCalcOut = round(($OutTimeSrt - $SHEndTime) / 60);


                    if ($iCalcOut >= 0) {

                        $AfterShift = $iCalcOut;
                    } else {

                        if ($ShiftType = 'DU') {
                            $ED = true;
                            $ED = 0 - $iCalcOut;
                        }
                    }

                    $Status = 'PR';

                    $data_arr = array("InRec" => 1, "InDate" => $FromDate, "InTime" => $InTime, "OutRec" => 1, "OutDate" => $FromDate, "OutTime" => $OutTime, "nopay" => 0, "Is_processed" => 1, "DayStatus" => $Status, "LateM" => $lateM, "LateM" => $lateM, "BeforeExH" => $BeforeShift, "AfterExH" => $AfterShift);
                    $whereArray = array("ID_roster" => $ID_Roster);
                    $result = $this->db_model->updateData("tbl_individual_roster", $data_arr, $whereArray);
                } else {
                    
                }
            }


            /*
             * *************Over Time Process************
             */

//                echo 'Over Time';
            $this->session->set_flashdata('success_message', 'Process Completed');

//            echo 'end';
        }

//        echo $EmpNo;

        redirect('/Attendance/Attendance_Process_1');
    }

}
