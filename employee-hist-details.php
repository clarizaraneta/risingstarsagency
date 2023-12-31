<?php
// Include your database connection file
include('config.php');

// Check if emp_id is set in the URL
if (isset($_GET['emp_id'])) {
    $empId = $_GET['emp_id'];

    // Fetch employee details to display last name and first name
    $employeeQuery = "SELECT lname, fname FROM employee WHERE emp_id = ?";
    $employeeStmt = $conn->prepare($employeeQuery);
    $employeeStmt->bind_param("i", $empId);
    $employeeStmt->execute();
    $employeeResult = $employeeStmt->get_result();
    $employeeRow = $employeeResult->fetch_assoc();

    // Fetch emp_history details for the specified emp_id, ordered by date in descending order
    $query = "SELECT eh.hist_id, eh.emp_id, eh.date, eh.position_id, jp.position_name, jp.salary_rate, eh.status
              FROM emp_history eh
              JOIN job_position jp ON eh.position_id = jp.position_id
              WHERE eh.emp_id = ?
              ORDER BY eh.date DESC";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $empId);
    $stmt->execute();
    $result = $stmt->get_result();
?>

<?php require 'header.php'; ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Employee History Details</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="employee-history.php">Employee History</a></li>
                            <li class="active">Employee History Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Employee History Details</strong>
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#newEntryModal">New</button>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <p style="color: black; font-size: 20px;">Employee Name: <b><?php echo $employeeRow['lname'] . ', ' . $employeeRow['fname']; ?></b></p>
                            <p style="color: black; font-size: 18px;">Employee ID: <b><?php echo $_GET['emp_id']; ?></b></p>
                            <button class="btn btn-primary" onclick="downloadTable()">Download</button>
                        </div>
                    </div>
                    <hr>

                    <div class="card-body">
                        <table id="employeeHistoryTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Position Name</th>
                                    <th>Salary Rate</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Loop through the result set and display data
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>{$row['date']}</td>";
                                    echo "<td>{$row['position_name']}</td>";
                                    echo "<td>{$row['salary_rate']}</td>";
                                    echo "<td>{$row['status']}</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Entry Modal -->
<div class="modal fade" id="newEntryModal" tabindex="-1" role="dialog" aria-labelledby="newEntryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newEntryModalLabel">New Employee History Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="newEntryForm">
                    <!-- Hidden input for emp_id -->
                    <input type="hidden" name="emp_id" value="<?php echo $empId; ?>">

                    <!-- Other form fields for the new entry -->
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>

                    <div class="form-group">
                        <label for="position_id">Position:</label>
                        <select class="form-control" id="position_id" name="position_id" required>
                            <!-- Fetch position names from the job_position table -->
                            <?php
                            $positionQuery = "SELECT position_id, position_name FROM job_position";
                            $positionResult = $conn->query($positionQuery);

                            while ($positionRow = $positionResult->fetch_assoc()) {
                                echo "<option value='{$positionRow['position_id']}'>{$positionRow['position_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Readonly field for salary_rate -->
                    <div class="form-group">
                        <label for="salary_rate">Salary Rate:</label>
                        <input type="text" class="form-control" id="salary_rate" name="salary_rate" readonly>
                    </div>

                    <div class="form-group">
                        <label for="status">Status:</label>
                        <input type="text" class="form-control" id="status" name="status" value="Inactive" readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveNewEntry()">Save</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>

<script>
    // Function to save the new entry using AJAX
    function saveNewEntry() {
        // Serialize form data
        var formData = jQuery('#newEntryForm').serialize();

        // Example: Use AJAX to send form data to the server
        jQuery.post('save-new-entry.php', formData, function(response) {
            console.log(response);
            jQuery('#newEntryModal').modal('hide');
            // Reload the entire page after a successful save
            location.reload(true);
        });
    }
</script>

<script>
    function downloadTable() {
        // Assuming your table has an ID of "employeeHistoryTable"
        var table = document.getElementById('employeeHistoryTable');

        // Convert the table to a downloadable format (e.g., CSV)
        // You can use a library like DataTables' buttons extension or other libraries for more complex scenarios
        // For simplicity, let's create a basic CSV download
        var csvContent = 'data:text/csv;charset=utf-8,';

        // Iterate over rows and cells to build the CSV content
        for (var i = 0; i < table.rows.length; i++) {
            var row = table.rows[i];
            for (var j = 0; j < row.cells.length; j++) {
                csvContent += row.cells[j].innerText + ',';
            }
            csvContent += '\n';
        }

        // Create a link and trigger a click event to download the CSV
        var encodedUri = encodeURI(csvContent);
        var link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', 'employee_history.csv');
        document.body.appendChild(link);
        link.click();
    }
</script>

</body>

</html>

<?php
    // Close the statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect to the employee list page if emp_id is not set
    header("Location: employee-list.php");
    exit();
}
?>
