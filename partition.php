<?php



include('db.php');
// Prepare and execute the query to filter by department
//New task query
$sql = "SELECT 
    cd.id,
    cd.faculty_id,
    f.faculty_name,
    f.department,
    f.faculty_contact,
    f.faculty_mail,
    cd.block_venue,
    cd.venue_name,
    cd.type_of_problem,
    cd.problem_description,
    cd.images,
    cd.date_of_reg,
    cd.days_to_complete,
    cd.task_completion,
    cd.status,
    cd.feedback,
    m.task_id,
    m.priority
FROM 
    complaints_detail AS cd
JOIN 
    manager AS m ON cd.id = m.problem_id
JOIN 
    faculty AS f ON cd.faculty_id = f.faculty_id
WHERE 
        (m.worker_id  LIKE 'PAR%')
AND 
    cd.status = '7'";

// Filter by department
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$newcount = mysqli_num_rows($result);




//inprogress query
$sql1 = "SELECT 
    cd.id,
    cd.faculty_id,
    f.faculty_name,
    f.department,
    f.faculty_contact,
    f.faculty_mail,
    cd.block_venue,
    cd.venue_name,
    cd.type_of_problem,
    cd.problem_description,
    cd.images,
    cd.date_of_reg,
    cd.days_to_complete,
    cd.task_completion,
    cd.status,
    cd.feedback,
    m.task_id,
    m.priority
FROM 
    complaints_detail AS cd
JOIN 
    manager AS m ON cd.id = m.problem_id
JOIN 
    faculty AS f ON cd.faculty_id = f.faculty_id
WHERE 
        (m.worker_id  LIKE 'PAR%')
AND 
    cd.status = '10'";

// Filter by department
$stmt = $conn->prepare($sql1);
$stmt->execute();
$result1 = $stmt->get_result();
$progcount = mysqli_num_rows($result1);


//waiting for approval query
$sql2 = "SELECT 
    cd.id,
    cd.faculty_id,
    f.faculty_name,
    f.department,
    f.faculty_contact,
    f.faculty_mail,
    cd.block_venue,
    cd.venue_name,
    cd.type_of_problem,
    cd.problem_description,
    cd.images,
    cd.date_of_reg,
    cd.days_to_complete,
    cd.task_completion,
    cd.status,
    cd.reason,
    cd.feedback,
    m.task_id,
    m.priority
FROM 
    complaints_detail AS cd
JOIN 
    manager AS m ON cd.id = m.problem_id
JOIN 
    faculty AS f ON cd.faculty_id = f.faculty_id
WHERE 
        (m.worker_id  LIKE 'PAR%')
AND 
    (cd.status = '11' OR cd.status = '18')";

// Filter by department
$stmt = $conn->prepare($sql2);
$stmt->execute();
$result2 = $stmt->get_result();
$waitcount = mysqli_num_rows($result2);


//completed query
$sql3 = "SELECT 
    cd.id,
    cd.faculty_id,
    f.faculty_name,
    f.department,
    f.faculty_contact,
    f.faculty_mail,
    cd.block_venue,
    cd.venue_name,
    cd.type_of_problem,
    cd.problem_description,
    cd.images,
    cd.date_of_reg,
    cd.days_to_complete,
    cd.task_completion,
    cd.date_of_completion,
    cd.status,
    cd.feedback,
    m.task_id,
    m.priority
FROM 
    complaints_detail AS cd
JOIN 
    manager AS m ON cd.id = m.problem_id
JOIN 
    faculty AS f ON cd.faculty_id = f.faculty_id
WHERE 
        (m.worker_id  LIKE 'PAR%')
AND 
    cd.status = '16'";

// Filter by department
$stmt = $conn->prepare($sql3);
$stmt->execute();
$result3 = $stmt->get_result();
$compcount = mysqli_num_rows($result3);


//not approved query
$sql4 = "SELECT 
    cd.id,
    cd.faculty_id,
    f.faculty_name,
    f.department,
    f.faculty_contact,
    f.faculty_mail,
    cd.block_venue,
    cd.venue_name,
    cd.type_of_problem,
    cd.problem_description,
    cd.images,
    cd.date_of_reg,
    cd.days_to_complete,
    cd.task_completion,
    cd.date_of_completion,
    cd.status,
    cd.feedback,
    m.task_id,
    m.priority
FROM 
    complaints_detail AS cd
JOIN 
    manager AS m ON cd.id = m.problem_id
JOIN 
    faculty AS f ON cd.faculty_id = f.faculty_id
WHERE 
        (m.worker_id  LIKE 'PAR%')
AND 
    cd.status = '15'";

// Filter by department
$stmt = $conn->prepare($sql4);
$stmt->execute();
$result4 = $stmt->get_result();
$notcount = mysqli_num_rows($result4);


//count for side bar starts

$q1 = "SELECT * FROM complaints_detail as cd JOIN manager as m on cd.id = m.problem_id WHERE cd.status = '7' AND m.worker_id LIKE 'CIV%'";
$q2 = "SELECT * FROM complaints_detail as cd JOIN manager as m on cd.id = m.problem_id WHERE cd.status = '7' AND m.worker_id LIKE 'CAR%'";
$q3 = "SELECT * FROM complaints_detail as cd JOIN manager as m on cd.id = m.problem_id WHERE cd.status = '7' AND m.worker_id LIKE 'ELE%'";
$q4 = "SELECT * FROM complaints_detail as cd JOIN manager as m on cd.id = m.problem_id WHERE cd.status = '7' AND m.worker_id LIKE 'INF%'";
$q5 = "SELECT * FROM complaints_detail as cd JOIN manager as m on cd.id = m.problem_id WHERE cd.status = '7' AND m.worker_id LIKE 'PAR%'";
$q6 = "SELECT * FROM complaints_detail as cd JOIN manager as m on cd.id = m.problem_id WHERE cd.status = '7' AND m.worker_id LIKE 'PLU%'";

$r1 = mysqli_query($conn, $q1);

$r2 = mysqli_query($conn, $q2);

$r3 = mysqli_query($conn, $q3);

$r4 = mysqli_query($conn, $q4);

$r5 = mysqli_query($conn, $q5);

$r6 = mysqli_query($conn, $q6);

$c1 = mysqli_num_rows($r1);

$c2 = mysqli_num_rows($r2);

$c3 = mysqli_num_rows($r3);

$c4 = mysqli_num_rows($r4);

$c5 = mysqli_num_rows($r5);

$c6 = mysqli_num_rows($r6);











//count for side bar ends

?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <title>Partition</title>
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <style>
        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active {
            color: white;
            background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
            padding: 11px 15px;
        }

        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active:hover {
            border: none;
        }

        a {
            color: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
            padding: 11px 15px;
        }

        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs a:hover {
            color: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
            border: 4px solid gray;
            /* Include the border within the button size */
            padding: 8px 15px;
            /* Adjust padding to maintain the button's size */
        }

        th {
            /* background-color: #7460ee; */
            background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
            color: white;
        }

        @media (min-width:1300px) and (max-width:1800px) {
            /* For mobile phones: */

        }
    </style>
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
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
                    <!-- Sidebar toggle for mobile -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>

                    <!-- Logo -->
                    <a class="navbar-brand" href="index.html">

                        <span class="logo-text">
                            <img src="assets/images/mkcenavlogo.png" alt="homepage" class="light-logo" />
                        </span>
                    </a>

                    <!-- Toggle for mobile -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>

                <!-- Navbar items -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a>
                        </li>
                        <!-- Additional items can be added here -->
                    </ul>
                    <a href="login.php" class="btn btn-danger">
                        <i class=" fas fa-sign-out-alt" style="font-size: 15px;"></i>
                    </a>


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
                    <li class="sidebar-item"> <a id="view-work-task-history" class="sidebar-link waves-effect waves-dark sidebar-link" href="index.php" aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span class="hide-menu">Dashboard</span></a></li>
                <li class="sidebar-item"> <a id="view-work-task-history" class="sidebar-link waves-effect waves-dark sidebar-link" href="work.php" aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span class="hide-menu">Work Asign</span></a></li>

                    <li class="sidebar-item"> <a id="view-work-task-history" class="sidebar-link waves-effect waves-dark sidebar-link" href="civil.php" aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span class="hide-menu">CIVIL(<?php echo $c1; ?>)</span></a></li>
                    <li class="sidebar-item"> <a id="view-work-task-history" class="sidebar-link waves-effect waves-dark sidebar-link" href="carpenter.php" aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span class="hide-menu">CARPENTER(<?php echo $c2; ?>)</span></a></li>
                        <li class="sidebar-item"> <a id="view-work-task-history" class="sidebar-link waves-effect waves-dark sidebar-link" href="electrical.php" aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span class="hide-menu">ELECTRICAL(<?php echo $c3; ?>)</span></a></li>
                        <li class="sidebar-item"> <a id="view-work-task-history" class="sidebar-link waves-effect waves-dark sidebar-link" href="infra.php" aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span class="hide-menu">IT INFRA(<?php echo $c4; ?>)</span></a></li>
                        <li class="sidebar-item"> <a id="view-work-task-history" class="sidebar-link waves-effect waves-dark sidebar-link" href="partition.php" aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span class="hide-menu">PARTITION(<?php echo $c5; ?>)</span></a></li>
                        <li class="sidebar-item"> <a id="view-work-task-history" class="sidebar-link waves-effect waves-dark sidebar-link" href="plumbing.php" aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span class="hide-menu">PLUMBING(<?php echo $c6; ?>)</span></a></li>
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
                        <h4 class="page-title">Partition</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Partition</li>
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
                <div class="row">
                    <div class="col-md-12">

                        <!-- Tabs -->
                        
                        <!-- Tabs -->
                        <div class="card" >
                            <div id="navref">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#completed"
                                        role="tab"><span class="hidden-sm-up"></span><div id="ref1"> <span
                                            class="hidden-xs-down"><b>Completed(<?php echo $compcount ?>)</b></span></div></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#newtask"
                                        role="tab"><span class="hidden-sm-up"></span><div id="ref2"> <span
                                            class="hidden-xs-down"><b>NewTask(<?php echo $newcount ?>)</b></span></div></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#notapproved"
                                        role="tab"><span class="hidden-sm-up"></span> <div id="ref3"><span
                                            class="hidden-xs-down"><b>NotApproved(<?php echo $notcount ?>)</b></span></div></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#inprogressdiv"
                                        role="tab"><span class="hidden-sm-up"></span> <div id="ref4"><span
                                            class="hidden-xs-down"><b>InProgress(<?php echo $progcount ?>)</b></span></div></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#waitingforapproval"
                                        role="tab"><span class="hidden-sm-up"></span> <div id="ref5"><span
                                            class="hidden-xs-down"><b>WaitingForApproval(<?php echo $waitcount ?>)</b></span></div></a> </li>
                            </ul>
                            </div>

    
                            <!-- Tab panes -->
                            <div class="tab-content tabcontent-border">
                                <!--completed start-->
                                <div class="tab-pane active p-20" id="completed" role="tabpanel">
                                    <div class="p-20">
                                        <div class="table-responsive">
                                            <h5 class="card-title">Completed Tasks</h5>
                                            <table id="addnewtaskcompleted" class="table table-striped table-bordered">
                                                <thead style="background-color: rgb(220, 20, 70); color: white; ">
                                                    <tr>

                                                        <th class="text-center"><b>
                                                                <h5>S.No</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Complaint Date</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Task ID</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Dept</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Complaint</h5>
                                                            </b></th>
                                                        <th class="text-center">
                                                            <b>
                                                                <h5>Photos</h5>
                                                            </b>
                                                        </th>
                                                        <th class=" col-md-2 text-center"><b>
                                                                <h5>Deadline</h5>
                                                            </b></th>
                                                        <th class=" col-md-2 text-center"><b>
                                                                <h5>Date of completion</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Status</h5>
                                                            </b></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $count = 1;
                                                    while ($row = $result3->fetch_assoc()) {
                                                        echo "<tr>";
                                                        echo "<td class='text-center'>" . $count++ . "</td>";
                                                        echo "<td class='text-center'>" . htmlspecialchars($row['date_of_reg']) . "</td>";
                                                        echo "<td class='text-center'>" . htmlspecialchars($row['task_id']) . "</td>";
                                                        echo "<td class='text-center'>" . htmlspecialchars($row['department']) . "</td>";
                                                    ?>
                                                        <td class='text-center'>
                                                        <button type='button' class='btn btn margin-5 view-complaint
                                                            '
                                                                data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                <i class="fas fa-eye" style="font-size: 25px;"></i>

                                                            </button>
                                                        </td>

                                                        <td>
                                                            <div class="d-flex justify-content-between">
                                                                <!-- Align the first button to the left -->

                                                                <button type='button' class='btn  margin-5 showbeforeimg'
                                                                    data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                    <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                </button>

                                                                <!-- Align the second button to the right -->
                                                                <button type="button" class="btn"
                                                                    style="margin-left:8px;" data-toggle="modal"
                                                                    data-target="#Modal4">
                                                                    <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                        <?php
                                                        echo "<td class='text-center'>" . htmlspecialchars($row['days_to_complete']) . "</td>";
                                                        echo "<td class='text-center'>" . htmlspecialchars($row['date_of_completion']) . "</td>";

                                                        ?>
                                                        <td><button type="button" class="btn btn-info"
                                                                data-toggle="modal">
                                                                Completed
                                                            </button></td>
                                                    <?php

                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </tbody>

                                            </table>
                                        </div>

                                    </div>
                                </div>
                                <!--completed end-->
                                <!--new task start-->
                                <div class="tab-pane  p-10" id="newtask" role="tabpanel">
                                    <div class="p-10">
                                        <div class="card">
                                            <div class="card-body" style="padding: 10px;">
                                                <h5 class="card-title">New Tasks</h5>
                                                <div class="table-responsive">
                                                    <table id="addnewtask" class="table table-striped table-bordered">
                                                        <thead style="background-color: rgb(220, 20, 70); color: white;">
                                                            <tr>
                                                                <th class="text-center"><b>S.No</b></th>
                                                                <th class="col-md-2 text-center"><b>Complaint Date</b></th>
                                                                <th class="text-center"><b>Task ID</b></th>
                                                                <th class="text-center col-md-1"><b>Dept</b></th>
                                                                <th class="col-md-2 text-center"><b>Complaint</b></th>
                                                                <th class="text-center"><b>Priority</b></th>
                                                                <th class="text-center"><b>Photos</b></th>
                                                                <th class="text-center"><b>Deadline</b></th>
                                                                <th class="text-center"><b>Status</b></th>
                                                                <th class="text-center"><b>Action</b></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $count = 1;
                                                            while ($row = $result->fetch_assoc()) {
                                                                echo "<tr>";
                                                                echo "<td class='text-center'>" . $count++ . "</td>";
                                                                echo "<td class='text-center'>" . htmlspecialchars($row['date_of_reg']) . "</td>";
                                                                echo "<td class='text-center'>" . htmlspecialchars($row['task_id']) . "</td>";
                                                                echo "<td class='text-center'>" . htmlspecialchars($row['department']) . "</td>";
                                                            ?>
                                                                <td class='text-center'>
                                                                <button type='button' class='btn btn margin-5 view-complaint
                                                            '
                                                                data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                <i class="fas fa-eye" style="font-size: 25px;"></i>

                                                            </button>
                                                                </td>
                                                                <?php
                                                                echo "<td class='text-center'>" . htmlspecialchars($row['priority']) . "</td>";
                                                                ?>
                                                                <td class='text-center'>
                                                                    <button type='button' class='btn margin-5 showbeforeimg'
                                                                        data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                        <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                    </button>
                                                                </td>
                                                                <?php
                                                                echo "<td class='text-center'>" . htmlspecialchars($row['days_to_complete']) . "</td>";
                                                                echo "<td class='text-center'>Pending</td>";
                                                                ?>
                                                                <td class='text-center'>
                                                                    <button id='reload-table-btn' type='button' class='btn btn-primary margin-5 start-work-btn '
                                                                        data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                        Start to work
                                                                    </button>
                                                                </td>
                                                            <?php echo "</tr>";
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>

                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--new task end-->
                                <div class="tab-pane p-10" id="notapproved" role="tabpanel">
                                    <div class="p-10">
                                        <div class="p-10">
                                            <div class="card">
                                                <div class="card-body" style="padding: 10px;">
                                                    <h5 class="card-title">Work not Approved</h5>
                                                    <div class="table-responsive">
                                                        <table id="statusnotapproved"
                                                            class="table table-striped table-bordered">
                                                            <thead
                                                                style="background-color: rgb(220, 20, 70); color: white; ">
                                                                <tr>

                                                                    <th class="text-center"><b>
                                                                            <h5>S.No</h5>
                                                                        </b></th>
                                                                    <th class="col-md-2 text-center"><b>
                                                                            <h5>Complaint Date</h5>
                                                                        </b></th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Task ID</h5>
                                                                        </b></th>
                                                                    <th class="text-center col-md-2"><b>
                                                                            <h5>Dept</h5>
                                                                        </b></th>
                                                                    <th class="col-md-2 text-center"><b>
                                                                            <h5>Complaint</h5>
                                                                        </b></th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Priority</h5>
                                                                        </b></th>
                                                                    <th class="text-center">
                                                                        <b>
                                                                            <h5>Photos</h5>
                                                                        </b>
                                                                    </th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Deadline</h5>
                                                                        </b></th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Comments</h5>
                                                                        </b></th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Status</h5>
                                                                        </b></th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Action</h5>
                                                                        </b></th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $count = 1;
                                                                while ($row = $result4->fetch_assoc()) {
                                                                    echo "<tr>";
                                                                    echo "<td class='text-center'>" . $count++ . "</td>";
                                                                    echo "<td class='text-center'>" . htmlspecialchars($row['date_of_reg']) . "</td>";
                                                                    echo "<td class='text-center'>" . htmlspecialchars($row['task_id']) . "</td>";
                                                                    echo "<td class='text-center'>" . htmlspecialchars($row['department']) . "</td>";
                                                                ?>
                                                                    <td class='text-center'>
                                                                    <button type='button' class='btn btn margin-5 view-complaint
                                                            '
                                                                data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                <i class="fas fa-eye" style="font-size: 25px;"></i>

                                                            </button>
                                                                    </td>
                                                                    <?php
                                                                    echo "<td class='text-center'>" . htmlspecialchars($row['priority']) . "</td>";
                                                                    ?>
                                                                    <td class='text-center'>
                                                                        <button type='button' class='btn margin-5 showbeforeimg'
                                                                            data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                            <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                        </button>
                                                                    </td>
                                                                    <?php
                                                                    echo "<td class='text-center'>" . htmlspecialchars($row['days_to_complete']) . "</td>";
                                                                    echo "<td class='text-center'>" . htmlspecialchars($row['feedback']) . "</td>";
                                                                    echo "<td class='text-center'>Pending</td>";
                                                                    ?>
                                                                    <td class='text-center'>
                                                                        <button type='button' class='btn btn-primary margin-5 start-work-btn '
                                                                            data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                            Start to work
                                                                        </button>
                                                                    </td>
                                                                <?php echo "</tr>";
                                                                }
                                                                ?>
                                                            </tbody>

                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Inprogress-->
                                <div class="tab-pane p-10" id="inprogressdiv" role="tabpanel">
                                    <div class="p-10">
                                        <div class="p-10">
                                            <div class="card">
                                                <div class="card-body" style="padding: 10px;">
                                                    <h5 class="card-title">InProgress</h5>
                                                    <div class="table-responsive">
                                                        <table id="statusinprogress"
                                                            class="table table-striped table-bordered">
                                                            <thead
                                                                style="background-color: rgb(220, 20, 70); color: white; ">
                                                                <tr>

                                                                    <th class="text-center"><b>
                                                                            <h5>S.No</h5>
                                                                        </b></th>
                                                                    <th class="col-md-2 text-center"><b>
                                                                            <h5>Complaint Date</h5>
                                                                        </b></th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Task ID</h5>
                                                                        </b></th>
                                                                    <th class="text-center col-md-2"><b>
                                                                            <h5>Dept</h5>
                                                                        </b></th>
                                                                    <th class="col-md-2 text-center"><b>
                                                                            <h5>Complaint</h5>
                                                                        </b></th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Priority</h5>
                                                                        </b></th>
                                                                    <th class="text-center">
                                                                        <b>
                                                                            <h5>Photos</h5>
                                                                        </b>
                                                                    </th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Deadline</h5>
                                                                        </b></th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Status</h5>
                                                                        </b></th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Action</h5>
                                                                        </b></th>

                                                                </tr>
                                                            </thead>
                                                            <tbody id = "progbody">
                                                                <?php
                                                                $count = 1;
                                                                while ($row = $result1->fetch_assoc()) {
                                                                    echo "<tr>";
                                                                    echo "<td class='text-center'>" . $count++ . "</td>";
                                                                    echo "<td class='text-center'>" . htmlspecialchars($row['date_of_reg']) . "</td>";
                                                                    echo "<td class='text-center'>" . htmlspecialchars($row['task_id']) . "</td>";
                                                                    echo "<td class='text-center'>" . htmlspecialchars($row['department']) . "</td>";
                                                                ?>
                                                                    <td class='text-center'>
                                                                    <button type='button' class='btn btn margin-5 view-complaint
                                                            '
                                                                data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                <i class="fas fa-eye" style="font-size: 25px;"></i>

                                                            </button>
                                                                    </td>
                                                                    <?php
                                                                    echo "<td class='text-center'>" . htmlspecialchars($row['priority']) . "</td>";
                                                                    ?>
                                                                    <td class='text-center'>
                                                                        <button type='button' class='btn margin-5 showbeforeimg'
                                                                            data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                            <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                        </button>
                                                                    </td>
                                                                    <?php
                                                                    echo "<td class='text-center'>" . htmlspecialchars($row['days_to_complete']) . "</td>";
                                                                    echo "<td class='text-center'>In Progress</td>";
                                                                    ?>
                                                                    <td class='text-center'>
                                                                        <button type='button' class='work-comp btn btn-primary margin-5 '
                                                                            data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                            Work Completion
                                                                        </button>
                                                                    </td>
                                                                <?php echo "</tr>";
                                                                }
                                                                ?>
                                                            </tbody>

                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end of inprogress-->
                                <!--inprogress task submission modal-->
                                <!--Task Completion--><!--Id:Modal2-->
                                <!-- Modal -->
                                <div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Task Completion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--form-->
                <form id="taskCompletionForm">
                    <div class="mb-3">
                        <label class="form-label">Task ID</label>
                        <input type="text" class="form-control" id="taskid" disabled readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Add Image-Proof</label>
                        <input onchange="validateSize(this)" class="form-control" type="file" id="imgafter">
                    </div>
                    <label class="form-label">Task Completion</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="completionStatus" id="inlineRadio1" value="Fully Completed">
                        <label class="form-check-label" for="inlineRadio1">Fully Completed</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="completionStatus" id="inlineRadio2" value="Partially Completed">
                        <label class="form-check-label" for="inlineRadio2">Partially Completed</label>
                    </div>
                    <!-- Hidden input field for reason -->
                    <div class="mb-3 mt-3" id="reason-container" style="display: none;">
                        <label class="form-label">Reason</label>
                        <input type="text" class="form-control" id="reason" name="reason" placeholder="Enter reason for partial completion">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="save-btn" type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

                                <!-- JavaScript -->


                                <!--inprogress task submission modal end-->
                                <!--start of waiting approval-->
                                <div class="tab-pane p-20" id="waitingforapproval" role="tabpanel">
                                    <div class="p-20">
                                        <div class="table-responsive"><!--id:addnewtask-->
                                            <table id="approval" class="table table-striped table-bordered">
                                                <h5 class="card-title">Waiting for Approval</h5>
                                                <thead style="background-color: rgb(220, 20, 70); color: white; ">
                                                    <tr>

                                                        <th class="text-center"><b>
                                                                <h5>S.No</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Complaint Date</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Task ID</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Dept</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Complaint</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Priority</h5>
                                                            </b></th>
                                                        <th class="text-center col-md-2">
                                                            <b>
                                                                <h5>Photos</h5>
                                                            </b>
                                                        </th>
                                                        <th class=" col-md-2 text-center"><b>
                                                                <h5>Deadline</h5>
                                                            </b></th>
                                                        <th class=" col-md-2 text-center"><b>
                                                                <h5>Reason</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Task Completion</h5>
                                                            </b></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $count = 1;
                                                    while ($row = $result2->fetch_assoc()) {
                                                        echo "<tr>";
                                                        echo "<td class='text-center'>" . $count++ . "</td>";
                                                        echo "<td class='text-center'>" . htmlspecialchars($row['date_of_reg']) . "</td>";
                                                        echo "<td class='text-center'>" . htmlspecialchars($row['task_id']) . "</td>";
                                                        echo "<td class='text-center'>" . htmlspecialchars($row['department']) . "</td>";
                                                    ?>
                                                        <td class='text-center'>
                                                        <button type='button' class='btn btn margin-5 view-complaint
                                                            '
                                                                data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                <i class="fas fa-eye" style="font-size: 25px;"></i>

                                                            </button>
                                                        </td>
                                                        <?php
                                                        echo "<td class='text-center'>" . htmlspecialchars($row['priority']) . "</td>";
                                                        ?>
                                                        <td>
                                                            <div class="d-flex justify-content-between">
                                                                <!-- Align the first button to the left -->

                                                                <button type='button' class='btn margin-5 showbeforeimg'
                                                                    data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                    <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                </button>

                                                                <!-- Align the second button to the right -->
                                                                <button type="button" class="btn showImage"
                                                                    style="margin-left:-12px;" data-toggle="modal"
                                                                    data-target="#Modal4" data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                    <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    <?php
                                                        echo "<td class='text-center'>" . htmlspecialchars($row['days_to_complete']) . "</td>";
                                                        echo "<td class='text-center'>" . htmlspecialchars($row['reason']) . "</td>";
                                                        echo "<td class='text-center'>" . htmlspecialchars($row['task_completion']) . "</td>";
                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </tbody>

                                            </table>
                                        </div>

                                    </div>
                                </div>



                                <!--image before and complaint start-->
                                <div class="modal fade" id="Modal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Image-Before</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <img id="modalImage1" src="" width="100%">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!--modal for image(After) viewing in model -->
                                <!-- Modal image view-->
                                <div class="modal fade" id="Modal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Image-After</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <img id="modalImage" src="" width="100%">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Structure -->
                                <div class="modal fade" id="Modal1" tabindex="-1" role="dialog" aria-labelledby="complaintDetailsModalLabel" aria-hidden="true">
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
                            <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Faculty Name</div>
                            <b><span id="faculty_name" style="color: #555;"></span></b>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Mobile Number</div>
                            <b><span id="contact" style="color: #555;"></span></b>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Block</div>
                            <b><span id="block-content" style="color: #555;"></span></b>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Venue Name</div>
                            <b><span id="venue-content" style="color: #555;"></span></b>
                        </div>
                    </li>
                 
                    <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Problem Description</div>
                            <b><span id="problem-description-content" style="color: #555;"></span></b>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Deadline</div>
                            <div class="alert alert-light" role="alert" style="border-radius: 6px; background-color: #f1f1f1; padding: 15px; color: #333;">
                                <span id="days-remaining-content"></span>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
        <!--image before and complaint end-->
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->
        <!-- .right-sidebar -->
        <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <footer class="footer text-center">
        <b>2024 © M.Kumarasamy College of Engineering All Rights Reserved.<br>
            Developed and Maintained by Technology Innovation Hub.</b>
    </footer>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
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
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>

$(function() {
                // Initialize the tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // You can also set options manually if needed
                $('.view-complaint').tooltip({
                    placement: 'top',
                    title: 'View Complaint'
                });
            });


            $(function() {
                // Initialize the tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // You can also set options manually if needed
                $('.showbeforeimg').tooltip({
                    placement: 'top',
                    title: 'Before'
                });
            });

            $(function() {
                // Initialize the tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // You can also set options manually if needed
                $('.showImage').tooltip({
                    placement: 'top',
                    title: 'Before'
                });
            });
        $(document).ready(function() {
            // Initialize DataTables
            var addTable = $('#addnewtask').DataTable({
                ordering: false
            });
            var inProgTable = $('#statusinprogress').DataTable({
                ordering: false
            });
            var apprTable = $('#approval').DataTable({
                ordering: false
            });
            var compTable = $('#addnewtaskcompleted').DataTable({
                ordering: false
            });
            var notApprTable = $('#statusnotapproved').DataTable({
                ordering: false
            });


        });
    </script>
    <script>
    $(document).on('click', '.view-complaint', function(e) {
    e.preventDefault();
    var taskId = $(this).data('task-id');

    $.ajax({
        url: 'backend.php',
        type: 'POST',
        data: {
            fetch_details: true,
            task_id: taskId
        },
        success: function(response) {
            console.log("Raw response:", response);

            // If response is a JSON string, parse it
            var data = typeof response === "string" ? JSON.parse(response) : response;

            if (data.error) {
                alert(data.error);
            } else {
               

                // Update modal content with data
                $('#faculty_name').text(data.faculty_name);
                $('#contact').text(data.faculty_contact);
                $('#block-content').text(data.block_venue);
                $('#venue-content').text(data.venue_name);
                $('#problem-description-content').text(data.problem_description);
                $('#days-remaining-content').text(data.days_to_complete);

                // Show modal
                $('#Modal1').modal('show');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX error:", textStatus, errorThrown);
            alert('Failed to fetch details');
        }
    });
});

</script>
    <script>
        //start work in new task table
        $(document).ready(function() {
            $('.start-work-btn').click(function(e) {
                e.preventDefault();
                var taskId = $(this).data('task-id');
                console.log(taskId);

                $.ajax({
                    url: 'backend.php',
                    type: 'POST',
                    data: {
                        start_work: true,
                        task_id: taskId
                    },
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if(res.status == 200) {
                            $('#addnewtask').DataTable().destroy();

$("#addnewtask").load(location.href + " #addnewtask > *", function() {
    // Reinitialize the DataTable after the content is loaded
    $('#addnewtask').DataTable();
});
$('#statusinprogress').DataTable().destroy();

$("#statusinprogress").load(location.href + " #statusinprogress > *", function() {
    // Reinitialize the DataTable after the content is loaded
    $('#statusinprogress').DataTable();
});

$('#approval').DataTable().destroy();

$("#approval").load(location.href + " #approval > *", function() {
    // Reinitialize the DataTable after the content is loaded
    $('#approval').DataTable();
});

$('#addnewtaskcompleted').DataTable().destroy();

$("#addnewtaskcompleted").load(location.href + " #addnewtaskcompleted > *", function() {
    // Reinitialize the DataTable after the content is loaded
    $('#addnewtaskcompleted').DataTable();
});

$('#statusnotapproved').DataTable().destroy();

$("#statusnotapproved").load(location.href + " #statusnotapproved > *", function() {
    // Reinitialize the DataTable after the content is loaded
    $('#statusnotapproved').DataTable();
});

$('#ref1').load(location.href + " #ref1");
                            $('#ref2').load(location.href + " #ref2");

                            $('#ref3').load(location.href + " #ref3");

                            $('#ref4').load(location.href + " #ref4");

                            $('#ref5').load(location.href + " #ref5");




                        }
                        else{
                            alert('Something went wrong')
                        }
                    }
                });
            });
        });

            
        </script>
<script>
        //work completed status in inprogress table
        $(document).on('click', '.work-comp', function(e) {
        e.preventDefault();
        var taskId = $(this).data('task-id');
        $('#Modal2').modal('show');

        $('#taskid').val(taskId);

    });
    </script>
    <script>
          $('input[id="inlineRadio1"]').on('change', function() {
        if ($(this).val() === 'Fully Completed') {
            $('#reason-container').hide();
        } 
    });
    
          $('input[id="inlineRadio2"]').on('change', function() {
        if ($(this).val() === 'Partially Completed') {
            $('#reason-container').show();
        } 
    });
  

    // Handle save button click for work completion
    $(document).on('click', '#save-btn', function(e) {
        var taskId = $('#taskid').val();
        var completionStatus = $('input[name="completionStatus"]:checked').val();
        var imgAfter = $('#imgafter')[0].files[0];
        var reason = $('#reason').val(); // Capture reason from the input field

        if (!taskId || !completionStatus) {
            Swal.fire({
                title: "Invalid!",
                text: "Please provide all required information.",
                icon: "error"
            });
            return;
        }

        // Prepare form data for submission
        var formData = new FormData();
        formData.append("update", true);
        formData.append('task_id', taskId);
        formData.append('completion_status', completionStatus);
        formData.append('reason', reason); // Append reason to form data

        if (imgAfter) {
            formData.append('img_after', imgAfter);
        }

        // AJAX request to submit the form data
        $.ajax({
            url: 'backend.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.fire({
                    title: "Updated!",
                    text: "Work is Completed",
                    icon: "success"
                });
                $('#Modal2').modal('hide');

                // Refresh specific sections dynamically
                setTimeout(function() {
                    $('#addnewtask').DataTable().destroy();

$("#addnewtask").load(location.href + " #addnewtask > *", function() {
    // Reinitialize the DataTable after the content is loaded
    $('#addnewtask').DataTable();
});
$('#statusinprogress').DataTable().destroy();

$("#statusinprogress").load(location.href + " #statusinprogress > *", function() {
    // Reinitialize the DataTable after the content is loaded
    $('#statusinprogress').DataTable();
});

$('#approval').DataTable().destroy();

$("#approval").load(location.href + " #approval > *", function() {
    // Reinitialize the DataTable after the content is loaded
    $('#approval').DataTable();
});

$('#addnewtaskcompleted').DataTable().destroy();

$("#addnewtaskcompleted").load(location.href + " #addnewtaskcompleted > *", function() {
    // Reinitialize the DataTable after the content is loaded
    $('#addnewtaskcompleted').DataTable();
});

$('#statusnotapproved').DataTable().destroy();

$("#statusnotapproved").load(location.href + " #statusnotapproved > *", function() {
    // Reinitialize the DataTable after the content is loaded
    $('#statusnotapproved').DataTable();
});

$('#ref1').load(location.href + " #ref1");
                            $('#ref2').load(location.href + " #ref2");

                            $('#ref3').load(location.href + " #ref3");

                            $('#ref4').load(location.href + " #ref4");

                            $('#ref5').load(location.href + " #ref5");
                }, 500); // Adding a delay to ensure the sections are reloaded after the update
            },
            error: function() {
                Swal.fire({
                    title: "Invalid!",
                    text: "An error occurred. Please try again.",
                    icon: "error"
                });
            }
        });
    });

    // Show the reason input field only when 'Partially Completed' is selected
  


    </script>
    <script>
        //after image showing
        // Show image
        // Show image
        $(document).on('click', '.showImage', function(e) {
            e.preventDefault(); // Prevent form submission
            var task_id = $(this).data('task-id');
            console.log(task_id);

            $.ajax({
                type: "POST",
                url: "backend.php",
                data: {
                    'get_image': true,
                    'task_id': task_id
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    if (response.status == 200) {
                        console.log('Image Path:', response.data.after_photo);

                        if (response.data.after_photo) {
                            $('#modalImage').attr('src', response.data.after_photo);
                        } else {
                            alert('No image found.');
                        }

                        $('#Modal4').modal('show');
                    } else {
                        alert(response.message || 'An error occurred while retrieving the image.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", xhr.responseText);
                    alert('An error occurred: ' + error + "\nStatus: " + status + "\nDetails: " + xhr.responseText);
                }
            });
        });
    </script>
    <script>
        //before image showing
        // Show image
        // Show image
        $(document).on('click', '.showbeforeimg', function(e) {
            e.preventDefault();
            var task_id = $(this).data('task-id');
            console.log(task_id);

            $.ajax({
                type: "POST",
                url: "backend.php",
                data: {
                    'get_bef': true,
                    'task_id': task_id
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    if (response.status == 200) {
                        console.log('Image Path:', response.data.after_photo);

                        if (response.data.after_photo) {
                            $('#modalImage1').attr('src', response.data.after_photo);
                        } else {
                            alert('No image found.');
                        }

                        $('#Modal3').modal('show');
                    } else {
                        alert(response.message || 'An error occurred while retrieving the image.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", xhr.responseText);
                    alert('An error occurred: ' + error + "\nStatus: " + status + "\nDetails: " + xhr.responseText);
                }
            });
        });
    </script>
    <script>
        function validateSize(input) {
            const fileSize = input.files[0].size / 1024;
            var ext = input.value.split(".");
            ext = ext[ext.length - 1].toLowerCase();
            var arrayExtensions = ["jpg", "jpeg","png"];
            if (arrayExtensions.lastIndexOf(ext) == -1) {
                alert("Invalid file type");
                $(input).val('');

            } else if (fileSize > 2048057 ) {
                alert("file is too large");
                $(input).val('');
            }

        }
    </script>




</body>

</html>