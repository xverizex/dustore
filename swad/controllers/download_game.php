<?php
session_start();
require_once('../config.php');

$db = new Database();
$pdo = $db->connect();

if (empty($_SESSION['USERDATA']['id'])) {
    header('Location: /login');
    exit();
}

$game_id = (int)($_GET['game_id'] ?? 0);
$user_id = $_SESSION['USERDATA']['id'];

if ($game_id <= 0) {
    header('Location: /explore');
    exit();
}

// Проверяем, есть ли уже игра в библиотеке
$stmt = $pdo->prepare("SELECT id FROM library WHERE player_id = ? AND game_id = ?");
$stmt->execute([$user_id, $game_id]);
if (!$stmt->fetch()) {
    // Добавляем в библиотеку
    $stmt = $pdo->prepare("INSERT INTO library (player_id, game_id, purchased) VALUES (?, ?, 1)");
    $stmt->execute([$user_id, $game_id]);
}

// Получаем ссылку на ZIP
$stmt = $pdo->prepare("SELECT game_zip_url FROM games WHERE id = ?");
$stmt->execute([$game_id]);
$game = $stmt->fetch();

if ($game && $game['game_zip_url']) {
    header("Location: " . $game['game_zip_url']);
    exit();
} else {
    die("Файл игры не найден");
}
