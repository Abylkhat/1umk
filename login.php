<?php
include 'connect.php'; // Подключение к базе данных

// Получение данных из формы
if (isset($_POST["login-email"]) && isset($_POST["login-password"])) {
    $email = mysqli_real_escape_string($conn, $_POST["login-email"]);
    $password = $_POST["login-password"];

    // Запрос на получение пользователя с указанным email
    $sql = "SELECT `id`, `username`, `password` FROM `users` WHERE `email` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Проверка введённого пароля с хэшем из базы данных
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['user_id'] = $row['id']; // Сохраняем ID пользователя в сессии
            $_SESSION['username'] = $row['username'];
            // Редирект на главную страницу или в профиль пользователя
            header("Location: index.php");
            exit();
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Invalid email or password.";
    }
    // Закрытие подключения
    mysqli_stmt_close($stmt);
} else {
    echo "Please fill in the form.";
}
mysqli_close($conn);
