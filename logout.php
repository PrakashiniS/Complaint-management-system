<?php
session_start();
session_destroy(); // End the session
header("Location: faculty_login.php"); // Redirect to login page
exit();
