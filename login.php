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
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $stmt = $pdo->prepare("SELECT * FROM member WHERE Mail = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        //密碼比對
        if ($user && $password === $user['Password']) {
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['username'] = $user['Name'];
            $_SESSION['level'] = $user['Level'];
            $_SESSION['mail'] = $user['Mail'];
            $_SESSION['password'] = $user['Password'];
            //回index.php
            header("Location: index.php");
            exit();
        } else {
            $error = "登入失敗，帳號或密碼錯誤。";
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
  <title>會員登入</title>
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
    .login-form {
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
    }
    .login-form h2 {
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
    .register-link {
      margin-top: 1rem;
      text-align: center;
    }
    .error-msg {
      color: red;
      text-align: center;
      font-weight: bold;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>

  <form class="login-form" method="POST" action="">
    <h2>會員登入</h2>

    <?php if (!empty($error)) : ?>
      <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="form-group">
      <label for="email">電子郵件</label>
      <input type="email" id="email" name="email" required />
    </div>

    <div class="form-group">
      <label for="password">密碼</label>
      <input type="password" id="password" name="password" required />
    </div>

    <button type="submit" class="submit-btn">登入</button>

    <div class="register-link">
      沒有帳號？ <a href="register.php">立即註冊</a>
    </div>
  </form>

</body>
</html>
