<?php
include("db.php");
//query for 1st table input 
//Faculty complaint table
$sql1 = "SELECT * FROM complaints_detail WHERE status='4'";
$result1 = mysqli_query($conn, $sql1);
$row_count1 = mysqli_num_rows($result1);
//manager table
$sql2 = "SELECT * FROM worker_details";
$result2 = mysqli_query($conn, $sql2);
//worker details fetch panna
$sql3 = "SELECT * FROM complaints_detail WHERE status IN ('7','10','11','13')";
$result3 = mysqli_query($conn, $sql3);
$row_count3 = mysqli_num_rows($result3);

//worker details fetch panna
$sql4 = "
SELECT cd.*, faculty.faculty_name, faculty.department, faculty.faculty_contact, faculty.faculty_mail
FROM complaints_detail cd
JOIN faculty ON cd.faculty_id = faculty.faculty_id
WHERE cd.status = '9'
";
$result4 = mysqli_query($conn, $sql4);
//work finished table
$sql5 = "SELECT * FROM complaints_detail WHERE status = '14'";
$result5 = mysqli_query($conn, $sql5);
$row_count5 = mysqli_num_rows($result5);
//work completed table
$sql6 = "SELECT * FROM complaints_detail WHERE status='16'";
$result6 = mysqli_query($conn, $sql6);
//work reassigned table
$sql7 = "SELECT * FROM complaints_detail WHERE status IN ('15','17','18')";
$result7 = mysqli_query($conn, $sql7);
$row_count7 = mysqli_num_rows($result7);


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


if (isset($_POST['work'])) {
    $work = $_POST['worker_id'];  // The department value
    // Modify the query to select both worker_id and worker_first_name
    $sql8 = "SELECT worker_id, worker_first_name FROM worker_details WHERE worker_dept = '$work'";
    $result8 = mysqli_query($conn, $sql8);

    // Prepare to output options directly
    $options = '';

    while ($row = mysqli_fetch_assoc($result8)) {
        // Echo each worker's ID and name as an option element (worker_id - worker_first_name)
        $options .= '<option value="' . $row['worker_id'] . '">' . $row['worker_id'] . ' - ' . $row['worker_first_name'] . '</option>';
    }

    // Return the options to the AJAX request
    echo $options;
    exit();  // Stop script execution after output
}




if (isset($_POST['form'])) {
    $problem_id = $_POST['problem_id'] ?? null;
    $priority = $_POST['priority'] ?? null;
    $worker = $_POST['worker'] ?? null;

    if ($problem_id && $priority && $worker) {
        $insertQuery = "INSERT INTO manager (problem_id, worker_id, priority) VALUES ('$problem_id', '$worker', '$priority')";
        if (mysqli_query($conn, $insertQuery)) {
            $updateQuery = "UPDATE complaints_detail SET status='7' WHERE id='$problem_id'";
            if (mysqli_query($conn, $updateQuery)) {
                echo "Success: Complaint accepted and status updated successfully!";
                exit;
            } else {
                echo "Error: Failed to update complaint status.";
                exit;
            }
        } else {
            echo "Error: Failed to insert data into manager table.";
            exit;
        }
    } else {
        echo "Error: Required fields are missing.";
        exit;
    }
}


if (isset($_POST['form1'])) {
    $name = $_POST['w_name'];
    $dept = $_POST['w_dept'];
    $contact = $_POST['w_phone'];
    $gender = $_POST['w_gender'];

    // Step 1: Get the first 3 letters of the department
    $dept_prefix = strtoupper(substr($dept, 0, 3));  // Extract first 3 letters and convert to uppercase

    // Step 2: Check the highest worker_id for this department using SUBSTRING to extract the numeric part
    $checkQuery = "SELECT SUBSTRING(worker_id, 4) AS id_number FROM worker_details 
                   WHERE worker_id LIKE '$dept_prefix%' 
                   ORDER BY CAST(SUBSTRING(worker_id, 4) AS UNSIGNED) DESC LIMIT 1";

    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        // Fetch the last used worker_id and extract the number part
        $row = mysqli_fetch_assoc($result);
        $number = intval($row['id_number']) + 1; // Increment the number
    } else {
        // If no previous worker_id exists for this department, start with 01
        $number = 1;
    }

    // Step 3: Format the number to always be 2 digits (e.g., 01, 02, 03, 04)
    $worker_id = $dept_prefix . str_pad($number, 2, '0', STR_PAD_LEFT);

    // Step 4: Insert the new worker with the generated worker_id
    $insertQuery = "INSERT INTO worker_details (worker_id, worker_first_name, worker_dept, worker_mobile, worker_gender) 
                    VALUES ('$worker_id', '$name', '$dept', '$contact', '$gender')";

    if (mysqli_query($conn, $insertQuery)) {
        echo "Success: Worker added with ID $worker_id!";
        exit;
    } else {
        echo "Error: Could not insert worker details.";
        exit;
    }
}



?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>MIC - MKCE</title>

    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="assets/extra-libs/multicheck/multicheck.css">
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="dist/css/style.min.css" rel="stylesheet">

    <!-- CSS Alertify-->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <!-- Bootstrap theme alertify-->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.min.css" />
    <style>
        .nav-tabs .nav-link {
            color: #0033cc;
        }

        .nav-tabs .nav-link.active {
            background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
            color: white;
        }

        /* Dropdown animation */
        .dropdown-menu {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .dropdown-menu.show {
            opacity: 1;
        }

        .selected-priority {
            background-color: blue;
            color: white;
        }
    </style>

    <!-- Additional CSS for Modal -->
    <style>
        .close span {
            display: inline-block;
            transition: transform 0.3s ease-in-out;
        }

        .close:hover span {
            transform: rotate(45deg);
            color: white;
        }

        /* Close Button */
        .modal-header .close {
            font-size: 1.5rem;
            color: white;
            opacity: 1;
            transition: transform 0.3s ease;
            outline: none;
            /* Removes the focus outline */
            border: none;
            /* Ensures no border around the button */
        }

        .modal-header .close:focus {
            outline: none;
            /* Removes focus outline when the button is clicked */
            box-shadow: none;
            /* Ensures no shadow or box effect appears */
        }

        .modal-header .close:hover {
            transform: rotate(90deg);
            color: #ff8080;
        }


        /* priority modal */
        /* Modal Background */
        .modal-content {
            border-radius: 12px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
            background-color: #f5f5f5;

            border: none;
        }

        /* Header Styling with Gradient */
        .modal-header {
            background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
            color: white;
            border-bottom: none;
            padding: 10px 20px;
            border-radius: 12px 12px 0 0;
        }

        .modal-title {
            font-weight: bold;
            font-size: 1.5rem;
        }

        /* Close Button */
        .modal-header .close {
            font-size: 1.5rem;
            color: white;
            opacity: 1;
            transition: transform 0.3s ease;
        }

        .modal-header .close:hover {
            transform: rotate(90deg);
            color: #ff8080;
        }

        /* Modal Body */
        .modal-body {
            font-family: 'Arial', sans-serif;
            color: #333;
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Form Inputs and Labels */
        label {
            font-weight: bold;
            color: #555;
        }

        input[type="date"],
        input[type="text"] {
            border: none;
            /* Removed border */
            border-radius: 8px;
            padding: 5px;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        input[type="date"]:focus,
        input[type="text"]:focus {
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
        }

        /* Radio Buttons */
        .form-check-input[type="radio"] {
            transform: scale(1.2);
            margin-right: 10px;
            outline: none;
            /* Removes the focus outline */
            box-shadow: none !important;
            /* Removes the box-like effect when clicked */
        }

        .form-check-input[type="radio"]:focus {
            box-shadow: none;
            /* Ensures no shadow appears when focused */
        }

        /* Checkbox (No toggle effect) */
        #flexSwitchCheckDefault {
            width: auto;
            height: auto;
            background-color: transparent;
            cursor: pointer;
            transition: none;
            position: relative;
        }

        #flexSwitchCheckDefault:checked {
            background-color: transparent;
        }

        #flexSwitchCheckDefault::after {
            content: none;
        }

        /* Reason Input */
        #reasonInput {
            margin-top: 10px;
        }

        /* Modal Footer Buttons */
        .modal-footer .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .modal-footer .btn-primary:hover {
            background-color: #0056b3;
        }

        .modal-footer .btn-secondary {
            background-color: #6c757d;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .modal-footer .btn-secondary:hover {
            background-color: #5a6268;
        }




        /* Dropdown styling */
        ul.dropdown-menu {
            background-color: #f8f9fa;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            padding: 7px 0;
            text-align: center;
            opacity: 0;
            /* Start hidden */
            transform: translateY(-20px);
            /* Slightly above */
            /* Smooth transition */
            visibility: hidden;
            /* Initially hidden */
        }

        ul.dropdown-menu.show {
            opacity: 1;
            /* Fully visible */
            transform: translateY(0);
            /* Return to original position */
            visibility: visible;
            /* Visible */
        }

        ul.dropdown-menu li {
            display: block;
        }

        ul.dropdown-menu li a {
            display: block;
            padding: 5px 12px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
            /* Smooth hover effect */
        }

        ul.dropdown-menu li a:hover {
            background-color: #e9ecef;
            color: #0056b3;
            border-radius: 10px;
            transform: scale(1.05);
            /* Slight zoom effect on hover */
        }

        /* Center the dropdown items */
        ul.dropdown-menu center {
            display: block;
        }

        /* Animation for dropdown items (staggered effect) */
        ul.dropdown-menu li {
            animation: fadeIn 0.4s ease forwards;
            opacity: 0;
            /* Initially invisible */
        }

        /* Staggering delay for each item */
        ul.dropdown-menu li:nth-child(1) {
            animation-delay: 0.05s;
        }

        ul.dropdown-menu li:nth-child(2) {
            animation-delay: 0.1s;
        }

        ul.dropdown-menu li:nth-child(3) {
            animation-delay: 0.15s;
        }

        ul.dropdown-menu li:nth-child(4) {
            animation-delay: 0.2s;
        }

        ul.dropdown-menu li:nth-child(5) {
            animation-delay: 0.25s;
        }

        ul.dropdown-menu li:nth-child(6) {
            animation-delay: 0.30s;
        }

        /* Keyframes for dropdown items */
        @keyframes fadeIn {
            0% {
                transform: translateY(-20px);
                /* Move vertically */
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                /* Move to original position */
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper">
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

        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Complaints</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card">
                                    <ul class="nav nav-tabs mb-3" role="tablist" id="navrefresh">

                                        <li class="nav-item">
                                            <a class="nav-link active" id="principal-tab" href="#principal" role="tab"
                                                aria-selected="false">
                                                <span class="hidden-xs-down">
                                                    <i class="bi bi-people-fill"></i><b>Assign work</b>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="record-tab" href="#record" role="tab"
                                                aria-selected="false">
                                                <span class="hidden-xs-down">
                                                    <i class="bi bi-repeat"></i><b>Work Record</b>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <button type="button" class="btn btn-primary" style="margin-left:1080px;" data-toggle="modal" data-target="#addworker">
                                    Add worker</button>
                                <div class="modal fade" id="addworker" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content" style="border-radius: 8px; border: 1px solid #ccc;">
                                            <div class="modal-header" style="background-color: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                                                <h5 class="modal-title" id="exampleModalLabel">Add Worker</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="workers">
                                                <div class="modal-body" style="padding: 20px; background-color: #f5f5f5;">
                                                    <input type="text" name="w_name" placeholder="Enter Worker Name" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc; margin-bottom: 15px;">

                                                    <select id="gender" name="w_gender" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc; margin-bottom: 15px;">
                                                        <option value="all">Select Gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>

                                                    <select name="w_dept" id="dept" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc; margin-bottom: 15px;">
                                                        <option value="CIVIL">CIVIL</option>
                                                        <option value="CARPENTER">CARPENTER</option>
                                                        <option value="ELECTRICAL">ELECTRICAL</option>
                                                        <option value="INFRA">INFRA</option>
                                                        <option value="PARTITION">PARTITION</option>
                                                        <option value="PLUMBING">PLUMBING</option>
                                                    </select>

                                                    <input type="text" name="w_phone" placeholder="Enter Phone Number" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc; margin-bottom: 15px;">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" style="background-color: #6c757d; border: none; padding: 10px 20px;">Close</button>
                                                    <button type="submit" class="btn btn-primary" style="background-color: #007bff; border: none; padding: 10px 20px;">Add</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                                <!-- Tables Start -->
                                <div class="tab-content tabcontent-border">


                                    <!-- Complaint Table -->
                                    <div class="tab-pane" id="complain" role="tabpanel">
                                        <div class="table-responsive">
                                            <table id="complain_table" class="table table-striped table-bordered">
                                                <thead
                                                    style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                    <tr>
                                                        <th><b>S.No</b></th>
                                                        <th><b>Raised</b></th>
                                                        <th><b>Dept Name</b></th>
                                                        <th><b>Venue</b></th>
                                                        <th><b>Complaint</b></th>
                                                        <th><b>Picture</b></th>
                                                        <th><b>Action</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $s = 1;
                                                    while ($row = mysqli_fetch_assoc($result1)) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $s ?></td>
                                                            <td><?php echo $row['date_of_reg'] ?></td>
                                                            <td><?php echo $row['department'] ?></td>
                                                            <td><?php echo $row['block_venue'] ?></td>
                                                            <td><button type="button" value="<?php echo $row['id']; ?>"
                                                                    class="btn btn-primary viewcomplaint"
                                                                    data-toggle="modal"
                                                                    data-target="#complaintDetailsModal"> <i class="fas fa-eye" style="font-size: 25px;"></i>
                                                                </button>
                                                            </td>

                                                            <td>
                                                                <button type="button" class="btn btn-light btn-sm showImage"
                                                                    value="<?php echo $row['id']; ?>" data-toggle="modal">
                                                                    <i class="fas fa-image"></i> Before
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-success dropdown-toggle acceptcomplaint"
                                                                    value="<?php echo $row['id']; ?>"
                                                                    data-toggle="dropdown">Accept</button>
                                                                <ul class="dropdown-menu">
                                                                    <center>
                                                                        <li><a href="#" class="worker-option"
                                                                                data-toggle="modal"
                                                                                data-target="#prioritymodal1"
                                                                                data-value="CARPENTER">CARPENTER</a></li>
                                                                        <li><a href="#" class="worker-option"
                                                                                data-toggle="modal"
                                                                                data-target="#prioritymodal1"
                                                                                data-value="ELECTRICAL">ELECTRICAL</a></li>
                                                                        <li><a href="#" class="worker-option"
                                                                                data-toggle="modal"
                                                                                data-target="#prioritymodal1"
                                                                                data-value="CIVIL">CIVIL</a></li>
                                                                        <li><a href="#" class="worker-option"
                                                                                data-toggle="modal"
                                                                                data-target="#prioritymodal1"
                                                                                data-value="PARTITION">PARTITION</a></li>
                                                                        <li><a href="#" class="worker-option"
                                                                                data-toggle="modal"
                                                                                data-target="#prioritymodal1"
                                                                                data-value="PLUMBING">PLUMBING</a></li>
                                                                        <li><a href="#" class="worker-option"
                                                                                data-toggle="modal"
                                                                                data-target="#prioritymodal1"
                                                                                data-value="IT INFRA">IT INFRA</a></li>
                                                                    </center>
                                                                </ul>
                                                                <button type="button" class="btn btn-danger rejectcomplaint"
                                                                    id="rejectbutton" value="<?php echo $row['id']; ?>"
                                                                    data-toggle="modal"
                                                                    data-target="#rejectModal">X</button>

                                                                <button type="button" class="btn btn-primary principalcomplaint"
                                                                    id="principalbutton" value="<?php echo $row['id']; ?>"
                                                                    data-toggle="modal"
                                                                    data-target="#principalModal">need approve</button>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                        $s++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!--Principal | Need Approve Modal -->
                                    <div class="modal fade" id="principalModal" tabindex="-1" role="dialog"
                                        aria-labelledby="principalModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="principalModalLabel">Need Approval</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="principal_Form">
                                                        <input type="hidden" name="id" id="complaint_id89">
                                                        <div class="form-group">
                                                            <label for="approvalReason" class="form-label">Reason for
                                                                Approval</label>
                                                            <textarea class="form-control" name="reason"
                                                                id="approvalReason" rows="3"
                                                                placeholder="Type the reason here..."></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Complaint Details Modal -->
                                    <div class="modal fade" id="complaintDetailsModal" tabindex="-1" role="dialog" aria-labelledby="complaintDetailsModalLabel" aria-hidden="true">
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
                                                                <b><span id="faculty_contact" style="color: #555;"></span></b>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                            <div class="ms-2 me-auto">
                                                                <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">E-mail</div>
                                                                <b><span id="faculty_mail" style="color: #555;"></span></b>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                            <div class="ms-2 me-auto">
                                                                <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Venue Name</div>
                                                                <b><span id="venue_name" style="color: #555;"></span></b>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                            <div class="ms-2 me-auto">
                                                                <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Type of Problem</div>
                                                                <b><span id="type_of_problem" style="color: #555;"></span></b>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-start" style="padding: 10px; background-color: #fff;">
                                                            <div class="ms-2 me-auto">
                                                                <div class="fw-bold" style="font-size: 1.2em; font-weight: 600; color: #007bff;">Problem Description</div>
                                                                <div class="alert alert-light" role="alert" style="border-radius: 6px; background-color: #f1f1f1; padding: 15px; color: #333;">
                                                                    <span id="problem_description"></span>
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

                                    <!-- Priority Modal Box -->
                                    <div class="modal fade" id="prioritymodal1" tabindex="-1" role="dialog" aria-labelledby="priorityModalLabel1" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content" style="border-radius: 8px; border: 1px solid #ccc;">
                                                <div class="modal-header" style="background-color: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                                                    <h5 class="modal-title" id="priorityModalLabel1">Set Priority</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" style="padding: 20px; background-color: #f5f5f5;">
                                                    <form id="form20">
                                                        <input type="hidden" name="problem_id" id="complaint_id77" value="">

                                                        <div class="form-group" style="margin-bottom: 15px;">
                                                            <label for="worker" class="font-weight-bold" style="display: block; margin-bottom: 5px;">Assign Worker:</label>
                                                            <select class="form-control" name="worker" id="worker" style="width: 100%; height: 40px; border-radius: 4px; border: 1px solid #ccc;">
                                                                <option value="">Select Worker</option>
                                                            </select>
                                                        </div>

                                                        <span class="font-weight-bold" style="display: block; margin-bottom: 10px;">Set Priority:</span>
                                                        <ul class="list-group" style="list-style: none; padding: 0;">
                                                            <li class="list-group-item" style="padding: 10px; background-color: #ffffff; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 5px;">
                                                                <input type="radio" class="form-check-input" name="priority" value="High" required>
                                                                <label class="form-check-label">High</label>
                                                            </li>
                                                            <li class="list-group-item" style="padding: 10px; background-color: #ffffff; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 5px;">
                                                                <input type="radio" class="form-check-input" name="priority" value="Medium">
                                                                <label class="form-check-label">Medium</label>
                                                            </li>
                                                            <li class="list-group-item" style="padding: 10px; background-color: #ffffff; border: 1px solid #ddd; border-radius: 4px;">
                                                                <input type="radio" class="form-check-input" name="priority" value="Low">
                                                                <label class="form-check-label">Low</label>
                                                            </li>
                                                        </ul>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary" style="background-color: #007bff; border: none; padding: 12px 15px; font-size: 12px;">Submit</button>
                                                    <button type="button" class="btn btn-secondary" style="background-color: #6c757d; border: none; padding: 12px 15px; font-size: 12px;" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                            </form>

                                        </div>
                                    </div>





                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog"
                                        aria-labelledby="rejectModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="rejectModalLabel">Reject Complaint</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="rejectForm">
                                                        <input type="hidden" name="id" id="complaint_id99">
                                                        <div class="form-group">
                                                            <label for="rejectReason" class="form-label">Reason for
                                                                rejection</label>
                                                            <textarea class="form-control" name="feedback"
                                                                id="rejectReason" rows="3"
                                                                placeholder="Type the reason here..."></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Worker Table -->
                                    <div class="tab-pane" id="worker" role="tabpanel">
                                        <div class="table-responsive">
                                            <table id="worker_table" class="table table-striped table-bordered">
                                                <thead
                                                    style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                    <tr>
                                                        <th><b>S.No</b></th>
                                                        <th><b>Complaint</b></th>
                                                        <th><b>Worker Details</b></th>
                                                        <th><b>Deadline</b></th>
                                                        <th><b>Picture</b></th>
                                                        <th><b>Status</b></th>
                                                        <th><b>Principal Query</b></th>
                                                        <th><b>Your Reply</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $s = 1;
                                                    $current_date = date('Y-m-d'); // Get current date in 'YYYY-MM-DD' format

                                                    while ($row3 = mysqli_fetch_assoc($result3)) {
                                                        $deadline = $row3['days_to_complete'];
                                                        $h = $row3['id']; // complaint id

                                                        // Fetch query from manager table
                                                        $querydisplay = "SELECT * FROM manager WHERE problem_id=$h";
                                                        $resultdisplay = mysqli_query($conn, $querydisplay);
                                                        $rowdis = mysqli_fetch_assoc($resultdisplay);
                                                        $comment_query = $rowdis['comment_query'];
                                                        $comment_reply = $rowdis['comment_reply']; // Fetch the reply
                                                        $reply_date = $rowdis['reply_date']; // Fetch the reply date
                                                        $task_id = $rowdis['task_id']; // Unique ID from manager table

                                                        // Check if comment_reply has a value to assign the green color class
                                                        $buttonClass = empty($comment_reply) ? 'btn-primary' : 'btn-success';

                                                        // Check if current date is equal to or greater than the deadline
                                                        $rowBackground = ($current_date >= $deadline) ? 'background-color: #ffcccc;' : '';
                                                    ?>
                                                        <tr style="<?php echo $rowBackground; ?>">
                                                            <td><?php echo $s ?></td>
                                                            <td>
                                                                <button type="button" value="<?php echo $row3['id']; ?>"
                                                                    class="btn btn-primary viewcomplaint"
                                                                    data-toggle="modal"
                                                                    data-target="#complaintDetailsModal">See More</button>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-primary"
                                                                    value="<?php echo $row3['id']; ?>" id="seeworker"
                                                                    data-toggle="modal"
                                                                    data-target="#detailsModal">Details</button>
                                                            </td>
                                                            <td><?php echo $row3['days_to_complete'] ?></td>
                                                            <td>
                                                                <button type="button" class="btn btn-light btn-sm showImage"
                                                                    value="<?php echo $row3['id']; ?>" data-toggle="modal">
                                                                    <i class="fas fa-image"></i> Before
                                                                </button>
                                                            </td>
                                                            <td><span class="btn btn-warning">In Progress</span></td>

                                                            <td>
                                                                <button type="button"
                                                                    class="btn <?php echo $buttonClass; ?> openQueryModal"
                                                                    data-task-id="<?php echo $task_id; ?>"
                                                                    data-comment-query="<?php echo $comment_query; ?>"
                                                                    data-toggle="modal"
                                                                    data-target="#principalQueryModal"
                                                                    <?php echo empty($comment_query) ? 'disabled' : ''; ?>>
                                                                    <?php echo empty($comment_query) ? 'No Query' : 'View Query'; ?>
                                                                </button>
                                                            </td>


                                                            <!-- Display Comment Reply and Date if available -->
                                                            <td>
                                                                <?php if (!empty($comment_reply)): ?>
                                                                    <span> <?php echo $comment_reply; ?></span>
                                                                    <br>
                                                                    <span class="">Reply Date: <?php echo $reply_date; ?></span>
                                                                <?php else: ?>
                                                                    <span class="badge badge-secondary">No Reply Yet</span>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                        $s++;
                                                    }
                                                    ?>
                                                </tbody>


                                            </table>
                                        </div>
                                    </div>


                                    <!-- Principal Question Modal -->
                                    <div class="modal fade" id="principalQueryModal" tabindex="-1" role="dialog"
                                        aria-labelledby="principalQueryLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="principalQueryLabel">Principal's Query
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Question from comment_query -->
                                                    <p id="commentQueryText"></p>
                                                    <!-- Input for reply -->
                                                    <div class="form-group">
                                                        <label for="commentReply">Your Reply</label>
                                                        <input type="text" class="form-control" id="commentReply"
                                                            placeholder="Enter your reply">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary"
                                                        id="submitReply">Submit Reply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Principal Table -->
                                    <div class="tab-pane active show" id="principal" role="tabpanel">
                                        <div class="table-responsive">
                                            <table id="principal_table" class="table table-striped table-bordered">
                                                <thead
                                                    style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                    <tr>
                                                        <th><b>S.No</b></th>
                                                        <th><b>Raised Date</b></th>
                                                        <th><b>Venue</b></th>
                                                        <th><b>Complaint</b></th>
                                                        <th><b>Picture</b></th>
                                                        <th><b>Action</b></th>
                                                        <th><b>Status</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $s = 1;
                                                    while ($row4 = mysqli_fetch_assoc($result4)) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $s ?></td>
                                                            <td><?php echo $row4['date_of_reg'] ?></td>
                                                            <td><?php echo $row4['block_venue'] ?></td>
                                                            <td>
                                                                <button type="button" value="<?php echo $row4['id']; ?>"
                                                                    class="btn btn viewcomplaint"
                                                                    data-toggle="modal"
                                                                    data-target="#complaintDetailsModal">
                                                                    <i class="fas fa-eye" style="font-size: 25px;"></i>
                                                                </button>
                                                            </td>

                                                            <td>
                                                                <button type="button" class="btn btn-light btn-sm showImage"
                                                                    value="<?php echo $row4['id']; ?>" data-toggle="modal">
                                                                    <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button"
                                                                    class="btn btn-success dropdown-toggle acceptcomplaint"
                                                                    value="<?php echo $row4['id']; ?>"
                                                                    data-toggle="dropdown"><i class="fas fa-check"></i></button>
                                                                <ul class="dropdown-menu">
                                                                    <center>
                                                                        <li><a href="#" class="worker"
                                                                                data-toggle="modal"
                                                                                data-target="#prioritymodal1"
                                                                                data-value="CARPENTER   ">CARPENTER</a></li>
                                                                        <li><a href="#" class="worker"
                                                                                data-toggle="modal"
                                                                                data-target="#prioritymodal1"
                                                                                data-value="ELECTRICAL">ELECTRICAL</a></li>
                                                                        <li><a href="#" class="worker"
                                                                                data-toggle="modal"
                                                                                data-target="#prioritymodal1"
                                                                                data-value="CIVIL">CIVIL</a></li>
                                                                        <li><a href="#" class="worker"
                                                                                data-toggle="modal"
                                                                                data-target="#prioritymodal1"
                                                                                data-value="PARTITION">PARTITION</a></li>
                                                                        <li><a href="#" class="worker"
                                                                                data-toggle="modal"
                                                                                data-target="#prioritymodal1"
                                                                                data-value="PLUMBING">PLUMBING</a></li>
                                                                        <li><a href="#" class="worker"
                                                                                data-toggle="modal"
                                                                                data-target="#prioritymodal1"
                                                                                data-value="INFRA">INFRA</a></li>
                                                                    </center>
                                                                </ul>

                                                            </td>
                                                            <td>
                                                                <span class="btn btn-success">Approved</span>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                        $s++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Work Finished Table -->
                                    <div class="tab-pane" id="finished" role="tabpanel">
                                        <div class="table-responsive">
                                            <table id="finished_table" class="table table-striped table-bordered">
                                                <thead
                                                    style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                    <tr>
                                                        <th><b>S.No</b></th>
                                                        <th><b>Complaint</b></th>
                                                        <th><b>Worker Details</b></th>
                                                        <th><b>Date of Completion</b></th>
                                                        <th><b>Picture</b></th>
                                                        <th><b>Faculty Feedback/Action</b></th>
                                                        <th><b>Status</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $s = 1;
                                                    while ($row5 = mysqli_fetch_assoc($result5)) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $s ?></td>
                                                            <td>
                                                                <button type="button" value="<?php echo $row5['id']; ?>"
                                                                    class="btn btn-primary viewcomplaint"
                                                                    data-toggle="modal"
                                                                    data-target="#complaintDetailsModal">
                                                                    See More
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-primary"
                                                                    value="<?php echo $row5['id']; ?>" id="seeworker"
                                                                    data-toggle="modal" data-target="#detailsModal">
                                                                    Details
                                                                </button>
                                                            </td>
                                                            <td><?php echo $row5['date_of_completion'] ?></td>
                                                            <td>
                                                                <button type="button" class="btn btn-light btn-sm showImage"
                                                                    value="<?php echo $row5['id']; ?>" data-toggle="modal">
                                                                    <i class="fas fa-image"></i> Before
                                                                </button>
                                                                <button value="<?php echo $row5['id']; ?>" type="button"
                                                                    class="btn btn-light btn-sm imgafter"
                                                                    data-toggle="modal">
                                                                    <i class="fas fa-image"></i> After
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-primary facfeed"
                                                                    value="<?php echo $row5['id']; ?>" data-toggle="modal"
                                                                    data-target="#exampleModal">
                                                                    Feedback
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="btn btn-success"><?php echo $row5['task_completion'] ?></span>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                        $s++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Resigned Table -->
                                    <div class="tab-pane" id="reassigned" role="tabpanel">
                                        <div class="table-responsive">
                                            <table id="reassigned_table" class="table table-striped table-bordered">
                                                <thead
                                                    style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                    <tr>
                                                        <th><b>S.No</b></th>
                                                        <th><b>Complaint</b></th>
                                                        <th><b>Worker Details</b></th>
                                                        <th><b>Date of Reassigned</b></th>
                                                        <th><b>Deadline</b></th>
                                                        <th><b>Picture</b></th>
                                                        <th><b>Faculty Feedback</b></th>
                                                        <!-- <th><b>Status</b></th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $s = 1;
                                                    while ($row7 = mysqli_fetch_assoc($result7)) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $s ?></td>
                                                            <td>
                                                                <button type="button" value="<?php echo $row7['id']; ?>"
                                                                    class="btn btn-primary viewcomplaint"
                                                                    data-toggle="modal"
                                                                    data-target="#complaintDetailsModal">
                                                                    See More
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-primary"
                                                                    value="<?php echo $row7['id']; ?>" id="seeworker"
                                                                    data-toggle="modal" data-target="#detailsModal">
                                                                    Details
                                                                </button>
                                                            </td>
                                                            <td><?php echo $row7['reassign_date'] ?></td>
                                                            <td><?php echo $row7['days_to_complete'] ?></td>
                                                            <td>
                                                                <button type="button" class="btn btn-light btn-sm showImage"
                                                                    value="<?php echo $row7['id']; ?>" data-toggle="modal">
                                                                    <i class="fas fa-image"></i> Before
                                                                </button>
                                                                <button value="<?php echo $row7['id']; ?>" type="button"
                                                                    class="btn btn-light btn-sm imgafter"
                                                                    data-toggle="modal">
                                                                    <i class="fas fa-image"></i> After
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <?php echo $row7['feedback']; ?>
                                                            </td>
                                                            <!-- <td>
                                                                <span class="btn btn-warning">Reassigned</span>
                                                            </td> -->
                                                        </tr>
                                                    <?php
                                                        $s++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Completed Table -->
                                    <div class="tab-pane" id="completed" role="tabpanel">
                                        <div class="table-responsive">
                                            <table id="completed_table" class="table table-striped table-bordered">
                                                <thead
                                                    style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                    <tr>
                                                        <th><b>S.No</b></th>
                                                        <th><b>Complaint</b></th>
                                                        <th><b>Worker Details</b></th>
                                                        <th><b>Date of Completion</b></th>
                                                        <th><b>Picture</b></th>
                                                        <th><b>Faculty Feedback</b></th>
                                                        <!-- <th><b>Status</b></th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $s = 1;
                                                    while ($row6 = mysqli_fetch_assoc($result6)) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $s ?></td>
                                                            <td>
                                                                <button type="button" value="<?php echo $row6['id']; ?>"
                                                                    class="btn btn-primary viewcomplaint"
                                                                    data-toggle="modal"
                                                                    data-target="#complaintDetailsModal">
                                                                    See More
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-primary"
                                                                    value="<?php echo $row6['id']; ?>" id="seeworker"
                                                                    data-toggle="modal" data-target="#detailsModal">
                                                                    Details
                                                                </button>
                                                            </td>
                                                            <td><?php echo $row6['date_of_completion'] ?></td>
                                                            <td>
                                                                <button type="button" class="btn btn-light btn-sm showImage"
                                                                    value="<?php echo $row6['id']; ?>" data-toggle="modal">
                                                                    <i class="fas fa-image"></i> Before
                                                                </button>
                                                                <button value="<?php echo $row6['id']; ?>" type="button"
                                                                    class="btn btn-light btn-sm imgafter"
                                                                    data-toggle="modal">
                                                                    <i class="fas fa-image"></i> After
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <?php echo $row6['feedback']; ?>
                                                            </td>
                                                            <!-- <td>
                                                                <span class="btn btn-success">Completed</span>
                                                            </td> -->
                                                        </tr>
                                                    <?php
                                                        $s++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Record Table -->

                                    <?php
                                    // Set default month as the current month if no input is provided
                                    $selectedMonth = isset($_POST['selectmonth']) ? $_POST['selectmonth'] : date('m');

                                    // Fetch data based on the selected month
                                    $sql8 = "SELECT * FROM complaints_detail WHERE status='16' AND MONTH(date_of_completion) = $selectedMonth AND YEAR(date_of_completion) = YEAR(CURDATE())";
                                    $result8 = mysqli_query($conn, $sql8);
                                    ?>

                                    <div class="tab-pane p-20" id="record" role="tabpanel">
                                        <div class="p-20">
                                            <div class="table-responsive">
                                                <h5 class="card-title">Work Completed Records</h5>

                                                <form method="POST" action="">
                                                    <label for="selectmonth">Select Month (1-12): </label>
                                                    <input type="number" name="selectmonth" min="1" max="12" value="<?php echo $selectedMonth; ?>" required>
                                                    <button type="submit" class="btn btn-primary">Enter</button>
                                                </form><span style="float:right">
                                                    <button id="download" class="btn btn-success">Download as Excel</button></span><br><br>

                                                <table id="record_table" class="table table-striped table-bordered">
                                                    <thead style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                        <tr>
                                                            <th class="text-center"><b>
                                                                    <h5>S.No</h5>
                                                                </b></th>
                                                            <th class="col-md-2 text-center"><b>
                                                                    <h5>Work ID</h5>
                                                                </b></th>
                                                            <th class="text-center"><b>
                                                                    <h5>Venue Details</h5>
                                                                </b></th>
                                                            <th class="text-center"><b>
                                                                    <h5>Completed Details</h5>
                                                                </b></th>
                                                            <th class="text-center">
                                                                <b>
                                                                    <h5>Completed On</h5>
                                                                </b>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $s = 1;
                                                        while ($row = mysqli_fetch_assoc($result8)) {
                                                            $pid = $row['id'];
                                                        ?>
                                                            <tr>
                                                                <td class="text-center"><?php echo $s ?></td>
                                                                <td class="text-center"><?php echo $row['id'] ?></td>
                                                                <td class="text-center">Venue: <?php echo $row['block_venue'] ?> | <br>Problem: <?php echo $row['problem_description'] ?></td>
                                                                <td class="text-center">
                                                                    <?php
                                                                    $id = "SELECT * FROM manager WHERE problem_id=$pid";
                                                                    $query_run1 = mysqli_query($conn, $id);
                                                                    $roww = mysqli_fetch_array($query_run1);
                                                                    $worker_id = $roww['worker_id'];

                                                                    // Fetch worker details
                                                                    $query = "SELECT * FROM worker_details WHERE worker_id='$worker_id'";
                                                                    $query_run = mysqli_query($conn, $query);
                                                                    $User_data = mysqli_fetch_array($query_run); ?>
                                                                    Completed by: <?php echo $User_data['worker_first_name'] ?> | <br>
                                                                    Department: <?php echo $User_data['worker_dept'] ?>
                                                                </td>
                                                                <td class="text-center"><?php echo $row['date_of_completion'] ?></td>
                                                            </tr>
                                                        <?php
                                                            $s++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- Worker Details Modal -->
                                    <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog"
                                        aria-labelledby="detailsModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header"
                                                    style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                    <h5 class="modal-title" id="detailsModalLabel">Worker Details</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="viewcomplaint" style="font-size: 16px;">
                                                        <p><strong>Worker Name:</strong>
                                                            <span id="worker_first_name"></span>
                                                        </p>
                                                        <p><strong>Worker Contact:</strong>
                                                            <span id="worker_mobile"></span>
                                                        </p>
                                                        <p><strong>Worker Mail:</strong>
                                                            <span id="worker_mail"></span>
                                                        </p>
                                                        <p><strong>Worker Department:</strong>
                                                            <span id="worker_dept"></span>
                                                        </p>
                                                        <p><strong>Working Type:</strong>
                                                            <span id="worker_emp_type"></span>
                                                        </p>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Ans query Modal -->
                                    <div class="modal fade" id="ansquery" tabindex="-1" role="dialog"
                                        aria-labelledby="detailsModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailsModalLabel">Query Details</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Query:</strong> <br>
                                                        <input type="text" name="query2" id="query2" readonly>
                                                    <p><strong>Reply</strong> <br>
                                                        <input type="text" name="reply2" id="reply2" readonly>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Before Image Modal -->
                                    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog"
                                        aria-labelledby="imageModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="imageModalLabel">Image</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img id="modalImage" src="" alt="Image" class="img-fluid"
                                                        style="width: 100%; height: auto;">
                                                    <!-- src will be set dynamically -->
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- After Image Modal -->
                                    <div class="modal fade" id="afterImageModal" tabindex="-1" role="dialog"
                                        aria-labelledby="afterImageModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="afterImageModalLabel">After Picture</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img id="modalImage2" src="" alt="After" class="img-fluid">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Feedback Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Faculty Feedback</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <textarea name="ffeed" id="ffeed" readonly></textarea>
                                                    <!-- Change to complaintfeed_id -->
                                                    <input type="hidden" id="complaintfeed_id" value="">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-success done"
                                                        data-dismiss="modal">Done</button>
                                                    <button type="button" class="btn btn-danger reass">Reassign</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Date Picker Modal -->
                                    <div class="modal fade" id="datePickerModal" tabindex="-1" role="dialog" aria-labelledby="datePickerModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="datePickerModalLabel">Set Reassign Deadline</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <label for="reassign_deadline">Reassign Deadline Date:</label>
                                                    <input type="date" id="reassign_deadline" name="reassign_deadline" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-primary" id="saveDeadline">Set Deadline</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Completed Table Feedback Modal -->
                                    <div class="modal fade" id="completedfeedbackModal" tabindex="-1" role="dialog"
                                        aria-labelledby="completedfeedbackModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="completedfeedbackModalLabel">Faculty
                                                        Feedback</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Content goes here -->
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
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
        </div>
    </div>

    <footer class="footer text-center">
        <b>2024 © M.Kumarasamy College of Engineering All Rights Reserved.<br>
            Developed and Maintained by Technology Innovation Hub.
        </b>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Popper.js for Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <!-- Bootstrap 4 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <!-- Other JavaScript files -->
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>
    <script src="dist/js/waves.js"></script>
    <script src="dist/js/sidebarmenu.js"></script>
    <script src="dist/js/custom.min.js"></script>
    <script src="assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>
    <script src="assets/extra-libs/DataTables/datatables.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!--Download as XL-Sheet-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>


    <script>
        $(function() {
            // Initialize the tooltip
            $('[data-toggle="tooltip"]').tooltip();

            // You can also set options manually if needed
            $('.viewcomplaint').tooltip({
                placement: 'top',
                title: 'View Complaint'
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
            $("#principal_table").DataTable();
        });
        $(document).ready(function() {
            $("#complain_table").DataTable();
        });
        $(document).ready(function() {
            $("#worker_table").DataTable();
        });
        $(document).ready(function() {
            $("#finished_table").DataTable();
        });
        $(document).ready(function() {
            $("#reassigned_table").DataTable();
        });
        $(document).ready(function() {
            $("#completed_table").DataTable();
        });
        $(document).ready(function() {
            $("#record_table").DataTable();
        });

        $(document).ready(function() {
            $(".nav-link").click(function(e) {
                e.preventDefault(); // Prevent default anchor behavior
                // Remove 'active show' class from all nav links
                $(".nav-link").removeClass("active show");
                // Add 'active show' class to the clicked nav link
                $(this).addClass("active show");
                // Hide all tab panes
                $(".tab-pane").removeClass("active show");
                // Show the associated tab pane
                var target = $(this).attr("href");
                $(target).addClass("active show");
            });
        });
    </script>
    <script>
        $(function() {
            // Initialize the tooltip
            $('[data-toggle="tooltip"]').tooltip();

            // You can also set options manually if needed
            $('.acceptcomplaint').tooltip({
                placement: 'top',
                title: 'Accept'
            });
        });
        $(document).on("click", ".worker", function(e) {
            e.preventDefault();
            var worker_id = $(this).data("value");
            console.log(worker_id);

            $.ajax({
                url: "work.php",
                type: "POST",
                data: {
                    "work": true,
                    "worker_id": worker_id
                },
                success: function(response) {
                    // Inject the received HTML options into the <select> element
                    $('#worker').html(response);
                }
            });
        });



        $(document).on("submit", "#form20", function(e) {
            e.preventDefault();
            var dt = new FormData(this);
            dt.append("form", true);

            $.ajax({
                url: "work.php",
                type: "POST",
                data: dt,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Directly check if response contains "Success" or "Error"
                    if (response.includes("Success")) {
                        alertify.success("asigned successfully!");
                        $('#prioritymodal1').hide();
                        window.location.reload();

                    } else {
                        alert(response);
                    }
                },
                error: function(xhr, status, error) {
                    alert("An error occurred: " + error);
                }
            });
        });





        $(document).on("click", ".acceptcomplaint", function(e) {
            e.preventDefault();

            var user_id = $(this).val(); // Get the ID from the button's value
            console.log("User ID:", user_id);

            // Set the complaint ID in the hidden input field within the form
            $("#complaint_id77").val(user_id);

            // Reset the worker selection and the text in the modal
            $("#worker_id").val(''); // Reset the worker ID
            $("#assignedWorker").text('Assigned Worker: '); // Reset the assigned worker text
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".nav-link").click(function(e) {
                e.preventDefault(); // Prevent default anchor behavior
                // Remove 'active show' class from all nav links
                $(".nav-link").removeClass("active show");
                // Add 'active show' class to the clicked nav link
                $(this).addClass("active show");
                // Hide all tab panes
                $(".tab-pane").removeClass("active show");
                // Show the associated tab pane
                var target = $(this).attr("href");
                $(target).addClass("active show");
            });
        });


        $(document).on("click", ".viewcomplaint", function(e) {
            e.preventDefault();
            var user_id = $(this).val();
            console.log(user_id);
            $.ajax({
                type: "POST",
                url: "testbackend.php",
                data: {
                    view_complaint: true,
                    user_id: user_id,
                },
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    console.log(res);
                    if (res.status == 500) {
                        alert(res.message);
                    } else {
                        //$('#student_id2').val(res.data.uid);
                        $("#id").val(res.data.id);
                        $("#type_of_problem").text(res.data.type_of_problem);
                        $("#problem_description").text(res.data.problem_description);
                        $("#faculty_name").text(res.data.faculty_name);
                        $("#faculty_mail").text(res.data.faculty_mail);
                        $("#faculty_contact").text(res.data.faculty_contact);
                        $("#block_venue").text(res.data.block_venue);
                        $("#venue_name").text(res.data.venue_name);
                        $("#complaintDetailsModal").modal("show");
                    }
                },
            });
        });


        $(document).on("click", ".showImage", function() {
            var problem_id = $(this).val(); // Get the problem_id from button value
            console.log(problem_id); // Ensure this logs correctly
            $.ajax({
                type: "POST",
                url: "testbackend.php",
                data: {
                    get_image: true,
                    problem_id: problem_id, // Correct POST key
                },
                dataType: "json", // Automatically parses JSON responses
                success: function(response) {
                    console.log(response); // Log the parsed JSON response
                    if (response.status == 200) {
                        // Dynamically set the image source
                        $("#modalImage").attr("src", "uploads/" + response.data.images);
                        // Show the modal
                        $("#imageModal").modal("show");
                    } else {
                        // Handle case where no image is found
                        alert(
                            response.message || "An error occurred while retrieving the image."
                        );
                    }
                },
                error: function(xhr, status, error) {
                    // Log the full error details for debugging
                    console.error("AJAX Error: ", xhr.responseText);
                    alert(
                        "An error occurred: " +
                        error +
                        "\nStatus: " +
                        status +
                        "\nDetails: " +
                        xhr.responseText
                    );
                },
            });
        });


        $(document).on("click", ".imgafter", function() {
            var problem_id = $(this).val(); // Get the problem_id from button value
            console.log(problem_id); // Ensure this logs correctly
            $.ajax({
                type: "POST",
                url: "testbackend.php",
                data: {
                    get_aimage: true,
                    problem2_id: problem_id, // Correct POST key
                },
                dataType: "json", // Automatically parses JSON responses
                success: function(response) {
                    console.log(response); // Log the parsed JSON response
                    if (response.status == 200) { // Use 'response' instead of 'res'
                        // Dynamically set the image source
                        $("#modalImage2").attr("src", response.data.after_photo);
                        // Show the modal
                        $("#afterImageModal").modal("show");
                    } else {
                        // Handle case where no image is found
                        alert(response.message || "An error occurred while retrieving the image.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", status, error);
                }
            });
        });

        $(document).on("submit", "#workers", function(e) {
            e.preventDefault();
            var dt = new FormData(this);
            console.log(dt);
            dt.append("form1", true);
            $.ajax({
                url: "work.php",
                type: "POST",
                data: dt,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.includes("Success")) {
                        $("#addworker").modal("hide");
                        $('#workers')[0].reset();



                    } else {
                        alert("Error");
                    }
                },
                error: function(xhr, status, error) {
                    alert("An error occurred: " + error);
                }
            });
        })

        document.getElementById('download').addEventListener('click', function() {
            var wb = XLSX.utils.book_new();
            var ws = XLSX.utils.table_to_sheet(document.getElementById('record_table'));
            XLSX.utils.book_append_sheet(wb, ws, "Complaints Data");

            // Create and trigger the download
            XLSX.writeFile(wb, 'complaints_data.xlsx');
        });
    </script>

    <!-- JavaScript Alertify-->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>


</body>

</html>