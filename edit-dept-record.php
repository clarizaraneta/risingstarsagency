<?php
    require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get parameters from POST data
    $id = $_POST['id'];
    $newName = $_POST['name'];

    // Perform the update operation on your database
    $sql = "UPDATE job_department SET job_dept = ? WHERE dept_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newName, $id);
    $stmt->execute();

    // Example response
    $response = array('success' => true);

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