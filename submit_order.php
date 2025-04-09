<?php
session_start();

// Check if user is logged in
if (empty($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

include 'connect.php';

$userId = (int)$_SESSION['user_id'];

// Get total amount from cart
$totalResult = mysqli_query($conn, 
    "SELECT SUM(products.price * cart.quantity) AS total_amount
     FROM cart 
     JOIN products ON cart.product_id = products.id
     WHERE cart.user_id = $userId");
$totalAmount = mysqli_fetch_assoc($totalResult)['total_amount'];

// Create order and clear cart
$sql_insert = "INSERT INTO orders (user_id, total_amount) VALUES ($userId, $totalAmount)";
$sql_delete = "DELETE FROM cart WHERE user_id = $userId";
if (mysqli_query($conn, $sql_insert)) {
    mysqli_query($conn, $sql_delete);
    header('Location: cart.php?order_success=1');
    exit;
}

echo "Ошибка при оформлении заказа.";
mysqli_close($conn);
?>