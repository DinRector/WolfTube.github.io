<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $video_id = $_POST['video_id'];
    $user_id = $_SESSION['user_id'];
    $content = $_POST['content'];

    $stmt = $pdo->prepare("INSERT INTO comments (video_id, user_id, content) VALUES (?, ?, ?)");
    $stmt->execute([$video_id, $user_id, $content]);

    header("Location: video.php?id=$video_id");
    exit;
}
?>