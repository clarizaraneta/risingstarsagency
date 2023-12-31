<?php
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the employee ID from POST data
    $empId = $_POST['emp_id'];

    // Prepare the SQL statement to delete the employee
    $deleteSql = "DELETE FROM employee WHERE emp_id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $empId);

    // Execute the statement and check if the deletion was successful
    if ($deleteStmt->execute()) {
        // Success response
        $response = array('success' => true, 'message' => 'Employee deleted successfully.');
    } else {
        // Error response
        $response = array('success' => false, 'message' => 'Error deleting employee.');
    }

    // Output JSON response
    header('Content-Type: application/json');
    echo json_encode($response);

    // Close the statement
    $deleteStmt->close();
} else {
    // Invalid request method
    header('HTTP/1.1 405 Method Not Allowed');
    header('Allow: POST');
    exit;
}
?>
