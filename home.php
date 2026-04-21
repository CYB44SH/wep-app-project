
<?php
session_start();
require_once 'include/config.inc.php'; // اتصال قاعدة البيانات

// جلب المنتجات من قاعدة البيانات
try {
    $stmt = $pdo->query("SELECT id, name, image_path, price FROM products LIMIT 20"); 
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $products = [];
    error_log($e->getMessage());
}
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <link rel=" stylesheet" href="include/header_footer.css">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
<title>Lotus Care </title>
  <style>
    .image {
      object-fit: cover;
      display: flex;
      justify-content: center;
      margin-top: 75px;
      width: 100%;
      left: 0;
      right: 0;
      position: relative
    }

    .home {

      width: 100%;
      display: block;
      height: 15cm;


    }

    .image2 {

      object-fit: cover;
      display: flex;
      justify-content: center;
      width: 100%;
      left: 0;
      right: 0;
      margin-bottom:10px;

    }

    .product_section {

      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;

      padding: 10px 10px;
      
    }

    .product-card {
      width: 500px;
      background: #FFF7FA;
      border: 2px solid #77c393;
      border-radius: 22px;
      padding: 30px;
      text-align: center;
      box-shadow: 0 0 16px rgba(0, 0, 0, 0.07);
      transition: 0.3s;

    }

    .product-card:hover {
      transform: translateY(-6px);
    }

    .product-img {
      margin-top: 20px;
      width: 5cm;
      height: 6cm;
      object-fit: cover;
      border-radius: 18px;
      margin-bottom: 15px;
    }

    .products-scroll {
      display: flex;
      gap: 20px;
      overflow-x: auto;
      padding: 10px 0;
      scroll-behavior: smooth;
    }

    .products-scroll::-webkit-scrollbar {
      display: none;
      /* يخفي السكروول مثل سلة */
    }

    .section-title {
      font-size: 24px;
      font-weight: 700;
      color: #e78cb7ff;
    }

    .more-btn {
      padding: 8px 15px;
      border-radius: 18px;
      margin-right: 10px;
      background-color: #ecb2cdff;
      border: none;
      color: #faf6f8ff;
      font-size: 18px;
      font-weight: 600;
      cursor: pointer;
      text-decoration: underline;
      right: 20px;
    }
 .more-btn:hover{
  color:#6a53bc;
 }
    .product-name {
      font-size: 20px;
      font-weight: 600;
      color: #C05285;
      margin-bottom: 12px;
    }
   
    .image div {
      background-color: rgba(119, 195, 147, 0.5);
      border: #77c393;
      width: 580px;
      height: 150px;
      position: absolute;
      right: 0;
      top: 33%;
      box-shadow: 0 0 16px rgba(0, 0, 0, 0.07);   
      transition: 0.3s;
     display: flex;             /* تفعيل Flexbox */
    justify-content: center;   /* محاذاة العناصر أفقياً بالوسط */
    align-items: center; 
      padding: 20px;
      box-shadow: #77c393;
    }
 .image2 div {
     background-color: rgba(255, 213, 213, 0.76);

   
      width: 580px;
      height: 150px;
      position: absolute;
      left 0;
      color: #C05285;
      box-shadow: 0 0 16px rgba(0, 0, 0, 0.07);   
      transition: 0.3s;
     display: flex;             /* تفعيل Flexbox */
    justify-content: center;   /* محاذاة العناصر أفقياً بالوسط */
    align-items: center; 
      padding: 20px;
      box-shadow: #77c393;
      text-align:center;
      

    }
    .image3 div {
     background-color: rgba(226, 158, 158, 0.78);

   margin-top :100px;
      width: 580px;
      height: 200px;
      position: absolute;
      left 0;
      color: #C05285;
      box-shadow: 0 0 16px rgba(0, 0, 0, 0.07);   
      transition: 0.3s;
     display: flex;             /* تفعيل Flexbox */
    justify-content: center;   /* محاذاة العناصر أفقياً بالوسط */
    align-items: center; 
      padding: 20px;
      box-shadow: #272e29ff;
      text-align:center;
     

    }
    .image div:hover {
      transform: scale(1.1);
      
    }
     .image2 div:hover {
      transform: scale(1.1);
      
    }
    .image3 div:hover {
      transform: scale(1.1);
      
    }
    .l{
      width:13cm;
      height: 10cm;
    }

  </style>
</head>

<body>
  <div>
    <?php include'include/header.php'; ?>
  </div>

  <div class="image">
    <div> 
          <img src="image/l.png" class="l">
    </div>
    <img src="image/1.png" class="home">
  </div>

  <br>


<div class="product_section">
    <div class="section-title">Our Products</div>
    <button class="more-btn" onclick="window.location.href='index.php'">
        View All
    </button>
</div>

<div class="products-scroll">
<?php
// جلب المنتجات من قاعدة البيانات
$stmt = $pdo->query("SELECT id, name, image_path FROM products LIMIT 20"); // ممكن تحددي عدد المنتجات
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($products as $product): ?>
    <div class="product-card">
        <img src="<?= htmlspecialchars($product['image_path']) ?>" class="product-img" alt="<?= htmlspecialchars($product['name']) ?>">
        <div class="product-name"><?= htmlspecialchars($product['name']) ?></div>
       
        <button class="more-btn" onclick="window.location.href='product_details.php?id=<?= $product['id'] ?>'">
            التفاصيل
        </button>
    </div>
<?php endforeach; ?>
</div>


  <div class="image2">
    <div> 
         <h3> <b>Lotus Care</b><br>
 حيث تلتقي النقاء بالجمال، عناية بالبشرة تكشف إشراقتك الطبيعية.</h3>
    </div>
    <img src="image/22.png" class="home">
  </div>

  <div class="image3">
    <div>
<h3>براندنا وُلد من فكرة بسيطة: كل بشرة تستحق عناية مصمّمة لها.
نهتم بتفاصيل الجمال الحقيقي، ونقدّم منتجات مدروسة بعناية لتناسب جميع أنواع البشرة — الحساسة، الجافة، الدهنية، المختلطة وحتى البشرة التي تحتاج عناية خاصة.

نؤمن أن روتين العناية يجب أن يكون سهلاً، فعّالاً، ويعكس ثقتك بنفسك.
لذلك نختار مكونات آمنة، لطيفة، وعالية الجودة لنقدّم لك منتجات تمنح بشرتك التوازن، الإشراقة، والراحة اليومية.

هدفنا هو أن تكوني دائمًا واثقة بجمالك الطبيعي… لأن كل بشرة فريدة، وبراندنا موجود ليبرز أجمل ما فيها.</h3>
    </div>
    <img src="image/33.png" class="home">
  </div>

  <div>
    <?php include 'include/footer.php'; ?>
  </div>
</body>

</html>
