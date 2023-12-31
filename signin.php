<?php
require_once('config.php');

$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

$sql = "SELECT emp_id, fname, lname, role FROM employee WHERE email=? AND password=?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        session_start();

        if (isset($row['fname'], $row['lname'], $row['emp_id'])) {
            // Employee login
            $_SESSION['empName'] = $row['fname'] . ' ' . $row['lname'];
            $_SESSION['emp_id'] = $row['emp_id'];
            $_SESSION['role'] = $row['role'];

            if ($_SESSION['role'] === 'Payroll') {
                header('Location: payroll-list.php');
                exit();
            } elseif ($_SESSION['role'] === 'Emp') {
                header('Location: attendance.php');
                exit();
            } elseif ($_SESSION['role'] === 'HR') {
                header('Location: employee-list.php');
                exit();
            } elseif ($_SESSION['role'] === 'Admin') {
                header('Location: employee-list.php');
                exit();
            }
            $stmt->close();
            $conn->close();
            exit();
        }
    } else {
        // Invalid email or password
        header("Location: index.php?error=1");
        $stmt->close();
        $conn->close();
        exit();
    }
} else {
    // Database error handling
    session_start();
    $_SESSION['message'] = 'Database error: ' . $conn->error;
    header("Location: index.php?error=db");
    $conn->close();
    exit();
}
?>
