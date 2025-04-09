<?php
session_start();

// Check if user is logged in
if (empty($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'message' => 'Пользователь не авторизован']));
}

// Validate product ID
if (empty($_POST['product_id'])) {
    die(json_encode(['success' => false, 'message' => 'Неверный ID товара']));
}

include 'connect.php';

// Remove item from cart
$userId = (int)$_SESSION['user_id'];
$productId = (int)$_POST['product_id'];

$sql = "DELETE FROM cart WHERE user_id = $userId AND product_id = $productId";
if (mysqli_query($conn, $sql)) {
    header('Location: cart.php');
    exit;
}

echo "Ошибка при удалении товара из корзины.";
mysqli_close($conn);
?>