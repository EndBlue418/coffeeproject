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

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);

        // 防止刪除自己
        if ($_SESSION['user_id'] == $id) {
            die("不能刪除自己的帳號");
        }

        $stmt = $pdo->prepare("DELETE FROM member WHERE ID = ?");
        $stmt->execute([$id]);
    }

    header("Location: admin_dashboard.php");
    exit();

} catch (PDOException $e) {
    die("資料庫錯誤: " . $e->getMessage());
}
