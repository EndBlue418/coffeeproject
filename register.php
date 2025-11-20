<?php
session_start();
$host = "localhost";
$dbname = "coffeeproject";
$user = "admin";
$pass = "1234";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // 簡單資料驗證
        if (strlen($password) < 6) {
            $error = "密碼至少需 6 個字元！";
        } else {
            // 檢查 email 是否已存在
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM member WHERE Mail = ?");
            $stmt->execute([$email]);
            if ($stmt->fetchColumn() > 0) {
                $error = "此電子郵件已被註冊。";
            } else {
                // 新增會員 (明文密碼)
                $stmt = $pdo->prepare("INSERT INTO member (Name, Mail, Password, Level) VALUES (?, ?, ?, 1)");
                $stmt->execute([$name, $email, $password]);

                $success = "註冊成功！請使用您的帳號登入。";
            }
        }
    }
} catch (PDOException $e) {
    $error = "錯誤：" . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>會員註冊</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to right, #83a4d4, #b6fbff);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .register-form {
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
    }
    .register-form h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #333;
    }
    .form-group {
      margin-bottom: 1rem;
    }
    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
    }
    .form-group input {
      width: 100%;
      padding: 0.5rem;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .form-group input:focus {
      border-color: #007bff;
    }
    .submit-btn {
      width: 100%;
      padding: 0.7rem;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      cursor: pointer;
    }
    .submit-btn:hover {
      background-color: #0056b3;
    }
    .message {
      text-align: center;
      margin-top: 1rem;
      font-weight: bold;
    }
    .error-msg {
      color: red;
    }
    .success-msg {
      color: green;
    }
    .login-link {
      margin-top: 1rem;
      text-align: center;
    }
  </style>
</head>
<body>

  <form class="register-form" method="POST" action="">
    <h2>會員註冊</h2>

    <?php if (!empty($error)) : ?>
      <div class="message error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (!empty($success)) : ?>
      <div class="message success-msg"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="form-group">
      <label for="name">姓名</label>
      <input type="text" id="name" name="name" required />
    </div>

    <div class="form-group">
      <label for="email">電子郵件</label>
      <input type="email" id="email" name="email" required />
    </div>

    <div class="form-group">
      <label for="password">密碼（至少 6 位）</label>
      <input type="password" id="password" name="password" required minlength="6" />
    </div>

    <button type="submit" class="submit-btn">立即註冊</button>

    <div class="login-link">
      已有帳號？ <a href="login.php">立即登入</a>
    </div>
  </form>

</body>
</html>
