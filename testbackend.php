<?php
include("db.php");


if (isset($_POST['view_complaint'])) {
    $complain_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $query = "
    SELECT cd.*, faculty.faculty_name, faculty.faculty_contact, faculty.faculty_mail, faculty.department, cd.block_venue
    FROM complaints_detail cd
    JOIN faculty ON cd.faculty_id = faculty.faculty_id
    WHERE cd.id = '$complain_id'
";
    $query_run = mysqli_query($conn, $query);
    $User_data = mysqli_fetch_array($query_run);
    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'details Fetch Successfully by id',
            'data' => $User_data
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Details Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}


//backend for worker details
if (isset($_POST['see_worker_detail'])) {
    $complain_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $id = "SELECT * FROM manager WHERE problem_id='$complain_id'";
    $query_run1 = mysqli_query($conn, $id);
    $row = mysqli_fetch_array($query_run1);
    $worker_id = $row['worker_id'];
    //data only for editing
    $query = "SELECT * FROM worker_details WHERE worker_dept='$worker_id'";
    $query_run = mysqli_query($conn, $query);
    $User_data = mysqli_fetch_array($query_run);
    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'details Fetch Successfully by id',
            'data' => $User_data
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Details Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}


//reject reason
if (isset($_POST["reject_complaint"])) {
    try {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $reason = mysqli_real_escape_string($conn, $_POST['feedback']);
        $query = "UPDATE complaints_detail SET feedback = '$reason', status = '20' WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            $res = [
                'status' => 200,
               
            ];
            echo json_encode($res);
        } else {
            throw new Exception('Query Failed: ' . mysqli_error($conn));
        }
    } catch (Exception $e) {
        $res = [
            'status' => 500,
            'message' => 'Error: ' . $e->getMessage()
        ];
        echo json_encode($res);
    }
}


//Accept reason
if (isset($_POST['accept_complaint'])) {
    $problem_id = $_POST['problem_id'];
    $worker_id = $_POST['worker_id'];
    $priority = $_POST['priority'];
    $worker = $_POST['worker'];


/*     $principal_approval = isset($_POST['principal_approval']) ? 6 : 7;
    $reason = isset($_POST['reason11']) ? $_POST['reason11'] : ''; */
    // Insert into manager table
    $insertQuery = "INSERT INTO manager (problem_id, worker_id, priority) VALUES ('$problem_id', '$worker', '$priority')";
    if (mysqli_query($conn, $insertQuery)) {
        // Update status in complaints_detail table
        $updateQuery = "UPDATE complaints_detail SET status='7' WHERE id='$problem_id'";
        if (mysqli_query($conn, $updateQuery)) {
            $response = ['status' => 200, 'message' => 'Complaint accepted and status updated successfully!'];
          /*   $updateQuery7 = "INSERT INTO comments (problem_id, reason) VALUES ('$problem_id','$reason') ";
            if (mysqli_query($conn, $updateQuery7)) {
                $response = ['status' => 200, 'message' => 'Complaint accepted and status updated successfully!'];
            } else {
                $response = ['status' => 500, 'message' => 'Failed to update comments table.'];
            } */
        } else {
            $response = ['status' => 500, 'message' => 'Failed to update complaint status.'];
        }
    } else {
        $response = ['status' => 500, 'message' => 'Failed to insert data into manager table.'];
    }
    echo json_encode($response);
}


// Check if ID is provided
if (isset($_POST['id'])) {
    $complaint_id = intval($_POST['id']);
    // Prepare SQL query
    $query = "SELECT feedback FROM complaints_detail WHERE id = ? AND status IN ('13', '14')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $complaint_id);
    $stmt->execute();
    $stmt->bind_result($feedback);
    $stmt->fetch();
    $stmt->close();
    // Return the feedback
    echo $feedback;
} 

// Handle reply submission for principal's query
if (isset($_POST['submit_comment_reply'])) {
    $task_id = $_POST['task_id'];
    $comment_reply = $_POST['comment_reply'];
    $reply_date = date('Y-m-d'); // Get current date

    // Update the comment_reply and reply_date fields for the corresponding task_id
    $query = "UPDATE manager SET comment_reply=?, reply_date=? WHERE task_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssi', $comment_reply, $reply_date, $task_id);
    if ($stmt->execute()) {
        $response = ['status' => 200, 'message' => 'Reply submitted successfully!'];
    } else {
        $response = ['status' => 500, 'message' => 'Failed to submit reply.'];
    }
    echo json_encode($response);
}

if (isset($_POST['complaintfeed_id']) && isset($_POST['status'])) {
    $id = $_POST['complaintfeed_id']; // Get the complaint ID from the POST request
    $status = $_POST['status'];
    $current_date = date('Y-m-d'); // Get the current date in the format YYYY-MM-DD

    // Check if a reassign deadline is provided (only when status is 'reassign')
    $reassign_deadline = isset($_POST['reassign_deadline']) ? $_POST['reassign_deadline'] : null;

    // Prepare the SQL query based on the provided status and deadline
    if ($status == 15 && $reassign_deadline) {
        // Status '15' for Reassign, update reassign_date and reassign_deadline
        $sql = "UPDATE complaints_detail SET status='$status', reassign_date='$current_date', days_to_complete='$reassign_deadline' WHERE id='$id'";
    } else {
        // For other statuses, only update status and reassign_date (no reassign_deadline)
        $sql = "UPDATE complaints_detail SET status='$status', reassign_date='$current_date' WHERE id='$id'";
    }

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        echo json_encode([
            'status' => 200,
            'message' => "Status and updates saved successfully."
        ]);
    } else {
        echo json_encode([
            'status' => 500,
            'message' => "Error updating status: " . mysqli_error($conn)
        ]);
    }
}




if (isset($_POST['get_aimage'])) {
    // Get the problem_id from POST request
    $problem_id = isset($_POST['problem2_id']) ? $_POST['problem2_id'] : ''; 

    // Validate problem_id
    if (empty($problem_id)) {
        echo json_encode(['status' => 400, 'message' => 'Problem ID not provided']);
        exit;
    }

    // Log the received problem_id for debugging
    error_log("Problem ID received: " . $problem_id);

    // First, fetch the task_id from the manager table using the problem_id
    $query = "SELECT task_id FROM manager WHERE problem_id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo json_encode(['status' => 500, 'message' => 'Prepare statement failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param('i', $problem_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $task_id = $row['task_id'];

        // Log the fetched task_id for debugging
        error_log("Task ID fetched: " . $task_id);

        $stmt->close();

        // Now, fetch the after_photo using the retrieved task_id
        $query = "SELECT after_photo FROM worker_taskdet WHERE task_id = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            echo json_encode(['status' => 500, 'message' => 'Prepare statement failed: ' . $conn->error]);
            exit;
        }

        $stmt->bind_param('i', $task_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $image_filename = basename($row['after_photo']); // Get the filename
            $image_path = 'imgafter/' . $image_filename; // Path to the image

            echo json_encode(['status' => 200, 'data' => ['after_photo' => $image_path]]);
        } else {
            echo json_encode(['status' => 404, 'message' => 'No image found for the provided task ID']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 404, 'message' => 'No task found for the provided problem ID']);
    }
}

if (isset($_POST['get_image'])) {
    $problem_id = isset($_POST['problem_id']) ? $_POST['problem_id'] : ''; // Ensure problem_id is set
    // Validate problem_id
    if (empty($problem_id)) {
        echo json_encode(['status' => 400, 'message' => 'Problem ID not provided']);
        exit;
    }
    // Query to fetch the image based on problem_id
    $query = "SELECT images FROM complaints_detail WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode(['status' => 500, 'message' => 'Prepare statement failed: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param('i', $problem_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = json_encode(['status' => 200, 'data' => ['images' => $row['images']]]);
        // Log response to debug if the JSON is correctly formed
        error_log("Response: " . $response);
        echo $response;
    } else {
        // Return 404 if no image is found for the given problem_id
        echo json_encode(['status' => 404, 'message' => 'Image not found']);
    }
    $stmt->close();
    $conn->close();
    exit;
}


if (isset($_POST['facfeedview'])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $query = "SELECT * FROM complaints_detail WHERE id=$student_id and status IN ('13', '14')";
    $query_run = mysqli_query($conn, $query);
    //data only for editing
    $User_data = mysqli_fetch_array($query_run);
    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'details Fetch Successfully by id',
            'data' => $User_data
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Details Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}


//Accept reason
if (isset($_POST['principal_complaint'])) {
    $problem_id = $_POST['id'];
    $reason = $_POST['reason'];
/*     $principal_approval = isset($_POST['principal_approval']) ? 6 : 7;
    $reason = isset($_POST['reason11']) ? $_POST['reason11'] : ''; */
    // Insert into manager table
    $insertQuery = "INSERT INTO comments (problem_id, reason) VALUES ('$problem_id','$reason')";
    if (mysqli_query($conn, $insertQuery)) {
        // Update status in complaints_detail table
        $updateQuery = "UPDATE complaints_detail SET status='6' WHERE id='$problem_id'";
        if (mysqli_query($conn, $updateQuery)) {
            $response = ['status' => 200, 'message' => 'Complaint accepted and status updated successfully!'];
          /*   $updateQuery7 = "INSERT INTO comments (problem_id, reason) VALUES ('$problem_id','$reason') ";
            if (mysqli_query($conn, $updateQuery7)) {
                $response = ['status' => 200, 'message' => 'Complaint accepted and status updated successfully!'];
            } else {
                $response = ['status' => 500, 'message' => 'Failed to update comments table.'];
            } */
        } else {
            $response = ['status' => 500, 'message' => 'Failed to update complaint status.'];
        }
    } else {
        $response = ['status' => 500, 'message' => 'Failed to insert data into manager table.'];
    }
    echo json_encode($response);
}


if(isset($_POST["manager_approve"])){
  $deadline = $_POST["deadline"];
  $id = $_POST["problem_id"];
  $query = "UPDATE complaints_detail SET days_to_complete='$deadline' , status='9' WHERE id= $id";

  if(mysqli_query($conn, $query)){
    $res = [
        "status" => 200,
        "msg" => "complaint accepted sucessfully"
    ];
    echo json_encode($res);
  }else{
    echo 'Error updating status';
  }
}

//reject reason from principal
if (isset($_POST['get_reject_reason'])) {
    $complain_id = mysqli_real_escape_string($conn, $_POST['problem_id']);
    $query = "SELECT feedback FROM complaints_detail WHERE id='$complain_id'";
    $query_run = mysqli_query($conn, $query);
    $User_data = mysqli_fetch_array($query_run);
    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'details Fetch Successfully by id',
            'data' => $User_data
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Details Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

//worker phone number

if (isset($_POST['get_worker_phone'])) {
    $complain_id = mysqli_real_escape_string($conn, $_POST['prblm_id']);
    $query = "
    SELECT w.* 
    FROM complaints_detail cd
    INNER JOIN manager m ON cd.id = m.problem_id
    INNER JOIN worker_details w ON m.worker_id = w.worker_id
    WHERE cd.id = '$complain_id'
";
    $query_run = mysqli_query($conn, $query);
    $User_data = mysqli_fetch_array($query_run);
    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'details Fetch Successfully by id',
            'data' => $User_data
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Details Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

?>