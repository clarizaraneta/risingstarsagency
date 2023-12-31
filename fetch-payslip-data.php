<?php
require 'config.php'; // Database connection

$empId = $_POST['emp_id'];
$periodFrom = $_POST['period_from'];
$periodTo = $_POST['period_to'];

// Query the database
$sql = "SELECT * FROM employee_payroll WHERE emp_id = ? AND period_from = ? AND period_to = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $empId, $periodFrom, $periodTo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Echo the details
    echo "Emp ID: " . $row['emp_id'] . "<br>";
    echo "Name: " . $row['lname'] . ', ' . $row['fname'] . "<br>";
    // Add more details as required
} else {
    echo "No details found.";
}

$stmt->close();
$conn->close();
?>
