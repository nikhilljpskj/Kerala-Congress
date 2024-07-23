<?php
session_start();
include('connect.php'); // This will include the database connection code

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $con->prepare("SELECT id, district, email, password FROM dist_authority WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute and store result
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Bind result variables
        $stmt->bind_result($id, $district, $email, $hashed_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Store data in session variables
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $id;
            $_SESSION['district'] = $district;
            $_SESSION['email'] = $email;

            // Redirect to the dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No account found with that username.";
    }

    $stmt->close();
    $con->close();
}
?>
