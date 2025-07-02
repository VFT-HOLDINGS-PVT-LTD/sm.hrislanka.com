<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_Process_test extends CI_Controller {

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
        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("SELECT EmpNo,Enroll_No, EPFNO,RosterCode, Status  FROM  tbl_empmaster where status=1");

        /*
         * For Loop untill all employee and where employee status = 1
         */
        for ($x = 0; $x < count($dtEmp['EmpData']); $x++) {

            $EmpNo = $dtEmp['EmpData'][$x]->EmpNo;
            $EnrollNO = $dtEmp['EmpData'][$x]->Enroll_No;
            $EpfNO = $dtEmp['EmpData'][$x]->EPFNO;
            $roster = $dtEmp['EmpData'][$x]->RosterCode;

//            echo $EmpNo . "<br>";

            /*
             * Get Process From Date and To date(To day is currunt date)
             */
            $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT  Max(FDate) AS FDate, CURDATE() as ToDate  FROM tbl_individual_roster where Is_processed=0 GROUP BY EmpNo HAVING  EmpNo='$EmpNo'");


//            var




            if (!empty($dtRs['dt'])) {



//var_dump($dtRs);
                //Last Shift Allocated Date
                $FDate = date("Y-m-d", strtotime("+1 day", strtotime($dtRs['dt'][0]->FDate)));
                //Current Date
                $TDate = $dtRs['dt'][0]->ToDate;



                //Check If From date less than to Date
                If ($FDate <= $TDate) {

//                    var_dump('ss');
//                    die;


                    $d1 = new DateTime($FDate);
                    $d2 = new DateTime($TDate);

                    $interval = $d1->diff($d2)->days;




                    for ($y = 0; $y <= $interval; $y++) {






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

                        $Holiday = $this->Db_model->getfilteredData("select count(Hdate) as HasRow from tbl_holidays where Hdate = '$FDate' ");

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
                        //****Week Days  MON | TUE
                        $DayName = $ros[0]->DayName;
                        $FromTime = $ros[0]->FromTime;
                        $ToTime = $ros[0]->ToTime;
                        //****Shift Type DU | EX
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


                        $this->Db_model->insertData("tbl_individual_roster", $dataArray);



                        echo $FDate . "<br>";
                        $FDate = date("Y-m-d", strtotime("+1 day", strtotime($FDate)));
                    }




                    //**** Attendance Process start after shift allocation
                    $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT  Min(FDate) AS FromDate, Max(TDate) as ToDate  FROM tbl_individual_roster where Is_processed=0 GROUP BY EmpNo HAVING  EmpNo='$EmpNo'");

                    $FromDate = $dtRs['dt'][0]->FromDate;
                    $ToDate = $dtRs['dt'][0]->ToDate;

                    $d1 = new DateTime($FromDate);
                    $d2 = new DateTime($ToDate);

                    //Date intervel for, loop
                    $interval2 = $d1->diff($d2)->days;





                    for ($z = 0; $z <= $interval2; $z++) {


                        $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT  Min(FDate) AS FromDate, Max(TDate) as ToDate  FROM tbl_individual_roster where Is_processed=0 GROUP BY EmpNo HAVING  EmpNo='$EmpNo'");

                        $FromDate = $dtRs['dt'][0]->FromDate;
                        $ToDate = $dtRs['dt'][0]->ToDate;


                        /*
                         * ******Get Employee IN Details
                         */
                        $dt_in_Records['dt_Records'] = $this->Db_model->getfilteredData("select min(AttTime) as INTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EnrollNO' and AttDate='$FromDate' ");


                        $InRecords = $dt_in_Records['dt_Records'][0]->AttDate;




                        //**** In Date
                        $InDate = $dt_in_Records['dt_Records'][0]->AttDate;
                        //**** In Time
                        $InTime = $dt_in_Records['dt_Records'][0]->INTime;
                        $InRecID = $dt_in_Records['dt_Records'][0]->EventID;
                        $InRec = 1;

                        var_dump($InTime . 'In');
                        die;

                        if ($InRecords == null) {

//                            var_dump($FromDate,$EnrollNO);

                            $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='$FromDate' and Enroll_No='$EnrollNO' ");


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
//var_dump($Manual);die;

                        /*
                         * ******Get Employee OUT Details
                         */
                        $dt_out_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select max(AttTime) as OutTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EnrollNO' and AttDate='$FromDate' ");

                        //**** Out Date
                        $OutDate = $dt_out_Records['dt_out_Records'][0]->AttDate;
                        //**** Out Time
                        $OutTime = $dt_out_Records['dt_out_Records'][0]->OutTime;
                        $OutRecID = $dt_out_Records['dt_out_Records'][0]->EventID;
                        $OutRec = 1;


                        $OutRecords = $dt_out_Records['dt_out_Records'][0]->AttDate;

                        if ($OutRecords == null) {



                            $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='$FromDate' and Enroll_No='$EnrollNO' ");

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



                        /*
                         * ***** Get Shift Code
                         */
                        $SH['SH'] = $this->Db_model->getfilteredData("select ID_roster,EmpNo,ShiftCode,ShType,Day_Type,FDate,FTime,TDate,TTime,ShType from tbl_individual_roster where Is_processed=0 and EmpNo='$EmpNo'");
                        $SH_Code = $SH['SH'][0]->ShiftCode;
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






                        if ($InTime == $OutTime) {
                            $DayStatus = 'MS';
                        }





                        /*
                         * If In Available
                         */
                        if ($InTime != '') {

                            $InTimeSrt = strtotime($InTime);
                            $SHStartTime = strtotime($SHFT);

                            $iCalc = round(( $SHStartTime - $InTimeSrt) / 60);

                            var_dump($iCalc);
                            die;

                            if ($iCalc >= 0) {

                                $BeforeShift = $iCalc;
                            } else {

                                if ($ShiftType = 'DU') {
                                    $Late = true;
                                    $lateM = 0 - $iCalc;
                                }
                            }
                            if (empty($lateM)) {

                                $lateM = 0;
                                $Late_Status = 0;
                            } else {
                                $lateM;
                                $Late_Status = 1;
                            }
                            if (empty($BeforeShift)) {
                                $BeforeShift = 0;
                            }

                            //test
                            $DayStatus = 'PR';
                            $AfterShift = 1;




                            $data_arr = array("InRec" => 1, "InDate" => $FromDate, "InTime" => $InTime, "OutRec" => 1, "OutDate" => $FromDate, "OutTime" => $OutTime, "nopay" => 0, "Is_processed" => 1, "DayStatus" => $DayStatus, "LateSt" => $Late_Status, "LateM" => $lateM, "BeforeExH" => $BeforeShift, "AfterExH" => $AfterShift);
                            $whereArray = array("ID_roster" => $ID_Roster);


//                            var_dump($data_arr);die;


                            $result = $this->Db_model->updateData("tbl_individual_roster", $data_arr, $whereArray);
                        } else {

                            if ($ShiftType = 'DU') {

                                $NoPay = $DayType;
                            }
                        }


                        /*
                         * If Out Available 
                         */
                        if ($OutTime != '') {



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

                            $DayStatus = 'PR';


                            if ($InTime == $OutTime) {
                                $DayStatus = 'MS';
                            }


                            $data_arr = array("InRec" => 1, "InDate" => $FromDate, "InTime" => $InTime, "OutRec" => 1, "OutDate" => $FromDate, "OutTime" => $OutTime, "nopay" => 0, "Is_processed" => 1, "DayStatus" => $DayStatus, "BeforeExH" => $BeforeShift, "AfterExH" => $AfterShift);
                            $whereArray = array("ID_roster" => $ID_Roster);
                            $result = $this->Db_model->updateData("tbl_individual_roster", $data_arr, $whereArray);
                        }
                    }
                }



//                                var_dump('s');
//                die;
            } else {


                highlight_string("<?php\n\$data =\n" . var_export($dtRs, true) . ";\n?>");
                die;



//                var_dump('s');
//                die;

                $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT  Min(FDate) AS FromDate, Max(TDate) as ToDate  FROM tbl_individual_roster where Is_processed=0 GROUP BY EmpNo HAVING  EmpNo='$EmpNo'");



                if (!empty($dtRs['dt'])) {

                    $FromDate = $dtRs['dt'][0]->FromDate;
                    $ToDate = $dtRs['dt'][0]->ToDate;



                    /*
                     * ******Get Employee IN Details
                     */
                    $dt_in_Records['dt_Records'] = $this->Db_model->getfilteredData("select min(AttTime) as INTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EnrollNO' and AttDate='$FromDate' ");


                    $InRecords = $dt_in_Records['dt_Records'][0]->AttDate;


                    //**** In Date
                    $InDate = $dt_in_Records['dt_Records'][0]->AttDate;
                    //**** In Time
                    $InTime = $dt_in_Records['dt_Records'][0]->INTime;
                    $InRecID = $dt_in_Records['dt_Records'][0]->EventID;
                    $InRec = 1;



                    var_dump($InTime . 'else part');
                    die;


                    if ($InRecords == null) {



                        $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='$FromDate' and Enroll_No='$EnrollNO' ");

//                        var_dump($Manual); die;


                        if (!empty($Manual)) {
//                            print_r($FromDate);
//                            var_dump($Manual);
//                        die;


                            $InDate = $Manual[0]->Att_Date;
                            //**** In Time
                            $InTime = $Manual[0]->In_Time;

                            $InRec = 1;
                        }
                    }

//                    var_dump($InDates . 'ddd');
//                    die;



                    /*
                     * ******Get Employee OUT Details
                     */
                    $dt_out_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select max(AttTime) as OutTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EnrollNO' and AttDate='$FromDate' ");

                    //**** Out Date
                    $OutDate = $dt_out_Records['dt_out_Records'][0]->AttDate;
                    //**** Out Time
                    $OutTime = $dt_out_Records['dt_out_Records'][0]->OutTime;
                    $OutRecID = $dt_out_Records['dt_out_Records'][0]->EventID;
                    $OutRec = 1;


                    $OutRecords = $dt_out_Records['dt_out_Records'][0]->AttDate;


                    if ($OutRecords == null) {



                        $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='$FromDate' and Enroll_No='$EnrollNO' ");

//                        var_dump($Manual);
                        if (!empty($Manual)) {
//                            print_r($FromDate);
//                            var_dump($Manual);
//                        die;


                            $OutDate = $Manual[0]->Att_Date;
                            //**** In Time
                            $OutTime = $Manual[0]->Out_Time;

                            $OutRec = 1;
                        }
                    }



                    /*
                     * ***** Get Shift Code
                     */
                    $SH['SH'] = $this->Db_model->getfilteredData("select ID_roster,EmpNo,ShiftCode,ShType,Day_Type,FDate,FTime,TDate,TTime,ShType from tbl_individual_roster where Is_processed=0 and EmpNo='$EmpNo'");
                    $SH_Code = $SH['SH'][0]->ShiftCode;
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





                    /*
                     * If In Available
                     */

                    var_dump($InTime);
                    die;


                    if ($InTime != '') {

                        $InTimeSrt = strtotime($InTime);
                        $SHStartTime = strtotime($SHFT);

                        $iCalc = round(( $SHStartTime - $InTimeSrt) / 60);

//                    var_dump($iCalc);die;

                        if ($iCalc >= 0) {

                            $BeforeShift = $iCalc;
                        } else {

                            if ($ShiftType = 'DU') {
                                $Late = true;
                                $lateM = 0 - $iCalc;
                            }
                        }
                        if (empty($lateM)) {
                            $lateM = 0;
                            $Late_Status = 0;
                        } else {
                            $lateM;
                            $Late_Status = 1;
                        }
                        if (empty($BeforeShift)) {
                            $BeforeShift = 0;
                        }

                        //test
                        $Status = 1;
                        $AfterShift = 1;

                        $data_arr = array("InRec" => 1, "InDate" => $FromDate, "InTime" => $InTime, "OutRec" => 1, "OutDate" => $FromDate, "OutTime" => $OutTime, "nopay" => 0, "Is_processed" => 1, "DayStatus" => $Status, "LateSt" => $Late_Status, "LateM" => $lateM, "BeforeExH" => $BeforeShift, "AfterExH" => $AfterShift);
                        $whereArray = array("ID_roster" => $ID_Roster);

//                        var_dump($data_arr);die;


                        $result = $this->Db_model->updateData("tbl_individual_roster", $data_arr, $whereArray);
                    } else {

                        if ($ShiftType = 'DU') {

                            $NoPay = $DayType;
                        }
                    }


                    /*
                     * If Out Available 
                     */
                    if ($OutTime != '') {

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

                        $data_arr = array("InRec" => 1, "InDate" => $FromDate, "InTime" => $InTime, "OutRec" => 1, "OutDate" => $FromDate, "OutTime" => $OutTime, "nopay" => 0, "Is_processed" => 1, "DayStatus" => $Status, "BeforeExH" => $BeforeShift, "AfterExH" => $AfterShift);
                        $whereArray = array("ID_roster" => $ID_Roster);
                        $result = $this->Db_model->updateData("tbl_individual_roster", $data_arr, $whereArray);
                    }
                }
            }
//            var_dump($dtEmp);
        }
//        die;
        $this->session->set_flashdata('success_message', 'Attendance Process successfully');
        redirect('/Attendance/Attendance_Process_test');
    }

}
