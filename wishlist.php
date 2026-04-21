<?php
session_start();
require_once 'include/config.inc.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];


$stmt = $pdo->prepare("
    SELECT w.product_id AS pid, p.name, p.image_path, p.price
    FROM wishlist w
    JOIN products p ON w.product_id = p.id
    WHERE w.user_id = :user_id
");
$stmt->execute([':user_id' => $user_id]);
$wishlist_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$grand_total = 0;
?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة الأمنيات</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="include/header_footer.css">
    <style>
        body {
                margin: 10px;
    padding: 10px;
    width: 100%;
    min-height: 100%;
    overflow-y: auto; /* تأكدي من السماح بالتمرير العمودي */
   min-height: 120vh;

            
            font-family: Arial, sans-serif;
        }

        .wishlist-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
           gap:10px;
            padding: 20px;
          
        }

        .wishlist-item {
            background: #fff;
            border-radius: 15px;
            padding: 15px;
            width: 250px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .wishlist-item img {
            max-width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
        }

        .wishlist-item .name {
            margin: 10px 0 5px;
            font-weight: bold;
            font-size: 1.1em;

        }

        .wishlist-item .price {
            color: #555;
            margin-bottom: 10px;
        }

        .btn {
           
            border-radius: 5px;
            text-decoration: none;
            color: #fff;
            background: #eabdd7ff;
            border: none;
            cursor: pointer;
          
       padding: 10px 25px;
        font-size: 1.1em; 
        border-radius: 20px; 
        
     

        }

        .btn:hover {
            background: #4d9668;
        }

        .btn-delete {
            background: #e37882ff;
        }

        .btn-delete:hover {
            background: #e1192d;
        }

        .empty {
            text-align: center;
            margin-top: 50px;
            font-size: 1.2em;
            color: #555;
             margin-bottom: 200px;
        }

        .wishlist-actions {
            text-align: center;
           
        }

        .wishlist-actions a {
            margin: 0 10px;
            text-decoration: none;
        }

    </style>
</head>

<body>

<?php include 'include/header.php'; ?>

<section class="wishlist">
    <h1 style="text-align:center; margin-top:100px;">قائمة الأمنيات</h1>

    <?php if(!empty($wishlist_items)): ?>
        <div class="wishlist-container">
            <?php foreach($wishlist_items as $item): ?>
                <div class="wishlist-item">
                    <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                    <div class="name"><?= htmlspecialchars($item['name']) ?></div>
                    <div class="price"><?= number_format($item['price'],2) ?> ريال</div>

                    <!-- زر حذف نفس ستايل الكارت -->
                    <form action="process-wishlist.php" method="post" style="display:inline;">
                        <input type="hidden" name="delete_product_id" value="<?= $item['pid'] ?>">
                        <button type="submit" class="btn btn-delete">حذف</button>
                    </form>

                    <form action="include/addProduct.php" method="post" class="add-to-cart-form" style="display:inline;">
    <input type="hidden" name="product_id" value="<?= $item['pid'] ?>">
    <button class="btn btn-cart">أضف للسلة 🛒</button>
</form>


                </div>
                <?php $grand_total += $item['price']; ?>
            <?php endforeach; ?>
        </div>

        <div class="wishlist-actions">
            <form action="process-wishlist.php" method="post" style="display:inline;">
                <input type="hidden" name="delete_all" value="1">
                <button type="submit" class="btn btn-delete">حذف الكل</button>
            </form>
            <a href="index.php" class="btn">الرجوع للتسوق</a>
        </div>

    <?php else: ?>
        <p class="empty">قائمة الأمنيات فارغة!</p>
        <div class="wishlist-actions">
            <a href="index.php" class="btn">الرجوع للتسوق</a>
        </div>
    <?php endif; ?>
</section>

<?php include 'include/footer.php'; ?>
<script src="stockProcess.js"></script>

</body>
</html>
