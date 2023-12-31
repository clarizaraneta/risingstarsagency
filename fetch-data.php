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

// Fetch data from the database (adjust the query as needed)
$sql = "SELECT e.emp_id, e.profile_img, e.lname, e.fname, e.emp_type, jp.position_name, jd.job_dept  
        FROM employee e
        JOIN job_position jp ON e.position_id = jp.position_id
        JOIN job_department jd ON jp.dept_id = jd.dept_id";
$result = $conn->query($sql);

// Convert the result to a JSON format for DataTables
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Close the connection
$conn->close();

// Output JSON
echo json_encode(array("data" => $data));
?>
