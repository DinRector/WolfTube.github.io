<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

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
    <title>WolfTube | Мой профиль</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Мой профиль</h1>
        <nav>
            <a href="index.php">На главную</a>
            <a href="upload.php">Загрузить видео</a>
            <a href="logout.php">Выйти</a>
        </nav>
    </header>
    <div class="container">
        <div class="profile-info">
            <h2>Название канала: <?= htmlspecialchars($user['username']) ?></h2>
            <p>Дата создания канала: <?= $user['created_at'] ?></p>
        </div>

        <h2>Мои видео</h2>
        <div class="video-list">
            <?php if (count($videos) > 0): ?>
                <?php foreach ($videos as $video): ?>
                    <div class="video-item">
                        <h3><a href="video.php?id=<?= $video['id'] ?>"><?= htmlspecialchars($video['title']) ?></a></h3>
                        <p>Дата загрузки: <?= $video['created_at'] ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Вы пока не загрузили видео.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>