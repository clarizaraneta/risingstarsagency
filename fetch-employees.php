<?php
require 'config.php';

// Get the period_from and period_to from the POST data
$period_from = $_POST['period_from'];
$period_to = $_POST['period_to'];

// Prepare a SQL query to fetch active employees with attendance entries within the specified period
$sql = "
    SELECT e.emp_id, e.lname, e.fname, p.period_id, j.salary_rate as gross_pay, p.period_from, p.period_to
    FROM employee e
    JOIN attendance a ON e.emp_id = a.emp_id
    JOIN payroll_period p ON a.date BETWEEN p.period_from AND p.period_to
    JOIN job_position j ON e.position_id = j.position_id
    WHERE a.date BETWEEN '$period_from' AND '$period_to'
    AND e.employee_status = 'active'
";

$result = $conn->query($sql);

// Convert the result to a JSON format for DataTables
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = array(
        'emp_id' => $row['emp_id'],
        'lname' => $row['lname'],
        'fname' => $row['fname'],
        'period_id' => $row['period_id'],
        'gross_pay' => $row['gross_pay'],
        'period_from' => $row['period_from'],
        'period_to' => $row['period_to']
    );
}

// Close the database connection
$conn->close();

// Output JSON
echo json_encode(array("data" => $data));
?>
