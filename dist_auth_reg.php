<?php
include('connect.php'); // This will include the database connection code

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $district = $_POST['district'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate form data
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into database
    $sql = "INSERT INTO dist_authority (district, username, email, phone, password)
            VALUES ('$district', '$username', '$email', '$phone', '$hashed_password')";

    if ($con->query($sql) === TRUE) {
        echo "Registration successful.";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}
?>
