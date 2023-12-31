<?php
// Your database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "capstone";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data based on the emp_id passed via POST
$empId = $_POST['emp_id'];

// Adjust the query to fetch specific employee details based on emp_id
$sql = "SELECT e.emp_id, e.profile_img, e.lname, e.fname, e.emp_type, e.birthdate, e.contact_no, e.email, e.home_address, e.start_date, jp.position_name, e.gender
        FROM employee e
        JOIN job_position jp ON e.position_id = jp.position_id
        
        WHERE e.emp_id = $empId";

$result = $conn->query($sql);

// Check if any data is returned
if ($result->num_rows > 0) {
    // Fetch the data
    $row = $result->fetch_assoc();

    // Close the connection
    // $conn->close();

    // Output JSON
    echo json_encode($row);
} else {
    // No data found
    echo json_encode(array("error" => "No data found for emp_id: $empId"));
}

// Close the connection
$conn->close();
?>
