<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Attendance_Process_New extends CI_Controller
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
        $this->load->model('Db_model', '', true);
    }

    /*
     * Index page
     */

    public function index()
    {

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
                                                                    where tbl_individual_roster.EmpNo is null AND tbl_empmaster.status=1 and Active_process=1");

        $this->load->view('Attendance/Attendance_Process/index', $data);
    }

    public function re_process()
    {
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
                                                                    where tbl_individual_roster.EmpNo is null AND tbl_empmaster.status=1 and Active_process=1");

        $this->load->view('Attendance/Attendance_REProcess/index', $data);
    }

    /*
     * Insert Data
     */

    public function emp_attendance_re_process()
    {

        $from_date = $this->input->post('txt_from_date');
        $to_date = $this->input->post('txt_to_date');

        date_default_timezone_set('Asia/Colombo');
        /*
         * Get Employee Data
         * Emp no , EPF No, Roster Type, Roster Pattern Code, Status
         */
        //        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("SELECT EmpNo,Enroll_No, EPFNO,RosterCode, Status  FROM  tbl_empmaster where status=1");
        //        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("select EmpNo from tbl_individual_roster where Is_processed = 1 group by EmpNo");
        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("select EmpNo from tbl_individual_roster where FDate between '$from_date' and '$to_date' group by FDate");
        //        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("SELECT EmpNo,Enroll_No, EPFNO,RosterCode, Status  FROM  tbl_empmaster where EmpNo=3316");
        //        echo "<pre>";
        //        echo 'count--------------------------';
        //        var_dump(($dtEmp['EmpData']));
        //        var_dump(count($dtEmp['EmpData']));
        //        echo "<pre>";
        //        die;
        //        $DayStatus = 'AB';
        //        $lateM=0;
        $AfterShift = 0;
        //        var_dump($dtEmp);die;
        if (!empty($dtEmp['EmpData'])) {

            //echo "<pre>";  var_dump($dtEmp); echo "<pre>";die;
            /*
             * For Loop untill all employee and where employee status = 1
             */
            for ($x = 0; $x < count($dtEmp['EmpData']); $x++) {
                $EmpNo = $dtEmp['EmpData'][$x]->EmpNo;
                //                echo $x . 'Line_____________________77' . $EmpNo;
                //                $EnrollNO = $dtEmp['EmpData'][$x]->Enroll_No;
                //                $EpfNO = $dtEmp['EmpData'][$x]->EPFNO;
                //                $roster = $dtEmp['EmpData'][$x]->RosterCode;
                //            echo $EmpNo . "<br>";
                /*
                 * Get Process From Date and To date(To day is currunt date)
                 */
                //                $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT  Min(FDate) AS FDate, Max(FDate) as ToDate  FROM tbl_individual_roster where Is_processed=1 GROUP BY EmpNo HAVING  EmpNo='$EmpNo'");
                $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT  Min(FDate) AS FDate, Max(FDate) as ToDate  FROM tbl_individual_roster where EmpNo='$EmpNo' GROUP BY EmpNo");
                //            echo "<pre>";     var_dump($dtRs);echo "<pre>"; die;
                //            if (!empty($dtRs['dt'])) {
                //var_dump($dtRs);
                //Last Shift Allocated Date
                //                $FDate = date("Y-m-d", strtotime("+1 day", strtotime($dtRs['dt'][0]->FDate)));
                $FDate = $dtRs['dt'][0]->FDate;
                //Current Date
                $TDate = $dtRs['dt'][0]->ToDate;
                //Check If From date less than to Date
                if ($FDate <= $TDate) {

                    //                    var_dump($FDate . '   ' . $TDate . 'ss');die;
                    //                    die;
                    $d1 = new DateTime($FDate);
                    $d2 = new DateTime($TDate);

                    $interval = $d1->diff($d2)->days;
                    //**** Attendance Process start after shift allocation
                    //                    $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT  Min(FDate) AS FromDate, Max(TDate) as ToDate  FROM tbl_individual_roster where Is_processed=1 GROUP BY EmpNo HAVING  EmpNo='$EmpNo'");
                    $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT  Min(FDate) AS FromDate, Max(TDate) as ToDate  FROM tbl_individual_roster where EmpNo='$EmpNo' GROUP BY EmpNo");
                    //
                    //                    var_dump($dtRs);
                    //                    var_dump($EmpNo);
                    //                 die;
                    $FromDate = $dtRs['dt'][0]->FromDate;
                    $ToDate = $dtRs['dt'][0]->ToDate;

                    $d1 = new DateTime($FromDate);
                    $d2 = new DateTime($ToDate);

                    //Date intervel for, loop
                    $interval2 = $d1->diff($d2)->days;
                    //                    var_dump($interval2);die;
                    $ApprovedExH = 0;

                    $FromDate = $d1->modify("-1 day");

                    $FromDate = $FromDate->format('Y-m-d');

                    // die;
                    for ($z = 0; $z <= $interval2; $z++) {

                        //                        var_dump($FromDate);die;
                        //                     die;
                        //                          echo "<pre>";     var_dump($interval2);echo "<pre>"; die;
                        //                        $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT  Min(FDate) AS FromDate, Max(TDate) as ToDate  FROM tbl_individual_roster where Is_processed=1 GROUP BY EmpNo HAVING  EmpNo='$EmpNo'");
                        $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT  Min(FDate) AS FromDate, Max(TDate) as ToDate  FROM tbl_individual_roster where EmpNo='$EmpNo' GROUP BY EmpNo");

                        //                        var_dump($dtRs);die;

                        $FromDate = $dtRs['dt'][0]->FromDate;
                        $ToDate = $dtRs['dt'][0]->ToDate;
                        //                        var_dump($dtRs); die;
                        // die;

                        $FromDate = $d1->modify("+1 day");

                        $FromDate = $FromDate->format('Y-m-d');

                        /*
                         * ******Get Employee IN Details
                         */
                        $dt_in_Records['dt_Records'] = $this->Db_model->getfilteredData("select min(AttTime) as INTime,Enroll_No,AttDate from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='$FromDate' ");

                        $InRecords = $dt_in_Records['dt_Records'][0]->AttDate;
                        //                        var_dump($InRecords);die;
                        //**** In Date
                        $InDate = $dt_in_Records['dt_Records'][0]->AttDate;
                        //**** In Time
                        $InTime = $dt_in_Records['dt_Records'][0]->INTime;
                        $InRec = 1;
                        /*
                         * ******Get Employee OUT Details
                         */
                        $dt_out_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select max(AttTime) as OutTime,Enroll_No,AttDate from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='$FromDate' ");

                        //**** Out Date
                        $OutDate = $dt_out_Records['dt_out_Records'][0]->AttDate;
                        //                        var_dump($OutDate);
                        //**** Out Time
                        $OutTime = $dt_out_Records['dt_out_Records'][0]->OutTime;
                        $OutRec = 0;
                        $OutRecords = $dt_out_Records['dt_out_Records'][0]->AttDate;
                        //                        var_dump($OutRecords);
                        //                        var_dump($InTime . 'In');
                        //                    if ($InTime == $OutTime) {
                        //
                        //                    }
                        //                    die;

                        if ($InRecords == null) {

                            //                            echo 'heeeeeeeeeeeeeeeeeeeee';
                            //                            var_dump($FromDate,$EmpNo);
                            $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='$FromDate' and Enroll_No='$EmpNo' and Is_Admin_App_ID=1");
                            //                            var_dump($Manual);
                            //                            var_dump($FromDate . 'Manual In record available');
                            //                            var_dump($Manual);die;

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
                        //
                        //                        if ($FromDate = "2023-07-05") {
                        //                            echo 'find______2023-07-nooooo';
                        ////                            die;
                        //                        }
                        if ($OutRecords == null) {

                            $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='$FromDate' and Enroll_No='$EmpNo' and Is_Admin_App_ID=1");

                            //                            var_dump($Manual);
                            //                            die;
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
                        //                        var_dump('Innnnsdsds  ' . $InTime . 'OUT Time' . $OutTime);

                        /*
                         * ***** Get Shift Code
                         */
                        //                        var_dump($EmpNo.$FromDate);die;
                        $SH['SH'] = $this->Db_model->getfilteredData("select ID_roster,EmpNo,ShiftCode,ShType,ShiftDay,Day_Type,FDate,FTime,TDate,TTime,ShType,GracePrd from tbl_individual_roster where EmpNo='$EmpNo' && FDate='$FromDate'");

                        //                        var_dump($FromDate);die;

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

                        //                        var_dump('-----------Roster-------------' . '' . $ID_Roster . '----------------------Roster');
                        //                        var_dump($ShiftType);
                        //                        var_dump($Shift_Day . $ShiftType . $EmpNo);
                        //die;
                        /*
                         * Get OT Pattern Details
                         */
                        $OT['OT'] = $this->Db_model->getfilteredData("SELECT tbl_ot_pattern_dtl.DayCode,tbl_ot_pattern_dtl.OTCode,tbl_empmaster.EmpNo,tbl_ot_pattern_dtl.OTPatternName,tbl_ot_pattern_dtl.DUEX,tbl_ot_pattern_dtl.BeforeShift,tbl_ot_pattern_dtl.MinBS,tbl_ot_pattern_dtl.AfterShift,tbl_ot_pattern_dtl.MinAS,tbl_ot_pattern_dtl.RoundUp,tbl_ot_pattern_dtl.Rate,tbl_ot_pattern_dtl.Deduct_LNC FROM tbl_ot_pattern_dtl RIGHT JOIN tbl_empmaster ON tbl_ot_pattern_dtl.OTCode = tbl_empmaster.OTCode WHERE tbl_ot_pattern_dtl.DayCode ='$Shift_Day' and tbl_ot_pattern_dtl.DUEX='$ShiftType'");
                        $AfterShiftWH = 0;
                        //                        var_dump($OT);die;

                        $Round = 1;
                        $BeforeShift = 2;
                        $AfterShift = 3;
                        $Rate = 4;
                        $DayCode = 5;
                        $Deduct_Lunch = 6;

                        //                          echo "<pre>";     var_dump($Round,$BeforeShift,$AfterShift,$Rate,$DayCode,$Deduct_Lunch);echo "<pre>"; die;
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

                            //                            echo 'IN and Out Both available';

                            //                            var_dump($SHFT);
                            $SHStartTime = strtotime($SHFT);

                            //                            echo "<pre>";
                            //                            var_dump($InTime . $SHFT . 'InTime Sh time');
                            //                            echo "<pre>";
                            $iCalc = round(($SHStartTime - $InTimeSrt) / 60);

                            //                            echo "<pre>";
                            //                            var_dump($iCalc);
                            //                            echo "<pre>";
                            //                            var_dump($iCalc . 'iCalc');
                            //                            die;
                            //                            (FLOOR(@AcceptedBeforeEarlyMinutes / @RoundUP) * @RoundUP);

                            if ($iCalc >= 0) {

                                $BeforeShift = $iCalc;

                                $BeforeShift = ($BeforeShift);

                                //                                $BeforeShift = ((floor(($BeforeShift + $GracePrd) / $Round)) * $Round);
                            }
                            $testBSH = floor($BeforeShift);

                            //                            var_dump($testBSH . 'Before shift');
                            //                            die;

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
                            $Nopay_Hrs = 0;
                        } else if ($InTime == '' && $OutTime == '') {
                            $DayStatus = 'AB';
                            $Nopay = 1;
                            //                            $Nopay_Hrs = (((strtotime($SHTT) - strtotime($SHFT)) - 60 * 60) / 60);
                            $Nopay_Hrs = (((strtotime($SHTT) - strtotime($SHFT))) / 60);
                            if ($DayType == 0.5) {
                                $Nopay = 0.5;
                                $Nopay_Hrs = (((strtotime($SHTT) - strtotime($SHFT))) / 60);
                            }
                            //                            var_dump($Nopay_Hrs . '----------------------------' . $SHTT . '---' . $SHFT);
                            $Att_Allowance = 0;

                            if ($InTime == '' && $OutTime == '' && $ShiftType == 'EX') {
                                $Nopay = 0;
                                $Nopay_Hrs = 0;
                                $DayStatus = 'EX';
                            }
                        }

                        $ApprovedExH = 0;
                        //                        echo "<pre>";
                        //                        var_dump($ApprovedExH);
                        //                        echo "<pre>";
                        //
                        //                    if ($OutTime != '') {
                        if ($OutTime != '' && $InTime != $OutTime) {
                            //                            var_dump($OutTime . '_Out Time' . $SHTT . '_Shift End Time -------------------------');
                            $OutTimeSrt = strtotime($OutTime);
                            $SHEndTime = strtotime($SHTT);

                            //                            var_dump('Innnn' . $InTime . 'OUTttt' . $OutTime . 'Shift Out' . $SHTT . 'Shift End Time');
                            //Get Hours
                            //$iCalc1= round(round(($OutTime1 - $SHEndTime1) / 60)/60);
                            //*******Get Minutes
                            $iCalcOut = round(($OutTimeSrt - $SHEndTime) / 60);
                            //                            var_dump($iCalcOut . 'icalc-----------------------------------------');
                            //                            die;
                            //                            var_dump('$EX_OT_Gap..............' . '.............$BeforeShift............' . $BeforeShift);
                            //                            var_dump('icalc----------------' . $iCalcOut);
                            //                            var_dump($Deduct_Lunch . '-------------------');
                            if ($iCalcOut >= 0 && $AfterShift == 1) {
                                $AfterShiftWH = $iCalcOut;

                                //                                var_dump('asfter--------------' . $AfterShift);
                                //----------------Do not delete if need re use ------------------------------If need deduct Lunch----------------------------------------------------------
                                //                                if ($Deduct_Lunch >= 0) {
                                //                                    $AfterShift = $iCalcOut - 60;
                                //                                }
                                //----------------------------------------------If need deduct Lunch----------------------------------------------------------
                            }

                            $SH_EX_OT = 0;
                            if ($ShiftType == 'DU') {
                                $ED = 0 - $iCalcOut;
                                if ($ED <= 0) {
                                    $ED = 0;
                                }
                            }
                            if ($ShiftType == 'EX') {
                                $EX_OT_Gap = round(((strtotime($SHTT) - strtotime($InTime)) - 60 * 60) / 60);
                                $SH_EX_OT = $EX_OT_Gap - $BeforeShift + 5;
                                $Nopay = 0;
                                $Nopay_Hrs = 0;

                                //                                var_dump($Nopay . '---------------');
                            }
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
                        // $NetLateM = 0;

                        //                        $ApprovedExH = (floor(($BeforeShift + $AfterShift + $SH_EX_OT) / $Round)) * $Round;
                        $ExH_OT = $BeforeShift + $AfterShiftWH;
                        //                        $ApprovedExH = (floor(($BeforeShift + $AfterShiftWH) / $Round)) * $Round;
                        //                        var_dump($BeforeShift . '$BeforeShift................' . $AfterShift . '$AfterShift.........................' . $SH_EX_OT . '$SH_EX_OT...............................' . $Round . '$Round.................');
                        //                        var_dump($ApprovedExH . '$ApprovedExH......................');
                        //                        die;
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

                        if ($NetLateM > $ExH_OT) {

                            //                            echo 'yes late wedi'. '<br>';
                            //                            echo '$NetLateM---------' . $NetLateM . '$ExH_OT------------' . $ExH_OT. '<br>';

                            $NetLateM = $NetLateM - $ExH_OT;

                            //                            echo '$NetLateM-----------' . $NetLateM. '<br>';

                            $ApprovedExH = 0;
                        } else {
                            $ApprovedExHTemp = ($ExH_OT - $NetLateM);
                            $ApprovedExH = (floor(($ApprovedExHTemp) / $Round)) * $Round;

                            //                            echo 'appppproved ---- '. $ApprovedExH. '<br>';

                            $NetLateM = 0;
                        }

                        //                        if ($ExH_OT <= $NetLateM) {
                        //                            $ApprovedExH = $ApprovedExH - $NetLateM;
                        //                            if ($ApprovedExH <= 0) {
                        //                                $ApprovedExH = 0;
                        //                            }
                        //                        }
                        //                        $NetLateM = 0;
                        //                        if ($ExH_OT > $NetLateM) {
                        //                            echo 'Yes OT wedi'. '<br>';
                        //                            echo $ExH_OT . '$ExH_OT$ExH_OT$ExH_OT$ExH_OT----------' . $NetLateM . '-----------$NetLateM$NetLateM$NetLateM$NetLateM';
                        //                            echo 'page 462-----------goooooooooooooooooooooooooooooooooooooodddddddddddddddddddddddddddddddddddddddddddddddd' . $ApprovedExHTemp;
                        //                            var_dump($ApprovedExH.'sdsdsdsdsdsdsdsdaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
                        //                            die;
                        //                        }
                        //                        echo 'before submit app-----'. $ApprovedExH. '<br>';
                        //                        die;

                        if ($ApprovedExH >= 0) {

                            $dataArray = array(
                                'EmpNo' => $EmpNo,
                                'OTDate' => $FromDate,
                                'RateCode' => $Rate,
                                'OT_Cat' => $DayCode,
                                'OT_Min' => $ApprovedExH,
                            );

                            //                            var_dump($dataArray);
                            $whereArray = array("EmpNo" => $ID_Roster, "OTDate" => $FromDate);
                            $result = $this->Db_model->updateData("tbl_ot_d", $dataArray, $whereArray);
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
                        //                        echo $FromDate;
                        //                        echo $OutTime;
                        //                        echo $Nopay . 'No Pay';
                        //                        if ($FromDate == "2023-07-05") {
                        //                            echo $OutTime . 'yyyyyyyyyyyyyyyyyyyy' . $InTime . $ID_Roster . $Nopay;
                        ////                            die;
                        //                        }
                        //                        die;
                        $data_arr = array("InRec" => 1, "InDate" => $FromDate, "InTime" => $InTime, "OutRec" => 1, "OutDate" => $FromDate, "OutTime" => $OutTime, "nopay" => $Nopay, "Is_processed" => 1, "DayStatus" => $DayStatus, "BeforeExH" => $BeforeShift, "AfterExH" => $AfterShiftWH, "LateSt" => $Late_Status, "LateM" => $lateM, "EarlyDepMin" => $ED, "NetLateM" => $NetLateM, "ApprovedExH" => $ApprovedExH, "nopay_hrs" => $Nopay_Hrs, "Att_Allow" => $Att_Allowance);
                        $whereArray = array("ID_roster" => $ID_Roster);
                        //                         $whereArray = array("EmpNo" => $FromDate, "EmpNo" => $EmpNo ,""=> $DayStatus);
                        $result = $this->Db_model->updateData("tbl_individual_roster", $data_arr, $whereArray);
                        //                        var_dump($data_arr);
                        //                        var_dump('last Die');
                    }
                }
            }
            //            die;
            $this->session->set_flashdata('success_message', 'Attendance Process successfully');
            redirect('/Attendance/Attendance_Process_New/re_process');
        } else {
            //            die;
            $this->session->set_flashdata('success_message', 'Attendance Process successfully');
            redirect('/Attendance/Attendance_Process_New/re_process');
        }
        //        die;
        $this->session->set_flashdata('success_message', 'Attendance Process successfully');
        redirect('/Attendance/Attendance_Process_New/re_process');
    }

    public function emp_attendance_process()
    {

        date_default_timezone_set('Asia/Colombo');
        /*
         * Get Employee Data
         * Emp no , EPF No, Roster Type, Roster Pattern Code, Status
         */
        //        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("SELECT EmpNo,Enroll_No, EPFNO,RosterCode, Status  FROM  tbl_empmaster where status=1");
        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("select * from tbl_individual_roster where Is_processed = 0");
        // $dtEmp['EmpData'] = $this->Db_model->getfilteredData("SELECT EmpNo,Enroll_No, EPFNO,RosterCode, Status  FROM  tbl_empmaster where EmpNo=3316");
        // echo "<pre>";
        // echo 'count--------------------------';
        // var_dump(($dtEmp['EmpData']));
        // var_dump(count($dtEmp['EmpData']));
        // echo "<pre>";
        $InTime = 0;
        $OutTime = 0;
        $AfterShift = 0;

        if (!empty($dtEmp['EmpData'])) {

            for ($x = 0; $x < count($dtEmp['EmpData']); $x++) {
                $EmpNo = $dtEmp['EmpData'][$x]->EmpNo;

                $app_date = $this->Db_model->getfilteredData("SELECT tbl_empmaster.ApointDate FROM tbl_empmaster WHERE tbl_empmaster.EmpNo = '$EmpNo'");
                $apoint_date = $app_date[0]->ApointDate;

                $FromDate = $dtEmp['EmpData'][$x]->FDate;
                $ToDate = $dtEmp['EmpData'][$x]->TDate;
                //Check If From date less than to Date
                if ($FromDate <= $ToDate) {
                    $settings = $this->Db_model->getfilteredData("SELECT tbl_setting.Group_id,tbl_setting.Ot_m,tbl_setting.Ot_e,tbl_setting.Ot_d_Late,
                    tbl_setting.Late,tbl_setting.Ed,tbl_setting.Min_time_t_ot_m,tbl_setting.Min_time_t_ot_e,
                    tbl_setting.late_Grs_prd,tbl_setting.`Round`,tbl_setting.Hd_d_from,tbl_setting.Dot_f_holyday,tbl_setting.Dot_f_offday
                     FROM tbl_setting INNER JOIN tbl_emp_group ON tbl_setting.Group_id = tbl_emp_group.Grp_ID
                     INNER JOIN tbl_empmaster ON tbl_empmaster.Grp_ID = tbl_emp_group.Grp_ID WHERE tbl_empmaster.EmpNo = '$EmpNo'");
                    $ApprovedExH = 0;
                    $DayStatus = "not";

                    // Get the CheckIN
                    $dt_in_Records['dt_Records'] = $this->Db_model->getfilteredData("select min(AttTime) as INTime,Enroll_No,AttDate from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='" . $FromDate . "'");

                    $InRecords = $dt_in_Records['dt_Records'][0]->AttDate;

                    //**** In Date
                    $InDate = $dt_in_Records['dt_Records'][0]->AttDate;
                    //**** In Time
                    $InTime = $dt_in_Records['dt_Records'][0]->INTime;
                    $InRec = 1;

                    // **************************************************************************************//
                    // tbl_individual_roster eke OFF dwas ganne
                    $OFFDAY['OFF'] = $this->Db_model->getfilteredData("select `ShType` from tbl_individual_roster where FDate = '$FromDate'");
                    $Day = $OFFDAY['OFF'][0]->ShType;

                    if ($Day != "OFF") {

                        // Get the CheckOut
                        $dt_out_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select max(AttTime) as OutTime,Enroll_No,AttDate from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='" . $FromDate . "' ");

                        //**** Out Date
                        $OutDate = $dt_out_Records['dt_out_Records'][0]->AttDate;
                        //**** Out Time
                        $OutTime = $dt_out_Records['dt_out_Records'][0]->OutTime;
                        $OutRec = 0;
                        $OutRecords = $dt_out_Records['dt_out_Records'][0]->AttDate;

                        // Out Ekak nethnm check nextday(1st nextDay)
                        if ($OutTime == null) {

                            // Use Carbon to add one day to the date
                            $newDate = date('Y-m-d', strtotime($FromDate . ' +1 day'));

                            // Get the CheckOut in the nextDay (before 8am)
                            $dt_out_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select min(AttTime) as OutTime,Enroll_No,AttDate from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='$newDate' AND AttTime <'08:00:00'");

                            //**** Out Date
                            $OutDate = $dt_out_Records['dt_out_Records'][0]->AttDate;
                            //**** Out Time
                            $OutTime = $dt_out_Records['dt_out_Records'][0]->OutTime;
                            $OutRec = 0;
                            $OutRecords = $dt_out_Records['dt_out_Records'][0]->AttDate;

                        } else {

                            // nextDay Ekak nethnm this day(ema dwsema) ekema rathri 12 sita ude 8 dkwa record ekak thiywda balanwa
                            $dt_out_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select max(AttTime) as OutTime,Enroll_No,AttDate from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='" . $FromDate . "' AND AttTime BETWEEN '00:01:00' AND '08:00:00' ");

                            //**** Out Date
                            $OutDate1 = $dt_out_Records['dt_out_Records'][0]->AttDate;
                            //**** Out Time
                            $OutTime1 = $dt_out_Records['dt_out_Records'][0]->OutTime;
                            $OutRec1 = 0;
                            $OutRecords1 = $dt_out_Records['dt_out_Records'][0]->AttDate;

                            // ema record ekak thiywam
                            if ($OutTime1 != null) {
                                $newDate = date('Y-m-d', strtotime($FromDate . ' +1 day'));

                                // aye ee dwse idn thwa nextDay ekak balanwa (2nd nextDay)
                                $dt_out_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select min(AttTime) as OutTime,Enroll_No,AttDate from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='$newDate' AND AttTime <'08:00:00'");

                                //**** Out Date
                                $OutDate = $dt_out_Records['dt_out_Records'][0]->AttDate;
                                //**** Out Time
                                $OutTime = $dt_out_Records['dt_out_Records'][0]->OutTime;
                                $OutRec = 0;
                                $OutRecords = $dt_out_Records['dt_out_Records'][0]->AttDate;

                                if ($OutTime == null) {
                                    $OFFDAY['OFF'] = $this->Db_model->getfilteredData("select `ShType` from tbl_individual_roster where FDate = '$FromDate'");
                                    $Day = $OFFDAY['OFF'][0]->ShType;

                                    if ($Day != "OFF") {

                                        // same day ekma hws thiywda balanwa
                                        $dt_out_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select max(AttTime) as OutTime,Enroll_No,AttDate from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='" . $FromDate . "' AND AttTime >'08:00:00' ");

                                        //**** Out Date
                                        $OutDate = $dt_out_Records['dt_out_Records'][0]->AttDate;
                                        //**** Out Time
                                        $OutTime = $dt_out_Records['dt_out_Records'][0]->OutTime;
                                        $OutRec = 0;
                                        $OutRecords = $dt_out_Records['dt_out_Records'][0]->AttDate; //

                                        if ($OutTime == null) {
                                            $DayStatus = 'MS';
                                            $Late_Status = 0;
                                            $Nopay = 0;
                                            $OutTime = "00:00:00";
                                        }

                                    }
                                }

                            } else {
                                $OFFDAY['OFF'] = $this->Db_model->getfilteredData("select `ShType` from tbl_individual_roster where FDate = '$FromDate'");
                                $Day = $OFFDAY['OFF'][0]->ShType;

                                if ($Day != "OFF") {
                                    $dt_out_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select max(AttTime) as OutTime,Enroll_No,AttDate from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='" . $FromDate . "' ");

                                    //**** Out Date
                                    $OutDate = $dt_out_Records['dt_out_Records'][0]->AttDate;
                                    //                        var_dump($OutDate);
                                    //**** Out Time
                                    $OutTime = $dt_out_Records['dt_out_Records'][0]->OutTime;
                                    $OutRec = 0;
                                    $OutRecords = $dt_out_Records['dt_out_Records'][0]->AttDate;
                                }

                            }
                        }

                        // var_dump($InRecords . ' ' . $InTime . ' ' . $EmpNo);
                        // echo "<br>";
                        // var_dump($OutDate . ' ' . $OutTime . ' ' . $EmpNo);
                        // echo "<br>";
                        // echo "<br>";
                    }
                    // die;
                    // echo $EmpNo.' '.$OutDate.' '.$OutTime .' '.$newDate;
                    // echo '<br>';

                    // Manual Entry-START****************************************

                    // **************************************************************************************//
                    // if ($InRecords == null) {

                    //     $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='" . $FromDate . "' and Enroll_No='$EmpNo' and Is_Admin_App_ID=1 and Status='0'");
                    //     if (!empty ($Manual)) {

                    //         $InDate = $Manual[0]->Att_Date;
                    //         //**** In Time
                    //         $InTime = $Manual[0]->In_Time;

                    //         $InRec = 1;
                    //     }
                    // }

                    // if ($OutTime == null) {
                    //     $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='" . $FromDate . "' and Enroll_No='$EmpNo' and Is_Admin_App_ID=1 and Status='1'");
                    //     if (!empty($Manual)) {

                    //         $OutDate = $Manual[0]->Att_Date;
                    //         //**** In Time
                    //         $OutTime = $Manual[0]->In_Time;
                    //         $InRec = 1;

                    //         if ($OutTime == null) {

                    //             $newDate = date('Y-m-d', strtotime($FromDate . ' +1 day'));
                    //             $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='" . $newDate . "' and Enroll_No='$EmpNo' and Is_Admin_App_ID=1 and Status='1' AND In_Time <'08:00:00'");
                    //             if (!empty($Manual)) {

                    //                 $OutDate = $Manual[0]->Att_Date;
                    //                 //**** In Time
                    //                 $OutTime = $Manual[0]->In_Time;

                    //                 $InRec = 1;
                    //             }
                    //         }

                    //     }
                    // }
                    // Manual Entry-END********************************************8

                    // if ($InTime == $OutTime) {
                    //     $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='" . $FromDate . "' and Enroll_No='$EmpNo' and Is_Admin_App_ID=1");
                    //     if (!empty($Manual)) {

                    //         $InDate = $Manual[0]->Att_Date;
                    //         //**** In Time
                    //         $InTime = $Manual[0]->In_Time;

                    //         $OutTime = $Manual[0]->Out_Time;

                    //         $InRec = 1;
                    //     }
                    // }

                    // if ($OutRecords == null) {

                    //     $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='" . $FromDate . "' and Enroll_No='$EmpNo' and Is_Admin_App_ID=1");

                    //     if (!empty($Manual)) {

                    //         $OutDate = $Manual[0]->Att_Date;
                    //         //**** In Time
                    //         $OutTime = $Manual[0]->Out_Time;

                    //         $OutRec = 1;
                    //     }
                    // }

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

                    /*
                     * Get OT Pattern Details
                     */
                    $OT['OT'] = $this->Db_model->getfilteredData("SELECT tbl_ot_pattern_dtl.DayCode,tbl_ot_pattern_dtl.OTCode,tbl_empmaster.EmpNo,tbl_ot_pattern_dtl.OTPatternName,tbl_ot_pattern_dtl.DUEX,tbl_ot_pattern_dtl.BeforeShift,tbl_ot_pattern_dtl.MinBS,tbl_ot_pattern_dtl.AfterShift,tbl_ot_pattern_dtl.MinAS,tbl_ot_pattern_dtl.RoundUp,tbl_ot_pattern_dtl.Rate,tbl_ot_pattern_dtl.Deduct_LNC FROM tbl_ot_pattern_dtl RIGHT JOIN tbl_empmaster ON tbl_ot_pattern_dtl.OTCode = tbl_empmaster.OTCode WHERE tbl_ot_pattern_dtl.DayCode ='$Shift_Day' and tbl_ot_pattern_dtl.DUEX='$ShiftType'");
                    $AfterShiftWH = 0;

                    $Round = $OT['OT'][0]->RoundUp;
                    $BeforeShift = $OT['OT'][0]->BeforeShift;
                    $AfterShift = $OT['OT'][0]->AfterShift;
                    $Rate = $OT['OT'][0]->Rate;
                    $DayCode = $OT['OT'][0]->DayCode;
                    $Deduct_Lunch = $OT['OT'][0]->Deduct_LNC;
                    $MinAS = $OT['OT'][0]->MinAS;

                    $lateM = 0;
                    // $BeforeShift = 0;
                    $Late_Status = 0;
                    $NetLateM = 0;
                    $ED = 0;
                    $EDF = 0;
                    $Att_Allowance = 1;
                    $Nopay = 0;

                    // if ($InTime !== null) {
                    //     $InTime = substr($InTime, 0, 5);
                    // }
                    // **************************************************************************************//
                    if ($InTime == $OutTime || $OutTime == null || $OutTime == '') {
                        $DayStatus = 'MS';
                        $Late_Status = 0;
                        $Nopay = 0;
                        $Nopay_Hrs = 0;
                    }

                    /*
                     * If In Available & Out Missing
                     */
                    if ($InTime != '' && $InTime == $OutTime) {
                        $DayStatus = 'MS';
                        $Late_Status = 0;
                        $Nopay = 0;
                        $Nopay_Hrs = 0;
                    }

                    // If Out Available & In Missing
                    if ($OutTime != '' && $InTime == $OutTime) {
                        $DayStatus = 'MS';
                        $Late_Status = 0;
                        $Nopay = 0;
                        $Nopay_Hrs = 0;
                    }

                    // If In Available & Out Missing
                    if ($InTime != '' && $OutTime == '') {
                        $DayStatus = 'MS';
                        $Late_Status = 0;
                        $Nopay = 0;
                        $Nopay_Hrs = 0;
                    }

                    // If Out Available & In Missing
                    if ($OutTime != '' && $InTime == '') {
                        $DayStatus = 'MS';
                        $Late_Status = 0;
                        $Nopay = 0;
                        $Nopay_Hrs = 0;
                    }
                    // **************************************************************************************//

                    if ($InTime != '' && $InTime != $OutTime && $OutTime != '') {
                        $Nopay = 0;
                        $DayStatus = 'PR';
                        $Nopay_Hrs = 0;
                    }
                    // **************************************************************************************//

                    // **************************************************************************************//

                    // // IN wenna kalin OT
                    // if ($InTime != '' && $InTime != $OutTime) {
                    //     $InTimeSrt = strtotime($InTime);
                    //     $SHStartTime = strtotime($SHFT);
                    //     $iCalc = round(($SHStartTime - $InTimeSrt) / 60);

                    //     if ($iCalc >= 0) {

                    //         $BeforeShift = $iCalc;

                    //         $BeforeShift = ($BeforeShift);
                    //     }
                    //     $testBSH = floor($BeforeShift);

                    //     if ($ShiftType == 'DU') {
                    //         $Late = true;

                    //         $lateM = 0 - $iCalc - $GracePrd;
                    //         $Late_Status = 1;

                    //         if ($lateM <= 0) {
                    //             $lateM = 0;
                    //         }
                    //     }
                    //     $Nopay = 0;
                    //     $DayStatus = 'PR';
                    //     $Nopay_Hrs = 0;
                    // } else

                    // **************************************************************************************//
                    $Nopay_Hrs = 0;
                    // Nopay
                    if ($InTime == '' && $OutTime == '' && $Day == 'DU') {
                        $DayStatus = 'AB';
                        $Nopay = 1;
                        $Nopay_Hrs = (((strtotime($SHTT) - strtotime($SHFT))) / 60);

                        // if ($DayType == 0.5) {
                        //     $Nopay = 0.5;
                        //     $Nopay_Hrs = (((strtotime($SHTT) - strtotime($SHFT))) / 60);
                        // }
                        // $Att_Allowance = 0;

                        if ($InTime == '' && $OutTime == '' && $Day == 'EX') {
                            $Nopay = 0;
                            $Nopay_Hrs = 0;
                            $DayStatus = 'EX';
                        }

                    }

                    // var_dump($InDate . ' ' . $InTime . ' ' . $ED . ' ' . $DayStatus);
                    // echo "<br>";
                    // var_dump($OutDate . ' ' . $OutTime . ' ' . $EmpNo);
                    // echo "<br>";
                    // echo "<br>";
                    // die;

                    // DOT
                    // if ($ShiftType == 'EX') {
                    //     $EX_OT_Gap = round(((strtotime($SHTT) - strtotime($InTime)) - 60 * 60) / 60);
                    //     $SH_EX_OT = $EX_OT_Gap - $BeforeShift + 5;
                    //     $Nopay = 0;
                    //     $Nopay_Hrs = 0;
                    // }

                    // **************************************************************************************//
                    // haffDay thiywam
                    if ($InTime != '' && $InTime != $OutTime && $Day == 'DU' || $OutTime != '' && $InTime != $OutTime && $Day == 'DU') {
                        // $HaffDayaLeave = $this->Db_model->getfilteredData("SELECT * FROM tbl_leave_entry where EmpNo = $EmpNo and Leave_Date = '$FromDate' AND Leave_Count='0.5' ");

                        // Half day ekak thiywanm withari Late ganne

                    }
                    // Half day ekak thiywanm withari ED ganne

                    // **************************************************************************************//
                    //OT
                    $ApprovedExH = 0;
                    $SH_EX_OT = 0;
                    if ($OutTime != '' && $InTime != $OutTime && $InTime != '' && $Day == 'DU' && $OutTime != "00:00:00") {

                        // **************************************************************************************//
                        // Out wunma passe OT
                        $SHIFTDAY['SHIFT'] = $this->Db_model->getfilteredData("SELECT `TDate` FROM tbl_individual_roster WHERE FDate = '$FromDate'");
                        $ToDateOT = $SHIFTDAY['SHIFT'][0]->TDate;
                        // date samanam
                        if ($ToDateOT == $OutDate) {
                            if ($AfterShift == 1) {

                                $OutTimeSrt = strtotime($OutTime);
                                $SHEndTime = strtotime($SHTT);

                                //*******Get Minutes
                                $iCalcOut = (($OutTimeSrt - $SHEndTime) / 60);
                                // if($OutTime >= "19:30:00"){
                                //     $icalData = $iCalcOut;
                                // }else{
                                //     $icalData = 0;
                                // }
                                $icalData = $iCalcOut - $MinAS; //windi 30kin pase OT hedenne(tbl_ot_pattern_dtl eken balanna)

                            } else if ($AfterShift == 0) {

                                $OutTimeSrt = strtotime($OutTime);
                                $SHEndTime = strtotime($SHTT);

                                //*******Get Minutes
                                $iCalcOut = (($OutTimeSrt - $SHEndTime) / 60);
                                $icalData = $iCalcOut;

                            }
                        } else {
                            // nextDay thiywam OT hedena widiha
                            if ($AfterShift == 1) {

                                // $SHEndTime = strtotime($SHTT);

                                // $OutTime;

                                // $H = explode(":",$OutTime);
                                // $H2 = $H[0];

                                // $OutT = $H2+24;

                                // $OutTimeSrt = strtotime($OutT);

                                // // $OTHHH = $OutT-$SHTT;

                                // $iCalcOut = (($OutTimeSrt - $SHEndTime) / 60);

                                // Define the two dates
                                $date1 = new DateTime($SHTT);
                                $date2 = new DateTime($OutTime);

                                // Subtract 24 hours from $date1
                                $date1->sub(new DateInterval('P1D')); // P1D represents a period of 1 day

                                // Calculate the difference in minutes
                                $interval = $date2->getTimestamp() - $date1->getTimestamp();
                                $totalMinutes = round($interval / 60); // Convert seconds to minutes

                                // Subtract 30 minutes
                                // $totalMinutes -= 30;

                                // Store the result in $icalData
                                $icalData = $totalMinutes;

                                // echo $icalData; // Output: Updated time difference in minutes

                                // Using codnighter
                                // echo $timeDifference;

                                // Using codnighter

                                //*******Get Minutes
                                // $iCalcOut = (($OutTimeSrt - $SHEndTime) / 60);
                                // $icalData = $iCalcOut - $MinAS;//windi 30kin pase OT hedenne(tbl_ot_pattern_dtl eken balanna)

                            } else if ($AfterShift == 0) { //30m gap ekak nethnm
                                // check
                                // Define the two dates
                                $date1 = new DateTime($SHTT);
                                $date2 = new DateTime($OutTime);

                                // Subtract 24 hours from $date1
                                $date1->sub(new DateInterval('P1D')); // P1D represents a period of 1 day

                                // Calculate the difference in minutes
                                $interval = $date2->getTimestamp() - $date1->getTimestamp();
                                $totalMinutes = round($interval / 60); // Convert seconds to minutes

                                // Subtract 30 minutes
                                $totalMinutes -= 30;

                                // Store the result in $icalData
                                $icalData = $totalMinutes;

                            }

                        }

                        // if ($icalData >= 0 && ) {
                        // }

                        // Out wunma passe OT
                        if ($icalData >= 0 && $AfterShift == 1) {
                            $AfterShiftWH = $icalData;
                        }

                        // **************************************************************************************//
                        // kalin giya ewa (ED)
                        $SHIFTDAY['SHIFT'] = $this->Db_model->getfilteredData("SELECT `TDate` FROM tbl_individual_roster WHERE FDate = '$FromDate'");
                        $ToDateOT = $SHIFTDAY['SHIFT'][0]->TDate;
                        // date samanam
                        if ($ToDateOT == $OutDate) {
                            if ($Day == 'DU') {
                                if ($OutTime < $SHTT) {
                                    $OutTimeSrt = strtotime($OutTime);
                                    $SHEndTime = strtotime($SHTT);
                                    $EDF = ($SHEndTime - $OutTimeSrt) / 60;

                                    // kalin gihhilanm haff day ekak thiynwda balanna
                                    $HaffDayaLeave = $this->Db_model->getfilteredData("SELECT * FROM tbl_leave_entry where EmpNo = $EmpNo and Leave_Date = '$FromDate' AND Leave_Count='0.5' ");
                                    if (!empty($HaffDayaLeave[0]->Is_Approve)) {
                                        $SHstarttime = "14:00:00";

                                        $OutTimeSrt = strtotime($OutTime);
                                        $SHstartimeSrt = strtotime($SHstarttime);

                                        $iCalcHaffED = ($SHstartimeSrt - $OutTimeSrt) / 60;

                                        if ($iCalcHaffED >= 0) {
                                            //ED thiywa
                                            $ED = $iCalcHaffED;
                                            // $ED = $EDF + $iCalcHaffED;

                                        } else if ($iCalcHaffED <= 0) {
                                            //ED nee
                                            $ED = 0;
                                        }
                                    } else {

                                        $HDFDateSrt = strtotime($InDate);
                                        $OutDateSrt = strtotime($OutDate);

                                        if ($HDFDateSrt == $OutDateSrt) {

                                            $ED = $EDF;

                                        } else {
                                            $ED = 0;
                                        }
                                    }
                                }

                                // $ED = 0 - $icalData;
                                // if ($ED <= 0) {
                                //     $ED = 0;
                                // }
                            }
                        }

                        // **************************************************************************************//
                        // HaffDay walata kalin gihin nethnm (ED)
                        if ($InTime != '' && $InTime != $OutTime && $Day == 'DU' || $OutTime != '' && $Day == 'DU') {

                            $HaffDayaLeave = $this->Db_model->getfilteredData("SELECT * FROM tbl_leave_entry where EmpNo = $EmpNo and Leave_Date = '$FromDate' AND Leave_Count='0.5' ");
                            if (!empty($HaffDayaLeave[0]->Is_Approve)) {
                                $SHstarttime = "14:00:00";

                                $OutTimeSrt = strtotime($OutTime);
                                $SHstartimeSrt = strtotime($SHstarttime);

                                $iCalcHaffED = ($SHstartimeSrt - $OutTimeSrt) / 60;

                                if ($iCalcHaffED <= 0) {
                                    //ED nee

                                    $ED = 0;
                                } else if ($iCalcHaffED >= 0) {

                                    $HDFDateSrt = strtotime($InDate);
                                    $OutDateSrt = strtotime($OutDate);

                                    if ($HDFDateSrt == $OutDateSrt) {

                                        $ED = $iCalcHaffED;

                                    } else {
                                        $ED = 0;
                                    }
                                }
                            }
                        }

                    }

                    $lateM = 0; //late minutes
                    $ED = 0; //ED minutes
                    $iCalcHaffT = 0;
                    // New Late with HFD
                    
                    if ($InTime != '' && $InTime != $OutTime && $Day == 'DU' || $OutTime != '' && $Day == 'DU') {

                        $SHStartTime = strtotime($SHFT);
                        $InTimeSrt = strtotime($InTime);

                        $iCalc = ($InTimeSrt - $SHStartTime) / 60; //minutes
                        
                        $HaffDayaLeave = $this->Db_model->getfilteredData("SELECT count(EmpNo) as HasRow FROM tbl_leave_entry where EmpNo = $EmpNo and Leave_Date = '$FromDate' AND Leave_Count='0.5' ");

                        // if ($HaffDayaLeave[0]->HasRow == 0) {
                        //     $lateM = $iCalc - $GracePrd;
                        // }else{
                        //     $lateM = 0;
                        // }
                        $lateM = $iCalc - $GracePrd;
                        

                        $HaffDayaLeave = $this->Db_model->getfilteredData("SELECT * FROM tbl_leave_entry where EmpNo = $EmpNo and Leave_Date = '$FromDate' AND Leave_Count='0.5' ");
                        // echo $HaffDayaLeave[0]->Is_Approve.'********';
                        // haffDay thiywam (only) Morning
                        if (!empty($HaffDayaLeave[0]->Is_Approve)) {
                            $SHTtime = "14:00:00";
                            // $SHFttime = "19:00:00";

                            $InTimeSrt = strtotime($InTime);
                            $SHToTimeSrt = strtotime($SHTtime);

                            $iCalcHaffT = ($InTimeSrt - $SHToTimeSrt) / 60;
                            
                            if ($InTime <= "11:00:00") {
                                $lateM;
                            } else {
                                if ($iCalcHaffT <= 0) {
                                    // welawta ewilla
                                    $lateM = 0;
                                    $Late_Status = 0;
                                    $DayStatus = 'HFD';

                                } else if ($iCalcHaffT >= 0) {
                                    $lateM = $iCalcHaffT;

                                    $DayStatus = 'HFD';
                                }
                            }

                            

                        }
                        

                        $SHEndTime = strtotime($SHTT);
                        $OutTimeSrt = strtotime($OutTime);

                        $iCalcED = ($SHEndTime - $OutTimeSrt) / 60; //minutes

                        if($OutTime != '' && $InDate == $OutDate){
                            if ($ED >= 0) {
                                $ED = $iCalcED;
                            }
                        }

                        // haffDay thiywam (only) Evening
                        if (!empty($HaffDayaLeave[0]->Is_Approve)) {
                            $HDFTtime = "14:00:00";

                            $HDFTimeSrt = strtotime($HDFTtime);
                            $OutTimeSrt = strtotime($OutTime);

                            $iCalcHaffT = ($HDFTimeSrt - $OutTimeSrt) / 60;

                            if ($InTime <= "13:00:00") {
                                if ($iCalcHaffT <= 0) {
                                    // welawta ewilla
                                    $ED = 0;
                                    // $Late_Status = 0;
                                    $DayStatus = 'HFD';
                                    $lateM;

                                } else if ($iCalcHaffT >= 0) {
                                    $DayStatus = 'HFD';

                                    $HDFDateSrt = strtotime($InDate);
                                    $OutDateSrt = strtotime($OutDate);

                                    if ($HDFDateSrt == $OutDateSrt) {

                                        $ED = $iCalcHaffT;
                                        $lateM;

                                    } else {
                                        $ED = 0;
                                    }
                                }
                            }

                        }

                    }

                    // ===================Start Short Leave

                    // **************************************************************************************//
                    // Get the BreakkIN
                    $dt_Breakin_Records['dt_Records'] = $this->Db_model->getfilteredData("select min(AttTime) as INTime,Enroll_No,AttDate from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='" . $FromDate . "' AND Status='3' ");
                    $BreakInRecords = $dt_Breakin_Records['dt_Records'][0]->AttDate;
                    $BreakInDate = $dt_Breakin_Records['dt_Records'][0]->AttDate;
                    $BreakInTime = $dt_Breakin_Records['dt_Records'][0]->INTime;
                    $BreakInRec = 1;

                    // Get the BreakOut
                    $dt_Breakout_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select max(AttTime) as OutTime,Enroll_No,AttDate from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='" . $FromDate . "' AND Status='4' ");
                    $BreakOutDate = $dt_Breakout_Records['dt_out_Records'][0]->AttDate;
                    $BreakOutTime = $dt_Breakout_Records['dt_out_Records'][0]->OutTime;
                    $BreakOutRec = 0;
                    $BreakOutRecords = $dt_Breakout_Records['dt_out_Records'][0]->AttDate;

                    // // ShortLeave thani eka [(After)atharameda]
                    if ($BreakInTime != null && $BreakOutTime != null) {
                        $BreakInTime = $dt_Breakin_Records['dt_Records'][0]->INTime;
                        $BreakOutTime = $dt_Breakout_Records['dt_out_Records'][0]->OutTime;

                        //Late(Short)
                        $ShortLeave = $this->Db_model->getfilteredData("SELECT * FROM tbl_shortlive WHERE EmpNo = $EmpNo AND tbl_shortlive.Date = '$FromDate' AND Is_Approve = 1");
                        if (!empty($ShortLeave[0]->Is_Approve)) {
                            $SHFtime = $ShortLeave[0]->from_time;
                            $SHTtime = $ShortLeave[0]->to_time;

                            $BreakOutTimeSrt = strtotime($BreakOutTime);
                            $SHToTimeSrt = strtotime($SHTtime);

                            $iCalcShortLTIntv = ($BreakOutTimeSrt - $SHToTimeSrt) / 60;
                            $DayStatus = 'SL';
                            if ($iCalcShortLTIntv <= 0) {
                                // welawta ewilla

                            } else if ($iCalcShortLTIntv >= 0) {
                                // welatwa ewilla ne(short leave & haffDay ektath passe late)
                                $lateM = $iCalcHaffT + $iCalcShortLTIntv;

                            }
                        }

                        // ED(Short)
                        if (!empty($ShortLeave[0]->Is_Approve)) {
                            $SHFtime = $ShortLeave[0]->from_time;
                            $SHTtime = $ShortLeave[0]->to_time;

                            $BreakInTimeSrt = strtotime($BreakInTime);
                            $SHFromTimeSrt = strtotime($SHFtime);

                            $iCalcShortLTIntvED = ($SHFromTimeSrt - $BreakInTimeSrt) / 60;
                            $DayStatus = 'SL';

                            if ($iCalcShortLTIntvED <= 0) {
                                // ee welwta hari ee welwen passe hari gihinm

                            } else if ($iCalcShortLTIntvED >= 0) {
                                // kalin gihinm
                                // $ED = $EDF + $iCalcShortLTIntvED;
                                $ED = $iCalcShortLTIntvED;

                            }
                        }
                    }

                    // Hawasa ShortLeave thiynwam
                    $ShortLeave = $this->Db_model->getfilteredData("SELECT * FROM tbl_shortlive WHERE EmpNo = $EmpNo AND tbl_shortlive.Date = '$FromDate' AND Is_Approve = 1");
                    if (!empty($ShortLeave[0]->Is_Approve)) {
                        if ($ShortLeave[0]->from_time >= '17:30:00') {

                            $SHFtime = $ShortLeave[0]->from_time;
                            $SHTtime = $ShortLeave[0]->to_time;

                            if (($OutTime > '17:30:00') || ($OutTime < '18:00:00')) {
                                // echo $InTime . '-' . $OutTime . ' || ' . $EmpNo;
                                // echo "<br>";
                                // echo $FromDate;
                                // echo "<br>";
                                $OutTimeSrt = strtotime($OutTime);
                                $SHFromTimeSrt = strtotime($SHFtime);

                                $iCalcShortLTED = ($SHFromTimeSrt - $OutTimeSrt) / 60;
                                // echo $iCalcShortLTED;
                                if ($iCalcShortLTED > 0) {
                                    $ED = 0;
                                    $ED = $iCalcShortLTED;
                                    $DayStatus = 'SL';

                                } else {
                                    $ED = 0;
                                    $DayStatus = 'SL';
                                    // echo "2";
                                }
                            } else {

                            }

                        }
                    }

                    // Morning In Time ekata kalin short leave thiywam
                    $ShortLeave = $this->Db_model->getfilteredData("SELECT * FROM tbl_shortlive WHERE EmpNo = $EmpNo AND tbl_shortlive.Date = '$FromDate' AND Is_Approve = 1");
                    if (!empty($ShortLeave[0]->Is_Approve)) {
                        $SHFtime = $ShortLeave[0]->from_time;
                        $SHTtime = $ShortLeave[0]->to_time;

                        $InTimeSrt = strtotime($InTime);
                        $SHToTimeSrt = strtotime($SHTtime);

                        $iCalcShortLT = ($InTimeSrt - $SHToTimeSrt) / 60;

                        if ($SHFtime <= "10:00:00") {
                            if ($iCalcShortLT <= 0) {
                                // welawta ewilla
                                $lateM = 0;
                                $Late_Status = 0;
                                $DayStatus = 'SL';
    
                            } else {
                                // welatwa ewilla ne(short leave ektath passe late /haffDay ne )
                                $lateM = $iCalcShortLT;
                                $DayStatus = 'SL';
    
                                // echo "2gg";
                            }
                        }
                        
                    }

                    // // var_dump($InDate . ' ' . $InTime . ' ' . $ED . ' ' . $DayStatus);
                    // // echo "<br>";
                    // // var_dump($OutDate . ' ' . $OutTime . ' ' . $EmpNo);
                    // // echo "<br>";
                    // // echo "<br>";
                    // // **************************************************************************************//
                    // $lateM = 0;
                    // Late
                    // if ($InTime != '' && $InTime != $OutTime && $Day == 'DU' || $OutTime != '' && $Day == 'DU') {
                    //     $Late = true;

                    //     $SHStartTime = strtotime($SHFT);
                    //     $InTimeSrt = strtotime($InTime);

                    //     $iCalc = ($InTimeSrt - $SHStartTime) / 60;

                    //     $ShortLeave = $this->Db_model->getfilteredData("SELECT count(EmpNo) as HasRow FROM tbl_shortlive WHERE EmpNo = $EmpNo AND tbl_shortlive.Date = '$FromDate' ");

                    //     $HaffDayaLeave = $this->Db_model->getfilteredData("SELECT count(EmpNo) as HasRow FROM tbl_leave_entry where EmpNo = $EmpNo and Leave_Date = '$FromDate' AND Leave_Count='0.5' ");

                    //     // if (!empty($ShortLeave[0]->Is_Approve)) {

                    //     // }
                    //     // if (empty($HaffDayaLeave[0]->Is_Approve)) {
                    //     //     $lateM = $iCalc - $GracePrd;
                    //     // }
                    //     // if ($ShortLeave[0]->HasRow == 0) {
                    //     //     // $lateM;
                    //     //     $lateM = $iCalc - $GracePrd;
                    //     // }

                    //     // if ($HaffDayaLeave[0]->HasRow == 0) {
                    //         $lateM = $iCalc - $GracePrd;
                    //     // }

                    //     if ($lateM <= 0) {
                    //         $lateM = 0;
                    //         $Late_Status = 0;

                    //     } else if ($lateM >= 0) {
                    //         $lateM;
                    //         $Late_Status = 1;

                    //         // Morning In Time ekata kalin short leave thiywam
                    //         $ShortLeave = $this->Db_model->getfilteredData("SELECT * FROM tbl_shortlive WHERE EmpNo = $EmpNo AND tbl_shortlive.Date = '$FromDate' ");
                    //         if (!empty($ShortLeave[0]->Is_Approve)) {
                    //             $SHFtime = $ShortLeave[0]->from_time;
                    //             $SHTtime = $ShortLeave[0]->to_time;

                    //             $InTimeSrt = strtotime($InTime);
                    //             $SHToTimeSrt = strtotime($SHTtime);

                    //             $iCalcShortLT = ($InTimeSrt - $SHToTimeSrt) / 60;

                    //             if ($iCalcShortLT <= 0) {
                    //                 // welawta ewilla
                    //                 $lateM = 0;
                    //                 $Late_Status = 0;
                    //                 $DayStatus = 'SL';

                    //             } else if ($iCalcShortLT >= 0) {
                    //                 // welatwa ewilla ne(short leave ektath passe late)

                    //                 // haffDay thiywam short Leave ekka
                    //                 $HaffDayaLeave = $this->Db_model->getfilteredData("SELECT * FROM tbl_leave_entry where EmpNo = $EmpNo and Leave_Date = '$FromDate' AND Leave_Count='0.5' ");
                    //                 if (!empty($HaffDayaLeave[0]->Is_Approve)) {
                    //                     $SHTtime = "14:00:00";

                    //                     $InTimeSrt = strtotime($InTime);
                    //                     $SHToTimeSrt = strtotime($SHTtime);

                    //                     // Morning Halfday with SL
                    //                     if($InTime >= "14:00:00"){

                    //                         $iCalcHaffT = ($InTimeSrt - $SHToTimeSrt) / 60;
                    //                         // echo "0";

                    //                         if ($iCalcHaffT <= 0) {
                    //                             // welawta ewilla
                    //                             $lateM = 0;
                    //                             $Late_Status = 0;
                    //                             $DayStatus = 'HFD/SL';

                    //                         } else if ($iCalcHaffT >= 0) {
                    //                             // welatwa ewilla ne(short leave & haffDay ektath passe late)
                    //                             $lateM = $iCalcHaffT;
                    //                             $DayStatus = 'HFD/SL';

                    //                             // echo "1";
                    //                         }
                    //                     }

                    //                     // Evening Halfday with SL
                    //                     if($InTime <= "14:00:00"){

                    //                         $SHStartTime = strtotime($SHFT);
                    //                         $InTimeSrt = strtotime($InTime);

                    //                         $iCalc = ($InTimeSrt - $SHStartTime) / 60;
                    //                         $lateM = $iCalc - $GracePrd;
                    //                         $lateM;
                    //                         $Late_Status = 1;

                    //                     }

                    //                 } else {
                    //                     // welatwa ewilla ne(short leave ektath passe late /haffDay ne )
                    //                     $lateM = $iCalcShortLT;
                    //                     $DayStatus = 'SL';

                    //                     // echo "2gg";
                    //                 }
                    //             }
                    //         }
                    //     }

                    // }
                    // ===================End Short Leave with HFD

                    // $$$$$$$$$$$$$$$$$$$$$$$//
                    // **************************************************************************************//
                    $OFFDAY['OFF'] = $this->Db_model->getfilteredData("select `ShType` from tbl_individual_roster where FDate = '$FromDate'  ");
                    $Day = $OFFDAY['OFF'][0]->ShType;

                    if ($OutTime == "00:00:00") {
                        $DayStatus = 'MS';
                        $Late_Status = 0;
                        $Nopay = 0;
                        $OutTime = "00:00:00";
                    }

                    if ($Day == "OFF") {
                        $DayStatus = 'OFF';
                        $Late_Status = 0;
                        $Nopay = 0;
                        $InRecords = $FromDate;
                        $OutDate = $FromDate;
                        $InTime = "00:00:00";
                        $OutTime = "00:00:00";
                    }

                    // $SH_EX_OT = 0;
                    // $NetLateM = 0;

                    // $ExH_OT = $BeforeShift + $AfterShiftWH;

                    // if ($NetLateM > $ExH_OT) {
                    //     $NetLateM = $NetLateM - $ExH_OT;
                    //     $ApprovedExH = 0;

                    // } else {
                    //     $ApprovedExHTemp = ($ExH_OT - $NetLateM);
                    //     $ApprovedExH = (floor(($ApprovedExHTemp) / $Round)) * $Round;

                    //     $NetLateM = 0;
                    // }

                    // if ($ApprovedExH >= 0) {

                    //     $dataArray = array(
                    //         'EmpNo' => $EmpNo,
                    //         'OTDate' => $FromDate,
                    //         'RateCode' => $Rate,
                    //         'OT_Cat' => $DayCode,
                    //         'OT_Min' => $ApprovedExH
                    //     );

                    //     //                            var_dump($dataArray);
                    //     $result = $this->Db_model->insertData("tbl_ot_d", $dataArray);
                    // }

                    // var_dump($InDate . ' ' . $InTime );
                    // echo "<br>";
                    // var_dump($OutDate . ' ' . $OutTime . ' ' . $EmpNo);
                    // echo "<br>";
                    // echo "<br>";

                    $Holiday = $this->Db_model->getfilteredData("select count(Hdate) as HasRow from tbl_holidays where Hdate = '$FromDate' ");
                    if ($Holiday[0]->HasRow == 1) {
                        $DayStatus = 'HD';
                        $Nopay = 0;
                        $Nopay_Hrs = 0;
                        $Att_Allowance = 0;
                    }
                    $Leave = $this->Db_model->getfilteredData("SELECT * FROM tbl_leave_entry where EmpNo = $EmpNo and Leave_Date = '$FromDate' AND Leave_Count='1' ");
                    if (!empty($Leave[0]->Is_Approve)) {
                        $Nopay = 0;
                        $DayStatus = 'LV';
                        $Nopay_Hrs = 0;
                        $Att_Allowance = 0;
                        $ED = 0;
                    }
                    //apoint date ekata kalin off dawasakath ab saha nopay wadinna one
                    if($FromDate <= $apoint_date ){
                        $Nopay = 1;
                        $DayStatus = 'AB';
                        $Nopay_Hrs = 0;
                        $Att_Allowance = 0;
                    }
                    if ($settings[0]->Ot_e == 0) {
                        $AfterShiftWH = 0;
                    }
                    if ($settings[0]->Late == 0) {
                        $lateM = 0;
                    }
                    if ($settings[0]->Ed == 0) {
                        $ED = 0;
                    }
                    if($lateM >= 0){
                        $lateM;
                    }else{
                        $lateM = 0;
                    }

                    if($ED >= 0){
                        $ED;
                    }else{
                        $ED = 0;
                    }
                    
                    
                    $HaffDayaLeave = $this->Db_model->getfilteredData("SELECT * FROM tbl_leave_entry where EmpNo = $EmpNo and Leave_Date = '$FromDate' AND Leave_Count='0.5' AND Is_Approve = 1");
                    if (!empty($HaffDayaLeave[0]->Is_Approve)) {
                        if ($InTime == null || $InTime == "" || $InTime == "00:00:00") {
                            $SHTtime = "14:00:00";
                            $SHFttime = "19:00:00";
                            $NewIntime = strtotime($SHTtime);
                            $NewTotime = strtotime($SHFttime);

                            $NewiCalcHaffT = ($NewTotime - $NewIntime) / 60;

                            if ($NewiCalcHaffT >= 0) {
                                $lateM = $NewiCalcHaffT;
                                $DayStatus = 'HFD/AB';
                            }
                        }
                    }else{
                        if ($InTime == "00:00:00" && $OutTime == "00:00:00" && $Day == 'DU') {
                            $DayStatus = 'AB';
                            $Nopay = 1;
                            $Nopay_Hrs = (((strtotime($SHTT) - strtotime($SHFT))) / 60);
                        }
                    }
                    
                    // echo $InTime . '|-|' . $OutTime . ' || ' . $EmpNo;
                    // echo "<br>";
                    // echo $FromDate;
                    // echo "<br>";
                    // echo 'ED' . $ED;
                    // echo "<br>";
                    // echo 'Late' . $lateM;
                    // echo "<br>";
                    // echo "<br>";
                    // echo $ED;
                    // die;
                    $data_arr = array("InRec" => 1, "InDate" => $FromDate, "InTime" => $InTime, "OutRec" => 1, "OutDate" => $OutDate, "OutTime" => $OutTime, "nopay" => $Nopay, "Is_processed" => 1, "DayStatus" => $DayStatus, "BeforeExH" => $BeforeShift, "AfterExH" => $AfterShiftWH, "LateSt" => $Late_Status, "LateM" => $lateM, "EarlyDepMin" => $ED, "NetLateM" => $NetLateM, "ApprovedExH" => $ApprovedExH, "nopay_hrs" => $Nopay_Hrs, "Att_Allow" => $Att_Allowance);
                    $whereArray = array("ID_roster" => $ID_Roster);
                    $result = $this->Db_model->updateData("tbl_individual_roster", $data_arr, $whereArray);

                }
            }
            // }
            // Log_Insert - Start

            // Get the last inserted ID
            // $insert_id = $this->Db_model->getfilteredData("SELECT `Lv_T_ID` FROM tbl_leave_types WHERE `leave_name`='".$LeaveName."'");//change action
            // $Lv_T_ID = $insert_id[0]->Lv_T_ID;//change action

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

            $ip = get_client_ips();

            // $ip = "111";
            $currentUser = $this->session->userdata('login_user');
            $Emp = $currentUser[0]->EmpNo;

            date_default_timezone_set('Asia/Colombo');
            $current_time = date('Y-m-d H:i:s');
            
            $system_page_name = "Attendance - Attendance Process";//change action
            $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");

            $dataArray = array(
                'log_user_id' => $Emp,
                'ip_address' => $ip,
                'system_action' => 'Attendance Process successfully',//change action
                'trans_time' => $current_time,
                'system_page' => $spnID[0]->id 
            );

            $this->Db_model->insertData("tbl_audit_log_all", $dataArray);
            // Log_Insert - End
            $this->session->set_flashdata('success_message', 'Attendance Process successfully');
            redirect('/Attendance/Attendance_Process_New');

        } else {
            // Log_Insert - Start

            // Get the last inserted ID
            // $insert_id = $this->Db_model->getfilteredData("SELECT `Lv_T_ID` FROM tbl_leave_types WHERE `leave_name`='".$LeaveName."'");//change action
            // $Lv_T_ID = $insert_id[0]->Lv_T_ID;//change action

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

            $ip = get_client_ips();

            // $ip = "111";
            $currentUser = $this->session->userdata('login_user');
            $Emp = $currentUser[0]->EmpNo;

            date_default_timezone_set('Asia/Colombo');
            $current_time = date('Y-m-d H:i:s');
            
            $system_page_name = "Attendance - Attendance Process";//change action
            $spnID = $this->Db_model->getfilteredData("select `id` from tbl_audit_pages where `system_page_name` = '".$system_page_name."'");

            $dataArray = array(
                'log_user_id' => $Emp,
                'ip_address' => $ip,
                'system_action' => '(Already Attendance Processed) Attendance Process is not Processed',//change action
                'trans_time' => $current_time,
                'system_page' => $spnID[0]->id 
            );

            $this->Db_model->insertData("tbl_audit_log_all", $dataArray);
            // Log_Insert - End
            // $this->session->set_flashdata('success_message', 'Attendance Process successfully');
            $this->session->set_flashdata('error_message', 'Already Attendance Processed');
            redirect('/Attendance/Attendance_Process_New');

        }
        $this->session->set_flashdata('success_message', 'Attendance Process successfully');
        redirect('/Attendance/Attendance_Process_New');
    }

}
