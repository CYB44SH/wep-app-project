<?php

require_once 'include/config.inc.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
}

if ($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (!$product) {
    $product = [
        'id'          => 0,
        'name'        => 'منتج غير متوفر',
        'image_path'  => 'image/default.png',
        'price'       => 0,
        'skin_type'   => '',
        'stock'       => 0,
        'description' => '',
        'usage'       => '',
        'ingredients' => '',
    ];
}

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($product['name']) ?> - تفاصيل المنتج</title>
<link href="include/header_footer.css" rel="stylesheet">

<style>
body {
  font-family: "Cairo", sans-serif;
  background: url("image/2.png") no-repeat center center fixed;
  background-size: cover;
  margin-top: 90px;
}

.product-wrapper {

  max-width: 1100px;
  margin: auto;
  display: flex;
  gap: 40px;
  padding: 20px;
  background: rgba(255, 247, 250, 0.92);
  border-radius: 25px;
  border: 2px solid #F3C6DA;
  box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

.product-wrapper img {
  width: 420px;
  height: 420px;
  object-fit: cover;
  border-radius: 20px;
  border: 2px solid #F3C6DA;
}

.details-box {

  flex: 1;
}

.details-box h2 {
  font-size: 30px;
  color: #C05285;
  margin-bottom: 10px;
}

.price {
  font-size: 20px;
  margin-bottom: 15px;
  color: #6d6d6d;
}

.description {
  background: rgba(255, 255, 255, 0.75);
  border-radius: 18px;
  padding: 18px 22px;
  border: 1.5px solid #F7D9E6;
  margin: 20px 0;
  line-height: 2.1;
  color: #444;
  font-size: 16px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
  backdrop-filter: blur(4px);
}
.btn-box {
  margin-bottom: 20px;
}

.btn {
  border: none;
  padding: 10px 22px;
  border-radius: 30px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  margin-left: 8px;
  margin-bottom: 10px;
  transition: 0.3s ease;
}

.btn-cart {
  background: white;
  color: #0b4b19ff;
  border: 1px solid #F3C6DA;
}

.btn-wish {
  background: white;
  color: #0b4b19ff;
  border: 1px solid #F3C6DA;
}

.btn:hover {
  transform: translateY(-3px);
}

details {
  background: #fff;
  border: 1px solid #F3C6DA;
  padding: 12px 15px;
  border-radius: 15px;
  margin-bottom: 12px;
  cursor: pointer;
}

summary {
  font-size: 17px;
  color: #BF4776;
  font-weight: 600;
  outline: none;
}

summary:hover {
  color: #E84C88;
}

details p {
  padding: 10px 5px 5px;
  margin: 0;
  color: #444;
  line-height: 1.8;
}

.back-link {
  display: block;
  text-align: center;
  margin-top: 25px;
  font-size: 16px;
  color: #C05285;
  text-decoration: none;
  margin-bottom: 120px;
}

.back-link:hover {
  text-decoration: underline;
}
.desc-title {
    font-size: 24px;
    font-weight: 700;
    color: #B03060; 
    margin-bottom: 8px;
}

.desc-text {
    font-size: 16px;
    font-weight: 600; 
    color: #444;
    line-height: 1.9;
    margin-bottom: 25px;
}

</style>
</head>
<body>


<?php include 'include/header.php'; ?>


<div class="product-wrapper">

  <img src="<?= htmlspecialchars($product['image_path']) ?>">

  <div class="details-box">

      <h2><?= htmlspecialchars($product['name']) ?></h2>
      <div class="price"><?= htmlspecialchars($product['price']) ?> ر.س</div>

      <?php if (!empty($product['description'])): ?>
  <h3 class="desc-title">الوصف</h3>
  <p class="desc-text">
    <?= nl2br(htmlspecialchars($product['description'])) ?>
  </p>
<?php endif; ?>


      <div class="btn-box">
        <form action="include/addProduct.php" method="post" style="display:inline;" class="add-to-cart-form">
          <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
          <button class="btn btn-cart">أضف للسلة୨ৎ🛒</button>
        </form>

<form action="process-wishlist.php" method="post" style="display:inline;">
    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
    <input type="hidden" name="add_to_wishlist" value="1"> <!-- مهم -->
    <button type="submit" class="btn btn-wish">أضف لقائمة الأماني 🪷</button>
</form>

      </div>

      <?php if (!empty($product['usageProduct'])): ?>
      <details>
        <summary>طريقة الاستعمال˚⊱🪷⊰˚</summary>
        <p><?= nl2br(htmlspecialchars($product['usageProduct'])) ?></p>
      </details>
    <?php endif; ?>

    <?php if (!empty($product['ingredients'])): ?>
      <details>
        <summary>المكوّنات˚⊱🪷⊰˚</summary>
        <p><?= nl2br(htmlspecialchars($product['ingredients'])) ?></p>
      </details>
    <?php endif; ?>

  </div>

</div>

<a href="index.php" class="back-link">العودة لصفحة المنتجات</a>

<?php include 'include/footer.php'; ?>
<script src="stockProcess.js"></script>
</body>
</html>