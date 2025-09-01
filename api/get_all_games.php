<?php
require_once('../swad/config.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

$db = new Database();
$pdo = $db->connect();

// Получаем список игр студии
$stmt = $pdo->prepare("SELECT * FROM games;");
$stmt->execute();
$games = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($games !== false) {
    echo json_encode($games);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch games']);
}
