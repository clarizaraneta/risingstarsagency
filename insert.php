<?php
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the POST data contains the necessary keys
    if (isset($_POST['emp_id'], $_POST['punchType'])) {
        // Get data from the POST request
        $emp_id = $_POST['emp_id'];
        $punchType = ($_POST['punchType'] === '1') ? 1 : 0; // Convert to integer (1 or 0)

        // Prepare and execute SQL query to insert data into the database
        $sql = "INSERT INTO attendance (emp_id, in_status ) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('ii', $emp_id, $punchType);
            $stmt->execute();
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
