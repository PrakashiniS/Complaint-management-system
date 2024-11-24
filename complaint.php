<?php
include("db.php");
$sql1 = "SELECT complaints_detail.*,worker_taskdet.work_completion_date FROM complaints_detail LEFT JOIN worker_taskdet on complaints_detail.id=worker_taskdet.task_id WHERE complaints_detail.status = 13";
$result1 = mysqli_query($conn, $sql1);
$compcount = mysqli_num_rows($result1);
$sql2 = "SELECT complaints_detail.*,manager.* FROM complaints_detail LEFT JOIN manager on complaints_detail.id=manager.problem_id WHERE status IN (7,10,14)";
$result2 = mysqli_query($conn, $sql2);


//pending count
$sql3 = "SELECT complaints_detail.*,manager.* FROM complaints_detail LEFT JOIN manager on complaints_detail.id=manager.problem_id WHERE status = 7";
$result3 = mysqli_query($conn, $sql3);
$compcount1 = mysqli_num_rows($result3);

//inprogress count
$sql4 = "SELECT complaints_detail.*,manager.* FROM complaints_detail LEFT JOIN manager on complaints_detail.id=manager.problem_id WHERE status = 10";
$result4 = mysqli_query($conn, $sql4);
$compcount2 = mysqli_num_rows($result4);

//reassigned work
$sql5 = "SELECT complaints_detail.*,manager.* FROM complaints_detail LEFT JOIN manager on complaints_detail.id=manager.problem_id WHERE status = 14";
$result5 = mysqli_query($conn, $sql5);
$compcount3 = mysqli_num_rows($result5);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" integrity="sha512-IXuoq1aFd2wXs4NqGskwX2Vb+I8UJ+tGJEu/Dc0zwLNKeQ7CW3Sr6v0yU3z5OQWe3eScVIkER4J9L7byrgR/fA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS (Optional but recommended) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title>Mkce Complain Management Systems</title>
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <!--For data table-->
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .nav-tabs .nav-link {
            color: #555;
            /* Default color for tabs */
            background-color: #f8f9fa;
            /* Default background color */
            border: 1px solid transparent;
            /* Default border */
        }

        .nav-tabs .nav-link.active {
            color: #fff;
            /* Text color when active */
            background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
            /* Background color when active */
            border-color: #989393;
            border-width: 5px;
            /* Border color when active */
        }

        /* Optional: Hover effect */
        .nav-tabs .nav-link:hover {
            color: #000;
            border-color: #989393;
            border-width: 5px;
            /* Text color on hover */
        }
    </style>

</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon -->
                        <b class="logo-icon p-l-8">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="assets/images/logo-icon.png" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="assets/images/logo-text.png" alt="homepage" class="light-logo" />
                        </span>
                    </a>
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                            class="ti-more"></i></a>
                </div>

                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a
                                class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                    </ul>
                    <ul class="navbar-nav float-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    src="assets/images/users/1.jpg" alt="user" class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <a class="dropdown-item" href="javascript:void(0)"><i class="ti-user m-r-5 m-l-5"></i>
                                    My Profile</a>
                                <a class="dropdown-item" href="javascript:void(0)"><i
                                        class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                                <div class="dropdown-divider"></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->

        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->

                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="p-t-30">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="p_index.php" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="requirements1.php" aria-expanded="false"><i class="mdi mdi-chart-bar"></i><span class="hide-menu">Requirements</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="complaint.php" aria-expanded="false"><i class="mdi mdi-chart-bubble"></i><span class="hide-menu">Complaint Status</span></a></li>

                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Complaint Status</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="p_index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Complaint</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->


                <!-- Tabs -->
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#completed"
                                            role="tab"><span class="hidden-sm-up"></span> <span
                                                class="hidden-xs-down"><i class="mdi mdi-book-open"></i>Completed Work (<?php echo $compcount ?>)</span></a>
                                    </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#inprogress"
                                            role="tab"><span class="hidden-sm-up"></span> <span
                                                class="hidden-xs-down"><i class="mdi mdi-book-open"></i>Work
                                                Assigned</span></a> </li>


                                </ul>
                                <!-- Tab panes -->
                                <!-- Tab panes -->
                                <div class="tab-content tabcontent-border">
                                    <div class="tab-pane active" id="completed" role="tabpanel">
                                        <div class="p-20">
                                            <div class="table-responsive">
                                                <div class="card">
                                                    <div class="card-body" style="padding: 10px;">

                                                        <!-- Dropdown filter for Status -->


                                                        <table id="dataTable" class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr style="color:white">
                                                                    <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);">
                                                                        <b>
                                                                            <h5>S.No</h5>
                                                                        </b>
                                                                    </th>
                                                                    <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);">
                                                                        <b>
                                                                            <h5>Dept</h5>
                                                                        </b>
                                                                    </th>
                                                                    <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);">
                                                                        <b>
                                                                            <h5>Block \ Venue</h5>
                                                                        </b>
                                                                    </th>

                                                                    <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);">
                                                                        <b>
                                                                            <h5>Complaint</h5>
                                                                        </b>
                                                                    </th>
                                                                    <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);">
                                                                        <b>
                                                                            <h5>Image</h5>
                                                                        </b>
                                                                    </th>
                                                                    <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);">
                                                                        <b>
                                                                            <h5>Date_raised</h5>
                                                                        </b>
                                                                    </th>
                                                                    <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);">
                                                                        <b>
                                                                            <h5>Deadline</h5>
                                                                        </b>
                                                                    </th>
                                                                    <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);">
                                                                        <b>
                                                                            <h5>Actual Date</h5>
                                                                        </b>
                                                                    </th>
                                                                    <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);">
                                                                        <b>
                                                                            <h5>Status</h5>
                                                                        </b>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $s = 1;
                                                                while ($row = mysqli_fetch_array($result1)) {
                                                                    $modal_id = "problem" . $s;
                                                                ?>
                                                                    <tr>
                                                                        <td class="text-center"><?php echo $s ?></td>
                                                                        <td class="text-center"><?php echo $row['department'] ?></td>
                                                                        <td class="text-center"><?php echo $row['block_venue'] ?> \ <?php echo $row['venue_name'] ?></td>

                                                                        <td class="text-center">
                                                                            <button type="button" class="btn viewcomplaint   margin-5" data-toggle="modal" data-target="#<?php echo $modal_id; ?>"><i class="fas fa-eye" style="font-size: 25px;"></i></button>
                                                                        </td>

                                                                        <!-- Modal for Problem Description and Faculty Info -->



                                                                        <div class="modal fade" id="<?php echo $modal_id; ?>" tabindex="-1" role="dialog" aria-labelledby="complaintDetailsModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                                                <div class="modal-content" style="border-radius: 8px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15); background-color: #f9f9f9;">

                                                                                    <!-- Modal Header with bold title and cleaner button -->
                                                                                    <div class="modal-header" style="background-color: #007bff; color: white; border-top-left-radius: 8px; border-top-right-radius: 8px; padding: 15px;">
                                                                                        <h5 class="modal-title" id="complaintDetailsModalLabel" style="font-weight: 700; font-size: 1.4em; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                                                                                            📋 Complaint Details
                                                                                        </h5>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; font-size: 1.2em;">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>

                                                                                    <!-- Modal Body with reduced padding -->
                                                                                    <div class="modal-body" style="padding: 15px; font-size: 1.1em; color: #333; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

                                                                                        <!-- Complaint Info Section with minimized spacing -->
                                                                                        <ol class="list-group list-group-numbered" style="margin-bottom: 0;">
                                                                                            <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                                                                <div class="ms-2 me-auto">
                                                                                                    <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Faculty ID</div>
                                                                                                    <b><span id="faculty_name" style="color: #555;"><?php echo $row['faculty_id'] ?></span></b>
                                                                                                </div>
                                                                                            </li>
                                                                                            <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                                                                <div class="ms-2 me-auto">
                                                                                                    <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Faculty Name</div>
                                                                                                    <b><span id="faculty_name" style="color: #555;"><?php echo $row['faculty_name'] ?></span></b>
                                                                                                </div>
                                                                                            </li>
                                                                                            <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                                                                <div class="ms-2 me-auto">
                                                                                                    <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Mobile Number</div>
                                                                                                    <b><span id="faculty_contact" style="color: #555;"><?php echo $row['faculty_contact'] ?></span></b>
                                                                                                </div>
                                                                                            </li>
                                                                                            <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                                                                <div class="ms-2 me-auto">
                                                                                                    <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">E-mail</div>
                                                                                                    <b><span id="faculty_mail" style="color: #555;"><?php echo $row['faculty_mail'] ?></span></b>
                                                                                                </div>
                                                                                            </li>

                                                                                            <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                                                                <div class="ms-2 me-auto">
                                                                                                    <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Type of Problem</div>
                                                                                                    <b><span id="type_of_problem" style="color: #555;"><?php echo $row['type_of_problem'] ?></span></b>
                                                                                                </div>
                                                                                            </li>
                                                                                            <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                                                                <div class="ms-2 me-auto">
                                                                                                    <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Problem Description</div>
                                                                                                    <div class="alert alert-light" role="alert" style="border-radius: 6px; background-color: #f1f1f1; padding: 15px; color: #333;">
                                                                                                        <b><span id="problem_description"><?php echo $row['problem_description'] ?></span></b>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </li>
                                                                                        </ol>
                                                                                    </div>

                                                                                    <!-- Modal Footer with reduced padding -->
                                                                                    <div class="modal-footer" style="border-top: none; justify-content: center; padding: 10px;">
                                                                                        <button type="button" class="btn btn-primary btn-lg" data-dismiss="modal" style="border-radius: 25px; padding: 10px 30px; font-size: 1.1em; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                                                                                            Close
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!--Description id=problem-->

                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <button type="button" class="btn showImage1" data-toggle="modal" data-target="imageModal1" data-id="<?php echo $row['id']; ?>"><i class="fas fa-image" style="font-size: 25px;"></i></button>
                                                                                <button type="button" class="btn imgafter" data-toggle="modal" data-target="imageModal" data-id="<?php echo $row['id']; ?>" style="margin:0 10px;"><i class="fas fa-images" style="font-size: 25px;"></i></button>
                                                                            </div>
                                                                        </td>

                                                                        <!-- Image Modal -->

                                                                        <td class="text-center"><?php echo $row['date_of_reg'] ?></td>
                                                                        <td class="text-center"><?php echo $row['days_to_complete'] ?></td>
                                                                        <td class="text-center"><?php echo $row['work_completion_date'] ?></td>
                                                                        <td class="text-center">Completed</td>
                                                                    </tr>
                                                                    <!-- Add more rows as needed -->
                                                                <?php
                                                                    $s++;
                                                                } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- work assigned tabs... -->
                                    <div class="tab-pane" id="inprogress" role="tabpanel">
                                        <div class="p-20">
                                            <div class="card">
                                                <div class="card-body" style="padding: 10px;">
                                                    <div class="filter-section" style="float:right">
                                                        <label for="status-filter">Filter by Status:</label>
                                                        <select id="status-filter" class="form-control" style="width: 200px; display: inline-block;">
                                                            <option value="">All</option>
                                                            <option value="Worker inProgress">In Progress (<?php echo $compcount2 ?>)</option>
                                                            <option value="Worker Pending">Pending (<?php echo $compcount1 ?>)</option>
                                                            <option value="Work Reassigned">Work Reassigned (<?php echo $compcount3 ?>)</option>
                                                        </select>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <!-- Table for In Progress tasks -->
                                                        <table id="dataTable1" class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr style="color: white;">
                                                                    <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);">
                                                                        <b>
                                                                            <h5>S.No</h5>
                                                                        </b>
                                                                    </th>
                                                                    <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);">
                                                                        <b>
                                                                            <h5>Dept</h5>
                                                                        </b>
                                                                    </th>
                                                                    <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);">
                                                                        <b>
                                                                            <h5>Block \ Venue</h5>
                                                                        </b>
                                                                    </th>
                                                                    <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);">
                                                                        <b>
                                                                            <h5>Complaint</h5>
                                                                        </b>
                                                                    </th>
                                                                    <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);">
                                                                        <b>
                                                                            <h5>Image</h5>
                                                                        </b>
                                                                    </th>
                                                                    <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);">
                                                                        <b>
                                                                            <h5>Date_raised</h5>
                                                                        </b>
                                                                    </th>
                                                                    <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);">
                                                                        <b>
                                                                            <h5>Deadline</h5>
                                                                        </b>
                                                                    </th>
                                                                    <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);">
                                                                        <b>
                                                                            <h5>Status</h5>
                                                                        </b>
                                                                    </th>
                                                                    <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);">
                                                                        <b>
                                                                            <h5>Comments</h5>
                                                                        </b>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $sql2 = "SELECT complaints_detail.*,manager.* FROM complaints_detail LEFT JOIN manager on complaints_detail.id=manager.problem_id WHERE status IN (7,10,14)";
                                                                $result2 = mysqli_query($conn, $sql2);
                                                                $s = 1;
                                                                while ($row = mysqli_fetch_array($result2)) {
                                                                    $modal_id = "problem1" . $s;
                                                                    $deadline_date = $row['days_to_complete']; // Assuming 'deadline' is in 'YYYY-MM-DD' format

                                                                    // Get the current date
                                                                    $current_date = date('Y-m-d');

                                                                    // Check if the deadline is exceeded
                                                                    $is_deadline_exceeded = ($current_date > $deadline_date) ? true : false;

                                                                    // Apply the background color if the deadline is exceeded
                                                                    $row_style = $is_deadline_exceeded ? 'background-color: rgba(255, 0, 0, 0.2);' : '';
                                                                    
                                                                ?>
                                                                    <tr style="<?php echo $row_style; ?>">
                                                                        <td class="text-center"><?php echo $s ?></td>
                                                                        <td class="text-center"><?php echo $row['department'] ?></td>
                                                                        <td class="text-center"><?php echo $row['block_venue'] ?> \ <?php echo $row['venue_name'] ?></td>
                                                                        <td class="text-center"><button type="button" class="btn viewcomplaint margin-5" data-toggle="modal" data-target="#<?php echo $row['problem_id']; ?>" height="30px" width="30px"><i class="fas fa-eye" style="font-size: 25px;"></i></button></td>
                                                                        

                                                                        <div class="modal fade" id="<?php echo $row['problem_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="complaintDetailsModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                                                <div class="modal-content" style="border-radius: 8px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15); background-color: #f9f9f9;">

                                                                                    <!-- Modal Header with bold title and cleaner button -->
                                                                                    <div class="modal-header" style="background-color: #007bff; color: white; border-top-left-radius: 8px; border-top-right-radius: 8px; padding: 15px;">
                                                                                        <h5 class="modal-title" id="complaintDetailsModalLabel" style="font-weight: 700; font-size: 1.4em; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                                                                                            📋 Complaint Details
                                                                                        </h5>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; font-size: 1.2em;">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>

                                                                                    <!-- Modal Body with reduced padding -->
                                                                                    <div class="modal-body" style="padding: 15px; font-size: 1.1em; color: #333; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

                                                                                        <!-- Complaint Info Section with minimized spacing -->
                                                                                        <ol class="list-group list-group-numbered" style="margin-bottom: 0;">
                                                                                            <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                                                                <div class="ms-2 me-auto">
                                                                                                    <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Faculty ID</div>
                                                                                                    <b><span id="faculty_name" style="color: #555;"><?php echo $row['faculty_id'] ?></span></b>
                                                                                                </div>
                                                                                            </li>
                                                                                            <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                                                                <div class="ms-2 me-auto">
                                                                                                    <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Faculty Name</div>
                                                                                                    <b><span id="faculty_name" style="color: #555;"><?php echo $row['faculty_name'] ?></span></b>
                                                                                                </div>
                                                                                            </li>
                                                                                            <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                                                                <div class="ms-2 me-auto">
                                                                                                    <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Mobile Number</div>
                                                                                                    <b><span id="faculty_contact" style="color: #555;"><?php echo $row['faculty_contact'] ?></span></b>
                                                                                                </div>
                                                                                            </li>
                                                                                            <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                                                                <div class="ms-2 me-auto">
                                                                                                    <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">E-mail</div>
                                                                                                    <b><span id="faculty_mail" style="color: #555;"><?php echo $row['faculty_mail'] ?></span></b>
                                                                                                </div>
                                                                                            </li>

                                                                                            <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                                                                <div class="ms-2 me-auto">
                                                                                                    <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Type of Problem</div>
                                                                                                    <b><span id="type_of_problem" style="color: #555;"><?php echo $row['type_of_problem'] ?></span></b>
                                                                                                </div>
                                                                                            </li>
                                                                                            <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                                                                <div class="ms-2 me-auto">
                                                                                                    <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Problem Description</div>
                                                                                                    <div class="alert alert-light" role="alert" style="border-radius: 6px; background-color: #f1f1f1; padding: 15px; color: #333;">
                                                                                                        <b><span id="problem_description"><?php echo $row['problem_description'] ?></span></b>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </li>
                                                                                        </ol>
                                                                                    </div>

                                                                                    <!-- Modal Footer with reduced padding -->
                                                                                    <div class="modal-footer" style="border-top: none; justify-content: center; padding: 10px;">
                                                                                        <button type="button" class="btn btn-primary btn-lg" data-dismiss="modal" style="border-radius: 25px; padding: 10px 30px; font-size: 1.1em; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                                                                                            Close
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!--Description id=problem-->

                                                                        <td class="text-center">
                                                                            <button type="button" class="btn showImage1" data-toggle="modal" data-target="imageModal" data-id="<?php echo $row['id']; ?>"><i class="fas fa-image" style="font-size: 25px;"></i></button>
                                                                        </td>
                                                                        <!--Image id=image-->

                                                                        <td class="text-center"><?php echo $row['date_of_reg'] ?></td>
                                                                        <td class="text-center"><?php echo $row['days_to_complete'] ?></td>
                                                                        <td class="text-center"><?php
                                                                                                if ($row['status'] == 7) {
                                                                                                    echo "Worker Pending";
                                                                                                } elseif ($row['status'] == 10) {
                                                                                                    echo "Worker inProgress";
                                                                                                } else {
                                                                                                    echo "Work Reassigned";
                                                                                                }
                                                                                                ?></td>
                                                                        <td class="text-center">
                                                                            <button type="button" value="<?php echo $row['task_id']; ?>"
                                                                                class="btn <?php

                                                                                            if (!empty($row['comment_query']) && !empty($row['comment_reply'])) {
                                                                                                echo 'btn-success'; // Green if both query and reply exist
                                                                                            } elseif (!empty($row['comment_query']) && empty($row['comment_reply'])) {
                                                                                                echo 'btn-warning'; // Yellow if only query exists
                                                                                            }  // Yellow if only query exists
                                                                                            else {
                                                                                                echo 'btn-info'; // Default blue if neither query nor reply exists
                                                                                            }
                                                                                            ?> details " data-toggle="modal" data-target="#comment">Comment</button>
                                                                        </td>
                                                                        <!-- Comment Modal -->
                                                                        <div class="modal fade" id="comment" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="rejectModalLabel">Comment Forum</h5>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <form id="comment_det">
                                                                                        <div class="modal-body">
                                                                                            <input type="hidden" name="task_id" id="task_id">
                                                                                            <!-- Query Field -->
                                                                                            <label class="form-label">Query*</label>
                                                                                            <input type="text" class="form-control" id="comment_query" name="comment_query" placeholder="Enter your query here">
                                                                                            <input type="text" class="form-control" id="query_date" name="query_date" placeholder="Date of Query Submission">
                                                                                            <!-- Reply Field -->
                                                                                            <label class="form-label">Reply*</label>
                                                                                            <input type="text" class="form-control" id="comment_reply" name="comment_reply" placeholder="Reply will be displayed here" readonly>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                            <button type="submit" class="btn btn-primary">Submit</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </tr>
                                                                    <!-- Add more rows as needed -->
                                                                <?php
                                                                    $s++;
                                                                } ?>
                                                                <!-- Rows for In Progress tasks -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <!-- ============================================================== -->
                                <!-- End Container fluid  -->
                                <!-- ============================================================== -->
                                <!-- ============================================================== -->
                                <!-- footer -->
                                <!-- ============================================================== -->

                                <!-- ============================================================== -->
                                <!-- End footer -->
                                <!-- ============================================================== -->
                            </div>
                            <!-- ============================================================== -->
                            <!-- End Page wrapper  -->
                            <!-- ============================================================== -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <footer class="footer text-center" style="padding-left: 250px;">
        <b>2024 © M.Kumarasamy College of Engineering All Rights Reserved.<br>
            Developed and Maintained by Technology Innovation Hub.</b>
    </footer>
    <!--Description id=problem-->
    <!-- Problem Description Modal -->


    <!--image modal-->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                    <h5 class="modal-title" id="imageModalLabel">Problem Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="rejectreason">
                    <div class="modal-body">
                        <img id="modalImage" src="" alt="Image" class="img-fluid" style="width:1500px;height:250px;">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->



    <!-- Bootstrap tether Core JavaScript -->

    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>
    <!--for data table-->
    <script src="assets/extra-libs/DataTables/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js" integrity="sha512-JnjG+Wt53GspUQXQhc+c4j8SBERsgJAoHeehagKHlxQN+MtCCmFDghX9/AcbkkNRZptyZU4zC8utK59M5L45Iw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(function() {
            // Initialize the tooltip
            $('[data-toggle="tooltip"]').tooltip();

            // You can also set options manually if needed
            $('.showImage1').tooltip({
                placement: 'top',
                title: 'Before'
            });
        });

        $(function() {
            // Initialize the tooltip
            $('[data-toggle="tooltip"]').tooltip();

            // You can also set options manually if needed
            $('.imgafter').tooltip({
                placement: 'top',
                title: 'After'
            });
        });
        $(function() {
            // Initialize the tooltip
            $('[data-toggle="tooltip"]').tooltip();

            // You can also set options manually if needed
            $('.viewcomplaint').tooltip({
                placement: 'top',
                title: 'View Complaint'
            });
        });




        //image
        // Show image
        $(document).on('click', '.showImage', function() {
            var user_id = $(this).data('id'); // Get the user ID from data attribute
            console.log(user_id);

            $.ajax({
                type: "POST",
                url: "backend1.php",
                data: {
                    'get_image': true,
                    'user_id': user_id
                },
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    console.log(res);

                    if (res.status == 500) {
                        alert(res.message);
                    } else {
                        $('#modalImage').attr('src', 'uploads/' + res.data.images); // Dynamically set the image source
                        $('#imageModal').modal('show'); // Show the modal
                    }
                }
            });
        });

        //to shows table
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });

        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#dataTable1').DataTable();

            // Apply filter on status change
            $('#status-filter').on('change', function() {
                var selectedStatus = $(this).val();
                if (selectedStatus) {
                    table.column(8).search('^' + selectedStatus + '$', true, false).draw();
                } else {
                    table.column(8).search('').draw();
                }
            });
        });

        $(document).ready(function() {
            $('#dataTable2').DataTable();
        });
        //comments query to insert

        $(document).on('click', '.details', function(e) {
            e.preventDefault();
            if ($(this).prop('disabled')) {
                return; // Prevent modal from opening if the button is disabled
            }
            var user_id = $(this).val();
            console.log(user_id)
            $.ajax({
                type: "POST",
                url: "backend1.php",
                data: {
                    'edit_user': true,
                    'user_id': user_id
                },
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    console.log(res);
                    if (res.status == 500) {
                        alert(res.message);
                    } else {
                        //$('#student_id2').val(res.data.uid);

                        $('#task_id').val(res.data.task_id);
                        $('#comment_query').val(res.data.comment_query);
                        $('#comment_reply').val(res.data.comment_reply);

                        $('#query_date').val("Query Submission Date: " + res.data.query_date);
                        var queryReadOnly = res.date_diff < 5 && res.data.comment_query;
                        if (queryReadOnly) {
                            // If less than 5 days and comment_query is given, make it readonly
                            $('#comment_query').prop('readonly', true);
                        } else {
                            // Otherwise, make it editable
                            $('#comment_query').prop('readonly', false);
                        }
                        $('#comment').modal('show');
                    }
                }
            });
        });

        //view descriotion
        $(document).on('click', '.viewDescription', function() {
            var complaintId = $(this).data('id'); // Get the complaint ID from the button's data-id attribute
            console.log(complaintId);
            // Send an AJAX request to fetch the description from the database using the complaint ID
            $.ajax({
                url: 'backend1.php', // Create this PHP file to handle fetching data
                method: 'POST',
                data: {
                    id: complaintId
                },
                success: function(response) {
                    $('#problem_description').val(response); // Populate the textarea with the fetched description
                }
            });
        });

        //comments query

        $(document).on('submit', '#comment_det', function(e) {
            e.preventDefault();
            var queryReadOnly = $('#comment_query').prop('readonly');
            var comment_query = $('#comment_query').val();
            var comment_reply = $('#comment_reply').val();

            // If both fields are readonly, simply close the modal without submitting
            if (queryReadOnly) {
                $('#comment').modal('hide');
            } else {
                var formData = new FormData(this);
                console.log(formData)
                formData.append("save_edituser", true);
                $.ajax({
                    type: "POST",
                    url: "backend1.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {
                            $('#comment').modal('hide');
                            $('#comment_det')[0].reset();
                            $('#dataTable1').load(location.href + " #dataTable1");
                            alertify.success('Query Successfully Submitted');

                        } else if (res.status == 500) {
                            $('#comment').modal('hide');
                            $('#comment_det')[0].reset();
                            console.error("Error:", res.message);
                            alert("Something Went wrong.! try again")
                        }
                    }
                });
            }
        });

        $(document).on('click', '.afterImage', function() {
            var user_id = $(this).data('id'); // Get the user ID from data attribute
            console.log(user_id);

            $.ajax({
                type: "POST",
                url: "backend1.php",
                data: {
                    'after_image': true,
                    'user_id': user_id
                },
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    console.log(res);

                    if (res.status == 500) {
                        alert(res.message);
                    } else {
                        $('#modalImage').attr('src', 'uploads/' + res.data.after_photo); // Dynamically set the image source
                        $('#imageModal').modal('show'); // Show the modal
                    }
                }
            });
        });
    </script>


</body>

</html>