<?php
// add-deduction.php
require 'config.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get POST data
    $dedTypeId = $_POST['dedTypeId'];
    $emppayId = $_POST['emppayId'];
    $amount = $_POST['amount'];

    // SQL to add the deduction
    $sql = "INSERT INTO deductions (dedtype_id, emppay_id, amount) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iid", $dedTypeId, $emppayId, $amount);

    if ($stmt->execute()) {
        echo "Deduction added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
