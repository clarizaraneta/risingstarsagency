<?php
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['emp_id'])) {
        // Get data from the POST request
        $emp_id = $_POST['emp_id'];

        // Echo the received emp_id for debugging
        echo "Received emp_id: " . $emp_id . "<br>";

        // Get the current date
        $currentDate = date('Y-m-d');

        // Echo the current date for debugging
        echo "Current date: " . $currentDate . "<br>";

        // Check if the employee has already punched in for the day
        $checkQuery = "SELECT * FROM attendance WHERE emp_id = ? AND DATE(in_time) = ?";
        $stmt = $conn->prepare($checkQuery);

        if ($stmt) {
            $stmt->bind_param('is', $emp_id, $currentDate);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Employee already punched in for the day
                echo 'DENY';
            } else {
                // Employee can punch in for the day
                echo 'ALLOW';
            }

            $stmt->close();
        } else {
            echo "Prepare statement failed: " . $conn->error;
        }
    } else {
        echo "Required data not received";
    }
} else {
    echo "Invalid request method";
}

$conn->close();
?>
