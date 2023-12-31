
<?php require 'header.php'; ?>
<!doctype html>
<head> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
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
                                    <li><a href="employee-list.php">Employee List</a></li>
                                    <li class="active">Add New Employee</li>
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
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Add New Employee</strong> 
                    </div>
                    <div class="card-body card-block">
                        <!-- <form id="employeeForm" method="post" enctype="multipart/form-data" class="form-horizontal"> -->
                        <form id="employeeForm" onsubmit="return false;" method="post" enctype="multipart/form-data" class="form-horizontal">

                            <!-- Name fields -->
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="lname" class=" form-control-label">Last Name</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="lname" name="lname" placeholder="Last Name" class="form-control"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="fname" class=" form-control-label">First Name</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="fname" name="fname" placeholder="First Name" class="form-control"></div>
                            </div>

                            <!-- Gender -->
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="gender" class=" form-control-label">Gender</label></div>
                                <div class="col-12 col-md-9">
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="female">Female</option>
                                        <option value="male">Male</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Birthdate -->
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="birthdate" class=" form-control-label">Birthdate</label></div>
                                <div class="col-12 col-md-9"><input type="date" id="birthdate" name="birthdate" class="form-control"></div>
                            </div>

                            <!-- Contact, Address -->
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="contact_no" class=" form-control-label">Contact Number</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="contact_no" name="contact_no" placeholder="Contact Number" class="form-control"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="home_address" class=" form-control-label">Home Address</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="home_address" name="home_address" placeholder="Home Address" class="form-control"></div>
                            </div>

                            <!-- File inputs for profile_img and identity -->
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="profile_img" class=" form-control-label">Profile Image</label></div>
                                <div class="col-12 col-md-9"><input type="file" id="profile_img" name="profile_img" class="form-control-file"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="identity" class=" form-control-label">Identity Document</label></div>
                                <div class="col-12 col-md-9"><input type="file" id="identity" name="identity" class="form-control-file"></div>
                            </div>

                            <!-- Email & Password -->
                            <!-- ... existing email and password fields ... -->
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="email" class=" form-control-label">Email Input</label></div>
                                <div class="col-12 col-md-9"><input type="email" id="email" name="email" placeholder="Enter Email" class="form-control"><small class="help-block form-text">Please enter your email</small></div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="password" class=" form-control-label">Password</label></div>
                                <div class="col-12 col-md-9"><input type="password" id="password" name="password" placeholder="Password" class="form-control" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACIUlEQVQ4EX2TOYhTURSG87IMihDsjGghBhFBmHFDHLWwSqcikk4RRKJgk0KL7C8bMpWpZtIqNkEUl1ZCgs0wOo0SxiLMDApWlgOPrH7/5b2QkYwX7jvn/uc//zl3edZ4PPbNGvF4fC4ajR5VrNvt/mo0Gr1ZPOtfgWw2e9Lv9+chX7cs64CS4Oxg3o9GI7tUKv0Q5o1dAiTfCgQCLwnOkfQOu+oSLyJ2A783HA7vIPLGxX0TgVwud4HKn0nc7Pf7N6vV6oZHkkX8FPG3uMfgXC0Wi2vCg/poUKGGcagQI3k7k8mcp5slcGswGDwpl8tfwGJg3xB6Dvey8vz6oH4C3iXcFYjbwiDeo1KafafkC3NjK7iL5ESFGQEUF7Sg+ifZdDp9GnMF/KGmfBdT2HCwZ7TwtrBPC7rQaav6Iv48rqZwg+F+p8hOMBj0IbxfMdMBrW5pAVGV/ztINByENkU0t5BIJEKRSOQ3Aj+Z57iFs1R5NK3EQS6HQqF1zmQdzpFWq3W42WwOTAf1er1PF2USFlC+qxMvFAr3HcexWX+QX6lUvsKpkTyPSEXJkw6MQ4S38Ljdbi8rmM/nY+CvgNcQqdH6U/xrYK9t244jZv6ByUOSiDdIfgBZ12U6dHEHu9TpdIr8F0OP692CtzaW/a6y3y0Wx5kbFHvGuXzkgf0xhKnPzA4UTyaTB8Ph8AvcHi3fnsrZ7Wore02YViqVOrRXXPhfqP8j6MYlawoAAAAASUVORK5CYII=&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;"><small class="help-block form-text">Please enter a complex password</small></div>
                            </div>

                            <!-- Additional Fields -->
                            <!-- ... similar structure for start_date, emp_type, hrs_per_day, position_id, role ... -->
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="start_date" class=" form-control-label">Start Date</label></div>
                                <div class="col-12 col-md-9"><input type="date" id="start_date" name="start_date" class="form-control"></div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="emp_type" class=" form-control-label">Employee Type</label></div>
                                <div class="col-12 col-md-9">
                                    <select name="emp_type" id="emp_type" class="form-control">
                                        <option value="full-time">Full-time</option>
                                        <option value="part-time">Part-time</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="position_id" class=" form-control-label">Position</label></div>
                                <div class="col-12 col-md-9">
                                    <select name="position_id" id="position_id" class="form-control">
                                        <?php
                                        // Assuming you have a database connection named $conn
                                        include('config.php'); // Include your database connection file if necessary

                                        // Fetch position names from the database
                                        $sql = "SELECT * FROM job_position";
                                        $result = $conn->query($sql);

                                        // Check if there are rows in the result
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . $row['position_id'] . '">' . $row['position_name'] . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">No positions available</option>';
                                        }

                                        // Close the database connection
                                        $conn->close();
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="role" class=" form-control-label">Access Role</label></div>
                                <div class="col-12 col-md-9">
                                    <select name="role" id="role" class="form-control">
                                        <option value="emp">Employee</option>
                                        <option value="hr">HR</option>
                                        <option value="payroll">Payroll</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-dot-circle-o"></i> Submit
                                </button>
                                <button type="reset" class="btn btn-danger btn-sm">
                                    <i class="fa fa-ban"></i> Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- .animated -->
    </div><!-- .content -->

    <div class="clearfix"></div>

    <footer class="site-footer">
        <div class="footer-inner bg-white">
            <div class="row">
                <div class="col-sm-6">
                    Copyright &copy; Rising Stars Agency
                </div>
                <div class="col-sm-6 text-right">
                    
                </div>
            </div>
        </div>
    </footer>

</div><!-- /#right-panel -->

<!-- Right Panel -->

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
<script src="assets/js/main.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#employeeForm').on('submit', function(e) {
        e.preventDefault();

        // Check if form is valid
        if (!validateForm()) {
            alert('Please fill out all required fields.');
            return; // Stop the function if validation fails
        }

        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: 'add-employee-data.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                    alert(response.message);
                    window.location.href = "employee-list.php";
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('An error occurred while submitting the form.');
            }
        });
    });
});

function validateForm() {
    var requiredFields = ['lname', 'fname', 'gender', 'birthdate', 'contact_no', 'home_address', 'email', 'password', 'start_date', 'emp_type', 'position_id', 'role'];
    for (var i = 0; i < requiredFields.length; i++) {
        var field = document.getElementById(requiredFields[i]);
        if (field.value === '' || field.value === null) {
            field.style.borderColor = 'red';
            return false;
        } else {
            field.style.borderColor = '';
        }
    }
    return true;
}
</script>



</body>
</html>
