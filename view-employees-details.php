<?php
require 'config.php';

$periodId = $_GET['period_id'];

// Your SQL query to fetch details of employees under the specified period_id
$sql = "
    SELECT
        ep.emppay_id,
        e.emp_id,
        e.lname,
        e.fname,
        jp.salary_rate AS gross_pay,
        ep.period_from,
        ep.period_to
    FROM employee_payroll ep
    JOIN employee e ON ep.emp_id = e.emp_id
    JOIN job_position jp ON e.position_id = jp.position_id
    WHERE ep.period_id = $periodId
";

$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(array("data" => $data));
?>
