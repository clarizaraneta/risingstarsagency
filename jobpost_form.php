<?php
// create_job.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    require_once('db_connect.php');

    // Retrieve form data
    $jobTitle = $_POST['jobTitle'];
    $jobDescription = $_POST['jobDescription'];
    $qualification = $_POST['qualification'];
    $salary = $_POST['salary'];
    $personNeed = $_POST['personNeed'];
    $published = $_POST['published'];

    // Validate and sanitize the data (you can add more validation as needed)

    // Insert data into the 'jobs' table
    $sql = "INSERT INTO jobs (job_title, description, qualification, salary, person_need, published) 
            VALUES ('$jobTitle', '$jobDescription', '$qualification', '$salary', '$personNeed', '$published')";

    if ($conn->query($sql) === TRUE) {
        echo "Job post created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Job Post</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/flatly/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h3>Create Job Post</h3>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="mb-3">
            <label for="jobTitle" class="form-label">Job Title</label>
            <input type="text" class="form-control" id="jobTitle" name="jobTitle" required>
        </div>
        <div class="mb-3">
            <label for="jobDescription" class="form-label">Job Description</label>
            <textarea class="form-control" id="jobDescription" name="jobDescription" rows="4" required></textarea>
        </div>
        <!-- insert Qualification -->
        <div class="mb-3">
            <label for="qualification" class="form-label">Qualification</label>
            <textarea class="form-control" id="qualification" name="qualification" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="salary" class="form-label">Salary</label>
            <input type="text" class="form-control" id="salary" name="salary" required>
        </div>
        <!-- position Available -->
        <div class="mb-3">
            <label for="personNeed" class="form-label">Position Available</label>
            <input type="text" class="form-control" id="personNeed" name="personNeed" required>
        </div>
        <div class="mb-3">
            <label for="published" class="form-label">Published</label>
            <select class="form-select" id="published" name="published">
                <option value="1" selected>Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Job Post</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

</body>
</html>
