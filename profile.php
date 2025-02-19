<?php
require 'config.php';

$user_id = $_GET['id'];

// Получаем информацию о пользователе
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    die("Пользователь не найден.");
}

// Получаем видео пользователя
$stmt = $pdo->prepare("SELECT * FROM videos WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$videos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль <?= htmlspecialchars($user['username']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header style="position:relative; min-width: 10%; margin-right: 3%;">
        <h1 >Профиль <?= htmlspecialchars($user['username']) ?></h1>
        <nav>
            <a href="index.php">На главную</a>
        </nav>
    </header>
    <div class="container">
        <h2>Видео пользователя <?= htmlspecialchars($user['username']) ?></h2>
        <div class="video-list">
            <?php if (count($videos) > 0): ?>
                <?php foreach ($videos as $video): ?>
                    <div class="video-item">
                        <h3><a href="video.php?id=<?= $video['id'] ?>"><?= htmlspecialchars($video['title']) ?></a></h3>
                        <p>Дата: <?= $video['created_at'] ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Пользователь пока не загрузил видео.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>