<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "capstone";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT period_id, period_from, period_to, total, date_generated, status FROM payroll_period ORDER BY period_from ASC";
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
