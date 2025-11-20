<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['level'] < 4) {
    header("Location: login.php");
    exit();
}

$host = "localhost";
$dbname = "coffeeproject";
$user = "admin";
$pass = "1234";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_GET['id'] ?? null;
    $name = $mail = $level = "";
    $error = "";

    // 編輯模式：讀取現有資料
    if ($id) {
        $stmt = $pdo->prepare("SELECT * FROM member WHERE ID = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            die("找不到會員資料");
        }
        $name = $user['Name'];
        $mail = $user['Mail'];
        $level = $user['Level'];
    }

    // 處理表單送出
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'] ?? "";
        $mail = $_POST['mail'] ?? "";
        $level = intval($_POST['level'] ?? 1);
        $password = $_POST['password'] ?? "";

        if (!$name || !$mail || !$level) {
            $error = "請填寫所有欄位";
        } else {
            if ($id) {
                // 編輯會員
                if ($password) {
                    // 有輸入密碼才更新密碼
                    $stmt = $pdo->prepare("UPDATE member SET Name=?, Mail=?, Password=?, Level=? WHERE ID=?");
                    $stmt->execute([$name, $mail, $password, $level, $id]);
                } else {
                    // 不更新密碼
                    $stmt = $pdo->prepare("UPDATE member SET Name=?, Mail=?, Level=? WHERE ID=?");
                    $stmt->execute([$name, $mail, $level, $id]);
                }
                header("Location: admin_dashboard.php");
                exit();
            } else {
                // 新增會員
                if (!$password) {
                    $error = "新增會員時必須設定密碼";
                } else {
                    $stmt = $pdo->prepare("INSERT INTO member (Name, Mail, Password, Level) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$name, $mail, $password, $level]);
                    header("Location: admin_dashboard.php");
                    exit();
                }
            }
        }
    }

} catch (PDOException $e) {
    die("資料庫錯誤: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8" />
  <title><?= $id ? "編輯會員" : "新增會員" ?></title>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f2f5; padding: 20px;}
    .container { max-width: 400px; margin: auto; background: white; padding: 20px; border-radius: 6px; }
    label { display: block; margin-top: 12px; }
    input, select { width: 100%; padding: 8px; margin-top: 6px; box-sizing: border-box; }
    .btn { margin-top: 20px; padding: 10px; width: 100%; background: #007bff; color: white; border: none; cursor: pointer; border-radius: 4px; }
    .btn:hover { background: #0056b3; }
    .error { color: red; margin-top: 10px; }
    a { display: inline-block; margin-top: 10px; }
  </style>
</head>
<body>
  <div class="container">
    <h2><?= $id ? "編輯會員" : "新增會員" ?></h2>
    <?php if ($error): ?>
      <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="">
      <label>姓名
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" required>
      </label>
      <label>電子郵件
        <input type="email" name="mail" value="<?= htmlspecialchars($mail) ?>" required>
      </label>
      <label>密碼
        <input type="password" name="password" placeholder="<?= $id ? "留空表示不修改密碼" : "請輸入密碼" ?>">
      </label>
      <label>等級
        <select name="level" required>
          <option value="1" <?= $level == 1 ? "selected" : "" ?>>1 - 一般免費會員</option>
          <option value="2" <?= $level == 2 ? "selected" : "" ?>>2 - 進階會員 (每季消費1000)</option>
          <option value="3" <?= $level == 3 ? "selected" : "" ?>>3 - 高級會員 (每季消費3000)</option>
          <option value="4" <?= $level == 4 ? "selected" : "" ?>>4 - 管理員</option>
        </select>
      </label>
      <button type="submit" class="btn"><?= $id ? "更新" : "新增" ?></button>
            </form>
            <a href="admin_dashboard.php">回會員管理列表</a>
          </div>
        </body>
        </html>

