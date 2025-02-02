<?php
session_start();
session_unset(); // Удаляем все данные сессии
session_destroy(); // Завершаем сессию

// Перенаправление на главную страницу или страницу входа
header("Location: index.php");
exit();
?>