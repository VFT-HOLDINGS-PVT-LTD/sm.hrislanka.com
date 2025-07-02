<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_Process_New extends CI_Controller {

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

        $data['title'] = "Attendance Process | HRM System";
        $data['data_set'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $data['data_shift'] = $this->Db_model->getData('ShiftCode,ShiftName', 'tbl_shifts');
        $data['data_roster'] = $this->Db_model->getData('RosterCode,RosterName', 'tbl_rosterpatternweeklyhd');



        $data['sh_employees'] = $this->Db_model->getfilteredData("SELECT 
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
//        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("SELECT EmpNo,Enroll_No, EPFNO,RosterCode, Status  FROM  tbl_empmaster where status=1");
        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("select EmpNo from tbl_individual_roster where Is_processed = 0");
//        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("SELECT EmpNo,Enroll_No, EPFNO,RosterCode, Status  FROM  tbl_empmaster where EmpNo=3316");
//        $DayStatus = 'AB';
//        $lateM=0;
        $AfterShift = 0;
//        var_dump($dtEmp);
        if (!empty($dtEmp['EmpData'])) {
//        var_dump($dtEmp);die;
            /*
             * For Loop untill all employee and where employee status = 1
             */
            for ($x = 0; $x < count($dtEmp['EmpData']); $x++) {
                $EmpNo = $dtEmp['EmpData'][$x]->EmpNo;
//                $EnrollNO = $dtEmp['EmpData'][$x]->Enroll_No;
//                $EpfNO = $dtEmp['EmpData'][$x]->EPFNO;
//                $roster = $dtEmp['EmpData'][$x]->RosterCode;
//            echo $EmpNo . "<br>";
                /*
                 * Get Process From Date and To date(To day is currunt date)
                 */
                $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT  Min(FDate) AS FDate, Max(FDate) as ToDate  FROM tbl_individual_roster where Is_processed=0 GROUP BY EmpNo HAVING  EmpNo='$EmpNo'");
//                var_dump($dtRs);
//            if (!empty($dtRs['dt'])) {
//var_dump($dtRs);
                //Last Shift Allocated Date
//                $FDate = date("Y-m-d", strtotime("+1 day", strtotime($dtRs['dt'][0]->FDate)));
                $FDate = $dtRs['dt'][0]->FDate;
                //Current Date
                $TDate = $dtRs['dt'][0]->ToDate;
                //Check If From date less than to Date
                If ($FDate <= $TDate) {

//                    var_dump($FDate . '   ' . $TDate . 'ss');die;
//                    die;
                    $d1 = new DateTime($FDate);
                    $d2 = new DateTime($TDate);

                    $interval = $d1->diff($d2)->days;


                    //***** If from date is greter than to date shift allocation
                    If (($interval > 0 ) && ($FromDate < $TODate)) {
                        $d1 = new DateTime($FDate);
                        $d2 = new DateTime($TDate);

                        $interval = $d1->diff($d2)->days;


                        for ($x = 0; $x <= $interval; $x++) {


                            /*
                             * Get Day Type in weekly roster
                             */
                            $Current_date = "";
                            $num = date("N", strtotime($from_date));

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

                            $var = $from_date;
                            $date = str_replace('/', '-', $var);
                            $from_date = date('Y-m-d', strtotime($date));

                            $Holiday = $this->Db_model->getfilteredData("select count(Hdate) as HasRow from tbl_holidays where Hdate = '$from_date' ");

                            $year = date("Y");

                            $ros = $this->Db_model->getfilteredData("SELECT 
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


                            for ($i = 0; $i < $Count; $i++) {

                                $Em = $EmpData[$i]->EmpNo;


                                $dataArray = array(
                                    'RYear' => $year,
                                    'EmpNo' => $EmpData[$i]->EmpNo,
                                    'ShiftCode' => $ShiftCode,
                                    'ShiftDay' => $DayName,
                                    'Day_Type' => $DayType,
                                    'ShiftIndex' => 1,
                                    'FDate' => $from_date,
                                    'FTime' => $FromTime,
                                    'TDate' => $from_date,
                                    'TTime' => $ToTime,
                                    'ShType' => $ShiftType,
                                    'DayStatus' => $DayStatus,
                                    'GapHrs' => $ShiftGap,
                                    'nopay' => $NoPay,
                                );

                                /*
                                 * Check If Allocated Shift in Individual Roster Table
                                 */
                                $HasR = $this->Db_model->getfilteredData("SELECT 
                                                        COUNT(EmpNo) AS HasRow
                                                    FROM
                                                        tbl_individual_roster
                                                    WHERE
                                                        EmpNo = '$Em' AND FDate = '$from_date' ");

                                if ($HasR[0]->HasRow == 1) {
//                                $this->session->set_flashdata('error_message', 'Already Shift Allocated');
                                } else {
                                    $this->Db_model->insertData("tbl_individual_roster", $dataArray);
//                                $this->session->set_flashdata('success_message', 'Shift Allocation Processed successfully');
//                                die;
                                }
                            }

                            $from_date = date("Y-m-d", strtotime("+1 day", strtotime($from_date)));
                        }
                        break;
                        //****** Else do attendance Process
                    } else {



                        //**** Attendance Process start after shift allocation
                        $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT  Min(FDate) AS FromDate, Max(TDate) as ToDate  FROM tbl_individual_roster where Is_processed=0 GROUP BY EmpNo HAVING  EmpNo='$EmpNo'");

//                    var_dump($dtRs);
//                    var_dump($EmpNo);
//                 die;
                        $FromDate = $dtRs['dt'][0]->FromDate;
                        $ToDate = $dtRs['dt'][0]->ToDate;

                        $d1 = new DateTime($FromDate);
                        $d2 = new DateTime($ToDate);

                        //Date intervel for, loop
                        $interval2 = $d1->diff($d2)->days;
//                    var_dump($interval2);
                        $ApprovedExH = 0;
// die;
                        for ($z = 0; $z <= $interval2; $z++) {
//                     die;

                            $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT  Min(FDate) AS FromDate, Max(TDate) as ToDate  FROM tbl_individual_roster where Is_processed=0 GROUP BY EmpNo HAVING  EmpNo='$EmpNo'");

                            $FromDate = $dtRs['dt'][0]->FromDate;
                            $ToDate = $dtRs['dt'][0]->ToDate;
//                        var_dump($dtRs); 
// die;
                            /*
                             * ******Get Employee IN Details
                             */
                            $dt_in_Records['dt_Records'] = $this->Db_model->getfilteredData("select min(AttTime) as INTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='$FromDate' ");

                            $InRecords = $dt_in_Records['dt_Records'][0]->AttDate;
//                        var_dump($dt_in_Records);
                            //**** In Date
                            $InDate = $dt_in_Records['dt_Records'][0]->AttDate;
                            //**** In Time
                            $InTime = $dt_in_Records['dt_Records'][0]->INTime;
                            $InRecID = $dt_in_Records['dt_Records'][0]->EventID;
                            $InRec = 1;
                            /*
                             * ******Get Employee OUT Details
                             */
                            $dt_out_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select max(AttTime) as OutTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='$FromDate' ");

                            //**** Out Date
                            $OutDate = $dt_out_Records['dt_out_Records'][0]->AttDate;
                            //**** Out Time
                            $OutTime = $dt_out_Records['dt_out_Records'][0]->OutTime;
                            $OutRecID = $dt_out_Records['dt_out_Records'][0]->EventID;
                            $OutRec = 0;
                            $OutRecords = $dt_out_Records['dt_out_Records'][0]->AttDate;
//                        var_dump($dt_out_Records);
//                        var_dump($InTime . 'In');
//                    if ($InTime == $OutTime) {
//                        
//                    }
//                    die;

                            if ($InRecords == null) {
//                            var_dump($FromDate,$EmpNo);
                                $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='$FromDate' and Enroll_No='$EmpNo' and Is_Admin_App_ID=1");
                                if (!empty($Manual)) {
//                                print_r($FromDate);
//                                var_dump($Manual);
//                        die;
                                    $InDate = $Manual[0]->Att_Date;
                                    //**** In Time
                                    $InTime = $Manual[0]->In_Time;

                                    $InRec = 1;
                                }
                            }
                            if ($InTime == $OutTime) {
                                $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='$FromDate' and Enroll_No='$EmpNo' and Is_Admin_App_ID=1");
                                if (!empty($Manual)) {
//                                print_r($FromDate);
//                                var_dump($Manual);
//                        die;
                                    $InDate = $Manual[0]->Att_Date;
                                    //**** In Time
                                    $InTime = $Manual[0]->In_Time;

                                    $OutTime = $Manual[0]->Out_Time;

                                    $InRec = 1;
                                }
                            }
//var_dump($Manual);die;
//                        var_dump($dt_out_Records);
//
//                        die;
                            if ($OutRecords == null) {

                                $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='$FromDate' and Enroll_No='$EmpNo' and Is_Admin_App_ID=1");

//                            var_dump($Manual);
                                if (!empty($Manual)) {
//                                print_r($FromDate);
//                                var_dump($Manual);
//                        die;

                                    $OutDate = $Manual[0]->Att_Date;
                                    //**** In Time
                                    $OutTime = $Manual[0]->Out_Time;

                                    $OutRec = 1;
                                }
                            }
//                        
//die;

                            /*
                             * ***** Get Shift Code
                             */
                            $SH['SH'] = $this->Db_model->getfilteredData("select ID_roster,EmpNo,ShiftCode,ShType,ShiftDay,Day_Type,FDate,FTime,TDate,TTime,ShType,GracePrd from tbl_individual_roster where Is_processed=0 and EmpNo='$EmpNo'");
                            $SH_Code = $SH['SH'][0]->ShiftCode;
                            $Shift_Day = $SH['SH'][0]->ShiftDay;
                            //****Shift Type DU| EX
                            $ShiftType = $SH['SH'][0]->ShType;
                            //****Individual Roster ID
                            $ID_Roster = $SH['SH'][0]->ID_roster;
                            //****Shift from time
                            $SHFT = $SH['SH'][0]->FTime;
                            //****Shift to time
                            $SHTT = $SH['SH'][0]->TTime;
                            //****Day Type Full day or Half day (1)or 0.5
                            $DayType = $SH['SH'][0]->Day_Type;

                            $GracePrd = $SH['SH'][0]->GracePrd;

//                        var_dump($ShiftType);
//                        var_dump($Shift_Day . $ShiftType . $EmpNo);
//die;
                            /*
                             * Get OT Pattern Details
                             */
                            $OT['OT'] = $this->Db_model->getfilteredData("SELECT tbl_ot_pattern_dtl.DayCode,tbl_ot_pattern_dtl.OTCode,tbl_empmaster.EmpNo,tbl_ot_pattern_dtl.OTPatternName,tbl_ot_pattern_dtl.DUEX,tbl_ot_pattern_dtl.BeforeShift,tbl_ot_pattern_dtl.MinBS,tbl_ot_pattern_dtl.AfterShift,tbl_ot_pattern_dtl.MinAS,tbl_ot_pattern_dtl.RoundUp,tbl_ot_pattern_dtl.Rate,tbl_ot_pattern_dtl.Deduct_LNC FROM tbl_ot_pattern_dtl RIGHT JOIN tbl_empmaster ON tbl_ot_pattern_dtl.OTCode = tbl_empmaster.OTCode WHERE tbl_ot_pattern_dtl.DayCode ='$Shift_Day' and tbl_ot_pattern_dtl.DUEX='$ShiftType' and tbl_empmaster.EmpNo='$EmpNo'");

//                        var_dump($OT);die;

                            $Round = $OT['OT'][0]->RoundUp;
                            $BeforeShift = $OT['OT'][0]->BeforeShift;
                            $AfterShift = $OT['OT'][0]->AfterShift;
                            $Rate = $OT['OT'][0]->Rate;
                            $DayCode = $OT['OT'][0]->DayCode;
                            $Deduct_Lunch = $OT['OT'][0]->Deduct_LNC;

//                        var_dump($OT);
                            $lateM = 0;
                            $BeforeShift = 0;
                            $Late_Status = 0;
                            $NetLateM = 0;
                            $ED = 0;
                            $Att_Allowance = 1;
//                        var_dump($OT);
//                        var_dump($InTime . 'Intime');

                            if ($InTime !== null) {
                                $InTime = substr($InTime, 0, 5);
                            }
//                        $InTime = substr($InTime, 0, 5);
                            if ($InTime == $OutTime) {
                                $DayStatus = 'MS';

//                                die;
                            }
                            /*
                             * If In Available & In Out Missing
                             */
                            if ($InTime != '' && $InTime == $OutTime) {
                                $DayStatus = 'MS';
                                $Late_Status = 0;
                                $Nopay = 0;


                                $Nopay_Hrs = 0;
                            }
                            if ($InTime != '' && $InTime != $OutTime) {
                                $InTimeSrt = strtotime($InTime);
                                $SHStartTime = strtotime($SHFT);

//                            var_dump($InTime . $SHFT . 'InTime Sh time');
                                $iCalc = round(( $SHStartTime - $InTimeSrt) / 60);

//                            var_dump($iCalc . 'iCalc');
//                            die;
//                            (FLOOR(@AcceptedBeforeEarlyMinutes / @RoundUP) * @RoundUP);


                                if ($iCalc >= 0) {

                                    $BeforeShift = $iCalc;

                                    $BeforeShift = ($BeforeShift + $GracePrd);

//                                $BeforeShift = ((floor(($BeforeShift + $GracePrd) / $Round)) * $Round);
                                }
                                $testBSH = floor($BeforeShift);

//                            var_dump($BeforeShift . '_' . $GracePrd . 'Round ' . $Round . 'TestMin' . $testBSH);
//                            var_dump($BeforeShift);
//                            var_dump($ShiftType);

                                if ($ShiftType == 'DU') {
                                    $Late = true;

                                    $lateM = 0 - $iCalc - $GracePrd;
                                    $Late_Status = 1;

                                    if ($lateM <= 0) {
                                        $lateM = 0;
                                    }
                                }
                                $Nopay = 0;
                                $DayStatus = 'PR';
//                        $DayStatus = 'PR';
//                            $AfterShift = 1;
                                $Nopay_Hrs = 0;
                            } else if ($InTime == '' && $OutTime == '') {
                                $DayStatus = 'AB';
                                $Nopay = 1;
                                $Nopay_Hrs = (((strtotime($SHTT) - strtotime($SHFT)) - 60 * 60) / 60);
                                if ($DayType == 0.5) {
                                    $Nopay = 0.5;
                                    $Nopay_Hrs = (((strtotime($SHTT) - strtotime($SHFT)) ) / 60);
                                }
//                            var_dump($Nopay_Hrs . '----------------------------' . $SHTT . '---' . $SHFT);
                                $Att_Allowance = 0;
                            }
//                        var_dump($Nopay_Hrs);
//                        var_dump($lateM);
//                        $data_arr = array("InRec" => 1, "InDate" => $FromDate, "InTime" => $InTime, "OutRec" => 1, "OutDate" => $FromDate, "OutTime" => $OutTime, "nopay" => $Nopay, "Is_processed" => 1, "DayStatus" => $DayStatus, "LateSt" => $Late_Status, "LateM" => $lateM, "BeforeExH" => $BeforeShift, "AfterExH" => $AfterShift);
//                        $whereArray = array("ID_roster" => $ID_Roster);
//                        var_dump($data_arr);
//                        die;
//                        $result = $this->Db_model->updateData("tbl_individual_roster", $data_arr, $whereArray);
                            //die;
//var_dump($OutTime.'Out');die;
                            /*
                             * If Out Available 
                             */
//                        var_dump($OutTime . '_' . $InTime . 'Out string' . strtotime($OutTime));

                            $ApprovedExH = 0;
//                        var_dump($ApprovedExH);
//                    if ($OutTime != '') {
                            if ($OutTime != '' && $InTime != $OutTime) {
//                            var_dump($OutTime . '_Out Time' . $SHTT . '_Shift End Time -------------------------');
                                $OutTimeSrt = strtotime($OutTime);
                                $SHEndTime = strtotime($SHTT);
                                //Get Hours
                                //$iCalc1= round(round(($OutTime1 - $SHEndTime1) / 60)/60);
                                //*******Get Minutes
                                $iCalcOut = round(($OutTimeSrt - $SHEndTime) / 60);
//                            var_dump($iCalcOut);
                                $EX_OT_Gap = round(((strtotime($SHTT) - strtotime($InTime)) - 60 * 60) / 60);
//                            var_dump($EX_OT_Gap);
//                            var_dump($Deduct_Lunch . '-------------------');
                                if ($iCalcOut >= 0 && $AfterShift == 1) {
                                    $AfterShift = $iCalcOut;
                                    if ($Deduct_Lunch >= 0) {
                                        $AfterShift = $iCalcOut - 60;
                                    }
                                }

                                $SH_EX_OT = 0;
                                if ($ShiftType == 'DU') {
                                    $ED = 0 - $iCalcOut;
                                    if ($ED <= 0) {
                                        $ED = 0;
                                    }
                                }
                                if ($ShiftType == 'EX') {
                                    $SH_EX_OT = $EX_OT_Gap - $BeforeShift + 5;
                                    $Nopay = 0;
                                    $Nopay_Hrs = 0;

//                                var_dump($Nopay . '---------------');
                                }
//                            var_dump((strtotime($InTime)) . '_' . (strtotime($SHFT)));
//                            if ($ShiftType == 'EX' && ((strtotime($InTime)) > (strtotime($SHFT))) ){
//                                 $SH_EX_OT = $EX_OT_Gap + 5 + $BeforeShift;
//                                $Nopay = 0;
//                                $Nopay_Hrs = 0;
//                                
//                                var_dump($SH_EX_OT);
//
//                                var_dump($Nopay . '---------------');
//                            }
//                            die;
                            }
                            $SH_EX_OT = 0;
//                        var_dump($ShiftType . $ED);
//                            die;
//                        var_dump($AfterShift);
//                        $DayStatus = 'PR';
//                        var_dump($EmpNo . ' ' . $FromDate);
//                        var_dump('Round Eco' . $Round . 'Round Eco');
//                        var_dump($BeforeShift . 'BF' . $AfterShift . 'AF' . $SH_EX_OT . ' -EX OT-' . $Round . '-Round' . '---------------------');

                            $NetLateM = $lateM + $ED;
                            $ApprovedExH = (floor(($BeforeShift + $AfterShift + $SH_EX_OT) / $Round)) * $Round;


//                        if ($Round != 0) {
//                            $ApprovedExH = (floor(($BeforeShift + $AfterShift + $SH_EX_OT) / $Round)) * $Round;
//                        } else {
//                            // Handle the case when $Round is zero (e.g., assign a default value or show an error message)
//                            // Example:
//                            $ApprovedExH = 0; // Assigning zero as a default value
//                            // or
//                            echo "Error: Division by zero encountered.";
//                        }
//                        $ApprovedExH = ((floor(($BeforeShift + $AfterShift + $SH_EX_OT) / $Round)) * $Round);
//                        
//                            $ApprovedExH = (((($BeforeShift + $AfterShift) / $Round)) * $Round);
//                        var_dump($ApprovedExH);

                            if ($ApprovedExH >= 0) {

                                $dataArray = array(
                                    'EmpNo' => $EmpNo,
                                    'OTDate' => $FromDate,
                                    'RateCode' => $Rate,
                                    'OT_Cat' => $DayCode,
                                    'OT_Min' => $ApprovedExH
                                );

                                var_dump($SH_EX_OT);


                                $result = $this->Db_model->insertData("tbl_ot_d", $dataArray);
                            }
                            $Holiday = $this->Db_model->getfilteredData("select count(Hdate) as HasRow from tbl_holidays where Hdate = '$FromDate' ");
                            if ($Holiday[0]->HasRow == 1) {
                                $DayStatus = 'HD';
                                $Nopay = 0;
                                $Nopay_Hrs = 0;
                                $Att_Allowance = 0;
                            }
                            $Leave = $this->Db_model->getfilteredData("SELECT * FROM tbl_leave_entry where EmpNo = $EmpNo and Leave_Date = '$FromDate' ");
//                        $isLeave = $Leave[0]->Is_Approve;
                            if (!empty($Leave[0]->Is_Approve)) {
//                            var_dump($isLeave);
                                $Nopay = 0;
                                $DayStatus = 'LV';
                                $Nopay_Hrs = 0;
                                $Att_Allowance = 0;
                            }
                            $data_arr = array("InRec" => 1, "InDate" => $FromDate, "InTime" => $InTime, "OutRec" => 1, "OutDate" => $FromDate, "OutTime" => $OutTime, "nopay" => $Nopay, "Is_processed" => 0, "DayStatus" => $DayStatus, "BeforeExH" => $BeforeShift, "AfterExH" => $AfterShift, "LateSt" => $Late_Status, "LateM" => $lateM, "EarlyDepMin" => $ED, "NetLateM" => $NetLateM, "ApprovedExH" => $ApprovedExH, "nopay_hrs" => $Nopay_Hrs, "Att_Allow" => $Att_Allowance);
                            $whereArray = array("ID_roster" => $ID_Roster);
                            $result = $this->Db_model->updateData("tbl_individual_roster", $data_arr, $whereArray);
//                        var_dump($data_arr);
//                        var_dump('last Die');
                        }
//                    die;
                    }
                }
            }
        } else {
//            die;
            $this->session->set_flashdata('success_message', 'Attendance Process successfully');
            redirect('/Attendance/Attendance_Process_test');
        }
//        die;
        $this->session->set_flashdata('success_message', 'Attendance Process successfully');
        redirect('/Attendance/Attendance_Process_test');
    }

}
