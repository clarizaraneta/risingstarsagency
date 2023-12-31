<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "capstone";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $period_from = date("Y-m-d", strtotime($_POST["period_from"]));
    $period_to = date("Y-m-d", strtotime($_POST["period_to"]));
    $period_type = $_POST["period_type"];
    $date_generated = date("Y-m-d H:i:s"); // Automatically add the current date and time
    $status = "Open"; // Automatically set status to "Open"

    $sql = "INSERT INTO payroll_period (period_from, period_to, period_type, date_generated, status)
            VALUES ('$period_from', '$period_to', '$period_type', '$date_generated', '$status')";

    $newPeriodFrom = $period_from;
    $newPeriodTo = $period_to;

    if ($conn->query($sql) === TRUE) {
        echo "Payroll Period added successfully";

        // Fetch the newly added period_id
        $newPeriodId = $conn->insert_id;

        // Fetch employee data and update payroll for the new period_id
        $stmt = $conn->prepare("SELECT e.emp_id, e.fname, e.lname, jp.salary_rate, jp.ot_rate, e.hrs_per_day
                                FROM attendance a
                                JOIN employee e ON a.emp_id = e.emp_id
                                JOIN job_position jp ON e.position_id = jp.position_id
                                WHERE a.date BETWEEN ? AND ?");
        $stmt->bind_param("ss", $period_from, $period_to);
        $stmt->execute();
        $stmt->bind_result($empId, $fname, $lname, $salaryRate, $otRate, $hrsPerDay);

        // Fetch results
        $data = array();
        while ($stmt->fetch()) {
            $data[] = array('empId' => $empId, 'fname' => $fname, 'lname' => $lname, 'salaryRate' => $salaryRate, 'otRate' => $otRate, 'hrsPerDay' => $hrsPerDay);
        }

        $stmt->close(); // Close the initial prepared statement

        // Loop through results and perform inserts or updates for the new period_id
        foreach ($data as $row) {
            // Check if an entry already exists for the emp_id and new period_id
            $checkQuery = "SELECT COUNT(*) AS count FROM employee_payroll WHERE emp_id = ? AND period_id = ?";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->bind_param("ii", $row['empId'], $newPeriodId);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();
            $checkRow = $checkResult->fetch_assoc();

            // Determine the basic salary based on payroll_type
            $basicSalary = ($period_type === 'semi-monthly') ? ($row['salaryRate'] / 2) : $row['salaryRate'];

            // Calculate required_hours
            $requiredHours = calculateRequiredHours($newPeriodFrom, $newPeriodTo, $row['empId'], $row['hrsPerDay'], $conn);

            // Calculate total hours rendered
            $totalHoursRendered = calculateTotalHoursRendered($newPeriodFrom, $newPeriodTo, $row['empId'], $conn);

            $deductionsTotal = 0;

            if ($checkRow['count'] > 0) {
                // Update the existing entry
                $updateQuery = "UPDATE employee_payroll SET lname = ?, fname = ?, basic_salary = ?, ot_rate = ?, required_hours = ?, hours_rendered = ?, deductions_total = ? WHERE emp_id = ? AND period_id = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("ssddiidii", $row['lname'], $row['fname'], $basicSalary, $row['otRate'], $requiredHours, $totalHoursRendered, $deductionsTotal, $row['empId'], $newPeriodId);
                $updateStmt->execute();
                $updateStmt->close();
            } else {
                // Insert a new entry
                $insertQuery = "INSERT INTO employee_payroll (emp_id, period_id, basic_salary, ot_rate, required_hours, hours_rendered, deductions_total, period_from, period_to, lname, fname) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, (SELECT period_from FROM payroll_period WHERE period_id = ?), (SELECT period_to FROM payroll_period WHERE period_id = ?), ?, ?)";
                $insertStmt = $conn->prepare($insertQuery);
                $insertStmt->bind_param("iidddidiiss", $row['empId'], $newPeriodId, $basicSalary, $row['otRate'], $requiredHours, $totalHoursRendered, $deductionsTotal, $newPeriodId, $newPeriodId, $row['lname'], $row['fname']);
                $insertStmt->execute();
                $insertStmt->close();
            }

            $checkStmt->close();
        }

        echo " Payroll successfully added for Period ID: " . $newPeriodId;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

// Function to calculate required_hours based on weekdays
function calculateRequiredHours($newPeriodFrom, $newPeriodTo, $empId, $hrsPerDay, $conn) {
    $startTimestamp = strtotime($newPeriodFrom);
    $endTimestamp = strtotime($newPeriodTo);
    $weekdayCount = 0;

    // Count weekdays between start and end dates
    while ($startTimestamp <= $endTimestamp) {
        if (date("N", $startTimestamp) <= 5) { // Monday to Friday
            $weekdayCount++;
        }
        $startTimestamp = strtotime("+1 day", $startTimestamp);
    }

    $hrsPerDayInt = (int)$hrsPerDay;

    // Calculate required_hours
    $requiredHours = $weekdayCount * $hrsPerDayInt;

    return $requiredHours;
}

// Function to calculate total hours rendered during the period
function calculateTotalHoursRendered($newPeriodFrom, $newPeriodTo, $empId, $conn) {
    $startTimestamp = strtotime($newPeriodFrom);
    $endTimestamp = strtotime($newPeriodTo);
    $totalHoursRendered = 0;

    // Calculate total hours rendered for the employee
    $totalHoursRenderedQuery = "SELECT SUM(dailyDuration) AS total_hours_rendered
                                FROM attendance
                                WHERE emp_id = ? AND date BETWEEN ? AND ?";
    $totalHoursRenderedStmt = $conn->prepare($totalHoursRenderedQuery);
    $totalHoursRenderedStmt->bind_param("iss", $empId, $newPeriodFrom, $newPeriodTo);
    $totalHoursRenderedStmt->execute();
    $totalHoursRenderedStmt->bind_result($totalHoursRendered);
    $totalHoursRenderedStmt->fetch();
    $totalHoursRenderedStmt->close();

    return $totalHoursRendered;
}


?>
