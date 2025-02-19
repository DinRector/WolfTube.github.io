<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && $user['password'] === $password) { // Сравниваем пароль в чистом виде
        // Устанавливаем сессию
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Устанавливаем куки на месяц
        setcookie('user_id', $user['id'], time() + (30 * 24 * 60 * 60), "/"); // 30 дней
        setcookie('username', $user['username'], time() + (30 * 24 * 60 * 60), "/");

        header('Location: index.php');
        exit;
    } else {
        echo '<div style="margin-right: 0.8%;"><font color="#B22222">Неверный логин или пароль!</font></div>';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Вход</h1>
    </header>
    <div class="container">
        <form method="POST">
            <label for="username">Имя пользователя:</label>
            <input type="text" name="username" id="username" required>
            <br>
            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" required>
            <br>
            <button type="submit">Войти</button>
        </form>
    </div>
</body>
</html>