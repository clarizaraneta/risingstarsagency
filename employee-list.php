<?php require 'header.php'; ?>
<!doctype html>
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
                                    <li class="active">Employee List</li>
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
                                <strong class="card-title">Employee List</strong>
                                
                                    <!-- Add New Employee Button -->
                                    <a href="add-employee.php" class="btn btn-success btn-sm float-right">
                                        Add New Employee
                                    </a>
                                </div>

                            </div>
                            <div class="card-body">
                                
                                <table id="employee" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Department</th>
                                            <th>Employee Type</th>
                                            <th width="6%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Update Employee Modal -->
                    <div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="employeeModalLabel">Employee Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Employee Form -->
                                    <form id="employeeForm" enctype="multipart/form-data">
                                        <input type="hidden" id="empId" name="empId" value="0">
                                        <div class="form-group">
                                            <label for="lname">Last Name</label>
                                            <input type="text" class="form-control" id="lname" name="lname" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="fname">First Name</label>
                                            <input type="text" class="form-control" id="fname" name="fname" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="gender">Gender</label>
                                            <select class="form-control" id="gender" name="gender" required>
                                                <option value="female">Female</option>
                                                <option value="male">Male</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="birthdate">Birthdate</label>
                                            <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="contact_no">Contact Number</label>
                                            <input type="text" class="form-control" id="contact_no" name="contact_no" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="home_address">Home Address</label>
                                            <textarea class="form-control" id="home_address" name="home_address" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="profile_img">Profile Image</label>
                                            <input type="file" class="form-control-file" id="profile_img" name="profile_img" accept="image/jpeg, image/png">
                                        </div>
                                        <div class="form-group">
                                            <label for="start_date">Start Date</label>
                                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="emp_type">Employee Type</label>
                                            <select class="form-control" id="emp_type" name="emp_type" required>
                                                <option value="full-time">Full-time</option>
                                                <option value="part-time">Part-time</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="job_dept">Department Name</label>
                                            <select class="form-control" id="job_dept" name="job_dept" required>
                                                <!-- Departments will be fetched and populated here -->
                                            </select>
                                        </div>
                                                                                
                                        <div class="form-group">
                                            <label for="position_name">Position Name</label>
                                            <select class="form-control" id="position_name" name="position_name" required>
                                                <option value="">Select Position</option>
                                                <!-- Positions will be dynamically populated based on the selected department -->
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </form>
                                </div>
                            </div>
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
                        Copyright &copy; 2018 Ela Admin
                    </div>
                    <div class="col-sm-6 text-right">
                        Designed by <a href="https://colorlib.com">Colorlib</a>
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

    <script src="DataTables\jQuery-3.7.0\jquery-3.7.0.min.js"></script>
    <script src="DataTables\DataTables-1.13.8\js\jquery.dataTables.min.js"></script>


    <script src="assets/js/lib/data-table/datatables.min.js"></script>
    <script src="assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
    <script src="assets/js/lib/data-table/dataTables.buttons.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
    <script src="assets/js/lib/data-table/jszip.min.js"></script>
    <script src="assets/js/lib/data-table/vfs_fonts.js"></script>
    <script src="assets/js/lib/data-table/buttons.html5.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.print.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.colVis.min.js"></script>
    <script src="assets/js/init/datatables-init.js"></script>


    <!-- <script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
      } );
  </script> -->

  <script>
        $(document).ready(function () {
            $('#employee').DataTable({
                "ajax": "fetch-data.php",
                "columns": [
                    { "data": "emp_id" },
                    { "data": "profile_img" },
                    {
                        "data": null,
                        "render": function (data, type, row) {
                            return row.lname + ', ' + row.fname;
                        }
                    },
                    { "data": "position_name" },
                    { "data": "job_dept" },
                    { "data": "emp_type" },
                    {
                        "data": null,
                        "render": function (data, type, row) {
                            return '<button class="btn btn-warning btn-sm update-btn" data-toggle="modal" data-target="#employeeModal" data-id="' + row.emp_id + '">Update</button>' +
                                '<button class="btn btn-danger btn-sm delete-btn" data-toggle="modal" data-target="#deleteModal" data-id="' + row.emp_id + '">Delete</button>';
                        }
                    }
                ]
            });


            
            // Fetch departments on page load
            fetchDepartments();

                // Fetch positions when a department is selected
                $('#job_dept').on('change', function(){
                    var deptId = $(this).val();
                    fetchPositions(deptId);
                });

                // Function to fetch departments
                function fetchDepartments() {
                    $.ajax({
                        url: 'get-department-list.php',
                        success: function(data) {
                            $('#job_dept').html(data);
                        }
                    });
                }

                // Function to fetch positions based on the selected department
                function fetchPositions(deptId) {
                    console.log("Fetching positions for department:", deptId); // Confirm this function is called
                    $.ajax({
                        type: 'POST',
                        url: 'get-position-names.php',
                        data: { dept_id: deptId },
                        success: function(data) {
                            console.log("Positions data received:", data); // Check the received data
                            $('#position_name').html(data);
                        },
                        error: function(xhr, status, error) {
                            console.error("Error in fetching positions:", error);
                        }
                    });
                }

            // Handle form submission
            $('#employeeForm').on('submit', function(e) {
                e.preventDefault();

                // Use FormData to include the file inputs
                var formData = new FormData(this);

                // AJAX request to server-side script
                $.ajax({
                    type: 'POST',
                    url: 'update-employee.php', // URL to your update script
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Handle success (You might want to parse JSON response)
                        alert("Employee updated successfully");
                        // Reload DataTable or specific part of your page
                        $('#employee').DataTable().ajax.reload();
                    },
                    error: function() {
                        alert("Error updating employee");
                    }
                });
            });

            // Update button click handler
            $('#employee').on('click', '.update-btn', function () {
                var empId = $(this).data('id');

                // Fetch employee details via AJAX
                $.ajax({
                    type: 'POST',
                    url: 'fetch-employee-details.php',
                    data: { emp_id: empId },
                    dataType: 'json',
                    success: function (response) {
                        // Populate the form fields in the modal
                        // Populate the form fields in the modal
                        $('#empId').val(response.emp_id); // Assuming you have a hidden field for empId
                        $('#lname').val(response.lname);
                        $('#fname').val(response.fname);
                        $('#gender').val(response.gender); // Ensure the gender values in the database match the option values
                        $('#birthdate').val(response.birthdate);
                        $('#contact_no').val(response.contact_no);
                        $('#email').val(response.email);
                        $('#home_address').val(response.home_address);
                        $('#start_date').val(response.start_date);
                        // For the file inputs like profile_img and identity, you cannot set their values due to security reasons
                        $('#emp_type').val(response.emp_type);

                        // Select dropdowns for job_dept and position_name
                        // Note: Ensure these dropdowns are populated with options having values corresponding to those in the database
                        
                        $('#position_name').val(response.position_name);

                        // Show the modal
                        $('#employeeModal').modal('show');
                    },
                    error: function (error) {
                        console.error('Error fetching employee details:', error);
                    }
                });
            });


            // Delete employee event listener
            $('#employee').on('click', '.delete-btn', function () {
                var empId = $(this).data('id');
                if (confirm("Are you sure you want to delete this employee?")) {
                    deleteEmployee(empId);
                }
            });

        // Function to delete an employee
            function deleteEmployee(empId) {
                $.ajax({
                    url: "delete-employee.php",
                    method: "POST",
                    data: { emp_id: empId },
                    success: function (response) {
                        // Check if the response has a 'message' property and use it
                        if(response.message) {
                            alert(response.message);
                        } else {
                            alert('Employee deleted successfully.');
                        }
                        // Reload the DataTable
                        $('#employee').DataTable().ajax.reload(null, false);
                    },
                    error: function (error) {
                        console.error('Error:', error);
                        alert('Error occurred while deleting employee.');
                    }
                });
            }





        });
    </script>





</body>

</html>
