
<?php
session_start();

// Check if department is passed via POST
if (isset($_POST['department'])) {
    // Update the session with the new department value
    $_SESSION['department'] = $_POST['department'];
    echo "Session department updated to: " . $_SESSION['department'];
} else {
    echo "No department data received.";
}
?>