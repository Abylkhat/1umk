<?php
session_start(); // Запуск сессии
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Корзина - Интернет-магазин</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!-- Шапка -->
  <header>
    <div class="container">
      <h1>Интернет-магазин</h1>
      <nav>
        <ul>
          <li><a href="index.php">Главная</a></li>
          <li><a href="catalog.php">Каталог</a></li>
          <li><a href="cart.php">Корзина</a></li>
          <?php if (isset($_SESSION['user_id'])): ?>
            <li id="li_greeting"><?php echo "Привет, " . $_SESSION['username'] . "!"; ?></li>
            <li><a href="logout.php">Выйти?</a></li>
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
          <!-- Товары загружаются из базы -->
        </tbody>
      </table>
      <div class="cart-total">
        <h3>Итого: <span id="total-price">0₸</span></h3>
        <button class="checkout-btn">Оформить заказ</button>
      </div>
    </div>
  </main>


</body>

</html