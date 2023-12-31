<?php
// Include your database connection file
include('config.php');

// Check if the necessary POST data is set
if (isset($_POST['period_id'])) {
    $periodId = $_POST['period_id'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT e.emp_id, e.fname, e.lname, jp.salary_rate
                            FROM attendance a
                            JOIN employee e ON a.emp_id = e.emp_id
                            JOIN job_position jp ON e.position_id = jp.position_id
                            WHERE a.date BETWEEN (SELECT period_from FROM payroll_period WHERE period_id = ?) AND (SELECT period_to FROM payroll_period WHERE period_id = ?)");
    $stmt->bind_param("ii", $periodId, $periodId);
    $stmt->execute();
    $stmt->bind_result($empId, $fname, $lname, $salaryRate);

    // Fetch results
    $data = array();
    while ($stmt->fetch()) {
        $data[] = array('empId' => $empId, 'fname' => $fname, 'lname' => $lname, 'salaryRate' => $salaryRate);
    }

    $stmt->close(); // Close the initial prepared statement

    // Loop through results and perform inserts or updates
    foreach ($data as $row) {
        // Check if an entry already exists for the emp_id and period_id
        $checkQuery = "SELECT COUNT(*) AS count FROM employee_payroll WHERE emp_id = ? AND period_id = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param("ii", $row['empId'], $periodId);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        $checkRow = $checkResult->fetch_assoc();

        if ($checkRow['count'] > 0) {
            // Update the existing entry
            $updateQuery = "UPDATE employee_payroll SET gross_pay = ?, lname = ?, fname = ? WHERE emp_id = ? AND period_id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("issii", $row['salaryRate'], $row['lname'], $row['fname'], $row['empId'], $periodId);
            $updateStmt->execute();
            $updateStmt->close();
        } else {
            // Insert a new entry
            $insertQuery = "INSERT INTO employee_payroll (emp_id, period_id, gross_pay, period_from, period_to, lname, fname) 
                             VALUES (?, ?, ?, (SELECT period_from FROM payroll_period WHERE period_id = ?), (SELECT period_to FROM payroll_period WHERE period_id = ?), ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("iississ", $row['empId'], $periodId, $row['salaryRate'], $periodId, $periodId, $row['lname'], $row['fname']);
            $insertStmt->execute();
            $insertStmt->close();
        }

        $checkStmt->close();
    }

    echo "Payroll successfully recalculated for Period ID: " . $periodId;
} else {
    echo "Invalid request. Missing parameters.";
}

// Close the database connection
$conn->close();
?>
