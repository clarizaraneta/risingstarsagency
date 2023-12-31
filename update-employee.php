<?php
// Assuming you are using PDO for database connection
include 'config.php'; // Your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $empId = $_POST['empId'];
    $lname = $_POST['lname'];
    $fname = $_POST['fname'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $contact_no = $_POST['contact_no'];
    $email = $_POST['email'];
    $home_address = $_POST['home_address'];
    $start_date = $_POST['start_date'];
    $emp_type = $_POST['emp_type'];
    $job_dept = $_POST['job_dept'];
    $position_name = $_POST['position_name'];

    $hrs_per_day = $emp_type == 'full-time' ? '8:00:00' : '4:00:00';

    // Handle file upload for profile image
    $profileImagePath = ''; // Default value if no file is uploaded
    if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] == 0) {
        $targetDirectory = "uploads/"; // Specify the directory where files are stored
        $fileName = basename($_FILES["profile_img"]["name"]);
        $targetFilePath = $targetDirectory . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Check if file type is valid
        $allowTypes = array('jpg', 'png', 'jpeg');
        if (in_array($fileType, $allowTypes)) {
            // Upload file to server
            if (move_uploaded_file($_FILES["profile_img"]["tmp_name"], $targetFilePath)) {
                $profileImagePath = $targetFilePath;
            }
        }
    }

    // SQL to update employee
    $sql = "UPDATE employees SET lname = ?, fname = ?, gender = ?, birthdate = ?, contact_no = ?, email = ?, home_address = ?, profile_img = ?, start_date = ?, emp_type = ?, job_dept = ?, position_name = ?, hrs_per_day = ? WHERE emp_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $lname);
    $stmt->bindParam(2, $fname);
    $stmt->bindParam(3, $gender);
    $stmt->bindParam(4, $birthdate);
    $stmt->bindParam(5, $contact_no);
    $stmt->bindParam(6, $email);
    $stmt->bindParam(7, $home_address);
    $stmt->bindParam(8, $profileImagePath);
    $stmt->bindParam(9, $start_date);
    $stmt->bindParam(10, $emp_type);
    $stmt->bindParam(11, $job_dept);
    $stmt->bindParam(12, $position_name);
    $stmt->bindParam(13, $hrs_per_day);
    $stmt->bindParam(14, $empId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update employee']);
    }
}
?>
