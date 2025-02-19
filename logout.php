<?php
session_start();

// Удаляем сессию
session_destroy();

// Удаляем куки
setcookie('user_id', '', time() - 3600, "/");
setcookie('username', '', time() - 3600, "/");

header('Location: index.php');
exit;
?>