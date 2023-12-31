<?php
include('config.php');

// Assuming you have a connection named $conn

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Sanitize and validate your input here
    $periodId = isset($_GET['period_id']) ? $_GET['period_id'] : null;

    if (!$periodId) {
        echo json_encode(['error' => 'Invalid period_id']);
        exit();
    }

    // Fetch employee names with emppay_id
    $query = "SELECT emp_id, emppay_id, lname, fname FROM employee_payroll WHERE period_id = '$periodId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $employeeList = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $employeeList[] = [
                'emp_id' => $row['emp_id'],
                'emppay_id' => $row['emppay_id'],
                'lname' => $row['lname'],
                'fname' => $row['fname'],
            ];
        }

        echo json_encode($employeeList);
    } else {
        echo json_encode(['error' => 'Error fetching employee names']);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
