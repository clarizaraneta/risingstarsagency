<?php
require_once('config.php');

function sendJsonResponse($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get parameters from POST data
    $id = $_POST['id'];
    $newName = $_POST['name'];
    $newDescription = $_POST['description'];
    $newSalaryRate = $_POST['rate'];
    $newDeptId = $_POST['dept_id'];

    // Perform the update operation on your database
    $sql = "UPDATE job_position SET position_name = ?, job_description = ?, salary_rate = ?, dept_id = ? WHERE position_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $newName, $newDescription, $newSalaryRate, $newDeptId, $id);

    if ($stmt->execute()) {
        // Successfully updated
        $response = array('success' => true);
        sendJsonResponse($response);
    } else {
        // Failed to update
        $error = $stmt->error;
        $response = array('success' => false, 'error' => 'Failed to update job position: ' . $error);
        sendJsonResponse($response);
    }

    $stmt->close();
} else {
    // Invalid request method
    header('HTTP/1.1 405 Method Not Allowed');
    header('Allow: POST');
    exit;
}
?>
