<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $user_id = $_SESSION['user_id'];
    $file = $_FILES['video'];

    // Проверка MIME-типа файла
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'video/webm'];
    if (!in_array($file['type'], $allowed_types)) {
        die("Ошибка: Разрешены только изображения (JPEG, PNG, GIF) и видео (MP4, WebM).");
    }

    if ($file['error'] === UPLOAD_ERR_OK) {
        $file_path = 'uploads/' . basename($file['name']);
        move_uploaded_file($file['tmp_name'], $file_path);

        $stmt = $pdo->prepare("INSERT INTO videos (user_id, title, file_path) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $title, $file_path]);

        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>WolfTube</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header style="position:relative; min-width: 10%; margin-right: 3%;">
        <h1>Загрузить видео</h1>
    </header>
    <div class="container">
        <form method="POST" enctype="multipart/form-data">
            <label for="title">Название:</label>
            <input style="margin-top: 2%;" type="text" name="title" id="title" required>
            <br>
            <label for="video">Файл (только фото или видео):</label>
            <input style="margin-top: 0.8%;" type="file" name="video" id="video" required>
            <br>
            <button style="margin-top: 3.4%;" type="submit">Загрузить</button>
        </form>
    </div>
</body>
</html>