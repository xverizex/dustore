<?php
require_once('../swad/config.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['token'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No token provided']);
    exit;
}

$token = trim($input['token']);

$db = new Database();
$pdo = $db->connect();

// Проверяем токен
$stmt = $pdo->prepare("SELECT id, name FROM studios WHERE api_token = :token");
$stmt->execute(['token' => $token]);
$studio = $stmt->fetch(PDO::FETCH_ASSOC);

if ($studio) {
    echo json_encode([
        'status' => 'ok',
        'studio_id' => $studio['id'],
        'studio_name' => $studio['name']
    ]);
} else {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid token']);
}
