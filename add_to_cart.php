<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Пользователь не авторизован']);
    exit;
}

// Get the product ID from the request
$productId = $_POST['product_id'];

// Validate the product ID
if (empty($productId)) {
    echo json_encode(['success' => false, 'message' => 'Неверный ID товара']);
    exit;
}

// Database connection
include 'connect.php';

// Check if the product already exists in the cart
$userId = $_SESSION['user_id'];
$sql = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $userId, $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update the quantity if the product already exists
    $sql = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $userId, $productId);
} else {
    // Insert a new row if the product doesn't exist
    $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $userId, $productId);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Ошибка при добавлении товара в корзину']);
}

$stmt->close();
$conn->close();
?>