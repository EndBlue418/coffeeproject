<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['level'] < 4) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) die("缺少公告 ID");

$host = "localhost";
$dbname = "coffeeproject";
$user = "admin";
$pass = "1234";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 更新公告
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $title = trim($_POST["title"]);
        $content = trim($_POST["content"]);
        $update = $pdo->prepare("UPDATE announcements SET title = ?, content = ? WHERE id = ?");
        $update->execute([$title, $content, $_GET["id"]]);
        header("Location: admin_dashboard.php"); // 回到後台首頁
        exit();
    }

    // 取得公告資料
    $stmt = $pdo->prepare("SELECT * FROM announcements WHERE id = ?");
    $stmt->execute([$_GET["id"]]);
    $a = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$a) die("找不到公告");

} catch (PDOException $e) {
    die("資料庫錯誤：" . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <title>編輯公告</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
    .container { max-width: 700px; margin: 50px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    h2 { text-align: center; margin-bottom: 30px; color: #343a40; }
    textarea { resize: none; }
    .btn { border-radius: 5px; }
  </style>
</head>
<body>
  <div class="container">
    <h2>✏ 編輯公告 #<?= $a['id'] ?></h2>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">公告標題</label>
        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($a['title']) ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">公告內容</label>
        <textarea name="content" class="form-control" rows="6" required><?= htmlspecialchars($a['content']) ?></textarea>
      </div>
      <div class="d-flex justify-content-between">
        <a href="admin_dashboard.php" class="btn btn-secondary">⬅ 返回後台</a>
        <button type="submit" class="btn btn-primary">💾 儲存修改</button>
      </div>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
