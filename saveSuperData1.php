<?php

echo "Run//";

$servername = "localhost";
$username = "petcolanka_user";
$password = "CA5Js?G_9UJM";
$database = "petcolanka_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json_data = file_get_contents("php://input");
    $decoded_data = json_decode($json_data, true);

    if ($decoded_data !== null) {
        // Extract data from JSON
            
            foreach ($decoded_data as $date) {
                
                $EmpId = $date['EmpId'];
                $AttFullData = $date['AttTime'];
                $CheckingStatus = $date['CheckingStatus'];
                $VerifyType = $date['VerifyType'];
                $attPlace = "null";
                $eventName = "null";
                
                list($AttDate, $AttTime) = explode(" ", $AttFullData);
    
                     $searchData = "SELECT * FROM `tbl_u_attendancedata` WHERE `AttDateTimeStr`='".$AttFullData."' AND `Enroll_No`='".$EmpId."'";
                     $result = mysqli_query($conn, $searchData);
                     
                     $test = $result->num_rows;
        
                     
                    //  echo json_encode($searchData);
        
                    if ($test > 0) {
                        // echo  "Thiywa";
                    }else{
                        // echo "Nee";
                    
                        
                        $sql = "INSERT INTO tbl_u_attendancedata (AttDate, AttTime, AttDateTimeStr, Enroll_No, AttPlace, Status, verify_type, EventName)
            			        VALUES ('$AttDate', '$AttTime', '$AttFullData', '$EmpId', '$attPlace', '$CheckingStatus', '$VerifyType', '$eventName')";
            
            			if ($conn->query($sql) === TRUE) {
            			 //   echo "Record added successfully";
            				// echo json_encode(['status' => 'success', 'message' => 'Record added successfully']);
            			} else {
            			    echo "Error: " . $sql . "<br>" . $conn->error;
            			}
                }
            }
        echo "Record added successfully";

    } else {
        echo "Invalid JSON data";
    }
}

$conn->close();

?>