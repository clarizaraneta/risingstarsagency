<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "capstone";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the period_id from the POST data
$periodId = $_POST['period_id'];

// Perform the deletion in the database
$sql = "DELETE FROM payroll_period WHERE period_id = $periodId";
$result = $conn->query($sql);

if ($result) {
    echo "Payroll period deleted successfully!";
} else {
    echo "Error deleting payroll period: " . $conn->error;
}

$conn->close();
?>
