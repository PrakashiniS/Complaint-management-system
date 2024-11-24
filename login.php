<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "complaints";
session_start();
$data = mysqli_connect($host, $user, $password, $db);

if ($data === false) {
    die("Connection error");
}

$error_flag = false; // Error flag to trigger SweetAlert
$success_flag = false; // Success flag to trigger SweetAlert

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $worker_id = $_POST["worker_id"];
    $password = $_POST["password"];
    $_SESSION['worker_id'] = $worker_id;

    // Prepare and bind
    $stmt = $data->prepare("SELECT * FROM worker_details WHERE worker_id = ? AND password = ?");
    $stmt->bind_param("ss", $worker_id, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $_SESSION["worker_id"] = $worker_id;
        $success_flag = true; // Set the success flag for SweetAlert

        if ($row["usertype"] == "user") {
            // Delay redirect to show SweetAlert
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'index.php';
                    }, 2000); // Redirect after 2 seconds
                  </script>";
        } elseif ($row["usertype"] == "admin") {
            // Delay redirect to show SweetAlert
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'adminhome.php';
                    }, 2000); // Redirect after 2 seconds
                  </script>";
        }
    } else {
        $error_flag = true; // Trigger error flag if credentials are wrong
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - CMS</title>
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <link href="dist/css/style.min.css" rel="stylesheet">

    <!-- Include SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* Custom styles for the login page */
        body {
            background-color: #1a1a1a;
        }

        .auth-wrapper {
            height: 100vh;
        }

        .auth-box {
            width: 400px;
            padding: 30px;
            background: #2c2c2c;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
        }

        .auth-box .input-group-text {
            background-color: #343a40;
            border-color: #343a40;
        }

        .auth-box .form-control {
            background-color: #2c2c2c;
            color: #fff;
            border-color: #343a40;
        }

        .auth-box .form-control:focus {
            background-color: #2c2c2c;
            color: #fff;
            border-color: #ffc107;
            box-shadow: none;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .btn-info:hover {
            background-color: #138496;
            border-color: #117a8b;
        }

        .alert {
            margin-top: 20px;
            font-size: 14px;
        }

        .preloader .lds-ripple {
            width: 64px;
            height: 64px;
        }

        .preloader .lds-pos {
            width: 8px;
            height: 8px;
            background-color: #28a745;
        }
    </style>
</head>

<body>
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>

        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
            <div class="auth-box bg-dark border-top border-secondary">
                <div id="loginform">
                    <div class="text-center p-t-20 p-b-20">
                        <h1 class="text-light">Worker login</h1>
                    </div>

                    <form class="form-horizontal m-t-20" id="loginform" action="login.php" method="POST">
                        <div class="row p-b-30">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon1"><i
                                                class="ti-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg" placeholder="Username"
                                        name="worker_id" aria-label="worker_id" id="worker_id"
                                        aria-describedby="basic-addon1" required="">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-warning text-white" id="basic-addon2"><i
                                                class="ti-pencil"></i></span>
                                    </div>
                                    <input type="password" class="form-control form-control-lg" placeholder="Password"
                                        name="password" aria-label="Password" id="password"
                                        aria-describedby="basic-addon2" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="p-t-20">
                                        <button class="btn btn-info" id="to-recover" type="button"><i
                                                class="fa fa-lock m-r-5"></i> Lost password?</button>
                                        <button class="btn btn-success float-right" type="submit">Login</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="recoverform">
                    <div class="text-center">
                        <span class="text-white">Enter your e-mail address below and we will send you instructions how
                            to recover a password.</span>
                    </div>
                    <div class="row m-t-20">
                        <form class="col-12" action="index.html">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-danger text-white" id="basic-addon1"><i
                                            class="ti-email"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-lg" placeholder="Email Address"
                                    aria-label="Email" aria-describedby="basic-addon1">
                            </div>
                            <div class="row m-t-20 p-t-20 border-top border-secondary">
                                <div class="col-12">
                                    <a class="btn btn-success" href="#" id="to-login" name="action">Back To Login</a>
                                    <button class="btn btn-info float-right" type="button"
                                        name="action">Recover</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><br>
                <footer class="text-light ">
                    <center>All Rights Reserved by M.Kumarasamy College of <br>Engineering, Karur.</center>
                </footer>
            </div>
        </div>
    </div>

    <!-- Include SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
        $('[data-toggle="tooltip"]').tooltip();
        $(".preloader").fadeOut();

        <?php if ($error_flag): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Invalid login credentials!',
            });
        <?php endif; ?>

        <?php if ($success_flag): ?>
            Swal.fire({
                icon: 'success',
                title: 'Login Successful!',
                text: 'Redirecting to your dashboard...',
                timer: 2000,
                showConfirmButton: false,
                willClose: () => {
                    // JavaScript redirect will already be handled in PHP, this just confirms the behavior
                }
            });
        <?php endif; ?>
    </script>
</body>

</html>