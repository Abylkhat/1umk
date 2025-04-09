<?php
session_start();

// Check if user is logged in
if (empty($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

include 'connect.php';

// Fetch cart items and calculate total
$userId = (int)$_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT p.id, p.name, p.price, c.quantity FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = $userId");
$cartItems = [];
$totalAmount = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $cartItems[] = $row;
    $totalAmount += $row['price'] * $row['quantity'];
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина - Интернет-магазин</title>
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
            <h2>Ваша корзина</h2>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Товар</th>
                        <th>Количество</th>
                        <th>Цена</th>
                        <th>Общая стоимость</th>
                        <th>Удалить</th>
                    </tr>
                </thead>
                <tbody id="cart-items">
                    <?php if (!empty($cartItems)): ?>
                        <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                <td>$ <?php echo htmlspecialchars($item['price']); ?></td>
                                <td>$ <?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                                <td>
                                    <form action="remove_from_cart.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                        <button type="submit" class="remove-btn">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Ваша корзина пуста.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="cart-total">
                <h3>Итого: <span id="total-price">$ <?php echo htmlspecialchars($totalAmount); ?></span></h3>
                <form action="submit_order.php" method="POST">
                    <button type="submit" class="checkout-btn">Оформить заказ</button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>