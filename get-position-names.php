
<?php
include('config.php');


// Get department ID from AJAX request
$deptId = isset($_POST['dept_id']) ? $conn->real_escape_string($_POST['dept_id']) : '';

// SQL to fetch positions
$sql = "SELECT position_id, position_name FROM job_position WHERE dept_id = '$deptId'";
$result = $conn->query($sql);

$options = "<option value=''>Select Position</option>";
if ($result && $result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row["position_id"] . "'>" . $row["position_name"] . "</option>";
    }
} else {
    $options = "<option value=''>No positions available</option>";
}

echo $options;

$conn->close();
?>