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

$userId = $_SESSION['user_id'];
$productId = (int)$_POST['product_id'];

// Check if product exists in cart
$exists = mysqli_query($conn, 
    "SELECT 1 FROM cart WHERE user_id = $userId AND product_id = $productId");

// Update or insert based on existence
if (mysqli_num_rows($exists) > 0) {
    $query = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = $userId AND product_id = $productId";
} else {
    $query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($userId, $productId, 1)";
}

if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Ошибка при добавлении товара в корзину']);
}

mysqli_close($conn);
?>