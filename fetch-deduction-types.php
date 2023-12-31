<?php
include('config.php');

// Fetch deduction types from the deduction_template table
$query = "SELECT dedtype_id, deduction_type, percentage_amount FROM deduction_template";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$deductionTypes = array();

while ($row = mysqli_fetch_assoc($result)) {
    $deductionTypes[] = $row;
}

// Close the database connection
mysqli_close($conn);

// Send the JSON response
header('Content-Type: application/json');

// Check if there are any records
if (empty($deductionTypes)) {
    echo json_encode(['error' => 'No records found']);
} else {
    echo json_encode($deductionTypes);
}
?>
