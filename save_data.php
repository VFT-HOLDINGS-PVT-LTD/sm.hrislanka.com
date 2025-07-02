<?php

echo "Run successfully..///";

$servername = "localhost";
$username = "pl_user";
$password = "z2=P=SHWSgx{";
$database = "pl_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Read the raw POST data
    $json_data = file_get_contents("php://input");

    // Decode the JSON data
    $decoded_data = json_decode($json_data, true);

    // Check if decoding was successful
    if ($decoded_data !== null) {
        // Echo the decoded data
        //echo "Received Data:\n";
        //print_r($decoded_data);
		
		foreach ($decoded_data as $item) {
			// Access each element of the array
			$attDate = $item['AttDate'];
			$dateTime = new DateTime($attDate);
			// Format the date as yyyy-MM-dd
			$formattedDate = $dateTime->format('Y-m-d');
	
			$attTime = $item['AttTime'];
			$attDateTimeStr = $item['AttDateTimeStr'];
			$enrollNo = $item['Enroll_No'];
			$attPlace = $item['AttPlace'];
			$status = $item['Status'];
			$verifyType = $item['verify_type'];
			$eventName = $item['EventName'];
			
			$searchData = "SELECT * FROM `tbl_u_attendancedata` WHERE `AttDateTimeStr`='".$attDateTimeStr."' AND `Enroll_No`='".$enrollNo."'";
            $result = mysqli_query($conn, $searchData);
             
            $test = $result->num_rows;
			
			if ($test > 0) {
				
                 echo  "Thiywa";
				 
            }else{
				
                echo "Nee";
			
				$sql = "INSERT INTO tbl_u_attendancedata (AttDate, AttTime, AttDateTimeStr, Enroll_No, AttPlace, Status, verify_type, EventName)
						VALUES ('$formattedDate', '$attTime', '$attDateTimeStr', '$enrollNo', '$attPlace', '$status', '$verifyType', '$eventName')";

				if ($conn->query($sql) === TRUE) {
					echo "Record added successfully";
					echo json_encode(['status' => 'success', 'message' => 'Record added successfully']);
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
			}
			
			// ... (assign other values to variables as needed)

			// Now you can use these variables as needed
			// For example, you can insert them into a database or perform other operations
			//echo "Enroll_No: $enrollNo, AttDate: $attDate, AttTime: $attTime, \n";
			// ... (do something with other variables)
		}

    } else {
        // Handle JSON decoding error
        echo "Error decoding JSON data";
    }
}

$conn->close();
?>
