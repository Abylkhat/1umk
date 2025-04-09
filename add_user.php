<?php
include 'connect.php';

// Get form data
$username = $_POST['register-name'];
$password = $_POST['register-password'];
$email =  $_POST['register-email'];

// Check if email exists
$result = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
if (mysqli_num_rows($result)) {
    die("Email already in use.");
}

// Hash password and insert user
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
if (mysqli_query($conn, "INSERT INTO users (username, password, email) VALUES ('$username', '$hashed_password', '$email')")) {
    header("Location: index.php");
    exit();
} else {
    die("Error: " . mysqli_error($conn));
}

mysqli_close($conn);
?>