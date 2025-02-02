<?php
include 'connect.php'; // Подключение к базе данных

// Получение данных из формы
$username = mysqli_real_escape_string($conn, $_POST["register-name"]);
$password = $_POST["register-password"];
$email = mysqli_real_escape_string($conn, $_POST["register-email"]);

// Проверка, существует ли пользователь с таким email
$checkEmailSql = "SELECT `id` FROM `users` WHERE `email` = ?";
$stmt = mysqli_prepare($conn, $checkEmailSql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    echo "Email already in use.";
    exit();
}

// Хеширование пароля
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Подготовка запроса для вставки данных
$sql = "INSERT INTO `users`(`username`, `password`, `email`) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sss", $username, $hashed_password, $email);

// Выполнение запроса
if (mysqli_stmt_execute($stmt)) {
    echo "Registration successful!";
    // Редирект на страницу входа
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}

// Закрытие подключения
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>