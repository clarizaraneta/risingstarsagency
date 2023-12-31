<?php
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get parameters from POST data
    $name = $_POST['name'];

    // Check if the specified name already exists
    $checkSql = "SELECT COUNT(*) as count FROM job_department WHERE job_dept = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $name);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    $count = $checkResult->fetch_assoc()['count'];

    if ($count > 0) {
        // Name already exists, return an error
        $response = array('success' => false, 'error' => 'Department name already exists');
    } else {
        // Name doesn't exist, perform the insertion
        $insertSql = "INSERT INTO job_department (job_dept) VALUES (?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("s", $name);
        $insertStmt->execute();

        // Example response
        $response = array('success' => true, 'id' => $conn->insert_id);
    }

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
