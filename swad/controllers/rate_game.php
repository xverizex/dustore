<?php
session_start();
require_once('../config.php');
require_once('game.php');
require_once('send_email.php');

header('Content-Type: application/json');

if (empty($_SESSION['USERDATA'])) {
    echo json_encode(['error' => 'not_logged_in']);
    exit;
}

$gameId = $_POST['game_id'] ?? 0;
$rating = $_POST['rating'] ?? 0;
$userId = $_SESSION['USERDATA']['id'];
$developer_mail = $_POST['devEmail'] ?? null;
// print_r($_SESSION);

if ($gameId <= 0 || $rating < 1 || $rating > 10) {
    echo json_encode(['error' => 'invalid_data']);
    exit;
}

$gameController = new Game();
$gameController->addRating($gameId, $userId, $rating);
sendMail($developer_mail, "Ваша игра получила отзыв", "Вы можете просмотреть его на <a href='https://dustore.ru/g/$gameId'>странице игры</a> или в <a href='https://dustore.ru/devs/replies'>консоли разработчика");

$newRating = $gameController->getAverageRating($gameId);
echo json_encode(['success' => true, 'avg' => $newRating['avg'], 'count' => $newRating['count']]);
