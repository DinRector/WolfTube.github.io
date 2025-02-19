<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$video_id = $_GET['id'];

// Получаем информацию о видео
$stmt = $pdo->prepare("SELECT * FROM videos WHERE id = ?");
$stmt->execute([$video_id]);
$video = $stmt->fetch();

if (!$video) {
    die("Видео не найдено.");
}

// Проверяем, является ли текущий пользователь автором видео
if ($_SESSION['user_id'] != $video['user_id']) {
    die("У вас нет прав на удаление этого видео.");
}

// Удаляем видео из базы данных
$stmt = $pdo->prepare("DELETE FROM videos WHERE id = ?");
$stmt->execute([$video_id]);

// Удаляем файл видео
if (file_exists($video['file_path'])) {
    unlink($video['file_path']);
}

// Удаляем комментарии к видео
$stmt = $pdo->prepare("DELETE FROM comments WHERE video_id = ?");
$stmt->execute([$video_id]);

header('Location: index.php');
exit;
?>