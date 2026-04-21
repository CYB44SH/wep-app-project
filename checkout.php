<?php
session_start();
require_once "include/config.inc.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT c.product_id, c.quantity, p.name, p.price 
    FROM cart c 
    JOIN products p ON c.product_id = p.id 
    WHERE c.user_id = :user_id
");
$stmt->execute([':user_id' => $user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($cart_items)) {
    header("Location: cart.php");
    exit();
}

$subtotal = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}

$vatRate   = 0.15;
$vatAmount = $subtotal * $vatRate;
$total     = $subtotal + $vatAmount;

$success_message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_order'])) {

    $delete = $pdo->prepare("DELETE FROM cart WHERE user_id = :user_id");
    $delete->execute([':user_id' => $user_id]);

    $success_message = "تم إكمال طلبك بنجاح! شكراً لتسوقك من Lotus Care 🌸";

    $subtotal = 0;
    $vatAmount = 0;
    $total = 0;
    $cart_items = [];
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>صفحة الدفع - Lotus Care</title>
    <link rel="stylesheet" href="include/header_footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: "Cairo", sans-serif;
            background: url("image/2.png") no-repeat center center fixed;
            background-size: cover;
            padding-top: 120px;
            padding-bottom: 120px;
            display: flex;
            justify-content: center;
        }

        .checkout-box {
            width: 420px;
            background: #FFF7FA;
            border-radius: 24px;
            border: 2px solid #F3C6DA;
            padding: 28px 24px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            text-align: center;
        }

        .checkout-title {
            font-size: 26px;
            color: #C85C8E;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .checkout-subtitle {
            font-size: 14px;
            color: #777;
            margin-bottom: 18px;
        }

        .summary-box {
            background: rgba(255,255,255,0.8);
            border-radius: 18px;
            padding: 14px 18px;
            border: 1px solid #F7D9E6;
            text-align: right;
            margin-bottom: 20px;
            font-size: 15px;
            color: #444;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .summary-row span:first-child {
            color: #BF4776;
            font-weight: 600;
        }

        .summary-total {
            font-size: 18px;
            font-weight: 700;
            color: #3a6f43;
            margin-top: 6px;
            border-top: 1px dashed #E0B6C9;
            padding-top: 8px;
        }

        .methods-title {
            font-size: 16px;
            color: #BF4776;
            font-weight: 600;
            margin: 10px 0;
        }

        .payment-list {
            list-style: none;
            padding: 0;
            margin: 0 0 18px;
            text-align: right;
        }

        .payment-list li {
            margin-bottom: 6px;
            color: #444;
            font-weight: 600;
        }

        .checkout-btn {
            width: 100%;
            background: linear-gradient(135deg, #77c393, #3a6f43);
            border: none;
            padding: 12px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            border-radius: 25px;
            cursor: pointer;
            transition: 0.3s ease;
            margin-bottom: 10px;
        }

        .checkout-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(58,111,67,0.45);
        }

        .link-btn {
            display: inline-block;
            margin-top: 6px;
            font-size: 14px;
            color: #c85c8e;
            text-decoration: none;
            font-weight: 600;
        }

        .link-btn:hover {
            text-decoration: underline;
        }

        .success-message {
            background: #e7f7ec;
            border: 1px solid #77c393;
            color: #2f6b3f;
            padding: 10px 12px;
            font-size: 14px;
            border-radius: 14px;
            margin-bottom: 14px;
        }

        .note-empty {
            font-size: 14px;
            color: #777;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<?php include 'include/header.php'; ?>

<div class="checkout-box">

    <h2 class="checkout-title">🚚 صفحة الدفع</h2>
    <p class="checkout-subtitle">راجع ملخص طلبك واختر طريقة الدفع المناسبة</p>

    <?php if ($success_message !== ""): ?>

        <div class="success-message">
            <?= htmlspecialchars($success_message) ?>
        </div>
        <p class="note-empty">يمكنك العودة للتسوق مرة أخرى 🌷</p>
        <a href="index.php" class="link-btn">الرجوع للمنتجات</a>

    <?php else: ?>

        <div class="summary-box">
            <div class="summary-row">
                <span>إجمالي المنتجات (بدون ضريبة):</span>
                <span><?= number_format($subtotal, 2) ?> ر.س</span>
            </div>
            <div class="summary-row">
                <span>قيمة الضريبة (15٪):</span>
                <span><?= number_format($vatAmount, 2) ?> ر.س</span>
            </div>
            <div class="summary-total">
                الإجمالي النهائي: <?= number_format($total, 2) ?> ر.س
            </div>
        </div>

        <div class="methods">
            <div class="methods-title">اختر طريقة الدفع:</div>
            <ul class="payment-list">
                <li>تحويل بنكي</li>
                <li>الدفع عند الاستلام</li>
                <li>بطاقة مدى / فيزا</li>
            </ul>
        </div>

        <form method="post" action="checkout.php">
            <button type="submit" name="confirm_order" class="checkout-btn">
                إتمام الطلب🪷 ୨ৎ 
            </button>
        </form>

        <a href="cart.php" class="link-btn">العودة إلى السلة</a><br>
        <a href="index.php" class="link-btn">متابعة التسوق</a>

    <?php endif; ?>

</div>

<?php include 'include/footer.php'; ?>
</body>
</html> 