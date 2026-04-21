<?php
session_start();
require_once "include/config.inc.php";

$cart_items = [];

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("
        SELECT c.product_id, c.quantity, p.name, p.price 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = :user_id
    ");
    $stmt->execute([':user_id' => $user_id]);
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// حساب الإجمالي
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <link rel=" stylesheet" href="include/header_footer.css">

    <title>🛒 سلة المشتريات</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding-bottom: 120px;
             padding-top: 120px;
             display: flex;
             align-items: center;
             justify-content: center;
             
             
             
        }

        .cart-container {
            width: 90%;
           
           
            background: #fff;
            padding: 100px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #f8bfc9;
        }

        .btn {
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: #fff;
            background: #77c393;
            display: inline-block;
            border-color:#4d9668ff;
        }
 .btn:hover{
     background: #4d9668ff;
            cursor: pointer;
 }

        .btn-danger {
            background: #dc3546be;

        }
.btn-danger:hover {
            background: #e1192dff;
            cursor: pointer;
            
        }
        .total-box {
            text-align: right;
            margin-top: 15px;
            font-size: 18px;
            font-weight: bold;
        }

        .card {
  --bg: #e8e8e8;
  --contrast: #e2e0e0;
  --grey: #93a1a1;
  position: relative;
  padding: 9px;
  background-color: var(--bg);
  border-radius: 35px;
  box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
}

.card-overlay {
  position: absolute;
  inset: 0;
  pointer-events: none;
  background: repeating-conic-gradient(var(--bg) 0.0000001%, var(--grey) 0.000104%) 60% 60%/600% 600%;
  filter: opacity(10%) contrast(105%);
}

.card-inner {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
  width: 70%px;
  height: 254px;
  background-color: var(--contrast);
  border-radius: 30px;
  /* Content style */
  font-size: 30px;
  font-weight: 900;
  color: #c7c4c4;
  text-align: center;
  font-family: monospace;
}
.index{
     left: 50%;
  transform: translateX(-50%);

}


    </style>
</head>

<body>

    <div>
        <?php include 'include/header.php'; ?>
    </div>

    <div class="cart-container">
        <h2>🛒 سلة المشتريات</h2>

        <?php if (empty($cart_items)): ?>
       <div class="card">
  <div class="card-overlay"> </div>
  <div class="card-inner">السلة فارغة!</div>

</div>
        <a class="btn" href="index.php" class="index">الرجوع للتسوق</a>
        <?php else: ?>
        <table>
            <tr>
                <th>المنتج</th>
                <th>السعر</th>
                <th>الكمية</th>
                <th>المجموع</th>
                <th>إزالة</th>
            </tr>
            <?php foreach ($cart_items as $item): ?>
            <tr>
                <td>
                    <?= htmlspecialchars($item['name']) ?>
                </td>
                <td>
                    <?= htmlspecialchars($item['price']) ?> ريال
                </td>
                <td>
                    <?= htmlspecialchars($item['quantity']) ?>
                </td>
                <td>
                    <?= htmlspecialchars($item['price'] * $item['quantity']) ?> ريال
                </td>
                <td><form action="include/removeProduct.php" method="post">
    <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
    <button type="submit" class="btn btn-danger">حذف</button>
</form>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <div class="total-box">إجمالي السلة:
            <?= $total ?> ريال
        </div>
        <br>
        <a class="btn" href="checkout.php">إكمال الدفع</a>
        <a class="btn" href="index.php">متابعة التسوق</a>
        <?php endif; ?>
    </div>
    <div>
        <?php include 'include/footer.php'; ?>
    </div>
</body>

</html>