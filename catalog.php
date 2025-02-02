<?php
session_start(); // Запуск сессии
include 'connect.php';
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$category = $_GET['category'] ?? 'all';
$sort = $_GET['sort'] ?? 'default';

// Build the SQL query
$sql = "SELECT * FROM products";
if ($category !== 'all') {
  $sql .= " WHERE category_id = '$category'";
}
if ($sort === 'price-asc') {
  $sql .= " ORDER BY price ASC";
} elseif ($sort === 'price-desc') {
  $sql .= " ORDER BY price DESC";
}

$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $products[] = $row;
  }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Каталог товаров - Интернет-магазин</title>
  <link rel="stylesheet" href="css/style2.css">
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
          </li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Фильтр и сортировка товаров -->
  <section class="filter">
    <div class="container">
      <h2>Каталог товаров</h2>
      <form id="filter-form" method="GET" action="">
        <select id="category-filter" name="category">
          <option value="all" <?php echo ($category === 'all') ? 'selected' : ''; ?>>Все категории</option>
          <option value="1" <?php echo ($category === 'clothing') ? 'selected' : ''; ?>>Одежда</option>
          <option value="2" <?php echo ($category === 2) ? 'selected' : ''; ?>>Электроника</option>
          <option value="3" <?php echo ($category === 3) ? 'selected' : ''; ?>>Товары для дома</option>
          <option value="4" <?php echo ($category === 4) ? 'selected' : ''; ?>>Книги</option>
        </select>
        <select id="sort-filter" name="sort">
          <option value="default" <?php echo ($sort === 'default') ? 'selected' : ''; ?>>По умолчанию</option>
          <option value="price-asc" <?php echo ($sort === 'price-asc') ? 'selected' : ''; ?>>Цена: по возрастанию</option>
          <option value="price-desc" <?php echo ($sort === 'price-desc') ? 'selected' : ''; ?>>Цена: по убыванию</option>
        </select>
        <button type="submit">Применить</button>
      </form>
    </div>
  </section>

  <!-- Список товаров -->
  <section class="product-list">
    <div class="container">
      <div class="products">
        <?php if (!empty($products)): ?>
          <?php foreach ($products as $product): ?>
            <div class="product-card">
              <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
              <h3><?php echo htmlspecialchars($product['name']); ?></h3>
              <p class="price">₽ <?php echo htmlspecialchars($product['price']); ?></p>
              <a href="#" class="btn">Добавить в корзину</a>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No products found.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Пагинация -->
  <section class="pagination">
    <div class="container">
      <a href="#" class="page">1</a>
      <a href="#" class="page">2</a>
      <a href="#" class="page">3</a>
      <!-- Пагинация будет динамически подгружать страницы товаров -->
    </div>
  </section>
</body>

</html>