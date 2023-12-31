<?php
include('config.php'); // Ensure you have included your database configuration file

// Function to sanitize input data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to get emppay_id
function getEmpPayId($empId, $periodId, $mysqli) {
    $query = "SELECT emppay_id FROM employee_payroll WHERE emp_id = ? AND period_id = ? LIMIT 1";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("ii", $empId, $periodId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row['emppay_id'];
        }
        $stmt->close();
    }
    return null;
}

// Function to fetch the deduction type using dedtype_id
function getDeductionTypeByDedtypeId($dedtypeId, $mysqli) {
    $query = "SELECT deduction_type FROM deduction_template WHERE dedtype_id = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("i", $dedtypeId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row['deduction_type'];
        }
        $stmt->close();
    }
    return null;
}

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $empId = isset($_POST['emp_id']) ? sanitizeInput($_POST['emp_id']) : '';
    $periodId = isset($_POST['period_id']) ? sanitizeInput($_POST['period_id']) : '';
    $dedtypeId = isset($_POST['dedtype_id']) ? sanitizeInput($_POST['dedtype_id']) : '';
    $amount = isset($_POST['amount']) ? sanitizeInput($_POST['amount']) : '';

    // Check if any required field is empty
    if (empty($empId) || empty($periodId) || empty($dedtypeId) || empty($amount)) {
        echo "All fields are required.";
        exit;
    }

    // Get emppay_id
    $emppayId = getEmpPayId($empId, $periodId, $conn);

    // Get deduction_type
    $deductionType = getDeductionTypeByDedtypeId($dedtypeId, $conn);

    if ($emppayId !== null && $deductionType !== null) {
        // Prepare an SQL statement to prevent SQL injection
        $sql = "INSERT INTO deduction_details (dedtype_id, emppay_id, amount, deduction_type) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("iids", $dedtypeId, $emppayId, $amount, $deductionType);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                echo "Deduction saved successfully.";
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close statement
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "Could not retrieve employee payroll ID or deduction type.";
    }
} else {
    echo "Invalid request method.";
}

// Update deductions_total in employee_payroll table
$deductionsTotalQuery = "UPDATE employee_payroll ep
SET ep.deductions_total = (SELECT SUM(amount) FROM deduction_details dd WHERE dd.emppay_id = ep.emppay_id)
WHERE ep.period_id = '$periodId'";

$updateDeductionsTotalResult = mysqli_query($conn, $deductionsTotalQuery);

if (!$updateDeductionsTotalResult) {
echo json_encode(['error' => 'Error updating deductions total']);
exit();
}


// Close database connection
$conn->close();
?>
