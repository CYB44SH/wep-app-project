<?php
// File: include/wishlist_process.php
session_start();
require_once 'include/config.inc.php';

$user_id = $_SESSION['user_id'];

// إضافة منتج للوش ليست
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_wishlist'])) {
    $product_id = (int)$_POST['product_id'];
    $stmt = $pdo->prepare("SELECT * FROM wishlist WHERE user_id = :user_id AND product_id = :product_id");
    $stmt->execute([':user_id'=>$user_id, ':product_id'=>$product_id]);
    
    if(!$stmt->fetch()) {
        $stmt = $pdo->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (:user_id, :product_id)");
        $stmt->execute([':user_id'=>$user_id, ':product_id'=>$product_id]);
    }
    header("Location: wishlist.php");
    exit;
}

// حذف منتج من الوش ليست
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product_id'])) {
    $product_id = (int)$_POST['delete_product_id'];
    $stmt = $pdo->prepare("DELETE FROM wishlist WHERE user_id = :user_id AND product_id = :product_id");
    $stmt->execute([':user_id'=>$user_id, ':product_id'=>$product_id]);


    header("Location: wishlist.php");
    exit;
}

// حذف كل المنتجات من الوش ليست
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_all'])) {
    $stmt = $pdo->prepare("DELETE FROM wishlist WHERE user_id = :user_id");
    $stmt->execute([':user_id'=>$user_id]);

    header("Location: wishlist.php");
    exit;
}
?>