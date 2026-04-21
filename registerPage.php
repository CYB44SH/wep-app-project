
<?php
require_once "include/config.inc.php";
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm  = trim($_POST['confirm_password']);
    $skin     = trim($_POST['skin_type']);

    // تحقق أن الحقول ليست فارغة
    if ($name === "" || $email === "" || $password === "" || $confirm === "") {
       $error = 'الرجاء تعبئة جميع الحقول';
    }
    // تحقق من تطابق كلمة المرور
    elseif ($password !== $confirm) {
       $error = 'كلمة المرور غير متطابقة';
    } else {
        // التحقق إذا الإيميل مستخدم
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $error = 'البريد الالكتروني مستخدم مسبقا';
        } else {
            // تشفير كلمة المرور
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // إضافة المستخدم لقاعدة البيانات
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, skin_type) VALUES (?, ?, ?, ?)");
            $saved = $stmt->execute([$name, $email, $hashedPassword, $skin]);

        }
    }
}
?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>Register - Lotus Care</title>
<link rel="stylesheet" href="include/header_footer.css">

<style>
/* صندوق موحّد لصفحات الـ Auth (تسجيل / دخول / بروفايل) */
.lotus-auth-container {
  width: 360px;
  margin: 130px auto;
  background: #FFF7FA;
  border-radius: 22px;
  padding: 28px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.08);
  border: 2px solid #F3C6DA;
  font-family: "Cairo", sans-serif;
}

/* العنوان الفرعي */
.lotus-auth-title {
  text-align: center;
  color: #C85C8E;
  font-size: 26px;
  font-weight: 700;
  margin: 0;
}

.lotus-auth-subtitle {
  text-align: center;
  color: #777;
  font-size: 14px;
  margin: 6px 0 20px;
}

/* المجموعات */
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

.lotus-input-group input,
.lotus-input-group select {
  width: 100%;
  padding: 10px 12px;
  border-radius: 12px;
  border: 1px solid #f3c6da;
  outline: none;
  background: white;
  font-size: 14px;
  transition: 0.25s;
}

.lotus-input-group input:focus,
.lotus-input-group select:focus {
  border-color: #77c393;
  box-shadow: 0 0 0 2px rgba(119,195,147,0.25);
}

/* زر */
.lotus-auth-btn {
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
  margin-top: 4px;
}

.lotus-auth-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 16px rgba(58,111,67,0.45);
}

/* النص اللي تحت */
.lotus-auth-switch {
  margin-top: 14px;
  text-align: center;
  font-size: 14px;
  color: #555;
}

.lotus-auth-switch a {
  color: #c85c8e;
  font-weight: 600;
  text-decoration: none;
}

.lotus-auth-switch a:hover {
  text-decoration: underline;
}

.error-msg {
    color: #640934ff;
    font-size: 12px;
    display: block;
}
</style>
</head>

<body>
<?php include 'include/header.php'; ?>

<div class="lotus-auth-container">
    <h2 class="lotus-auth-title">Lotus Care</h2>
    <p class="lotus-auth-subtitle">إنشاء حساب جديد</p>
 <?php if ($error !== ''): ?>
        <p class="error-message"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
   
    <form method="post" action="registerPage.php" id="registerForm">
        <div class="lotus-input-group">
            <label for="name">الاسم الكامل</label>
            <input type="text" id="name" name="name" placeholder="اكتبي اسمك هنا">
        </div>

        <div class="lotus-input-group">
            <label for="email">البريد الإلكتروني</label>
            <input type="email" id="email" name="email" placeholder="example@email.com">
            <span id="emailError" class="error-msg"></span>


        </div>

        <div class="lotus-input-group">
            <label for="password">كلمة المرور</label>
            <input type="password" id="password" name="password" placeholder="••••••••">
            <span id="passwordError" class="error-msg"></span>


        </div>

        <div class="lotus-input-group">
            <label for="confirm_password">تأكيد كلمة المرور</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="أعيدي كتابة كلمة المرور">
            <span id="confirmError" class="error-msg"></span>
        </div>

        <div class="lotus-input-group">
            <label for="skin_type">نوع البشرة</label>
            <select id="skin_type" name="skin_type">
                <option value="">اختاري نوع بشرتك</option>
                <option value="oily">دهنية</option>
                <option value="dry">جافة</option>
                <option value="sensitive">حساسة</option>
                <option value="normal">عادية</option>
            </select>
        </div>

        <button type="submit" class="lotus-auth-btn">إنشاء الحساب</button>
    </form>

    <p class="lotus-auth-switch">
        عندك حساب من قبل؟
        <a href="login.php">تسجيل الدخول</a>
    </p>
</div>
<?php include 'include/footer.php'; ?>
<script>
const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

const email = document.getElementById("email");
const password = document.getElementById("password");
const confirmPassword = document.getElementById("confirm_password");

const emailError = document.getElementById("emailError");
const passwordError = document.getElementById("passwordError");
const confirmError = document.getElementById("confirmError");

const form = document.getElementById("registerForm");
let confirmTouched = false; 

// تحقق أثناء الكتابة للبريد
email.addEventListener("input", function () {
    if (!emailPattern.test(email.value)) {
        emailError.textContent = "اكتبي البريد الإلكتروني بشكل صحيح ⚠";
    } else {
        emailError.textContent = "";
    }
});

// تحقق عند الخروج من خانة كلمة المرور
password.addEventListener("blur", function () {
    if (!passwordPattern.test(password.value)) {
        passwordError.textContent =
            "الرقم السري يجب أن يحتوي حرف كبير + حرف صغير + رقم + رمز ⚠";
    } else {
        passwordError.textContent = "";
    }

    // تحقق من تطابق التأكيد إذا تم لمس خانة التأكيد
    if (confirmTouched && confirmPassword.value !== "") {
        if (password.value !== confirmPassword.value) {
            confirmError.textContent = "كلمتا المرور غير متطابقتين ⚠";
        } else {
            confirmError.textContent = "";
        }
    }
});

// تحقق عند الخروج من خانة التأكيد
confirmPassword.addEventListener("blur", function () {
    confirmTouched = true;

    if (password.value !== confirmPassword.value) {
        confirmError.textContent = "كلمتا المرور غير متطابقتين ⚠";
    } else {
        confirmError.textContent = "";
    }
});

// منع إرسال الفورم إذا فيه أخطاء
form.addEventListener("submit", function(e) {
    let valid = true;

    if (!emailPattern.test(email.value)) {
        emailError.textContent = "اكتبي البريد الإلكتروني بشكل صحيح ⚠";
        valid = false;
    }

    if (!passwordPattern.test(password.value)) {
        passwordError.textContent = "الرقم السري يجب أن يحتوي حرف كبير + حرف صغير + رقم + رمز ⚠";
        valid = false;
    }

    if (password.value !== confirmPassword.value) {
        confirmError.textContent = "كلمتا المرور غير متطابقتين ⚠";
        valid = false;
    }

    if (!valid) {
        e.preventDefault();
    }
});
</script>

</body>
</html>
