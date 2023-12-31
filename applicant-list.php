<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "capstone";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getApplicantList($conn)
{
    $sql = "SELECT app_id, CONCAT(lastname, ', ', firstname, ' ', middlename) AS full_name, gender, email, contact, address, cover_letter, resume_path, date_apply, process_id
            FROM applicants";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    } else {
        return [];
    }
}

$applicantList = getApplicantList($conn);

// Process status update if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $app_id = isset($_POST['app_id']) ? intval($_POST['app_id']) : 0;
    $status = isset($_POST['status']) ? intval($_POST['status']) : 0;

    // Update the applicant status in the database
    $updateSql = "UPDATE applicants SET process_id = ? WHERE app_id = ?";
    $updateStmt = $conn->prepare($updateSql);

    if ($updateStmt) {
        $updateStmt->bind_param("ii", $status, $app_id);
        $updateStmt->execute();
    }
}

$conn->close();
?>



<?php require 'header.php'; ?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+WywlF1AZ5e/aIoByw5JvoMgMBC68EZ6Q"
    crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/slate/bootstrap.min.css"> -->
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
                            <li class="active">Applicant List</li>
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
                        <strong class="card-title">Applicant List</strong>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                        <table id="applicantlist" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Applicant ID</th>
                                <th>Full Name</th>
                                <th>Gender</th>
                                <th>Email Address</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th>Letter</th>
                                <th>Resume</th>
                                <th>Date Apply</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($applicantList as $applicant): ?>
                                <tr>
                                    <td><?php echo $applicant['app_id']; ?></td>
                                    <td><?php echo $applicant['full_name']; ?></td>
                                    <td><?php echo $applicant['gender']; ?></td>
                                    <td><?php echo $applicant['email']; ?></td>
                                    <td><?php echo $applicant['contact']; ?></td>
                                    <td><?php echo $applicant['address']; ?></td>
                                    <td><?php echo $applicant['cover_letter']; ?></td>
                                    <td><?php echo $applicant['resume_path']; ?></td>
                                    <td><?php echo $applicant['date_apply']; ?></td>
                                    <td>
                                        <?php
                                        $status = getStatus($applicant['process_id']);
                                        echo '<span class="badge badge-' . getStatusBadgeClass($status) . '">' . $status . '</span>';
                                        ?>
                                    </td>
                                    <td>
                                        <!-- Display a button to trigger the modal for status update -->
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#statusModal<?php echo $applicant['app_id']; ?>">
                                            Update Status
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal for status update -->
                                <div class="modal fade" id="statusModal<?php echo $applicant['app_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="statusModalLabel">Update Status</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Add a form for status update here -->
                                                <form method="post" action="">
                                                    <input type="hidden" name="app_id" value="<?php echo $applicant['app_id']; ?>">
                                                    <div class="form-group">
                                                        <label for="status">Select Status:</label>
                                                        <select class="form-control" id="status" name="status">
                                                            <option value="1" <?php echo ($applicant['process_id'] == 1) ? 'selected' : ''; ?>>Accepted</option>
                                                            <option value="2" <?php echo ($applicant['process_id'] == 2) ? 'selected' : ''; ?>>Pending</option>
                                                            <option value="3" <?php echo ($applicant['process_id'] == 3) ? 'selected' : ''; ?>>Rejected</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-zO5nUqIaKaGtKaQeaACtyDodL9HlMz7ZiCJ1jBLq5oNOYg3JZNohS9BpxHtbvTlg"
    crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+WywlF1AZ5e/aIoByw5JvoMgMBC68EZ6Q"
    crossorigin="anonymous"></script>
</body>
</html>

<?php
function getStatus($processId)
{
    switch ($processId) {
        case 1:
            return 'Accepted';
        case 2:
            return 'Pending';
        case 3:
            return 'Rejected';
        default:
            return 'Unknown';
    }
}

function getStatusBadgeClass($status)
{
    switch ($status) {
        case 'Accepted':
            return 'success';
        case 'Pending':
            return 'warning';
        case 'Rejected':
            return 'danger';
        default:
            return 'secondary';
    }
}
?>


<style>
    #applicantlist {
        width: 100%; /* This ensures the table takes full width of its container */
        max-width: 100%; /* This prevents the table from exceeding the width of its container */
    }
</style>
