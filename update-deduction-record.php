<?php
// Include your database configuration file or establish a database connection here
require_once('config.php');

// Check if the necessary data is received via POST
if (isset($_POST['id']) && isset($_POST['type']) && isset($_POST['valueType']) && isset($_POST['value'])) {
    $id = $_POST['id'];
    $deductionType = $_POST['type'];
    $valueType = $_POST['valueType'];
    $value = $_POST['value'];

    // Perform the update query
    $updateQuery = "UPDATE deduction_template 
                    SET deduction_type = '$deductionType', 
                        amount = " . ($valueType == 'amount' ? $value : 'NULL') . ",
                        percentage_amount = " . ($valueType == 'percentage' ? $value : 'NULL') . "
                    WHERE dedtype_id = $id";

    if ($conn->query($updateQuery) === TRUE) {
        // If the update was successful, send a success response
        echo json_encode(['success' => true]);
    } else {
        // If there was an error in the update query, send a failure response
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }

    // Close the database connection
    $conn->close();
} else {
    // If the necessary data is not received, send a failure response
    echo json_encode(['success' => false, 'error' => 'Invalid data received']);
}
?>
