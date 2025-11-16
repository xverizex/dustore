<?php
session_start();
require_once('../config.php');


if (empty($_SESSION['USERDATA']['id'])) {
    $game_id = (int)($_GET['game_id'] ?? 0);
    $user_id = '0';
    downloadGame($game_id, $user_id);
}else{
    $game_id = (int)($_GET['game_id'] ?? 0);
    $user_id = $_SESSION['USERDATA']['id'];
    downloadGame($game_id, $user_id);
}

function downloadGame($game_id, $user_id){
    $db = new Database();
    $pdo = $db->connect();


    if ($game_id <= 0) {
        header('Location: /explore');
        exit();
    }

    $stmt = $pdo->prepare("
    INSERT INTO library (player_id, game_id, purchased, date)
    SELECT ?, ?, 1, NOW()
    WHERE NOT EXISTS (
        SELECT 1 FROM library WHERE player_id = ? AND game_id = ?
    )
");
    $stmt->execute([$user_id, $game_id, $user_id, $game_id]);

    $stmt = $pdo->prepare("SELECT game_zip_url FROM games WHERE id = ?");
    $stmt->execute([$game_id]);
    $game = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($game && !empty($game['game_zip_url'])) {
        header("Location: " . $game['game_zip_url']);
        exit();
    }

    header("Location: /g/$game_id");
    exit();
}

