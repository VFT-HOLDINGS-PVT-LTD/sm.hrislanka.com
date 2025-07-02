<?php

// Enable error reporting to help debug the 500 error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details
$servername = "localhost";
$username = "sm_user";
$password = "dX@bNRGxLSpe";
$database = "sm_db";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json_data = file_get_contents("php://input");

    // Check if the JSON data was properly received
    if ($json_data === false) {
        die('Error reading input data');
    }

    // Decode the JSON data
    $decoded_data = json_decode($json_data, true);

    // Check if the JSON was properly decoded
    if ($decoded_data === null) {
        die('Invalid JSON format: ' . json_last_error_msg());
    }

    // Ensure $decoded_data is always an array (wrap single object in array)
    if (!is_array($decoded_data)) {
        die('Invalid data format');
    }

    // If $decoded_data is a single object (not an array), wrap it in an array
    if (isset($decoded_data['EmpId'])) {
        $decoded_data = [$decoded_data];
    }

    // Loop through the data and process each entry
    foreach ($decoded_data as $date) {
        
        // Ensure that $date is an array
        if (!is_array($date)) {
            die('Invalid data format: each entry should be an array');
        }
        
        // Extract necessary fields
        $EmpId = isset($date['EmpId']) ? $date['EmpId'] : null;
        $AttFullData = isset($date['AttTime']) ? $date['AttTime'] : null;
        $CheckingStatus = isset($date['CheckingStatus']) ? $date['CheckingStatus'] : null;
        $VerifyType = isset($date['VerifyType']) ? $date['VerifyType'] : null;
        // $DeviceID = isset($date['DeviceID']) ? $date['DeviceID'] : null;
        $attPlace = NULL; // Set to NULL instead of "null"
        $eventName = NULL; // Set to NULL instead of "null"
        
        // Validate that required fields are not empty
        if (is_null($EmpId) || is_null($AttFullData)) {
            die('Missing required fields: EmpId or AttTime');
        }

        // Split AttFullData into date and time components
        list($AttDate, $AttTime) = explode(" ", $AttFullData);

        // SQL query to check if the record already exists
        $searchData = "SELECT * FROM `tbl_u_attendancedata` WHERE `AttDateTimeStr` = '$AttFullData' AND `Enroll_No` = '$EmpId'";
        $result = mysqli_query($conn, $searchData);
        
        // Check if the query returned any results
        if (!$result) {
            die('Error in SELECT query: ' . mysqli_error($conn));
        }

        // Check if the record already exists
        if ($result->num_rows > 0) {
            // Record already exists, no need to insert
            continue;
        } else {
            // Prepare the SQL INSERT statement
            $sql = "INSERT INTO tbl_u_attendancedata (AttDate, AttTime, AttDateTimeStr, Enroll_No, AttPlace, Status, verify_type, EventName)
                    VALUES ('$AttDate', '$AttTime', '$AttFullData', '$EmpId', '$attPlace', '$CheckingStatus', '$VerifyType', '$eventName')";

            // Execute the INSERT query
            if ($conn->query($sql) !== TRUE) {
                die("Error inserting record: " . $conn->error);
            }
        }
    }

    // If we reached this point, the records were successfully added
    echo "Records added successfully";

} else {
    echo "Invalid request method";
}

// Close the database connection
$conn->close();

?>
