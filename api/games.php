<?php
require_once('../swad/config.php');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Можно ограничить доменом твоего лаунчера
header('Access-Control-Allow-Methods: GET');

$db = new Database();
$pdo = $db->connect();

try {
    $stmt = $pdo->query("SELECT id, name, banner_url, description FROM games");
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($games);
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Query failed']);
    exit;
}
