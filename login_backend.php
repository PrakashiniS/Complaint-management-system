<?php
session_start();
include('db.php'); // Include the database connection file

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $faculty_id = mysqli_real_escape_string($conn, $_POST['faculty_id']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check if faculty ID and password match
    $query = "SELECT * FROM faculty WHERE faculty_id = '$faculty_id' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    // If user exists
    if (mysqli_num_rows($result) == 1) {
        $_SESSION['faculty_id'] = $faculty_id; // Store faculty ID in session
        header("Location: completedtable.php"); // Redirect to the completedtable page
        exit();
    } else {
        // Invalid credentials
        echo "<script>alert('Invalid Faculty ID or Password. Please try again.'); window.location.href='flogin.php';</script>";
    }
} else {
    header("Location: flogin.php"); // Redirect back to login page if accessed without form submission
    exit();
}
