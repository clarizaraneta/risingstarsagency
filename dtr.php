
<?php
require 'header.php';
require_once('config.php');

// Check if emp_id exists in the session or fetch it from wherever it's set
if (!isset($_SESSION['emp_id'])) {
    // Redirect to login or set emp_id based on your authentication process
    header("Location: index.php");
    exit();
}

$emp_id = $_SESSION['emp_id'];
?>


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
                            <li class="active">Daily Time Record</li>
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
                        <strong class="card-title">Daily Time Record</strong>
                    </div>
                    <div class="card-body">
                        <div id="DTRContainer" class="dtr-container">
            <!-- User's login records will be displayed here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>


<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
window.onload = function() {
    showDTR();
};

function showDTR() {
    let emp_id = <?php echo json_encode(intval($emp_id)); ?>;

    fetch('get_login_records.php?emp_id=' + emp_id)
    .then(response => response.text())
    .then(data => {
        document.getElementById('DTRContainer').innerHTML = data;
    })
    .catch(error => {
        console.error('Error fetching login records:', error);
    });
}
</script>

</body>
</html>

<style>
    .dtr-container {
        /* Add your styles here */
        padding: 20px;
        background-color: #f5f5f5;
        border: 1px solid #ddd;
        margin-top: 20px;
    }
</style>
