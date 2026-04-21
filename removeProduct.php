<?php
session_start();
require_once "config.inc.php";

$user_id = $_SESSION['user_id'] ?? null;

if (($_POST['product_iissetd'])) {

    $product_id = $_POST['product_id'];

    // نجيب الكمية
    $stmt = $pdo->prepare("SELECT quantity FROM cart WHERE user_id = :user_id AND product_id = :product_id");
    $stmt->execute([
        ':user_id' => $user_id,
        ':product_id' => $product_id
    ]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($item) {
        // نرجّع الكمية للمخزون
        $stmt = $pdo->prepare("UPDATE products SET stock = stock + :qty WHERE id = :id");
        $stmt->execute([
            ':qty' => $item['quantity'],
            ':id'  => $product_id
        ]);
     

        // نحذف المنتج من السلة
        $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute([
            ':user_id' => $user_id,
            ':product_id' => $product_id
        ]);

    }

    header("Location: ../cart.php");
    exit;
}
?>
