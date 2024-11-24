<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");

if (!$conn) {
    echo json_encode(['status' => 500, 'message' => 'Database connection failed']);
    exit;
}

// Define the counter file path
$counterFilePath = './uploads/counter.txt';

// Function to get the next file number
function getNextFileNumber($counterFilePath)
{
    if (file_exists($counterFilePath)) {
        $file = fopen($counterFilePath, 'r');
        $lastNumber = (int)fgets($file);
        fclose($file);
        $nextNumber = $lastNumber + 1;
    } else {
        $nextNumber = 1;
    }
    $file = fopen($counterFilePath, 'w');
    fwrite($file, $nextNumber);
    fclose($file);
    return $nextNumber;
}

// Handle form submission
if (isset($_POST['faculty_id'])) {
    $faculty_id = mysqli_real_escape_string($conn, $_POST['faculty_id']);
    $block_venue = mysqli_real_escape_string($conn, $_POST['block_venue']);
    $venue_name = mysqli_real_escape_string($conn, $_POST['venue_name']);
    $type_of_problem = mysqli_real_escape_string($conn, $_POST['type_of_problem']);
    $problem_description = mysqli_real_escape_string($conn, $_POST['problem_description']);
    $date_of_reg = mysqli_real_escape_string($conn, $_POST['date_of_reg']);
    $status = $_POST['status'];

    // Handle file upload
    $images = "";
    $uploadFileDir = './uploads/';

    if (!is_dir($uploadFileDir) && !mkdir($uploadFileDir, 0755, true)) {
        echo json_encode(['status' => 500, 'message' => 'Failed to create upload directory.']);
        exit;
    }

    if (isset($_FILES['images']) && $_FILES['images']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['images']['tmp_name'];
        $fileNameCmps = explode(".", $_FILES['images']['name']);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        if (in_array($fileExtension, $allowedExtensions)) {
            $nextFileNumber = getNextFileNumber($counterFilePath);
            $newFileName = str_pad($nextFileNumber, 10, '0', STR_PAD_LEFT) . '.' . $fileExtension;
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $images = $newFileName;
            } else {
                echo json_encode(['status' => 500, 'message' => 'Error moving the uploaded file.']);
                exit;
            }
        } else {
            echo json_encode(['status' => 500, 'message' => 'Upload failed. Allowed types: jpg, jpeg, png.']);
            exit;
        }
    }


    // Insert data into the database
    $query = "INSERT INTO complaints_detail (faculty_id, block_venue, venue_name, type_of_problem, problem_description, images, date_of_reg, status) 
              VALUES ('$faculty_id', '$block_venue', '$venue_name', '$type_of_problem', '$problem_description', '$images', '$date_of_reg', '$status')";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 200, 'message' => 'Success']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Error inserting data: ' . mysqli_error($conn)]);
    }
    exit;
}

// Handle complaint deletion
if (isset($_POST['delete_user'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $query = "DELETE FROM complaints_detail WHERE id='$user_id'";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 200, 'message' => 'Deleted successfully']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Error deleting data: ' . mysqli_error($conn)]);
    }
    exit;
}

// Handle image retrieval
if (isset($_POST['get_image'])) {
    $id = isset($_POST['id']) ? $_POST['id'] : ''; // Ensure id is set

    // Validate id
    if (empty($id)) {
        echo json_encode(['status' => 400, 'message' => 'ID not provided']);
        exit;
    }

    // Query to fetch the image based on id
    $query = "SELECT id, images FROM complaints_detail WHERE id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo json_encode(['status' => 500, 'message' => 'Prepare statement failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['status' => 200, 'data' => $row]);
    } else {
        echo json_encode(['status' => 500, 'message' => 'No image found']);
    }

    $stmt->close();
    $conn->close();
    exit; // Ensure we exit after handling the request
}

//  View workers details
if (isset($_POST['get_worker_details'])) {
    $id = $_POST['id'];

    // SQL query to get worker details
    $query = "
    SELECT w.worker_first_name,
     w.worker_mobile
    FROM complaints_detail cd
    INNER JOIN manager m ON cd.id = m.problem_id
    INNER JOIN worker_details w ON m.worker_id = w.worker_id
    WHERE cd.id = ?
";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $worker = $result->fetch_assoc();
        echo json_encode(['status' => 200, 'worker_first_name' => $worker['worker_first_name'], 'worker_mobile' => $worker['worker_mobile']]);
    } else {
        echo json_encode(['status' => 500, 'message' => 'No worker details found for this id']);
    }

    $stmt->close();
    $conn->close();
    exit;
}

// Handle status details retrieval
if (isset($_POST['get_status_details'])) {
    $id = $_POST['id'];

    // Query to fetch status based on id
    $query = "SELECT status FROM complaints_detail WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $status = $row['status'];

        // Mapping status codes to messages
        $statusMessage = '';
        if ($status == 1) {
            $statusMessage = 'pending';
        } elseif ($status == 2) {
            $statusMessage = 'Approved by infra';
        } elseif ($status == 3) {
            $statusMessage = 'Rejected by infra';
        } elseif ($status == 4) {
            $statusMessage = 'Approved by HOD';
        } elseif ($status == 5) {
            $statusMessage = 'Rejected by HOD';
        } elseif ($status == 6) {
            $statusMessage = 'sent to principal for approval';
        } elseif ($status == 7) {
            $statusMessage = 'Assigned to worker';
        } elseif ($status == 8) {
            $statusMessage = 'Approved by Principal ';
        } elseif ($status == 9) {
            $statusMessage = 'Approved by Manager ';
        } elseif ($status == 10) {
            $statusMessage = 'worker inprogress';
        } elseif ($status == 11) {
            $statusMessage = 'waiting for approval';
        } elseif ($status == 12) {
            $statusMessage = 'Satisfied by Faculty';
        } elseif ($status == 13) {
            $statusMessage = '';
        } elseif ($status == 14) {
            $statusMessage = 'Sent to manager for rework(Reassign)';
        } elseif ($status == 15) {
            $statusMessage = 'Rework details';
        } elseif ($status == 16) {
            $statusMessage = 'Rejected by manager(Reassign)';
        } elseif ($status == 17) {
            $statusMessage = 'In progress';
        } elseif ($status == 18) {
            $statusMessage = 'Waiting for Approval';
        } elseif ($status == 19) {
            $statusMessage = 'Rejected by Principal';
        } elseif ($status == 20) {
            $statusMessage = 'Rejected principal';
        } else {
            $statusMessage = 'Unknown status';
        }

        echo json_encode(['status' => 200, 'message' => $statusMessage]);
    } else {
        echo json_encode(['status' => 500, 'message' => 'No status found']);
    }

    $stmt->close();
    $conn->close();
    exit;
}

// Handle feedback form submission
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $satisfaction = $_POST['satisfaction']; // Get satisfaction (13 for Satisfied, 14 for Not Satisfied)
    $feedback = $_POST['feedback'];

    // Validate inputs
    if (empty($id) || empty($feedback) || empty($satisfaction)) {
        echo json_encode(['status' => 400, 'message' => 'Problem ID, Feedback, or Satisfaction is missing']);
        exit;
    }

    // Check if feedback already exists for the given id
    $checkQuery = "SELECT feedback FROM complaints_detail WHERE id = ?";
    $stmt = $conn->prepare($checkQuery);

    if (!$stmt) {
        echo json_encode(['status' => 500, 'message' => 'Prepare statement failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    $feedbackExists = $stmt->num_rows > 0; // Check if a row exists for the given id

    $stmt->close();

    // Update feedback if it exists, otherwise insert a new one
    if ($feedbackExists) {
        // Update existing feedback and status
        $query = "UPDATE complaints_detail SET feedback = ?, status = ? WHERE id = ?";
    } else {
        // Insert new feedback (though, this case might not happen since the record should exist)
        // You can adjust logic here if necessary, but we'll proceed with update as the case.
        $query = "UPDATE complaints_detail SET feedback = ?, status = ? WHERE id = ?";
    }

    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo json_encode(['status' => 500, 'message' => 'Prepare statement failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param('sii', $feedback, $satisfaction, $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 200, 'message' => 'Feedback updated successfully']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Query failed: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}

?>
