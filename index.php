<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>منتجات العناية</title>
 <link rel=" stylesheet" href="include/header_footer.css">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600&display=swap" rel="stylesheet">

<style>
h2 {
  text-align: center;
  scroll-margin-top: 120px;
  margin-bottom: 5cqmax;
  font-size: 50px;
  font-weight: ;
  color: #a5545f;
  letter-spacing: 2cap;
  animation: wave 0.6s ease-in-out infinite;

}

@keyframes wave {
  0%   { transform: rotate(1deg); }
  50%  { transform: rotate(-1deg); }
  100% { transform: rotate(1deg); }
}


body {
  font-family: "Cairo", sans-serif;
  background: url("image/2.png") no-repeat center center fixed;
  background-size: cover;
   padding-top: 100px; 
   
}

 wave {
  0%   { transform: rotate(1deg) };
  50%  { transform: rotate(-1deg) };
  100% { transform: rotate(1deg)}; 
}


h1 {
  text-align: center;
  font-size: 36px;
  color: #C85C8E;
  margin-bottom: 30px;
  padding: 12px 25px;
  border: 3px solid #F3C6DA;
  border-radius: 18px;
  background: rgba(255, 255, 255, 0.7);
  width: fit-content;
  margin-left: auto;
  margin-right: auto;
}



.skin-section {
  height:600px;
  background: url("image/Untitled design.png") no-repeat center center;
  background-size: cover;
  margin-bottom: 60px;
  border-radius: 50px;
  box-shadow: 0 5px 25px rgba(0,0,0,0.06);

}


.skin-title {
  font-size: 26px;
  font-weight: bold;
  color: #BF4776;
  margin-bottom: 20px;
  border-right: 6px solid #E8A5C4;
  padding-right: 12px;
}


.products {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 40px;
  justify-items: center;
}
 
.product-card {
  width: 200px;
 
  background: #FFF7FA;
  border: 2px solid #F3C6DA;
  border-radius: 22px;
  padding: 20px;
  text-align: center;
  box-shadow: 0 0 16px rgba(0,0,0,0.07);
  transition: 0.3s;
}

.product-card:hover {
  transform: translateY(-6px);
}

.product-img {
  width: 100%;
  height: 270px;
  object-fit: cover;
  border-radius: 18px;
  margin-bottom: 15px;
}

.product-name {
  font-size: 20px;
  font-weight: 600;
  color: #C05285;
  margin-bottom: 12px;
}

/* زر التفاصيل */
.product-btn {
  background: linear-gradient(135deg, #F8BBD0, #F48FB1);
  border: none;
  padding: 12px 28px;
  border-radius: 30px;
  cursor: pointer;
  font-size: 17px;
  font-weight: 600;
  color: white;
  display: inline-flex;
  align-items: center;
  gap: 10px;
  box-shadow: 0 4px 12px rgba(244, 143, 177, 0.4);
  transition: 0.35s ease;
}

.product-btn:hover {
  transform: translateY(-4px) scale(1.05);
  box-shadow: 0 6px 18px rgba(244, 143, 177, 0.55);
}

/* أيقونة الزهرة */
.flower-icon {
  width: 30px;
  height: 30px;
  background: #FFB7D5;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-weight: bold;
  font-size: 18px;
  color: white;
  transition: 0.3s ease;
}

.product-btn:hover .flower-icon {
  background: rgb(171, 104, 104);
  color: #E84C88;
  transform: rotate(15deg) scale(1.2);
  box-shadow: 0 0 10px #F48FB1;
}

</style>
</head>

<body>

  <?php include 'include/header.php';?>
<h2>جمالك يبدأ بأختيارك الصحيح للمنتجات</h2>
<h1>منتجات مناسبة لأنواع البشرة</h1>

<!-- =================== البشرة الدهنية =================== -->
<div class="skin-section" id="oily">
  
  <div class="skin-title">البشرة الدهنية</div>

  <div class="products">

    <div class="product-card">
      <img src="image/download.jpeg" class="product-img">
      <div class="product-name">Gel Cleanser</div>
       <form action="product_details.php" method="GET">
        <input type="hidden" name="id" value="1">
        <button type="submit" class="product-btn">
          <div class="flower-icon">✿</div> تفاصيل
        </button>
      </form>
    </div>

    <div class="product-card">
      <img src="image/Daily Purifying Toner by AXIS-Y✨.jpeg" class="product-img">
      <div class="product-name">Oil Control Toner</div>
       <form action="product_details.php" method="GET">
        <input type="hidden" name="id" value="2">
        <button type="submit" class="product-btn">
          <div class="flower-icon">✿</div> تفاصيل
        </button>
      </form>
    </div>
 
  </div>
</div>

<!-- =================== البشرة الجافة =================== -->
<div class="skin-section" id="dry">
  <div class="skin-title">البشرة الجافة</div>

  <div class="products">

    <div class="product-card">
      <img src="image/هيالورونيك اسيد،سيروم.jpeg" class="product-img">
      <div class="product-name">Deep Moisture Cream</div>
       <form action="product_details.php" method="GET">
        <input type="hidden" name="id" value="3">
        <button type="submit" class="product-btn">
          <div class="flower-icon">✿</div> تفاصيل
        </button>
      </form>
    </div>

    <div class="product-card">
      <img src="image/download (2).jpeg" class="product-img">
      <div class="product-name">Hydrating Serum</div>
       <form action="product_details.php" method="GET">
        <input type="hidden" name="id" value="4">
        <button type="submit" class="product-btn">
          <div class="flower-icon">✿</div> تفاصيل
        </button>
      </form>
    </div>

  </div>
</div>

<!-- =================== البشرة الحساسة =================== -->
<div class="skin-section" id="sensitive">
  <div class="skin-title">البشرة الحساسة</div>

  <div class="products">

    <div class="product-card">
      <img src="image/غسول الوجه الجاف cerave.jpeg" class="product-img">
      <div class="product-name">Soothing Gel</div>
       <form action="product_details.php" method="GET">
        <input type="hidden" name="id" value="5">
        <button type="submit" class="product-btn">
          <div class="flower-icon">✿</div> تفاصيل
        </button>
      </form>
    </div>

    <div class="product-card">
      <img src="image/📌 Daily Skincare Routine 🧴✨.jpeg" class="product-img">
      <div class="product-name">Calming Cream</div>
      <form action="product_details.php" method="GET">
        <input type="hidden" name="id" value="6">
        <button type="submit" class="product-btn">
          <div class="flower-icon">✿</div> تفاصيل
        </button>
      </form>
    </div>

  </div>
</div>

<!-- =================== البشرة العادية =================== -->
<div class="skin-section" id="normal">
  <div class="skin-title">البشرة العادية</div>

  <div class="products">

    <div class="product-card">
      <img src="image/download (1).jpeg" class="product-img">
      <div class="product-name">Balanced Daily Cleanser</div>
       <form action="product_details.php" method="GET">
        <input type="hidden" name="id" value="7">
        <button type="submit" class="product-btn">
          <div class="flower-icon">✿</div> تفاصيل
        </button>
      </form>
    </div>

    <div class="product-card">
      <img src="image/Kiehl's Midnight Recovery Omega Rich Cloud Cream 50 ml كريم ليلي معالج للبشرة.jpeg" class="product-img">
      <div class="product-name">Light Moisturizer</div>
       <form action="product_details.php" method="GET">
        <input type="hidden" name="id" value="8">
        <button type="submit" class="product-btn">
          <div class="flower-icon">✿</div> تفاصيل
        </button>
      </form>
    </div>

  </div>
</div>

  <div><?php include 'include/footer.php'; ?></div>
</body>
</html>
