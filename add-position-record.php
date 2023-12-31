<?php
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get parameters from POST data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $salaryRate = $_POST['rate'];
    $deptId = $_POST['dept_id']; // Add this line to get the selected department ID

    // Check if the specified ID already exists
    $checkSql = "SELECT COUNT(*) as count FROM job_position WHERE position_name = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $name);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    $count = $checkResult->fetch_assoc()['count'];

    if ($count > 0) {
        // Name already exists, return an error
        $response = array('success' => false, 'error' => 'Position Name already exists');
    } else {
        // Name doesn't exist, perform the insertion
        $insertSql = "INSERT INTO job_position (position_name, job_description, salary_rate, dept_id) VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("ssdi", $name, $description, $salaryRate, $deptId);
        $insertStmt->execute();

        if ($insertStmt->affected_rows > 0) {
            // Successfully inserted
            $response = array('success' => true, 'id' => $conn->insert_id);
        } else {
            // Failed to insert
            $response = array('success' => false, 'error' => 'Failed to insert job position');
        }
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
