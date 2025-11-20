<?php
session_start();
$username = $_SESSION['username'] ?? null;
$level = $_SESSION['level'] ?? null;
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <title>Dropdown 登入狀態顯示</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<div class="container mt-5 text-end">
  <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      <?php if ($username): ?>
        <?= htmlspecialchars($username) ?>（等級<?= $level ?>）
      <?php else: ?>
        請選擇
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>