<?php
session_start();

// Check if user is logged in
if (empty($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

include 'connect.php';

// Fetch orders
$userId = (int)$_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT id, total_amount, order_date FROM orders WHERE user_id = $userId ORDER BY order_date DESC");
$orders = [];
while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заказы - Интернет-магазин</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <!-- Шапка -->
    <header>
    <div class="container">
        <h1>Интернет-магазин</h1>
        <nav>
            <ul class="nav-menu">
                <li><a href="index.php">Главная</a></li>
                <li><a href="catalog.php">Каталог</a></li>
                <li><a href="cart.php">Корзина</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="user-dropdown">
                        <span id="li_greeting">Привет, <?php echo $_SESSION['username']; ?> ▼</span>
                        <ul class="dropdown-menu">
                            <li><a href="orders.php">Мои заказы</a></li>
                            <li><a href="logout.php">Выйти</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li><a href="login.html">Вход</a></li>
                    <li><a href="register.html">Регистрация</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

    <!-- Основной контент -->
    <main>
        <div class="container">
            <h2>Мои заказы</h2>
            <?php if (!empty($orders)): ?>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Номер заказа</th>
                            <th>Общая сумма</th>
                            <th>Дата заказа</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['id']); ?></td>
                                <td>₽ <?php echo htmlspecialchars($order['total_amount']); ?></td>
                                <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>У вас пока нет заказов.</p>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>