
<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$db = "complaints";
session_start();
$conn = new mysqli($host, $user, $password, $db);
if (isset($_SESSION['worker_id'])) {
    $worker_id = $_SESSION['worker_id'];
   
} else {
    die("Couldn't find department in session.");
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['department'])){
// Fetch data from the worker_details table
$sql = "SELECT worker_first_name, worker_last_name, worker_emp_type, worker_dept FROM worker_details WHERE worker_id = '$worker_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    $row = $result->fetch_assoc();
    echo json_encode([
        'name' => $row['worker_first_name'],
        'employment_type' => $row['worker_emp_type'],
        'department' => $row['worker_dept'],
    ]);
} else {
    echo json_encode([
        'name' => '',
        'employment_type' => '',
        'department' => '',
    ]);
}


}
?>
