<?php 
session_start(); // Start the session
ob_start();

// Check if the empName session variable is set
if (isset($_SESSION['empName'])) {
   $empName = $_SESSION['empName'];
   $emp_id = $_SESSION['emp_id'];// Retrieve $empName from the session
} else {
   $empName = "Sign in"; // Set a default value if empName is not found in the session
}

$role = isset($_SESSION['role']) ? $_SESSION['role'] : ''; // Check if 'role' is set in the session

?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rising Stars Agency</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="images/logo.png">
    <link rel="shortcut icon" href="images/logo.png">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/lib/datatable/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.css"> -->
    <link rel="stylesheet" type="text/css" href="DataTables\DataTables-1.13.8\css\jquery.dataTables.css">

</head>
<body>
    <!-- Left Panel -->

    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                <?php if ($role === 'Admin') { ?>
                    <!-- <li><a href="employee-list.php"><i class="menu-icon fa fa-laptop"></i>Dashboard </a></li> -->
                    <!-- <li class="menu-title">UI elements</li> -->
                    <li><a href="applicant-list.php"><i class="menu-icon fa fa-users"></i>Applicant List </a></li>
                    <li><a href="employee-list.php"><i class="menu-icon fa fa-users"></i>Employee List </a></li>
                    <li><a href="jobpost.php"><i class="menu-icon fa fa-briefcase"></i>Job Posting </a></li>
                    <li><a href="payroll-list.php"><i class="menu-icon fa fa-table"></i>Payroll List </a></li>
                    <li><a href="employee-history.php"><i class="menu-icon fa fa-list"></i>Employee History </a></li>
                    <li class="menu-item-has-children active dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cogs"></i>Settings</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-sitemap"></i><a href="department-list.php"> Department</a></li>
                            <li><i class="fa fa-group"></i><a href="position-list.php"> Position</a></li>
                            <!-- <li><i class="fa fa-plus-square"></i><a href="tables-data.php"> Allowance</a></li> -->
                            <li><i class="fa fa-minus-square"></i><a href="deduction-template-list.php"> Deduction</a></li>
                        </ul>
                    </li>

                <?php } elseif ($role === 'HR') { ?>
                    <!-- <li class="menu-title">UI elements</li>
                    <li class="menu-title">UI elements</li> -->
                    <li><a href="employee-list.php"><i class="menu-icon fa fa-users"></i>Employee List </a></li>
                    <li><a href="applicant-list.php"><i class="menu-icon fa fa-users"></i>Applicant List </a></li>
                    <li><a href="jobpost.php"><i class="menu-icon fa fa-briefcase"></i>Job Posting </a></li>
                    

                <?php } elseif ($role === 'Payroll') { ?>
                    <li><a href="payroll-list.php"><i class='fa fa-home'></i> Home</a></li>
                    <li><a href="employee-list.php"><i class="menu-icon fa fa-users"></i>Employee List </a></li>
                    <li><a href="payroll-list.php"><i class="menu-icon fa fa-table"></i>Payroll List </a></li>
                    <li><a href="employee-history.php"><i class="menu-icon fa fa-list"></i>Employee History </a></li>
                    <li class="menu-item-has-children active dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cogs"></i>Settings</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-sitemap"></i><a href="department-list.php"> Department</a></li>
                            <li><i class="fa fa-group"></i><a href="position-list.php"> Position</a></li>
                            <!-- <li><i class="fa fa-plus-square"></i><a href="tables-data.php"> Allowance</a></li> -->
                            <li><i class="fa fa-minus-square"></i><a href="deduction-template-list.php"> Deduction</a></li>
                        </ul>
                    </li>

                <?php } elseif ($role === 'Emp') { ?>
                    <li><a href="attendance.php"><i class="menu-icon fa fa-laptop"></i>Dashboard </a></li>
                    <!-- <li class="menu-title">UI</li> -->
                    <li><a href="attendance.php"><i class="menu-icon fa fa-users"></i>Attendance</a></li>
                    <li><a href="dtr.php"><i class="menu-icon fa fa-list"></i>Daily Time Record</a></li>
                    <li><a href="logout.php"><i class="menu-icon fa fa-sign-out"></i>Logout</a></li>
                <?php } ?>

                </ul>
            </div>
        </nav>
    </aside>

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">
            <div class="top-left">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./"><img src="images/logo.png" alt="Logo"></a>
                    <a class="navbar-brand hidden" href="./"><img src="images/logo.png" alt="Logo"></a>
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                </div>
            </div>
            <div class="top-right">
                <div class="header-menu">
                    <div class="header-left">
                        <!-- <button class="search-trigger"><i class="fa fa-search"></i></button> -->
                        <div class="form-inline">
                            <form class="search-form">
                                <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                                <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                            </form>
                        </div>

                    <div class="user-area dropdown float-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class='fa fa-user'></i> <?php echo "$empName"; ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <!-- <li role="menuitem"><a href="#">Profile</a></li> -->
                            <li role="menuitem"><a href="logout.php">Logout</a></li>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header-->