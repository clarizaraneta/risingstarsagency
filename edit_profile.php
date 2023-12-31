<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #2259E3;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #1e4ab8;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Edit Employee Profile</h2>
    <form action="edit_profile.php<?php echo isset($_GET['emp_id']) ? '?emp_id=' . $_GET['emp_id'] : ''; ?>" method="POST">
        <?php
        if (isset($_GET['emp_id'])) {
            $emp_id = $_GET['emp_id'];
            require_once('config.php');

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Sanitize and update employee data in the database
                $fname = $_POST['fname']; // Sanitize these values before using in SQL query
                $lname = $_POST['lname'];
                $email = $_POST['email'];
                $home_address = $_POST['home_address'];
                $start_date = $_POST['start_date'];


                $sql = "UPDATE employees SET fname=?, lname=?, email=?, home_address=?, start_date=? WHERE emp_id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssssi", $fname, $lname, $email, $home_address,$start_date, $emp_id);
                $stmt->execute();

                // Redirect to employee list after updating data
                header("Location: employee-list.php");
                exit();
            }

            $sql = "SELECT * FROM employees WHERE emp_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $emp_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $employeeData = $result->fetch_assoc();

            if ($result->num_rows > 0) {
                ?>
                <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
                <label for="fname">First Name:</label>
                <input type="text" id="fname" name="fname" value="<?php echo $employeeData['fname']; ?>"><br>
                
                <label for="lname">Last Name:</label>
                <input type="text" id="lname" name="lname" value="<?php echo $employeeData['lname']; ?>"><br>

                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo $employeeData['email']; ?>"><br> 

                <label for="home_address">Home Address:</label>
                <input type="text" id="home_address" name="home_address" value="<?php echo $employeeData['home_address']; ?>"><br> 

                <label for="start_date">Date Started:</label>
                <input type="date" id="start_date" name="start_date" value="<?php echo $employeeData['start_date']; ?>"><br> 
                <br>


                <input type="submit" value="Save Changes">
                <?php
            } else {
                echo "Employee not found.";
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Employee ID not provided.";
        }
        ?>
    </form>
</body>
</html>
