<?php
// Create connection
require 'config.php';


if(isset($_POST['view'])){
  $period_id = $_POST['period_id'];
  $period_from = $_POST['period_from'];
  $period_to = $_POST['period_to'];

  // Get employee details
  $sql = "SELECT a.emp_id, e.lname, e.fname, j.salary_rate 
          FROM attendance a 
          JOIN employee e ON a.emp_id = e.emp_id 
          JOIN job_position j ON e.position_id = j.position_id 
          WHERE a.date BETWEEN '$period_from' AND '$period_to'";

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
      $emp_id = $row["emp_id"];
      $lname = $row["lname"];
      $fname = $row["fname"];
      $gross_pay = $row["salary_rate"];

      // Insert into employee_payroll
      $sql_insert = "INSERT INTO employee_payroll (emp_id, lname, fname, period_id, gross_pay, period_from, period_to) 
                     VALUES ('$emp_id', '$lname', '$fname', '$period_id', '$gross_pay', '$period_from', '$period_to')";

      if ($conn->query($sql_insert) === TRUE) {
        echo "New record created successfully";
      } else {
        // Log the error
        error_log("Error: " . $sql_insert . "\n" . $conn->error . "\n", 3, "/path/to/your/error_log.txt");
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
      }
    }
  } else {
    echo "0 results";
  }
}
$conn->close();
?>
