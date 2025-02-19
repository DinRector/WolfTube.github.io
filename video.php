<?php
require 'config.php';

$video_id = $_GET['id'];

// Получаем информацию о видео
$stmt = $pdo->prepare("SELECT videos.id, videos.title, videos.file_path, videos.created_at, videos.user_id, users.username FROM videos JOIN users ON videos.user_id = users.id WHERE videos.id = ?");
$stmt->execute([$video_id]);
$video = $stmt->fetch();

if (!$video) {
    die("Видео не найдено.");
}

// Получаем комментарии
$stmt = $pdo->prepare("SELECT comments.content, comments.created_at, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE comments.video_id = ? ORDER BY comments.created_at DESC");
$stmt->execute([$video_id]);
$comments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WolfTube | <?= htmlspecialchars($video['title']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1><?= htmlspecialchars($video['title']) ?></h1>
        <nav>
            <a href="index.php">На главную</a>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $video['user_id']): ?>
                <a href="delete_video.php?id=<?= $video['id'] ?>" onclick="return confirm('Вы уверены, что хотите удалить это видео?')">Удалить видео</a>
            <?php endif; ?>
        </nav>
    </header>
    <div class="container video-page">
        <p>Загрузил: <a href="profile.php?id=<?= $video['user_id'] ?>"><?= htmlspecialchars($video['username']) ?></a> | Дата: <?= $video['created_at'] ?></p>
        <video controls>
            <source src="<?= htmlspecialchars($video['file_path']) ?>" type="video/mp4">
            Ваш браузер не поддерживает видео.
        </video>

        <h2>Комментарии</h2>
        <div class="comment-section">
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <strong><?= htmlspecialchars($comment['username']) ?>:</strong>
                    <p><?= htmlspecialchars($comment['content']) ?></p>
                    <small><?= $comment['created_at'] ?></small>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>
            <form action="comment.php" method="POST">
                <input type="hidden" name="video_id" value="<?= $video_id ?>">
                <textarea name="content" placeholder="Ваш комментарий" required></textarea>
                <button type="submit">Отправить</button>
            </form>
        <?php else: ?>
            <p><a href="login.php">Войдите</a>, чтобы оставить комментарий.</p>
        <?php endif; ?>
    </div>
</body>
</html>