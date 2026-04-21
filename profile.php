<?php
session_start();
require_once 'include/config.inc.php'; 

$user_logged_in = false;
$user = null;

if (isset($_SESSION['user_id'])) {
    $user_id = (int) $_SESSION['user_id'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $user_logged_in = true;
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>Profile - Lotus Care</title>
<link rel="stylesheet" href="include/header_footer.css">

<style>
.lotus-profile-container {
  width: 360px;
  margin: 130px auto;
  background: #FFF7FA;
  border-radius: 22px;
  padding: 28px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.08);
  border: 2px solid #F3C6DA;
  font-family: "Cairo", sans-serif;
  text-align: center;
}

.lotus-profile-title {
  color: #3a6f43;
  font-size: 24px;
  font-weight: 700;
  margin: 0 0 6px;
}

.lotus-profile-subtitle {
  color: #777;
  font-size: 14px;
  margin: 0 0 18px;
}

.lotus-profile-avatar {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  margin: 0 auto 12px;
  background: #ffd5d5;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #3a6f43;
  font-size: 32px;
  font-weight: 700;
}

.lotus-profile-info p {
  margin: 4px 0;
  font-size: 14px;
  color: #555;
}

.lotus-profile-info span.label {
  font-weight: 600;
  color: #3a6f43;
}

.lotus-profile-buttons {
  margin-top: 18px;
  display: flex;
  gap: 10px;
  justify-content: center;
  flex-wrap: wrap;
}

.lotus-profile-btn {
  padding: 8px 16px;
  border-radius: 20px;
  border: none;
  font-size: 14px;
  cursor: pointer;
  transition: 0.3s;
}

.lotus-profile-btn.primary {
  background: #77c393;
  color: white;
}

.lotus-profile-btn.secondary {
  background: #ffd5d5;
  color: #3a6f43;
}

.lotus-profile-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}
</style>
</head>

<body>
<?php include 'include/header.php'; ?>

<div class="lotus-profile-container">
    <div class="lotus-profile-avatar">
        <?php
        if ($user_logged_in) {
            echo strtoupper(substr($user['name'], 0, 1));
        } else {
            echo "";
        }
        ?>
    </div>

    <?php if ($user_logged_in): ?>
        <h2 class="lotus-profile-title">مرحباً، <?= htmlspecialchars($user['name']) ?></h2>
        <p class="lotus-profile-subtitle">هذا هو ملفك الشخصي في Lotus Care</p>

        <div class="lotus-profile-info">
            <p><span class="label">البريد الإلكتروني:</span> <?= htmlspecialchars($user['email']) ?></p>
            <p><span class="label">نوع البشرة:</span> <?= htmlspecialchars($user['skin_type']) ?></p>
            
        </div>

        <div class="lotus-profile-buttons">
            <a href="index.php">
                <button class="lotus-profile-btn primary">عرض المنتجات المناسبة لبشرتي</button>
            </a>
       <form action="logout.php" method="post">
    <button type="submit" class="lotus-profile-btn secondary">تسجيل الخروج</button>
</form>

               
          </form>
        </div>
    <?php else: ?>
        <h2 class="lotus-profile-title">مرحباً بك في Lotus Care</h2>
        <p class="lotus-profile-subtitle">سجّل دخولك أو أنشئ حساب جديد للوصول للبروفايل</p>

        <div class="lotus-profile-buttons">
            <a href="registerPage.php">
                <button class="lotus-profile-btn primary">إنشاء حساب</button>
            </a>
            <a href="login.php">
                <button class="lotus-profile-btn secondary">تسجيل الدخول</button>
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include 'include/footer.php'; ?>
</body>
</html>


