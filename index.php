<?php
require 'config.php';

$stmt = $pdo->query("SELECT videos.id, videos.title, videos.created_at, users.username FROM videos JOIN users ON videos.user_id = users.id ORDER BY videos.created_at DESC");
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WolfTube</title>
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
<header>
    <h1>Главная</h1>
    <nav>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="my_profile.php">Мой профиль</a>
            <a href="upload.php">Загрузить видео</a>
            <a href="logout.php">Выйти</a>
        <?php else: ?>
            <a href="register.php">Регистрация</a>
            <a href="login.php">Вход</a>
        <?php endif; ?>
    </nav>
</header>
    <div class="container">
        <h2>Последние видео</h2>
        <div class="video-list">
            <?php foreach ($videos as $video): ?>
                <div class="video-item">
                    <h3><a href="video.php?id=<?= $video['id'] ?>"><?= htmlspecialchars($video['title']) ?></a></h3>
                    <p>Загрузил: <?= htmlspecialchars($video['username']) ?> | Дата: <?= $video['created_at'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>