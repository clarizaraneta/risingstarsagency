<?php
// path_to_your_php_file.php
require_once 'config.php'; // Adjust this to your database configuration file

// Check if emp_id and period_id are set
if(isset($_GET['emp_id']) && isset($_GET['period_id'])) {
    $empId = $_GET['emp_id'];
    $periodId = $_GET['period_id'];

    // Your query to fetch payroll details
    $sql = "SELECT * FROM employee_payroll WHERE emp_id = ? AND period_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $empId, $periodId);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $payrollDetails = $result->fetch_assoc();

        // Deduction types
        $deductionTypes = ["Tax", "SSS", "PhilHealth", "PagIBIG", "Salary Advance", "Other"];

        // Fetch and sum deductions for each type
        foreach ($deductionTypes as $type) {
            $deductionSql = "SELECT SUM(amount) AS total FROM deduction_details WHERE emppay_id = ? AND deduction_type = ?";
            $deductionStmt = $conn->prepare($deductionSql);
            $deductionStmt->bind_param("is", $empId, $type);
            $deductionStmt->execute();
            $deductionResult = $deductionStmt->get_result();
            if ($deductionResult->num_rows > 0) {
                $row = $deductionResult->fetch_assoc();
                $payrollDetails['deductions'][$type] = $row['total'];
            } else {
                $payrollDetails['deductions'][$type] = 0;
            }
        }

        echo json_encode($payrollDetails);
    } else {
        echo json_encode(['error' => 'No details found']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
