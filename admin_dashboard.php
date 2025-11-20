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

    /* ========== 會員列表 ========== */
    $stmt = $pdo->query("SELECT * FROM member");
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /* ========== 公告列表 ========== */
    $stmt2 = $pdo->query("SELECT * FROM announcements ORDER BY created_at DESC LIMIT 10");
    $announcements = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    /* ========== 新增公告 ========== */
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "add_announcement") {
        $title = trim($_POST["title"]);
        $content = trim($_POST["content"]);
        if ($title && $content) {
            $insert = $pdo->prepare("INSERT INTO announcements (title, content, created_at) VALUES (?, ?, NOW())");
            $insert->execute([$title, $content]);
            header("Location: admin_dashboard.php");
            exit();
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
  <title>管理員後台</title>
  <style>
    body { font-family: 'Segoe UI', sans-serif; background-color: #f8f9fa; padding: 40px; }
    .container { max-width: 960px; margin: auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    h1, h2 { text-align: center; color: #343a40; }
    table { width: 100%; border-collapse: collapse; margin-top: 25px; }
    th, td { border: 1px solid #dee2e6; padding: 12px; text-align: center; }
    th { background-color: #343a40; color: white; }
    tr:nth-child(even) { background-color: #f1f1f1; }
    .actions a { padding: 6px 12px; margin: 0 4px; border-radius: 4px; text-decoration: none; font-size: 14px; }
    .btn-edit { background-color: #17a2b8; color: white; }
    .btn-delete { background-color: #dc3545; color: white; }
    .btn-add { display: inline-block; margin: 10px 0; padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; }
    .btn-add:hover, .btn-edit:hover, .btn-delete:hover { opacity: 0.85; }
    form { margin-top: 20px; }
    textarea { width: 100%; height: 100px; }
    input[type="text"] { width: 100%; padding: 8px; }
  </style>
</head>
<body>
  <div class="container">
    <h1>管理員後台</h1>

    <!-- ========== 會員管理 ========== -->
    <h2>會員管理</h2>
    <a class="btn-add" href="admin_edit.php">➕ 新增會員</a>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>姓名</th>
          <th>電子郵件</th>
          <th>等級</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($members as $member): ?>
        <tr>
          <td><?= $member['ID'] ?></td>
          <td><?= htmlspecialchars($member['Name']) ?></td>
          <td><?= htmlspecialchars($member['Mail']) ?></td>
          <td><?= $member['Level'] ?></td>
          <td class="actions">
            <a class="btn-edit" href="admin_edit.php?id=<?= $member['ID'] ?>">編輯</a>
            <a class="btn-delete" href="admin_delete.php?id=<?= $member['ID'] ?>" onclick="return confirm('確定要刪除這位會員？');">刪除</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <!-- ========== 公告管理 ========== -->
    <h2>公告管理</h2>
    <form method="POST">
      <input type="hidden" name="action" value="add_announcement">
      <label>標題：</label><br>
      <input type="text" name="title" required><br><br>
      <label>內容：</label><br>
      <textarea name="content" required></textarea><br><br>
      <button type="submit" class="btn-add">📢 發布公告</button>
    </form>

    <h2>最新公告</h2>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>標題</th>
          <th>內容</th>
          <th>發布時間</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($announcements as $a): ?>
        <tr>
          <td><?= $a['id'] ?></td>
          <td><?= htmlspecialchars($a['title']) ?></td>
          <td><?= nl2br(htmlspecialchars($a['content'])) ?></td>
          <td><?= $a['created_at'] ?></td>
          <td class="actions">
            <a class="btn-edit" href="announcement_edit.php?id=<?= $a['id'] ?>">編輯</a>
            <a class="btn-delete" href="announcement_delete.php?id=<?= $a['id'] ?>" onclick="return confirm('確定要刪除此公告？');">刪除</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      </table>

    <!-- 返回主頁按鈕 -->
    <div style="text-align: center; margin-top: 30px;">
        <a href="index.php" class="btn-add">🏠 回到主頁</a>
    </div>
  </div>
</body>
</html>