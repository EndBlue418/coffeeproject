<?php
session_start();
$username = $_SESSION['username'] ?? null;
$level = $_SESSION['level'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>第八組-咖啡品牌形象、品牌忠誠度之影響-以路易莎咖啡為例</title>
  <!-- MDB icon -->
  <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
  <!-- MDB ESSENTIAL -->
  <link rel="stylesheet" href="css/mdb.min.css" />
  <!-- MDB PLUGINS -->
  <link rel="stylesheet" href="plugins/css/all.min.css" />
  <!-- Custom styles -->
  <style>
    @import url('https://fonts.googleapis.com/css2?family=LXGW+WenKai+Mono+TC&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap');

    /* Color of the links BEFORE scroll */
    .navbar-scroll .nav-link,
    .navbar-scroll .navbar-toggler-icon,
    .navbar-scroll .navbar-brand {
      color: #fff;
    }

    /* Color of the links AFTER scroll */
    .navbar-scrolled .nav-link,
    .navbar-scrolled .navbar-toggler-icon,
    .navbar-scrolled .navbar-brand {
      color: #fff;
    }

    /* Color of the navbar AFTER scroll */
    .navbar-scroll,
    .navbar-scrolled {
      background-color: #cbbcb1;
    }

    .mask-custom {
      backdrop-filter: blur(5px);
      background-color: rgba(0, 0, 0, 0.3);
    }

    .navbar-brand {
      font-size: 1.75rem;
      letter-spacing: 3px;
    }



    /*會員徽章顏色*/
           /* 頁面基本設定 */
        body {
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
        }

        /* 徽章容器 */
        .badge-container {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            justify-content: center;
        }

        /* 徽章基本樣式 */
        .badge {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: bold;
            position: relative;
            text-shadow: 0 2px 3px rgba(0, 0, 0, 0.3);
        }

        /* 普通會員 */
        .normal {
            background: #3498db;
        }

        /* 進階會員 */
        .advanced {
            background: linear-gradient(135deg, #f1c40f, #e67e22);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        /* 高級會員 */
        .premium {
            background: linear-gradient(135deg, #8e44ad, #f39c12);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
        }

        /* 徽章下方標籤 */
        .badge::after {
            content: attr(data-rank);
            position: absolute;
            bottom: -30px;
            width: 100%;
            font-size: 16px;
            color: #333;
            text-align: center;
        }



/*會員加入按鈕樣式*/
          .btn-member {
    color: white;
    border: none;
    border-radius: 50px;
    padding: 0.7rem 2rem;
    font-weight: bold;
    position: relative;
    overflow: hidden;
    z-index: 1;
    transition: all 0.3s ease-in-out;
  }

  /* 共用動態光暈效果 */
  .btn-member::before {
    content: "";
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.2), transparent 70%);
    animation: pulse 2s infinite;
    z-index: 0;
  }

  .btn-member:hover {
    transform: scale(1.05);
    box-shadow: 0 0 25px rgba(255, 255, 255, 0.5);
  }

  .btn-member span {
    position: relative;
    z-index: 1;
  }

  @keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    100% { transform: scale(1.5); opacity: 0; }
  }



/*會員顏色*/
  /* 普通會員（藍色） */
    .normal-btn {
      background: linear-gradient(135deg, #3498db, #5dade2);
      box-shadow: 0 0 15px rgba(52, 152, 219, 0.5);
    }

  /* 進階會員（金橘） */
    .advanced-btn {
      background: linear-gradient(135deg, #f1c40f, #e67e22);
      box-shadow: 0 0 15px rgba(241, 196, 15, 0.5);
    }

  /* 高級會員（紫金） */
    .premium-btn {
      background: linear-gradient(135deg, #8e44ad, #f39c12);
      box-shadow: 0 0 20px rgba(142, 68, 173, 0.6);
    }



/*navbar右側Dropdown樣式*/
.custom-orange {
  background-color: #ef7f0f;
  color: white;
  border: none;
  transition: background-color 0.3s ease;
}

.custom-orange:hover,
.custom-orange:focus {
  background-color: #e96e00;
  color: white;
}




/*字型*/
    body {
      font-family: "Open Sans", "LXGW WenKai Mono TC", serif;
    }



  </style>
</head>

<body>

  <!-- === navbar ============================================================= -->

  <header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top mask-custom shadow-0">
      <div class="container">
        <a class="navbar-brand" href="#!"> <span
            style="color: #fff;">LuCafe</span><span style="color: #ef7f0f;">+</span></a>
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
          data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
          aria-label="Toggle navigation">
          <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a class="nav-link" href="#top" style="color: #fff;">首頁</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="announcements.php"
                style="color: #fff">公告</a>
            </li>
            <li class="nav-item">
              <a class="nav-link"
                href="https://www.buoncaffe.com.tw/blog/posts/coffeebean?srsltid=AfmBOoqzzDvrxJbI-ET1WQkcobJbdK2wt6BkfIhWe4mUvCVrv2QcZGcc"
                style="color: #fff;">關於咖啡豆</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://www.ssscafe.com/pages/taiwan-coffee-history"
                style="color: #fff">咖啡歷史</a>
            </li>
                    </ul>
                        <div class="dropdown">
                          <button class="btn custom-orange dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php if ($username): ?>
                              <?= htmlspecialchars($username) ?>（等級<?= $level ?>）
                            <?php else: ?>
                              請登入
                            <?php endif; ?>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-end">
                            <?php if (!$username): ?>
                              <li><a class="dropdown-item" href="login.php">登入</a></li>
                              <li><a class="dropdown-item" href="register.php">註冊</a></li>
                            <?php else: ?>
                              <li>
                                <a class="dropdown-item" href="<?= $level == 4 ? 'admin_dashboard.php' : 'member_dashboard.php' ?>">我的</a>
                              </li>
                              <li><a class="dropdown-item" href="logout.php">登出</a></li>
                            <?php endif; ?>
                          </ul>
                        </div>
                      </div>
                    </ul>
                  </div>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Navbar -->

  <!-- === End navbar ========================================================== -->





  <br>





  <!-- === slider carousel ============================================================= -->

        <div id="carousel名稱" class="carousel slide carousel-fade carousel-dark" data-mdb-interval="2000" data-mdb-ride="carousel" data-mdb-carousel-init>

        <!-- 項目符號 -->
        <div class="carousel-indicators">
            <button type="button" data-mdb-target="#carousel名稱" data-mdb-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-mdb-target="#carousel名稱" data-mdb-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-mdb-target="#carousel名稱" data-mdb-slide-to="2" aria-label="Slide 3"></button>
        </div>


        <div class="carousel-inner shadow-6-strong rounded-5 ">
            <div class="carousel-item active" data-mdb-interval="5000">
                <img src="./img/slider-1.jpg" class="d-block w-100" alt="..." />
                <div class="carousel-caption d-none d-md-block">
                </div>
            </div>

            <div class="carousel-item" data-mdb-interval="5000">
                <img src="./img/slider-2.jpg" class="d-block w-100" alt="..." />
                <div class="carousel-caption d-none d-md-block">
                </div>
            </div>

            <div class="carousel-item" data-mdb-interval="5000">
                <img src="./img/slider-3.jpg" class="d-block w-100" alt="..." />
                <div class="carousel-caption d-none d-md-block">
                </div>
            </div>
        </div><!-- carousel-inner -->

        <!-- 前後切換 button -->
        <button class="carousel-control-prev" type="button" data-mdb-target="#carousel名稱"
            data-mdb-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-mdb-target="#carousel名稱"
            data-mdb-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

    </div><!-- carousel -->

  <!-- === End slider carousel ========================================================== -->





  <br>





    <!-- === 關於我們 ============================================================= -->


<div class="container">
  <div class="row">
    <div class="card shadow-5-strong mb-3">
        <div class="row g-0">

            <div class="col-md-4">
                <!-- bg-img -->
                <div class="bg-image hover-overlay ripple h-100" data-mdb-ripple-init data-mdb-ripple-color="light">
                    <img class="img-fluid h-100 rounded" src="./img/about-us.jpg" alt="提示文字">

                    <!-- mask -->
                    <a href="#!">
                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                    </a>
                </div><!-- bg-img -->
            </div>

            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">關於我們
                    </h5>
                    <p class="card-text">
                      我們致力於提供專業咖啡體驗，旨在將咖啡的獨特魅力與精湛的手藝呈現給每一位顧客。我們的使命是讓每位顧客都能深入了解咖啡的藝術與科學，並從每一杯手沖咖啡中，品味到極致的風味。
                      <br>我們相信回饋與忠誠是品牌成長的重要動力。因此，我們精心設計了會員等級制度，讓顧客能夠在每一次的參與中獲得回報。無論是參加免費的會員活動，還是享受更多特權的會員專屬活動，會員的忠誠度將不斷得到回饋。我們提供的活動不僅是一次的體驗，更是與品牌建立深厚聯繫的橋樑，讓每一位會員都能在我們的活動中體驗到專業與熱情。
                      <br>組員:潘柏佑,施宇謄,李冠霖
                    </p>
                    <p class="card-text d-flex justify-content-start">
                        <small class="text-muted"></small>
                    </p>
                </div>
                <div class="card-body d-flex justify-content-end">
                  <a href="https://www.accupass.com/event/2502200140032375337600" class="btn btn-lg me-2" role="button" style="background-color: #ef7f0f; border: none; color: white;">活動資訊</a>

              </div>
            </div>

        </div><!-- row -->
    </div><!-- card -->
  </div><!-- Row -->
</div><!--Container -->


    <!-- === End 關於我們 ========================================================== -->





  <br>





<!-- === 會員卡片 ============================================================= -->

<center>
  <h1>會員等級</h1></p>
</center>

    <div class="badge-container">
      <div class="badge normal" data-rank="一般會員">一般</div> &nbsp;
      <div class="badge advanced" data-rank="進階會員">進階</div> &nbsp;
      <div class="badge premium" data-rank="高級會員">高級</div>
    </div>
    <br><br>


    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-4">
          <div class="card">
              <!-- card-body -->
              <div class="card-body">
                  <h5 class="card-title fs-3">一般會員</h5>
                  <p class="card-text fs-6">
                    ✅ 會員專屬活動報名權限 <br>
                    ✅ 積分系統開通，可累積消費點數 <br>
                    ✅ 訂閱電子報，獲取最新資訊與優惠
                  </p>
              </div>

              <div class="card-body d-flex justify-content-end">
                  <a href="register.php" class="btn-member normal-btn">加入</a>
              </div>

          </div><!-- card -->
        </div>
        <div class="col-xs-12 col-sm-4">
          <div class="card">
              <!-- card-body -->
              <div class="card-body">
                  <h5 class="card-title fs-3">進階會員</h5>
                  <p class="card-text fs-6">
                    🔹 免費升級部分服務 <br>
                    🔹 VIP客服通道，享有更快速的問題解決服務 <br>
                    🔹 積分兌換更多高價值禮品或服務
                  </p>
              </div>

              <div class="card-body d-flex justify-content-end">
                  <a href="register.php" class="btn-member advanced-btn">加入</a>
              </div>

          </div><!-- card -->
        </div>
        <div class="col-xs-12 col-sm-4">
          <div class="card">
              <!-- card-body -->
              <div class="card-body">
                  <h5 class="card-title fs-3">高級會員</h5>
                  <p class="card-text fs-6">
                    ✨ 會員專屬活動，包含線下VIP特別體驗活動 <br>
                    ✨ 個性化禮品或年度會員紀念品 <br>
                    ✨ 與品牌合作的獨家限量商品優先購買權
                  </p>
              </div>

              <div class="card-body d-flex justify-content-end">
                  <a href="register.php" class="btn-member premium-btn">加入</a>
              </div>

          </div><!-- card -->
        </div>
      </div><!-- Row -->
    </div><!--Container -->


<!-- === End 會員卡片 ========================================================== -->







  <br>





  <!-- === footer ============================================================= -->

  <!-- Remove the container if you want to extend the Footer to full width. -->
  <div class="">

    <footer class="text-center text-white" style="background-color: #281822 ;">
      <!-- Grid container -->
      <div class="container p-4">
        <!-- Section: Images -->
        <section class="">
          <div class="row">
            <div class="col-lg-2 col-md-12 mb-4 mb-md-0">
              <div class="bg-image hover-overlay ripple shadow-1-strong rounded" data-mdb-ripple-init
                data-mdb-ripple-color="light">
                <img src="./img/footer-1.jpg" class="w-100" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(255, 255, 255, 0.2);"></div>
                </a>
              </div>
            </div>
            <div class="col-lg-2 col-md-12 mb-4 mb-md-0">
              <div class="bg-image hover-overlay ripple shadow-1-strong rounded" data-mdb-ripple-init
                data-mdb-ripple-color="light">
                <img src="./img/footer-2.jpg" class="w-100" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(251, 251, 251, 0.2);"></div>
                </a>
              </div>
            </div>
            <div class="col-lg-2 col-md-12 mb-4 mb-md-0">
              <div class="bg-image hover-overlay ripple shadow-1-strong rounded" data-mdb-ripple-init
                data-mdb-ripple-color="light">
                <img src="./img/footer-3.jpg" class="w-100" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(251, 251, 251, 0.2);"></div>
                </a>
              </div>
            </div>
            <div class="col-lg-2 col-md-12 mb-4 mb-md-0">
              <div class="bg-image hover-overlay ripple shadow-1-strong rounded" data-mdb-ripple-init
                data-mdb-ripple-color="light">
                <img src="./img/footer-4.jpg" class="w-100" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(251, 251, 251, 0.2);"></div>
                </a>
              </div>
            </div>
            <div class="col-lg-2 col-md-12 mb-4 mb-md-0">
              <div class="bg-image hover-overlay ripple shadow-1-strong rounded" data-mdb-ripple-init
                data-mdb-ripple-color="light">
                <img src="./img/footer-5.jpg" class="w-100" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(251, 251, 251, 0.2);"></div>
                </a>
              </div>
            </div>
            <div class="col-lg-2 col-md-12 mb-4 mb-md-0">
              <div class="bg-image hover-overlay ripple shadow-1-strong rounded" data-mdb-ripple-init
                data-mdb-ripple-color="light">
                <img src="./img/footer-6.jpg" class="w-100" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(255, 251, 251, 0.2);"></div>
                </a>
              </div>
            </div>
          </div>
        </section>
        <!-- Section: Images -->
      </div>
      <!-- Grid container -->

      <!-- Copyright -->
      <div class="text-center p-3" style="background-color: rgba(239, 127, 15, 1);">
        © 2025 Copyright:
        <a class="text-white" href="https://www.smvhs.kh.edu.tw/">smvhs.kh.edu.tw</a>
      </div>
      <!-- Copyright -->
    </footer>

  </div>
  <!-- End of .container -->

  <!-- === End footer ========================================================== -->

    <!-- Bootstrap 5 JS Bundle (含 Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

<!-- MDB ESSENTIAL -->
<script type="text/javascript" src="js/mdb.umd.min.js"></script>
<!-- MDB PLUGINS -->
<script type="text/javascript" src="plugins/js/all.min.js"></script>
<!-- Custom scripts -->
<script type="text/javascript"></script>

</html>