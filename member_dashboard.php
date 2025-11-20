<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['level'] < 1 || $_SESSION['level'] > 3) {
    header("Location: login.php");
    exit();
}

$host = "localhost";
$dbname = "coffeeproject";
$user = "admin";
$pass = "1234";

$error = "";
$success = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $mail = $_POST['mail'] ?? "";
        $password = $_POST['password'] ?? "";

        if (!$mail) {
            $error = "信箱不可為空";
        } else {
            if ($password) {
                $stmt = $pdo->prepare("UPDATE member SET Mail=?, Password=? WHERE ID=?");
                $stmt->execute([$mail, $password, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE member SET Mail=? WHERE ID=?");
                $stmt->execute([$mail, $id]);
            }
            $_SESSION['mail'] = $mail;
            if ($password) {
                $_SESSION['password'] = $password;
            }
            $success = "資料更新成功！";
        }
    }

} catch (PDOException $e) {
    die("資料庫錯誤: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <title>會員中心</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4f6f9;
      margin: 0;
      padding: 40px 20px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .container {
      max-width: 600px;
      width: 100%;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    h1 { text-align: center; color: #333; margin-bottom: 30px; }
    .info-value { font-size: 16px; margin-bottom: 15px; color: #555; }
    .info-label { font-weight: bold; color: #333; }
    .level-card { color: white; border-radius: 12px; padding: 20px; text-align: center; font-size: 18px; margin-top: 25px; }
    .normal { background: #3498db; }
    .advanced { background: linear-gradient(135deg, #f1c40f, #e67e22); box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); }
    .premium { background: linear-gradient(135deg, #8e44ad, #f39c12); box-shadow: 0 0 20px rgba(0, 0, 0, 0.4); }
    .logout { display: block; text-align: center; margin-top: 30px; text-decoration: none; color: #007bff; font-weight: bold; }
    .logout:hover { text-decoration: underline; }
    form { margin-top: 20px; }
    label { display: block; margin-top: 10px; }
    input { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; }
    .btn { margin-top: 15px; padding: 10px; width: 100%; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
    .btn:hover { background: #218838; }
    .msg { margin-top: 15px; text-align: center; font-weight: bold; }
    .error { color: red; }
    .success { color: green; }
  </style>
</head>
<body>
  <div class="container">
    <h1>會員中心</h1>
    <div class="info-value"><span class="info-label">姓名：</span><?= htmlspecialchars($_SESSION['username']) ?></div>
    <div class="info-value"><span class="info-label">信箱：</span><?= htmlspecialchars($_SESSION['mail'] ?? '-') ?></div>
    <div class="info-value">
      <span class="info-label">密碼：</span>
      <span id="password" style="letter-spacing: 3px;">********</span>
      <button type="button" onclick="togglePassword()" style="margin-left: 10px;">顯示</button>
    </div>

    <script>
      function togglePassword() {
        const pwSpan = document.getElementById("password");
        const button = event.target;
        if (pwSpan.textContent.includes('*')) {
          pwSpan.textContent = "<?= htmlspecialchars($_SESSION['password'] ?? '無資料') ?>";
          button.textContent = "隱藏";
        } else {
          pwSpan.textContent = "********";
          button.textContent = "顯示";
        }
      }
    </script>

    <?php
      $level = intval($_SESSION['level']);
      switch ($level) {
          case 1: $levelText = "普通會員"; $class = "normal"; break;
          case 2: $levelText = "進階會員（每季消費 1000）"; $class = "advanced"; break;
          case 3: $levelText = "高級會員（每季消費 3000）"; $class = "premium"; break;
          default: $levelText = "未知等級"; $class = "";
      }
    ?>
    <div class="level-card <?= $class ?>">
      <?= $levelText ?>
    </div>

    <!-- 修改信箱與密碼 -->
    <form method="POST" action="">
      <h3>修改資料</h3>
      <label>新信箱
        <input type="email" name="mail" value="<?= htmlspecialchars($_SESSION['mail'] ?? '') ?>" required>
      </label>
      <label>新密碼（留空則不修改）
        <input type="password" name="password">
      </label>
      <button type="submit" class="btn">更新</button>
    </form>

    <?php if ($error): ?><p class="msg error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <?php if ($success): ?><p class="msg success"><?= htmlspecialchars($success) ?></p><?php endif; ?>

    <a href="logout.php" class="logout">登出帳號</a>
  </div>
</body>
</html>
