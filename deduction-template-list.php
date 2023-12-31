<?php require 'header.php'; ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deduction Template List</title>
    <!-- Add your additional head content here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <!-- Add any content for the left section of the header if needed -->
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li class="active">Deduction Template List</li>
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
                        <strong class="card-title">Deduction Template List</strong>

                        <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#addDeductionTemplateModal">
                        Add Deduction Template
                        </button>

                    </div>
                    <div class="card-body">

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Deduction Type</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Percentage Amount %</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once('config.php');

                                            $sql = "SELECT * FROM deduction_template ORDER by dedtype_id ASC";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row["dedtype_id"] . "</td>";
                                                    echo "<td>" . $row["deduction_type"] . "</td>";
                                                    echo "<td>" . $row["amount"] . "</td>";
                                                    echo "<td>" . $row["percentage_amount"] . "</td>";
                                                    echo "<td>" .
                                                        '<i class="fa fa-edit" style="font-size:20px; cursor: pointer;" title="Edit" data-toggle="modal" data-target="#editDeductionModal" data-id="' . $row["dedtype_id"] . '" data-type="' . $row["deduction_type"] . '" data-amount="' . $row["amount"] . '" data-percentage="' . $row["percentage_amount"] . '"></i>' .
                                                        '<i class="fa fa-trash-o" style="font-size:20px; cursor: pointer;" title="Delete" data-toggle="modal" data-target="#deleteDeductionModal" data-id="' . $row["dedtype_id"] . '"></i>' .
                                                        '</td>';
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='5'>0 results</td></tr>";
                                            }
                                            $conn->close();
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Add Deduction Template Modal -->
                        <div class="modal fade" id="addDeductionTemplateModal" tabindex="-1" role="dialog" aria-labelledby="addDeductionTemplateModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addDeductionTemplateModalLabel">Add Deduction Template</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="addDeductionForm">
                                            <div class="form-group">
                                                <label for="addDeductionType">Deduction Type:</label>
                                                <input type="text" class="form-control" id="addDeductionType">
                                            </div>
                                            <div class="form-group">
                                                <label for="addDeductionValueType">Value Type:</label>
                                                <select class="form-control" id="addDeductionValueType">
                                                    <option value="amount">Amount</option>
                                                    <option value="percentage">Percentage Amount</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="addDeductionValue">Value:</label>
                                                <input type="text" class="form-control" id="addDeductionValue">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="confirmAddDeductionTemplate">Add Deduction Template</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Edit Deduction Template Modal -->
                        <div class="modal fade" id="editDeductionModal" tabindex="-1" role="dialog" aria-labelledby="editDeductionModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editDeductionModalLabel">Edit Deduction Template</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editDeductionForm">
                                            <div class="form-group">
                                                <label for="editDeductionType">Deduction Type:</label>
                                                <input type="text" class="form-control" id="editDeductionType">
                                            </div>
                                            <div class="form-group">
                                                <label for="editDeductionValueType">Value Type:</label>
                                                <select class="form-control" id="editDeductionValueType">
                                                    <option value="amount">Amount</option>
                                                    <option value="percentage">Percentage Amount</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="editDeductionValue">Value:</label>
                                                <input type="text" class="form-control" id="editDeductionValue">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="confirmEditDeductionTemplate">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Delete Deduction Template Modal -->
                        <div class="modal fade" id="deleteDeductionModal" tabindex="-1" role="dialog" aria-labelledby="deleteDeductionModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteDeductionModalLabel">Delete Deduction Template</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Add your confirmation message for deletion here -->
                                        <p>Are you sure you want to delete this deduction template?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-danger" id="confirmDeleteDeduction">Delete</button>
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
                                var editDeductionId;
                                var deleteDeductionId;

                                // Handle the click event of the "Edit" button in the table
                                $('.fa-edit').click(function () {
                                    editDeductionId = $(this).data('id');
                                    var deductionType = $(this).data('type');
                                    var amount = $(this).data('amount');
                                    var percentageAmount = $(this).data('percentage');

                                    // Update the modal content or perform any other actions based on the deduction details
                                    $('#editDeductionModalLabel').html('Edit Deduction Template');

                                    // Update the input fields in the edit modal with existing details
                                    $('#editDeductionType').val(deductionType);
                                    $('#editDeductionValueType').val(amount > 0 ? 'amount' : 'percentage').change();
                                    $('#editDeductionValue').val(amount > 0 ? amount : percentageAmount);

                                    // Show the modal
                                    $('#editDeductionModal').modal('show');
                                });

                                // Handle the click event of the "Save Changes" button in the edit modal
                                $('#confirmEditDeductionTemplate').click(function () {
                                    // Retrieve values from the form fields
                                    var editedDeductionType = $('#editDeductionType').val();
                                    var editedDeductionValueType = $('#editDeductionValueType').val();
                                    var editedDeductionValue = $('#editDeductionValue').val();

                                    // Perform AJAX request to update data in the database
                                    $.ajax({
                                        url: 'update-deduction-record.php',
                                        method: 'POST',
                                        data: {
                                            id: editDeductionId,
                                            type: editedDeductionType,
                                            valueType: editedDeductionValueType,
                                            value: editedDeductionValue
                                        },
                                        success: function (response) {
                                            if (response.success) {
                                                // Successfully updated in the database
                                                // Update the data in the table dynamically
                                                $('[data-id="' + editDeductionId + '"]').data('type', editedDeductionType);
                                                // Update other relevant data attributes as needed
                                            } else {
                                                // Handle update failure
                                                console.error('Failed to update deduction template record.');
                                            }
                                        },
                                        error: function (xhr, status, error) {
                                            // Handle AJAX error
                                            console.error('AJAX error:', status, error);
                                        },
                                        complete: function () {
                                            // Close the modal after the AJAX request is complete
                                            $('#editDeductionModal').modal('hide');
                                            location.reload();
                                        }
                                    });
                                });

                                // Handle the click event of the "Delete" button in the table
                                $('.fa-trash-o').click(function () {
                                    deleteDeductionId = $(this).data('id');
                                });

                                // Add your logic for the edit modal and delete modal here

                                // Handle the click event of the "Delete" button in the delete modal for deductions
                                $('#confirmDeleteDeduction').click(function () {
                                    // Perform an AJAX request to delete the record on the server
                                    $.ajax({
                                        url: 'delete-deduction-record.php', // Replace with your server-side script for deleting deductions
                                        method: 'POST',
                                        data: { id: deleteDeductionId },
                                        success: function (response) {
                                            if (response.success) {
                                                // Successfully deleted on the server
                                                // Remove the row from the table
                                                $('[data-id="' + deleteDeductionId + '"]').closest('tr').remove();
                                                // Close the delete modal
                                                $('#deleteDeductionModal').modal('hide');
                                            } else {
                                                // Handle deletion failure
                                                console.error('Failed to delete deduction template record.');
                                            }
                                        },
                                        error: function (xhr, status, error) {
                                            // Handle AJAX error
                                            console.error('AJAX error:', status, error);
                                        }
                                    });
                                });


                                // ... (similar to the previous code for departments)

                                // Handle the click event of the "Add Deduction Template" button in the add modal
                                $('#confirmAddDeductionTemplate').click(function () {
                                    var deductionType = $('#addDeductionType').val();
                                    var deductionValueType = $('#addDeductionValueType').val();
                                    var deductionValue = $('#addDeductionValue').val();

                                    // Perform an AJAX request to add the new deduction template on the server
                                    $.ajax({
                                        url: 'add-deduction-template-record.php', // Replace with your server-side script for adding
                                        method: 'POST',
                                        data: {
                                            type: deductionType,
                                            valueType: deductionValueType,
                                            value: deductionValue
                                        },
                                        success: function (response) {
                                            if (response.success) {
                                                // Successfully added on the server
                                                // Add the new row to the table or perform other actions
                                                // Close the add modal
                                                location.reload();
                                                $('#addDeductionTemplateModal').modal('hide');
                                            } else {
                                                // Handle addition failure
                                                console.error('Failed to add deduction template.');
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


                        <!-- Add your additional scripts or footer content here -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
