<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Job List</title> -->
    <link rel="stylesheet" href="https://bootswatch.com/5/flatly/bootstrap.min.css">

    <style>
        table {
            text-align: justify;
        }

        .job_title,
        .qualification
        .salary,
        .person_need,
        .published,
        .actions,
        .view-applications {
            text-align: center;
        }

        .qualification {
            max-width: 580px; /* Adjust the maximum width as needed */
            overflow: auto;
        }
    </style>
<!-- </head>
<body> -->

<!-- <div class='container mt-4'>
    ?php echo "<h3>Join Us</h3>"; ?>
</div> -->

<div class='container'>
    <div class="table-responsive"> 
        <table class="table table-striped table-hover">
            <thead>
                <tr class="table-primary">
                    <th scope="col">Job Title</th>
                    <!-- <th scope="col">description</th> -->
                    <th scope="col">Qualification</th>
                    <th scope="col">Salary</th>
                    <th scope="col">Position Available</th>
                    <th scope="col">View Details</th>
                    <th scope="col">Apply</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    require_once('config.php');
                    
                    $sql = "SELECT * FROM jobs WHERE published=1";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["job_title"]. "</td>";
                            echo "<td>" . $row["qualification"]. "</td>";
                            echo "<td>" . $row["salary"]. "</td>";
                            echo "<td>" . $row["person_need"]. "</td>";
                            echo "<td><a href='job-detail.php?job_id=" . $row["job_id"] . "' class='btn btn-warning'>View Details</a></td>";
                            // echo "<td><button class='btn btn-warning'>View Details</button></td>";
                            echo "<td><a href='application-form.php?job_id=" . $row["job_id"] . "' class='btn btn-success'>Apply</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No jobs available</td></tr>";
                    }
                    $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script> -->

<!-- </body>
</html> -->
