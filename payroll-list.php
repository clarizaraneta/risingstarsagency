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
                            <li class="active">Payroll Period</li>
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
                        <strong class="card-title">Payroll Period</strong>

                        <div class="col-md-12 mb-3 text-right">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addPayrollModal">
                                <i class="fa fa-plus"></i> Add Payroll
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="payperiod" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Period ID</th>
                                    <th>Period From</th>
                                    <th>Period To</th>
                                    <th>Total</th>
                                    <th>Date Generated</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Payroll Period Modal -->
    <div class="modal fade" id="addPayrollModal" tabindex="-1" role="dialog" aria-labelledby="addPayrollModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPayrollModalLabel">Add Payroll Period</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addPayrollForm">
                        <div class="form-group">
                            <label for="period_from">Period From</label>
                            <input type="date" class="form-control" id="period_from" name="period_from" required>
                        </div>
                        <div class="form-group">
                            <label for="period_to">Period To</label>
                            <input type="date" class="form-control" id="period_to" name="period_to" required>
                        </div>
                        <div class="form-group">
                            <label for="period_type">Period Type</label>
                            <select class="form-control" id="period_type" name="period_type" required>
                                <option value="semi-monthly">Semi-Monthly</option>
                                <option value="monthly">Monthly</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>


<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
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

<script>
        $(document).ready(function () {
            // DataTable initialization
            $('#payperiod').DataTable({
                "ajax": "fetch-payrollperiod.php",
                "columns": [
                    { "data": "period_id" },
                    { "data": "period_from" },
                    { "data": "period_to" },
                    { "data": "total" },
                    { "data": "date_generated" },
                    { "data": "status" },
                    {
                        "data": null,
                        "render": function (data, type, row) {
                            // Add data attributes to store the period_id, period_from, and period_to
                            return '<button class="btn btn-info btn-sm view-btn" ' +
                                'data-periodid="' + row.period_id + '" ' +
                                'data-periodfrom="' + row.period_from + '" ' +
                                'data-periodto="' + row.period_to + '">View</button>' +
                                '<button class="btn btn-danger btn-sm delete-btn" data-id="' + row.period_id + '">Delete</button>' +
                                '<button class="btn btn-warning btn-sm recalculate-btn" data-id="' + row.period_id + '">Re-calculate</button>';
                        }
                    }
                ],
                "drawCallback": function () {
                    // Attach a click event listener to the "View" buttons
                    $('#payperiod tbody').on('click', '.view-btn', function () {
                        var periodId = $(this).data('periodid');
                        var periodFrom = $(this).data('periodfrom');
                        var periodTo = $(this).data('periodto');

                        // Make an AJAX request to fetch the period_type
                        $.ajax({
                            url: 'fetch-period-type.php',
                            type: 'POST',
                            data: { period_id: periodId },
                            success: function (response) {
                                // Check if the response is not empty
                                if (response.trim() !== '') {
                                    // Store the period_type in a variable
                                    var periodType = response;

                                    // Redirect to view-emp-paylist.php with the selected period_id, period_from, period_to, and period_type
                                    window.location.href = 'view-emp-paylist.php?period_id=' + periodId + '&period_from=' + periodFrom + '&period_to=' + periodTo + '&period_type=' + periodType;
                                } else {
                                    console.error('Error: Empty response received for period_type.');
                                }
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });
                    });
                }
            });         
                

            // Add Payroll form submission
            $("#addPayrollForm").submit(function (e) {
                e.preventDefault();

                $.ajax({
                    url: "save-payrollperiod.php",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        alert(response);
                        $('#addPayrollModal').modal('hide');
                        removeModalBackdrop();
                        reloadPayrollPeriodDataTable();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });


            // Event listener for delete button
            $('#payperiod').on('click', '.delete-btn', function () {
                var periodId = $(this).data('id');

                // Show a confirmation dialog before deleting
                if (confirm("Are you sure you want to delete this payroll period?")) {
                    // Call the delete function
                    deletePayrollPeriod(periodId);
                }
            });

            // Event listener for re-calculate button
            $('#payperiod').on('click', '.recalculate-btn', function () {
                var periodId = $(this).data('id');

                // Call the re-calculate function
                recalculatePayroll(periodId);
            });

            // Function to delete payroll period
            function deletePayrollPeriod(periodId) {
                $.ajax({
                    url: "delete-payrollperiod.php",
                    method: "POST",
                    data: { period_id: periodId },
                    success: function (response) {
                        alert(response);
                        reloadPayrollPeriodDataTable();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }

            // Function to re-calculate payroll
            function recalculatePayroll(periodId) {
                $.ajax({
                    url: "recalculate-payroll.php",
                    method: "POST",
                    data: { period_id: periodId },
                    success: function (response) {
                        alert(response);
                        reloadPayrollPeriodDataTable();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }

            // Function to manually remove the modal backdrop
            function removeModalBackdrop() {
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
            }

            // Function to reload the Payroll Period DataTable
            function reloadPayrollPeriodDataTable() {
                $('#payperiod').DataTable().ajax.reload(null, false);
            }
        });
    </script>

</body>
</html>
