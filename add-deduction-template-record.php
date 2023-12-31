<?php
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get parameters from POST data
    $deductionType = $_POST['type'];
    $deductionValue = $_POST['value'];
    $deductionValueType = $_POST['valueType'];

    // Prepare the SQL statement
    $sql = "INSERT INTO deduction_template (deduction_type, amount, percentage_amount) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Determine and bind parameters based on the deduction value type
    if ($deductionValueType === 'amount') {
        $amount = $deductionValue;
        $percentageAmount = null;
        $stmt->bind_param("sdd", $deductionType, $amount, $percentageAmount);
    } elseif ($deductionValueType === 'percentage') {
        $amount = null;
        $percentageAmount = $deductionValue;
        $stmt->bind_param("sdd", $deductionType, $amount, $percentageAmount);
    } else {
        // Handle invalid valueType
        $response = array('success' => false, 'message' => 'Invalid value type');
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Check if the insertion was successful
        $response = ($stmt->affected_rows > 0) 
                    ? array('success' => true) 
                    : array('success' => false, 'message' => 'Failed to add deduction template');
    } else {
        // Failed to execute the prepared statement
        $response = array('success' => false, 'message' => 'Failed to execute the query');
    }

    // Close the prepared statement
    $stmt->close();

    // Output JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Invalid request method
    header('HTTP/1.1 405 Method Not Allowed');
    header('Allow: POST');
    exit;
}
?>
