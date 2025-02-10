<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Пользователь не авторизован']);
    exit;
}

$productId = $_POST['product_id'];

if (empty($productId)) {
    echo json_encode(['success' => false, 'message' => 'Неверный ID товара']);
    exit;
}

// Database connection
include 'connect.php';

$userId = $_SESSION['user_id'];
$sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $userId, $productId);

if ($stmt->execute()) {
    header('Location: cart.php'); // Redirect back to the cart page
} else {
    echo "Ошибка при удалении товара из корзины.";
}

$stmt->close();
$conn->close();
?>