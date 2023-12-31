<?php
require_once('config.php');
 
$query = $conn->query("SELECT count(emp_id) FROM employee");
$totalRecords = $query->fetch_row()[0];
 
$length = $_GET['length'];
$start = $_GET['start'];
 
$sql = "SELECT emp_id, fullname, email FROM employee";
 
if (isset($_GET['search']) && !empty($_GET['search']['value'])) {
    $search = $_GET['search']['value'];
    $sql .= sprintf(" WHERE fullname like '%s' OR email like '%s'", '%'.$conn->real_escape_string($search).'%', '%'.$conn->real_escape_string($search).'%');
}

$sql .= " LIMIT $start, $length";
$query = $conn->query($sql);
$result = [];
while ($row = $query->fetch_assoc()) {
    $result[] = [
        $row['fullname'],
        $row['email'],
        "<a href='edit.php?id=".$row['emp_id']."'>Edit</a> | <a href='delete.php?id=".$row['emp_id']."''>Delete</a>"
    ];
}

echo json_encode([
    'draw' => $_GET['draw'],
    'recordsTotal' => $totalRecords,
    'recordsFiltered' => $totalRecords,
    'data' => $result,
]);