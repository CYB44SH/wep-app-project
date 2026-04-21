<?php
session_start();
require_once "config.inc.php";

$user_id = $_SESSION['user_id'] ?? null;

$response = ['success' => false, 'redirect' => false, 'message' => 'حدث خطأ'];

if(isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    $stmt = $pdo->prepare("SELECT stock, name FROM products WHERE id = :id");
    $stmt->execute([':id' => $product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$product){
        $response['message'] = "المنتج غير موجود!";
        $response['redirect'] = false;
    } elseif($product['stock'] <= 0){
        $response['message'] = "هذا المنتج نفد!";
        $response['redirect'] = false;
    } else {
        $stmt = $pdo->prepare("SELECT quantity FROM cart WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute([':user_id' => $user_id, ':product_id' => $product_id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if($item){
            $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = :user_id AND product_id = :product_id");
            $stmt->execute([':user_id' => $user_id, ':product_id' => $product_id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, 1)");
            $stmt->execute([':user_id' => $user_id, ':product_id' => $product_id]);
        }

        $stmt = $pdo->prepare("UPDATE products SET stock = stock - 1 WHERE id = :product_id");
        $stmt->execute([':product_id' => $product_id]);

        $response['success'] = true;
        $response['message'] = "تمت إضافة '{$product['name']}' للسلة ✅";
        $response['redirect'] = true;
        $response['redirect_url'] = "../cart.php";
    }
}

header('Content-Type: application/json');
echo json_encode($response);
