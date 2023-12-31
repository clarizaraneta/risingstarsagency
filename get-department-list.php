
<?php
include('config.php');

// SQL to fetch departments
$sql = "SELECT dept_id, job_dept FROM job_department";
$result = $conn->query($sql);

$options = "<option value=''>Select Department</option>";
if ($result && $result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row["dept_id"] . "'>" . $row["job_dept"] . "</option>";
    }
} else {
    $options = "<option value=''>No departments available</option>";
}

echo $options;

$conn->close();
?>