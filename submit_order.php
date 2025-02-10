<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

// Database connection
include 'connect.php';

$userId = $_SESSION['user_id'];

// Fetch the total amount from the cart
$sql = "SELECT SUM(products.price * cart.quantity) AS total_amount 
        FROM cart 
        JOIN products ON cart.product_id = products.id 
        WHERE cart.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalAmount = $row['total_amount'];

$stmt->close();

// Insert the order into the orders table
$sql = "INSERT INTO orders (user_id, total_amount) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('id', $userId, $totalAmount);

if ($stmt->execute()) {
    // Clear the cart after submitting the order
    $sql = "DELETE FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userId);
    $stmt->execute();

    header('Location: cart.php?order_success=1'); // Redirect back to the cart page
} else {
    echo "Ошибка при оформлении заказа.";
}

$stmt->close();
$conn->close();
?>