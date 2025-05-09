<?php
require_once('/swad/config.php');
require_once('/swad/controllers/user.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm_password) {
        header('Location: register.html?error=Пароли не совпадают');
        exit();
    }

    try {
        $conn = $db->connect();

        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);

        if ($stmt->fetch()) {
            header('Location: register.html?error=Пользователь с таким именем или email уже существует');
            exit();
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashed_password]);

        $user_id = $conn->lastInsertId();

        header('Location: dashboard.php');
        exit();
    } catch (PDOException $e) {
        header('Location: register.html?error=Ошибка базы данных');
        exit();
    }
} else {
    header('Location: register.html');
    exit();
}
