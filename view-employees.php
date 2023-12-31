<?php
require 'header.php';
?>

<!DOCTYPE html>

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
                                <li><a href="#">Payroll Period</a></li>
                                <li class="active">View Employees</li>
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
                        </div>
                        <div class="card-body">
                            <table id="employeeTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Period ID</th>
                                        <th>Gross Pay</th>
                                        <th>Period From</th>
                                        <th>Period To</th>
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
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
        $('#employeeTable').DataTable({
            "ajax": {
                "url": "fetch-employees.php",
                "type": "POST",
                "data": {
                    "period_from": "<?php echo $_GET['period_from']; ?>",
                    "period_to": "<?php echo $_GET['period_to']; ?>"
                }
            },
            "columns": [
                { "data": "emp_id" },
                { "data": "lname" },
                { "data": "fname" },
                { "data": "period_id" },
                { "data": "gross_pay" },
                { "data": "period_from" },
                { "data": "period_to" }
            ]
        });
        });
    </script>
</body>

</html>
