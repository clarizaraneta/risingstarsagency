<?php
// Include your database connection file
include('config.php');

// Check if the necessary POST data (period_id) is set
if (isset($_POST['period_id'])) {
    $periodId = $_POST['period_id'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT emp_id, lname, fname, basic_salary, ot_payment, gross_pay, deductions_total, net_pay
                            FROM employee_payroll
                            WHERE period_id = ?");
    $stmt->bind_param("i", $periodId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch results into an associative array
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Close the statement
    $stmt->close();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode(['data' => $data]);
} else {
    // Handle the case when period_id is not set
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid request. Missing parameters.']);
}

// Close the database connection
$conn->close();
?>
