<?php
include("db.php");
$sql1 = "SELECT 
    cd.*, 
    c.*, 
    f.faculty_name, 
    f.department, 
    f.faculty_contact, 
    f.faculty_mail 
FROM 
    complaints_detail AS cd 
LEFT JOIN 
    comments AS c ON cd.id = c.problem_id 
JOIN 
    faculty AS f ON cd.faculty_id = f.faculty_id 
WHERE 
    cd.status = 6";

$result1 = mysqli_query($conn,$sql1);

?>


<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon icon -->
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
</head>

<style>
    .left-sidebar {
        position: absolute;
        width: 250px;
        height: 100%;
        top: 0px;
        z-index: 10;
        padding-top: 64px;
        background: #fff;
        -webkit-box-shadow: 1px 0px 20px rgba(0, 0, 0, 0.08);
        box-shadow: 1px 0px 20px rgba(0, 0, 0, 0.08);
    }
</style>

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
                        <h4 class="page-title">Requirements Status</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="p_index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Requirements</li>
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
                <div class="card">
                    <!-- Tab panes -->
                    <div class="tab-content tabcontent-border">


                        <div class="card">
                            <div class="card-body" style="padding: 10px;">
                                <div class="table-responsive">
                                    <!--id:addnewtask-->
                                    <table id="addnewtask" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>

                                                <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                        <h5>S.No</h5>
                                                    </b></th>
                                                <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                        <h5>Dept</h5>
                                                    </b></th>
                                                <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                        <h5>Block \ Venue</h5>
                                                    </b></th>
                                                <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                        <h5>Complaint</h5>
                                                    </b></th>
                                                <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                        <h5>Image</h5>
                                                    </b></th>
                                                <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                        <h5>Date_raised</h5>
                                                    </b></th>

                                                <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                        <h5>Requirements</h5>
                                                    </b></th>
                                                <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                        <h5>Action</h5>
                                                    </b></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $s = 1;
                                            while ($row = mysqli_fetch_array($result1)) {
                                            ?>
                                                <tr>
                                                    <th class="text-center" scope="row"><?php echo $s ?></td>
                                                    <td class="text-center"><?php echo $row['department'] ?></td>
                                                    <td class="text-center"><?php echo $row['block_venue'] ?> \ <?php echo $row['venue_name'] ?></td>

                                                    <td class="text-center"><button type="button" class=" btn viewcomplaint margin-5" data-toggle="modal" data-target="#<?php echo $row['problem_id']; ?>" height="30px" width="30px"><i class="fas fa-eye" style="font-size: 25px;"></i></button></td>
                                                    <!--Description id=problem-->


                                                    <!-- Complaint Details Modal -->
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
                                                    <td class="text-center">

                                                        <button type="button" class="btn showImage1" data-toggle="modal" data-target="imageModal1" data-id="<?php echo $row['problem_id']; ?>"><i class="fas fa-image" style="font-size: 25px;"></i></button>
                                                    </td>

                                                    <td class="text-center"><?php echo $row['date_of_reg'] ?></td>

                                                    <td class="text-center"><?php echo $row['reason'] ?></td>
                                                    <td class="text-center">
                                                        <button type="button" value="<?php echo $row['problem_id'] ?>" class="btn btn-success userapprove"><i class="fas fa-check"></i></button>

                                                        <button type="button" value="<?php echo $row['problem_id']; ?>" class="btn btn-danger userreject" data-toggle="modal" data-target="#rejectModal"><i class="fas fa-times"></i></button>

                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            $s++
                                            ?>

                                        </tbody>

                                    </table>
                                </div>

                            </div>
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

    <footer class="footer text-center" style="padding-left: 250px;">
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
    </div>


    <!--Task Completion--><!--Id:comment-->
    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Problem</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="rejectreason">
                    <div class="modal-body">
                        <p>Are you sure you want to reject this problem?</p>
                        <textarea name="reason" class="form-control" placeholder="Reason for rejection" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- problem description -->


    <!-- image-->
    <!-- ============================================================== -->
    <div class="modal fade" id="imageModal1" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
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
                        <img id="modalImage1" src="" alt="Image" class="img-fluid" style="width:1500px;height:250px;">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


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
    <!--for data table-->
    <script src="assets/extra-libs/DataTables/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>

    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js" integrity="sha512-JnjG+Wt53GspUQXQhc+c4j8SBERsgJAoHeehagKHlxQN+MtCCmFDghX9/AcbkkNRZptyZU4zC8utK59M5L45Iw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        //Tool Tip
        $(function() {
            // Initialize the tooltip
            $('[data-toggle="tooltip"]').tooltip();

            // You can also set options manually if needed
            $('.userreject').tooltip({
                placement: 'top',
                title: 'Reject'
            });
        });

        $(function() {
            // Initialize the tooltip
            $('[data-toggle="tooltip"]').tooltip();

            // You can also set options manually if needed
            $('.userapprove').tooltip({
                placement: 'top',
                title: 'Accept'
            });
        });

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
            $('.viewcomplaint').tooltip({
                placement: 'top',
                title: 'View Complaint'
            });
        });


        $(document).ready(function() {
            $('#addnewtask').DataTable();
        });

        //requirement approve
        $(document).on('click', '.userapprove', function(e) {
            e.preventDefault();
            var user_id = $(this).val();
            console.log(user_id);
            if (confirm('Are you sure you want to approve?')) {

                $.ajax({
                    type: "POST",
                    url: "backend1.php",
                    data: {
                        'approve_user': true,
                        'user_id': user_id
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {
                            alert(res.message);
                        } else {
                            Swal.fire({
                                title: "Approved!",
                                text: "Requirements are verified!",
                                icon: "success"
                            });
                            $('#addnewtask').load(location.href + " #addnewtask");
                            $('#addnewtask').DataTable().destroy();

                            $("#addnewtask").load(location.href + " #addnewtask > *", function() {
                                // Reinitialize the DataTable after the content is loaded
                                $('#addnewtask').DataTable();
                            });
                        }
                    }
                });
            }
        });

        //reject 
        $(document).on('submit', '#rejectreason', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Create a FormData object from the form
            var formData = new FormData(this);

            // Get the problem_id from the button that triggered the modal
            var problem_id = $('#rejectModal').data('problem_id');
            console.log(problem_id);

            // Append the problem_id to the FormData
            formData.append("problem_id", problem_id);
            formData.append("save_reason", true); // Add an identifier for the backend

            // Perform the AJAX request
            $.ajax({
                type: "POST",
                url: "backend1.php", // Replace with your backend PHP script
                data: formData,
                processData: false, // Important: Prevent jQuery from processing the data
                contentType: false, // Important: Prevent jQuery from setting the content type
                success: function(response) {
                    console.log(response);
                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        // Hide the modal on success

                        $('#rejectModal').modal('hide');

                        // Reset the form after submission
                        $('#rejectreason')[0].reset();
                        // Reload the task or the section after update
                        
                        $('#addnewtask').load(location.href + " #addnewtask");
                            $('#addnewtask').DataTable().destroy();

                            $("#addnewtask").load(location.href + " #addnewtask > *", function() {
                                // Reinitialize the DataTable after the content is loaded
                                $('#addnewtask').DataTable();
                            });
                        alertify.error('Rejected Success');
                    } else {
                        // Handle errors
                        alertify.error('Error Occured');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle any errors that occurred during the request
                    console.error('AJAX Error:', error);
                    alert('An error occurred. Please try again.');
                }
            });
        });

        // Pass the problem_id to the modal when it is shown
        $('#rejectModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var problem_id = button.val(); // Extract problem_id from button value
            var modal = $(this);
            modal.data('problem_id', problem_id); // Store problem_id in the modal's data attribute
        });

        //image
        // Show image
        $(document).on('click', '.showImage1', function() {
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
                        $('#modalImage1').attr('src', 'uploads/' + res.data.images); // Dynamically set the image source
                        $('#imageModal1').modal('show'); // Show the modal
                    }
                }
            });
        });
    </script>



</body>

</html>