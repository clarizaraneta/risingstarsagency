<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect post data
    $lname = $_POST['lname'];
    $fname = $_POST['fname'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $contact_no = $_POST['contact_no'];
    $home_address = $_POST['home_address'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Consider encrypting the password
    $start_date = $_POST['start_date'];
    $emp_type = $_POST['emp_type'];
    $position_id = $_POST['position_id'];
    $role = $_POST['role'];

    // Calculate hours per day based on employment type
    $hrs_per_day = $emp_type == 'full-time' ? '8:00:00' : '4:00:00';

    // Prepare an insert statement for the employee
    $sql = "INSERT INTO employee (lname, fname, gender, birthdate, contact_no, home_address, email, password, start_date, emp_type, hrs_per_day, position_id, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssis", $lname, $fname, $gender, $birthdate, $contact_no, $home_address, $email, $password, $start_date, $emp_type, $hrs_per_day, $position_id, $role);

    if ($stmt->execute()) {
        $emp_id = $conn->insert_id; // Get the last inserted emp_id

        // Fetch salary_rate from job_position
        $query = "SELECT salary_rate FROM job_position WHERE position_id = ?";
        $positionStmt = $conn->prepare($query);
        $positionStmt->bind_param("i", $position_id);
        $positionStmt->execute();
        $result = $positionStmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $salary_rate = $row['salary_rate'];

            // Insert into emp_history
            $hist_sql = "INSERT INTO emp_history (emp_id, date, position_id, salary_rate, status) VALUES (?, NOW(), ?, ?, 'active')";
            $hist_stmt = $conn->prepare($hist_sql);
            $hist_stmt->bind_param("iis", $emp_id, $position_id, $salary_rate);
            
            if ($hist_stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "New employee and history record created successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error adding to emp_history: " . $conn->error]);
            }

            $hist_stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Error fetching salary rate"]);
        }

        $positionStmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Error adding employee: " . $conn->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>
