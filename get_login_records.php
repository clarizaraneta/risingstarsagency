<!DOCTYPE html>
<html>
<head>
<style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<!-- <form id="dateForm" method="get" action="">
    <label for="month">Select Month:</label>
    <select id="month" name="month">
        //<?php
        // Create options for months (1 to 12)
        // for ($i = 1; $i <= 12; $i++) {
        //     echo "<option value=\"$i\">".date("F", mktime(0, 0, 0, $i, 10))."</option>";
        // }
        // ?>
    </select>

    <label for="year">Select Year:</label>
    <select id="year" name="year">
        <?php
        // Get the current year and generate options for years (from 2020 to 2030, change range as needed)
        // $currentYear = date("Y");
        // for ($i = 2020; $i <= 2030; $i++) {
        //     echo "<option value=\"$i\">$i</option>";
        // }
        // ?>
    </select>
</form> -->

<script>
    // JavaScript code for automatic form submission on dropdown change
    const monthSelect = document.getElementById('month');
    const yearSelect = document.getElementById('year');

    monthSelect.addEventListener('change', () => {
        document.getElementById('dateForm').submit();
    });

    yearSelect.addEventListener('change', () => {
        document.getElementById('dateForm').submit();
    });
</script>

<?php
require_once('config.php');

// Check if emp_id exists in the query parameters
if (isset($_GET['emp_id'])) {
    $emp_id = $_GET['emp_id'];

    // Check if month and year are set, otherwise use current month and year
    if (isset($_GET['month'], $_GET['year'])) {
        $selectedMonth = $_GET['month'];
        $selectedYear = $_GET['year'];
    } else {
        // If not set, default to current month and year
        $selectedMonth = date("n");
        $selectedYear = date("Y");
    }

    // Fetch the user's login records based on selected or default month and year
    $query = "SELECT DATE(in_time) AS login_date, in_time, out_time, TIME_FORMAT(TIMEDIFF(out_time, in_time), '%H:%i:%s') AS daily_duration FROM attendance WHERE emp_id = ? AND MONTH(in_time) = ? AND YEAR(in_time) = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param('iii', $emp_id, $selectedMonth, $selectedYear);
        $stmt->execute();
        $result = $stmt->get_result();

        // Display the user's login records in a formatted HTML table
        echo "<table>";
        echo "<tr><th>Date</th><th>Login Time</th><th>Logout Time</th><th>Daily Duration (Time Only)</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['login_date']}</td><td>{$row['in_time']}</td><td>{$row['out_time']}</td><td>{$row['daily_duration']}</td></tr>";
        }
        echo "</table>";

        $stmt->close();
    } else {
        echo "Prepare statement failed: " . $conn->error;
    }
} else {
    echo "No emp_id provided";
}

$conn->close();
?>

</body>
</html>