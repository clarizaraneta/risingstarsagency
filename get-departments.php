<?php
require_once('config.php');

$deptSql = "SELECT * FROM job_department";
$deptResult = $conn->query($deptSql);

$departments = array();

if ($deptResult->num_rows > 0) {
    while ($deptRow = $deptResult->fetch_assoc()) {
        $departments[] = array('dept_id' => $deptRow["dept_id"], 'job_dept' => $deptRow["job_dept"]);
    }
}

// Close the database connection
$conn->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($departments);
?>
