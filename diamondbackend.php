<?php
header('Content-Type: application/json');
include 'db.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize response array
    $response = array();

    // Fetch total complaints
    $query1 = "SELECT COUNT(*) as complain FROM complaints_detail WHERE status > 0";
    $output1 = mysqli_query($conn, $query1);
    $row1 = mysqli_fetch_assoc($output1);
    $response['complainCount'] = $row1['complain'];

    // Fetch completed complaints
    $query2 = "SELECT COUNT(*) as completed FROM complaints_detail WHERE status = '13'";
    $output2 = mysqli_query($conn, $query2);
    $row2 = mysqli_fetch_assoc($output2);
    $response['completedCount'] = $row2['completed'];

    // Fetch in-progress complaints
    $query3 = "SELECT COUNT(*) as inprogress FROM complaints_detail WHERE status = '10'";
    $output3 = mysqli_query($conn, $query3);
    $row3 = mysqli_fetch_assoc($output3);
    $response['inprogressCount'] = $row3['inprogress'];

    // Fetch pending status
    $query4 = "SELECT COUNT(*) as pending FROM complaints_detail WHERE status ='7'";
    $output4 = mysqli_query($conn, $query4);
    $row4 = mysqli_fetch_assoc($output4);
    $response['pendingCount'] = $row4['pending'];

    // Fetch request count
    $query5 = "SELECT COUNT(*) as request FROM complaints_detail WHERE status ='6'";
    $output5 = mysqli_query($conn, $query5);
    $row5 = mysqli_fetch_assoc($output5);
    $response['requestCount'] = $row5['request'];

    // Fetch reassigned work
    $query6 = "SELECT COUNT(*) as reassign FROM complaints_detail WHERE status ='14'";
    $output6 = mysqli_query($conn, $query6);
    $row6 = mysqli_fetch_assoc($output6);
    $response['reassignCount'] = $row6['reassign'];

    // Query to get counts of each type_of_problem
    $query7 = "SELECT type_of_problem, COUNT(*) as count FROM complaints_detail WHERE status IN ('7', '10','17') GROUP BY type_of_problem";
    $output7 = $conn->query($query7);

    //  pie chart count to display Initialize an array to store type_of_problem counts
    $typeOfProblemCounts = array();
    while ($row7 = $output7->fetch_assoc()) {
        $typeOfProblemCounts[] = $row7;
    }
    $response['typeOfProblemCounts'] = $typeOfProblemCounts;

    // Return the full response as a JSON object
    echo json_encode($response);
} else {
    echo json_encode(array("error" => "Invalid request method."));
}
?>
