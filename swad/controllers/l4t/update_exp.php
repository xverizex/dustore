<?php
require_once('../../config.php');
session_start();


ini_set('display_errors', 1);
error_reporting(E_ALL);
file_put_contents(__DIR__ . '/exp_log.txt', print_r([
    'post' => $_POST,
    'input' => file_get_contents('php://input'),
    'session' => $_SESSION ?? null
], true));

if ($_SESSION['USERDATA']['id'] != $targetUserId) {
    http_response_code(403);
    echo json_encode(['success' => false]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($_SESSION['USERDATA']['id'])) {
    echo json_encode(["success" => false, "msg" => "no auth"]);
    exit;
}

$userId = $_SESSION['USERDATA']['id'];

$exp = $data['exp'] ?? [];

// жёсткая фильтрация, без твоих ебаных XSS
$clean = [];
foreach ($exp as $e) {
    if (!isset($e['role'], $e['years'])) continue;

    $clean[] = [
        "role"  => mb_substr(strip_tags($e['role']), 0, 30),
        "years" => min(50, max(0, (int)$e['years']))
    ];
}


$db = new Database();
$pdo = $db->connect();

$stmt = $pdo->prepare("UPDATE users SET l4t_exp = ? WHERE id = ?");
$stmt->execute([json_encode($clean, JSON_UNESCAPED_UNICODE), $userId]);

echo json_encode(["success" => true]);
