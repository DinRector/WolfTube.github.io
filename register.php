<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Сохраняем пароль без хеширования

    // Проверка, существует ли пользователь с таким именем
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        die("Ошибка: Пользователь с таким именем уже существует.");
    }

    // Сохраняем пароль в чистом виде
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);

    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>WolfTube | Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header style="position:relative; padding-right: 3%;">
        <h1>Регистрация</h1>
    </header>
    <div class="container">
        <form method="POST">
            <label for="username">Имя пользователя:</label>
            <input type="text" name="username" id="username" required>
            <br>
            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" required>
            <br>
            <button>Зарегистрироваться</button>
        </form>
    </div>
</body>
</html>