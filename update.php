<?php
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the POST data contains the necessary keys
    if (isset($_POST['emp_id'], $_POST['punchType'])) {
        // Get data from the POST request
        $emp_id = $_POST['emp_id'];
        $punchType = ($_POST['punchType'] === '1') ? 1 : 0; // Convert to integer (1 or 0)

        // Check if punchType is a valid value (either 0 or 1)
        if ($punchType === 0 || $punchType === 1) {
            // Update the existing record in the database based on emp_id and punchType
            $updateQuery = "UPDATE attendance SET out_status = ? WHERE emp_id = ? ORDER BY in_time DESC LIMIT 1";
            $stmt = $conn->prepare($updateQuery);

            if ($stmt) {
                $stmt->bind_param('ii', $punchType, $emp_id);
                $stmt->execute();
                $stmt->close();
                echo "Punch out recorded successfully";
            } else {
                echo "Prepare statement failed: " . $conn->error;
            }
        } else {
            echo "Invalid punchType for update operation";
        }
    } else {
        echo "Required data not received";
    }
} else {
    echo "Invalid request method";
}

$conn->close();
?>
