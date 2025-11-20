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

    $stmt = $pdo->prepare("DELETE FROM announcements WHERE id = ?");
    $stmt->execute([$_GET['id']]);

    header("Location: admin_dashboard.php");
    exit();
} catch (PDOException $e) {
    die("刪除公告失敗：" . $e->getMessage());
}
?>
