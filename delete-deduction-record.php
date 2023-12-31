<?php
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get parameter from POST data
    $id = $_POST['id'];

    // Perform the deletion operation on your database
    $sql = "DELETE FROM deduction_template WHERE dedtype_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
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
