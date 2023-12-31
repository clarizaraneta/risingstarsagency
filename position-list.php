<?php require 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .expandable-content {
            max-height: 100px;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .expand-button {
            cursor: pointer;
            color: blue;
            text-decoration: underline;
            display: block;
            margin-top: 10px;
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
                            <li class="active">Job Position List</li>
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
                        <strong class="card-title">Job Position List</strong>
                    </div>
                    <div class="card-body">
                    <button type="button" class="btn btn-success mx-auto" data-toggle="modal" data-target="#addPositionModal">
                        Add Job Position
                    </button>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Position Name</th>
                                                <th scope="col">Job Description</th>
                                                <th scope="col">Salary Rate</th>
                                                <th scope="col">Department</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            require_once('config.php');

                                            $sql = "SELECT jp.position_id, jp.position_name, jp.job_description, jp.salary_rate, jd.job_dept
                                                    FROM job_position jp
                                                    LEFT JOIN job_department jd ON jp.dept_id = jd.dept_id
                                                    ORDER BY jp.position_id ASC";

                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row["position_id"] . "</td>";
                                                    echo "<td class='expandable-content'>" . $row["position_name"] . "</td>";
                                                    echo "<td>"; // Open the <td> for "Job Description" column
                                                    // Add a button to toggle the collapse
                                                    echo '<button class="btn btn-link btn-sm" type="button" data-toggle="collapse" data-target="#description' . $row["position_id"] . '" aria-expanded="false" aria-controls="description' . $row["position_id"] . '">';
                                                    echo 'View Description';
                                                    echo '</button>';
                                                    // Add a collapse container for the job description
                                                    echo '<div class="collapse" id="description' . $row["position_id"] . '">';
                                                    echo $row["job_description"];
                                                    echo '</div>';
                                                    echo "</td>"; // Close the <td> for "Job Description" column
                                                    echo "<td>" . $row["salary_rate"] . "</td>";
                                                    echo "<td>" . $row["job_dept"] . "</td>"; // Display the job_dept
                                                    echo "<td>" .
                                                        '<i class="fa fa-edit" style="font-size:20px; cursor: pointer;" title="Edit" data-toggle="modal" data-target="#editPositionModal" data-id="' . $row["position_id"] . '" data-name="' . $row["position_name"] . '" data-description="' . $row["job_description"] . '" data-salary="' . $row["salary_rate"] . '"></i>' .
                                                        '<i class="fa fa-trash-o" style="font-size:20px; cursor: pointer;" title="Delete" data-toggle="modal" data-target="#deletePositionModal" data-id="' . $row["position_id"] . '"></i>' .
                                                        '</td>';
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

                        <!-- Add Job Position Modal -->
                        <div class="modal fade" id="addPositionModal" tabindex="-1" role="dialog" aria-labelledby="addPositionModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addPositionModalLabel">Add Position</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        
                                        <div class="form-group">
                                            <label for="addPositionName">Position Name:</label>
                                            <input type="text" class="form-control" id="addPositionName">
                                        </div>
                                        <div class="form-group">
                                            <label for="addJobDescription">Job Description:</label>
                                            <input type="text" class="form-control" id="addJobDescription">
                                        </div>
                                        <div class="form-group">
                                            <label for="addSalaryRate">Salary Rate:</label>
                                            <input type="text" class="form-control" id="addSalaryRate">
                                        </div>

                                        <div class="form-group">
                                            <label for="addDeptId">Department:</label>
                                            <select class="form-control" id="addDeptId">
                                                <option value="" disabled selected>Select Department</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="confirmAddPosition">Add Position</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Position Modal -->
                        <div class="modal fade" id="editPositionModal" tabindex="-1" role="dialog" aria-labelledby="editPositionModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editPositionModalLabel">Edit Job Position</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Add your form elements for editing a job position here -->
                                        <div class="form-group">
                                            <label for="editPositionName">Position Name:</label>
                                            <input type="text" class="form-control" id="editPositionName">
                                        </div>
                                        <div class="form-group">
                                            <label for="editJobDescription">Job Description:</label>
                                            <textarea class="form-control" id="editJobDescription"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="editSalaryRate">Salary Rate:</label>
                                            <input type="text" class="form-control" id="editSalaryRate">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="editDeptId">Department:</label>
                                            <select class="form-control" id="editDeptId">
                                                <!-- Dropdown options will be populated dynamically using JavaScript -->
                                            </select>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="confirmEditPosition">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Position Modal -->
                        <div class="modal fade" id="deletePositionModal" tabindex="-1" role="dialog" aria-labelledby="deletePositionModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deletePositionModalLabel">Delete Position</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Add your confirmation message for deletion here -->
                                        <p>Are you sure you want to delete this position?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Your custom JavaScript -->
                        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>

                        <script>
                            $(document).ready(function () {
                                var editPositionId;
                                var deletePositionId;

                                // Handle the click event of the "Edit" button in the table
                                $('.fa-edit').click(function () {
                                    editPositionId = $(this).data('id');
                                    var positionName = $(this).data('name');
                                    var jobDescription = $(this).closest('tr').find('td:nth-child(3) .expandable-content').html();
                                    var salaryRate = $(this).closest('tr').find('td:nth-child(4)').text();
                                    var deptId = $(this).closest('tr').find('td:nth-child(5)').data('dept-id'); // Add this line to get department ID

                                    // Update the modal content or perform any other actions based on the position details
                                    $('#editPositionModalLabel').html('Edit Job Position');
                                    $('#editPositionName').val(positionName);
                                    $('#editJobDescription').val(jobDescription);
                                    $('#editSalaryRate').val(salaryRate);
                                    $('#editDeptId').val(deptId);

                                    // Manually update the collapse state after a short delay to ensure proper rendering
                                    setTimeout(function () {
                                        updateCollapseState(editPositionId);
                                    }, 300);

                                    // Fetch department details and populate the dropdown in the Edit modal
                                    $.ajax({
                                        url: 'get-departments.php',
                                        method: 'GET',
                                        dataType: 'json',
                                        success: function (response) {
                                            // Populate the dropdown with department options
                                            var dropdown = $('#editDeptId');
                                            dropdown.empty();
                                            dropdown.append('<option value="" disabled>Select Department</option>');
                                            $.each(response, function (index, department) {
                                                var selected = department.dept_id == deptId ? 'selected' : ''; // Select the current department
                                                dropdown.append('<option value="' + department.dept_id + '" ' + selected + '>' + department.job_dept + '</option>');
                                            });
                                        },
                                        error: function (xhr, status, error) {
                                            // Handle AJAX error
                                            console.error('AJAX error:', status, error);
                                        }
                                    });
                                });



                                // Handle the click event of the "Delete" button in the table
                                $('.fa-trash-o').click(function () {
                                    deletePositionId = $(this).data('id');
                                });

                                // Handle the click event of the "Edit" button in the edit modal
                                $('#confirmEditPosition').click(function () {
                                var newPositionName = $('#editPositionName').val();
                                var newJobDescription = $('#editJobDescription').val();
                                var newSalaryRate = $('#editSalaryRate').val();
                                var newDeptId = $('#editDeptId').val(); // Get the department ID from the hidden input field

                                // Perform an AJAX request to update the job position details on the server
                                $.ajax({
                                    url: 'edit-position-record.php', // Replace with your server-side script for editing
                                    method: 'POST',
                                    data: {
                                        id: editPositionId,
                                        name: newPositionName,
                                        description: newJobDescription,
                                        rate: newSalaryRate,
                                        dept_id: newDeptId 
                                    },
                                    success: function (response) {
                                        if (response.success) {
                                            // Successfully edited on the server
                                            // Update the job position details in the table
                                            location.reload();

                                            // Update the collapse state
                                            updateCollapseState(editPositionId);

                                            // Close the edit modal
                                            $('#editPositionModal').modal('hide');
                                        } else {
                                            // Handle editing failure
                                            console.error('Failed to edit job position.');
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        // Handle AJAX error
                                        console.error('AJAX error:', status, error);
                                    }
                                });
                            });

                            // Function to update the collapse state based on the position ID
                            function updateCollapseState(positionId) {
                                var collapseContainer = $('#description' + positionId);

                                // Manually toggle the collapse state
                                collapseContainer.collapse('toggle');
                            }


                                // Handle the click event of the "Delete" button in the delete modal
                                $('#confirmDelete').click(function () {
                                    // Perform an AJAX request to delete the job position on the server
                                    $.ajax({
                                        url: 'delete-position-record.php', // Replace with your server-side script for deleting
                                        method: 'POST',
                                        data: { id: deletePositionId },
                                        success: function (response) {
                                            if (response.success) {
                                                // Successfully deleted on the server
                                                // Remove the row from the table
                                                $('[data-id="' + deletePositionId + '"]').closest('tr').remove();
                                                // Close the delete modal
                                                $('#deletePositionModal').modal('hide');
                                            } else {
                                                // Handle deletion failure
                                                console.error('Failed to delete job position.');
                                            }
                                        },
                                        error: function (xhr, status, error) {
                                            // Handle AJAX error
                                            console.error('AJAX error:', status, error);
                                        }
                                    });
                                });

                                // Handle the click event of the "Add Job Position" button in the add modal
                                $('#confirmAddPosition').click(function () {
                                    var newPositionName = $('#addPositionName').val();
                                    var newJobDescription = $('#addJobDescription').val();
                                    var newSalaryRate = $('#addSalaryRate').val();

                                    // Get the selected department ID from the dropdown
                                    var selectedDeptId = $('#addDeptId').val();

                                    // Perform an AJAX request to add the new job position on the server
                                    $.ajax({
                                        url: 'add-position-record.php',
                                        method: 'POST',
                                        data: {
                                            name: newPositionName,
                                            description: newJobDescription,
                                            rate: newSalaryRate,
                                            dept_id: selectedDeptId  // Add a comma here
                                        },
                                        success: function (response) {
                                            console.log('Server Response:', response); // Log the entire response
                                            if (response.success) {
                                                // Successfully added on the server
                                                
                                                location.reload();
                                                // Close the add modal
                                                $('#addPositionModal').modal('hide');
                                            } else {
                                                // Handle addition failure
                                                console.error('Failed to add job position:', response.error || 'Unknown error');
                                            }
                                        },
                                        error: function (xhr, status, error) {
                                            // Handle AJAX error
                                            console.error('AJAX error:', status, error);
                                        }
                                    });
                                });
                                
                            });
                        </script>

                        <script>
                            $(document).ready(function () {

                                $.ajax({
                                    url: 'get-departments.php', // Replace with the server-side script to fetch departments
                                    method: 'GET',
                                    dataType: 'json',
                                    success: function (response) {
                                        // Populate the dropdown with department options
                                        var dropdown = $('#addDeptId');
                                        dropdown.empty();
                                        dropdown.append('<option value="" disabled selected>Select Department</option>');
                                        $.each(response, function (index, department) {
                                            dropdown.append('<option value="' + department.dept_id + '">' + department.job_dept + '</option>');
                                        });
                                    },
                                    error: function (xhr, status, error) {
                                        // Handle AJAX error
                                        console.error('AJAX error:', status, error);
                                    }
                                });
                            });
                            </script>

                        <div class="clearfix"></div>

                    </div><!-- /#right-panel -->
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>








