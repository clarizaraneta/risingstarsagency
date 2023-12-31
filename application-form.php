
<!-- apply.php -->
<?php
// Include your database connection file
require_once('config.php');

// Define variables to store form data
$firstname = $middlename = $lastname = $gender = $email = $contact = $address = $cover_letter = $job_id = $resume_path = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize
    $firstname = isset($_POST['firstName']) ? mysqli_real_escape_string($conn, $_POST['firstName']) : '';
    $middlename = isset($_POST['middleName']) ? mysqli_real_escape_string($conn, $_POST['middleName']) : '';
    $lastname = isset($_POST['lastName']) ? mysqli_real_escape_string($conn, $_POST['lastName']) : '';
    $gender = isset($_POST['gender']) ? mysqli_real_escape_string($conn, $_POST['gender']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
    $contact = isset($_POST['contact']) ? mysqli_real_escape_string($conn, $_POST['contact']) : '';
    $address = isset($_POST['address']) ? mysqli_real_escape_string($conn, $_POST['address']) : '';
    $cover_letter = isset($_POST['cover_Letter']) ? mysqli_real_escape_string($conn, $_POST['cover_Letter']) : '';
    $job_id = isset($_POST['job_id']) ? mysqli_real_escape_string($conn, $_POST['job_id']) : '';
    // Note: You should handle file uploads properly. This is a basic example.
    $resume_path = isset($_POST['resume_path']) ? mysqli_real_escape_string($conn, $_POST['resume_path']) : '';

    // SQL query to insert data into the database
    $sql = "INSERT INTO applicants (firstname, middlename, lastname, gender, email, contact, address, cover_letter, job_id, resume_path, date_apply)
            VALUES ('$firstname', '$middlename', '$lastname', '$gender', '$email', '$contact', '$address', '$cover_letter', '$job_id', '$resume_path', NOW())";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        echo "Application submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    
}
?>
<!-- Rest of your HTML form remains unchanged -->

<!DOCTYPE html>
<html lang="en">

<head>
   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Application Form</title>

   
</head>

<body>
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#applicationModal">
        Apply Now
    </button> -->
   

         <!-- Modal -->
        <!-- <div class="modal fade" id="applicationModal" tabindex="-1" role="dialog" aria-labelledby="applicationModalLabel" aria-hidden="true"> -->
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="applicationModalLabel">Application Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div>
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter your first name">
                            </div>

                            <div class="form-group">
                                <label for="middleName">Middle Name</label>
                                <input type="text" class="form-control" id="middleName" name="middleName" placeholder="Enter your middle name">
                            </div>

                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter your last name">
                            </div>

                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address">
                            </div>

                            <div class="form-group">
                                <label for="contact">Contact Number</label>
                                <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter your contact number">
                            </div>

                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address">
                            </div>

                            <div class="form-group">
                                <label for="job_id">Position Applying For</label>
                                <select class="form-control" id="job_id" name="job_id">
                                    <option value="1">Payroll Specialist</option>
                                    <option value="2">Recruiter</option>
                                    <option value="3">Virtual Assistant</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="resume_path">Resume (PDF only)</label>
                                <input type="file" class="form-control-file" id="resume_path" name="resume_path" accept=".pdf">
                                <span class="error">
                            </div>

                            <div class="form-group">
                                <label for="cover_Letter">Cover Letter</label>
                                <textarea class="form-control" id="cover_Letter" name="cover_Letter" rows="5" placeholder="Write your cover letter"></textarea>
                            </div>
                            <div>
                            <button type="submit" class="btn btn-primary">Submit Application</button>
                            <a class="btn btn-danger" href="job-list.php">Cancel</a>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        <!-- </div> -->

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </body>
</html>
