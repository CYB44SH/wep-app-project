<?php
session_start();

// مسح كل المتغيرات المخزنة في الجلسة
$_SESSION = [];

// إذا فيه كوكي للجلسة، نحذفه
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// إنهاء الجلسة
session_destroy();

// إعادة التوجيه لصفحة الهوم
header("Location: home.php");
exit;
