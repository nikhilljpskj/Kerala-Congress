<?php
session_start();

// Check if the user is logged in, if not then exit
if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
    echo "Unauthorized";
    exit;
}

// Include database configuration file
require_once "connect.php";

// Get POST data
$reg_no = isset($_POST['reg_no']) ? $_POST['reg_no'] : '';

if ($reg_no) {
    // Prepare SQL statement to update status
    $sql = "UPDATE members SET status = 1 WHERE reg_no = ?";

    if ($stmt = $con->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("s", $reg_no);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "Member approved successfully.";
        } else {
            echo "Execution failed: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Prepare failed: " . $con->error;
    }
} else {
    echo "Invalid input.";
}

$con->close(); // Close the database connection
?>
