<?php
// Include your database connection file
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $empId = $_POST['emp_id'];
    $date = $_POST['date'];
    $positionId = $_POST['position_id'];
    $status = 'Active'; // Set the status to 'Active' for the new entry

    // Fetch salary_rate based on the chosen position_id
    $positionQuery = "SELECT salary_rate FROM job_position WHERE position_id = ?";
    $stmt = $conn->prepare($positionQuery);
    $stmt->bind_param("i", $positionId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $salaryRate = $row['salary_rate'];

        // Set all previous entries for the same emp_id to inactive
        $updateQuery = "UPDATE emp_history SET status = 'Inactive' WHERE emp_id = ?";
        $stmtUpdate = $conn->prepare($updateQuery);
        $stmtUpdate->bind_param("i", $empId);
        $stmtUpdate->execute();

        // Insert the new entry into the emp_history table
        $insertQuery = "INSERT INTO emp_history (emp_id, date, position_id, salary_rate, status) VALUES (?, ?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($insertQuery);
        $stmtInsert->bind_param("isiss", $empId, $date, $positionId, $salaryRate, $status);
        $stmtInsert->execute();

        // Update the position_id in the employee table
        $updateEmployeeQuery = "UPDATE employee SET position_id = ? WHERE emp_id = ?";
        $stmtUpdateEmployee = $conn->prepare($updateEmployeeQuery);
        $stmtUpdateEmployee->bind_param("ii", $positionId, $empId);
        $stmtUpdateEmployee->execute();

        // Close the statements
        $stmt->close();
        $stmtUpdate->close();
        $stmtInsert->close();
        $stmtUpdateEmployee->close();

        // Close the database connection
        $conn->close();

        echo "New entry saved successfully!";
    } else {
        echo "Error: Unable to fetch salary_rate for the selected position_id.";
    }
} else {
    echo "Error: Invalid request method.";
}
?>
