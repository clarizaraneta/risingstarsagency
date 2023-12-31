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
                                    <li class="active">Department List</li>
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
                                <strong class="card-title">Department List</strong>
                            </div>
                            <div class="card-body">

                            <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#addModal">
                            Add Department
                            </button>

                            <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Job Department</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                require_once('config.php');
                                                
                                                $sql = "SELECT * FROM job_department ORDER by dept_id ASC";
                                                $result = $conn->query($sql);
                                                
                                                if ($result->num_rows > 0) {
                                                    // output data of each row
                                                    while($row = $result->fetch_assoc()) {
                                                        echo "<tr>";
                                                        echo "<td>" . $row["dept_id"]. "</td>";
                                                        echo "<td>" . $row["job_dept"]. "</td>";
                                                        echo "<td> 
                                                                <i class='fa fa-edit' style='font-size:20px; cursor: pointer;' title='Edit' data-toggle='modal' data-target='#editModal' data-id='".$row["dept_id"]."' data-name='".$row["job_dept"]."'></i>
                                                                <i class='fa fa-trash-o' style='font-size:20px; cursor: pointer;' title='Delete' data-toggle='modal' data-target='#deleteModal' data-id='".$row["dept_id"]."'></i>
                                                            </td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='3'>0 results</td></tr>";
                                                }
                                                $conn->close();
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Department</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Add your form elements for editing here -->
                                        <div class="form-group">
                                            <label for="editDepartmentName">Department Name:</label>
                                            <input type="text" class="form-control" id="editDepartmentName">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="confirmEdit">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Delete Department</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Add your confirmation message for deletion here -->
                                        <p>Are you sure you want to delete this department?</p>
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
                                var editId;
                                var deleteId;

                                // Handle the click event of the "Edit" button in the table
                                $('.fa-edit').click(function () {
                                    editId = $(this).data('id');
                                    var departmentName = $(this).data('name');
                                    // Update the modal content or perform any other actions based on the department details
                                    $('#editModalLabel').html('Edit Department');
                                    $('#editDepartmentName').val(departmentName);
                                });

                            // Handle the click event of the "Delete" button in the table
                            $('.fa-trash-o').click(function() {
                                deleteId = $(this).data('id');
                            });

                            // Handle the click event of the "Edit" button in the edit modal
                            $('#confirmEdit').click(function() {
                                var newDepartmentName = $('#editDepartmentName').val();
                                // Perform an AJAX request to update the department name on the server
                                $.ajax({
                                    url: 'edit-dept-record.php', // Replace with your server-side script for editing
                                    method: 'POST',
                                    data: { id: editId, name: newDepartmentName },
                                    success: function(response) {
                                        if (response.success) {
                                            // Successfully edited on the server
                                            // Update the department name in the table
                                            $('[data-id="' + editId + '"]').closest('tr').find('td:nth-child(2)').html(newDepartmentName);
                                            // Close the edit modal
                                            $('#editModal').modal('hide');
                                        } else {
                                            // Handle editing failure
                                            console.error('Failed to edit record.');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        // Handle AJAX error
                                        console.error('AJAX error:', status, error);
                                    }
                                });
                            });

                            // Handle the click event of the "Delete" button in the delete modal
                            $('#confirmDelete').click(function() {
                                // Perform an AJAX request to delete the record on the server
                                $.ajax({
                                    url: 'delete-dept-record.php', // Replace with your server-side script for deleting
                                    method: 'POST',
                                    data: { id: deleteId },
                                    success: function(response) {
                                        if (response.success) {
                                            // Successfully deleted on the server
                                            // Remove the row from the table
                                            $('[data-id="' + deleteId + '"]').closest('tr').remove();
                                            // Close the delete modal
                                            $('#deleteModal').modal('hide');
                                        } else {
                                            // Handle deletion failure
                                            console.error('Failed to delete record.');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        // Handle AJAX error
                                        console.error('AJAX error:', status, error);
                                    }
                                });
                            });

                            // Handle the shown.bs.modal event for all modals
                            $('.modal').on('shown.bs.modal', function () {
                                // Remove the modal backdrop
                                $('.modal-backdrop').remove();
                            });

                            // Handle the click event of the "Add Department" button in the add modal
                            $('#confirmAdd').click(function() {
                                var newDepartmentName = $('#addDepartmentName').val();
                                // Perform an AJAX request to add the new department on the server
                                $.ajax({
                                    url: 'add-dept-record.php', // Replace with your server-side script for adding
                                    method: 'POST',
                                    data: { name: newDepartmentName },
                                    success: function(response) {
                                        if (response.success) {
                                            // Successfully added on the server
                                            // Add the new row to the table
                                            var newRow = '<tr><td>' + response.id + '</td><td>' + newDepartmentName + '</td><td>' +
                                                '<i class="fa fa-edit" style="font-size:20px; cursor: pointer;" title="Edit" data-toggle="modal" data-target="#editModal" data-id="' + response.id + '" data-name="' + newDepartmentName + '"></i>' +
                                                '<i class="fa fa-trash-o" style="font-size:20px; cursor: pointer;" title="Delete" data-toggle="modal" data-target="#deleteModal" data-id="' + response.id + '"></i></td></tr>';
                                            $('table tbody').append(newRow);
                                            // Close the add modal
                                            $('#addModal').modal('hide');
                                        } else {
                                            // Handle addition failure
                                            console.error('Failed to add department.');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        // Handle AJAX error
                                        console.error('AJAX error:', status, error);
                                    }
                                });
                            }); 
                        });
                    </script>

                    <!-- Add Department Modal -->
                    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addModalLabel">Add Department</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Add your form elements for adding a new department here -->
                                    <div class="form-group">
                                        <label for="addDepartmentName">Department Name:</label>
                                        <input type="text" class="form-control" id="addDepartmentName">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="confirmAdd">Add Department</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="clearfix"></div>

                    
</div><!-- /#right-panel -->

</body>
</html>