<?php require 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jobs Posting</title>
    <!-- <link rel="stylesheet" href="https://bootswatch.com/5/flatly/bootstrap.min.css"> -->
    <style>
        table {
            text-align: justify;
        }

        .job_title,
        .salary,
        .published,
        .actions,
        .view-applications {
            text-align: center;
        }

        .job-description {
            max-width: 580px; /* Adjust the maximum width as needed */
            overflow: auto;
        }
    </style>
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
                            <li class="active">Job Post</li>
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
                        <strong class="card-title">Job Posting</strong>
                        <div class="col-md-12 mb-3 text-right">
                        

                            <a href="jobpost_form.php" class="btn btn-success btn-sm float-right">
                                Create New Job Post
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="jobpost" class="table table-striped table-bordered">
                            <thead>
    <!-- <div class="table-responsive">
        <table class="table table-striped table-hover"> -->

                            <tr class="table-primary">
                                <th scope="row" class="job-title">Job Title</th>
                                <td class="job-description">Descriptions</td>
                                <td class="salary-rate">Salary Rate</td>
                                <td class="person_need">Person Needed</td>
                                <td class="status">Status</td>
                                <td class="actions">Actions</td>
                                <td class="view-applications">View Applications</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            require_once('config.php');
                            
                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                // Check if the Post or Unpost button is clicked
                                if (isset($_POST['postJob'])) {
                                    $jobId = $_POST['jobId'];
                                    $updateSql = "UPDATE jobs SET published = 1 WHERE job_id = $jobId";
                                    $conn->query($updateSql);
                                } elseif (isset($_POST['unpostJob'])) {
                                    $jobId = $_POST['jobId'];
                                    $updateSql = "UPDATE jobs SET published = 0 WHERE job_id = $jobId";
                                    $conn->query($updateSql);
                                }
                            }
                            
                            $sql = "SELECT * FROM jobs";
                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td class='job-title'>" . $row["job_title"]. "</td>";
                                    echo "<td class='job-description'>" . $row["description"]. "</td>";
                                    echo "<td class='salary-rate'>" . $row["salary"]. "</td>";
                                    echo "<td class='person_need'>" . $row["person_need"]. "</td>";
                                    
                                    // Published status
                                    $statusBadge = ($row["published"] == 0) ? 'badge bg-dark' : 'badge bg-success';
                                    echo "<td class='status'><span class='$statusBadge'>" . ($row["published"] == 0 ? 'Not Posted' : 'Published') . "</span></td>";
                                    
                                    echo "<td class='actions'>";
                                    if ($row["published"] == 0) {
                                        echo "<form method='post' action=''>";
                                        echo "<input type='hidden' name='jobId' value='" . $row["job_id"] . "'>";
                                        echo "<button type='submit' class='btn btn-success' name='postJob'>Post</button>";
                                        echo "</form>";
                                    } else {
                                        echo "<form method='post' action=''>";
                                        echo "<input type='hidden' name='jobId' value='" . $row["job_id"] . "'>";
                                        echo "<button type='submit' class='btn btn-danger' name='unpostJob'>Unpost</button>";
                                        echo "</form>";
                                    }
                                    echo "</td>";

                                    echo "<td class='view-applications'><a href='".$row["job_id"]."' class='btn btn-info'>View Applicants</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>0 results</td></tr>";
                            }
                            $conn->close();
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

</body>
</html>
