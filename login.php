<?php
include 'connect.php';

// Check if form was submitted
if (!isset($_POST['login-email'], $_POST['login-password'])) {
    die('Please fill in the form.');
}

// Get input
$email = $_POST['login-email'];
$password = $_POST['login-password'];

// Check user credentials
$sql ="SELECT id, username, password FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($row && password_verify($password, $row['password'])) {
    session_start();
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['username'] = $row['username'];
    header('Location: index.php');
    exit();
}

echo 'Invalid email or password.';
mysqli_close($conn);
?>