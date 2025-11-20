<?php
// 連接資料庫
$host = 'localhost';
$dbname = 'coffeeproject';
$user = 'admin';
$password = '1234';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 取得最新公告
    $stmt = $pdo->query("SELECT * FROM announcements ORDER BY created_at DESC LIMIT 5");
    $announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("資料庫連線失敗：" . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>公告欄</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .container { max-width: 900px; margin: 50px auto; }
        h2 { text-align: center; margin-bottom: 30px; color: #343a40; }
        .announcement-card { margin-bottom: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); background: #fff; padding: 20px; }
        .announcement-title { font-size: 1.3rem; font-weight: bold; color: #007bff; }
        .announcement-content { margin-top: 10px; white-space: pre-line; }
        .announcement-date { font-size: 0.9rem; color: #6c757d; margin-top: 15px; }
        @media (max-width: 576px) {
            .announcement-title { font-size: 1.1rem; }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>📢 最新公告</h2>

    <?php if (!empty($announcements)): ?>
        <?php foreach ($announcements as $a): ?>
            <div class="announcement-card">
                <div class="announcement-title"><?= htmlspecialchars($a['title']) ?></div>
                <div class="announcement-content"><?= nl2br(htmlspecialchars($a['content'])) ?></div>
                <div class="announcement-date">發布於 <?= $a['created_at'] ?></div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info text-center">目前沒有公告。</div>
    <?php endif; ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
