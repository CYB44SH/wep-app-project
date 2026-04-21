<?php
session_start();
require_once 'include/config.inc.php'; // اتصال PDO بالداتا بيس

$error = '';

// تحقق إذا تم إرسال الفورم
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($email === '' || $password === '') {
        $error = 'الرجاء تعبئة جميع الحقول';
    } else {
        // جلب المستخدم حسب الإيميل
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // التحقق من كلمة المرور
            if (password_verify($password, $user['password'])) {
                // تسجيل الدخول بنجاح
                $_SESSION['user_id'] = $user['id'];
                header('Location: profile.php'); // تحويل البروفايل
                exit;
            } else {
                $error = 'كلمة المرور غير صحيحة';
            }
        } else {
            $error = 'المستخدم غير موجود';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>Login - Lotus Care</title>
<link rel="stylesheet" href="include/header_footer.css">

<style>
/* نفس ستايل تسجيل الدخول */
.lotus-login-container {
  width: 360px;
  margin: 130px auto;
  background: #FFF7FA;
  border-radius: 22px;
  padding: 28px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.08);
  border: 2px solid #F3C6DA;
  font-family: "Cairo", sans-serif;
}

.lotus-login-title {
  text-align: center;
  color: #C85C8E;
  font-size: 28px;
  font-weight: 700;
  margin: 0;
}

.lotus-login-subtitle {
  text-align: center;
  color: #777;
  font-size: 14px;
  margin-bottom: 20px;
}

.lotus-input-group {
  margin-bottom: 16px;
}

.lotus-input-group label {
  display: block;
  margin-bottom: 6px;
  color: #3a6f43;
  font-size: 14px;
  font-weight: 600;
}

.lotus-input-group input {
  width: 100%;
  padding: 10px 12px;
  border-radius: 12px;
  border: 1px solid #f3c6da;
  outline: none;
  background: white;
  font-size: 14px;
  transition: 0.25s;
}

.lotus-input-group input:focus {
  border-color: #77c393;
  box-shadow: 0 0 0 2px rgba(119,195,147,0.25);
}

.lotus-login-btn {
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
}

.lotus-login-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 16px rgba(58,111,67,0.45);
}

.lotus-login-switch {
  margin-top: 14px;
  text-align: center;
  font-size: 14px;
  color: #555;
}

.lotus-login-switch a {
  color: #c85c8e;
  font-weight: 600;
  text-decoration: none;
}

.lotus-login-switch a:hover {
  text-decoration: underline;
}

.error-message {
  text-align: center;
  color: red;
  font-size: 14px;
  margin-bottom: 10px;
}
</style>
</head>

<body>
<?php include 'include/header.php'; ?>

<div class="lotus-login-container">
    <h2 class="lotus-login-title">Lotus Care</h2>
    <p class="lotus-login-subtitle">تسجيل الدخول إلى حسابك</p>

    <?php if ($error !== ''): ?>
        <p class="error-message"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" action="login.php">

        <div class="lotus-input-group">
            <label for="email">البريد الإلكتروني</label>
            <input type="email" id="email" name="email" placeholder="example@email.com" required>
        </div>

        <div class="lotus-input-group">
            <label for="password">كلمة المرور</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required>
        </div>

        <button type="submit" class="lotus-login-btn">تسجيل الدخول</button>
    </form>

    <p class="lotus-login-switch">
        ما عندك حساب؟  
        <a href="registerPage.php">إنشاء حساب جديد</a>
    </p>
</div>

<?php include 'include/footer.php'; ?>
</body>
</html>


