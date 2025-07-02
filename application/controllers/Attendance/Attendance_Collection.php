<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_Collection extends CI_Controller {

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

//    SELECT
//  t1.EventID,
//  t1.AttDate AS INDate,
//  CASE
//    WHEN t1.AttDate = t2.AttDate THEN t2.AttDate
//    ELSE DATE_ADD(t1.AttDate, INTERVAL 1 DAY)
//  END AS OUTDate,
//  t1.AttTime AS InTime,
//  CASE
//    WHEN t1.AttDate = t2.AttDate THEN t2.AttTime
//    ELSE (
//      SELECT MAX(AttTime)
//      FROM tbl_u_attendancedata
//      WHERE AttDate = DATE_ADD(t1.AttDate, INTERVAL 1 DAY)
//        AND Enroll_No = t1.Enroll_No
//        AND Status = '1'
//      GROUP BY Enroll_No
//    )
//  END AS OUTATT,
//  t1.Enroll_No,
//  t1.Status,
//  t1.verify_type,
//  TIMEDIFF(
//    CONCAT(
//      CASE
//        WHEN t1.AttDate = t2.AttDate THEN t2.AttDate
//        ELSE DATE_ADD(t1.AttDate, INTERVAL 1 DAY)
//      END,
//      ' ',
//      CASE
//        WHEN t1.AttDate = t2.AttDate THEN t2.AttTime
//        ELSE (
//          SELECT MAX(AttTime)
//          FROM tbl_u_attendancedata
//          WHERE AttDate = DATE_ADD(t1.AttDate, INTERVAL 1 DAY)
//            AND Enroll_No = t1.Enroll_No
//            AND Status = '1'
//          GROUP BY Enroll_No
//        )
//      END
//    ),
//    CONCAT(t1.AttDate, ' ', t1.AttTime)
//  ) AS TimeDifference
//FROM
//  tbl_u_attendancedata t1
//LEFT JOIN
//  tbl_u_attendancedata t2 ON t1.Enroll_No = t2.Enroll_No AND t1.AttDate = t2.AttDate AND t2.Status = '1'
//WHERE
//  t1.Status = '0'
//  AND (
//    t2.Enroll_No IS NULL -- No shift two on the same day
//    OR (
//      t1.AttTime < t2.AttTime -- Shift one: InTime is before OutTime of shift two
//      OR t1.AttDate <> t2.AttDate -- Shift one: InTime and OutTime are on different days
//    )
//  )
//GROUP BY
//  t1.Enroll_No, t1.AttDate
//ORDER BY
//  t1.EventID;





    public function get_from_table() {

        $tb_data = $this->Db_model->getfilteredData("select * from events WHERE EventDateTime BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE() order by EventDateTime ");


//        $EnrollID = $tb_data[0]->EnrollNO;
//        $DeviceID = $tb_data[0]->DeviceID;
//        $EventDateTime = $tb_data[0]->EventDateTime;
//        $EventMode = $tb_data[0]->EventMode;
//        $EventOrigin = $tb_data[0]->EventOrigin;
//        $EventStatus = $tb_data[0]->EventStatus;


        foreach ($tb_data as $item) {

            $EnrollID = $item->EnrollNO;
            $EventDateTime = $item->EventDateTime;
            $EventMode = $item->EventMode;
            $EventOrigin = $item->EventOrigin;
            $EventStatus = $item->EventStatus;

            $datetime = new DateTime($EventDateTime);
//            $time = $datetime->format("H:i:s");
            $time = $datetime->format("H:i:s");

            $data = array(
                'Enroll_No' => $EnrollID,
                'AttDate' => $EventDateTime,
                'AttTime' => $time,
                'AttDateTimeStr' => $EventDateTime,
                'Status' => $EventStatus,
                'verify_type' => $EventMode
            );
            $this->Db_model->insertData('tbl_u_attendancedata', $data);
        }

        $this->session->set_flashdata('success_message', 'Attendance data has been added successfully');
        redirect(base_url() . 'Attendance/Attendance_Collection');



//        echo $EnrollID;
//        die;
//        echo '<pre>';
//        var_dump($tb_data);
//        die;
//        echo '</pre>';
    }

    public function pro_attendance() {


        $dtRs1 = $this->Db_model->getfilteredData("select Enroll_No from tbl_u_attendancedata group by Enroll_No ");

        var_dump($dtRs1);

        for ($x = 0; $x <= count($dtRs1); $x++) {

            $Enroll = $dtRs1[$x]->Enroll_No;
            var_dump($Enroll);

//            echo '<h1>xxxxxxxxxx</h1>'. $x . '<br><h1>xxxxxxxxxx</h1>';

            $dtRs = $this->Db_model->getfilteredData("select EventID,AttDate,(AttTime) as InTime ,(AttTime) as OUTTime ,Enroll_No,Status,verify_type from tbl_u_attendancedata   where Enroll_No='$Enroll' group by Enroll_No order by EventID ");

            $EventID = $dtRs[0]->EventID;
            echo $EventID . '<br>';

            $AttDate = $dtRs[0]->AttDate;
            echo $AttDate . '<br>';

            $InTime = $dtRs[0]->InTime;
            echo $InTime . '<br>';

            $OUTTime = $dtRs[0]->OUTTime;
            echo $OUTTime . '<br>';

            $Enroll_No = $dtRs[0]->Enroll_No;
            echo $Enroll_No . '<br>';

            $Status = $dtRs[0]->Status;
            echo $Status . '<br>';


            if ($InTime == $OUTTime && $Status == 0) {
//                echo $OUTTime.'ss'.$Enroll_No;
                $InTime = $InTime;
                $next_date = date('Y-m-d', strtotime($AttDate . ' +1 day'));

                echo $next_date . 'Go next day';

                $dtRs1 = $this->Db_model->getfilteredData("select EventID,AttDate,(AttTime) as InTime ,MAX(AttTime) as OUTTime ,Enroll_No,Status,verify_type from tbl_u_attendancedata where AttDate = '$next_date' and Enroll_No='$Enroll_No' and Status ='1' ");

                $OUTTime = $dtRs1[0]->InTime;

//                echo $AttDate.' '.$InTime;die;


                $startTimeObj = new DateTime($AttDate . ' ' . $InTime);
                $endTimeObj = new DateTime($next_date . ' ' . $OUTTime);

                $timeDiff = $startTimeObj->diff($endTimeObj);

                $hours = $timeDiff->h; // Hours
                $minutes = $timeDiff->i; // Minutes


                echo "Time difference for the next day: {$hours} hours, {$minutes} minutes" . '<br>';

                var_dump($dtRs1);

//                $OUTTime = '';
//                var_dump($next_date);
            }


//            if ($InTime == $OUTTime && $Status == 0) {
//                // Calculate time difference for the next day
//                $nextDate = date('Y-m-d', strtotime($AttDate . ' +1 day'));
//                echo $nextDate . ' Go to the next day';
//
//                $dtRs1 = $this->Db_model->getfilteredData("SELECT EventID, AttDate, AttTime AS InTime, MAX(AttTime) AS OUTTime, Enroll_No, Status, verify_type FROM tbl_u_attendancedata WHERE AttDate = '$nextDate' AND Enroll_No = '$Enroll_No' AND Status = '1'");
//
//                if (!empty($dtRs1)) {
//                    $OUTTime = $dtRs1[0]->InTime;
//
//                    $startTimeObj = new DateTime($AttDate . ' ' . $InTime);
//                    $endTimeObj = new DateTime($nextDate . ' ' . $OUTTime);
//
//                    $timeDiff = $startTimeObj->diff($endTimeObj);
//                    
////                    echo $timeDiff;die;
//
//                    $hours = $timeDiff->h; // Hours
//                    $minutes = $timeDiff->i; // Minutes
//
//                    echo "Time difference for the next day: {$hours} hours, {$minutes} minutes"; die;
//                } else {
//                    echo "No attendance data found for the next day.";
//                }
//            }


            echo '<br><br><br><br>' . $Enroll_No . 'Enroll' . $InTime . 'IN' . $OUTTime . 'OUT' . $hours . $minutes . 'WH';



//            die;
//            if()

            var_dump($dtRs);
        }
    }

    public function get_attendance() {



// Create the POST data as an associative array
        date_default_timezone_set('Asia/Colombo');
//          $date = date('Y-m-d');
//          
//          echo $date; 
//          die;
// Create a cURL handle
        $ch = curl_init();

// Set the URL to send the POST request to
        $url = "http://35.222.58.166/vft.public.api/getToken";

// Set the request body
        $data = array(
            'username' => 'vftholdings',
            'password' => 'Admin',
            'tenant' => 'vftcloud.com'
        );
        $body = json_encode($data);

// Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url); // Set the URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string instead of outputting it
        curl_setopt($ch, CURLOPT_POST, true); // Set the request method to POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body); // Set the request body
// Set headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($body)
        ));

// Execute the POST request
        $response = curl_exec($ch);

// Check for errors
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            // Handle the error appropriately
        } else {
            // The request was successful
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get the HTTP status code
            // Process the response
            if ($httpCode === 200) {
                // Request was successful, handle the response data
                $responseData = json_decode($response, true);
                // Access specific data from the response
//        $token = $responseData['Token'];

                echo '<pre>';
//                $hh = ($responseData['data']);

                $token = $responseData['data']['data']['Token'];
//                echo "Token: " . $token . "\n";
//                var_dump($hh);
//                echo '<pre>';
                // ...
            } else {
                // Request was not successful, handle the error
                // ...
            }

            // Close the cURL handle
            curl_close($ch);
        }













        $url = 'http://vftcloud.com/vft.public.api/GetAttRecords';



        $currentDate = date('Y-m-d');  // Current date
        $backDate = date('Y-m-d', strtotime('-45 days', strtotime($currentDate)));

        $data = array(
            "FromDate" => $backDate,
            "ToDate" => $currentDate
        );
// Convert data array to JSON
        $jsonData = json_encode($data);

// Initialize a cURL session
        $ch = curl_init();

// Set the cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);




// Set the authorization header
        $authorizationHeader = 'Authorization:' . $token . '';
//        echo $authorizationHeader;die;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            $authorizationHeader,
            'Content-Type: application/json'
        ));

// Execute the request
        $response = curl_exec($ch);

// Check for errors
        if ($response === false) {
            echo 'Error: ' . curl_error($ch);
        }

// Close the cURL session
        curl_close($ch);

// Display the response
//        echo $response;


        $data = json_decode($response);

//        var_dump($data);
//        die;
//        var_dump($response);die;
// Accessing the variables
        $isSuccess = $data->isSuccess;
        $Id = $data->Id;
        $dataArray = $data->data;

        foreach ($dataArray as $item) {

// Accessing the values in the "data" array
            $id = $item->id;
            $SN = $item->SN;
            $EnrollNo = $item->EnrollNo;
            $DateTime = $item->DateTime;
            $EventMode = $item->EventMode;
            $RecivedAt = $item->RecivedAt;

//            echo 'ID' . $id . "Enrll____" . $EnrollNo . "Date____" . $DateTime;


            $datetime = new DateTime($DateTime);
//            $time = $datetime->format("H:i:s");
            $time = $datetime->format("H:i:s");

            $data = array(
                'Enroll_No' => $EnrollNo,
                'AttDate' => $DateTime,
                'AttTime' => $time,
                'AttDateTimeStr' => $DateTime,
                'Status' => 0,
                'verify_type' => $EventMode
            );
            $this->Db_model->insertData('tbl_u_attendancedata', $data);
        }
//        die;
        $this->session->set_flashdata('success_message', 'Attendance data has been added successfully');
        redirect(base_url() . 'Attendance/Attendance_Collection');
    }

//    public function get_attendance() {
//        require_once APPPATH . 'third_party/zkteco/zklib/zklib.php';
//        
//          $device_Data = $this->Db_model->getfilteredData("select * from tbl_devices where Is_Active =1");
//          
//          $D_IP = $device_Data[0]->Device_IP;
////          var_dump($D_IP);
////          
////          var_dump($device_Data);die;
//        
//        $zk = new ZKLib("$D_IP", 4370);
//
//        $ret = $zk->connect();
//
//        $attendance = $zk->getAttendance();
////     sleep(1);
////        var_dump($attendance); die;
//
//        foreach ($attendance as $item) {
//            list($UID, $UID2, $verify_type, $AttDate, $Status) = $item;
//
//            // Use the variables here
////            echo $var1 . ", " . $var2 . ", " . $var3 . ", " . $var4 . " , ". $var5 ."<br>"; die;
////            $datetimeString = "2021-04-21 11:19:09";
//            $datetime = new DateTime($AttDate);
//            $time = $datetime->format("H:i:s");
//
////echo $time;
////            die;
//
//            $data = array(
//                'Enroll_No' => $UID,
//                'AttDate' => $AttDate,
//                'AttTime' => $time,
//                'AttDateTimeStr' => $AttDate,
//                'Status' => $Status,
//                'verify_type' => $verify_type
//            );
//
////            var_dump($data);
//
//
////            if($UID2)
////
////             $data1 = array(
////                'Enroll_No' => $UID2,
////                'AttDate' => $AttDate,
////                'AttTime' => $time,
////                'AttDateTimeStr' => $AttDate,
////                'Status' => $Status,
////                'verify_type' =>$verify_type
////            );
////            
////            
////            
////            
////            
////                 $this->Db_model->insertData('tbl_u_process_complicated', $data1);
////            var_dump($data);die;
//
//            $this->Db_model->insertData('tbl_u_attendancedata', $data);
//        }
//    echo date( "d-m-Y", strtotime( $attendance[3] ) );
//     echo $attendance;
//        $this->session->set_flashdata('success_message', 'Attendance data has been added successfully');
//        redirect(base_url() . 'Attendance/Attendance_Collection');
//    }

    public function index() {

        $data['title'] = "Attendance Collection | HRM System";
        $data['data_set'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');

//                 $this->load->library("zkteco_library");


        $this->load->view('Attendance/Attendance_Collection/index', $data);
    }

    /*
     * Insert Data
     */

    public function insert_data() {





//*** Make directory if not available
        $filepath = "./attendance/" . date('Y') . "/" . date('m');
        if (!is_dir($filepath)) {
            mkdir($filepath, 0777, TRUE);
        }


        $new_filename = date('d') . ".txt";
        move_uploaded_file($_FILES['text_file_upload'] ['tmp_name'], "$filepath/" . $new_filename);


        $row = array();
        $filename1 = $new_filename;
        $filename = $filepath . "/" . $filename1;

        
//        var_dump($filename);die;

//**** Read Text file data
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        foreach ($lines as $key => $value) {

//            $row[$key] = preg_split('/[\s]+/', $value);
            
             $row = explode("\t", $value);
            
//            var_dump($row[0] . '____' . $row[1]);
            $datesss = $row[1];
            
            
            $dateTime = DateTime::createFromFormat('d/m/Y H:i:s', $datesss);
//            $dateTime = new DateTime($datesss);
            
            var_dump($dateTime);
            
            $date = $dateTime->format('Y-m-d');
            $time = $dateTime->format('H:i:s');
            echo 'Original' .$time;
            
            
//            die;

//            $row[$key] = explode("/\s+/", $value);
//            var_dump($row);

            $data = array(
                'Enroll_No' => $row[0],
                'AttDate' => $date,
                'AttTime' => $time,
                'AttDateTimeStr' => $date,
                'Status' => 1
            );



//            var_dump($data);die;

            $this->Db_model->insertData('tbl_u_attendancedata', $data);
        }
        $this->session->set_flashdata('success_message', 'Attendance data has been added successfully');
        redirect(base_url() . 'Attendance/Attendance_Collection');
    }

    /*
     * Get data
     */

    public function get_details() {
        $ShiftCode = $this->input->post('ShiftCode');

        $whereArray = array('ShiftCode' => $ShiftCode);

        $this->Db_model->setWhere($whereArray);
        $dataObject = $this->Db_model->getData('ShiftCode,ShiftName,FromTime,ToTime,ShiftGap', 'tbl_shifts');

        $array = (array) $dataObject;
        echo json_encode($array);
    }

    /*
     * Edit Data
     */

    public function edit() {
        $ShiftCode = $this->input->post("ShiftCode", TRUE);
        $ShiftName = $this->input->post("ShiftName", TRUE);
        $FromTime = $this->input->post("FromTime", TRUE);
        $ToTime = $this->input->post("ToTime", TRUE);
        $ShiftGap = $this->input->post("ShiftGap", TRUE);



        $data = array("ShiftName" => $ShiftName, "FromTime" => $FromTime, "ToTime" => $ToTime, "ShiftGap" => $ShiftGap,);
        $whereArr = array("ShiftCode" => $ShiftCode);
        $result = $this->Db_model->updateData("tbl_shifts", $data, $whereArr);
        redirect(base_url() . "Master/Shifts");
    }

    /*
     * Delete Data
     */

    public function ajax_delete($id) {
        $table = "tbl_shifts";
        $where = 'ShiftCode';
        $this->Db_model->delete_by_id($id, $where, $table);
        echo json_encode(array("status" => TRUE));
    }

}
