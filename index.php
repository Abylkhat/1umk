<?php
session_start(); // Запуск сессии
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Главная - Интернет-магазин</title>
  <link rel="stylesheet" href="css/style.css">
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

  <!-- Баннер -->
  <section class="banner">
    <div class="container">
      <h2>Добро пожаловать в наш интернет-магазин!</h2>
      <p>Находите лучшие предложения и последние новинки.</p>
    </div>
  </section>

  <!-- Категории товаров -->
  <section class="categories">
    <div class="container">
      <h2>Категории товаров</h2>
      <div class="category-list">
        <div class="category-item">
          <a href="#"><img src="images/electronics.jpg" alt="Электроника"></a>
          <h3>Электроника</h3>
        </div>
        <div class="category-item">
          <a href="#"><img src="images/clothes.jpg" alt="Одежда"></a>
          <h3>Одежда</h3>
        </div>
        <div class="category-item">
          <a href="#"><img src="images/utencils.jpg" alt="Товары для дома"></a>
          <h3>Товары для дома</h3>
        </div>
        <div class="category-item">
          <a href="#"><img src="images/books.jpg" alt="Книги"></a>
          <h3>Книги</h3>
        </div>
      </div>
    </div>
  </section>

  <!-- Популярные товары -->
  <section class="popular-products">
    <div class="container">
      <h2>Популярные товары</h2>
      <div class="product-list">
        <div class="product-item">
          <img src="img/product1.jpg" alt="Товар 1">
          <h3>Наименование товара</h3>
          <p>Цена: $549.99</p>
          <a href="#" class="btn">Купить</a>
        </div>
        <div class="product-item">
          <img src="img/product2.jpg" alt="Товар 2">
          <h3>Наименование товара</h3>
          <p>Цена: $99.99</p>
          <a href="#" class="btn">Купить</a>
        </div>
        <div class="product-item">
          <img src="img/product3.jpg" alt="Товар 3">
          <h3>Наименование товара</h3>
          <p>Цена: $159.99</p>
          <a href="#" class="btn">Купить</a>
        </div>
      </div>
    </div>
  </section>
</body>

</html>